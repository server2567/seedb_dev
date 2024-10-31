<?php
/*
* M_hr_timework_attendance_config
* Model for Manage about hr_timework_attendance_config Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 12/09/2024
*/
include_once("Da_hr_timework_attendance_config.php");

class M_hr_timework_attendance_config extends Da_hr_timework_attendance_config {

/*
 * get_all_attendance_config_data
 * ดึงข้อมูลรายการรูปแบบการลงเวลาทำงานตาม filter
 * @input -
 * @output รายชื่อข้อมูล
 * @author Tanadon Tangjaimongkhon
 * @Create Date 12/09/2024
 */
function get_all_attendance_config_data($twac_type, $twac_is_medical, $twac_active) {
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
            $conditions[] = "(" . implode(" OR ", array_map(function($value) {
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
                    WHEN twac_is_medical = 'N' THEN 'สายพยาบาล'
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
            FROM ".$this->hr_db.".hr_timework_attendance_config
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
    public function get_by_primary_key($twac_id) {

        $sql = "SELECT * 
                FROM ".$this->hr_db.".hr_timework_attendance_config 
                WHERE twac_id = ?";
        
        // เรียกใช้ query โดยส่ง twac_id เป็น parameter
        $query = $this->hr->query($sql, array($twac_id));

        // คืนค่าผลลัพธ์กลับในกรณีที่พบข้อมูล
        if ($query->num_rows() > 0) {
            return $query->row();
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
    public function update_status() {
        $sql = "UPDATE ".$this->hr_db.".hr_timework_attendance_config
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
	function get_attendance_config_person_data($ps_id, $dp_id) {

        $sql = "SELECT 
					twac_id,
					twac_name_th,
					twac_name_abbr_th,
					twac_start_time,
					twac_end_time,
                    twac_color

				FROM " . $this->hr_db . ".hr_person as ps
				LEFT JOIN " . $this->hr_db . ".hr_person_position as pos
				   ON pos.pos_ps_id = ps.ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_hire as hire
				   ON pos.pos_hire_id = hire.hire_id
                LEFT JOIN ".$this->hr_db.".hr_timework_attendance_config as twac
                    ON twac.twac_is_medical = hire.hire_is_medical AND twac.twac_type = hire.hire_type
				WHERE 	pos.pos_ps_id = {$ps_id} AND pos.pos_dp_id = {$dp_id}
                        AND twac.twac_active = 1
                ORDER BY twac_start_time ASC";
		$query = $this->hr->query($sql);
		return $query;
	
    }
	// get_attendance_config_person_data
    

} // end class M_hr_timework_attendance_config
?>
