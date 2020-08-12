<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no,email=no">
    <meta name="robots" content="index,follow">
    <title>{{ENV('APP_NAME')}}</title>
    <meta name="keywords" content="Pusat Isi Ulang" />
    <meta name="description" content="Pusat Isi Ulang" />

    <link href="{{ asset('css/banner.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
    
    <script type="text/javascript" src="//midas.gtimg.cn/h5/overseah5/js/midas-oversea-h5page.js"></script>
    <script type="text/javascript" src="//www.midasbuy.com/oversea_web/static/js/jquery.js?jslib=1"></script>
    <script type="text/javascript" src="//www.midasbuy.com/oversea_web/static/js/swiper3_4_2/swiper.jquery.min.js?jslib=1"></script>
    
    <style type="text/css">
        input::-ms-clear {
            display: none;
        }
        .footer ul {
            margin-right: 15px;
        }
    </style>

    <script>
        jQuery.fn.placeholder = function () {
            var i = document.createElement('input'),placeholdersupport ='placeholder' in i;
            if(!placeholdersupport){
                var inputs = jQuery(this);
                inputs.each(function(){
                    var input = jQuery(this),
                        text = input.attr('placeholder'),
                        pdl = 0,height = input.outerHeight(),
                        width = input.outerWidth(),
                        placeholder = jQuery('<span class="phTips">'+text+'</span>');
                        try{
                            pdl = input.css('padding-left').match(/\d*/i)[0] * 1;
                        }catch(e){
                            pdl = 5;
                        }
                        placeholder.css({
                            'margin-left': -(width-pdl),
                            'height':height,
                            'line-height':height+'px',
                            'position':'absolute',
                            'color': '#cecfc9',
                            'font-size' : '12px'
                        });
                        placeholder.click(function(){
                            input.focus();
                        });
                        if(input.val() != ''){
                            placeholder.css({display:'none'});
                        }else{
                            placeholder.css({display:'inline'});
                        }
                        placeholder.insertAfter(input);
                        input.keydown(function(e){
                            placeholder.css({display:'none'});
                        });
                        input.keyup(function(e){
                            if(jQuery(this).val() != ''){
                                placeholder.css({display:'none'});
                            }else{
                                placeholder.css({display:'inline'});
                            }
                        });
                    });
                }
            return this;
        };
        
    </script>

</head>
<body>

<div class="wrap">
   
<div class="bg"></div>
<div class="header-box g-clr"></div>
<div class="header">
    <div class="main g-clr">
        
            <div class="menu-more">
                <div class="icon-box">
                    <div class="line1 line"></div>
                    <div class="line2 line"></div>
                    <div class="line3 line"></div>
                </div>
            </div>
        
        <h1 class="logo"><a class="pc" href="/">{{ENV('APP_NAME')}}</a></h1>
        
            <div class="menu">
                <a class="active navIndexButton" href="/" cr="homepage">Beranda</a>
            </div>
        
        <div class="log">
            <div class="login" id="headerLoginButton"><a href="login">Login</a></div>
            <div class="login" id="headerLoginButton"><a href="register">Register</a></div>
        </div>
        
        <div class="menu-nav-box">
            <ul>
                <li class="acitve navIndexButton"><a href="/" cr="homepage">Beranda</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="xnav">
    <div class="main g-clr">
        <ul>
            <li class="active" cr="header_games">Game Populer</li>
        </ul>
    </div>
</div>


<div class="banner-wrap">

    <div class="swiper-container" style="height: auto;overflow: visible;">
        <div class="swiper-wrapper swiper-wrapper1">
             
            <div class="swiper-slide">
                <a class="banner-link" href="/midasbuy/id/buy/pubgm">
                    <div class="img-box">
                        <img class="banner-pic" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAxCAQAAAALxYPPAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkBgsLGTJGwpbsAAAAAW9yTlQBz6J3mgAAACxJREFUWMPtzEENAAAIBCC1f2ft4HY/CEBvZUzoFYvFYrFYLBaLxWKxWCz+OkvmAWHcq1PMAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA2LTExVDExOjI1OjUwKzAwOjAwDrJzIQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNi0xMVQxMToyNTo1MCswMDowMH/vy50AAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC" data-src="//midas.gtimg.cn/store_config/1596005262769x99sUQGs.jpg" alt="img" cr="banner"/>
                    </div>
                </a>
            </div>
            
            <div class="swiper-slide">
                <a class="banner-link" href="https://www.midasbuy.com/midasbuy/id/event/invite/pubgm?lan=id&amp;from=__mds_buy_invite">
                    <div class="img-box">
                        <img class="banner-pic" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAxCAQAAAALxYPPAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkBgsLGTJGwpbsAAAAAW9yTlQBz6J3mgAAACxJREFUWMPtzEENAAAIBCC1f2ft4HY/CEBvZUzoFYvFYrFYLBaLxWKxWCz+OkvmAWHcq1PMAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA2LTExVDExOjI1OjUwKzAwOjAwDrJzIQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNi0xMVQxMToyNTo1MCswMDowMH/vy50AAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC" data-src="//midas.gtimg.cn/store_config/1595572784048M2sLGFmC.jpg" alt="img" cr="banner"/>
                    </div>
                </a>
            </div>
            
            <div class="swiper-slide">
                <a class="banner-link" href="https://www.midasbuy.com/midasbuy/id/props_order/pubgm?pid=S14_RP_Upgrade_Card_Package">
                    <div class="img-box">
                        <img class="banner-pic" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAxCAQAAAALxYPPAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkBgsLGTJGwpbsAAAAAW9yTlQBz6J3mgAAACxJREFUWMPtzEENAAAIBCC1f2ft4HY/CEBvZUzoFYvFYrFYLBaLxWKxWCz+OkvmAWHcq1PMAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA2LTExVDExOjI1OjUwKzAwOjAwDrJzIQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNi0xMVQxMToyNTo1MCswMDowMH/vy50AAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC" data-src="//midas.gtimg.cn/store_config/15946220520989wSiZbRA.jpg" alt="img" cr="banner"/>
                    </div>
                </a>
            </div>
            
            <div class="swiper-slide">
                <a class="banner-link" href="#">
                    <div class="img-box">
                        <img class="banner-pic" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAxCAQAAAALxYPPAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkBgsLGTJGwpbsAAAAAW9yTlQBz6J3mgAAACxJREFUWMPtzEENAAAIBCC1f2ft4HY/CEBvZUzoFYvFYrFYLBaLxWKxWCz+OkvmAWHcq1PMAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA2LTExVDExOjI1OjUwKzAwOjAwDrJzIQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNi0xMVQxMToyNTo1MCswMDowMH/vy50AAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC" data-src="//midas.gtimg.cn/store_config/1593587225980YLciUsm2.png" alt="img" cr="banner"/>
                    </div>
                </a>
            </div>
            
            <div class="swiper-slide">
                <a class="banner-link" href="https://www.midasbuy.com/id/shop/hayday">
                    <div class="img-box">
                        <img class="banner-pic" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAxCAQAAAALxYPPAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkBgsLGTJGwpbsAAAAAW9yTlQBz6J3mgAAACxJREFUWMPtzEENAAAIBCC1f2ft4HY/CEBvZUzoFYvFYrFYLBaLxWKxWCz+OkvmAWHcq1PMAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA2LTExVDExOjI1OjUwKzAwOjAwDrJzIQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNi0xMVQxMToyNTo1MCswMDowMH/vy50AAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC" data-src="//midas.gtimg.cn/store_config/1588162050420ZJjuXQL3.png" alt="img" cr="banner"/>
                    </div>
                </a>
            </div>
            
            <div class="swiper-slide">
                <a class="banner-link" href="https://www.midasbuy.com/id/event/register/pubgm?from=__mds_buy_banner&amp;lan=id">
                    <div class="img-box">
                        <img class="banner-pic" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAxCAQAAAALxYPPAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkBgsLGTJGwpbsAAAAAW9yTlQBz6J3mgAAACxJREFUWMPtzEENAAAIBCC1f2ft4HY/CEBvZUzoFYvFYrFYLBaLxWKxWCz+OkvmAWHcq1PMAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA2LTExVDExOjI1OjUwKzAwOjAwDrJzIQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNi0xMVQxMToyNTo1MCswMDowMH/vy50AAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC" data-src="//midas.gtimg.cn/oversea_web/events/register/images/ID.jpg" alt="img" cr="banner"/>
                    </div>
                </a>
            </div>
            
            <div class="swiper-slide">
                <a class="banner-link" href="/id/pubgm">
                    <div class="img-box">
                        <img class="banner-pic" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAxCAQAAAALxYPPAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkBgsLGTJGwpbsAAAAAW9yTlQBz6J3mgAAACxJREFUWMPtzEENAAAIBCC1f2ft4HY/CEBvZUzoFYvFYrFYLBaLxWKxWCz+OkvmAWHcq1PMAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA2LTExVDExOjI1OjUwKzAwOjAwDrJzIQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNi0xMVQxMToyNTo1MCswMDowMH/vy50AAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC" data-src="//midas.gtimg.cn/oversea_web/PUBGM_index_banner.png" alt="img" cr="banner"/>
                    </div>
                </a>
            </div>
            
            <div class="swiper-slide">
                <a class="banner-link" href="/id/pubgmlite">
                    <div class="img-box">
                        <img class="banner-pic" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAxCAQAAAALxYPPAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkBgsLGTJGwpbsAAAAAW9yTlQBz6J3mgAAACxJREFUWMPtzEENAAAIBCC1f2ft4HY/CEBvZUzoFYvFYrFYLBaLxWKxWCz+OkvmAWHcq1PMAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA2LTExVDExOjI1OjUwKzAwOjAwDrJzIQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNi0xMVQxMToyNTo1MCswMDowMH/vy50AAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC" data-src="//midas.gtimg.cn/oversea_web/pubg_lite_banner.jpg" alt="img" cr="banner"/>
                    </div>
                </a>
            </div>
             
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-prev swiper-button-white" cr="banner_left"></div>
        <div class="swiper-button-next swiper-button-white" cr="banner_right"></div>
        <img class="mc l-mc" src="//midas.gtimg.cn/midasbuy/banner/mc-left.png" alt="img" />
        <img class="mc r-mc" src="//midas.gtimg.cn/midasbuy/banner/mc-right.png" alt="img" />
    </div>
    
</div>

<script type="application/javascript">
    window.onload = function() {
        // NodeList
        if (window.NodeList && !NodeList.prototype.forEach) {
            NodeList.prototype.forEach = Array.prototype.forEach;
        }
        
        // banner
        var bannerImg = [{"end":"2020-08-12 00:00:00","href":"/midasbuy/id/buy/pubgm","id":"1596005029754016293169417183107","start":"2020-07-29 14:43:09","title":"razer 充值赠送","url":"//midas.gtimg.cn/store_config/1596005262769x99sUQGs.jpg"},{"end":"2020-08-10 00:00:00","href":"https://www.midasbuy.com/midasbuy/id/event/invite/pubgm?lan=id&from=__mds_buy_invite","id":"15954174500690614672439554363","start":"2020-07-23 11:00:00","title":"东南亚好友返利","url":"//midas.gtimg.cn/store_config/1595572784048M2sLGFmC.jpg"},{"end":"2020-09-14 08:00:00","href":"https://www.midasbuy.com/midasbuy/id/props_order/pubgm?pid=S14_RP_Upgrade_Card_Package","id":"15946222019590313434312253164","start":"2020-07-14 10:30:00","title":"S14RPCARD","url":"//midas.gtimg.cn/store_config/15946220520989wSiZbRA.jpg"},{"end":"2023-07-03 00:00:00","href":"#","id":"159367672676609325820382453887","start":"2020-07-02 15:58:34","title":"CHESS RUSH 常态banner","url":"//midas.gtimg.cn/store_config/1593587225980YLciUsm2.png"},{"end":"2025-04-18 20:10:10","href":"https://www.midasbuy.com/id/shop/hayday","id":"09704551568515438","start":"2020-04-29 20:20:00","title":"Hayday常态广告","url":"//midas.gtimg.cn/store_config/1588162050420ZJjuXQL3.png"},{"end":"2020-08-31 23:59:59","href":"https://www.midasbuy.com/id/event/register/pubgm?from=__mds_buy_banner&lan=id","id":"05682623777829938","start":"2020-04-14 00:00:00","title":"注册赠送","url":"//midas.gtimg.cn/oversea_web/events/register/images/ID.jpg"},{"end":"2025-01-01 00:00:00","href":"/id/pubgm","id":"068873608270357","start":"2019-01-01 00:00:00","title":"PUBG Mobile","url":"//midas.gtimg.cn/oversea_web/PUBGM_index_banner.png"},{"end":"2025-01-01 00:00:00","href":"/id/pubgmlite","id":"007021179796768173","start":"2019-01-01 00:00:00","title":"PUBG Mobile Lite","url":"//midas.gtimg.cn/oversea_web/pubg_lite_banner.jpg"}];        
        var imgEL = document.querySelectorAll('.banner-pic');

        imgEL.forEach(function(item) {
            var src = item.getAttribute('data-src');
            item.src = src;
        })
    }
</script>

<div class="content">
    <div class="main">
        
        <div class="section hot-game">
            <div class="title-box">
                <h2>Game Populer</h2>
            </div>

            <div class="list-box">
                <ul>
                    @foreach ($products as $pro)
                    <li class="list">
                        <a href="{{$pro->slug}}">
                            <div class="type-label" limit="12">{{$pro->name}}</div>
                            <div class="pic">
                                <img src="{{url('storage')}}/{{$pro->thumbnail}}" alt="img"/>
                            </div>
                            <div class="mask"></div>                     
                           <span class="btn">GO</span>
                       </a>
                   </li>
                   @endforeach
               </ul>
           </div>
       </div>
       
       
   </div>
</div>
<div class="footer" style=" background: rgba(20,27,61,1);">
    <div class="main">
        <div class="t" style="text-align: center;">
                <div class="box">
                    <p class="p">
                        Untuk layanan pelanggan, harap kirim email ke help@email.com<br>
                        <a href="#" target="_blank"> Persyaratan Layanan</a> | <a href="#" target="_blank"> Kebijakan Privasi</a><br>
                    </p>
                    <br>
                    <p class="p">Copyright &copy; 2020 {{ENV('APP_NAME')}}. All Rights Reserved.</p>
                </div>
        </div>
    </div>
</div>

</div>

</body>
</html>