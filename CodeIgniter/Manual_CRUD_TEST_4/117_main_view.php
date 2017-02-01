<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Codage Bulk SMS Software</title>

    <!-- Bootstrap core CSS -->
    <link  rel="stylesheet" href="<?php echo base_url('template_admin/css/bootstrap.css'); ?>" />

    <!-- Add custom CSS here -->
    <link  rel="stylesheet" href="<?php echo base_url('template_admin/css/sb-admin.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('template_common/font_awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template_common/datatables/datatables.min.css'); ?>"/>
    
    <!-- JavaScript -->
    <script src="<?php echo base_url('template_admin/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?php echo base_url('template_admin/js/bootstrap.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('template_common/datatables/datatables.min.js'); ?>"></script>
    
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
    <link rel="stylesheet" href="<?php echo base_url('template_admin/navigation.css'); ?>" />
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="<?php echo site_url('admin/entry'); ?>">Codage Bulk SMS Software</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
<!--            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Entry <b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <li><a href="<?php echo site_url().'/admin/entry/customer_entry'; ?>" target="frame">Customer</a></li>
                <li><a href="<?php echo site_url().'/admin/entry/supplier_entry'; ?>" target="frame">Supplier</a></li>
                <li><a href="<?php echo site_url().'/admin/entry/supplier_entry'; ?>" target="frame">Invoice</a></li>
                <li><a href="<?php echo site_url().'/admin/entry/supplier_entry'; ?>" target="frame">Tax</a></li>
              </ul>
            </li>-->
            

<li><a href="<?php echo site_url().'/admin/home'; ?>"><i class="fa fa-desktop"></i> Dashboard</a></li>
<li><a href="<?php echo site_url().'/admin/home/customer_grid'; ?>"><i class="fa fa-desktop"></i> Customer Grid</a></li>
<li><a href="<?php echo site_url().'/admin/home/add_customer'; ?>"><i class="fa fa-desktop"></i> Add Customer</a></li>
<li><a href="<?php echo site_url().'/admin/home/edit_customer'; ?>"><i class="fa fa-desktop"></i> Edit Customer</a></li>
<li><a href="<?php echo site_url().'/admin/home/suspend_account'; ?>"><i class="fa fa-desktop"></i> Suspend Account</a></li>
<li><a href="<?php echo site_url().'/admin/home/report'; ?>"><i class="fa fa-desktop"></i> Report</a></li>
<li><a href="<?php echo site_url('login/logout'); ?>"><i class="fa fa-desktop"></i> Logout</a></li>
            
<!--            <li><a href="charts.html"><i class="fa fa-bar-chart-o"></i> Charts</a></li>
            <li><a href="bootstrap-elements.html"><i class="fa fa-desktop"></i> Bootstrap Elements</a></li>-->
            <li><a href="#"> &nbsp;</a></li>
            
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('user_name'); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <!--<li><a href="#"><i class="fa fa-user"></i> Profile</a></li>-->
                <!--<li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">7</span></a></li>-->
                <li><a href="<?php echo site_url().'/admin/security/user_setup'; ?>" target="frame"><i class="fa fa-gear"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo site_url('login/logout'); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper"> <!--Main content start-->

      <?php 
      $this->load->view("$page_name");
      ?>

      </div> <!--/#page-wrapper--> <!--Main content end-->

    </div><!-- /#wrapper -->

    

    <!-- Page Specific Plugins -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="<?php echo base_url('template_admin/js/morris/chart-data-morris.js'); ?>"></script>
    <script src="<?php echo base_url('template_admin/js/tablesorter/jquery.tablesorter.js'); ?>"></script>
    <script src="<?php echo base_url('template_admin/js/tablesorter/tables.js'); ?>"></script>

  </body>
</html>