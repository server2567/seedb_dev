<?php
/*
 * Da_que_base_type
 * Model for Manage about que_base_type Table.
 * @Author Dechathon prajit
 * @Create Date 31/05/2024
*/
include_once(dirname(__FILE__)."/que_model.php");

class Da_que_base_type extends Que_model {

	// PK is type_id

	public $type_id;
	public $type_name;
	public $type_code;
	public $type_value;
	public $type_func;
	public $type_active;
	public $type_create_user;
	public $type_create_date;
	public $type_update_user;
    public $type_update_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->que_db.".que_base_type (
			type_id, type_name, type_code, type_value, 
			type_func, type_active, type_create_user, 
			type_create_date, type_update_user, type_update_date
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ?
		)";
		$this->que->query($sql, array(
			$this->type_id,$this->type_name,$this->type_code,$this->type_value,
            $this->type_func,$this->type_active,$this->type_create_user,$this->type_create_date,
            $this->type_update_user,$this->type_update_date
		));
		
	}
	function update() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->que_db.".que_base_type 
                SET 
                    type_name = ?, 
                    type_code = ?, 
                    type_value = ?, 
                    type_func = ?, 
                    type_active = ?, 
                    type_update_user = ?, 
                    type_update_date = ?
                WHERE
                    type_id = ?";
		$this->que->query($sql, array(
			$this->type_name,
			$this->type_code,
			$this->type_value,
            $this->type_func,
			$this->type_active,
            $this->type_update_user,
			$this->type_update_date,
			$this->type_id
		));
		
	}
	
		
	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->que_db . ".que_base_type
		        SET type_active=?
				WHERE type_id=?";
		$this->que->query($sql, array($this->type_active, $this->type_id));
	}
}    
?>
