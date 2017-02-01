<?php

class One extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');
    }

    public function index() {
        
    }
	
	public function fn_one() {
		echo 'Controller: One{} and Function: fn_one() <br />';
		require_once(APPPATH."controllers/Two.php");
		$two_obj = new Two();
		$two_obj->fn_eleven();
	}
}

