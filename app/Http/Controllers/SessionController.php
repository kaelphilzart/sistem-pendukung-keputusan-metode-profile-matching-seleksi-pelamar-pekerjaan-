<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;


class SessionController extends Controller
{
    //

    //login

    public function login(){
        return view('login');
    }
    public function login_akun()
    {
        $attributes = request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($attributes)) {
            $user = Auth::user(); // Mendapatkan objek pengguna yang berhasil login
            session()->regenerate();
    
            if ($user->role == 'pemilik') {
                return redirect('dashboard_pemilik')->with(['success' => 'Anda masuk sebagai pemilik']);
            } elseif ($user->role == 'HRD') {
                return redirect('dashboard_HRD')->with(['success' => 'Anda masuk sebagai HRD']);
            } elseif ($user->role == 'pelamar') {
                return redirect('dashboard_pelamar')->with(['success' => 'Anda masuk sebagai pelamar']);
            }
        } else {
            return back()->with(['error' => 'Email atau password salah.']);
        }
    }



    //register

    public function register(){
        return view('register');
    }

    public function createUser()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'role' => 'required', // validasi level
        ]);
        $attributes['password'] = bcrypt($attributes['password']);
    
        $user = User::create($attributes);
        Auth::login($user);
    
        // Mengarahkan pengguna baru sesuai dengan level
        if ($user->role == "pemilik") {
            return redirect('dashboard_pemilik')->with(['success' => 'Selamat datang pemilik.']);
        } else if ($user->role == "HRD") {
            return redirect('dashboard_HRD')->with(['success' => 'Selamat datang HRD']);
        } else if ($user->role == "pelamar") {
            return redirect('dashboard_pelamar')->with(['success' => 'Selamat datang pelamar']);
        } else {
            return redirect('errors.404')->with(['success' => 'tidak punya akun']);
        }
    }

   

    //logout

    public function destroyPemilik()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'Berhasil Logout']);
    }

    public function destroyHRD()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'Berhasil Logout']);
    }

    public function destroyPelamar()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'Berhasil Logout']);
    }
}
