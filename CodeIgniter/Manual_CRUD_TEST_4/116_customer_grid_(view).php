<script>
    function suspend_confirm(customer_id) {
        if (window.confirm('Are you sure to suspend this Customer?'))
        {
            //            alert("You agree");
            window.location.href = '<?php echo site_url('admin/crud/customer_crud/suspend'); ?>' + '/' + customer_id;
        }
    }
</script>

<script>
    function delete_confirm(customer_id) {
        if (window.confirm('Are you sure to delete this Customer Information?'))
        {
//            alert("You agree");
            window.location.href = '<?php echo site_url('admin/crud/customer_crud/delete'); ?>' + '/' + customer_id;
        }
    }
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
        <div class="panel-heading">Contact List</div>
        <a href="<?php echo site_url('admin/crud/customer_crud/add'); ?>" style="display: inline-table; margin: 7px 0px 0px 10px;"><button class="btn btn-default"><i class="fa fa-plus-circle"></i>&nbsp;Add New</button></a>
        
        <div class="panel-body">
            <?php  
            $customer_query = $this->db->get('user');
            ?>
            <table id="customer_grid_table" class="display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Address</th>
                        <th>User Name</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    foreach ($customer_query->result() as $customer_row) {
        echo '<tr>';
        echo '<td>'.$customer_row->name.'</td>';
        echo '<td>'.$customer_row->phone.'</td>';
        echo '<td>'.$customer_row->email.'</td>';
        echo '<td>'.$customer_row->website.'</td>';
        echo '<td>'.$customer_row->address.'</td>';
        echo '<td>'.$customer_row->user_name.'</td>';
        echo '<td>'.$customer_row->status.'</td>';
        echo '<td>';
        echo '<a href="'.site_url("admin/crud/customer_crud/view/$customer_row->id").'"><i class="fa fa-eye"></i>View</a>';
        echo '&nbsp;&nbsp;';
        echo '<a href="'.site_url("admin/crud/customer_crud/edit/$customer_row->id").'"><i class="fa fa-pencil-square-o"></i>Edit</a>';
        echo '&nbsp;&nbsp;';
        echo '<a href ="'. site_url("admin/crud/customer_crud/delete/$customer_row->id").'" onclick = "suspend_confirm('. $customer_row->id .'); return false;"><i class="fa fa-trash"></i>Suspend</a>';
        echo '&nbsp;&nbsp;';
        echo '<a href ="'. site_url("admin/crud/customer_crud/delete/$customer_row->id").'" onclick = "delete_confirm('. $customer_row->id .'); return false;"><i class="fa fa-trash"></i>Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        $(document).ready(function () {
            $('#customer_grid_table').DataTable();
        });
    </script>







