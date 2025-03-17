@extends('sewa_buku.layouts.app')

@section('title')
    Detail Laporan
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Laporan</h3>
                    <p class="text-subtitle text-muted">Lihat informasi lengkap laporan buku</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('report.index') }}">Daftar Laporan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Laporan</li>
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
                            <h4 class="card-title">Informasi Laporan</h4>
                            <div class="row">
                                <!-- ID Report -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ID Laporan</label>
                                    <p class="text-lg font-semibold">{{ $report->id_report }}</p>
                                </div>

                                <!-- Nama User -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama User</label>
                                    <p class="text-lg font-semibold">{{ $report->user->name ?? '-' }}</p>
                                </div>

                                <!-- Judul Buku -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Judul Buku</label>
                                    <p class="text-lg font-semibold">{{ $report->buku->judul_buku ?? '-' }}</p>
                                </div>

                                <!-- Alasan -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Alasan Laporan</label>
                                    <p class="text-lg font-semibold">{{ $report->alasan }}</p>
                                </div>

                                <!-- Tanggal Laporan -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Laporan</label>
                                    <p class="text-lg font-semibold">{{ date('d M Y', strtotime($report->created_at)) }}</p>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('report.index') }}" class="btn btn-secondary">Kembali</a>
                                <form action="{{ route('report.destroy', $report->id_report) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus laporan ini?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
