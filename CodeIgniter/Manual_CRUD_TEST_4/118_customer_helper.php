<?php

function customer_api_add() {
    $CI =& get_instance();
    $CI->load->database();
    $customer_api_query = $CI->db->get('customer_api');
    echo '<option value="">Select an API</option>';
    foreach ($customer_api_query->result() as $customer_api_row) {
        echo '<option value="'.$customer_api_row->customer_api_id.'">'.$customer_api_row->name.'</option>';
    }
}

function customer_api_edit($existing_api='') {
    $CI =& get_instance();
    $CI->load->database();
    $customer_api_query = $CI->db->get('customer_api');
    echo '<option value="">Select an API</option>';
    foreach ($customer_api_query->result() as $customer_api_row) {
        echo '<option value="'.$customer_api_row->customer_api_id.'" ';
        if ($customer_api_row->customer_api_id == $existing_api) {
            echo 'selected';
        }
        echo '>'.$customer_api_row->name.'</option>';
    }
}
