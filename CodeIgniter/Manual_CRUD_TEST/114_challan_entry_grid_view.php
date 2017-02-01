<script>
    function YNconfirm(challan_id) {
        if (window.confirm('Are you sure to delete this Challan?'))
        {
//            alert("You agree");
            window.location.href = '<?php echo site_url('challan_entry/challan_delete'); ?>' + '/' + challan_id;
        }
    }
</script>

<!-- Default datatable inside panel -->
<div class="panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><a href="<?php echo site_url('challan_entry/challan_entry_form'); ?>">Add Challan</a></h6></div>

    <?php
    if (isset($show_message)) {
        echo '<h3 style="color: green; text-align: center;">' . $show_message . '</h3>';
    }
    ?>

    <div class="datatable">
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction No</th>
                    <th>Challan No</th>
                    <th>Date</th>
                    <th>Truck No</th>
                    <th>Driver Name</th>
                    <th>Customer Name</th>
                    <th>Project Name</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Remark</th>
                    <?php
                    if ($this->session->userdata('user_level') == 'admin') {
                        echo '<th>Edit</th>';
                        echo '<th>Delete</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $query_challan = $this->db->get('challan');
                foreach ($query_challan->result() as $row_challan) {
                    ?>
                    <tr>

                        <td><?php echo $this->db->select('transaction_no')->where('id', $row_challan->sale_id)->get('sale')->result()[0]->transaction_no; ?></td>
                        <td><?php echo $row_challan->challan_no; ?></td>
                        <td>
                            <?php
                            echo date('d-m-Y h:i A', strtotime($row_challan->date));
                            ?>
                        </td>
                        <td><?php echo $row_challan->truck_no; ?></td>
                        <td><?php echo $this->db->select('name')->where('id', $row_challan->driver_id)->get('driver')->result()[0]->name; ?></td>
                        <td><?php echo $this->db->select('name')->where('id', $row_challan->customer_id)->get('customer')->result()[0]->name; ?></td>
                        <td><?php echo $this->db->select('project_name')->where('id', $row_challan->project_id)->get('project')->result()[0]->project_name; ?></td>
                        <td><?php echo $this->db->select('name')->where('id', $row_challan->item_id)->get('item')->result()[0]->name; ?></td>
                        <td><?php echo $row_challan->quantity; ?></td>
                        <td><?php echo $this->db->select('name')->where('id', $row_challan->unit_id)->get('unit')->result()[0]->name; ?></td>
                        <td><?php echo $row_challan->remark; ?></td>

                        <?php
                        if ($this->session->userdata('user_level') == 'admin') {
                            ?>
                            <td><a href = "<?php echo site_url('challan_entry/challan_edit_form/' . $row_challan->id); ?>">Edit</a></td>
                            <td><a href = "<?php echo site_url('challan_entry/challan_delete/' . $row_challan->id); ?>" onclick = "YNconfirm(<?php echo $row_challan->id; ?>);
                                    return false;">Delete</a></td>
                        </tr>

                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</div>
<!-- /default datatable inside panel -->

