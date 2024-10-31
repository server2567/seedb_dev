<?php
/*
 * Da_que_create_tracking
 * Model for Manage about que_create_tracking Table.
 * @Author Dechathon prajit
 * @Create Date 7/06/2024
*/
include_once(dirname(__FILE__)."/que_model.php");

class Da_que_create_tracking extends Que_model {

	// PK is ct_id

	public $ct_id;
	public $ct_name;
	public $ct_dpk_id;
	public $ct_keyword;
	public $ct_value;
	public $ct_value_demo;
    public $ct_active;
	public $ct_create_user;
	public $ct_create_date;
	public $ct_update_user;
    public $ct_update_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->que_db.".que_create_tracking (
			ct_id, 
            ct_name,
            ct_dpk_id,
            ct_keyword, 
			ct_value,
            ct_value_demo,
            ct_active,
            ct_create_user, 
			ct_create_date,
            ct_update_user,
            ct_update_date
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? 
		)";
		$this->que->query($sql, array(
			$this->ct_id,
            $this->ct_name,
            $this->ct_dpk_id,
            $this->ct_keyword,
            $this->ct_value,
            $this->ct_value_demo,
            $this->ct_active,
            $this->ct_create_user,
            $this->ct_create_date,
            $this->ct_update_user,
            $this->ct_update_date
		));
		
	}
	function update() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->que_db.".que_create_tracking 
                SET 
                    ct_name = ?, 
                    ct_dpk_id = ?, 
                    ct_keyword = ?, 
                    ct_active = ?,
                    ct_update_user = ?, 
                    ct_update_date = ?
                WHERE
                    ct_id = ?";
		$this->que->query($sql, array(
			$this->ct_name,
			$this->ct_dpk_id,
			$this->ct_keyword,
			$this->ct_active,
            $this->ct_update_user,
			$this->ct_update_date,
			$this->ct_id
		));
		
	}
	function update_format() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->que_db.".que_create_tracking 
                SET 
					ct_value = ?,
					ct_value_demo = ?,
                    ct_update_user = ?, 
                    ct_update_date = ?
                WHERE
                    ct_id = ?";
		$this->que->query($sql, array(
			$this->ct_value,
			$this->ct_value_demo,
            $this->ct_update_user,
			$this->ct_update_date,
			$this->ct_id
		));
		
	}
	
		
	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->que_db . ".que_create_tracking
		        SET ct_active=?
				WHERE ct_id=?";
		$this->que->query($sql, array(
            $this->ct_active, 
            $this->ct_id));
	}
}    
?>
