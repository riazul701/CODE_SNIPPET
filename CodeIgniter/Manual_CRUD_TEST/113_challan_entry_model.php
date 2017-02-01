<?php

class Challan_entry_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Teacher Information Entry Section
//    public function teacher_entry_submit($picture_name) {
//
//        foreach ($this->input->post() as $key => $value) {
//            $data["$key"] = trim($value);
//        }
//
//        $data['picture'] = $picture_name;
//
//        // Converting date from dd-mm-yyyy to yyyy-mm-dd
//        $join_date_temp = date_create($data['join_date']);
//        $data['join_date'] = date_format($join_date_temp, "Y-m-d");
//
//        $leave_date_temp = date_create($data['leave_date']);
//        $data['leave_date'] = date_format($leave_date_temp, "Y-m-d");
//
//        if ($this->db->insert('teacher', $data)) {
//
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }

}
