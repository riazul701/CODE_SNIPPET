File Location: 118_project_root/application/views/crud/student/student_view.php (View File)

<div class="panel panel-success">
   <div class="panel-heading">
       <h3 class="panel-title">Student Information</h3>
   </div>
   <div class="panel-body">
       <table class="table table-striped">
           <tr>
               <th>Student Name</th>
               <td><?php echo $student_view->student_name; ?></td>
           </tr>
           <tr>
               <th>Father Name</th>
               <td><?php echo $student_view->father_name; ?></td>
           </tr>
           <tr>
               <th>Mother Name</th>
               <td><?php echo $student_view->mother_name; ?></td>
           </tr>
       </table>
       <a class="btn btn-default" href="<?php echo site_url('crud/student/grid'); ?>" role="button">Back to List</a>
   </div>
</div>