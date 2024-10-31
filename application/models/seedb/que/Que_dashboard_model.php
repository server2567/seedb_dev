<?php
/*
* Que_dashboard
* Model for Manage about Que Dashboard
* @Author Patiya Peansawat
* @Create Date 09/08/2024
*/
include_once(dirname(__FILE__)."/../seedb_model.php");

class Que_dashboard_model extends seedb_model {
    public function get_last_activity($limit){
        $sql = "SELECT see_wtsdb.wts_notifications_department.*,
		            que_appointment.apm_id,
                    CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                    wts_location.loc_name 
                FROM wts_notifications_department
                LEFT JOIN see_quedb.que_appointment ON ntdp_apm_id = apm_id
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id
                LEFT JOIN see_wtsdb.wts_location ON see_wtsdb.wts_location.loc_id = wts_notifications_department.ntdp_loc_Id
                WHERE ntdp_date_start = CURDATE()  
                ORDER BY ntdp_id DESC
                LIMIT ? ";
        $query = $this->wts->query($sql,array($limit));
        return $query;
    }
    public function count_all_que($apm_app_walk = null,$apm_patient_type = null){
        $sql = "SELECT count(*) as total
                FROM see_quedb.que_appointment 
                WHERE  apm_date = CURDATE() ";
            $params = [];
    
            // Add additional condition if $apm_app_walk is provided
            if (!is_null($apm_app_walk)) {
                $sql .= " AND apm_app_walk = ?";
                $params[] = $apm_app_walk; // Add the parameter to the array
            }
            
            // Add additional condition if $apm_patient_type is provided
            if (!is_null($apm_patient_type)) {
                $sql .= " AND apm_patient_type = ?";
                $params[] = $apm_patient_type; // Add the parameter to the array
            }
            
            // Execute the query with the dynamic parameters
            $query = $this->que->query($sql, $params);
        return $query;
    }
}?>
