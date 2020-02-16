<?php
require_once('config.php');
include('models/user_model.php');
/**
 * 
 */
$action = isset($_GET['action']) ? $_GET['action'] : null;
$ajaxType = isset($_POST['ajaxType']) ? $_POST['ajaxType'] : null;

class UserClass{

	function __construct($action, $ajaxType){
		$this->action = $action;
		$this->ajax_type = $ajaxType;		
	}

	function index(){
		try{
			unset($_SESSION);
			include 'views/include/header.php';
			include 'views/include/sidebar.php';
			include 'views/user/user_list.php';
			include 'views/include/footer.php';
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function getUserList($um_obj){
		$res = $um_obj->getUserList($_POST);
		if(!empty($res['users'])){
			$data = [];
			foreach($res['users'] as $user)
			{
				$row = array();
				$row[]=isset($user->user_id) ? $user->user_id : Null;
				$row[]=isset($user->user_fname) ? $user->user_fname : Null;
				$row[]=isset($user->user_email) ? $user->user_email : Null;
				$row[]=isset($user->user_mobile) ? $user->user_mobile : Null;
				$row[]=isset($user->city) ? $user->city : Null;
				$row[]=isset($user->pincode) ? $user->pincode : Null;
				$row[]=($user->user_status == 1) ? 'active' : 'deactive';
				$row[]=isset($user->address) ? $user->created_at : Null;
				$row[]='<a style="color:green;" href="edit.php?action=edit&id='.$user->user_id.'">Edit</a> | <a style="color:red;" href="dashboard.php?action=delete&id='.$user->user_id.'">Delete</a>';
				$data[] = $row;
			}	
			$output = array(
				"draw" =>intval($_POST['draw']),
				"recordsTotal"=>intval($res['countTotal']),
				"recordsFiltered"=>intval($res['countTotal']),
				"data"=>$data
			);
			echo json_encode($output);
		}else{
			echo json_decode(array('status'=>0));
		}
	}

	function addUser(){
		echo "add new User";
	}

	function editUser(){
		echo "edit exist User";
	}

	function deleteUser(){
		echo "delete exist User";
	}
}

$userObj = new UserClass($action, $ajaxType);
$userModelObj = new userModel();

if(!empty($action)){
	switch ($action) {
		case 'add':
			$userObj->addUser(); exit();
			break;
		
		case 'edit':
			$userObj->editUser(); exit();
			break;
		
		case 'delete':
			$userObj->deleteUser(); exit();
			break;
	}
}else if(!empty($ajaxType)){
	switch ($ajaxType) {
		case 'userList':
			$userObj->getUserList($userModelObj); exit();
			break;
		
		case 'edit':
			$userObj->editUser(); exit();
			break;
		
		case 'delete':
			$userObj->deleteUser(); exit();
			break;
		
		default:
			$userObj->view(); exit();
			break;
	}
}else{
	$userObj->index(); exit;
}

/*if(empty($_GET)){
	$userObj->index(); exit();
}elseif($_GET['action'] == 'add'){
	$userObj->getUserList(); exit();
}*/