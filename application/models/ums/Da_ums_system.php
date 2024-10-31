<?php
/*
 * Da_ums_system
 * Model for Manage about ums_system Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_system extends ums_model {		
	
	// PK is st_id
	
	public $st_id;
	public $st_name_th;
	public $st_name_en;
	public $st_name_abbr_th;
	public $st_name_abbr_en;
	public $st_detail;
	public $st_url;
	public $st_icon;
	public $st_active;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_system (st_id, st_name_th, st_name_en, st_name_abbr_th, st_name_abbr_en, st_detail, st_url, st_icon, st_active)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		 
		$this->ums->query($sql, array($this->st_id, $this->st_name_th, $this->st_name_en, $this->st_name_abbr_th, $this->st_name_abbr_en, $this->st_detail, $this->st_url, $this->st_icon, $this->st_active));
		$this->last_insert_id = $this->ums->insert_id();
		
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_system 
				SET	st_name_th=?, st_name_en=?, st_name_abbr_th=?, st_name_abbr_en=?, st_detail=?, st_url=?, st_icon=?, st_active=?
				WHERE st_id=?";	
		 
		$this->ums->query($sql, array($this->st_name_th, $this->st_name_en, $this->st_name_abbr_th, $this->st_name_abbr_en, $this->st_detail, $this->st_url, $this->st_icon, $this->st_active, $this->st_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_system
				WHERE st_id=?";
		 
		$this->ums->query($sql, array($this->st_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_system 
				WHERE st_id=?";
		$query = $this->ums->query($sql, array($this->st_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_umsystem
?>
