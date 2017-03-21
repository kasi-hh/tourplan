<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 17:11
 */

namespace Controller;


class GoogleController extends BaseController {
    public function getDistance(\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        $from = $request->getParsedBodyParam('from', false);
        $to = $request->getParsedBodyParam('to', false);
        if (!$from || !$to) return $response->withJson(['status'=>'failed']);
        $maps = new \App\GoogleMaps();
        $data = $maps->getDistance($from, $to, $this->container);
        return $response->withJson($data);
    }
}