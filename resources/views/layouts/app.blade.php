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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navbar dengan warna baru -->
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm" style="background-color: #0e5fb4;">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <i class="bi bi-egg-fried me-2" style="font-size: 1.5rem; color: #d8d262;"></i>
                    <span style="font-weight: 700;">Sistem Catering</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left side -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if(Auth::user()->hasRole('hrga'))
                                {{-- MENU UNTUK HRGA --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('hrga.dashboard') ? 'active' : '' }}" href="{{ route('hrga.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('hrga.manajemen.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-gear me-1"></i> Manajemen
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('hrga.manajemen.karyawan.index') }}"><i class="bi bi-people me-2"></i>Data Karyawan</a></li>
                                        <li><a class="dropdown-item" href="{{ route('hrga.pesanan.index') }}"><i class="bi bi-cart me-2"></i>Pesanan Makanan</a></li>
                                        <li><a class="dropdown-item" href="{{ route('hrga.manajemen.shift.index') }}"><i class="bi bi-clock me-2"></i>Manajemen Shift</a></li>
                                        <li><a class="dropdown-item" href="{{ route('hrga.manajemen.vendor.index') }}"><i class="bi bi-shop me-2"></i>Manajemen Vendor</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('hrga.laporan.*') || request()->routeIs('hrga.monitoring.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-clipboard-data me-1"></i> Laporan & Monitoring
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('hrga.laporan.harian') }}"><i class="bi bi-file-earmark-text me-2"></i>Laporan Harian</a></li>
                                        <li><a class="dropdown-item" href="{{ route('hrga.laporan.bulanan') }}"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Laporan Bulanan</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('hrga.monitoring.konsumsi') }}"><i class="bi bi-graph-up me-2"></i>Monitoring Konsumsi</a></li>
                                    </ul>
                                </li>
                            @elseif(Auth::user()->hasRole('koki'))
                                {{-- MENU UNTUK KOKI --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('koki.dashboard') ? 'active' : '' }}" href="{{ route('koki.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Dashboard Koki
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('koki.laporan.harian') ? 'active' : '' }}" href="{{ route('koki.laporan.harian') }}">
                                        <i class="bi bi-qr-code-scan me-1"></i> Laporan Scan Harian
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right side -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="btn btn-outline-light" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="me-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background-color: #d8d262; color: #0e5fb4;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->hasRole('koki'))
                                        <a class="dropdown-item" href="{{ route('koki.profil.show') }}">
                                            <i class="bi bi-person me-2"></i> Profil Saya
                                        </a>
                                        <hr class="dropdown-divider">
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
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
                <!-- Notifikasi -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Breadcrumb -->
                @hasSection('breadcrumb')
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb" style="background-color: #e9ecef; border-radius: .25rem; padding: .75rem 1rem;">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                @endif

                <!-- Page Header -->
                @hasSection('page-header')
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-0" style="color: #0e5fb4;">
                                <i class="bi @yield('page-icon', 'bi-file-earmark') me-2"></i>
                                @yield('page-header')
                            </h2>
                            @hasSection('page-description')
                                <p class="text-muted mb-0">@yield('page-description')</p>
                            @endif
                        </div>
                        @hasSection('page-button')
                            <div>
                                @yield('page-button')
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Konten Utama -->
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-5 py-3" style="background-color: #0e5fb4; color: white;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="bi bi-egg-fried me-2" style="color: #d8d262;"></i> Sistem Catering</h5>
                        <p class="mb-0">Solusi manajemen catering untuk kebutuhan pabrik</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">
                            &copy; {{ date('Y') }} Tim Jamvi productions.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>