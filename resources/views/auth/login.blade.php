@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')
<<<<<<< HEAD
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
                <a href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title mb-0">Masuk.</h1>
            <p class="auth-subtitle mb-4 mt-0">Masuk menggunakan akun yang telah terdaftar</p>
=======
<div class="d-flex align-items-center justify-content-center" style="height: 100vh; background-image: url('{{ asset('/images/bglogin.png') }}'); background-size: cover; background-position: center;">
    <div class="card p-4" style="width: 500px; background-color: transparent;">
        <h1 class="text-center text-white" style="font-size: 28px; margin-bottom:20px; font-weight: bold; font-family: 'Libre Baskerville', serif;">Login</h1>
        <p class="text-center text-white" style="font-size: 16px; margin-bottom:40px;  font-family: 'Libre Baskerville', serif;">LoginPlease enter your Login and your Password</p>
>>>>>>> 87025d4... FE Login, Register, Landing Page

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close text-light" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group position-relative has-icon-left mb-3">
                <input type="email" name="email" class="form-control" placeholder="Username or Email" style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                <div class="form-control-icon" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                    <i class="bi bi-person" style="font-size: 16px; color: #fff;"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" style="padding-left: 40px; border-radius: 16px;  background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                <div class="form-control-icon" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                    <i class="bi bi-shield-lock" style="font-size: 16px; color: #fff;"></i>
                </div>
<<<<<<< HEAD
                <button class="btn btn-primary btn-block shadow-lg mt-4">Masuk</button>
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <a href="{{ route('auth.google') }}" class="shadow-lg">
                        <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" alt="Sign in with Google">
                    </a>
                </div>                
            </form>
            <div class="text-center mt-3 text-lg">
                <p>Belum punya akun? <a href="{{ route('register') }}" class="fw-bold">Daftar</a>.</p>
                <p><a class="font-bold" href="#forgot-password" data-bs-toggle="modal"
                        data-bs-target="#forgotPasswordModal">Lupa Kata Sandi?</a>.</p>
=======
>>>>>>> 87025d4... FE Login, Register, Landing Page
            </div>
            <div class="d-flex justify-content-end mb-3">
                <a  href="{{ 'password.request' }}" data-bs-toggle="modal"
                        data-bs-target="#forgotPasswordModal" style="font-size: 12px; color: #ffffff;">Lupa Kata Sandi?</a>
      </div>
            <button class="btn w-100 mb-3 "
            style="background-color: #052D6E; border: 2px solid #1E90FF; color: white; font-weight: semibold; font-family: 'Libre Baskerville', serif; border-radius: 16px; transition: background-color 0.3s;"
            onmouseover="this.style.backgroundColor='#1E90FF'"
            onmouseout="this.style.backgroundColor='#052D6E'">
      Login
    </button>



    <div class="text-center mb-3">
        <a href="{{ route('auth.google') }}"
        class="btn btn-outline-light w-100"
        style="background-color: #1A1B22; border: none; padding: 10px 0; display: flex; align-items: center; justify-content: center; color: #fff; border-radius: 16px;"
        onmouseover="this.style.backgroundColor='#1E90FFFF'; this.style.color='#fff';"
        onmouseout="this.style.backgroundColor='#1A1B22'; this.style.color='#fff';">
            <img src="images/google.png" alt="Sign in with Google" style="height: 20px; margin-right: 10px;">
            <p style="font-size: 10px; color: #ffffff; font-weight: bold; margin: 0;">Or, sign-in with Google</p>
        </a>
    </div>

        </form>
        <div class="text-center">
            <p style="font-size: 12px; color: white;"><strong> Masih belum punya akun?</strong> <a href="{{ route('register') }}"  style="color: white;">Register!</a></p>
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
@endsection
