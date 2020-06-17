<?php

require_once('database.php');
/**
 * 
 */
class customerModel extends database {
	
	public function __construct() {
        // if you define a function present in the parent also (even __construct())
        // forward call to the parent (unless you have a VALID reason not to)
        parent::__construct();
    }

	function getCustomerList($request){
		$request 	= 	$_REQUEST;	// storing  request (ie, get/post) global array to a variable  
		$serchArgu 	=	$request['search']['value'];
		$order_col 	=  	$request['order'][0]['column'];
		$order_dir 	=  	$request['order'][0]['dir'];
		$length 	= 	intval($request['length']);
		$offset 	= 	intval($request['start']); 
		$fieldName 	= 	$request['columns'][$order_col]['name']; //it is get column field name in query..
		try{
			$query = "SELECT customers.*, CONCAT( employees.firstName, ' ', employees.lastName) AS empFullName FROM customers LEFT JOIN employees ON(customers.salesRepEmployeeNumber = employees.employeeNumber) WHERE 1 ";
			$sql = $this->conn->prepare($query);
			$sql->execute();
			$countTotal=$sql->rowCount();

			if(!empty($serchArgu)){
				try{
					$query .= " AND (customerName LIKE '%$serchArgu%') OR (phone LIKE '%$serchArgu%') ";
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
			$customers=array();

			while($row = $sql->fetch(PDO::FETCH_OBJ)){
				$customers[]=$row;
			}
			return array('customers'=>$customers, 'countTotal'=>$countTotal);
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

	function updateCustomer($customerNumber, $post){
		try {

			$customerArr = [
				'customerName' => $post['customerName'],
				'contactLastName' => $post['contactLastName'],
				'contactFirstName' => $post['contactFirstName'],
				'phone' => $post['phone'],
				'addressLine1' => $post['addressLine1'],
				'addressLine2' => $post['addressLine2'],
				'city' => $post['city'],
				'state' => $post['state'],
				'postalCode' => $post['postalCode'],
				'country' => $post['country'],
				'salesRepEmployeeNumber' => $post['salesRepEmployeeNumber'],
				'creditLimit' => $post['creditLimit'],
			];
			extract($customerArr);

			$sql = "UPDATE customers SET customerName = :customerName, contactLastName = :contactLastName, contactFirstName = :contactFirstName, phone = :phone, addressLine1 = :addressLine1, addressLine2 = :addressLine2, city = :city, state = :state, postalCode = :postalCode, country = :country, salesRepEmployeeNumber = :salesRepEmployeeNumber, creditLimit = :creditLimit WHERE customerNumber=:customerNumber";
			$stmt = $this->conn->prepare($sql);

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
			$stmt->bindParam(':customerNumber', $customerNumber);
			
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
				INSERT INTO customers 
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

$customerModel = new customerModel();