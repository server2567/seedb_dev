<?php
/*
 * Da_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
require_once(dirname(__FILE__) . "/../hr/hr_model.php");

class Da_staff_profile extends Hr_model {

	// PK is ps_id


	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	// function insert() {
	// 	// if there is no auto_increment field, please remove it
	// 	$sql = "INSERT INTO ".$this->hr_db.".hr_person (ps_fname, ps_pf_id, ps_lname, ps_fname_en, ps_lname_en, ps_nickname, ps_nickname_en, ps_status, ps_create_user, ps_create_date, ps_update_user ,ps_update_date)
	// 			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	// 	$this->hr->query($sql, array($this->ps_fname, $this->ps_pf_id, $this->ps_lname, $this->ps_fname_en, $this->ps_lname_en, $this->ps_nickname, $this->ps_nickname_en, $this->ps_status, $this->ps_create_user, $this->ps_create_date, $this->ps_update_user, $this->ps_update_date));
	// 	$this->last_insert_id = $this->hr->insert_id();
	// }

}	 //=== end class Da_hr_person
?>
