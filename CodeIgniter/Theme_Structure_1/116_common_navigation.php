<!--Sitewide Navigation Menu goes here-->
 <?php // Setup Menu Start Here ?>
            <li class="nav-item  <?php if($active_link_group == 'setup') {echo 'active open'; } ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Setup</span>
                    <?php if($active_link_group == 'setup') {echo '<span class="selected"></span>'; } ?>
                    <span class="arrow <?php if($active_link_group == 'setup') {echo 'open'; } ?>"></span>
                </a>
                <ul class="sub-menu">
                    
                    <li class="nav-item  <?php if($active_link_specific == 'company_setup') {echo 'active open'; } ?>">
                        <a href="<?php echo site_url('setup/company_setup'); ?>" class="nav-link ">
                            <span class="title">Company Info</span>
                            <?php if($active_link_specific == 'company_setup') {echo '<span class="selected"></span>'; } ?>
                        </a>
                    </li>
                    <li class="nav-item  <?php if($active_link_specific == 'customer_setup') {echo 'active open'; } ?>">
                        <a href="<?php echo site_url('setup/customer_setup'); ?>" class="nav-link ">
                            <span class="title">Department</span>
                            <?php if($active_link_specific == 'customer_setup') {echo '<span class="selected"></span>'; } ?>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <?php // Setup menu end here ?>