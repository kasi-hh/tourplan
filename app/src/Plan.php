<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 22.03.2017
 * Time: 17:14
 */

namespace App;


class Plan extends Base {

    public function getRow($id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * from tourdaten where id = ?');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function getPrevRow($planId, $num){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * from tourdaten where plan_id = ? and num < ? order by num desc limit 1');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$planId,$num]);
        return $stmt->fetch();
    }
    public function getLastNum($planId){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT MAX(num) AS last_num FROM tourdaten WHERE plan_id = ?');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$planId]);
        $row = $stmt->fetch();
        return $row ? $row['last_num'] : '0';
    }
    public function getTour($id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT p.id,a.name, p.destination AS ort, p.distance_text AS strecke, p.duration_text AS zeit FROM tourdaten p LEFT JOIN adressen a ON a.id=p.adresse_id WHERE p.plan_id = ? ORDER BY p.num ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$id]);
        $result = [];
        while($row = $stmt->fetch()){
            $result[] = $row;
        }
        return $result;
    }
    public function add($planId, $adrId, $num, $destination){
        $db = $this->getDb();
        $stmt = $db->prepare('insert into tourdaten (plan_id,adresse_id,num,destination) values(?,?,?,?)');
        $result = $stmt->execute([$planId, $adrId, $num, $destination]);
        return $result ? $db->lastInsertId() : $stmt->errorInfo();

    }
    public function setDistance(array $row){
        $prev = $this->getPrevRow($row['plan_id'],$row['num']);
        $maps = new \App\GoogleMaps($this->container);
        $data = $maps->getDistance($prev['destination'],$row['destination']);
        $db = $this->getDb();
        $stmt = $db->prepare('update tourdaten set destination = ?,distance_text = ?,distance_value=?,duration_text = ?,duration_value = ? where id = ?');
        $result = $stmt->execute([
            $data['destination'],
            $data['distance_text'],
            $data['distance_value'],
            $data['duration_text'],
            $data['duration_value'],
            $row['id']
        ]);
        return $result ? $result : $stmt->errorInfo();
    }
}