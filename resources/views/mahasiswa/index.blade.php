@extends('layouts.app')

@section('title', 'Mahasiswa')
@section('breadcrumb', 'Mahasiswa')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Data akademik</div><h1 class="page-title">Mahasiswa</h1><p class="page-subtitle">Kelola mahasiswa dan lihat program studi masing-masing.</p></div>
        <a class="button button-primary" href="{{ route('mahasiswa.create') }}">＋ Tambah mahasiswa</a>
    </div>
    <section class="panel">
        <div class="panel-head"><div><div class="panel-title">Daftar mahasiswa</div><div class="panel-meta">{{ $mahasiswa->total() }} data tersimpan</div></div>
            <form class="search-form" action="{{ route('mahasiswa.index') }}" method="GET"><input class="field" type="search" name="q" value="{{ $keyword }}" placeholder="Cari nama atau NIM..."><button class="button button-light" type="submit">Cari</button></form>
        </div>
        <div class="table-wrap"><table><thead><tr><th>Mahasiswa</th><th>NIM</th><th>Program studi</th><th>Akreditasi prodi</th><th>Angkatan</th><th>Jenis kelamin</th><th>Aksi</th></tr></thead><tbody>
        @forelse ($mahasiswa as $item)
            <tr><td><div class="student-cell">@if ($item->foto)<img class="photo-thumb" src="{{ asset('storage/'.$item->foto) }}" alt="Foto {{ $item->nama }}">@else<span class="student-avatar">{{ strtoupper(substr($item->nama, 0, 1)) }}</span>@endif<strong>{{ $item->nama }}</strong></div></td><td>{{ $item->nim }}</td><td>{{ $item->prodi?->nama_prodi ?? 'Belum dipilih' }}</td><td><span class="badge {{ $item->prodi?->akreditasi ? '' : 'badge-muted' }}">{{ $item->prodi?->akreditasi ?: '—' }}</span></td><td>{{ $item->angkatan }}</td><td>{{ $item->jenis_kelamin }}</td><td><a class="action-link" href="{{ route('mahasiswa.show', $item) }}">Lihat detail →</a></td></tr>
        @empty
            <tr><td colspan="7"><div class="empty-state">Data tidak ditemukan. Coba kata kunci lain atau tambahkan mahasiswa baru.</div></td></tr>
        @endforelse
        </tbody></table></div>
        @if ($mahasiswa->hasPages())<div class="pagination"><span>Menampilkan {{ $mahasiswa->firstItem() }}–{{ $mahasiswa->lastItem() }} dari {{ $mahasiswa->total() }}</span><nav>{{ $mahasiswa->links('pagination::simple-tailwind') }}</nav></div>@endif
    </section>
@endsection