@extends('layouts.app')

@section('content')



<div class="ps-checkout pt-80 pb-80">
        <div class="ps-container">
          <form class="ps-checkout__form" action="{{ route('register-user')}}" method="post">
            @csrf
            <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                    <div class="ps-checkout__billing">
                      <h3>Register User</h3>
                            <div class="form-group form-group--inline">
                              <label>Full Name<span>*</span>
                              </label>
                              <input class="form-control" name="name" required type="text">
                            </div>
                            <div class="form-group form-group--inline">
                              <label>Email Address<span>*</span>
                              </label>
                              <input class="form-control" name="email" required type="email">
                            </div>
                            <div class="form-group form-group--inline">
                              <label>Password<span>*</span>
                              </label>
                              <input class="form-control" name="password" required type="password">
                            </div>
                            <div class="form-group form-group--inline">
                              <label>Phone
                              </label>
                              <input class="form-control" name="phone" type="tel">
                            </div>
                            <div class="form-group form-group--inline">
                              <label>Address
                              </label>
                              <textarea class="form-control" rows="5" placeholder="Enter Address Here......" name="address"></textarea>
                            </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                    <div class="ps-checkout__order">
                      <header>
                        <h3>
                          @if(session('cart'))  
                            Your Order
                          @else
                            Register User
                          @endif
                        </h3>
                      </header>
                      @if(session('cart'))
                      <div class="content">
                        <table class="table ps-checkout__products">
                          <thead>
                            <tr>
                              <th class="text-uppercase">Product</th>
                              <th class="text-uppercase">Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach(session('cart') as $item)
                            <tr>
                              <td>{{ $item['title']}} (x{{ $item['total_product_qty']}})</td>
                              <td>{{ $item['total_product_price']}}</td>
                            </tr>
                            @endforeach
                            <tr>
                              <td>Order Total</td>
                              <td>NPR. {{ session('total_amount')}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      @endif
                      <footer>
                        <div class="form-group paypal">
                          <button class="ps-btn ps-btn--fullwidth">
                            Register
                            @if(session('cart'))
                              & Place Order
                            @endif  
                          <i class="ps-icon-next"></i></button>
                        </div>
                      </footer>
                    </div>
                  </div>
            </div>
          </form>
        </div>
      </div>



@endsection
