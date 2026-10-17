@extends('layouts.app')

@section('title', 'Ringkasan')
@section('breadcrumb', 'Ringkasan')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Pusat data akademik</div><h1 class="page-title">Selamat datang 👋</h1><p class="page-subtitle">Ringkasan data kampusmu hari ini.</p></div>
        <a class="button button-primary" href="{{ route('mahasiswa.create') }}">＋ Tambah mahasiswa</a>
    </div>

    <section class="stats-grid" aria-label="Jumlah data">
        <article class="stat"><div class="stat-top"><span>Total mahasiswa</span><span class="stat-icon">◉</span></div><div class="stat-value">{{ $jumlahMahasiswa }}</div><div class="stat-foot">Data mahasiswa terdaftar</div></article>
        <article class="stat"><div class="stat-top"><span>Program studi</span><span class="stat-icon">▤</span></div><div class="stat-value">{{ $jumlahProdi }}</div><div class="stat-foot">Program studi aktif</div></article>
        <article class="stat"><div class="stat-top"><span>Mata kuliah</span><span class="stat-icon">▧</span></div><div class="stat-value">{{ $jumlahMataKuliah }}</div><div class="stat-foot">Mata kuliah terdaftar</div></article>
    </section>

    <section class="panel">
        <div class="panel-head"><div><div class="panel-title">Mahasiswa terbaru</div><div class="panel-meta">Data mahasiswa yang baru ditambahkan</div></div><a class="action-link" href="{{ route('mahasiswa.index') }}">Lihat semua →</a></div>
        <div class="table-wrap"><table><thead><tr><th>Mahasiswa</th><th>NIM</th><th>Program studi</th><th>Angkatan</th><th></th></tr></thead><tbody>
        @forelse ($mahasiswaTerbaru as $item)
            <tr><td><div class="student-cell"><span class="student-avatar">{{ strtoupper(substr($item->nama, 0, 1)) }}</span><strong>{{ $item->nama }}</strong></div></td><td>{{ $item->nim }}</td><td>{{ $item->prodi?->nama_prodi ?? 'Belum dipilih' }}</td><td>{{ $item->angkatan }}</td><td><a class="action-link" href="{{ route('mahasiswa.show', $item) }}">Detail →</a></td></tr>
        @empty
            <tr><td colspan="5"><div class="empty-state">Belum ada data mahasiswa. Tambahkan data pertamamu.</div></td></tr>
        @endforelse
        </tbody></table></div>
    </section>
@endsection