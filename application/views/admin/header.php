<?php 
    $this->load->helper('status');
    //ERP Database
    $db2 = $this->load->database('db2', TRUE); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="">
        <meta name="author" content="Chandra Narayan">
        <meta name="keyword" content="Administration Panel">
        <title>Mahaveer Group</title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/img/favicon.png">
        <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap-theme.css" rel="stylesheet">
        <!-- ICONS CLASS -->
        <link href="<?php echo base_url(); ?>assets/admin/css/elegant-icons-style.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/owl.carousel.css" type="text/css">
        <link href="<?php echo base_url(); ?>assets/admin/css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/fullcalendar.css">
        <link href="<?php echo base_url(); ?>assets/admin/css/widgets.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/style-responsive.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/admin/css/xcharts.min.css" rel=" stylesheet">	
        <link href="<?php echo base_url(); ?>assets/admin/css/jquery-ui-1.10.4.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/jquery-ui.css" rel="stylesheet"/>
        <?php //select 2 box ?>
        <link href="<?php echo base_url(); ?>assets/admin/classes/bootstrap.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/admin/css/select2.min.css" rel="stylesheet"/>
        <script src="<?php echo base_url(); ?>assets/admin/js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/select2.min.js"></script>
        <!--- Data Table Scripts --->
        <script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap.min.css"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/ColReorderWithResize.js"></script>
        
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.timepicker.min.css">
        
        <style>
        /* table border */
        .table th{
			border: #000 solid 1px !important;
			color:#000;
			font-weight:bold;
        }
        
        .table td{
        	border: #000 solid 1px !important;
        }
        
        #myBtn {
			display: none;
			position: fixed;
			bottom: 20px;
			right: 30px;
			z-index: 99;
			font-size: 18px;
			border: none;
			outline: none;
			background-color: red;
			color: white;
			cursor: pointer;
			padding: 10px;
			border-radius: 4px;
        }
        
        #myBtn:hover {
        	background-color: #555;
        }
        
        </style>
    </head>

    <?php 
    $username = $_SESSION['username'];
    if($username == ""){
        $url = base_url()."index.php/logout";
        redirect($url);
    }

    $sql_user_det = "select * from login where username = '".$username."'";
    $qry_user_det = $this->db->query($sql_user_det)->row();
    $user_id = $qry_user_det->id;
    $email = $qry_user_det->email;
    $password = $qry_user_det->password;
    $username = $qry_user_det->username;
    $name = $qry_user_det->name;
    $dob = $qry_user_det->dob;
    $mob_no = $qry_user_det->mob_no;
    $role = $qry_user_det->role;
    $emp_active = $qry_user_det->emp_active;
    $emp_id = $qry_user_det->emp_id; 

    ?>

    <body>
    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
        <section id="container" class="">
            <header class="header dark-bg">
                <div class="toggle-nav">
                    <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom">
                        <i class="icon_menu"></i>
                    </div>
                </div>

                <!--logo start-->
                <a href="<?php echo base_url(); ?>index.php/welcome/dashboard" class="logo" style="margin-top:2px">
                    <img src="<?php echo base_url(); ?>assets/admin/img/mpp_logo_new_white.png" width="20%" height="auto" />
                </a>
                <!--logo end-->

                <div class="top-nav notification-row">
                    <!-- notificatoin dropdown start-->
                    <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                        <span class="profile-ava">
                                            <img alt="" src="<?php echo base_url(); ?>assets/admin/img/default_avtar.png">
                                        </span>
                                        <span class="username" style="color:white"><?php echo $name; ?></span>
                                        <b class="caret"></b>
                                    </a>
                        <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/logout"><i class="icon_key_alt"></i> Log Out</a>
                        </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                    </ul>
                    <!-- notificatoin dropdown end-->
                </div>

            </header>
            <?php include('sidebar_menu.php'); ?>