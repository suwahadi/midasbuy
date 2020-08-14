@extends('app')

@section('content')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<body class="theme-page--landing-page">

<header class="top-navbar top-nav--general">
<div class="top-nav-container">
<div class="logo-container">
	<a href="{{url('/')}}" class="logo-container-link">
		<img class="logo-image theme-default__logo" src="{{config('logo')}}" alt="{{config('webname')}}" title="{{config('webname')}}"/>
	</a>
	{{-- <p class="slogan-element">{{config('slogan')}}</p> --}}
</div>
<div class="search-container">
    <div class="search-icon-container" style="float: right;">
        @guest
        <a href="{{url('login')}}" style="text-decoration: none; color: #fff; font-size:12px;">LOGIN</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{url('register')}}" style="text-decoration: none; color: #fff; font-size:12px;">REGISTER</a>
        @else
            <a style="text-decoration: none; color: #fff; font-size:12px;" href="{{url('profile')}}">{{ Auth::user()->userid }}</a> | <a style="text-decoration: none; color: #fff; font-size:12px;" href="{{url('logout')}}">Logout</a>
        @endguest
    </div>
</div>
</div>
</header>

<div class="coda-about__short-description" style="color: #fff;font-size: 15px;padding: 30px;max-width:350px; background: #111733; margin-top: 12%; margin-bottom: 12%; border-radius: 0;">

<div class="form" id="formSection">

<h4 style="text-align: center">Pendaftaran Akun</h4>
<br>
@if($errors->any())
<div class="alert alert-danger" role="alert">
    <strong>Terjadi kesalahan. Silahkan diulang...</strong>
</div>
@endif

<form id="FormRegister" name="FormRegister" method="POST" action="{{ route('register') }}" onsubmit="return checkForm(this);">

    @csrf

    <div class="form-group">
        <input style="border-radius: 0; height: 45px;" id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap Anda">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </div>

    <div class="form-group">
        <input style="border-radius: 0; height: 45px;" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Alamat Email (Harus Valid)">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </div>

    <div class="form-group">
        <input style="border-radius: 0; height: 45px;" id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus placeholder="Nomor HP (Harus Valid)" pattern="(08)\d{7,12}" title="Nomor HP harus valid, tanpa tanda hubung / tanpa spasi (Contoh: 081234567890)">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </div>

    <div class="form-group">
        <input style="border-radius: 0; height: 45px;" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </div>

    <div class="form-group">
        <input style="border-radius: 0; height: 45px;" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi Password">
    </div>

    <div class="form-group">
        <input style="background: #3a7bfc; border-radius: 0;" type="submit" id="submit" name="submit" class="btn btn-dark btn-lg btn-block" value="Daftar" style="background: rgba(20,27,61,1);">
    </div>

    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
        <path fill-rule="evenodd" d="M1.5 13A1.5 1.5 0 0 0 3 14.5h10a1.5 1.5 0 0 0 1.5-1.5V8a.5.5 0 0 0-1 0v5a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 0 0-1H3A1.5 1.5 0 0 0 1.5 3v10z"/>
      </svg> <span style="font-size: 12px;">Dengan mendaftarkan akun, berarti Anda sudah mengerti & setuju dengan <a style="color: #fff; text-decoration: underline" href="{{url('terms-conditions')}}">Syarat & Ketentuan</span>.</a>

    <div class="form-group" style="text-align: center; padding: 20px">
        Sudah Punya Akun? <a href="{{ route('login') }}" style="color: #fff; text-decoration: underline">Login Disini</a>
    </div>

</form>
</div>

</div>

<script>
function checkForm(FormRegister)
{
    FormRegister.submit.disabled = true;
    FormRegister.submit.value = "Please Wait...";
    return true;
}
</script>

<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />

@endsection