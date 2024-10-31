<?php
/*
* Da_hr_prefix
* Model for Manage about hr_base_prefix Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__) . "/../hr_model.php");

class Da_hr_prefix extends Hr_model
{

	// PK is pf_id

	public $pf_id;
	public $pf_name;
	public $pf_name_en;
	public $pf_name_abbr;
	public $pf_name_abbr_en;
	public $pf_gd_id;
	public $pf_seq_no;
	public $pf_active;
	public $pf_create_user;
	public $pf_update_user;
	public $last_insert_id;

	function __construct()
	{
		parent::__construct();
	}

	function insert()
	{
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO " . $this->hr_db . ".hr_base_prefix (pf_name, pf_name_en,pf_gd_id,pf_name_abbr,pf_name_abbr_en,pf_active,pf_create_user,pf_update_user)
				VALUES( ?, ?, ?, ?,?,?,?,?)";
		$this->hr->query($sql, array($this->pf_name, $this->pf_name_en ,$this->pf_gd_id,$this->pf_name_abbr,$this->pf_name_abbr_en ,$this->pf_active,$this->pf_create_user,$this->pf_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_prefix
				SET	pf_name=?, pf_name_en=?, pf_gd_id=?,pf_name_abbr=?,pf_name_abbr_en=?,pf_active=?,pf_update_user=?
				WHERE pf_id=?";
		$this->hr->query($sql, array($this->pf_name, $this->pf_name_en, $this->pf_gd_id, $this->pf_name_abbr, $this->pf_name_abbr_en, $this->pf_active, $this->pf_update_user,$this->pf_id));
	}

	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM " . $this->hr_db . ".hr_base_prefix
				WHERE pf_id=?";
		$this->hr->query($sql, array($this->pf_id));
	}
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_base_prefix
		        SET pf_active=?
				WHERE pf_id=?";
		$this->hr->query($sql, array($this->pf_active, $this->pf_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_prefix 
        WHERE pf_active != 2 AND pf_name = ?" . (!empty($this->pf_id) ? " AND pf_id != ?" : "");
		if(!empty($this->pf_id)){
			$query = $this->hr->query($sql, array($this->pf_name,$this->pf_id));
		}else{
			$query = $this->hr->query($sql, array($this->pf_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_base_prefix
				WHERE pf_id=?";
		$query = $this->hr->query($sql, array($this->pf_id));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}
}	 //=== end class Da_hr_prefix
