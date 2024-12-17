@extends('sewa_buku.layouts.app')

@section('title')
    Edit Opsi
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Opsi</h3>
                <p class="text-subtitle text-muted">Perbarui opsi untuk soal ini.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Opsi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Perbarui Opsi</h4>

                        <!-- Form Edit Opsi -->
                        <form action="{{ route('opsi.update', $opsi->id_opsi) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Input Opsi -->
                            <div class="mb-3">
                                <label for="opsi" class="form-label">Opsi</label>
                                <textarea name="opsi" id="opsi" rows="3" class="form-control" required>{{ old('opsi', $opsi->opsi) }}</textarea>
                                @error('opsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Input Gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar (Opsional)</label>
                                @if($opsi->image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($opsi->image) }}" alt="Gambar Opsi" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Input Status Kebenaran -->
                            <div class="mb-3">
                                <label for="is_correct" class="form-label">Status Kebenaran</label>
                                <select name="is_correct" id="is_correct" class="form-select" required>
                                    <option value="1" {{ $opsi->is_correct ? 'selected' : '' }}>Benar</option>
                                    <option value="0" {{ !$opsi->is_correct ? 'selected' : '' }}>Salah</option>
                                </select>
                                @error('is_correct')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update Opsi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
