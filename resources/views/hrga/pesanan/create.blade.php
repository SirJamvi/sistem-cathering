@extends('layouts.app')

@section('title', 'Buat Pesanan Makanan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">Formulir Pesanan Makanan Baru</h5></div>
                <div class="card-body">
                    <form action="{{ route('hrga.pesanan.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pesanan" class="form-label">Tanggal Pesanan</label>
                                <input type="date" class="form-control @error('tanggal_pesanan') is-invalid @enderror" name="tanggal_pesanan" value="{{ old('tanggal_pesanan', date('Y-m-d')) }}" required>
                                @error('tanggal_pesanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="jumlah_porsi_dipesan" class="form-label">Jumlah Porsi</label>
                                <input type="number" class="form-control @error('jumlah_porsi_dipesan') is-invalid @enderror" name="jumlah_porsi_dipesan" value="{{ old('jumlah_porsi_dipesan') }}" required min="1">
                                @error('jumlah_porsi_dipesan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shift_id" class="form-label">Shift</label>
                                <select class="form-select @error('shift_id') is-invalid @enderror" name="shift_id" required>
                                    <option value="">Pilih Shift...</option>
                                    @foreach($shifts as $item)
                                        <option value="{{ $item->id }}" {{ old('shift_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_shift }}</option>
                                    @endforeach
                                </select>
                                @error('shift_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="vendor_id" class="form-label">Vendor</label>
                                <select class="form-select @error('vendor_id') is-invalid @enderror" name="vendor_id" required>
                                    <option value="">Pilih Vendor...</option>
                                    @foreach($vendors as $item)
                                        <option value="{{ $item->id }}" {{ old('vendor_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_vendor }}</option>
                                    @endforeach
                                </select>
                                @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="catatan_pesanan" class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" name="catatan_pesanan" rows="3">{{ old('catatan_pesanan') }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('hrga.pesanan.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection