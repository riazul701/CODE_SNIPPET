File Location: 116_project_root/application/views/crud/student/student_edit_form.php (View File)

<div class="panel panel-success">
   <div class="panel-heading">
       <h3 class="panel-title">Student Add</h3>
   </div>
   <div class="panel-body">
       <form class="form-horizontal" action="<?php echo site_url('crud/student/edit_save'); ?>" method="post" enctype="multipart/form-data">
           <input type="hidden" name="student_id" value="<?php echo $student_edit->student_id; ?>">
           <div class="form-group">
               <label for="student_name_id" class="col-sm-2 control-label">Student Name</label>
               <div class="col-sm-10">
                   <input type="text" name="student_name" class="form-control" id="student_name_id" placeholder="Student Name" value="<?php echo $student_edit->student_name; ?>">
               </div>
           </div>
           <div class="form-group">
               <label for="father_name_id" class="col-sm-2 control-label">Father Name</label>
               <div class="col-sm-10">
                   <input type="text" name="father_name" class="form-control" id="father_name_id" placeholder="Father Name" value="<?php echo $student_edit->father_name; ?>">
               </div>
           </div>
           <div class="form-group">
               <label for="mother_name_id" class="col-sm-2 control-label">Mother Name</label>
               <div class="col-sm-10">
                   <input type="text" name="mother_name" class="form-control" id="mother_name_id" placeholder="Mother Name" value="<?php echo $student_edit->mother_name; ?>">
               </div>
           </div>
           <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
                   <button type="submit" class="btn btn-default">Submit</button>
               </div>
           </div>
       </form>
   </div>
</div>
