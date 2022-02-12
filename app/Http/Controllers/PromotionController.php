<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    protected $promotion=null;

    public function __construct(Promotion $promotion)
    {
        $this->promotion=$promotion;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_promotion=$this->promotion->get();
        return view('admin.promotion.index')
        ->with('promotion',$all_promotion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promotion.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=$this->promotion->getRules();
        $request->validate($rules);
        $data=$request->except('image');

        $image=uploadImage($request->image,"Promotion","960x401");
        if($image)
        {
            $data['image']=$image;
        }
        $data['created_by']=auth()->user()->id;
        $this->promotion->fill($data);
        $status=$this->promotion->save();
        if($status)
        {
            $request->session()->flash('success','Promotion Added Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Adding Promotion');
        }

        return redirect()->route('promotion.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        return view('admin.promotion.form')
        ->with('data',$promotion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        $rules=$promotion->getRules('update');
        $request->validate($rules);
        $data=$request->except('image');
        if($request->image)
        {
            $image=uploadImage($request->image,'Promotion',"960x401");
            if($image)
            {
                if($promotion->image && $promotion->image !=null)
                {
                    deleteImage($promotion->image,"Promotion");
                }
                $data['image']=$image;
            }
        }

        $promotion->fill($data);
        $status=$promotion->save();
        if($status)
        {
            $request->session()->flash('success','Promotion Updatted Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Updating Promotion');
        }

        return redirect()->route('promotion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        $image=$promotion->image;
        $del=$promotion->delete();
        if($del)
        {
            if($image)
            {
                deleteImage($image,"Promotion");
            }
            request()->session()->flash('success','Promotion deleted Successfully !');
        }
        else
        {
            request()->session()->flash('error','Sorry! There Was A Problem WHile Deleting Promotion');
        }

        return redirect()->back();
    }

    public function updateStatus(Request $request,$id,$status)
    {
        $this->promotion=$this->promotion->findOrFail($id);

        if($status=='active')
        {
            $this->promotion->status='inactive';
        }
        else
        {
            $this->promotion->status='active';
        }

        $status=$this->promotion->save();

        if($status)
        {
            $request->session()->flash('success','Promotion Status Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Updating Promotion Status');
        }

        return redirect()->back();
    }
}
