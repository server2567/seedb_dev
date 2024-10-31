<?php
/*
* Que_dashboard
* Model for Manage about Que Dashboard
* @Author Patiya Peansawat
* @Create Date 09/08/2024
*/
include_once(dirname(__FILE__)."/../seedb_model.php");

class Ums_dashboard_model extends seedb_model {

    /**
     * Count the number of registered patients based on the provided date range or year.
     * 
     * @param string $startDate The start date to filter patients (format: YYYY-MM-DD). Optional.
     * @param string $endDate The end date to filter patients (format: YYYY-MM-DD). Optional.
     * @param string $year The year to filter patients. Optional.
     * 
     * @return object The query result containing the count of registered patients.
     * 
     * Created on: 2024-08-20
     */
    function countPatientRegistered( $startDate = "" , $endDate = "", $year = ""){

        $sql = "SELECT COUNT(pt_id) as count
                FROM {$this->ums_db}.ums_patient
                WHERE pt_sta_id = 1 ";
    
        $params = [];
        
        if ($year != "") {
            $sql .= " AND YEAR(pt_create_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(pt_create_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(pt_create_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(pt_create_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        $query = $this->ums->query($sql, $params);
        return $query;
    }

    /**
     * Count the number of system users or administrators based on the provided date range or year.
     * 
     * @param string $dpId The department ID to filter users. Optional.
     * @param string $startDate The start date to filter users (format: YYYY-MM-DD). Optional.
     * @param string $endDate The end date to filter users (format: YYYY-MM-DD). Optional.
     * @param string $year The year to filter users. Optional.
     * 
     * @return object The query result containing the count of system users or administrators.
     * 
     * Created on: 2024-08-20
     */
    function countUserAdmin($dpId = "", $startDate = "" , $endDate = "", $year = "") {

        $sql = "SELECT COUNT(DISTINCT us_ps_id) as count
                FROM {$this->ums_db}.ums_user
                INNER JOIN {$this->hr_db}.hr_person ps ON us_ps_id = ps_id
                WHERE us_active = 1 AND ps_status = 1";

        $params = [];
        
        if ($year != "") {
            $sql .= " AND YEAR(us_create_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(us_create_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(us_create_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(us_create_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }
        if ($dpId != ""){
            $sql .= " AND us_dp_id = ?";
            $params[] = $dpId;
        }

        // $sql .= " GROUP BY us_ps_id ";

        $query = $this->ums->query($sql, $params);
        // echo $this->ums->last_query();die;
        return $query;
    }

    /**
     * Count the number of news items based on the provided date range or year.
     * 
     * @param string $startDate The start date to filter news items (format: YYYY-MM-DD). Optional.
     * @param string $endDate The end date to filter news items (format: YYYY-MM-DD). Optional.
     * @param string $year The year to filter news items. Optional.
     * 
     * @return object The query result containing the count of news items.
     * 
     * Created on: 2024-08-20
     */
    function countNews($startDate = "" , $endDate = "", $year = ""){

        $sql = "SELECT COUNT(news_id) as count
                FROM {$this->ums_db}.ums_news
                WHERE news_active = 1 ";

        $params = [];
        
        if ($year != "") {
            $sql .= " AND YEAR(news_start_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(news_start_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(news_stop_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(news_start_date) >= ? AND DATE(news_stop_date) <= ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        $query = $this->ums->query($sql, $params);
        return $query;
    }

    /**
     * Count the total number of systems available.
     * 
     * @return object The query result containing the count of systems.
     * 
     * Created on: 2024-08-20
     */
    function countSystem(){
        $sql = "SELECT COUNT(st_id) as count
                FROM {$this->ums_db}.ums_system
                WHERE st_active = 1";
        $query = $this->ums->query($sql);
        return $query;
    }



    function getTotalPatientRecords($selectedLetters = [], $privacyType = "", $startDate = "", $endDate = "", $year = "")
    {

        $wherePrivacy = "";
        if (strtoupper($privacyType) == 'Y' || strtoupper($privacyType) == 'N') {
            $p = strtoupper($privacyType);
            $wherePrivacy = " AND pt_privacy = '$p' ";
            
        }
        
        $sql = "SELECT COUNT(pt_id) as total FROM {$this->ums_db}.ums_patient WHERE pt_sta_id = 1  $wherePrivacy ";

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }


        $params = [];
        if ($year != "") {
            $sql .= " AND YEAR(pt_create_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(pt_create_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(pt_create_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(pt_create_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        $query = $this->ums->query($sql ,  $params);
        return $query->row()->total;
    }

    function getTotalUmsUserRecords($selectedLetters = [], $hireIsMedical = "", $dpId = "", $startDate = "", $endDate = "", $year = "")
    {
        $params = [];
        $subSql = "";

        if ($dpId != "") {
            $subSql .= " AND pos_dp_id = ? ";
            $params[] = $dpId;
        }

        $sql = "SELECT COUNT( DISTINCT us_ps_id) as total 
                FROM {$this->ums_db}.ums_user
                INNER JOIN {$this->hr_db}.hr_person ON us_ps_id = ps_id
                LEFT JOIN (
                    SELECT pos_ps_id, pos_ps_code, pos_hire_id
                    FROM {$this->hr_db}.hr_person_position
                    WHERE pos_ps_code IS NOT NULL AND pos_active = 'Y' $subSql 
                    GROUP BY pos_ps_id
                ) pos ON ps_id = pos.pos_ps_id
                LEFT JOIN {$this->hr_db}.hr_base_hire ON pos.pos_hire_id = hire_id
                WHERE us_active = 1 AND ps_status = 1";

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "ps_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }
        
        if ($year != "") {
            $sql .= " AND YEAR(us_create_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(us_create_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(us_create_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(us_create_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($dpId != "") {
            $sql .= " AND us_dp_id = ?";
            $params[] = $dpId;
        }
        
        if ($hireIsMedical != "all" && $hireIsMedical != "") {
            $sql .= " AND hire_is_medical = ?";
            $params[] = $hireIsMedical;
        }

        $query = $this->ums->query($sql, $params);
        return $query->row()->total;
    }


    function getUmsPatientDetail( $searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters = [], $privacyType = "",  $startDate = "", $endDate = "", $year = "")
    {
        $orderColumn = $orderColumn === 'pt_fname' ? 'CONVERT(pt_fname USING tis620)' :
                    ($orderColumn === 'pt_lname' ? 'CONVERT(pt_lname USING tis620)' : $orderColumn);
        
        $wherePrivacy = "";
        if (strtoupper($privacyType) == 'Y' || strtoupper($privacyType) == 'N') {
            $p = strtoupper($privacyType);
            $wherePrivacy = " AND pt_privacy = '$p' ";
            
        }

        $sql = "SELECT pt_id, pt_member, pt_identification, pt_passport, pt_peregrine, pt_prefix, pt_fname, pt_lname, pt_tel, pt_email, pt_privacy, pt_create_date
                FROM {$this->ums_db}.ums_patient
                WHERE pt_sta_id = 1  $wherePrivacy ";

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "pt_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        if ($searchValue) {
            $sql .= " AND (pt_member LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                    OR pt_lname LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                    OR pt_identification LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                    OR pt_fname LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                    OR pt_tel LIKE '%" . $this->db->escape_like_str($searchValue) . "%'";
        }

        $params = [];
        if ($year != "") {
            $sql .= " AND YEAR(pt_create_date) = ? ";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(pt_create_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(pt_create_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(pt_create_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }
  

        $sql .= " ORDER BY $orderColumn $orderDirection
                LIMIT $start, $length";

        $query = $this->ums->query($sql, $params);
        return $query;
    }


    function getUmsUsersDetail( $searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters = [], $hireIsMedical = ""  ,$dpId = "", $startDate = "", $endDate = "", $year = "")
    {
        $orderColumn = $orderColumn === 'ps_fname' ? 'CONVERT(ps_fname USING tis620)' :
                    ($orderColumn === 'ps_lname' ? 'CONVERT(ps_lname USING tis620)' : $orderColumn);
        $params = [];

        // $subSql2 = "";
        // if ($year != "") {
        //     $subSql2 .= " AND YEAR(ml_date) = ?";
        //     $params[] = $year;
        // } else {
        //     if ($startDate != "" && $endDate == "") {
        //         $subSql2 .= " AND ml_date >= ?";
        //         $params[] = $startDate;
        //     } else if ($startDate == "" && $endDate != "") {
        //         $subSql2 .= " AND ml_date <= ?";
        //         $params[] = $endDate;
        //     } else if ($startDate != "" && $endDate != "") {
        //         $subSql2 .= " AND ml_date BETWEEN ? AND ?";
        //         $params[] = $startDate;
        //         $params[] = $endDate;
        //     }
        // }


        $subSql = "";
        if ($dpId != ""){
            $subSql .= " AND pos_dp_id = ?";
            $params[] = $dpId;
        }


        $sql = "SELECT us_id, ps_id, pf_name, ps_fname, ps_lname, pos.pos_ps_code, psd_id_card_no, GROUP_CONCAT(DISTINCT us_id) as multiple_us_id,
                CASE 
                    WHEN hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire_is_medical = 'N' THEN 'สายการพยาบาล'
                    WHEN hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE ''
                END  as hire_is_medical_name ,
                hire_name
                FROM {$this->ums_db}.ums_user us
                INNER JOIN {$this->hr_db}.hr_person ps ON us_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                LEFT JOIN 
                (
                    SELECT pos_ps_id, pos_ps_code , pos_hire_id
                    FROM {$this->hr_db}.hr_person_position
                    WHERE pos_ps_code IS NOT NULL AND pos_active = 'Y' $subSql 
                    
                ) pos ON ps_id = pos.pos_ps_id
                LEFT JOIN {$this->hr_db}.hr_base_hire ON  pos_hire_id = hire_id
                LEFT JOIN {$this->hr_db}.hr_person_detail ON ps_id = psd_ps_id
                WHERE us_active = 1 AND ps_status = 1";

  

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "ps_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        if ($searchValue) {
            $sql .= " AND (ps_fname LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                    OR ps_lname LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                    OR psd_id_card_no LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                    OR hire_name LIKE '%" . $this->db->escape_like_str($searchValue) . "%')";
        }

      
        if ($year != "") {
            $sql .= " AND YEAR(us_create_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(us_create_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(us_create_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(us_create_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }
        
        if ($dpId != ""){
            $sql .= " AND us_dp_id = ?";
            $params[] = $dpId;
        }

        if ($hireIsMedical  != "all" && $hireIsMedical  != ""){
            $sql .= " AND hire_is_medical = ?";
            $params[] = $hireIsMedical;
        }
        
        $sql .= " GROUP BY us_ps_id ";
        $sql .= " ORDER BY $orderColumn $orderDirection
                LIMIT $start, $length";
        $query = $this->ums->query($sql, $params);
        return $query;
    }

    /**
     * This function retrieves the count of systems that the specified user is responsible for, 
     * considering the given date range and year.
     *
     * Function creation date: August 22, 2024
     *
     * @param int $usId The user ID for which the count of responsible systems is to be retrieved
     * @return object The count of systems the user is responsible for
     */
    function getResponsibleSystem($usId){
        $sql = "SELECT st.*
                FROM {$this->ums_db}.ums_usergroup
                INNER JOIN {$this->ums_db}.ums_group ON ug_gp_id = gp_id
                INNER JOIN {$this->ums_db}.ums_system st ON gp_st_id = st_id
                WHERE ug_us_id = ? AND st_active =  1 GROUP BY st_id";

        $query = $this->ums->query($sql, array($usId));
        return $query;
    }

    function getResponsibleSystemWhereIn($InusId){

        $InusIdArray = explode(',', $InusId);
    
        $placeholders = implode(',', array_fill(0, count($InusIdArray), '?'));

        $sql = "SELECT st.*
                FROM {$this->ums_db}.ums_usergroup
                INNER JOIN {$this->ums_db}.ums_group ON ug_gp_id = gp_id
                INNER JOIN {$this->ums_db}.ums_system st ON gp_st_id = st_id
                WHERE ug_us_id IN ($placeholders) AND st_active =  1 GROUP BY st_id";

        $query = $this->ums->query($sql, $InusIdArray);
        return $query;
    }


    /**
     * Retrieves the count of login events for a specified user within a given date range or for a specific year.
     * This function queries the database to determine how many times the user has logged into the system
     * during the specified period or overall.
     *
     * Function creation date: August 22, 2024
     *
     * @param int $usId The user ID for which the login count is to be retrieved.
     * @param string $startDate (Optional) The start date of the period to filter login events (format: 'Y-m-d').
     * @param string $endDate (Optional) The end date of the period to filter login events (format: 'Y-m-d').
     * @param string $year (Optional) The year to filter login events (format: 'Y').
     * @return int The count of login events for the specified user within the given period or overall.
     */

    function getCountLoginSystem($usId, $startDate = "", $endDate = "", $year = ""){
        $sql = "SELECT COUNT(ml_id) as count
                FROM {$this->ums_db}.ums_user_logs_menu
                LEFT JOIN {$this->ums_db}.ums_user ON ml_us_id = us_id
                LEFT JOIN  {$this->hr_db}.hr_person ON us_ps_id = ps_id
                WHERE ml_changed LIKE '%เข้าใช้งานระบบ%' AND ml_us_id = ? ";
                
        $params = [];
        $params[] = $usId;
        if ($year != "") {
            $sql .= " AND YEAR(ml_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(ml_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(ml_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(ml_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        $query = $this->ums->query($sql, $params);
        return $query;
        
                
    }

    function getUmsNewsDetail($startDate = "", $endDate = "", $year = ""){


        $sql = "SELECT * , 
                CASE
                    WHEN news_type = 1 THEN 'ปกติ'
                    WHEN news_type = 2 THEN 'ด่วน'
                END as news_type_name
                FROM {$this->ums_db}.ums_news
                WHERE news_active = 1";

        $params = [];

        if ($year != "") {
            $sql .= " AND YEAR(news_start_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(news_start_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(news_stop_date )<= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(news_start_date) >= ? AND DATE(news_stop_date) <= ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        $sql .= " ORDER BY news_id DESC ";
        $query = $this->ums->query($sql, $params);
        return $query;
    }

    function getUmsSystemDetail() {
            $sql = "SELECT  *
                FROM {$this->ums_db}.ums_system
                WHERE st_active = 1 ORDER BY st_name_th ASC ";
        $query = $this->ums->query($sql);
        return $query;
    }

    function getRegistrationSummary( $privacy  = "", $startDate = "", $endDate = "", $year = ""){

        $sql = "SELECT *
                FROM {$this->ums_db}.ums_patient
                WHERE pt_sta_id = 1 ";

        $params = [];
        
        if ($year != "") {
            $sql .= " AND YEAR(pt_create_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $sql .= " AND DATE(pt_create_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $sql .= " AND DATE(pt_create_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $sql .= " AND DATE(pt_create_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }

        if ($privacy != ""){
            $sql .= " AND pt_privacy = ? ";
            $params[] = $privacy;
        }


        $query = $this->ums->query($sql, $params);
        return $query;

    }

    function getCountUsersInSystemByType( $isMedicalType , $sysId, $dpId = "") {

        $params = [];
        $subSql = "";

        if ($dpId != "") {
            $subSql .= " AND pos_dp_id = ? ";
            $params[] = $dpId;
        }

        $params[] = $isMedicalType;
        $params[] = $sysId;

        $sql = "SELECT COUNT(DISTINCT us_ps_id) as count
                FROM {$this->ums_db}.ums_usergroup
                INNER JOIN {$this->ums_db}.ums_group ON ug_gp_id = gp_id
                INNER JOIN {$this->ums_db}.ums_system st ON gp_st_id = st_id
                INNER JOIN {$this->ums_db}.ums_user ON ug_us_id = us_id
                INNER JOIN {$this->hr_db}.hr_person ps ON us_ps_id = ps_id
                LEFT JOIN (
                    SELECT pos_ps_id, pos_ps_code, pos_hire_id
                    FROM {$this->hr_db}.hr_person_position
                    WHERE pos_ps_code IS NOT NULL AND pos_active = 'Y' $subSql 
                    GROUP BY pos_ps_id
                ) pos ON ps_id = pos.pos_ps_id
                LEFT JOIN {$this->hr_db}.hr_base_hire ON pos.pos_hire_id = hire_id
                WHERE  us_active = 1 AND ps_status = 1 AND st_active =  1 AND hire_is_medical = ? AND gp_st_id  = ? ";

        if ($dpId != "") {
            $sql .= " AND us_dp_id = ?";
            $params[] = $dpId;
        }
        $query = $this->ums->query($sql, $params);
        return $query;
    }


    function getStaffOfSystem($dpId = "",  $startDate = "", $endDate = "", $year = "" , $sysId = "" , $selectedLetters  = []) {
        $params = [];


        // $subSql2 = "";
        // if ($year != "") {
        //     $subSql2 .= " AND YEAR(ml_date) = ?";
        //     $params[] = $year;
        // } else {
        //     if ($startDate != "" && $endDate == "") {
        //         $subSql2 .= " AND ml_date >= ?";
        //         $params[] = $startDate;
        //     } else if ($startDate == "" && $endDate != "") {
        //         $subSql2 .= " AND ml_date <= ?";
        //         $params[] = $endDate;
        //     } else if ($startDate != "" && $endDate != "") {
        //         $subSql2 .= " AND ml_date BETWEEN ? AND ?";
        //         $params[] = $startDate;
        //         $params[] = $endDate;
        //     }
        // }

        // if ($sysId != "" && $sysId != "all"){
        //     $subSql2 .= " AND ml_st_id = ? ";
        //     $params[] = $sysId;
        // }


        $subSql = "";
        if ($dpId != "") {
            $subSql .= " AND pos_dp_id = ? ";
            $params[] = $dpId;
        }


        $sql = "SELECT ps.*, pos_ps_code, psd_id_card_no, ps_fname, hire_name,  pf_name, GROUP_CONCAT(DISTINCT us_id) as multiple_us_id,
                CASE 
                    WHEN hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire_is_medical = 'N' THEN 'สายการพยาบาล'
                    WHEN hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE ''
                END  as hire_is_medical_name 
                FROM {$this->ums_db}.ums_usergroup
                INNER JOIN {$this->ums_db}.ums_group ON ug_gp_id = gp_id
                INNER JOIN {$this->ums_db}.ums_system st ON gp_st_id = st_id
                INNER JOIN {$this->ums_db}.ums_user us ON ug_us_id = us_id
                INNER JOIN {$this->hr_db}.hr_person ps ON us_ps_id = ps_id
                LEFT JOIN (
                    SELECT pos_ps_id, pos_ps_code, pos_hire_id
                    FROM {$this->hr_db}.hr_person_position
                    WHERE pos_ps_code IS NOT NULL AND pos_active = 'Y' $subSql 
                    GROUP BY pos_ps_id
                ) pos ON ps_id = pos.pos_ps_id
                LEFT JOIN {$this->hr_db}.hr_base_hire ON pos.pos_hire_id = hire_id
                LEFT JOIN {$this->hr_db}.hr_person_detail ON ps_id = psd_ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                WHERE  us_active = 1 AND ps_status = 1 AND st_active =  1  ";

        if ($dpId != "") {
            $sql .= " AND us_dp_id = ?";
            $params[] = $dpId;
        }

        if ($sysId != "all" && $sysId != ""){
            $params[] = $sysId;
            $sql .= " AND gp_st_id  = ? ";
        }

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "ps_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        $sql .= " GROUP BY ps_id  ORDER BY  CONVERT(ps_fname USING tis620) ASC, CONVERT(ps_fname USING tis620) ASC";
        $query = $this->ums->query($sql, $params);
        return $query;
    }

    function getCountLoginSystemhereIn($InusId, $startDate = "", $endDate = "", $year = ""){

        $params = [];
        $InusIdArray = explode(',', $InusId);
        $placeholders = implode(',', array_fill(0, count($InusIdArray), '?'));

        $params = $InusIdArray;  // เริ่มจาก array ของ user IDs

        $subSql2 = "";
        if ($year != "") {
            $subSql2 .= " AND YEAR(ml_date) = ?";
            $params[] = $year;
        } else {
            if ($startDate != "" && $endDate == "") {
                $subSql2 .= " AND DATE(ml_date) >= ?";
                $params[] = $startDate;
            } else if ($startDate == "" && $endDate != "") {
                $subSql2 .= " AND DATE(ml_date) <= ?";
                $params[] = $endDate;
            } else if ($startDate != "" && $endDate != "") {
                $subSql2 .= " AND DATE(ml_date) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
        }
 
        $sql = "SELECT *
                FROM {$this->ums_db}.ums_user_logs_menu
                LEFT JOIN {$this->ums_db}.ums_user ON ml_us_id = us_id
                LEFT JOIN  {$this->hr_db}.hr_person ON us_ps_id = ps_id
                WHERE ml_changed LIKE '%เข้าใช้งานระบบ%' 
                AND ml_us_id IN ($placeholders) $subSql2";

        $query = $this->ums->query($sql, $params);
        return $query;
    }
    
    function getUsersOfSystemByLine($dpId = "",  $hireIsMedical = "", $selectedLetters = []){

        $params = [];
        $subSql = "";

        if ($dpId != "") {
            $subSql .= " AND pos_dp_id = ? ";
            $params[] = $dpId;
        }

        $sql = "SELECT us_id, ps_id, pf_name, ps_fname, ps_lname, pos.pos_ps_code, psd_id_card_no, GROUP_CONCAT(DISTINCT us_id) as multiple_us_id,
                CASE 
                    WHEN hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire_is_medical = 'N' THEN 'สายการพยาบาล'
                    WHEN hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE ''
                END  as hire_is_medical_name ,
                hire_name
                FROM {$this->ums_db}.ums_user us
                INNER JOIN {$this->hr_db}.hr_person ps ON us_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                LEFT JOIN 
                (
                    SELECT pos_ps_id, pos_ps_code , pos_hire_id
                    FROM {$this->hr_db}.hr_person_position
                    WHERE pos_ps_code IS NOT NULL AND pos_active = 'Y' $subSql 
                    
                ) pos ON ps_id = pos.pos_ps_id
                LEFT JOIN {$this->hr_db}.hr_base_hire ON  pos_hire_id = hire_id
                LEFT JOIN {$this->hr_db}.hr_person_detail ON ps_id = psd_ps_id
                INNER JOIN {$this->ums_db}.ums_usergroup ON ug_us_id = us_id
                INNER JOIN {$this->ums_db}.ums_group ON ug_gp_id = gp_id
                INNER JOIN {$this->ums_db}.ums_system st ON gp_st_id = st_id
                WHERE us_active = 1 AND ps_status = 1 AND st_active =  1 ";

        if ($hireIsMedical  != "all" && $hireIsMedical  != ""){
            $sql .= " AND hire_is_medical = ?";
            $params[] = $hireIsMedical;
        }


        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "ps_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        if ($dpId != ""){
            $sql .= " AND us_dp_id = ?";
            $params[] = $dpId;
        }
        
        $sql .= " GROUP BY us_ps_id ORDER BY  CONVERT(ps_fname USING tis620) ASC, CONVERT(ps_fname USING tis620) ASC";
        $query = $this->ums->query($sql, $params);
        return $query;
    }



    function getCountUsersActiveSystem($dpId = "", $stId = "" ,$date = "" , $month = "", $year = ""){
            


            $sql = "SELECT COUNT(*) as count
                    FROM {$this->ums_db}.ums_user_logs_menu
                    LEFT JOIN {$this->ums_db}.ums_user ON ml_us_id = us_id
                    LEFT JOIN  {$this->hr_db}.hr_person ON us_ps_id = ps_id
                    LEFT JOIN {$this->hr_db}.hr_person_detail ON ps_id = psd_ps_id
                    WHERE ml_changed LIKE '%เข้าใช้งานระบบ%'  ";

            $params = [];
            if ($dpId != "") {
                $sql .= " AND us_dp_id = ? ";
                $params[] = $dpId;
            }

            if ($stId != "") {
                $sql .= " AND ml_st_id = ? ";
                $params[] = $stId;
            }

            if ($date != "") {
                $sql .= " AND DATE(ml_date) = ? ";
                $params[] = $date;
            }

            if ($month != ""){
                $sql .= " AND MONTH(ml_date) = ?";
                $params[] = $month;
            }   

            if ($year != ""){
                $sql .= " AND YEAR(ml_date) = ? ";
                $params[] = $year;
            }   

            $query = $this->ums->query($sql, $params);
            // echo $this->ums->last_query();die;
            return $query;
    }




    function getTotalUsersActiveSystemRecords($selectedLetters = [], $stId = "", $dpId = "", $startDate = "", $endDate = "", $year = "", $arrDate = [], $startMonth = "", $endMonth = "")
    {   

        $params = [];
        $sql = "SELECT COUNT(*) as total
                FROM {$this->ums_db}.ums_user_logs_menu
                LEFT JOIN {$this->ums_db}.ums_user ON ml_us_id = us_id
                LEFT JOIN  {$this->hr_db}.hr_person ON us_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_person_detail ON ps_id = psd_ps_id
                WHERE ml_changed LIKE '%เข้าใช้งานระบบ%'  ";

        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "ps_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        if ($stId != "") {
            $sql .= " AND ml_st_id = ? ";
            $params[] = $stId;
        }

        if ($dpId != "") {
            $sql .= " AND us_dp_id = ? ";
            $params[] = $dpId;
        }

        if (!empty($arrDate)){
            $sql .= " AND DATE(ml_date) BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
        }else {
            $sql .= " AND DATE_FORMAT(FROM_UNIXTIME(ml_date), '%Y-%m') >= ? AND DATE_FORMAT(FROM_UNIXTIME(ml_date), '%Y-%m') <= ?";
            $params[] = "{$year}-" . str_pad($startMonth, 2, '0', STR_PAD_LEFT);
            $params[] = "{$year}-" . str_pad($endMonth, 2, '0', STR_PAD_LEFT);
        }   

        $query = $this->ums->query($sql, $params);
        return $query->row()->total;
    }

    function getMultipleUsId($psId) {
        $sql = "SELECT GROUP_CONCAT(DISTINCT us_id) as multiple_us_id 
                FROM {$this->ums_db}.ums_user
                WHERE us_ps_id = ? ";
        $query = $this->ums->query($sql, array($psId));
        return $query;
    }

    function getUsersActiveSystemRecords($searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters = [], $stId = "" ,$dpId = "" , $startDate = "", $endDate = "", $year = "", $arrDate = [] , $startMonth = "", $endMonth = "" ) {


        $orderColumn = $orderColumn === 'ps_fname' ? 'CONVERT(ps_fname USING tis620)' :
        ($orderColumn === 'ps_lname' ? 'CONVERT(ps_lname USING tis620)' : $orderColumn);
        
   
        $params = [];
        $subSql = "";

        if ($dpId != "") {
            $subSql .= " AND pos_dp_id = ? ";
            $params[] = $dpId;
        }
        
        $sql = "SELECT *,
                CASE 
                    WHEN hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire_is_medical = 'N' THEN 'สายการพยาบาล'
                    WHEN hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE ''
                END  as hire_is_medical_name 
                FROM {$this->ums_db}.ums_user_logs_menu
                LEFT JOIN {$this->ums_db}.ums_user ON ml_us_id = us_id
                LEFT JOIN  {$this->hr_db}.hr_person ON us_ps_id = ps_id
                LEFT JOIN {$this->hr_db}.hr_base_prefix ON ps_pf_id = pf_id
                LEFT JOIN {$this->hr_db}.hr_person_detail ON ps_id = psd_ps_id
                LEFT JOIN (
                    SELECT pos_ps_id, pos_ps_code, pos_hire_id
                    FROM {$this->hr_db}.hr_person_position
                    WHERE pos_ps_code IS NOT NULL AND pos_active = 'Y' $subSql 
                    GROUP BY pos_ps_id
                ) pos ON ps_id = pos.pos_ps_id
                LEFT JOIN {$this->hr_db}.hr_base_hire ON  pos_hire_id = hire_id
                WHERE ml_changed LIKE '%เข้าใช้งานระบบ%'  ";


        if (!empty($selectedLetters)) {
            $escapedLetters = array_map([$this->db, 'escape_like_str'], $selectedLetters);
            $letterConditions = array_map(function($letter) {
                return "ps_fname LIKE '{$letter}%'";
            }, $escapedLetters);
            
            $sql .= " AND (" . implode(" OR ", $letterConditions) . ")";
        }

        if ($searchValue) {
            $sql .= " AND (ps_fname LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                        OR ps_lname LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                        OR psd_id_card_no LIKE '%" . $this->db->escape_like_str($searchValue) . "%'
                        OR hire_name LIKE '%" . $this->db->escape_like_str($searchValue) . "%')";
        }

        if ($stId != "") {
            $sql .= " AND ml_st_id = ? ";
            $params[] = $stId;
        }

        if ($dpId != "") {
            $sql .= " AND us_dp_id = ? ";
            $params[] = $dpId;
        }

        if (!empty($arrDate)){
            $sql .= " AND DATE(ml_date) BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
        }else {
            $sql .= " AND DATE_FORMAT(FROM_UNIXTIME(ml_date), '%Y-%m') >= ? AND DATE_FORMAT(FROM_UNIXTIME(ml_date), '%Y-%m') <= ?";
            $params[] = "{$year}-" . str_pad($startMonth, 2, '0', STR_PAD_LEFT);
            $params[] = "{$year}-" . str_pad($endMonth, 2, '0', STR_PAD_LEFT);
        }   

        $sql .= " ORDER BY $orderColumn $orderDirection
                LIMIT $start, $length";

        $query = $this->ums->query($sql, $params);
        return $query;
    }




}?>
