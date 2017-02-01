<?php

class Challan_entry_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function grid_list_field_relation($table_row_key, $table_row_value, $field_relation_list_define) {
        foreach ($field_relation_list_define as $field_relation_specific) {
            foreach ($field_relation_specific as $field_relation_key => $field_relation_value) {
                if ($table_row_key == $field_relation_specific[$field_relation_key]) {
                    return $this->db->select;
                }
            }
        }
    }

        public function grid_list_table_data($table_define, $field_avoid_list_define, $field_rename_list_define, $field_relation_list_define) {
        $i = 0;
        $table_query = $this->db->get($table_define);
        foreach ($table_query->result_array() as $table_result) {
            foreach ($table_result as $table_row_key => $table_row_value) {
//                $grid_list_data[$i][$table_row_key] = $table_row_value;
                $grid_list_data[$i][$table_row_key] = $this->grid_list_field_relation($table_row_key, $table_row_value, $field_relation_list_define);
            }
            $i++;
        }
        var_dump($grid_list_data);
    }

}
