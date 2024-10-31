<?php
/*
* Da_hr_manage_calendar
* Model for Manage about hr_base_manage_calendar Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_calendar extends Hr_model {

	// PK is pf_id

	public $clnd_id ;
	public $clnd_name;
	public $clnd_type_date;
	public $clnd_year;
	public $clnd_start_date;
	public $clnd_end_date;
	public $clnd_diff_date;
	public $clnd_active;
	public $clnd_create_user;
	public $clnd_create_date;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_calendar (clnd_name,clnd_type_date,clnd_year,clnd_start_date,clnd_end_date,clnd_diff_date,clnd_active,clnd_create_date,clnd_create_user)
				VALUES( ?, ?, ?,?,?,?,?,?,?)";
		$this->hr->query($sql, array($this->clnd_name,$this->clnd_type_date,$this->clnd_year,$this->clnd_start_date,$this->clnd_end_date,$this->clnd_diff_date,$this->clnd_active,$this->clnd_create_date,$this->clnd_create_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_calendar
				SET	clnd_name=?, clnd_type_date = ?,clnd_year=?,clnd_start_date=?,clnd_end_date=?,clnd_diff_date=?,clnd_active=?
				WHERE clnd_id=?";
		$this->hr->query($sql, array($this->clnd_name,$this->clnd_type_date,$this->clnd_year,$this->clnd_start_date,$this->clnd_end_date,$this->clnd_diff_date,$this->clnd_active,$this->clnd_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_calendar
				WHERE clnd_id=?";
		$this->hr->query($sql, array($this->clnd_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_calendar
		        SET clnd_active=?
				WHERE clnd_id=?";
				$this->hr->query($sql, array($this->clnd_active,$this->clnd_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_calendar 
        WHERE clnd_active != 2 AND clnd_name = ?" . (!empty($this->clnd_id) ? " AND clnd_id != ?" : "");
		if (!empty($this->clnd_id)) {
			$query = $this->hr->query($sql, array($this->clnd_name, $this->clnd_id));
		} else {
			$query = $this->hr->query($sql, array($this->clnd_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_calendar
				WHERE clnd_id=?";
		$query = $this->hr->query($sql, array($this->clnd_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
