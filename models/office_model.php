<?php

require_once('database.php');
/**
 * 
 */
class officeModel extends database {
	
	public function __construct() {
        // if you define a function present in the parent also (even __construct())
        // forward call to the parent (unless you have a VALID reason not to)
        parent::__construct();
    }

	function getEmployeeList($request){
		$request 	= 	$_REQUEST;	// storing  request (ie, get/post) global array to a variable  
		$serchArgu 	=	$request['search']['value'];
		$order_col 	=  	$request['order'][0]['column'];
		$order_dir 	=  	$request['order'][0]['dir'];
		$length 	= 	intval($request['length']);
		$offset 	= 	intval($request['start']); 
		$fieldName 	= 	$request['columns'][$order_col]['name']; //it is get column field name in query..
		try{
			$query = "SELECT e.`employeeNumber`, e.`extension`, e.`email`, e.`officeCode`, e.`jobTitle`, CONCAT(e.`firstName`, ' ',e.`lastName`) EmployeeName, IFNULL(CONCAT(CONCAT(m.`firstName`, ' ', m.`lastName`), ' - ', m.`jobTitle`),'SELF') as reportTo 
			FROM `employees` e LEFT JOIN `employees` m ON(m.`employeeNumber` = e.`reportsTo`) WHERE 1 ";
			$sql = $this->conn->prepare($query);
			$sql->execute();
			$countTotal=$sql->rowCount();

			if(!empty($serchArgu)){
				try{
					$query .= " AND (e.EmployeeName LIKE '%$serchArgu%') OR (e.extension LIKE '%$serchArgu%') OR (e.jobTitle LIKE '%$serchArgu%') ";
					$sql = $this->conn->prepare($query);
					$sql->execute();
					$countTotal=$sql->rowCount();		
				}
				catch(PDOException $e){
					echo "PDO Query failed: " . $e->getMessage();
				}	
			}
		}	
		catch(PDOException $e)	{
			echo "PDO Query failed: " . $e->getMessage();
		}

		try{
			if(!empty($order_col)):
				$query .= "ORDER BY $fieldName $order_dir ";
			endif;
			$query .= "LIMIT $length OFFSET $offset ";
			$sql = $this->conn->prepare($query);
			$sql->execute();
			$employees=array();

			while($row = $sql->fetch(PDO::FETCH_OBJ)){
				$employees[]=$row;
			}
			return array('employees'=>$employees, 'countTotal'=>$countTotal);
		}catch(PDOException $e){
			echo "PDO Query failed: " . $e->getMessage();
		}
	}

	function getUserProfile($user_id)
	{
		try
		{
			$query = "SELECT * from users WHERE user_id ='$user_id' ";
			$sql = $this->conn->prepare($query);
			$sql->execute();
			$result = $sql->fetch(PDO::FETCH_OBJ);
			return $result;
		}
		catch(PDOException $e)
		{
			echo "MYSQL Error: " . $e->getMessage();
		}
	}

	function update_unique_email($id, $value){
		$sql = "SELECT user_email From users WHERE user_email ='$value' AND user_id != '$id'";
		$stmt = $this->conn->query($sql);
		$num_rows = $stmt->fetch(PDO::FETCH_NUM);
		if ($num_rows>0) {
			return true;
		}else{
			return false;
		}
	}

	function updateEmployee($employeeNumber, $post){
		try {

			$employeeArr = [
				'lastName' => $post['lastName'],
				'firstName' => $post['firstName'],
				'extension' => $post['extension'],
				'email' => $post['email'],
				'officeCode' => $post['officeCode'],
				'reportsTo' => $post['reportsTo'],
				'jobTitle' => $post['jobTitle']
			];
			extract($employeeArr);

			$sql = "UPDATE employees SET lastName=:lastName, firstName=:firstName, extension=:extension, email=:email, officeCode=:officeCode, reportsTo=:reportsTo, jobTitle=:jobTitle WHERE employeeNumber=:employeeNumber";
			$stmt = $this->conn->prepare($sql);

			$stmt->bindParam(':lastName', $lastName);
			$stmt->bindParam(':firstName', $firstName);
			$stmt->bindParam(':extension', $extension);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':officeCode', $officeCode);
			$stmt->bindParam(':reportsTo', $reportsTo);
			$stmt->bindParam(':jobTitle', $jobTitle);
			$stmt->bindParam(':employeeNumber', $employeeNumber);

			$stmt->execute();
			return true;
		}	
		catch(PDOException $e){
			echo "Error: " . $e->getMessage();die;
		}
	}

	function addCustomer($data){
		try {
			// prepare sql and bind parameters

			extract($data);

			$stmt = $this->conn->prepare("
				INSERT INTO employees 
					(customerName,contactLastName,contactFirstName,phone,addressLine1,addressLine2,city,state,postalCode,country,salesRepEmployeeNumber,creditLimit)
				VALUES 
					(:customerName,:contactLastName,:contactFirstName,:phone,:addressLine1,:addressLine2,:city,:state,:postalCode,:country,:salesRepEmployeeNumber,:creditLimit)");

				$stmt->bindParam(':customerName', $customerName);
				$stmt->bindParam(':contactLastName', $contactLastName);
				$stmt->bindParam(':contactFirstName', $contactFirstName);
				$stmt->bindParam(':phone', $phone);
				$stmt->bindParam(':addressLine1', $addressLine1);
				$stmt->bindParam(':addressLine2', $addressLine2);
				$stmt->bindParam(':city', $city);
				$stmt->bindParam(':state', $state);
				$stmt->bindParam(':postalCode', $postalCode);
				$stmt->bindParam(':country', $country);
				$stmt->bindParam(':salesRepEmployeeNumber', $salesRepEmployeeNumber);
				$stmt->bindParam(':creditLimit', $creditLimit);
			$stmt->execute();

			return true;
		}	
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
			exit();
		}
	}
}

$officeModel = new officeModel();