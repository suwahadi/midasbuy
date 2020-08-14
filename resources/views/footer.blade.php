<style>
    .footer-container a {
        color:#222;
        text-decoration: none;
        font-size: 13px;
    }
</style>

<footer class="footer-container">
</footer>

<div style="text-align:center; background: #fff; color:#222; font-size:13px; padding:30px;">

        <a style="color: #222;" href="https://wa.me/{{config('whatsapp')}}" target="_blank">
            <img src="{{URL::asset('images/whatsapp.png')}}" alt="WhatsApp" title="WhatsApp" class="social-icon"><br>
            <div>{{config('whatsapp')}}</div>
        </a>

        <br>

        <a href='{{config('facebook')}}' target="_blank" class="social-icon-container">
            <img src="{{URL::asset('images/facebook.png')}}" alt="Facebook" title="Facebook" class="social-icon">
        </a>
    
        <a href='{{config('youtube')}}' target="_blank" class="social-icon-container">
            <img src="{{URL::asset('images/youtube.png')}}" alt="Youtube" title="Youtube" class="social-icon">
        </a>

        <a href='{{config('instagram')}}' target="_blank" class="social-icon-container">
            <img src="{{URL::asset('images/instagram.png')}}" alt="Instagram" title="Instagram" class="social-icon">
        </a>

        <br><br>

        <a style="color: #222;" href="{{url('api')}}">API Documentation</a> | 
        <a style="color: #222;" href="{{url('news')}}">News & Promotions</a> | 
        <a style="color: #222;" href="{{url('terms-conditions')}}">Syarat & Ketentuan</a> | 
        <a style="color: #222;" href="{{url('privacy-policy')}}">Kebijakan Privasi</a>

    <br>
    Copyright &copy; 2020 {{config('webname')}} - {{config('slogan')}}
</div>

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/footers.css')}}" />