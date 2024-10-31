<?php
/*
* Da_hr_retire
* Model for Manage about hr_base_retire Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__) . "/../hr_model.php");

class Da_hr_retire extends Hr_model
{

	// PK is pf_id

	public $retire_id;
	public $retire_name;
	public $retire_ps_status;
	public $retire_timestamp;
	public $retire_active;
	public $retire_create_user;
	public $retire_update_user;
	public $last_insert_id;

	function __construct()
	{
		parent::__construct();
	}

	function insert()
	{
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO " . $this->hr_db . ".hr_base_retire (retire_name, retire_ps_status,retire_timestamp,retire_active,retire_create_user,retire_update_user)
				VALUES( ?, ?,?, ?,?,?)";
		$this->hr->query($sql, array($this->retire_name, $this->retire_ps_status, $this->retire_timestamp, $this->retire_active,$this->retire_create_user,$this->retire_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_retire
				SET retire_name=?, retire_ps_status=?,retire_timestamp=?, retire_active=?,retire_update_user = ?
				WHERE retire_id=?";
		$this->hr->query($sql, array($this->retire_name, $this->retire_ps_status, $this->retire_timestamp, $this->retire_active, $this->retire_update_user,$this->retire_id));
	}

	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM " . $this->hr_db . ".hr_base_retire
				WHERE retire_id=?";
		$this->hr->query($sql, array($this->retire_id));
	}
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_retire
		        SET retire_active=?
				WHERE retire_id=?";
		$this->hr->query($sql, array($this->retire_active, $this->retire_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_retire 
        WHERE retire_active != 2 AND retire_name = ?" . (!empty($this->retire_id) ? " AND retire_id != ?" : "");
		if (!empty($this->retire_id)) {
			$query = $this->hr->query($sql, array($this->retire_name, $this->retire_id));
		} else {
			$query = $this->hr->query($sql, array($this->retire_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_base_retire
				WHERE retire_id=?";
		$query = $this->hr->query($sql, array($this->retire_id));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}
}	 //=== end class Da_hr_prefix
