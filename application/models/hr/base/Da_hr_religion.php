<?php
/*
* Da_hr_religion
* Model for Manage about hr_base_religion Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_religion extends Hr_model {

	// PK is pf_id

	public $reli_id ;
	public $reli_name;
	public $reli_name_en;
	public $reli_active;
	public $reli_create_user;
	public $reli_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_religion (reli_name, reli_name_en,reli_active,reli_create_user,reli_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->reli_name, $this->reli_name_en,$this->reli_active,$this->reli_create_user,$this->reli_create_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_religion
				SET	reli_name=?, reli_name_en=?, reli_active=?,reli_update_user=?
				WHERE reli_id=?";
		$this->hr->query($sql, array($this->reli_name, $this->reli_name_en, $this->reli_active,$this->reli_update_user,$this->reli_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_religion
				WHERE reli_id=?";
		$this->hr->query($sql, array($this->reli_id));
	}
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_religion
		        SET reli_active=?
				WHERE reli_id=?";
		$this->hr->query($sql, array($this->reli_active, $this->reli_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_religion 
        WHERE reli_active != 2 AND reli_name = ?" . (!empty($this->reli_id) ? " AND reli_id != ?" : "");
		if (!empty($this->reli_id)) {
			$query = $this->hr->query($sql, array($this->reli_name, $this->reli_id));
		} else {
			$query = $this->hr->query($sql, array($this->reli_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_religion
				WHERE reli_id=?";
		$query = $this->hr->query($sql, array($this->reli_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
