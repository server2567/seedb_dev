<?php
/*
 * Da_ums_usergroup_history
 * Model for Manage about ums_usergroup_history Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_usergroup_history extends ums_model {		
	
	// PK is ughi_id
	
	public $ughi_id;
	public $ughi_gp_id;
	public $ughi_us_id;
	public $ughi_date;
	public $ughi_changed;
	public $ughi_ip;
	public $ughi_agent;
	public $ughi_create_user;
	
	public $hr_db;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
		$this->hr_db = $this->load->database('hr', TRUE)->database;
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_usergroup_history (ughi_id, ughi_gp_id, ughi_us_id, ughi_date, ughi_changed, ughi_ip, ughi_agent, ughi_create_user)
				VALUES(?, ?, ?, NOW(), ?, ?, ?, ?)";
		$this->ums->query($sql, array($this->ughi_id, $this->ughi_gp_id, $this->ughi_us_id, $this->ughi_changed, $this->ughi_ip, $this->ughi_agent, $this->ughi_create_user));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_usergroup_history 
				SET	ughi_gp_id=?, ughi_us_id=?, ughi_date=NOW(), ughi_changed=?, ughi_ip=?, ughi_agent=?, ughi_create_user=?
				WHERE ughi_id=?";	
		 
		$this->ums->query($sql, array($this->ughi_gp_id, $this->ughi_us_id, $this->ughi_changed, $this->ughi_ip, $this->ughi_agent, $this->ughi_create_user, $this->ughi_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_usergroup_history
				WHERE ughi_id=?";
		 
		$this->ums->query($sql, array($this->ughi_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_usergroup_history 
				WHERE ughi_id=?";
		$query = $this->ums->query($sql, array($this->ughi_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ums_usergroup_history
?>
