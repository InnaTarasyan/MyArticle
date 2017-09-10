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
    protected function grab($url){

        $html = file_get_contents( $url );
        $dom = new DOMDocument();
        @$dom->loadHTML( $html );
        $xpath = new DOMXPath( $dom );
        $hrefs= $xpath->query( '//div[@class="news-blocks"]/a[1]/@href');
        return $hrefs;
    }
    protected function getData()
    {
        $urls = array();
        // Start date
        $date = '2016/02/01';
        // End date
        $end_date = '2016/05/01';

        $base_url = "http://www.tert.am/am/news/";

        while (strtotime($date) <= strtotime($end_date)) {
            $urls[] = $base_url . $date;
            $date = date("Y/m/d", strtotime("+1 day", strtotime($date)));
        }


        $count = 0;
        foreach ($urls as $url) {
            $hrefs = $this->grab($url);

            if ($hrefs) {
                if ($count < 1000) {
                    foreach ($hrefs as $ref) {
                        if ($count < 1000) {
                            $urls[] = $ref->nodeValue;
                            $count++;
                        } else {
                            break;
                        }

                    }
                }

            }


        }

        return $urls;

    }

    public function populate(){
        $hrefs = $this->getData();

        dd($hrefs);

        foreach ($hrefs as $href) {

            $data = [];

            // url of article
            $artUrl = $href->nodeValue;

            $data['url'] = $artUrl;
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
            $date = $datePath[0]->nodeValue;
            $time = substr($date, 0, 5);
            $dateT = substr($date, -8, 10);
            $data['data'] = $dateT . ' ' . $time;


            // article image
            $imagePath = $artXpath->query('//div[@class="i-content"]//img/@src');
            $image = $imagePath[0]->nodeValue;
            $img = Image::make($image);
            $path = public_path('/img/' . substr($artUrl, -7) . '.jpg');
            $data['main_image'] = $path;
            File::isDirectory($path) or File::makeDirectory(asset('img/'), 0777, true, true);
            $img->save($path);


            // article text
            $articleText = $artXpath->query('//div[@class="i-content"]//p');

            if ($articleText) {
                $desc = '';
                foreach ($articleText as $ref) {
                    $desc .= $ref->nodeValue;

                }
                $data['description'] = $desc;
            }

            Article::create($data);

        }
    }


}