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

<h3>Status Order</h3>
<hr>

<h4>Riwayat Transaksi Saya</h4>
    @if (count($datas) == 0)
        <i>Data belum tersedia...</i><br><br>
    @elseif (count($datas) >= 1)
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Trx ID</th>
            <th>Date</th>
            <th>Product</th>
            <th>Total</th>
            <th>Status</th>
            {{-- <th>SN</th> --}}
        </tr>
        </thead>
        <tbody>
        @php $i=1 @endphp
        @foreach ( $datas as $data )
        <tr>
            <td>{{$i}}</td>
            <td><a href="order/{{$data->trx_id}}" target="_blank">#{{$data->trx_id}}</a></td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->product_code}}</td>
            <td>Rp {{number_format($data->total, 0)}}</td>
            <td>
                @if ($data->status == '1')
                    <span class="badge badge-info">Process</span>
                @elseif ($data->status == '2')
                    <span class="badge badge-success">Success</span>
                @else
                    <span class="badge badge-danger">Refund</span>
                @endif
            </td>
            {{-- <td>{{$data->notes}}</td> --}}
        </tr>
        @php $i++ @endphp
        @endforeach
        </tbody>
    </table>
    @endif

    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-3" style="padding:3px;">
                <a href="{{url('profile')}}" role="button" aria-pressed="true" class="btn btn-dark btn-lg btn-block">< Kembali</a>
            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" type="text/css" media="all" href="{{URL::asset('css/landing.css')}}" />
{{-- <link rel="stylesheet" type="text/css" href="{{URL::asset('css/product.css')}}" /> --}}

@endsection