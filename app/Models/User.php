<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserInfo;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'first_register'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function UserInfo()
    {
        return $this->hasOne('App\Models\UserInfo','user_id','id');
    }

    public function getRules($act='add')
    {
        $rules=[
            'name'=>'required|string|max:150',
            'address'=>'nullable|string',
            'phone'=>'nullable|string',
            'image'=>'required|image|max:5000'
        ];

        if($act=='register')
        {
            $rules['email']='required|email|unique:users,email';
            $rules['role']='required|in:seller,customer';
            $rules['status']='required|in:active,inactive';

        }

        if($act !='add')
        {
            $rules['image']='sometimes|image|max:5000';
        }

        if($act=='front-user')
        {
            $rules['image']='sometimes|image|max:5000';
            $rules['email']='required|email|unique:users,email';
            $rules['role']='required|in:customer';
        }

        return $rules;
    }

    
}
