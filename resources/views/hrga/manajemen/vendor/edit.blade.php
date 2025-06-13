@extends('layouts.app')

@php
    $isEdit = isset($vendor);
    $formAction = $isEdit ? route('hrga.manajemen.vendor.update', $vendor->id) : route('hrga.manajemen.vendor.store');
@endphp

@section('title', $isEdit ? 'Edit Vendor' : 'Tambah Vendor Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">{{ $isEdit ? 'Formulir Edit Vendor' : 'Formulir Vendor Baru' }}</h5></div>
                <div class="card-body">
                    <form action="{{ $formAction }}" method="POST">
                        @csrf
                        @if($isEdit) @method('PUT') @endif
                        
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="nama_vendor" class="form-label">Nama Vendor</label><input type="text" class="form-control @error('nama_vendor') is-invalid @enderror" name="nama_vendor" value="{{ old('nama_vendor', $vendor->nama_vendor ?? '') }}" required>@error('nama_vendor')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-md-6 mb-3"><label for="kontak_person" class="form-label">Kontak Person</label><input type="text" class="form-control @error('kontak_person') is-invalid @enderror" name="kontak_person" value="{{ old('kontak_person', $vendor->kontak_person ?? '') }}" required>@error('kontak_person')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-md-6 mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $vendor->email ?? '') }}" required>@error('email')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-md-6 mb-3"><label for="phone" class="form-label">Telepon</label><input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $vendor->phone ?? '') }}" required>@error('phone')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-12 mb-3"><label for="alamat" class="form-label">Alamat</label><textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3" required>{{ old('alamat', $vendor->alamat ?? '') }}</textarea>@error('alamat')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-md-6 mb-3"><label for="harga_per_porsi" class="form-label">Harga per Porsi (Rp)</label><input type="number" class="form-control @error('harga_per_porsi') is-invalid @enderror" name="harga_per_porsi" value="{{ old('harga_per_porsi', $vendor->harga_per_porsi ?? '') }}" required>@error('harga_per_porsi')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-md-6 mb-3"><label for="status_kontrak" class="form-label">Status Kontrak</label><select class="form-select @error('status_kontrak') is-invalid @enderror" name="status_kontrak" required><option value="aktif" @if(old('status_kontrak', $vendor->status_kontrak ?? '') == 'aktif') selected @endif>Aktif</option><option value="non_aktif" @if(old('status_kontrak', $vendor->status_kontrak ?? '') == 'non_aktif') selected @endif>Non-Aktif</option><option value="suspended" @if(old('status_kontrak', $vendor->status_kontrak ?? '') == 'suspended') selected @endif>Suspended</option></select>@error('status_kontrak')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-md-6 mb-3"><label for="tanggal_kontrak_mulai" class="form-label">Tgl Mulai Kontrak</label><input type="date" class="form-control @error('tanggal_kontrak_mulai') is-invalid @enderror" name="tanggal_kontrak_mulai" value="{{ old('tanggal_kontrak_mulai', $vendor->tanggal_kontrak_mulai ?? '') }}" required>@error('tanggal_kontrak_mulai')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-md-6 mb-3"><label for="tanggal_kontrak_berakhir" class="form-label">Tgl Berakhir Kontrak</label><input type="date" class="form-control @error('tanggal_kontrak_berakhir') is-invalid @enderror" name="tanggal_kontrak_berakhir" value="{{ old('tanggal_kontrak_berakhir', $vendor->tanggal_kontrak_berakhir ?? '') }}" required>@error('tanggal_kontrak_berakhir')<div class="invalid-feedback">{{$message}}</div>@enderror</div>
                            <div class="col-12 mb-3"><label for="catatan" class="form-label">Catatan (Opsional)</label><textarea class="form-control" name="catatan" rows="2">{{ old('catatan', $vendor->catatan ?? '') }}</textarea></div>
                        </div>
                        <div class="d-flex justify-content-end"><a href="{{ route('hrga.manajemen.vendor.index') }}" class="btn btn-secondary me-2">Batal</a><button type="submit" class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Vendor' }}</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection