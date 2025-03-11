@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-center"
        style="height: 100vh; position: relative; background-image: url('{{ asset('/images/bglogin.png') }}'); background-size: cover; background-position: center;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: #052D6E; z-index: -1;"></div>
        <div class="card p-4" style="width: 500px; background-color: transparent;">
            <h1 class="text-center text-white"
                style="font-size: 28px; margin-bottom:20px; font-weight: bold; font-family: 'Libre Baskerville', serif;">
                Login</h1>
            <p class="text-center text-white"
                style="font-size: 16px; margin-bottom:40px;  font-family: 'Libre Baskerville', serif;">Please enter your
                Email and Password</p>

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
                    <input type="email" name="email" class="form-control" placeholder="Username or Email"
                        style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                    <div class="form-control-icon"
                        style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                        <i class="bi bi-person" style="font-size: 16px; color: #fff;"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                        style="padding-left: 40px; border-radius: 16px;  background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                    <div class="form-control-icon"
                        style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                        <i class="bi bi-shield-lock" style="font-size: 16px; color: #fff;"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ 'password.request' }}" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal"
                        style="font-size: 12px; color: #ffffff;">Forgot Password?</a>
                </div>
                <button class="btn w-100 mb-3 "
                    style="background-color: #052D6E; border: 2px solid #1E90FF; color: white; font-weight: semibold; font-family: 'Libre Baskerville', serif; border-radius: 16px; transition: background-color 0.3s;"
                    onmouseover="this.style.backgroundColor='#1E90FF'" onmouseout="this.style.backgroundColor='#052D6E'">
                    Login
                </button>

                <div class="text-center mb-3">
                    <a href="{{ route('auth.google') }}" class="btn btn-outline-light w-100"
                        style="background-color: #1A1B22; border: none; padding: 10px 0; display: flex; align-items: center; justify-content: center; color: #fff; border-radius: 16px;"
                        onmouseover="this.style.backgroundColor='#1E90FFFF'; this.style.color='#fff';"
                        onmouseout="this.style.backgroundColor='#1A1B22'; this.style.color='#fff';">
                        <img src="images/google.png" alt="Sign in with Google" style="height: 20px; margin-right: 10px;">
                        <p style="font-size: 10px; color: #ffffff; font-weight: bold; margin: 0;">Or, sign-in with Google
                        </p>
                    </a>
                </div>

            </form>
            <div class="text-center">
                <p style="font-size: 12px; color: white;"><strong> Doesn't have account yet?</strong> <a
                        href="{{ route('register') }}" style="color: white;">Register Now!</a></p>
            </div>
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
