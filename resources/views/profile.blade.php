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

<div class="coda-about__short-description" style="color: #111;font-size: 15px;padding: 10px;max-width: 755px; min-height: 500px; background: #fff;margin-top: 5%; margin-bottom: 5%; border-radius: 6px;">

<h3>Profile</h3>
<hr>

<div class="alert alert-primary" role="alert">
    Halo, <strong>{{ Auth::user()->userid }}</strong> | Saldo Anda saat ini: <strong>Rp {{ number_format(Auth::user()->balance, 0) }} <a href="{{url('deposit')}}">[Topup Saldo]</a></strong>
</div>

@if(Session::has('alert-success'))
<div class="popError" id="popError">
    <div class="section">
        <h2 class="errorHeader">Sukses!</h2>
        <div class="container">
            <div class="row">
            <div class="col-sm-12" style="padding:20px;">
                {{ \Illuminate\Support\Facades\Session::get('alert-success') }}
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

@endif

<script>
    $(document).ready(function(){
        $("#myBtn").click(function(){
        $("#popError").hide();
        });
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-sm" style="padding:3px;">
            <a href="{{url('deposit')}}" role="button" aria-pressed="true" class="btn btn-success btn-lg btn-block">Topup Saldo</a>
        </div>
        <div class="col-sm" style="padding:3px;">
            <a href="{{url('history')}}" role="button" aria-pressed="true" class="btn btn-primary btn-lg btn-block">Status Order</a>
        </div>
        <div class="col-sm" style="padding:3px;">
            <a href="{{url('profile/edit')}}" role="button" aria-pressed="true" class="btn btn-info btn-lg btn-block">Edit Profile</a>
        </div>
        <div class="col-sm" style="padding:3px;">
            <a href="{{url('logout')}}" role="button" aria-pressed="true" class="btn btn-dark btn-lg btn-block">Logout</a>
        </div>
    </div>
</div>

<hr>
<h4>Riwayat Mutasi Saldo</h4>
@if (count($logs) == 0)
    <i>Data belum tersedia...</i><br><br>
@elseif (count($logs) > 0)
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Total</th>
        <th>Type</th>
        <th>Notes</th>
        <th>Balance</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach ( $logs as $log )
    <tr>
        <td>{{$i}}</td>
        <td>{{$log->created_at}}</td>
        <td>Rp {{number_format($log->total, 0)}}</td>
        <td>
            @if ($log->type == 'Credit')
                <span class="badge badge-success">Credit</span>
            @else
                <span class="badge badge-danger">Debet</span>
            @endif
        </td>
        <td>{{$log->notes}}</td>
        <td>Rp {{number_format($log->balance, 0)}}</td>
    </tr>
    @php $i++ @endphp
    @endforeach
    </tbody>
</table>
@endif

</div>


<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/product-page.css')}}" />

@endsection