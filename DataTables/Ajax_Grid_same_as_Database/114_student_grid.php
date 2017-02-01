File Location: project_root/application/views/crud/student/student_grid.php

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Student List</h3>
    </div>
    <div class="panel-body">
        <div id="db_message">
            <?php
            if (isset($db_feedback)) {
                echo $db_feedback;
            }
            ?>
        </div>
        <a class="btn btn-default" href="<?php echo site_url('crud/student/add_form'); ?>" role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add
            New</a>
        <br/><br/>
        <table id="grid-table">
            <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>Mother Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="5">Loading data from server</td>
            </tr>
            </tbody>
            <tfoot>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Father Name</th>
            <th>Mother Name</th>
            <th>Actions</th>
            </tfoot>
        </table>
    </div>
</div>

<?php
//foreach ($student_result as $student_row) {
//    echo '<tr>';
//    echo '<td>' . $student_row->student_name . '</td>';
//    echo '<td>' . $student_row->father_name . '</td>';
//    echo '<td>' . $student_row->mother_name . '</td>';
//    echo '<td>';
//    echo '<a href="'.site_url("crud/student/view/{$student_row->student_id}").'">' . '<i class="fa fa-eye" aria-hidden="true"></i>' . '</a>' . '&nbsp;&nbsp;';
//    echo '<a href="'.site_url("crud/student/edit_form/{$student_row->student_id}").'">' . '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>' . '</a>' . '&nbsp;&nbsp;';
//    echo '<a href="#" onclick="delete_confirm('.$student_row->student_id.'); return false;">' . '<i class="fa fa-trash" aria-hidden="true"></i>' . '</a>';
//    echo '</td>';
//    echo '</tr>';
//}
?>

<script>
//    function delete_confirm(student_id) {
//        if (window.confirm('Are you sure to delete this Student Information?'))
//        {
////            alert("You agree");
//            window.location.href = '<?php //echo site_url('crud/student/delete'); ?>//' + '/' + student_id;
//        }
//    }
</script>




