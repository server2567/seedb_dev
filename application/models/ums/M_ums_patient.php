<?php

include_once("Da_ums_patient.php");

class M_ums_patient extends Da_ums_patient {
	
	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
	function get_all($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT * 
				FROM ums_patient 
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	/*
	 * create array of pk field and value for generate select list in view, must edit PK_FIELD and FIELD_NAME manually
	 * the first line of select list is '-----เลือก-----' by default.
	 * if you do not need the first list of select list is '-----เลือก-----', please pass $optional parameter to other values. 
	 * you can delete this function if it not necessary.
	 */
	function get_options($optional='y') {
		$qry = $this->get_all();
		if ($optional=='y') $opt[''] = '-----เลือก-----';
		foreach ($qry->result() as $row) {
			$opt[$row->PK_FIELD] = $row->FIELD_NAME;
		}
		return $opt;
	}
	
	// // add your functions here
	function get_unique_th()
	{
			$sql = "SELECT * FROM ums_patient WHERE pt_identification = ?";
			$query = $this->ums->query($sql,array($this->pt_identification));
			return $query;
	}

	function get_unique_th_with_id()
	{
			$sql = "SELECT * FROM ums_patient WHERE pt_id != ? AND pt_identification = ?";
			$query = $this->ums->query($sql,array($this->pt_id, $this->pt_identification));
			return $query;
	}

  public function check_id_exists($id) {
    $this->ums->where('pt_identification', $id);
    $this->ums->where('pt_save', 'regis');
    $query = $this->ums->get('ums_patient'); // Replace 'patients' with your actual table name
    return $query->num_rows() > 0;
  }

  public function check_alien_id_exists($id) {
    $this->ums->where('pt_peregrine', $id);
    $query = $this->ums->get('ums_patient'); // Replace 'patients' with your actual table name
    return $query->num_rows() > 0;
  }

  public function check_passport_id_exists($id) {
    $this->ums->where('pt_passport', $id);
    $query = $this->ums->get('ums_patient'); // Replace 'patients' with your actual table name
    return $query->num_rows() > 0;
  }

  public function insert_patient($data) {
    $this->db->insert(''.$this->ums_db.'.ums_patient', $data);
  }

  public function insert_patient_requests($data) {
    $this->db->insert(''.$this->ums_db.'.ums_patient_requests', $data);
  }

  public function update_patient($data, $where) {
    $this->db->where($where);
    $this->db->update($this->ums_db . '.ums_patient', $data);
  }

  public function insert_patient_detail($data) {
    $this->ums->insert('ums_patient_detail', $data);
  }

  public function insert_patient_detail_requests($data) {
    $this->ums->insert('ums_patient_detail_requests', $data);
    // echo $this->ums->last_query(); die;
  }

  public function update_patient_detail($data, $where) {
    $this->db->where($where);
    $this->db->update($this->ums_db . '.ums_patient_detail', $data);
  }

  public function check_member() {
    $sql = "SELECT MAX(pt_member) AS max_pt_member FROM $this->ums_db.ums_patient";
    $query = $this->ums->query($sql);
    return $query;
  }

  public function check_insert_identification($pt_identification) {
    $sql = "SELECT * FROM $this->ums_db.ums_patient WHERE pt_identification = ? ";
    $query = $this->ums->query($sql,array($pt_identification));
    return $query;
  }
  public function check_insert_passport($passport) {
    $sql = "SELECT * FROM $this->ums_db.ums_patient WHERE pt_passport = ? ";
    $query = $this->ums->query($sql,array($passport));
    return $query;
  }
  public function check_insert_alien($alien) {
    $sql = "SELECT * FROM $this->ums_db.ums_patient WHERE pt_peregrine = ? ";
    $query = $this->ums->query($sql,array($alien));
    return $query;
  }

  public function check_pt_id($pt_id) {
    $sql = "SELECT * FROM $this->ums_db.ums_patient 
    LEFT JOIN $this->ums_db.ums_patient_detail ON ptd_pt_id = pt_id 
    LEFT JOIN $this->hr_db.hr_base_person_status ON ptd_psst_id = psst_id
    LEFT JOIN $this->hr_db.hr_base_blood ON ptd_blood_id = blood_id
    LEFT JOIN $this->hr_db.hr_base_nation ON ptd_nation_id = nation_id
    LEFT JOIN $this->hr_db.hr_base_religion ON ptd_reli_id = reli_id
    LEFT JOIN $this->hr_db.hr_base_district ON ptd_dist_id = dist_id
    LEFT JOIN $this->hr_db.hr_base_amphur ON ptd_amph_id = amph_id
    LEFT JOIN $this->hr_db.hr_base_province ON ptd_pv_id = pv_id
    WHERE pt_id = ? ";
    $query = $this->ums->query($sql,array($pt_id));
    return $query;
  }

  public function check_pt_id_requests_1($pt_id) {
    $sql = "SELECT latest_requests.*, latest_detail_requests.*, 
                   hr_base_person_status.psst_name, hr_base_blood.blood_name, 
                   hr_base_nation.nation_name, hr_base_religion.reli_name, 
                   hr_base_district.dist_name, hr_base_amphur.amph_name, 
                   hr_base_province.pv_name
            FROM (
                SELECT ums_patient_requests.*, ums_patient.pt_id AS ums_pt_id
                FROM $this->ums_db.ums_patient_requests
                INNER JOIN $this->ums_db.ums_patient ON ums_patient_requests.pt_id = ums_patient.pt_id
                INNER JOIN $this->ums_db.ums_patient_detail_requests ON ums_patient_requests.id = ums_patient_detail_requests.ptd_req_id
                WHERE ums_patient_requests.pt_id = ? AND ums_patient_detail_requests.ptd_seq = '1'
                AND ums_patient_requests.pt_sta_id NOT IN ('1','6')
                ORDER BY ums_patient_requests.id DESC
                LIMIT 1
            ) AS latest_requests
            INNER JOIN (
                SELECT ums_patient_detail_requests.*
                FROM $this->ums_db.ums_patient_detail_requests
                WHERE ums_patient_detail_requests.ptd_pt_id = ? AND ums_patient_detail_requests.ptd_seq = '1'
                ORDER BY ums_patient_detail_requests.ptd_id DESC
                LIMIT 1
            ) AS latest_detail_requests ON latest_detail_requests.ptd_req_id = latest_requests.id
            LEFT JOIN $this->hr_db.hr_base_person_status ON latest_detail_requests.ptd_psst_id = psst_id
            LEFT JOIN $this->hr_db.hr_base_blood ON latest_detail_requests.ptd_blood_id = blood_id
            LEFT JOIN $this->hr_db.hr_base_nation ON latest_detail_requests.ptd_nation_id = nation_id
            LEFT JOIN $this->hr_db.hr_base_religion ON latest_detail_requests.ptd_reli_id = reli_id
            LEFT JOIN $this->hr_db.hr_base_district ON latest_detail_requests.ptd_dist_id = dist_id
            LEFT JOIN $this->hr_db.hr_base_amphur ON latest_detail_requests.ptd_amph_id = amph_id
            LEFT JOIN $this->hr_db.hr_base_province ON latest_detail_requests.ptd_pv_id = pv_id
            LIMIT 1;";
    
    $query = $this->ums->query($sql, array($pt_id, $pt_id));
      // echo $this->ums->last_query(); die;
    return $query;
}

public function check_pt_id_requests_2($pt_id) {
  $sql = "SELECT latest_requests.*, latest_detail_requests.*, 
                   hr_base_person_status.psst_name, hr_base_blood.blood_name, 
                   hr_base_nation.nation_name, hr_base_religion.reli_name, 
                   hr_base_district.dist_name, hr_base_amphur.amph_name, 
                   hr_base_province.pv_name
            FROM (
                SELECT ums_patient_requests.*, ums_patient.pt_id AS ums_pt_id
                FROM $this->ums_db.ums_patient_requests
                INNER JOIN $this->ums_db.ums_patient ON ums_patient_requests.pt_id = ums_patient.pt_id
                INNER JOIN $this->ums_db.ums_patient_detail_requests ON ums_patient_requests.id = ums_patient_detail_requests.ptd_req_id
                WHERE ums_patient_requests.pt_id = ? AND ums_patient_detail_requests.ptd_seq = '2'
                AND ums_patient_requests.pt_sta_id NOT IN ('1','6')
                ORDER BY ums_patient_requests.id DESC
                LIMIT 1
            ) AS latest_requests
            INNER JOIN (
                SELECT ums_patient_detail_requests.*
                FROM $this->ums_db.ums_patient_detail_requests
                WHERE ums_patient_detail_requests.ptd_pt_id = ? AND ums_patient_detail_requests.ptd_seq = '2'
                ORDER BY ums_patient_detail_requests.ptd_id DESC
                LIMIT 1
            ) AS latest_detail_requests ON latest_requests.id = latest_detail_requests.ptd_req_id
            LEFT JOIN $this->hr_db.hr_base_person_status ON latest_detail_requests.ptd_psst_id = psst_id
            LEFT JOIN $this->hr_db.hr_base_blood ON latest_detail_requests.ptd_blood_id = blood_id
            LEFT JOIN $this->hr_db.hr_base_nation ON latest_detail_requests.ptd_nation_id = nation_id
            LEFT JOIN $this->hr_db.hr_base_religion ON latest_detail_requests.ptd_reli_id = reli_id
            LEFT JOIN $this->hr_db.hr_base_district ON latest_detail_requests.ptd_dist_id = dist_id
            LEFT JOIN $this->hr_db.hr_base_amphur ON latest_detail_requests.ptd_amph_id = amph_id
            LEFT JOIN $this->hr_db.hr_base_province ON latest_detail_requests.ptd_pv_id = pv_id
            LIMIT 1;";
  $query = $this->ums->query($sql, array($pt_id,$pt_id));
  // echo $this->ums->last_query(); die;
  return $query;
}

public function check_pt_id_requests_3($pt_id) {
  $sql = "SELECT latest_requests.*, latest_detail_requests.*, 
                   hr_base_person_status.psst_name, hr_base_blood.blood_name, 
                   hr_base_nation.nation_name, hr_base_religion.reli_name, 
                   hr_base_district.dist_name, hr_base_amphur.amph_name, 
                   hr_base_province.pv_name
            FROM (
                SELECT ums_patient_requests.*, ums_patient.pt_id AS ums_pt_id
                FROM $this->ums_db.ums_patient_requests 
                INNER JOIN $this->ums_db.ums_patient ON ums_patient_requests.pt_id = ums_patient.pt_id
                INNER JOIN $this->ums_db.ums_patient_detail_requests ON ums_patient_requests.id = ums_patient_detail_requests.ptd_req_id
                WHERE ums_patient_requests.pt_id = ? AND ums_patient_detail_requests.ptd_seq = '3'
                AND ums_patient_requests.pt_sta_id NOT IN ('1','6')
                ORDER BY ums_patient_requests.id DESC
                LIMIT 1
            ) AS latest_requests
            INNER JOIN (
                SELECT ums_patient_detail_requests.*
                FROM $this->ums_db.ums_patient_detail_requests
                WHERE ums_patient_detail_requests.ptd_pt_id = ? AND ums_patient_detail_requests.ptd_seq = '3'
                ORDER BY ums_patient_detail_requests.ptd_id DESC
                LIMIT 1
            ) AS latest_detail_requests ON latest_requests.id = latest_detail_requests.ptd_req_id
            LEFT JOIN $this->hr_db.hr_base_person_status ON latest_detail_requests.ptd_psst_id = psst_id
            LEFT JOIN $this->hr_db.hr_base_blood ON latest_detail_requests.ptd_blood_id = blood_id
            LEFT JOIN $this->hr_db.hr_base_nation ON latest_detail_requests.ptd_nation_id = nation_id
            LEFT JOIN $this->hr_db.hr_base_religion ON latest_detail_requests.ptd_reli_id = reli_id
            LEFT JOIN $this->hr_db.hr_base_district ON latest_detail_requests.ptd_dist_id = dist_id
            LEFT JOIN $this->hr_db.hr_base_amphur ON latest_detail_requests.ptd_amph_id = amph_id
            LEFT JOIN $this->hr_db.hr_base_province ON latest_detail_requests.ptd_pv_id = pv_id
            LIMIT 1;";
  $query = $this->ums->query($sql, array($pt_id,$pt_id));
  // echo $this->ums->last_query(); die;
  return $query;
}
  public function validate_login($username, $password) {
    $this->ums->group_start();
    $this->ums->where('pt_identification', $username);
    $this->ums->or_where('pt_passport', $username);
    $this->ums->or_where('pt_peregrine', $username);
    $this->ums->group_end();
    $query = $this->ums->get('ums_patient');
    
    if ($query->num_rows() == 1) {
        $user = $query->row();
        // ใช้ password_verify เพื่อตรวจสอบรหัสผ่าน
        if (password_verify("O]O" . $password . "O[O", $user->pt_password)) {
            return $user;
        }
        
    }
    
    return false;
  }

  public function log_login($data) {
    $this->ums->insert('ums_patient_logs_login', $data);
  }

  public function log_register($data) {
    $this->ums->insert('ums_patient_logs_register', $data);
  }

  public function patient_status() {
    $sql = "SELECT * FROM $this->ums_db.ums_patient_status  WHERE sta_ative = '1'";
    $query = $this->ums->query($sql);
    return $query;
  }

  public function base_person_status() {
    $sql = "SELECT * FROM $this->hr_db.hr_base_person_status  WHERE psst_active = '1'";
    $query = $this->hr->query($sql);
    return $query;
  }

  public function base_blood() {
    $sql = "SELECT * FROM $this->hr_db.hr_base_blood  WHERE blood_active = '1'";
    $query = $this->hr->query($sql);
    return $query;
  }
  
  public function base_nation() {
    $sql = "SELECT * FROM $this->hr_db.hr_base_nation  WHERE nation_active = '1'";
    $query = $this->hr->query($sql);
    return $query;
  }
  public function base_religion() {
    $sql = "SELECT * FROM $this->hr_db.hr_base_religion  WHERE reli_active = '1'";
    $query = $this->hr->query($sql);
    return $query;
  }


  public function verify_user_patient($id_number, $first_name, $last_name, $phone) {
    $this->ums->where('id_number', $id_number);
    $this->ums->where('first_name', $first_name);
    $this->ums->where('last_name', $last_name);
    $this->ums->where('phone', $phone);
    $query = $this->ums->get('ums_patient');
    
    return $query->num_rows() > 0;
  }

  public function get_user_pt_id($id_number, $first_name, $last_name, $phone) {
    $this->ums->select('pt_id');
    $this->ums->group_start();
    $this->ums->where('pt_identification', $id_number);
    $this->ums->or_where('pt_passport', $id_number);
    $this->ums->or_where('pt_peregrine', $id_number);
    $this->ums->group_end();
    $this->ums->where('pt_fname', $first_name);
    $this->ums->where('pt_lname', $last_name);
    $this->ums->where('pt_tel', $phone);
    $query = $this->ums->get('ums_patient');

    if ($query->num_rows() > 0) {
        return $query->row()->pt_id;
    } else {
        return false;
    }
}

  public function verify_user_birthdate($pt_id, $birth_date) {
      $this->ums->where('ptd_pt_id', $pt_id);
      $this->ums->where('ptd_birthdate', $birth_date);
      $query = $this->ums->get('ums_patient_detail');
      
      return $query->num_rows() > 0;
  }

  public function update_password($pt_id, $password , $confirm_password) {
    $data = array(
        'pt_password' => password_hash("O]O".$password."O[O", PASSWORD_BCRYPT),
        'pt_password_confirm' => password_hash("O]O".$confirm_password."O[O", PASSWORD_BCRYPT),
    );
    $this->ums->where('pt_id', $pt_id);
    $this->ums->update('ums_patient', $data);
  }

  public function get_que_appointment($pt_id){
    $sql = "SELECT * FROM que_appointment  
    LEFT JOIN $this->hr_db.hr_person ON ps_id = apm_ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
    LEFT JOIN $this->hr_db.hr_structure_detail ON stde_id = apm_stde_id
    WHERE apm_pt_id = '".$pt_id."' ORDER BY apm_date DESC, apm_time DESC";
    $query = $this->que->query($sql);
    return $query;
  }

  public function get_que_appointment_all($pt_id){
    $sql = "SELECT * FROM que_appointment  
    LEFT JOIN $this->hr_db.hr_person ON ps_id = apm_ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
        LEFT JOIN $this->hr_db.hr_structure_detail ON stde_id = apm_stde_id
    WHERE apm_pt_id = '".$pt_id."' ORDER BY apm_date DESC,apm_time DESC";
    $query = $this->que->query($sql);
    return $query;
  }

  public function get_base_disease_time($apm_id,$ds_id){
    $sql = "SELECT * FROM que_appointment  
    LEFT JOIN $this->wts_db.wts_base_disease_time ON dst_ds_id = apm_ds_id
    WHERE apm_id = '".$apm_id."' AND apm_ds_id = '".$ds_id."'";
    $query = $this->que->query($sql);
    return $query;
  }

  public function get_notification_results($pt_id,$status){ // บันทึกผลการแจ้งเตือน
    $sql = "SELECT *, CONCAT(pf_name_abbr, ps_fname,' ', ps_lname) AS full_name FROM ams_notification_results 
    LEFT JOIN $this->que_db.que_appointment ON ntr_apm_id = apm_id
    LEFT JOIN $this->hr_db.hr_person ON ps_id = ntr_ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
    WHERE ntr_pt_id = '".$pt_id."' AND ntr_ast_id IN (".$status.") ORDER BY ntr_create_date DESC LIMIT 2";
    $query = $this->ams->query($sql);
    return $query;
  }  

  public function get_notifications_department_old($apm_id){
    $sql = "SELECT * FROM $this->wts_db.wts_notifications_department 
    LEFT JOIN $this->wts_db.wts_location ON ntdp_loc_Id = loc_id
    LEFT JOIN see_eqsdb.eqs_room ON ntdp_loc_ft_Id = rm_his_id
    WHERE ntdp_apm_id = '".$apm_id."' AND ntdp_date_end IS NOT NULL ORDER BY ntdp_id DESC , ntdp_in_out DESC";
    $query = $this->db->query($sql);
    
    return $query;
  }

  public function get_notifications_department($apm_id){
    $sql = "SELECT 
                t1.ntdp_id,
                t1.ntdp_seq,
                t1.ntdp_apm_id,
                t1.ntdp_date_start,
                t1.ntdp_time_start AS original_time_start,
                IF(t1.ntdp_seq = 2, t2.ntdp_time_start, t1.ntdp_time_start) AS ntdp_time_start,
                t1.ntdp_time_finish,
                t1.ntdp_in_out,
                t1.ntdp_date_end,
                t1.ntdp_time_end,
                t1.ntdp_loc_Id,
                t1.ntdp_loc_ft_Id,
                t1.ntdp_function,
                loc.loc_name,
                room.rm_name
            FROM see_wtsdb.wts_notifications_department AS t1
            LEFT JOIN see_wtsdb.wts_notifications_department AS t2 
                ON t1.ntdp_apm_id = t2.ntdp_apm_id AND t2.ntdp_seq = 1
            LEFT JOIN see_wtsdb.wts_location AS loc 
                ON t1.ntdp_loc_Id = loc.loc_id
            LEFT JOIN see_eqsdb.eqs_room AS room 
                ON t1.ntdp_loc_ft_Id = room.rm_his_id
            WHERE t1.ntdp_apm_id = '".$apm_id."'
            AND t1.ntdp_date_end IS NOT NULL
            ORDER BY t1.ntdp_id DESC, t1.ntdp_in_out DESC";
    $query = $this->db->query($sql);
    
    return $query;
  }

  public function get_notification_results_all($pt_id, $status_ntr){ // บันทึกผลการแจ้งเตือน
    $sql = "SELECT *, CONCAT(pf_name_abbr, ps_fname,' ', ps_lname) AS full_name FROM ams_notification_results 
    LEFT JOIN $this->que_db.que_appointment ON ntr_apm_id = apm_id
    LEFT JOIN $this->hr_db.hr_person ON ps_id = ntr_ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
    WHERE ntr_pt_id = '".$pt_id."' AND ntr_ast_id = '".$status_ntr."' ORDER BY ntr_create_date DESC";
    $query = $this->ams->query($sql);
    return $query;
  }  

  public function get_ams_appointment($pt_id){ 
    $sql = "SELECT *, CONCAT(pf_name_abbr, ps_fname,' ', ps_lname) AS full_name 
    FROM ams_appointment 
    LEFT JOIN ams_notification_results ON ap_ntr_id = ntr_id
    LEFT JOIN $this->que_db.que_appointment ON ntr_apm_id = apm_id
    LEFT JOIN $this->hr_db.hr_person ON ps_id = ntr_ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
    WHERE ap_pt_id = '".$pt_id."' "; //AND ap_ast_id IN (".$status.") 
    $query = $this->ams->query($sql);
    return $query;
  }  

  public function get_ams_appointment_all($pt_id){ 
    $sql = "SELECT *, CONCAT(pf_name_abbr, ps_fname,' ', ps_lname) AS full_name 
    FROM ams_appointment 
    LEFT JOIN ams_notification_results ON ap_ntr_id = ntr_id
    LEFT JOIN $this->que_db.que_appointment ON ntr_apm_id = apm_id
    LEFT JOIN $this->hr_db.hr_person ON ps_id = ntr_ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON pf_id = ps_pf_id
    WHERE ap_pt_id = '".$pt_id."'"; // AND ap_ast_id IN (".$status.")
    $query = $this->ams->query($sql);
    return $query;
  } 

  public function get_ums_news($status_group,$status_active){
    $sql = "SELECT * FROM ums_news WHERE news_active IN (".$status_active.") AND news_bg_id LIKE '%".$status_group."%' ORDER BY news_start_date DESC";
    $query = $this->ums->query($sql);
    return $query;
  }

  public function get_ums_news_id($news_id){
    $sql = "SELECT * FROM ums_news WHERE news_id='".$news_id."' ORDER BY news_start_date DESC";
    $query = $this->ums->query($sql);
    return $query;
  }

  public function get_patient_logs_login($pt_id){
    $sql = "SELECT * FROM ums_patient_logs_login WHERE pl_pt_id = '".$pt_id."' AND pl_changed = 'เข้าสู่ระบบสำเร็จ' AND pl_active = '1' ORDER BY pl_id DESC";
    $query = $this->ums->query($sql);
    return $query;
  }

  public function update_log_status($log_id, $data) {
    $this->ums->where('pl_id', $log_id);
    return $this->ums->update('ums_patient_logs_login', $data);
  }

  public function get_que_details($ap_id){
    $sql = "SELECT * FROM $this->ums_db.ums_patient 
    LEFT JOIN $this->que_db.que_appointment ON apm_pt_id = pt_id 
    LEFT JOIN $this->que_db.que_base_status ON apm_sta_id = sta_id 
    LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id 
    LEFT JOIN $this->hr_db.hr_person_detail ON psd_ps_id = apm_ps_id
    LEFT JOIN $this->hr_db.hr_person ON psd_ps_id = ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON ps_pf_id = pf_id
    LEFT JOIN $this->hr_db.hr_person_position ON pos_ps_id = ps_id AND pos_dp_id = '1'
    WHERE apm_id = '".$ap_id."'"; // AND apm_sta_id IN (".$status_que.")
    $query = $this->db->query($sql);
    return $query;
  }

  public function get_que_details_all($ap_id){
    $sql = "SELECT * FROM $this->ums_db.ums_patient 
    LEFT JOIN $this->que_db.que_appointment ON apm_pt_id = pt_id 
    LEFT JOIN $this->que_db.que_base_status ON apm_sta_id = sta_id 
    LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id 
    LEFT JOIN $this->hr_db.hr_person_detail ON psd_ps_id = apm_ps_id
    LEFT JOIN $this->hr_db.hr_person ON psd_ps_id = ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON ps_pf_id = pf_id
    LEFT JOIN $this->hr_db.hr_person_position ON pos_ps_id = ps_id AND pos_dp_id = '1'
    WHERE apm_id = '".$ap_id."'";
    $query = $this->db->query($sql);
    return $query;
  }

  public function get_base_cancel(){
    $sql = "SELECT * FROM $this->que_db.que_base_cancel WHERE can_active = '1'";
    $query = $this->db->query($sql);
    return $query;
  }

  public function get_appointment_details($ap_id){
    $sql = "SELECT * FROM $this->ams_db.ams_appointment
    LEFT JOIN $this->ams_db.ams_notification_results ON ap_ntr_id = ntr_id
    LEFT JOIN $this->que_db.que_appointment ON ntr_apm_id = apm_id 
    LEFT JOIN $this->ums_db.ums_patient ON ap_pt_id = pt_id
    LEFT JOIN $this->ams_db.ams_base_status ON ap_ast_id = ast_id
    LEFT JOIN $this->que_db.que_base_status ON apm_sta_id = sta_id 
    LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id 
    LEFT JOIN $this->hr_db.hr_person_detail ON psd_ps_id = apm_ps_id
    LEFT JOIN $this->hr_db.hr_person ON psd_ps_id = ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON ps_pf_id = pf_id
    LEFT JOIN $this->hr_db.hr_person_position ON pos_ps_id = ps_id AND pos_dp_id = '1'
    WHERE ap_id = '".$ap_id."' "; //AND ap_ast_id IN (".$status_app.")
    $query = $this->db->query($sql);
    return $query;
  }
  
  public function get_ntr_details($ntr_id){
    $sql = "SELECT * FROM $this->ams_db.ams_notification_results
    LEFT JOIN $this->ams_db.ams_notification_upload ON ntup_ntr_id = ntr_id
    LEFT JOIN $this->ums_db.ums_patient ON ntr_pt_id = pt_id
    LEFT JOIN $this->ams_db.ams_base_status ON ntr_ast_id = ast_id
    LEFT JOIN $this->que_db.que_appointment ON ntr_apm_id = apm_id 
    LEFT JOIN $this->hr_db.hr_structure_detail ON apm_stde_id = stde_id 
    LEFT JOIN $this->hr_db.hr_person_detail ON psd_ps_id = ntr_ps_id
    LEFT JOIN $this->hr_db.hr_person ON psd_ps_id = ps_id
    LEFT JOIN $this->hr_db.hr_base_prefix ON ps_pf_id = pf_id
    LEFT JOIN $this->hr_db.hr_person_position ON pos_ps_id = ps_id AND pos_dp_id = '1'
    WHERE ntr_id = '".$ntr_id."'";
    $query = $this->db->query($sql);
    return $query;
  }

  public function get_patient($patient_id) {  
    $this->ums->from('ums_patient');
    $this->ums->where('pt_id', $patient_id);
    $query = $this->ums->get();

    if ($query->num_rows() == 1) {
        return $query->row();
    } else {
        return false;
    }
  }
  public function update_patient_requests($user_id, $data) {
    $this->ums->where('pt_id', $user_id);
    return $this->ums->update('ums_patient', $data);
  }

  public function update_patient_detail_requests($user_id, $data) {
      $this->ums->where('ptd_pt_id', $user_id);
      return $this->ums->update('ums_patient_detail', $data);
  }

  public function update_status_requests($user_id, $data) {
      $this->ums->where('pt_id', $user_id);
      return $this->ums->update('ums_patient_requests', $data);
  }
} // end class M_umusergroup
?>
