<?php

class Excel_create extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('excel');
        $this->load->helper('file');
        $this->load->helper('download');
    }

    public function create_one() {
        $buyer_result = $this->db->get('buyer_directory')->result_array();
        $obj_php_excel = new PHPExcel();
        $obj_php_excel->setActiveSheetIndex(0)->fromArray($buyer_result);
        $obj_php_excel->getActiveSheet()->setTitle('test worksheet');
        $filename = 'just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        $objWriter = PHPExcel_IOFactory::createWriter($obj_php_excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function create_two() {
        $buyer_result = $this->db->get('buyer_directory')->result_array();
        $obj_php_excel = new PHPExcel();
        $obj_php_excel->setActiveSheetIndex(0)->fromArray($buyer_result);

        $obj_php_excel->getActiveSheet()->getStyle('A1:E1')
                ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FF0000');

        // Excel file protection start
        $obj_php_excel->getActiveSheet()->getProtection()->setSheet(true);
        $obj_php_excel->getActiveSheet()->getProtection()->setSort(true);
        $obj_php_excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $obj_php_excel->getActiveSheet()->getProtection()->setFormatCells(true);
        $obj_php_excel->getActiveSheet()->getProtection()->setPassword('password');
        // Excel file protection end
        // Auto size column width start 
        for ($col = 'A'; $col !== 'K'; $col++) {
            $obj_php_excel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }
        // Auto size column width end
        // Watermark add start
        $objDrawing = new PHPExcel_Worksheet_Drawing;
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('./image_sample.png');
        $objDrawing->setHeight(800);
        $objDrawing->setWidth(800);
        $objDrawing->setWorksheet($obj_php_excel->getActiveSheet());
        // Watermark add end
        // Save excel file to hard disk. In case of codeigniter it is root directory.
        $objWriter = PHPExcel_IOFactory::createWriter($obj_php_excel, 'Excel5');
        $name = 'abcde';
        $result = $objWriter->save("excel_file/$name.xls");
        var_dump($result);
    }

}
