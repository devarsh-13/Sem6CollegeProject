<?php 
require "Database/Create_db.php";

$flag=0;

	if(isset($_POST['getOtp']))
	{
		$Contact=	$_POST['Contact_no'];
		
		$error = false;

		$mo=$_POST['Contact_no'];
		if(!preg_match("/^[0-9]*$/", $mo))
		{

			$error_msg['C']=' Enter Only number!!';
			$error=true;
		}
		elseif(strlen($mo)<10)
		{
			$error_msg['C']='Please enter proper 10 Digit number!! ';
			$error=true;
		}
		elseif(strlen($mo)>10)
		{
			$error_msg['C']='Please enter proper 10 Digit number!! ';
			$error=true;
		}
		$query = mysqli_query($Conn,"SELECT `S_srn` FROM `Students` WHERE
			`S_contact` = '$Contact'") or die(mysqli_connect_error());
		
		$row = mysqli_num_rows($query);
		$arr=mysqli_fetch_row($query);
		
		if($row == 1)
		{
			session_start();
			
			$_SESSION['id']=$arr[0];
			header("location:submit_otp_student.php");
		}
		else
		{
			$flag=1;
		}
		
	}

		
?>


<!DOCTYPE html>
<html>

<head>
    <title>get otp</title>
    <link rel="stylesheet" href="css/log_style.css">
</head>

<body>
    <div class="wrapper">

        <div class="title"></div>

        <form action="#" method="Post">

            <div class="field">
                <input title="Please do not enter Country Code " type="text" name="Contact_no" maxlength='10' required>
                <label>Contact Number</label>
            </div>

            <?php

            if (isset($error_msg['C'])) {
                echo "<div class='invalid'><p>" . $error_msg['C'] . "</p></div>";
            }


            ?>


            <div class="field">
                <input type="submit" name="getOtp" value="Get OTP">
            </div>
        </form>
    </div>

</body>

</html>