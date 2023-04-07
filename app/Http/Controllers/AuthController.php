<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        //validasi apakah data login terdaftar atau tidak di sistem
        if(!Auth::attempt($credentials)){
            return response([
                'error' => 'Username atau Password salah.'
            ], 422);
        }

        //menyimpan data user ke variabel user untuk mempermudah melakukan autentifikasi ketika menggunakan sistem
        $user = Auth::user();

        //membuat token sebagai identifikasi unik ketika mengakses sistem
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        
        //menghapus token yang digunakan sebelumnya ketika masih login
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
}
