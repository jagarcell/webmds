@extends('layouts.master')
@section('header')
<title id="Home_Tab">
{{$groups[0]->groupsdescriptions[0]->description}}
</title>
@endsection

@section('scripts')
<script type="text/javascript" src="/js/products.js"></script>
@endsection

@section('main')
    <div class="main">
        <div class="content" id="products">
            <div class="content_top">
                <div class="heading">
                    <h3 id="h_groupvar">{{$groups[0]->groupsdescriptions[0]->description}}</h3>
                </div>
                <div class="see">
                    <p><a href="/#">@lang('products.seeallproducts')</a></p>
                </div>
                <div class="clear"></div>
                <?php
                    // $gridColumns DEFINES THE NUMBER OF PRODUCTS TO SHOW IN A ROW
                    $gridColumns = 4;

                    // WE CHUNK THE PRODUCT ARRAY IN N ROWS OF $gridColumns ELEMENTS PER ROW

                    $prods = array_chunk($prods, $gridColumns);

                ?>
                <!-- LETS LOOP THROUGH THE PRODUCTS ROWS -->
                @foreach($prods as $prodIndex => $product)
                <!-- EACH ROW IS A GROUP -->
                <div class="section group">
                    <!-- LETS LOOP THROUGH THE PRODUCTS IN A ROW (GROUP) -->
                    @foreach($product as $k => $p)
                    <?php
                        // TO CALCULATE THE LEFT MARGIN WE TAKE THE NUMBER OF ELEMENTS
                        // PRESENT IN THE ROW ( count($product)) AND SUBSTRACT IT FROM THE NUMBER
                        // OF COLUMNS IN A ROW ($gridColumns) AND MULTIPLY IT BY THE %
                        // OF MARGIN TO BE LEFT ACCORDING TO THE ELEMENTS PRESENT 
                        $marginLeft = (100/$gridColumns/2) * ($gridColumns - count($product)) + 4.8;
                     ?>
                    @if ($loop->first)
                    <!-- IF WE ARE DISPLAYING THE FIRST PRODUCT OF THE ROW THEN WE  
                          APPLY THE ROW'S LEFT MARGIN TO THE ELEMENT -->
                    <div style="margin-left: {{$marginLeft}}%;" class="grid_1_of_4 images_1_of_4">
                        <a href="/preview"><img src="/images/{{$products[$prodIndex*$gridColumns+$k]['image']}}" alt="" /></a>
                        <h2>{{$p}}</h2>
                        <div class="price-details">
                            <div class="price-number">
                                <p><span class="rupees"><!--$620.87--></span></p>
                            </div>
                            <div class="add-cart">                              
                                <h4><a href="/preview">@lang('products.addtocart')</a></h4>
                             </div>
                             <div class="clear"></div>
                        </div>
                    </div>
                    @else
                    <!-- IF THIS IS NOT THE FIRST ELEMENT OF THE ROW WE DON'T APPLY LEFT MARGIN -->
                    <div class="grid_1_of_4 images_1_of_4">
                        <a href="/preview"><img src="/images/{{$products[$prodIndex*$gridColumns+$k]['image']}}" alt="" /></a>
                        <h2>{{$p}}</h2>
                        <div class="price-details">
                            <div class="price-number">
                                <p><span class="rupees"><!--$620.87--></span></p>
                            </div>
                            <div class="add-cart">                              
                                <h4><a href="/preview">@lang('products.addtocart')</a></h4>
                             </div>
                             <div class="clear"></div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
