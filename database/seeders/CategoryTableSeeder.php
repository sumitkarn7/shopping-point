<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoryTableSeeder extends Seeder
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
                'title'=>'Electronics',
                'slug'=>\Str::slug('Electronics'),
                'summary'=>'Electronics Summary',
                'status'=>'active'
            ),
            array(
                'title'=>'Mobile Devices',
                'slug'=>\Str::slug('Mobile Devices'),
                'summary'=>'Mobile Devices Summary',
                'status'=>'active'
            ),
            array(
                'title'=>'Clothes',
                'slug'=>\Str::slug('Clothes'),
                'summary'=>'Clothes Summary',
                'status'=>'active'
            ),
            array(
                'title'=>'Levis',
                'slug'=>\Str::slug('Levis'),
                'summary'=>'Levis Summary',
                'status'=>'active'
            )
        );

        foreach($list as $cat_info)
        {
            if(Category::where('slug',$cat_info['slug'])->count() <=0)
            {
                $cat=new Category();
                $cat->fill($cat_info);
                $cat->save();
            }
        }
    }
}
