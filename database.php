<?php
// include_once('config.php');
/**
 * Database connection established
 */
class database
{
	private $conn;
	
	public function __construct()
	{
		$host		= "localhost";
		$username	= "root";
		$password	= "";
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
			return 0;
		}
	}

	/*public function getData($select = '*', $tbl_name, $where_array = NULL, $type = 'result', $order_by = NULL, $limit = NULL , $offset = NULL, $group_by = NULL){
		$this->db->select($select);
		$this->db->from($tbl_name);
		//$where_array Exp. array('id' => 1)
		if($where_array != NULL)
			$this->db->where($where_array);
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
		// echo $this->db->last_query();die;
		return $query->{$type}();
	}

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

	public function deleteData($table_name = '' , $where_array = ''){
		$this->db->delete($table_name,$where_array);		
		return true;
	}

	public function updateData($table_name , $where_array , $post){
		$this->db->where($where_array);
		$this->db->update($table_name, $post);
		return true;
	}

	// Country List 
	public function getAllCountry()
	{
		$this->db->select('*');
		$this->db->from('com_country');
		$this->db->where('country_status', '1');
		$query = $this->db->get();
		return $query->result() ;
	}

	// Get all State List  
	public function getAllState()
	{
		$this->db->select('*');
		$this->db->from('com_state');
		$this->db->where('state_status', '1');
		$this->db->where('country_id', '99');
		$query = $this->db->get();
		return $query->result() ;
	}

	// Get all State List by country Id 
	public function getStateListByCountryID($country_id)
	{
		$this->db->select('*');
		$this->db->from('com_state');
		$this->db->where('state_status', '1');
		$this->db->where('country_id', $country_id);
		$query = $this->db->get();
		return $query->result() ;
	}

	// Get table data by ID  
	public function getTableValue($table_name,$column_name,$value)
	{
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where($column_name, $value);
		$query = $this->db->get();
		return $query->row() ;
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

	// Get all table data  
	public function getTableAllValue($table_name,$column_name)
	{
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where($column_name, '1');
		$query = $this->db->get();
		return $query->result() ;
	} */
}

$db = new database();

?>