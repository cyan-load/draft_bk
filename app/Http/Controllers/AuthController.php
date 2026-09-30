<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin() {
        return view('auth.login');
    }

    // Menampilkan halaman register
    public function showRegister() {
        return view('auth.register');
    }

    // Proses Registrasi Siswa
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|unique:students,nis|unique:users,username', // Pastikan NIS unik di kedua tabel
            'password' => 'required|min:6',
            'nama' => 'required|string',
            'kelas' => 'required|string',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string',
            'nomor_telepon_orang_tua' => 'nullable|string',
        ]);

        // Gunakan DB Transaction agar data sinkron antara tabel users & students
        DB::beginTransaction();
        try {
            // 2. Simpan Data Akun ke tabel 'users'
            $user = User::create([
                'username' => $request->nis, 
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa'
            ]);

            // 3. Simpan Profil ke tabel 'students'
            Student::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'email' => $request->email,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
                'nomor_telepon_orang_tua' => $request->nomor_telepon_orang_tua ?? null,
                'status' => 'aktif'
            ]);

            DB::commit();

            // 4. Langsung Login dan ke Dashboard
            Auth::login($user);
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Pendaftaran gagal: ' . $e->getMessage()])->withInput();
        }
    }

    // Proses Login (Bisa pakai NIS atau Email)
    public function login(Request $request)
    {
        $request->validate([
            'login_identity' => 'required',
            'password' => 'required'
        ]);

        $identity = $request->login_identity;
        $field = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $identity, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'guru') {
                return redirect()->route('guru.dashboard');
            }
            
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'login_identity' => 'NIS/Email atau password salah.',
        ])->onlyInput('login_identity');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}