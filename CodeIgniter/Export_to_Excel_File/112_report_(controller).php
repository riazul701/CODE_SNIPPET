<?php

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged')) {
            redirect('login');
        }
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->load->model('report_model');
        $this->load->model('dropdown_model');
        $this->load->library("pagination");
        $this->load->helper("url");
    }


    function monthly_sale_report() {
        $data['title'] = "Monthly Sales Report";
        $data['viewName'] = 'report/monthly_sale';
        $this->load->view('template_main', $data);
    }


    function monthly_sale_excel_or_print() {
        if ($this->input->post('print') == 'excel') {
            $this->monthly_sale_excel(); // export the report to excel file
        } else {
            $this->monthly_sale_view(); // print the report in another tab
        }
    }
    
    function monthly_sale_excel() {
        $file = 'Monthly_Sale_Report.xls';
        header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
        $this->load->view('report/monthly_sale_report');
    }
 
    
    function monthly_sale_view() {
        $this->load->view('report/monthly_sale_report');
    }

}

?>