<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 17:11
 */

namespace Controller;


class AdressenController extends BaseController {

    public function getData(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $result = [];
        $adressen = new \App\Adressen($this->container);
        $result = $adressen->getAdressen();
        return $response->withJson(['success'=>true,'data'=>$result]);
    }
    public function update(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $column = $request->getParsedBodyParam('column');
        $id = $request->getParsedBodyParam('id');
        $value = $request->getParsedBodyParam('value');
        $adressen = new \App\Adressen($this->container);
        $result = $adressen->updateColumn($id, $column,$value);
        return $response->withJson(['success'=>$result]);
    }
    public function create(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $adressen = new \App\Adressen($this->container);
        $result = $adressen->create(
            $request->getParsedBodyParam('name'),
            $request->getParsedBodyParam('strasse'),
            $request->getParsedBodyParam('plz'),
            $request->getParsedBodyParam('ort'),
            $request->getParsedBodyParam('telefon'),
            $request->getParsedBodyParam('besonderheiten'),
            $request->getParsedBodyParam('rollator'),
            $request->getParsedBodyParam('aufenthalt')
        );
        return $response->withJson(['success'=>$result]);
    }
    public function delete(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $adressen = new \App\Adressen($this->container);
        $adressen->delete($request->getParsedBodyParam('id'));
        return $response->withJson(['success'=>true]);
    }

}