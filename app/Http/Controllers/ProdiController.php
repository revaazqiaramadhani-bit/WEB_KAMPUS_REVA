<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProdiController extends Controller
{
    public function index(): View
    {
        return view('prodi.index', ['prodiList' => Prodi::withCount(['mahasiswa', 'mataKuliah'])->orderBy('nama_prodi')->get()]);
    }

    public function create(): View
    {
        return view('prodi.form', ['prodi' => new Prodi]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['foto'] = $request->file('foto')?->store('prodi', 'public');
        Prodi::create($data);

        return redirect()->route('prodi.index')->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi): View
    {
        return view('prodi.form', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi): RedirectResponse
    {
        $data = $this->validatedData($request, $prodi);
        $fotoLama = $prodi->foto;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('prodi', 'public');
        }

        $prodi->update($data);

        if ($request->hasFile('foto') && $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()->route('prodi.index')->with('success', 'Program studi berhasil diperbarui.');
    }

    public function destroy(Prodi $prodi): RedirectResponse
    {
        if ($prodi->mataKuliah()->exists()) {
            return back()->with('error', 'Prodi ini masih dipakai mata kuliah, jadi tidak bisa dihapus.');
        }

        $prodi->delete();
        if ($prodi->foto) {
            Storage::disk('public')->delete($prodi->foto);
        }

        return redirect()->route('prodi.index')->with('success', 'Program studi berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Prodi $prodi = null): array
    {
        return $request->validate([
            'kode_prodi' => ['required', 'string', 'max:15', 'unique:prodi,kode_prodi,'.$prodi?->id],
            'nama_prodi' => ['required', 'string', 'max:255'],
            'jenjang' => ['required', 'in:D3,D4,S1,S2,S3'],
            'akreditasi' => ['nullable', 'string', 'max:30'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}