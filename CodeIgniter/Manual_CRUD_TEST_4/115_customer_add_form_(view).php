<div id="container">
    
    <?php
    if (isset($action) && ($action == 'edit')) {
        $submit_url = site_url('admin/crud/customer_crud/edit_save');
    } else {
        $submit_url = site_url('admin/crud/customer_crud/add_save');
    }
    ?>
    
    <?php
    if (isset($action) && ($action == 'view')) {
        echo '<div class="form-horizontal">';
    } else {
        ?>
    <form class="form-horizontal" action="<?php echo $submit_url; ?>" method="post" id="customer_add_form">
        <?php  }  ?>
        <div class="panel panel-success">
            <div class="panel-heading">Customer Information</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <?php
                    if (isset($action) && ($action == 'edit')) {
                        echo '<input type="text" name="id" value="'.$customer_edit->id.'" hidden />';
                    }
                    ?>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php
                             if (isset($action)) {
                                   if ($action == 'edit') {
                                       echo $customer_edit->name;
                                   } elseif ($action == 'view') {
                                       echo $customer_view->name;
                                   } else {
                                       echo '';
                                   }
                               }
                               ?>" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" value="<?php
                             if (isset($action)) {
                                   if ($action == 'edit') {
                                       echo $customer_edit->phone;
                                   } elseif ($action == 'view') {
                                       echo $customer_view->phone;
                                   } else {
                                       echo '';
                                   }
                               }
                               ?>" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?php
                             if (isset($action)) {
                                   if ($action == 'edit') {
                                       echo $customer_edit->email;
                                   } elseif ($action == 'view') {
                                       echo $customer_view->email;
                                   } else {
                                       echo '';
                                   }
                               }
                               ?>" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="website" class="col-sm-2 control-label">Website</label>
                    <div class="col-sm-10">
                        <input type="text" name="website" class="form-control" id="website" placeholder="Website" value="<?php
                             if (isset($action)) {
                                   if ($action == 'edit') {
                                       echo $customer_edit->website;
                                   } elseif ($action == 'view') {
                                       echo $customer_view->website;
                                   } else {
                                       echo '';
                                   }
                               }
                               ?>" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                        <textarea name="address" class="form-control" id="address" rows="3" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                            <?php
                            if (isset($action)) {
                                if ($action == 'edit') {
                                    echo $customer_edit->address;
                                } elseif ($action == 'view') {
                                    echo $customer_view->address;
                                } else {
                                    echo '';
                                }
                            }
                            ?>
                        </textarea>
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-success">
            <div class="panel-heading">API Assign</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="api_011" class="col-sm-2 control-label">011</label>
                    <div class="col-sm-10">
                        <select name="api_011" id="api_011" class="form-control" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                            <?php
                            if (isset($action)) {
                                if ($action == 'add') {
                                    customer_api_add();
                                } elseif ($action == 'edit') {
                                    customer_api_edit("$customer_edit->api_011");
                                } elseif ($action == 'view') {
                                    customer_api_edit("$customer_view->api_011");
                                } else {
                                    echo '';
                                }
                            }
                            ?>  
                        </select>
                        
                    </div>
                </div>  
                <div class="form-group">
                    <label for="api_015" class="col-sm-2 control-label">015</label>
                    <div class="col-sm-10">
                        <select name="api_015" id="api_015" class="form-control" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                            <?php
                            if (isset($action)) {
                                if ($action == 'add') {
                                    customer_api_add();
                                } elseif ($action == 'edit') {
                                    customer_api_edit("$customer_edit->api_015");
                                } elseif ($action == 'view') {
                                    customer_api_edit("$customer_view->api_015");
                                } else {
                                    echo '';
                                }
                            }
                            ?> 
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="api_016" class="col-sm-2 control-label">016</label>
                    <div class="col-sm-10">
                        <select name="api_016" id="api_016" class="form-control" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                            <?php
                            if (isset($action)) {
                                if ($action == 'add') {
                                    customer_api_add();
                                } elseif ($action == 'edit') {
                                    customer_api_edit("$customer_edit->api_016");
                                } elseif ($action == 'view') {
                                    customer_api_edit("$customer_view->api_016");
                                } else {
                                    echo '';
                                }
                            }
                            ?> 
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="api_017" class="col-sm-2 control-label">017</label>
                    <div class="col-sm-10">
                        <select name="api_017" id="api_017" class="form-control" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                            <?php
                            if (isset($action)) {
                                if ($action == 'add') {
                                    customer_api_add();
                                } elseif ($action == 'edit') {
                                    customer_api_edit("$customer_edit->api_017");
                                } elseif ($action == 'view') {
                                    customer_api_edit("$customer_view->api_017");
                                } else {
                                    echo '';
                                }
                            }
                            ?> 
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="api_018" class="col-sm-2 control-label">018</label>
                    <div class="col-sm-10">
                        <select name="api_018" id="api_018" class="form-control" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                            <?php
                            if (isset($action)) {
                                if ($action == 'add') {
                                    customer_api_add();
                                } elseif ($action == 'edit') {
                                    customer_api_edit("$customer_edit->api_018");
                                } elseif ($action == 'view') {
                                    customer_api_edit("$customer_view->api_018");
                                } else {
                                    echo '';
                                }
                            }
                            ?> 
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="api_019" class="col-sm-2 control-label">019</label>
                    <div class="col-sm-10">
                        <select name="api_019" id="api_019" class="form-control" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                            <?php
                            if (isset($action)) {
                                if ($action == 'add') {
                                    customer_api_add();
                                } elseif ($action == 'edit') {
                                    customer_api_edit("$customer_edit->api_019");
                                } elseif ($action == 'view') {
                                    customer_api_edit("$customer_view->api_019");
                                } else {
                                    echo '';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div> 
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">Credit</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="credit" class="col-sm-2 control-label">Credit</label>
                    <div class="col-sm-10">
                        <input type="text" name="credit" class="form-control" id="credit" placeholder="Credit" value="<?php
                             if (isset($action)) {
                                   if ($action == 'edit') {
                                       echo $customer_edit->credit;
                                   } elseif ($action == 'view') {
                                       echo $customer_view->credit;
                                   } else {
                                       echo '';
                                   }
                               }
                               ?>" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                    </div>
                </div>    
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">Credential</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="user_name" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Email" value="<?php
                             if (isset($action)) {
                                   if ($action == 'edit') {
                                       echo $customer_edit->user_name;
                                   } elseif ($action == 'view') {
                                       echo $customer_view->user_name;
                                   } else {
                                       echo '';
                                   }
                               }
                               ?>" <?php if (isset($action) && ($action == 'view')) { echo 'readonly'; } ?>>
                    </div>
                </div>   
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input <?php if (isset($action) && ($action == 'view')) { echo 'type="text" readonly'; } else { echo 'type="password"'; } ?> name="password" class="form-control" id="password" placeholder="Password" value="<?php
                             if (isset($action)) {
                                   if ($action == 'edit') {
                                       echo $customer_edit->password;
                                   } elseif ($action == 'view') {
                                       echo $customer_view->password;
                                   } else {
                                       echo '';
                                   }
                               }
                               ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php if (isset($action) && ($action == 'add')) { ?>
                    <input type="submit" style="display: none;" />
                    <input type="button" onclick="submitForm('<?php echo site_url('admin/crud/customer_crud/add_save'); ?>')" value="Save" class="btn btn-default" />
                    <input type="button" onclick="submitForm('<?php echo site_url('admin/crud/customer_crud/add_save_email'); ?>')" value="Save and Email" class="btn btn-default" />
                <?php
                } elseif (isset($action) && ($action == 'view')) {
                    echo '<a href="' . site_url('admin/crud/customer_crud/grid') . '"><button class="btn btn-default" id="submit_one">Back to List</button></a>';
                } else {
                    echo '<input type="submit" value="Update" class="btn btn-default" />';
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
    <?php } ?>
</div>

<script type="text/javascript">
    function submitForm(action)
    {
        document.getElementById('customer_add_form').action = action;
        document.getElementById('customer_add_form').submit();
    }
</script>
