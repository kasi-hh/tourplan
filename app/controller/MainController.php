<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 17:11
 */

namespace Controller;


class MainController extends BaseController {

    public function getData(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $result = [];
        $people = new \App\Adressen($this->container);
        $touren = new \App\Touren($this->container);
        $adressen = new \App\Adressen($this->container);
        $result['adressen'] = $people->getAdressen();
        $result['tournames'] = $touren->getTourNames();
        $result['adressnames'] = $adressen->getAdressenNames();
        return $response->withJson($result);
    }
}