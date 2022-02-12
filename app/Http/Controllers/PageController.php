<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{

    protected $page=null;

    public function __construct(Page $page)
    {
        $this->page=$page;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_type='Blog';
        return view('admin.page.form')
        ->with('page_type',$page_type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=$this->page->getRules();
        $request->validate($rules);
        $data=$request->except('image');

        if($request->image)
        {
            $image=uploadImage($request->image,"Page","2000x2000");
            if($image)
            {
                $data['image']=$image;
            }
        }

        $data['page_type']='blog';
        $data['slug']=$this->page->getSlugs($request->title);
        $data['created_by']=auth()->user()->id;

        $this->page->fill($data);
        $status=$this->page->save();

        
        if($status)
        {
            $request->session()->flash('success','Blog Added Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry ! There Was A Problem Whle Adding Blog');
        }

        return redirect()->route('page.show','blog');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($page)
    {
        if($page=='blog')
        {
            $page_type=$this->page->where('page_type','blog')->get();
        }
        else
        {
            $page_type=$this->page->where('page_type','!=','blog')->get();
        }

        return view('admin.page.index')
        ->with('page',$page_type)
        ->with('page_type',$page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        if($page->page_type=='blog')
        {
            $page_type='blog';

        }
        else
        {
            $page_type='page';
        }
        return view('admin.page.form')
        ->with('data',$page)
        ->with('page_type',$page_type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $rules=$page->getRules();
        $request->validate($rules);
        $data=$request->except('image');

        if($request->image)
        {
            $image=uploadImage($request->image,"Page","2000x2000");
            if($image)
            {
                if($page->image && $page->image !=null)
                {
                    deleteImage($page->image,"Page");
                }
                $data['image']=$image;
            }
        }

        $page->fill($data);
        $status=$page->save();

        if($page->page_type=='blog')
        {
            $type="blog";
        }
        else
        {
            $type="page";
        }
        if($status)
        {
            $request->session()->flash('success',$type.' Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry ! There Was A Problem Whle Updating'.$type);
        }

        return redirect()->route('page.show',$type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $image=$page->image;
        $del=$page->delete();
        if($del)
        {
            if($image)
            {
                deleteImage($image,"Page");
            }
            request()->session()->flash('success','Blog deleted Successfully !');
        }
        else
        {
            request()->session()->flash('error','Sorry ! There Was A Problem While deleting Blog');
        }

        return redirect()->back();
    }

    public function updateStatus(Request $request,$id,$status)
    {
        $this->page=$this->page->findOrFail($id);
        if($status=='active')
        {
            $this->page->status='inactive';
        }
        else
        {
            $this->page->status='active';
        }

        $status=$this->page->save();

        if($this->page->page_type=='blog')
        {
            $type='Blog';
        }
        else
        {
            $type='Page';
        }
        if($status)
        {
            $request->session()->flash('success',$type.' Status Updated Successfully ');
        }
        else
        {
            $request->session()->flash('error','Sorry !There Was A Proble While Updating '.$type.'Status' );
        }

        return redirect()->back();
    }
}
