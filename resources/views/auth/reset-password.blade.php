@extends('layouts.auth')

@section('title')
    Masuk
@endsection
@section('content')
    <div class="col-lg-5 col-12 d-flex flex-column">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="/"><img src="{{ asset('images/logo-kpspam.png') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title mb-0">Setel Ulang Kata Sandi</h1>
            <p class="auth-subtitle mb-4 mt-0">Silahkan Mengganti Kata Sandi Anda</p>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close text-light" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('password.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group position-relative has-icon-left mb-2">
                    <input disabled type="email" name="email" class="form-control" placeholder="Email"
                        value="{{ $email ?? old('email') }}">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" id="password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <span class="position-absolute end-0 top-0 mt-2 me-3"
                        onclick="togglePasswordVisibility('password', 'togglePasswordIcon1')" style="cursor: pointer;">
                        <i id="togglePasswordIcon1" class="bi bi-eye-slash"></i>
                    </span>
                </div>
                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" id="password_confirmation">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <span class="position-absolute end-0 top-0 mt-2 me-3"
                        onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordIcon2')"
                        style="cursor: pointer;">
                        <i id="togglePasswordIcon2" class="bi bi-eye-slash"></i>
                    </span>
                </div>

                <button class="btn btn-primary btn-block shadow-lg mt-4">Simpan Kata Sandi</button>
            </form>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right" style="background-image: url({{ asset('/images/DSC02061-min.png') }}); background-size: cover">

        </div>
    </div>
    <div class="footer px-5 mt-auto fixed-bottom">
        @include('components.footer')
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
