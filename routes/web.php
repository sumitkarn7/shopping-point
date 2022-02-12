<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// ---------------------------------------------------FrontEnd Routes Starts Here---------------------------------------------------------------------------------


        Route::group(['namespace'=>'App\Http\Controllers'],function(){

            Route::get('/','FrontendController@index')->name('homepage');

            Route::get('/product-detail/{slug}','ProductController@show')->name('product-detail');

            Route::put('/add-review/{slug}','FrontendController@addReview')->name('add-review');

            Route::get('/product-list/{pslug}/{slug}','FrontendController@childProductList')->name('child-list');
            Route::get('/product-list/{pslug}','FrontendController@parentProductList')->name('parent-list');

            Route::post('/cart','FrontendController@addToCart')->name('add-to-cart');
            Route::get('/cart/delete-from-cart/{index}','FrontendController@deleteFromCart')->name('delete-from-cart');
            Route::get('/cart-detail','FrontendController@cartDetail')->name('cart-detail');
            Route::get('/checkout','FrontendController@checkout')->name('checkout')->middleware(['auth','customer']);

            Route::post('/register-user','UserController@registerUser')->name('register-user');

            Route::get('success',function(){
                return view('front.success');
            })->name('success');
        });


// ---------------------------------------------------FrontEnd Routes Ends Here---------------------------------------------------------------------------------

// -------------------------------------------------------------------Backend Routes Starts Here------------------------------------------------------------------------



    Route::group(['namespace'=>'App\Http\Controllers','middleware'=>'auth'],function(){

            // ------------------------------------------------Admin Routes Starts Here------------------------------------------------------------------

            Route::group(['prefix'=>'admin','middleware'=>'admin'],function(){

                Route::get('','HomeController@admin')->name('admin');

                Route::resource('/user','UserController');
                
                Route::get('/user/update-status/{id}/{status}','UserController@updateStatus')->name('user.update-status');
                Route::get('/show-user','UserController@showUser')->name('show-user');

                Route::resource('/banner','BannerController');
                Route::get('/banner/update-status/{id}/{status}','BannerController@updateStatus')->name('banner.update-status');
                Route::get('/show-banner','BannerController@showBanner')->name('show-banner');

                Route::resource('/brand','BrandController');
                Route::get('/brand/update-status/{id}/{status}','BrandController@updateStatus')->name('brand.update-status');
                Route::get('/show-brand','BrandController@showBrand')->name('show-brand');

                Route::resource('/category','CategoryController');
                Route::get('/category/update-status/{id}/{status}','CategoryController@updateStatus')->name('category.update-status');
                Route::get('/category/{slug}/child','CategoryController@showChild')->name('show-child');
                Route::get('/show-category','CategoryController@showCategory')->name('show-category');

                Route::resource('/product','ProductController');
                Route::get('/show-sub-cat','CategoryController@showSubCat')->name('show-sub-cat');
                Route::get('/product/update-status/{id}/{status}','ProductController@updateStatus')->name('product.update-status');

                Route::resource('/page','PageController');
                Route::get('/page/update-status/{id}/{status}','PageController@updateStatus')->name('page.update-status');

                Route::resource('/promotion','PromotionController');
                Route::get('/promotion/update-status/{id}/{status}','PromotionController@updateStatus')->name('promotion.update-status');
            });


            // ------------------------------------------------Admin Routes Ends Here------------------------------------------------------------------

            // ------------------------------------------------Seller Routes Starts Here------------------------------------------------------------------


            Route::group(['prefix'=>'seller','middleware'=>'seller'],function(){

                Route::get('','HomeController@seller')->name('seller');
            });


            // ------------------------------------------------Seller Routes Ends Here------------------------------------------------------------------


            // ------------------------------------------------Customer Routes Starts Here------------------------------------------------------------------


            Route::group(['prefix'=>'customer','middleware'=>'customer'],function(){

                Route::get('','HomeController@customer')->name('customer');
            });



            // ------------------------------------------------Customer Routes Ends Here------------------------------------------------------------------


            // ------------------------------------------------Common Routes Starts Here---------------------------------------------------------------

                    Route::get('/delete-image','ProductController@deleteImage');
                    Route::put('/user/update-password/{id}','UserController@updatePassword')->name('user.update-password');


            // ------------------------------------------------Common Routes Ends Here---------------------------------------------------------------
    });

        
// -------------------------------------------------------------------Backend Routes Ends Here------------------------------------------------------------------------



