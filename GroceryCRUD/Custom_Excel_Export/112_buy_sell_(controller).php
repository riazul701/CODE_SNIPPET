<?php

class Buy_sell extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->database();
        $this->load->library(array('session'));
        $this->load->helper(array('url','form','text','array'));
        /* grocery_crud */
        $this->load->library('grocery_crud');         
        if(!$this->session->userdata('admin_logged_in_in')){
            redirect('login', 'refresh');
        }
    }
    
    public function index() {
        $page_data = array(
            'page_name' => 'buyer',
            'page_title' => 'Buyer Information',
            'sidebar' => 'buy_sell_sidebar'
        );                
        $this->load->view('index', $page_data); 
    }
    
    public function buyer_frame() {
        $crud = new Grocery_CRUD();
        $crud->set_table('buyer');
        $crud->unset_add()->unset_edit()->unset_delete()->unset_print()->unset_export();
        $output = $crud->render();
        $this->load->view('frame/buyer',$output);
    }
    
    public function excel_export() {
        $file = 'Excel_Data.xls';
        header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
        $data['search_text_excel'] = $this->input->post('search_text_excel');
        $data['seach_field_excel'] = $this->input->post('seach_field_excel');
        $this->load->view('excel_export',$data);
    }
    
    
}

