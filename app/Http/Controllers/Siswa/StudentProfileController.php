<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function show()
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        return view('siswa.profile.index', compact('student'));
    }

    public function edit()
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        return view('siswa.profile.edit', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'nama'                    => 'required|string|max:255',
            'foto'                    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tempat_lahir'            => 'nullable|string|max:100',
            'tanggal_lahir'           => 'nullable|date',
            'jenis_kelamin'           => 'nullable|in:Laki-laki,Perempuan',
            'agama'                   => 'nullable|string|max:50',
            'alamat'                  => 'nullable|string',
            'nomor_telepon'           => 'nullable|string|max:20',
            'nama_ayah'               => 'nullable|string|max:255',
            'nama_ibu'                => 'nullable|string|max:255',
            'nomor_telepon_orang_tua' => 'nullable|string|max:20',
            'hobi'                    => 'nullable|string|max:100',
            'cita_cita'               => 'nullable|string|max:100',
        ]);

        $data = $request->only([
            'nama', 
            'tempat_lahir', 
            'tanggal_lahir', 
            'jenis_kelamin', 
            'agama',
            'alamat', 
            'nomor_telepon', 
            'nama_ayah', 
            'nama_ibu', 
            'nomor_telepon_orang_tua',
            'hobi',
            'cita_cita'
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('student-photos', 'public');
            $data['foto'] = $path;
        }

        $student->update($data);

        return redirect()->route('siswa.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}