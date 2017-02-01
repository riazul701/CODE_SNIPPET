<!doctype html>
<html>
    <head>
        <title>Codage Bulk SMS Software</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url('template_common/bootstrap/css/bootstrap.min.css'); ?>" />
        <!--<link rel="stylesheet" href="<?php echo base_url('template_common/font_awesome/css/font-awesome.min.css'); ?>" />-->
        <script src="<?php echo base_url('template_common/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('template_common/bootstrap/bootstrap.min.js'); ?>"></script>                
        <style>
            /* Overall page structure start */
            body {
                background-color: #F0F2F5; 
            }
            #container {
                margin: 0 auto;
                width: 100%;
                background-color: #F0F2F5;
                text-align: center;
                /*padding: 5px;*/
            }
            #header {
                width: 100%;
                background-color: #FFFFFF;
                border-bottom: 5px solid #E5E5E5;
                margin-bottom: 10px;
            }
            #header2 {
                width: 1000px;
                margin: 0 auto;
            }
            #header2 img {
                width: 140px;
                padding: 10px 20px 10px 0;
            }
            #header2 h2{
                padding: 0px;
                margin: 0px;
                font-family: "Open Sans",sans-serif !important;
                font-size: 25px !important;
                font-weight: 300 !important;
                color: #999999;
            }
            #menu {
                width: 80%;
                border: 5px solid #E5E5E5;
                padding: 10px 0px;
                margin: 0px auto 20px;
                background-color: #FFFFFF;
            }
            #menu div:first-child {
                margin-left: 17px;
            }
            #content {
                width: 80%;
                border: 5px solid #E5E5E5;
                padding: 0px 0px 10px;
                margin: 0px auto 20px;
                background-color: #FFFFFF;
            }
            #file_message {
                width: 80%;
                margin: 10px auto 10px;
            }
            #div_heading {
                color: #999999;
                font-size: 18px;
                font-weight: 350;
                padding: 5px 0px 5px 20px;
                border-bottom: 1px solid #e5e5e5;
                font-family: "Open Sans",sans-serif;
                text-align: left;
                margin-bottom: 10px;
            }
            #submit_one {
                margin-left: -200px;
            }
            #footer {
                width: 100%;
                padding-top: 10px;
                background-color: #FFFFFF;
                border-bottom: 5px solid #E5E5E5;
                color: #999999;

            }
            #footer a {
                color: #999999;
            }
            #footer a:hover {
                color: #337ab7;
            }
            /* Overall page structure end */

            /*Button style start*/
            button {
                color: #40516F;
                font-weight: bold;
                background-color: #FFFFFF;
                border: 2px solid #E5E5E5;
                line-height: 14px;
            }
            button:hover {
                color: #FFFFFF;
                background-color: #40516F;
            }
            #menu button {
                width: 105px;
                height: 65px;
            }
            /*Button style end*/
            .glyphicon {
                font-size: 20px;
            }
        </style>
    </head>

    <body>
        <div id="container">
            <div id="header">
                <div id="header2">
                    <!--<h2>Codage Corporation Ltd.</h2>-->
                    <!--                <h4>54 Gulshan Avenue <br /> Dhaka-1212, Bangladesh</h4>-->
                    <h2><img src="<?php echo base_url('template_admin/ccl_logo_small.png'); ?>" />  Bulk SMS Software</h2>
                </div>
            </div>
            <div id="menu">
                <div>
                    <a href="<?php echo site_url('user/home'); ?>"><button type="button"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span><br />Dashboard<br />&nbsp;</button></a>
                    <a href="<?php echo site_url('user/home/send_sms'); ?>"><button type="button"><span class="glyphicon glyphicon-send" aria-hidden="true"></span><br />Send SMS<br />&nbsp;</button></a>
                    <a href="<?php echo site_url('user/home/create_list'); ?>"><button type="button"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span><br />Create List<br />&nbsp;</button></a>
                    <a href="<?php echo site_url('user/home/report'); ?>"><button type="button"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span><br />Report<br />&nbsp;</button></a>
                    <a href="<?php echo site_url('user/home/credit_request'); ?>"> <button type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span><br />Add Credit Request</button></a>
                    <a href="<?php echo site_url('user/home/masking_list'); ?>"><button type="button"><span class="glyphicon glyphicon-check" aria-hidden="true"></span><br />Masking List<br />&nbsp;</button></a>
                    <a href="<?php echo site_url('login/logout'); ?>"><button type="button"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span><br />Log Off<br />&nbsp;</button></a>
                </div>
            </div>

            <?php
            if (isset($action) && ($action == 'edit')) {
                $submit_url = site_url('user/crud/create_list_crud/edit_save');
            } else {
                $submit_url = site_url('user/crud/create_list_crud/add_save');
            }
            ?>

            <div id="file_message">
                <?php
                if (isset($file_feedback)) {
                    echo $file_feedback;
                }
                ?>
            </div>

            <div id="content">
                <div id="div_heading">Create List</div>
                <?php
                if (isset($action) && ($action == 'view')) {
                    echo '<div class="form-horizontal">';
                } else {
                ?>
                <form class="form-horizontal" action="<?php echo $submit_url; ?>" enctype="multipart/form-data" method="post" id="create_list_form">
                <?php  }  ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">Create List Form</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="group_name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    
                                    <?php
                                    if (isset($action) && ($action == 'edit')) {
                                        echo "<input type=\"text\" name=\"contact_list_id\" value=\"$contact_list_edit->contact_list_id\"  hidden />";
                                    }
                                        ?>
                                    
                                    <input type="text" name="group_name" class="form-control" id="group_name" value="<?php
                                          if (isset($action)) {
                                              if ($action == 'pre_add') {
                                                   echo $_POST['group_name'];
                                               } elseif ($action == 'edit') {
                                                   echo $contact_list_edit->group_name;
                                               } elseif ($action == 'view') {
                                                   echo $contact_list_view->group_name;
                                               } else {
                                                   echo '';
                                               }
                                           }
                                           ?>" placeholder="Name of List" <?php if (isset($action) && ($action == 'view')) {echo 'readonly';} ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact_number" class="col-sm-2 control-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <textarea name="contact_number" class="form-control" rows="3" id="contact_number" <?php if (isset($action) && ($action == 'view')) {echo 'readonly';} ?>><?php
                                        if (isset($action)) {
                                            if ($action == 'pre_add') {
                                                echo $all_contact_newline;
                                            } elseif ($action == 'edit') {
                                                echo $contact_list_edit->contact_number;
                                            } elseif ($action == 'view') {
                                                echo $contact_list_view->contact_number;
                                            } else {
                                                echo '';
                                            }
                                        }
                                        ?></textarea>
                                </div>
                            </div>

                            <?php
                            if (isset($action) && ($action == 'pre_add')) {
                                echo '';
                            } elseif (isset($action) && ($action == 'edit')) {
                                echo '';
                            } elseif (isset($action) && ($action == 'view')) {
                                echo '';
                            } else {
                                ?>
                                <div class="form-group">
                                    <label for="file_name" class="col-sm-2 control-label">Import from File</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="user_file" id="file_name" onchange="file_selected(); this.form.submit();">

                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php
                      if (isset($action) && ($action == 'edit')) {
                                echo '<button type="submit" class="btn btn-default" id="submit_one">Update List</button>';
                            } elseif (isset($action) && ($action == 'view')) {
                                echo '<a href="'.site_url('user/crud/create_list_crud/grid').'"><button class="btn btn-default" id="submit_one">Back to List</button></a>';
                            } else {
                                echo '<button type="submit" class="btn btn-default" id="submit_one">Save List</button>';
                            }
                            ?>
                            
                        </div>
                    </div>
               <?php
                if (isset($action) && ($action == 'view')) {
                    echo '</div>';
                } else {
                ?>
                </form>
                <?php  }  ?>

            </div>

            <div id="footer">
<!--                <p>Developed by <a href="http://codagecorp.com" target="_blank">Codage Corporation Ltd.</a></p>-->
                <p><a href="http://codagecorp.com" target="_blank"><img src="<?php echo base_url('template_admin/ccl_logo_footer.png'); ?>" /></a></p>
            </div>
        </div>

        <script>
            function file_selected() {
                document.getElementById("create_list_form").action = "<?php echo site_url('user/crud/create_list_pre_add'); ?>";
            }
        </script>

    </body>
</html>



