<!--Jquery ui calendar load start-->
<link rel="stylesheet" href="<?php echo base_url('file_addon/jquery-ui.css'); ?>">
<script src="<?php echo base_url('file_addon/jquery-1.10.2.js'); ?>"></script>
<script src="<?php echo base_url('file_addon/jquery-ui.js'); ?>"></script>
<!--Jquery ui calendar load end-->
<!--Jquey timepicker addon load start-->
<script src="<?php echo base_url('file_addon/jquery-ui-timepicker-addon.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('file_addon/jquery-ui-timepicker-addon.css'); ?>">
<!--Jquery timepicker addon load end--> 
<script>
    function from_calendar() {
//        $.noConflict();
        $(function () {
            $("#date").datetimepicker({
                dateFormat: "dd-mm-yy",
                timeFormat: 'hh:mm TT'
            });
        });
    }
</script>
<iframe onload="from_calendar()" style="display: none;"></iframe>
<?php
//echo "<div style='text-align:center; color: red;'>";
//if (isset($picture_error)) {
//    echo $picture_error;
//}
//echo validation_errors();
//echo "</div>";
?>

<?php
if ($action == 'add') {
    $submit_url = 'challan_entry/challan_entry_submit';
} else {
    $submit_url = 'challan_entry/challan_edit_submit';
    $query_challan_table = $this->db->where('id', $challan_id)->get('challan');
    $challan_table_sale_id = $query_challan_table->result()[0]->sale_id;
}
?>




<form class="form-horizontal" role="form" action="<?php echo site_url("$submit_url"); ?>" method="post" enctype="multipart/form-data">

    <?php
    if ($action == 'edit') {
        echo '<input type="text" name="id" value="' . $challan_id . '" hidden>';
    }
    ?>

    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Transaction No:</label>
        <div class="col-sm-4">
            <select name="sale_id" id="sale_id" class="form-control" onchange="info_based_on_transaction_no()" required>
                <?php
                if ($action == 'add') {
                    $query_sale_table = $this->db->get('sale');
                    echo '<option>Select Transaction No.</option>';
                    foreach ($query_sale_table->result() as $row_sale_table) {
                        echo '<option value="' . $row_sale_table->id . '">' . $row_sale_table->transaction_no . '</option>';
                    }
                } else {
                    $query_sale_table = $this->db->get('sale');
                    echo '<option>Select Transaction No.</option>';
                    foreach ($query_sale_table->result() as $row_sale_table) {
                        if ($challan_table_sale_id == $row_sale_table->id) {
                            echo '<option value="' . $row_sale_table->id . '" selected>' . $row_sale_table->transaction_no . '</option>';
                        } else {
                            echo '<option value="' . $row_sale_table->id . '">' . $row_sale_table->transaction_no . '</option>';
                        }
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="father_name">Challan No.:</label>
        <div class="col-sm-4">
            <?php
            $next_challan_id = $this->db->select_max('id')->get('challan')->result()[0]->id + 1;
            $next_challan_no = date('Y') . '/' . str_pad($next_challan_id, 5, "0", STR_PAD_LEFT);
            ?>
            <input type="text" class="form-control" name="challan_no" id="challan_no" value="<?php
            if ($action == 'add') {
                echo $next_challan_no;
            } else {
                echo $query_challan_table->result()[0]->challan_no;
            }
            ?>" readonly required />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="mother_name">Date</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="date" id="date" value="<?php
            if ($action == 'add') {
                echo "";
            } else {
                echo date('d-m-Y h:i A', strtotime($query_challan_table->result()[0]->date));
            }
            ?>" required />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="truck_no">Truck No.:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="truck_no" id="truck_no" value="<?php
            if ($action == 'add') {
                echo "";
            } else {
                echo $query_challan_table->result()[0]->truck_no;
            }
            ?>" required />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="driver_id">Driver Name:</label>
        <div class="col-sm-4">
            <select name="driver_id" id="driver_id" class="form-control" required>
                <?php
                if ($action == 'add') {
                    $query_driver_table = $this->db->get('driver');
                    foreach ($query_driver_table->result() as $row_driver_table) {
                        echo '<option value="' . $row_driver_table->id . '">' . $row_driver_table->name . '</option>';
                    }
                } else {
                    $challan_table_driver_id = $query_challan_table->result()[0]->driver_id;
                    $query_driver_table = $this->db->get('driver');
                    foreach ($query_driver_table->result() as $row_driver_table) {
                        if ($challan_table_driver_id == $row_driver_table->id) {
                            echo '<option value="' . $row_driver_table->id . '" selected>' . $row_driver_table->name . '</option>';
                        } else {
                            echo '<option value="' . $row_driver_table->id . '">' . $row_driver_table->name . '</option>';
                        }
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="customer_id">Customer Name:</label>
        <div class="col-sm-4">
            <select name="customer_id" class="form-control" id="customer_name_container" readonly required>       
                <?php
                if ($action == 'add') {
                    echo '<option value = "">Select Customer Name</option>';
                } else {
                    $challan_table_customer_id = $query_challan_table->result()[0]->customer_id;
                    echo '<option value="' . $query_challan_table->result()[0]->customer_id . '">';
                    echo $this->db->select('name')->where('id', $challan_table_customer_id)->get('customer')->result()[0]->name;
                    echo '</option>';
                }
                ?>
            </select>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="project_id">Project Name:</label>
        <div class="col-sm-4">
            <select name="project_id" class="form-control" id="project_name_container" readonly required>
                <?php
                if ($action == 'add') {
                    echo '<option value = "">Select Project Name</option>';
                } else {
                    $challan_table_project_id = $query_challan_table->result()[0]->project_id;
                    echo '<option value="' . $query_challan_table->result()[0]->project_id . '">';
                    echo $this->db->select('project_name')->where('id', $challan_table_project_id)->get('project')->result()[0]->project_name;
                    echo '</option>';
                }
                ?> 
            </select>



        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="item_name_container">Item Name:</label>
        <div class="col-sm-4">
            <select name="item_id" class="form-control" id="item_name_container" readonly required>
                <?php
                if ($action == 'add') {
                    echo '<option value = "">Select Item Name</option>';
                } else {
                    $challan_table_item_id = $query_challan_table->result()[0]->item_id;
                    echo '<option value="' . $query_challan_table->result()[0]->item_id . '">';
                    echo $this->db->select('name')->where('id', $challan_table_item_id)->get('item')->result()[0]->name;
                    echo '</option>';
                }
                ?>
            </select>


        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="quantity">Quantity:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="quantity" id="quantity" value="<?php
            if ($action == 'add') {
                echo "";
            } else {
                echo $query_challan_table->result()[0]->quantity;
            }
            ?>" readonly required />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="unit_id">Unit:</label>
        <div class="col-sm-4">
            <select name="unit_id" class="form-control" id="unit_container" readonly required>
                <?php
                if ($action == 'add') {
                    echo '<option value = "">Select Unit</option>';
                } else {
                    $challan_table_unit_id = $query_challan_table->result()[0]->unit_id;
                    echo '<option value="' . $query_challan_table->result()[0]->unit_id . '">';
                    echo $this->db->select('name')->where('id', $challan_table_unit_id)->get('unit')->result()[0]->name;
                    echo '</option>';
                }
                ?>
            </select>  
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="remark">Remark:</label>
        <div class="col-sm-4">
            <textarea rows="4" cols="50" name="remark" class="form-control" required>
                <?php
                if ($action == 'add') {
                    echo "";
                } else {
                    echo $query_challan_table->result()[0]->remark;
                }
                ?>
            </textarea>

        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>

</form>

<script>
    // Ajax function start
    function get_sale_id_based_customer_name() {
        sale_id = $('#sale_id').val();
        $.post("<?php echo site_url('entry_ajax/get_sale_id_based_customer_name'); ?>",
                {
                    sale_id: sale_id
                },
        function (data, status) {
            $('#customer_name_container').empty();
            $('#customer_name_container').append(data);
//            alert("Data: " + data + "\nStatus: " + status);
        });
    }

    function get_sale_id_based_project_name() {
        sale_id = $('#sale_id').val();
        $.post("<?php echo site_url('entry_ajax/get_sale_id_based_project_name'); ?>",
                {
                    sale_id: sale_id
                },
        function (data, status) {
            $('#project_name_container').empty();
            $('#project_name_container').append(data);
//            alert("Data: " + data + "\nStatus: " + status);
        });
    }

    function get_sale_id_based_item_name() {
        sale_id = $('#sale_id').val();
        $.post("<?php echo site_url('entry_ajax/get_sale_id_based_item_name'); ?>",
                {
                    sale_id: sale_id
                },
        function (data, status) {
            $('#item_name_container').empty();
            $('#item_name_container').append(data);
//            alert("Data: " + data + "\nStatus: " + status);
        });
    }

    function get_sale_id_based_quantity() {
        sale_id = $('#sale_id').val();
        $.post("<?php echo site_url('entry_ajax/get_sale_id_based_quantity'); ?>",
                {
                    sale_id: sale_id
                },
        function (data, status) {
//            $('#quantity').empty();
            $('#quantity').val(data);
//            alert("Data: " + data + "\nStatus: " + status);
        });
    }

    function get_sale_id_based_unit() {
        sale_id = $('#sale_id').val();
        $.post("<?php echo site_url('entry_ajax/get_sale_id_based_unit'); ?>",
                {
                    sale_id: sale_id
                },
        function (data, status) {
            $('#unit_container').empty();
            $('#unit_container').append(data);
//            alert("Data: " + data + "\nStatus: " + status);
        });
    }

    function info_based_on_transaction_no() {
        get_sale_id_based_customer_name();
        get_sale_id_based_project_name();
        get_sale_id_based_item_name();
        get_sale_id_based_quantity();
        get_sale_id_based_unit();
    }
    // Ajax function end

    function show_calendar() {
//        $(function () {
        $("#date").datepicker({
            dateFormat: "dd-mm-yy"
        });
//        });
    }
//
//            $(function () {
//                $("#leave_date").datepicker({
//                    dateFormat: "dd-mm-yy"
//                });
//            });
</script>

