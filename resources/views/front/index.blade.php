@extends('layouts.app')


@section('content')
    @isset($banner)
        <div class="ps-banner">
            <div class="rev_slider fullscreenbanner" id="home-banner">
            <ul>
                @foreach($banner as $banner_info)
                    <li class="ps-banner" data-index="rs-{{ $banner_info->id}}" data-transition="random" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-rotate="0">
                        <img class="rev-slidebg" src="{{ asset('Uploads/Banner/'.$banner_info->image) }}" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="5" data-no-retina>
                    <div class="tp-caption ps-banner__header" id="layer-1" data-x="left" data-hoffset="['-60','15','15','15']" data-y="['middle','middle','middle','middle']" data-voffset="['-150','-120','-150','-170']" data-width="['none','none','none','400']" data-type="text" data-responsive_offset="on" data-frames="[{&quot;delay&quot;:1000,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;x:50px;opacity:0;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:300,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;x:50px;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]">
                        <p>{{ date('F,d,Y',strtotime($banner_info->updated_at))}} <br> {{ ucfirst($banner_info->title)}}</p>
                    </div>
                    <div class="tp-caption ps-banner__description" id="layer211" data-x="['left','left','left','left']" data-hoffset="['-60','15','15','15']" data-y="['middle','middle','middle','middle']" data-voffset="['30','50','50','50']" data-type="text" data-responsive_offset="on" data-textAlign="['center','center','center','center']" data-frames="[{&quot;delay&quot;:1200,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;x:50px;opacity:0;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:300,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;x:50px;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]">
                    </div>
                    <a class="tp-caption ps-btn" id="layer31" href="{{ $banner_info->link}}" data-x="['left','left','left','left']" data-hoffset="['-60','15','15','15']" data-y="['middle','middle','middle','middle']" data-voffset="['120','140','200','200']" data-type="text" data-responsive_offset="on" data-textAlign="['center','center','center','center']" data-frames="[{&quot;delay&quot;:1500,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;x:50px;opacity:0;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:300,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;x:50px;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]">
                        Purchase Now<i class="ps-icon-next"></i>
                    </a>
                    </li>
                @endforeach
            </ul>
            </div>
        </div>
    @endisset

    @isset($is_featured)
        <div class="ps-section--features-product ps-section masonry-root pt-100 pb-100">
            <div class="ps-container">
            <div class="ps-section__header mb-50">
                <h3 class="ps-section__title" data-mask="features">- Features Products</h3>
                <ul class="ps-masonry__filter">
                <li class="current"><a href="#" data-filter="*">All <sup>8</sup></a></li>
                <li><a href="#" data-filter=".nike">Nike <sup>1</sup></a></li>
                <li><a href="#" data-filter=".adidas">Adidas <sup>1</sup></a></li>
                <li><a href="#" data-filter=".men">Men <sup>1</sup></a></li>
                <li><a href="#" data-filter=".women">Women <sup>1</sup></a></li>
                <li><a href="#" data-filter=".kids">Kids <sup>4</sup></a></li>
                </ul>
            </div>
            <div class="ps-section__content pb-50">
                <div class="masonry-wrapper" data-col-md="4" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
                <div class="ps-masonry">
                    <div class="grid-sizer"></div>
                    @foreach($is_featured as $product)
                        <div class="grid-item kids">
                        <div class="grid-item__content-wrapper">
                            <div class="ps-shoe mb-30">
                            <div class="ps-shoe__thumbnail">
                        <div class="ps-badge">
                                <span>New</span>
                            </div>
                            @if($product->discount && $product->discount !=null)
                            <div class="ps-badge ps-badge--sale ps-badge--2nd">
                                <span>-{{$product->discount}}%</span>
                            </div>
                            @endif
                            @if($product->getProductImage && $product->getProductImage->count() >0)
                            <img src="{{ asset('Uploads/Product/'.$product->getProductImage[0]->image_name) }}" alt=""><a class="ps-shoe__overlay" href="{{route('product-detail',$product->slug) }}">
                            @endif
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                            @if($product->getProductImage && $product->getProductImage->count() >0)
                            <div class="ps-shoe__variant normal">
                                @foreach($product->getProductImage as $image)
                                    <img src="{{ asset('Uploads/Product/'.$image->image_name) }}" alt="">
                                @endforeach
                            </div>
                            @endif
                            </div>
                            <div class="ps-shoe__detail">
                                <a class="ps-shoe__name" href="{{ route('product-detail',$product->slug) }}">{{ ucfirst($product->title) }}</a>
                            @if($product->getBrand && $product->getBrand->count() >0)
                            <p class="ps-shoe__categories">
                                @foreach($product->getBrand as $brand)
                                    <a href="#">{{ $brand->title}}</a>,
                                @endforeach
                            </p>
                            @endif
                            <span class="ps-shoe__price mt-15">
                                @if($product->discount && $product->discount !=null)
                                <del>{{ $product->price}}</del>
                                @endif
                                NPR. {{$product->actual_price}}
                            </span>
                            </div>
                        </div>
                            </div>
                        </div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>
            </div>
        </div>
    @endisset

    @isset($promotion)
        <div class="ps-section--offer">
            @foreach($promotion as $promotion_info)
                <div class="ps-column">
                    <a class="ps-offer" href="{{ $promotion_info->link}}">
                        <img src="{{ asset('Uploads/Promotion/'.$promotion_info->image) }}" alt="">
                    </a>
                </div>
            @endforeach
        </div>
    @endisset

        <div class="ps-section--sale-off ps-section pt-80 pb-40">
            <div class="ps-container">
            <div class="ps-section__header mb-50">
                <h3 class="ps-section__title" data-mask="Sale off">- Hot Deal Today</h3>
            </div>
            <div class="ps-section__content">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
                        <div class="ps-hot-deal">
                        <h3>Nike DUNK Max 95 OG</h3>
                        <p class="ps-hot-deal__price">Only:  <span>£155</span></p>
                        <ul class="ps-countdown" data-time="December 13, 2017 15:37:25">
                            <li><span class="hours"></span><p>Hours</p></li>
                            <li class="divider">:</li>
                            <li><span class="minutes"></span><p>minutes</p></li>
                            <li class="divider">:</li>
                            <li><span class="seconds"></span><p>Seconds</p></li>
                        </ul><a class="ps-btn" href="#">Order Today<i class="ps-icon-next"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
                        <div class="ps-hotspot"><a class="point first active" href="javascript:;"><i class="fa fa-plus"></i>
                            <div class="ps-hotspot__content">
                            <p class="heading">JUMP TO HEADER</p>
                            <p>Dynamic Fit Collar en la zona del tobillo que une la parte inferior de la pierna y el pie sin reducir la libertad de movimiento.</p>
                            </div></a><a class="point second" href="javascript:;"><i class="fa fa-plus"></i>
                            <div class="ps-hotspot__content">
                            <p class="heading">JUMP TO HEADER</p>
                            <p>Dynamic Fit Collar en la zona del tobillo que une la parte inferior de la pierna y el pie sin reducir la libertad de movimiento.</p>
                            </div></a><a class="point third" href="javascript:;"><i class="fa fa-plus"></i>
                            <div class="ps-hotspot__content">
                            <p class="heading">JUMP TO HEADER</p>
                            <p>Dynamic Fit Collar en la zona del tobillo que une la parte inferior de la pierna y el pie sin reducir la libertad de movimiento.</p>
                            </div></a><img src="{{ asset('frontend/images/hot-deal.png') }}" alt=""></div>
                    </div>
                </div>
            </div>
            </div>
        </div>

    @isset($top_sale)
        <div class="ps-section ps-section--top-sales ps-owl-root pt-80 pb-80">
            <div class="ps-container">
            <div class="ps-section__header mb-50">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                        <h3 class="ps-section__title" data-mask="BEST SALE">- Top Sales</h3>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                        <div class="ps-owl-actions"><a class="ps-prev" href="#"><i class="ps-icon-arrow-right"></i>Prev</a><a class="ps-next" href="#">Next<i class="ps-icon-arrow-left"></i></a></div>
                    </div>
                </div>
            </div>
            <div class="ps-section__content">
                <div class="ps-owl--colection owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="30" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">
                @foreach($top_sale as $product)
                <div class="ps-shoes--carousel">
                    <div class="ps-shoe">
                    <div class="ps-shoe__thumbnail">
                        <div class="ps-badge">
                            <span>New</span>
                        </div>
                        @if($product->discount && $product->discount !=null)
                        <div class="ps-badge ps-badge--sale ps-badge--2nd">
                            <span>-{{$product->discount}}%</span>
                        </div>
                        @endif
                        @if($product->getProductImage && $product->getProductImage->count() >0)
                        <img src="{{ asset('Uploads/Product/'.$product->getProductImage[0]->image_name) }}" alt=""><a class="ps-shoe__overlay" href="{{route('product-detail',$product->slug) }}">
                        @endif
                    </div>
                    <div class="ps-shoe__content">
                        <div class="ps-shoe__variants">
                        @if($product->getProductImage && $product->getProductImage->count() >0)
                        <div class="ps-shoe__variant normal">
                            @foreach($product->getProductImage as $image)
                                <img src="{{ asset('Uploads/Product/'.$image->image_name) }}" alt="">
                            @endforeach
                        </div>
                        @endif
                        </div>
                        <div class="ps-shoe__detail">
                            <a class="ps-shoe__name" href="{{ route('product-detail',$product->slug) }}">{{ ucfirst($product->title) }}</a>
                        @if($product->getBrand && $product->getBrand->count() >0)
                        <p class="ps-shoe__categories">
                            @foreach($product->getBrand as $brand)
                                <a href="#">{{ $brand->title}}</a>,
                            @endforeach
                        </p>
                        @endif
                        <span class="ps-shoe__price mt-15">
                            @if($product->discount && $product->discount !=null)
                            <del>{{ $product->price}}</del>
                            @endif
                            NPR. {{$product->actual_price}}
                        </span>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    @endisset
    
        <!-- <div class="ps-home-testimonial bg--parallax pb-80" data-background="{{ asset('sanu.jpg') }}">
            <div class="container">
            <div class="owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-animate-in="fadeIn" data-owl-animate-out="fadeOut">
                <div class="ps-testimonial">
                <div class="ps-testimonial__thumbnail"><img src="{{ asset('sanu.jpg') }}" alt=""><i class="fa fa-quote-left"></i></div>
                <header>
                    <p>Laravel Developer-Sumit Karn</p>
                </header>
                <footer>
                    <p>“Dessert pudding dessert jelly beans cupcake sweet caramels gingerbread. Fruitcake biscuit cheesecake. Cookie topping sweet muffin pudding tart bear claw sugar plum croissant. “</p>
                </footer>
                </div>
                <div class="ps-testimonial">
                <div class="ps-testimonial__thumbnail"><img src="{{ asset('sanu.jpg') }}" alt=""><i class="fa fa-quote-left"></i></div>
                <header>
                    <p>Laravel Developer-Sumit Karn</p>
                </header>
                <footer>
                    <p>“Dessert pudding dessert jelly beans cupcake sweet caramels gingerbread. Fruitcake biscuit cheesecake. Cookie topping sweet muffin pudding tart bear claw sugar plum croissant. “</p>
                </footer>
                </div>
            </div>
            </div>
        </div> -->

    @isset($all_product)
        <div class="ps-section--features-product ps-section masonry-root pt-100 pb-100">
            <div class="ps-container">
            <div class="ps-section__header mb-50">
                <h3 class="ps-section__title" data-mask="features">-Products</h3>
            </div>
            <div class="ps-section__content pb-50">
                <div class="masonry-wrapper" data-col-md="4" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
                <div class="ps-masonry">
                    <div class="grid-sizer"></div>
                    @foreach($all_product as $product)
                    <div class="grid-item kids">
                    <div class="grid-item__content-wrapper">
                        <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail">
                        <div class="ps-badge">
                            <span>New</span>
                        </div>
                        @if($product->discount && $product->discount !=null)
                        <div class="ps-badge ps-badge--sale ps-badge--2nd">
                            <span>-{{$product->discount}}%</span>
                        </div>
                        @endif
                        @if($product->getProductImage && $product->getProductImage->count() >0)
                        <img src="{{ asset('Uploads/Product/'.$product->getProductImage[0]->image_name) }}" alt=""><a class="ps-shoe__overlay" href="{{route('product-detail',$product->slug) }}">
                        @endif
                    </div>
                    <div class="ps-shoe__content">
                        <div class="ps-shoe__variants">
                        @if($product->getProductImage && $product->getProductImage->count() >0)
                        <div class="ps-shoe__variant normal">
                            @foreach($product->getProductImage as $image)
                                <img src="{{ asset('Uploads/Product/'.$image->image_name) }}" alt="">
                            @endforeach
                        </div>
                        @endif
                        </div>
                        <div class="ps-shoe__detail">
                            <a class="ps-shoe__name" href="{{ route('product-detail',$product->slug) }}">{{ ucfirst($product->title) }}</a>
                        @if($product->getBrand && $product->getBrand->count() >0)
                        <p class="ps-shoe__categories">
                            @foreach($product->getBrand as $brand)
                                <a href="#">{{ $brand->title}}</a>,
                            @endforeach
                        </p>
                        @endif
                        <span class="ps-shoe__price mt-15">
                            @if($product->discount && $product->discount !=null)
                            <del>{{ $product->price}}</del>
                            @endif
                            NPR. {{$product->actual_price}}
                        </span>
                        </div>
                    </div>
                        </div>
                    </div>
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
            </div>
        </div>
    @endisset
@endsection