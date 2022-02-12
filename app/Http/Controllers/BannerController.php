<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    protected $banner=null;

    public function __construct(Banner $banner)
    {
        $this->banner=$banner;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_banner=$this->banner->get();
        return view('admin.banner.index')
        ->with('banner',$all_banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=$this->banner->getRules();
        $request->validate($rules);
        $data=$request->except('image');

        $image=uploadImage($request->image,"Banner","1920x650 ");
        if($image)
        {
            $data['image']=$image;
        }
        $data['created_by']=auth()->user()->id;
        $this->banner->fill($data);
        $status=$this->banner->save();
        if($status)
        {
            $request->session()->flash('success','Banner Added Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Adding Banner');
        }

        return redirect()->route('banner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banner.form')
        ->with('data',$banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $rules=$banner->getRules('update');
        $request->validate($rules);
        $data=$request->except('image');
        if($request->image)
        {
            $image=uploadImage($request->image,'Banner',"1920x650 ");
            if($image)
            {
                if($banner->image && $banner->image !=null)
                {
                    deleteImage($banner->image,"Banner");
                }
                $data['image']=$image;
            }
        }

        $banner->fill($data);
        $status=$banner->save();
        if($status)
        {
            $request->session()->flash('success','Banner Updatted Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Updating Banner');
        }

        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $image=$banner->image;
        $del=$banner->delete();
        if($del)
        {
            if($image)
            {
                deleteImage($image,"Banner");
            }
            request()->session()->flash('success','Banner deleted Successfully !');
        }
        else
        {
            request()->session()->flash('error','Sorry! There Was A Problem WHile Deleting Banner');
        }

        return redirect()->back();
    }

    public function updateStatus(Request $request,$id,$status)
    {
        $this->banner=$this->banner->findOrFail($id);

        if($status=='active')
        {
            $this->banner->status='inactive';
        }
        else
        {
            $this->banner->status='active';
        }

        $status=$this->banner->save();

        if($status)
        {
            $request->session()->flash('success','Banner Status Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Updating Banner Status');
        }

        return redirect()->back();
    }

    public function showBanner(Request $request)
    {

        $this->banner=$this->banner->findOrFail($request->banner_id);
        $user=$this->banner->getUser->name;
        $banner_image=null;
        if(!$this->banner)
        {
            return response()->json([
                'error'=>true,
                'data'=>'null',
                'msg'=>'Invalid Banner Id !'
            ],200);
        }

        session()->put('banner_image',$this->banner->image);

        return response()->json([
            'error'=>false,
            'data'=>$this->banner,
            'user'=>$user,
            'msg'=>'Success !'
        ],200);
    }
}
