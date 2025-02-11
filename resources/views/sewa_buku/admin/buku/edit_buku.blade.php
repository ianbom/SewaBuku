@extends('sewa_buku.layouts.app')

@section('style')
@endsection

@section('title')
    Edit Buku
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Buku</h3>
                    <p class="text-subtitle text-muted">Perbarui informasi buku</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Daftar Buku</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="form-section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.buku.update', $buku->id_buku) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Nama Buku -->
                                <div class="mb-3">
                                    <label for="nama_buku" class="form-label">Judul Buku</label>
                                    <input type="text" name="nama_buku" id="nama_buku" class="form-control"
                                        value="{{ old('nama_buku', $buku->judul_buku) }}" required>
                                    @error('nama_buku')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sub_judul" class="form-label">Sub Judul Buku</label>
                                    <input type="text" name="sub_judul" id="sub_judul" class="form-control"
                                        value="{{ old('sub_judul', $buku->judul_buku) }}" required>
                                </div>

                                <!-- ISBN -->
                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" name="isbn" id="isbn" class="form-control"
                                        value="{{ old('isbn', $buku->isbn) }}" required>
                                    @error('isbn')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Tahun Terbit -->
                                <div class="mb-3">
                                    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                    <input type="text" name="tahun_terbit" id="tahun_terbit" class="form-control"
                                        value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
                                    @error('tahun_terbit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Penulis -->
                                <div class="mb-3">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" name="penulis" id="penulis" class="form-control"
                                        value="{{ old('penulis', $buku->penulis) }}" required>
                                    @error('penulis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Tentang Penulis -->
                                <div class="mb-3">
                                    <label for="tentang_penulis" class="form-label">Tentang Penulis</label>
                                    <textarea name="tentang_penulis" id="tentang_penulis" rows="4" class="form-control">{{ old('tentang_penulis', $buku->tentang_penulis) }}</textarea>
                                    @error('tentang_penulis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Penerbit -->
                                <div class="mb-3">
                                    <label for="penerbit" class="form-label">Penerbit</label>
                                    <input type="text" name="penerbit" id="penerbit" class="form-control"
                                        value="{{ old('penerbit', $buku->penerbit) }}" required>
                                    @error('penerbit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Sinopsis -->
                                <div class="mb-3">
                                    <label for="sinopsis" class="form-label">Sinopsis</label>
                                    <textarea name="sinopsis" id="sinopsis" rows="5" class="form-control">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                                    @error('sinopsis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Rating Amazon -->
                                <div class="mb-3">
                                    <label for="rating_amazon" class="form-label">Rating Amazon</label>
                                    <input type="number" name="rating_amazon" id="rating_amazon" class="form-control"
                                        value="{{ old('rating_amazon', $buku->rating_amazon) }}" step="0.1"
                                        min="0" max="5">
                                    @error('rating_amazon')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Link Pembelian -->
                                <div class="mb-3">
                                    <label for="link_pembelian" class="form-label">Link Pembelian</label>
                                    <input type="url" name="link_pembelian" id="link_pembelian" class="form-control"
                                        value="{{ old('link_pembelian', $buku->link_pembelian) }}">
                                    @error('link_pembelian')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Teaser Audio -->
                                <div class="mb-3">
                                    <label for="teaser_audio" class="form-label">Teaser Audio</label>
                                    <input type="file" name="teaser_audio" id="teaser_audio" class="form-control"
                                        accept="audio/mp3">
                                    <p class="text-muted">Current: {{ $buku->teaser_audio }}</p>
                                    <audio controls>
                                        <source src="{{ Storage::url($buku->teaser_audio) }}" type="audio/mp3">
                                        Browser Anda tidak mendukung pemutar audio.
                                    </audio>
                                </div>

                                <!-- Ringkasan Audio -->
                                <div class="mb-3">
                                    <label for="ringkasan_audio" class="form-label">Ringkasan Audio</label>
                                    <input type="file" name="ringkasan_audio" id="ringkasan_audio"
                                        class="form-control" accept="audio/mp3">
                                    <p class="text-muted">Current: {{ $buku->ringkasan_audio }}</p>
                                    <audio controls>
                                        <source src="{{ Storage::url($buku->ringkasan_audio) }}" type="audio/mp3">
                                        Browser Anda tidak mendukung pemutar audio.
                                    </audio>
                                </div>

                                <!-- Cover Buku -->
                                <div class="mb-3">
                                    <label for="cover_buku" class="form-label">Cover Buku (JPG, PNG)</label>
                                    <input type="file" name="cover_buku[]" id="cover_buku" class="form-control"
                                        accept=".jpg,.jpeg,.png" multiple>
                                </div>

                                <!-- Gratis (is_free) -->
                                <div class="mb-3">
                                    <label for="is_free" cla ss="form-label">Gratis?</label>
                                    <select name="is_free" id="is_free" class="form-select">
                                        <option value="0"
                                            {{ old('is_free', $buku->is_free) == 0 ? 'selected' : '' }}>Tidak</option>
                                        <option value="1"
                                            {{ old('is_free', $buku->is_free) == 1 ? 'selected' : '' }}>Ya</option>
                                    </select>
                                </div>
                                <!-- Submit Button -->
                                <div class="mt-4 text-end">
                                    <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">Cancel</a>
                                    <a href="{{ route('admin.tagsBuku.edit', $buku->id_buku) }}"
                                        class="btn btn-warning">Edit Tags Buku</a>
                                    <a href="{{ route('admin.detailBuku.edit', $buku->id_buku) }}"
                                        class="btn btn-success">Edit Chapter Buku</a>
                                    <button type="submit" class="btn btn-primary">Update Buku</button>
                                </div>
                            </form>
                            <div class="mb-3">
                                <label for="cover_buku" class="form-label">Hapus Cover Buku Disini</label>

                                <div class="d-flex flex-wrap mt-2 gap-2">
                                    @foreach ($buku->coverBuku as $cover)
                                        <div class="position-relative">
                                            <img src="{{ Storage::url($cover->file_image) }}" alt="Cover Buku"
                                                class="img-thumbnail" style="width: 100px; height: auto;">
                                            <form action="{{ route('admin.buku.deleteCover', $cover->id_cover_buku) }}"
                                                method="POST" class="position-absolute top-0 end-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">X</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
