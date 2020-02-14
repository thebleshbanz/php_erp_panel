<?php
include_once('config.php');
include_once('database.php');

$data = $error = array();

if(isset($_SESSION['auth']) && !empty($_SESSION['auth']) ){
	header('location:'.base_url.'dashboard.php'); exit();
}

if (isset($_POST['submit']) && $_POST['submit'] == 'login' ){

	if (empty($_POST["email"])) {
		$error['email'] = "Email is required";
	} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error['email']= "Invalid email format";
	}

	if (empty($_POST["password"])) {
		$error['password'] = "password is required";
	}
	
	if(empty($error)):
		$data['user_email'] = $_POST['email'];
		$data['user_password'] = md5($_POST['password']);
		$res = $db->get_auth($data);
		if(!empty($res)){
			$_SESSION['auth'] = $res;
			header('location:'.base_url.'dashboard.php'); exit();
		}
	endif;
	
}

include('views/login.php');