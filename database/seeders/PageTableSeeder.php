<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
class PageTableSeeder extends Seeder
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
                'title'=>'About Us',
                'slug'=>\Str::slug('About Us'),
                'summary'=>'About Us Summary',
                'description'=>'About Us Description',
                'page_type'=>'about',
                'status'=>'active'
            ),
            array(
                'title'=>'Faq',
                'slug'=>\Str::slug('Faq'),
                'summary'=>'Faq Summary',
                'description'=>'Faq Description',
                'page_type'=>'faq',
                'status'=>'active'
            ),
            array(
                'title'=>'Privacy And Policy',
                'slug'=>\Str::slug('Privacy And Policy'),
                'summary'=>'Privacy And Policy Summary',
                'description'=>'Privacy And Policy Description',
                'page_type'=>'privacy_and_policy',
                'status'=>'active'
            ),
            array(
                'title'=>'Terms And Aggrement',
                'slug'=>\Str::slug('Terms And Aggrement'),
                'summary'=>'Terms And Aggrement Summary',
                'description'=>'Terms And Aggrement Description',
                'page_type'=>'terms_and_aggrement',
                'status'=>'active'
            ),
            array(
                'title'=>'Blog',
                'slug'=>\Str::slug('Blog'),
                'summary'=>'Blog Summary',
                'description'=>'Blog Description',
                'page_type'=>'blog',
                'status'=>'active'
            )
        );

        foreach($list as $page_info)
        {
            if(Page::where('slug',$page_info['slug'])->count() <=0)
            {
                $page=new Page();
                $page->fill($page_info);
                $page->save();
            }
        }
    }
}
