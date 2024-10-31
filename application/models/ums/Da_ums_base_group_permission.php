<?php
/*
 * Da_ums_base_group_permission
 * Model for Manage about ums_base_group_permission Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_base_group_permission extends ums_model {		
	
	public $ugp_gp_id;
	public $ugp_bg_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_base_group_permission (ugp_gp_id, ugp_bg_id)
				VALUES(?, ?)";
		 
		$this->ums->query($sql, array($this->ugp_gp_id, $this->ugp_bg_id));
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_base_group_permission 
				SET	ugp_gp_id=?, ugp_bg_id=?
				WHERE ugp_gp_id=? AND ugp_bg_id=? ";	
		 
		$this->ums->query($sql, array($this->ugp_gp_id, $this->ugp_bg_id, $this->ugp_gp_id, $this->ugp_bg_id));		
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_base_group
				WHERE ugp_gp_id=? AND ugp_bg_id=?";
		 
		$this->ums->query($sql, array($this->ugp_gp_id, $this->ugp_bg_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_base_group_permission 
				WHERE ugp_gp_id=? AND ugp_bg_id=?";
		$query = $this->ums->query($sql, array($this->ugp_gp_id, $this->ugp_bg_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ums_base_group_permission
?>
