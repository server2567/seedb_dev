<?php
/*
 * Da_ams_notification_upload
 * Model for Manage about ams_notification_upload Table.
 * @Author Dechathon prajit
 * @Create Date 20/06/2024
*/
include_once(dirname(__FILE__)."/ams_model.php");

class Da_ams_notification_upload extends Ams_model {

	// PK is ntr_id

	public $ntup_id;
	public $ntup_ntr_id;
	public $ntup_seq;
    public $ntup_name_temp;
	public $ntup_name_file;
	public $ntup_path;
	public $ntup_create_user;
	public $ntup_create_date;
	public $ntup_update_user;
    public $ntup_update_date;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->ams_db.".ams_notification_upload (
			ntup_ntr_id,
			ntup_seq,
			ntup_name_temp,
            ntup_name_file,
            ntup_path,
            ntup_create_user,
            ntup_create_date
		) VALUES (
			?, ?, ?, ?, ? , ? , ? 
		)";
		$this->ams->query($sql, array(
			$this->ntup_ntr_id,
            $this->ntup_seq,
            $this->ntup_name_temp,
            $this->ntup_name_file,
            $this->ntup_path,
            $this->ntup_create_user,
			$this->ntup_create_date
		));
		
	}
	
	function delete($id)
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE 
				FROM 
					see_amsdb.ams_notification_upload 
				WHERE ntup_ntr_id = ?";
		$this->ams->query($sql, array($id));
	}
}    
?>
