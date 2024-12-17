@extends('sewa_buku.layouts.app')

@section('title')
    Profil Admin
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Profil Admin</h3>
                <p class="text-subtitle text-muted">Lihat informasi profil Anda</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profil Admin</li>
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
                        <h4 class="card-title mb-4">Informasi Profil</h4>

                        <div class="row">
                            <!-- Nama -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-gray-700">Nama</label>
                                <p class="text-lg font-semibold">{{ $user->name }}</p>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-gray-700">Email</label>
                                <p class="text-lg font-semibold">{{ $user->email }}</p>
                            </div>

                            <!-- No. HP -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-gray-700">No. HP</label>
                                <p class="text-lg font-semibold">{{ $user->no_hp ?? 'Belum diisi' }}</p>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-gray-700">Tanggal Lahir</label>
                                <p class="text-lg font-semibold">{{ $user->tanggal_lahir ?? 'Belum diisi' }}</p>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
                                Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
