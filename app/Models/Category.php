<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'slug',
        'status',
        'summary',
        'created_by',
        'image',
        'parent_id'
    ];

    public function getRules()
    {
        $rules=[
            'title'=>'required|string|max:250',
            'summary'=>'nullable|string',
            'parent_id'=>'nullable|exists:categories,id',
            'status'=>'required|in:active,inactive',
            'image'=>'sometimes|image|max:5000',
            'brand_id.*'=>'required|exists:brands,id'
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

    public function getCategory()
    {
        return $this->hasOne('App\Models\Category','id','parent_id');
    }

    public function getBrand()
    {
        return $this->belongsToMany('App\Models\Brand','brand_categories','category_id','brand_id');
    }

    public function getChild()
    {
        return $this->hasMany('App\Models\Category','parent_id','id');
    }

    public function getActiveParentCat()
    {
        return $this->whereNull('parent_id')->where('status','active')->get();
    }

    public function getProduct()
    {
        return $this->hasMany('App\Models\Product','cat_id','id')->where('status','active');
    }
}
