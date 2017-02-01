<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ABC Bricks</title>

        <?php $this->load->view('common/script'); ?>

    </head>

    <body>

        <?php $this->load->view('common/navbar'); ?>

        <?php $this->load->view('common/page_header'); ?>




        <!-- Page container -->
        <div class="page-container container-fluid">

            <?php $this->load->view('common/sidebar'); ?>

            <!-- Page content -->
            <div class="page-content">

                <!-- Page title -->
                <div class="page-title">
                    <h5><i class="fa fa-bars"></i> Dashboard 
                        <!--<small>Welcome, Eugene!</small>-->
                    </h5>
                    <!--                    <div class="btn-group">
                                            <a href="#" class="btn btn-link btn-lg btn-icon dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i><span class="caret"></span></a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li><a href="#">One more line</a></li>
                                            </ul>
                                        </div>-->
                </div>
                <!-- /page title -->



                <?php // $this->load->view($load_view_name); ?>

                <!--<iframe src="<?php // echo site_url('entry/challan_entry'); ?>" name="frame" style="width: 100%; height: 600px; border: 0" id="main_frame"></iframe>-->
                <?php
                $this->load->view($view_to_load);
                ?>


                <?php $this->load->view('common/page_footer'); ?>

            </div>
        </div>


        <script>
            function print_iframe() {
                document.getElementById("main_frame").contentWindow.print();
            }
        </script>
    </body>
</html>


