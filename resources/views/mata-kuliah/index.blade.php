@extends('layouts.app')

@section('title', 'Mata kuliah')
@section('breadcrumb', 'Mata kuliah')

@section('content')
    <div class="page-heading"><div><div class="eyebrow">Data akademik</div><h1 class="page-title">Mata kuliah</h1><p class="page-subtitle">Kelola mata kuliah yang tersedia di setiap program studi.</p></div><a class="button button-primary" href="{{ route('mata-kuliah.create') }}">＋ Tambah mata kuliah</a></div>
    <section class="panel"><div class="panel-head"><div><div class="panel-title">Daftar mata kuliah</div><div class="panel-meta">{{ $mataKuliahList->count() }} mata kuliah tersimpan</div></div></div>
        <div class="table-wrap"><table><thead><tr><th>Kode</th><th>Nama mata kuliah</th><th>Program studi</th><th>SKS</th><th>Semester</th><th>Aksi</th></tr></thead><tbody>
        @forelse ($mataKuliahList as $item)<tr><td><strong>{{ $item->kode_mk }}</strong></td><td>{{ $item->nama_mk }}</td><td>{{ $item->prodi->nama_prodi }}</td><td>{{ $item->sks }}</td><td>{{ $item->semester }}</td><td><div class="action-row"><a class="action-link" href="{{ route('mata-kuliah.edit', $item) }}">Ubah</a><form method="POST" action="{{ route('mata-kuliah.destroy', $item) }}" onsubmit="return confirm('Hapus mata kuliah ini?')">@csrf @method('DELETE')<button class="action-link" style="border:0;background:none;cursor:pointer" type="submit">Hapus</button></form></div></td></tr>
        @empty<tr><td colspan="6"><div class="empty-state">Belum ada mata kuliah.</div></td></tr>@endforelse
        </tbody></table></div>
    </section>
@endsection