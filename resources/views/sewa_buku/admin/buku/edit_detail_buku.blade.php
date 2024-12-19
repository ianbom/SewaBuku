    @extends('sewa_buku.layouts.app')

    @section('style')
    @endsection

    @section('title')
        Edit Detail Buku
    @endsection

    @section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Detail Buku</h3>
                <p class="text-subtitle text-muted">Perbarui atau tambahkan detail untuk buku "{{ $buku->judul_buku }}"</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Daftar Buku</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Detail Buku</li>
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
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.updateBuku.edit', $buku->id_buku) }}" method="POST" enctype="multipart/form-data" id="detailBukuForm">
                            @csrf
                            @method('PUT')

                            @foreach ($detailWithQuiz as $key => $detail)
                                <div class="border p-4 mb-4 rounded detail-buku">
                                    <h5 class="text-primary">Detail {{ $key + 1 }}</h5>

                                    <div class="mb-3">
                                        <label for="detail_buku[{{ $key }}][bab]" class="form-label">Bab</label>
                                        <input type="text" name="detail_buku[{{ $key }}][bab]" class="form-control" value="{{ old("detail_buku.$key.bab", $detail->bab) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="detail_buku[{{ $key }}][isi]" class="form-label">Isi</label>
                                        <textarea name="detail_buku[{{ $key }}][isi]" rows="3" class="form-control" required>{{ old("detail_buku.$key.isi", $detail->isi) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="detail_buku[{{ $key }}][audio]" class="form-label">Audio</label>
                                        <input type="file" name="detail_buku[{{ $key }}][audio]" class="form-control" accept="audio/mp3">
                                        @if ($detail->audio)
                                            <div class="form-check mt-2">
                                                <input type="checkbox" name="detail_buku[{{ $key }}][keep_existing_audio]" value="1" class="form-check-input" checked>
                                                <label class="form-check-label">Pertahankan audio yang ada</label>
                                                <p class="text-muted small">Audio saat ini: {{ $detail->audio }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="is_free_detail" class="form-label">Gratis?</label>
                                        <select name="detail_buku[{{ $key }}][is_free_detail]" id="is_free_detail" class="form-select">
                                            <option value="0" {{ old("detail_buku.$key.is_free_detail", $detail->is_free_detail) == 0 ? 'selected' : '' }}>Tidak</option>
                                            <option value="1" {{ old("detail_buku.$key.is_free_detail", $detail->is_free_detail) == 1 ? 'selected' : '' }}>Ya</option>
                                        </select>
                                    </div>

                                    @if ($detail && $detail->bab && $detail->isi)
                                        <div class="mb-3">
                                            @if ($detailWithQuiz->contains($detail))
                                                <a href="{{ route('quiz.show', $detail->id_detail_buku) }}" class="btn btn-success btn-sm">Lihat Quiz</a>
                                            @else
                                                <a href="{{ route('quiz.create', $detail->id_detail_buku) }}" class="btn btn-primary btn-sm">Buat Quiz</a>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            @endforeach

                            @foreach ($detailNoQuiz as $key => $detail)
                                <div class="border p-4 mb-4 rounded detail-buku">
                                    <h5 class="text-primary">Detail {{ $key + 1 }}</h5>

                                    <div class="mb-3">
                                        <label for="detail_buku[{{ $key }}][bab]" class="form-label">Bab</label>
                                        <input type="text" name="detail_buku[{{ $key }}][bab]" class="form-control" value="{{ old("detail_buku.$key.bab", $detail->bab) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="detail_buku[{{ $key }}][isi]" class="form-label">Isi</label>
                                        <textarea name="detail_buku[{{ $key }}][isi]" rows="3" class="form-control" required>{{ old("detail_buku.$key.isi", $detail->isi) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="detail_buku[{{ $key }}][audio]" class="form-label">Audio</label>
                                        <input type="file" name="detail_buku[{{ $key }}][audio]" class="form-control" accept="audio/mp3">
                                        @if ($detail->audio)
                                            <div class="form-check mt-2">
                                                <input type="checkbox" name="detail_buku[{{ $key }}][keep_existing_audio]" value="1" class="form-check-input" checked>
                                                <label class="form-check-label">Pertahankan audio yang ada</label>
                                                <p class="text-muted small">Audio saat ini: {{ $detail->audio }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="is_free_detail" class="form-label">Gratis?</label>
                                        <select name="detail_buku[{{ $key }}][is_free_detail]" id="is_free_detail" class="form-select">
                                            <option value="0" {{ old("detail_buku.$key.is_free_detail", $detail->is_free_detail) == 0 ? 'selected' : '' }}>Tidak</option>
                                            <option value="1" {{ old("detail_buku.$key.is_free_detail", $detail->is_free_detail) == 1 ? 'selected' : '' }}>Ya</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                            <a href="{{ route('quiz.create', $detail->id_detail_buku) }}" class="btn btn-primary btn-sm">Buat Quiz</a>
                                    </div>

                                </div>
                            @endforeach

                            <div id="newDetailsContainer"></div>
                            <button type="button" id="addDetailButton" class="btn btn-success mb-3">Tambah Detail Baru</button>

                            <div class="text-end">
                                <a href="{{ route('admin.buku.index') }}" class="btn btn-success"> Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>




                        <script>
                            document.getElementById('addDetailButton').addEventListener('click', function() {
                                const container = document.getElementById('newDetailsContainer');
                                const index = document.querySelectorAll('.detail-buku').length;

                                const newDetailHTML = `
                                    <div class="border p-4 mb-4 rounded detail-buku">
                                        <h5 class="text-success">Tambah Detail Baru ${index + 1}</h5>
                                        <div class="mb-3">
                                            <label for="detail_buku[${index}][bab]" class="form-label">Bab</label>
                                            <input type="text" name="detail_buku[${index}][bab]" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="detail_buku[${index}][isi]" class="form-label">Isi</label>
                                            <textarea name="detail_buku[${index}][isi]" rows="3" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="detail_buku[${index}][audio]" class="form-label">Audio</label>
                                            <input type="file" name="detail_buku[${index}][audio]" class="form-control" accept="audio/mp3">
                                        </div>
                                        <div class="mb-3">
                                            <label for="detail_buku[${index}][is_free_detail]" class="form-label">Gratis?</label>
                                            <select name="detail_buku[${index}][is_free_detail]" id="detail_buku[${index}][is_free_detail]" class="form-select">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>
                                `;

                                container.insertAdjacentHTML('beforeend', newDetailHTML);
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
