<!doctype html>
<html>
  <head>
    <title><?php echo $page_title; ?></title>
    <!--common stylesheet file-->
    <?php if(isset($common_stylesheet)) { $this->load->view("$common_stylesheet"); } ?>
    <!--custom stylesheet file-->
    <?php if(isset($custom_stylesheet)) { $this->load->view("$custom_stylesheet"); } ?>
  </head>
  <body>
    <!--Page Header Start-->
    <div id="page_header">
      Page Header goes here. 
      <?php if(isset($common_navigation)) { $this->load->view("$common_navigation"); } ?>
    </div>
    <!--Page Header End-->
    
    <!--Page Content Start-->
    <!--Page Content may be in div tag-->
    <!--OR Page Content may be in iframe. For Grocery CRUD or library conflict-->
    <div id="content_page_specific">
      <?php if(isset($content_page)) { $this->load->view("$content_page"); } ?>
         <?php
          if(isset($load_iframe) && ($load_iframe=='yes')) {
           echo '<iframe src="'.site_url("$iframe_source").'"></iframe>';
          }
          ?>
      </div>
    <!--Page Content End-->
    
    <!--Page Footer Start-->
    <div id="page_footer">Page Footer goes here.</div>
    <!--Page Footer End-->
    
    <!--common script file-->
    <?php if(isset($common_script)) { $this->load->view("$common_script"); } ?>
    <!--custom script file-->
    <?php if(isset($custom_script)) { $this->load->view("$custom_script"); } ?>
    
    <!--
    Note: JavaScript is located at botom of page so that page load is faster. 
    Custom JavaScript goes under Common Javascript/Library JavaScript so that jQuery can be used in Custom 
    JavaScript file.
    -->
  </body>
</html>