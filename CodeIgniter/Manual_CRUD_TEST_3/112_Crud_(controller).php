<?php

class Crud extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('email');
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

    public function credit_request() {
        $user_name = $this->session->userdata('user_name');
        $content = array('request_message' => $_POST['request_message']);
        $db_operation = $this->db->insert('credit_request', $content);
        if ($db_operation) {
            $this->email->from('sms@codagevps.pw', "$user_name");
            $this->email->to('codagecorp@gmail.com');

            $this->email->subject('Add Credit Request');
            $this->email->message($_POST['request_message']);

            if ($this->email->send()) {
                $data['email_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Email Sent</div>';
            } else {
                $data['email_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Email Sending Failed</div>';    
            }
        }
        $this->load->view('user/credit_request', $data);
    }
    
    public function create_list_pre_add() {
        $user_id = $this->session->userdata('user_id');
//        $information['group_name'] = $_POST['group_name'];
//        $information['contact_number'] = $_POST['contact_number'];
        $current_contact_list_id = $this->db->select_max('contact_file_id')->get('contact_file')->result()[0]->contact_file_id;
        $next_contact_list_id = $current_contact_list_id + 1;
        $file_name = $next_contact_list_id . '_' . $_FILES['user_file']['name'];

        $config['upload_path'] = 'upload/contact_number';
        $config['allowed_types'] = 'txt';
        $config['max_size'] = 1000;
        $config['file_name'] = "$file_name";

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('user_file')) {
            $error = array('error' => $this->upload->display_errors());
            $information['file_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Error occurred during file upload</div>';
        } else {
            $data = array('upload_data' => $this->upload->data());
            $to_db = array(
                'file_name' => $file_name,
                'user_id' => $user_id
            );
            $this->db->insert('contact_file', $to_db);
            $file_address = base_url("upload/contact_number/$file_name");
            $file_content_string = file_get_contents($file_address);
            $all_contact_array = explode(PHP_EOL, $file_content_string);
            $information['all_contact_newline'] = implode(PHP_EOL, $all_contact_array);
        }
        $information['action'] = 'pre_add';

        $this->load->view('user/create_list_form', $information);
    }

    public function create_list_crud($action = 'grid', $contact_list_id = '0') {
        $information = array();
        switch ($action) {
            case 'view':
                $information['contact_list_view'] = $this->db->where('contact_list_id', $contact_list_id)->get('contact_list')->result()[0];
                $information['action'] = 'view';
                $view_name = 'user/create_list_form';
                break;
            case 'add':
//                $group_name = $_POST['group_name'];
//                $contact_number = $_POST['contact_number'];
                $view_name = 'user/create_list_form';
                break;

            case 'edit':
                $information['contact_list_edit'] = $this->db->where('contact_list_id', $contact_list_id)->get('contact_list')->result()[0];
                $information['action'] = 'edit';
                $view_name = 'user/create_list_form';
                break;
            
            case 'add_save':
                $content_to_db = array(
                    'group_name' => $_POST['group_name'],
                    'contact_number' => $_POST['contact_number'],
                    'user_id' => $this->session->userdata('user_id')
                );
                $db_operation = $this->db->insert('contact_list', $content_to_db);
                if ($db_operation) {
                    $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
                }
                $view_name = 'user/create_list_grid';
                break;
                
            case 'edit_save':
                $content_edit = array(
                    'group_name' => $_POST['group_name'],
                    'contact_number' => $_POST['contact_number']
                    );
                $this->db->where('contact_list_id', $_POST['contact_list_id']);
                $db_operation = $this->db->update('contact_list', $content_edit);
                if ($db_operation) {
                    $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
                }
                $view_name = 'user/create_list_grid';
                break;
            
            case 'delete':
                $this->db->where('contact_list_id', $contact_list_id);
                $db_operation = $this->db->delete('contact_list');
                if ($db_operation) {
                    $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deleted Successfully</div>';
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deletion Failed</div>';
                }
                $view_name = 'user/create_list_grid';
                break;

            default :
                // Load crud grid  
                $view_name = 'user/create_list_grid';
        }
        $this->load->view("$view_name", $information);
    }

}
