<?php

class Login_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index($data = array()) {
        $this->load->view('login_view', $data);
    }

    public function login_submit() {
        $this->load->model('login_model');
        $user_name = trim($this->input->post('user_name'));
        $password = trim($this->input->post('password'));
        $condition = array(
            'user_name' => $user_name,
            'password' => $password
        );
        $result_user = $this->login_model->validity_check($condition);
        if ($result_user !== 0) {
           $count_row = $result_user->num_rows();
        } else {
            $count_row = 0;
        }
        
        if ($count_row == 1) { // User entered 'user_name' and 'password' found in database
            $this->login_submit_process($result_user);
        } else {  // User entered 'user_name' and 'password' does not found in database
            $data['wrong_user'] = 'Wrong user name or password';
            $this->index($data);
        }
    }

    public function login_submit_process($result_user) {

        $user_id = $result_user->result()[0]->id;
        $user_name = $result_user->result()[0]->user_name;

        $this->session->set_userdata(array('user_id' => $user_id, 'user_name' => $user_name, 'admin_logged_in' => 'admin_logged_in'));
        $url_enter = site_url('entry');
        redirect($url_enter, 'refresh');
    }

    public function logout() {
        $this->session->sess_destroy();
        $url_login = site_url('login');
        redirect($url_login, 'refresh');
    }

}
