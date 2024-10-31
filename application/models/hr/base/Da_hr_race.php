<?php
/*
* Da_hr_race
* Model for Manage about hr_base_race Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__) . "/../hr_model.php");

class Da_hr_race extends Hr_model
{

	// PK is pf_id

	public $race_id;
	public $race_name;
	public $race_active;
	public $race_create_user;
	public $race_update_user;
	public $last_insert_id;

	function __construct()
	{
		parent::__construct();
	}

	function insert()
	{
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO " . $this->hr_db . ".hr_base_race (race_name,race_active,race_create_user,race_update_user)
				VALUES( ?, ?,?,?)";
		$this->hr->query($sql, array($this->race_name, $this->race_active,$this->race_create_user,$this->race_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_race
				SET	race_name=?, race_active=?,race_update_user = ?
				WHERE race_id=?";
		$this->hr->query($sql, array($this->race_name, $this->race_active, $this->race_update_user,$this->race_id));
	}

	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM " . $this->hr_db . ".hr_base_race
				WHERE race_id=?";
		$this->hr->query($sql, array($this->race_id));
	}
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_race
		        SET race_active=?
				WHERE race_id=?";
		$this->hr->query($sql, array($this->race_active, $this->race_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_race 
        WHERE race_active != 2 AND race_name = ?" . (!empty($this->race_id) ? " AND race_id != ?" : "");
		if (!empty($this->race_id)) {
			$query = $this->hr->query($sql, array($this->race_name, $this->race_id));
		} else {
			$query = $this->hr->query($sql, array($this->race_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_base_race
				WHERE race_id=?";
		$query = $this->hr->query($sql, array($this->race_id));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}
}	 //=== end class Da_hr_prefix
