<?php
/*
 * Da_ams_notification_result
 * Model for Manage about ams_appointment Table.
 * @Author Jiradat Pomyai
 * @Create Date 20/06/2024
*/
include_once(dirname(__FILE__) . "/ams_model.php");

class Da_ams_appointment extends Ams_model
{

	// PK is ntr_id
	public $ap_id;
	public $ap_pt_id;
	public $ap_ntr_id;
	public $ap_detail_appointment;
	public $ap_detail_prepare;
	public $ap_report_type;
	public $ap_ast_id;
	public $ap_date;
	public $ap_rp_date;
	public $ap_rp_time;
	public $ap_time;
	public $ap_create_user;
	public $ap_create_date;
	public $ap_update_user;
	public $ap_update_date;

	public $ums_db;
	public $hr_db;
	public $que_db;

	public $last_insert_id;

	function __construct()
	{
		parent::__construct();
		$this->ums_db = $this->load->database('ums', TRUE)->database;
		$this->hr_db = $this->load->database('hr', TRUE)->database;
		$this->que_db = $this->load->database('que', TRUE)->database;
	}

	function insert()
	{
		// Construct the SQL query for UPDATE
		$sql = "INSERT INTO ams_appointment (ap_id, ap_pt_id, ap_ntr_id, ap_detail_appointment, ap_detail_prepare, ap_report_type, ap_ast_id, ap_date, ap_time, ap_rp_date,ap_create_user, ap_create_date) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,NOW())";
		$this->ams->query($sql, array($this->ap_id, $this->ap_pt_id, $this->ap_ntr_id, $this->ap_detail_appointment, $this->ap_detail_prepare, $this->ap_report_type, $this->ap_ast_id, $this->ap_date, $this->ap_time, $this->ap_rp_date, $this->ap_create_user));
		$this->last_insert_id = $this->ams->insert_id();
	}


	function update()
	{
		// Construct the SQL query for UPDATE
		$sql = "UPDATE " . $this->ams_db . ".ams_appointment 
                SET 
                    ap_detail_appointment = ?, 
                    ap_detail_prepare = ?,
					ap_ast_id = ?,
					ap_date = ?,
                	ap_time = ?, 
					ap_rp_date = ?,
					ap_rp_time = ?,
					ap_update_user = ?,
					ap_report_type = ?
                WHERE
                    ap_id = ?";
		$this->ams->query($sql, array(
			$this->ap_detail_appointment,
			$this->ap_detail_prepare,
			$this->ap_ast_id,
			$this->ap_date,
			$this->ap_time,
			$this->ap_rp_date,
			$this->ap_rp_time,
			$this->ap_update_user,
			$this->ap_report_type,
			$this->ap_id
		));
	}
	/*
	* update_ap_ast_id
	* update ams_appointment.ap_ast_id
	* @input 
        ap_ast_id(ams_base_status id): id of status
        ntr(notifications_result id): id of notifications_result
	* @output -
	* @author Areerat Pongurai
	* @Create Date 23/07/2024f
	*/
	function update_ap_ast_id()
	{
		$sql = "UPDATE " . $this->ams_db . ".ams_appointment SET ap_ast_id=? WHERE ap_id=?";
		$query = $this->ams->query($sql, array($this->ap_ast_id, $this->ap_id));
		return $query;
	}

	function update_ap_overdate()
	{
		$status = 6;
		$sql_select = "SELECT * FROM " . $this->ams_db . ".ams_appointment WHERE ap_date < CURDATE() AND ap_ast_id != ?";
		$query_select = $this->ams->query($sql_select, array($status));
		// ถ้ามีข้อมูลตรงตามเงื่อนไข
		if ($query_select->num_rows() > 0) {
			// นำค่า ap_id มาจากผลลัพธ์การ SELECT
			$result = $query_select->result(); // หรือ ->result() ถ้าคุณต้องการหลายแถว
		    foreach ($result as $key => $value) {
				$this->ap_id = $value->ap_id;
				// อัพเดทสถานะ
				$sql_update = "UPDATE " . $this->ams_db . ".ams_appointment SET ap_ast_id = 11 WHERE ap_id = ?";
				$query_update = $this->ams->query($sql_update, array($this->ap_id));	
			}
			return $query_update;
		}
	}
}
