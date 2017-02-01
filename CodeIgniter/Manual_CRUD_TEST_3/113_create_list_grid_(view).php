<!doctype html>
<html>
    <head>
        <title>Codage Bulk SMS Software</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url('template_common/bootstrap/css/bootstrap.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('template_common/font_awesome/css/font-awesome.min.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('template_common/datatables/datatables.min.css'); ?>"/>
        
                
        <!-- JavaScript -->
        <script src="<?php echo base_url('template_common/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('template_common/bootstrap/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('template_common/datatables/datatables.min.js'); ?>"></script>        
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
            #db_message {
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
            .icon-custom-size {
                font-size: 15px;
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
            
            <div id="db_message">
                <?php
                if (isset($db_feedback)) {
                    echo $db_feedback;
                }
                ?>
            </div>

            <div id="content">
                <div id="div_heading">Create List</div>
                <div class="panel panel-success">
                    <div class="panel-heading">Contact List</div>
                    <a href="<?php echo site_url('user/crud/create_list_crud/add'); ?>" style="display: inline-table; margin: 7px 0px 0px -950px;"><button class="btn btn-default"><i class="fa fa-plus-circle"></i>&nbsp;Add New</button></a>
                    <div class="panel-body">

                        <?php
                        $user_id = $this->session->userdata('user_id');
                        $contact_query = $this->db->where('user_id',$user_id)->order_by('group_name')->get('contact_list');
                        ?>
                        
                        <table id="table_one" class="display">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php
                    foreach ($contact_query->result() as $contact_row) {
                        echo '<tr>';
                        echo '<td>'.$contact_row->group_name.'</td>';
                        echo '<td>';
                        echo '<a href="'.site_url("user/crud/create_list_crud/view/$contact_row->contact_list_id").'"><i class="fa fa-eye"></i>View</a>';
                        echo '&nbsp;&nbsp;';
                        echo '<a href="'.site_url("user/crud/create_list_crud/edit/$contact_row->contact_list_id").'"><i class="fa fa-pencil-square-o"></i>Edit</a>';
                        echo '&nbsp;&nbsp;';
                        echo '<a href ="'. site_url("user/crud/create_list_crud/delete/$contact_row->contact_list_id").'" onclick = "YNconfirm('. $contact_row->contact_list_id .'); return false;"><i class="fa fa-trash"></i>Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div id="footer">
<!--                <p>Developed by <a href="http://codagecorp.com" target="_blank">Codage Corporation Ltd.</a></p>-->
                <p><a href="http://codagecorp.com" target="_blank"><img src="<?php echo base_url('template_admin/ccl_logo_footer.png'); ?>" /></a></p>
            </div>
        </div>
        
        <script>
            $(document).ready(function () {
                $('#table_one').DataTable();
            });
        </script>
        
        <script>
            function YNconfirm(contact_list_id) {
                if (window.confirm('Are you sure to delete this Contact List?'))
                {
        //            alert("You agree");
                    window.location.href = '<?php echo site_url('user/crud/create_list_crud/delete'); ?>' + '/' + contact_list_id;
            }
        }
        </script>
        
    </body>
</html>



