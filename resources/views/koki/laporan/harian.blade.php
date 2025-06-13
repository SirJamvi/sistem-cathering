@extends('layouts.app')

@section('title', 'Laporan Scan Harian')

@section('content')
<div class="container">
    <x-laporan-table>
        <x-slot name="title">
            Riwayat Scan QR Code Hari Ini ({{ now()->format('d F Y') }})
        </x-slot>

        {{-- ✅ BAGIAN FILTER BARU --}}
        <x-slot name="filters">
            <form action="{{ route('koki.laporan.harian') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="shift_id" class="form-label">Filter Berdasarkan Shift</label>
                    <select class="form-select" id="shift_id" name="shift_id">
                        <option value="">Tampilkan Semua Shift</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}" {{ request('shift_id') == $shift->id ? 'selected' : '' }}>
                                {{ $shift->nama_shift }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('koki.laporan.harian') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </x-slot>

        {{-- Header Tabel --}}
        <x-slot name="head">
            <th>Waktu Scan</th>
            <th>Nama Karyawan</th>
            <th>Shift</th>
            <th class="text-center">Hasil Scan</th>
            <th>Pesan</th>
        </x-slot>

        {{-- Body Tabel --}}
        <x-slot name="body">
            @forelse ($scanHistory as $log)
                <tr>
                    <td>{{ $log->waktu_scan->format('H:i:s') }}</td>
                    <td>{{ $log->karyawan->nama_lengkap ?? 'N/A' }}</td>
                    <td>{{ $log->karyawan->shift->nama_shift ?? 'N/A' }}</td>
                    <td class="text-center">
                        <x-status-badge :status="$log->hasil_scan" />
                    </td>
                    <td>{{ $log->pesan_error }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada aktivitas scan yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </x-slot>

        {{-- Paginasi --}}
        @if ($scanHistory->hasPages())
            <x-slot name="pagination">
                {{ $scanHistory->appends(request()->query())->links() }}
            </x-slot>
        @endif
    </x-laporan-table>
</div>
@endsection