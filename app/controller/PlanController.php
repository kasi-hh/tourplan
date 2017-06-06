<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 17:11
 */

namespace Controller;


class PlanController extends BaseController {

    public function getTour(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $id = $request->getParsedBodyParam('tourname_id');
        $datum = $request->getParsedBodyParam('datum');
        $plan = new \App\Plan($this->container);
        $data = $plan->getTour($id, $datum);
        return $response->withJson(['success'=>true,'data'=>$data]);
    }
    public function init(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $tournameId = $request->getParsedBodyParam('tourname_id');
        $datum = $request->getParsedBodyParam('datum');
        $datumInit = $request->getParsedBodyParam('init_datum');
        $plan = new \App\Plan($this->container);
        $result = $plan->init($tournameId, $datum, $datumInit);
        return $response->withJson(['success'=>$result]);
    }
    public function add(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $id = $request->getParsedBodyParam('id');
        $tournameId = $request->getParsedBodyParam('tourname_id');
        $datum = $request->getParsedBodyParam('datum');
        $adressen = new \App\Adressen($this->container);
        $plan = new \App\Plan($this->container);
        $num = $plan->getLastNum($tournameId, $datum)+1;
        $adresse = $adressen->getAdresse($id);
        $destination = $adresse['strasse'].','.$adresse['plz'].' '.$adresse['ort'];
        $result = $plan->add($tournameId,$adresse['id'],$num,$destination, $datum);
        if ($result && $num > 1){
            /** @var  $db */
            $row = $plan->getRow($result);
            $plan->setDistance($row);
        }
        return $response->withJson(['success'=>$result]);
    }
    public function delete(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $id = $request->getParsedBodyParam('id');
        $plan = new \App\Plan($this->container);
        $plan->delete($id);
        return $response->withJson(['success'=>true]);
    }
    public function recalc(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $tournameId = $request->getParsedBodyParam('tourname_id');
        $datum = $request->getParsedBodyParam('datum');
        $plan = new \App\Plan($this->container);
        $result = $plan->recalc($tournameId, $datum);
        return $response->withJson(['success'=>$result]);
    }

    public function setorder(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $order = $request->getParsedBodyParam('order');
        $tournameId = $request->getParsedBodyParam('tourname_id');
        $data = [];
        foreach($order as $entry){
            $temp =explode('-',$entry);
            $data[$temp[0]] = intval($temp[1])+1;
        }
        $plan = new \App\Plan($this->container);
        $result = $plan->setOrder($tournameId, $data);
        return $response->withJson(['success'=>$result]);
    }

}