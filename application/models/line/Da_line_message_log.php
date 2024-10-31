<?php
/*
 * Da_line_message_log
 * Model for Manage about hr_person Table.
 * @Author Tanadon
 * @Create Date 2564-06-14
 */
include_once('Line_model.php');

class Da_line_message_log extends Line_model {

	// PK is msl_id
	public $msl_id;
	public $msl_lpt_id;
	public $msl_detail;
	public $msl_status;
	public $msl_msst_id;
    public $msl_date;

	public $mst_id;
	public $mst_name_th;
	public $mst_name_en;
	public $mst_active;

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->line_db.".line_message_log (msl_lpt_id, msl_detail, msl_status, msl_msst_id)
				VALUES(?, ?, ?, ?)";
		$this->line->query($sql, array($this->msl_lpt_id, $this->msl_detail, $this->msl_status, $this->msl_msst_id));
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->line_db.".line_message_log
				SET	msl_lpt_id=?, msl_detail=?, msl_status=?, msl_msst_id=?
				WHERE msl_id=?";
		$this->line->query($sql, array($this->msl_lpt_id, $this->msl_detail, $this->msl_status, $this->msl_msst_id, $this->msl_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->line_db.".line_message_log
				WHERE msl_id=?";
		$this->line->query($sql, array($this->msl_id));
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->line_db.".line_message_log
				WHERE msl_id=?";
		$query = $this->line->query($sql, array($this->msl_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function row2attribute($rw) {
		foreach ($rw as $key => $value) {
			if ( is_null($value) ) 
				eval("\$this->$key = NULL;");
			else
				$value = str_replace("'","&apos;",$value);
				eval("\$this->$key = '$value';");
		}
	}

}	 //=== end class Da_hr_person
?>
