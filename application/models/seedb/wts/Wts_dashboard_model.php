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
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                WHERE  apm_sta_id  = 4 ";

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
                $sql .= " AND stde_id IS NULL ";
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
                INNER JOIN {$this->ums_db}.ums_patient ON apm_pt_id = pt_id
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
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
                $sql .= " AND stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }

        $sql .= " GROUP BY ntdp.ntdp_apm_id ";
        $query = $this->wts->query($sql, $params);
    
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
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id AND stde_is_medical = 'Y' AND stde_active  = 1
                WHERE ntdp.ntdp_in_out = '1' ";


        $params = [];
        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
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
                $sql .= " AND stde_id IS NULL ";
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
                INNER JOIN {$this->hr_db}.hr_structure_detail stde1 ON  apm_stde_id = stde1.stde_id 
                WHERE 1
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
                INNER JOIN {$this->hr_db}.hr_structure_detail stde2 ON  apm_stde_id = stde2.stde_id
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
                INNER JOIN {$this->hr_db}.hr_structure_detail stde3 ON  apm_stde_id = stde3.stde_id 
                WHERE ntdp.ntdp_in_out = '1'
            ";

            // เพิ่มเงื่อนไขเพิ่มเติมในคิวรีที่สาม
            if ($year != "") {
                $sql .= " AND YEAR(ntdp_date_finish) = ?";
                $params[] = $year;
            } else {
                if ($startDate != "" && $endDate == "") {
                    $sql .= " AND DATE(ntdp_date_finish) = ?";
                    $params[] = $startDate;
                } else if ($startDate == "" && $endDate != "") {
                    $sql .= " AND DATE(ntdp_date_finish) <= ?";
                    $params[] = $endDate;
                } else if ($startDate != "" && $endDate != "") {
                    $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
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


    function getTotalWaitingPatientsRecords($selectedLetters = [], $type = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = "") {

        $sql = "SELECT COUNT(DISTINCT apm_id) as total
                FROM {$this->que_db}.que_appointment 
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id 
                INNER JOIN {$this->ums_db}.ums_patient ON apm_pt_id = pt_id
                WHERE   apm_sta_id  = 4 ";

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
                $sql .= " AND stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }


        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }
        

        $query = $this->que->query($sql, $params);
        // echo $this->que->last_query();die;
        return $query->row()->total;
    }


    function getWaitingPatientsDetail($searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters = [], $type = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = "") {


        $orderColumn = $orderColumn === 'pt_fname' ? 'CONVERT(pt_fname USING tis620)' :
                    ($orderColumn === 'pt_lname' ? 'CONVERT(pt_lname USING tis620)' : $orderColumn);

        $sql = "SELECT
            pt_id,
            ps_id, 
            pf_name,
            ps_fname,
            ps_lname,
            pt_member,
            pt_fname,
            pt_lname,
            pt_identification,
            stde_name_th,
            apm_id,
            apm_visit,
            apm_ql_code,
            apm_date,
            apm_time, 
            apm_app_walk,
            apm_patient_type,
            pt_prefix,
            stde_abbr,
            stde_id,
                CASE 
                    WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า'
                    WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่'
                    ELSE ''
                END as type_name,
                CASE 
                    WHEN apm_app_walk = 'A' THEN 'นัดหมาย'
                    WHEN apm_app_walk = 'W' THEN 'Walk-In'
                    ELSE ''
                END as type_walk
                FROM {$this->que_db}.que_appointment 
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                INNER JOIN {$this->ums_db}.ums_patient ON apm_pt_id = pt_id
                LEFT JOIN  {$this->hr_db}.hr_person ON apm_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                WHERE   apm_sta_id  = 4 ";

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
                $sql .= " AND stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }


        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        if ($searchValue) {
            $escapedSearchValue = $this->db->escape_like_str($searchValue);
            
            $sql .= " AND (
                pt_member LIKE '%" . $escapedSearchValue . "%'
                OR pt_lname LIKE '%" . $escapedSearchValue . "%'
                OR pt_identification LIKE '%" . $escapedSearchValue . "%'
                OR pt_fname LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR apm_visit LIKE '%" . $escapedSearchValue . "%'
                OR apm_ql_code LIKE '%" . $escapedSearchValue . "%'
                OR apm_date LIKE '%" . $escapedSearchValue . "%'
                OR apm_time LIKE '%" . $escapedSearchValue . "%'
                OR ps_fname LIKE '%" . $escapedSearchValue . "%'
                OR ps_lname LIKE '%" . $escapedSearchValue . "%'
                OR stde_abbr LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR (
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า' 
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
                OR (
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย' 
                        WHEN apm_app_walk = 'W' THEN 'Walk-In' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
            )";
        }


        $sql .= " ORDER BY $orderColumn $orderDirection
                LIMIT $start, $length";

        $query = $this->que->query($sql, $params);
        return $query;
    }


    function getTotalBeingServedRecords($selectedLetters = [], $type = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = "") {
        
        $sql = "SELECT COUNT(DISTINCT sub.ntdp_apm_id) as total 
                FROM (
                SELECT ntdp.ntdp_apm_id
                FROM {$this->wts_db}.wts_notifications_department ntdp
                INNER JOIN (
                    SELECT ntdp_apm_id, MAX(ntdp_seq) AS max_seq
                    FROM {$this->wts_db}.wts_notifications_department
                    WHERE ntdp_in_out = '0'
                    GROUP BY ntdp_apm_id
                ) max_ntdp ON ntdp.ntdp_apm_id = max_ntdp.ntdp_apm_id AND ntdp.ntdp_seq = max_ntdp.max_seq
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                INNER JOIN {$this->ums_db}.ums_patient ON apm_pt_id = pt_id
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
                $sql .= " AND stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        $sql .= " GROUP BY ntdp.ntdp_apm_id ) sub";

        $query = $this->que->query($sql, $params);
        return $query->row()->total;
    }



    function getBeingServedDetail($searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters = [], $type = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = "") {


        $orderColumn = $orderColumn === 'pt_fname' ? 'CONVERT(pt_fname USING tis620)' :
                    ($orderColumn === 'pt_lname' ? 'CONVERT(pt_lname USING tis620)' : $orderColumn);

        $sql = "SELECT * FROM (
                SELECT 
                    pt_id,
                    ps_id, 
                    pf_name,
                    ps_fname,
                    ps_lname,
                    pt_member,
                    pt_fname,
                    pt_lname,
                    pt_identification,
                    stde_name_th,
                    apm_visit,
                    apm_ql_code,
                    apm_date,
                    apm_time, 
                    apm_app_walk,
                    apm_patient_type,
                    pt_prefix,
                    stde_abbr,
                    stde_id,
                    ntdp_date_start,
                    ntdp_time_start,
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า'
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่'
                        ELSE ''
                    END as type_name,
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย'
                        WHEN apm_app_walk = 'W' THEN 'Walk-In'
                        ELSE ''
                    END as type_walk
                FROM {$this->wts_db}.wts_notifications_department ntdp
                INNER JOIN (
                    SELECT ntdp_apm_id, MAX(ntdp_seq) AS max_seq
                    FROM {$this->wts_db}.wts_notifications_department
                    WHERE ntdp_in_out = '0'
                    GROUP BY ntdp_apm_id
                ) max_ntdp ON ntdp.ntdp_apm_id = max_ntdp.ntdp_apm_id AND ntdp.ntdp_seq = max_ntdp.max_seq
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                INNER JOIN {$this->ums_db}.ums_patient ON apm_pt_id = pt_id
                LEFT JOIN  {$this->hr_db}.hr_person ON apm_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                WHERE ntdp.ntdp_in_out = '0'  ";

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
                $sql .= " AND stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        if ($searchValue) {
            $escapedSearchValue = $this->db->escape_like_str($searchValue);
            
            $sql .= " AND (
                pt_member LIKE '%" . $escapedSearchValue . "%'
                OR pt_lname LIKE '%" . $escapedSearchValue . "%'
                OR pt_identification LIKE '%" . $escapedSearchValue . "%'
                OR pt_fname LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR apm_visit LIKE '%" . $escapedSearchValue . "%'
                OR apm_ql_code LIKE '%" . $escapedSearchValue . "%'
                OR apm_date LIKE '%" . $escapedSearchValue . "%'
                OR apm_time LIKE '%" . $escapedSearchValue . "%'
                OR ps_fname LIKE '%" . $escapedSearchValue . "%'
                OR ps_lname LIKE '%" . $escapedSearchValue . "%'
                OR stde_abbr LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR (
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า' 
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
                OR (
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย' 
                        WHEN apm_app_walk = 'W' THEN 'Walk-In' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
            )";
        }

        $sql .= " GROUP BY ntdp.ntdp_apm_id ) sub";
        $sql .= " ORDER BY $orderColumn $orderDirection
                LIMIT $start, $length";
        
        $query = $this->que->query($sql, $params);
        return $query;
    }


    function getTotalPatientsDoneRecords($selectedLetters = [] , $type = "", $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = "" ) {
        $sql = "SELECT COUNT(DISTINCT ntdp.ntdp_apm_id) as total
            FROM {$this->wts_db}.wts_notifications_department ntdp
            INNER JOIN (
                SELECT ntdp_apm_id, MAX(ntdp_seq) AS max_seq
                FROM {$this->wts_db}.wts_notifications_department
                WHERE ntdp_in_out = '1'
                GROUP BY ntdp_apm_id
            ) max_ntdp ON ntdp.ntdp_apm_id = max_ntdp.ntdp_apm_id AND ntdp.ntdp_seq = max_ntdp.max_seq
            INNER JOIN {$this->que_db}.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
            LEFT JOIN {$this->ums_db}.ums_patient pt ON apm_pt_id = pt_id
            LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
            WHERE ntdp.ntdp_in_out = '1' ";


        $params = [];
        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
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
                $sql .= " AND stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }


    
        $query = $this->wts->query($sql, $params);
        return $query->row()->total;
    }

    function getPatientsDonDetail($searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters = [], $type = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $stdeId = "") {

        $orderColumn = $orderColumn === 'pt_fname' ? 'CONVERT(pt_fname USING tis620)' :
        ($orderColumn === 'pt_lname' ? 'CONVERT(pt_lname USING tis620)' : $orderColumn);

        $sql = "SELECT 
                    pt_id,
                    ps_id, 
                    pf_name,
                    ps_fname,
                    ps_lname,
                    pt_member,
                    pt_fname,
                    pt_lname,
                    pt_identification,
                    stde_name_th,
                    apm_visit,
                    apm_ql_code,
                    apm_date,
                    apm_time, 
                    apm_app_walk,
                    apm_patient_type,
                    pt_prefix,
                    stde_abbr,
                    stde_id,
                    ntdp_date_start,
                    ntdp_time_start,
                    ntdp_date_finish,
                    ntdp_time_finish,
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า'
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่'
                        ELSE ''
                    END as type_name,
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย'
                        WHEN apm_app_walk = 'W' THEN 'Walk-In'
                        ELSE ''
                    END as type_walk
            FROM {$this->wts_db}.wts_notifications_department ntdp
            INNER JOIN (
                SELECT ntdp_apm_id, MAX(ntdp_seq) AS max_seq
                FROM {$this->wts_db}.wts_notifications_department
                WHERE ntdp_in_out = '1'
                GROUP BY ntdp_apm_id
            ) max_ntdp ON ntdp.ntdp_apm_id = max_ntdp.ntdp_apm_id AND ntdp.ntdp_seq = max_ntdp.max_seq
            INNER JOIN {$this->que_db}.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
            LEFT JOIN {$this->ums_db}.ums_patient pt ON apm_pt_id = pt_id
            LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
            LEFT JOIN  {$this->hr_db}.hr_person ON apm_ps_id = ps_id
            LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
            WHERE ntdp.ntdp_in_out = '1' ";


        $params = [];
        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
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
                $sql .= " AND stde_id IS NULL ";
            }else{

                $sql .= " AND apm_stde_id = ? ";
                $params[] = $stdeId;
            }
        }

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

            if ($searchValue) {
            $escapedSearchValue = $this->db->escape_like_str($searchValue);
            
            $sql .= " AND (
                pt_member LIKE '%" . $escapedSearchValue . "%'
                OR pt_lname LIKE '%" . $escapedSearchValue . "%'
                OR pt_identification LIKE '%" . $escapedSearchValue . "%'
                OR pt_fname LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR apm_visit LIKE '%" . $escapedSearchValue . "%'
                OR apm_ql_code LIKE '%" . $escapedSearchValue . "%'
                OR apm_date LIKE '%" . $escapedSearchValue . "%'
                OR apm_time LIKE '%" . $escapedSearchValue . "%'
                OR ps_fname LIKE '%" . $escapedSearchValue . "%'
                OR ps_lname LIKE '%" . $escapedSearchValue . "%'
                OR stde_abbr LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR (
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า' 
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
                OR (
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย' 
                        WHEN apm_app_walk = 'W' THEN 'Walk-In' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
            )";
        }


        $sql .= " GROUP BY ntdp.ntdp_apm_id  ORDER BY $orderColumn $orderDirection
                LIMIT $start, $length";

        $query = $this->wts->query($sql, $params);
        return $query;

    }

    function getWtsLocation() {

        $sql = "SELECT * FROM wts_location ORDER BY loc_seq ASC ";
        $query = $this->wts->query($sql);
        return $query;
    }



    function getCountPatientService( $depId = "", $startDate = "", $endDate = "", $year = "" , $loc_id = "" ,$overTimeStatus = ""){
        
        // -- กรณีที่ date และ time ไม่เป็น NULL ทั้งหมด
        // -- กรณี ntdp_time_end เป็น NULL แต่ ntdp_time_finish ไม่เป็น NULL
        // -- กรณี ntdp_time_finish เป็น NULL แต่ ntdp_time_end ไม่เป็น NULL
        $cond = "";
        if ($overTimeStatus == "O") { //เกินเวลา
            $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )";
        }else if($overTimeStatus == "N"){ //ไม่เกิน
                    $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    "; 
        }

        $sql = "SELECT * 
                FROM wts_notifications_department
                INNER JOIN {$this->que_db}.que_appointment ON ntdp_apm_id = apm_id
                INNER JOIN wts_location ON ntdp_loc_Id = loc_id
                WHERE (1 $cond)";

        
        $params = [];
        if ($loc_id != ""){
            $sql .= " AND ntdp_loc_Id = ? ";
            $params[] = $loc_id;
        }

        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }


        $query = $this->wts->query($sql, $params);
        return $query;
    }


    function getTotalPatientServiceTimeRecords($selectedLetters = [], $overTimeStatus = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $loc_id = "") {
        // -- กรณีที่ date และ time ไม่เป็น NULL ทั้งหมด
        // -- กรณี ntdp_time_end เป็น NULL แต่ ntdp_time_finish ไม่เป็น NULL
        // -- กรณี ntdp_time_finish เป็น NULL แต่ ntdp_time_end ไม่เป็น NULL
        $cond = "";
        if ($overTimeStatus == "O") { //เกินเวลา
            $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )";
        }else if($overTimeStatus == "N"){ //ไม่เกิน
                    $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    "; 
        }

        $sql = "SELECT COUNT(DISTINCT ntdp_id) as total
                FROM wts_notifications_department
                INNER JOIN {$this->que_db}.que_appointment ON ntdp_apm_id = apm_id
                INNER JOIN wts_location ON ntdp_loc_Id = loc_id
                LEFT JOIN {$this->ums_db}.ums_patient pt ON apm_pt_id = pt_id
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                LEFT JOIN  {$this->hr_db}.hr_person ON apm_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                WHERE (1 $cond)";

        
        $params = [];
        if ($loc_id != ""){
            $sql .= " AND ntdp_loc_Id = ? ";
            $params[] = $loc_id;
        }

        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }


        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }


        $query = $this->wts->query($sql, $params);
        return $query->row()->total;
    }

    function getPatientServiceTimeDetail($searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters = [], $overTimeStatus = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $loc_id = "") {


        $orderColumn = $orderColumn === 'pt_fname' ? 'CONVERT(pt_fname USING tis620)' :
        ($orderColumn === 'pt_lname' ? 'CONVERT(pt_lname USING tis620)' : $orderColumn);
        

                $cond = "";
        if ($overTimeStatus == "O") { //เกินเวลา
            $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )";
        }else if($overTimeStatus == "N"){ //ไม่เกิน
                    $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    "; 
        }

        $sql = "SELECT 
                  pt_id,
                    ps_id, 
                    pf_name,
                    ps_fname,
                    ps_lname,
                    pt_member,
                    pt_fname,
                    pt_lname,
                    pt_identification,
                    stde_name_th,
                    apm_visit,
                    apm_ql_code,
                    apm_date,
                    apm_time, 
                    apm_app_walk,
                    apm_patient_type,
                    pt_prefix,
                    stde_abbr,
                    stde_id,
                    ntdp_date_start,
                    ntdp_time_start,
                    ntdp_date_end,
                    ntdp_time_end,
                    ntdp_date_finish,
                    ntdp_time_finish,
                    loc_name,
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า'
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่'
                        ELSE ''
                    END as type_name,
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย'
                        WHEN apm_app_walk = 'W' THEN 'Walk-In'
                        ELSE ''
                    END as type_walk
                FROM wts_notifications_department ntdp
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp_apm_id = apm_id
                INNER JOIN wts_location ON ntdp_loc_Id = loc_id
                LEFT JOIN {$this->ums_db}.ums_patient pt ON apm_pt_id = pt_id
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                LEFT JOIN  {$this->hr_db}.hr_person ON apm_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                WHERE (1 $cond)";


        $params = [];
        if ($loc_id != ""){
            $sql .= " AND ntdp_loc_Id = ? ";
            $params[] = $loc_id;
        }

        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }


        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }


            if ($searchValue) {
            $escapedSearchValue = $this->db->escape_like_str($searchValue);
            
            $sql .= " AND (
                pt_member LIKE '%" . $escapedSearchValue . "%'
                OR pt_lname LIKE '%" . $escapedSearchValue . "%'
                OR pt_identification LIKE '%" . $escapedSearchValue . "%'
                OR pt_fname LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR apm_visit LIKE '%" . $escapedSearchValue . "%'
                OR apm_ql_code LIKE '%" . $escapedSearchValue . "%'
                OR apm_date LIKE '%" . $escapedSearchValue . "%'
                OR apm_time LIKE '%" . $escapedSearchValue . "%'
                OR ps_fname LIKE '%" . $escapedSearchValue . "%'
                OR ps_lname LIKE '%" . $escapedSearchValue . "%'
                OR stde_abbr LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR loc_name LIKE '%" . $escapedSearchValue . "%'
                OR (
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า' 
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
                OR (
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย' 
                        WHEN apm_app_walk = 'W' THEN 'Walk-In' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
            )";
        }


        $sql .= "  ORDER BY $orderColumn $orderDirection
                LIMIT $start, $length";

        $query = $this->wts->query($sql, $params);
        // echo $this->wts->last_query();die;
        return $query;


    }

    function getDoctorWtsLocationByid($depId = "" , $startDate = "" , $endDate = "" , $year = "" , $loc_id = "") {
        
        $sql = "SELECT *
                FROM wts_notifications_department ntdp
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp_apm_id = apm_id
                INNER JOIN wts_location ON ntdp_loc_Id = loc_id
                LEFT JOIN {$this->ums_db}.ums_patient pt ON apm_pt_id = pt_id
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                LEFT JOIN  {$this->hr_db}.hr_person  ps ON apm_ps_id = ps_id
                LEFT JOIN  {$this->hr_db}.hr_person_detail  psd ON psd_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix pf ON ps_pf_id = pf_id
                WHERE 1 ";

        $params = [];
        if ($loc_id != ""){
            $sql .= " AND ntdp_loc_Id = ? ";
            $params[] = $loc_id;
        }

        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }

        $sql .= "  GROUP BY ps_id ";
        $query = $this->wts->query($sql, $params);
        return $query;
    }



    function getCountPatientServiceByDoctor( $depId = "", $startDate = "", $endDate = "", $year = "" , $ps_id = "" , $loc_id = "" ,$overTimeStatus = ""){
        
        // -- กรณีที่ date และ time ไม่เป็น NULL ทั้งหมด
        // -- กรณี ntdp_time_end เป็น NULL แต่ ntdp_time_finish ไม่เป็น NULL
        // -- กรณี ntdp_time_finish เป็น NULL แต่ ntdp_time_end ไม่เป็น NULL
        $cond = "";
        if ($overTimeStatus == "O") { //เกินเวลา
            $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )";
        }else if($overTimeStatus == "N"){ //ไม่เกิน
                    $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    "; 
        }

        $sql = "SELECT * 
                FROM wts_notifications_department
                INNER JOIN {$this->que_db}.que_appointment ON ntdp_apm_id = apm_id
                INNER JOIN wts_location ON ntdp_loc_Id = loc_id
                WHERE (1 $cond)";

        
        $params = [];
        if ($loc_id != ""){
            $sql .= " AND ntdp_loc_Id = ? ";
            $params[] = $loc_id;
        }

        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }


        if ($ps_id != "") {
            $sql .= " AND apm_ps_id = ? ";
            $params[] = $ps_id;
        }

        $query = $this->wts->query($sql, $params);
        return $query;
    }




    function getTotalPatientServiceTimeByDoctorRecords($selectedLetters = [], $overTimeStatus = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $loc_id = "", $ps_id = "") {
        // -- กรณีที่ date และ time ไม่เป็น NULL ทั้งหมด
        // -- กรณี ntdp_time_end เป็น NULL แต่ ntdp_time_finish ไม่เป็น NULL,
        // -- กรณี ntdp_time_finish เป็น NULL แต่ ntdp_time_end ไม่เป็น NULL
        $cond = "";
        if ($overTimeStatus == "O") { //เกินเวลา
            $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )";
        }else if($overTimeStatus == "N"){ //ไม่เกิน
                    $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    "; 
        }

        $sql = "SELECT COUNT(DISTINCT ntdp_id) as total
                FROM wts_notifications_department
                INNER JOIN {$this->que_db}.que_appointment ON ntdp_apm_id = apm_id
                INNER JOIN wts_location ON ntdp_loc_Id = loc_id
                LEFT JOIN {$this->ums_db}.ums_patient pt ON apm_pt_id = pt_id
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                LEFT JOIN  {$this->hr_db}.hr_person ON apm_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                WHERE (1 $cond)";

        
        $params = [];
        if ($loc_id != ""){
            $sql .= " AND ntdp_loc_Id = ? ";
            $params[] = $loc_id;
        }

        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }

        if ($ps_id != "") {
            $sql .= " AND apm_ps_id = ? ";
            $params[] = $ps_id;
        }


        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }


        $query = $this->wts->query($sql, $params);
        return $query->row()->total;
    }

    function getPatientServiceTimeByDoctorDetail($searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters = [], $overTimeStatus = "" , $depId = "", $startDate = "", $endDate = "", $year = "", $loc_id = "", $ps_id = "") {


        $orderColumn = $orderColumn === 'pt_fname' ? 'CONVERT(pt_fname USING tis620)' :
        ($orderColumn === 'pt_lname' ? 'CONVERT(pt_lname USING tis620)' : $orderColumn);
        

                $cond = "";
        if ($overTimeStatus == "O") { //เกินเวลา
            $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) > CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') > CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )";
        }else if($overTimeStatus == "N"){ //ไม่เกิน
                    $cond = " AND 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NULL 
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NOT NULL
                        AND CONCAT(ntdp_date_finish, ' ', ntdp_time_finish) <= CONCAT(ntdp_date_end, ' ', '00:00:00')
                    )
                    OR 
                    (
                        ntdp_date_end IS NOT NULL 
                        AND ntdp_time_end IS NOT NULL
                        AND ntdp_date_finish IS NOT NULL 
                        AND ntdp_time_finish IS NULL
                        AND CONCAT(ntdp_date_finish, ' ', '23:59:59') <= CONCAT(ntdp_date_end, ' ', ntdp_time_end)
                    )
                    "; 
        }

        $sql = "SELECT 
                  pt_id,
                    ps_id, 
                    pf_name,
                    ps_fname,
                    ps_lname,
                    pt_member,
                    pt_fname,
                    pt_lname,
                    pt_identification,
                    stde_name_th,
                    apm_visit,
                    apm_ql_code,
                    apm_date,
                    apm_time, 
                    apm_app_walk,
                    apm_patient_type,
                    pt_prefix,
                    stde_abbr,
                    stde_id,
                    ntdp_date_start,
                    ntdp_time_start,
                    ntdp_date_end,
                    ntdp_time_end,
                    ntdp_date_finish,
                    ntdp_time_finish,
                    loc_name,
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า'
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่'
                        ELSE ''
                    END as type_name,
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย'
                        WHEN apm_app_walk = 'W' THEN 'Walk-In'
                        ELSE ''
                    END as type_walk
                FROM wts_notifications_department ntdp
                INNER JOIN {$this->que_db}.que_appointment apm ON ntdp_apm_id = apm_id
                INNER JOIN wts_location ON ntdp_loc_Id = loc_id
                LEFT JOIN {$this->ums_db}.ums_patient pt ON apm_pt_id = pt_id
                LEFT JOIN {$this->hr_db}.hr_structure_detail ON  apm_stde_id = stde_id 
                LEFT JOIN  {$this->hr_db}.hr_person ON apm_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                WHERE (1 $cond)";


        $params = [];
        if ($loc_id != ""){
            $sql .= " AND ntdp_loc_Id = ? ";
            $params[] = $loc_id;
        }

        if ($year != "") {
            $sql .= " AND YEAR(ntdp_date_finish) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ntdp_date_finish) = ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ntdp_date_finish) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($depId != ""){
            $sql .= " AND apm_dp_id = ? ";
            $params[] = $depId;
        }

        if ($ps_id != "") {
            $sql .= " AND apm_ps_id = ? ";
            $params[] = $ps_id;
        }


        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }


            if ($searchValue) {
            $escapedSearchValue = $this->db->escape_like_str($searchValue);
            
            $sql .= " AND (
                pt_member LIKE '%" . $escapedSearchValue . "%'
                OR pt_lname LIKE '%" . $escapedSearchValue . "%'
                OR pt_identification LIKE '%" . $escapedSearchValue . "%'
                OR pt_fname LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR apm_visit LIKE '%" . $escapedSearchValue . "%'
                OR apm_ql_code LIKE '%" . $escapedSearchValue . "%'
                OR apm_date LIKE '%" . $escapedSearchValue . "%'
                OR apm_time LIKE '%" . $escapedSearchValue . "%'
                OR ps_fname LIKE '%" . $escapedSearchValue . "%'
                OR ps_lname LIKE '%" . $escapedSearchValue . "%'
                OR stde_abbr LIKE '%" . $escapedSearchValue . "%'
                OR stde_name_th LIKE '%" . $escapedSearchValue . "%'
                OR loc_name LIKE '%" . $escapedSearchValue . "%'
                OR (
                    CASE 
                        WHEN apm_patient_type = 'old' THEN 'ผู้ป่วยเก่า' 
                        WHEN apm_patient_type = 'new' THEN 'ผู้ป่วยใหม่' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
                OR (
                    CASE 
                        WHEN apm_app_walk = 'A' THEN 'นัดหมาย' 
                        WHEN apm_app_walk = 'W' THEN 'Walk-In' 
                        ELSE '' 
                    END LIKE '%" . $escapedSearchValue . "%'
                )
            )";
        }


        $sql .= "  ORDER BY $orderColumn $orderDirection
                LIMIT $start, $length";

        $query = $this->wts->query($sql, $params);
        // echo $this->wts->last_query();die;
        return $query;


    }

}?>
