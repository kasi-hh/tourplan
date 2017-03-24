<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 16:59
 */

namespace App;


class GoogleMaps extends Base {

    public function getDistance($from, $to){
        $mapsAPIKey = $this->container->get('config')['google']['apikey'];
        $url = sprintf('https://maps.googleapis.com/maps/api/distancematrix/json?origins=%s&destinations=%s&mode=driving&language=de&key=%s', urlencode($from), urlencode($to), $mapsAPIKey);
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
        $data = json_decode($content,true);
        $result = [];
        $status = $result['status'] = $data['status'];
        if (strtoupper($status) == 'OK') {
            $result['destination'] = $data['destination_addresses'][0];
            $result['origin'] = $data['origin_addresses'][0];
            $element = $data['rows'][0]['elements'][0];
            if (strtoupper($element['status']) == 'OK'){
                $result['distance_text'] = $element['distance']['text'];
                $result['distance_value'] = $element['distance']['value'];
                $result['duration_text'] = $element['duration']['text'];
                $result['duration_value'] = $element['duration']['value'];
            }
        }
        return $result;
    }
    public function getAdressDistance(array $origin, array $destionation){
        return $this->getDistance(
            $origin['strasse'].','.$origin['plz'].' '.$origin['ort'].',Deutschland',
            $destionation['strasse'].','.$destionation['plz'].' '.$destionation['ort'].',Deutschland'
        );
    }
}