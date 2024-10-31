<?php
/*
 * Da_hr_person_detail
 * Model for Manage about hr_structure_detail Table.
 * @Author Dechathon Prajit
 * @Create Date 2567-05-20
 */
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_structure extends Hr_model {
	
	// PK is psd_id
	public $stuc_id;
	public $stuc_dp_id;
	public $stuc_status;
	public $stuc_confirm_date;
	public $stuc_create_user;
	public $stuc_create_date;
	public $stuc_update_user;
	public $stuc_update_date;
	public $last_insert_id;
	

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_structure (
			stuc_dp_id, stuc_status, 
			stuc_create_user,stuc_create_date, stuc_update_user, stuc_update_date
		) VALUES (
			?, ?, ?, ?, ?, ?
		)";
		$query = $this->hr->query($sql, array(
			$this->stuc_dp_id,$this->stuc_status,
            $this->stuc_create_user,$this->stuc_create_date,$this->stuc_update_user,$this->stuc_update_date
		));
		$this->last_insert_id = $this->hr->insert_id();
		return $query;
		
	}
	function update() {
		// if there is no auto_increment field, please remove it
		$sql = "UPDATE ".$this->hr_db.".hr_structure_detail (
			stde_id, stde_stuc_id, stde_name_th, stde_name_en, 
			stde_desc, stde_level, stde_seq, stde_create_user, 
			stde_create_date, stde_update_user, stde_update_date
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
		)";
		$this->hr->query($sql, array(
			$this->stde_id,$this->stde_stuc_id,$this->stde_name_en,$this->stde_name_th,
            $this->stde_desc,$this->stde_level,$this->stde_seq,$this->stde_create_user,
            $this->stde_create_date,$this->stde_update_user,$this->stde_update_date
		));
		
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_structure_detail
				WHERE stde_id=?";
		$this->hr->query($sql, array($this->stde_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_structure
		        SET stuc_status=?
				WHERE stuc_id=?";
				$this->hr->query($sql, array($this->stuc_status,$this->stuc_id));
	}
	function deselect_old_struc() {
		$sql = "UPDATE ".$this->hr_db.".hr_structure
		        SET stuc_status=?,
					stuc_end_date = CASE
					WHEN CURDATE() = stuc_confirm_date then CURDATE()
					WHEN CURDATE() > stuc_confirm_date THEN DATE_SUB(CURDATE(), INTERVAL 1 DAY)
					ELSE stuc_end_date
				END
				WHERE stuc_dp_id=? and stuc_status = ?";
				$this->hr->query($sql, array($this->stuc_status,$this->stuc_dp_id,1));
	}
	function select_struc() {
		$current = '9999-12-31';
		$sql = "UPDATE ".$this->hr_db.".hr_structure
		        SET stuc_status=? ,stuc_confirm_date = ?,stuc_end_date = ?
				WHERE stuc_id=?";
				$this->hr->query($sql, array($this->stuc_status,$this->stuc_confirm_date,$current,$this->stuc_id));
	}
	
	
	
}	 
?>