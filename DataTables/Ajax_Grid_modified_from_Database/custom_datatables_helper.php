<?php

function customer_grid_expire_check($expire_date)
{
    date_default_timezone_set('Asia/Dhaka');
    $current_time = strtotime(date('Y-m-d H:i:s'));
    $expire_time_from_db = trim($expire_date);
    $expire_time = strtotime($expire_time_from_db);
    if ($current_time > $expire_time) {
        return 'Expired';
    } else {
        return 'Valid';
    }
}

function customer_grid_expire_date_format($expire_date)
{
    $expire_date = trim($expire_date);
    return date_format(date_create($expire_date), 'd-m-Y h:i A');
}


function customer_grid_actions($user_id)
{
    $user_id = trim($user_id);
    $CI =& get_instance();
    $CI->load->database();
    $status = trim($CI->db->select('status')->where('id',$user_id)->get('user')->result()[0]->status);

    if ("$status" == 'active') {
        return '<a href ="' . site_url("admin/crud/customer_crud/suspend/$user_id") . '" onClick="return confirm(\'Are you sure to suspend this Customer?\')"><i class="fa fa-hourglass"></i>Suspend</a>&nbsp;&nbsp;';
    } else {
        return '<a href ="' . site_url("admin/crud/customer_crud/activate/$user_id") . '" onClick="return confirm(\'Are you sure to activate this Customer?\')"><i class="fa fa-hourglass"></i>Activate</a>&nbsp;&nbsp;';
    }
}
