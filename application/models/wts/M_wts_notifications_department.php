<?php
/*
 *  M_wts_notifications_department
 *  Model for Manage about wts_notifications_department Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 11/07/2024
 */

include_once("Da_wts_notifications_department.php");
class M_wts_notifications_department extends Da_wts_notifications_department
{
    function get_last_ntdp_id_by_apm_id($apm_id){
        $sql =" SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_id = ( 
                    SELECT MAX(ntdp_id) 
                    FROM see_wtsdb.wts_notifications_department 
                    WHERE ntdp_apm_id = ?
      )";
      $query = $this->wts->query($sql,array($apm_id));
      return $query;
    }
    function get_ntdp_id ($apm_id){
        $sql = "SELECT ntdp_id FROM ".$this->wts_db.".wts_notifications_department 
                WHERE 
                    ntdp_apm_id = ?"; 
        $query=$this->wts->query($sql,array($apm_id));
        return $query;
    }
    public function delete_noti ($apm_id){
        $sql = "DELETE FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = ?";
        $this->wts->query($sql , $apm_id);
    }
    public function get_pt_que_by_pt_id($pt_id){
        $sql = "SELECT ntdp_id, wts_base_route_department.rdp_name, wts_base_disease.ds_name_disease_type, wts_base_disease_time.dst_name_point,  ntdp_date_start, ntdp_time_start, que_base_status.sta_name as ntdp_status, que_appointment.apm_ql_code, que_appointment.apm_pt_id, ums_patient.pt_prefix, ums_patient.pt_fname,ums_patient.pt_lname, que_appointment.apm_ps_id, hr_person.ps_pf_id, hr_person.ps_fname, hr_person.ps_lname
                FROM wts_notifications_department
                Left join see_quedb.que_appointment
                ON ntdp_apm_id = apm_id
                LEFT JOIN see_quedb.que_base_status
                ON que_appointment.apm_sta_id = sta_id
                LEFT JOIN wts_base_route_department
                ON ntdp_rdp_id = rdp_id
                Left join wts_base_disease_time
                ON ntdp_dst_id = dst_id
                LEFT JOIN wts_base_disease
                ON ntdp_ds_id = ds_id
                LEFT JOIN see_umsdb.ums_patient
                ON que_appointment.apm_pt_id = pt_id
                LEFT JOIN see_hrdb.hr_person
                ON que_appointment.apm_ps_id = ps_id
                where ums_patient.pt_id = '$pt_id'
                ORDER BY ntdp_id DESC
                LIMIT 1
        ";
        $query = $this->wts->query($sql, array($pt_id));
        return $query; // Return result as array
    }

    public function get_present_que_by_sta_id($pre_date, $stde, $ps_id, $sta_id){
        $sql = "SELECT ntdp_id, wts_base_route_department.rdp_name, wts_base_disease.ds_name_disease_type, wts_base_disease_time.dst_name_point,  ntdp_date_start, ntdp_time_start, que_base_status.sta_name as ntdp_status, que_appointment.apm_ql_code, que_appointment.apm_pt_id, ums_patient.pt_prefix, ums_patient.pt_fname,ums_patient.pt_lname, que_appointment.apm_ps_id, hr_person.ps_pf_id, hr_person.ps_fname, hr_person.ps_lname
                FROM wts_notifications_department
                Left join see_quedb.que_appointment
                ON ntdp_apm_id = apm_id
                LEFT JOIN see_quedb.que_base_status
                ON que_appointment.apm_sta_id = sta_id
                LEFT JOIN wts_base_route_department
                ON ntdp_rdp_id = rdp_id
                Left join wts_base_disease_time
                ON ntdp_dst_id = dst_id
                LEFT JOIN wts_base_disease
                ON ntdp_ds_id = ds_id
                LEFT JOIN see_umsdb.ums_patient
                ON que_appointment.apm_pt_id = pt_id
                LEFT JOIN see_hrdb.hr_person
                ON que_appointment.apm_ps_id = ps_id
                where ntdp_date_start = ?
                AND que_appointment.apm_stde_id = ?
                AND que_appointment.apm_ps_id = ?
                AND que_appointment.apm_sta_id = ?
                ORDER BY que_appointment.apm_ql_id ASC
                LIMIT 1
        ";
        $query = $this->wts->query($sql, array($pre_date, $stde, $ps_id, $sta_id));
        return $query; // Return result as array
    }

    public function get_pt_que_by_apm_ql_code($pre_date, $apm_ql_code, $stde){
        $sql = "SELECT ntdp_id, hr_structure_detail.stde_name_th, wts_base_route_department.rdp_name, wts_base_disease.ds_name_disease_type, wts_base_disease_time.dst_name_point,  ntdp_date_start, ntdp_time_start, que_base_status.sta_name as ntdp_status, que_appointment.apm_ql_code, que_appointment.apm_pt_id, ums_patient.pt_prefix, ums_patient.pt_fname,ums_patient.pt_lname, que_appointment.apm_ps_id, hr_person.ps_pf_id, hr_base_prefix.pf_name, hr_person.ps_fname, hr_person.ps_lname
                FROM wts_notifications_department
                Left join see_quedb.que_appointment
                ON ntdp_apm_id = apm_id
                LEFT JOIN see_quedb.que_base_status
                ON que_appointment.apm_sta_id = sta_id
                LEFT JOIN wts_base_route_department
                ON ntdp_rdp_id = rdp_id
                LEFT JOIN see_hrdb.hr_structure_detail
                ON rdp_stde_id = stde_id
                Left join wts_base_disease_time
                ON ntdp_dst_id = dst_id
                LEFT JOIN wts_base_disease
                ON ntdp_ds_id = ds_id
                LEFT JOIN see_umsdb.ums_patient
                ON que_appointment.apm_pt_id = pt_id
                LEFT JOIN see_hrdb.hr_person
                ON que_appointment.apm_ps_id = ps_id
                LEFT JOIN see_hrdb.hr_base_prefix
                ON ps_pf_id = pf_id
                where ntdp_date_start = '$pre_date'
                AND que_appointment.apm_ql_code = '$apm_ql_code'
                AND que_appointment.apm_stde_id = '$stde'
                ORDER BY ntdp_date_start DESC

        ";
        $query = $this->wts->query($sql, array($pre_date, $apm_ql_code, $stde));
        return $query; // Return result as array
    }

    /*
    * get_ntdp_list_btw_select_ntdp
    * get dst_minute list between pre_ntdp and pt_ntdp
    * @input present apm_cl_code, patient apm_cl_code : เลขนัดหมายปัจจุบันและเลขนัดหมายของผู้ป่วย
    * @output dst_minute between present apm_cl_code and patient apm_cl_code
    * @author Supawee Sangrapee
    * @Create Date 17/07/2024
    */  
    function get_ntdp_list_btw_select_ntdp($date, $pre_que, $pt_que) {
        $sql = "SELECT wts_notifications_department.*, wts_base_disease_time.*
                FROM wts_notifications_department
                LEFT JOIN see_quedb.que_appointment
                ON ntdp_apm_id = apm_id
                LEFT JOIN wts_base_disease_time
                ON ntdp_dst_id = dst_id
                WHERE see_quedb.que_appointment.apm_date = '$date'
                AND (see_quedb.que_appointment.apm_ql_code BETWEEN '$pre_que' AND '$pt_que')
                OR (see_quedb.que_appointment.apm_ql_code BETWEEN '$pt_que' AND '$pre_que')
                
                ";
                $query = $this->wts->query($sql, array());
                return $query; // Return result as array
    }
    
    /*
    * get_last_data_by_ntdp_apm_id
    * get notifications_department data by ntdp_apm_id
    * @input ntdp_apm_id (apm_id - que_appointment id): ไอดีข้อมูลจองคิว
    * @output notifications_department data
    * @author Areerat Pongurai
    * @Create Date 17/07/2024
    */  
    function get_last_data_by_ntdp_apm_id (){
        $sql = "SELECT * FROM ".$this->wts_db.".wts_notifications_department 
                WHERE ntdp_apm_id = ?
                ORDER BY ntdp_date_start DESC, ntdp_time_start DESC
                LIMIT 1 "; 
                //, ntdp_id DESC
        $query=$this->wts->query($sql,array($this->ntdp_apm_id));
        return $query;
    } 

    /*
    * update_finish_see_doctor
    * update notifications_department (finish date/time, status)
    * @input ntdp_apm_id (apm_id - que_appointment id): ไอดีข้อมูลจองคิว
    * @output -
    * @author Areerat Pongurai
    * @Create Date 17/07/2024
    */  
    function update_finish_see_doctor (){
        $sql = "UPDATE wts_notifications_department 
                SET ntdp_date_finish=?, ntdp_time_finish=?, ntdp_sta_id=? 
                WHERE ntdp_apm_id=? "; 
        $query=$this->wts->query($sql,array($this->ntdp_date_finish, $this->ntdp_time_finish, $this->ntdp_sta_id, $this->ntdp_apm_id));
        return $query;
    } 

    /*
    * update_finish_see_doctor_by_key
    * update notifications_department (finish date/time, status)
    * @input ntdp_id (ntdp_id - wts_notifications_department id): ไอดี
    * @output -
    * @author Areerat Pongurai
    * @Create Date 16/09/2024
    */  
    function update_finish_see_doctor_by_key (){
        $sql = "UPDATE wts_notifications_department 
                SET ntdp_date_finish=?, ntdp_time_finish=?, ntdp_sta_id=? 
                WHERE ntdp_id=? "; 
        $query=$this->wts->query($sql,array($this->ntdp_date_finish, $this->ntdp_time_finish, $this->ntdp_sta_id, $this->ntdp_id));
        return $query;
    } 

    /*
    * update_status
    * update ntdp_sta_id
    * @input 
        ntdp_sta_id: ไอดีสถานะการแจ้งเตือน
        ntdp_id: ไอดีการแจ้งเตือน
    * @output -
    * @author Areerat Pongurai
    * @Create Date 17/07/2024
    */  
    function update_status (){
        $sql = "UPDATE wts_notifications_department 
                SET ntdp_sta_id=? 
                WHERE ntdp_id=? "; 
        $query=$this->wts->query($sql,array($this->ntdp_sta_id, $this->ntdp_id));
        return $query;
    } 

    /*
    * get_all_for_alert_by_ps_id
    * get wts_notifications_departments will be alert
    * @input ps_id(hr_person id): ไอดีแพทย์
    * @output list of wts_notifications_department will be alert
    * @author Areerat Pongurai
    * @Create Date 17/07/2024
    */  
    function get_all_for_alert_by_ps_id ($ps_id){
        $sql = "SELECT ntdp.ntdp_id, ntdp.ntdp_apm_id, ntdp.ntdp_date_start, ntdp.ntdp_time_start, ntdp.ntdp_date_end, ntdp.ntdp_time_end, 
                    ntdp.ntdp_date_finish, ntdp.ntdp_time_finish, ntdp.ntdp_sta_id, ntdp.ntdp_loc_cf_Id, ntdp.ntdp_loc_Id
                FROM wts_notifications_department ntdp
                LEFT JOIN ".$this->que_db.".que_appointment apm ON apm.apm_id = ntdp.ntdp_apm_id
                WHERE (ntdp.ntdp_date_end IS NOT NULL OR ntdp.ntdp_time_end IS NOT NULL)
                    AND ntdp.ntdp_sta_id <> 4
                    AND apm.apm_ps_id = ?
                GROUP BY ntdp.ntdp_id, ntdp.ntdp_apm_id, ntdp.ntdp_date_start, ntdp.ntdp_time_start, ntdp.ntdp_date_end, ntdp.ntdp_time_end, 
                    ntdp.ntdp_date_finish, ntdp.ntdp_time_finish, ntdp.ntdp_sta_id, ntdp.ntdp_loc_cf_Id, ntdp.ntdp_loc_Id "; 
                    
                    // WHERE (ntdp.ntdp_date_end IS NOT NULL OR ntdp.ntdp_time_end IS NOT NULL)
                    // AND ntdp.ntdp_sta_id <> 4
                    // AND apm.apm_ps_id = 4
                    // AND !((ntdp.ntdp_date_finish IS NOT NULL OR ntdp.ntdp_time_finish IS NOT NULL) AND ntdp.ntdp_sta_id = 2)
        
        $query=$this->wts->query($sql,array($ps_id));
        return $query;
    }

    /*
    * update_end_date_by_doctor
    * update notifications_department (ำืก date/time, status)
    * @input ntdp_apm_id (apm_id - que_appointment id): ไอดีข้อมูลจองคิว
    * @output -
    * @author Areerat Pongurai
    * @Create Date 19/07/2024
    */
    function update_end_date_by_doctor (){
        $sql = "UPDATE wts_notifications_department 
                SET ntdp_date_end=?, ntdp_time_end=?, ntdp_sta_id=? 
                WHERE ntdp_apm_id=? "; 
        $query=$this->wts->query($sql,array($this->ntdp_date_end, $this->ntdp_time_end, $this->ntdp_sta_id, $this->ntdp_apm_id));
        return $query;
    }
}
