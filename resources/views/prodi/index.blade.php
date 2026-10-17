@extends('layouts.app')

@section('title', 'Program studi')
@section('breadcrumb', 'Program studi')

@section('content')
    <div class="page-heading"><div><div class="eyebrow">Data akademik</div><h1 class="page-title">Program studi</h1><p class="page-subtitle">Kelola prodi yang dapat dipilih oleh mahasiswa dan mata kuliah.</p></div><a class="button button-primary" href="{{ route('prodi.create') }}">＋ Tambah prodi</a></div>
    <section class="panel"><div class="panel-head"><div><div class="panel-title">Daftar program studi</div><div class="panel-meta">{{ $prodiList->count() }} prodi tersimpan</div></div></div>
        <div class="table-wrap"><table><thead><tr><th>Foto</th><th>Kode</th><th>Nama program studi</th><th>Jenjang</th><th>Akreditasi</th><th>Mahasiswa</th><th>Mata kuliah</th><th>Aksi</th></tr></thead><tbody>
        @forelse ($prodiList as $item)<tr><td>@if ($item->foto)<img class="photo-thumb" src="{{ asset('storage/'.$item->foto) }}" alt="Foto {{ $item->nama_prodi }}">@else<span class="photo-placeholder">{{ strtoupper(substr($item->kode_prodi, 0, 2)) }}</span>@endif</td><td><strong>{{ $item->kode_prodi }}</strong></td><td>{{ $item->nama_prodi }}</td><td><span class="badge">{{ $item->jenjang }}</span></td><td><span class="badge {{ $item->akreditasi ? '' : 'badge-muted' }}">{{ $item->akreditasi ?: 'Belum diisi' }}</span></td><td>{{ $item->mahasiswa_count }}</td><td>{{ $item->mata_kuliah_count }}</td><td><div class="action-row"><a class="action-link" href="{{ route('prodi.edit', $item) }}">Ubah</a><form method="POST" action="{{ route('prodi.destroy', $item) }}" onsubmit="return confirm('Hapus prodi ini?')">@csrf @method('DELETE')<button class="action-link" style="border:0;background:none;cursor:pointer" type="submit">Hapus</button></form></div></td></tr>
        @empty<tr><td colspan="8"><div class="empty-state">Belum ada program studi.</div></td></tr>@endforelse
        </tbody></table></div>
    </section>
@endsection