<?php
/*
 * Da_ums_group_permission
 * Model for Manage about ums_group_permission Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_group_permission extends ums_model {		
	
	// PK is gpn_id
	
	public $gpn_id;
	public $gpn_gp_id;
	public $gpn_mn_id;
	public $gpn_active;
	
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_group_permission (gpn_id, gpn_gp_id, gpn_mn_id, gpn_active)
				VALUES(?, ?, ?, ?)";
		 
		$this->ums->query($sql, array($this->gpn_id, $this->gpn_gp_id, $this->gpn_mn_id, $this->gpn_active));
		$this->last_insert_id = $this->ums->insert_id();
		
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_group_permission 
				SET	gpn_active=?
				WHERE gpn_gp_id=? and gpn_mn_id=?";	
		 
		$this->ums->query($sql, array($this->gpn_active, $this->gpn_gp_id, $this->gpn_mn_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_group_permission
				WHERE gpn_gp_id=? and gpn_mn_id=? ";
		 
		$this->ums->query($sql, array($this->gpn_gp_id, $this->gpn_mn_id));
	}	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		
		$sql = "SELECT * 
				FROM ums_group_permission 
				WHERE gpn_id=?";//, gpMnID=?";
		$query = $this->ums->query($sql, $this->gpn_id);
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_ums_group_permission

?>
