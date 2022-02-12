<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7"><![endif]-->
<!--[if IE 8]><html class="ie ie8"><![endif]-->
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="favicon.png') }}" rel="icon">
    <meta name="author" content="Nghia Minh Luong">
    <meta name="keywords" content="Default Description">
    <meta name="description" content="Default keyword">
    <title>Hamro Bazar</title>
    <!-- Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Narrow:300,400,700%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/ps-icon/style.css') }}">
    <!-- CSS Library-->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/owl-carousel/assets/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/Magnific-Popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/revolution/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/revolution/css/layers.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/revolution/css/navigation.css') }}">
    <!-- Custom-->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!--HTML5 Shim and Respond.js') }} IE8 support of HTML5 elements and media queries-->
    <!--WARNING: Respond.js') }} doesn't work if you view the page via file://-->
    <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js }}"></script><script src="https://oss.maxcdn.com/libs/respond.js }}/1.4.2/respond.min.js') }}"></script><![endif]-->
  </head>
  <!--[if IE 7]><body class="ie7 lt-ie8 lt-ie9 lt-ie10"><![endif]-->
  <!--[if IE 8]><body class="ie8 lt-ie9 lt-ie10"><![endif]-->
  <!--[if IE 9]><body class="ie9 lt-ie10"><![endif]-->
  <body class="ps-loading">
    <div class="header--sidebar"></div>
    <header class="header">
      <div class="header__top">
        <div class="container-fluid">
          <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 ">
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 ">
                  <div class="header__actions">
                    @auth
                    <a href="{{ route(auth()->user()->role)}}">{{ auth()->user()->name}}</a>
                    <a href="javascript:;" onclick="event.preventDefault();document.getElementById('logout').submit();"><i data-feather="log-out"></i> Logout</a>
                    {{Form::open(['url'=>route('logout'),'id'=>'logout'])}}
                    {{ Form::close()}}
                    @else
                    <a href="{{ route('login')}}">Login</a>
                    <a href="{{ route('register')}}">Register</a>
                    @endauth
                  </div>
                </div>
          </div>
        </div>
      </div>
      <nav class="navigation">
        <div class="container-fluid">
          <div class="navigation__column left">
            <div class="header__logo"><a class="ps-logo" href="{{ route('homepage') }}"><img src="{{ asset('frontend/images/logo.png') }}" alt=""></a></div>
          </div>
          <div class="navigation__column center">
                <ul class="main-menu menu">
                  <li class="menu-item menu-item-has-children dropdown"><a href="{{ route('homepage') }}">Home</a>
                  </li>
                  <li class="menu-item menu-item-has-children has-mega-menu"><a href="#">Category</a>
                    <div class="mega-menu">
                      <div class="mega-wrap">
                        {{getMenu()}}
                      </div>
                    </div>
                  </li>
                  <li class="menu-item"><a href="#">About Us</a></li>
                  <li class="menu-item"><a href="#">Privacy Policy</a></li>
                  <li class="menu-item menu-item-has-children dropdown"><a href="#">Blogs</a>
                        <ul class="sub-menu">
                          <li class="menu-item menu-item-has-children dropdown"><a href="blog-grid.html">Blog-grid</a>
                                <ul class="sub-menu">
                                  <li class="menu-item"><a href="blog-grid.html">Blog Grid 1</a></li>
                                  <li class="menu-item"><a href="blog-grid-2.html">Blog Grid 2</a></li>
                                </ul>
                          </li>
                          <li class="menu-item"><a href="blog-list.html">Blog List</a></li>
                        </ul>
                  </li>
                  <li class="menu-item menu-item-has-children dropdown"><a href="#">Contact</a>
                  </li>
                </ul>
          </div>
          <div class="navigation__column right">
            <form class="ps-search--header" action="do_action" method="post">
              <input class="form-control" type="text" placeholder="Search Product…">
              <button><i class="ps-icon-search"></i></button>
            </form>
            <div class="ps-cart"><a class="ps-cart__toggle" href="#"><span><i class="cart_counter">{{ session('total_item',0)}}</i></span><i class="ps-icon-shopping-cart"></i></a>
              <div class="ps-cart__listing">
                <div class="ps-cart__content">
                  @if(session('cart'))
                    @foreach(session('cart') as $index=>$item)
                      <div class="ps-cart-item">
                        <a class="ps-cart-item__close" href="{{ route('delete-from-cart',$index) }}"></a>
                        <div class="ps-cart-item__thumbnail">
                          <a href="{{ $item['url'] }}"></a><img src="{{ $item['image']}}" alt="">
                        </div>
                        <div class="ps-cart-item__content">
                          <a class="ps-cart-item__title" href="{{ $item['url'] }}">{{ $item['title']}}</a>
                          <p>
                            <span>Quantity:<i>{{ $item['total_product_qty']}}</i></span>
                            <span>Total:<i>NPR. {{ $item['total_product_price']}}</i></span>
                          </p>
                        </div>
                      </div>
                    @endforeach
                  @else
                  <div class="ps-cart-item">
                    <div class="ps-cart-item__thumbnail"></div>
                    <div class="ps-cart-item__content"><a class="ps-cart-item__title" href="product-detail.html">No Item In Ther Cart...</a>
                    </div>
                  </div>
                  @endif
                </div>
                <div class="ps-cart__total @if(!session('cart')) hidden @endif">
                  <p>Number of items:<span id="total_item">{{ session('total_item')}}</span></p>
                  <p>Item Total:<span id="total_amount">NPR. {{ session('total_amount') }}</span></p>
                </div>
                <div class="ps-cart__footer @if(!session('cart')) hidden @endif"><a class="ps-btn " href="{{ route('cart-detail') }}">Check out<i class="ps-icon-arrow-left"></i></a></div>
              </div>
            </div>
            <div class="menu-toggle"><span></span></div>
          </div>
        </div>
      </nav>
    </header>
    <main class="ps-main">
        @yield('content')
      <div class="ps-footer bg--cover" data-background="{{ asset('frontend/images/background/parallax.jpg') }}">
        <div class="ps-footer__content">
          <div class="ps-container">
            <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                    <aside class="ps-widget--footer ps-widget--info">
                      <header><a class="ps-logo" href="{{ route('homepage') }}"><img src="{{ asset('frontend/images/logo-white.png') }}" alt=""></a>
                        <h3 class="ps-widget__title">Address</h3>
                      </header>
                      <footer>
                        <p><strong>Kadam Chowk,Janakpur Nepal</strong></p>
                        <p>Email: <a href='mailto:support@store.com'>sumitkarn989@gamil.com</a></p>
                        <p>Phone: +977-9819813330</p>
                        <p>Fax:   +977-9844434175</p>
                      </footer>
                    </aside>
                  </div>
                  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
                    <aside class="ps-widget--footer ps-widget--info second">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d7127.091811854694!2d85.93718947527543!3d26.726950182831448!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sbinaytara%20foundation!5e0!3m2!1sen!2snp!4v1639454886253!5m2!1sen!2snp" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </aside>
                  </div>
                  @isset($footer_cat)
                  <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 ">
                    <aside class="ps-widget--footer ps-widget--link">
                      <header>
                        <h3 class="ps-widget__title">Categories</h3>
                      </header>
                      <footer>
                        <ul class="ps-list--line">
                          @foreach($footer_cat as $cat_info)
                            <li><a href="{{ route('parent-list',$cat_info->slug) }}">{{ $cat_info->title}}</a></li>
                          @endforeach
                        </ul>
                      </footer>
                    </aside>
                  </div>
                  @endisset
                  @isset($footer_brand)
                  <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 ">
                    <aside class="ps-widget--footer ps-widget--link">
                      <header>
                        <h3 class="ps-widget__title">Brands</h3>
                      </header>
                      <footer>
                        <ul class="ps-list--line">
                          @foreach($footer_brand as $brand)
                          <li><a href="#">{{ $brand->title}}</a></li>
                          @endforeach
                        </ul>
                      </footer>
                    </aside>
                  </div>
                  @endisset
            </div>
          </div>
        </div>
        <div class="ps-footer__copyright">
          <div class="ps-container">
            <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                    <p>&copy; <a href="#">SKYTHEMES</a>, Inc. All rights Resevered. Design by <a href="#"> Alena Studio</a></p>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                    <ul class="ps-social">
                      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- JS Library-->
    <script type="text/javascript" src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/jquery-bar-rating/dist/jquery.barrating.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/gmap3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/imagesloaded.pkgd.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/isotope.pkgd.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/jquery.matchHeight-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/slick/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/elevatezoom/jquery.elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/Magnific-Popup/dist/jquery.magnific-popup.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAx39JFH5nhxze1ZydH-Kl8xXM3OK4fvcg&amp;region=GB"></script><script type="text/javascript" src="{{ asset('frontend/plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    @yield('js')
    <!-- Custom scripts-->
    <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
  </body>
</html>