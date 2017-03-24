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
        $stmt = $db->query('select id as value, bezeichnung as text from tourplan order by bezeichnung');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        while($row = $stmt->fetch()){
            $result[] = $row;
        }
        return $result;
    }
}