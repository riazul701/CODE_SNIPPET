File Location: project_root/application/controllers/crud/Student.php
<?php

class Student extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('crud/student_model','student_model');
        $this->load->library('datatables');
    }

    public function index() {
        echo '';
    }

    public function grid() {
        $data['student_result'] = $this->student_model->grid();
        $data['page_title'] = 'Student Information';
        $data['common_stylesheet'] = 'stylesheet/common/common_stylesheet';
        $data['custom_stylesheet'] = 'stylesheet/custom/student_grid_stylesheet';
        $data['common_navigation'] = 'navigation';
        $data['content_page'] = 'crud/student/student_grid';
        $data['common_script'] = 'script/common/common_script';
        $data['custom_script'] = 'script/custom/student_grid_script';
        $this->load->view('main_view',$data);
    }

    public function grid_ajax() {
//        unset($_POST['columns'][4]);

        $this->datatables->select("student_id,student_name,father_name,mother_name", FALSE)->from('student');
        $this->datatables->add_column("actions","<a href='".site_url("crud/student/view/$1")."'>" . "<i class='fa fa-eye' aria-hidden='true'></i>" . "</a>&nbsp;&nbsp;","student_id,student_name,father_name,mother_name");
//        $this->datatables->add_column("actions","some text","aaa");

        echo $this->datatables->generate();
    }

    public function view($student_id = 0) {
        $data['student_view'] = $this->student_model->view($student_id);
        $data['page_title'] = 'Student Information';
        $data['common_stylesheet'] = 'stylesheet/common/common_stylesheet';
        $data['common_navigation'] = 'navigation';
        $data['content_page'] = 'crud/student/student_view';
        $data['common_script'] = 'script/common/common_script';
        $this->load->view('main_view',$data);
    }

    public function add_form() {
        $data['page_title'] = 'Student Information';
        $data['common_stylesheet'] = 'stylesheet/common/common_stylesheet';
        $data['content_page'] = 'crud/student/student_add_form';
        $data['common_script'] = 'script/common/common_script';
        $this->load->view('main_view',$data);
    }

    public function add_save() {
        $db_operation = $this->student_model->add_save();
        if ($db_operation) {
            $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
        } else {
            $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
        }
        $data['student_result'] = $this->student_model->grid();
        $data['page_title'] = 'Student Information';
        $data['common_stylesheet'] = 'stylesheet/common/common_stylesheet';
        $data['custom_stylesheet'] = 'stylesheet/custom/student_grid_stylesheet';
        $data['content_page'] = 'crud/student/student_grid';
        $data['common_script'] = 'script/common/common_script';
        $data['custom_script'] = 'script/custom/student_grid_script';
        $this->load->view('main_view',$data);
    }

    public function edit_form($student_id = 0) {
        $data['student_edit'] = $this->student_model->edit_form($student_id);
        $data['page_title'] = 'Student Information';
        $data['common_stylesheet'] = 'stylesheet/common/common_stylesheet';
        $data['content_page'] = 'crud/student/student_edit_form';
        $data['common_script'] = 'script/common/common_script';
        $this->load->view('main_view',$data);
    }

    public function edit_save() {
        $db_operation = $this->student_model->edit_save();
        if ($db_operation) {
            $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
        } else {
            $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
        }
        $data['student_result'] = $this->student_model->grid();
        $data['page_title'] = 'Student Information';
        $data['common_stylesheet'] = 'stylesheet/common/common_stylesheet';
        $data['custom_stylesheet'] = 'stylesheet/custom/student_grid_stylesheet';
        $data['content_page'] = 'crud/student/student_grid';
        $data['common_script'] = 'script/common/common_script';
        $data['custom_script'] = 'script/custom/student_grid_script';
        $this->load->view('main_view',$data);
    }

    public function delete($student_id = 0) {
        $db_operation = $this->student_model->delete($student_id);
        if ($db_operation) {
            $data['db_feedback'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Deleted Successfully</div>';
        } else {
            $data['db_feedback'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Delete Failed</div>';
        }
        $data['student_result'] = $this->student_model->grid();
        $data['page_title'] = 'Student Information';
        $data['common_stylesheet'] = 'stylesheet/common/common_stylesheet';
        $data['custom_stylesheet'] = 'stylesheet/custom/student_grid_stylesheet';
        $data['content_page'] = 'crud/student/student_grid';
        $data['common_script'] = 'script/common/common_script';
        $data['custom_script'] = 'script/custom/student_grid_script';
        $this->load->view('main_view',$data);
    }
}