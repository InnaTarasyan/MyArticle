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

        // This is going to be a crone job !!!

        $url = "http://www.tert.am/";
        $html = file_get_contents( $url );

        $dom = new DOMDocument();
        @$dom->loadHTML( $html );
        $xpath = new DOMXPath( $dom );

        $hrefs= $xpath->query( '//p[@class="today-title"]//a/@href' );


        if( $hrefs ) {


                 // url of article
                 $artUrl = $hrefs[0]->nodeValue;

                 echo $artUrl . '</br>';
                 $artHtml = file_get_contents($artUrl);

                 $artDom = new DOMDocument();
                 @$artDom->loadHTML($artHtml);
                 $artXpath = new DOMXPath($artDom);

                 $titlePath = $artXpath->query('//div[@id="item"]//h1');
                 $title = $titlePath[0]->nodeValue . '<br/>';
                 echo $title;


                 $datePath = $artXpath->query('//p[@class="n-d"]');
                 $date = $datePath[0]->nodeValue . '<br/>';
                 echo $date;


                 $imagePath = $artXpath->query('//div[@class="i-content"]//img/@src');
                 $image = $imagePath[0]->nodeValue;
                 echo $image . '<br/>';
//                $path= storage_path('article/'.substr($artUrl, -7).'.jpg');
//                File::isDirectory($path) or  File::makeDirectory(storage_path('article/'), 0777, true, true);
//                $image->save($path);


                 // article text
                 $articleText = $artXpath->query('//div[@class="i-content"]//p');

                 if ($articleText) {
                     foreach ($articleText as $ref) {
                         echo $ref->nodeValue . '<br/>';

                     }
                 }
             }


        }



}