<?php
require_once('config.php');
include('models/customer_model.php');
/**
 * 
 */
$action = isset($_GET['action']) ? $_GET['action'] : null;
$ajaxType = isset($_POST['ajaxType']) ? $_POST['ajaxType'] : null;

class CustomerClass{

	function __construct($action, $ajaxType){
		$this->action = $action;
		$this->ajax_type = $ajaxType;		
	}

	function index(){
		try{
			include 'views/include/header.php';
			include 'views/include/sidebar.php';
			include 'views/customer/customer_list.php';
			include 'views/include/footer.php';
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function getCustomerList($customer_db){
		$res = $customer_db->getCustomerList($_POST);
		if(!empty($res['customers'])){
			$data = [];
			foreach($res['customers'] as $customer)
			{
				$row = array();
				$row[]=isset($customer->customerNumber) ? $customer->customerNumber : Null;
				$row[]=isset($customer->customerName) ? $customer->customerName : Null;
				$row[]=isset($customer->contactLastName) ? $customer->contactFirstName.' '.$customer->contactLastName : Null;
				$row[]=isset($customer->phone) ? $customer->phone : Null;
				$row[]=isset($customer->empFullName) ? $customer->empFullName : Null;
				$row[]=isset($customer->creditLimit) ? $customer->creditLimit : Null;
				$row[]='<a style="color:blue;" href="customer.php?action=view&customerNumber='.$customer->customerNumber.'">View</a> | <a style="color:green;" href="customer.php?action=edit&customerNumber='.$customer->customerNumber.'">Edit</a> | <a style="color:red;" href="customer.php?action=delete&customerNumber='.$customer->customerNumber.'">Delete</a>';
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

	function addCustomer($customer_db){
		try{
			if ( isset($_POST['submit']) && $_POST['submit'] == 'add' ) {

				if (empty($_POST["customerName"])) {
					$error['customerName'] = "customerNumber Name is required";
				} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['customerName'])){
					$error['customerName'] = "Only letters and white space allowed";
				}

				if (empty($_POST["contactFullName"])) {
					$error['contactFullName'] = "Contact Full Name is required";
				} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['contactFullName'])){
					$error['contactFullName'] = "Only letters and white space allowed";
				}

				if(empty($_POST["phone"])) {
					$error['phone'] = "mobile number is required";
				}else if (!preg_match("/^[0-9]*$/",$_POST["phone"])) {
					$error['phone'] = "Only numeric value is required";
				}

				if (empty($_POST["creditLimit"])) {
					$error['creditLimit'] = "credit limit is required";
				} else if (!preg_match("/^[0-9]*$/",$_POST["creditLimit"])) {
					$error['creditLimit'] = "Only numeric value is required";
				}

				if (empty($_POST["salesRepEmployeeNumber"])){
					$error['salesRepEmployeeNumber'] = "employees is required";
				}

				if (empty($_POST["country"])){
					$error['country'] = "country is required";
				}else{
					if (empty($_POST["state"])){
						$error['state'] = "state is required";
					}
				}
				
				if (!empty($_POST['postalCode'])) {
					if (!preg_match("/^[0-9]*$/", $_POST['postalCode'])) {
						$error['postalCode']="Only numeric value is required";
					}
				}

				if(empty($error)){
					// data key should be updated columns name same as in table
					$nameArr = explode(' ', $_POST['contactFullName']);
					$data['customerName'] = $_POST["customerName"];
					$data['contactLastName'] = $nameArr[1];
					$data['contactFirstName'] = $nameArr[0];
					$data['phone'] = $_POST['phone'];
					$data['addressLine1'] = $_POST['addressLine1'];
					$data['addressLine2'] = $_POST['addressLine2'];
					$data['city'] = $_POST['city'];
					$data['state'] = $_POST['state'];
					$data['postalCode'] = $_POST['postalCode'];
					$data['country'] = $_POST['country'];
					$data['salesRepEmployeeNumber'] = $_POST['salesRepEmployeeNumber'];
					$data['creditLimit'] = $_POST['creditLimit'];

					$last_id = $customer_db->AddData('customers', $data);

					if(!empty($last_id)):
						$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
						header('location:'.base_url.'customer.php');
						exit();
					else:
						$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
						header('location:'.base_url.'customer.php');
						exit();
					endif;	
				}else{
					$countries = $customer_db->getAllCountry();
					$employees = $customer_db->getTableAllValue('employees');
					include 'views/include/header.php';
					include 'views/include/sidebar.php';
					include 'views/customer/customer_add.php';
					include 'views/include/footer.php';
				}

			}else{
				$countries = $customer_db->getAllCountry();
				$employees = $customer_db->getTableAllValue('employees');
				include 'views/include/header.php';
				include 'views/include/sidebar.php';
				include 'views/customer/customer_add.php';
				include 'views/include/footer.php';
			}

		}catch(Exception $e){
			echo "Error : ".$e->getMessage();
		}
	}

	function editCustomer($customer_db){
		try{
			if( isset($_GET['customerNumber']) && is_numeric($_GET['customerNumber']) ){
				$customer = $customer_db->getTableValue('customers', 'customerNumber', $_GET['customerNumber']);
				if(!empty($customer)){				
					$data = $message = $error = array();
					if ( isset($_POST['submit']) && $_POST['submit'] == 'update' ) {

						$customerNumber = $_POST['customerNumber'];

						if (empty($_POST["customerName"])) {
							$error['customerName'] = "customerNumber Name is required";
						} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['customerName'])){
							$error['customerName'] = "Only letters and white space allowed";
						}

						if (empty($_POST["contactFullName"])) {
							$error['contactFullName'] = "Contact Full Name is required";
						} else if (!preg_match("/^[a-zA-Z ]*$/",$_POST['contactFullName'])){
							$error['contactFullName'] = "Only letters and white space allowed";
						}

						if(empty($_POST["phone"])) {
							$error['phone'] = "mobile number is required";
						}else if (!preg_match("/^[0-9]*$/",$_POST["phone"])) {
							$error['phone'] = "Only numeric value is required";
						}

						if (empty($_POST["creditLimit"])) {
							$error['creditLimit'] = "credit limit is required";
						} else if (!preg_match("/^[0-9]+(\.[0-9]{1,2})?$/",$_POST["creditLimit"])) {
							$error['creditLimit'] = "Only numeric value is required";
						}

						if (empty($_POST["salesRepEmployeeNumber"])){
							$error['salesRepEmployeeNumber'] = "employees is required";
						}

						if (empty($_POST["country"])){
							$error['country'] = "country is required";
						}else{
							if (empty($_POST["state"])){
								$error['state'] = "state is required";
							}
						}
						
						if (!empty($_POST['postalCode'])) {
							if (!preg_match("/^[0-9]*$/", $_POST['postalCode'])) {
								$error['postalCode']="Only numeric value is required";
							}
						}

						if(empty($error)){
							$nameArr = explode(' ', $_POST['contactFullName']);
							$data['customerName'] = $_POST["customerName"];
							$data['contactLastName'] = $nameArr[1];
							$data['contactFirstName'] = $nameArr[0];
							$data['phone'] = $_POST['phone'];
							$data['addressLine1'] = $_POST['addressLine1'];
							$data['addressLine2'] = $_POST['addressLine2'];
							$data['city'] = $_POST['city'];
							$data['state'] = $_POST['state'];
							$data['postalCode'] = $_POST['postalCode'];
							$data['country'] = $_POST['country'];
							$data['salesRepEmployeeNumber'] = $_POST['salesRepEmployeeNumber'];
							$data['creditLimit'] = $_POST['creditLimit'];
							// data key should be updated columns name same as in table
							$res = $customer_db->updateCustomer($customerNumber, $data);
							if(!empty($res)):
								$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
								header('location:'.base_url.'customer.php');
								exit();
							else:
								$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
								header('location:'.base_url.'customer.php');
								exit();
							endif;	
						}else{
							$countries = $customer_db->getAllCountry();
							$employees = $customer_db->getTableAllValue('employees');
							include 'views/include/header.php';
							include 'views/include/sidebar.php';
							include 'views/customer/customer_edit.php';
							include 'views/include/footer.php';
						}

					}else{
						$countries = $customer_db->getAllCountry();
						$employees = $customer_db->getTableAllValue('employees');
						include 'views/include/header.php';
						include 'views/include/sidebar.php';
						include 'views/customer/customer_edit.php';
						include 'views/include/footer.php';
					}
				}else{
					header('location:'.base_url.'customer.php');
					exit();	
				}
			}else{
				header('location:'.base_url.'customer.php');
				exit();
			}
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function deleteCustomer($customer_db){
		try{
			if( isset($_GET['customerNumber']) && is_numeric($_GET['customerNumber']) ){
				$customer = $customer_db->getTableValue('customers', 'customerNumber', $_GET['customerNumber']);
				if(!empty($customer)){
					$data = [];
					if ( isset($_POST['submit']) && $_POST['submit'] == 'delete' ) {
						$customerNumber = $_POST['customerNumber'];
						$res = $customer_db->deleteData('customers', array('customerNumber = ?'=>$customerNumber));
						
						if(!empty($res)):
							$message = '<div class="alert alert-success text-center"><h2>Thank You</h2><br>You have signup successfully.Please click to <a href="signin.php">sign in</a> </div>';
							header('location:'.base_url.'customer.php');
							exit();
						else:
							$message = '<div class="alert alert-danger text-center"><h2>Oops</h2><br>some database error </div>';
							header('location:'.base_url.'customer.php');
							exit();
						endif;
					}else{
						$countries = $customer_db->getAllCountry();
						$employees = $customer_db->getTableAllValue('employees');
						include 'views/include/header.php';
						include 'views/include/sidebar.php';
						include 'views/customer/customer_delete.php';
						include 'views/include/footer.php';
					}
				}else{
					header('location:'.base_url.'customer.php');
					exit();	
				}
			}else{
				header('location:'.base_url.'customer.php');
				exit();
			}
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function viewCustomer($customer_db){
		try{
			if( isset($_GET['customerNumber']) && is_numeric($_GET['customerNumber']) ){
				$customer = $customer_db->getTableValue('customers', 'customerNumber', $_GET['customerNumber']);
				if(!empty($customer)){
					$countries = $customer_db->getAllCountry();
					$employees = $customer_db->getTableAllValue('employees');
					include 'views/include/header.php';
					include 'views/include/sidebar.php';
					include 'views/customer/customer_view.php';
					include 'views/include/footer.php';
				}else{
					header('location:'.base_url.'customer.php');
					exit();	
				}
			}else{
				header('location:'.base_url.'customer.php');
				exit();
			}
		}catch(Exception $e){
			echo "Error : ". $e->getMessage();
		}
	}
}

$customerObj = new CustomerClass($action, $ajaxType);
$customer_db = new customerModel();

if(!empty($action)){
	switch ($action) {
		case 'add':
			$customerObj->addCustomer($customer_db);
			break;
		
		case 'edit':
			$customerObj->editCustomer($customer_db);
			break;
		
		case 'delete':
			$customerObj->deleteCustomer($customer_db);
			break;
		
		case 'view':
			$customerObj->viewCustomer($customer_db);
			break;
	}
}else if(!empty($ajaxType)){
	switch ($ajaxType) {
		case 'customerList':
			$customerObj->getCustomerList($customer_db);
			break;
		
		case 'edit':
			$customerObj->editUser();
			break;
		
		case 'delete':
			$customerObj->deleteUser();
			break;
		
		default:
			$customerObj->view();
			break;
	}
}else{
	$customerObj->index(); exit;
}