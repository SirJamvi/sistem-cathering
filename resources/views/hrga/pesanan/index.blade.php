@extends('layouts.app')

@section('title', 'Daftar Pesanan Makanan')

@section('content')
<div class="container">
    <x-laporan-table>
        <x-slot name="title">
            <div class="d-flex justify-content-between align-items-center">
                <span>Daftar Pesanan Makanan</span>
                <a href="{{ route('hrga.pesanan.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Buat Pesanan
                </a>
            </div>
        </x-slot>

        <x-slot name="head">
            <th>Tanggal</th>
            <th>Shift</th>
            <th>Vendor</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Status</th>
            <th class="text-center">Aksi</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($pesanan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d M Y') }}</td>
                    <td>{{ $item->shift->nama_shift ?? '-' }}</td>
                    <td>{{ $item->vendor->nama_vendor ?? '-' }}</td>
                    <td class="text-center">{{ $item->jumlah_porsi_dipesan }}</td>
                    <td class="text-center"><x-status-badge :status="$item->status_pesanan" /></td>
                    <td class="text-center">
                        <a href="{{ route('hrga.pesanan.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data pesanan.</td>
                </tr>
            @endforelse
        </x-slot>

        @if ($pesanan->hasPages())
            <x-slot name="pagination">
                {{ $pesanan->links() }}
            </x-slot>
        @endif
    </x-laporan-table>
</div>
@endsection