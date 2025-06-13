@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="container">
    {{-- Menggunakan komponen tabel laporan --}}
    <x-laporan-table>
        <x-slot name="title">
            <div class="d-flex justify-content-between align-items-center">
                <span>Data Karyawan</span>
                <a href="{{ route('hrga.manajemen.karyawan.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Karyawan
                </a>
            </div>
        </x-slot>

        <x-slot name="head">
            <th>#</th>
            <th>NIP</th>
            <th>Nama Lengkap</th>
            <th>Divisi</th>
            <th>Shift</th>
            <th class="text-center">Status</th>
            <th class="text-center">Aksi</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($karyawan as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration + $karyawan->firstItem() - 1 }}</th>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->divisi->nama_divisi ?? '-' }}</td>
                    <td>{{ $item->shift->nama_shift ?? '-' }}</td>
                    <td class="text-center">
                        <x-status-badge :status="$item->status_kerja" />
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn btn-warning btn-sm" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm" title="Hapus">
                            <i class="bi bi-trash3"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Data karyawan tidak ditemukan.</td>
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