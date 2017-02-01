<!DOCTYPE html>
<html>
    <head>
        <title>Codage Restaurant Software</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="<?php echo base_url() . 'template_common/css/bootstrap.min.css'; ?>">
        <script src="<?php echo base_url() . 'template_common/jquery.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'template_common/bootstrap.min.js'; ?>"></script>

        <style>
            /*@CHARSET "UTF-8";*/
            /*
            over-ride "Weak" message, show font in dark grey
            */

            .progress-bar {
                color: #333;
            } 

            /*
            Reference:
            http://www.bootstrapzen.com/item/135/simple-login-form-logo/
            */

            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                outline: none;
            }

            .form-control {
                position: relative;
                font-size: 16px;
                height: auto;
                padding: 10px;
                @include box-sizing(border-box);

                &:focus {
                    z-index: 2;
                }
            }

            body {
                background: url("<?php echo base_url('template_admin/login_background.jpg'); ?>") no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            .login-form {
                margin-top: 60px;
            }

            form[role=login] {
                color: #5d5d5d;
                background: #f2f2f2;
                padding: 26px;
                border-radius: 10px;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
            }
            form[role=login] img {
                display: block;
                margin: 0 auto;
                margin-bottom: 35px;
            }
            form[role=login] input,
            form[role=login] button {
                font-size: 18px;
                margin: 16px 0;
            }
            form[role=login] > div {
                text-align: center;
            }

            .form-links {
                text-align: center;
                margin-top: 1em;
                margin-bottom: 50px;
            }
            .form-links a {
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="container">

            <div class="row" id="pwd-container">
                <div class="col-md-4"></div>

                <div class="col-md-4">
                    <section class="login-form">
                        <form method="post" action="<?php echo site_url() . '/login/login_submit'; ?>" role="login">
                            <img src="<?php echo base_url('template_admin/ccl_logo_small.png') ?>" class="img-responsive" alt="" />
                            <input type="text" name="user_name" placeholder="User Name" required class="form-control input-lg" value="<?php
                            if (isset($_POST['user_name'])) {
                                echo $_POST['user_name'];
                            } else {
                                echo "";
                            }
                            ?>" />

                            <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password" required="" />


                            <!--          <div class="pwstrength_viewport_progress"></div>-->

                            <select name="login_panel" id="login_panel" class="form-control input-lg">
                                <option value="admin">Admin Panel</option>
<!--                                <option value="manager">Manager Panel</option>-->
                                <option value="user">User Panel</option>
                            </select>

                            <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>
<!--                            <p style="text-align: center; font-weight: bold;" class="text-danger">Wrong User Name or Password!</p>-->
                            <?php
                            if (isset($user_not_admin)) {
                                echo '<p style="text-align: center; font-weight: bold;" class="text-danger">' . $user_not_admin . '</p>';
                            }

                            if (isset($wrong_user)) {
                                echo '<p style="text-align: center; font-weight: bold;" class="text-danger">' . $wrong_user . '</p>';
                            }
                            ?>
<!--                            <div>
                                <a href="#">Create account</a> or <a href="#">reset password</a>
                            </div>-->

                        </form>

                        <div class="form-links">
                            <span style="color: #DDDDDD;">Developed By </span><a href="http://codagecorp.com" target="_blank">Codage Corporation Ltd.</a>
                        </div>
                    </section>  
                </div>

                <div class="col-md-4"></div>


            </div>




        </div>


    </body>
</html>
