<?php

class Crud extends CI_Controller {

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
        $this->load->view('user/home_view');
    }

    public function masking_add($action = 'add', $masking_id = '0') {
        $data = array();
        if ($action == 'add') {
            $data['action'] = 'add';
        } elseif ($action == 'edit') {
            $data['action'] = 'edit';
            $data['edit_existing'] = $this->db->where('masking_id', $masking_id)->get('masking')->result()[0];
        } elseif ($action == 'add_save') {
            // Add data to database which comes from Add form
            $content = array('masking_name' => $_POST['masking_name']);
            $db_operation = $this->db->insert('masking', $content);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
            }
        } elseif ($action == 'edit_save') {
            $content_e = array('masking_name' => $_POST['masking_name']);
            $this->db->where('masking_id', $_POST['masking_id']);
            $db_operation = $this->db->update('masking', $content_e);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
            }
        } else {
            // Delete data from database
            if ($action == 'delete') {
                $this->db->where('masking_id', $masking_id);
                $db_operation = $this->db->delete('masking');
                if ($db_operation) {
                    $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deleted Successfully</div>';
                } else {
                    $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deletion Failed</div>';
                }
            }
        }
        $this->load->view('user/masking_list', $data);
    }

}
