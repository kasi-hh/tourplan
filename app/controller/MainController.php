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
        $result['touren'] = $touren->load();
        return $response->withJson($result);
    }
    public function getAusgabe(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $result = [];
        $tournameId = $request->getParsedBodyParam('tourname_id');
        $datum = $request->getParsedBodyParam('datum');
        $main = new \App\Main($this->container);
        $result['data'] = $main->getAusgabe($tournameId, $datum);
        $result['success'] = true;
        return $response->withJson($result);
    }
}