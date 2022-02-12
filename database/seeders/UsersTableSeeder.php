<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list=array(
            array(
                'name'=>'Admin User',
                'email'=>'admin@ecom.com',
                'password'=>bcrypt('adminuser'),
                'role'=>'admin',
                'status'=>'active'
            ),
            array(
                'name'=>'Seller User',
                'email'=>'seller@ecoms.com',
                'password'=>bcrypt('selleruser'),
                'role'=>'seller',
                'status'=>'active'
            ),
            array(
                'name'=>'Customer User',
                'email'=>'customer@ecom.com',
                'password'=>bcrypt('customeruser'),
                'role'=>'customer',
                'status'=>'active'
            )
        );

        foreach($list as $user_info)
        {
            if(User::where('email',$user_info['email'])->count() <=0)
            {
                $user=new User();
                $user->fill($user_info);
                $user->save();
            }
        }
    }
}
