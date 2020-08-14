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

<main id="contents" class="content" style="margin-top: 3%; margin-bottom: 3%; width: 100%; padding: 20px; background: #111733">

    <div style="color: #fff;">

        <div class="order-header-container">
            <h3 class="response-header">Topup Saldo #{{$datas->id}}</h3>
            <br>
        </div>

        <div class="order-detail-container">

        <div class="deposit" id="deposit">
            <div class="body">
                <p>
                    ID Topup: <span style="font-weight: 600;">#{{$datas->id}}</span><br>
                    Tanggal: <span style="font-weight: 600;">{{$datas->created_at}}</span>
                </p>
                
                <p>
                    Metode Pembayaran:<br>
                    <img src="{{url('storage')}}/{{$payment->payment_logo}}" title="{{$payment->payment_name}}" alt="{{$payment->payment_name}}" style="padding:5px 0 5px 0;"><br>
                    <span style="font-weight: 600;">{{$payment->payment_name}}</span>
                </p>
    
                <p>
                    Status:<br>
                    <span style="font-weight: 600;">
                        @if ($datas->status == 0)
                            <span class="badge badge-warning" style="padding:5px;">Waiting Payment</span>
                        @elseif ($datas->status == 1)
                            <span class="badge badge-success" style="padding:5px;">Success</span>
                        @elseif ($datas->status == 2)
                            <span class="badge badge-secondary" style="padding:5px;">Expired</span>
                        @endif
                    </span>
                </p>
            
                <p>
                    Nominal Topup:<br>
                    <span style="font-weight: 500;">Rp {{number_format($datas->total, 0)}}</span>
                    @if ($payment->mark_up_price != '0')
                     (+Biaya Administrasi: <span style="font-weight: 500;">Rp {{number_format($payment->mark_up_price, 0)}}</span>)
                    @endif
                </p>

                <p>
                    Total Pembayaran:<br>
                    <span style="font-weight: 600;">Rp {{number_format($datas->total+$payment->mark_up_price, 0)}}</span>
                </p>

                @if ($datas->status == 0)
                <span style="text-align: center; font-weight: 600;">Petunjuk Pembayaran:</span>
                <p>
                    @if ($datas->payment_channel == 5 OR $datas->payment_channel == 6 OR $datas->payment_channel == 7 OR $datas->payment_channel == 9 OR $datas->payment_channel == 10 OR $datas->payment_channel == 11)
                        <div class="alert alert-light" role="alert">
                        Silahkan selesaikan pembayaran Anda dengan klik: 'Lakukan Pembayaran' pada tombol dibawah ini. Petunjuk pembayaran via {{$payment->payment_name}} akan muncul pada halaman selanjutnya.<br><br>
                        <a href="https://payment.tripay.co.id/checkout/{{$datas->payment_ref}}" style="text-decoration: none;"><input type="button" class="btn btn-info btn-lg btn-block" style="cursor: pointer; margin: 0; float: none;" value="Lakukan Pembayaran"></a>
                        <div>
                    @else
                        <div class="alert alert-light" role="alert">
                        Silahkan lakukan transfer / pembayaran via {{$payment->payment_name}} tepat sejumlah: <span style="font-weight: 600;">Rp {{number_format($datas->total, 0)}}</span> (jangan dibulatkan) ke:<br><br>
                        <strong>{{$payment->payment_name}}</strong><br>
                        No Rekening / No Tujuan: <strong>{{$payment->api_key}}</strong><br>
                        a/n: <strong>{{$payment->api_user}}</strong><br>
                        Nominal: <strong>Rp {{number_format($datas->total, 0)}}</strong><br><br>
                        Tidak perlu konfirmasi pembayaran. Topup Anda akan otomatis masuk dalam 3-5 menit setelah pembayaran sukses divalidasi.
                        <div>
                    @endif
                </p>
                @elseif ($datas->status == 2)
                    <div class="alert alert-danger" role="alert">
                        Pembayaran untuk Topup Saldo ini sudah tidak berlaku (expired). Silahkan lakukan request Topup Saldo ulang.
                    </div>
                @endif

            </div>
        </div>

        <div class="email-form-btn-group">
            <a href="{{url('deposit')}}" role="button" aria-pressed="true" class="btn btn-primary btn-lg">< Kembali</a>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

        </div>
        
    </div>

<div id="overlay" class="overlay-element"></div>

</main>

</div>

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/jquery-ui-1.12.1.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/product-page.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/infobar2.css')}}" />
<script type="text/javascript" src="{{URL::asset('js/jquery.cookie.js')}}"></script>

@endsection