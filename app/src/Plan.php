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
    public function getLastNum($planId, $datum){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT MAX(num) AS last_num FROM tourdaten WHERE plan_id = ? and datum = ?');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$planId, $datum]);
        $row = $stmt->fetch();
        return $row ? $row['last_num'] : '0';
    }
    public function getTour($id, $datum){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT p.id,a.name,p.num,p.plan_id,p.destination AS ort, p.distance_text AS strecke, p.duration_text AS zeit FROM tourdaten p LEFT JOIN adressen a ON a.id=p.adresse_id WHERE p.plan_id = ? and p.datum = ? ORDER BY p.num ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$id,$datum]);
        $result = [];
        while($row = $stmt->fetch()){
            $result[] = $row;
        }
        return $result;
    }
    public function getTourRows($planId){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT p.* FROM tourdaten p WHERE p.plan_id = ? ORDER BY p.num ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$planId]);
        $result = [];
        while($row = $stmt->fetch()){
            $result[] = $row;
        }
        return $result;
    }
    public function add($planId, $adrId, $num, $destination, $datum){
        $db = $this->getDb();
        $stmt = $db->prepare('insert into tourdaten (plan_id,adresse_id,num,destination,datum) values(?,?,?,?,?)');
        $result = $stmt->execute([$planId, $adrId, $num, $destination,$datum]);
        return $result ? $db->lastInsertId() : $stmt->errorInfo();

    }
    public function delete($id){
        $db = $this->getDb();
        $row = $this->getRow($id);
        $stmt = $db->prepare('delete from tourdaten where id = ?');
        $result = $stmt->execute([$id]);
        $this->reorder($row['plan_id']);
        return $result;
    }
    public function setDistance(array $row){
        $prev = $this->getPrevRow($row['plan_id'],$row['num']);
        if (!$prev){
            return 'Prev nicht vorhanden';
        }
        $maps = new \App\GoogleMaps($this->container);
        $data = $maps->getDistance($prev['destination'],$row['destination']);
        if (strtoupper($data['status']) != 'OK'){
            return 'Maps fehlgeschlagen';
        }
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
    public function recalc($planId){
        $data = $this->getTourRows($planId);
        $counter = 0;
        foreach($data as $row){
            if ($counter > 0){
                $this->setDistance($row);
            }
            else {
                $db = $this->getDb();
                $stmt = $db->prepare("update tourdaten set distance_text = '',distance_value =0, duration_text = '', duration_value = 0 where id = ?");
                $stmt->execute([$row['id']]);
            }
            $counter++;
        }
        return true;
    }
    public function reorder($planId){
        $data = $this->getTourRows($planId);
        $db = $this->getDb();
        $counter = 1;
        $stmt = $db->prepare('update tourdaten set num = ? where id = ?');
        foreach($data as $row){
            $stmt->execute([$counter,$row['id']]);
            $counter++;
        }
    }

    public function setOrder($planId, array $data){
        $db = $this->getDb();
        $stmt = $db->prepare('update tourdaten set num = ? where id = ?');
        foreach($data as $id => $order){
            $stmt->execute([$order,$id]);
        }
        return true;
    }
    public function deletePlan($planId){
        $db = $this->getDb();
        $stmt = $db->prepare('delete from tourdaten where plan_id = ?');
        $result = $stmt->execute([$planId]);
        return $result;
    }
}