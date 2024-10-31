<?php
/*
* M_hr_timework_setting
* Model for Manage about hr_timework_setting Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 23/09/2024
*/
include_once("Da_hr_timework_setting.php");

class M_hr_timework_setting extends Da_hr_timework_setting {

	/*
    * get_all_timework_setting_by_param
    * ดึงข้อมูลกำหนดระยะเวลาการลงเวลาทำงาน
    * @input $this->session->userdata('hr_hire_is_medical_string')
    * @output ข้อมูลที่ตรงกับ 
    * @author Tanadon Tangjaimongkhon
    * @Create Date 23/09/2024
    */
    public function get_all_timework_setting_by_param() {
        
        $sql = "SELECT twst.*, us.us_name
                FROM ".$this->hr_db.".hr_timework_setting as twst
                LEFT JOIN ".$this->ums_db.".ums_user as us
                    ON twst.twst_create_user = us.us_id 
                ORDER BY twst.twst_start_date ASC";
        
        // เรียกใช้ query โดยส่ง twst_id เป็น parameter
        $query = $this->hr->query($sql);

        return $query;
    }
    // get_all_timework_setting_by_param

    /*
    * get_timework_setting_duplicate
    * ตรวจสอบข้อมูลที่ซ้ำ
    * @input twst_month, twst_year
    * @output 
    * @author Tanadon Tangjaimongkhon
    * @Create Date 12/09/2024
    */
    public function get_timework_setting_duplicate() {

        $sql = "SELECT * 
                FROM ".$this->hr_db.".hr_timework_setting 
                WHERE twst_month = ? AND twst_year = ?";
        
        // เรียกใช้ query โดยส่ง twst_id เป็น parameter
        $query = $this->hr->query($sql, array($this->twst_month, $this->twst_year));

        return $query;
        
    }
    // get_timework_setting_duplicate

     /*
    * get_timework_setting_status_now
    * ดึงข้อมูลสถานะปัจจุบัน
    * @input twst_month, twst_year
    * @output 
    * @author Tanadon Tangjaimongkhon
    * @Create Date 16/10/2024
    */
    public function get_timework_setting_status_now() {

        $sql = "SELECT * 
                FROM ".$this->hr_db.".hr_timework_setting 
                WHERE twst_status = 'Y'";
        
        // เรียกใช้ query โดยส่ง twst_id เป็น parameter
        $query = $this->hr->query($sql);

        return $query;
        
    }
    // get_timework_setting_status_now


     /*
    * update_all_status
    * อัพเดทสถานะทั้งหมด
    * @input twst_month, twst_year
    * @output 
    * @author Tanadon Tangjaimongkhon
    * @Create Date 16/10/2024
    */
	function update_all_status() {
        $sql = "UPDATE ".$this->hr_db.".hr_timework_setting
				SET twst_status = 'N'";
		$this->hr->query($sql);

		$sql = "UPDATE ".$this->hr_db.".hr_timework_setting
				SET twst_status = 'Y'
				WHERE twst_id=?";
		$this->hr->query($sql, array($this->twst_id));
	}
    // update_all_status

} // end class M_hr_timework_setting
?>
