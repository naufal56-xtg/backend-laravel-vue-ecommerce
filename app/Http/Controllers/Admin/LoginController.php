<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.login');
    }

    public function login()
    {
        request()->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ],
            [
                'email.required' => 'Email Tidak Boleh Kosong',
                'password.required' => 'Password Tidak Boleh Kosong',
                'email.email' => 'Input Yang Anda Masukkan Bukan Jenis Email',
                'password.min' => 'Minimal 6 Panjang Character'
            ],
        );

        $data = request()->only('email', 'password');

        if (Auth::attempt($data)) {
            return redirect()->route('api.categories');
            // return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->route('admin.login');
        }
    }
}
