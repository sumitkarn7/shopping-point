<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'slug',
        'summary',
        'description',
        'image',
        'created_by',
        'page_type',
        'status'
    ];

    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }

    public function getRules()
    {
        $rules=[
            'title'=>'required|string|max:250',
            'summary'=>'required|string',
            'description'=>'required|string',
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
}
