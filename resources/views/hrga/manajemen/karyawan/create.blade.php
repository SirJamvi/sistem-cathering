@extends('layouts.app')

@section('title', 'Tambah Karyawan Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Formulir Pendaftaran Karyawan Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('hrga.manajemen.karyawan.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">Nomor Induk Pegawai (NIP)</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}" required>
                                @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="divisi_id" class="form-label">Divisi</label>
                                <select class="form-select @error('divisi_id') is-invalid @enderror" id="divisi_id" name="divisi_id" required>
                                    <option value="">Pilih Divisi...</option>
                                    @foreach($divisi as $item)
                                        <option value="{{ $item->id }}" {{ old('divisi_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_divisi }}</option>
                                    @endforeach
                                </select>
                                @error('divisi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shift_id" class="form-label">Shift</label>
                                <select class="form-select @error('shift_id') is-invalid @enderror" id="shift_id" name="shift_id" required>
                                    <option value="">Pilih Shift...</option>
                                    @foreach($shifts as $item)
                                        <option value="{{ $item->id }}" {{ old('shift_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_shift }}</option>
                                    @endforeach
                                </select>
                                @error('shift_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                                <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror" id="tanggal_bergabung" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', date('Y-m-d')) }}" required>
                                @error('tanggal_bergabung') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- ✅ TAMBAHKAN DUA INPUT INI -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('hrga.manajemen.karyawan.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
