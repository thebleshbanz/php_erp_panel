<?php
include_once('config.php');
/**
 * Database connection established
 */
class database
{
	
	public function __construct()
	{
		$host		= "localhost";
		$username	= "root";
		$password	= "root";
		$dbname		= "erp_php_demo";
		try {
			$this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			$message = "Connection failed: " . $e->getMessage();
			header('Location: '.base_url.'error.php?message='.$message);
		}
	}

	function unique_email($value){
		try{
			$sql = "SELECT user_email From users WHERE user_email = :email ";
			$stm = $this->conn->prepare($sql);
			$stm->execute(['email'=>$value]);
			$num_rows=$stm->fetch(PDO::FETCH_NUM);
			if ($num_rows>0) {
				return true;
			}else{
				return false;
			}
		}catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		}		
	}

	public	function get_auth($data)
	{
		try{
			$sql ="SELECT * FROM users WHERE user_email = '".$data['user_email']."' AND user_password = '".$data['user_password']."'";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();		
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			if (!empty($result)) {
				return $result;
			}else{
				return false;
			}
		}catch(PDOException $e){
			echo "Error : ". $e->getMessage();
		}
	}

	function AddData($table_name , $post){
		try{
			$columnString = implode(',', array_keys($post));
			$valueString = implode(',', array_fill(0, count($post), '?'));
			$query = "INSERT INTO ".$table_name." ({$columnString}) VALUES ({$valueString})";
			$stmt = $this->conn->prepare($query);
			$stmt->execute(array_values($post));
			return $this->conn->lastInsertId();
		}catch(PDOException $e){
			echo "Error : ". $e->getMessage();
			exit();
		}
	}

	function updateData($table_name, $user_id, $post){
		$allowed = [];
		foreach($post as $key => $value){
			// the list of allowed field names
			$allowed[] = $key;
		}
		// initialize an array with values:
		$params = [];

		// initialize a string with `fieldname` = :placeholder pairs
		$setStr = "";

		// loop over source data array
		foreach ($allowed as $key){
		    if (isset($post[$key]) && $key != "user_id"){
		        $setStr .= "`$key` = :$key,";
		        $params[$key] = $post[$key];
		    }
		}
		$setStr = rtrim($setStr, ",");

		$params['user_id'] = $user_id;
		$query = "UPDATE ".$table_name." SET $setStr WHERE user_id = :user_id";
		return $this->conn->prepare($query)->execute($params);
	}

	// Country List 
	public function getAllCountry()
	{
		$data = [];
		try{
			$sql ="SELECT * FROM com_country WHERE country_status = 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();		
			// $result = $stmt->fetch(PDO::FETCH_ASSOC);
			while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}else{
				return false;
			}
		}catch(PDOException $e){
			echo "Error : ". $e->getMessage();
		}
	}

	// Get all State List  
	public function getAllState()
	{
		try{
			$sql ="SELECT * FROM com_state WHERE state_status = 1 AND country_id = 99";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();		
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($result)) {
				return $result;
			}else{
				return false;
			}
		}catch(PDOException $e){
			echo "Error : ". $e->getMessage();
		}
	}

	// Get all State List by country Id 
	public function getStateListByCountryID($country_id)
	{
		$data = [];
		try{
			$sql ="SELECT * FROM com_state WHERE state_status = 1 AND country_id = ".$country_id;
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();		
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}else{
				return false;
			}
		}catch(PDOException $e){
			echo "Error : ". $e->getMessage();
		}
	}

	// Get all table data  
	public function getTableAllValue($table_name,$column_name='', $value='')
	{
		$data = [];
		if($column_name != ''){
			$sql = "SELECT * FROM ".$table_name." WHERE ".$column_name." = '".$value."'";
		}else{
			$sql = "SELECT * FROM ".$table_name;
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			$data[] = $row;
		}
		return $data;
	}
	
	// Get table data by ID  
	public function getTableValue($table_name,$column_name,$value)
	{
		$sql = "SELECT * FROM ".$table_name." WHERE ".$column_name." = '".$value."' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		return $row;
	}

	public function deleteData($table_name = '' , $where_array = ''){
		// always initialize a variable before use!
		$conditions = [];
		$parameters = [];
		if(!empty($where_array)){
			// conditional statements
			foreach( $where_array as $key => $value ){

				if (!empty($value))
				{
				    // here we are using not equality
				    $conditions[] = $key;
				    $parameters[] = $value;
				}
			}
			// the main query
			$sql = "DELETE FROM ".$table_name;
			// a smart code to add all conditions, if any
			if (!empty($conditions))
			{
			    $sql .= " WHERE ".implode(" AND ", $conditions)." = ?";
			}
			// the usual prepare/execute/fetch routine
			$stmt = $this->conn->prepare($sql);
			$stmt->execute($parameters);
			return true;
		}else{
			return false;
		}

	}

	public function getData($select = '*', $tbl_name, $where_array, $type = 'PDO::FETCH_ASSOC', $order_by = NULL, $limit = NULL , $offset = NULL, $group_by = NULL){
		// echo "<pre>";print_r($where_array);die;
		// always initialize a variable before use!
		$conditions = [];
		$parameters = [];

		// conditional statements
		if($where_array != NULL){
			foreach( $where_array as $key => $value ){
				if (!empty($value)){
				    // here we are using not equality
				    $conditions[] = $key;
				    $parameters[] = $value;
				}
			}
		}

		// the main query
		$sql = "SELECT ".$select." FROM ".$tbl_name;

		// a smart code to add all conditions, if any
		if ($conditions)
		{
		    $sql .= " WHERE ".implode(" AND ", $conditions);
		}

		if($order_by != NULL){
			$sql .= " ORDER BY ".$order_by;
		}

		if($limit != NULL && $offset != NULL)
			$sql .= " LIMIT ".$limit." OFFSET ".$offset;

		echo $sql;die;
		// the usual prepare/execute/fetch routine
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($parameters);
		if($type == 'PDO::FETCH_OBJ'){
			$row = $stmt->fetch(PDO::FETCH_OBJ);
			return $row;
			exit();
		}else if($type == 'PDO::FETCH_ASSOC'){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$data[] = $row;
			}
			return $data;
		}
		
	}


	function getReportToData($jobTitle){
		$data = [];
		$sql = "SELECT * FROM employees WHERE jobTitle NOT LIKE '%".$jobTitle."%' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_OBJ) ){
			$data[] = $row;
		}
		return $data;
	}	
	/*

	public function getDataV2($select = '*', $tbl_name, $join_array = NULL, $where_array = NULL, $type = 'result', $order_by = NULL, $limit = NULL , $offset = NULL, $group_by = NULL){
		
		$this->db->select($select);
		$this->db->from($tbl_name);

		//Join cond. array('where' => array('id' => 1 , 'status' => 1) , 'where_in' => array('id' => array('1','2','3'))
		if($join_array != NULL){
			foreach ($join_array as $key => $value){
				$this->db->join($key, $value['cond'] , $value['type']);
			}
		}
		//where and where_in cond. array('where' => array('id' => 1 , 'status' => 1) , 'where_in' => array('id' => array('1','2','3'))
		if($where_array != NULL){
			foreach ($where_array as $key => $value) 
			{
				$this->db->{$key}($value);
			}
		}
		//$order_by Exp. 'id DESC'
		if($order_by != NULL)
			$this->db->order_by($order_by);		
		//Exp. $limit = 10 , $offset = 0
		if($limit != NULL && $offset != NULL)
			$this->db->limit($limit,$offset);		
		//Exp. $limit = 10
		if($limit != NULL)
			$this->db->limit($limit);
		$query = $this->db->get();
		return $query->{$type}();
	}

	// Get table data by ID with status=1 
	public function getTableValueWithStatus($table_name, $column_name1, $column_name2, $value1, $value2)
	{
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where($column_name1, $value1);
		$this->db->where($column_name2, $value2);
		$query = $this->db->get();
		return $query->row() ;
	}

	// check table unique value  
	public function checkUniqueValue($table_name,$column_name,$value, $column_name_id, $value_id)
	{
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where($column_name, $value);
		$this->db->where($column_name_id.' !=', $value_id);
		$query = $this->db->get();
		return $query->row() ;
	}

	// Get table data by ID  
	public function getTableMultipleValue($table_name,$column_name,$value)
	{
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where($column_name, $value);
		$query = $this->db->get();
		return $query->result() ;
	}

	 */
}

$db = new database();

?>