<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function index(){
        return view('sesi/index');
    }

    public function login(Request $request)
    {
        // 1. Validasi inputan dari form
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        // 2. Ambil data login (email & password)
        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // 3. Cek apakah datanya cocok dengan database
        if (Auth::attempt($infologin)) {
            // Kalau cocok, arahkan ke halaman dashboard
            return redirect()->route('dashboard.page');
        } else {
            // Kalau salah, balikin lagi ke halaman login sambil bawa pesan error
           return redirect()->route('login')->withErrors('Email atau password salah')->withInput();
        }
        
    }
        public function logout(Request $request)
        {
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Berhasil Logout');
        }
}