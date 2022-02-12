@extends('layouts.app')

@section('js')

  <script>
    $('.add-to-cart').click(function(e){

      const quantity=$('#qty').val();
      const product_id={{ $product->id}};
      // console.log('id:',product_id);

      $.ajax({
        url:"{{ route('add-to-cart') }}",
        type:"post",
        data:{
          _token:"{{ csrf_token()}}",
          quantity:quantity,
          product_id:product_id
        },
        success:function(response)
        {
          if(typeof(response)!='object')
          {
            response=JSON.parse(response);
          }

          if(response.data !=null)
          {
            var cart_html="";
            var counter=0;
            response.data.forEach(function(value)
            {
              cart_html +='<div class="ps-cart-item">';
              cart_html +='<a class="ps-cart-item__close" href="{{ url('/cart/delete-from-cart/') }}/'+counter+'"></a>';
              cart_html +='<div class="ps-cart-item__thumbnail">';
              cart_html +='<a href="'+value.url+'"></a><img src="'+value.image+'" alt="">';
              cart_html +='</div>';
              cart_html +='<div class="ps-cart-item__content">';
              cart_html +='<a class="ps-cart-item__title" href="'+value.url+'">'+value.title+'</a>';
              cart_html +='<p>';
              cart_html +='<span>Quantity:<i>'+value.total_product_qty+'</i></span>';
              cart_html +='<span>Total:<i>NPR.<br>'+value.total_product_price+'</i></span>';
              cart_html +='</p>';
              cart_html +='</div>';
              cart_html +='</div>';
              counter++;
            }); 

            alert(response.msg);
          }

          $('.ps-cart__content').html(cart_html);
          $('#total_item').html(response.total_item);
          $('#total_amount').html(response.total_amount);
          $('.ps-cart__total').removeClass('hidden');
          $('.ps-cart__footer').removeClass('hidden');
          $('.cart_counter').html(response.total_item);
        }
      });
    });
  </script>


@endsection


@section('content')

<main class="ps-main">
      <div class="test">
        <div class="container">
          <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 ">
                </div>
          </div>
        </div>
      </div>
      @isset($product)
      <div class="ps-product--detail pt-60">
        <div class="ps-container">
          <div class="row">
            <div class="col-lg-10 col-md-12 col-lg-offset-1">
              <div class="ps-product__thumbnail">
                <div class="ps-product__preview">
                @if($product->getProductImage && $product->getProductImage->count() >0)
                  <div class="ps-product__variants">
                    @foreach($product->getProductImage as $image)
                        <div class="item"><img src="{{ asset('Uploads/Product/'.$image->image_name) }}" alt=""></div>
                    @endforeach
                  </div><a class="popup-youtube ps-product__video" href="http://www.youtube.com/watch?v=0O2aH4XLbto"><img src="{{ asset('Uploads/Product/'.$product->getProductImage[0]->image_name) }}" alt=""><i class="fa fa-play"></i></a>
                @endif
                </div>
                @if($product->getProductImage && $product->getProductImage->count() >0)
                <div class="ps-product__image">
                @foreach($product->getProductImage as $image)
                  <div class="item"><img class="zoom" src="{{ asset('Uploads/Product/'.$image->image_name) }}" alt="" data-zoom-image="{{ asset('Uploads/Product/'.$image->image_name) }}"></div>
                @endforeach
                </div>
                @endif
              </div>
              <div class="ps-product__thumbnail--mobile">
                <div class="ps-product__main-img"><img src="images/shoe-detail/1.jpg" alt=""></div>
                <div class="ps-product__preview owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="false" data-owl-item="3" data-owl-item-xs="3" data-owl-item-sm="3" data-owl-item-md="3" data-owl-item-lg="3" data-owl-duration="1000" data-owl-mousedrag="on"><img src="images/shoe-detail/1.jpg" alt=""><img src="images/shoe-detail/2.jpg" alt=""><img src="images/shoe-detail/3.jpg" alt=""></div>
              </div>
              <div class="ps-product__info">
                <div class="ps-product__rating">
                  <select class="ps-rating">
                    <option value="1">1</option>
                    <option value="1">2</option>
                    <option value="1">3</option>
                    <option value="1">4</option>
                    <option value="2">5</option>
                  </select><a href="#">(Read all {{ $product->getReview->count() ?? 0}} reviews)</a>
                </div>
                <h1>{{ $product->title}}</h1>
                @if($product->getBrand && $product->getBrand->count() >0)
                <p class="ps-product__category">
                    @foreach($product->getBrand as $brand)
                    <a href="#"> {{ $brand->title}}</a>,
                    @endforeach
                </p>
                @endif
                <h3 class="ps-product__price">
                    NPR. {{ $product->actual_price}} 
                    @if($product->discount && $product->discount !=null)
                    <del>NPR. {{ $product->price}}</del>
                    @endif
                </h3>
                <div class="ps-product__block ps-product__quickview">
                  <h4>QUICK REVIEW</h4>
                  <p>{{ ucfirst($product->summary) }}</p>
                </div>
                <div class="ps-product__block ps-product__size">
                  <div class="form-group">
                    <input class="form-control" type="number" value="1" min="1" id="qty">
                  </div>
                </div>
                <div class="ps-product__shopping"><a class="ps-btn mb-10 add-to-cart" href="javascript:;" data-id="{{ $product->id}}">Add to cart<i class="ps-icon-next"></i></a>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="ps-product__content mt-50">
                <ul class="tab-list" role="tablist">
                  <li class="active"><a href="#tab_01" aria-controls="tab_01" role="tab" data-toggle="tab">Overview</a></li>
                  <li><a href="#tab_02" aria-controls="tab_02" role="tab" data-toggle="tab">Review</a></li>
                </ul>
              </div>
              <div class="tab-content mb-60">
                <div class="tab-pane active" role="tabpanel" id="tab_01">
                    <p>{!! $product->description !!}</p>
                </div>
                @include('admin.partials.message')
                <div class="tab-pane" role="tabpanel" id="tab_02">
                  <p class="mb-20">{{ $product->getReview->count() ?? 0}} review for <strong>{{ ucfirst($product->title) }}</strong></p>
                  @if($product->getReview && $product->getReview->count() >0)
                    @foreach($product->getReview as $review)
                    <div class="ps-review">
                        <div class="ps-review__thumbnail">
                            @if($review->getReviewedUser->UserInfo && $review->getReviewedUser->UserInfo->image !=null)
                            <img src="{{ asset('Uploads/User/'.$review->getReviewedUser->UserInfo->image) }}" alt="">
                            @else
                            <img src="{{ asset('sumit.jfif') }}" alt="">
                            @endif
                        </div>
                        <div class="ps-review__content">
                        <header>
                            <select class="ps-rating">
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{ $i<=$review->rate ? 1:0}}">{{ $i}}</option>
                                @endfor
                            </select>
                            <p>By<a href=""> {{ucfirst($review->getReviewedUser->name)}}</a> - {{ date("F d, Y",strtotime($review->created_at))}}</p>
                        </header>
                        <p>{{ $review->review}}</p>
                        </div>
                    </div>
                    @endforeach
                  @endif
                  @auth
                  {{ Form::open(['url'=>route('add-review',$product->slug)])}}
                  @method('put')
                    <h4>ADD YOUR REVIEW</h4>
                    
                    <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                              <label>Your rating<span></span></label>
                              <select class="ps-rating " name="rate">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                              <label>Your Review:</label>
                              
                              <textarea class="form-control" rows="6" name="review"></textarea>
                            </div>
                            <div class="form-group">
                              <button class="ps-btn ps-btn--sm" type="submit">Submit<i class="ps-icon-next"></i></button>
                            </div>
                          </div>
                    </div>
                  {{ Form::close()}}
                  @else
                  <p>Plz <strong><e><a href="{{ route('login') }}" class="text-danger">Login</a></em></strong> First To Review product</p>
                  @endauth
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endisset
      @isset($related_product)
      <div class="ps-section ps-section--top-sales ps-owl-root pt-40 pb-80">
        <div class="ps-container">
          <div class="ps-section__header mb-50">
            <div class="row">
                  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <h3 class="ps-section__title" data-mask="Related item">- YOU MIGHT ALSO LIKE</h3>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                    <div class="ps-owl-actions"><a class="ps-prev" href="#"><i class="ps-icon-arrow-right"></i>Prev</a><a class="ps-next" href="#">Next<i class="ps-icon-arrow-left"></i></a></div>
                  </div>
            </div>
          </div>
          <div class="ps-section__content">
            <div class="ps-owl--colection owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="30" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">
              @foreach($related_product as $product)
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
      </div>
      @endisset
    </main>
@endsection

@section('js')
    <script>
        setTimeout(function(){
            $('.alert').slideUp();
        }, 9000);
    </script>
@endsection