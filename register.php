<?php
include_once('config.php');
include_once('database.php');

$data = $error = array();

if(isset($_SESSION['auth']) && !empty($_SESSION['auth']) ){
	header('location:'.base_url.'dashboard.php');
}

if (isset($_POST['submit']) && $_POST['submit'] == 'Register' ){

	if (empty($_POST["fullname"])) {
		$error['fullname'] = "Full Name is required";
	} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['fullname'])){
		$error['fullname'] = "Only letters and white space allowed";
	}

	if (empty($_POST["mobile"])) {
		$error['mobile'] = "mobile number is required";
	} else if (!preg_match("/^[0-9]*$/",$_POST["mobile"])) {
		$error['mobile'] = "Only numeric value is required";
	}

	if (empty($_POST["email"])) {
		$error['email'] = "Email is required";
	} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error['email']= "Invalid email format";
	}elseif ($db->unique_email($_POST["email"])) {
		$error['email'] = 'Email already Exit';
	}

	if (empty($_POST["password"])){
		$error['password'] = "password is required";
	}
	
	if (empty($_POST["confirm_pwd"])) {
		$error['confirm_pwd'] = "Confirm password is required";
	}elseif($_POST['confirm_pwd']!=$_POST['password']){
		$error['confirm_pwd']="password should be match";
	}

	if (!empty($_POST['pincode'])) {
		if (!preg_match("/^[0-9]*$/", $_POST['pincode'])) {
			$error['pincode']="Only numeric value is required";
		}
	}

	/*if (empty($_POST["terms"])){
		$error['terms'] = "terms is required";
	}*/

	if(empty($error)):
		$extName = explode(' ', $_POST['fullname']);
		
		$data['user_fname'] = $extName[0];
		$data['user_lname'] = $extName[1];
		$data['user_email'] = $_POST['email'];
		$data['user_mobile'] = $_POST['mobile'];
		$data['user_password'] = md5($_POST['password']);
		$data['user_role'] = 'user';
		$data['city'] = $_POST['city'];
		$data['address'] = $_POST['address'];
		$data['pincode'] = $_POST['pincode'];
		$data['user_status'] = 1;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');

		$last_id = $db->AddData('users', $data);
		if($last_id != 0):
			$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
			header('location:'.base_url.'login.php');
			exit();
		else:
			$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
			header('location:'.base_url.'register.php');
			exit();
		endif;  
	endif;
	
}

include('views/register.php');