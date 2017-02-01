<?php

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function validity_check($condition = array()) {
        if (!count($condition)) {
            return 0;
        }
        $query_user = $this->db->where($condition)->limit(1)->get('user');
        if ($query_user->num_rows() == 1) {
            $password_from_db = $query_user->result()[0]->password;
        } else {
            // $password_from_db is not set
        }

        if (isset($password_from_db) && ($password_from_db == $condition['password'])) {
            return $query_user;
        } else {
            return 0;
        }
    }

//    public function get_user_level($user_id = "") {
//        $this->db->select('user_level');
//        $this->db->where('id', $user_id);
//        $result_user_level = $this->db->get('user');
//        $user_level = $result_user_level->result()[0]->user_level;
//        return $user_level;
//    }
}
