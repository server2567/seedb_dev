<?php
/*
 * Da_ums_group
 * Model for Manage about ums_group Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_group extends ums_model {		
	
	// PK is gp_id
	
	public $gp_id;
	public $gp_name_th;
	public $gp_name_en;
	public $gp_detail;
	public $gp_st_id;
	public $gp_icon;
	public $gp_url;
	public $gp_is_medical;
	public $gp_active;
	public $gp_create_user;
	public $gp_create_date;
	public $gp_update_user;
	public $gp_update_date;

	public $last_insert_id;
	public $last_insert_gp_name_th;

	function __construct() {
		parent::__construct() ;
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_group (gp_id, gp_name_th, gp_name_en, gp_detail, gp_st_id, gp_icon, gp_url, gp_is_medical, gp_active, gp_create_user, gp_create_date) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
		
		$this->ums->query($sql, array($this->gp_id, $this->gp_name_th, $this->gp_name_en, $this->gp_detail, $this->gp_st_id, $this->gp_icon, $this->gp_url, $this->gp_is_medical, $this->gp_active, $this->gp_create_user));
		$this->last_insert_id = $this->ums->insert_id();
		$this->last_insert_gp_name_th = $this->gp_name_th;
		//echo $this->last_insert_gp_name_th;
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_group 
				SET	gp_name_th=?, gp_name_en=?, gp_detail=?, gp_st_id=?, gp_icon=?, gp_url=?, gp_is_medical=?, gp_active=?, gp_update_user=?, gp_update_date=NOW()
				WHERE gp_id=?";
				
		$this->ums->query($sql, array($this->gp_name_th, $this->gp_name_en, $this->gp_detail, $this->gp_st_id, $this->gp_icon, $this->gp_url, $this->gp_is_medical, $this->gp_active, $this->gp_update_user, $this->gp_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_group
				WHERE gp_id=?";
		 
		$this->ums->query($sql, array($this->gp_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_group 
				WHERE gp_id=?";
		$query = $this->ums->query($sql, array($this->gp_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_ums_group
?>
