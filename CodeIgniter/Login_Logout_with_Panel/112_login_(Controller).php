<?php

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index($data = array()) {
        $this->load->view('login_view', $data);
    }

    public function login_submit() {
//        $this->form_validation->set_rules('user_name');
        $this->load->model('login_model');
        $user_name = trim($this->input->post('user_name'));
        $password = trim($this->input->post('password'));
        $login_panel = trim($this->input->post('login_panel'));
        $condition = array(
            'user_name' => $user_name,
            'password' => $password
        );
        $result = $this->login_model->validity_check($condition);
        if ($result !== 0) {
           $count_row = $result->num_rows(); 
        } else {
            $count_row = 0;
        }
        
        if ($count_row == 1) {
        $login_status = $result->result()[0]->status;
        }

        if (($count_row == 1) && ($login_status == 'active')) { // User entered 'user_name' and 'password' found in database
            $this->login_submit_process($result, $login_panel);
        } else {  // User entered 'user_name' and 'password' does not found in database
//            $url_login_page_2 = site_url('login');
//            redirect($url_login_page_2, 'refresh');
            if (($count_row == 1) && ($login_status == 'inactive')) {
                $data['wrong_user'] = 'User is Inactive';
            } else {
               $data['wrong_user'] = 'Wrong user name or password'; 
            }
            $this->index($data);
        }
    }

    public function login_submit_process($result, $login_panel) {

        $user_id = $result->result()[0]->id;
//            $user_level = $this->login_model->get_user_level($user_id);
        $user_level = $result->result()[0]->user_level;
        $user_name = $result->result()[0]->user_name;
        $cash_register_id = $result->result()[0]->cash_register_id;

        if ($user_level == 'admin') { // 'user_level' is Admin, so he has right to enter 'admin panel' and 'manager panel' and 'sale panel' all three
            $this->session->set_userdata(array('user_id' => $user_id, 'user_name' => $user_name, 'user_level' => $user_level, 'admin_logged_in' => 'admin_logged_in', 'cash_register_id' => $cash_register_id));

            if ($login_panel == 'admin') { // Admin want to enter 'admin panel'
                $url_admin_1 = site_url() . '/admin/entry';
                redirect($url_admin_1, 'refresh');
            } elseif ($login_panel == 'manager') { // Admin want to enter 'manager panel'
                $url_manager_1 = site_url() . '/manager/entry';
                redirect($url_manager_1, 'refresh');
            } else { // Admin want to enter 'sale panel'
                $url_sale_1 = site_url() . '/sale/home';
                redirect($url_sale_1, 'refresh');
            }
        } elseif ($user_level == 'manager') {
            // 'user_level' is 'manager', so he has right to enter 'manager panel' and 'sale panel"

            if ($login_panel == 'manager') { // Manager want to enter 'manager panel', so go forward
                $this->session->set_userdata(array('user_id' => $user_id, 'user_name' => $user_name, 'user_level' => $user_level, 'manager_logged_in' => 'manager_logged_in', 'cash_register_id' => $cash_register_id));
                $url_manager_2 = site_url() . '/manager/entry';
                redirect($url_manager_2, 'refresh');
            } elseif ($login_panel == 'user') {
                $this->session->set_userdata(array('user_id' => $user_id, 'user_name' => $user_name, 'user_level' => $user_level, 'manager_logged_in' => 'manager_logged_in', 'cash_register_id' => $cash_register_id));
                $url_sale_2 = site_url() . '/sale/home';
                redirect($url_sale_2, 'refresh');
            } else { // Manager want to enter 'admin panel', so he is blocked
                $data['user_not_admin'] = 'Current user does not have Admin Privilege';
                $this->index($data);
            }
        } else { // 'user_level' is 'normal user', so he has right only to enter 'sale panel'
            if ($login_panel == 'user') { // Normal User want to enter 'sale panel', so go forward
                $this->session->set_userdata(array('user_id' => $user_id, 'user_name' => $user_name, 'user_level' => $user_level, 'user_logged_in' => 'user_logged_in', 'cash_register_id' => $cash_register_id));
                $url_sale_3 = site_url() . '/sale/home';
                redirect($url_sale_3, 'refresh');
            } elseif ($login_panel == 'manager') { // Normal User want to enter 'manager panel', so he is blocked
                $data['user_not_admin'] = 'Current user does not have Manager Privilege';
                $this->index($data);
            } else { // Normal User want to enter 'admin panel', so he is blocked
                $data['user_not_admin'] = 'Current user does not have Admin Privilege';
                $this->index($data);
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $url_login_page_3 = site_url('login');
        redirect($url_login_page_3, 'refresh');
    }

}
