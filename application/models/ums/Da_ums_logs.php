<?php
/*
 * Da_ums_logs
 * Model for Manage about ums_logs Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_logs extends ums_model {		
	
	// PK is log_id
	public $log_id;
	public $log_us_id;
	public $log_date;
	public $log_changed;
	public $log_ip;
	public $log_agent;

	public $last_insert_id;

	function __construct() {
		parent::__construct() ;
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_logs (log_id, log_us_id, log_date, log_changed, log_ip, log_agent) 
				VALUES (?, ?, NOW(), ?, ?, ?)";
		
		$this->ums->query($sql, array($this->log_id, $this->log_us_id, $this->log_changed, $this->log_ip, $this->log_agent));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_logs
				WHERE log_id=?";
		 
		$this->ums->query($sql, array($this->log_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_logs 
				WHERE log_id=?";
		$query = $this->ums->query($sql, array($this->log_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	//=== end class Da_ums_logs
?>
