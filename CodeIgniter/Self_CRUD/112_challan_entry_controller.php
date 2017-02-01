<?php

class Challan_entry_con extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('challan_entry_model');
        $this->load->helper('url');
    }

    public function test() {
        $fields = $this->db->field_data('challan');

        foreach ($fields as $field) {
            echo $field->name . '<br />';
            echo $field->type . '<br />';
            echo $field->max_length . '<br />';
            echo $field->primary_key . '<br /><hr />';
        }
    }

    public function grid_field_avoid($table_field_specific = "", $field_avoid_list_define) {
        foreach ($field_avoid_list_define as $field_avoid_define_key => $field_avoid_define_value) {
            if ($field_avoid_define_key == $table_field_specific) {
                return $table_field_specific;
            } else {
                continue;
            }
        }
    }

    public function grid_field_rename($table_field_specific = "", $field_rename_list_define) {

        foreach ($field_rename_list_define as $field_rename_define_key => $field_rename_define_value) {
            if ($field_rename_define_key == $table_field_specific) {
                $table_field_specific = $field_rename_define_value;
                return $table_field_specific;
            } else {
                continue;
            }
        }
        return $table_field_specific;
    }

    public function grid_view($table_define, $field_avoid_list_define, $field_rename_list_define, $field_relation_list_define) {
        // Get primary key of table
        $table_primary_key_array = $this->db->field_data($table_define);
        foreach ($table_primary_key_array as $table_primary_key_specific) {
            if ($table_primary_key_specific->primary_key) {
                $table_primary_key = $table_primary_key_specific->name;
            }
        }

        // Get list of table field
        $table_field_array = $this->db->list_fields($table_define);

        foreach ($table_field_array as $table_field_specific) {
            // Get original table field list
            $table_field_list_original[] = $table_field_specific;

            // Get list of field that we want to avoid
            if ($this->grid_field_avoid($table_field_specific, $field_avoid_list_define)) {
                $table_field_list_avoid[] = $this->grid_field_avoid($table_field_specific, $field_avoid_list_define);
                continue;
            } else {
                // Filtered table field
                 $table_field_list_filter[] = $table_field_specific;
                // Rename table field
                $table_field_specific_rename = $this->grid_field_rename($table_field_specific, $field_rename_list_define);
                $table_field_list_rename[] = $table_field_specific_rename;
            }
//            $table_field_list_rename[] = $table_field_specific_rename;
        }

        $data['table_field_list_original'] = $table_field_list_original;
        $data['table_field_list_avoid'] = $table_field_list_avoid;
        $data['table_field_list_filter'] = $table_field_list_filter;
        $data['table_field_list_rename'] = $table_field_list_rename;
        $data['table_primary_key'] = $table_primary_key;
        $data['grid_list_data'] = $this->challan_entry_model->grid_list_table_data($table_define, $field_avoid_list_define, $field_rename_list_define, $field_relation_list_define);
//        $this->load->view('challan_entry/grid_view', $data);
    }

    public function grid_initial() {
        $table_define = 'challan';
        $field_avoid_list_define = array(
            'id' => 'id'
        );
        $field_rename_list_define = array(
            'sale_id' => 'Sale ID',
            'challan_no' => 'Challan NO.'
        );
        $field_relation_list_define = array(
            array(
                'current_table_field' => 'customer_id',
                'related_table_name' => 'customer',
                'related_table_pk' => 'id',
                'related_table_field_show' => 'name'
            )
        );
        $this->grid_view($table_define, $field_avoid_list_define, $field_rename_list_define, $field_relation_list_define);
    }

}
