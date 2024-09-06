<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function cekLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status == 2) {
                Auth::logout();
                return back()->with('loginError', 'Akun anda dinonaktifkan, silahkan hubungi admin untuk informasi lebih lanjut.');
            } else {
                $request->session()->regenerate();
                return redirect('/dashboard');
            }
        }
        return back()->with('loginError', 'Nama Pengguna / Kata Sandi Salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
