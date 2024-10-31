<?php
/*
* Da_hr_timework_person_compile
* Model for managing hr_timework_person_compile table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 23/09/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_timework_person_compile extends Hr_model {

	// PK is twcp_id

	public $twcp_id;
	public $twcp_ps_id;
	public $twcp_ws_id;
	public $twcp_hipos_id;
	public $twcp_date;
	public $twcp_time;
	public $twcp_num_hour;
	public $twcp_num_minute;
	public $twcp_seq;
	public $twcp_desc;
	public $twcp_create_user;
	public $twcp_create_date;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	// Insert new record
	function insert() {
		$sql = "INSERT INTO ".$this->hr_db.".hr_timework_person_compile 
				(twcp_ps_id, twcp_ws_id, twcp_hipos_id, twcp_date, twcp_time, twcp_num_hour, twcp_num_minute, twcp_seq, twcp_desc, twcp_create_user, twcp_create_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->hr->query($sql, array(
			$this->twcp_ps_id,
			$this->twcp_ws_id,
			$this->twcp_hipos_id,
			$this->twcp_date,
			$this->twcp_time,
			$this->twcp_num_hour,
			$this->twcp_num_minute,
			$this->twcp_seq,
			$this->twcp_desc,
			$this->twcp_create_user,
			$this->twcp_create_date
		));
		$this->last_insert_id = $this->hr->insert_id();
	}

	// Update record
	function update() {
		$sql = "UPDATE ".$this->hr_db.".hr_timework_person_compile
				SET twcp_ps_id=?, twcp_ws_id=?, twcp_hipos_id=?, twcp_date=?, twcp_time=?, twcp_num_hour=?, twcp_num_minute=?, twcp_seq=?, twcp_desc=?
				WHERE twcp_id=?";
		$this->hr->query($sql, array(
			$this->twcp_ps_id,
			$this->twcp_ws_id,
			$this->twcp_hipos_id,
			$this->twcp_date,
			$this->twcp_time,
			$this->twcp_num_hour,
			$this->twcp_num_minute,
			$this->twcp_seq,
			$this->twcp_desc,
			$this->twcp_id
		));
	}

	// Delete record
	function delete() {
		$sql = "DELETE FROM ".$this->hr_db.".hr_timework_person_compile
				WHERE twcp_id=?";
		$this->hr->query($sql, array($this->twcp_id));
	}

	// Get by primary key
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT * 
				FROM ".$this->hr_db.".hr_timework_person_compile
				WHERE twcp_id=?";
		$query = $this->hr->query($sql, array($this->twcp_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query;
		}
	}
} //=== end class Da_hr_timework_person_compile
?>
