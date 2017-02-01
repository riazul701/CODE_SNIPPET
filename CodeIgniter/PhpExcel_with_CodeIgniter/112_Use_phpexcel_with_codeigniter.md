Web Address: https://arjunphp.com/how-to-use-phpexcel-with-codeigniter/

PHPExcel is a pure PHP library for reading and writing spreadsheet files and CodeIgniter is one of the well known PHP MVC framework. Here i am gonna show you how to Integrate PHPEXcel library in CodeIgniter.

Setp1 : Download and setup CodeIgniter.(download it here: https://ellislab.com/codeigniter)
Setp2 : Download PHPExcel.(download it here: http://phpexcel.codeplex.com/)
Setp3 : Unzip or extract the downloaded PHPExcel lib files and copy Class directory inside files to application/third-party directory(folder).
setp3: Now create one file called EXcel.php in application/library folder [application/library/Excel.php]. Then include PHPExcel Class to it. see how i did it below

```php
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/PHPExcel.php";
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}
```

That’s it now you can use PHPEXcel methods inside your CodeIgniter application.But you should load it before using it methods(Ex: $this->load->library(‘excel’);)

###### How to read excel file

```php
$file = './files/test.xlsx';
//load the excel library
$this->load->library('excel');
//read file from path
$objPHPExcel = PHPExcel_IOFactory::load($file);
//get only the Cell Collection
$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
//extract to a PHP readable array format
foreach ($cell_collection as $cell) {
    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
    //header will/should be in row 1 only. of course this can be modified to suit your need.
    if ($row == 1) {
        $header[$row][$column] = $data_value;
    } else {
        $arr_data[$row][$column] = $data_value;
    }
}
//send the data in an array format
$data['header'] = $header;
$data['values'] = $arr_data;
 
```

###### How to Create excel file on the file

```php
//load our new PHPExcel library
$this->load->library('excel');
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//name the worksheet
$this->excel->getActiveSheet()->setTitle('test worksheet');
//set cell A1 content with some text
$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
//change the font size
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
//make the font become bold
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//merge cell A1 until D1
$this->excel->getActiveSheet()->mergeCells('A1:D1');
//set aligment to center for that merged cell (A1 to D1)
$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$filename='just_some_random_name.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
            
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');
 
```

That’s it.

I hope you like this Post, Please feel free to comment below, your suggestion and problems if you face - we are here to solve your problems.

