@extends('sewa_buku.layouts.app')

@section('style')
@endsection

@section('title')
    Edit Tags Buku
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Tags Buku</h3>
                <p class="text-subtitle text-muted">Edit tags untuk buku "{{ $buku->judul_buku }}"</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Daftar Buku</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Tags</li>
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
                        <h4 class="card-title mb-4">Pilih Tags untuk Buku "{{ $buku->judul_buku }}"</h4>

                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Form Edit Tags -->
                        <form action="{{ route('admin.tagsBuku.update', $buku->id_buku) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label">Tags Tersedia</label>
                                <div class="row">
                                    @foreach($tags as $tag)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    name="id_tags[]"
                                                    value="{{ $tag->id_tags }}"
                                                    class="form-check-input"
                                                    id="tag-{{ $tag->id_tags }}"
                                                    {{ in_array($tag->id_tags, $selectedTags) ? 'checked' : '' }}
                                                >
                                                <label class="form-check-label" for="tag-{{ $tag->id_tags }}">
                                                    {{ $tag->nama_tags }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end mt-4">
                                <a href="{{ route('admin.buku.edit', $buku->id_buku) }}" class="btn btn-secondary">Batal</a>
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
