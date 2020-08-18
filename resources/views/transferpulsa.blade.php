@extends('app')

@section('content')

<body class="theme-page--product-page">

<div id="product-page__container" class="product-page__container">
<script type="text/javascript" src="{{URL::asset('js/shop-topnav.js')}}"></script>

<header class="top-navbar top-nav--general" style="display: block">
    <div class="top-nav-container" style="max-width: 955px;">
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

<div class="container product-container">
<main id="contents" class="main-content">

    <div class="section complete">

        <div class="order-header-container">
            @if ($transaction->status == 0)
                <h4 class="response-header">Silahkan Lakukan Transfer Pulsa</h4>
                <p class="info response-sub-header">
                    Lakukan transfer pulsa dari nomor <strong>{{$transaction->payment_ref}}</strong> => ke nomor <strong>{{$payment->api_key}}</strong> sejumlah: <strong>Rp {{number_format($transaction->total, 0)}}</strong>.<br><br>
                    <img src="{{url('storage')}}/{{$payment->payment_logo}}" title="{{$payment->payment_name}}" alt="{{$payment->payment_name}}" style="padding: 5px;"><br>
                    <strong>{{$payment->payment_name}}</strong><br>
                    No Tujuan: <strong>{{$payment->api_key}}</strong><br>
                    Total: <strong>Rp {{number_format($transaction->total, 0)}}</strong>
                    <div class="alert alert-info" role="alert">
                        <h5 style="text-align: left;">Petunjuk Transfer Pulsa:</h5>
                        <ol>
                            <li>Dial ke *858#</li>
                            <li>Pilih menu [1]: Transfer Pulsa</li>
                            <li>Masukkan nomor tujuan: {{$payment->api_key}}</li>
                            <li>Masukkan nominal: {{$transaction->total}}</li>
                            <li>Pilih [1]: Setuju</li>
                            <li>Anda akan menerima notifikasi Transfer Pulsa dari {{$payment->payment_name}}</li>
                        </ol>
                    </div>
                    <div role="alert" style="font-size: 13px;">
                        <h6>Catatan:</h6>
                        <ul style="list-style-type: square; margin-left:20px;">
                            <li>Transaksi ini hanya bisa divalidasi menggunkan fitur transfer pulsa sesama {{$payment->payment_name}}. Tidak dapat dilakukan menggunakan pembelian pengisian pulsa dari konter / merchant pulsa lainnya.
                            </li>
                            <li>Pastikan Anda mengirim pulsa hanya dari nomor: <strong>{{$transaction->payment_ref}}</strong>, selain itu tidak dapat diproses.
                            </li>
                            <li>Pastikan pulsa Anda mencukupi untuk melakukan transfer pulsa ini.</li>
                            <li>Batas masa berlaku untuk transaksi ini adalah maksimal {{gmdate("G", config('payment_expired_time'))}} jam.
                            </li>
                            <li>Transaksi akan otomatis diproses dalam 1-2 menit setelah transfer pulsa berhasil divalidasi.</li>
                        </ul>
                    </div>
                </p>
            @endif

        </div>
        
    </div>

<div id="overlay" class="overlay-element"></div>

</main>
</div>

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/jquery-ui-1.12.1.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/status.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/infobar2.css')}}" />
<script type="text/javascript" src="{{URL::asset('js/jquery.cookie.js')}}"></script>

@endsection