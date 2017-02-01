<?php

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        if (!$this->session->userdata('admin_logged_in')) {
            if (!$this->session->userdata('manager_logged_in')) {
                if (!$this->session->userdata('user_logged_in')) {
                    $url_login = site_url('login');
                    redirect($url_login, 'refresh');
                }
            }
        }
    }

    public function index() {
        $this->load->view('sale/home_view');
    }

}
