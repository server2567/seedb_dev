<?php
/*
 * Da_ams_base_alarm
 * Model for Manage about ams_base_notify Table.
 * @Author Dechathon prajit
 * @Create Date 7/06/2024
*/
include_once(dirname(__FILE__)."/../ams_model.php");

class Da_ams_base_alarm extends Ams_model {

	// PK is al_id

	public $al_id;
	public $al_ntf_id;
	public $al_number;
    public $al_day;
	public $al_minute;
	public $al_time;
	public $al_active;
	public $al_create_user;
	public $al_create_date;
	public $al_update_user;
    public $al_update_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->ams_db.".ams_base_alarm (
			al_ntf_id,
			al_number,
			al_day,
            al_minute,
            al_time,
            al_active,
            al_create_user, 
			al_create_date
		) VALUES (
			?, ?, ?, ?, ? , ? , ? , ? 
		)";
		$this->ams->query($sql, array(
			$this->al_ntf_id,
            $this->al_number,
            $this->al_day,
            $this->al_minute,
            $this->al_time,
            $this->al_active,
			$this->al_create_user,
			$this->al_create_date
		));
		
	}
	function update() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->ams_db.".ams_base_alarm 
                SET 
                    al_ntf_id = ?, 
                    al_number = ?,
					al_day = ?,
					al_minute = ?,
					al_time = ?, 
                    al_active = ?,
                    al_update_user = ?, 
                    al_update_date = ?
                WHERE
                    al_id = ?";
		$this->ams->query($sql, array(
			$this->al_ntf_id,
			$this->al_number,
			$this->al_day,
            $this->al_minute,
			$this->al_time,
			$this->al_active,
			$this->al_update_user,
			$this->al_update_date,
			$this->al_id 
		));
		
	}
	
	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->ams_db . ".ams_base_alarm
		        SET al_active=?
				WHERE al_id=?";
		$this->ams->query($sql, array(
            $this->al_active, 
            $this->al_id));
	}
}    
?>
