@extends('layouts.app')

@section('title', 'Manajemen Shift')

@section('content')
<div class="container">
    <x-laporan-table>
        <x-slot name="title">
            <div class="d-flex justify-content-between align-items-center">
                <span>Manajemen Jadwal Shift</span>
                <a href="{{ route('hrga.manajemen.shift.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Shift
                </a>
            </div>
        </x-slot>

        <x-slot name="head">
            <th>Nama Shift</th>
            <th>Jam Kerja</th>
            <th>Jam Makan</th>
            <th class="text-center">Status</th>
            <th class="text-center">Aksi</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($shifts as $item)
                <tr>
                    <td><a href="{{ route('hrga.manajemen.shift.show', $item->id) }}">{{ $item->nama_shift }}</a></td>
                    <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                    <td>{{ $item->jam_makan_mulai }} - {{ $item->jam_makan_selesai }}</td>
                    <td class="text-center"><x-status-badge :status="$item->is_active ? 'Aktif' : 'Non_Aktif'" /></td>
                    <td class="text-center">
                        <form action="{{ route('hrga.manajemen.shift.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('hrga.manajemen.shift.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus shift ini?')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada data shift.</td></tr>
            @endforelse
        </x-slot>

        @if ($shifts->hasPages())
            <x-slot name="pagination">{{ $shifts->links() }}</x-slot>
        @endif
    </x-laporan-table>
</div>
@endsection