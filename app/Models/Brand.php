<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'slug',
        'status',
        'image',
        'created_by'
    ];

    public function getRules()
    {
        $rules=[
            'title'=>'required|string|max:250',
            'status'=>'required|in:active,inactive',
            'image'=>'sometimes|image|max:5000'
        ];

        return $rules;
    }

    public function getSlugs($title)
    {
        $slug=\Str::slug($title);
        if($this->where('slug',$slug)->count() >0)
        {
            $slug=$slug."-".rand(0,9999);
            $this->getSlugs($slug);
        }

        return $slug;
    }

    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
}
