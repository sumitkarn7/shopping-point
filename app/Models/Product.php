<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ReviewProduct;
class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'title',
        'slug',
        'cat_id',
        'sub_cat_id',
        'summary',
        'description',
        'price',
        'discount',
        'is_featured',
        'status',
        'seller_id',
        'created_by',
        'actual_price'
    ];

    public function getRules($act='add')
    {
        $rules=[
            'title'=>'required|string|max:250',
            'cat_id'=>'nullable|exists:categories,id',
            'sub_cat_id'=>'nullable|exists:categories,id',
            'brand_id.*'=>'required|exists:brands,id',
            'summary'=>'required|string',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:100',
            'discount'=>'nullable|numeric|min:0|max:95',
            'is_featured'=>'nullable|in:1',
            'status'=>'required|in:active,inactive',
            'seller'=>'nullable|exists:users,id',
            'image.*'=>'required|image|max:5000'
        ];

        if($act !='add')
        {
            $rules['image.*']='sometimes|image|max:5000';
        }
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

    public function getParent()
    {
        return $this->hasOne('App\Models\Category','id','cat_id');
    }

    public function getSubCat()
    {
        return $this->hasOne('App\Models\Category','id','sub_cat_id');
    }

    public function getSeller()
    {
        return $this->hasOne('App\Models\User','id','seller_id');
    }

    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }

    public function getBrand()
    {
        return $this->belongsToMany('App\Models\Brand','brand_products','product_id','brand_id');
    }

    public function getProductImage()
    {
        return $this->hasMany('App\Models\ProductImage','product_id','id');
    }

    public function getRelatedProduct()
    {
        return $this->hasMany('App\Models\Product','sub_cat_id','sub_cat_id')->where('status','active')->orderBy('id','desc');
    }

    public function getReview()
    {
        return $this->hasMany('App\Models\ReviewProduct','product_id','id')->orderBy('id','desc');
    } 
}
