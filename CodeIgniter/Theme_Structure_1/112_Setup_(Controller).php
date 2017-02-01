<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
    }
    
    public function index() {
        // Index function content
    }

    public function company_setup()
    {
        $data['page_title'] = 'title of page';
        $data['common_stylesheet'] = 'common stylesheet file'; // common_stylesheet.php
        $data['custom_stylesheet'] = 'custom stylesheet file'; // custom_stylesheet.php
        $data['common_navigation'] = 'common navigation page'; // common_navigation.php
        $data['active_link_group'] = 'setup'; // Drop Down menu group (for css class insertion)
        $data['active_link_specific'] = 'company_setup'; // Specific menu (for css class insertion)
        $data['content_page'] = 'content specific page'; // content_page.php
        $data['common_script'] = 'common javascript file'; // common_scipt.php
        $data['custom_script'] = 'custom javascript file'; // custom_script.php
        $this->load->view('main_view', $data);
    }
    
    public function customer_setup_source() {  // iframe source
        $crud = new Grocery_CRUD();
        $crud->set_table('customer');
        $output = $crud->render();
        $this->load->view('iframe_crud',$output);
    }
    
    public function customer_setup() {
        $data['common_stylesheet'] = 'common stylesheet file'; // common_stylesheet.php
        $data['custom_stylesheet'] = 'custom stylesheet file'; // custom_stylesheet.php
        $data['common_navigation'] = 'common navigation page'; // common_navigation.php
        $data['active_link_group'] = 'setup'; // Drop Down menu group (for css class insertion)
        $data['active_link_specific'] = 'customer_setup'; // Specific menu (for css class insertion)
//        $data['content_page'] = 'content specific page'; // content_page.php
        $data['load_iframe'] = 'yes';
        $data['iframe_source'] = 'setup/customer_setup_source';
        $data['common_script'] = 'common javascript file'; // common_scipt.php
        $data['custom_script'] = 'custom javascript file'; // custom_script.php
        $this->load->view('main_view', $data);
    }
}
