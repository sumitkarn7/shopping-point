<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'image',
        'address',
        'phone',
        'created_by'
    ];

    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
}
