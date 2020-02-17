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

	function updateUser($user_id, $post){
		try {
			$userArr = array(
				'id' => $user_id,
				'user_fname' => $post['user_fname'],
				'user_lname' => $post['user_lname'],
				'user_email' => $post['user_email'],
				'user_mobile' => $post['user_mobile'],
				'user_img' => $post['user_img'],
				'city' => $post['city'],
				'address' => $post['address'],
				'pincode' => $post['pincode'],
				'updated_at' => date('Y-m-d H:i:s')
			);
			extract($userArr);
			$sql = "UPDATE users SET user_fname=:user_fname, user_lname=:user_lname, user_email=:user_email, user_mobile=:user_mobile, user_img=:user_img, city=:city, address=:address, pincode=:pincode, updated_at=:updated_at WHERE user_id=:user_id";
			$stmt = $this->conn->prepare($sql);

			$stmt->bindParam(':user_fname', $user_fname);
			$stmt->bindParam(':user_lname', $user_lname);
			$stmt->bindParam(':user_email', $user_email);
			$stmt->bindParam(':user_mobile', $user_mobile);
			$stmt->bindParam(':user_img', $user_img);
			$stmt->bindParam(':city', $city);
			$stmt->bindParam(':address', $address);
			$stmt->bindParam(':pincode', $pincode);
			$stmt->bindParam(':updated_at', $updated_at);
			$stmt->bindParam(':user_id', $id);
			$stmt->execute();
			return true;
		}	
		catch(PDOException $e){
			echo "Error: " . $e->getMessage();
			return false;
		}
	}
}

$userModel = new userModel();