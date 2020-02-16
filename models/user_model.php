<?php

require_once('database.php');
/**
 * 
 */
class userModel extends database {
	
	public function __construct() {
        // if you define a function present in the parent also (even __construct())
        // forward call to the parent (unless you have a VALID reason not to)
        parent::__construct();
    }

	function getUserList($request){
		$request 	= 	$_REQUEST;	// storing  request (ie, get/post) global array to a variable  
		$serchArgu 	=	$request['search']['value'];
		$order_col 	=  	$request['order'][0]['column'];
		$order_dir 	=  	$request['order'][0]['dir'];
		$length 	= 	intval($request['length']);
		$offset 	= 	intval($request['start']); 
		$fieldName 	= 	$request['columns'][$order_col]['name']; //it is get column field name in query..
		try{
			$query = "SELECT * FROM users WHERE user_role != 'admin' ";
			$sql = $this->conn->prepare($query);
			$sql->execute();
			$countTotal=$sql->rowCount();

			if(!empty($serchArgu)){
				try{
					$query .= " AND (user_fname LIKE '%$serchArgu%') OR (user_mobile LIKE '%$serchArgu%') OR (user_email LIKE '%$serchArgu%')  OR (city LIKE '%$serchArgu%') OR (pincode LIKE '%$serchArgu%')";
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
			$users=array();

			while($row = $sql->fetch(PDO::FETCH_OBJ)){
				$users[]=$row;
			}
			return array('users'=>$users, 'countTotal'=>$countTotal);
		}catch(PDOException $e){
			echo "PDO Query failed: " . $e->getMessage();
		}
	}
}

$userModel = new userModel();