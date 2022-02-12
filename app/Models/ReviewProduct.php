<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class ReviewProduct extends Model
{
    use HasFactory;

    protected $fillable=[
        'product_id',
        'reviewed_by',
        'rate',
        'review'
    ];

    public function getRules()
    {
        $rules=[
            'rate'=>'nullable|int',
            'review'=>'nullable|string'
        ];

        return $rules;
    }

    public function getReviewedUser()
    {
        return $this->hasOne('App\Models\User','id','reviewed_by');
    }
}
