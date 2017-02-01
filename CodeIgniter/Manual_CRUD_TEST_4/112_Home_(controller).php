<?php

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('customer_helper');
        if (!$this->session->userdata('admin_logged_in')) {
            $url_login = site_url('login');
            redirect($url_login, 'refresh');
        }
    }

    public function index() {
        $data['page_name'] = 'admin/dashboard';
        $this->load->view('admin/main_view', $data);
    }
    
    public function customer_grid() {
        $data['page_name'] = 'admin/customer_grid';
        $this->load->view('admin/main_view', $data);
    }
    
    public function add_customer() {
        $data['page_name'] = 'admin/customer_add_form';
        $this->load->view('admin/main_view', $data);
    }
    
    public function edit_customer() {
        $data['page_name'] = 'admin/customer_add_form';
        $this->load->view('admin/main_view', $data);
    }
    
    public function suspend_account() {
        $data['page_name'] = 'admin/suspend_account';
        $this->load->view('admin/main_view', $data);
    }
    
    public function report() {
        $data['page_name'] = 'admin/report';
        $this->load->view('admin/main_view', $data);
    }

}
