<?php
/*
* Da_hr_country
* Model for Manage about hr_base_develop_type Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_develop_type extends Hr_model {

	// PK is pf_id

	public $devb_id ;
	public $devb_name;
	public $devb_name_en;
	public $devb_active;
	public $devb_create_user;
	public $devb_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_develop_type (devb_name, devb_name_en,devb_active,devb_create_user,devb_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->devb_name, $this->devb_name_en,$this->devb_active,$this->devb_create_user,$this->devb_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_develop_type
				SET	devb_name=?, devb_name_en=?, devb_active=? , devb_update_user = ?
				WHERE devb_id=?";
		$this->hr->query($sql, array($this->devb_name, $this->devb_name_en, $this->devb_active,$this->devb_update_user,$this->devb_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_develop_type
				WHERE devb_id=?";
		$this->hr->query($sql, array($this->devb_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_develop_type
		        SET devb_active=?
				WHERE devb_id=?";
				$this->hr->query($sql, array($this->devb_active,$this->devb_id));
	}
	function finding()
	{
		$this->devb_id = decrypt_id($this->devb_id);
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_develop_type 
        WHERE devb_active != 2 AND devb_name = ?" . (!empty($this->devb_id) ? " AND devb_id != ?" : "");
		if (!empty($this->devb_id)) {
			$query = $this->hr->query($sql, array($this->devb_name, $this->devb_id));
		} else {
			$query = $this->hr->query($sql, array($this->devb_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_develop_type
				WHERE devb_id=?";
		$query = $this->hr->query($sql, array($this->devb_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
