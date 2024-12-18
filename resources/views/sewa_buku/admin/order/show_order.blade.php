@extends('sewa_buku.layouts.app')

@section('title')
    Detail Pesanan
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Pesanan</h3>
                    <p class="text-subtitle text-muted">Lihat informasi lengkap pesanan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Daftar Pesanan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
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
                            <h4 class="card-title">Informasi Pesanan</h4>
                            <div class="row">
                                <!-- ID Order -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ID Order</label>
                                    <p class="text-lg font-semibold">{{ $order->id_order }}</p>
                                </div>

                                <!-- Nama User -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama User</label>
                                    <p class="text-lg font-semibold">{{ $order->user->name ?? '-' }}</p>
                                </div>

                                <!-- Paket -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Paket</label>
                                    <p class="text-lg font-semibold">{{ $order->nama_paket ?? '-' }}</p>
                                </div>

                                <!-- Total Bayar -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Total Bayar</label>
                                    <p class="text-lg font-semibold">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                                </div>

                                <!-- Status Order -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Order</label>
                                    <p class="text-lg font-semibold">
                                        @if ($order->status_order == 'Dibayar')
                                            <span class="badge bg-success">Dibayar</span>
                                        @else
                                            <span class="badge bg-danger">{{ $order->status_order }}</span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Tanggal Order -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Order</label>
                                    <p class="text-lg font-semibold">{{ date('d M Y', strtotime($order->created_at)) }}</p>
                                </div>
                            </div>



                            <div class="text-end mt-4">
                                <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
