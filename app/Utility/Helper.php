<?php

use App\Models\Category;
    function uploadImage($image,$dir,$thumb="50x50")
    {
        list($thumb_width,$thumb_height)=explode("x",$thumb);
        
        $path=public_path().'/Uploads/'.$dir;
        if(!File::exists($path))
        {
            File::makeDirectory($path,0777,true,true);
        }

        $image_name=ucfirst($dir)."-".date("YmdHis")."-".rand(0,9999).".".$image->getClientOriginalExtension();

        $status=$image->move($path,$image_name);
        if($status)
        {
            Image::make($path."/".$image_name)->resize($thumb_width,$thumb_height,function($constraint){
                return $constraint->aspectRatio();
            })->save($path."/".$image_name);

            return $image_name;
        }
        else
        {
            return null;
        }
    }

     function deleteImage($image,$dir)
    {
        $path=public_path()."/Uploads/".$dir."/".$image;
        if(file_exists($path))
        {
            unlink($path);
        }
    }

    function getMenu()
    {
        $category=new Category();
        $category=$category->getActiveParentCat();

        if($category->count() >0)
        {
            foreach($category as $cat_info)
            {
                if($cat_info->getChild->count() >0)
                {
                    ?>
                        <div class="mega-column">
                          <h4 class="mega-heading"><?php echo $cat_info->title?></h4>
                          <ul class="mega-item">
                            <?php
                                foreach($cat_info->getChild as $child)
                                {
                                    ?>
                                    <li><a href="<?php echo route('child-list',[$cat_info->slug,$child->slug])?>"><?php echo $child->title?></a></li>
                                    <?php
                                }
                            ?>
                          </ul>
                        </div>
                    <?php
                }
                else
                {
                    ?>
                        <div class="mega-column">
                            <div class="mega-heading">
                                <a href="<?php echo route('parent-list',$cat_info->slug)?>">
                                    <?php echo $cat_info->title?>
                                </a>
                            </div>
                        </div>
                    <?php
                }
            }
        }
        else
        {
            ?>
                        <div class="mega-column">
                            <div class="mega-heading">
                                <p>Sorry! No Category Avialable At The Moment...</p>
                            </div>
                        </div>
            <?php
        }
    }
?>