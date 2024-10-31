<?php
/*
 * Da_que_department
 * Model for Manage about que_base_department_keyword Table.
 * @Author Dechathon prajit
 * @Create Date 17/05/2024
*/
include_once(dirname(__FILE__)."/que_model.php");

class Da_que_department extends Que_model {

	// PK is dpk_id

	public $dpk_id ;
	public $dpk_stde_id;
	public $dpk_name;
	public $dpk_keyword;
	public $dpk_detail;
	public $dpk_active;
	public $dpk_create_user;
	public $dpk_create_date;
	public $dpk_update_user;
    public $dpk_update_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->que_db.".que_base_department_keyword (
			dpk_id, dpk_stde_id, dpk_name, dpk_keyword, 
			dpk_detail, dpk_active, dpk_create_user, 
			dpk_create_date, dpk_update_user, dpk_update_date
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ?
		)";
		$this->que->query($sql, array(
			$this->dpk_id,$this->dpk_stde_id,$this->dpk_name,$this->dpk_keyword,
            $this->dpk_detail,$this->dpk_active,$this->dpk_create_user,$this->dpk_create_date,
            $this->dpk_update_user,$this->dpk_update_date
		));
		
	}
	
	function update() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE " . $this->que_db . ".que_base_department_keyword 
				SET 
					dpk_stde_id = ?,
					dpk_name = ?,
					dpk_keyword = ?,
					dpk_detail = ?,
					dpk_active = ?,
					dpk_update_user = ?,
					dpk_update_date = ?
				WHERE
					dpk_id = ?";
	
		// Execute the query with the provided data
		$this->que->query($sql, array(
			$this->dpk_stde_id,
			$this->dpk_name,
			$this->dpk_keyword,
			$this->dpk_detail,
			$this->dpk_active,
			$this->dpk_update_user,
			$this->dpk_update_date,
			$this->dpk_id
		));
	
		// Check for errors or return true for success
		return $this->que->affected_rows() > 0; // This checks if any rows were affected
	}
	
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->que_db . ".que_base_department_keyword
		        SET dpk_active=?
				WHERE dpk_id=?";
		$this->que->query($sql, array($this->dpk_active, $this->dpk_id));
	}


	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->que_db.".que_base_department_keyword
				WHERE dpk_id=?";
		$this->que->query($sql, array($this->dpk_id));
	}

}	 //=== end class Da_hr_prefix
?>
