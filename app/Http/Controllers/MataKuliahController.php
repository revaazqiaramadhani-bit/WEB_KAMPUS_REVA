<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(): View
    {
        return view('mata-kuliah.index', ['mataKuliahList' => MataKuliah::with('prodi')->orderBy('nama_mk')->get()]);
    }

    public function create(): View
    {
        return view('mata-kuliah.form', ['mataKuliah' => new MataKuliah, 'prodi' => Prodi::orderBy('nama_prodi')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        MataKuliah::create($this->validatedData($request));

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah): View
    {
        return view('mata-kuliah.form', ['mataKuliah' => $mataKuliah, 'prodi' => Prodi::orderBy('nama_prodi')->get()]);
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->update($this->validatedData($request, $mataKuliah));

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->delete();

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }

    private function validatedData(Request $request, ?MataKuliah $mataKuliah = null): array
    {
        return $request->validate([
            'kode_mk' => ['required', 'string', 'max:15', 'unique:mata_kuliah,kode_mk,'.$mataKuliah?->id],
            'nama_mk' => ['required', 'string', 'max:255'],
            'sks' => ['required', 'integer', 'between:1,6'],
            'semester' => ['required', 'integer', 'between:1,14'],
            'prodi_id' => ['required', 'exists:prodi,id'],
        ]);
    }
}