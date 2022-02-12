<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInfo;
use Image;
use File;
use Mail;
use Auth;
use App\Mail\UserRegisterMail;
use App\Mail\FrontUserRegister;
use App\Models\Order;
class UserController extends Controller
{

    protected $user=null;
    protected $user_info=null;

    public function __construct(User $user,UserInfo $user_info)
    {
        $this->user=$user;
        $this->user_info=$user_info;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=$this->user->where('id','!=',auth()->user()->id)->withTrashed()->get();
        return view('admin.user.index')
        ->with('user',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['status'=>'inactive']);
        $rules=$this->user->getRules('register');
        $request->validate($rules);
        $data=$request->except('image');
        $pass=\Str::random(8);
        $data['password']=bcrypt($pass);
        $data['first_register']=true;

        $this->user->fill($data);
        $status=$this->user->save();
        if($status)
        {
            if($request->image)
            {
                $image=uploadImage($request->image,"User","100x100");
                if($image)
                {
                    $data['image']=$image;
                }
            }

            $data['user_id']=$this->user->id;
            $data['created_by']=auth()->user()->id;
            $this->user_info->fill($data);
            $this->user_info->save();
            Mail::to($this->user->email)->send(new UserRegisterMail($this->user,$pass));
            $request->session()->flash('success','User Added Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Adding User');
        }

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->user=$this->user->findOrFail($id);
        return view('admin.user.form')
        ->with('data',$this->user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->user=$this->user->findOrFail($id);
        $rules=$this->user->getRules('update');
        $request->validate($rules);

        $data=$request->except('image');

        

        $this->user->fill($data);
        $status=$this->user->save();
        if($status)
        {
            $data['user_id']=$this->user->id;
            $data['created_by']=auth()->user()->id;
            if($request->image)
            {
                $image=uploadImage($request->image,"User","100x100");
                if($image)
                {
                    if($this->user->UserInfo && $this->user->UserInfo->image !=null)
                    {
                        deleteImage($this->user->UserInfo->image,"User");
                    }
                    $data['image']=$image;
                }
            }

            $this->user_info=$this->user->UserInfo;
            if(!$this->user_info)
            {
                $this->user_info=new UserInfo();
            }

            $this->user_info->fill($data);
            $this->user_info->save();

            $request->session()->flash('success','User Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem WHile Updating User');
        }

        if(auth()->user()->id==$this->user->id)
        {
            return redirect()->back();
        }
        else
        {
            return redirect()->route('user.index');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user=$this->user->findOrFail($id);
        // $image=$this->user->UserInfo->image;
        $del=$this->user->delete();
        if($del)
        {
            // if($image)
            // {
            //     deleteImage($image,"User");
            // }

            
            request()->session()->flash('success','User Deleted Successfully !');
        }
        else
        {
            request()->session()->flash('error','Sorry! There Was A Problem While Deleting User');
        }

        return redirect()->back();
    }

    public function updatePassword(Request $request,$id)
    {
        $this->user=$this->user->findOrFail($id);
        $rules=[
            'password'=>'required|confirmed|min:5'
        ];

        $this->user->first_register=false;
        $this->user->status='active';

        $this->user->password=bcrypt($request->password);
        $status=$this->user->save();
        if($status)
        {
            
            $request->session()->flash('success','Password Updated Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry There Was A Problem While Updating Password !');
        }

        Auth::logout();

        return redirect('login');

    }

    public function updateStatus(Request $request,$id,$status)
    {
        $this->user=$this->user->findOrFail($id);
        if($status=='active')
        {
            $this->user->status='inactive';
        }
        else
        {
            $this->user->status='active';
        }

        $status=$this->user->save();

        if($status)
        {
            $request->session()->flash('success','User Status Updatd Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry ! There Was A Problem While Updating Usr Status');
        }

        return redirect()->back();
    }

    public function showUser(Request $request)
    {
        $this->user=$this->user->findOrFail($request->user_id);

        if(!$this->user)
        {
            return response()->json([
                'error'=>true,
                'data'=>null,
                'msg'=>'Invalid User Id !'
            ],200);
        }

        return response()->json([
            'error'=>false,
            'data'=>$this->user,
            'user_address'=>@$this->user->UserInfo->address,
            'user_phone'=>@$this->user->UserInfo->phone,
            'user_name'=>@$this->user->UserInfo->getUser->name,
        ],200);
    }

    public function registerUser(Request $request)
    {
        $request->request->add(['role'=>'customer']);
        $rules=$this->user->getRules('front-user');
        $request->validate($rules);
        $data=$request->all();
        // dd($data);
        $data['password']=bcrypt($request->password);
        $data['first_register']=false;

        $this->user->fill($data);
        $status=$this->user->save();
        
        if($status)
        {
            

            $data['user_id']=$this->user->id;

            $this->user_info->fill($data);
            $this->user_info->save();
            Mail::to($this->user->email)->send(new FrontUserRegister($this->user));

            if(session('cart'))
            {
                $order=new Order();
                $order_status=$order->saveOrder(session('cart'),$this->user->id);
                if($order_status)
                {
                    auth()->loginUsingId($this->user->id);
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

            $request->session()->flash('success','Account Created Successfully !');
        }
        else
        {
            $request->session()->flash('error','Sorry! There Was A Problem While Creating Account');
        }

        return redirect()->back();

        
    }
}
