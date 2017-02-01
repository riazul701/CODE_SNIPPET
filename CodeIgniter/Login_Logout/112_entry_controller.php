<?php

class Entry_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        if (!$this->session->userdata('admin_logged_in')) {
            $url_login = site_url('login');
            redirect($url_login,'refresh');
        }
    }

    public function index() {
        $this->challan_entry();
    }

    public function challan_entry() {
        $crud = new Grocery_CRUD();
        $crud->set_table('challan');
        $crud->display_as('driver_id', 'Driver name')
             ->display_as('customer_id', 'Customer name')
             ->display_as('project_id', 'Project name')
             ->display_as('material_id', 'Material name')
             ->display_as('unit_id', 'Unit');
        $crud->set_relation('driver_id', 'driver', 'name')
             ->set_relation('customer_id', 'customer', 'name')
             ->set_relation('project_id', 'project', 'project_name')
             ->set_relation('material_id', 'material', 'name')
             ->set_relation('unit_id', 'unit', 'name');
        $data = $crud->render();
        $this->load->view('entry_view',$data);
    }
    
    public function customer_entry() {
        $crud = new Grocery_CRUD();
        $crud->set_table('customer');
        $data = $crud->render();
        $this->load->view('entry_view',$data);
    }
    
    public function driver_entry() {
        $crud = new Grocery_CRUD();
        $crud->set_table('driver');
        $data = $crud->render();
        $this->load->view('entry_view',$data);
    }
    
    public function item_entry() {
        $crud = new Grocery_CRUD();
        $crud->set_table('item');
        $data = $crud->render();
        $this->load->view('entry_view',$data);
    }
    
    public function material_entry() {
        $crud = new Grocery_CRUD();
        $crud->set_table('material');
        $data = $crud->render();
        $this->load->view('entry_view',$data);
    }
    
    public function project_entry() {
        $crud = new Grocery_CRUD();
        $crud->set_table('project');
        $crud->display_as('customer_id', 'Customer name');
        $crud->set_relation('customer_id', 'customer', 'name');
        $data = $crud->render();
        $this->load->view('entry_view',$data);
    }

    public function sale_entry() {
        $crud = new Grocery_CRUD();
        $crud->set_table('sale');
        $crud->display_as('customer_id', 'Customer name')
             ->display_as('project_id', 'Project name')
             ->display_as('item_id', 'Item name')
             ->display_as('unit_id', 'Unit');
        $crud->set_relation('customer_id', 'customer', 'name')
             ->set_relation('project_id', 'project', 'project_name')
             ->set_relation('item_id', 'item', 'name')
             ->set_relation('unit_id', 'unit', 'name');
        $crud->field_type('payment_mode', 'dropdown', array('cash' => 'Cash', 'credit' => 'Credit', 'bank' => 'Bank'));
        $data = $crud->render();
        $this->load->view('sale_entry_view',$data);
    }
    
    public function unit_entry() {
        $crud = new Grocery_CRUD();
        $crud->set_table('unit');
        $data = $crud->render();
        $this->load->view('entry_view',$data);
    }

}
