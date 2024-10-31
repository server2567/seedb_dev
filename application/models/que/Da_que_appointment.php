<?php
/*
 * Da_que_appointment
 * Model for Manage about que_appointment Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 12/06/2024
*/
include_once(dirname(__FILE__) . "/que_model.php");

class Da_que_appointment extends Que_model
{

	// PK is apm_id

	public $apm_id;
	public $apm_pt_id;
	public $apm_cl_id;
	public $apm_cl_code;
	public $apm_date;
	public $apm_time;
	public $apm_ps_id;
	public $apm_stde_id;
	public $apm_ds_id;
	public $apm_patient_type;
	public $apm_cause;
	public $apm_need;
	public $apm_sta_id;
	public $apm_create_user;
	public $apm_create_date;
	public $apm_update_user;
	public $apm_update_date;

	public $last_insert_id;

	function __construct()
	{
		parent::__construct();
	}

	function insert()
	{
		$sql = "INSERT INTO " . $this->que_db . ".que_appointment (
			apm_pt_id, apm_cl_id, apm_cl_code, 
			apm_date, apm_time, apm_ps_id, apm_stde_id, 
			apm_ds_id, apm_patient_type, apm_cause, apm_need, 
			apm_create_user, apm_create_date, apm_update_user, apm_update_date
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
		)";
		$this->que->query($sql, array(
			$this->apm_pt_id,
			$this->apm_cl_id,
			$this->apm_cl_code,
			$this->apm_date,
			$this->apm_time,
			$this->apm_ps_id,
			$this->apm_stde_id,
			$this->apm_ds_id,
			$this->apm_patient_type,
			$this->apm_cause,
			$this->apm_need,
			$this->apm_create_user,
			$this->apm_create_date,
			$this->apm_update_user,
			$this->apm_update_date
		));
	}


	function update()
	{
		$sql = "UPDATE " . $this->que_db . ".que_appointment 
                SET 
                    apm_pt_id = ?, 
                    apm_cl_id = ?, 
                    apm_cl_code = ?, 
                    apm_date = ?, 
                    apm_time = ?, 
                    apm_ps_id = ?, 
                    apm_stde_id = ?, 
                    apm_ds_id = ?, 
                    apm_patient_type = ?, 
                    apm_cause = ?, 
                    apm_need = ?, 
                    apm_update_user = ?, 
                    apm_update_date = ?
                WHERE
                    apm_id = ?";
		$this->que->query($sql, array(
			$this->apm_pt_id,
			$this->apm_cl_id,
			$this->apm_cl_code,
			$this->apm_date,
			$this->apm_time,
			$this->apm_ps_id,
			$this->apm_stde_id,
			$this->apm_ds_id,
			$this->apm_patient_type,
			$this->apm_cause,
			$this->apm_need,
			$this->apm_update_user,
			$this->apm_update_date,
			$this->apm_id
		));
	}
	function update_sta_by_id()
	{
		$sql = "UPDATE " . $this->que_db . ".que_appointment SET apm_sta_id=? WHERE apm_id=?";
		// pre($sql);
		$this->que->query($sql, array($this->apm_sta_id, $this->apm_id));
	}
	function delete()
	{
		$sql = "DELETE FROM " . $this->que_db . ".que_appointment
				WHERE apm_id = ?";
		$this->que->query($sql, array($this->apm_id));
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT *
				FROM " . $this->que_db . ".que_appointment
				WHERE apm_id=?";
		$query = $this->hr->query($sql, array($this->apm_id));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}
	function update_doctor_by_id()
	{
		$sql = "UPDATE " . $this->que_db . ".que_appointment SET apm_ps_id=? WHERE apm_id=?";
		// pre($sql);
		$this->que->query($sql, array($this->apm_ps_id, $this->apm_id));
	}
}
