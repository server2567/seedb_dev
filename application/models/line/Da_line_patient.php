<?php
/*
 * Da_line_patient
 * Model for Manage about hr_person Table.
 * @Author Tanadon
 * @Create Date 2567-07-17
 */
include_once('Line_model.php');

class Da_line_patient extends Line_model {

	// PK is lpt_id

	public $lpt_id;
	public $lpt_pt_id;
	public $lpt_user_line_id;
	public $lpt_status;
	public $lpt_create_date;
    public $lpt_create_user;
	public $lpt_update_user;
	public $lpt_update_date;

	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->line_db.".line_patient (lpt_pt_id, lpt_user_line_id, lpt_status, lpt_create_date, lpt_create_user, lpt_update_user, lpt_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?)";
		$this->line->query($sql, array($this->lpt_pt_id, $this->lpt_user_line_id, $this->lpt_status, $this->lpt_create_date, $this->lpt_create_user, $this->lpt_update_user, $this->lpt_update_date));
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->line_db.".line_patient
				SET	lpt_pt_id=?, lpt_user_line_id=?, lpt_status=?, lpt_create_date=?, lpt_create_user=?, lpt_update_user=?, lpt_update_date=?
				WHERE lpt_id=?";
		$this->line->query($sql, array($this->lpt_pt_id, $this->lpt_user_line_id, $this->lpt_status, $this->lpt_create_date, $this->lpt_create_user, $this->lpt_update_user, $this->lpt_update_date, $this->lpt_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->line_db.".line_patient
				WHERE lpt_id=?";
		$this->line->query($sql, array($this->lpt_id));
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->line_db.".line_patient
				WHERE lpt_id=?";
		$query = $this->line->query($sql, array($this->lpt_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_person
?>
