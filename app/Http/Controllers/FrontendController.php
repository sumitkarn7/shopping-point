<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\ReviewProduct;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
class FrontendController extends Controller
{

    protected $banner=null;
    protected $product=null;
    protected $promotion=null;
    protected $review_product=null;
    protected $category=null;
    protected $brand=null;


    public function __construct(Banner $banner,Product $product,Promotion $promotion,ReviewProduct $review_product,Category $category,Brand $brand)
    {
        $this->banner=$banner;
        $this->product=$product;
        $this->promotion=$promotion;
        $this->review_product=$review_product;
        $this->category=$category;
        $this->brand=$brand;
        $this->middleware('auth')->only(['addReview']);
    }



    public function index()
    {
        $footer_category=$this->category->whereNull('parent_id')->where('status','active')->get();
        $footer_brand=$this->brand->where('status','active')->get();

        $banner=$this->banner->where('status','active')->limit(3)->get();

        $featured_product=$this->product->where('status','active')->where('is_featured',1)->inRandomOrder()->limit(8)->get();
        $all_promotion=$this->promotion->where('status','active')->inRandomOrder()->limit(2)->get();
        $top_sale=$this->product->where('status','active')->where('discount','!=',null)->orderBy('discount','desc')->limit(8)->get();

        $all_product=$this->product->where('status','active')->inRandomOrder()->limit(32)->get();

        return view('front.index')
        ->with('banner',$banner)
        ->with('is_featured',$featured_product)
        ->with('promotion',$all_promotion)
        ->with('top_sale',$top_sale)
        ->with('all_product',$all_product)
        ->with('footer_cat',$footer_category)
        ->with('footer_brand',$footer_brand);
    }

    public function addReview(Request $request,$slug)
    {
        $this->product=$this->product->where('slug',$slug)->firstOrFail();
        $rules=$this->review_product->getRules();
        $request->validate($rules);

        $data=$request->all();
        $data['reviewed_by']=auth()->user()->id;
        $data['product_id']=$this->product->id;

        $this->review_product->fill($data);
        $status=$this->review_product->save();
        if($status)
        {
            $request->session()->flash('success','Your Review Added Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry ! There Was A Proble While Adding Your Review');
        }

        return redirect()->back();
    }

    public function childProductList(Request $request,$pslug,$slug)
    {
        $this->category=$this->category->where('slug',$slug)->firstOrFail();

        $this->product=$this->product->where('sub_cat_id',$this->category->id)->where('status','active')->orderBy('id','desc')->get();

        $parent_cat=$this->category->whereNull('parent_id')->where('status','active')->get();

        $footer_category=$this->category->whereNull('parent_id')->where('status','active')->get();
        $footer_brand=$this->brand->where('status','active')->get();

        $this->brand=$this->brand->get();
        return view('front.product-list')
        ->with('product',$this->product)
        ->with('category',$parent_cat)
        ->with('brand_info',$this->brand)
        ->with('footer_brand',$footer_brand)
        ->with('footer_cat',$footer_category);
    }

    public function parentProductList(Request $request,$pslug)
    {
        $this->category=$this->category->where('slug',$pslug)->firstOrFail();

        $this->product=$this->product->where('cat_id',$this->category->id)->where('status','active')->orderBy('id','desc')->get();

        $parent_cat=$this->category->whereNull('parent_id')->get();

        $footer_category=$this->category->whereNull('parent_id')->where('status','active')->get();
        $footer_brand=$this->brand->where('status','active')->get();

        $this->brand=$this->brand->get();
        return view('front.product-list')
        ->with('category',$parent_cat)
        ->with('product',$this->product)
        ->with('brand_info',$this->brand)
        ->with('footer_brand',$footer_brand)
        ->with('footer_cat',$footer_category);

    }


   public function addToCart(Request $request)
   {
    //    session()->forget('cart');
        $this->product=$this->product->findOrFail($request->product_id);

        $qty=(int)$request->quantity;

        $current_cart=array(
            'id'=>$this->product->id,
            'image'=> asset('Uploads/Product/'.$this->product->getproductImage[0]->image_name),
            'title'=>$this->product->title,
            'url'=>route('product-detail',$this->product->slug),
            'product_cost'=>$this->product->actual_price
        );

        $total_item=0;
        $total_amount=0;
        $cart=session('cart') ?? [];

        if($cart)
        {
            foreach($cart as $key=>$item)
            {
                if($item['id']==$this->product->id)
                {
                    $cart[$key]['total_product_qty']=$qty;
                    $cart[$key]['total_product_price']=$qty*$current_cart['product_cost'];
                }
                else
                {
                    $current_cart['total_product_qty']=$qty;
                    $current_cart['total_product_price']=$qty*$current_cart['product_cost'];
                    $cart[]=$current_cart;
                }

                break;
            }
        }
        else
        {
            $current_cart['total_product_qty']=$qty;
            $current_cart['total_product_price']=$qty*$current_cart['product_cost'];
            $cart[]=$current_cart;
        }

        if(!empty($cart))
        {
            foreach($cart as $key=>$item)
            {
                $total_item +=$item['total_product_qty'];
                $total_amount +=$item['total_product_price'];
            }
        }

        session()->put('cart',$cart);
        session()->put('total_item',$total_item);
        session()->put('total_amount',$total_amount);

        return response()->json([
            'error'=>false,
            'data'=>$cart,
            'total_item'=>$total_item,
            'total_amount'=>$total_amount,
            'msg'=>'Product Added Successfully !'
        ],200);



        
   }

   public function deleteFromCart(Request $request)
   {
       $index=(int)$request->index;

       $cart=session('cart');

       unset($cart[$index]);
       

       $total_item=0;
       $total_amount=0;

       if(!empty($cart))
        {
            foreach($cart as $key=>$item)
            {
                $total_item +=$item['total_product_qty'];
                $total_amount +=$item['total_product_price'];
            }
        }

        session()->put('cart',$cart);
        session()->put('total_item',$total_item);
        session()->put('total_amount',$total_amount);

        return redirect()->back();

   }

   public function cartDetail(Request $request)
   {
        $footer_category=$this->category->whereNull('parent_id')->where('status','active')->get();
        $footer_brand=$this->brand->where('status','active')->get();
        return view('front.cart-detail')
        ->with('footer_brand',$footer_brand)
        ->with('footer_cat',$footer_category);
   }

   public function checkout(Request $request)
   {
        
            $order=new Order();
            $order_status=$order->saveOrder(session('cart'),$request->user()->id);
            if($order_status)
            {
                session()->forget('cart');
                session()->forget('total_item');
                session()->forget('total_amount');
                $request->session()->flash('success','Order Placed Successfully !');
                return redirect()->route('success');
            }
            else
            {
                $request->session()->flash('error','Sorry ! There Was A Proble While Creating Order');

                return redirect()->route('homepage');
            }
        
   }
}
