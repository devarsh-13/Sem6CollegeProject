<?php
require "../connection.php";
require "../admin/store_data.php";
require "../ec_dc.php";
error_reporting(0);
session_start();

if(isset($_SESSION['a_id']))
{
	echo "<script>alert('Admin Account is loged in from the same Device (logout to continue)');window.location.href='../admin/dashboard.php';</script>";
}
elseif (isset($_SESSION['t_id'])) 
{
	header("location:dashboard.php");	
}
elseif (isset($_SESSION['s_id'])) 
{
	echo "<script>alert('Student Account is loged in from the same Device (logout to continue)');window.location.href='../main.php';</script>";	
}
else
{
	$action="Teacher Login";
	$log=new Log();
	$obj = new ecdc();
	$flag = 0;

	if (isset($_POST['Submit'])) {
		$Contact =	$_POST['Contact_no'];
		//$Password = sha1($_POST['Password']);

		$os=$_POST['Password'];
	$Password= $obj->encrypt($os);

		$error = false;

		$mo = $_POST['Contact_no'];
		if (!preg_match("/^[0-9]*$/", $mo)) {

			$error_msg['C'] = ' Enter Only number!!';
			$error = true;
		} elseif (strlen($mo) < 10) {
			$error_msg['C'] = 'Please enter proper 10 Digit number!! ';
			$error = true;
		}

		$query = mysqli_query($Conn, "SELECT * FROM `teachers` WHERE
				`Contact` = '$Contact' && `Password` = '$Password' AND `is_deleted`='0'
				") or die(mysqli_connect_error());

		$row = mysqli_num_rows($query);
		$arr = mysqli_fetch_row($query);

		if ($row == 1) 
		{
			
			$_SESSION['t_id'] = $arr[0];
			$log->success_entry($action,$Conn);

			if (isset($_POST["remember"])) 
			{
				setcookie("teacher_contact", $Contact, time() + (10 * 365 * 24 * 60 * 60), "/");

				setcookie("teacher_password", $Password, time() + (10 * 365 * 24 * 60 * 60), "/");
				
				$c = mysqli_query($Conn, "SELECT * FROM `teachers` WHERE `Contact` = '$Contact' && `Password` = '$Password' AND `is_deleted`='0'");			
				$count = mysqli_fetch_array($c);
				
				if($count['login_count'] == 0)
				{	
					
					header("location:teacher_info.php");	
				}
				else
				{
					header("location:dashboard.php");
				}
			}
			else 
			{
				$c = mysqli_query($Conn, "SELECT * FROM `teachers` WHERE `Contact` = '$Contact' && `Password` = '$Password'AND `is_deleted`='0'");			
				$count = mysqli_fetch_array($c);
				
				if($count['login_count'] == 0)
				{	
					
					header("location:teacher_info.php");	
				}
				else
				{
					header("location:dashboard.php");
				}
				
				unset($_COOKIE['teacher_contact']);
				setcookie('teacher_contact', null, -1, '/');
				unset($_COOKIE['teacher_password']);
				setcookie('teacher_password', null, -1, '/');
				$c = mysqli_query($Conn, "SELECT * FROM `teachers`");			
				$count = mysqli_fetch_array($c);
				
			}
		}
		else 
		{
			$log = new Log();
			$log->wrong_login($_POST['Contact_no'],$action,$Conn);
			$flag = 1;


			$query = mysqli_query($Conn, "SELECT * FROM `teachers` WHERE
				`Contact` = '$Contact' && `Password` = '$Password' AND `is_deleted`='1'
				") or die(mysqli_connect_error());
			$row = mysqli_num_rows($query);
			$arr = mysqli_fetch_row($query);
			if ($row == 1) 
			{
				$flag = 2;
			}
		}
	}

	?>


	<!DOCTYPE html>
	<html>

	<head>
		<title>Teacher Login Form</title>
		<link rel="stylesheet" href="../css/log_style.css">
	</head>

	<body>
		<div class="wrapper">

			<div class="title">Teacher Login Form</div>

			<form action="#" method="Post">

				<div class="field">
					<input title="Please do not enter Country Code " type="text" name="Contact_no" value="<?php if (isset($_COOKIE["teacher_contact"])) 
					{
																												echo $_COOKIE["teacher_contact"];
																											} ?>" maxlength='10' required>
					<label>Contact Number</label>
				</div>

				<?php

				if (isset($error_msg['C'])) {
					echo "<div class='invalid'><p>" . $error_msg['C'] . "</p></div>";
				}


				?>


				<div class="field">
					<input type="password" name="Password" value="<?php if (isset($_COOKIE['teacher_password'])) {
																		$c=$obj->decrypt($_COOKIE["teacher_password"]);echo $c;
																		
																	} ?>" required>
					<label>Password</label>
				</div>

				<?php
				if ($flag == 1) {
					echo "<div class='invalid'><p>Incorrect Contact Number OR Password</p></div>";
					$flag = 0;
				}
				elseif($flag==2)
				{
					echo "<div class='invalid'><p>This User is Blocked Please Contact Admin</p></div>";
					$flag=0;
				}
				?>

				<div class="content">
					<div class="field-rem">

						<input type="checkbox" name="remember" id="remember" <?php if (isset($_COOKIE["teacher_contact"])) { ?> checked <?php } ?> /> <label for="remember-me">Remember me</label>

					</div>
					<div class="pass-link"><a href="get_otp_teacher.php">Forgot password?</a></div>
				</div>

				<div class="field">
					<input type="submit" name="Submit" value="Login">
				</div>
			</form>
		</div>

	</body>

	</html>
<?php } ?>