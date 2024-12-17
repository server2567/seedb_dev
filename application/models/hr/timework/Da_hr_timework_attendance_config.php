<?php
/*
* Da_hr_timework_attendance_config
* Model for managing hr_timework_attendance_config table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 12/09/2024
*/
include_once(dirname(__FILE__) . "/../hr_model.php");

class Da_hr_timework_attendance_config extends Hr_model
{

	// PK is twac_id

	public $twac_id;
	public $twac_name_th;
	public $twac_name_abbr_th;
	public $twac_start_time;
	public $twac_end_time;
	public $twac_late_time;
	public $twac_is_ot;
	public $twac_is_break;
	public $twac_is_pre_cal;
	public $twac_twag_id;
	public $twac_is_medical;
	public $twac_type;
	public $twac_active;
	public $twac_color;
	public $twac_create_user;
	public $twac_create_date;
	public $twac_update_user;
	public $twac_update_date;
	public $last_insert_id;

	function __construct()
	{
		parent::__construct();
	}

	// Insert new record
	function insert()
	{
		$sql = "INSERT INTO " . $this->hr_db . ".hr_timework_attendance_config 
				(twac_twag_id, twac_name_th, twac_name_abbr_th, twac_start_time, twac_end_time, twac_late_time, twac_is_ot, twac_is_break, twac_is_pre_cal, twac_is_medical, 
				twac_type, twac_active, twac_color, twac_create_user, twac_create_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->hr->query($sql, array(
			$this->twac_twag_id,
			$this->twac_name_th,
			$this->twac_name_abbr_th,
			$this->twac_start_time,
			$this->twac_end_time,
			$this->twac_late_time,
			$this->twac_is_ot,
			$this->twac_is_break,
			$this->twac_is_pre_cal,
			$this->twac_is_medical,
			$this->twac_type,
			$this->twac_active,
			$this->twac_color,
			$this->twac_create_user,
			$this->twac_create_date
		));
		$this->last_insert_id = $this->hr->insert_id();
	}

	// Update record
	function update()
	{
		$sql = "UPDATE " . $this->hr_db . ".hr_timework_attendance_config
				SET twac_name_th=?, twac_name_abbr_th=?, twac_start_time=?, twac_end_time=?, twac_late_time=?, twac_is_ot = ?,twac_is_break=?, twac_is_pre_cal=?,twac_is_medical=?, twac_type=?, twac_active=?, twac_color=?, twac_update_user=?, twac_update_date=?
				WHERE twac_id=?";
		$this->hr->query($sql, array(
			$this->twac_name_th,
			$this->twac_name_abbr_th,
			$this->twac_start_time,
			$this->twac_end_time,
			$this->twac_late_time,
			$this->twac_is_ot,
			$this->twac_is_break,
			$this->twac_is_pre_cal,
			$this->twac_is_medical,
			$this->twac_type,
			$this->twac_active,
			$this->twac_color,
			$this->twac_update_user,
			$this->twac_update_date,
			$this->twac_id
		));
	}

	// Delete record
	function delete()
	{
		$sql = "DELETE FROM " . $this->hr_db . ".hr_timework_attendance_config
				WHERE twac_id=?";
		$this->hr->query($sql, array($this->twac_id));
	}

	// Get by primary key
	function get_by_key($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT * 
				FROM " . $this->hr_db . ".hr_timework_attendance_config
				WHERE twac_id=?";
		$query = $this->hr->query($sql, array($this->twac_id));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}
	public function insert_develop_person($twac_id, $ps_id, $pos_dp_id,$create_user)
	{
		$sql = "INSERT INTO " . $this->hr_db . ".hr_timework_attendance_config_person (twap_twac_id,twps_id,twap_dp_id,twap_status,twap_create_user)
       VALUES(?, ?,?, ?,?)";
		$this->hr->query($sql, array($twac_id, $ps_id,$pos_dp_id, 1,$create_user));
	}
	public function update_develop_person($twac_id, $ps_id, $status, $user_user)
	{
		$sql = "UPDATE " . $this->hr_db . ".hr_timework_attendance_config_person 
        SET twap_status = ? , twap_update_user = ? 
        WHERE twps_id = ? AND twap_twac_id = ?";
		$this->hr->query($sql, array($status, $user_user, $ps_id, $twac_id));
	}
} //=== end class Da_hr_timework_attendance_config
