@extends('app')

@section('content')

<body class="theme-page--product-page">

<div id="product-page__container" class="product-page__container">

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/topnav.css')}}" />

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

<section class="product-details-container">
    <div class="product__name">
        Terima kasih atas pesanan Anda
    </div>
    <input type="checkbox" id="product-description" name="product-description" class="product-description-checkbox">
    <label for="product-description">
        <span class="more-info">Baca lebih lanjut</span>
        <span class="less-info">Tutup informasi detail</span>
    </label>
    <div class="product__description">
        Setiap bulannya, jutaan gamers menggunakan {{config('webname')}} untuk melakukan pembelian kredit game dengan lancar: tanpa registrasi ataupun log-in, dan kredit permainan akan ditambahkan secara instan. Top-up Mobile Legends, Free Fire, Ragnarok M, dan berbagai game lainnya!
        <br><br>
        Bingung cara menggunakan Redeem Code? <a style="color:#fff; text-decoration: underline;" href="{{url('faq')}}">Klik disini</a>.
        <br>
</section>

<main id="contents" class="main-content">

@if(Session::has('errorNomor'))
<div class="popError" id="popError">
    <div class="section">
        <h2 class="errorHeader">Error input nomor!</h2>
        <div class="container">
            <div class="row">
            <div class="col-sm-12" style="padding:20px;">
                {{ \Illuminate\Support\Facades\Session::get('errorNomor') }}
            </div>
            <div class="col-sm-9" style="padding:3px;">
            </div>
            <div class="col-sm-3" style="padding:10px;">
                <a style="color:#fff" class="btn btn-dark btn-lg btn-block" id="myBtn" style="cursor: pointer;">Ulangi</a>
            </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.popError>.section {
    max-width: 450px;
    width: 80%;
    margin: auto;
    display: block;
    position: fixed;
    left: 50%;
    top: 35% !important;
    transform: translate(-50%,-50%);
    border-radius: 6px;
    padding: 0;
    z-index: 20;
    overflow: hidden;
    box-shadow: none;
    border: 1px solid #ddd;
}
.errorHeader {
    margin: 0;
    padding: 10px 15px;
    background: #FF6C2C !important;
    color: #fff;
    font-size: 18px;
}
</style>

<script>
    $(document).ready(function(){
        $("#myBtn").click(function(){
        $("#popError").hide();
        });
    });
</script>

    <div class="section complete">

        <div class="order-header-container">
            @if ($transaction->status == 0)
                <h1 class="response-header">Selesaikan Pembayaran Anda</h1>
                @if ($transaction->payment_channel_id == 1)
                <p class="info response-sub-header">
                    Silahkan lakukan pembayaran tepat sejumlah: <strong>Rp {{number_format($transaction->total, 0)}}</strong> ke:<br><br>
                    <img src="{{url('storage')}}/{{$payment->payment_logo}}" title="{{$payment->payment_name}}" alt="{{$payment->payment_name}}" style="padding: 5px;"><br>
                    <strong>{{$payment->payment_name}}</strong><br>
                    No Tujuan: <strong>{{$payment->api_key}}</strong><br>
                    a/n: <strong>{{$payment->api_user}}</strong><br>
                    Total: <strong>Rp {{number_format($transaction->total, 0)}}</strong>
                    <div class="alert alert-warning" role="alert">
                        Silahkan lakukan pembayaran via {{$payment->payment_name}} tepat sejumlah: <strong>Rp {{number_format($transaction->total, 0)}}</strong> (harus sama persis). Jangan dibulatkan. Pembayaran akan divalidasi otomatis dalam 1-2 menit setelah pembayaran.
                    </div>
                    Setelah pembayaran Anda berhasil terkonfirmasi, notifikasi akan dikirimkan ke email: 
                    <span style="font-weight:600;">{{$transaction->email}}</span> dan SMS ke: <span style="font-weight:600;">{{$transaction->phone}}</span> secepatnya.<br><br>
                    Apabila Anda mempunyai pertanyaan, silahkan hubungi layanan pelanggan kami di WhatsApp: {{config('whatsapp')}}.
                </p>
                @elseif ($transaction->payment_channel_id == 2)
                <p class="info response-sub-header">
                    Silahkan lakukan pembayaran tepat sejumlah: <strong>Rp {{number_format($transaction->total, 0)}}</strong> ke:<br><br>
                    <img src="{{url('storage')}}/{{$payment->payment_logo}}" title="{{$payment->payment_name}}" alt="{{$payment->payment_name}}" style="padding: 5px;"><br>
                    <strong>{{$payment->payment_name}}</strong><br>
                    No Tujuan: <strong>{{$payment->api_key}}</strong><br>
                    a/n: <strong>{{$payment->api_user}}</strong><br>
                    Total: <strong>Rp {{number_format($transaction->total, 0)}}</strong>
                    <div class="alert alert-warning" role="alert">
                        Silahkan lakukan pembayaran via {{$payment->payment_name}} tepat sejumlah: <strong>Rp {{number_format($transaction->total, 0)}}</strong> (harus sama persis). Jangan dibulatkan. Pembayaran akan divalidasi otomatis dalam 1-2 menit setelah pembayaran.
                    </div>
                    Setelah pembayaran Anda berhasil terkonfirmasi, notifikasi akan dikirimkan ke email: 
                    <span style="font-weight:600;">{{$transaction->email}}</span> dan SMS ke: <span style="font-weight:600;">{{$transaction->phone}}</span> secepatnya.<br><br>
                    Apabila Anda mempunyai pertanyaan, silahkan hubungi layanan pelanggan kami di WhatsApp: {{config('whatsapp')}}.
                </p>
                @elseif ($transaction->payment_channel_id == 8)
                <p class="info response-sub-header">
                    Silahkan lakukan pembayaran tepat sejumlah: <strong>Rp {{number_format($transaction->total, 0)}}</strong> ke:<br><br>
                    <img src="{{url('storage')}}/{{$payment->payment_logo}}" title="{{$payment->payment_name}}" alt="{{$payment->payment_name}}" style="padding: 5px;"><br>
                    <strong>{{$payment->payment_name}}</strong><br>
                    No Tujuan: <strong>{{$payment->api_key}}</strong><br>
                    a/n: <strong>{{$payment->api_user}}</strong><br>
                    Total: <strong>Rp {{number_format($transaction->total, 0)}}</strong>
                    <div class="alert alert-warning" role="alert">
                        Silahkan lakukan pembayaran via {{$payment->payment_name}} tepat sejumlah: <strong>Rp {{number_format($transaction->total, 0)}}</strong> (harus sama persis). Jangan dibulatkan. Pembayaran akan divalidasi otomatis dalam 2-5 menit setelah pembayaran.
                    </div>
                    Setelah pembayaran Anda berhasil terkonfirmasi, notifikasi akan dikirimkan ke email: 
                    <span style="font-weight:600;">{{$transaction->email}}</span> dan SMS ke: <span style="font-weight:600;">{{$transaction->phone}}</span> secepatnya.<br><br>
                    Apabila Anda mempunyai pertanyaan, silahkan hubungi layanan pelanggan kami di WhatsApp: {{config('whatsapp')}}.
                </p>
                @elseif ($transaction->payment_channel_id == 12)
                <p class="info response-sub-header">
                    Silahkan lengkapi form Transfer Pulsa {{$payment->payment_name}} berikut ini:
                    <form name="FormPulsa" action="{{route('transferpulsa')}}" method="POST" onsubmit="return checkForm(this);">
                    {{ csrf_field() }}
                    <div class="form-group" style="display: none;">
                        <label for="label">Order ID #:</label>
                        <input type="text" class="form-control" id="trx_id" name="trx_id" value="{{$transaction->trx_id}}" readonly>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label for="label">Total (Rp):</label>
                        <input type="text" class="form-control" id="total" name="total" value="{{$transaction->total}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="label">Masukkan Nomor {{$payment->payment_name}} Pengirim Pulsa:</label>
                        <input type="text" class="form-control" id="phone" name="phone" pattern="(62811|62812|62813|62821|62822|62823|62851|62852|62853)\d{7,12}" title="Nomor awalan harus 62, tanpa tanda hubung / tanpa spasi (Contoh: 6281234567890)" required placeholder="62">
                        <p style="font-size:13px; line-height:1.2em; padding:3px 0 3px 0;">Pastikan nomor {{$payment->payment_name}} yang Anda masukkan sudah benar, awalan harus 62, tanpa tanda hubung / tanpa spasi (Contoh: 6281234567890)</p>
                    </div>
                    <div class="email-form-btn-group">
                        <input type="submit" id="submit" name="submit" class="btn btn-info btn-lg btn-block" style="cursor: pointer; margin: 0; float: none;" value="Proses Transfer Pulsa >">
                    </div>
                    </form>
                    <script>
                        function checkForm(FormPulsa)
                        {
                            FormPulsa.submit.disabled = true;
                            FormPulsa.submit.value = "Please Wait...";
                            return true;
                        }
                    </script>
                </p>
                @else
                <p class="info response-sub-header">
                    Silahkan selesaikan pembayaran Anda dengan klik: 'Lakukan Pembayaran' pada tombol dibawah ini.<br><br>
                    Setelah pembayaran Anda berhasil dikonfirmasi, notifikasi akan dikirimkan ke email: 
                    <span style="font-weight:600;">{{$transaction->email}}</span> dan SMS ke: <span style="font-weight:600;">{{$transaction->phone}}</span> secepatnya.<br><br>
                    Apabila Anda mempunyai pertanyaan, silahkan hubungi layanan pelanggan kami di WhatsApp: {{config('whatsapp')}}.
                </p>
                @endif
             @elseif ($transaction->status == 1)
                <h1 class="response-header"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock-history" fill="currentColor" xmlns="//www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                    <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                    <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                  </svg> Transaksi Dalam Proses...</h1>
                <p class="info response-sub-header">

                    <div class="alert alert-info" role="alert">
                        Saat ini transaksi Anda sedang dalam proses. Mohon ditunggu...
                    </div>
                    
                    Setelah proses selesai, notifikasi akan dikirimkan ke email: 
                    <span style="font-weight:600;">{{$transaction->email}}</span> dan SMS ke: <span style="font-weight:600;">{{$transaction->phone}}</span> secepatnya.<br><br>
                    Apabila Anda mempunyai pertanyaan, silahkan hubungi layanan pelanggan kami di WhatsApp: {{config('whatsapp')}}.
                </p>
            @elseif ($transaction->status == 2)
                <h1 class="response-header"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2-square" fill="currentColor" xmlns="//www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M1.5 13A1.5 1.5 0 0 0 3 14.5h10a1.5 1.5 0 0 0 1.5-1.5V8a.5.5 0 0 0-1 0v5a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 0 0-1H3A1.5 1.5 0 0 0 1.5 3v10z"/>
                  </svg> Transaksi Sudah Selesai</h1>
                <p class="info response-sub-header">

                    <div class="alert alert-info" role="alert">
                        Terima kasih. Transaksi Anda telah selesai...
                    </div>

                    Silahkan cek notifikasi yang kami kirimkan ke email: 
                    <span style="font-weight:600;">{{$transaction->email}}</span> dan SMS ke: <span style="font-weight:600;">{{$transaction->phone}}</span>.<br><br>
                    Apabila Anda mempunyai pertanyaan, silahkan hubungi layanan pelanggan kami di WhatsApp: {{config('whatsapp')}}.
                </p>
                @elseif ($transaction->status == 3)
                <h1 class="response-header">Transaksi Gagal</h1>
                <p class="info response-sub-header">
                    Mohon maaf. Transaksi Anda gagal diproses. Kemungkinan produk sedang gangguan atau layanan yang sedang padat.<br><br>
                    Apabila Anda mempunyai pertanyaan, silahkan hubungi layanan pelanggan kami di WhatsApp: {{config('whatsapp')}}.
                </p>
                @elseif ($transaction->status == 4)
                <h1 class="response-header"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle" fill="currentColor" xmlns="//www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                    <circle cx="8" cy="4.5" r="1"/>
                  </svg> Transaksi Kadaluarsa</h1>
                <p class="info response-sub-header">

                    <div class="alert alert-danger" role="alert">
                        Transaksi Anda sudah tidak berlaku, karena melewati batas waktu pembayaran yang sudah ditetapkan. Silahkan lakukan order ulang.
                    </div>

                    Apabila Anda mempunyai pertanyaan, silahkan hubungi layanan pelanggan kami di WhatsApp: {{config('whatsapp')}}.
                </p>
            @endif

        </div>

        <div class="order-detail-container">

        <p style="text-align: center;">
            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Ringkasan Pesanan <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-double-down" fill="currentColor" xmlns="//www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
              </svg></a>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <p>
                    Tanggal:<br>
                    <span style="font-weight: 600;">{{$transaction->created_at}}</span>
                </p>
    
                <p>
                    ID Transaksi:<br>
                    <span style="font-weight: 600;">#{{$transaction->trx_id}}</span>
                </p>
    
                <p>
                    Item:<br>
                    <span style="font-weight: 600;">{{$transaction->product_code}} - {{$product->name}}</span>
                </p>
                
                <p>
                    Metode Pembayaran:<br>
                    @if ($transaction->payment_channel_id == 0)
                    <span style="font-weight: 600;">Saldo Member</span>
                    @else
                        <span style="font-weight: 600;">{{$payment->payment_name}}</span>
                    @endif
                    
                </p>
    
                <p>
                    Status:<br>
                    <span style="font-weight: 600;">
                        @if ($transaction->status == 0)
                            Waiting
                        @elseif ($transaction->status == 1)
                            Process
                        @elseif ($transaction->status == 2)
                            Success
                        @elseif ($transaction->status == 3)
                            Failed
                        @elseif ($transaction->status == 4)
                            Expired
                        @endif
                    </span>
                </p>
            
                <p>
                    Total Pembayaran:<br>
                    <span style="font-weight: 600;">Rp {{number_format($transaction->total, 0)}}</span>
                </p>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

        {{-- <h2 class="order-detail__headline">Ringkasan Pesanan:</h2> --}}

            @if ($transaction->status == 0)
                @if ($transaction->payment_channel_id == 5 OR $transaction->payment_channel_id == 6 OR $transaction->payment_channel_id == 7 OR $transaction->payment_channel_id == 9 OR $transaction->payment_channel_id == 10 OR $transaction->payment_channel_id == 11)
                    <a href="https://payment.tripay.co.id/checkout/{{$transaction->payment_ref}}" style="text-decoration: none;"><input type="button" class="btn btn-info btn-lg btn-block" style="cursor: pointer; margin: 0; float: none;" value="Lakukan Pembayaran"></a>
                @elseif ($transaction->payment_channel_id == 12)
                    {{-- <a href="{{$transaction->payment_ref}}" style="text-decoration: none;"><input type="button" class="btn btn-info btn-lg btn-block" style="cursor: pointer; margin: 0; float: none;" value="Proses Transfer Pulsa"></a> --}}
                @else
                    <a href="/" style="text-decoration: none;"><input type="button" id="submit" name="submit" class="btn btn-dark btn-lg btn-block" value="Order Item Lainnya" style="background: rgba(20,27,61,1);"></a>
                @endif
            @elseif ($transaction->status == 1 OR $transaction->status == 2 OR $transaction->status == 3 OR $transaction->status == 4)
                <a href="/" style="text-decoration: none;"><input type="button" id="submit" name="submit" class="btn btn-dark btn-lg btn-block" value="Order Item Lainnya" style="background: rgba(20,27,61,1);"></a>
            @endif

        </div>
        
    </div>

<div id="overlay" class="overlay-element"></div>

</main>

</div>

<section class="section product__long-description">
    <article class="product__tag-line">
        Anda mengalami kesulitan atau kendala dalam order / pembelian item produk?<br>
        Silahkan hubungi layanan pelanggan {{config('webname')}} via WhatsApp di: {{config('whatsapp')}} atau melalui email kami di: {{config('email')}}.
        <br>
    </article>
</section>

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/jquery-ui-1.12.1.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/product-page.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/infobar2.css')}}" />
<script type="text/javascript" src="{{URL::asset('js/jquery.cookie.js')}}"></script>

@endsection