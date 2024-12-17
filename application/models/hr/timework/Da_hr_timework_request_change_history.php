<?php
/*
* Da_hr_timework_request_change_history
* Model for managing hr_timework_request_change_history table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_timework_request_change_history extends Hr_model {

	// PK is twrch_id

	public $twrch_id;
	public $twrch_twrc_id;
	public $twrch_seq;
	public $twrch_action;
	public $twrch_old_status;
	public $twrch_new_status;
	public $twrch_create_user;
	public $twrch_create_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// คำนวณ `twrch_seq` โดยเพิ่มค่าเป็นลำดับถัดไปตาม `twrch_twrc_id`
		$this->twrch_seq = $this->get_next_sequence($this->twrch_twrc_id);
		
		$sql = "INSERT INTO ".$this->hr_db.".hr_timework_request_change_history (twrch_twrc_id, twrch_seq, twrch_action, twrch_old_status, twrch_new_status, twrch_create_user, twrch_create_date)
				VALUES(?, ?, ?, ?, ?, ?, NOW())";
		$this->hr->query($sql, array($this->twrch_twrc_id, $this->twrch_seq, $this->twrch_action, $this->twrch_old_status, $this->twrch_new_status, $this->twrch_create_user));
	}

	function update() {
		$sql = "UPDATE ".$this->hr_db.".hr_timework_request_change_history
				SET twrch_action=?, twrch_old_status=?, twrch_new_status=?, twrch_create_user=?, twrch_create_date=NOW()
				WHERE twrch_id=?";
		$this->hr->query($sql, array($this->twrch_action, $this->twrch_old_status, $this->twrch_new_status, $this->twrch_create_user, $this->twrch_id));
	}

	function delete() {
		$sql = "DELETE FROM ".$this->hr_db.".hr_timework_request_change_history
				WHERE twrch_id=?";
		$this->hr->query($sql, array($this->twrch_id));
	}

	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_timework_request_change_history
				WHERE twrch_id=?";
		$query = $this->hr->query($sql, array($this->twrch_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query;
		}
	}

	function get_history_by_request_id($twrc_id) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_timework_request_change_history
				WHERE twrch_twrc_id=?
				ORDER BY twrch_create_date DESC";
		$query = $this->hr->query($sql, array($twrc_id));
		return $query->result();
	}

	private function get_next_sequence($twrc_id) {
		$sql = "SELECT IFNULL(MAX(twrch_seq), 0) + 1 AS next_seq
				FROM ".$this->hr_db.".hr_timework_request_change_history
				WHERE twrch_twrc_id=?";
		$query = $this->hr->query($sql, array($twrc_id));
		$row = $query->row();
		return $row->next_seq;
	}

}	 //=== end class Da_hr_timework_request_change_history
?>
