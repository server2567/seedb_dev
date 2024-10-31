<?php
/*
* Da_hr_hire
* Model for Manage about hr_base_hire Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_hire extends Hr_model {

	// PK is pf_id

	public $hire_id ;
	public $hire_name;
	public $hire_abbr;
	public $hire_type;
	public $hire_is_medical;
	public $hire_active;
	public $hire_create_user;
	public $hire_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_hire (hire_name, hire_abbr,hire_type,hire_is_medical,hire_active,hire_create_user,hire_update_user)
				VALUES( ?, ?,?, ?,?,?,?)";
		$this->hr->query($sql, array($this->hire_name, $this->hire_abbr,$this->hire_type,$this->hire_is_medical,$this->hire_active,$this->hire_create_user,$this->hire_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_hire
				SET	hire_name=?, hire_abbr=?,hire_type=? ,hire_is_medical=?,hire_active=?,hire_update_user=?
				WHERE hire_id=?";
		$this->hr->query($sql, array($this->hire_name, $this->hire_abbr, $this->hire_type,$this->hire_is_medical ,$this->hire_active,$this->hire_update_user,$this->hire_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_hire
				WHERE hire_id=?";
		$this->hr->query($sql, array($this->hire_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_hire
		        SET hire_active=?
				WHERE hire_id=?";
				$this->hr->query($sql, array($this->hire_active,$this->hire_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_hire 
        WHERE hire_active != 2 AND hire_name = ?" . (!empty($this->hire_id) ? " AND hire_id != ?" : "");
		if (!empty($this->hire_id)) {
			$query = $this->hr->query($sql, array($this->hire_name, $this->hire_id));
		} else {
			$query = $this->hr->query($sql, array($this->hire_name));
		}
		return $query;
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_hire
				WHERE hire_id=?";
		$query = $this->hr->query($sql, array($this->hire_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
