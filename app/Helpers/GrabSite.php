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

                echo $artUrl.'</br>';
                $artHtml = file_get_contents( $artUrl );

                $artDom = new DOMDocument();
                @$artDom->loadHTML( $artHtml );
                $artXpath = new DOMXPath( $artDom);

                $h= $artXpath->query( '//div[@id="item"]//h1' );

                //title of article
                if($h){
                    foreach ($h as $ref) {
                        echo $ref->nodeValue.'<br/>';
                    }
                }

                //date
                $h= $artXpath->query( '//p[@class="n-d"]' );
                if($h){
                    foreach ($h as $ref) {
                        echo $ref->nodeValue.'<br/>';
                    }
                }

                //image
                $h= $artXpath->query( '//div[@class="i-content"]//img/@src' );

                if($h){
                    foreach ($h as $ref) {
                        echo $ref->nodeValue.'<br/>';
                        $img = Image::make($ref->nodeValue);
                        $path= storage_path('article/'.substr($artUrl, -7).'.jpg');
                        File::isDirectory($path) or  File::makeDirectory(storage_path('article/'), 0777, true, true);
                        $img->save($path);
                    }
                }


            // article text
            $h= $artXpath->query( '//div[@class="i-content"]//p' );

            if($h){
                foreach ($h as $ref) {
                    echo $ref->nodeValue.'<br/>';

                }
            }


        }


    }
}