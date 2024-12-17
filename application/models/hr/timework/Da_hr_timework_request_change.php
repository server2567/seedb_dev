<?php
/*
* Da_hr_timework_request_change
* Model for managing hr_timework_request_change table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_timework_request_change extends Hr_model {

	// PK is twrc_id

	public $twrc_id;
	public $twrc_twpp_id;
	public $twrc_ps_id;
	public $twrc_dp_id;
	public $twrc_start_date;
	public $twrc_end_date;
	public $twrc_start_time;
	public $twrc_end_time;
	public $twrc_rm_id;
	public $twrc_reason;
	public $twrc_is_holiday;
	public $twrc_status;
	public $twrc_create_user;
	public $twrc_create_date;
	public $twrc_update_user;
	public $twrc_update_date;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		$sql = "INSERT INTO ".$this->hr_db.".hr_timework_request_change (twrc_twpp_id, twrc_ps_id, twrc_start_date, twrc_end_date, twrc_start_time, twrc_end_time, twrc_dp_id, twrc_rm_id, twrc_reason, twrc_is_holiday, twrc_status, twrc_create_user, twrc_create_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
		$this->hr->query($sql, array($this->twrc_twpp_id, $this->twrc_ps_id, $this->twrc_start_date, $this->twrc_end_date, $this->twrc_start_time, $this->twrc_end_time, $this->twrc_dp_id, $this->twrc_rm_id, $this->twrc_reason, $this->twrc_is_holiday, $this->twrc_status, $this->twrc_create_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		$sql = "UPDATE ".$this->hr_db.".hr_timework_request_change
				SET twrc_twpp_id=?, twrc_ps_id=?, twrc_start_date=?, twrc_end_date=?, twrc_start_time=?, twrc_end_time=?, twrc_dp_id=?, twrc_rm_id=?, twrc_reason=?, twrc_is_holiday=?, twrc_status=?, twrc_update_user=?, twrc_update_date=NOW()
				WHERE twrc_id=?";
		$this->hr->query($sql, array($this->twrc_twpp_id, $this->twrc_ps_id, $this->twrc_start_date, $this->twrc_end_date, $this->twrc_start_time, $this->twrc_end_time, $this->twrc_dp_id, $this->twrc_rm_id, $this->twrc_reason, $this->twrc_is_holiday, $this->twrc_status, $this->twrc_update_user, $this->twrc_id));
	}

	function delete() {
		$sql = "DELETE FROM ".$this->hr_db.".hr_timework_request_change
				WHERE twrc_id=?";
		$this->hr->query($sql, array($this->twrc_id));
	}

	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_timework_request_change
				WHERE twrc_id=?";
		$query = $this->hr->query($sql, array($this->twrc_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_hr_timework_request_change
?>
