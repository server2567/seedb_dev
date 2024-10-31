<?php
/*
 * Da_ums_user_config
 * Model for Manage about ums_user_config Table.
 * @Author Areerat Pongurai
 * @Create Date 13/09/2024
 */

include_once("ums_model.php");

class Da_ums_user_config extends ums_model {		
	
	// PK is usc_id
	
	public $usc_id;
	public $usc_us_id;
	public $usc_ps_id;
	public $usc_wts_is_noti;
	public $usc_wts_is_noti_sound;
	public $usc_ams_minute;
	public $usc_create_user;
	public $usc_create_date;
	public $usc_update_user;
	public $usc_update_date;
	
	public $hr_db;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
		
		$this->hr_db = $this->load->database('hr', TRUE)->database;
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_user_config (usc_id, usc_us_id, usc_ps_id, usc_wts_is_noti, usc_wts_is_noti_sound, usc_ams_minute, usc_create_user, usc_create_date) 
				VALUES(?, ?, ?, ?, ?, ?, ?, NOW()) ";
		 
		$this->ums->query($sql, array($this->usc_id, $this->usc_us_id, $this->usc_ps_id, $this->usc_wts_is_noti, $this->usc_wts_is_noti_sound, $this->usc_ams_minute, $this->usc_create_user));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_user_config 
				SET	usc_us_id=?, usc_ps_id=?, usc_wts_is_noti=?, usc_wts_is_noti_sound=?, usc_ams_minute=?, usc_update_user=?, usc_update_date=NOW()
				WHERE usc_id=? ";	
		 
		$this->ums->query($sql, array($this->usc_us_id, $this->usc_ps_id, $this->usc_wts_is_noti, $this->usc_wts_is_noti_sound, $this->usc_ams_minute, $this->usc_update_user, $this->usc_id));		
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_user_config
				WHERE usc_id=?";
		 
		$this->ums->query($sql, array($this->usc_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_user_config 
				WHERE usc_id=?";
		$query = $this->ums->query($sql, array($this->usc_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ums_user_config
?>
