<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user()->load('role');

            if ($user->role->name == 'pemeliharaan') {
                return redirect()->route('pemeliharaan.sewa-kendaraan.index');
            } elseif ($user->role->name == 'fasilitas') {
                return redirect()->route('fasilitas.sewa-kendaraan.index');
            } elseif ($user->role->name == 'admin') {
                return redirect()->route('admin.sewa-kendaraan.index');
            } elseif ($user->role->name == 'vendor') {
                return redirect()->route('vendor.sewa-kendaraan.index');
            }
        }
    
        return back()->withErrors(['credentials' => 'Password atau Username yang anda masukkan salah']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}