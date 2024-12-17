<?php
/*
* M_hr_timework_request_change
* Model for Manage about hr_timework_request_change Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 23/08/2024
*/
include_once("Da_hr_timework_request_change.php");

class M_hr_timework_request_change extends Da_hr_timework_request_change {

	 /*
	* get_timework_change_all_by_param
	* ข้อมูลการร้องขอเปลี่ยนตารางการทำงาน
	* @input -
	* @output timework change all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 05/11/2567
	*/
	function get_timework_change_all_by_param($ps_id, $twrc_type, $status, $start_date, $end_date)
    {
        $cond = " WHERE twrc_ps_id = {$ps_id} AND twpp_is_public = 0 "; // กำหนดเงื่อนไขเริ่มต้นให้กรองตาม `ps_id`

        if ($twrc_type != "all") {
            $cond .= " AND twrc_is_holiday = {$twrc_type}"; 
        }
        
        if ($status != "all") {
            $cond .= " AND twrc_status = '{$status}'"; 
        }

        if ($start_date && $end_date) {
            $cond .= " AND twrc_start_date >= '{$start_date}' AND twrc_end_date <= '{$end_date}'";
        } elseif ($start_date) {
            $cond .= " AND twrc_start_date >= '{$start_date}'";
        } elseif ($end_date) {
            $cond .= " AND twrc_end_date <= '{$end_date}'";
        }
        
        $sql = "
            SELECT *
            FROM ".$this->hr_db.".hr_timework_request_change
            LEFT JOIN ".$this->hr_db.".hr_timework_person_plan
                ON twrc_twpp_id = twpp_id
            $cond
            ORDER BY twrc_create_date DESC
        ";

        $query = $this->hr->query($sql);
        return $query; // คืนค่าเป็นผลลัพธ์ของการค้นหา
    }

    // get_timework_change_all_by_param
	
} // end class M_hr_timework_request_change
?>
