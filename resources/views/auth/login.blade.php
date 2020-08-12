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
	<p class="slogan-element">{{config('slogan')}}</p>
</div>
<div class="search-container">
    <div class="search-icon-container" style="float: right;">
        @guest
        <a href="{{url('login')}}" style = "text-decoration: none; color: #222; font-size:14px;">LOGIN</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{url('register')}}" style="text-decoration: none; color: #222; font-size:14px;">REGISTER</a>
        @else
            Halo {{ Auth::user()->name }}
        @endguest
    </div>
</div>
</div>
</header>

<div class="coda-about__short-description" style="color: #111;font-size: 15px;padding: 20px;max-width:500px;background: #fff; margin-top: 20%; margin-bottom: 20%; border-radius: 6px;">

<div class="form" id="formSection">

<h4 style="text-align: center">Login Akun {{config('webname')}}</h4>

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
        <label for="label">Email:</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required autocomplete="email" autofocus placeholder="Email">
    </div>

    <div class="form-group">
        <label for="label">Password:</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="email" name="password" required autocomplete="password" placeholder="Password">
    </div>

    @if (Route::has('password.request'))
        {{-- <a class="btn btn-link" style="float: right" href="{{ route('password.request') }}">
            Lupa Password?<br><br>
        </a> --}}
    @endif

    <div class="form-group">
        <input type="submit" id="submit" name="submit" class="btn btn-dark btn-lg btn-block" value="Login" style="background: rgba(20,27,61,1);">
    </div>

    <div class="form-input-container" style="text-align: center; padding: 20px">
        Belum Punya Akun? <a href="{{ route('register') }}" style="text-decoration: underline">Daftar Sekarang</a>
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