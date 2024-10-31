<?php
/*
 * Da_que_create_queue
 * Model for Manage about que_create_tracking Table.
 * @Author Dechathon prajit
 * @Create Date 7/06/2024
*/
include_once(dirname(__FILE__)."/que_model.php");

class Da_que_create_queue extends Que_model {

	// PK is cq_id

	public $cq_id;
	public $cq_name;
	public $cq_dpq_id;
	public $cq_keyword;
	public $cq_value;
	public $cq_value_demo;
    public $cq_active;
	public $cq_create_user;
	public $cq_create_date;
	public $cq_update_user;
    public $cq_update_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->que_db.".que_create_queue (
			cq_id, 
            cq_name,
            cq_dpq_id,
            cq_keyword, 
			cq_value,
            cq_value_demo,
            cq_active,
            cq_create_user, 
			cq_create_date,
            cq_update_user,
            cq_update_date
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? 
		)";
		$this->que->query($sql, array(
			$this->cq_id,
            $this->cq_name,
            $this->cq_dpq_id,
            $this->cq_keyword,
            $this->cq_value,
            $this->cq_value_demo,
            $this->cq_active,
            $this->cq_create_user,
            $this->cq_create_date,
            $this->cq_update_user,
            $this->cq_update_date
		));
		
	}
	function update() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->que_db.".que_create_queue 
                SET 
                    cq_name = ?, 
                    cq_dpq_id = ?, 
                    cq_keyword = ?, 
                    cq_active = ?,
                    cq_update_user = ?, 
                    cq_update_date = ?
                WHERE
                    cq_id = ?";
		$this->que->query($sql, array(
			$this->cq_name,
			$this->cq_dpq_id,
			$this->cq_keyword,
			$this->cq_active,
            $this->cq_update_user,
			$this->cq_update_date,
			$this->cq_id
		));
		
	}
	function update_format() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->que_db.".que_create_queue 
                SET 
					cq_value = ?,
					cq_value_demo = ?,
                    cq_update_user = ?, 
                    cq_update_date = ?
                WHERE
                    cq_id = ?";
		$this->que->query($sql, array(
			$this->cq_value,
			$this->cq_value_demo,
            $this->cq_update_user,
			$this->cq_update_date,
			$this->cq_id
		));
		
	}
	
		
	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->que_db . ".que_create_queue
		        SET cq_active=?
				WHERE cq_id=?";
		$this->que->query($sql, array(
            $this->cq_active, 
            $this->cq_id));
	}
}    
?>
