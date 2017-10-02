<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @yield('header')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="/css/slider.css" rel="stylesheet" type="text/css" media="all"/>
    <script type="text/javascript" src="/js/App.js"></script> 
    <script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> 
    <script type="text/javascript" src="/js/move-top.js"></script>
    <script type="text/javascript" src="/js/easing.js"></script>
    <script type="text/javascript" src="/js/startstop-slider.js"></script>
    <script type="text/javascript" src="/js/master.js"></script>
    @yield('scripts')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- LET'S CHECK IF WE ARE IN A MOBILE -->
    <?php
        // THIS IS THE MENU'S FONT SIZE FOR A DESKTOP
        $menuFontSize = 'font-size:0.823em';
        $aMobileUA = array(
                '/iphone/i' => 'iPhone', 
                '/ipod/i' => 'iPod', 
                '/ipad/i' => 'iPad', 
                '/android/i' => 'Android', 
                '/blackberry/i' => 'BlackBerry', 
                '/webos/i' => 'Mobile'
            );

        //Return true if Mobile User Agent is detected
        foreach($aMobileUA as $sMobileKey => $sMobileOS){
            if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
                // THIS IS THE MENU FONT SIZE FOR A MOBILE DEVICE
                $menuFontSize = 'font-size:0.323em';
            }
        }
    ?>
    <div class="wrap">
        <div class="header">
            <div class="headertop_desc">
                <div class="call">
                     <p><span>@lang('master.needhelp')</span> @lang('master.callus') <span class="number">+58-261-7526671</span></p>
                </div>
                <div style="{{$menuFontSize}};" class="account_desc">
                    <ul>
                        <li><a href="/#">@lang('master.delivery')</a></li>
                        <li><a href="/#">@lang('master.checkout')</a></li>
                        <li><a href="/#">@lang('master.myaccount')</a></li>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="{{ route('login') }}">@lang('master.login')</a></li>
                        <li><a href="{{ route('register') }}">@lang('master.register')</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <?php
                            use App\Languages;
                            use Illuminate\Support\Facades\App;
                            $languages = (new Languages())->all();
                            if(!session()->has('lang'))
                            {
                                session(['lang' => App::getLocale()]);
                            }
                            $lang = App::getLocale();
                            $selectedLang = 0;
                            foreach ($languages as $key => $value) {
                                # code...
                                if($lang == $value->lang)
                                {
                                    $selectedLang = $key;
                                }
                            }
                        ?>
                        <select style="border: none; font-style: italic;" id="langdropdown" onchange="langchange(this)">
                            @foreach($languages as $key => $language) 
                            <option value="{{$language->lang}}">{{$language->description}}</option>
                            @endforeach
                        </select>
                        <script type="text/javascript">
                            document.getElementById('langdropdown').selectedIndex = {{$selectedLang}};
                        </script>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="header_top">
                <div class="logo">
                    <a href="/"><img src="/images/logo.png" alt="" /></a>
                </div>
                  <div class="cart">
                       <p>@lang('master.welcometoourstore') <span>@lang('master.cart'):</span><div id="dd" class="wrapper-dropdown-2"> @lang('master.itemsincart')
                        <ul class="dropdown">
                                <li>@lang('master.havenoitems')</li>
                        </ul></div></p>
                  </div>
                  <script type="text/javascript">

                        function DropDown(el) {
                            this.dd = el;
                            this.initEvents();
                        }
                        DropDown.prototype = {
                            initEvents : function() {
                                var obj = this;

                                obj.dd.on('click', function(event){
                                    $(this).toggleClass('active');
                                    event.stopPropagation();
                                }); 
                            }
                        }

                        $(function() {

                            var dd = new DropDown( $('#dd') );

                            $(document).click(function() {
                                // all dropdowns
                                $('.wrapper-dropdown-2').removeClass('active');
                            });

                        });
                    </script>
                <div class="clear"></div>
            </div>
            <div class="header_bottom">
                <div style="{{$menuFontSize}};" class="menu">
                    <ul class="nav-link">
                        <li id="li_Home_Tab"><a href="/">@lang('master.home')</a></li>
                        <li id="li_About_Tab"><a href="/about">@lang('master.about')</a></li>
                        <li id="li_Delivery_Tab"><a href="/delivery">@lang('master.delivery')</a></li>
                        <li id="li_News_Tab"><a href="/news">@lang('master.news')</a></li>
                        <li id="li_Contact_Tab"><a href="/contact">@lang('master.contact')</a></li>
                    <div class="clear"></div>
                    </ul>
                </div>
                <div class="search_box">
                    <form>
                        <input type="text" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}"><input type="submit" value="">
                    </form>
                </div>
                <div class="clear"></div>
            </div>
            @yield('additional_header')
        </div>
        @yield('main')
    </div>
    <div class="footer">
        <div class="wrap">  
            <div class="section group">
                <div class="col_1_of_4 span_1_of_4">
                    <h4>@lang('master.information')</h4>
                    <ul>
                        <li><a href="/about">@lang('master.aboutus')</a></li>
                        <li><a href="/contact">@lang('master.customerservice')</a></li>
                        <li><a href="/#">@lang('master.advancesearch')</a></li>
                        <li><a href="/delivery">@lang('master.ordersandreturns')</a></li>
                        <li><a href="/contact">@lang('master.contactus')</a></li>
                    </ul>
                </div>
                <div class="col_1_of_4 span_1_of_4">
                    <h4>@lang('master.whybuyfromus')</h4>
                    <ul>
                        <li><a href="/about">@lang('master.aboutus')</a></li>
                        <li><a href="/contact">@lang('master.customerservice')</a></li>
                        <li><a href="/#">@lang('master.privacypolicy')</a></li>
                        <li><a href="/contact">@lang('master.sitemap')</a></li>
                        <li><a href="/#">@lang('master.searchterms')</a></li>
                    </ul>
                </div>
                <div class="col_1_of_4 span_1_of_4">
                    <h4>@lang('master.myaccount')</h4>
                        <ul>
                            <li><a href="/login">@lang('master.signin')</a></li>
                            <li><a href="/">@lang('master.viewcart')</a></li>
                            <li><a href="/#">@lang('master.mywishlist')</a></li>
                            <li><a href="/#">@lang('master.trackmyorder')</a></li>
                            <li><a href="/contact">@lang('master.help')</a></li>
                        </ul>
                </div>
                <div class="col_1_of_4 span_1_of_4">
                    <h4>@lang('master.contact')</h4>
                    <ul>
                        <li><span>+58-261-7526671</span></li>
                        <li><span>+58-261-7830528</span></li>
                    </ul>
                    <div class="social-icons">
                        <h4>@lang('master.followus')</h4>
                        <ul>
                            <li><a href="/#" target="_blank"><img src="/images/facebook.png" alt="" /></a></li>
                            <li><a href="/#" target="_blank"><img src="/images/twitter.png" alt="" /></a></li>
                            <li><a href="/#" target="_blank"><img src="/images/skype.png" alt="" /> </a></li>
                            <li><a href="/#" target="_blank"> <img src="/images/dribbble.png" alt="" /></a></li>
                            <li><a href="/#" target="_blank"> <img src="/images/linkedin.png" alt="" /></a></li>
                            <div class="clear"></div>
                        </ul>
                        </div>
                </div>
            </div>          
        </div>
        <div class="copy_right">
            <p>Company Name © All rights Reseverd | Design by  <a href="/http://w3layouts.com">W3Layouts</a> </p>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {          
            $().UItoTop({ easingType: 'easeOutQuart' });
            $('#li_' + $('title').attr('id')).addClass('active');
        });
    </script>

    <!-- Scripts -->
    <a href="/#" id="toTop"><span id="toTopHover"> </span></a>
</body>
</html>
