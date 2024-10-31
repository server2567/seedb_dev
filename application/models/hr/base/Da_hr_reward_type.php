<?php
/*
* Da_hr_reward_type
* Model for Manage about hr_base_reward_type Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_reward_type extends Hr_model {

	// PK is pf_id

	public $rwt_id ;
	public $rwt_name;
	public $rwt_name_en;
	public $rwt_active;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_reward_type (rwt_name,rwt_name_en,rwt_active)
				VALUES( ?, ?, ?)";
		$this->hr->query($sql, array($this->rwt_name,$this->rwt_name_en,$this->rwt_active));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_reward_type
				SET	rwt_name=?, rwt_name_en=?,rwt_active=?
				WHERE rwt_id=?";
		$this->hr->query($sql, array($this->rwt_name,$this->rwt_name_en,$this->rwt_active,$this->rwt_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_reward_type
				WHERE rwt_id=?";
		$this->hr->query($sql, array($this->rwt_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_reward_type
		        SET rwt_active=?
				WHERE rwt_id=?";
				$this->hr->query($sql, array($this->rwt_active,$this->rwt_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_reward_type 
        WHERE rwt_active != 2 AND rwt_name = ?" . (!empty($this->rwt_id) ? " AND rwt_id != ?" : "");
		if (!empty($this->rwt_id)) {
			$query = $this->hr->query($sql, array($this->rwt_name, $this->rwt_id));
		} else {
			$query = $this->hr->query($sql, array($this->rwt_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_reward_type
				WHERE rwt_id=?";
		$query = $this->hr->query($sql, array($this->rwt_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
