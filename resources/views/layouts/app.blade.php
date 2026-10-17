<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ruang Kampus') · Ruang Kampus</title>
    @vite(['resources/css/app.css', 'resources/css/pink-theme.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('dashboard') }}">
                <span class="brand-mark">R</span>
                <span><span class="brand-name">Ruang Kampus</span><span class="brand-caption">Sistem data akademik</span></span>
            </a>
            <div>
                <div class="nav-label">Menu utama</div>
                <nav class="nav-list">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon">⌂</span>Ringkasan</a>
                    <a class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}" href="{{ route('mahasiswa.index') }}"><span class="nav-icon">◉</span>Mahasiswa</a>
                    <a class="nav-link {{ request()->routeIs('prodi.*') ? 'active' : '' }}" href="{{ route('prodi.index') }}"><span class="nav-icon">▤</span>Program studi</a>
                    <a class="nav-link {{ request()->routeIs('mata-kuliah.*') ? 'active' : '' }}" href="{{ route('mata-kuliah.index') }}"><span class="nav-icon">▧</span>Mata kuliah</a>
                </nav>
            </div>
            <div class="sidebar-note">Data akademik dalam satu tempat.<br>Laravel 12 · Kampus edition</div>
        </aside>
        <main class="main-area">
            <header class="topbar">
                <div class="breadcrumb">Ruang Kampus <span aria-hidden="true"> / </span> <strong>@yield('breadcrumb', 'Ringkasan')</strong></div>
                <div class="user-chip"><span class="avatar">RK</span><span>Administrator</span></div>

                <!-- Tambahan Tombol Logout -->
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: 600;">
                Logout
            </button>
        </form>
            </header>
            <div class="page">
                @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>