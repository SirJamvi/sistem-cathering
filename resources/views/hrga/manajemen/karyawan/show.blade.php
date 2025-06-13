@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Karyawan</h5>
                    <a href="{{ route('hrga.manajemen.karyawan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%;">Nama Lengkap</th>
                            <td>: {{ $karyawan->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td>: {{ $karyawan->nip }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $karyawan->email }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td>: {{ $karyawan->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Divisi</th>
                            <td>: {{ $karyawan->divisi->nama_divisi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Shift</th>
                            <td>: {{ $karyawan->shift->nama_shift ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Kerja</th>
                            <td>: <x-status-badge :status="$karyawan->status_kerja" /></td>
                        </tr>
                        <tr>
                            <th>Tanggal Bergabung</th>
                            <td>: {{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d F Y') }}</td>
                        </tr>
                    </table>
                    <div class="mt-3 text-end">
                        <a href="{{ route('hrga.manajemen.karyawan.edit', $karyawan->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection