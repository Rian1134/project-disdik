<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Halaman login (kalau sudah login, langsung ke dashboard sesuai role).
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect($this->tujuan());
        }

        return view('auth.login');
    }

    /**
     * Proses login dengan email & password.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($data, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect($this->tujuan());
    }

    /**
     * Logout lalu kembali ke halaman login.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Role admin (Spatie) ke halaman admin, selain itu ke halaman user.
     */
    private function tujuan(): string
    {
        return Auth::user()->hasRole('admin')
            ? route('admin.sekolah.index')
            : route('user.sekolah.index');
    }
}