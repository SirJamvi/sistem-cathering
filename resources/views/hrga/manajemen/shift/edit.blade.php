@extends('layouts.app')

@php
    // Menentukan apakah ini form untuk 'create' atau 'edit'
    $isEdit = isset($shift);
    $formAction = $isEdit ? route('hrga.manajemen.shift.update', $shift->id) : route('hrga.manajemen.shift.store');
@endphp

@section('title', $isEdit ? 'Edit Shift' : 'Tambah Shift Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">{{ $isEdit ? 'Formulir Edit Shift' : 'Formulir Shift Baru' }}</h5></div>
                <div class="card-body">
                    <form action="{{ $formAction }}" method="POST">
                        @csrf
                        @if($isEdit)
                            @method('PUT')
                        @endif
                        
                        <div class="mb-3">
                            <label for="nama_shift" class="form-label">Nama Shift</label>
                            <input type="text" class="form-control @error('nama_shift') is-invalid @enderror" name="nama_shift" value="{{ old('nama_shift', $shift->nama_shift ?? '') }}" required>
                            @error('nama_shift') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai Kerja</label>
                                <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" name="jam_mulai" value="{{ old('jam_mulai', $shift->jam_mulai ?? '') }}" required>
                                @error('jam_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai Kerja</label>
                                <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" name="jam_selesai" value="{{ old('jam_selesai', $shift->jam_selesai ?? '') }}" required>
                                @error('jam_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="jam_makan_mulai" class="form-label">Jam Mulai Makan</label>
                                <input type="time" class="form-control @error('jam_makan_mulai') is-invalid @enderror" name="jam_makan_mulai" value="{{ old('jam_makan_mulai', $shift->jam_makan_mulai ?? '') }}" required>
                                @error('jam_makan_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jam_makan_selesai" class="form-label">Jam Selesai Makan</label>
                                <input type="time" class="form-control @error('jam_makan_selesai') is-invalid @enderror" name="jam_makan_selesai" value="{{ old('jam_makan_selesai', $shift->jam_makan_selesai ?? '') }}" required>
                                @error('jam_makan_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                             <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" name="is_active" required>
                                <option value="1" {{ old('is_active', $shift->is_active ?? '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $shift->is_active ?? '1') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('hrga.manajemen.shift.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Shift' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection