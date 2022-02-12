@extends('layouts.app')


@section('content')
      <div class="ps-content pt-80 pb-80">
        <div class="ps-container">
        @if(session('cart'))
          <div class="ps-cart-listing">
            <table class="table ps-cart__table ">
              <thead class="text-center">
                <tr>
                  <th>All Products</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                @foreach(session('cart') as $index=>$item)
                    <tr>
                    <td><a class="ps-product__preview" href="{{ $item['url'] }}"><img class="mr-50" src="{{ $item['image'] }}" style="width:100px;height:100px" alt=""> {{ $item['title']}}</a></td>
                    <td>NPR.{{ $item['product_cost']}}</td>
                    <td>x {{ $item['total_product_qty']}}</td>
                    <td>NPR. {{ $item['total_product_price']}}</td>
                    <td>
                        <a href="{{ route('delete-from-cart',$index) }}" class="btn btn-sm btn-danger ps-remove" style=" border-radius:50%">
                            <i data-feather="times"></i>
                        </a>
                    </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <h2 class="text-center text-danger">No Item In The Cart</h2>
            @endif
            <div class="ps-cart__actions">
              <div class="ps-cart__promotion">
                <div class="form-group">
                <a href="{{ route('homepage') }}"><button class="ps-btn ps-btn--gray">Continue Shopping</button></a>
                </div>
              </div>
              @if(session('cart'))
              <div class="ps-cart__total">
                <h3>Total Item: <span> {{ session('total_item',0)}} </span></h3>
                <h3>Total Price: <span> {{ session('total_amount',0)}} NPR</span></h3><a class="ps-btn" href="{{ route('checkout')}}">Process to checkout<i class="ps-icon-next"></i></a>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
  
@endsection