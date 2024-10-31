<?php
/*
 * Da_ams_base_notify
 * Model for Manage about ams_base_notify Table.
 * @Author Dechathon prajit
 * @Create Date 7/06/2024
*/
include_once(dirname(__FILE__)."/../ams_model.php");

class Da_ams_base_notify extends Ams_model {

	// PK is ntf_id

	public $ntf_id;
	public $ntf_name;
	public $ntf_name_en;
    public $ntf_active;
	public $ntf_create_user;
	public $ntf_create_date;
	public $ntf_update_user;
    public $ntf_update_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->ams_db.".ams_base_notify (
			
            ntf_name,
            ntf_name_en,
            ntf_active,
            ntf_create_user, 
			ntf_create_date
		) VALUES (
			?, ?, ?, ?, ? 
		)";
		$this->ams->query($sql, array(
			
            $this->ntf_name,
            $this->ntf_name_en,
            $this->ntf_active,
            $this->ntf_create_user,
            $this->ntf_create_date
		));
		
	}
	function update() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->ams_db.".ams_base_notify 
                SET 
                    ntf_name = ?, 
                    ntf_name_en = ?, 
                    ntf_active = ?,
                    ntf_update_user = ?, 
                    ntf_update_date = ?
                WHERE
                    ntf_id = ?";
		$this->ams->query($sql, array(
			$this->ntf_name,
			$this->ntf_name_en,
			$this->ntf_active,
            $this->ntf_update_user,
			$this->ntf_update_date,
			$this->ntf_id
		));
		
	}
	
	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->ams_db . ".ams_base_notify
		        SET ntf_active=?
				WHERE ntf_id=?";
		$this->ams->query($sql, array(
            $this->ntf_active, 
            $this->ntf_id));
	}
}    
?>
