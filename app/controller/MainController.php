<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 17:11
 */

namespace Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Color;

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
    public function createExcel(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $data = $request->getParsedBodyParam('data');
        $datum = $request->getParsedBodyParam('datum');
        $tour = $request->getParsedBodyParam('tour');
        //include __DIR__.'/../../excel.php';
        try {
            $spreadsheet = new Spreadsheet();

            $spreadsheet->getProperties()
                ->setCreator('Schuchardt')
                ->setLastModifiedBy('Schuchardt')
                ->setTitle('Tourenplan')
                ->setSubject('Tourenplan')
                ->setDescription('Tourenplan.')
                ->setKeywords('tourenplan')
                ->setCategory('Tourenplan');

            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', $tour);
            $sheet->setCellValue('C1', $datum);
            $startRow = 3;
            $rowNum = $startRow;
            $sheet->setCellValue('A' . $rowNum, 'Start');
            $sheet->setCellValue('B' . $rowNum, 'Name');
            $sheet->setCellValue('C' . $rowNum, 'KM');
            $sheet->setCellValue('D' . $rowNum, 'Minuten');
            $sheet->setCellValue('E' . $rowNum, 'Aufenthalt');
            $sheet->setCellValue('F' . $rowNum, 'Extra');
            $rowNum++;
            foreach ($data as $row) {
                $start = $row['start'];
                $name = str_replace('<br>', ', ', $row['name']);
                $km = (float)str_replace(',', '.', $row['km']);
                $min = $row['min'];
                $auf = $row['auf'];
                $extra = $row['extra'];
                $sheet->setCellValue('A' . $rowNum, $start);
                $sheet->setCellValue('B' . $rowNum, $name);
                $sheet->setCellValue('C' . $rowNum, $km);
                $sheet->setCellValue('D' . $rowNum, $min);
                $sheet->setCellValue('E' . $rowNum, $auf);
                $sheet->setCellValue('F' . $rowNum, $extra);
                $rowNum++;
            }
            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(100);
            $sheet->getColumnDimension('C')->setWidth(10);
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(10);
            $rowNum += 1;
            $sheet->getStyle('C' . $startRow . ':C' . $rowNum)
                ->getNumberFormat()
                ->setFormatCode(
                    \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00
                );
            $sheet->setCellValue('C' . $rowNum, '=SUM(C' . $startRow . ':C' . $rowNum . ')');
            $writer = IOFactory::createWriter($spreadsheet, 'xlsx');
            $writer->save(__DIR__ . '/../../public/excel.xlsx');
        }
        catch (\Exception $e){
            return $response->withJson(['success'=>false,'message'=>$e->getMessage()]);
        }
        return $response->withJson(['success'=>true]);
    }
    public function getExcel(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        //header("Content-Type: application/force-download");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        //header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=tour.xml");
        header("Content-Transfer-Encoding: binary ");
        echo file_get_contents( __DIR__.'/../../public/excel.xml');
        exit;
    }
}