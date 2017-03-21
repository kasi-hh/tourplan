<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 16:59
 */

namespace App;


class GoogleMaps {

    public function getDistance($from, $to, \Slim\Container $container){
        $mapsAPIKey = $container->get('config')['google']['apikey'];
        $url = sprintf('https://maps.googleapis.com/maps/api/distancematrix/json?origins=%s&destinations=%s&mode=car&language=de&key=%s', urlencode($from), urlencode($to), $mapsAPIKey);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HEADER, false); // header will be at output
        curl_setopt($curl, CURLOPT_NOBODY, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $content = curl_exec($curl);
        return json_decode($content,true);
    }
}