<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = $request->string('q')->trim()->toString();
        $mahasiswa = Mahasiswa::with('prodi')
            ->when($keyword, fn ($query) => $query->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('nim', 'like', "%{$keyword}%");
            }))
            ->orderBy('nama')
            ->paginate(8)
            ->withQueryString();

        return view('mahasiswa.index', compact('mahasiswa', 'keyword'));
    }

    public function create(): View
    {
        return view('mahasiswa.form', ['mahasiswa' => new Mahasiswa, 'prodi' => Prodi::orderBy('nama_prodi')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['foto'] = $request->file('foto')?->store('mahasiswa', 'public');
        $mahasiswa = Mahasiswa::create($data);

        return redirect()->route('mahasiswa.show', $mahasiswa)->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.show', ['mahasiswa' => $mahasiswa->load('prodi')]);
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.form', ['mahasiswa' => $mahasiswa, 'prodi' => Prodi::orderBy('nama_prodi')->get()]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $data = $this->validatedData($request, $mahasiswa);
        $fotoLama = $mahasiswa->foto;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        $mahasiswa->update($data);

        if ($request->hasFile('foto') && $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()->route('mahasiswa.show', $mahasiswa)->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $foto = $mahasiswa->foto;
        $mahasiswa->delete();
        if ($foto) {
            Storage::disk('public')->delete($foto);
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Mahasiswa $mahasiswa = null): array
    {
        return $request->validate([
            'nim' => ['required', 'string', 'max:25', 'unique:mahasiswa,nim,'.$mahasiswa?->id],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'email' => ['nullable', 'email', 'max:255'],
            'angkatan' => ['required', 'integer', 'between:2000,2100'],
            'alamat' => ['nullable', 'string', 'max:2000'],
            'prodi_id' => ['nullable', 'exists:prodi,id'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}