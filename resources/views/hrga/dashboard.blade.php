@extends('layouts.app')

@section('title', 'Dashboard HRGA')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h1 class="h3 mb-0">Dashboard HRGA</h1>
            <p class="text-muted">Ringkasan aktivitas sistem hari ini.</p>
        </div>
    </div>

    {{-- Baris untuk Kartu Statistik --}}
    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <x-dashboard-card 
                icon="bi-people-fill" 
                :value="$totalKaryawanAktif" 
                label="Karyawan Aktif" 
                color="primary" />
        </div>
        <div class="col-md-6 col-xl-3">
            <x-dashboard-card 
                icon="bi-truck" 
                :value="$totalVendorAktif" 
                label="Vendor Aktif" 
                color="info" />
        </div>
        <div class="col-md-6 col-xl-3">
            <x-dashboard-card 
                icon="bi-box-seam" 
                :value="$totalPorsiDipesan" 
                label="Porsi Dipesan Hari Ini" 
                color="success" />
        </div>
        <div class="col-md-6 col-xl-3">
            <x-dashboard-card 
                icon="bi-check-circle-fill" 
                :value="$totalPorsiDikonsumsi" 
                label="Porsi Dikonsumsi" 
                color="warning" />
        </div>
    </div>

    {{-- Tambahan: Anda bisa menambahkan chart atau tabel di sini --}}
    <div class="row mt-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Aktivitas Terkini</h5>
                </div>
                <div class="card-body">
                    {{-- Di sini bisa ditambahkan tabel log aktivitas atau chart konsumsi mingguan --}}
                    <p>Chart atau data aktivitas akan ditampilkan di sini.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection