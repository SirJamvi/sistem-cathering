@extends('layouts.app')

@section('title', 'Laporan Harian')

@section('content')
<div class="container">
    <x-laporan-table>
        <x-slot name="title">
            Laporan Konsumsi Harian
        </x-slot>

        {{-- Slot untuk Filter --}}
        <x-slot name="filters">
            <form action="{{ route('hrga.laporan.harian') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label for="shift_id" class="form-label">Shift</label>
                    <select class="form-select" id="shift_id" name="shift_id">
                        <option value="">Semua Shift</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}" {{ request('shift_id') == $shift->id ? 'selected' : '' }}>
                                {{ $shift->nama_shift }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('hrga.laporan.harian') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </x-slot>

        {{-- Slot untuk Header Tabel --}}
        <x-slot name="head">
            <th>Tanggal</th>
            <th>Shift</th>
            <th>Vendor</th>
            <th class="text-center">Dipesan</th>
            <th class="text-center">Dikonsumsi</th>
            <th class="text-center">Sisa</th>
            <th class="text-center">Efektivitas</th>
        </x-slot>

        {{-- Slot untuk Body Tabel --}}
        <x-slot name="body">
            @forelse ($laporan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->shift->nama_shift ?? '-' }}</td>
                    <td>{{ $item->pesananMakanan->vendor->nama_vendor ?? '-' }}</td>
                    <td class="text-center">{{ $item->total_porsi_dipesan }}</td>
                    <td class="text-center">{{ $item->total_porsi_dikonsumsi }}</td>
                    <td class="text-center">{{ $item->total_porsi_sisa }}</td>
                    <td class="text-center fw-bold">{{ $item->persentase_konsumsi }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data untuk ditampilkan.</td>
                </tr>
            @endforelse
        </x-slot>

        {{-- Slot untuk Paginasi --}}
        @if ($laporan->hasPages())
            <x-slot name="pagination">
                {{ $laporan->links() }}
            </x-slot>
        @endif
    </x-laporan-table>
</div>
@endsection