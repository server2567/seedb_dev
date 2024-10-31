<?php
/*
 *  M_ams_base_alarm
 *  Model for Manage about ams_base_alarm Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 19/06/2024
 */

include_once("Da_ams_appointment.php");
class M_ams_appointment extends Da_ams_appointment
{
    function get_nonti_patient_by_doctor_id($data, $ast_id)
    {
        $sql = "SELECT * FROM " . $this->ams_db . ".ams_appointment as ap
        LEFT JOIN (
            SELECT pt_id, pt_member, pt_prefix, pt_fname, pt_lname 
            FROM " . $this->ums_db . ".ums_patient
        ) AS patient_data ON ap.ap_pt_id = patient_data.pt_id
        LEFT JOIN (
            SELECT ntr_id, ntr_ntf_id, ntr_ps_id, ntr_apm_id 
            FROM " . $this->ams_db . ".ams_notification_results
        ) AS ntr ON ntr.ntr_id = ap.ap_ntr_id
        LEFT JOIN (
            SELECT ntf_id, ntf_name, ntf_name_en 
            FROM " . $this->ams_db . ".ams_base_notify
        ) AS ntf ON ntr.ntr_ntf_id = ntf.ntf_id
          LEFT JOIN (
            SELECT al_id, al_ntf_id, al_day 
            FROM " . $this->ams_db . ".ams_base_alarm
        ) AS al ON al.al_ntf_id = ntf.ntf_id
        LEFT JOIN (
            SELECT ntl_seq, ntl_ap_id, ntl_date_appointment, ntl_time_appointment
            FROM " . $this->ams_db . ".ams_notification_log
        ) AS ntl ON ntl.ntl_ap_id = ap.ap_id 
        LEFT JOIN (
            SELECT apm_id, apm_stde_id
            FROM " . $this->que_db . ".que_appointment
        ) AS qe ON qe.apm_id = ntr.ntr_apm_id
        WHERE " . (
            $data == null || !isset($data['stde_id']) || $data['stde_id'] == 'all' ? '' : "qe.apm_stde_id = " . $data['stde_id'] . " AND "
        ) . (
            $data != null ?
            'ap.ap_ast_id = ' . $data['appoint_status']
            : ($ast_id <= 2 ?
                'ap.ap_ast_id <= ' . $ast_id :
                'ap.ap_ast_id = ' . $ast_id
            )
        ) . (isset($data['start_date']) && $data['start_date'] != '' ? ' AND ap.ap_date >= ' . "'" . $data['start_date'] . "'"  : '')
            . (isset($data['end_date']) && $data['end_date'] != '' ? ' AND ap.ap_date <= ' . "'" . $data['end_date'] . "'" : '');
        $query = $this->ams->query($sql);
        return $query;
    }
    function get_stde_id()
    {
        $dp_id = $this->session->userdata('us_dp_id');
        $status = '1';
        $sql = "SELECT stde_id,stde_name_th FROM " . $this->hr_db . ".hr_structure_detail as stde
        INNER JOIN (SELECT apm_id,apm_stde_id FROM ".$this->que_db.".que_appointment) as apm on apm.apm_stde_id = stde.stde_id
        INNER JOIN (SELECT ntr_id,ntr_apm_id FROM ".$this->ams_db.".ams_notification_results) as ntr on ntr.ntr_apm_id = apm.apm_id
        INNER JOIN (SELECT ap_id,ap_ntr_id FROM ".$this->ams_db. ".ams_appointment) as ap on ap.ap_ntr_id = ntr.ntr_id
        INNER JOIN (SELECT stdp_id, stdp_stde_id, stdp_ps_id, stdp_active FROM " . $this->hr_db . ".hr_structure_person) as stdp on stde.stde_id = stdp.stdp_stde_id
        INNER JOIN (SELECT stuc_id, stuc_dp_id, stuc_status FROM " . $this->hr_db . ".hr_structure) as stuc on stuc.stuc_id = stde.stde_stuc_id AND stdp.stdp_active = '$status'
        WHERE stuc.stuc_dp_id = '$dp_id' AND stuc.stuc_status = '$status' GROUP BY stde_id";
       
        $query = $this->ams->query($sql);
        return $query;
    }
    /*
     * get_email_patient
     * Retrieve patient information for sending email BY Cron_job
     * 
     * @param int $hn_id - Patient ID
     * @param int $ap_id - Appointment ID
     * @return object - Patient data containing email and appointment details
     * 
     * @author JIRADAT POMYAI
     * @created 24/07/2024
     */
    function get_email_patient($Cron_job, $ap_id = null,$hn_id = null,$ast_id = ['1','6'])
    {
        if ($Cron_job == true) {
            $where = "WHERE DATE(ap.ap_rp_date) = CURDATE() AND ap.ap_ast_id = '$ast_id[0]'";
        } else {
            if ($hn_id != null) {
                $where = "WHERE upt.pt_member = ".$hn_id." AND ap.ap_id = ".$ap_id;
            } else {
                $where = "WHERE ap.ap_id = '$ap_id'";
            }
        }
        $sql = "SELECT upt.pt_id,upt.pt_email,upt.pt_member,dp.dp_name_th,qe.apm_cl_code,ap.ap_detail_appointment,ap.ap_id,ap.ap_detail_prepare,ap.ap_date,ap.ap_time,stde.stde_name_th,ap_before_time,CONCAT(pf.pf_name_abbr, ' ', ps.ps_fname, ' ', ps.ps_lname) as doctor_name FROM " . $this->ums_db . ".ums_patient as upt
        LEFT JOIN " . $this->ams_db . ".ams_appointment AS ap ON ap.ap_pt_id = upt.pt_id
        LEFT JOIN " . $this->ams_db . ".ams_notification_results AS ntr ON ntr.ntr_id = ap.ap_ntr_id
        LEFT JOIN " . $this->que_db . ".que_appointment AS qe ON qe.apm_id = ntr.ntr_apm_id
        LEFT JOIN ".$this->hr_db.".hr_person as ps ON ps.ps_id = ntr.ntr_ps_id
        LEFT JOIN ".$this->hr_db.".hr_base_prefix as pf on pf.pf_id = ps.ps_pf_id 
        LEFT JOIN ".$this->hr_db.".hr_structure_detail as stde on stde.stde_id = qe.apm_stde_id
        LEFT JOIN " . $this->ums_db . ".ums_department AS dp ON dp.dp_id = qe.apm_dp_id " . $where ;
        $query = $this->ams->query($sql);
        return $query;
    }

    /*
	* get_by_ntr_id
	* get ams_appointment data by ntr (not get which ap_ast_id != 9 cancel)
	* @input ntr(notifications_result id): id of notifications_result
	* @output ams_appointment data
	* @author Areerat Pongurai
	* @Create Date 23/07/2024f
	*/
    function get_by_ntr_id()
    {
        $sql = "SELECT * FROM ams_appointment WHERE ap_ntr_id=? AND ap_ast_id<>9 ";
        $query = $this->ams->query($sql, array($this->ap_ntr_id));
        return $query;
    }
}
