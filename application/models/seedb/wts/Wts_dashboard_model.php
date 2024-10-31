<?php
/*
* Que_dashboard
* Model for Manage about Que Dashboard
* @Author Patiya Peansawat
* @Create Date 09/08/2024
*/
include_once(dirname(__FILE__)."/../seedb_model.php");

class Wts_dashboard_model extends seedb_model {

    /*    
    Load database
    $this->que 
    $this->hr 
    $this->ums 
    $this->wts 

    database name
    $this->que_db 
    $this->hr_db 
    $this->ums_db
    $this->wts_db
    */
    function getWaitingPatientsByType($type = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = "") {

        $sql = "SELECT * 
                FROM {$this->que_db}.que_appointment 
                INNER JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id
                WHERE stde_is_medical = 'Y' AND stde_active  = 1 AND apm_sta_id  = 4 ";

        $params = [];

        if ($year != "") {
            $sql .= " AND YEAR(apm_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(apm_date) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(apm_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(apm_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }


        if ($type != ""){
            $sql .= " AND apm_patient_type = ? ";
            $params[] = $type;
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }


        if ($stdeId != ""){
            if ($stdeId == "NULL"){
                $sql .= " AND apm_stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }
        

        $query = $this->que->query($sql, $params);
        return $query;
    }


    function getPatientsBeingServedByType($type = "", $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = ""){

        $sql = "SELECT *
                FROM {$this->wts_db}.wts_notifications_department ntdp
                INNER JOIN (
                    SELECT ntdp_apm_id, MAX(ntdp_seq) AS max_seq
                    FROM {$this->wts_db}.wts_notifications_department
                    WHERE ntdp_in_out = '0'
                    GROUP BY ntdp_apm_id
                ) max_ntdp ON ntdp.ntdp_apm_id = max_ntdp.ntdp_apm_id AND ntdp.ntdp_seq = max_ntdp.max_seq
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
                WHERE ntdp.ntdp_in_out = '0' ";


        $params = [];
        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_start) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_start) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_start) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_start) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }


        if ($type != ""){
            $sql .= " AND apm_patient_type = ? ";
            $params[] = $type;
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }

        if ($stdeId != ""){
            if ($stdeId == "NULL"){
                $sql .= " AND apm_stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }

        $sql .= " GROUP BY ntdp.ntdp_apm_id ";
        $query = $this->wts->query($sql, $params);
        // echo $this->wts->last_query();die;
        return $query;
    }

    function getPatientsDoneByType($type = "", $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = ""){

        $sql = "SELECT *
                FROM {$this->wts_db}.wts_notifications_department ntdp
                INNER JOIN (
                    SELECT ntdp_apm_id, MAX(ntdp_seq) AS max_seq
                    FROM {$this->wts_db}.wts_notifications_department
                    WHERE ntdp_in_out = '1'
                    GROUP BY ntdp_apm_id
                ) max_ntdp ON ntdp.ntdp_apm_id = max_ntdp.ntdp_apm_id AND ntdp.ntdp_seq = max_ntdp.max_seq
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
                WHERE ntdp.ntdp_in_out = '1' ";


        $params = [];
        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_start) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_start) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_start) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_start) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }


        if ($type != ""){
            $sql .= " AND apm_patient_type = ? ";
            $params[] = $type;
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }


        if ($stdeId != ""){
            if ($stdeId == "NULL"){
                $sql .= " AND apm_stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }

        $sql .= " GROUP BY ntdp.ntdp_apm_id ";
        $query = $this->wts->query($sql, $params);
        return $query;
    }

    function getYearOfStructureByStatus($status = "") {
        
        $sql = "SELECT YEAR(stuc_confirm_date) as year
                FROM {$this->hr_db}hr_structure WHERE 1";

        $params = [];
        if ($status != ""){
            $sql .= " AND stuc_status = 1 ";
        }

        $query = $this->wts->query($sql, $params);
        return $query;
    }

    function getStructureDetaulIsMedical($depId = "", $startDate = "", $endDate = "", $year = ""){

            // คิวรี่แรก
            $sql = "
                SELECT stde_id, stde_abbr, stde_name_th
                FROM {$this->que_db}.que_appointment 
                INNER JOIN {$this->hr_db}.hr_structure_detail stde1 ON  apm_stde_id = stde1.stde_id AND  stde1.stde_active = 1 AND stde1.stde_stuc_id = 1  AND  stde1.stde_level = 4 AND stde1.stde_is_medical = 'Y' 
                WHERE stde_is_medical = 'Y' 
                AND stde_active = 1 
                AND apm_sta_id = 4 
            ";

            // เพิ่มเงื่อนไขเพิ่มเติมในคิวรีแรก
            if ($year != "") {
                $sql .= " AND YEAR(apm_date) = ?";
                $params[] = $year;
            } else {
                if ($startDate != "" && $endDate == "") {
                    $sql .= " AND DATE(apm_date) = ?";
                    $params[] = $startDate;
                } else if ($startDate == "" && $endDate != "") {
                    $sql .= " AND DATE(apm_date) <= ?";
                    $params[] = $endDate;
                } else if ($startDate != "" && $endDate != "") {
                    $sql .= " AND DATE(apm_date) BETWEEN ? AND ?";
                    $params[] = $startDate;
                    $params[] = $endDate;
                }
            }



            if ($depId != "") {
                $sql .= " AND apm_dp_id = ? ";
                $params[] = $depId;
            }

            $sql .= " GROUP BY apm_stde_id";

            // คิวรี่ที่สอง
            $sql .= "
                UNION
                SELECT stde_id, stde_abbr, stde_name_th
                FROM {$this->wts_db}.wts_notifications_department ntdp
                INNER JOIN (
                    SELECT ntdp_apm_id, MAX(ntdp_seq) AS max_seq
                    FROM {$this->wts_db}.wts_notifications_department
                    WHERE ntdp_in_out = '0'
                    GROUP BY ntdp_apm_id
                ) max_ntdp ON ntdp.ntdp_apm_id = max_ntdp.ntdp_apm_id 
                AND ntdp.ntdp_seq = max_ntdp.max_seq
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
                INNER JOIN {$this->hr_db}.hr_structure_detail stde2 ON  apm_stde_id = stde2.stde_id AND  stde2.stde_active = 1 AND stde2.stde_stuc_id = 1  AND  stde2.stde_level = 4 AND stde2.stde_is_medical = 'Y' 
                WHERE ntdp.ntdp_in_out = '0'
            ";

            // เพิ่มเงื่อนไขเพิ่มเติมในคิวรีที่สอง
            if ($year != "") {
                $sql .= " AND YEAR(ntdp_date_start) = ?";
                $params[] = $year;
            } else {
                if ($startDate != "" && $endDate == "") {
                    $sql .= " AND DATE(ntdp_date_start) = ?";
                    $params[] = $startDate;
                } else if ($startDate == "" && $endDate != "") {
                    $sql .= " AND DATE(ntdp_date_start) <= ?";
                    $params[] = $endDate;
                } else if ($startDate != "" && $endDate != "") {
                    $sql .= " AND DATE(ntdp_date_start) BETWEEN ? AND ?";
                    $params[] = $startDate;
                    $params[] = $endDate;
                }
            }



            if ($depId != "") {
                $sql .= " AND apm_dp_id = ? ";
                $params[] = $depId;
            }

            $sql .= " GROUP BY apm_stde_id";

            // คิวรี่ที่สาม
            $sql .= "
                UNION
                SELECT stde_id, stde_abbr, stde_name_th
                FROM {$this->wts_db}.wts_notifications_department ntdp
                INNER JOIN (
                    SELECT ntdp_apm_id, MAX(ntdp_seq) AS max_seq
                    FROM {$this->wts_db}.wts_notifications_department
                    WHERE ntdp_in_out = '1'
                    GROUP BY ntdp_apm_id
                ) max_ntdp ON ntdp.ntdp_apm_id = max_ntdp.ntdp_apm_id 
                AND ntdp.ntdp_seq = max_ntdp.max_seq
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
                INNER JOIN {$this->hr_db}.hr_structure_detail stde3 ON  apm_stde_id = stde3.stde_id AND  stde3.stde_active = 1 AND stde3.stde_stuc_id = 1  AND  stde3.stde_level = 4 AND stde3.stde_is_medical = 'Y' 
                WHERE ntdp.ntdp_in_out = '1'
            ";

            // เพิ่มเงื่อนไขเพิ่มเติมในคิวรีที่สาม
            if ($year != "") {
                $sql .= " AND YEAR(ntdp_date_start) = ?";
                $params[] = $year;
            } else {
                if ($startDate != "" && $endDate == "") {
                    $sql .= " AND DATE(ntdp_date_start) = ?";
                    $params[] = $startDate;
                } else if ($startDate == "" && $endDate != "") {
                    $sql .= " AND DATE(ntdp_date_start) <= ?";
                    $params[] = $endDate;
                } else if ($startDate != "" && $endDate != "") {
                    $sql .= " AND DATE(ntdp_date_start) BETWEEN ? AND ?";
                    $params[] = $startDate;
                    $params[] = $endDate;
                }
            }



            if ($depId != "") {
                $sql .= " AND apm_dp_id = ? ";
                $params[] = $depId;
            }

            $sql .= " GROUP BY apm_stde_id";
            $query = $this->wts->query($sql, $params);
            return $query;

    }
}?>
