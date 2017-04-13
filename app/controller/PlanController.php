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
        $id = $request->getParsedBodyParam('id');
        $plan = new \App\Plan($this->container);
        $data = $plan->getTour($id);
        return $response->withJson(['success'=>true,'data'=>$data]);
    }
    public function add(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $id = $request->getParsedBodyParam('id');
        $planId = $request->getParsedBodyParam('plan_id');
        $adressen = new \App\Adressen($this->container);
        $plan = new \App\Plan($this->container);
        $num = $plan->getLastNum($planId)+1;
        $adresse = $adressen->getAdresse($id);
        $destination = $adresse['strasse'].','.$adresse['plz'].' '.$adresse['ort'];
        $result = $plan->add($planId,$adresse['id'],$num,$destination);
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
        $planId = $request->getParsedBodyParam('plan_id');
        $plan = new \App\Plan($this->container);
        $result = $plan->recalc($planId);
        return $response->withJson(['success'=>$result]);
    }

    public function setorder(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $order = $request->getParsedBodyParam('order');
        $planId = $request->getParsedBodyParam('plan_id');
        $data = [];
        foreach($order as $entry){
            $temp =explode('-',$entry);
            $data[$temp[0]] = intval($temp[1])+1;
        }
        $plan = new \App\Plan($this->container);
        $result = $plan->setOrder($planId, $data);
        return $response->withJson(['success'=>$result]);
    }

}