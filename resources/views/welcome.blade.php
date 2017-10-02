@extends('layouts.master')

@section('header')
<title id="Home_Tab">Home</title>
@endsection
@section('scripts')
<script type="text/javascript" src="/js/welcome.js"></script>
@endsection

@section('additional_header')

    <div class="header_slide">
        <!-- LET'S CHECK IF WE ARE IN  A MOBILE DEVICE -->
        <?php
            // THIS IS THE CATEGORIES MENU HEIGHT FOR A DESKTOP DEVICE
            $catHeight = '24em';
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
                    // THIS IS THE CATGORIES MENU HEIGHT FRO A MOBILE DEVICE
                    $catHeight = '4em';
                    if($sMobileKey == '/ipad/i')
                    {
                        $catHeight = '24em';
                    }
                }
            }
        ?>
        <div class="header_bottom_left">                
            <div class="categories">
              <ul>
                <h3>@lang('welcome.categories')</h3>
                    <div id="categories_div"  style="height: {{$catHeight}}; overflow: auto;"">
                    @foreach($groups as $key => $group)
                        <li><a href="/products/{{$group->groupid}}">{{$group->groupsdescriptions[0]->description}}</a></li>
                    @endforeach
                    </div>
              </ul>
            </div>
        </div>
        <div class="header_bottom_right">                    
            <div class="slider">                         
                <div id="slider">
                    <div id="mover">
                        <div id="slide-1" class="slide">                                
                            <div class="slider-img">
                                <a href="/preview"><img src="/images/{{$slideproducts[0]->image}}" alt="learn more" /></a>
                            </div>
                            <div class="slider-text">
                                <h1>@lang('welcome.clearance')<br><span>@lang('welcome.sale')</span></h1>
                                <h2>@lang('welcome.discount1') {{$slideproducts[0]->discount}}% @lang('welcome.discount2')</h2>
                                <div class="features_list">
                                    <h4>{{$slideproducts[0]->productsdescriptions[0]->description}}</h4>
                                </div>
                                <a href="/preview" class="button">@lang('welcome.shopnow')</a>
                            </div>                         
                            <div class="clear"></div>               
                        </div>  
                        <div class="slide">
                            <div class="slider-text">
                                <h1>@lang('welcome.clearance')<br><span>@lang('welcome.sale')</span></h1>
                                <h2>@lang('welcome.discount1') {{$slideproducts[1]->discount}}% @lang('welcome.discount2')</h2>
                                <div class="features_list">
                                    <h4>{{$slideproducts[1]->productsdescriptions[0]->description}}</h4>           
                                </div>
                                <a href="/preview" class="button">@lang('welcome.shopnow')</a>
                            </div>      
                            <div class="slider-img">
                                <a href="/preview"><img src="/images/{{$slideproducts[1]->image}}" alt="learn more" /></a>
                            </div>                                                                       
                            <div class="clear"></div>               
                        </div>
                        <div class="slide">                                     
                            <div class="slider-img">
                                <a href="/preview"><img src="/images/{{$slideproducts[2]->image}}" alt="learn more" /></a>
                            </div>
                            <div class="slider-text">
                                <h1>@lang('welcome.clearance')<br><span>@lang('welcome.sale')</span></h1>
                                <h2>@lang('welcome.discount1') {{$slideproducts[2]->discount}}% @lang('welcome.discount2')</h2>
                                <div class="features_list">
                                    <h4>{{$slideproducts[2]->productsdescriptions[0]->description}}</h4>                                        
                                </div>
                                <a href="/preview" class="button">@lang('welcome.shopnow')</a>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
@endsection
@section('main')
    <div class="main">
        <div class="content">
            <div class="content_top">
                <div class="heading">
                    <h3>@lang('welcome.newproducts')</h3>
                </div>
                <div class="see">
                    <p><a href="/#">@lang('welcome.seeallproducts')</a></p>
                </div>
                <div class="clear"></div>
            </div>
            <div class="section group">
                <div class="grid_1_of_4 images_1_of_4">
                    <a href="/preview"><img src="/images/{{$newproducts[0]['image']}}" alt="" /></a>
                    <h2>{{$newproducts[0]['productsdescriptions'][0]['description']}} </h2>
                    <div class="price-details">
                        <div class="price-number">
                            <p><span class="rupees"><!--$620.87--></span></p>
                        </div>
                        <div class="add-cart">                              
                            <h4><a href="/preview">@lang('welcome.addtocart')</a></h4>
                         </div>
                         <div class="clear"></div>
                    </div>
                 
                </div>
                <div class="grid_1_of_4 images_1_of_4">
                    <a href="/preview"><img  src="/images/{{$newproducts[1]['image']}}" alt="" /></a>
                    <h2>{{$newproducts[1]['productsdescriptions'][0]['description']}}</h2>
                    <div class="price-details">
                        <div class="price-number">
                            <p><span class="rupees"><!--$899.75--></span></p>
                        </div>
                            <div class="add-cart">                              
                                <h4><a href="/preview">@lang('welcome.addtocart')</a></h4>
                            </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="grid_1_of_4 images_1_of_4">
                    <a href="/preview"><img src="/images/{{$newproducts[2]['image']}}" alt="" /></a>
                    <h2>{{$newproducts[2]['productsdescriptions'][0]['description']}}</h2>
                    <div class="price-details">
                        <div class="price-number">
                            <p><span class="rupees"><!--$599.00--></span></p>
                        </div>
                        <div class="add-cart">                              
                            <h4><a href="/preview">@lang('welcome.addtocart')</a></h4>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="grid_1_of_4 images_1_of_4">
                    <a href="/preview"><img src="/images/{{$newproducts[3]['image']}}" alt="" /></a>
                    <h2>{{$newproducts[3]['productsdescriptions'][0]['description']}}</h2>
                    <div class="price-details">
                        <div class="price-number">
                            <p><span class="rupees"><!--$679.87--></span></p>
                        </div>
                            <div class="add-cart">                              
                                <h4><a href="/preview">@lang('welcome.addtocart')</a></h4>
                            </div>
                        <div class="clear"></div>
                    </div>                   
                </div>
            </div>
            <div class="content_bottom">
                <div class="heading">
                    <h3>@lang('welcome.featureproducts')</h3>
                </div>
                <div class="see">
                    <p><a href="/#">@lang('welcome.seeallproducts')</a></p>
                </div>
                <div class="clear"></div>
            </div>
            <div class="section group">
                <div style="margin-left: 0%;" class="grid_1_of_4 images_1_of_4">
                    <a href="/preview"><img src="/images/{{$featureproducts[0]['image']}}" alt="" /></a>                 
                    <h2>{{$featureproducts[0]['productsdescriptions'][0]['description']}} </h2>
                    <div class="price-details">
                        <div class="price-number">
                            <p><span class="rupees"><!--$849.99--></span></p>
                        </div>
                        <div class="add-cart">                              
                            <h4><a href="/preview">@lang('welcome.addtocart')</a></h4>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div style="margin-left: 0%;" class="grid_1_of_4 images_1_of_4">
                    <a href="/preview"><img src="/images/{{$featureproducts[1]['image']}}" alt="" /></a>
                    <h2>{{$featureproducts[1]['productsdescriptions'][0]['description']}} </h2>
                    <div class="price-details">
                        <div class="price-number">
                            <p><span class="rupees"><!--$599.99--></span></p>
                        </div>
                        <div class="add-cart">                              
                            <h4><a href="/preview">@lang('welcome.addtocart')</a></h4>
                         </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div style="margin-left: 0%;" class="grid_1_of_4 images_1_of_4">
                    <a href="/preview"><img src="/images/{{$featureproducts[2]['image']}}" alt="" /></a>
                    <h2>{{$featureproducts[2]['productsdescriptions'][0]['description']}} </h2>
                    <div class="price-details">
                        <div class="price-number">
                            <p><span class="rupees"><!--$799.99--></span></p>
                        </div>
                        <div class="add-cart">                              
                            <h4><a href="/preview">@lang('welcome.addtocart')</a></h4>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div style="margin-left: 0%;" class="grid_1_of_4 images_1_of_4">
                    <a href="/preview"><img src="/images/{{$featureproducts[3]['image']}}" alt="" /></a>
                    <h2>{{$featureproducts[3]['productsdescriptions'][0]['description']}} </h2>                  
                    <div class="price-details">
                        <div class="price-number">
                            <p><span class="rupees"><!--$899.99--></span></p>
                        </div>
                        <div class="add-cart">                              
                            <h4><a href="/preview">@lang('welcome.addtocart')</a></h4>
                         </div>
                         <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
