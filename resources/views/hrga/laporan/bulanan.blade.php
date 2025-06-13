@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="container">
    <x-laporan-table>
        <x-slot name="title">
            Laporan Konsumsi Bulanan
        </x-slot>

        {{-- Slot untuk Filter --}}
        <x-slot name="filters">
            {{-- Anda bisa menambahkan form filter bulan, tahun, dan vendor di sini --}}
            <p class="text-muted">Filter laporan bulanan akan ditempatkan di sini.</p>
        </x-slot>

        {{-- Slot untuk Header Tabel --}}
        <x-slot name="head">
            <th>Periode</th>
            <th>Vendor</th>
            <th class="text-end">Total Porsi Dipesan</th>
            <th class="text-end">Total Dikonsumsi</th>
            <th class="text-end">Total Biaya</th>
            <th class="text-center">Efektivitas</th>
        </x-slot>

        {{-- Slot untuk Body Tabel --}}
        <x-slot name="body">
            @forelse ($laporan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($item->bulan)->format('F') }} {{ $item->tahun }}</td>
                    <td>{{ $item->vendor->nama_vendor ?? '-' }}</td>
                    <td class="text-end">{{ number_format($item->total_porsi_dipesan) }}</td>
                    <td class="text-end">{{ number_format($item->total_porsi_dikonsumsi) }}</td>
                    <td class="text-end">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                    <td class="text-center fw-bold">{{ $item->persentase_efektivitas }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada data untuk ditampilkan.</td>
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