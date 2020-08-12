@extends('app')

@section('content')

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
			{{ Auth::user()->userid }} | <a href="{{url('profile')}}">Profile</a> | <a href="{{url('logout')}}">Logout</a>
		@endguest
	</div>
</div>
</div>
</header>

<div class="coda-about__short-description" style="color: #111;font-size: 15px;padding: 10px;max-width: 755px;background: #fff;margin-top: 2%; margin-bottom: 2%; border-radius: 6px;">
	<img src="{{url('storage')}}/{{$news->thumbNews}}" alt="{{$news->titleNews}}" title="{{$news->titleNews}}" class="promo-banner-image flickity-lazyloaded">
	<h3>{{$news->titleNews}}</h3>	
	{!!$news->contentNews!!}
</div>

<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />

@endsection