@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $pesanan->id)

@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pesanan #{{ $pesanan->id }}</h5>
                    <a href="{{ route('hrga.pesanan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%;">Status</th>
                            <td>: <x-status-badge :status="$pesanan->status_pesanan"/></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pesanan</th>
                            <td>: {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Shift</th>
                            <td>: {{ $pesanan->shift->nama_shift ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Vendor</th>
                            <td>: {{ $pesanan->vendor->nama_vendor ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Porsi</th>
                            <td>: {{ $pesanan->jumlah_porsi_dipesan }} Porsi</td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td>: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Oleh</th>
                            <td>: {{ $pesanan->adminHrga->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>: {{ $pesanan->catatan_pesanan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection