<?php

include_once("eqs_model.php");

class Da_eqs_equipments extends eqs_model {		
	
	// PK is eqs_id
	public $eqs_id;
	public $eqs_unit;
	public $eqs_amount;
	public $eqs_name;
	public $eqs_name_en;
	public $eqs_fmst_id;
	public $eqs_fmnd_id;
	public $eqs_fmrd_id;
	public $eqs_code;
	public $eqs_gf;
	public $eqs_bm_id;
	public $eqs_model_id;
	public $eqs_price;
	public $eqs_bg_id;
	public $eqs_mt_id;
	public $eqs_buydate;
	public $eqs_expiredate;
	public $eqs_expireyear;
	public $eqs_dp_id;
	public $eqs_stde_id;
	public $eqs_bd_id;
	public $eqs_rm_id;
	public $eqs_vd_id;
	public $eqs_status;
	public $eqs_distribute_date;
	public $eqs_detail;
	public $eqs_folder;
	public $eqs_active;
	public $eqs_create_user;
	public $eqs_create_date;
	public $eqs_update_user;
	public $eqs_update_date;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO eqs_equipments (eqs_id, eqs_unit, eqs_amount, eqs_name, eqs_name_en, eqs_fmst_id, eqs_fmnd_id, eqs_fmrd_id, eqs_code, eqs_gf, eqs_bm_id, eqs_model_id, eqs_price, eqs_bg_id, eqs_mt_id, eqs_buydate, eqs_expiredate, eqs_expireyear, eqs_dp_id, eqs_stde_id, eqs_bd_id, eqs_rm_id, eqs_vd_id, eqs_status, eqs_distribute_date, eqs_detail, eqs_folder, eqs_active, eqs_create_user, eqs_create_date, eqs_update_user, eqs_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, NOW())";
		 
		$this->eqs->query($sql, array($this->eqs_id, $this->eqs_unit, $this->eqs_amount, $this->eqs_name, $this->eqs_name_en, $this->eqs_fmst_id, $this->eqs_fmnd_id, $this->eqs_fmrd_id, $this->eqs_code, $this->eqs_gf, $this->eqs_bm_id, $this->eqs_model_id, $this->eqs_price, $this->eqs_bg_id, $this->eqs_mt_id, $this->eqs_buydate, $this->eqs_expiredate, $this->eqs_expireyear, $this->eqs_dp_id, $this->eqs_stde_id, $this->eqs_bd_id, $this->eqs_rm_id, $this->eqs_vd_id, $this->eqs_status, $this->eqs_distribute_date, $this->eqs_detail, $this->eqs_folder, $this->eqs_active, $this->eqs_create_user, $this->eqs_update_user));
		$this->last_insert_id = $this->eqs->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE eqs_equipments 
				SET	eqs_unit=?, eqs_amount=?, eqs_name=?, eqs_name_en=?, eqs_fmst_id=?, eqs_fmnd_id=?, eqs_fmrd_id=?, eqs_code=?, eqs_gf=?, eqs_bm_id=?, eqs_model_id=?, eqs_price=?, eqs_bg_id=?, eqs_mt_id=?, eqs_buydate=?, eqs_expiredate=?, eqs_expireyear=?, eqs_dp_id=?, eqs_stde_id=?, eqs_bd_id=?, eqs_rm_id=?, eqs_vd_id=?, eqs_status=?, eqs_distribute_date=?, eqs_detail=?, eqs_folder=?, eqs_active=?, eqs_create_user=?, eqs_create_date=NOW(), eqs_update_user=?, eqs_update_date=NOW()
				WHERE eqs_id=? ";	
		 
		$this->eqs->query($sql, array($this->eqs_unit, $this->eqs_amount, $this->eqs_name, $this->eqs_name_en, $this->eqs_fmst_id, $this->eqs_fmnd_id, $this->eqs_fmrd_id, $this->eqs_code, $this->eqs_gf, $this->eqs_bm_id, $this->eqs_model_id, $this->eqs_price, $this->eqs_bg_id, $this->eqs_mt_id, $this->eqs_buydate, $this->eqs_expiredate, $this->eqs_expireyear, $this->eqs_dp_id, $this->eqs_stde_id, $this->eqs_bd_id, $this->eqs_rm_id, $this->eqs_vd_id, $this->eqs_status, $this->eqs_distribute_date, $this->eqs_detail, $this->eqs_folder, $this->eqs_active, $this->eqs_create_user, $this->eqs_update_user, $this->eqs_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM eqs_equipments
				WHERE eqs_id=?";
		 
		$this->eqs->query($sql, array($this->eqs_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM eqs_equipments 
				WHERE eqs_id=?";
		$query = $this->eqs->query($sql, array($this->eqs_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_eqs_equipments
?>
