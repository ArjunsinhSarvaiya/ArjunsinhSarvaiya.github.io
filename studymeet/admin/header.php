<?php 
	require_once('../config/config.php');      
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.ico" />
        <title>ADMIN DASHBOARD</title>
        <!-- Bootstrap -->
        <link href="<?php echo LINK_URL;?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo LINK_URL;?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo LINK_URL;?>vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="<?php echo LINK_URL;?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- bootstrap-progressbar -->
        <link href="<?php echo LINK_URL;?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <!-- JQVMap -->
        <link href="<?php echo LINK_URL;?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link href="<?php echo LINK_URL;?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <!-- Datatables -->
        <link href="<?php echo LINK_URL;?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo LINK_URL;?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo LINK_URL;?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo LINK_URL;?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo LINK_URL;?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo LINK_URL; ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?php echo LINK_URL;?>build/css/custom.min.css" rel="stylesheet">
        <link href="<?php echo LINK_URL; ?>css/custom_static.css" rel="stylesheet">
        <link href="<?php echo LINK_URL; ?>css/support.css" rel="stylesheet">
        <link href="<?php echo LINK_URL;?>editor/editor.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo LINK_URL; ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
        
        <!-- Switchery -->
        <link href="<?php echo LINK_URL; ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="<?php echo LINK_URL;?>vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo LINK_URL;?>editor/editor.js"></script>
        <script src="<?php echo LINK_URL;?>vendors/select2/dist/js/select2.min.js"></script>
        <script src="<?php echo LINK_URL; ?>firebase-messaging-sw.js"></script>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
               
            	<div class="col-md-3 left_col">
            	    <div class="left_col scroll-view">
            	        <div class="navbar nav_title" style="border: 0;">
        	               <a href="<?php echo ADMIN_URL.'dashboard.php'; ?>" class="site_title"><center><?php echo PROJECT_NAME; ?></center></a>
                        </div>
            	        <div class="clearfix"></div>
            	        <div class="profile clearfix">
            	            <div class="profile_pic">
            	                <img src="<?php echo IMG_URL;?>user.png" alt="..." class="img-circle profile_img">
            	            </div>
            	            <div class="profile_info">            	              
                                    <?php if(isset($_SESSION['admin_id'])){ ?>
                                    <span>Welcome,<br><?php echo
                                        $_SESSION['name']->name;?></span>
                                <?php }else{ ?>
                                    <span>Welcome</span>
                                <?php } ?>
            	            </div>
            	        </div>
            	        <br />
            	        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            	            <div class="menu_section">
            	                <ul class="nav side-menu">
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'dashboard.php'; ?>"><i class="fa fa-home"></i>DashBoard</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'manage_plan.php'; ?>"><i class="fa fa-list"></i>Manage Plans</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'manage_transaction.php'; ?>"> <i class="fa fa-list"></i>Transaction</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'User_list.php'; ?>"><i class="fa fa-list"></i>User List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'Que_list.php'; ?>"><i class="fa fa-list"></i> Question List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'Que_list_by_admin.php'; ?>"><i class="fa fa-list"></i> Question By Admin</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'manage_coupan.php'; ?>"> <i class="fa fa-list"></i>Coupon Code </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'Campaign_by_admin.php'; ?>"> <i class="fa fa-list"></i>Campaign By Admin</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'Campaign_List.php'; ?>"> <i class="fa fa-list"></i>Campaign List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'manage_post.php'; ?>"> <i class="fa fa-list"></i>Manage Post</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'Approve_sc_clg.php'; ?>"><i class="fa fa-list"></i>School or Collage Approve</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL.'manage_language.php'; ?>"><i class="fa fa-list"></i>Manage Language</a>
                                    </li>
                                </ul>
                            </div>
            	        </div>
            	    </div>
            	</div>
            	<!-- top navigation -->
            	<div class="top_nav">
            	    <div class="nav_menu">
            	        <nav>
            	            <div class="nav toggle">
            	                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            	            </div>
            	            <ul class="nav navbar-nav navbar-right">
            	                <li class="">
            	                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            	                    <img src="<?php echo IMG_URL;?>user.png" alt="...">
            	                        <?php if(isset($_SESSION['admin_id'])){ ?>
                                    <span>Welcome,<br><?php echo
                                        $_SESSION['name']->name;?></span>
                                <?php }else{ ?>
                                    <span>Welcome</span>
                                <?php } ?>
            	                    <span class=" fa fa-angle-down"></span>
            	                    </a>
            	                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        
                                           <li><a href="<?php echo ADMIN_URL;?>dashboard.php">Dashboard</a></li>
                                           <li><a href="<?php echo ADMIN_URL;?>change_password.php"> Change Password</a></li> 
            	                          <li><a href="<?php echo ADMIN_URL;?>logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>

            	                    </ul>
            	                </li>
                            </ul>
            	        </nav>
            	    </div>
            	</div>
            	<!-- /top navigation -->
            	
            	<!-- page content -->
            	<div class="right_col" role="main">
