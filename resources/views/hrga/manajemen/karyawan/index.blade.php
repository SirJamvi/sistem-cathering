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
            <td><a href="{{ route('hrga.manajemen.karyawan.show', $item->id) }}">{{ $item->nip }}</a></td>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->divisi->nama_divisi ?? '-' }}</td>
            <td>{{ $item->shift->nama_shift ?? '-' }}</td>
            <td class="text-center">
                <x-status-badge :status="$item->status_kerja" />
            </td>
            <td class="text-center">
                <form action="{{ route('hrga.manajemen.karyawan.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('hrga.manajemen.karyawan.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus karyawan ini?')">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
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