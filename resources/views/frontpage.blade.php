@extends('app')

@section('content')

<header class="top-navbar top-nav--general">
    <div class="top-nav-container">
        
        <div class="logo-container">
            
		<a href="{{url('/')}}" class="logo-container-link">
			<img class="logo-image theme-default__logo" src="{{config('logo')}}" alt="{{config('webname')}}" title="{{config('webname')}}"/>
		</a>
            
        {{-- <p class="slogan-element">{{config('slogan')}}</p> --}}

        </div>
		<div class="search-icon-container" style="float: right;">
            @guest
            <a href="{{url('login')}}" style="text-decoration: none; color: #fff; font-size:12px;">LOGIN</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{url('register')}}" style="text-decoration: none; color: #fff; font-size:12px;">REGISTER</a>
            @else
                <a style="text-decoration: none; color: #fff; font-size:12px;" href="{{url('profile')}}">{{ Auth::user()->userid }}</a> | <a style="text-decoration: none; color: #fff; font-size:12px;" href="{{url('logout')}}">Logout</a>
            @endguest
        </div>
    </div>
</header>

<body class="theme-page--landing-page">

	@if(Session::has('alert-success'))
		<div class="alert alert-success">
			<strong>{{ \Illuminate\Support\Facades\Session::get('alert-success') }}</strong>
		</div>
	@endif
	
    <input type="hidden" id="data_landing_page" value='{
	"promoBannerSection": {
		"cycleTime": 5000,
		"images": {{$banner_top}}
	},
	"categorySection-1": {
		"name": "Game Populer",
		"shortDescription": "",
		"products": {{$products}}
	}

	{{-- "categorySection-2": {
		"name": "Sedang Promo",
		"shortDescription": "",
		"products": {{$promo}}
	}, --}}

	{{-- "aboutSection": {
		"title": "{{config('webname')}}: {{config('slogan')}}",
		"subTitle": "{{config('about')}}",
		"content": [{
				"imageUrl": "images/icon1.png",
				"altText": "Quick icon",
				"title": "Bayar dalam hitungan detik",
				"subTitle": "Hanya dibutuhkan beberapa detik saja untuk menyelesaikan pembayaran di {{config('webname')}} karena situs kami berfungsi dengan baik dan mudah untuk digunakan."
			},
			{
				"imageUrl": "images/icon2.png",
				"altText": "Delivery icon",
				"title": "Pengiriman instan",
				"subTitle": "Ketika kamu melakukan top-up di {{config('webname')}}, item atau barang yang kamu beli akan selalu dikirim ke akun kamu secara instan dan cepat, tanpa tertunda."
			},
			{
				"imageUrl": "images/icon3.png",
				"altText": "Payments icon",
				"title": "Metode pembayaran terbaik",
				"subTitle": "Kami menawarkan begitu banyak pilihan pembayaran mulai dari potong pulsa, e-wallet, bank transfer, dan pembayaran di mini market terdekat."
			},
			{
				"imageUrl": "images/icon4.png",
				"altText": "24h support",
				"title": "Bantuan 24 jam",
				"subTitle": "Tim kami selalu tersedia selama 24 jam selama 7 hari penuh dalam seminggu untuk menjawab pertanyaan-pertanyaan dari kamu :)"
			}
		]
	}, --}}
	{{-- "newsBannerSection": {
		"title": "Latest News & Promotions",
		"content": {{$news}}
	} --}}

}'>

<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />
<script type="text/javascript" src="{{URL::asset('js/frontpage.js')}}"></script>

@endsection