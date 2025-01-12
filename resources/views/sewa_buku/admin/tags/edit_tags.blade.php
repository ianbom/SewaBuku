@extends('sewa_buku.layouts.app')

@section('title')
    Edit Tags
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Tags</h3>
                <p class="text-subtitle text-muted">Perbarui nama tags sesuai kebutuhan.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Tags</li>
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
                        <h4 class="card-title mb-4">Form Edit Tags</h4>

                        <!-- Tampilkan pesan sukses jika ada -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Form Edit Tags -->
                        <form action="{{ route('admin.tags.update', $tags->id_tags) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Tags -->
                            @if ($tags->id_child != null)
                                <div class="mb-3">
                                    <label for="id_child" class="form-label">ID Parent (Optional)</label>
                                    <select name="id_child" class="form-control">
                                        <option value="">-- Pilih Parent Tag (Opsional) --</option>
                                        @foreach ($parent as $tag)
                                            <option value="{{ $tag->id_tags }}"
                                                {{ old('id_child', $tags->id_child) == $tag->id_tags ? 'selected' : '' }}>
                                                {{ $tag->nama_tags }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_child')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_tags" class="form-label">Nama Tags</label>
                                    <input type="text" id="nama_tags" name="nama_tags" value="{{ old('nama_tags', $tags->nama_tags) }}"
                                           class="form-control @error('nama_tags') is-invalid @enderror" required>
                                    @error('nama_tags')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="nama_tags" class="form-label">Nama Tags</label>
                                    <input type="text" id="nama_tags" name="nama_tags" value="{{ old('nama_tags', $tags->nama_tags) }}"
                                           class="form-control @error('nama_tags') is-invalid @enderror" required>
                                    @error('nama_tags')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                            

                            <!-- Tombol Simpan Perubahan -->
                            <div class="text-end mt-4">
                                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
