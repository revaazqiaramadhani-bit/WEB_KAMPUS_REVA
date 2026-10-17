<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'jumlahMahasiswa' => Mahasiswa::count(),
            'jumlahProdi' => Prodi::count(),
            'jumlahMataKuliah' => MataKuliah::count(),
            'mahasiswaTerbaru' => Mahasiswa::with('prodi')->latest()->take(5)->get(),
        ]);
    }
}