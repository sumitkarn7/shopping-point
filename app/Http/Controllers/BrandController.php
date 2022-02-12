<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    protected $brand=null;

    public function __construct(Brand $brand)
    {
        $this->brand=$brand;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_brand=$this->brand->get();
        return view('admin.brand.index')
        ->with('brand',$all_brand);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=$this->brand->getRules();
        $request->validate($rules);
        $data=$request->except('image');
        if($request->image)
        {
            $image=uploadImage($request->image,"Brand","480x480");
            if($image)
            {
                $data['image']=$image;
            }
        }

        $data['slug']=$this->brand->getSlugs($request->title);
        $data['created_by']=auth()->user()->id;
        $this->brand->fill($data);
        $status=$this->brand->save();
        if($status)
        {
            $request->session()->flash('success','Brand Added Succeesfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Adding Brand');
        }

        return redirect()->route('brand.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.form')
        ->with('data',$brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $rules=$brand->getRules();
        $request->validate($rules);
        $data=$request->except('image');
        if($request->image)
        {
            $image=uploadImage($request->image,"Brand","480x480");
            if($image)
            {
                if($brand->image && $brand->image !=null)
                {
                    deleteImage($brand->image,"Brand");
                }
                $data['image']=$image;
            }
        }

        $brand->fill($data);
        $status=$brand->save();
        if($status)
        {
            $request->session()->flash('success','Brand Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Updating Brand');
        }

        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $image=$brand->image;
        $del=$brand->delete();
        if($del)
        {
            if($image)
            {
                deleteImage($image,"Brand");
            }
            request()->session()->flash('success','Brand Deleted Successfully !');
        }
        else
        {
            request()->session()->flash('error','Sorry! There Was A Problem While Deleting Brand');
        }

        return redirect()->back();
    }

    public function updateStatus(Request $request,$id,$status)
    {
        $this->brand=$this->brand->findOrFail($id);
        if($status=='active')
        {
            $this->brand->status='inactive';
        }
        else
        {
            $this->brand->status='active';
        }

        $status=$this->brand->save();
        if($status)
        {
            $request->session()->flash('success','Brand Status Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Updating Brand Status');
        }

        return redirect()->back();
    }

    public function showBrand(Request $request)
    {
        $this->brand=$this->brand->findOrFail($request->brand_id);
        $user=$this->brand->getUser->name;
        if(!$this->brand)
        {
            return response()->json([
                'error'=>true,
                'data'=>'null',
                'msg'=>'Invalid Brand Id !'
            ],200);
        }

        return response()->json([
            'error'=>false,
            'data'=>$this->brand,
            'created_by'=>$user,
            'msg'=>'Success !'
        ],200);
        
    }
}
