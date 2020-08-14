<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<!--[if lt IE 9]>
<script src="js/html5.min.js"></script>
<![endif]-->

<title>{{config('webname')}} - {{config('slogan')}}</title>

<meta name="generator" content="{{config('webname')}}" />
<meta name='viewport' content='width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0' />
<meta name="mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="application-name" content="{{config('webname')}}" />
<meta name="apple-mobile-web-app-capable " content="yes " />
<meta name="apple-mobile-web-app-status-bar-style " content="black " />
<meta name="apple-mobile-web-app-title " content="{{config('webname')}}" />
<link rel="shortcut icon" href="{{URL::asset('images/fav.ico')}}">
<meta name="msapplication-TileColor " content="#f76b1d " />
<meta name="theme-color " content="#f76b1d" />
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<script type="text/javascript" src="{{URL::asset('js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="{{URL::asset('css/slider.css')}}"/>
<script type="text/javascript" src="{{URL::asset('js/flickity.pkgd.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/lozad.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/fonts.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/infobar.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/top-nav.css')}}" />
<script type="text/javascript" src="{{URL::asset('js/shop-topnav.js')}}"></script>

<!-- OG Tags Start -->
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{config('webname')}}" />
<meta property="og:description" content='{{config('slogan')}}'>
<meta property="og:image" content="{{URL::asset('images/og-image.jpg')}}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<!-- OG Tags End -->

<meta name="description" content='{{config('slogan')}}'>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>

@yield('content')
@include('footer')

</body>
</html>