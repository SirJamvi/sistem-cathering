@extends('layouts.app')

@section('title', 'Monitoring Konsumsi Harian')

@section('content')
<div class="container">
    <x-laporan-table>
        <x-slot name="title">
            Monitoring Konsumsi Makanan Harian
        </x-slot>

        {{-- Filter Form --}}
        <x-slot name="filters">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label for="shift_id" class="form-label">Shift</label>
                    <select class="form-select" name="shift_id">
                        <option value="">Semua Shift</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}" {{ request('shift_id') == $shift->id ? 'selected' : '' }}>{{ $shift->nama_shift }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="divisi_id" class="form-label">Divisi</label>
                    <select class="form-select" name="divisi_id">
                        <option value="">Semua Divisi</option>
                        @foreach($divisi as $item)
                            <option value="{{ $item->id }}" {{ request('divisi_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_divisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                </div>
            </form>
        </x-slot>

        {{-- Table Head --}}
        <x-slot name="head">
            <th>#</th>
            <th>Nama Karyawan</th>
            <th>Divisi</th>
            <th>Shift</th>
            <th class="text-center">Status Konsumsi</th>
            <th>Waktu Pengambilan</th>
        </x-slot>

        {{-- Table Body --}}
        <x-slot name="body">
            @forelse ($karyawan as $item)
                <tr>
                    <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->divisi->nama_divisi ?? '-' }}</td>
                    <td>{{ $item->shift->nama_shift ?? '-' }}</td>
                    <td class="text-center">
                        {{-- PERBAIKAN 1: Cek jika koleksi tidak kosong --}}
                        @if($item->distribusiMakanan->isNotEmpty())
                            <x-status-badge status="berhasil" />
                        @else
                            <span class="badge text-bg-light">Belum Mengambil</span>
                        @endif
                    </td>
                    <td>
                        {{-- PERBAIKAN 2: Ambil item pertama dari koleksi, baru ambil propertinya --}}
                        {{ $item->distribusiMakanan->first()->waktu_pengambilan ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada data karyawan yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </x-slot>

        @if ($karyawan->hasPages())
            <x-slot name="pagination">
                {{ $karyawan->links() }}
            </x-slot>
        @endif
    </x-laporan-table>
</div>
@endsection