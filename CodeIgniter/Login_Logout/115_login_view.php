<!DOCTYPE html>
<html>
    <head>
        <title>ABC Bricks Login</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo base_url('template_common/bootstrap.min.css'); ?>">
        <script src="<?php echo base_url('template_common/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('template_common/bootstrap.min.js'); ?>"></script>
    </head>
    <body>

    <center> <br />
        <h2>ABC Bricks</h2>

        <div style="margin-left: 390px;">

            <form class="form-horizontal" role="form" action="<?php echo site_url('login/login_submit'); ?>" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="user_name">User Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="user_name" id="user_name" value="<?php
                        if (isset($_POST['user_name'])) {
                            echo $_POST['user_name'];
                        } else {
                            echo "";
                        }
                        ?>"  />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="password">Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" name="password" id="password" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>

        </div>
        <?php
        if (isset($wrong_user)) {
            echo '<span style="margin-left: 100px;"><b>' . $wrong_user . '</b></span>';
        }
        ?>

    </center>
</body>
</html>

