<?php
/*
 * Da_hr_person_detail
 * Model for Manage about hr_structure_detail Table.
 * @Author Dechathon Prajit
 * @Create Date 2567-05-20
 */
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_structure_detail extends Hr_model {
	
	// PK is psd_id
	public $stde_id;
	public $stde_stuc_id;
	public $stde_name_th;
	public $stde_name_en;
	public $stde_desc;
	public $stde_level;
	public $stde_parent;
	public $stde_seq;
	public $stde_is_medical;
	public $stde_create_user;
	public $stde_create_date;
	public $stde_update_user;
	public $stde_update_date;
	public $last_insert_id;
	

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$active = 1;
		$sql = "INSERT INTO ".$this->hr_db.".hr_structure_detail (
			stde_stuc_id, stde_name_th, stde_name_en, 
			stde_desc, stde_level, stde_parent,stde_seq,stde_active,stde_is_medical,stde_create_user, 
			stde_create_date, stde_update_user, stde_update_date
		) VALUES (
			 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?
		)";
		$this->hr->query($sql, array(
			$this->stde_stuc_id,$this->stde_name_th,$this->stde_name_en,
            $this->stde_desc,$this->stde_level,$this->stde_parent,$this->stde_seq,$active,$this->stde_is_medical,$this->stde_create_user,
            $this->stde_create_date,$this->stde_update_user,$this->stde_update_date
		));
		$this->last_insert_id = $this->hr->insert_id();
	}
	
	function update() {
		// if there is no auto_increment field, please remove it
		$sql = "UPDATE ".$this->hr_db.".hr_structure_detail 
		SET  stde_name_th =?, stde_name_en =?, 
			stde_desc = ?,stde_is_medical=?,stde_update_user = ?, stde_update_date = ?
		    where stde_id = ?";
		$this->hr->query($sql, array(
			$this->stde_name_th,$this->stde_name_en,
            $this->stde_desc,$this->stde_is_medical,$this->stde_update_user,$this->stde_update_date,$this->stde_id
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
		$sql = "UPDATE ".$this->hr_db.".hr_structure_detail
		        SET stde_active=?
				WHERE stde_id=?";
				$this->hr->query($sql, array(2,$this->stde_id));
	}
	
}	 
?>