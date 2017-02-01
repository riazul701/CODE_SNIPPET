<?php

class Crud_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function customer_add_save() {
        $db_operation = $this->db->insert('user', $_POST);
        if ($db_operation) {
            $db_feedback = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Inserted Successfully</div>';
        } else {
            $db_feedback = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Insertion Failed</div>';
        }
        return $db_feedback;
    }
    
    public function customer_edit_save() {
        $this->db->where('id', $_POST['id']);
        $db_operation = $this->db->update('user', $_POST);
        if ($db_operation) {
            $db_feedback = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Updated Successfully</div>';
        } else {
            $db_feedback = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Data Update Failed</div>';
        }
        return $db_feedback;
    }

}

