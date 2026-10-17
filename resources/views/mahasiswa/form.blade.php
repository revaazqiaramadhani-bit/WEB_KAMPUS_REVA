@extends('layouts.app')

@php($editing = $mahasiswa->exists)
@section('title', $editing ? 'Ubah mahasiswa' : 'Tambah mahasiswa')
@section('breadcrumb', 'Mahasiswa / '.($editing ? 'Ubah data' : 'Tambah data'))

@section('content')
    <div class="page-heading"><div><div class="eyebrow">Data akademik</div><h1 class="page-title">{{ $editing ? 'Ubah mahasiswa' : 'Tambah mahasiswa' }}</h1><p class="page-subtitle">Isi identitas mahasiswa dan pilih program studinya.</p></div></div>
    @if ($prodi->isEmpty())<div class="alert alert-error">Belum ada prodi. Kamu tetap bisa menyimpan mahasiswa tanpa memilih prodi.</div>@endif
    <form class="panel form-panel" method="POST" enctype="multipart/form-data" action="{{ $editing ? route('mahasiswa.update', $mahasiswa) : route('mahasiswa.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="form-grid">
            <label class="form-field"><span class="form-label">NIM *</span><input class="field" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required maxlength="25" placeholder="Contoh: 23101001">@error('nim')<span class="form-error">{{ $message }}</span>@enderror</label>
            <label class="form-field"><span class="form-label">Nama lengkap *</span><input class="field" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required placeholder="Nama mahasiswa">@error('nama')<span class="form-error">{{ $message }}</span>@enderror</label>
            <label class="form-field"><span class="form-label">Program studi</span><select class="select" name="prodi_id"><option value="" @selected(old('prodi_id', $mahasiswa->prodi_id) == '')>Belum dipilih</option>@foreach ($prodi as $item)<option value="{{ $item->id }}" @selected(old('prodi_id', $mahasiswa->prodi_id) == $item->id)>{{ $item->nama_prodi }} · {{ $item->jenjang }}</option>@endforeach</select>@error('prodi_id')<span class="form-error">{{ $message }}</span>@enderror</label>
            <label class="form-field"><span class="form-label">Angkatan *</span><input class="field" type="number" name="angkatan" min="2000" max="2100" value="{{ old('angkatan', $mahasiswa->angkatan) }}" required placeholder="2023">@error('angkatan')<span class="form-error">{{ $message }}</span>@enderror</label>
            <label class="form-field"><span class="form-label">Jenis kelamin *</span><select class="select" name="jenis_kelamin" required><option value="">Pilih jenis kelamin</option><option value="Laki-laki" @selected(old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'Laki-laki')>Laki-laki</option><option value="Perempuan" @selected(old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'Perempuan')>Perempuan</option></select>@error('jenis_kelamin')<span class="form-error">{{ $message }}</span>@enderror</label>
            <label class="form-field"><span class="form-label">Email</span><input class="field" type="email" name="email" value="{{ old('email', $mahasiswa->email) }}" placeholder="nama@email.com">@error('email')<span class="form-error">{{ $message }}</span>@enderror</label>
            <label class="form-field"><span class="form-label">Foto mahasiswa</span><input class="field" type="file" name="foto" accept="image/*">@if ($mahasiswa->foto)<img class="photo-preview" src="{{ asset('storage/'.$mahasiswa->foto) }}" alt="Foto {{ $mahasiswa->nama }}">@endif<span class="form-hint">JPG, PNG, atau WEBP. Maksimal 2 MB.</span>@error('foto')<span class="form-error">{{ $message }}</span>@enderror</label>
            <label class="form-field full"><span class="form-label">Alamat</span><textarea class="textarea" name="alamat" rows="3" placeholder="Alamat tempat tinggal">{{ old('alamat', $mahasiswa->alamat) }}</textarea>@error('alamat')<span class="form-error">{{ $message }}</span>@enderror</label>
        </div>
        <div class="form-actions"><a class="button button-light" href="{{ route('mahasiswa.index') }}">Batal</a><button class="button button-primary" type="submit">{{ $editing ? 'Simpan perubahan' : 'Simpan mahasiswa' }}</button></div>
    </form>
@endsection