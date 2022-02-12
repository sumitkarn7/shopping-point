<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable=[
        'order_id',
        'product_id',
        'qty',
        'amount',
        'status',
        'processed_by'
    ];

    public function saveOrderDetail($order,$cart)
    {
        $temp=[];
        foreach($cart as $item)
        {
            $temp[]=array(
                'order_id'=>$order->id,
                'product_id'=>$item['id'],
                'qty'=>$item['total_product_qty'],
                'amount'=>$item['total_product_price'],
                'status'=>$order->status,
                'processed_by'=>null
            );
        }

        $this->insert($temp);
        return true;
    }
}
