<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 22.03.2017
 * Time: 17:14
 */

namespace App;


class Touren extends Base {
    protected $container;

    public function getTourNames(){
        $db = $this->getDb();
        $result = [];
        $stmt = $db->query('select id as value, bezeichnung as text from tournamen order by bezeichnung');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        while($row = $stmt->fetch()){
            $result[] = $row;
        }
        return $result;
    }
    public function getTour($id){
        $db = $this->getDb();
        $stmt = $db->prepare('select * from tournamen where id = ?');
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }
    public function load(){
        $db = $this->getDb();
        $stmt = $db->query('select * from tournamen order by bezeichnung');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
    public function create($name){
        $db = $this->getDb();
        $stmt = $db->prepare('insert into tournamen (bezeichnung) values(?)');
        return $stmt->execute([$name]);
    }
    public function delete($id){
        $plan = new \App\Plan($this->container);
        $plan->deletePlan($id);
        $db = $this->getDb();
        $stmt = $db->prepare('delete from tournamen where id = ?');
        $result = $stmt->execute([$id]);
        return $result;
    }
    public function update($id, $bezeichnung){
        $db = $this->getDb();
        $stmt = $db->prepare("update tournamen set bezeichnung = ? where id=?");
        $result = $stmt->execute([$bezeichnung,$id]);
        return $result ? $result : $stmt->errorInfo();
    }

}