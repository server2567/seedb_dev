<?php
/*
 * Da_ums_user
 * Model for Manage about ums_user Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_user extends ums_model {		
	
	// PK is us_id
	
	
	public $us_id;
	public $us_name;
	public $us_username;
	public $us_password;
	public $us_password_confirm;
	public $us_ps_id;
	public $us_psd_id_card_no;
	public $us_bg_id;
	public $us_active;
	public $us_sync;
	public $us_create_user;
	public $us_create_date;
	public $us_update_user;
	public $us_update_date;
	public $us_dp_id;
	public $us_email;
	public $us_detail;
	public $us_his_id = 0;
	
	public $last_insert_id;
	
	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_user (us_id, us_name, us_username, us_password, us_password_confirm, us_ps_id,us_his_id,us_psd_id_card_no, us_bg_id, us_active, us_sync, us_create_user, us_create_date, us_update_user, us_update_date, us_dp_id, us_email, us_detail)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, NOW(), ?, NOW(), ?, ?, ?)";
		 
		$this->ums->query($sql, array($this->us_id, $this->us_name, $this->us_username, $this->us_password, $this->us_password_confirm, $this->us_ps_id, $this->us_his_id,$this->us_psd_id_card_no, $this->us_bg_id, $this->us_active, $this->us_sync, $this->us_create_user, $this->us_update_user, $this->us_dp_id, $this->us_email, $this->us_detail));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_user 
				SET	us_name=?, us_username=?, us_password=?, us_password_confirm=?, us_ps_id=?, us_psd_id_card_no=?, us_bg_id=?, us_active=?, us_sync=?, us_create_user=?, us_create_date=NOW(), us_update_user=?, us_update_date=NOW(), us_dp_id=?, us_email=?, us_detail=?
				WHERE us_id=?";	
		 
		$this->ums->query($sql, array($this->us_name, $this->us_username, $this->us_password, $this->us_password_confirm, $this->us_ps_id, $this->us_psd_id_card_no, $this->us_bg_id, $this->us_active, $this->us_sync, $this->us_create_user, $this->us_update_user, $this->us_dp_id, $this->us_email, $this->us_detail, $this->us_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_user
				WHERE us_id=?";
		 
		$this->ums->query($sql, array($this->us_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_user 
				WHERE us_id=?";
		$query = $this->ums->query($sql, array($this->us_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	function update_his_id() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_user 
				SET	us_his_id=?
				WHERE us_id=?";	
		 
		$this->ums->query($sql, array($this->us_his_id, $this->us_id));
	}
}	 //=== end class Da_umuser
?>
