<?php
/*
 * Da_ums_user_logs_menu
 * Model for Manage about ums_user_logs_menu Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_user_logs_menu extends ums_model {		
	
	// PK is ml_id
	public $ml_id;
	public $ml_us_id;
	public $ml_st_id;
	public $ml_mn_id;
	public $ml_date;
	public $ml_changed;
	public $ml_ip;
	public $ml_agent;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		$sql = "INSERT INTO ums_user_logs_menu (ml_id, ml_us_id, ml_st_id, ml_mn_id, ml_date, ml_changed, ml_ip, ml_agent)
				VALUES(?, ?, ?, ?, NOW(), ?, ?, ?)";
		 
		$this->ums->query($sql, array($this->ml_id, $this->ml_us_id, $this->ml_st_id, $this->ml_mn_id, $this->ml_changed, $this->ml_ip, $this->ml_agent));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		$sql = "UPDATE ums_user_logs_menu 
				SET	ml_us_id=?, ml_st_id=?, ml_mn_id=?, ml_date=NOW(), ml_changed=?, ml_ip=?, ml_agent=?
				WHERE ml_id=? ";	
		 
		$this->ums->query($sql, array($this->ml_us_id, $this->ml_st_id, $this->ml_mn_id, $this->ml_changed, $this->ml_ip, $this->ml_agent, $this->ml_id));		
	}
	
	function delete() {
		$sql = "DELETE FROM ums_user_logs_menu
				WHERE ml_id=?";
		 
		$this->ums->query($sql, array($this->ml_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_user_logs_menu 
				WHERE ml_id=?";
		$query = $this->ums->query($sql, array($this->ml_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ums_user_logs_menu
?>
