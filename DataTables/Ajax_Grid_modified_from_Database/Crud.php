<?php

class Crud extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('session');
        $this->load->database();
        $this->load->library('email');
        $this->load->library('datatables');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->load->model('admin/crud_model', 'crud_model');
        $this->load->helper('url');
        $this->load->helper('customer_helper');
        $this->load->helper('custom_datatables_helper');
        if (!$this->session->userdata('admin_logged_in')) {
            $url_login = site_url('login');
            redirect($url_login, 'refresh');
        }
    }

    /**
     * Load Customer Information CRUD Grid
     */
    public function index() {
        $data['page_name'] = 'admin/customer_grid';
        $this->load->view('admin/main_view', $data);
    }

    /**
     * Customer Information CRUD
     *
     * @param string $action Determine which type of CRUD action will be performed - grid, add, edit, delete
     * @param string $customer_id Determine which customer information will be edited or deleted
     */
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
                $db_operation = $this->crud_model->customer_add_save();
                if ($db_operation) {
                    $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
                }
                $information['page_name'] = 'admin/customer_grid';
                break;

            case 'add_save_email':
                $user_name = $this->session->userdata('user_name');
                $email_to = trim($_POST['email']);
                $soft_login_address = site_url();
                $db_operation = $this->crud_model->customer_add_save();
                if ($db_operation) {
                    $this->email->from('sms@codagecorporation.com', 'Codage Bulk SMS Software');
                    $this->email->to($email_to);
                    $this->email->bcc('codagecorp@gmail.com');

                    $this->email->subject('Account Create Information');
                    $this->email->message('Dear '.trim($_POST['name']).',<br />Your account has been created successfully.'.'<br /><br />Please Login to this Address: '.$soft_login_address.'<br /><br /><strong>Your Login Credential:</strong><br />Username: '.trim($_POST['user_name']).'<br />Password: '.trim($_POST['password']).'<br />Credit Limit: '.trim(($_POST['credit']) - 1).'<br /><br />Thanks,<br />Codage Corporation Ltd.<br />Hotline: +8801971 263243<br />Email: info@codagecorp.com<br />Web: http://www.codagecorp.com');

                    if ($this->email->send()) {
                        $information['email_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Information Inserted Successfully and Email Sent.</div>';
                    } else {
                        $information['email_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Email Sending Failed</div>';
                    }
                }
                $information['page_name'] = 'admin/customer_grid';
                break;

            case 'edit_save':
                $edit_save_status = $this->crud_model->customer_edit_save();
                if($edit_save_status) {
                    $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
                }
                $information['page_name'] = 'admin/customer_grid';
                break;

            case 'edit_save_email':
                $email_to = trim($_POST['email']);
                $soft_login_address = site_url();
                $edit_save_status = $this->crud_model->customer_edit_save();
                if($edit_save_status) {

                    $this->email->from('sms@codagecorporation.com', 'Codage Bulk SMS Software');
                    $this->email->to($email_to);
                    $this->email->bcc('codagecorp@gmail.com');

                    $this->email->subject('Account Update Information');
                    $this->email->message('Dear '.trim($_POST['name']).',<br />Your account information has been updated successfully.'.'<br /><br />Please Login to this Address: '.$soft_login_address.'<br /><br /><strong>Your Login Credential:</strong><br />Username: '.trim($_POST['user_name']).'<br />Password: '.trim($_POST['password']).'<br />Credit Limit: '.(trim($_POST['credit']) - 1).'<br /><br />Thanks,<br />Codage Corporation Ltd.<br />Hotline: +8801971 263243<br />Email: info@codagecorp.com<br />Web: http://www.codagecorp.com');

                    if ($this->email->send()) {
                        $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully and Email Sent</div>';
                    }
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
                }
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

            case 'activate':
                $this->db->set('status', 'active');
                $this->db->where('id', $customer_id);
                $db_operation = $this->db->update('user');
                if ($db_operation) {
                    $information['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Account Activated Successfully</div>';
                } else {
                    $information['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Account Activation Failed</div>';
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

    public function customer_grid_ajax()
    {
//        unset($_POST['columns'][4]);

        $this->datatables->select("id,name,phone,email,website,user_name,credit,expire_date as expire_check,status,expire_date", FALSE)->from('user');
        $this->datatables->edit_column('expire_check', '$1', 'customer_grid_expire_check(expire_check)');
        $this->datatables->edit_column('expire_date', '$1', 'customer_grid_expire_date_format(expire_date)');
        $this->datatables->add_column("actions", "<a href='" . site_url("admin/crud/customer_crud/view/$1") . "'>" . "<i class='fa fa-eye' aria-hidden='true'></i>View" . "</a>&nbsp;&nbsp;" . "<a href='" . site_url("admin/crud/customer_crud/edit/$1") . "'>" . "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit" . "</a>&nbsp;&nbsp;" . '$2' . "<a href='" . site_url("admin/crud/customer_crud/delete/$1") . "' onClick=\"return confirm('Are you sure to delete this Customer Information?')\">" . "<i class='fa fa-trash' aria-hidden='true'></i>Delete" . "</a>", "id,customer_grid_actions(id)");
//        $this->datatables->add_column("actions","some text","aaa");

        echo $this->datatables->generate();
    }

    /**
     * GP Masking CRUD
     *
     * @param string $action Determine GP Masking CRUD action - add, edit, delete
     * @param string $gp_masking_id Determine which GP Masking information will be edited or deleted
     */
    public function gp_masking_add($action = 'add', $gp_masking_id = '0') {
        $data = array();
        if ($action == 'add') {
            $data['action'] = 'add';
        } elseif ($action == 'edit') {
            $data['action'] = 'edit';
            $data['edit_existing'] = $this->db->where('gp_masking_id', $gp_masking_id)->get('gp_masking')->result()[0];
        } elseif ($action == 'add_save') {
            // Add data to database which comes from Add form
            foreach($_POST as $post_key=>$post_value) {
                $_POST[$post_key] = trim($post_value);
            }
            $content = array(
                'gp_masking_name' => $_POST['gp_masking_name']
            );
            $db_operation = $this->db->insert('gp_masking', $content);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
            }
        } elseif ($action == 'edit_save') {
            foreach($_POST as $post_key=>$post_value) {
                $_POST[$post_key] = trim($post_value);
            }
            $content_e = array('gp_masking_name' => $_POST['gp_masking_name']);
            $this->db->where('gp_masking_id', $_POST['gp_masking_id']);
            $db_operation = $this->db->update('gp_masking', $content_e);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
            }
        } else {
            // Delete data from database
            if ($action == 'delete') {
                $this->db->where('gp_masking_id', $gp_masking_id);
                $db_operation = $this->db->delete('gp_masking');
                if ($db_operation) {
                    $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deleted Successfully</div>';
                } else {
                    $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deletion Failed</div>';
                }
            }
        }
        $data['page_name'] = 'admin/gp_masking_list';
        $this->load->view('admin/main_view', $data);
    }

    /**
     * Robi Masking CRUD
     *
     * @param string $action Determine Robi Masking CRUD action - add, edit, delete
     * @param string $robi_masking_id Determine which Robi Masking will be edited or deleted
     */
    public function robi_masking_add($action = 'add', $robi_masking_id = '0') {
        $data = array();
        if ($action == 'add') {
            $data['action'] = 'add';
        } elseif ($action == 'edit') {
            $data['action'] = 'edit';
            $data['edit_existing'] = $this->db->where('robi_masking_id', $robi_masking_id)->get('robi_masking')->result()[0];
        } elseif ($action == 'add_save') {
            // Add data to database which comes from Add form
            foreach($_POST as $post_key=>$post_value) {
                $_POST[$post_key] = trim($post_value);
            }
            $content = array(
                'robi_masking_name' => $_POST['robi_masking_name']
            );
            $db_operation = $this->db->insert('robi_masking', $content);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
            }
        } elseif ($action == 'edit_save') {
            foreach($_POST as $post_key=>$post_value) {
                $_POST[$post_key] = trim($post_value);
            }
            $content_e = array('robi_masking_name' => $_POST['robi_masking_name']);
            $this->db->where('robi_masking_id', $_POST['robi_masking_id']);
            $db_operation = $this->db->update('robi_masking', $content_e);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
            }
        } else {
            // Delete data from database
            if ($action == 'delete') {
                $this->db->where('robi_masking_id', $robi_masking_id);
                $db_operation = $this->db->delete('robi_masking');
                if ($db_operation) {
                    $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deleted Successfully</div>';
                } else {
                    $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deletion Failed</div>';
                }
            }
        }
        $data['page_name'] = 'admin/robi_masking_list';
        $this->load->view('admin/main_view', $data);
    }

    /**
     * BL & TT Masking CRUD
     *
     * @param string $action Determine BL & TT Masking CRUD action - add, edit, delete
     * @param string $bl_tt_masking_id Determine which BL & TT Masking will be edited or deleted
     */
    public function bl_tt_masking_add($action = 'add', $bl_tt_masking_id = '0') {
        $data = array();
        if ($action == 'add') {
            $data['action'] = 'add';
        } elseif ($action == 'edit') {
            $data['action'] = 'edit';
            $data['edit_existing'] = $this->db->where('bl_tt_masking_id', $bl_tt_masking_id)->get('bl_tt_masking')->result()[0];
        } elseif ($action == 'add_save') {
            // Add data to database which comes from Add form
            foreach($_POST as $post_key=>$post_value) {
                $_POST[$post_key] = trim($post_value);
            }
            $content = array(
                'bl_tt_masking_name' => $_POST['bl_tt_masking_name']
            );
            $db_operation = $this->db->insert('bl_tt_masking', $content);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
            }
        } elseif ($action == 'edit_save') {
            foreach($_POST as $post_key=>$post_value) {
                $_POST[$post_key] = trim($post_value);
            }
            $content_e = array('bl_tt_masking_name' => $_POST['bl_tt_masking_name']);
            $this->db->where('bl_tt_masking_id', $_POST['bl_tt_masking_id']);
            $db_operation = $this->db->update('bl_tt_masking', $content_e);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
            }
        } else {
            // Delete data from database
            if ($action == 'delete') {
                $this->db->where('bl_tt_masking_id', $bl_tt_masking_id);
                $db_operation = $this->db->delete('bl_tt_masking');
                if ($db_operation) {
                    $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deleted Successfully</div>';
                } else {
                    $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deletion Failed</div>';
                }
            }
        }
        $data['page_name'] = 'admin/bl_tt_masking_list';
        $this->load->view('admin/main_view', $data);
    }

    /**
     * Block Masking Name CRUD
     *
     * Masking name list which are restricted. User can not add these names as Masking Name.
     *
     * @param string $action Determine which CRUD action will be performed - add, edit, delete
     * @param string $block_masking_id Determine which Block Masking Name will be edited or deleted
     */
    public function block_masking_add($action = 'add', $block_masking_id = '0') {
        $data = array();
        if ($action == 'add') {
            $data['action'] = 'add';
        } elseif ($action == 'edit') {
            $data['action'] = 'edit';
            $data['edit_existing'] = $this->db->where('block_masking_id', $block_masking_id)->get('block_masking')->result()[0];
        } elseif ($action == 'add_save') {
            // Add data to database which comes from Add form
            foreach($_POST as $post_key=>$post_value) {
                $_POST[$post_key] = trim($post_value);
            }
            $content = array(
                'block_masking_name' => $_POST['block_masking_name']
            );
            $db_operation = $this->db->insert('block_masking', $content);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
            }
        } elseif ($action == 'edit_save') {
            foreach($_POST as $post_key=>$post_value) {
                $_POST[$post_key] = trim($post_value);
            }
            $content_e = array('block_masking_name' => $_POST['block_masking_name']);
            $this->db->where('block_masking_id', $_POST['block_masking_id']);
            $db_operation = $this->db->update('block_masking', $content_e);
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
            }
        } else {
            // Delete data from database
            if ($action == 'delete') {
                $this->db->where('block_masking_id', $block_masking_id);
                $db_operation = $this->db->delete('block_masking');
                if ($db_operation) {
                    $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deleted Successfully</div>';
                } else {
                    $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deletion Failed</div>';
                }
            }
        }
        $data['page_name'] = 'admin/block_masking_list';
        $this->load->view('admin/main_view', $data);
    }

    /**
     * System Setting for Software Internal Use
     */
    public function system_setting()
    {
        if (count($_POST) > 0) {
            $db_operation = $this->crud_model->system_setting_edit_save();
            if ($db_operation) {
                $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Data Updated Successfully
    </div>';
            } else {
                $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Data Update Failed
    </div>';
            }

        }
        $data['page_name'] = 'admin/system_setting_form';
        $this->load->view('admin/main_view', $data);
    }
}
