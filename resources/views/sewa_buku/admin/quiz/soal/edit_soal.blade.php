@extends('sewa_buku.layouts.app')

@section('title')
    Edit Soal
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Soal</h3>
                <p class="text-subtitle text-muted">Perbarui informasi soal.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quiz.show', $soal->id_quiz) }}">Detail Quiz</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Soal</li>
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
                        <h4 class="card-title mb-4">Form Edit Soal</h4>

                        <!-- Form Edit Soal -->
                        <form action="{{ route('soal.update', $soal->id_soal) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Input Soal -->
                            <div class="mb-3">
                                <label for="soal" class="form-label">Soal</label>
                                <textarea name="soal" id="soal" rows="4" class="form-control" required>{{ old('soal', $soal->soal) }}</textarea>
                                @error('soal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Input Gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar (Opsional)</label>
                                @if($soal->image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($soal->image) }}" alt="Gambar Soal" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Input Opsi -->
                            <div id="opsi-container">
                                @foreach($soal->opsi as $index => $opsi)
                                    <div class="mb-3 opsi-item">
                                        <label for="opsi_{{ $index }}" class="form-label">Opsi {{ $index + 1 }}</label>
                                        <input type="text" name="opsi[{{ $opsi->id_opsi }}]" id="opsi_{{ $index }}" value="{{ $opsi->opsi }}" class="form-control" required>
                                        <input type="radio" name="is_correct" value="{{ $opsi->id_opsi }}" {{ $opsi->is_correct ? 'checked' : '' }}> Benar
                                        <button type="button" class="btn btn-danger btn-sm remove-opsi">Hapus</button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-opsi" class="btn btn-success btn-sm">Tambah Opsi</button>

                            <!-- Tombol Submit -->
                            <div class="text-end mt-4">
                                <a href="{{ route('quiz.show', $soal->id_quiz) }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Update Soal</button>
                            </div>
                        </form>



                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    let opsiCount = {{ $soal->opsi->count() }};
    document.getElementById('add-opsi').addEventListener('click', () => {
        const container = document.getElementById('opsi-container');
        const newOpsi = `
            <div class="mb-3 opsi-item">
                <label for="opsi_${opsiCount}" class="form-label">Opsi ${opsiCount + 1}</label>
                <input type="text" name="opsi[new][${opsiCount}]" id="opsi_${opsiCount}" class="form-control" required>
                <input type="radio" name="is_correct" value="new_${opsiCount}"> Benar
                <button type="button" class="btn btn-danger btn-sm remove-opsi">Hapus</button>
            </div>`;
        container.insertAdjacentHTML('beforeend', newOpsi);
        opsiCount++;

        document.querySelectorAll('.remove-opsi').forEach(button => {
            button.addEventListener('click', (e) => e.target.closest('.opsi-item').remove());
        });
    });
</script>
@endsection
