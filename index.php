<?php
try{
	require_once('config.php');
	require_once('database.php');
	if(isset($_SESSION['auth']) && !empty($_SESSION['auth']) ){
		header('location:'.base_url.'dashboard.php'); exit();
	}else
		header('location:'.base_url.'login.php'); exit();

	throw new Exception("Error Processing Request", 1);

}catch(Exception $e){
	echo "error :" . $e->getMessage();	
}
