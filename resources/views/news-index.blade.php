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

<div class="coda-about__short-description" style="color: #fff;font-size: 15px;padding: 10px;max-width: 755px;background:#f8f8f8;margin-top: 2%;">

	<div class="news__card-row">
		@foreach ( $newss as $news )
	<div class="news__card-cell">
		
		<a class="news_card_link" href="{{url('news')}}/{{$news->slugNews}}">
			<div class="news__card-banner-frame">
				<img class="news__card-banner lozad"  src="{{url('storage')}}/{{$news->thumbNews}}" data-loaded="true">
				<div class="new__card-content-block">
					<div class="news__card-content-title">{{$news->titleNews}}</div>
				</div>
			</div>	
		</a>
		
	</div>
	@endforeach
	</div>

</div>

<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />

<style>
	@media screen and (min-width: 600px) {
	.news__card-cell {
		width: 49%;
		vertical-align: middle;
		padding: 10px;
		margin-bottom: 5px;
	}
	}
</style>

@endsection