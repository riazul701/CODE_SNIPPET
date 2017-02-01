<?php

class Challan_entry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->library("form_validation");
        $this->load->model("challan_entry_model");
        $this->load->database();
        $this->load->library('grocery_crud');
        if (!$this->session->userdata('admin_logged_in')) {
            $url_login = site_url('login');
            redirect($url_login, 'refresh');
        }
    }

    public function challan_entry_grid($show_message = "") {
        if ($show_message != "") {
            $data['show_message'] = $show_message;
        }
        $data['view_to_load'] = 'challan_entry/challan_entry_grid';
        $this->load->view('template_view', $data);
    }

    public function challan_entry_form() {
        $data['view_to_load'] = 'challan_entry/challan_entry_form';
        $data['action'] = 'add';
        $this->load->view('template_view', $data);
//        $this->load->view("challan_entry/challan_entry_form");
    }

    public function challan_edit_form($challan_id) {
        $data['challan_id'] = $challan_id;
        $data['view_to_load'] = 'challan_entry/challan_entry_form';
        $data['action'] = 'edit';
        $this->load->view('template_view', $data);
    }

    public function challan_entry_submit() {
        $date_temp = date_create($_POST['date']);
        $_POST['date'] = date_format($date_temp, 'Y-m-d H:i:s');
        $this->db->insert('challan', $_POST);
        $show_message = 'Record Inserted Successfully';
        $this->challan_entry_grid($show_message);
    }

    public function challan_edit_submit() {
        $date_temp = date_create($_POST['date']);
        $_POST['date'] = date_format($date_temp, 'Y-m-d H:i:s');
        $this->db->where('id', $_POST['id']);
        $this->db->update('challan', $_POST);
        $show_message = 'Record Updated Successfully';
        $this->challan_entry_grid($show_message);
    }

    public function challan_delete($challan_id) {
        $this->db->where('id', $challan_id);
        $this->db->delete('challan');
        $show_message = 'Challan Deleted';
        $this->challan_entry_grid($show_message);
    }

}
