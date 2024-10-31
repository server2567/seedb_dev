<?php
/*
* Da_hr_nation
* Model for Manage about hr_base_nation Table.
* @Author Jiradat Pomyai
* @Create Date 28/10/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_leave_approve extends Hr_model {

	// PK is pf_id

	public $last_id ;
	public $last_name;
	public $last_mean;
	public $last_yes;
	public $last_no;
	public $last_desc;
	public $last_active;
	public $last_create_user;
	public $last_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_leave_approve_status (last_name, last_mean,last_yes,last_no,last_desc,last_active,last_create_user)
				VALUES( ?, ?, ?,?,?,?,?)";
		$this->hr->query($sql, array($this->last_name, $this->last_mean,$this->last_yes,$this->last_no,$this->last_desc,1,$this->last_create_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_leave_approve_status
				SET	last_name = ?,last_mean = ?,last_yes= ?,last_no = ?,last_desc = ?,last_active = ?,last_update_user = ?
				WHERE last_id =?";
		$this->hr->query($sql, array($this->last_name, $this->last_mean, $this->last_yes,$this->last_no,$this->last_desc,$this->last_active,$this->last_update_user,$this->last_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_nation
				WHERE nation_id=?";
		$this->hr->query($sql, array($this->nation_id));
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_nation
				WHERE nation_id=?";
		$query = $this->hr->query($sql, array($this->nation_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_leave_approve_status
		        SET last_active=?
				WHERE last_id=?";
		$this->hr->query($sql, array($this->last_active, $this->last_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_leave_approve_status
        WHERE last_active != 2 AND last_name = ?" . (!empty($this->last_id) ? " AND last_id != ?" : "");
		if(!empty($this->last_id)){
			$query = $this->hr->query($sql, array($this->last_name,$this->last_id));
		}else{
			$query = $this->hr->query($sql, array($this->last_name));
		}
		return $query;
	}

}	 //=== end class Da_hr_prefix
?>
