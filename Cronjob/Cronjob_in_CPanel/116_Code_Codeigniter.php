<?php

class Cron_sms extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('session');
        $this->load->database();
    }
    
    public function index() {
        echo '';
    }


    public function send_sms($limit=1) {
        // Do Processing
    }
}

