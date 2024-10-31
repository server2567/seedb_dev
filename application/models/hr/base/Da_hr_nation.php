<?php
/*
* Da_hr_nation
* Model for Manage about hr_base_nation Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_nation extends Hr_model {

	// PK is pf_id

	public $nation_id ;
	public $nation_name;
	public $nation_name_en;
	public $nation_active;
	public $nation_create_user;
	public $nation_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_nation (nation_name, nation_name_en,nation_active,nation_create_user,nation_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->nation_name, $this->nation_name_en,$this->nation_active,$this->nation_create_user,$this->nation_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_nation
				SET	nation_name=?, nation_name_en=?, nation_active=?,nation_update_user =?
				WHERE nation_id=?";
		$this->hr->query($sql, array($this->nation_name, $this->nation_name_en, $this->nation_active,$this->nation_update_user,$this->nation_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_nation
				WHERE nation_id=?";
		$this->hr->query($sql, array($this->nation_id));
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_nation
				WHERE nation_id=?";
		$query = $this->hr->query($sql, array($this->nation_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_nation
		        SET nation_active=?
				WHERE nation_id=?";
		$this->hr->query($sql, array($this->nation_active, $this->nation_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_nation
        WHERE nation_active != 2 AND nation_name = ?" . (!empty($this->nation_id) ? " AND nation_id != ?" : "");
		if(!empty($this->nation_id)){
			$query = $this->hr->query($sql, array($this->nation_name,$this->nation_id));
		}else{
			$query = $this->hr->query($sql, array($this->nation_name));
		}
		return $query;
	}

}	 //=== end class Da_hr_prefix
?>
