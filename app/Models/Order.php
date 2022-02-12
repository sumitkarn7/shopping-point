<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable=[
        'order_id',
        'buyer_id',
        'sub_total_amount',
        'discount',
        'total',
        'status'
    ];

    public function saveOrder($cart,$buyer_id)
    {
        $this->buyer_id=$buyer_id;
        $this->order_id=\Str::random(15);
        $this->sub_total_amount=session('total_amount',0);
        $this->discount=session('discont',0);
        $this->total=$this->sub_total_amount-$this->discount;
        $this->status='new';

        if($this->save())
        {
            $order_detail=new OrderDetail();
            return $order_detail->saveOrderDetail($this,$cart);
        }
        else
        {
            return null;
        }
    }

    public function buyerName()
    {
        return $this->hasOne('App\Models\User','id','buyer_id');
    }


}
