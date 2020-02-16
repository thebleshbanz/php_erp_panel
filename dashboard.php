<?php
try{

	require_once('database.php');
	
	include 'views/include/header.php';
	include 'views/include/sidebar.php';
	include 'views/dashboard.php';
	include 'views/include/footer.php';

}catch(Exception $e){
	echo "Error : ". $e->getMessage();
}