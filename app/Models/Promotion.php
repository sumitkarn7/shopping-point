<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Promotion extends Model
{
    use HasFactory;

    
    protected $fillable=[
        'title',
        'link',
        'image',
        'status',
        'created_by'
    ];

    public function getRules($act='add')
    {
        $rules=[
            'title'=>'required|string|max:250',
            'link'=>'nullable|url',
            'status'=>'required|in:active,inactive',
            'image'=>'required|image|max:5000'
        ];

        if($act !='add')
        {
            $rules['image']='sometimes|image|max:5000';
        }

        return $rules;
    }

    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
}
