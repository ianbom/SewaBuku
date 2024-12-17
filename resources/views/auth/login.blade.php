@extends('layouts.auth')

@section('title')
    Masuk
@endsection
@section('content')
    {{-- modal reset password --}}
    <div class="modal fade card-primary" id="forgotPasswordModal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-auto">
            <div class="modal-content text-center">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100 text-center" id="forgotPasswordModalLabel">Lupa Password</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form action="{{ route('password.email') }}" method="POST" id="form_send_reset_link"
                        enctype="multipart/form-data" data-modal="forgotPasswordModal">
                        @csrf
                        <label class="fw-bold mb-3">Masukkan Email Anda yang Terdaftar</label>
                        <div class="form-group position-relative has-icon-left mb-2">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block shadow-lg mt-4">Kirim Link Setel Ulang
                            Kata Sandi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal --}}
    <div class="col-lg-5 col-12 d-flex flex-column">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="/"><img src="{{ asset('images/logo-kpspam.png') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title mb-0">Masuk.</h1>
            <p class="auth-subtitle mb-4 mt-0">Masuk menggunakan akun yang telah terdaftar</p>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close text-light" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kata Sandi">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <span class="position-absolute end-0 top-0 mt-2 me-3"
                        onclick="togglePasswordVisibility('password', 'togglePasswordIcon1')" style="cursor: pointer;">
                        <i id="togglePasswordIcon1" class="bi bi-eye-slash"></i>
                    </span>
                </div>
                <div class="form-check d-flex justify-content-start align-items-center">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Buat Saya Tetap Masuk
                    </label>
                </div>
                <button class="btn btn-primary btn-block shadow-lg mt-4">Masuk</button>
            </form>
            <div class="text-center mt-3 text-lg">
                <p>Belum punya akun? <a href="{{ route('register') }}" class="fw-bold">Daftar</a>.</p>
                <p><a class="font-bold" href="#forgot-password" data-bs-toggle="modal"
                        data-bs-target="#forgotPasswordModal">Lupa Kata Sandi?</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right" style="background-image: url({{ asset('/images/bg-min.jpg') }}); background-size: cover">

        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_send_reset_link').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                let form = $(this);
                var modalId = form.data('modal');

                // Hide the modal
                $('#' + modalId).modal('hide');

                // Prepare the parameters for ajaxSaveDatas
                var arr_params = {
                    url: form.attr('action'),
                    method: 'POST',
                    input: form.serialize(),
                    forms: form[0],
                    modal: modalId,
                    reload: false,
                    load_msg: 'Sedang Mengirim Email...'
                }

                // Call the ajax function
                ajaxSaveDatas(arr_params);
            });
        });
    </script>
@endsection
