<?php
/*
* Da_hr_timework_person_plan
* Model for managing hr_timework_person_plan table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_timework_person_plan extends Hr_model {

	// PK is twpp_id

	public $twpp_id;
	public $twpp_ps_id;
	public $twpp_start_date;
	public $twpp_end_date;
	public $twpp_start_time;
	public $twpp_end_time;
	public $twpp_sum_hour;
	public $twpp_stde_id;
	public $twpp_rm_id;
	public $twpp_desc;
	public $twpp_create_user;
	public $twpp_create_date;
	public $twpp_update_user;
	public $twpp_update_date;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		$sql = "INSERT INTO ".$this->hr_db.".hr_timework_person_plan (twpp_ps_id, twpp_start_date, twpp_end_date, twpp_start_time, twpp_end_time, twpp_sum_hour, twpp_stde_id, twpp_rm_id, twpp_desc, twpp_create_user, twpp_create_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
		$this->hr->query($sql, array($this->twpp_ps_id, $this->twpp_start_date, $this->twpp_end_date, $this->twpp_start_time, $this->twpp_end_time, $this->twpp_sum_hour, $this->twpp_stde_id, $this->twpp_rm_id, $this->twpp_desc, $this->twpp_create_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		$sql = "UPDATE ".$this->hr_db.".hr_timework_person_plan
				SET twpp_ps_id=?, twpp_start_date=?, twpp_end_date=?, twpp_start_time=?, twpp_end_time=?, twpp_sum_hour=?, twpp_stde_id=?, twpp_rm_id=?, twpp_desc=?, twpp_update_user=?, twpp_update_date=NOW()
				WHERE twpp_id=?";
		$this->hr->query($sql, array($this->twpp_ps_id, $this->twpp_start_date, $this->twpp_end_date, $this->twpp_start_time, $this->twpp_end_time, $this->twpp_sum_hour, $this->twpp_stde_id, $this->twpp_rm_id, $this->twpp_desc, $this->twpp_update_user, $this->twpp_id));
	}

	function delete() {
		$sql = "DELETE FROM ".$this->hr_db.".hr_timework_person_plan
				WHERE twpp_id=?";
		$this->hr->query($sql, array($this->twpp_id));
	}

	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_timework_person_plan
				WHERE twpp_id=?";
		$query = $this->hr->query($sql, array($this->twpp_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_hr_timework_person_plan
?>
