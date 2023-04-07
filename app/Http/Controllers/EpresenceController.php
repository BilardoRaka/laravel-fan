<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveEpresenceRequest;
use App\Http\Requests\StoreEpresenceRequest;
use App\Http\Resources\EpresenceResource;
use App\Models\Epresence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EpresenceController extends Controller
{
    //Get All Data, yang sesuai dengan npp ATAU npp_supervisor
    public function index(Request $request)
    {
        $user = $request->user();
        
        //mengecek data presensi yang dapat dilihat oleh user yang telah login dengan mencocokkan kolom npp atau npp_supervisor
        $supervisor = User::where('npp', $user->npp)->orWhere('npp_supervisor', $user->npp)->pluck('id');

        //return json dengan whereIn (karena kondisi lebih dari satu) kemudian mengurutkan hasil API dari yang terbaru
        $Collection = EpresenceResource::collection(Epresence::whereIn('user_id', $supervisor)->get());

        return response([
            'message' => 'Success get data',
            'data' => $Collection
        ]);
    }

    //Store Data
    public function store(StoreEpresenceRequest $request){

        $user = $request->user();
        $data = $request->validated();
        
        //mengecek apakah hari ini user sudah absensi IN atau OUT (INCASE SENSITIVE).
        $checkEpresence = Epresence::where('user_id', $user->id)->whereDate('waktu', $data['waktu'])->pluck('type')->all();
        $strarray = array_map('strtoupper', $checkEpresence);
        $upperType = strtoupper($data['type']);
        $array = in_array($upperType, $strarray);

        //jika user sudah absensi (IN atau OUT) hari ini, sistem akan memberikan peringatan dan tidak memasukkan data
        if($array){
            $upperType == 'IN' ? abort(403, 'Anda sudah presensi masuk hari ini') : abort(403, 'Anda sudah presensi keluar hari ini.');
        }
        
        //memasukkan request yang sudah lolos validasi ke tabel epresence
        $epresence = Epresence::create($data);

        //return json data epresence yang baru dibuat
        return new EpresenceResource($epresence);
    }

    //Approve Data
    public function approve(ApproveEpresenceRequest $request, Epresence $epresence){
        
        $user = $request->user();
        $data = $request->validated();

        //membuat validasi apakah user yang akan approve memiliki kewenangan untuk approve epresence
        $supervisor = User::where('npp_supervisor', $user->npp)->pluck('id')->all();
        $array = in_array($epresence->id,$supervisor);

        //jika validasi gagal (bukan supervisor), sistem akan memberikan peringatan
        if(!$array){
            return abort(403, 'Anda bukan supervisor.');
        }

        //mengubah kolom is_approve menjadi true
        $epresence->update($data);
        
        //return json data epresence yang sudah di approve oleh supervisor
        return new EpresenceResource($epresence);
    }

}
