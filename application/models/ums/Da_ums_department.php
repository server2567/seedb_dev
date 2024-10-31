<?php
/*
 * Da_ums_department
 * Model for Manage about ums_department Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_department extends ums_model {		
	
	// PK is dp_id

	public $dp_id;
	public $dp_name_th;
	public $dp_name_abbr_th;
	public $dp_name_en;
	public $dp_name_abbr_en;
	public $dp_logo;
	public $dp_address_th;
	public $dp_address_en;
	public $dp_dist_id;
	public $dp_amph_id;
	public $dp_pv_id;
	public $dp_zipcode;
	public $dp_tel;
	public $dp_mail;
	public $dp_facebook;
	public $dp_website;
	public $dp_create_user;
	public $dp_create_date;
	public $dp_update_user;
	public $dp_update_date;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_department (dp_id, dp_name_th, dp_name_abbr_th, dp_name_en, dp_name_abbr_en, dp_logo, dp_address_th, dp_address_en, dp_dist_id, dp_amph_id, dp_pv_id, dp_zipcode, dp_tel, dp_mail, dp_facebook, dp_website, dp_create_user, dp_create_date, dp_update_user, dp_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, NOW())";
		 
		$this->ums->query($sql, array($this->dp_id, $this->dp_name_th, $this->dp_name_abbr_th, $this->dp_name_en, $this->dp_name_abbr_en, $this->dp_logo, $this->dp_address_th, $this->dp_address_en, $this->dp_dist_id, $this->dp_amph_id, $this->dp_pv_id, $this->dp_zipcode, $this->dp_tel, $this->dp_mail, $this->dp_facebook, $this->dp_website, $this->dp_create_user, $this->dp_update_user));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_department 
				SET	dp_name_th=?, dp_name_abbr_th=?, dp_name_en=?, dp_name_abbr_en=?, dp_logo=?, dp_address_th=?, dp_address_en=?, dp_dist_id=?, dp_amph_id=?, dp_pv_id=?, dp_zipcode=?, dp_tel=?, dp_mail=?, dp_facebook=?, dp_website=?, dp_update_user=?, dp_update_date=NOW()
				WHERE dp_id=? ";	
		 
		$this->ums->query($sql, array($this->dp_name_th, $this->dp_name_abbr_th, $this->dp_name_en, $this->dp_name_abbr_en, $this->dp_logo, $this->dp_address_th, $this->dp_address_en, $this->dp_dist_id, $this->dp_amph_id, $this->dp_pv_id, $this->dp_zipcode, $this->dp_tel, $this->dp_mail, $this->dp_facebook, $this->dp_website, $this->dp_update_user, $this->dp_id));		
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_department
				WHERE dp_id=?";
		 
		$this->ums->query($sql, array($this->dp_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_department 
				WHERE dp_id=?";
		$query = $this->ums->query($sql, array($this->dp_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ums_department
?>
