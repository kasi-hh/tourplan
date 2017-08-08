<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 17:11
 */

namespace Controller;


use App\Adressen;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet;

class AdressenController extends BaseController {

    public function getData(\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        $result = [];
        $adressen = new \App\Adressen($this->container);
        $result = $adressen->getAdressen();
        return $response->withJson(['success' => true, 'data' => $result]);
    }

    public function get(\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        $tournameId = $request->getParsedBodyParam('tourname_id');
        $people = new \App\Adressen($this->container);
        $result = ['success' => true];
        $result['adressen'] = $people->getAdressenNames($tournameId);
        return $response->withJson($result);
    }

    public function update(\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        $column = $request->getParsedBodyParam('column');
        $id = $request->getParsedBodyParam('id');
        $value = $request->getParsedBodyParam('value');
        $adressen = new \App\Adressen($this->container);
        $result = $adressen->updateColumn($id, $column, $value);
        return $response->withJson(['success' => $result]);
    }

    public function create(\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        $adressen = new \App\Adressen($this->container);
        $result = $adressen->create(
            $request->getParsedBodyParam('tourname_id'),
            $request->getParsedBodyParam('name'),
            $request->getParsedBodyParam('strasse'),
            $request->getParsedBodyParam('plz'),
            $request->getParsedBodyParam('ort'),
            $request->getParsedBodyParam('telefon'),
            $request->getParsedBodyParam('besonderheiten'),
            $request->getParsedBodyParam('rollator'),
            $request->getParsedBodyParam('aufenthalt')
        );
        return $response->withJson(['success' => $result]);
    }

    public function delete(\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        $adressen = new \App\Adressen($this->container);
        $adressen->delete($request->getParsedBodyParam('id'));
        return $response->withJson(['success' => true]);
    }

    protected function setSheetHeader(Worksheet $sheet, $values){
        $col = 65;
        foreach($values as $key =>$value){
            $sheet->setCellValue(chr($col+$key).'1', $value);
        }
    }
    protected function setColWidth(Worksheet $sheet, $widths){
        $chr = 65;
        foreach($widths as $key=>$width){
            $sheet->getColumnDimension(chr($chr+$key))->setWidth($width);
        }

    }
    public function getList(\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        $adressen = new Adressen($this->container);
        $excel = new Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Alle');
        $row = 2;
        $this->setSheetHeader($sheet,['Tour','Name','Straße','Plz','Ort','Telefon','Besonderheiten','Aufenthalt','Rollator']);
        $this->setColWidth($sheet,[15,20,20,15,25,20,20,20,20]);
        foreach($adressen->getList() as $adr){
            $sheet->setCellValue('A'.$row,$adr['bezeichnung']);
            $sheet->setCellValue('B'.$row,$adr['name']);
            $sheet->setCellValue('C'.$row,$adr['strasse']);
            $sheet->setCellValue('D'.$row,$adr['plz']);
            $sheet->setCellValue('E'.$row,$adr['ort']);
            $sheet->setCellValue('F'.$row,$adr['telefon']);
            $sheet->setCellValue('G'.$row,$adr['besonderheiten']);
            $sheet->setCellValue('H'.$row,$adr['aufenthalt']);
            $sheet->setCellValue('I'.$row,$adr['rollator'] == '1' ? 'Ja' : 'Nein');
            $row++;
        }

        $writer = IOFactory::createWriter($excel, 'Xlsx');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=adressliste.xlsx");
        header("Content-Transfer-Encoding: binary ");

        $writer->save('php://output');


    }
}