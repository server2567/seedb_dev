<?php
/*
* Da_hr_reward_level
* Model for Manage about hr_base_reward_level Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_reward_level extends Hr_model {

	// PK is pf_id

	public $rwlv_id ;
	public $rwlv_name;
	public $rwlv_name_en;
	public $rwlv_active;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_reward_level (rwlv_name,rwlv_name_en,rwlv_active)
				VALUES( ?, ?, ?)";
		$this->hr->query($sql, array($this->rwlv_name,$this->rwlv_name_en,$this->rwlv_active));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_reward_level
				SET	rwlv_name=?, rwlv_name_en=?,rwlv_active=?
				WHERE rwlv_id=?";
		$this->hr->query($sql, array($this->rwlv_name,$this->rwlv_name_en,$this->rwlv_active,$this->rwlv_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_reward_level
				WHERE rwlv_id=?";
		$this->hr->query($sql, array($this->rwlv_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_reward_level
		        SET rwlv_active=?
				WHERE rwlv_id=?";
				$this->hr->query($sql, array($this->rwlv_active,$this->rwlv_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_reward_level 
        WHERE rwlv_active != 2 AND rwlv_name = ?" . (!empty($this->rwlv_id) ? " AND rwlv_id != ?" : "");
		if (!empty($this->rwlv_id)) {
			$query = $this->hr->query($sql, array($this->rwlv_name, $this->rwlv_id));
		} else {
			$query = $this->hr->query($sql, array($this->rwlv_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_reward_level
				WHERE rwlv_id=?";
		$query = $this->hr->query($sql, array($this->rwlv_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
