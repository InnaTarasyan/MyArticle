<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08/Sep/2017
 * Time: 19:26
 */

class GrabSite
{
    public function getData(){
        $img = Image::make('http://www.tert.am/news_images/826/2477835_1/8e32f749936471e696b1802b2d391fd7_3131.jpg');
        $path= storage_path('article/d.jpg');
        File::isDirectory($path) or  File::makeDirectory(storage_path('article/'), 0777, true, true);
        $img->save($path);
    }
}