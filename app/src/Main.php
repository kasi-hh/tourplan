<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 22.03.2017
 * Time: 17:14
 */

namespace App;


class Main extends Base {
    protected $container;

    public function getAusgabe($tournameId, $datum){
        $datum = (new \DateTime($datum))->format('Y-m-d');
        $tournameId = (int) $tournameId;
        $result = [];
        $db = $this->getDb();
        $stm = $db->prepare('select td.id,a.aufenthalt, a.name,td.origin,td.destination, td.distance_text, td.distance_value,td.duration_text,td.duration_value from tourdaten td left join adressen a on a.id = td.adresse_id where td.tourname_id = ? and td.datum = ? order by td.num');
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute([$tournameId, $datum]);
        $lastDestination = '';
        while($row = $stm->fetch()){
            $secs = (int)$row['duration_value'];
            $length = (int) $row['distance_value'];
            $hours = floor($secs / 3600);
            $secs %= 3600;
            $min = floor($secs / 60);
            $seconds = $secs % 60;
            if ($seconds > 30) {
                $min += 1;
            }
            $data = [
                'id'=>$row['id'],
                'target'=>$row['name'] .'<br>'.$row['destination'],
                'saddr'=>urlencode($lastDestination),
                'daddr'=>urlencode($row['destination']),
                'dauer'=> $hours.':'.str_pad($min,2,'0',STR_PAD_LEFT),
                'km'=>number_format($length / 1000,2,',',''),
                'extra'=>'0',
                'zeit'=>'0:00',
                'duration'=>$row['duration_value'],
                'distance'=>$row['distance_value'],
                'aufenthalt'=>$row['aufenthalt'],
            ];
            $lastDestination = $row['destination'];
            $result[] = $data;
        }
        return $result;
    }
}