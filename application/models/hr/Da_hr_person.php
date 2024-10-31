<?php
/*
 * Da_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("hr_model.php");

class Da_hr_person extends Hr_model {

	// PK is ps_id

	public $ps_id;
	public $ps_pf_id;
	public $ps_fname;
	public $ps_lname;
	public $ps_fname_en;
	public $ps_lname_en;
	public $ps_nickname;
	public $ps_nickname_en;
	public $ps_status;
	public $ps_create_user;
	public $ps_create_date;
	public $ps_update_user;
	public $ps_update_date;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_person (ps_fname, ps_pf_id, ps_lname, ps_fname_en, ps_lname_en, ps_nickname, ps_nickname_en, ps_status, ps_create_user, ps_create_date, ps_update_user ,ps_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->hr->query($sql, array($this->ps_fname, $this->ps_pf_id, $this->ps_lname, $this->ps_fname_en, $this->ps_lname_en, $this->ps_nickname, $this->ps_nickname_en, $this->ps_status, $this->ps_create_user, $this->ps_create_date, $this->ps_update_user, $this->ps_update_date));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_person
				SET	ps_pf_id=?, ps_fname=?, ps_lname=?, ps_fname_en=?, ps_lname_en=?, ps_nickname=?, ps_nickname_en=?, ps_status=?, ps_update_user=? , ps_update_date=?
				WHERE ps_id=?";
		$this->hr->query($sql, array($this->ps_pf_id, $this->ps_fname, $this->ps_lname, $this->ps_fname_en, $this->ps_lname_en, $this->ps_nickname, $this->ps_nickname_en, $this->ps_status, $this->ps_update_user, $this->ps_update_date, $this->ps_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_person
				WHERE ps_id=?";
		$this->hr->query($sql, array($this->ps_id));
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_person
				WHERE ps_id=?";
		$query = $this->hr->query($sql, array($this->ps_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_person
?>
