@extends('app')

@section('content')

<body class="theme-page--product-page">

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/topnav.css')}}" />
<script type="text/javascript" src="{{URL::asset('js/shop-topnav.js')}}"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

@if(Session::has('error'))
<div class="popError" id="popError">
    <div class="section">
        <h2 class="errorHeader">Upps...</h2>
        <div class="container">
            <div class="row">
            <div class="col-sm-12" style="padding:20px;">
                {{ \Illuminate\Support\Facades\Session::get('error') }}
            </div>
            <div class="col-sm-9" style="padding:3px;">
            </div>
            <div class="col-sm-3" style="padding:10px;">
                <a style="color:#fff" class="btn btn-dark btn-lg btn-block" id="myBtn" style="cursor: pointer;">Okay!</a>
            </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .errorHeader {
        margin: 0;
        padding: 10px 15px;
        background-color: #222 !important;
        color: #fff;
        font-size: 18px;
    }
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
</style>

<section class="product-details-container">
    <div class="product-top-banner__container"><img src="{{url('storage')}}/{{$productByCode->image}}" alt="{{strtoupper($productByCode->name)}}" title="{{strtoupper($productByCode->name)}}" class="product__top-banner"></div>
        
    <div class="product__name">
        {{strtoupper($productByCode->name)}}
    </div>

    <input type="checkbox" id="product-description" name="product-description" class="product-description-checkbox">
    <label for="product-description">
        <span class="more-info">Baca lebih lanjut</span>
        <span class="less-info">Tutup informasi detail</span>
    </label>
    <div class="product__description">
        {!! $productByCode->intro !!}
        <br><br>
        Bingung cara menggunakan Redeem Code? <a style="color:#fff; text-decoration: underline;" href="{{url('/faq')}}">Klik disini</a>.
        <br><br>

        @if ($productByCode->ios_link != NULL)
            <a href="{{$productByCode->ios_link}}" target="_blank" style="padding: 0 0 0 0;" >
            <img style="width:120px; padding-top: 5px;"src="{{URL::asset('images/app_store.png')}}" alt="Download on the App Store" title="Download on the App Store"></a>
        @endif

        @if ($productByCode->android_link != NULL)
        <a href="{{$productByCode->android_link}}" target="_blank" style="padding: 0 0 0 0;" >
        <img style="width:120px; padding-top: 5px;"src="{{URL::asset('images/google_play.png')}}" alt="Download on Google Play" title="Download on Google Play"></a></div>
        @endif

</section>

<main id="contents" class="main-content">

<div class="section voucher">
    <h2 class="circle">
		<span>1</span> Pilih Voucher
    </h2>

    @auth
    <ul class="vocherSelectionList ul-denoms voucher-denom-container">
        @php $i = 1; @endphp
        @foreach ($produkpluck as $cp)
            <li id="denomination" class="voucher-list-element" onclick="show{{$i}}();">
                <a onclick="cekDenom0(this);" id="{{$cp->id}}" code="{{$cp->code}}" style="cursor:pointer">
                    {{$cp->name}}
                    <span id="check-{{$i}}"> L </span>
                </a>
            </li>
        @php $i++; @endphp
        @endforeach
        <span id="id"></span>
    </ul>
    @endauth

    @guest
    <ul class="vocherSelectionList ul-denoms voucher-denom-container">
        @php $i = 1; @endphp
        @foreach ($produkpluck as $cp)
            <li id="denomination" class="voucher-list-element" onclick="show{{$i}}();">
                <a onclick="cekDenom(this);" id="{{$cp->id}}" code="{{$cp->code}}" style="cursor:pointer">
                    {{$cp->name}}
                    <span id="check-{{$i}}"> L </span>
                </a>
            </li>
        @php $i++; @endphp
        @endforeach
        <span id="id"></span>
    </ul>
    @endguest

</div>


<div class="section payment" id="form-payment" style="display: none;">

    @auth
    <h2 class="circle">
		<span>2</span>Pilih Pembayaran
    </h2>
    <ul class="ul-paymentChannels">
        <li id="paymentChannel" class="payment-channel-element">
            <a markup="0" channel="0" class="payment-channel-link">
                <span id="element-check-label-1" style="display: inline;"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container" style="display: flex !important;">
                        <img src="{{URL::asset('images/fav.ico')}}" height="50px;" width="50px;">
                        Saldo Akun:<br> Rp {{ number_format(Auth::user()->balance, 0) }}
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-memberr" style="color:#222;"></span>
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-memberr"></span>
                    </div>
                </div>
            </a>
        </li>
    </ul>
    @endauth

    @guest
    <h2 class="circle">
		<span>2</span>Pilih Pembayaran
	</h2>

    <ul class="ul-paymentChannels">

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$bca->mark_up_price}}" channel="8" class="payment-channel-link" onclick="showPayment4(); CekPayment4(this)">
                <span id="element-check-label-4"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-4" src="{{url('storage')}}/{{$bca->payment_logo}}" alt="{{$bca->payment_name}}" title="{{$bca->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-bca" style="color:#222;"></span>
                        <input id="total4" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$bca->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-4" class="payment-channel-4" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$bca->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$mandiri->mark_up_price}}" channel="9" class="payment-channel-link" onclick="showPayment5(); CekPayment5(this)">
                <span id="element-check-label-5"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-5" src="{{url('storage')}}/{{$mandiri->payment_logo}}" alt="{{$mandiri->payment_name}}" title="{{$mandiri->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-mandiri" style="color:#222;"></span>
                        <input id="total5" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$mandiri->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-5" class="payment-channel-5" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$mandiri->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$bni->mark_up_price}}" channel="10" class="payment-channel-link" onclick="showPayment6(); CekPayment6(this)">
                <span id="element-check-label-6"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-6" src="{{url('storage')}}/{{$bni->payment_logo}}" alt="{{$bni->payment_name}}" title="{{$bni->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-bni" style="color:#222;"></span>
                        <input id="total6" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$bni->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-6" class="payment-channel-6" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$bni->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$bri->mark_up_price}}" channel="11" class="payment-channel-link" onclick="showPayment7(); CekPayment7(this)">
                <span id="element-check-label-7"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-7" src="{{url('storage')}}/{{$bri->payment_logo}}" alt="{{$bri->payment_name}}" title="{{$bri->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-bri" style="color:#222;"></span>
                        <input id="total7" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$bri->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-7" class="payment-channel-7" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$bri->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$ovo->mark_up_price}}" channel="2" class="payment-channel-link" onclick="showPayment1(); CekPayment1(this)">
                <span id="element-check-label-1"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-1" src="{{url('storage')}}/{{$ovo->payment_logo}}" alt="{{$ovo->payment_name}}" title="{{$ovo->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-ovo" style="color:#222;"></span>
                        <input id="total1" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$ovo->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-1" class="payment-channel-1" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$ovo->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$gopay->mark_up_price}}" channel="1" class="payment-channel-link" onclick="showPayment8(); CekPayment8(this)">
                <span id="element-check-label-8"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-8" src="{{url('storage')}}/{{$gopay->payment_logo}}" alt="{{$gopay->payment_name}}" title="{{$gopay->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-gopay" style="color:#222;"></span>
                        <input id="total8" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$gopay->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-8" class="payment-channel-8" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$gopay->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$indomaret->mark_up_price}}" channel="6" class="payment-channel-link" onclick="showPayment2(); CekPayment2(this)">
                <span id="element-check-label-2"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-2" src="{{url('storage')}}/{{$indomaret->payment_logo}}" alt="{{$indomaret->payment_name}}" title="{{$indomaret->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-indomaret" style="color:#222;"></span>
                        <input id="total2" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$indomaret->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-2" class="payment-channel-2" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$indomaret->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$alfamart->mark_up_price}}" channel="5" class="payment-channel-link" onclick="showPayment3(); CekPayment3(this)">
                <span id="element-check-label-3"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-3" src="{{url('storage')}}/{{$alfamart->payment_logo}}" alt="{{$alfamart->payment_name}}" title="{{$alfamart->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-alfamart" style="color:#222;"></span>
                        <input id="total3" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$alfamart->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-3" class="payment-channel-3" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$alfamart->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

        <li id="paymentChannel" class="payment-channel-element">
            <a markup="{{$telkomsel->mark_up_price}}" channel="12" class="payment-channel-link" onclick="showPayment9(); CekPayment9(this)">
                <span id="element-check-label-9"> L </span>
                <div class="payment-channel-container">
                    <figure class="payment-logo-container">
                        <img class="logo" id="payment-9" src="{{url('storage')}}/{{$telkomsel->payment_logo}}" alt="{{$telkomsel->payment_name}}" title="{{$telkomsel->payment_name}}" />
                    </figure>
                </div>
                <div class="payment-price-container">
                    <div class="price_label" id="priceLabel">
                        <span id="price-telkomsel" style="color:#222;"></span>
                        <input id="total9" type="hidden">
                    </div>
                    <div class="price pr" id="priceInfo"><span id="harga-{{$telkomsel->payment_code}}"></span>
                    </div>
                </div>
                <div id="payment-tagline-container-9" class="payment-channel-12" style="width:100%">
                    <p class="payment-tagline" id="payment-channel">{{$telkomsel->payment_description}}</p>
                </div>
                <div class="best-deal-label"></div>
            </a>
        </li>

    </ul>
    @endguest

</div>

<div class="section buy default-template" id="form-buy" style="display: none;">
    <h2 class="circle"><span>3</span>        
        <div class="section-title">Lengkapi Form</div>
    </h2 >
    <div class="form" id="formSection">

    <form id="FomOrder" name="FomOrder" action="{{url('order')}}" method="POST" onsubmit="return checkForm(this);">

        {{ csrf_field() }}
        
        <p class="emailOptional default-2">
            Pastikan ID Game, alamat email dan nomor HP yang Anda masukkan sudah benar.<br> 
            Kami akan Topup langsung ID Game Anda, serta kirim kode voucher Anda melalui email dan SMS ke nomor HP tersebut.
        </p>

        <div class="form-input-container">
            @auth
            <input type="hidden" id="user_id" name="user_id" class="product-form-input" value="{{ Auth::user()->id }}">
            @endauth
            
            @if ( $productByCode->slug == 'mobile-legends' )

                <div class="form-field-wrapper form__field-user-id">
                   <input id="game_id" name="game_id" type="text" class="userid form-input" placeholder="Masukkan User ID" maxlength="10" required>
                </div>
       
                <div class="form-field-wrapper form__field-zone-id zone-id--with-parenthesis">
                   <span class="form-field-parenthesis">(</span>
                   <input id="game_id2" name="game_id2" type="tel" class="zoneid form-input enable" maxlength="5" required>
                   <span class="form-field-parenthesis">)</span>
               </div>

                <p class="form__field-instruction-text">Untuk mengetahui User ID Anda, Silakan Klik menu profile dibagian kiri atas pada menu utama game. Dan user ID akan terlihat dibagian bawah Nama Karakter Game Anda. Silakan masukkan User ID Anda untuk menyelesaikan transaksi. Contoh: 12345678 (1234).</p>

            @else
                <input type="text" id="game_id" name="game_id" class="product-form-input" placeholder="ID Game">

                <p class="form__field-instruction-text">Untuk menemukan ID Anda, ketuk pada ikon karakter. User ID tercantum dibawah nama karakter Anda. Contoh: 5363266446.</p>
            @endif

        </div>

        <br>

        <div class="form-input-container">
            <input type="hidden" id="productID" name="productID" class="product-form-input" placeholder="Product ID">
        </div>

        <div class="form-input-container">
            <input type="hidden" id="productCode" name="productCode" class="product-form-input" placeholder="Product Code">
        </div>

        <div class="email-input-container">
            <input type="email" id="email" name="email" required class="product-form-input" placeholder="Email Anda (Contoh: email@domain.com)">
        </div>

        <br>

        <div class="form-input-container">
            <input type="text" id="phone" name="phone" pattern="(08)\d{7,12}" required class="product-form-input" placeholder="Nomor WhatsApp (Contoh 081234567890)" title="Nomor WhatsApp harus valid, tanpa tanda hubung / tanpa spasi (Contoh: 081234567890)">
        </div>

        <div class="form-input-container">
            @auth
                <input type="hidden" id="channel" name="channel" class="product-form-input" value="0">
            @endauth
            @guest
                <input type="hidden" id="channel" name="channel" class="product-form-input">
            @endguest
        </div>

        <div class="form-input-container">
            @auth
                <input type="hidden" id="price" name="price" class="product-form-input">
            @endauth
            @guest
                <input type="hidden" id="price" name="price" class="product-form-input">
            @endguest
        </div>

        <div class="email-form-btn-group">
            <div class="loader" id="submit-loader"></div>
            <input type="submit" id="submit" name="submit" class="btn btn-dark btn-lg btn-block" value="Beli Sekarang" style="background: rgba(20,27,61,1);">
        </div>

    </form>

    </div>
</div>

@if($errors->any())
<div class="popError" id="popError">
    <div class="section">
        <h2 class="errorHeader">Upps...</h2>
        <div class="container">
            <div class="row">
            <div class="col-sm-12" style="padding:20px;">
                <ul class="errorMessage__container" id="errorMessage">
                    {{$errors->first()}}<br><br>
                    <li class="error-msg__element">Silahkan pilih nomor voucher</li>
                    <li class="error-msg__element">Silahkan pilih metode pembayaran</li>
                    <li class="error-msg__element">Silahkan isi User ID Game Anda</li>
                    <li class="error-msg__element">Silahkan isi alamat Email yang Anda pakai</li>
                    <li class="error-msg__element">Silahkan isi nomor HP yang Anda pakai</li>
                </ul>
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

<script>
    $(document).ready(function(){
        $("#myBtn").click(function(){
        $("#popError").hide();
        });
    });
</script>

<div id="overlay" class="overlay-element"></div>

</main>

</div>

<section class="section product__long-description">
    <article class="product__tag-line">
        {!! $productByCode->description !!}
        <br>
    </article>
</section>

<script>
function checkForm(FomOrder)
{
    FomOrder.submit.disabled = true;
    FomOrder.submit.value = "Please Wait...";
    return true;
}
</script>


<script type="text/javascript">
    function cekDenom0(ele)
    {
        var id = $(ele).attr('id');
        var code = $(ele).attr('code');
        document.getElementById("productID").value = id;
        document.getElementById("productCode").value = code;

        $.ajax({
            url: "{{ route('options.get_by_item') }}?id=" + id,
            method: 'GET',
            success: function(data) {
                $('#price-memberr').html(data.memberr);
                $('#price-ovo').html(data.ovo);
                $('#price-gopay').html(data.gopay);
                $('#price-indomaret').html(data.indomaret);
                $('#price-alfamart').html(data.alfamart);
                $('#price-bca').html(data.bca);
                $('#price-mandiri').html(data.mandiri);
                $('#price-bni').html(data.bni);
                $('#price-bri').html(data.bri);
                document.getElementById("price").value = data.input0;
            }
        });
        document.getElementById("form-payment").style.display="block";
        document.getElementById("form-buy").style.display="block";
    }
</script>


<script type="text/javascript">
    function cekDenom(ele)
    {
        var id = $(ele).attr('id');
        var code = $(ele).attr('code');
        document.getElementById("productID").value = id;
        document.getElementById("productCode").value = code;

        $.ajax({
            url: "{{ route('options.get_by_item') }}?id=" + id,
            method: 'GET',
            success: function(data) {
                $('#price-memberr').html(data.memberr);
                $('#price-ovo').html(data.ovo);
                $('#price-gopay').html(data.gopay);
                $('#price-indomaret').html(data.indomaret);
                $('#price-alfamart').html(data.alfamart);
                $('#price-bca').html(data.bca);
                $('#price-mandiri').html(data.mandiri);
                $('#price-bni').html(data.bni);
                $('#price-bri').html(data.bri);
                $('#price-telkomsel').html(data.telkomsel);
                document.getElementById("total1").value = data.input1;
                document.getElementById("total2").value = data.input2;
                document.getElementById("total3").value = data.input3;
                document.getElementById("total4").value = data.input4;
                document.getElementById("total5").value = data.input5;
                document.getElementById("total6").value = data.input6;
                document.getElementById("total7").value = data.input7;
                document.getElementById("total8").value = data.input8;
                document.getElementById("total9").value = data.input9;
            }
        });
        document.getElementById("form-payment").style.display="block";
        document.getElementById("form-buy").style.display="block";

        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("channel").value = '';
        document.getElementById("price").value = '';
    }
</script>

<script type="text/javascript">
function show1() {
    document.getElementById("check-1").style.display="inline-block";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show2() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="inline-block";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show3() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="inline-block";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show4() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="inline-block";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show5() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="inline-block";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show6() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="inline-block";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show7() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="inline-block";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show8() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="inline-block";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show9() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="inline-block";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show10() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="inline-block";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show11() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="inline-block";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show12() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="inline-block";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show13() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="inline-block";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show14() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="inline-block";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show15() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="inline-block";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show16() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="inline-block";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show17() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="inline-block";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show18() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="inline-block";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="none";
}
function show19() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="inline-block";
    document.getElementById("check-20").style.display="none";
}
function show20() {
    document.getElementById("check-1").style.display="none";
    document.getElementById("check-2").style.display="none";
    document.getElementById("check-3").style.display="none";
    document.getElementById("check-4").style.display="none";
    document.getElementById("check-5").style.display="none";
    document.getElementById("check-6").style.display="none";
    document.getElementById("check-7").style.display="none";
    document.getElementById("check-8").style.display="none";
    document.getElementById("check-9").style.display="none";
    document.getElementById("check-10").style.display="none";
    document.getElementById("check-11").style.display="none";
    document.getElementById("check-12").style.display="none";
    document.getElementById("check-13").style.display="none";
    document.getElementById("check-14").style.display="none";
    document.getElementById("check-15").style.display="none";
    document.getElementById("check-16").style.display="none";
    document.getElementById("check-17").style.display="none";
    document.getElementById("check-18").style.display="none";
    document.getElementById("check-19").style.display="none";
    document.getElementById("check-20").style.display="inline-block";
}
</script>

<script type="text/javascript">
    function showPayment1() {
        document.getElementById("payment-tagline-container-1").style.display="inline-block";
        document.getElementById("element-check-label-1").style.display="inline-block";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("payment-tagline-container-4").style.display="none";
        document.getElementById("element-check-label-4").style.display="none";
        document.getElementById("payment-tagline-container-5").style.display="none";
        document.getElementById("element-check-label-5").style.display="none";
        document.getElementById("payment-tagline-container-6").style.display="none";
        document.getElementById("element-check-label-6").style.display="none";
        document.getElementById("payment-tagline-container-7").style.display="none";
        document.getElementById("element-check-label-7").style.display="none";
        document.getElementById("payment-tagline-container-8").style.display="none";
        document.getElementById("element-check-label-8").style.display="none";
        document.getElementById("payment-tagline-container-9").style.display="none";
        document.getElementById("element-check-label-9").style.display="none";
    }
</script>

<script type="text/javascript">
    function showPayment2() {
        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="inline-block";
        document.getElementById("element-check-label-2").style.display="inline-block";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("payment-tagline-container-4").style.display="none";
        document.getElementById("element-check-label-4").style.display="none";
        document.getElementById("payment-tagline-container-5").style.display="none";
        document.getElementById("element-check-label-5").style.display="none";
        document.getElementById("payment-tagline-container-6").style.display="none";
        document.getElementById("element-check-label-6").style.display="none";
        document.getElementById("payment-tagline-container-7").style.display="none";
        document.getElementById("element-check-label-7").style.display="none";
        document.getElementById("payment-tagline-container-8").style.display="none";
        document.getElementById("element-check-label-8").style.display="none";
        document.getElementById("payment-tagline-container-9").style.display="none";
        document.getElementById("element-check-label-9").style.display="none";
    }
</script>

<script type="text/javascript">
    function showPayment3() {
        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="inline-block";
        document.getElementById("element-check-label-3").style.display="inline-block";
        document.getElementById("payment-tagline-container-4").style.display="none";
        document.getElementById("element-check-label-4").style.display="none";
        document.getElementById("payment-tagline-container-5").style.display="none";
        document.getElementById("element-check-label-5").style.display="none";
        document.getElementById("payment-tagline-container-6").style.display="none";
        document.getElementById("element-check-label-6").style.display="none";
        document.getElementById("payment-tagline-container-7").style.display="none";
        document.getElementById("element-check-label-7").style.display="none";
        document.getElementById("payment-tagline-container-8").style.display="none";
        document.getElementById("element-check-label-8").style.display="none";
        document.getElementById("payment-tagline-container-9").style.display="none";
        document.getElementById("element-check-label-9").style.display="none";
    }
</script>

<script type="text/javascript">
    function showPayment4() {
        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("payment-tagline-container-4").style.display="inline-block";
        document.getElementById("element-check-label-4").style.display="inline-block";
        document.getElementById("payment-tagline-container-5").style.display="none";
        document.getElementById("element-check-label-5").style.display="none";
        document.getElementById("payment-tagline-container-6").style.display="none";
        document.getElementById("element-check-label-6").style.display="none";
        document.getElementById("payment-tagline-container-7").style.display="none";
        document.getElementById("element-check-label-7").style.display="none";
        document.getElementById("payment-tagline-container-8").style.display="none";
        document.getElementById("element-check-label-8").style.display="none";
        document.getElementById("payment-tagline-container-9").style.display="none";
        document.getElementById("element-check-label-9").style.display="none";
    }
</script>

<script type="text/javascript">
    function showPayment5() {
        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("payment-tagline-container-4").style.display="none";
        document.getElementById("element-check-label-4").style.display="none";
        document.getElementById("payment-tagline-container-5").style.display="inline-block";
        document.getElementById("element-check-label-5").style.display="inline-block";
        document.getElementById("payment-tagline-container-6").style.display="none";
        document.getElementById("element-check-label-6").style.display="none";
        document.getElementById("payment-tagline-container-7").style.display="none";
        document.getElementById("element-check-label-7").style.display="none";
        document.getElementById("payment-tagline-container-8").style.display="none";
        document.getElementById("element-check-label-8").style.display="none";
        document.getElementById("payment-tagline-container-9").style.display="none";
        document.getElementById("element-check-label-9").style.display="none";
    }
</script>

<script type="text/javascript">
    function showPayment6() {
        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("payment-tagline-container-4").style.display="none";
        document.getElementById("element-check-label-4").style.display="none";
        document.getElementById("payment-tagline-container-5").style.display="none";
        document.getElementById("element-check-label-5").style.display="none";
        document.getElementById("payment-tagline-container-6").style.display="inline-block";
        document.getElementById("element-check-label-6").style.display="inline-block";
        document.getElementById("payment-tagline-container-7").style.display="none";
        document.getElementById("element-check-label-7").style.display="none";
        document.getElementById("payment-tagline-container-8").style.display="none";
        document.getElementById("element-check-label-8").style.display="none";
        document.getElementById("payment-tagline-container-9").style.display="none";
        document.getElementById("element-check-label-9").style.display="none";
    }
</script>

<script type="text/javascript">
    function showPayment7() {
        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("payment-tagline-container-4").style.display="none";
        document.getElementById("element-check-label-4").style.display="none";
        document.getElementById("payment-tagline-container-5").style.display="none";
        document.getElementById("element-check-label-5").style.display="none";
        document.getElementById("payment-tagline-container-6").style.display="none";
        document.getElementById("element-check-label-6").style.display="none";
        document.getElementById("payment-tagline-container-7").style.display="inline-block";
        document.getElementById("element-check-label-7").style.display="inline-block";
        document.getElementById("payment-tagline-container-8").style.display="none";
        document.getElementById("element-check-label-8").style.display="none";
        document.getElementById("payment-tagline-container-9").style.display="none";
        document.getElementById("element-check-label-9").style.display="none";
    }
</script>

<script type="text/javascript">
    function showPayment8() {
        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("payment-tagline-container-4").style.display="none";
        document.getElementById("element-check-label-4").style.display="none";
        document.getElementById("payment-tagline-container-5").style.display="none";
        document.getElementById("element-check-label-5").style.display="none";
        document.getElementById("payment-tagline-container-6").style.display="none";
        document.getElementById("element-check-label-6").style.display="none";
        document.getElementById("payment-tagline-container-7").style.display="none";
        document.getElementById("element-check-label-7").style.display="none";
        document.getElementById("payment-tagline-container-8").style.display="inline-block";
        document.getElementById("element-check-label-8").style.display="inline-block";
        document.getElementById("payment-tagline-container-9").style.display="none";
        document.getElementById("element-check-label-9").style.display="none";
    }
</script>

<script type="text/javascript">
    function showPayment9() {
        document.getElementById("payment-tagline-container-1").style.display="none";
        document.getElementById("element-check-label-1").style.display="none";
        document.getElementById("payment-tagline-container-2").style.display="none";
        document.getElementById("element-check-label-2").style.display="none";
        document.getElementById("payment-tagline-container-3").style.display="none";
        document.getElementById("element-check-label-3").style.display="none";
        document.getElementById("payment-tagline-container-4").style.display="none";
        document.getElementById("element-check-label-4").style.display="none";
        document.getElementById("payment-tagline-container-5").style.display="none";
        document.getElementById("element-check-label-5").style.display="none";
        document.getElementById("payment-tagline-container-6").style.display="none";
        document.getElementById("element-check-label-6").style.display="none";
        document.getElementById("payment-tagline-container-7").style.display="none";
        document.getElementById("element-check-label-7").style.display="none";
        document.getElementById("payment-tagline-container-8").style.display="none";
        document.getElementById("element-check-label-8").style.display="none";
        document.getElementById("payment-tagline-container-9").style.display="inline-block";
        document.getElementById("element-check-label-9").style.display="inline-block";
    }
</script>

<script>
    function CekPayment1(ele)
    {
        var hargatotal = document.getElementById('total1').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
        //console.log('hargatotal: '+hargatotal);
    }
    function CekPayment2(ele)
    {
        var hargatotal = document.getElementById('total2').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
    }
    function CekPayment3(ele)
    {
        var hargatotal = document.getElementById('total3').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
    }
    function CekPayment4(ele)
    {
        var hargatotal = document.getElementById('total4').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
    }
    function CekPayment5(ele)
    {
        var hargatotal = document.getElementById('total5').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
    }
    function CekPayment6(ele)
    {
        var hargatotal = document.getElementById('total6').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
    }
    function CekPayment7(ele)
    {
        var hargatotal = document.getElementById('total7').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
    }
    function CekPayment8(ele)
    {
        var hargatotal = document.getElementById('total8').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
    }
    function CekPayment9(ele)
    {
        var hargatotal = document.getElementById('total9').value;
        var channel = $(ele).attr('channel');
        document.getElementById("price").value = hargatotal;
        document.getElementById("channel").value = channel;
    }
</script>

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/jquery-ui-1.12.1.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/product-page.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/infobar2.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/payment.css')}}" />
<script type="text/javascript" src="{{URL::asset('js/jquery.cookie.js')}}"></script>

@endsection