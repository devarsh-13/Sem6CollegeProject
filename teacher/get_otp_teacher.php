<?php
error_reporting(0);
session_start();

require "../connection.php";

$flag = 0;

if (isset($_POST['getOtp'])) {



	$error = false;

	$mo = $_POST['Contact_no'];
	if (!preg_match("/^[0-9]*$/", $mo)) {

		$error_msg['C'] = ' Enter Only number!!';
		$error = true;
	} elseif (strlen($mo) < 10) {
		$error_msg['C'] = 'Please enter proper 10 Digit number!! ';
		$error = true;
	} elseif (strlen($mo) > 10) {
		$error_msg['C'] = 'Please enter proper 10 Digit number!! ';
		$error = true;
	}
	$query = mysqli_query($Conn, "SELECT `T_srn` FROM `teachers` WHERE `Contact` = '$mo'") or die(mysqli_connect_error());

	$row = mysqli_num_rows($query);
	$arr = mysqli_fetch_row($query);

	if ($row == 1) {
		
		$_SESSION['t_id'] = $arr[0];



		// Account details

		// Message details
		 $numbers = $mo;

		 $otp = mt_rand(1000, 9999);


		 $_SESSION['otp']=$otp;

		



		// Prepare data for POST request

		// Send the POST request with cURL
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://2factor.in/API/V1/0c76f968-a347-11eb-80ea-0200cd936042/SMS/$numbers/$otp",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
			header("location:submit_otp_teacher.php");
		}
	} else {
		$error_msg['C'] = 'Please enter valid number!! ';
		$error = true;
		$flag = 1;
	}
}


?>


<!DOCTYPE html>
<html>

<head>
	<title>Teacher's OTP | IGHS</title>
	<link rel="stylesheet" href="css/log_style.css">
</head>

<body>
	<div class="wrapper">

		<div class="title"></div>

		<form action="#" method="POST">

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