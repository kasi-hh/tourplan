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

    public function getAdressen() {
        $result = [];
        $db = $this->getDb();
        $stm = $db->query('SELECT * FROM adressen ORDER BY name');
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        while ($row = $stm->fetch()) {
            $result[] = $row;
        }
        return $result;
    }

    public function updateColumn($rowId, $columnName, $value) {
        if (!in_array($columnName, ['name', 'stasse', 'plz', 'ort', 'telefon', 'besonderheit', 'aufenthalt', 'rollator', 'tourname_id'])) {
            throw  new \Exception('Invalid Column Name');
        }
        $db = $this->getDb();
        $stmt = $db->prepare("update adressen set $columnName = ? where id=?");
        $result = $stmt->execute([$value, $rowId]);
        return $result ? $result : $stmt->errorInfo();
    }

    public function create($tournameId, $name, $strasse, $plz, $ort, $telefon, $besonderheiten, $rollator, $aufenthalt) {
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO adressen (tourname_id,name,strasse,plz,ort,telefon,besonderheiten,rollator,aufenthalt) VALUES(?,?,?,?,?,?,?,?,?)');
        $result = $stmt->execute([$tournameId,$name, $strasse, $plz, $ort, $telefon, $besonderheiten, $rollator, $aufenthalt]);
        return $result ? $result : $stmt->errorInfo();
    }

    public function delete($id) {
        $db = $this->getDb();
        $stmt = $db->prepare('DELETE FROM adressen WHERE id = ?');
        $result = $stmt->execute([$id]);
        return $result ? $result : $stmt->errorInfo();
    }

    public function getAdressenNames($tournameId = '') {
        $db = $this->getDb();
        $result = [];
        $stmt = $db->query('SELECT id AS value, name AS text, tourname_id FROM adressen ORDER BY name');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            if ($tournameId) {
                if ($tournameId == $row['tourname_id']) {
                    $result[] = $row;
                }
            } else {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getAdresse($id) {
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM adressen WHERE id = ?');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

}