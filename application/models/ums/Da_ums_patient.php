<?php
/*
 * Da_ums_patient
 * Model for Manage about ums_patient Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_patient extends ums_model {		
	
	// PK is pt_id
	public $pt_id;
	public $pt_sta_id;
	public $pt_member;
	public $pt_identification;
	public $pt_password;
	public $pt_password_confirm;
	public $pt_prefix;
	public $pt_fname;
	public $pt_lname;
	public $pt_tel;
	public $pt_email;
  public $pt_privacy;
	public $pt_create_date;
	public $last_insert_id;
	
	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_patient (pt_sta_id,pt_member, pt_identification, pt_password, pt_password_confirm, pt_prefix, pt_fname, pt_lname, pt_tel, pt_email, pt_privacy, pt_create_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
		 
		$this->ums->query($sql, array($this->pt_sta_id, $this->pt_member, $this->pt_identification, $this->pt_password, $this->pt_password_confirm, $this->pt_prefix, $this->pt_fname, $this->pt_lname, $this->pt_tel, $this->pt_email, $this->pt_privacy));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_patient 
				SET	pt_sta_id=?, pt_member=?, pt_identification=?, pt_password=?, pt_password_confirm=?, pt_prefix=?, pt_fname=?, pt_lname=?, pt_tel=?, pt_email=?,pt_privacy=? , pt_create_date=NOW()
				WHERE pt_id=?";	
		 
		$this->ums->query($sql, array($this->pt_sta_id, $this->pt_member, $this->pt_identification, $this->pt_password, $this->pt_password_confirm, $this->pt_prefix, $this->pt_fname, $this->pt_lname, $this->pt_tel, $this->pt_email, $this->pt_privacy, $this->pt_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE FROM ums_patient SET pt_sta_id=?
				WHERE sta_id = ?";
		 
		$this->ums->query($sql, array($this->sta_id));
	}
	
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_patient 
				WHERE pt_id=?";
		$query = $this->ums->query($sql, array($this->pt_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_umuser
?>
