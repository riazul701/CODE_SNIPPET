File Location: project_root/application/models/crud/Student_model.php

<?php

class Student_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function grid() {
        $student_result = $this->db->get('student')->result();
        return $student_result;
    }

    public function view($student_id = 0) {
        $student_result = $this->db->where('student_id',$student_id)->get('student')->result()[0];
        return $student_result;
    }

    public function add_save() {
        $student_name = $this->input->post('student_name');
        $father_name = $this->input->post('father_name');
        $mother_name = $this->input->post('mother_name');
        $data = array(
            'student_name' => $student_name,
            'father_name' => $father_name,
            'mother_name' => $mother_name
        );
        $db_operation = $this->db->insert('student', $data);
        if ($db_operation) {
            $db_feedback = true;
        } else {
            $db_feedback = false;
        }
        return $db_feedback;
    }

    public function edit_form($student_id = 0) {
        $student_result = $this->db->where('student_id',$student_id)->get('student')->result()[0];
        return $student_result;
    }

    public function edit_save() {
        $student_id = $this->input->post('student_id');
        $student_name = $this->input->post('student_name');
        $father_name = $this->input->post('father_name');
        $mother_name = $this->input->post('mother_name');
        $data = array(
            'student_name' => $student_name,
            'father_name' => $father_name,
            'mother_name' => $mother_name
        );
        $this->db->where('student_id',$student_id);
        $db_operation = $this->db->update('student',$data);
        if ($db_operation) {
            $db_feedback = true;
        } else {
            $db_feedback = false;
        }
        return $db_feedback;
    }

    public function delete($student_id = 0) {
        $this->db->where('student_id',$student_id);
        $db_operation = $this->db->delete('student');
        if ($db_operation) {
            $db_feedback = true;
        } else {
            $db_feedback = false;
        }
        return $db_feedback;
    }

}