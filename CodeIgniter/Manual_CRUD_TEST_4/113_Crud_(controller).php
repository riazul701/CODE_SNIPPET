<?php

class Crud extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->library('email');
        $this->load->model('admin/crud_model', 'crud_model');
        $this->load->helper('url');
        $this->load->helper('customer_helper');
        if (!$this->session->userdata('admin_logged_in')) {
            $url_login = site_url('login');
            redirect($url_login, 'refresh');
        }
    }

    public function index() {
        $data['page_name'] = 'admin/customer_grid';
        $this->load->view('admin/main_view', $data);
    }

    public function customer_crud($action = 'grid', $customer_id = '0') {
        $information = array();
        switch ($action) {
            case 'view':
                $information['customer_view'] = $this->db->where('id', $customer_id)->get('user')->result()[0];
                $information['action'] = 'view';
                $information['page_name'] = 'admin/customer_add_form';
                break;
            case 'add':
                $information['action'] = 'add';
                $information['page_name'] = 'admin/customer_add_form';
                break;
            case 'edit':
                $information['customer_edit'] = $this->db->where('id', $customer_id)->get('user')->result()[0];
                $information['action'] = 'edit';
                $information['page_name'] = 'admin/customer_add_form';
                break;

            case 'add_save':
                $information['db_feedback'] = $this->crud_model->customer_add_save();
                $information['page_name'] = 'admin/customer_grid';
                break;

            case 'add_save_email':
                $user_name = $this->session->userdata('user_name');
                $db_operation = $this->db->insert('user', $_POST);
                if ($db_operation) {
                    $this->email->from('sms@codagevps.pw', 'Codage Bulk SMS Software');
                    $this->email->to($_POST['user_name']);

                    $this->email->subject('Account Open Information');
                    $this->email->message('Dear '.$_POST['name'].' your account has been opened successfully. Your Login Email is: '.$_POST['user_name'].'and Password is: '.$_POST['password']);

                    if ($this->email->send()) {
                        $information['email_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Email Sent</div>';
                    } else {
                        $information['email_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Email Sending Failed</div>';
                    }
                }
                $information['page_name'] = 'admin/customer_grid';
                break;

            case 'edit_save':
                $information['db_feedback'] = $this->crud_model->customer_edit_save();
                $information['page_name'] = 'admin/customer_grid';
                break;

            case 'suspend':
                $this->db->set('status', 'inactive');
                $this->db->where('id', $customer_id);
                $db_operation = $this->db->update('user');
                if ($db_operation) {
                    $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Account Suspended Successfully</div>';
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Account Suspend Failed</div>';
                }
                $information['page_name'] = 'admin/customer_grid';
                break;

            case 'delete':
                $this->db->where('id', $customer_id);
                $db_operation = $this->db->delete('user');
                if ($db_operation) {
                    $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deleted Successfully</div>';
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deletion Failed</div>';
                }
                $information['page_name'] = 'admin/customer_grid';
                break;
            default :
                // Load crud grid  
                $information['page_name'] = 'admin/customer_grid';
        }
        $view_name = 'admin/main_view';
        $this->load->view("$view_name", $information);
    }

}
