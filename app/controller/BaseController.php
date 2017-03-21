<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 17:24
 */

namespace Controller;


class BaseController {

    /** @var  \Slim\Container */
    protected $container;

    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }
}