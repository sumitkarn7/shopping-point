<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\User;
use App\Models\Category;
use App\Models\BrandProduct;
use App\Models\ProductImage;
class ProductController extends Controller
{

    protected $brand=null;
    protected $user=null;
    protected $category=null;
    protected $product=null;
    protected $brand_product=null;
    protected $product_image=null;

    public function __construct(Brand $brand,User $user,Category $category,Product $product,BrandProduct $brand_product,ProductImage $product_image)
    {
        $this->brand=$brand;
        $this->user=$user;
        $this->category=$category;
        $this->product=$product;
        $this->brand_product=$brand_product;
        $this->product_image=$product_image;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_product=$this->product->withTrashed()->get();
        return view('admin.product.index')
        ->with('product',$all_product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_brand=$this->brand->get();
        $all_seller=$this->user->where('role','seller')->get();
        $parent_cat=$this->category->whereNull('parent_id')->get();

        return view('admin.product.form')
        ->with('all_brand',$all_brand)
        ->with('all_seller',$all_seller)
        ->with('parent_cat',$parent_cat);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=$this->product->getRules('add');
        $request->validate($rules);
        $data=$request->except(['image','brand_id']);
        $data['actual_price']=ceil($data['price']-($data['price']*$data['discount'])/100);
        $data['slug']=$this->product->getSlugs($request->title);
        $data['created_by']=auth()->user()->id;

        $this->product->fill($data);
        $status=$this->product->save();
        if($status)
        {
            if($request->brand_id)
            {
                $temp=[];
                foreach($request->brand_id as $brand)
                {
                    $temp[]=array(
                        'product_id'=>$this->product->id,
                        'brand_id'=>$brand
                    );
                }
                $this->brand_product->insert($temp);
            }

            if($request->image)
            {
                $temp=[];
                foreach($request->image as $image_name)
                {
                    $image=uploadImage($image_name,"Product","800x800");
                    if($image)
                    {
                        $temp[]=array(
                            'product_id'=>$this->product->id,
                            'image_name'=>$image
                       );
                    }
                   
                }
                $this->product_image->insert($temp);
            }
            $request->session()->flash('success','Product Added Successfully !');
        }
        else
        {
            $request->session()->flash('success','Sorry ! There Was A Problem While Adding Product');
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $this->product=$this->product->where('slug',$request->slug)->firstOrFail();

        $footer_category=$this->category->whereNull('parent_id')->where('status','active')->get();
        $footer_brand=$this->brand->where('status','active')->get();

        $related_product=$this->product->getRelatedProduct;

        return view('front.product-detail')
        ->with('product',$this->product)
        ->with('related_product',$related_product)
        ->with('footer_brand',$footer_brand)
        ->with('footer_cat',$footer_category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $all_brand=$this->brand->get();
        $all_seller=$this->user->where('role','seller')->get();
        $parent_cat=$this->category->whereNull('parent_id')->get();

        return view('admin.product.form')
        ->with('all_brand',$all_brand)
        ->with('all_seller',$all_seller)
        ->with('parent_cat',$parent_cat)
        ->with('data',$product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules=$product->getRules('update');
        $request->validate($rules);
        $data=$request->except(['image','brand_id']);
        if($request->is_featured ==null)
        {
            $data['is_featured']=0;
        }
        $data['actual_price']=ceil($data['price']-($data['price']*$data['discount'])/100);

        $product->fill($data);
        $status=$product->save();
        if($status)
        {
            if($request->brand_id)
            {
                $this->brand_product->where('product_id',$product->id)->delete();
                $temp=[];
                foreach($request->brand_id as $brand)
                {
                    $temp[]=array(
                        'product_id'=>$product->id,
                        'brand_id'=>$brand
                    );
                }
                $this->brand_product->insert($temp);
            }

            if($request->image)
            {
                $temp=[];
                foreach($request->image as $image_name)
                {
                    $image=uploadImage($image_name,"Product","800x800");
                    if($image)
                    {
                        $temp[]=array(
                            'product_id'=>$product->id,
                            'image_name'=>$image
                       );
                    }
                   
                }
                $this->product_image->insert($temp);
            }
            $request->session()->flash('success','Product Updated  Successfully !');
        }
        else
        {
            $request->session()->flash('success','Sorry ! There Was A Problem While Updating Product');
        }

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $del=$product->delete();
        if($del)
        {
            request()->session()->flash('success','Product deleted Successfully !');
        }
        else
        {
            request()->session()->flash('error','Sorry ! There Was A Problem While Deleting Product');
        }

        return redirect()->back();
    }

    public function updateStatus(Request $request,$id,$status)
    {
        $this->product=$this->product->findOrFail($id);
        if($status=='active')
        {
            $this->product->status='inactive';
        }
        else
        {
            $this->product->status='active';
        }

        $status=$this->product->save();
        if($status)
        {
            $request->session()->flash('success','Product Status Updated Successfuly !');
        }
        else
        {
            $request->session()->flash('error','Sorry ! There Was A Problem While Updating Product Status');
        }

        return redirect()->back();
    }

    public function deleteImage(Request $request)
    {
        $image=$this->product_image->findOrFail($request->image_id);
        
        if($image)
        {
           deleteImage($image->image_name,"Product");
           $image->delete();
        }
        else
        {
            return response()->json([
                'error'=>true,
                'data'=>null,
                'msg'=>'Invalid Image Id !'
            ],200);
        }

        
    }
}
