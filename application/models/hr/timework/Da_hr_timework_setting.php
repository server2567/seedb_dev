<?php
/*
* Da_hr_timework_setting
* Model for managing hr_timework_setting table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 23/09/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_timework_setting extends Hr_model {

	// PK is twst_id

	public $twst_id;
	public $twst_month;
	public $twst_year;
	public $twst_start_time;
	public $twst_end_time;
	public $twst_start_date;
	public $twst_end_date;
	public $twst_status;
	public $twst_create_user;
	public $twst_create_date;
	public $twst_update_user;
	public $twst_update_date;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	// Insert new record
	function insert() {
		$sql = "INSERT INTO ".$this->hr_db.".hr_timework_setting 
				(twst_month, twst_year, twst_start_time, twst_end_time, twst_start_date, twst_end_date, twst_status, twst_create_user, twst_create_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->hr->query($sql, array(
			$this->twst_month,
			$this->twst_year,
			$this->twst_start_time,
			$this->twst_end_time,
			$this->twst_start_date,
			$this->twst_end_date,
			$this->twst_status,
			$this->twst_create_user,
			$this->twst_create_date
		));
		$this->last_insert_id = $this->hr->insert_id();
	}

	// Update record
	function update() {
		$sql = "UPDATE ".$this->hr_db.".hr_timework_setting
				SET twst_month=?, twst_year=?, twst_start_time=?, twst_end_time=?, twst_start_date=?, twst_end_date=?, twst_status=?, twst_update_user=?, twst_update_date=?
				WHERE twst_id=?";
		$this->hr->query($sql, array(
			$this->twst_month,
			$this->twst_year,
			$this->twst_start_time,
			$this->twst_end_time,
			$this->twst_start_date,
			$this->twst_end_date,
			$this->twst_status,
			$this->twst_update_user,
			$this->twst_update_date,
			$this->twst_id
		));
	}

	// Delete record
	function delete() {
		$sql = "DELETE FROM ".$this->hr_db.".hr_timework_setting
				WHERE twst_id=?";
		$this->hr->query($sql, array($this->twst_id));
	}

	// Get by primary key
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT * 
				FROM ".$this->hr_db.".hr_timework_setting
				WHERE twst_id=?";
		$query = $this->hr->query($sql, array($this->twst_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query;
		}
	}
} //=== end class Da_hr_timework_setting
?>
