<?php

class Excel_uploader extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('excel');

        $this->load->model('adminModel');
        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in())
            redirect('/auth/login');

        $user = $this->ion_auth->user()->row();
        $this->session->set_userdata('userid', $user->id);
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
// Remove Heading from Every worksheet in Excel file which is Row '1'
            for ($row = 2; $row <= $highest_row; $row++) {
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
//        $this->whole_workbook_show($data, $worksheet_array, $worksheet_dimension);
        $this->data_excel_to_db($data, $worksheet_array, $worksheet_dimension);
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
    public function upload_form($message_excel_uploader = "") {
//        $this->load->view('excel_uploader_form');
        $data['pages'] = 'excel_uploader_form';
        $data['title'] = 'Excel Uploader Form';
        $data['head'] = 'Excel Uploader Form';
        $data['message_excel_uploader'] = $message_excel_uploader;
        $this->load->view('admin/index.php', $data);
    }

// This function take the uploaded excel file. Save the file to folder and keep file name in database.
    public function upload_form_submit() {
        $field_name = "user_file";
        $this->db->select_max('id');
        $last_excel_file_id = $this->db->get('excel_file')->result()[0]->id;

        $last_excel_file_id_2 = (int) $last_excel_file_id;
        $last_excel_file_id_3 = $last_excel_file_id_2 + 1;
        $config['upload_path'] = './excel_file/';
        $config['allowed_types'] = 'xls|xlsx|csv';
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
            $data = array('file_upload_error' => $this->upload->display_errors());
//            $this->load->view("excel_uploader_form", $error);
            $data['pages'] = 'excel_uploader_form';
            $data['title'] = 'Excel Uploader Form';
            $data['head'] = 'Excel Uploader Form';
            $this->load->view('admin/index.php', $data);
        }
    }

// This function take name of last uploaded excel file from database.
    public function last_uploaded_excel_file() {
        $script_filename = rtrim($_SERVER['SCRIPT_FILENAME'], 'index.php');
        $uploaded_file_name = $this->db->select('file_name')->order_by('id', 'desc')->limit(1)->get('excel_file')->result()[0]->file_name;
        $input_file_name = $script_filename . 'excel_file/' . $uploaded_file_name;
        $minimum_column = $this->input->post('minimum_column');
        $this->whole_workbook_process($input_file_name, $minimum_column);
    }

    public function whole_workbook_row_count($data = "", $worksheet_array = "", $worksheet_dimension = "") {
        $counter = 0;
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                $counter++;
            }
        }
        return "Total <b>$counter</b> rows in whole workbook";
    }

// This function insert excel file data to database.
    public function data_excel_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
        $uploader_name = $this->input->post('uploader_name');
        switch ($uploader_name) {
            case 'product':
                $this->product_to_db($data, $worksheet_array, $worksheet_dimension);
                break;
            case 'machineries':
                $this->machineries_to_db($data, $worksheet_array, $worksheet_dimension);
                break;
            case 'sub_contract':
                $this->sub_contract_to_db($data, $worksheet_array, $worksheet_dimension);
                break;
            case 'buy_sell_lease':
                $this->buy_sell_lease_to_db($data, $worksheet_array, $worksheet_dimension);
                break;
            case 'head_office':
                $this->head_office_to_db($data, $worksheet_array, $worksheet_dimension);
                break;
            case 'branch':
                $this->branch_to_db($data, $worksheet_array, $worksheet_dimension);
                break;
            case 'buyer':
                $this->buyer_to_db($data, $worksheet_array, $worksheet_dimension);
                break;
            default :
                $this->upload_form();
        }
    }

    public function product_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
        //        echo 'product_to_db';
        $product_array = array();
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                // Get "category_id" start
                if (trim($data[$worksheet][$row][0]) == '') {
                    $category_excel = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $category_excel = trim($data[$worksheet][$row][0]);
                }
                $category_get = $this->db->select('id')->where('parent', '0')->where('title', $category_excel)->get('g_category');
                if ($category_get->num_rows() == 0) {
                    $category_get = $this->db->select('id')->where('parent', '0')->like('title', $category_excel)->get('g_category');
                }
                if ($category_get->num_rows() > 0) {
                    $category_id = $category_get->result()[0]->id;
                } else {
                    $category_id = -1;
                }
                // Get "category_id" end
                // Get "sub_category_id" start
                if (trim($data[$worksheet][$row][1]) == '') {
                    $sub_category_excel = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $sub_category_excel = trim($data[$worksheet][$row][1]);
                }
                $sub_category_get = $this->db->select('id')->where('parent !=', '0')->where('title', $sub_category_excel)->get('g_category');
                if ($sub_category_get->num_rows() == 0) {
                  $sub_category_get = $this->db->select('id')->where('parent !=', '0')->like('title', $sub_category_excel)->get('g_category');  
                }
                if ($sub_category_get->num_rows() > 0) {
                    $sub_category_id = $sub_category_get->result()[0]->id;
                } else {
                    $sub_category_id = -1;
                }
                // Get "sub_category_id" end
                // Get "type_id" start
                if (trim($data[$worksheet][$row][2]) == '') {
                    $type_excel = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $type_excel = trim($data[$worksheet][$row][2]);
                }
                $type_get = $this->db->select('id')->where('type', $type_excel)->get('type');
                if ($type_get->num_rows() == 0) {
                   $type_get = $this->db->select('id')->like('type', $type_excel)->get('type');
                }
                if ($type_get->num_rows() > 0) {
                    $type_id = $type_get->result()[0]->id;
                } else {
                    $type_id = -1;
                }
                // Get "type_id" end
                // Get country code start
                if (trim($data[$worksheet][$row][14]) == '') {
                    $country_name = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $country_name = trim($data[$worksheet][$row][14]);
                }
                $country_get = $this->db->select('code')->where('name', $country_name)->get('countries');
                if ($country_get->num_rows() == 0) {
                $country_get = $this->db->select('code')->like('name', $country_name)->get('countries');    
                }
                if ($country_get->num_rows() > 0) {
                    $country_code = $country_get->result()[0]->code;
                } else {
                    $country_code = -1;
                }
                // Get country code end

                $product_array[] = array(
                    'cat' => $category_id,
                    'subCat' => $sub_category_id,
                    'type' => $type_id,
                    'name' => $data[$worksheet][$row][3],
                    'ref' => $data[$worksheet][$row][4],
                    'description' => $data[$worksheet][$row][5],
                    'gsm' => $data[$worksheet][$row][6],
                    'gg' => $data[$worksheet][$row][7],
                    'fabric' => $data[$worksheet][$row][8],
                    'cCount' => $data[$worksheet][$row][9],
                    'color' => $data[$worksheet][$row][10],
                    'quantity' => $data[$worksheet][$row][11],
                    'sizeRange' => $data[$worksheet][$row][12],
                    'itemLocation' => $data[$worksheet][$row][13],
                    'madeCountry' => $country_code,
                    'payMode' => $data[$worksheet][$row][15],
                    'currency' => $data[$worksheet][$row][16],
                    'offerPrice' => $data[$worksheet][$row][17],
                    'offerRate' => $data[$worksheet][$row][18],
                    'status' => '1',
                    'date' => date("Y-m-d"),
                    'userid' => '1'
                );
            }
        }
        $this->db->insert_batch('product', $product_array);
        $message_excel_uploader = 'Product information inserted successfully. <br />';
        $message_excel_uploader .= $this->whole_workbook_row_count($data, $worksheet_array, $worksheet_dimension);
        $this->upload_form($message_excel_uploader);
    }

    public function machineries_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
//        echo 'machineries_to_db';
        $machineries_array = array();
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {

                // Get "category_id" start
                if (trim($data[$worksheet][$row][0]) == '') {
                    $category_excel = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $category_excel = trim($data[$worksheet][$row][0]);
                }
                $category_get = $this->db->select('id')->where('title', $category_excel)->get('m_category');
                if ($category_get->num_rows() == 0) {
                    $category_get = $this->db->select('id')->like('title', $category_excel)->get('m_category');
                }
                if ($category_get->num_rows() > 0) {
                    $category_id = $category_get->result()[0]->id;
                } else {
                    $category_id = -1;
                }
                // Get "category_id" end
                // Get country code start
                if (trim($data[$worksheet][$row][4]) == '') {
                    $country_name = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $country_name = trim($data[$worksheet][$row][4]);
                }
                $country_get = $this->db->select('code')->where('name', $country_name)->get('countries');
                if ($country_get->num_rows() == 0) {
                $country_get = $this->db->select('code')->like('name', $country_name)->get('countries');    
                }
                if ($country_get->num_rows() > 0) {
                    $country_code = $country_get->result()[0]->code;
                } else {
                    $country_code = -1;
                }
                // Get country code end

                $machineries_array[] = array(
                    'category' => $category_id,
                    'itemName' => $data[$worksheet][$row][1],
                    'description' => $data[$worksheet][$row][2],
                    'use' => $data[$worksheet][$row][3],
                    'origin' => $country_code,
                    'brand' => $data[$worksheet][$row][5],
                    'quantity' => $data[$worksheet][$row][6],
                    'pMode' => $data[$worksheet][$row][7],
                    'price' => $data[$worksheet][$row][9] . ' ' . $data[$worksheet][$row][8] . 'Per ' . $data[$worksheet][$row][10],
                    'contact_name' => $data[$worksheet][$row][11],
                    'designation' => $data[$worksheet][$row][12],
                    'address' => $data[$worksheet][$row][13],
                    'email' => $data[$worksheet][$row][14],
                    'cell' => $data[$worksheet][$row][15],
                    'userid' => '1',
                    'status' => '1',
                    'date' => date("Y-m-d")
                );
            }
        }
        $this->db->insert_batch('machineries', $machineries_array);
        $message_excel_uploader = 'Machineries information inserted successfully. <br />';
        $message_excel_uploader .= $this->whole_workbook_row_count($data, $worksheet_array, $worksheet_dimension);
        $this->upload_form($message_excel_uploader);
    }

    public function sub_contract_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
//        echo 'sub_contract_to_db';
        $sub_contract_array = array();
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                $type_excel = trim($data[$worksheet][$row][0]);
                if ($type_excel == 'Sub-contract Wanted') {
                    $type = 1;
                } elseif ($type_excel == 'Sub-contract Available') {
                    $type = 0;
                } else {
                    $type = -1;
                }
                $sub_contract_array[] = array(
                    'type' => $type,
                    'title' => $data[$worksheet][$row][1],
                    'quantity' => $data[$worksheet][$row][2],
                    'description' => $data[$worksheet][$row][3],
                    'contact_name' => $data[$worksheet][$row][4],
                    'designation' => $data[$worksheet][$row][5],
                    'address' => $data[$worksheet][$row][6],
                    'email' => $data[$worksheet][$row][7],
                    'cell' => $data[$worksheet][$row][8],
                    'userid' => '1',
                    'status' => '1',
                    'date' => date("Y-m-d")
                );
            }
        }
        $this->db->insert_batch('sub_contract', $sub_contract_array);
        $message_excel_uploader = 'Sub Contract information inserted successfully. <br />';
        $message_excel_uploader .= $this->whole_workbook_row_count($data, $worksheet_array, $worksheet_dimension);
        $this->upload_form($message_excel_uploader);
    }

    public function buy_sell_lease_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
//        echo 'buy_sell_lease_to_db';
        $buy_sell_array = array();
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                // Determine "type" start
                $type_excel = trim($data[$worksheet][$row][0]);
                if ($type_excel == 'Buy') {
                    $type = 1;
                } elseif ($type_excel == 'Sell') {
                    $type = 2;
                } elseif ($type_excel == 'Lease') {
                    $type = 3;
                } else {
                    $type = -1;
                }
                // Determine "type" end
                $buy_sell_array[] = array(
                    'type' => $type,
                    'title' => $data[$worksheet][$row][1],
                    'quantity' => $data[$worksheet][$row][2],
                    'details' => $data[$worksheet][$row][3],
                    'contact_name' => $data[$worksheet][$row][4],
                    'designation' => $data[$worksheet][$row][5],
                    'address' => $data[$worksheet][$row][6],
                    'email' => $data[$worksheet][$row][7],
                    'cell' => $data[$worksheet][$row][8],
                    'userid' => '1',
                    'status' => '1',
                    'date' => date("Y-m-d")
                );
            }
        }
        $this->db->insert_batch('buy_sell', $buy_sell_array);
        $message_excel_uploader = 'Buy Sell Lease information inserted successfully. <br />';
        $message_excel_uploader .= $this->whole_workbook_row_count($data, $worksheet_array, $worksheet_dimension);
        $this->upload_form($message_excel_uploader);
    }

    public function company_to_phone_table($previous_company_id = "") {
        $last_company_id = $this->db->select_max('id')->get('company')->result()[0]->id;
        for ($id = $previous_company_id; $id <= $last_company_id; $id++) {
            $phone_temporary = $this->db->select('phone_temporary')->where('id', $id)->get('company')->result()[0]->phone_temporary;
            if (($phone_temporary == '') || ($phone_temporary == NULL)) {
                continue;
            } else {
                $phone_array = explode(',', $phone_temporary);
                for ($i = 0; $i < count($phone_array); $i++) {
                    if ($phone_array[$i] == '')
                        continue;
                    $data = array(
                        'item_id' => $id,
                        'category' => 1,
                        'phone' => $phone_array[$i],
                        'status' => 1,
                        'date' => date("Y-m-d")
                    );

                    $this->db->insert('phone', $data);
                }
            }
            $company_update_array = array(
                'cell' => count($phone_array),
                'phone_temporary' => ''
            );
            $this->db->where('id', $id);
            $this->db->update('company', $company_update_array);
        }
    }

    public function head_office_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
//        echo 'head_office_to_db';
        $head_office_array = array();
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {

                // Get "category_id" start
                if (trim($data[$worksheet][$row][0]) == '') {
                    $category_excel = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $category_excel = trim($data[$worksheet][$row][0]);
                }
                $category_get = $this->db->select('id')->where('parent', '0')->where('title', $category_excel)->get('d_category');
                if ($category_get->num_rows() == 0) {
                $category_get = $this->db->select('id')->where('parent', '0')->like('title', $category_excel)->get('d_category');
                }
                if ($category_get->num_rows() > 0) {
                    $category_id = $category_get->result()[0]->id;
                } else {
                    $category_id = -1;
                }
                // Get "category_id" end
                // Get "sub_category_id" start
                if (trim($data[$worksheet][$row][1]) == '') {
                    $sub_category_excel = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $sub_category_excel = trim($data[$worksheet][$row][1]);
                }
                $sub_category_get = $this->db->select('id')->where('parent !=', '0')->where('title', $sub_category_excel)->get('d_category');
                if ($sub_category_get->num_rows() == 0) {
                $sub_category_get = $this->db->select('id')->where('parent !=', '0')->like('title', $sub_category_excel)->get('d_category');    
                }
                if ($sub_category_get->num_rows() > 0) {
                    $sub_category_id = $sub_category_get->result()[0]->id;
                } else {
                    $sub_category_id = -1;
                }
                // Get "sub_category_id" end

                $head_office_array[] = array(
                    'cat' => $category_id,
                    'subCat' => $sub_category_id,
                    'name' => $data[$worksheet][$row][2],
                    'group' => $data[$worksheet][$row][3],
                    'contact_person' => $data[$worksheet][$row][4],
                    'shiftCode' => $data[$worksheet][$row][5],
                    'address' => $data[$worksheet][$row][6],
                    'district' => $data[$worksheet][$row][7],
                    'phone_temporary' => $data[$worksheet][$row][8], // How many phone number
                    'fax' => $data[$worksheet][$row][9],
                    'email' => $data[$worksheet][$row][10],
                    'website' => $data[$worksheet][$row][11],
                    'cell' => '',
                    'cellVerify' => 1,
                    'emailVerify' => 1,
                    'status' => 1,
                    'date' => date("Y-m-d")
                );
            }
        }
        $previous_company_id = $this->db->select_max('id')->get('company')->result()[0]->id;
        $this->db->insert_batch('company', $head_office_array);
        $this->company_to_phone_table($previous_company_id);
        $message_excel_uploader = 'Head Office information inserted successfully. <br />';
        $message_excel_uploader .= $this->whole_workbook_row_count($data, $worksheet_array, $worksheet_dimension);
        $this->upload_form($message_excel_uploader);
    }

    public function branch_to_phone_table($previous_branch_id = "") {
        $last_branch_id = $this->db->select_max('id')->get('branch')->result()[0]->id;
        for ($id = $previous_branch_id; $id <= $last_branch_id; $id++) {
            $phone_temporary = $this->db->select('phone_temporary')->where('id', $id)->get('branch')->result()[0]->phone_temporary;
            if (($phone_temporary == '') || ($phone_temporary == NULL)) {
                continue;
            } else {
                $phone_array = explode(',', $phone_temporary);
                for ($i = 0; $i < count($phone_array); $i++) {
                    if ($phone_array[$i] == '')
                        continue;
                    $data = array(
                        'item_id' => $id,
                        'category' => 2,
                        'phone' => $phone_array[$i],
                        'status' => 1,
                        'date' => date("Y-m-d")
                    );

                    $this->db->insert('phone', $data);
                }
            }
            $branch_update_array = array(
                'phone_temporary' => ''
            );
            $this->db->where('id', $id);
            $this->db->update('branch', $branch_update_array);
        }
    }

    public function branch_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
//        echo 'branch_to_db';
        $branch_array = array();
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                // Get "company_id" start
                if (trim($data[$worksheet][$row][0]) == '') {
                    $company_excel = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $company_excel = trim($data[$worksheet][$row][0]);
                }
                $company_get = $this->db->select('id')->where('name', $company_excel)->get('company');
                if ($company_get->num_rows() == 0) {
                $company_get = $this->db->select('id')->like('name', $company_excel)->get('company');   
                }
                if ($company_get->num_rows() > 0) {
                    $company_id = $company_get->result()[0]->id;
                } else {
                    $company_id = -1;
                }
                // Get "company_id" end
                $branch_array[] = array(
                    'did' => $company_id,
                    'name' => $data[$worksheet][$row][1],
                    'address' => $data[$worksheet][$row][2],
                    'district' => $data[$worksheet][$row][3],
                    'phone_temporary' => $data[$worksheet][$row][4],
                    'fax' => $data[$worksheet][$row][5],
                    'email' => $data[$worksheet][$row][6],
                    'cellVerify' => 1,
                    'emailVerify' => 1,
                    'status' => 1,
                    'date' => date("Y-m-d")
                );
            }
        }
        $previous_branch_id = $this->db->select_max('id')->get('branch')->result()[0]->id;
        $this->db->insert_batch('branch', $branch_array);
        $this->branch_to_phone_table($previous_branch_id);
        $message_excel_uploader = 'Branch information inserted successfully. <br />';
        $message_excel_uploader .= $this->whole_workbook_row_count($data, $worksheet_array, $worksheet_dimension);
        $this->upload_form($message_excel_uploader);
    }

    public function buyer_to_db($data = "", $worksheet_array = "", $worksheet_dimension = "") {
//        echo 'buyer_to_db';
        $buyer_array = array();
        foreach ($worksheet_array as $worksheet) {
            for ($row = 0; $row < $worksheet_dimension[$worksheet]['highest_row']; $row++) {
                // Get country code start
                if (trim($data[$worksheet][$row][9]) == '') {
                    $country_name = '!@#$%^&NotFound!@#$%^&';
                } else {
                    $country_name = trim($data[$worksheet][$row][9]);
                }
                $country_get = $this->db->select('code')->where('name', $country_name)->get('countries');
                if ($country_get->num_rows() == 0) {
                $country_get = $this->db->select('code')->like('name', $country_name)->get('countries');    
                }
                if ($country_get->num_rows() > 0) {
                    $country_code = $country_get->result()[0]->code;
                } else {
                    $country_code = -1;
                }
                // Get country code end
                $buyer_array[] = array(
                    'company' => $data[$worksheet][$row][0],
                    'product' => $data[$worksheet][$row][1],
                    'address' => $data[$worksheet][$row][2],
                    'phone' => $data[$worksheet][$row][3],
                    'fax' => $data[$worksheet][$row][4],
                    'contact_person' => $data[$worksheet][$row][5],
                    'email' => $data[$worksheet][$row][6],
                    'website' => $data[$worksheet][$row][7],
                    'instruction' => $data[$worksheet][$row][8],
                    'country' => $country_code,
                    'status' => '1',
                    'date' => date("Y-m-d")
                );
            }
        }
        $this->db->insert_batch('buyer', $buyer_array);
        $message_excel_uploader = 'Buyer information inserted successfully. <br />';
        $message_excel_uploader .= $this->whole_workbook_row_count($data, $worksheet_array, $worksheet_dimension);
        $this->upload_form($message_excel_uploader);
    }

}
