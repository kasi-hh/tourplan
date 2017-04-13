<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 17:11
 */

namespace Controller;


class TourenController extends BaseController {

    public function load(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $touren = new \App\Touren($this->container);
        $data = $touren->load();
        return $response->withJson(['success'=>true,'data'=>$data]);
    }
    public function create(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $name = $request->getParsedBodyParam('name');
        $touren = new \App\Touren($this->container);
        $result = $touren->create($name);
        return $response->withJson(['success'=>$result]);
    }
    public function delete(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $id = $request->getParsedBodyParam('id');
        $touren = new \App\Touren($this->container);
        $result = $touren->delete($id);
        return $response->withJson(['success'=>$result]);
    }
    public function update(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $id = $request->getParsedBodyParam('id');
        $value = $request->getParsedBodyParam('value');
        $touren = new \App\Touren($this->container);
        $result = $touren->update($id, $value);
        return $response->withJson(['success'=>$result]);
    }
}