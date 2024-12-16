@extends('layouts.auth')

@section('title')
    Daftar
@endsection
@section('style')
    <style>
        .has-icon-left {
            display: flex;
            align-items: center;
        }

        .custom-file-label {
            position: absolute;
            left: 10rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #aaa;
        }

        input[type="file"]:not(:placeholder-shown)+.custom-file-label {
            display: none;
        }

        
    </style>
@endsection
@section('content')
    <div class="col-lg-5 col-12 d-flex flex-column">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="/"><img src="{{ asset('images/logo-kpspam.png') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title mb-0">Daftar</h1>
            <p class="auth-subtitle mb-4 mt-0">Masukkan Data Anda ke Website Kami.</p>

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="email" name="email" class="form-control" placeholder="Email"
                        value="{{ old('email') }}">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="text" name="name" class="form-control" placeholder="Nama"
                        value="{{ old('name') }}">
                    <div class="form-control-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="text" id="rtRwInput" name="rt_rw" value="{{ old('rt_rw') }}" class="form-control"
                        placeholder="RT/ RW" required>
                    <div class="form-control-icon">
                        <i class="bi bi-houses"></i>
                    </div>
                    <small id="error-message" style="color: red; display: none;">Format harus seperti 001/003</small>
                </div>
                <div class="form-group position-relative">
                    <label for="kartuIdentitasInput">
                        KTP/ KK/ Passport
                    </label>
                    <input type="file" id="kartuIdentitasInput" name="kartu_identitas" class="form-control"
                        placeholder="KTP/ KK/ Passport" required>
                    <small id="error-message" style="color: red; display: none;">Input Gambar KTP/KK/Passport Max.
                        2mb</small>
                </div>
                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                        required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <span class="position-absolute end-0 top-0 mt-2 me-3"
                        onclick="togglePasswordVisibility('password', 'togglePasswordIcon1')" style="cursor: pointer;">
                        <i id="togglePasswordIcon1" class="bi bi-eye-slash"></i>
                    </span>
                </div>

                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="Confirm Password" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <span class="position-absolute end-0 top-0 mt-2 me-3"
                        onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordIcon2')"
                        style="cursor: pointer;">
                        <i id="togglePasswordIcon2" class="bi bi-eye-slash"></i>
                    </span>
                </div>
                {{-- <div class="form-check form-check-lg d-flex align-items-end">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                        Buat Saya Tetap Masuk
                    </label>
                </div> --}}
                <button type="submit" class="btn btn-primary btn-block shadow-lg mt-4">Daftar Sekarang</button>
            </form>
            <div class="text-center mt-3">
                <p>Sudah punya Akun? <a href="{{ route('login') }}" class="font-bold">Masuk</a>.</p>
                {{-- <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p> --}}
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right" style="background-image: url({{ asset('/images/DSC02061-min.png') }}); background-size: cover">

        </div>
    </div>

    <div class="footer px-5 mt-auto">
        @include('components.footer')
    </div>
@endsection

@section('scripts')
    <script>
        $('#rtRwInput').on('input', function() {
            const input = $(this).val();
            const regex = /^\d{3}\/\d{3}$/; // Regular expression for 3 digits / 3 digits format

            const $errorMessage = $('#error-message');

            if (regex.test(input)) {
                $(this).removeClass('is-invalid');
                $errorMessage.hide();
            } else {
                $(this).addClass('is-invalid');
                $errorMessage.show();
            }
        });
    </script>
@endsection
