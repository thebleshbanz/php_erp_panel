<?php
include '../database.php';
if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action'] == 'onChangeCountry'){
		$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
		$state_res = $db->getStateListByCountryID($country_id);
		if(!empty($state_res)){
			echo json_encode(array('status'=>1, 'res'=>$state_res));
		}else{
			echo json_encode(array('status'=>0));
		}
	}
}