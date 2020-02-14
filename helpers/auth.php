<?php
include_once('../config.php');
include_once('../database.php');

function isAuth(){
	if(isset($_SESSION['auth']) && !empty($_SESSION['auth']) ){
		return true;
	}else{
		return false;
	}
}