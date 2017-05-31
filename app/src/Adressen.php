<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 22.03.2017
 * Time: 17:14
 */

namespace App;


class Adressen extends Base {
    protected $container;

    public function getAdressen($name = ''){
        $result = [];
        $db = $this->getDb();
        $stm = $db->query('select * from adressen order by name');
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        while($row = $stm->fetch()){
            if ($name){
                if ($name == $row['tourname']){
                    $result[] = $row;
                }
            }
            else {
                $result[] = $row;
            }
        }
        return $result;
    }
    public function updateColumn($rowId, $columnName, $value){
        if (!in_array($columnName,['name','stasse','plz','ort','telefon','besonderheit','aufenthalt','rollator', 'tourname'])){
            throw  new \Exception('Invalid Column Name');
        }
        $db = $this->getDb();
        $stmt = $db->prepare("update adressen set $columnName = ? where id=?");
        $result = $stmt->execute([$value,$rowId]);
        return $result ? $result : $stmt->errorInfo();
    }
    public function create($name, $strasse, $plz, $ort, $telefon, $besonderheiten, $rollator,$aufenthalt){
        $db = $this->getDb();
        $stmt = $db->prepare('insert into adressen (name,strasse,plz,ort,telefon,besonderheiten,rollator,aufenthalt) values(?,?,?,?,?,?,?,?)');
        $result = $stmt->execute([$name, $strasse, $plz, $ort, $telefon, $besonderheiten, $rollator, $aufenthalt]);
        return $result ? $result : $stmt->errorInfo();
    }
    public function delete($id){
        $db = $this->getDb();
        $stmt = $db->prepare('delete from adressen where id = ?');
        $result = $stmt->execute([$id]);
        return $result ? $result : $stmt->errorInfo();
    }
    public function getAdressenNames($tourname = ''){
        $db = $this->getDb();
        $result = [];
        $stmt = $db->query('select id as value, name as text, tourname from adressen order by name');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        while($row = $stmt->fetch()){
            if ($tourname){
                if ($tourname == $row['tourname']){
                    $result[] = $row;
                }
            }
            else {
                $result[] = $row;
            }
        }
        return $result;
    }
    public function getAdresse($id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * from adressen where id = ?');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

}