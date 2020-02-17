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
			include 'views/include/header.php';
			include 'views/include/sidebar.php';
			include 'views/user/user_list.php';
			include 'views/include/footer.php';
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function getUserList($userModelObj){
		$res = $userModelObj->getUserList($_POST);
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
				$row[]='<a style="color:green;" href="user.php?action=edit&user_id='.$user->user_id.'">Edit</a> | <a style="color:red;" href="user.php?action=delete&user_id='.$user->user_id.'">Delete</a>';
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

	function addUser($userModelObj){
		try{
			if ( isset($_POST['submit']) && $_POST['submit'] == 'add' ) {

				if (empty($_POST["fullname"])) {
					$error['fullname'] = "Full Name is required";
				} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['fullname'])){
					$error['fullname'] = "Only letters and white space allowed";
				}else{
					$nameArr = explode(' ', $_POST['fullname']);
					$data['user_fname'] = $nameArr[0];
					$data['user_lname'] = $nameArr[1];
				}

				if (empty($_POST["user_email"])) {
					$error['user_email'] = "Email is required";
				} elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
					$error['user_email']= "Invalid email format";
				}elseif (!empty($userModelObj->unique_email($_POST["user_email"]))){
					$error['user_email'] = 'Email already Exit';
				}else{
					$data['user_email'] = $_POST['user_email'];
				}

				if (empty($_POST["user_mobile"])) {
					$error['user_mobile'] = "mobile number is required";
				} else if (!preg_match("/^[0-9]*$/",$_POST["user_mobile"])) {
					$error['user_mobile'] = "Only numeric value is required";
				}else{
					$data['user_mobile'] = $_POST['user_mobile'];
				}

				if (empty($_POST["user_password"])){
					$error['user_password'] = "password is required";
				}
				
				if (empty($_POST["confirm_pwd"])) {
					$error['confirm_pwd'] = "Confirm password is required";
				}elseif($_POST['confirm_pwd']!=$_POST['user_password']){
					$error['confirm_pwd']="password should be match";
				}else{
					$data['user_password'] = md5($_POST['user_password']);
				}
				
				if (!empty($_POST['pincode'])) {
					if (!preg_match("/^[0-9]*$/", $_POST['pincode'])) {
						$error['pincode']="Only numeric value is required";
					}else{
						$data['pincode'] = $_POST['pincode'];
					}
				}

				$data['city'] = $_POST['city'];
				$data['address'] = $_POST['address'];

				if( isset($_FILES['user_img']) && $_FILES['user_img']['error'] == '0' ){
					
					$path = "assets/uploads/user_img/";
					$allowed_files = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");

					$filename = $_FILES['user_img']['name'];
					$new_name_file = time().'.'.pathinfo($_FILES['user_img']['name'], PATHINFO_EXTENSION);
					$filetype = $_FILES['user_img']['type'];
					$filesize = $_FILES['user_img']['size'];

					// Verify file extension
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					// Verify file size - 1MB maximum
					$maxsize = 1 * 1024 * 1024;

					if(!array_key_exists($ext, $allowed_files)){
						$error['user_img'] = "Error: Please select a valid file format.";
					}else if($filesize > $maxsize){
						$error['user_img'] = "Error: File size is should be less than the 2 MB.";
					}else if(in_array($filetype, $allowed_files)){
						$data['user_img'] = $path.$new_name_file;
						move_uploaded_file($_FILES['user_img']['tmp_name'] , $path.$new_name_file);
					}
				}else{
					$error['user_img'] = "Image is required";
				}

				if(empty($error)){
					// data key should be updated columns name same as in table
					$data['user_role'] = 'user';
					$data['user_status'] = 1;
					$data['created_at'] = date('Y-m-d H:i:s');
					$data['updated_at'] = date('Y-m-d H:i:s');

					$last_id = $userModelObj->AddData('users', $data);

					if(!empty($res)):
						$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
						header('location:'.base_url.'user.php');
						exit();
					else:
						$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
						header('location:'.base_url.'user.php');
						exit();
					endif;	
				}else{
					include 'views/include/header.php';
					include 'views/include/sidebar.php';
					include 'views/user/user_add.php';
					include 'views/include/footer.php';
				}

			}else{
				include 'views/include/header.php';
				include 'views/include/sidebar.php';
				include 'views/user/user_add.php';
				include 'views/include/footer.php';
			}

		}catch(Exception $e){
			echo "Error : ".$e->getMessage();
		}
	}

	function editUser($userModelObj){
		try{
			if( isset($_GET['user_id']) && is_numeric($_GET['user_id']) ){
				$user = $userModelObj->getUserProfile($_GET['user_id']);
				if(!empty($user)){
					
					$data = $message = $error = array();
					
					if ( isset($_POST['submit']) && $_POST['submit'] == 'update' ) {

						$user_id = $_POST['user_id'];

						if (empty($_POST["fullname"])) {
							$error['fullname'] = "Full Name is required";
						} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['fullname'])){
							$error['fullname'] = "Only letters and white space allowed";
						}else{
							$nameArr = explode(' ', $_POST['fullname']);
							$data['user_fname'] = $nameArr[0];
							$data['user_lname'] = $nameArr[1];
						}

						if (empty($_POST["user_email"])) {
							$error['user_email'] = "Email is required";
						} elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
							$error['user_email']= "Invalid email format";
						}elseif (!empty($userModelObj->update_unique_email($_GET['user_id'], $_POST["user_email"]))){
							$error['user_email'] = 'Email already Exit';
						}else{
							$data['user_email'] = $_POST['user_email'];
						}

						if (empty($_POST["user_mobile"])) {
							$error['user_mobile'] = "mobile number is required";
						} else if (!preg_match("/^[0-9]*$/",$_POST["user_mobile"])) {
							$error['user_mobile'] = "Only numeric value is required";
						}else{
							$data['user_mobile'] = $_POST['user_mobile'];
						}

						if (!empty($_POST["user_password"])){
							if($_POST['confirm_pwd']!=$_POST['user_password']){
								$error['confirm_pwd']="password should be match";
							}else{
								$data['user_password'] = $_POST['user_password'];
							}
						}
						
						if (!empty($_POST['pincode'])) {
							if (!preg_match("/^[0-9]*$/", $_POST['pincode'])) {
								$error['pincode']="Only numeric value is required";
							}else{
								$data['pincode'] = $_POST['pincode'];
							}
						}

						$data['city'] = $_POST['city'];
						$data['address'] = $_POST['address'];

						if( isset($_FILES['user_img']) && $_FILES['user_img']['error'] == '0' ){
							
							$path = "assets/uploads/user_img/";
							$allowed_files = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");

							$filename = $_FILES['user_img']['name'];
							$new_name_file = time().'.'.pathinfo($_FILES['user_img']['name'], PATHINFO_EXTENSION);
							$filetype = $_FILES['user_img']['type'];
							$filesize = $_FILES['user_img']['size'];

							// Verify file extension
							$ext = pathinfo($filename, PATHINFO_EXTENSION);
							
							// Verify file size - 1MB maximum
        					$maxsize = 1 * 1024 * 1024;

							if(!array_key_exists($ext, $allowed_files)){
								$error['user_img'] = "Error: Please select a valid file format.";
							}else if($filesize > $maxsize){
								$error['user_img'] = "Error: File size is should be less than the 2 MB.";
							}else if(in_array($filetype, $allowed_files)){
								$data['user_img'] = $path.$new_name_file;
								move_uploaded_file($_FILES['user_img']['tmp_name'] , $path.$new_name_file);
							}
						}

						if(empty($error)){
							// data key should be updated columns name same as in table
							$res = $userModelObj->updateUser($user_id, $data);
							if(!empty($res)):
								$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
								header('location:'.base_url.'user.php');
								exit();
							else:
								$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
								header('location:'.base_url.'user.php');
								exit();
							endif;	
						}else{
							include 'views/include/header.php';
							include 'views/include/sidebar.php';
							include 'views/user/user_edit.php';
							include 'views/include/footer.php';
						}

					}else{
						include 'views/include/header.php';
						include 'views/include/sidebar.php';
						include 'views/user/user_edit.php';
						include 'views/include/footer.php';
					}
				}else{
					header('location:'.base_url.'user.php');
					exit();	
				}
			}else{
				header('location:'.base_url.'user.php');
				exit();
			}
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function deleteUser($userModelObj){
		try{
			if( isset($_GET['user_id']) && is_numeric($_GET['user_id']) ){
				$user_id = $_POST['user_id'];
				$user = $userModelObj->getUserProfile($_GET['user_id']);
				if(!empty($user)){
					$data = [];
					if ( isset($_POST['submit']) && $_POST['submit'] == 'delete' ) {
						$data['user_status'] = 0;
						$data['updated_at']  = date('Y-m-d H:i:s');
						$res = $userModelObj->updateData('users', $user_id, $data);
						
						if(!empty($res)):
							$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
							header('location:'.base_url.'user.php');
							exit();
						else:
							$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
							header('location:'.base_url.'user.php');
							exit();
						endif;
					}else{
						include 'views/include/header.php';
						include 'views/include/sidebar.php';
						include 'views/user/user_delete.php';
						include 'views/include/footer.php';
					}
				}else{
					header('location:'.base_url.'user.php');
					exit();	
				}
			}else{
				header('location:'.base_url.'user.php');
				exit();
			}
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}
}

$userObj = new UserClass($action, $ajaxType);
$userModelObj = new userModel();

if(!empty($action)){
	switch ($action) {
		case 'add':
			$userObj->addUser($userModelObj);
			break;
		
		case 'edit':
			$userObj->editUser($userModelObj);
			break;
		
		case 'delete':
			$userObj->deleteUser($userModelObj);
			break;
	}
}else if(!empty($ajaxType)){
	switch ($ajaxType) {
		case 'userList':
			$userObj->getUserList($userModelObj);
			break;
		
		case 'edit':
			$userObj->editUser();
			break;
		
		case 'delete':
			$userObj->deleteUser();
			break;
		
		default:
			$userObj->view();
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