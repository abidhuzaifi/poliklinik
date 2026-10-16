<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        // Mengambil jadwal hanya untuk dokter yang sedang login
        // Sesuaikan 'id_dokter' dengan nama kolom relasi di database Anda jika berbeda
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())->latest()->get();
        return view('dokter.jadwal-periksa.index', compact('jadwals'));
    }

    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hari'        => 'required|string',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ], [
            'required' => ':attribute tidak boleh kosong.',
        ]);

        // Tambahkan ID dokter yang sedang login ke dalam data
        $validatedData['id_dokter'] = Auth::id();
        // Asumsi default status aktif saat dibuat, sesuaikan jika ada field status
        // $validatedData['status'] = 'Aktif'; 

        JadwalPeriksa::create($validatedData);

        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal periksa berhasil ditambahkan!');
    }

    public function edit(JadwalPeriksa $jadwal_periksa)
    {
        // Pengecekan keamanan: pastikan jadwal ini milik dokter yang login
        if ($jadwal_periksa->id_dokter != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('dokter.jadwal-periksa.edit', compact('jadwal_periksa'));
    }

    public function update(Request $request, JadwalPeriksa $jadwal_periksa)
    {
        if ($jadwal_periksa->id_dokter != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'hari'        => 'required|string',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'status'      => 'nullable|string' // Jika Anda menggunakan field status
        ]);

        $jadwal_periksa->update($validatedData);

        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal periksa berhasil diperbarui!');
    }

    public function destroy(JadwalPeriksa $jadwal_periksa)
    {
        if ($jadwal_periksa->id_dokter != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $jadwal_periksa->delete();
        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal periksa berhasil dihapus!');
    }
}