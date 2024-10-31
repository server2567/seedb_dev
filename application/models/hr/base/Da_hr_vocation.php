<?php
/*
* Da_hr_vocation
* Model for Manage about hr_base_vocation Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_vocation extends Hr_model {

	// PK is pf_id

	public $voc_id ;
	public $voc_name;
	public $voc_done;
	public $voc_active;
	public $voc_create_user;
	public $voc_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_vocation (voc_name, voc_done,voc_active,voc_create_user,voc_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->voc_name,$this->voc_done,$this->voc_active,$this->voc_create_user,$this->voc_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_vocation
				SET	voc_name=?, voc_done=?,voc_active=?, voc_update_user = ?
				WHERE voc_id=?";
		$this->hr->query($sql, array($this->voc_name, $this->voc_done,$this->voc_active,$this->voc_update_user,$this->voc_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_vocation
				WHERE voc_id=?";
		$this->hr->query($sql, array($this->voc_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_vocation
		        SET voc_active=?
				WHERE voc_id=?";
				$this->hr->query($sql, array($this->voc_active,$this->voc_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_vocation 
        WHERE voc_active != 2 AND voc_name = ?" . (!empty($this->voc_id) ? " AND voc_id != ?" : "");
		if (!empty($this->voc_id)) {
			$query = $this->hr->query($sql, array($this->voc_name, $this->voc_id));
		} else {
			$query = $this->hr->query($sql, array($this->voc_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_vocation
				WHERE voc_id=?";
		$query = $this->hr->query($sql, array($this->voc_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
