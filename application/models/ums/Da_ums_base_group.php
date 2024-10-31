<?php
/*
 * Da_ums_base_group
 * Model for Manage about ums_base_group Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_base_group extends ums_model {		
	
	// PK is bg_id
	
	public $bg_id;
	public $bg_name_th;
	public $bg_name_en;
	public $bg_active;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_base_group (bg_id, bg_name_th, bg_name_en, bg_active)
				VALUES(?, ?, ?, ?)";
		 
		$this->ums->query($sql, array($this->bg_id, $this->bg_name_th, $this->bg_name_en, $this->bg_active));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_base_group 
				SET	bg_name_th=?, bg_name_en=?, bg_active=?
				WHERE bg_id=? ";	
		 
		$this->ums->query($sql, array($this->bg_name_th, $this->bg_name_en, $this->bg_active, $this->bg_id));		
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_base_group
				WHERE bg_id=?";
		 
		$this->ums->query($sql, array($this->bg_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_base_group 
				WHERE bg_id=?";
		$query = $this->ums->query($sql, array($this->bg_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ums_base_group
?>
