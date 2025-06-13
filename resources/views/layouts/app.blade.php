<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Catering Pabrik')</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Sistem Catering
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if(Auth::user()->hasRole('hrga'))
                                {{-- MENU UNTUK HRGA --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('hrga.dashboard') ? 'active' : '' }}" href="{{ route('hrga.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('hrga.manajemen.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                        Manajemen
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('hrga.manajemen.karyawan.index') }}">Data Karyawan</a></li>
                                         <li><a class="dropdown-item" href="{{ route('hrga.pesanan.index') }}">Pesanan Makanan</a></li>
                                         <li><a class="dropdown-item" href="{{ route('hrga.manajemen.shift.index') }}">Manajemen Shift</a></li>
                                         <li><a class="dropdown-item" href="{{ route('hrga.manajemen.vendor.index') }}">Manajemen Vendor</a></li>
                                        {{-- Link manajemen lain bisa ditambahkan di sini --}}
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('hrga.laporan.*') || request()->routeIs('hrga.monitoring.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                        Laporan & Monitoring
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('hrga.laporan.harian') }}">Laporan Harian</a></li>
                                        <li><a class="dropdown-item" href="{{ route('hrga.laporan.bulanan') }}">Laporan Bulanan</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('hrga.monitoring.konsumsi') }}">Monitoring Konsumsi</a></li>
                                    </ul>
                                </li>

                            @elseif(Auth::user()->hasRole('koki'))
                                {{-- MENU UNTUK KOKI --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('koki.dashboard') ? 'active' : '' }}" href="{{ route('koki.dashboard') }}">Dashboard Koki</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>