@extends('layouts.auth')

@section('title')
    Register
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-center"
        style="height: 100vh; background-image: url('{{ asset('/images/bglogin.png') }}'); background-size: cover; background-position: center;">
        <div class="card p-4" style="width: 500px; background-color: transparent;">
            <h1 class="text-center text-white"
                style="font-size: 28px; margin-bottom:20px; font-weight: bold; font-family: 'Libre Baskerville', serif;">
                Register</h1>
            <p class="text-center text-white"
                style="font-size: 16px; margin-bottom:40px; font-family: 'Libre Baskerville', serif;">Enter your details to
                register on our website</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name"
                        style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                    <div class="form-control-icon"
                        style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                        <i class="bi bi-person" style="font-size: 16px; color: #fff;"></i>
                    </div>
                </div>

                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email"
                        style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                    <div class="form-control-icon"
                        style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                        <i class="bi bi-envelope" style="font-size: 16px; color: #fff;"></i>
                    </div>
                </div>

                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                        style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                    <div class="form-control-icon"
                        style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                        <i class="bi bi-shield-lock" style="font-size: 16px; color: #fff;"></i>
                    </div>
                </div>

                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="Confirm Password"
                        style="padding-left: 40px; border-radius: 16px; background-color: #052D6E; border: 1px solid #fff; color: #fff;">
                    <div class="form-control-icon"
                        style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">
                        <i class="bi bi-shield-lock" style="font-size: 16px; color: #fff;"></i>
                    </div>
                </div>

                <button class="btn w-100 mb-3"
                    style="background-color: #052D6E; border: 2px solid #1E90FF; color: white; font-weight: semibold; font-family: 'Libre Baskerville', serif; border-radius: 16px; transition: background-color 0.3s;"
                    onmouseover="this.style.backgroundColor='#1E90FF'" onmouseout="this.style.backgroundColor='#052D6E'">
                    Register
                </button>

                <div class="text-center mb-3">
                    <a href="{{ route('auth.google') }}" class="btn btn-outline-light w-100"
                        style="background-color: #1A1B22; border: none; padding: 10px 0; display: flex; align-items: center; justify-content: center; color: #fff; border-radius: 16px;"
                        onmouseover="this.style.backgroundColor='#1E90FF'; this.style.color='#fff';"
                        onmouseout="this.style.backgroundColor='#1A1B22'; this.style.color='#fff';">
                        <img src="images/google.png" alt="Sign in with Google" style="height: 20px; margin-right: 10px;">
                        <p style="font-size: 10px; color: #ffffff; font-weight: bold; margin: 0;">Or, Register with Google
                        </p>
                    </a>
                </div>
            </form>

            <div class="text-center">
                <p style="font-size: 12px; color: white;"><strong> Already have an account?</strong> <a
                        href="{{ route('login') }}" style="color: white;">Login!</a></p>
            </div>
        </div>
    </div>
@endsection
