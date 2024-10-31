<?php
/*
* Da_hr_timework_person_record
* Model for managing hr_timework_person_record table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 23/09/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_timework_person_record extends Hr_model {

	// PK is twpc_id

	public $twpc_id;
	public $twpc_mc_code;
	public $twpc_ps_code;
	public $twpc_date;
	public $twpc_time;
	public $twpc_create_user;
	public $twpc_create_date;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	// Insert new record
	function insert() {
		$sql = "INSERT INTO ".$this->hr_db.".hr_timework_person_record 
				(twpc_mc_code, twpc_ps_code, twpc_date, twpc_time, twpc_create_user, twpc_create_date)
				VALUES(?, ?, ?, ?, ?, ?)";
		$this->hr->query($sql, array(
			$this->twpc_mc_code,
			$this->twpc_ps_code,
			$this->twpc_date,
			$this->twpc_time,
			$this->twpc_create_user,
			$this->twpc_create_date
		));
		$this->last_insert_id = $this->hr->insert_id();
	}

	// Update record
	function update() {
		$sql = "UPDATE ".$this->hr_db.".hr_timework_person_record
				SET twpc_mc_code=?, twpc_ps_code=?, twpc_date=?, twpc_time=?
				WHERE twpc_id=?";
		$this->hr->query($sql, array(
			$this->twpc_mc_code,
			$this->twpc_ps_code,
			$this->twpc_date,
			$this->twpc_time,
			$this->twpc_id
		));
	}

	// Delete record
	function delete() {
		$sql = "DELETE FROM ".$this->hr_db.".hr_timework_person_record
				WHERE twpc_mc_code=? AND twpc_ps_code=? AND twpc_date=?";
		$this->hr->query($sql, array($this->twpc_mc_code, $this->twpc_ps_code, $this->twpc_date));
	}

	// Get by primary key
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT * 
				FROM ".$this->hr_db.".hr_timework_person_record
				WHERE twpc_mc_code=? AND twpc_ps_code=? AND twpc_date=?";
		$query = $this->hr->query($sql, array($this->twpc_mc_code, $this->twpc_ps_code, $this->twpc_date));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query;
		}
	}
} //=== end class Da_hr_timework_person_record
?>
