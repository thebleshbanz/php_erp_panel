<?php
require_once('config.php');
include('models/office_model.php');
/**
 * 
 */
$action = isset($_GET['action']) ? $_GET['action'] : null;
$ajaxType = isset($_POST['ajaxType']) ? $_POST['ajaxType'] : null;

class OfficeClass{

	function __construct($action, $ajaxType){
		$this->action = $action;
		$this->ajax_type = $ajaxType;		
	}

	function index($office_db){
		try{
			$countries = $office_db->getAllCountry();
			$offices = $office_db->getTableAllValue('offices');
			include 'views/include/header.php';
			include 'views/include/sidebar.php';
			include 'views/office/office_list.php';
			include 'views/include/footer.php';
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function getEmployeeList($office_db){
		$res = $office_db->getEmployeeList($_POST);
		if(!empty($res['employees'])){
			$data = [];
			foreach($res['employees'] as $employee)
			{
				$row = array();
				$row[]=isset($employee->employeeNumber) ? $employee->employeeNumber : Null;
				$row[]=isset($employee->EmployeeName) ? $employee->EmployeeName : Null;
				$row[]=isset($employee->extension) ? $employee->extension : Null;
				$row[]=isset($employee->email) ? $employee->email : Null;
				$row[]=isset($employee->officeCode) ? $employee->officeCode : Null;
				$row[]=isset($employee->jobTitle) ? $employee->jobTitle : Null;
				$row[]=isset($employee->reportTo) ? $employee->reportTo : Null;
				$row[]='<a style="color:blue;" href="employee.php?action=view&employeeNumber='.$employee->employeeNumber.'">View</a> | <a style="color:green;" href="employee.php?action=edit&employeeNumber='.$employee->employeeNumber.'">Edit</a> | <a style="color:red;" href="employee.php?action=delete&employeeNumber='.$employee->employeeNumber.'">Delete</a>';
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

	function addEmployee($office_db){
		try{
			if ( isset($_POST['submit']) && $_POST['submit'] == 'add' ) {

				if (empty($_POST["employeeName"])) {
					$error['employeeName'] = "Employee Name is required";
				} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['employeeName'])){
					$error['employeeName'] = "Only letters and white space allowed";
				}

				if (empty($_POST["extension"])) {
					$error['extension'] = "Extension is required";
				} else if (!preg_match("/^[a-zA-Z0-9]*$/",$_POST['extension'])){
					$error['extension'] = "Only letters and white space allowed";
				}

				if (empty($_POST["email"])) {
					$error['email'] = "Email is required";
				} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
					$error['email']= "Invalid email format";
				}elseif ( !empty( $office_db->getTableValue( 'employees', 'email', $_POST["email"]) ) ){
					$error['email'] = 'Email already Exit';
				}

				if (empty($_POST["officeCode"])){
					$error['officeCode'] = "officeCode is required";
				}

				if (empty($_POST["jobTitle"])){
					$error['jobTitle'] = "jobTitle is required";
				}else{
					if (empty($_POST["reportsTo"])){
						$error['reportsTo'] = "reportsTo is required";
					}
				}

				if(empty($error)){
					// data key should be updated columns name same as in table
					$nameArr = explode(' ', $_POST['employeeName']);
					$data['lastName'] = $nameArr[1];
					$data['firstName'] = $nameArr[0];
					$data['extension'] = $_POST['extension'];
					$data['email'] = $_POST['email'];
					$data['officeCode'] = $_POST['officeCode'];
					$data['reportsTo'] = $_POST['reportsTo'];
					$data['jobTitle'] = $_POST['jobTitle'];

					$last_id = $office_db->AddData('employees', $data);

					if(!empty($last_id)):
						$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
						header('location:'.base_url.'employee.php');
						exit();
					else:
						$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
						header('location:'.base_url.'employee.php');
						exit();
					endif;	
				}else{
					$offices = $office_db->getTableAllValue('offices');
					include 'views/include/header.php';
					include 'views/include/sidebar.php';
					include 'views/employee/employee_add.php';
					include 'views/include/footer.php';
				}

			}else{
				$offices = $office_db->getTableAllValue('offices');
				include 'views/include/header.php';
				include 'views/include/sidebar.php';
				include 'views/employee/employee_add.php';
				include 'views/include/footer.php';
			}

		}catch(Exception $e){
			echo "Error : ".$e->getMessage();
		}
	}

	function editEmployee($office_db){
		try{
			if( isset($_GET['employeeNumber']) && is_numeric($_GET['employeeNumber']) )
			{
				$employee = $office_db->getTableValue('employees', 'employeeNumber', $_GET['employeeNumber']);
				
				if(!empty($employee))
				{
					$data = $message = $error = array();
					if ( isset($_POST['submit']) && $_POST['submit'] == 'update' ) 
					{
						$employeeNumber = $_POST['employeeNumber'];

						if (empty($_POST["employeeName"])) {
							$error['employeeName'] = "Employee Name is required";
						} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['employeeName'])){
							$error['employeeName'] = "Only letters and white space allowed";
						}

						if (empty($_POST["extension"])) {
							$error['extension'] = "Extension is required";
						} else if (!preg_match("/^[a-zA-Z0-9]*$/",$_POST['extension'])){
							$error['extension'] = "Only letters and white space allowed";
						}

						if (empty($_POST["email"])) {
							$error['email'] = "Email is required";
						} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
							$error['email']= "Invalid email format";
						}

						if (empty($_POST["officeCode"])){
							$error['officeCode'] = "officeCode is required";
						}

						if (empty($_POST["jobTitle"])){
							$error['jobTitle'] = "jobTitle is required";
						}else{
							if (empty($_POST["reportsTo"])){
								$error['reportsTo'] = "reportsTo is required";
							}
						}

						if(empty($error)){
							// data key should be updated columns name same as in table
							$nameArr = explode(' ', $_POST['employeeName']);
							$data['lastName'] = $nameArr[1];
							$data['firstName'] = $nameArr[0];
							$data['extension'] = $_POST['extension'];
							$data['email'] = $_POST['email'];
							$data['officeCode'] = $_POST['officeCode'];
							$data['reportsTo'] = $_POST['reportsTo'];
							$data['jobTitle'] = $_POST['jobTitle'];
							// data key should be updated columns name same as in table
							$res = $office_db->updateEmployee($employeeNumber, $data);
							if(!empty($res)):
								$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
								header('location:'.base_url.'employee.php');
								exit();
							else:
								$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
								header('location:'.base_url.'employee.php');
								exit();
							endif;	
						}else{
							$offices = $office_db->getTableAllValue('offices');
							$reportTo_res = $office_db->getReportToData($employee->jobTitle);
							include 'views/include/header.php';
							include 'views/include/sidebar.php';
							include 'views/employee/employee_edit.php';
							include 'views/include/footer.php';
						}

					}else{
						$offices = $office_db->getTableAllValue('offices');
						$reportTo_res = $office_db->getReportToData($employee->jobTitle);
						include 'views/include/header.php';
						include 'views/include/sidebar.php';
						include 'views/employee/employee_edit.php';
						include 'views/include/footer.php';
					}
				}else{
					header('location:'.base_url.'employee.php');
					exit();	
				}
			}else{
				header('location:'.base_url.'employee.php');
				exit();
			}
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function deleteEmployee($office_db){
		try{
			if( isset($_GET['employeeNumber']) && is_numeric($_GET['employeeNumber']) ){
				$employee = $office_db->getTableValue('employees', 'employeeNumber', $_GET['employeeNumber']);
				if(!empty($employee)){
					$data = [];
					if ( isset($_POST['submit']) && $_POST['submit'] == 'delete' ) {
						$employeeNumber = $_POST['employeeNumber'];
						$res = $office_db->deleteData('employees', array('employeeNumber = ?'=>$employeeNumber));
						
						if(!empty($res)):
							$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
							header('location:'.base_url.'employee.php');
							exit();
						else:
							$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
							header('location:'.base_url.'employee.php');
							exit();
						endif;
					}else{
						$offices = $office_db->getTableAllValue('offices');
						$reportTo_res = $office_db->getReportToData($employee->jobTitle);
						include 'views/include/header.php';
						include 'views/include/sidebar.php';
						include 'views/employee/employee_delete.php';
						include 'views/include/footer.php';
					}
				}else{
					header('location:'.base_url.'employee.php');
					exit();	
				}
			}else{
				header('location:'.base_url.'employee.php');
				exit();
			}
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function viewEmployee($office_db){
		try{
			if( isset($_GET['employeeNumber']) && is_numeric($_GET['employeeNumber']) ){
				$employee = $office_db->getTableValue('employees', 'employeeNumber', $_GET['employeeNumber']);
				if(!empty($employee)){
					$offices = $office_db->getTableAllValue('offices');
					$reportTo_res = $office_db->getReportToData($employee->jobTitle);
					include 'views/include/header.php';
					include 'views/include/sidebar.php';
					include 'views/employee/employee_view.php';
					include 'views/include/footer.php';
				}else{
					header('location:'.base_url.'employee.php');
					exit();	
				}
			}else{
				header('location:'.base_url.'employee.php');
				exit();
			}
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}
}

$officeObj = new OfficeClass($action, $ajaxType);
$office_db = new officeModel();

if(!empty($action)){
	switch ($action) {
		case 'add':
			$officeObj->addEmployee($office_db);
			break;
		
		case 'edit':
			$officeObj->editEmployee($office_db);
			break;
		
		case 'delete':
			$officeObj->deleteEmployee($office_db);
			break;
		
		case 'view':
			$officeObj->viewEmployee($office_db);
			break;
	}
}else if(!empty($ajaxType)){
	switch ($ajaxType) {
		case 'employeeList':
			$officeObj->getEmployeeList($office_db);
			break;
		
		case 'edit':
			$officeObj->editUser();
			break;
		
		case 'delete':
			$officeObj->deleteUser();
			break;
		
		default:
			$officeObj->view();
			break;
	}
}else{
	$officeObj->index($office_db); exit;
}