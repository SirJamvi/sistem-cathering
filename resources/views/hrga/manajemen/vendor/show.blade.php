@extends('layouts.app')

@section('title', 'Detail Vendor')

@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Vendor: {{ $vendor->nama_vendor }}</h5>
                    <a href="{{ route('hrga.manajemen.vendor.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th style="width: 30%;">Nama Vendor</th><td>: {{ $vendor->nama_vendor }}</td></tr>
                        <tr><th>Kontak Person</th><td>: {{ $vendor->kontak_person }}</td></tr>
                        <tr><th>Email & Telepon</th><td>: {{ $vendor->email }} / {{ $vendor->phone }}</td></tr>
                        <tr><th>Alamat</th><td>: {{ $vendor->alamat }}</td></tr>
                        <tr><th>Status Kontrak</th><td>: <x-status-badge :status="$vendor->status_kontrak"/></td></tr>
                        <tr><th>Periode Kontrak</th><td>: {{ \Carbon\Carbon::parse($vendor->tanggal_kontrak_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($vendor->tanggal_kontrak_berakhir)->format('d M Y') }}</td></tr>
                        <tr><th>Harga per Porsi</th><td>: Rp {{ number_format($vendor->harga_per_porsi, 0, ',', '.') }}</td></tr>
                        <tr><th>Catatan</th><td>: {{ $vendor->catatan ?? '-' }}</td></tr>
                    </table>
                     <div class="mt-3 text-end">
                        <a href="{{ route('hrga.manajemen.vendor.edit', $vendor->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit Vendor</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection