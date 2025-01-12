@extends('sewa_buku.layouts.userApp')

@section('style')
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Beranda</h3>
                    <p class="text-subtitle text-muted">Selamat Datang di {{ env('APP_NAME') }}</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Beranda</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Layout Default</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title txt_title">Beranda </h4>
                </div>

            </div>

        </section>
    </div>
@endsection
