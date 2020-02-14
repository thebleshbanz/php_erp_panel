<?php
require_once('app.php');
require_once('database.php');
session_start();
if(isset($_SESSION['auth']) && !empty($_SESSION['auth']) ){
	header('location:'.base_url.'dashboard.php');
}
	header('location:'.base_url.'login.php');
