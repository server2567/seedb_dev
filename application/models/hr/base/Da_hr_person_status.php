<?php
/*
* Da_hr_person_status
* Model for Manage about hr_base_person_status Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_person_status extends Hr_model {

	// PK is pf_id

	public $psst_id ;
	public $psst_name;
	public $psst_name_en;
	public $psst_active;
	public $psst_create_user;
	public $psst_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_person_status (psst_name, psst_name_en,psst_active,psst_create_user,psst_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->psst_name, $this->psst_name_en,$this->psst_active,$this->psst_create_user,$this->psst_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_person_status
				SET	psst_name=?, psst_name_en=?, psst_active=?
				WHERE psst_id=?";
		$this->hr->query($sql, array($this->psst_name, $this->psst_name_en, $this->psst_active,$this->psst_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_person_status
				WHERE psst_id=?";
		$this->hr->query($sql, array($this->psst_id));
	}
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_person_status
		        SET psst_active=?
				WHERE psst_id=?";
		$this->hr->query($sql, array($this->psst_active, $this->psst_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_person_status 
        WHERE psst_active != 2 AND psst_name = ?" . (!empty($this->psst_id) ? " AND psst_id != ?" : "");
		if (!empty($this->psst_id)) {
			$query = $this->hr->query($sql, array($this->psst_name, $this->psst_id));
		} else {
			$query = $this->hr->query($sql, array($this->psst_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_person_status
				WHERE psst_id=?";
		$query = $this->hr->query($sql, array($this->psst_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
