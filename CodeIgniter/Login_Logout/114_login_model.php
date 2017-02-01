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
        $this->db->where($condition);
        $this->db->from('user');
        $result = $this->db->get();
        if ($result->num_rows() == 1) {
            $password_from_db = $result->result()[0]->password;
        } else {
            // $password_from_db is not set
        }
        if (isset($password_from_db) && ($password_from_db == $condition['password'])) {
            return $result;
        } else {
            return 0;
        }
    }

}
