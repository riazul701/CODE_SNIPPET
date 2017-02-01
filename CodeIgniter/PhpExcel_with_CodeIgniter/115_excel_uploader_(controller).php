<?php

class Excel_uploader extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('excel');
    }

    // This function remove empty row from single worksheet
    public function remove_empty_row_single_worksheet($data = "") {
        foreach ($data as $row_key => $row_value) {
            $empty_value_check = "";
            foreach ($row_value as $column_key => $column_value) {
                if (($column_value == "") || $column_value == NULL) {
                    $empty_value_check .= "";
                } else {
                    $empty_value_check .= $column_value;
                }
            }
            if ($empty_value_check == "") {
                unset($data[$row_key]);
            }
        }
        sort($data);
        return $data;
    }

    // This function process single worksheet from a workbook. Stores data in an Array.
    public function single_worksheet_process($input_file_name = "", $worksheet_name = "", $minimum_column = 1) {
//        $input_file_name = 'D:/xampp/htdocs/ptest_1/excel_file/test_3.xlsx';
//        $worksheet_name = 'Belgium';
        $input_file_type = PHPExcel_IOFactory::identify($input_file_name);
        $obj_reader = PHPExcel_IOFactory::createReader($input_file_type);

        $obj_php_excel = $obj_reader->load($input_file_name);
        $highest_row = $obj_php_excel->getSheetByName("$worksheet_name")->getHighestRow();

        $highest_column_temp = $obj_php_excel->getSheetByName("$worksheet_name")->getHighestColumn();
        $highest_column = PHPExcel_Cell::columnIndexFromString($highest_column_temp);
        if ($highest_column < $minimum_column) {
            $highest_column = $minimum_column;
        }
        // Row begin from '1' in Excel file
        for ($row = 1; $row <= $highest_row; $row++) {
            // Column begin from '0' in Excel file
            for ($column = 0; $column < $highest_column; $column++) {
                $data[$row][$column] = $obj_php_excel->getSheetByName("$worksheet_name")->getCellByColumnAndRow($column, $row)->getValue();
                if ($data[$row][$column] === NULL) {
                    $data[$row][$column] = "";
                }
            }
        }
        $data = $this->remove_empty_row_single_worksheet($data);

        $highest_row = count($data);
        $this->single_worksheet_show($data, $highest_row, $highest_column, $worksheet_name);
    }

    // This function shows the Array that is created by $this->single_worksheet_process()
    public function single_worksheet_show($data, $highest_row, $highest_column, $worksheet_name) {
        echo '<table border="1">';
        $colspan_value = $highest_column + 1;
        echo '<tr>' . '<td colspan="' . $colspan_value . '" style="text-align: center; color: #800000; font-weight: bold; background-color: #DDDDDD;">' . $worksheet_name . '</td></tr>';
        echo '<tr><td>Serial</td>';
        for ($column = 0; $column < $highest_column; $column++) {
            echo '<td>' . $column . '</td>';
        }
        echo '</tr>';
        for ($row = 0; $row < $highest_row; $row++) {
            echo '<tr><td>' . $row . '</td>';
            for ($column = 0; $column < $highest_column; $column++) {
                echo '<td>';
                echo $data[$row][$column];
                echo '</td>';
            }
            echo '</tr>';
        }

        echo '</table>';
    }

    public function single_worksheet_process_caller() {
        $input_file_name = 'C:\Users\Laptop\Desktop\excel_file_test\file_one.xlsx';
        $worksheet_name = 'Sheet2';
        $minimum_column = 1;
        $this->single_worksheet_process($input_file_name, $worksheet_name, $minimum_column);
    }

    // This function remove empty row from every worksheet in whole workbook
    public function remove_empty_row_whole_workbook($data = "", $worksheet_dimension) {
        foreach ($data as $worksheet_key => $worksheet_value) {
            foreach ($worksheet_value as $row_key => $row_value) {
                $empty_value_check = "";
                foreach ($row_value as $column_key => $column_value) {
                    if (($column_value == "") || $column_value == NULL) {
                        $empty_value_check .= "";
                    } else {
                        $empty_value_check .= $column_value;
                    }
                }
                
                if ($empty_value_check == "") {
                    unset($data[$worksheet_key][$row_key]);
                }
            }
            sort($data[$worksheet_key]);
            $worksheet_dimension[$worksheet_key]['highest_row'] = count($data[$worksheet_key]);
        }
        // Do not sort 'Worksheet' that will cause problem
        $combine['data'] = $data;
        $combine['worksheet_dimension'] = $worksheet_dimension;
        return $combine;
    }

    // This function process whole workbook and stores data in an Array.
    public function whole_workbook_process($input_file_name = "", $minimum_column = 1) {
//        $input_file_name = 'D:/xampp/htdocs/ptest_1/excel_file/test_3.xlsx';

        $input_file_type = PHPExcel_IOFactory::identify($input_file_name);
        $obj_reader = PHPExcel_IOFactory::createReader($input_file_type);

        $obj_php_excel = $obj_reader->load($input_file_name);
        $worksheet_array = $obj_php_excel->getSheetNames();

        foreach ($worksheet_array as $worksheet) {
            $highest_row = $obj_php_excel->getSheetByName("$worksheet")->getHighestRow();
            $highest_column_temp = $obj_php_excel->getSheetByName("$worksheet")->getHighestColumn();
            $highest_column = PHPExcel_Cell::columnIndexFromString($highest_column_temp);
            if ($highest_column < $minimum_column) {
                $highest_column = $minimum_column;
            }
            $worksheet_dimension[$worksheet]['highest_row'] = $highest_row;
            $worksheet_dimension[$worksheet]['highest_column'] = $highest_column;
            // Row start from '1' in Excel file
            for ($row = 1; $row <= $highest_row; $row++) {
                // Column start from '0' in Excel file
                for ($column = 0; $column < $highest_column; $column++) {
                    $data[$worksheet][$row][$column] = $obj_php_excel->getSheetByName("$worksheet")->getCellByColumnAndRow($column, $row)->getValue();
                    if ($data[$worksheet][$row][$column] === NULL) {
                        $data[$worksheet][$row][$column] = "";
                    }
                }
            }
        }

        $combine = $this->remove_empty_row_whole_workbook($data, $worksheet_dimension);
        $data = $combine['data'];
        $worksheet_dimension = $combine['worksheet_dimension'];

        $this->whole_workbook_show($data, $worksheet_array, $worksheet_dimension);
//        $this->data_excel_to_db($data, $worksheet_array, $worksheet_dimension);
    }

    // This function show whole workbook that is stored by $this->whole_workbook_process()
    public function whole_workbook_show($data, $worksheet_array, $worksheet_dimension) {
        echo '<table border="1">';

        foreach ($worksheet_array as $worksheet) {
            $colspan_value = $worksheet_dimension[$worksheet]['highest_column'] + 1;
            echo '<tr>' . '<td colspan="' . $colspan_value . '" style="text-align: center; color: #800000; font-weight: bold; background-color: #DDDDDD;">' . $worksheet . '</td>' . '</tr>';
            echo '<tr><td>Serial</td>';
            for ($column = 0; $column < $worksheet_dimension[$worksheet]['highest_column']; $column++) {
                echo '<td>' . $column . '</td>';
            }
            echo '</tr>';
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                echo '<tr><td>' . $row . '</td>';
                for ($column = 0; $column < $worksheet_dimension[$worksheet]['highest_column']; $column++) {
                    echo '<td>';
                    echo $data[$worksheet][$row][$column];
                    echo '</td>';
                }
                echo '</tr>';
            }
        }

        echo '</table>';
    }

    public function whole_workbook_process_caller() {
        $input_file_name = 'C:\Users\Laptop\Desktop\excel_file_test\file_one.xlsx';
        $minimum_column = 1;
        $this->whole_workbook_process($input_file_name, $minimum_column);
    }

    // This funtion show excel file upload form.
    public function upload_form() {
        $this->load->view('excel_uploader_form');
    }

    // This function take the uploaded excel file. Save the file to folder and keep file name in database.
    public function upload_form_submit() {
        $field_name = "user_file";
        $this->db->select_max('id');
        $last_excel_file_id = $this->db->get('excel_file')->result()[0]->id;

        $last_excel_file_id_2 = (int) $last_excel_file_id;
        $last_excel_file_id_3 = $last_excel_file_id_2 + 1;
        $config['upload_path'] = './excel_file/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['file_name'] = "$last_excel_file_id_3" . '_' . $_FILES['user_file']['name'];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($field_name)) {
            $file_name = $this->upload->data()['file_name'];
            $data['file_name'] = $file_name;
            $result = $this->db->insert('excel_file', $data);
            if ($result) {
                $this->last_uploaded_excel_file();
            }
        } else {
            $error = array('file_upload_error' => $this->upload->display_errors());
            $this->load->view("excel_uploader_form", $error);
        }
    }

    // This function take name of last uploaded excel file from database.
    public function last_uploaded_excel_file() {
        $script_filename = rtrim($_SERVER['SCRIPT_FILENAME'], 'index.php');
        $uploaded_file_name = $this->db->select('file_name')->order_by('id', 'desc')->limit(1)->get('excel_file')->result()[0]->file_name;
        $input_file_name = $script_filename . 'excel_file/' . $uploaded_file_name;
        $minimum_column = 11;

        $this->whole_workbook_process($input_file_name, $minimum_column);
    }

    // This function insert excel file data to database.
    public function data_excel_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
        $buyer_array = array();
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                $buyer_array[] = array(
                    'company_name' => $data[$worksheet][$row][0],
                    'product' => $data[$worksheet][$row][1],
                    'address' => $data[$worksheet][$row][2],
                    'phone' => $data[$worksheet][$row][3],
                    'fax' => $data[$worksheet][$row][4],
                    'contact_person' => $data[$worksheet][$row][5],
                    'email' => $data[$worksheet][$row][6],
                    'website' => $data[$worksheet][$row][7],
                    'instruction' => $data[$worksheet][$row][8],
                    'country' => $data[$worksheet][$row][9],
                    'country_short_name' => $data[$worksheet][$row][10]
                );
            }
        }
        $this->db->insert_batch('buyer_directory', $buyer_array);
        echo 'Buyer information inserted successfully. <br />';
        $this->whole_workbook_row_count($data, $worksheet_array, $worksheet_dimension);
    }

    public function whole_workbook_row_count($data = "", $worksheet_array = "", $worksheet_dimension = "") {
        $counter = 0;
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                $counter++;
            }
        }
        echo "Total <b>$counter</b> rows in whole workbook";
    }

}
