<?php
session_start();
ini_set("display_errors",0);
if(isset($_SESSION['employee_id'])){	
	echo '<script language="javascript">window.location.href = "index.php"</script>';
}else{
	if(isset($_POST['login'])){
		include('../model/function.php');
		$functions = new functions();
		$username = $_POST['email'];
		$password = $_POST['password'];
		$loginData = $functions->employeeLogin($username,$password);
		if($loginData['login']=="Success"){
			echo '<script language="javascript">window.location.href = "index.php"</script>';
		}elseif($loginData['login']=="Failed"){
			$errMsg = $loginData['loginstatus'];
			echo '<script language="javascript">window.location.href = "login.php?errmsg='.$errMsg.'"</script>';
		}
	}
?>
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
    <title>Login</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
<!--    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">-->
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
	<script src="vendor/sweetalert-master/dist/sweetalert-dev.js"></script>
	<link rel="stylesheet" href="vendor/sweetalert-master/dist/sweetalert.css">

</head>

<body class="">
	<?php if(isset($_GET['errmsg']) && $_GET['errmsg']=="Invalid Password"){ ?>
	<script>
			swal("Password Mismatch!", "Please enter your correct password", "error");
	</script>
	<?php } ?>
	
	<?php if(isset($_GET['errmsg']) && $_GET['errmsg']=="User not exist"){ ?>
	<script>
			swal("Not Registered!", "Your are not registered with us", "error");
	</script>
	<?php } ?>
	
	<?php if(isset($_GET['errmsg']) && $_GET['errmsg']=="Access Denied"){ ?>
	<script>
			swal("Access Denied!", "Your are not allowed to login outside office. Please contact admin", "error");
	</script>
	<?php } ?>
	
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <!--<img src="images/icon/logo.png" alt="CoolAdmin">-->
								<img src="images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="login.php" method="post">
                                <div class="form-group">
                                    <label>User Name/Email Id</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password" required autofocus>
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">Remember Me
                                    </label>
                                    <label>
                                        <a href="#">Forgotten Password?</a>
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="login">sign in</button>
                                <!--<div class="social-login-content">
                                    <div class="social-button">
                                        <button class="au-btn au-btn--block au-btn--blue m-b-20">sign in with facebook</button>
                                        <button class="au-btn au-btn--block au-btn--blue2">sign in with twitter</button>
                                    </div>
                                </div>-->
                            </form>
                            <!--<div class="register-link">
                                <p>
                                    Don't you have account?
                                    <a href="#">Sign Up Here</a>
                                </p>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
   <!-- <script src="vendor/animsition/animsition.min.js"></script>-->
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->

<?php  
  }
?> 