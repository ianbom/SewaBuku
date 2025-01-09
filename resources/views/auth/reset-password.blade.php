@extends('layouts.auth')

@section('title')
    Setel Ulang Kata Sandi
@endsection

@section('content')
<<<<<<< HEAD
    <div class="col-lg-5 col-12 d-flex flex-column">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="/"><img src="{{ asset('images/logo-kpspam.png') }}" alt="Logo"></a>
=======
<div class="d-flex align-items-center justify-content-center" style="height: 100vh; background-image: url('{{ asset('/images/bglogin.png') }}'); background-size: cover; background-position: center;">
    <div class="card p-4" style="width: 500px; background-color: transparent;">
        <h1 class="text-center text-white" style="font-size: 28px; margin-bottom:20px; font-weight: bold; font-family: 'Libre Baskerville', serif;">Setel Ulang Kata Sandi</h1>
        <p class="text-center text-white" style="font-size: 16px; margin-bottom:40px; font-family: 'Libre Baskerville', serif;">Silahkan Mengganti Kata Sandi Anda</p>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close text-light" data-bs-dismiss="alert" aria-label="Close"></button>
>>>>>>> 87025d4... FE Login, Register, Landing Page
            </div>
        @endif

        <form action="{{ route('password.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group position-relative has-icon-left mb-3">
                <input disabled type="email" name="email" class="form-control" placeholder="Email" value="{{ $email ?? old('email') }}" style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                <div class="form-control-icon" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                    <i class="bi bi-person" style="font-size: 16px; color: #fff;"></i>
                </div>
            </div>

            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group position-relative has-icon-left mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" id="password" style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                <div class="form-control-icon" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                    <i class="bi bi-shield-lock" style="font-size: 16px; color: #fff;"></i>
                </div>
                <span class="position-absolute end-0 top-0 mt-2 me-3" onclick="togglePasswordVisibility('password', 'togglePasswordIcon1')" style="cursor: pointer;">
                    <i id="togglePasswordIcon1" class="bi bi-eye-slash" style="color: #fff;"></i>
                </span>
            </div>

            <div class="form-group position-relative has-icon-left mb-2">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" id="password_confirmation" style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                <div class="form-control-icon" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                    <i class="bi bi-shield-lock" style="font-size: 16px; color: #fff;"></i>
                </div>
                <span class="position-absolute end-0 top-0 mt-2 me-3" onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordIcon2')" style="cursor: pointer;">
                    <i id="togglePasswordIcon2" class="bi bi-eye-slash" style="color: #fff;"></i>
                </span>
            </div>

            <button class="btn w-100 mb-3" style="background-color: #052D6E; border: 2px solid #1E90FF; color: white; font-weight: semibold; font-family: 'Libre Baskerville', serif; border-radius: 16px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#1E90FF'" onmouseout="this.style.backgroundColor='#052D6E'">
                Simpan Kata Sandi
            </button>
        </form>

        <div class="text-center">
            <p style="font-size: 12px; color: white;"><strong>Masih belum punya akun?</strong> <a href="{{ route('register') }}" style="color: white;">Register!</a></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#form_send_reset_link').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            var modalId = form.data('modal');

            $('#' + modalId).modal('hide');

            var arr_params = {
                url: form.attr('action'),
                method: 'POST',
                input: form.serialize(),
                forms: form[0],
                modal: modalId,
                reload: false,
                load_msg: 'Sending Email...'
            }

            ajaxSaveDatas(arr_params);
        });
    });
</script>
<script>
    function togglePasswordVisibility(inputId, iconId) {
    var passwordField = document.getElementById(inputId);
    var icon = document.getElementById(iconId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        passwordField.type = "password";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
}

</script>
@endsection
