<?php
/*
* Da_hr_country
* Model for Manage about hr_base_country Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_country extends Hr_model {

	// PK is pf_id

	public $country_id ;
	public $country_name;
	public $country_name_en;
	public $country_active;
	public $country_create_user;
	public $country_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_country (country_name, country_name_en,country_active,country_create_user,country_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->country_name, $this->country_name_en,$this->country_active,$this->country_create_user,$this->country_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_country
				SET	country_name=?, country_name_en=?, country_active=? , country_update_user = ?
				WHERE country_id=?";
		$this->hr->query($sql, array($this->country_name, $this->country_name_en, $this->country_active,$this->country_update_user,$this->country_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_country
				WHERE country_id=?";
		$this->hr->query($sql, array($this->country_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_country
		        SET country_active=?
				WHERE country_id=?";
				$this->hr->query($sql, array($this->country_active,$this->country_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_country 
        WHERE country_active != 2 AND country_name = ?" . (!empty($this->country_id) ? " AND country_id != ?" : "");
		if (!empty($this->country_id)) {
			$query = $this->hr->query($sql, array($this->country_name, $this->country_id));
		} else {
			$query = $this->hr->query($sql, array($this->country_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_country
				WHERE country_id=?";
		$query = $this->hr->query($sql, array($this->country_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
