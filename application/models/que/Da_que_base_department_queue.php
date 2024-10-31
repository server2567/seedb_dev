<?php
/*
 * Da_que_base_department_queue
 * Model for Manage about que_base_department_queue Table.
 * @Author Dechathon prajit
 * @Create Date 19/07/2024
*/
include_once(dirname(__FILE__)."/que_model.php");

class Da_que_base_department_queue extends Que_model {

	// PK is dpk_id

	public $dpq_id ;
	public $dpq_stde_id;
	public $dpq_name;
	public $dpq_keyword;
	public $dpq_detail;
	public $dpq_active;
	public $dpq_create_user;
	public $dpq_create_date;
	public $dpq_update_user;
    public $dpq_update_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->que_db.".que_base_department_queue (
			dpq_id, dpq_stde_id, dpq_name, dpq_keyword, 
			dpq_detail, dpq_active, dpq_create_user, 
			dpq_create_date, dpq_update_user, dpq_update_date
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ?
		)";
		$this->que->query($sql, array(
			$this->dpq_id,$this->dpq_stde_id,$this->dpq_name,$this->dpq_keyword,
            $this->dpq_detail,$this->dpq_active,$this->dpq_create_user,$this->dpq_create_date,
            $this->dpq_update_user,$this->dpq_update_date
		));
		
	}
	
	function update() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE " . $this->que_db . ".que_base_department_queue 
				SET 
					dpq_stde_id = ?,
					dpq_name = ?,
					dpq_keyword = ?,
					dpq_detail = ?,
					dpq_active = ?,
					dpq_update_user = ?,
					dpq_update_date = ?
				WHERE
					dpq_id = ?";
	
		// Execute the query with the provided data
		$this->que->query($sql, array(
			$this->dpq_stde_id,
			$this->dpq_name,
			$this->dpq_keyword,
			$this->dpq_detail,
			$this->dpq_active,
			$this->dpq_update_user,
			$this->dpq_update_date,
			$this->dpq_id
		));
	
		// Check for errors or return true for success
		return $this->que->affected_rows() > 0; // This checks if any rows were affected
	}
	
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->que_db . ".que_base_department_queue
		        SET dpq_active=?
				WHERE dpq_id=?";
		$this->que->query($sql, array($this->dpq_active, $this->dpq_id));
	}


	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->que_db.".que_base_department_queue
				WHERE dpq_id=?";
		$this->que->query($sql, array($this->dpq_id));
	}

}	 //=== end class Da_hr_prefix
?>
