<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Ambil data pengguna yang sedang login
        return view('/', compact('user'));
    }


    public function register_action(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'nama_user' => 'required',
            'email' => 'required|email|unique:tb_user',
            'role' => 'required|in:admin,user',
        ]);

        // Hash password
        $hashedPassword = Hash::make('password123');

        // Buat instance baru dari model User
        $user = new User([
            'nama_user' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $hashedPassword, // Gunakan hashed password di sini
        ]);

        // Simpan data pengguna ke database
        $user->save();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registration success. Please login!');
    }

    public function login()
    {
        $data['title'] = 'Login';
        return view('user/login', $data);
    }

    public function login_action(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Cek apakah email ada di tabel users
    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        // Email tidak ditemukan
        return back()->with('error', 'Akun anda belum terdaftar! ❌');
    }

    // Jika email ditemukan, lanjutkan autentikasi
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect('/Dashboard')->with('success', 'Selamat Datang!');
    }

    // Jika password salah
    return back()->with('error', 'Password Anda salah! ❌');
}


    public function password()
    {
        $data['title'] = 'Change Password';
        return view('user.password', $data);
    }

    public function password_action(Request $request)
{
    $request->validate([
        'old_password' => 'required|current_password',
        'new_password' => 'required|confirmed|min:8', // Tambahkan aturan min:8
    ]);

    $user = User::find(Auth::id());
    $user->password = Hash::make($request->new_password);
    $user->save();

    $request->session()->regenerate();
    return back()->with('success', 'Password Berhasil Diperbarui! ✅');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
