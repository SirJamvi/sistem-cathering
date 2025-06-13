@extends('layouts.app')

@section('title', 'Detail Shift')

@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Shift: {{ $shift->nama_shift }}</h5>
                    <a href="{{ route('hrga.manajemen.shift.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th style="width: 30%;">Nama Shift</th><td>: {{ $shift->nama_shift }}</td></tr>
                        <tr><th>Jam Kerja</th><td>: {{ $shift->jam_mulai }} - {{ $shift->jam_selesai }}</td></tr>
                        <tr><th>Jam Makan</th><td>: {{ $shift->jam_makan_mulai }} - {{ $shift->jam_makan_selesai }}</td></tr>
                        <tr><th>Status</th><td>: <x-status-badge :status="$shift->is_active ? 'Aktif' : 'Non_Aktif'"/></td></tr>
                        <tr><th>Keterangan</th><td>: {{ $shift->keterangan ?? '-' }}</td></tr>
                    </table>
                     <div class="mt-3 text-end">
                        <a href="{{ route('hrga.manajemen.shift.edit', $shift->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit Shift</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection