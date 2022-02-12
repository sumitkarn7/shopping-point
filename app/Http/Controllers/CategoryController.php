<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\BrandCategory;
class CategoryController extends Controller
{

    protected $category=null;
    protected $brand=null;
    protected $brand_category=null;

    public function __construct(Category $category,Brand $brand,BrandCategory $brand_category)
    {
        $this->category=$category;
        $this->brand=$brand;
        $this->brand_category=$brand_category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parent_cat=$this->category->whereNull('parent_id')->get();
        return view('admin.category.index')
        ->with('parent_cat',$parent_cat);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_cat=$this->category->whereNull('parent_id')->get();
        $all_brand=$this->brand->get();
        return view('admin.category.form')
        ->with('all_cat',$all_cat)
        ->with('all_brand',$all_brand);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=$this->category->getRules();
        $request->validate($rules);
        $data=$request->except(['image','brand_id']);

        if($request->image)
        {
            $image=uploadImage($request->image,"Category","200x200");
            if($image)
            {
                $data['image']=$image;
            }
        }

        $data['slug']=$this->category->getSlugs($request->title);
        $data['created_by']=auth()->user()->id;

        $this->category->fill($data);
        $status=$this->category->save();
        if($status)
        {
            if($request->brand_id)
            {
                $temp=[];
                foreach($request->brand_id as $brand)
                {
                    $temp[]=array(
                        'category_id'=>$this->category->id,
                        'brand_id'=>$brand
                    );
                }

                $this->brand_category->insert($temp);
            }
            $request->session()->flash('success','Category Added Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Adding Category');
        }

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $all_cat=$this->category->where('id',"!=",$category->id)->whereNull('parent_id')->get();
        $all_brand=$this->brand->get();
        return view('admin.category.form')
        ->with('all_cat',$all_cat)
        ->with('all_brand',$all_brand)
        ->with('data',$category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules=$category->getRules();
        $request->validate($rules);
        $data=$request->except(['image','brand_id']);
        if($request->image)
        {
            $image=uploadImage($request->image,"Category","200x200");
            if($image)
            {
                if($category->image && $category->image !=null)
                {
                    deleteImage($category->image,"Category");
                }
                $data['image']=$image;
            }
        }

        $category->fill($data);
        $status=$category->save();
        if($status)
        {
            if($request->brand_id)
            {
                $this->brand_category->where('category_id',$category->id)->delete();
                $temp=[];
                foreach($request->brand_id as $brand)
                {
                    $temp[]=array(
                        'category_id'=>$category->id,
                        'brand_id'=>$brand
                    );
                }

                $this->brand_category->insert($temp);
            }
            $request->session()->flash('success','Category Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Proble While Updating Status');
        }

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $image=$category->image;
        $del=$category->delete();
        if($del)
        {
            if($image)
            {
                deleteImage($image,"Category");
            }
            request()->session()->flash('success','Category deleted Successfully !');
        }
        else
        {
            request()->session()->flash('error','Sorry! There Was A Problem While Deleting Category');
        }

        return redirect()->back();
    }

    public function updateStatus(Request $request,$id,$status)
    {
        $this->category=$this->category->findOrFail($id);
        if($status=='active')
        {
            $this->category->status='inactive';
        }
        else
        {
            $this->category->status='active';
        }

        $status=$this->category->save();
        if($status)
        {
            $request->session()->flash('success','Category Status Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Updating Category Status');
        }

        return redirect()->back();
    }

    public function showChild(Request $request)
    {
        $this->category=$this->category->where('slug',$request->slug)->firstOrFail();
        
        $child_cat=$this->category->getChild;

        return view('admin.category.index')
        ->with('parent_cat',$child_cat)
        ->with('main_cat',$this->category);
    }

    public function showCategory(Request $request)
    {
        $this->category=$this->category->findOrFail($request->category_id);

        if(!$this->category)
        {
            return response()->json([
                'error'=>true,
                'data'=>null,
                'msg'=>'Invalid Category Id !'
            ],200);
        }

        return response()->json([
            'error'=>false,
            'data'=>$this->category,
            'user'=>@$this->category->getUser->name,
            'brand'=>@$this->category->getBrand,
            'parent_of'=>@$this->category->getCategory->title,
            'msg'=>'Success !'
        ],200);
    }

    public function showSubCat(Request $request)
    {
        $this->category=$this->category->findOrFail($request->cat_id);
        $sub_cat=$this->category->getChild;
        if(!$this->category)
        {
            return response()->json([
                'error'=>true,
                'data'=>null,
                'msg'=>'Invalid Category Id !'
            ],200);
        }

        return response()->json([
            'error'=>false,
            'data'=>[
                'child'=>$sub_cat
            ],
            'msg'=>'Success !'
        ],200);
    }
}
