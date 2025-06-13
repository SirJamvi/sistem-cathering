@extends('layouts.app')

@section('title', 'Validasi Manual')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">Validasi Manual Karyawan</h5></div>
                <div class="card-body">
                    <p class="text-muted">Gunakan fitur ini jika scanner QR bermasalah. Cari karyawan berdasarkan NIP atau nama.</p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    {{-- Di sini Anda bisa menambahkan fitur live search dengan javascript --}}
                    {{-- Untuk saat ini, kita buat form sederhana --}}
                    <form action="{{ route('koki.validasi.manual.proses') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="karyawan_id" class="form-label">ID Karyawan</label>
                            <input type="text" name="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" placeholder="Masukkan ID Karyawan..." required>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Validasi Pengambilan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection