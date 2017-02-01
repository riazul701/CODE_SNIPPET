<script>
//    function activate_confirm(customer_id) {
//        if (window.confirm('Are you sure to activate this Customer?'))
//        {
//            //            alert("You agree");
//            window.location.href = '<?php //echo site_url('admin/crud/customer_crud/activate'); ?>//' + '/' + customer_id;
//        }
//    }
</script>

<script>
//    function suspend_confirm(customer_id) {
//        if (window.confirm('Are you sure to suspend this Customer?'))
//        {
//            //            alert("You agree");
//            window.location.href = '<?php //echo site_url('admin/crud/customer_crud/suspend'); ?>//' + '/' + customer_id;
//        }
//    }
</script>

<script>
//    function delete_confirm(customer_id) {
//        if (window.confirm('Are you sure to delete this Customer Information?'))
//        {
////            alert("You agree");
//            window.location.href = '<?php //echo site_url('admin/crud/customer_crud/delete'); ?>//' + '/' + customer_id;
//        }
//    }
</script>


<div id="container">
    <div id="db_message" style="text-align: center;">
        <?php
        if (isset($db_feedback)) {
            echo $db_feedback;
        }
        
        if (isset($email_feedback)) {
            echo $email_feedback;
        }
        ?>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">Customer List</div>
        <a href="<?php echo site_url('admin/crud/customer_crud/add'); ?>" style="display: inline-table; margin: 7px 0px 0px 10px;"><button class="btn btn-default"><i class="fa fa-plus-circle"></i>&nbsp;Add New</button></a>
        
        <div class="panel-body">
            <?php  
            $customer_query = $this->db->get('user');
            ?>
            <table id="customer_grid_table" class="display">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>User Name</th>
                        <th>Credit</th>
                        <th>Expired</th>
                        <th>Status</th>
                        <th>Expire Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="11">Loading data from server</td>
                </tr>
                </tbody>
                <tfoot>
                <th>User ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Website</th>
                <th>User Name</th>
                <th>Credit</th>
                <th>Expired</th>
                <th>Status</th>
                <th>Expire Date</th>
                <th>Actions</th>
                </tfoot>
            </table>
            <?php
//            foreach ($customer_query->result() as $customer_row) {
//                echo '<tr>';
//                echo '<td>'.$customer_row->name.'</td>';
//                echo '<td>'.$customer_row->phone.'</td>';
//                echo '<td>'.$customer_row->email.'</td>';
//                echo '<td>'.$customer_row->website.'</td>';
//                echo '<td>'.$customer_row->user_name.'</td>';
//                echo '<td>'.$customer_row->credit.'</td>';
//                // Show Status - Active/Inactive/Expired
//                $current_time = strtotime(date('Y-m-d H:i:s'));
//                $expire_time_from_db = trim($customer_row->expire_date);
//                $expire_time = strtotime($expire_time_from_db);
//                if($current_time > $expire_time) {
//                    echo '<td>'.'Expired'.'</td>';
//                } else {
//                    echo '<td>'.'Valid'.'</td>';
//                }
//                echo '<td>'.ucfirst($customer_row->status).'</td>';
//                echo '<td>'.date_format(date_create($customer_row->expire_date), 'd-m-Y h:i A').'</td>';
//                echo '<td>';
//                echo '<a href="'.site_url("admin/crud/customer_crud/view/$customer_row->id").'"><i class="fa fa-eye"></i>View</a>';
//                echo '&nbsp;&nbsp;';
//                echo '<a href="'.site_url("admin/crud/customer_crud/edit/$customer_row->id").'"><i class="fa fa-pencil-square-o"></i>Edit</a>';
//                echo '&nbsp;&nbsp;';
//
//                if ("$customer_row->status" == 'active') {
//                    echo '<a href ="' . site_url("admin/crud/customer_crud/suspend/$customer_row->id") . '" onclick = "suspend_confirm(' . $customer_row->id . '); return false;"><i class="fa fa-hourglass"></i>Suspend</a>';
//                } else {
//                    echo '<a href ="' . site_url("admin/crud/customer_crud/activate/$customer_row->id") . '" onclick = "activate_confirm(' . $customer_row->id . '); return false;"><i class="fa fa-trash"></i>Activate</a>';
//                }
//
//                echo '&nbsp;&nbsp;';
//                echo '<a href ="'. site_url("admin/crud/customer_crud/delete/$customer_row->id").'" onclick = "delete_confirm('. $customer_row->id .'); return false;"><i class="fa fa-trash"></i>Delete</a>';
//                echo '</td>';
//                echo '</tr>';
//            }
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#customer_grid_table').DataTable( {
                "processing": true,
                "serverSide": true,
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                "ajax": {
                    "url": "<?php echo site_url('admin/crud/customer_grid_ajax'); ?>",
                    "type": "POST",
                    "data": function ( d ) {
                        delete d.columns[10];
                    }
                }

            } );
        } );
    </script>







