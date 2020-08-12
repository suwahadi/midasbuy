<style>
    .footer-container a {
        color:#222;
        text-decoration: none;
        font-size: 13px;
    }
</style>

<footer class="footer-container">

    <div class="footer-area">
        <section class="left-blocks-container">

            <div class="socials-container">
                <p class="social-title" >Social Media</p>
                <div class="footer__social-media-container">
                    
                        <a href='{{config('facebook')}}' target="_blank" class="social-icon-container">
                            <img src="{{URL::asset('images/facebook.png')}}" alt="Facebook" title="Facebook" class="social-icon">
                        </a>
                    
                        <a href='{{config('youtube')}}' target="_blank" class="social-icon-container">
                            <img src="{{URL::asset('images/youtube.png')}}" alt="Youtube" title="Youtube" class="social-icon">
                        </a>

                        <a href='{{config('instagram')}}' target="_blank" class="social-icon-container">
                            <img src="{{URL::asset('images/instagram.png')}}" alt="Instagram" title="Instagram" class="social-icon">
                        </a>
                    
                </div>
            </div>

            <div class="support-container">
                <p class="support-title">Butuh Bantuan?</p>
                <ul style="text-align:left; list-style:none; margin:0; padding:0;">
                    <li><a href="{{url('faq')}}">FAQ</a></li>
                    <li><a href="{{url('contact')}}">Hubungi Kami</a></li>
                </ul>
                
            </div>
            <div class="international-container">
                <a href="https://wa.me/{{config('whatsapp')}}" target="_blank">
                    <img src="{{URL::asset('images/whatsapp.png')}}" alt="WhatsApp" title="WhatsApp" class="social-icon"><br>
                    <div>{{config('whatsapp')}}</div>
                </a>
            </div>
        </section>

        <section class="right-blocks-container">
            <div class="legal-content-container">
                <a href="{{url('api')}}">API Documentation</a>
                <a href="{{url('news')}}">News & Promotions</a>
                <a href="{{url('terms-conditions')}}">Syarat & Ketentuan</a>
                <a href="{{url('privacy-policy')}}">Kebijakan Privasi</a>
            </div>
			
        </section>
    </div>

</footer>

<div style="text-align:center; background: rgba(20,27,61,1); color:#fff; font-size:13px; padding:20px;">
    Copyright &copy; 2020 {{config('webname')}} - {{config('slogan')}}
</div>

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/footer.css')}}" />