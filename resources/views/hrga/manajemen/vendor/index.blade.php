@extends('layouts.app')

@section('title', 'Manajemen Vendor')

@section('content')
<div class="container">
    <x-laporan-table>
        <x-slot name="title">
            <div class="d-flex justify-content-between align-items-center">
                <span>Manajemen Data Vendor</span>
                <a href="{{ route('hrga.manajemen.vendor.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Vendor
                </a>
            </div>
        </x-slot>

        <x-slot name="head">
            <th>Nama Vendor</th>
            <th>Kontak Person</th>
            <th>Email & Telepon</th>
            <th class="text-center">Status Kontrak</th>
            <th class="text-center">Aksi</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($vendors as $item)
                <tr>
                    <td><a href="{{ route('hrga.manajemen.vendor.show', $item->id) }}">{{ $item->nama_vendor }}</a></td>
                    <td>{{ $item->kontak_person }}</td>
                    <td>{{ $item->email }} <br> <small class="text-muted">{{ $item->phone }}</small></td>
                    <td class="text-center"><x-status-badge :status="$item->status_kontrak" /></td>
                    <td class="text-center">
                        <form action="{{ route('hrga.manajemen.vendor.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('hrga.manajemen.vendor.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus vendor ini?')"><i class="bi bi-trash3"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada data vendor.</td></tr>
            @endforelse
        </x-slot>

        @if ($vendors->hasPages())
            <x-slot name="pagination">{{ $vendors->links() }}</x-slot>
        @endif
    </x-laporan-table>
</div>
@endsection