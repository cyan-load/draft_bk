<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // Menampilkan daftar siswa + filter & search
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $students = $query->paginate(10);
        $kelasList = ['X', 'XI', 'XII'];

        return view('guru.students.index', compact('students', 'kelasList'));
    }

    // Menampilkan form tambah siswa
    public function create()
    {
        return view('guru.students.create');
    }

    // Menyimpan data siswa baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:students,nis|unique:users,username',
            'email' => 'nullable|email|unique:users,email|unique:students,email',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'nomor_telepon_orang_tua' => 'nullable|string|max:20',
        ]);

        $email = $request->filled('email') ? trim($request->email) : null;

        // 1. Buat akun login otomatis untuk siswa di tabel users
        $user = User::create([
            'username' => $request->nis,
            'email' => $email,
            'password' => Hash::make('password123'), // Default password
            'role' => 'siswa',
        ]);

        // 2. Simpan profil detail siswa ke tabel students
        $data = [
            'user_id' => $user->id,
            'nis' => $request->nis,
            'email' => $email,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat ?? '-',
            'nomor_telepon' => $request->nomor_telepon ?? '-',
            'nomor_telepon_orang_tua' => $request->nomor_telepon_orang_tua,
            'status' => 'aktif',
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('student-photos', 'public');
        }

        Student::create($data);

        return redirect('/guru/students')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    // Menampilkan detail profil siswa
    public function show($id)
    {
        $student = Student::with([
            'user', 
            'answers.questionnaire', 
            'answers.question', 
            'answers.option',
            'counselingNotes.counselor',
            'counselingSessions'
        ])->findOrFail($id);
        
        // Mengelompokkan riwayat pengisian kuisioner siswa
        $answeredQuestionnaires = $student->answers->groupBy('questionnaire_id');

        return view('guru.students.show', compact('student', 'answeredQuestionnaires'));
    }

    // Menampilkan form edit data siswa
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('guru.students.edit', compact('student'));
    }

    // Memproses update data ke database
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:students,nis,' . $id,
            'email' => 'nullable|email|unique:users,email,' . ($student->user_id ?? 0) . '|unique:students,email,' . $id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'status' => 'required|in:aktif,lulus,pindah',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'nomor_telepon_orang_tua' => 'nullable|string|max:20',
        ]);

        $email = $request->filled('email') ? trim($request->email) : null;

        $data = [
            'nis' => $request->nis,
            'email' => $email,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'status' => $request->status,
            'alamat' => $request->alamat ?? '-',
            'nomor_telepon' => $request->nomor_telepon ?? '-',
            'nomor_telepon_orang_tua' => $request->nomor_telepon_orang_tua,
        ];

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('student-photos', 'public');
            $data['foto'] = $path;
        }

        $student->update($data);

        // Update user username & email
        if ($student->user) {
            $student->user->update([
                'username' => $request->nis,
                'email' => $email,
            ]);
        }

        return redirect('/guru/students')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // Menghapus data siswa
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        // Kita hapus akun User-nya, otomatis Student akan ikut terhapus
        // karena ada aturan "onDelete('cascade')" di migrasi database
        User::destroy($student->user_id);

        return redirect('/guru/students')->with('success', 'Data siswa dan akun loginnya berhasil dihapus!');
    }
}