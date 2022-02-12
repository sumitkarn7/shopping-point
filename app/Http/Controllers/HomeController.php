<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user,Order $order)
    {
        $this->user=$user;
        $this->order=$order;
        $this->middleware('auth');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->first_register==1)
        {
            return view('common.password-set');
        }

        return redirect(auth()->user()->role);
    }

    public function admin()
    {
        $container=[
            'users'=>$this->user->where('id','!=',auth()->user()->id)->count(),
            'revenue'=>$this->order->sum('total'),
            'today_order'=>$this->order->whereDate('created_at',today())->count(),
            'sales_today'=>$this->order->whereDate('created_at',today())->sum('total'),
            'this_month'=>$this->order->whereMonth('created_at',date('m'))->sum('total')
        ];

        $order_today=$this->order->whereDate('created_at',today())->get();
        return view('admin.dashboard')
        ->with('container',$container)
        ->with('order_today',$order_today);
    }

    public function seller()
    {
        echo "Seller User";
    }

    public function customer()
    {
        echo "Customer User";
    }
}
