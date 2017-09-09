<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08/Sep/2017
 * Time: 19:26
 */

use App\Article;

class GrabSite
{
    public function getData(){

        // This is going to be a crone job !!!

        $url = "http://www.tert.am/";
        $html = file_get_contents( $url );

        $dom = new DOMDocument();
        @$dom->loadHTML( $html );
        $xpath = new DOMXPath( $dom );

        $hrefs= $xpath->query( '//p[@class="today-title"]//a/@href' );


        if( $hrefs ) {

                 $data = [];

                 // url of article
                 $artUrl = $hrefs[37]->nodeValue;

                 $data['url']= $artUrl;
                 $artHtml = file_get_contents($artUrl);

                 $artDom = new DOMDocument();
                 @$artDom->loadHTML($artHtml);
                 $artXpath = new DOMXPath($artDom);

                 // article title
                 $titlePath = $artXpath->query('//div[@id="item"]//h1');
                 $title = $titlePath[0]->nodeValue;
                 $data['title'] = $title;

                 // article date
                 $datePath = $artXpath->query('//p[@class="n-d"]');
                 $date = $datePath[0]->nodeValue ;
                 $data['data'] = $date;
                 $time =  substr($data['data'], 0,5);
                 $dateT =  substr($data['data'],-8,10);
                 $data['data'] = $dateT.' : '.$time;


                 // article image
                 $imagePath = $artXpath->query('//div[@class="i-content"]//img/@src');
                 $image = $imagePath[0]->nodeValue;
                 $img = Image::make($image);
                 $path= public_path('/img/'.substr($artUrl, -7).'.jpg');
                 $data['main_image'] = $path;
                 File::isDirectory($path) or  File::makeDirectory(asset('img/'), 0777, true, true);
                 $img->save($path);


                 // article text
                 $articleText = $artXpath->query('//div[@class="i-content"]//p');

                 if ($articleText) {
                     $desc = '';
                     foreach ($articleText as $ref) {
                         $desc.= $ref->nodeValue;

                     }
                     $data['description'] = $desc;
                 }

                 Article::create($data);

             }


        }



}