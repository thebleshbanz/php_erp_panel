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
	
	if(isset($_POST['action']) && $_POST['action'] == 'onChangeJobTitle'){
		$jobTitle = isset($_POST['jobTitle']) ? $_POST['jobTitle'] : 0;
		$reportTo_res = $db->getReportToData($jobTitle);
		if(!empty($reportTo_res)){
			echo json_encode(array('status'=>1, 'res'=>$reportTo_res));
		}else{
			echo json_encode(array('status'=>0));
		}
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'onSubmitOfficeForm'){
		$data['addressLine1'] = $_POST['addressLine1'];
		$data['addressLine2'] = $_POST['addressLine2'];
		$data['phone'] = $_POST['phone'];
		$data['city'] = $_POST['city'];
		$data['country'] = $_POST['country'];
		$data['state'] = $_POST['state'];
		$data['postalCode'] = $_POST['postalCode'];
		$data['territory'] = $_POST['territory'];

		$last_id = $db->AddData('offices', $data);
		if(!empty($last_id)){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'onClickOfficeView'){
		$officeRow = $db->getTableValue('offices', 'officeCode', $_POST['officeCode']);
		if(!empty($officeRow)){
			echo json_encode(array('status'=>1, 'data'=>$officeRow));
		}else{
			echo json_encode(array('status'=>0));
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'onClickOfficeDelete'){
		if(isset($_POST['officeCode']) && is_numeric($_POST['officeCode']) ){
			$res = $db->deleteData('offices' , array('officeCode' => $_POST['officeCode']));
			if(!empty($res)){
				echo json_encode(array('status'=>1));
			}else{
				echo json_encode(array('status'=>0));
			}
		}
	}
}