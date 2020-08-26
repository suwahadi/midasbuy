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
        <a href="{{url('login')}}" style="text-decoration: none; font-weight: 600; color: #111; font-size:12px;">LOGIN</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{url('register')}}" style="text-decoration: none; color: #111; font-weight: 600; font-size:12px;">REGISTER</a>
        @else
            <a style="text-decoration: none; color: #111; font-weight: 600; font-size:12px;" href="{{url('profile')}}">{{ Auth::user()->userid }}</a> | <a style="text-decoration: none; font-weight: 600; color: #111; font-size:12px;" href="{{url('logout')}}">LOGOUT</a>
        @endguest
    </div>
</div>
</div>
</header>

<div class="coda-about__short-description" style="color: #222;font-size: 15px;padding: 30px;max-width:350px; background: #f8f8f8; margin-top: 12%; margin-bottom: 12%; border-radius: 0;">

<div class="form" id="formSection">

<h4 style="text-align: center">Login Akun</h4>
<br>
@if(Session::has('error'))
<div class="alert alert-danger" role="alert">
    <strong>{{ \Illuminate\Support\Facades\Session::get('error') }}</strong>
</div>
@endif

@error('email')
<div class="alert alert-danger" role="alert">
    <strong>{{ $message }}</strong>
</div>
@enderror

<form id="FormLogin" name="FormLogin" method="POST" action="{{ route('login') }}" onsubmit="return checkForm(this);">

    @csrf
    
    <div class="form-group">
        <input style="border-radius: 0; height: 45px;" type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required autocomplete="email" autofocus placeholder="Email">
    </div>

    <div class="form-group">
        <input style="border-radius: 0; height: 45px;" type="password" class="form-control @error('password') is-invalid @enderror" id="email" name="password" required autocomplete="password" placeholder="Password">
    </div>

    @if (Route::has('password.request'))
        {{-- <a class="btn btn-link" style="float: right" href="{{ route('password.request') }}">
            Lupa Password?<br><br>
        </a> --}}
    @endif

    <div class="form-group">
        <input type="submit" id="submit" name="submit" class="btn btn-dark btn-lg btn-block" value="Login">
    </div>

    <div class="form-input-container" style="text-align: center; padding: 20px">
        Belum Punya Akun? <a href="{{ route('register') }}" style="color: #222; text-decoration: underline">Daftar Sekarang</a>
    </div>

</form>

</div>

</div>

<script>
function checkForm(FormLogin)
{
    FormLogin.submit.disabled = true;
    FormLogin.submit.value = "Please Wait...";
    return true;
}
</script>

<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />

@endsection