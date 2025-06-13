@extends('layouts.app')

@section('title', 'Edit Data Karyawan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Formulir Edit Karyawan: {{ $karyawan->nama_lengkap }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('hrga.manajemen.karyawan.update', $karyawan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Isi form sama dengan create.blade.php, namun dengan value dari $karyawan --}}
                        {{-- Contoh untuk satu field: --}}
                        <div class="row">
                             <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required>
                                @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $karyawan->nip) }}" required>
                                @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $karyawan->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="divisi_id" class="form-label">Divisi</label>
                                <select class="form-select @error('divisi_id') is-invalid @enderror" name="divisi_id" required>
                                    @foreach($divisi as $item)
                                        <option value="{{ $item->id }}" {{ old('divisi_id', $karyawan->divisi_id) == $item->id ? 'selected' : '' }}>{{ $item->nama_divisi }}</option>
                                    @endforeach
                                </select>
                                @error('divisi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shift_id" class="form-label">Shift</label>
                                <select class="form-select @error('shift_id') is-invalid @enderror" name="shift_id" required>
                                    @foreach($shifts as $item)
                                        <option value="{{ $item->id }}" {{ old('shift_id', $karyawan->shift_id) == $item->id ? 'selected' : '' }}>{{ $item->nama_shift }}</option>
                                    @endforeach
                                </select>
                                @error('shift_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status_kerja" class="form-label">Status Kerja</label>
                                <select class="form-select @error('status_kerja') is-invalid @enderror" name="status_kerja" required>
                                    @foreach(['aktif', 'cuti', 'sakit', 'non_aktif'] as $status)
                                        <option value="{{ $status }}" {{ old('status_kerja', $karyawan->status_kerja) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                @error('status_kerja') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('hrga.manajemen.karyawan.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection