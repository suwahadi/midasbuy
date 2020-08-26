@extends('app')

@section('content')

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

<div class="coda-about__short-description" style="color: #111; font-size: 15px;padding: 10px;max-width: 755px; min-height: 400px; background: #fff;margin-top: 5%; margin-bottom: 5%;">

<h3>Edit Profile</h3>
<hr>

<form name="FomEditProfie" action="{{url('profile')}}" method="POST" onsubmit="return checkForm(this);">

{{ csrf_field() }}

<div class="form-input-container">
    @auth
        <input type="hidden" id="id" name="id" class="product-form-input" value="{{ Auth::user()->id }}">
    @endauth
</div>

<div class="form-group">
    <label for="label">ID Member:</label>
    <input type="text" class="form-control" id="userid" name="userid" value="{{ Auth::user()->userid }}" readonly disabled>
</div>

<div class="form-group">
    <label for="label">Nama:</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
</div>

<div class="form-group">
    <label for="label">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
</div>

<div class="form-group">
    <label for="label">HP:</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}" required>
</div>

@if (Auth::user()->type == 1)
<div class="form-group">
    <label for="label">API Key:</label>
    <input type="text" class="form-control" id="api" name="api" value="{{ Auth::user()->api_token }}" readonly disabled>
</div>
@endif

<div class="form-group">
    <label for="label">Password:</label>
    <input type="password" class="form-control" id="password" name="password" value="{{ Auth::user()->password }}">
    <small id="help" class="form-text text-muted">(Biarkan kolom ini jika tidak ingin merubah password)</small>
</div>

<div class="email-form-btn-group">
    <input type="submit" id="submit" name="submit" class="btn btn-success btn-lg" value="Update Profile">
    <a href="{{url('profile')}}" role="button" aria-pressed="true" class="btn btn-secondary btn-lg">< Kembali</a>
</div>

</form>

<script>
function checkForm(FomEditProfie)
{
    FomEditProfie.submit.disabled = true;
    FomEditProfie.submit.value = "Please Wait...";
    return true;
}
</script>

</div>

<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />
{{-- <link rel="stylesheet" type="text/css" href="{{URL::asset('css/product.css')}}" /> --}}

@endsection