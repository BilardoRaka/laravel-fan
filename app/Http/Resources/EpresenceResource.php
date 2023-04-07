<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EpresenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->type == 'IN'){
            $waktu = 'waktu_masuk';
            $status = 'status_masuk';
        } else {
            $waktu = 'waktu_pulang';
            $status = 'status_pulang';
        }
        
        return [
            'id_user' => $this->user_id,
            'nama_user' => $this->user->nama,
            'tanggal' => (new \DateTime($this->waktu))->format('Y-m-d'),
            $status => $this->is_approve == true ? 'APPROVE' : 'REJECT',
            $waktu => (new \DateTime($this->waktu))->format('H:i:s'),
        ];
    }
}
