@extends('app')

@section('content')

<body class="theme-page--landing-page">

<style>
    table { 
        width: 100%; 
        border-collapse: collapse; 
    }
    /* Zebra striping */
    tr:nth-of-type(odd) { 
        background: #eee; 
    }
    th { 
        background: #333; 
        color: white; 
        font-weight: bold; 
    }
    td, th { 
        padding: 6px; 
        border: 1px solid #ccc; 
        text-align: left; 
    }
    </style>

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
        <a href="{{url('login')}}" style="text-decoration: none; color: #fff; font-size:12px;">LOGIN</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{url('register')}}" style="text-decoration: none; color: #fff; font-size:12px;">REGISTER</a>
        @else
            <a style="text-decoration: none; color: #fff; font-size:12px;" href="{{url('profile')}}">{{ Auth::user()->userid }}</a> | <a style="text-decoration: none; color: #fff; font-size:12px;" href="{{url('logout')}}">Logout</a>
        @endguest
    </div>
</div>
</div>
</header>

<div class="coda-about__short-description" style="color: #111;font-size: 15px;padding: 10px;max-width: 755px; min-height: 400px; background: #fff;margin-top: 5%; margin-bottom: 5%; border-radius: 6px;">

<h3>Topup Saldo</h3>
<hr>

<div class="alert alert-info" role="alert">
    Info: 
    <ul>
    <li>Pastikan Anda membayar sejumlah tepat sesuai instruksi.</li>
    <li>Batas masa berlaku untuk pembayaran Topup Saldo adalah {{gmdate("G", config('payment_expired_time'))}} jam.</li>
    </ul>
</div>

<form id="FormDeposit" name="FormDeposit" action="{{url('deposit')}}" method="POST" onsubmit="return checkForm(this);">
    
{{ csrf_field() }}

<div class="form-input-container">
    @auth
        <input type="hidden" id="user_id" name="user_id" class="product-form-input" value="{{ Auth::user()->id }}">
    @endauth
</div>

<div class="amount-input-container">
    <label>Tentukan Nominal Topup Saldo:</label>
    <input type="number" id="amount" name="amount" required class="product-form-input" placeholder="Tulis Angka Saja (contoh: 10000)">
</div>

<br>

<div class="form-input-container">
    <label>Pilih Metode Pembayaran:</label>
    <select id="channel" name="channel" required class="product-form-input">
        <option value="" disabled selected>- Pilih Salah Satu -</option>
        <option value="8">Bank BCA</option>
        <option value="9">Bank Mandiri</option>
        <option value="10">Bank BNI</option>
        <option value="11">Bank BRI</option>
        <option value="1">GoPay</option>
        <option value="2">OVO</option>
        {{-- <option value="3">ATM / Bank Transfer</option> --}}
        {{-- <option value="4">Dana</option> --}}
        <option value="5">Alfamart</option>
        <option value="6">Indomaret</option>
        {{-- <option value="7">LinkAja</option> --}}
    </select>
</div>

<div class="email-form-btn-group">
    <input type="submit" id="submit" name="submit" class="btn btn-success btn-lg" value="Topup Saldo">
    <a href="{{url('profile')}}" role="button" aria-pressed="true" class="btn btn-secondary btn-lg">< Kembali</a>
</div>

</form>

<hr>
<h4>Riwayat Topup Saldo</h4>
@if (count($datas) == 0)
    <i>Data belum tersedia...</i><br><br>
@elseif (count($datas) > 0)
<table>
    <thead>
    <tr>
        <th>#</th>
        {{-- <th>ID</th> --}}
        <th>Date</th>
        <th>Total</th>
        <th>Payment</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach ( $datas as $data )
    <tr>
        <td>{{$i}}</td>
        {{-- <td>#{{$data->id}}</td> --}}
        <td><a href="{{url('deposit')}}/{{$data->id}}">{{$data->created_at}}</a></td>
        <td>Rp {{number_format($data->total, 0)}}</td>
        <td>
            @if ($data->payment_channel == '1')
                <span>GoPay</span>
            @elseif ($data->payment_channel == '2')
                <span>OVO</span>
            @elseif ($data->payment_channel == '3')
                <span>ATM</span>
            @elseif ($data->payment_channel == '4')
                <span>Dana</span>
            @elseif ($data->payment_channel == '5')
                <span>Alfamart</span>
            @elseif ($data->payment_channel == '6')
                <span>Indomaret</span>
            @elseif ($data->payment_channel == '7')
                <span>LinkAja</span>
            @elseif ($data->payment_channel == '8')
                <span>Bank BCA</span>
            @elseif ($data->payment_channel == '9')
                <span>Bank Mandiri</span>
            @elseif ($data->payment_channel == '10')
                <span>Bank BNI</span>
            @elseif ($data->payment_channel == '11')
                <span>Bank BRI</span>
            @endif
        </td>
        <td>
            @if ($data->status == '0')
                <span class="badge badge-warning">Waiting</span>
            @elseif ($data->status == '1')
                <span class="badge badge-success">Success</span>
            @else
                <span class="badge badge-dark">Expired</span>
            @endif
        </td>
    </tr>
    @php $i++ @endphp
    @endforeach
    </tbody>
</table>
@endif

</div>

<script>
function checkForm(FormDeposit)
{
    FormDeposit.submit.disabled = true;
    FormDeposit.submit.value = "Please Wait...";
    return true;
}
</script>

<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/product.css')}}" />

@endsection