<?php
/*
 * M_que_appointment
 * Model for Manage about que_appointment Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 12/06/2024
 */
include_once("Da_que_appointment.php");

class M_que_appointment extends Da_que_appointment
{
    
    /*
	* get_all_by_param
	* ข้อมูลการนัดหมายแพทย์
	* @input -
	* @output que_appointment all by param
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/06/2024
	*/
    function get_all_by_param($ps_id, $month, $year, $type="", $isAction="") {
        $dateString = date("Y-m-d", strtotime("$year-$month-01")); // Assuming the day is 01 for simplicity

        $cond = "";
        $select = "";
        $join = "";
        if($type != ""){
            $cond = "AND apm_patient_type = '{$type}'";
        }

        if($isAction == 'detail'){
            $select = "*";
            $join = "LEFT JOIN ".$this->ums_db.".ums_patient ON pt_id = apm_pt_id";
        }else{ 
            $select = "count(*) as count_que";
        }
        
        $sql = "SELECT {$select}
                FROM ".$this->que_db.".que_appointment
                {$join}
                WHERE   MONTH(apm_date) = MONTH('$dateString') 
                        AND YEAR(apm_date) = YEAR('$dateString')
                        AND apm_ps_id = {$ps_id} 
                        {$cond}
                ORDER BY apm_date ASC";
        $query = $this->que->query($sql);
        // echo $this->que->last_query();
        return $query;
    }
    // get_all_by_param


     /*
	* get_que_day_by_param
	* ข้อมูลการนัดหมายแพทย์
	* @input -
	* @output que_appointment all by param
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/06/2024
	*/
    function get_count_que_day_by_param($ps_id, $month, $year, $type, $isAction="") {
        $dateString = date("Y-m-d", strtotime("$year-$month-01")); // Assuming the day is 01 for simplicity

        $select = "";
        $join = "";
        $group_by = "";
        $cond = "";

        $with = "WITH days_of_week AS (
                    SELECT 'วันอาทิตย์' AS day_name, 0 AS day_order
                    UNION ALL SELECT 'วันจันทร์', 1
                    UNION ALL SELECT 'วันอังคาร', 2
                    UNION ALL SELECT 'วันพุธ', 3
                    UNION ALL SELECT 'วันพฤหัสบดี', 4
                    UNION ALL SELECT 'วันศุกร์', 5
                    UNION ALL SELECT 'วันเสาร์', 6
                )";


        if($isAction == 'detail'){
            $select = "*";
            $join = "LEFT JOIN ".$this->ums_db.".ums_patient ON pt_id = apm_pt_id";
        }else{ 
            $select = " days_of_week.day_name AS day_of_week_thai,
                        COALESCE(COUNT(apm_date), 0) AS count";

            $group_by = "GROUP BY days_of_week.day_name, days_of_week.day_order";
        }

        $sql = "{$with} 
                SELECT {$select}
                FROM days_of_week
                LEFT JOIN ".$this->que_db.".que_appointment
                ON days_of_week.day_name = CASE DAYNAME(CONVERT_TZ(apm_date, 'SYSTEM', '+07:00'))
                    WHEN 'Monday' THEN 'วันจันทร์'
                    WHEN 'Tuesday' THEN 'วันอังคาร'
                    WHEN 'Wednesday' THEN 'วันพุธ'
                    WHEN 'Thursday' THEN 'วันพฤหัสบดี'
                    WHEN 'Friday' THEN 'วันศุกร์'
                    WHEN 'Saturday' THEN 'วันเสาร์'
                    WHEN 'Sunday' THEN 'วันอาทิตย์'
                END
                {$join}
                WHERE   MONTH(apm_date) = MONTH('$dateString') 
                        AND YEAR(apm_date) = YEAR('$dateString')
                        AND apm_ps_id = {$ps_id}
                        AND apm_patient_type = '{$type}'
                        {$cond}
                {$group_by}
                ORDER BY days_of_week.day_order";
        $query = $this->que->query($sql);
        return $query;
    }
    // get_count_que_day_by_param

    function check_identification($identification_id){
      $sql = "SELECT * FROM $this->ums_db.ums_patient
              LEFT JOIN 
                see_umsdb.ums_patient_detail ON ptd_pt_id = pt_id
              WHERE ? IN (`pt_passport`, `pt_peregrine`, `pt_identification`) AND pt_sta_id = '1'";

      $query = $this->que->query($sql, array($identification_id));
      return $query;
    }
    function check_patient_by_id($pt_id){
        $sql = "SELECT * FROM $this->ums_db.ums_patient
                LEFT JOIN 
                  see_umsdb.ums_patient_detail ON ptd_pt_id = pt_id
                WHERE pt_id = ?  AND pt_sta_id = '1'";
  
        $query = $this->que->query($sql, array($pt_id));
        return $query;
      }

    function check_member($member_id){
      $sql = "SELECT * FROM $this->ums_db.ums_patient 
              LEFT JOIN 
                see_umsdb.ums_patient_detail ON ptd_pt_id = pt_id
              WHERE pt_member = ? AND pt_sta_id = '1'";
      
      $query = $this->que->query($sql, array($member_id));
      return $query;
    }
  /*
	* get_structure_detail
	* ข้อมูลแผนก ที่สถานะใช้งาน และ level 3
	* @input -
	* @output แผนก
	* @author Patiya
	* @Create Date 14/06/2024
	*/
    function get_structure_detail(){
      $sql = "SELECT * FROM $this->hr_db.hr_structure LEFT JOIN $this->hr_db.hr_structure_detail ON stde_stuc_id = stuc_id WHERE stuc_status = '1' AND stde_is_medical = 'Y' AND stde_active = '1' " ;
      $query = $this->que->query($sql);
      return $query;
    }
    function get_all_priority(){
        $sql = "SELECT * FROM see_quedb.que_base_priority LIMIT 3 " ;
        $query = $this->que->query($sql);
        return $query;
      }
    function get_stde_id_by_apm_id($apm_id){
        $sql ="SELECT apm_stde_id,apm_ps_id,apm_pt_id,apm_id,apm_date ,apm_time ,pt.pt_prefix,pt.pt_fname,pt.pt_lname
                FROM see_quedb.que_appointment 
                LEFT JOIN see_umsdb.ums_patient AS pt ON pt_id = apm_pt_id
                WHERE apm_id = ? ";
        $query = $this->que->query($sql,array($apm_id));
        return $query;
    }
    function get_stde_id_by_visit($visit){
        $sql ="SELECT   apm_stde_id,apm_ps_id,apm_pt_id,apm_id,apm_date ,apm_time ,apm_pri_id, apm_app_walk, 
                        CONCAT(pt.pt_prefix, '', pt.pt_fname, ' ', pt.pt_lname) AS pt_name,
                        hr_structure_detail.stde_name_th,
                        CONCAT(hr_base_prefix.pf_name_abbr, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name
                
                FROM see_quedb.que_appointment 
                LEFT JOIN see_umsdb.ums_patient AS pt ON pt.pt_id = apm_pt_id
                LEFT JOIN see_hrdb.hr_structure_detail ON see_quedb.que_appointment.apm_stde_id = hr_structure_detail.stde_id
                LEFT JOIN see_hrdb.hr_person ON que_appointment.apm_ps_id = hr_person.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
                WHERE apm_visit = ? ";
        $query = $this->que->query($sql,array($visit));
        return $query;
    }
    function get_visit_by_id($apm_id){
        $sql = "SELECT apm_visit FROM $this->que_db.que_appointment WHERE apm_id = ?";
        $query = $this->que->query($sql,array($apm_id));
        return $query;
    }

    function get_person_med(){
      $sql = "SELECT * FROM $this->hr_db.hr_structure_person 
      LEFT JOIN $this->hr_db.hr_structure_detail ON stde_id = stdp_stde_id 
      LEFT JOIN $this->hr_db.hr_person ON stdp_ps_id = ps_id 
      LEFT JOIN $this->hr_db.hr_person_position ON pos_ps_id = ps_id
      WHERE pos_dp_id = '".$this->session->userdata('us_dp_id')."' AND pos_hire_id IN ('1','2')";

      $query = $this->que->query($sql);
      return $query;
    }
    function get_doctors_by_departments_array($stde_ids = [], $show_all = false)
    {
        $stde_id_sql = '';
    
        if (!$show_all && !empty($stde_ids)) {
            $stde_ids = implode(',', array_map('intval', $stde_ids)); // Convert array to comma-separated string
            $stde_id_sql = "AND stde_id IN ($stde_ids) ";
        }
        
        $sql = "SELECT *, CONCAT(hr_base_prefix.pf_name_abbr, ' ', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name
                FROM $this->hr_db.hr_structure_person 
                LEFT JOIN $this->hr_db.hr_structure_detail ON stde_id = stdp_stde_id  AND stdp_active = 1 
                LEFT JOIN $this->hr_db.hr_person ON stdp_ps_id = ps_id 
                LEFT JOIN $this->hr_db.hr_person_position ON pos_ps_id = ps_id
                LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
                WHERE pos_dp_id = '".$this->session->userdata('us_dp_id')."' AND stuc_status = '1' $stde_id_sql 
                ";
       
        $query = $this->que->query($sql);
        // echo $this->que->last_query(); die;        
        return $query;
    }
    function get_doctors_by_department($stde_id = null, $show_all = false)
    {
        $us_dp_id = $this->session->userdata('us_dp_id');
        if (!$show_all && $stde_id !== null) {
            $stde_id_sql = "AND stde_id = '".$stde_id."' ";
        } else {
          $stde_id_sql = '';
        }
        $sql = "SELECT * , CONCAT(hr_base_prefix.pf_name_abbr, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name
        FROM $this->hr_db.hr_structure_person 
       
        LEFT JOIN $this->hr_db.hr_structure_detail ON stde_id = stdp_stde_id 
        LEFT JOIN $this->hr_db.hr_structure ON stuc_id = stde_stuc_id
        LEFT JOIN $this->hr_db.hr_person ON stdp_ps_id = ps_id 
        LEFT JOIN $this->hr_db.hr_person_position ON pos_ps_id = ps_id
        LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
        WHERE pos_dp_id = '".$us_dp_id."' AND stuc_status = '1' $stde_id_sql 
        GROUP BY ps_id";
        // AND pos_hire_id IN ('1','2')
        $query = $this->que->query($sql);
        // echo $this->que->last_query(); die;
        return $query;
    }

    function get_department_que_appointment(){
      $sql = "SELECT apm_stde_id, stde_name_th 
              FROM $this->que_db.que_appointment 
              LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id
              LEFT JOIN $this->hr_db.hr_structure ON stuc_id = stde_stuc_id 
              WHERE stuc_status = '1' 
              GROUP BY stde_name_th 
              ORDER BY CONVERT(stde_name_th USING utf8) COLLATE utf8_unicode_ci";
      $query = $this->que->query($sql);
      return $query;
    }

    function get_department(){
       $sql = "SELECT * FROM $this->ums_db.ums_department";
       $query = $this->que->query($sql);
       return $query;
    }

    public function get_department_times($dp_id, $day_name = '') {
      $sql =
      " SELECT 
            `dpt_dp_id`, 
            `dpt_date_name`,
            SUBSTRING_INDEX(GROUP_CONCAT(`dpt_period` ORDER BY `dpt_id` ASC), ',', 1) AS dpt_period_1,
            SUBSTRING_INDEX(GROUP_CONCAT(`dpt_time_start` ORDER BY `dpt_id` ASC), ',', 1) AS dpt_time_start_1,
            SUBSTRING_INDEX(GROUP_CONCAT(`dpt_time_end` ORDER BY `dpt_id` ASC), ',', 1) AS dpt_time_end_1,
            SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(`dpt_period` ORDER BY `dpt_id` ASC), ',', 2), ',', -1) AS dpt_period_2,
            SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(`dpt_time_start` ORDER BY `dpt_id` ASC), ',', 2), ',', -1) AS dpt_time_start_2,
            SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(`dpt_time_end` ORDER BY `dpt_id` ASC), ',', 2), ',', -1) AS dpt_time_end_2
        FROM 
            $this->ums_db.ums_department_time
        WHERE 
            `dpt_dp_id` = ?
             AND  `dpt_date_name` = ? 
        GROUP BY 
            `dpt_dp_id`, 
            `dpt_date_name`;
      "; 
      $query = $this->que->query($sql, array($dp_id, $day_name));
      
      if ($query->num_rows() > 0) {
          return $query->result_array();
      } else {
          return false;
      }
   }

    public function check_patient_by_identification($idCard)
    {
        $sql = "SELECT * FROM $this->ums_db.ums_patient WHERE pt_identification = ?";
        $query = $this->que->query($sql, array($idCard));
        // echo $this->que->last_query();
        return $query; // Return result as array
    }

    public function check_patient_by_identification_array($idCard)
    {
        $sql = "SELECT * FROM $this->ums_db.ums_patient WHERE pt_identification = ?";
        $query = $this->que->query($sql, array($idCard));
        return $query; // Return result as array
    }

    public function get_patient_by_id($pt_id)
    {
        $sql = "SELECT pt_id FROM $this->ums_db.ums_patient WHERE pt_id = ?";
        $query = $this->que->query($sql, array($pt_id));
        return $query; // Return result as array
    }
    public function get_patient()
    {
        $sql = "SELECT * FROM $this->ums_db.ums_patient WHERE pt_sta_id = '1'";
        $query = $this->que->query($sql);
        return $query; // Return result as array
    }
    public function get_patient_no_que($date_format)
    {
        $sql = "SELECT * FROM $this->que_db.que_appointment as que
        LEFT JOIN $this->wts_db.wts_queue_seq as qus on qus.qus_apm_id = que.apm_id
        LEFT JOIN $this->wts_db.wts_notifications_department as ntdp on ntdp.ntdp_apm_id = que.apm_id
        WHERE que.apm_sta_id = '4'AND ntdp.ntdp_loc_Id = '6' AND qus.qus_id IS NULL AND que.apm_date = '$date_format'";
        $query = $this->que->query($sql);
        return $query; // Return result as array
    }
    public function get_appointment_by_id($apm_id){
      $sql = "SELECT *,
                CONCAT(hr_base_prefix.pf_name_abbr, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name, 
                CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                ptd_img_type, ptd_img_code
             FROM $this->que_db.que_appointment
            LEFT JOIN $this->ums_db.ums_patient ON apm_pt_id = pt_id 
            LEFT JOIN $this->hr_db.hr_person ON apm_ps_id = ps_id
            LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
            LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id
            LEFT JOIN $this->wts_db.wts_base_disease ON apm_ds_id = ds_id
            LEFT JOIN $this->ums_db.ums_department ON apm_dp_id = dp_id
            LEFT JOIN $this->ums_db.ums_patient_detail ON ptd_pt_id = apm_pt_id
       WHERE apm_id = ? AND apm_sta_id != '9' ";
      $query = $this->que->query($sql, array($apm_id));
      return $query; // Return result as array
    }
    public function get_appointment_by_visit($apm_visit){
        $sql = "SELECT *,
                  CONCAT(hr_base_prefix.pf_name_abbr, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name, 
                  CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                  ptd_img_type, ptd_img_code
               FROM $this->que_db.que_appointment
              LEFT JOIN $this->ums_db.ums_patient ON apm_pt_id = pt_id 
              LEFT JOIN $this->hr_db.hr_person ON apm_ps_id = ps_id
              LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
              LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id
              LEFT JOIN $this->wts_db.wts_base_disease ON apm_ds_id = ds_id
              LEFT JOIN $this->ums_db.ums_department ON apm_dp_id = dp_id
              LEFT JOIN $this->ums_db.ums_patient_detail ON ptd_pt_id = apm_pt_id
         WHERE apm_visit = ? AND apm_sta_id != '9' ";
        $query = $this->que->query($sql, array($apm_visit));
        return $query; // Return result as array
      }


    public function get_appointment_by_code($date, $apm_ql_code, $apm_stde_id){
        $sql = "SELECT * FROM que_appointment 
        LEFT JOIN $this->ums_db.ums_patient ON apm_pt_id = pt_id 
        LEFT JOIN $this->hr_db.hr_person ON apm_ps_id = ps_id
        LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
        LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id
        LEFT JOIN $this->wts_db.wts_base_disease ON apm_ds_id = ds_id
        LEFT JOIN $this->ums_db.ums_department ON apm_dp_id = dp_id
        LEFT JOIN $this->wts_db.wts_notifications_department ON apm_id = ntdp_apm_id
        WHERE apm_date = ? AND apm_ql_code = ? AND apm_stde_id = ?
        
         ";
        $query = $this->que->query($sql, array($date, $apm_ql_code, $apm_stde_id));
        return $query; // Return result as array
      }

      public function get_appointment_by_sta($date, $sta_id, $ps_id){
        $order = '';
        if($sta_id == 4) {
            $order .= "ORDER BY que_appointment.apm_ql_id ASC";
        }else if($sta_id == 2) {
            $order .= "ORDER BY que_appointment.apm_ql_id DESC";
        }
        $sql = "SELECT * FROM que_appointment 
        LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
        LEFT JOIN see_hrdb.hr_person ON apm_ps_id = ps_id
        LEFT JOIN see_hrdb.hr_base_prefix ON pf_id = ps_pf_id
        LEFT JOIN see_hrdb.hr_structure_detail ON apm_stde_id = stde_id
        LEFT JOIN see_wtsdb.wts_base_disease ON apm_ds_id = ds_id
        LEFT JOIN see_umsdb.ums_department ON apm_dp_id = dp_id
        LEFT JOIN see_wtsdb.wts_notifications_department ON apm_id = ntdp_apm_id
        WHERE apm_date = ? AND apm_sta_id = ? AND apm_ps_id = ?
        GROUP BY apm_ql_code
        {$order}
        
         ";
        $query = $this->que->query($sql, array($date, $sta_id, $ps_id));
        // pre($query);
        return $query; // Return result as array
      }

      function get_ntdp_list_btw_select_apm($date, $pre_que, $pt_que) {
        $sql = "SELECT que_appointment.*, wts_notifications_department.*, wts_base_disease_time.*
                FROM que_appointment
                LEFT JOIN see_wtsdb.wts_notifications_department
                ON que_appointment.apm_id = wts_notifications_department.ntdp_apm_id
                LEFT JOIN see_wtsdb.wts_base_disease_time
                ON wts_notifications_department.ntdp_dst_id = wts_base_disease_time.dst_id
                WHERE see_quedb.que_appointment.apm_date = '$date'
                AND (
                (see_quedb.que_appointment.apm_ql_code BETWEEN '$pt_que' AND '$pre_que')
                OR (see_quedb.que_appointment.apm_ql_code BETWEEN '$pre_que' AND '$pt_que')
                )
                AND see_quedb.que_appointment.apm_ql_code IS NOT NULL;
                ";
                $query = $this->que->query($sql, array());
                return $query; // Return result as array
    }

    public function get_count_list_btw_select_apm($date, $pre_que, $pt_que) {
        // ฟังก์ชัน SQL สำหรับการค้นหาข้อมูล
        $where = 'AND see_quedb.que_appointment.apm_ql_code BETWEEN ? AND ?';
        $sql = "SELECT count(*)
                FROM que_appointment
                LEFT JOIN see_wtsdb.wts_notifications_department
                ON que_appointment.apm_id = wts_notifications_department.ntdp_apm_id
                LEFT JOIN see_wtsdb.wts_base_disease_time
                ON wts_notifications_department.ntdp_dst_id = wts_base_disease_time.dst_id
                WHERE see_quedb.que_appointment.apm_date = ?
                {$where}
                AND see_quedb.que_appointment.apm_ql_code IS NOT NULL
                GROUP BY apm_ql_code";
        
        // ลองค้นหาด้วย $pre_que และ $pt_que
        $query = $this->que->query($sql, array($date, $pre_que, $pt_que));
        
        // ถ้าไม่เจอผลลัพธ์ให้ลองสลับ $pre_que และ $pt_que แล้วค้นหาใหม่
        if ($query->num_rows() == 0) {
            $query = $this->que->query($sql, array($date, $pt_que, $pre_que));
        }

        return $query; // ส่งผลลัพธ์กลับเป็น array
    }
    public function get_datetime_by_code($apm_ql_id){
        $sql = "SELECT apm_date, apm_time FROM que_appointment
                WHERE apm_ql_id = '$apm_ql_id'
        ";
        $query = $this->que->query($sql, array($apm_ql_id));
        return $query; // Return result as array
        
    }  

    public function get_appointment(){
      $sql = "SELECT *,CONCAT(pf_name, '', ps_fname, ' ', ps_lname) AS ps_name,CONCAT(pt_prefix, '', pt_fname, ' ', pt_lname) AS pt_name  FROM $this->que_db.que_appointment 
      LEFT JOIN $this->ums_db.ums_patient ON apm_pt_id = pt_id 
      LEFT JOIN $this->hr_db.hr_person ON apm_ps_id = ps_id
      LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
      LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id
      LEFT JOIN $this->wts_db.wts_base_disease ON apm_ds_id = ds_id
      LEFT JOIN $this->ums_db.ums_department ON apm_dp_id = dp_id 
      WHERE MONTH(`apm_date`)=MONTH(NOW()) ORDER BY apm_cl_code DESC";
      $query = $this->que->query($sql, array());
      return $query; // Return result as array
    }
    public function get_patient_paginated($start, $length, $order_column, $order_dir, $params) {
        $sql = "SELECT * FROM $this->ums_db.ums_patient WHERE pt_sta_id = '1'";
        $binds = array();
    
        // Check if there's a patient name to search
        if (!empty($params['patientName'])) {
            $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
            $binds[] = '%' . $params['patientName'] . '%';
        }
    
        // Check if there's a search value
        if (!empty($params['search'])) {
            $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
            $binds[] = '%' . $params['search'] . '%';
        }
    
        // Add ordering
        $order_columns = array(
            "pt_prefix",
            "pt_fname",
            "pt_lname",
            "pt_id"
        );
        $order_by = isset($order_columns[$order_column]) ? $order_columns[$order_column] : 'pt_id';
        $sql .= " ORDER BY $order_by $order_dir";
    
        // Add limit
        $sql .= " LIMIT ?, ?";
        $binds[] = intval($start);  // Ensure start is an integer
        $binds[] = intval($length); // Ensure length is an integer
    
        // Execute the query
        $query = $this->que->query($sql, $binds);
        return $query->result_array(); // Return result as array
    }
    public function get_patient_count($params)
{
    $sql = "SELECT COUNT(*) as appointment_count FROM $this->ums_db.ums_patient WHERE pt_sta_id = '1'";
    $binds = array();

    // Check if there's a patient name to search
    if (!empty($params['patientName'])) {
        $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
        $binds[] = '%' . $params['patientName'] . '%';
    }

    // Check if there's a search value
    if (!empty($params['search'])) {
        $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
        $binds[] = '%' . $params['search'] . '%';
    }

    // Execute the query
    $query = $this->que->query($sql, $binds);
    return $query->row(); // Return single row containing the count
}
    public function get_appointments_paginated($start, $length, $order_column, $order_dir, $params) {
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id WHERE stde_is_medical = 'Y' AND stdp_ps_id ='".$ps_id."' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
        $dp_id = $this->session->userdata('us_dp_id');
        $stde_ids_str = implode(',', $stde_ids);
        $sql = "SELECT see_quedb.que_appointment.*, 
                        ums_patient.*, 
                        wts_notifications_department.ntdp_id,
                        wts_notifications_department.ntdp_apm_id,
                        wts_notifications_department.ntdp_loc_Id,
                        wts_location.loc_name,   
                CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name, 
                CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                ums_department.dp_name_th, hr_structure_detail.stde_name_th 
                FROM see_quedb.que_appointment 
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id 
                LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
                LEFT JOIN see_hrdb.hr_structure_detail ON see_quedb.que_appointment.apm_stde_id = hr_structure_detail.stde_id
                LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
                LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
                LEFT JOIN see_wtsdb.wts_notifications_department ON see_quedb.que_appointment.apm_id = wts_notifications_department.ntdp_apm_id AND wts_notifications_department.ntdp_id = (
      SELECT MAX(ntdp_id) 
      FROM see_wtsdb.wts_notifications_department 
      WHERE ntdp_apm_id = see_quedb.que_appointment.apm_id
  )
                LEFT JOIN see_wtsdb.wts_location ON see_wtsdb.wts_location.loc_id = wts_notifications_department.ntdp_loc_Id 
                WHERE see_quedb.que_appointment.apm_sta_id = '1' AND see_quedb.que_appointment.apm_dp_id = '$dp_id' ";
    
        $binds = array();
        if (!empty($params['date'])) {
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND see_quedb.que_appointment.apm_date = ?";
            $binds[] = $gregorianDate;
        } else if(empty($params['month'])){
            $sql .= "AND see_quedb.que_appointment.apm_date = CURRENT_DATE ";
        }
        if (!empty($params['update_date'])) {
            $dateParts = explode('/', $params['update_date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND ? IN (DATE(see_quedb.que_appointment.apm_create_date),DATE(see_quedb.que_appointment.apm_update_date) ) ";
            $binds[] = $gregorianDate;
        }
        if (!empty($params['month'])) {
            $sql .= " AND  MONTH(see_quedb.que_appointment.apm_date) = ?";
            $binds[] = $params['month'];
        }
        
        if (!empty($params['department'])) {
            $sql .= " AND see_quedb.que_appointment.apm_stde_id = ?";
            $binds[] = $params['department'];
        }
        if (!empty($params['doctor'])) {
            $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
            $binds[] = $params['doctor'];
        }
        if (!empty($params['patientId'])) {
            $sql .= " AND see_umsdb.ums_patient.pt_member = ?";
            $binds[] = $params['patientId'];
        }
        if (!empty($params['patientName'])) {
            $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
            $binds[] = '%' . $params['patientName'] . '%';
        }
        if (!empty($params['sta_id'])) {
            $sql .= " AND see_quedb.que_appointment.apm_sta_id = ?";
            $binds[] = $params['sta_id'];
        }
        if (!empty($params['search'])) {
            $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
        }
        
        $valid_columns = ['see_quedb.que_appointment.apm_date', 'see_umsdb.ums_patient.pt_member', 'hr_person.ps_name', 'hr_structure_detail.stde_name_th'];
        $order_column = in_array($order_column, $valid_columns) ? $order_column : 'see_quedb.que_appointment.apm_date';
        $sql .= "ORDER BY apm_ql_code ASC";
        if(!empty($start) && !empty($length)) {
            $sql .= " LIMIT ?, ?";
            $binds[] = $start;
            $binds[] = $length;
        }
    
        $query = $this->que->query($sql, $binds);
        return $query->result_array();
    }
    public function get_appointments_paginated_triage($start, $length, $order_column, $order_dir, $params) {
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id WHERE stde_is_medical = 'Y' AND stdp_ps_id ='".$ps_id."' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
        $dp_id = $this->session->userdata('us_dp_id');
        $stde_ids_str = implode(',', $stde_ids);
        $sql = "SELECT see_quedb.que_appointment.*, 
                        ums_patient.*, 
                CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name, 
                CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                ums_department.dp_name_th, hr_structure_detail.stde_name_th ,
                wts_notifications_department.ntdp_time_start,
                wts_notifications_department.ntdp_date_start
                FROM see_quedb.que_appointment 
                LEFT JOIN see_wtsdb.wts_notifications_department ON apm_id = wts_notifications_department.ntdp_apm_id
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id 
                LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
                LEFT JOIN see_hrdb.hr_structure_detail ON see_quedb.que_appointment.apm_stde_id = hr_structure_detail.stde_id
                LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
                LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
                WHERE ntdp_loc_id = '1' AND ntdp_sta_id = '1' AND apm_sta_id != '9' AND apm_dp_id = '$dp_id'
                ";
    
        $binds = array();
        
        if (!empty($params['date'])) {
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND see_quedb.que_appointment.apm_date = ?";
            $binds[] = $gregorianDate;
        } else if(empty($params['month'])){
            $sql .= "AND see_quedb.que_appointment.apm_date = CURRENT_DATE ";
        }
        if (!empty($params['update_date'])) {
            $dateParts = explode('/', $params['update_date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND ? IN (DATE(see_quedb.que_appointment.apm_create_date),DATE(see_quedb.que_appointment.apm_update_date) ) ";
            $binds[] = $gregorianDate;
        }
        if (!empty($params['month'])) {
            $sql .= " AND  MONTH(see_quedb.que_appointment.apm_date) = ?";
            $binds[] = $params['month'];
        }
        
        if (!empty($params['department'])) {
            $sql .= " AND see_quedb.que_appointment.apm_stde_id = ?";
            $binds[] = $params['department'];
        }
        if (!empty($params['doctor'])) {
            $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
            $binds[] = $params['doctor'];
        }
        if (!empty($params['patientId'])) {
            $sql .= " AND see_umsdb.ums_patient.pt_member = ?";
            $binds[] = $params['patientId'];
        }
        if (!empty($params['patientName'])) {
            $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
            $binds[] = '%' . $params['patientName'] . '%';
        }
        if (!empty($params['sta_id'])) {
            $sql .= " AND see_quedb.que_appointment.apm_sta_id = ?";
            $binds[] = $params['sta_id'];
        }
        if (!empty($params['search'])) {
            $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
        }
        
        $valid_columns = ['see_quedb.que_appointment.apm_date', 'see_umsdb.ums_patient.pt_member', 'hr_person.ps_name', 'hr_structure_detail.stde_name_th'];
        $order_column = in_array($order_column, $valid_columns) ? $order_column : 'see_quedb.que_appointment.apm_date';
        // $sql .= "GROUP BY apm_visit ";
        $sql .= "ORDER BY apm_ql_code ASC";
        // $sql .= " LIMIT 1";
        if(!empty($start))
            $binds[] = $start;
        if(!empty($length))
            $binds[] = $length;
    
        $query = $this->que->query($sql, $binds);
        return $query->result_array();
    }
    public function get_appointments_paginated_health_right($start, $length, $order_column, $order_dir, $params) {
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id WHERE stde_is_medical = 'Y' AND stdp_ps_id ='".$ps_id."' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
        $dp_id = $this->session->userdata('us_dp_id');
        $stde_ids_str = implode(',', $stde_ids);
        $sql = "SELECT see_quedb.que_appointment.*, 
                        ums_patient.*, 
                CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name, 
                CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                ums_department.dp_name_th, hr_structure_detail.stde_name_th ,
                wts_notifications_department.ntdp_time_start,
                wts_notifications_department.ntdp_date_start
                FROM see_quedb.que_appointment 
                LEFT JOIN see_wtsdb.wts_notifications_department ON apm_id = wts_notifications_department.ntdp_apm_id
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id 
                LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
                LEFT JOIN see_hrdb.hr_structure_detail ON see_quedb.que_appointment.apm_stde_id = hr_structure_detail.stde_id
                LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
                LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
                WHERE ntdp_loc_id = '2' AND apm_sta_id = '1' AND apm_sta_id != '9' AND apm_dp_id = '$dp_id'
                ";
    
        $binds = array();
        
        if (!empty($params['date'])) {
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND see_quedb.que_appointment.apm_date = ?";
            $binds[] = $gregorianDate;
        } else if(empty($params['month'])){
            $sql .= "AND see_quedb.que_appointment.apm_date = CURRENT_DATE ";
        }
        if (!empty($params['update_date'])) {
            $dateParts = explode('/', $params['update_date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND ? IN (DATE(see_quedb.que_appointment.apm_create_date),DATE(see_quedb.que_appointment.apm_update_date) ) ";
            $binds[] = $gregorianDate;
        }
        if (!empty($params['month'])) {
            $sql .= " AND  MONTH(see_quedb.que_appointment.apm_date) = ?";
            $binds[] = $params['month'];
        }
        
        if (!empty($params['department'])) {
            $sql .= " AND see_quedb.que_appointment.apm_stde_id = ?";
            $binds[] = $params['department'];
        }
        if (!empty($params['doctor'])) {
            $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
            $binds[] = $params['doctor'];
        }
        if (!empty($params['patientId'])) {
            $sql .= " AND see_umsdb.ums_patient.pt_member = ?";
            $binds[] = $params['patientId'];
        }
        if (!empty($params['patientName'])) {
            $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
            $binds[] = '%' . $params['patientName'] . '%';
        }
        if (!empty($params['sta_id'])) {
            $sql .= " AND see_quedb.que_appointment.apm_sta_id = ?";
            $binds[] = $params['sta_id'];
        }
        if (!empty($params['search'])) {
            $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
        }
        
        $valid_columns = ['see_quedb.que_appointment.apm_date', 'see_umsdb.ums_patient.pt_member', 'hr_person.ps_name', 'hr_structure_detail.stde_name_th'];
        $order_column = in_array($order_column, $valid_columns) ? $order_column : 'see_quedb.que_appointment.apm_date';
        // $sql .= "GROUP BY apm_visit ";
        $sql .= "ORDER BY apm_ql_code ASC";
        // $sql .= " LIMIT 1";
        if(!empty($start))
            $binds[] = $start;
        if(!empty($length))
            $binds[] = $length;
    
        $query = $this->que->query($sql, $binds);
        return $query->result_array();
    }

    public function get_appointment_count($params) {
        if (!is_array($params)) {
            $params = [];
        }
        $dp_id = $this->session->userdata('us_dp_id');
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id WHERE stde_is_medical = 'Y' AND stdp_ps_id ='".$ps_id."' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
    
        $stde_ids_str = implode(',', $stde_ids);
        $sql = "SELECT COUNT(*) as appointment_count 
                FROM see_quedb.que_appointment 
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id 
                LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
                LEFT JOIN see_hrdb.hr_structure_detail ON see_quedb.que_appointment.apm_stde_id = hr_structure_detail.stde_id
                LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
                LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
                LEFT JOIN see_wtsdb.wts_notifications_department ON see_quedb.que_appointment.apm_id = wts_notifications_department.ntdp_apm_id AND wts_notifications_department.ntdp_id = (
      SELECT MAX(ntdp_id) 
      FROM see_wtsdb.wts_notifications_department 
      WHERE ntdp_apm_id = see_quedb.que_appointment.apm_id
  )
                LEFT JOIN see_wtsdb.wts_location ON see_wtsdb.wts_location.loc_id = wts_notifications_department.ntdp_loc_Id
                WHERE see_quedb.que_appointment.apm_sta_id = '1' AND see_quedb.que_appointment.apm_dp_id = '$dp_id' ";
    
        $binds = array();
        
        
        if (!empty($params['date'])) {
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND see_quedb.que_appointment.apm_date = ?";
            $binds[] = $gregorianDate;
        } else if(empty($params['month'])){
            $sql .= "AND see_quedb.que_appointment.apm_date = CURRENT_DATE ";
        }
        if (!empty($params['update_date'])) {
            $dateParts = explode('/', $params['update_date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND ? IN (DATE(see_quedb.que_appointment.apm_create_date),DATE(see_quedb.que_appointment.apm_update_date) ) ";
            $binds[] = $gregorianDate;
        }
        if (!empty($params['month'])) {
            $sql .= " AND  MONTH(see_quedb.que_appointment.apm_date) = ?";
            $binds[] = $params['month'];
        }
        if (!empty($params['department'])) {
            $sql .= " AND see_quedb.que_appointment.apm_stde_id = ?";
            $binds[] = $params['department'];
        }
        if (!empty($params['doctor'])) {
            $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
            $binds[] = $params['doctor'];
        }
        if (!empty($params['patientId'])) {
            $sql .= " AND see_umsdb.ums_patient.pt_member = ?";
            $binds[] = $params['patientId'];
        }
        if (!empty($params['patientName'])) {
            $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
            $binds[] = '%' . $params['patientName'] . '%';
        }
        if (!empty($params['sta_id'])) {
            $sql .= " AND see_quedb.que_appointment.apm_sta_id = ?";
            $binds[] = $params['sta_id'];
        }
        if (!empty($params['search'])) {
            $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
        }
        
    
        $query = $this->que->query($sql, $binds);
        return $query->row();
    }
    public function get_appointment_count_triage($params) {
        if (!is_array($params)) {
            $params = [];
        }
        $dp_id = $this->session->userdata('us_dp_id');
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id WHERE stde_is_medical = 'Y' AND stdp_ps_id ='".$ps_id."' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
    
        $stde_ids_str = implode(',', $stde_ids);
        $sql = "SELECT COUNT(*) as appointment_count 
                FROM see_quedb.que_appointment 
                LEFT JOIN see_wtsdb.wts_notifications_department ON apm_id = wts_notifications_department.ntdp_apm_id
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id 
                LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
                LEFT JOIN see_hrdb.hr_structure_detail ON see_quedb.que_appointment.apm_stde_id = hr_structure_detail.stde_id
                LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
                LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
                WHERE ntdp_loc_id = '1' AND ntdp_sta_id = '1' AND apm_sta_id != '9' AND apm_dp_id = '$dp_id' ";
    
        $binds = array();
        
        if (!empty($params['date'])) {
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND see_quedb.que_appointment.apm_date = ?";
            $binds[] = $gregorianDate;
        } else if(empty($params['month'])){
            $sql .= "AND see_quedb.que_appointment.apm_date = CURRENT_DATE ";
        }
        if (!empty($params['update_date'])) {
            $dateParts = explode('/', $params['update_date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND ? IN (DATE(see_quedb.que_appointment.apm_create_date),DATE(see_quedb.que_appointment.apm_update_date) ) ";
            $binds[] = $gregorianDate;
        }
        if (!empty($params['month'])) {
            $sql .= " AND  MONTH(see_quedb.que_appointment.apm_date) = ?";
            $binds[] = $params['month'];
        }
        if (!empty($params['department'])) {
            $sql .= " AND see_quedb.que_appointment.apm_stde_id = ?";
            $binds[] = $params['department'];
        }
        if (!empty($params['doctor'])) {
            $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
            $binds[] = $params['doctor'];
        }
        if (!empty($params['patientId'])) {
            $sql .= " AND see_umsdb.ums_patient.pt_member = ?";
            $binds[] = $params['patientId'];
        }
        if (!empty($params['patientName'])) {
            $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
            $binds[] = '%' . $params['patientName'] . '%';
        }
        if (!empty($params['sta_id'])) {
            $sql .= " AND see_quedb.que_appointment.apm_sta_id = ?";
            $binds[] = $params['sta_id'];
        }
        if (!empty($params['search'])) {
            $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
        }
        
    
        $query = $this->que->query($sql, $binds);
        return $query->row();
    }
    public function get_appointment_count_health_right($params) {
        if (!is_array($params)) {
            $params = [];
        }
        $dp_id = $this->session->userdata('us_dp_id');
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id WHERE stde_is_medical = 'Y' AND stdp_ps_id ='".$ps_id."' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
    
        $stde_ids_str = implode(',', $stde_ids);
        $sql = "SELECT COUNT(*) as appointment_count 
                FROM see_quedb.que_appointment 
                LEFT JOIN see_wtsdb.wts_notifications_department ON apm_id = wts_notifications_department.ntdp_apm_id
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id 
                LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
                LEFT JOIN see_hrdb.hr_structure_detail ON see_quedb.que_appointment.apm_stde_id = hr_structure_detail.stde_id
                LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
                LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
                WHERE ntdp_loc_id = '2' AND apm_sta_id = '1' AND apm_sta_id != '9' AND apm_dp_id = '$dp_id' ";
    
        $binds = array();
        
        if (!empty($params['date'])) {
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND see_quedb.que_appointment.apm_date = ?";
            $binds[] = $gregorianDate;
        } else if(empty($params['month'])){
            $sql .= "AND see_quedb.que_appointment.apm_date = CURRENT_DATE ";
        }
        if (!empty($params['update_date'])) {
            $dateParts = explode('/', $params['update_date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= "AND ? IN (DATE(see_quedb.que_appointment.apm_create_date),DATE(see_quedb.que_appointment.apm_update_date) ) ";
            $binds[] = $gregorianDate;
        }
        if (!empty($params['month'])) {
            $sql .= " AND  MONTH(see_quedb.que_appointment.apm_date) = ?";
            $binds[] = $params['month'];
        }
        if (!empty($params['department'])) {
            $sql .= " AND see_quedb.que_appointment.apm_stde_id = ?";
            $binds[] = $params['department'];
        }
        if (!empty($params['doctor'])) {
            $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
            $binds[] = $params['doctor'];
        }
        if (!empty($params['patientId'])) {
            $sql .= " AND see_umsdb.ums_patient.pt_member = ?";
            $binds[] = $params['patientId'];
        }
        if (!empty($params['patientName'])) {
            $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
            $binds[] = '%' . $params['patientName'] . '%';
        }
        if (!empty($params['sta_id'])) {
            $sql .= " AND see_quedb.que_appointment.apm_sta_id = ?";
            $binds[] = $params['sta_id'];
        }
        if (!empty($params['search'])) {
            $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
        }
        
    
        $query = $this->que->query($sql, $binds);
        return $query->row();
    }
    public function check_appointment($apm_id){
        $sql = "SELECT * FROM $this->que_db.que_appointment WHERE apm_id = ?";
        $query = $this->que->query($sql, array($apm_id));
        return $query; // Return result as array
    }
    public function check_visit($apm_visit){
        $sql = "SELECT * FROM $this->que_db.que_appointment WHERE apm_visit = ?"; 
        $query = $this->que->query($sql,array($apm_visit));
        return $query;
    }
    public function check_visit_and_stde_id($apm_visit,$stde_id){
        $sql = "SELECT * FROM $this->que_db.que_appointment WHERE apm_visit = ? AND apm_stde_id = ? AND apm_sta_id != '9'"; 
        $query = $this->que->query($sql,array($apm_visit,$stde_id));
        return $query;
    }
    function get_appointment_by_date_pt_id($apm_date,$apm_pt_id){
        $sql = "SELECT * FROM see_quedb.que_appointment 
        WHERE apm_date = ? AND apm_pt_id = ? ";
        $query = $this->que->query($sql,array(
            $apm_date,$apm_pt_id
        ));
        return $query;
    }

    function insert_patient($identification,$pt_password,$pt_password_confirm,$pt_prefix,$pt_fname,$pt_lname,$pt_tel,$pt_email) {

        $sql_pt_member = "SELECT MAX(pt_member) AS max_pt_member FROM $this->ums_db.ums_patient";
        $query_pt_member = $this->que->query($sql_pt_member)->result_array();
        $pt_identification = null;
        $pt_peregrine = null;
        $pt_passport = null;

        if (strlen($identification) == 13) {
            if ($identification[0] == '0') {
                $pt_peregrine = $identification;
            } else {
                $pt_identification = $identification;
            }
        } else {
            $pt_passport = $identification;
        }
        $sql = "INSERT INTO ".$this->ums_db.".ums_patient (
            pt_sta_id, pt_member, pt_save, 
            pt_identification, pt_password, pt_password_confirm, pt_prefix, 
            pt_fname, pt_lname, pt_tel, pt_email, 
            pt_privacy, pt_create_date, pt_create_user , pt_peregrine ,pt_passport
        ) VALUES (
            '1', ?, 'que',
            ?, ?, ?, ?,
            ?, ?, ?, ?, 'Y', NOW(), ? , ? ,?
        )";
        
        // เพิ่มข้อมูลลูกค้าใหม่โดยใช้ query
        $this->ums->query($sql, array(
            ($query_pt_member[0]['max_pt_member'] + 1), // pt_member
            $pt_identification, $pt_password, $pt_password_confirm, $pt_prefix, // ข้อมูลส่วนตัว
            $pt_fname, $pt_lname, $pt_tel, $pt_email, // ข้อมูลส่วนตัว
            $this->session->userdata('us_id'),$pt_peregrine ,$pt_passport // ผู้ใช้ที่สร้าง
        ));
        echo $this->ums->last_query();
        return $this->ums->insert_id();
	}

    function update_patient($idCard, $prefix, $firstName, $lastName, $phoneNumber, $email, $patient) {
        $pt_identification = null;
        $pt_peregrine = null;
        $pt_passport = null;

        if (strlen($idCard) == 13) {
            if ($idCard[0] == '0') {
                $pt_peregrine = $idCard;
            } else {
                $pt_identification = $idCard;
            }
        } else {
            $pt_passport = $idCard;
        }
        $sql = "UPDATE ".$this->ums_db.".ums_patient SET
                    pt_identification = ?, pt_prefix = ?, pt_fname = ?, pt_peregrine =? , pt_passport =? ,
                    pt_lname = ?, pt_tel = ?, pt_email = ? , pt_update_date = NOW() , pt_update_user = ?
                WHERE 
                    pt_id = ?";
        $this->ums->query($sql, array(
            $pt_identification, $prefix, $firstName, $pt_peregrine , $pt_passport,
            $lastName, $phoneNumber, $email,$this->session->userdata('us_id'), $patient
        ));
    }

    function insert_appointment($pt_id, $apm_app_walk, $apm_cl_id , $apm_ntf_id, $apm_cl_code , $apm_pri_id, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id , $apm_ds_id, $apm_patient_type, $apm_cause , $apm_need, $apm_dp_id, $apm_create_user ,$apm_sta_id)
{
    $sql = "INSERT INTO " . $this->que_db . ".que_appointment (
        apm_pt_id, apm_app_walk, apm_cl_id, apm_cl_code, apm_pri_id,
        apm_date, apm_time, apm_ps_id, apm_stde_id, 
        apm_ds_id, apm_patient_type, apm_ntf_id, apm_cause, apm_need, 
        apm_dp_id, apm_create_user, apm_create_date , apm_sta_id
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW() , ?
    )";

    $this->que->query($sql, array(
        $pt_id, $apm_app_walk, $apm_cl_id, $apm_cl_code, $apm_pri_id,
        $apm_date, $apm_time, $apm_ps_id, $apm_stde_id,
        $apm_ds_id, $apm_patient_type, $apm_ntf_id, $apm_cause, $apm_need,
        $apm_dp_id, $apm_create_user , $apm_sta_id
    ));

    return $this->que->insert_id();
}
    function insert_appointment_api($apm_pt_id,$apm_visit,$apm_app_walk,$apm_ntf_id,$apm_date,$apm_sta_id, $apm_patient_type,$ds_stde_id,$apm_ql_code,$apm_pri_id,$apm_dp_id,$person_query,$apm_time)
    {
        $sql = "INSERT INTO " . $this->que_db . ".que_appointment (
            apm_pt_id,apm_visit,apm_app_walk,
            apm_ntf_id,apm_date, apm_sta_id,
            apm_patient_type,
            apm_create_date,
            apm_stde_id,
            apm_ql_code,
            apm_pri_id,
            apm_dp_id,
            apm_ps_id,
            apm_time
        ) VALUES (
           ?, ?, ?, ?, ?, ?, ? , NOW() , ? , ? , ? ,? ,? ,?
        )";
    
        $this->que->query($sql, array(
            $apm_pt_id,$apm_visit,$apm_app_walk,$apm_ntf_id, $apm_date,$apm_sta_id, $apm_patient_type , $ds_stde_id,$apm_ql_code,$apm_pri_id,$apm_dp_id,$person_query,$apm_time
        ));
    
        return $this->que->insert_id();
    }

    function insert_announce() {
      $sql = "INSERT INTO " . $this->que_db . ".que_appointment (
          apm_pt_id,
          apm_date,
          apm_sta_id, 
          apm_stde_id,
          apm_ps_id,
          apm_time
      ) VALUES (
         ?, ? , ? , ? , ? ,?
      )
      ";
      $this->que->query($sql, array(
          0,$this->apm_date,4, $this->apm_stde_id,$this->apm_ps_id,$this->apm_time
      ));
  return $this->last_insert_id = $this->que->insert_id();
  }
  function update_announce() {
      $sql = "UPDATE " . $this->que_db . ".que_appointment 
              SET 
                  apm_pt_id = ?,
                  apm_date = ?,
                  apm_sta_id = ?, 
                  apm_stde_id = ?, 
                  apm_ps_id = ?, 
                  apm_time = ?
              WHERE 
                  apm_id = ?";  // Assuming `apm_id` is the unique identifier for the record you want to update
  
      $this->que->query($sql, array(
          0, $this->apm_date, 4, $this->apm_stde_id, $this->apm_ps_id, $this->apm_time, $this->apm_id  // Make sure to pass `apm_id`
      ));
  }
      function get_tracking_department($stde_id){
      $sql = "SELECT * FROM $this->que_db.que_base_department_keyword WHERE dpk_stde_id = ? AND dpk_active != '2' ";
      $query = $this->ums->query($sql, array($stde_id));
      return $query; // Return result as array
    }
    function get_queue_department($stde_id){
        $sql = "SELECT * FROM $this->que_db.que_base_department_queue WHERE dpq_stde_id = ? AND dpq_active != '2' ";
        $query = $this->ums->query($sql, array($stde_id));
        return $query; // Return result as array
      }
    public function delete_appointment ($apm_id){
        $sql = "DELETE FROM see_quedb.que_appointment WHERE apm_id = ?";
        $this->que->query($sql , $apm_id);
    }
    public function update_appointment($appointmentId,$apm_app_walk,$update_appointment,$apm_pri_id, $pt_id, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id, $apm_ds_id, $apm_patient_type, $apm_cause, $apm_need, $apm_dp_id, $apm_create_user,$apm_sta_id) {
      $data = array(
          'apm_pt_id' => $pt_id,
          'apm_app_walk' => $apm_app_walk,
          'apm_ntf_id' => $update_appointment,
          'apm_date' => $apm_date,
          'apm_time' => $apm_time,
          'apm_pri_id' => $apm_pri_id,
          'apm_ps_id' => $apm_ps_id,
          'apm_stde_id' => $apm_stde_id,
          'apm_ds_id' => $apm_ds_id,
          'apm_patient_type' => $apm_patient_type,
          'apm_cause' => $apm_cause,
          'apm_need' => $apm_need,
          'apm_dp_id' => $apm_dp_id,
          'apm_update_user' => $apm_create_user,
          'apm_sta_id' => $apm_sta_id,
          'apm_update_date' => date('Y-m-d H:i:s')
      );

      $this->que->where('apm_id', $appointmentId);
      $this->que->update(''.$this->que_db.'.que_appointment', $data);

    }
    public function update_apm_visit ($apm_id,$apm_visit){
        $data = array(
            'apm_visit' => $apm_visit
        );
        $this->que->where('apm_id',$apm_id);
        $this->que->update(''.$this->que_db.'.que_appointment',$data);
    }
    public function get_app_walk($apm_id) {
        // Prepare the query
        $this->que->select('apm_app_walk');
        $this->que->from(''.$this->que_db.'.que_appointment');
        $this->que->where('apm_id', $apm_id);
    
        // Execute the query and retrieve the result
        $query = $this->que->get();
        
        // Check if the result has a row and return the `apm_app_walk` value
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->apm_app_walk;
        } else {
            return null; // Or handle the case when the appointment ID doesn't exist
        }
    }
    public function update_appointment_api($appointmentId,$apm_cl_id,$update_appointment,$apm_cl_code,$apm_pri_id, $pt_id, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id, $apm_ds_id, $apm_patient_type, $apm_cause, $apm_need, $apm_dp_id, $apm_create_user,$apm_sta_id) {
        $data = array(
            'apm_pt_id' => $pt_id,
            'apm_cl_id' => $apm_cl_id,
            'apm_ntf_id' => $update_appointment,
            'apm_cl_code' => $apm_cl_code,
            'apm_date' => $apm_date,
            'apm_time' => $apm_time,
            'apm_pri_id' => $apm_pri_id,
            'apm_ps_id' => $apm_ps_id,
            'apm_stde_id' => $apm_stde_id,
            'apm_ds_id' => $apm_ds_id,
            'apm_patient_type' => $apm_patient_type,
            'apm_cause' => $apm_cause,
            'apm_need' => $apm_need,
            'apm_dp_id' => $apm_dp_id,
            'apm_create_user' => $apm_create_user,
            'apm_sta_id' => $apm_sta_id,
            'apm_update_date' => date('Y-m-d H:i:s')
        );
  
        $this->que->where('apm_id', $appointmentId);
        $this->que->update(''.$this->que_db.'.que_appointment', $data);
        
        // echo $this->que->last_query(); die;
      }
    
  public function update_appointment_stde_id($appointment_id,$stde_id) {
    $data = array(
        'apm_stde_id' => $stde_id,
    );

    $this->que->where('apm_id', $appointment_id);
    $this->que->update(''.$this->que_db.'.que_appointment', $data);
}
  public function update_appointment_que_code($appointment_id,$apm_update_user) {
    $data = array(
        // 'apm_ql_code' => $apm_ql_code,
        // 'apm_ps_id' =>$apm_ps_id,
        // 'apm_pri_id' => $pri_id,
        'apm_sta_id' => '4',
        // 'apm_ql_id' => $apm_ql_id,
        'apm_update_user' => $apm_update_user
    );

    $this->que->where('apm_id', $appointment_id);
    $this->que->update(''.$this->que_db.'.que_appointment', $data);
}
public function get_ql_code($appointment_id){
    $this->que->select('apm_ql_code');
    $this->que->from(''.$this->que_db.'.que_appointment');
    $this->que->where('apm_id', $appointment_id);
    
    $query = $this->que->get();
    
    if ($query->num_rows() > 0) {
        $result = $query->row();
        return $result->apm_ql_code;
    }
    
    return null;
}

    /*
    * get_appointment_server
    * get all que_appointment all status for officer manage que
    * @input ps_id(person id): id of officer for get patient in structure department
    * @output list of que appointment wait for process
    * @author Dechathon prajit 
    * @Create Date 9/7/2024
    * @Update Date Areerat Pongurai 12/07/2024 get all status
    */
    public function get_appointments_server_wts($start, $length, $order_column, $order_dir, $params) {
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail 
                                      LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id 
                                      WHERE stde_is_medical = 'Y' AND stdp_ps_id = '$ps_id' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
    
        
            $stde_ids_str = implode(',', $stde_ids);
    
            $sql = "SELECT *, 
                           CONCAT(pf_name, '', ps_fname, ' ', ps_lname) AS ps_name, 
                           CONCAT(pt_prefix, '', pt_fname, ' ', pt_lname) AS pt_name
                    FROM see_quedb.que_appointment 
                    LEFT JOIN see_quedb.que_base_priority ON apm_pri_id = pri_id 
                    LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
                    LEFT JOIN see_hrdb.hr_person ON apm_ps_id = ps_id
                    LEFT JOIN see_hrdb.hr_base_prefix ON pf_id = ps_pf_id
                    LEFT JOIN see_hrdb.hr_structure_detail ON apm_stde_id = stde_id
                    LEFT JOIN see_wtsdb.wts_base_disease ON apm_ds_id = ds_id
                    LEFT JOIN see_umsdb.ums_department ON apm_dp_id = dp_id 
                    WHERE apm_stde_id IN ($stde_ids_str)";
    
            $binds = array();
    
            if (!empty($params['month'])) {
                $sql .= " AND MONTH(apm_date) = ?";
                $binds[] = $params['month'];
            }
    
            if (!empty($params['date'])) {
                $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= " AND DATE(see_quedb.que_appointment.apm_date) = ?";
            $binds[] = $gregorianDate;
            } else {
                $sql .= "AND DATE(apm_date) = CURDATE() ";

            }
    
            if (!empty($params['department'])) {
                $sql .= " AND apm_stde_id = ?";
                $binds[] = $params['department'];
            }
    
            if (!empty($params['doctor'])) {
                $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
                $binds[] = $params['doctor'];
            }
    
            if (!empty($params['patientId'])) {
                $sql .= " AND pt_member = ?";
                $binds[] = $params['patientId'];
            }
    
            if (!empty($params['patientName'])) {
                $sql .= " AND CONCAT(pt_prefix, '', pt_fname, ' ', pt_lname) LIKE ?";
                $binds[] = '%' . $params['patientName'] . '%';
            }
    
            if (!empty($params['sta_id'])) {
                $sql .= " AND apm_sta_id = ?";
                $binds[] = $params['sta_id'];
            }else {
                $sql .= "AND apm_sta_id NOT IN ('1', '5') "; // แก้ เพิ่ม 1, 5

            }
            if (!empty($params['search'])) {
                $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
                $binds[] ='%'. $params['search'].'%' ;
                $binds[] ='%'. $params['search'].'%' ;
                $binds[] ='%'. $params['search'].'%' ;
                $binds[] ='%'. $params['search'].'%' ;
                $binds[] ='%'. $params['search'].'%' ;
            }
    
            $sql .= " ORDER BY $order_column $order_dir";
            $sql .= " LIMIT ?, ?";
            $binds[] = (int)$start;
            $binds[] = (int)$length;
    
            $query = $this->que->query($sql, $binds);
    
            if (!$query) {
                log_message('error', 'Query error: ' . $this->db->_error_message());
            }
    
            return $query->result_array();
    }
    
    /*
    * get_appointment_count_wts2
    * get count que_appointment by params
    * @input $params
    * @output count
    * @author Areerat Pongurai 
    * @Create Date 31/07/2024
    */
    public function get_appointment_count_wts2($params) {
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail 
                                      LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id 
                                      WHERE stde_is_medical = 'Y' AND stdp_ps_id = '$ps_id' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
    
        $stde_ids_str = implode(',', $stde_ids);

        $sql = "SELECT COUNT(*) AS total
                FROM see_quedb.que_appointment 
                LEFT JOIN see_quedb.que_base_priority ON apm_pri_id = pri_id 
                LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
                LEFT JOIN see_hrdb.hr_person ON apm_ps_id = ps_id
                LEFT JOIN see_hrdb.hr_base_prefix ON pf_id = ps_pf_id
                LEFT JOIN see_hrdb.hr_structure_detail ON apm_stde_id = stde_id
                LEFT JOIN see_wtsdb.wts_base_disease ON apm_ds_id = ds_id
                LEFT JOIN see_umsdb.ums_department ON apm_dp_id = dp_id 
                WHERE apm_stde_id IN ($stde_ids_str)";

        $binds = array();

        if (!empty($params['month'])) {
            $sql .= " AND MONTH(apm_date) = ?";
            $binds[] = $params['month'];
        }

        if (!empty($params['date'])) {
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $sql .= " AND DATE(see_quedb.que_appointment.apm_date) = ?";
            $binds[] = $gregorianDate;
        } else {
            $sql .= "AND DATE(apm_date) = CURDATE() ";

        }

        if (!empty($params['department'])) {
            $sql .= " AND apm_stde_id = ?";
            $binds[] = $params['department'];
        }

        if (!empty($params['doctor'])) {
            $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
            $binds[] = $params['doctor'];
        }

        if (!empty($params['patientId'])) {
            $sql .= " AND pt_member = ?";
            $binds[] = $params['patientId'];
        }

        if (!empty($params['patientName'])) {
            $sql .= " AND CONCAT(pt_prefix, '', pt_fname, ' ', pt_lname) LIKE ?";
            $binds[] = '%' . $params['patientName'] . '%';
        }

        if (!empty($params['sta_id'])) {
            $sql .= " AND apm_sta_id = ?";
            $binds[] = $params['sta_id'];
        }else {
            $sql .= "AND apm_sta_id NOT IN (1, 5) "; // แก้ เพิ่ม 5

        }
        if (!empty($params['search'])) {
            $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
        }

        $query = $this->que->query($sql, $binds);

        if (!$query) {
            log_message('error', 'Query error: ' . $this->db->_error_message());
        }
        
        $result = $query->row_array();

        return isset($result['total']) ? $result['total'] : 0;
    }

    /*
    * get_appointment_count_wts
    * get count que_appointment by params
    * @input $params
    * @output count
    * @author ?
    * @Create Date ?
    * @Update Date ? 31/07/2024 Areerat Pongurai add where DATE(...) = ?
    */
    public function get_appointment_count_wts($params) {
        $ps_id = $this->session->userdata('us_ps_id');
        $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail 
                                      LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id 
                                      WHERE stde_is_medical = 'Y' AND stdp_ps_id = '$ps_id' AND stdp_active = '1'")->result_array();
        $stde_ids = array_column($get_stde, 'stde_id');
    
        if (!empty($stde_ids)) {
            $stde_ids_str = implode(',', $stde_ids);
    
            $sql = "SELECT COUNT(*) AS total 
                    FROM {$this->que_db}.que_appointment 
                    LEFT JOIN {$this->ums_db}.ums_patient ON apm_pt_id = pt_id 
                    LEFT JOIN {$this->hr_db}.hr_person ON apm_ps_id = ps_id
                    LEFT JOIN {$this->hr_db}.hr_base_prefix ON pf_id = ps_pf_id
                    LEFT JOIN {$this->hr_db}.hr_structure_detail ON apm_stde_id = stde_id
                    LEFT JOIN {$this->wts_db}.wts_base_disease ON apm_ds_id = ds_id
                    LEFT JOIN {$this->ums_db}.ums_department ON apm_dp_id = dp_id 
                    WHERE DATE(apm_date) = CURDATE() AND apm_stde_id IN ($stde_ids_str)";
    
            $binds = array();
    
            if (!empty($params['month'])) {
                $sql .= " AND MONTH(apm_date) = ?";
                $binds[] = $params['month'];
            }
    
            if (!empty($params['date'])) {
                $dateParts = explode('/', $params['date']);
                $day = $dateParts[0];
                $month = $dateParts[1];
                $buddhistYear = $dateParts[2];
                $gregorianYear = (int)$buddhistYear - 543;
                $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
                $sql .= " AND DATE(apm_date) = ?";
                $binds[] = $gregorianDate;
            }
    
            if (!empty($params['department'])) {
                $sql .= " AND apm_stde_id = ?";
                $binds[] = $params['department'];
            }
    
            if (!empty($params['doctor'])) {
                $sql .= " AND apm_ps_id = ?";
                $binds[] = $params['doctor'];
            }
    
            if (!empty($params['patientId'])) {
                $sql .= " AND pt_member = ?";
                $binds[] = $params['patientId'];
            }
    
            if (!empty($params['patientName'])) {
                $sql .= " AND CONCAT(pt_prefix, '', pt_fname, ' ', pt_lname) LIKE ?";
                $binds[] = '%' . $params['patientName'] . '%';
            }
    
            if (!empty($params['sta_id'])) {
                $sql .= " AND apm_sta_id = ?";
                $binds[] = $params['sta_id'];
            }
            if (!empty($params['search'])) {
                $sql .= " AND (CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ? OR apm_cl_code LIKE ? OR pt_member LIKE ? OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE ? OR stde_name_th LIKE ?)";
                $binds[] ='%'. $params['search'].'%' ;
                $binds[] ='%'. $params['search'].'%' ;
                $binds[] ='%'. $params['search'].'%' ;
                $binds[] ='%'. $params['search'].'%' ;
                $binds[] ='%'. $params['search'].'%' ;
            }
    
            $query = $this->que->query($sql, $binds);
            $result = $query->row_array();
    
            if (!$query) {
                log_message('error', 'Query error: ' . $this->db->_error_message());
            }
    
            return isset($result['total']) ? $result['total'] : 0;
        }
    
        return 0;
    }

    /*
    * search_appointments
    * ?
    * @input $params, $ps_id
    * @output ?
    * @author ?
    * @Create Date ?
    * @Update Date ? 31/07/2024 Areerat Pongurai add where DATE(...) = ?
    */
  public function search_appointments($params,$ps_id) {
    $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id WHERE stde_is_medical = 'Y' AND stdp_ps_id ='".$ps_id."' AND stdp_active = '1'")->result_array();
    $stde_ids = array_column($get_stde, 'stde_id');
    
    $stde_ids_str = implode(',', $stde_ids);
    $sql = "SELECT see_quedb.que_appointment.*, 
                    ums_patient.*, 
            CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name, 
            CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
            hr_structure_detail.stde_name_th 
            FROM see_quedb.que_appointment 
            LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id 
            LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
            LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
            LEFT JOIN see_hrdb.hr_structure_detail ON see_quedb.que_appointment.apm_stde_id = hr_structure_detail.stde_id
            LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
            LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
            WHERE apm_stde_id IN ('".$stde_ids_str."')";

    if (!empty($params['date'])) {
        $dateParts = explode('/', $params['date']); // Split date by '/'
        $day = $dateParts[0];
        $month = $dateParts[1];
        $buddhistYear = $dateParts[2];
        $gregorianYear = (int)$buddhistYear - 543;
        $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
        $sql .= " AND DATE(see_quedb.que_appointment.apm_date) = ?";
        $binds[] = $gregorianDate;
    }
    if (!empty($params['department'])) {
        $sql .= " AND see_quedb.que_appointment.apm_stde_id = ?";
        $binds[] = $params['department'];
    }
    if (!empty($params['doctor'])) {
        $sql .= " AND see_quedb.que_appointment.apm_ps_id = ?";
        $binds[] = $params['doctor'];
    }
    if (!empty($params['patientId'])) {
        $sql .= " AND see_umsdb.ums_patient.pt_member = ?";
        $binds[] = $params['patientId'];
    }
    if (!empty($params['patientName'])) {
        $sql .= " AND CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE ?";
        $binds[] = '%' . $params['patientName'] . '%';
    }
    if (!empty($params['sta_id'])) {
        $sql .= " AND see_quedb.que_appointment.apm_sta_id = ?";
        $binds[] = $params['sta_id'];
    }
    if (!empty($params['month'])) {
        $sql .= " AND MONTH(see_quedb.que_appointment.apm_date) = ?";
        $binds[] = $params['month'];
    }
    $sql .= " ORDER BY see_quedb.que_appointment.apm_cl_code DESC";

    $query = $this->que->query($sql, isset($binds) ? $binds : array());
    return $query->result_array();
}

  public function update_pt_id (){
    $sql = "UPDATE 
                see_quedb.que_appointment 
            SET
                apm_ps_id = ?
            where
                apm_id = ? ";
    $query = $this->que->query($sql , array(
        $this->apm_ps_id,
        $this->apm_id ));
  }

    /*
    * get_all_status_list
    * get list of que_base_status
    * @input $not_all
    * @output list of que_base_status
    * @author ?
    * @Create Date ?
    * @Update Date ? 31/07/2024 Areerat Pongurai add WHERE sta_id NOT IN (4, 5, 11, 12)
    */
    public function get_all_status_list($not_all = false) {
        $sql = "SELECT * FROM see_quedb.que_base_status ";
        
        if ($not_all) {
            $sql .= " WHERE sta_id NOT IN (1, 10, 4, 5, 11, 12) ";
        }

        $sql .= " ORDER BY sta_seq ";

        $query = $this->que->query($sql);
        return $query;
    }
    public function update_status (){
        $sql = "UPDATE 
                    see_quedb.que_appointment 
                SET
                    apm_sta_id = ?
                    , apm_update_user = ?
                    , apm_update_date = NOW()
                where
                    apm_id = ? ";
        $query = $this->que->query($sql , array(
            $this->apm_sta_id,
            $this->session->userdata('us_id'),
            $this->apm_id ));
    }

    /*
	* update_appointment_date
	* update date, time and status = 1 if appointment current date (like round 2)
	* @input apm_date, apm_time, update user/date, apm_sta_id
	* @output -
	* @author Areerat Pongurai
	* @Create Date 11/07/2024
	*/
    public function update_appointment_date (){
        $sql = "UPDATE 
                    see_quedb.que_appointment 
                SET
                    apm_sta_id = ?
                    , apm_date = ?
                    , apm_time = ?
                    , apm_update_user = ?
                    , apm_update_date = NOW()
                where
                    apm_id = ? ";
        $query = $this->que->query($sql , array(
            $this->apm_sta_id,
            $this->apm_date,
            $this->apm_time,
            $this->session->userdata('us_id'),
            $this->apm_id ));
    }

    // SELECT * FROM `hr_structure_detail` WHERE `stde_is_medical` LIKE 'Y' ORDER BY `stde_stuc_id` ASC
    public function get_base_noti(){
        $sql = "SELECT *
                FROM 
                    see_amsdb.ams_base_notify 
                where 
                    ntf_active = 1 ";
        $query = $this->que->query($sql);
        return $query; // Return result as array
    }

    function get_notification_by_person($ps_id){
        $sql = "
			
			SELECT 
				*
			FROM ".$this->que_db.".que_appointment AS que
			LEFT JOIN ".$this->hr_db.".hr_person ON que.apm_ps_id = ps_id
			LEFT JOIN ".$this->hr_db.".hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN ".$this->que_db.".que_code_list AS cl ON cl.cl_id = que.apm_cl_id
			LEFT JOIN ".$this->que_db.".que_base_department_keyword AS dpk ON dpk.dpk_keyword = cl.cl_dpk_keyword
			LEFT JOIN ".$this->ums_db.".ums_patient AS pt ON que.apm_pt_id = pt.pt_id
			LEFT JOIN ".$this->ums_db.".ums_department AS dp ON dp.dp_id = que.apm_dp_id
			WHERE que.apm_date >= CURDATE()
				AND que.apm_sta_id IN (1,2)
				AND que.apm_ps_id = {$ps_id}
            GROUP BY que.apm_id
            ORDER BY que.apm_date ASC";
		$query = $this->que->query($sql);
		return $query;
    }

    public function get_diseases_by_department($department_id) {
      $this->db->select('ds_id, ds_name_disease, ds_stde_id');
      $this->db->from(''.$this->wts_db.'.wts_base_disease');
      $this->db->where('ds_stde_id', $department_id);
      $query = $this->db->get();
  
      if ($query->num_rows() > 0) {
          return $query->result_array();
      } else {
          return [];
      }
  }

    /*
    * insert_by_apm_parent_id
    * insert que_appointment by que_appointment id that same data some field
    * @input apm_parent_id
    * @output -
    * @author Areerat Pongurai
    * @Create Date 05/08/2024
    */
    public function insert_by_apm_parent_id() {
        $sql = "INSERT INTO ".$this->que_db.".que_appointment (
                    apm_parent_id, apm_pt_id, apm_cl_id, apm_cl_code, 
                    apm_date, apm_time, apm_ps_id, apm_stde_id, apm_dp_id, apm_ntf_id, 
                    apm_ds_id, apm_patient_type, apm_create_user, apm_create_date
                )
                SELECT ?, apm_pt_id, ?, ?, 
                    ?, ?, apm_ps_id, apm_stde_id, apm_dp_id, apm_ntf_id, 
                    apm_ds_id, ?, ?, NOW()
                FROM ".$this->que_db.".que_appointment
                WHERE apm_id = ? ";
                //apm_cause, apm_need, 
		$query = $this->que->query($sql, array($this->apm_parent_id, $this->apm_cl_id, $this->apm_cl_code, 
            $this->apm_date, $this->apm_time, 
            $this->apm_patient_type, $this->apm_create_user, 
            $this->apm_parent_id));
		$this->last_insert_id = $this->que->insert_id();
		return $query;
    }

    /*
    * update_by_apm_parent_id
    * insert que_appointment by que_appointment id that same data some field
    * @input apm_parent_id
    * @output -
    * @author Areerat Pongurai
    * @Create Date 05/08/2024
    */
    public function update_by_apm_parent_id() {
        $sql = "UPDATE ".$this->que_db.".que_appointment 
                SET apm_date = ?, apm_time = ?, apm_update_user = ?,  apm_update_date = NOW()
                WHERE apm_parent_id = ? ";
		$query = $this->que->query($sql, array($this->apm_date, $this->apm_time, $this->apm_update_user, $this->apm_parent_id));
		return $query;
    }

    /*
    * get_by_apm_parent_id
    * get que_appointment by apm_parent_id
    * @input apm_parent_id
    * @output -
    * @author Areerat Pongurai
    * @Create Date 09/08/2024
    */
    public function get_by_apm_parent_id() {
        $sql = "SELECT * 
                FROM ".$this->que_db.".que_appointment 
                WHERE apm_parent_id = ? ";
		$query = $this->que->query($sql, array($this->apm_parent_id));
		return $query;
    }
  
    /*
    * get_appointment_trello_wts
    * get all que_appointment all status for officer manage que
    * @input ps_id(person id): id of officer for get patient in structure department
    * @output list of que appointment wait for process
    * @author Areerat Pongurai
    * @Create Date 20/08/2024
    * @Update Date 09/09/2024 Areerat - add params floor
    */
    public function get_appointment_trello_wts($params) {
        // $ps_id = $this->session->userdata('us_ps_id');
        // $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail 
        //                               LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id 
        //                               WHERE stde_is_medical = 'Y' AND stdp_ps_id = '$ps_id' AND stdp_active = '1'")->result_array();
        // $stde_ids = array_column($get_stde, 'stde_id');
    
        // $stde_ids_str = implode(',', $stde_ids);

        $binds = array();
        $where = '';
        if (!empty($params['month'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " MONTH(apm.apm_date) = ? ";
            $binds[] = $params['month'];
        }

        if (!empty($params['date'])) {
		    if(!empty($where)) $where .= " AND ";
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $where .= " DATE(apm.apm_date) = ? ";
            $binds[] = $gregorianDate;
        } else {
		    if(!empty($where)) $where .= " AND ";
            $where .= " DATE(apm.apm_date) = CURDATE() ";
        }

        if (!empty($params['department'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_stde_id = ? ";
            $binds[] = $params['department'];
        }

        if (!empty($params['departments'])) {
		    if(!empty($where)) $where .= " AND ";
            $stde_ids_str = implode(',', $params['departments']);
            $where .= " apm.apm_stde_id IN ({$stde_ids_str}) ";
        }
        
        if (!empty($params['is_null_ps_id']) && $params['is_null_ps_id']) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_ps_id IS NULL ";
        } else {
            if (!empty($params['doctor'])) {
                if(!empty($where)) $where .= " AND ";
                $where .= " apm.apm_ps_id = ? ";
                $binds[] = $params['doctor'];
            }
        }

        if (!empty($params['patientId'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " pt.pt_member = ? ";
            $binds[] = $params['patientId'];
        }

        if (!empty($params['visitId'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_visit LIKE ? ";
            $binds[] = '%' . $params['visitId'] . '%';
        }

        if (!empty($params['patientName'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " CONCAT(pt.pt_prefix, '', pt.pt_fname, ' ', pt.pt_lname) LIKE ? ";
            $binds[] = '%' . $params['patientName'] . '%';
        }

        // check condition for order by
        $order = " ORDER BY CASE WHEN apm.apm_sta_id = 2 THEN 0 ELSE 1 END ASC, CASE WHEN qus.qus_seq IS NULL THEN 1 ELSE 0 END ASC, qus.qus_seq ASC ";
        if (!empty($params['sta_id'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_sta_id = ? ";
            $binds[] = $params['sta_id'];

            // ยังไม่เสร็จ
            if ($params['sta_id'] == 10) { // พบแพทย์เสร็จสิ้น
                // $order = " ORDER BY CASE WHEN qus.qus_seq IS NULL THEN 1 ELSE 0 END ASC, qus.qus_seq ASC";
                $order = " ORDER BY apm.apm_update_date DESC";
            }
            if($params['sta_id'] == 4) { // ออกหมายเลขคิว
                // $order = " ORDER BY CASE WHEN qus.qus_seq IS NULL THEN 1 ELSE 0 END ASC, qus.qus_seq ASC";
                $order = " ORDER BY apm.apm_update_date DESC";
            }
        }else {
            /*  ไม่เอา
                1 - นัดหมายสำเร็จ
                5 - ดำเนินการเสร็จสิ้น (จะไม่ใช้แล้ว)
                10 - พบแพทย์เสร็จสิ้น
             */
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_sta_id NOT IN ('1', '5', '9', '10') ";
        }

        if (!empty($params['search'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " (CONCAT(pt.pt_prefix, '', pt.pt_fname, ' ', pt.pt_lname) LIKE ? OR apm.apm_cl_code LIKE ? OR pt.pt_member LIKE ? OR CONCAT(pf.pf_name, '', ps.ps_fname, ' ', ps.ps_lname) LIKE ? OR stde.stde_name_th LIKE ?)";
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
            $binds[] ='%'. $params['search'].'%' ;
        }

        // if have parameter floor then where stde(แผนก) that in this floor
        if (!empty($params['floor'])) {
            $rm_floor = $params['floor'];
            $rooms = $this->que->query("SELECT DISTINCT rm_stde_id FROM see_eqsdb.eqs_room WHERE rm_floor = {$rm_floor} AND rm_stde_id IS NOT NULL ORDER BY rm_name")->result_array();
            $stde_ids = array_column($rooms, 'rm_stde_id');
            $stde_ids_str = implode(',', $stde_ids);
            if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_stde_id IN ($stde_ids_str) ";
        }

        $sql = " SELECT apm.apm_stde_id, 
                    apm.apm_id, 
                    apm.apm_visit, 
                    apm.apm_patient_type, 
                    apm.apm_ps_id, 
                    apm.apm_sta_id, 
                    apm.apm_ql_code, 
                    apm.apm_pri_id, 
                    pri.pri_color, 
                    pri.pri_name, 
                    apm_app_walk, 
                    qus.qus_app_walk,
                    ntdp.max_ntdp_date_start AS ntdp_date_start, 
                    ntdp.max_ntdp_time_start AS ntdp_time_start, 
                    apm.apm_time, 
                    CONCAT(pf.pf_name, '', ps.ps_fname, ' ', ps.ps_lname) AS ps_name, 
                    CONCAT(pt.pt_prefix, '', pt.pt_fname, ' ', pt.pt_lname) AS pt_name,
                    qus.qus_announce_id,
                    qus.qus_announce,
                    qus.qus_time_start,
                    qus.qus_time_end                
                    FROM see_quedb.que_appointment apm
                LEFT JOIN see_quedb.que_base_priority pri ON apm.apm_pri_id = pri.pri_id 
                LEFT JOIN see_umsdb.ums_patient pt ON apm.apm_pt_id = pt.pt_id 
                LEFT JOIN see_hrdb.hr_person ps ON apm.apm_ps_id = ps.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix pf ON pf.pf_id = ps.ps_pf_id
                LEFT JOIN see_hrdb.hr_structure_detail stde ON apm.apm_stde_id = stde.stde_id
                LEFT JOIN see_wtsdb.wts_queue_seq qus ON qus.qus_apm_id = apm.apm_id
                LEFT JOIN see_umsdb.ums_department dp ON apm.apm_dp_id = dp.dp_id 
                LEFT JOIN (
                    SELECT ntdp_apm_id, 
                        MAX(ntdp_date_start) AS max_ntdp_date_start, 
                        MAX(ntdp_time_start) AS max_ntdp_time_start 
                    FROM see_wtsdb.wts_notifications_department 
                    WHERE ntdp_loc_id = 5 
                    GROUP BY ntdp_apm_id
                ) ntdp ON ntdp.ntdp_apm_id = apm.apm_id
                WHERE {$where}";
                // apm.apm_stde_id IN ($stde_ids_str)

        $sql .= " GROUP BY apm.apm_stde_id, 
                    apm.apm_id, 
                    apm.apm_visit, 
                    apm.apm_patient_type, 
                    apm.apm_ps_id, 
                    apm.apm_sta_id, 
                    apm.apm_ql_code, 
                    apm.apm_pri_id, 
                    pri.pri_color, 
                    pri.pri_name, 
                    apm_app_walk, 
                    qus.qus_app_walk,
                    ntdp.max_ntdp_date_start, 
                    ntdp.max_ntdp_time_start, 
                    apm.apm_time, 
                    CONCAT(pf.pf_name, '', ps.ps_fname, ' ', ps.ps_lname), 
                    CONCAT(pt.pt_prefix, '', pt.pt_fname, ' ', pt.pt_lname) ";

        $sql .= $order;
        // pre($binds);
       
        $query = $this->que->query($sql, $binds);
        // echo $query; die;
        if (!$query) {
            log_message('error', 'Query error: ' . $this->db->_error_message());
        }

        return $query->result_array();
    }
    
    /*
    * get_doctors_trello_wts
    * get all doctors in que_appointments that date
    * @input 
    * @output list of doctors in que_appointments that date
    * @author Areerat Pongurai
    * @Create Date 31/08/2024
    * @Update Date 09/09/2024 Areerat - add params floor
    */
    public function get_doctors_trello_wts($params) {
        // $ps_id = $this->session->userdata('us_ps_id');
        // $get_stde = $this->hr->query("SELECT * FROM hr_structure_detail 
        //                               LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id 
        //                               WHERE stde_is_medical = 'Y' AND stdp_ps_id = '$ps_id' AND stdp_active = '1'")->result_array();
        // $stde_ids = array_column($get_stde, 'stde_id');
    
        // $stde_ids_str = implode(',', $stde_ids);

        $binds = array();
        $where = '';
        $where_join = '';

        if (!empty($params['month'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " MONTH(apm.apm_date) = ? ";
            $binds[] = $params['month'];
        }

        if (!empty($params['date'])) {
		    if(!empty($where)) $where .= " AND ";
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $where .= " DATE(apm.apm_date) = ? ";
            $binds[] = $gregorianDate;

            $where_join .= " AND DATE(psrm.psrm_date) = ? ";
            $binds[] = $gregorianDate;
        } else {
		    if(!empty($where)) $where .= " AND ";
            $where .= " DATE(apm.apm_date) = CURDATE() ";

            $where_join .= " AND DATE(psrm.psrm_date) = CURDATE() ";
        }

        if (!empty($params['department'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_stde_id = ? ";
            $binds[] = $params['department'];
        }
        
        if (!empty($params['departments'])) {
		    if(!empty($where)) $where .= " AND ";
            $stde_ids_str = implode(',', $params['departments']);
            $where .= " apm.apm_stde_id IN ( {$stde_ids_str} ) ";
        }
        
        if (!empty($params['doctor'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_ps_id = ? ";
            $binds[] = $params['doctor'];

            // // ถ้ามีแพทย์ระบุและ ให้หาห้องของแพทย์คนนั้นด้วย
            // if (!empty($params['date'])) {
            //     $where_join .= " AND DATE(psrm.psrm_date) = '{$gregorianDate}'";
            // } else {
            //     $where_join .= "AND DATE(psrm.psrm_date) = CURDATE() ";
            // }
        }

        if (!empty($params['patientId'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " pt.pt_member = ? ";
            $binds[] = $params['patientId'];
        }

        if (!empty($params['visitId'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_visit LIKE ? ";
            $binds[] = '%' . $params['visitId'] . '%';
        }

        if (!empty($params['patientName'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " CONCAT(pt.pt_prefix, '', pt.pt_fname, ' ', pt.pt_lname) LIKE ? ";
            $binds[] = '%' . $params['patientName'] . '%';
        }

        // check condition for order by
        if (!empty($params['sta_id'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_sta_id = ? ";
            $binds[] = $params['sta_id'];
        }else {
            /*  ไม่เอา
                1 - นัดหมายสำเร็จ
                5 - ดำเนินการเสร็จสิ้น (จะไม่ใช้แล้ว)
                10 - พบแพทย์เสร็จสิ้น
             */
		    // if(!empty($where)) $where .= " AND ";
            // $where .= "AND apm.apm_sta_id NOT IN ('1', '5', '9', '10') ";
        }
        $order = " ORDER BY apm.apm_update_date DESC";

        // if have parameter floor then where stde(แผนก) that in this floor
        if (!empty($params['floor'])) {
            $rm_floor = $params['floor'];
            $rooms = $this->que->query("SELECT DISTINCT rm_stde_id FROM see_eqsdb.eqs_room WHERE rm_floor = {$rm_floor} AND rm_stde_id IS NOT NULL ORDER BY rm_name")->result_array();
            $stde_ids = array_column($rooms, 'rm_stde_id');
            $stde_ids_str = implode(',', $stde_ids);
            if(!empty($where)) $where .= " AND ";
            $where .= " apm.apm_stde_id IN ($stde_ids_str) ";
        }

        $sql = "SELECT  CONCAT(pf.pf_name, '', ps.ps_fname, ' ', ps.ps_lname) AS ps_name, 
                        apm.apm_ps_id, ps.ps_id, psrm.psrm_id, rm.rm_id, rm.rm_name, stde.stde_name_th
                FROM see_quedb.que_appointment apm
                LEFT JOIN see_hrdb.hr_person ps ON apm.apm_ps_id = ps.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix pf ON pf.pf_id = ps.ps_pf_id
                -- LEFT JOIN see_hrdb.hr_structure_detail stde ON apm.apm_stde_id = stde.stde_id
                LEFT JOIN see_hrdb.hr_person_room psrm ON psrm.psrm_ps_id = apm.apm_ps_id {$where_join}
                LEFT JOIN see_eqsdb.eqs_room rm ON rm.rm_id = psrm.psrm_rm_id
                LEFT JOIN see_hrdb.hr_structure_detail stde ON rm.rm_stde_id = stde.stde_id
                WHERE apm.apm_ps_id IS NOT NULL AND {$where}";
                // AND apm.apm_stde_id IN ($stde_ids_str) 

        $sql .= " GROUP BY CONCAT(pf.pf_name, '', ps.ps_fname, ' ', ps.ps_lname), 
                        apm.apm_ps_id, psrm.psrm_id, rm.rm_id, rm.rm_name, stde.stde_name_th ";

        $sql .= $order;
        $query = $this->que->query($sql, $binds);

        if (!$query) {
            log_message('error', 'Query error: ' . $this->db->_error_message());
        }

        return $query->result_array();
    }

    /*
    * get_stde_id_by_ps_id
    * get all stde that stde_is_medical = 'Y' by person
    * @input ps_id(hr_person_id)
    * @output list of stde that stde_is_medical = 'Y'
    * @author Areerat Pongurai
    * @Create Date 31/08/2024
    */
    public function get_stde_id_by_ps_id($ps_id) {
        return $this->hr->query("SELECT * FROM hr_structure_detail 
                                      LEFT JOIN hr_structure_person ON stdp_stde_id = stde_id 
                                      WHERE stde_is_medical = 'Y' AND stdp_ps_id = '$ps_id' AND stdp_active = '1'")->result_array();
    }  

    /*
    * get_all_tool_exr_of_patient
    * get all get_all_tool_exr_of_patient of patient
    * @input 
        ps_id(hr_person_id)
        stde_id(hr_structure_detail_id)
        ds_id(wts_dicease_id)
    * @output all get_all_tool_exr_of_patient of patient
    * @author Areerat Pongurai
    * @Create Date 04/09/2024
    */
    public function get_all_tool_exr_of_patient($pt_id, $stde_id, $ds_id = null) {
        $where = " WHERE exr.exr_id IS NOT NULL AND apm.apm_pt_id = {$pt_id} AND apm.apm_stde_id = {$stde_id} ";
        if(!empty($ds_id))
            $where .= " AND apm.apm_ds_id = {$ds_id} ";
            // $sql = "SELECT exr.exr_eqs_id, a.apm_pt_id, eqs.eqs_name, rm.rm_name, a.max_exr_inspection_time, exr.exr_status
            //         FROM ( 
            //             SELECT exr.exr_eqs_id, apm.apm_pt_id, MAX(exr.exr_inspection_time) AS max_exr_inspection_time, exr.exr_id
            //             FROM see_quedb.que_appointment apm 
            //             LEFT JOIN see_amsdb.ams_notification_results ntr ON apm.apm_id = ntr.ntr_apm_id 
            //             LEFT JOIN see_dimdb.dim_examination_result exr ON ntr.ntr_id = exr.exr_ntr_id 
            //             {$where}
            //             GROUP BY exr.exr_eqs_id ) a 
            //         LEFT JOIN see_dimdb.dim_examination_result exr ON a.exr_id = exr.exr_id
            //         LEFT JOIN see_eqsdb.eqs_equipments eqs ON exr.exr_eqs_id = eqs.eqs_id 
            //         LEFT JOIN see_eqsdb.eqs_room rm ON eqs.eqs_rm_id = rm.rm_id  
            //         WHERE exr.exr_id IS NOT NULL
            //         ORDER BY a.max_exr_inspection_time DESC, rm.rm_name, eqs.eqs_name ";
            $sql = "SELECT apm.apm_pt_id, apm.apm_visit, apm.apm_date, apm.apm_time, apm.apm_ds_id, apm.apm_stde_id, 
                            exr.exr_id, exr.exr_eqs_id, exr.exr_status, eqs.eqs_name, rm.rm_name
                        FROM see_quedb.que_appointment apm 
                        LEFT JOIN see_amsdb.ams_notification_results ntr ON apm.apm_id = ntr.ntr_apm_id 
                        LEFT JOIN see_dimdb.dim_examination_result exr ON ntr.ntr_id = exr.exr_ntr_id 
                        LEFT JOIN see_eqsdb.eqs_equipments eqs ON exr.exr_eqs_id = eqs.eqs_id 
                        LEFT JOIN see_eqsdb.eqs_room rm ON eqs.eqs_rm_id = rm.rm_id  
                        {$where}
                        ORDER BY apm.apm_date DESC, apm.apm_time DESC, rm.rm_name, eqs.eqs_name ";
        $query = $this->que->query($sql);
        return $query;
    }  


    public function get_user($us_ps_id){
      $sql = "SELECT * FROM see_umsdb.ums_user LEFT JOIN see_hrdb.hr_person ON us_ps_id = ps_id WHERE us_ps_id = '".$us_ps_id."'";
      $query = $this->que->query($sql);
      return $query;
    }

    public function get_room($apm_id){
      $sql = "SELECT * FROM see_wtsdb.wts_queue_seq 
      LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id = psrm_id 
      LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id 
      WHERE qus_apm_id = '".$apm_id."'";
      $query = $this->que->query($sql);
      return $query;
    }

    public function get_room_dep($rm_id){
      $sql = "SELECT * FROM see_eqsdb.eqs_room 
      WHERE rm_id = '".$rm_id."'";
      $query = $this->que->query($sql);
      return $query;
    }
} // end class M_que_appointment
?>