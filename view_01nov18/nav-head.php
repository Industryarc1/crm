<?php
session_start();
ini_set("display_errors",0);
include_once('../config.php');
include_once('../model/function.php');
$functions = new functions();
$empId=$_SESSION['employee_id'];
$assignedleads=$functions->getLeadsbyAssociateIdByLimit($empId);
$count=$functions->getLeadsbyAssociateIdCount($empId);
/*if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)){
	echo '<script language="javascript">window.location.href = "logout.php"</script>';
}else{
	$_SESSION['LAST_ACTIVITY'] = time();
}*/

if(!isset($_SESSION['employee_id'])){
    echo '<script language="javascript">window.location.href = "login.php"</script>';
}
?>

<style>
@media only screen
and (min-device-width : 300px)
and (max-device-width : 500px) {
#header-desktop {
display: none;
}
}
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <!-- Title Page-->
    <title>Dashboard</title>
    <!-- Fontfaces CSS-->
    <link href="css/fullcalendar.min.css" rel="stylesheet" media="all">
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet" media="all">
    <!-- Vendor CSS-->
    <!-- <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">-->
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link href="css/custom.css" rel="stylesheet" media="all">
    <link href="css/simplePagination.css" rel="stylesheet" media="all">
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet" media="all">
	<!-- DataTable CSS-->
	<link type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
	<link type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css" rel="stylesheet">
</head>

<body class="">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="index.php">
                        <img src="images/icon/logo.png" alt="IndustryARC CRM" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
				 <?php if($_SESSION['role_id'] != 4){?>
                    <li class="has-sub">
                        <a class="js-arrow" href="index.php">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
				 <?php } ?>
					<?php if($_SESSION['role_id']== 1){?>
                        <li>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-user"></i>Employees</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="view_employees.php">View Employees</a>
                                </li>
                                <li>
                                    <a href="add_employee.php">Add Employee</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-users"></i>Team</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="view_teams.php">View Teams</a>
                                </li>
                                <li>
                                    <a href="add_team.php">Add Team</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-plus-square"></i>Departments</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="view_departments.php">View Departments</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
					<li>
                        <a class="js-arrow" href="#">
                            <i class="far fa-check-square"></i>Contacts</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <?php if($_SESSION['role_id']==4 && $_SESSION['team_id']==1){?>
                                <li>
                                    <a href="contact.php">Contact</a>
                                </li>
                            <?php }else{ ?>
                                <li>
                                    <a href="contacts.php">Contact Lists</a>
                                </li>
                                <?php if($_SESSION['team_id']== 2){?>
                                    <li>
                                        <a href="my_contacts.php">My Contacts</a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <?php if($_SESSION['role_id']!=4 && $_SESSION['team_id']!=2){?>
                                <li>
                                    <a href="add_contact.php">Add Leads</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li>
                        <a class="js-arrow" href="#">
                            <i class="fas fa-tasks"></i>Tasks</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <li>
                                <a href="assigned_by_me.php">Assigned by Me</a>
                            </li>
                            <li>
                                <a href="assigned_to_me.php">Assigned to Me</a>
                            </li>
                        </ul>
                    </li>
                    <?php //if($_SESSION['team_id']!=1 && $_SESSION['role_id'] !=4){?>
                    <li>
                        <a href="calendar.php">
                            <i class="fas fa-calendar-alt"></i>Calendar</a>
                    </li>
                    <?php //} ?>
                    <?php if($_SESSION['role_id']== 1){?>
                        <!--      <li>
                                  <a href="email_template.php">
                                      <i class="fas fa-map-marker-alt"></i>Email</a>
                              </li>-->
                        <li>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Reports</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="lead_reports.php">Lead Reports</a>
                                </li>
                                <li>
                                    <a href="task_reports.php">Tasks Reports</a>
                                </li>
                                <li>
                                    <a href="invoice_reports.php">Invoice Reports</a>
                                </li>
                                <!--  <li>
                                      <a href="employee_reports.php">Employee Reports</a>
                                  </li>-->
                            </ul>
                        </li>
                    <?php }?>
					<li>
                        <a href="logout.php">
                            <i class="zmdi zmdi-power"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar d-none d-lg-block" id="mySidenav">
        <div class="logo">
            <a href="index.php">
                <img src="images/icon/logo.png" alt="IndustryARC CRM" />
            </a>
            <!--   <a href="#" class="closebtn" onclick="closeNav()">&times;</a>-->
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <?php if($_SESSION['role_id'] != 4){?>
                        <li class="active has-sub">
                            <a href="index.php"> <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <!-- <img class="icons_align" src="images/icon/Dashboard.svg">-->

                        </li>
                    <?php } ?>
                    <?php if($_SESSION['role_id']== 1){?>
                        <li>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-user"></i>Employees</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="view_employees.php">View Employees</a>
                                </li>
                                <li>
                                    <a href="add_employee.php">Add Employee</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-users"></i>Team</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="view_teams.php">View Teams</a>
                                </li>
                                <li>
                                    <a href="add_team.php">Add Team</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-plus-square"></i>Departments</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="view_departments.php">View Departments</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li>
                        <a class="js-arrow" href="#">
                            <i class="far fa-check-square"></i>Contacts</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <?php if($_SESSION['role_id']==4 && $_SESSION['team_id']==1){?>
                                <li>
                                    <a href="contact.php">Contact</a>
                                </li>
                            <?php }else{ ?>
                                <li>
                                    <a href="contacts.php">Contact Lists</a>
                                </li>
                                <?php if($_SESSION['team_id']== 2){?>
                                    <li>
                                        <a href="my_contacts.php">My Contacts</a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <?php if($_SESSION['role_id']!=4 && $_SESSION['team_id']!=2){?>
                                <li>
                                    <a href="add_contact.php">Add Leads</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li>
                        <a class="js-arrow" href="#">
                            <i class="fas fa-tasks"></i>Tasks</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="assigned_by_me.php">Assigned by Me</a>
                            </li>
                            <li>
                                <a href="assigned_to_me.php">Assigned to Me</a>
                            </li>
                        </ul>
                    </li>
                    <?php //if($_SESSION['team_id']!=1 && $_SESSION['role_id'] !=4){?>
                    <li>
                        <a href="calendar.php">
                            <i class="fas fa-calendar-alt"></i>Calendar</a>
                    </li>
                    <?php //} ?>
                    <?php if($_SESSION['role_id']== 1){?>
                        <!--      <li>
                                  <a href="email_template.php">
                                      <i class="fas fa-map-marker-alt"></i>Email</a>
                              </li>-->
                        <li>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Reports</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="lead_reports.php">Lead Reports</a>
                                </li>
                                <li>
                                    <a href="task_reports.php">Tasks Reports</a>
                                </li>
                                <li>
                                    <a href="invoice_reports.php">Invoice Reports</a>
                                </li>
                                <!--  <li>
                                      <a href="employee_reports.php">Employee Reports</a>
                                  </li>-->
                            </ul>
                        </li>
                    <?php }?>                    
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->
    <!-- PAGE CONTAINER-->
    <div class="page-container" id="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop" id="header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <div style="font-size:30px;cursor:pointer;">
                            <span id="menu-one"  style="display: none" onclick="openNav()">&#9776;</span>
                            <span id="menu-two" onclick="closeNav()">&#9776;</span>
                        </div>
                        <!--   <form class="form-header" action="" method="POST">
                               <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                               <button class="au-btn--submit" type="submit">
                                   <i class="zmdi zmdi-search"></i>
                               </button>
                           </form>-->
                        <div class="header-button">
                            <div class="noti-wrap">
                                <div class="noti__item js-item-menu">
                                    <i class="zmdi zmdi-notifications"></i>
                                    <?php if($count['count'] != 0){?>
                                    <span class="quantity">3</span>
                                    <div class="notifi-dropdown js-dropdown">
                                        <div class="notifi__title">
                                            <p>You have <?php echo $count['count']; ?> Notifications</p>
                                        </div>
                                        <?php foreach ($assignedleads as $leads){?>
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="content">
                                                <p>You have assigned to
                                                    <?php
                                                    $assignedby=$functions->getleadbyId($leads['id']);
                                                    echo $assignedby['fname'].' '.$assignedby['lname'];?>
                                                    by
                                                    <?php
                                                    $assignedby=$functions->getEmployeeByEmpId($leads['assigned_by']);
                                                    echo $assignedby['firstname'].' '.$assignedby['lastname'];?>
                                                </p>
                                                <span class="date"><?php echo $leads['lead_assigned_date'];?></span>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="image">
                                        <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                    </div>
                                    <div class="content">
                                        <a class="js-acc-btn" href="#"><?php echo $_SESSION['name']; ?></a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="image">
                                                <a href="#">
                                                    <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="name">
                                                    <a href="#"><?php echo $_SESSION['name']; ?></a>
                                                </h5>
                                                <span class="email"><?php echo $_SESSION['email']; ?></span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__body">
                                            <div class="account-dropdown__item">
                                                <a href="myprofile.php">
                                                    <i class="zmdi zmdi-account"></i>My Profile</a>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="logout.php">
                                                <i class="zmdi zmdi-power"></i>Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER DESKTOP-->
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
                document.getElementById("page-container").style.paddingLeft = "250px";
                document.getElementById("header-desktop").style.marginLeft = "250px";
                document.getElementById("menu-one").style.display = "none";
                document.getElementById("menu-two").style.display = "block";
            }
            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("page-container").style.paddingLeft = "0";
                document.getElementById("header-desktop").style.marginLeft = "0";
                document.getElementById("menu-one").style.display = "block";
                document.getElementById("menu-two").style.display = "none";
            }
        </script>
