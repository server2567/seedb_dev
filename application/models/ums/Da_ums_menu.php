<?php
/*
 * Da_ums_menu
 * Model for Manage about ums_menu Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_menu extends ums_model {		
	
	// PK is mn_id
	
	public $mn_id;
	public $mn_st_id;
	public $mn_seq;
	public $mn_icon;
	public $mn_name_th;
	public $mn_name_en;
	public $mn_url;
	public $mn_detail;
	public $mn_active;
	public $mn_parent_mn_id;
	public $mn_level;
	public $mn_create_user;
	public $mn_create_date;
	public $mn_update_user;
	public $mn_update_date;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_menu (mn_id, mn_st_id, mn_seq, mn_icon, mn_name_th, mn_name_en, mn_url, mn_detail, mn_active, mn_parent_mn_id, mn_level, mn_create_user, mn_create_date, mn_update_user, mn_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, NOW())";
		
		$this->ums->query($sql, array($this->mn_id, $this->mn_st_id, $this->mn_seq, $this->mn_icon, $this->mn_name_th, $this->mn_name_en, $this->mn_url, $this->mn_detail, $this->mn_active, $this->mn_parent_mn_id, $this->mn_level, $this->mn_create_user, $this->mn_update_user));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_menu 
				SET	mn_st_id=?, mn_seq=?, mn_icon=?, mn_name_th=?, mn_name_en=?, mn_url=?, mn_detail=?, mn_active=?, mn_parent_mn_id=?, mn_level=?, mn_update_user=?, mn_update_date=NOW()
				WHERE mn_id=?";	
		
		$this->ums->query($sql, array($this->mn_st_id, $this->mn_seq, $this->mn_icon, $this->mn_name_th, $this->mn_name_en, $this->mn_url, $this->mn_detail, $this->mn_active, $this->mn_parent_mn_id, $this->mn_level, $this->mn_update_user, $this->mn_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_menu
				WHERE mn_id=?";
		
		$this->ums->query($sql, array($this->mn_id));
	}

	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_menu 
				WHERE mn_id=?";
		$query = $this->ums->query($sql, array($this->mn_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ummenu
?>
