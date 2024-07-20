<?php
    if (!isset($_SESSION['admin_login'])) {
        session_start();   
    }
    $_SESSION['admin_login'] = "yes";
    $_SESSION['admin_status'] = "1";
    require_once('../config/config.php');    
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    
    $obj = new StudyMeet();
    $error = $success = array();

    if(isset($_POST['login'])){
        $username = isset($_POST['name'])?$_POST['name']:"";
        $password = isset($_POST['password'])?$_POST['password']:"";

        if(empty($username)){
            $error[] = "Please enter email address/mobile number.";
        }else if(is_numeric($username)){
            if(strlen($username)!=10){
                $error[] = "Mobile number must be 10 digits long";
            }
        }else if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
            $error[] = "Invalid E-mail address";
        }
        if(empty($password)){
            $error[] = "Please enter password.";
        }
       // echo "string";print_r($password);die();
        if(empty($error)){
            $user = $obj->CheckAuthentication($username,$password);
          // echo "string";print_r($user);die();
            if(isset($user->error)){
                $error[] = $user->error;                
            }else{
                 $_SESSION['admin_id'] = $user->admin_id;
                 $_SESSION['name'] = $user;
                 $success[] = "Login successfully";
                 header("Location: dashboard.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo PROJECT_TITLE;?> </title>
        <!-- Bootstrap -->
        <link href="<?php echo URL;?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo URL;?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo URL;?>vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="<?php echo URL;?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- bootstrap-progressbar -->
        <link href="<?php echo URL;?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <!-- JQVMap -->
        <link href="<?php echo URL;?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link href="<?php echo URL;?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <!-- Datatables -->
        <link href="<?php echo URL;?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL;?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL;?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL;?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL;?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?php echo URL;?>build/css/custom.min.css" rel="stylesheet">
        <link href="<?php echo URL;?>css/custom_css.css" rel="stylesheet">
        <link href="<?php echo URL; ?>css/custom_static.css" rel="stylesheet">
        <link href="<?php echo URL; ?>css/support.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="<?php echo URL;?>vendors/jquery/dist/jquery.min.js"></script>
        <style type="text/css">
            .left_col,.right_col,body{
                background: transparent !important;
            }
            .page-title{
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .x_panel{
                border:none !important;
            }
            .nav-md .container.body .right_col{
                margin-right: 200px;
            }
            .navbar{
                min-height: 100px !important;
            }
            .navbar-default .navbar-nav > li > a{
                font-size: 25px !important;
                font-weight: bold;
            }
            .navbar-nav {
                padding-top: 30px;
            }
            @media only screen and (max-width: 990px){
                .logo{
                   width: 200px; 
                }
            }
            @media only screen and (min-width: 990px){
                .logo{
                   width: 273px; 
                }
            }
            @media only screen and (max-width: 990px){
                .div-height{
                   margin-top: 26px;
                }
            }
            @media only screen and (min-width: 990px){
                .div-height{
                   margin-top: 103px;
                }
            }
        </style>
    </head>
    <body class="nav-md">
        
        <div class="container body">
            <div class="main_container" style="margin-top: 0;">
                <div class="right_col" role="main" style="padding-top:0;">
                    <div class="">
                        <div class="page-title">
                            <div class="text-center">
                                <img style="height: 130px;width:130px;margin-top: 40px;margin-bottom: 10px;" src="<?php echo URL."images/logo.png"; ?>">
                               <?php /*<h1><b>Ecommerce</b></h1>*/ ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 div-height">
                                <div class="x_panel">
                                    <div class="x_content" style="padding-top:0px;">
                                        <br/>
                                        <form id="business-category" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                                            <?php
                                            if(!empty($error)) {
                                              ?>
                                              <div class="alert alert-danger fade in error-msg">
                                                <ul>
                                                <?php
                                                  foreach ($error as $e) {
                                                    echo '<li>'.$e.'</li>';
                                                  }
                                                ?>
                                                </ul>
                                              </div>
                                              <?php
                                            }
                                            if (!empty($success)) {
                                                ?>
                                              <div class="alert alert-success fade in success-msg">
                                                <ul>
                                                <?php
                                                  foreach ($success as $s) {
                                                    echo '<li>'.$s.'</li>';
                                                  }
                                                ?>
                                                </ul>
                                              </div>
                                              <?php
                                            }
                                            ?>
                                          
                                            <div class="form-group">
                                                <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" class="form-control col-md-7 col-xs-12" placeholder="E-mail Address / Mobile number" name="name" maxlength="255" required="required"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="password" class="form-control col-md-7 col-xs-12" placeholder="Password" name="password" maxlength="255" required="required" />
                                                </div>
                                            </div>
                                            <?php /*<div class="form-group">
                                                <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                                                    <div class="g-recaptcha" data-sitekey="<?php echo CAPTCH_SITEKEY;?>"></div>
                                                </div>
                                            </div>*/?>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary" name="login">Log in</button>
                                            </div>
                                            <?php /*<div class="form-group text-center">
                                                <a href="<?php echo URL.'forgot_password.php'?>" style="font-size: 20px;color: #337ab7;">Forgot password?</a>
                                            </div>*/?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    
    <!-- Bootstrap -->
    <script src="<?php echo URL;?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo URL;?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo URL;?>vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo URL;?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo URL;?>vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo URL;?>vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo URL;?>vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo URL;?>vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo URL;?>vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo URL;?>vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo URL;?>vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo URL;?>vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo URL;?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo URL;?>vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo URL;?>vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo URL;?>vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo URL;?>vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo URL;?>vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo URL;?>vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo URL;?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Datatables -->
    <script src="<?php echo URL;?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo URL;?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo URL;?>build/js/custom.min.js"></script>
    
  </body>
</html>