<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 22.03.2017
 * Time: 17:14
 */

namespace App;


class Base {
    /** @var \Slim\Container  */
    protected $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }
    /** @return \PDO */
    protected function getDb(){
        return $this->container->get('db');
    }
}