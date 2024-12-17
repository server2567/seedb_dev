<?php
/*
* M_hr_timework_attendance_config
* Model for Manage about hr_timework_attendance_config Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 12/09/2024
*/
include_once("Da_hr_timework_attendance_config.php");

class M_hr_timework_attendance_config extends Da_hr_timework_attendance_config
{

    /*
 * get_all_attendance_config_data
 * ดึงข้อมูลรายการรูปแบบการลงเวลาทำงานตาม filter
 * @input -
 * @output รายชื่อข้อมูล
 * @author Tanadon Tangjaimongkhon
 * @Create Date 12/09/2024
 */
    function get_all_attendance_config_data($twac_type, $twac_is_medical, $twac_active)
    {
        $conditions = [];
        $params = [];
        $conditions[] = "twac_active != 2";  // Default condition to exclude inactive records

        // Add condition for twac_type if not 'all'
        if ($twac_type != 'all') {
            $conditions[] = "twac_type = ?";
            $params[] = $twac_type;
        }

        // Add condition for twac_is_medical if not 'all'
        if ($twac_is_medical != 'all') {
            $conditions[] = "twac_is_medical = ?";
            $params[] = $twac_is_medical;
        }

        // Add condition for twac_active if not 'all'
        if ($twac_active != 'all') {
            $conditions[] = "twac_active = ?";
            $params[] = $twac_active;
        }

        // Add filter from session if medical_string exists
        $medical_string = $this->session->userdata('hr_hire_is_medical_string');
        if (!empty($medical_string)) {
            // Remove outer quotes and split the string into an array
            $medical_array = explode(',', str_replace(["'", " "], '', $medical_string)); // Remove quotes and spaces

            // Construct the FIND_IN_SET clause with the cleaned values
            if (!empty($medical_array)) {
                $conditions[] = "(" . implode(" OR ", array_map(function ($value) {
                    return "FIND_IN_SET('$value', twac_is_medical)";
                }, $medical_array)) . ")";
            }
        }

        // Prepare the final WHERE clause
        $where_clause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

        // Final SQL query
        $sql = "SELECT *,
                CASE 
                    WHEN twac_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN twac_is_medical = 'N' THEN 'สายการพยาบาล'
                    WHEN twac_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN twac_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN twac_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE 'ไม่ระบุสายงาน'
                END AS twac_is_medical_text,
                CASE 
                    WHEN twac_type = 1 THEN 'ปฏิบัติงานเต็มเวลา (Full-Time)'
                    WHEN twac_type = 2 THEN 'ปฏิบัติงานบางเวลา (Part-Time)'
                    ELSE 'ไม่ระบุประเภทปฏิบัติงาน'
                END AS twac_type_text
            FROM " . $this->hr_db . ".hr_timework_attendance_config
            $where_clause
            ORDER BY twac_is_medical_text DESC";

        // Execute the query with parameters
        $query = $this->hr->query($sql, $params);
        return $query;
    }
    // get_all_attendance_config_data



    /*
    * get_by_primary_key
    * ดึงข้อมูลรูปแบบการลงเวลาทำงานตาม twac_id
    * @input twac_id
    * @output ข้อมูลที่ตรงกับ twac_id
    * @author Tanadon Tangjaimongkhon
    * @Create Date 12/09/2024
    */
    public function get_by_primary_key($twac_id, $twag_id = null)
    {

        $sql = "SELECT 
    twac.*, 
    CASE 
        WHEN COUNT(CASE WHEN twap.twap_status = 1 THEN 1 END) = 0 THEN NULL
        ELSE JSON_UNQUOTE(
            JSON_ARRAYAGG(
                DISTINCT JSON_OBJECT(
                    'ps_id', pos.pos_ps_id,
                    'check', 'old',
                    'twap_status', twap.twap_status,
                    'pos_ps_code', pos.pos_ps_code,
                    'pos_dp_id',pos.pos_dp_id,
                    'ps_name', CONCAT(pf.pf_name_abbr, ' ', ps.ps_fname, ' ', ps.ps_lname),
                    'hire_name', hire.hire_abbr,
                    'hire_is_medical', hire.hire_is_medical,
                    'adline_position', adline.alp_name,
                    'stde_name_three', (
                        SELECT JSON_ARRAYAGG(
                            DISTINCT JSON_OBJECT(
                                'stde_name_th', stde.stde_name_th, 
                                'stdp_po_id', stdp.stdp_po_id, 
                                'stde_level', stde.stde_level
                            )
                        )
                        FROM see_hrdb.hr_structure_detail AS stde
                        INNER JOIN see_hrdb.hr_structure_person AS stdp 
                            ON stde.stde_id = stdp.stdp_stde_id
                        INNER JOIN see_hrdb.hr_structure AS stuc
                            ON stuc.stuc_id = stde.stde_stuc_id  -- ตรวจสอบว่าชื่อคอลัมน์ถูกต้อง
                        WHERE stdp.stdp_ps_id = pos.pos_ps_id AND stdp.stdp_active = 1 AND stuc.stuc_status = 1
                    )
                )
            )
        )
    END AS twac_person
FROM see_hrdb.hr_timework_attendance_config AS twac
LEFT JOIN see_hrdb.hr_timework_attendance_config_person AS twap 
    ON twac.twac_id = twap.twap_twac_id AND twap.twap_status != 0
LEFT JOIN see_hrdb.hr_structure as stuc on stuc.stuc_id = twap.twap_dp_id
LEFT JOIN see_hrdb.hr_person AS ps 
    ON ps.ps_id = twap.twps_id
LEFT JOIN see_hrdb.hr_person_detail AS psd 
    ON psd.psd_ps_id = ps.ps_id
LEFT JOIN see_hrdb.hr_person_position AS pos 
    ON pos.pos_ps_id = ps.ps_id
LEFT JOIN see_hrdb.hr_base_adline_position AS adline 
    ON pos.pos_alp_id = adline.alp_id
LEFT JOIN see_hrdb.hr_base_prefix AS pf 
    ON pf.pf_id = ps.ps_pf_id
LEFT JOIN see_hrdb.hr_base_hire AS hire 
    ON hire.hire_id = pos.pos_hire_id
        ";
        if ($twac_id != null || $twag_id != null) {
            $sql .= ' Where ';
            if ($twac_id != null) {
                $sql .= ' twac.twac_id = ' . $twac_id;
            }
            if ($twac_id != null && $twag_id != null) {
                $sql .= ' AND twac.twac_twag_id = ' . $twag_id. ' GROUP BY twac.twac_id;';
            } else {
                if ($twag_id != null) {
                    $sql .= ' twac.twac_twag_id =' . $twag_id. ' GROUP BY twac.twac_id;';
                }
            }
            // เรียกใช้ query โดยส่ง twac_id เป็น parameter
            $query = $this->hr->query($sql);
            // pre($this->hr->last_query());
            // คืนค่าผลลัพธ์กลับในกรณีที่พบข้อมูล
            if($twag_id != null){
               return $query->result();
            } else {
                return $query->row();
            }
        }
    }
    /*
	* update_status
	* ปรับสถานะข้อมูลรูปแบบการลงเวลาทำงาน
	* @input -
	* @output ปรับสถานะตาม twac_active
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
    public function update_status()
    {
        $sql = "UPDATE " . $this->hr_db . ".hr_timework_attendance_config
                SET twac_active = ?
                WHERE twac_id = ?";
        $this->hr->query($sql, array($this->twac_active, $this->twac_id));
    }
    // update_status

    /*
	* get_attendance_config_person_data
	* ดึงข้อมูลรายการรูปแบบการลงเวลาทำงานตาม filter รายบุคคล
	* @input ps_id, dp_id
	* @output รายชื่อข้อมูล
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
    function get_attendance_config_person_data($ps_id, $dp_id)
    {

        $sql = "SELECT 
					twac_id,
					twac_name_th,
					twac_name_abbr_th,
					twac_start_time,
					twac_end_time,
                    twac_color,
                    twac_is_ot,
                    IF(twac_is_ot=0,'เวลาทำงานปกติ', 'OT วันทำงาน') AS twac_is_ot_name

				FROM " . $this->hr_db . ".hr_timework_attendance_config_person 
                LEFT JOIN " . $this->hr_db . ".hr_timework_attendance_config
                    ON twap_twac_id = twac_id  
				WHERE 	twps_id = {$ps_id}
                        AND twac_active = 1
                GROUP BY twac_id
                ORDER BY twac_name_th ASC";
        $query = $this->hr->query($sql);
        return $query;
    }
    // get_attendance_config_person_data
    function get_attendance_person($ps_id, $twac_id)
    {
        $sql = "SELECT * FROM " . $this->hr_db . ".hr_timework_attendance_config_person WHERE twps_id = ? AND twap_twac_id = ? AND twap_status != ?";
        $query = $this->hr->query($sql, array($ps_id, $twac_id, 0));
        return $query;
    }
    function get_attendance_report($postData)
    {

        $sql = "SELECT 
        CONCAT(pf.pf_name, ' ', ps.ps_fname, ' ', ps.ps_lname) as ps_name,
        JSON_UNQUOTE(
            JSON_ARRAYAGG(
                DISTINCT CASE 
                    WHEN twac.twac_is_ot = 0 THEN JSON_OBJECT(
                        'twac_id', twac.twac_id, 
                        'twac_twag_id',twac.twac_twag_id,
                        'twag_name',twag.twag_name_th,
                        'twac_name_th', twac.twac_name_th, 
                        'twac_name_abbr_th', twac.twac_name_abbr_th
                    )
                    ELSE NULL
                END
            )
        ) as worktime_normal,
        JSON_UNQUOTE(
            JSON_ARRAYAGG(
                DISTINCT CASE 
                    WHEN twac.twac_is_ot = 1 THEN JSON_OBJECT(
                        'twac_id', twac.twac_id, 
                        'twac_twag_id',twac.twac_twag_id,
                        'twag_name',twag.twag_name_th,
                        'twac_name_th', twac.twac_name_th, 
                        'twac_name_abbr_th', twac.twac_name_abbr_th
                    )
                    ELSE NULL
                END
            )
        ) as worktime_ot
    FROM see_hrdb.hr_timework_attendance_config_person as twap
    INNER JOIN hr_person as ps ON ps.ps_id = twap.twps_id
    INNER JOIN hr_person_position as pos ON pos.pos_ps_id = ps.ps_id
    INNER JOIN hr_base_prefix as pf ON pf.pf_id = ps.ps_pf_id
    INNER JOIN hr_base_hire as hire on hire.hire_id = pos.pos_hire_id
    LEFT JOIN hr_timework_attendance_config as twac ON twac.twac_id = twap.twap_twac_id
    LEFT JOIN hr_timework_attendance_config_group as twag on twag.twag_id = twac.twac_twag_id 
    WHERE twap.twap_status = ? AND pos.pos_dp_id = ?";
        if ($postData['hire_is_medical'] != 'all') {
            $sql .= ' AND hire.hire_is_medical = "' . $postData['hire_is_medical'] . '"';
        }
        if ($postData['hire_type'] != 'all') {
            $sql .= ' AND hire.hire_type = ' . $postData['hire_type'];
        }
        if ($postData['status_id'] != 'all') {
            $sql .= ' AND pos.pos_status = ' . $postData['status_id'];
        }
        $sql .= ' GROUP BY ps.ps_id';

        $query = $this->hr->query($sql, array(1, $postData['dp_id']));
        return $query;
    }
} // end class M_hr_timework_attendance_config
