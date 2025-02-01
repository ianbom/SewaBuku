@extends('sewa_buku.layouts.app')

@section('style')
@endsection

@section('title')
    Tambah Buku Baru
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Buku Baru</h3>
                <p class="text-subtitle text-muted">Form untuk menambahkan buku baru</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Daftar Buku</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Buku Baru</li>
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
                        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Judul Buku -->
                                <div class="col-md-6 mb-3">
                                    <label for="judul_buku" class="form-label">Judul Buku</label>
                                    <input type="text" name="judul_buku" id="judul_buku" class="form-control" required>
                                </div>

                                <!-- Penulis -->
                                <div class="col-md-6 mb-3">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" name="penulis" id="penulis" class="form-control" required>
                                </div>

                                <!-- Tentang Penulis -->
                                <div class="col-md-12 mb-3">
                                    <label for="tentang_penulis" class="form-label">Tentang Penulis</label>
                                    <textarea name="tentang_penulis" id="tentang_penulis" rows="4" class="form-control" required></textarea>
                                </div>

                                <!-- Rating Amazon -->
                                <div class="col-md-6 mb-3">
                                    <label for="rating_amazon" class="form-label">Rating Amazon</label>
                                    <input type="number" name="rating_amazon" id="rating_amazon" step="0.1" min="0" max="5" class="form-control" required>
                                </div>

                                <!-- Link Pembelian -->
                                <div class="col-md-6 mb-3">
                                    <label for="link_pembelian" class="form-label">Link Pembelian</label>
                                    <input type="url" name="link_pembelian" id="link_pembelian" class="form-control" required>
                                </div>

                                <!-- Penerbit -->
                                <div class="col-md-6 mb-3">
                                    <label for="penerbit" class="form-label">Penerbit</label>
                                    <input type="text" name="penerbit" id="penerbit" class="form-control" required>
                                </div>

                                <!-- ISBN -->
                                <div class="col-md-6 mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" name="isbn" id="isbn" class="form-control" required>
                                </div>

                                <!-- Tahun Terbit -->
                                <div class="col-md-6 mb-3">
                                    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                    <input type="text" name="tahun_terbit" id="tahun_terbit" class="form-control" required>
                                </div>

                                <!-- Teaser Audio -->
                                <div class="col-md-6 mb-3">
                                    <label for="teaser_audio" class="form-label">Teaser Audio (MP3)</label>
                                    <input type="file" name="teaser_audio" id="teaser_audio" accept="audio/mp3" class="form-control" required>
                                </div>

                                <!-- Ringkasan Audio -->
                                <div class="col-md-6 mb-3">
                                    <label for="ringkasan_audio" class="form-label">Ringkasan Audio (MP3)</label>
                                    <input type="file" name="ringkasan_audio" id="ringkasan_audio" accept="audio/mp3" class="form-control" required>
                                </div>

                                <!-- Sinopsis -->
                                <div class="col-md-12 mb-3">
                                    <label for="sinopsis" class="form-label">Sinopsis</label>
                                    <textarea name="sinopsis" id="sinopsis" rows="4" class="form-control" required></textarea>
                                </div>

                                <!-- Cover Buku -->
                                <div class="col-md-12 mb-3">
                                    <label for="cover_buku" class="form-label">Cover Buku (JPG/PNG)</label>
                                    <input type="file" name="cover_buku[]" id="cover_buku" accept="image/jpeg,image/png" class="form-control" multiple required>
                                </div>
                            </div>

                            <!-- Is Free -->
                            <div class="form-check mb-4">
                                <input type="checkbox" name="is_free" id="is_free" value="1" class="form-check-input">
                                <label for="is_free" class="form-check-label">Apakah Buku Gratis?</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan Buku</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection
