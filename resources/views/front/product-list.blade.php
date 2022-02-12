@extends('layouts.app')

@section('content')


    <main class="ps-main">
      <div class="ps-products-wrap pt-80 pb-80">
        <div class="ps-products" data-mh="product-listing">
          <div class="ps-product-action">
          </div>
          <div class="ps-product__columns">
            @if($product->count() >0)
                @foreach($product as $product)
                    <div class="ps-product__column">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail">
                        @if($product->discount && $product->discount !=null)
                        <div class="ps-badge ps-badge--sale">
                            <span>-{{ $product->discount}}%</span>
                        </div>
                        @endif
                        @if($product->getProductImage && $product->getProductImage->count() >0)
                        <img src="{{ asset('Uploads/Product/'.$product->getProductImage[0]->image_name) }}" alt=""><a class="ps-shoe__overlay" href="{{ route('product-detail',$product->slug) }}"></a>
                        @endif
                        </div>
                        <div class="ps-shoe__content">
                        <div class="ps-shoe__variants">
                        @if($product->getProductImage && $product->getProductImage->count() >0)
                            <div class="ps-shoe__variant normal">
                                @foreach($product->getProductImage as $image)
                                <a href="{{ route('product-detail',$product->slug) }}"><img src="{{ asset('Uploads/Product/'.$image->image_name) }}" alt=""></a>
                                @endforeach
                            </div>
                        @endif
                        </div>
                        <div class="ps-shoe__detail">
                            <a class="ps-shoe__name" href="{{ route('product-detail',$product->slug) }}">{{ ucfirst($product->title)}}</a>
                            @if($product->getBrand && $product->getBrand->count() >0)
                            <p class="ps-shoe__categories">
                                @foreach($product->getBrand as $brand)
                                <a href="#">{{ $brand->title}}</a>,
                                @endforeach
                            </p>
                            @endif
                            <span class="ps-shoe__price mt-35">
                            @if($product->discount && $product->discount !=null)
                            <del>{{ $product->price}}</del>
                            @endif
                            NPR. {{ $product->actual_price}}
                            </span>
                        </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            @else
                <div class="ps-product__column">
                    <p class="text-danger"><strong>Sorry! No Product Avialable For This Category</strong></p>
                </div>
            @endif
          </div>
          <div class="ps-product-action">
          </div>
        </div>
        <div class="ps-sidebar" data-mh="product-listing">
            @isset($category)
                <aside class="ps-widget--sidebar ps-widget--category">
                    <div class="ps-widget__header">
                    <h3>Category</h3>
                    </div>
                    <div class="ps-widget__content">
                    <ul class="ps-list--checked">
                        @foreach($category as $cat_info)
                            <li class="{{ $cat_info->slug==request()->pslug ?'current':''}}"><a href="{{ route('parent-list',$cat_info->slug)}}">{{ $cat_info->title}}({{ $cat_info->getProduct->count()}})</a></li>
                        @endforeach
                    </ul>
                    </div>
                </aside>
            @endisset
            @isset($brand_info)
                <aside class="ps-widget--sidebar ps-widget--category">
                    <div class="ps-widget__header">
                    <h3>Sky Brand</h3>
                    </div>
                    <div class="ps-widget__content">
                    <ul class="ps-list--checked">
                        @foreach($brand_info as $brand_info)
                            <li class=""><a href="#">{{ $brand_info->title}}</a></li>
                        @endforeach
                    </ul>
                    </div>
                </aside>
            @endisset
        </div>
      </div>
    </main>
@endsection