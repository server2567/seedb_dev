<?php

include_once("Da_ums_user_logs_menu.php");

class M_ums_user_logs_menu extends Da_ums_user_logs_menu {
	
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
				FROM ums_user_logs_menu 
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
	
	/*
	* get_ums_log_card
	* ข้อมูลประวัติการเข้าใช้งานระบบ 7 วันย้อนหลัง
	* @input -
	* @output ums log 7 days before
	* @author Tanadon Tangjaimongkhon
	* @Create Date 17/06/2024
	*/
	function get_ums_log_card($us_id){
		$sql = "
		SELECT 	'Login' AS ums_log_name,
				count(*) AS ums_log_count,
				0 AS log_system_id
		FROM ".$this->ums_db.".ums_user_logs_login
		WHERE ul_us_id = {$us_id} AND ul_date >= DATE_SUB(NOW(), INTERVAL 6 DAY)

		UNION

		SELECT
				st_name_th AS ums_log_name,
				count(*) AS ums_log_count,
				st_id AS log_system_id
		FROM ".$this->ums_db.".ums_user_logs_menu

		LEFT JOIN ".$this->ums_db.".ums_system
			ON ml_st_id = st_id
		WHERE 	ml_us_id = {$us_id} 
				AND ml_date >= DATE_SUB(NOW(), INTERVAL 6 DAY)
				AND (
						(ml_st_id = 10 AND ml_mn_id IS NULL) OR 
						(ml_st_id <> 10 AND ml_mn_id IS NOT NULL)
    				)
		GROUP BY st_id

		";
		$query = $this->ums->query($sql);
		return $query;
	}
	// get_ums_log_card

	/*
	* get_ums_log_dashboard
	* ข้อมูลประวัติการเข้าใช้งานระบบ 7 วันย้อนหลัง 
	* @input -
	* @output ums log 7 days before
	* @author Tanadon Tangjaimongkhon
	* @Create Date 17/06/2024
	*/
	public function get_ums_log_dashboard($us_id) {
        $sql = "
        SELECT 
            DATE(ul_date) AS log_date,
            'Login' AS ums_log_name,
            COUNT(*) AS ums_log_count
        FROM 
            ".$this->ums_db.".ums_user_logs_login 
        WHERE 
            ul_us_id = {$us_id} 
			AND ul_date >= DATE_SUB(NOW(), INTERVAL 6 DAY)
        GROUP BY 
            log_date

        UNION

        SELECT
            DATE(ml_date) AS log_date,
            st.st_name_th AS ums_log_name,
            COUNT(*) AS ums_log_count
      	FROM
            ".$this->ums_db.".ums_user_logs_menu
        LEFT JOIN
            ".$this->ums_db.".ums_system st ON ml_st_id = st.st_id
        WHERE
            ml_us_id = {$us_id} 
			AND ml_date >= DATE_SUB(NOW(), INTERVAL 6 DAY)
			AND (
					(ml_st_id = 10 AND ml_mn_id IS NULL) OR 
					(ml_st_id <> 10 AND ml_mn_id IS NOT NULL)
				)
        GROUP BY
            log_date, st_id
        ";
        
        $query = $this->ums->query($sql);
        return $query;
    }
	// get_ums_log_dashboard

	/*
	* get_ums_log_card_detail
	* ข้อมูลรายละเอียดประวัติการเข้าใช้งานระบบตามเดือนและปี
	* @input -
	* @output ums log by month and year
	* @author Tanadon Tangjaimongkhon
	* @Create Date 17/06/2024
	*/
	public function get_ums_log_card_detail($us_id, $log_system_id, $type, $month='', $year='') {

		if($type == "monthly"){

			$dateString = date("Y-m-d", strtotime("$year-$month-01")); // Assuming the day is 01 for simplicity
			
			if($log_system_id != 0){
				$cond = "	AND MONTH(ml_date) = MONTH('$dateString')
							AND YEAR(ml_date) = YEAR('$dateString')";
			}else{
				$cond = "	AND MONTH(ul_date) = MONTH('$dateString')
							AND YEAR(ul_date) = YEAR('$dateString')";
			}
		}
		else{
			if($log_system_id != 0){
				$cond = '	AND ml_date >= DATE_SUB(NOW(), INTERVAL 6 DAY)';
			}else{
				$cond = '	AND ul_date >= DATE_SUB(NOW(), INTERVAL 6 DAY)';
			}
		}
		
		if($log_system_id != 0){
			$sql = "
				SELECT
					ml_date AS log_date,
					ml_changed AS log_detail,
					ml_ip AS log_ip,
					ml_agent as log_agent
				FROM
					".$this->ums_db.".ums_user_logs_menu
				WHERE
					ml_us_id = {$us_id} 
					AND ml_st_id = {$log_system_id}
					AND (
						(ml_st_id = 10 AND ml_mn_id IS NULL) OR 
						(ml_st_id <> 10 AND ml_mn_id IS NOT NULL)
					)
					{$cond}
				ORDER BY ml_date DESC";
		}
		else{
			// for log login
			$sql = "
				SELECT 
					ul_date AS log_date,
					ul_changed AS log_detail,
					ul_ip AS log_ip,
					ul_agent as log_agent
				FROM
					".$this->ums_db.".ums_user_logs_login 
				WHERE 
					ul_us_id = {$us_id} 
					{$cond}
				ORDER BY ul_date DESC";
		}

        $query = $this->ums->query($sql);
        return $query;
    }
	// get_ums_log_dashboard
	
	/*
	* get_logs_all_system
	* logs of access all system for report
	* @input 
		type: per_month=get month, per_year=get all month of year
		year: year for need to get logs
		st_id(system_id): get logs of that system
	* @output logs of access all system list
	* @author Areerat Pongurai
	* @Create Date 21/06/2024
	*/
	function get_logs_all_system($type, $year, $st_id=null){
		$select = "";
		$group_by = "";
		if ($type == "per_month"){
			$select = "	,MONTH(ml.ml_date) AS log_month ";
			$group_by = " ,MONTH(ml.ml_date) ";
		}
		$where = "";
		if (!empty($st_id)) {
			$where = " AND st.st_id = $st_id ";
		}

		$sql = "
			SELECT
					st.st_name_th,
					st.st_icon,
					count(*) AS ums_log_count,
					st.st_id 
					{$select}
			FROM ".$this->ums_db.".ums_user_logs_menu ml
			LEFT JOIN ".$this->ums_db.".ums_system st ON ml.ml_st_id = st.st_id
			WHERE ml.ml_mn_id IS NULL AND YEAR(ml.ml_date) = {$year}
				{$where}
			GROUP BY st.st_id, st.st_icon {$group_by}
		";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	/*
	* get_logs_detail_system
	* logs detail in system with user, menu data 
	* @input 
		year: year for need to get logs
		st_id(system_id): get logs of that system
	* @output logs detail in system
	* @author Areerat Pongurai
	* @Create Date 02/07/2024
	*/
	function get_logs_detail_system($year, $st_id){
		$sql = "
			SELECT	ml.ml_us_id, ml.ml_st_id, ml.ml_mn_id, ml.ml_date, ml.ml_changed, ml.ml_ip, ml.ml_agent, 
					MONTH(ml.ml_date) AS log_month, 
					mn.mn_name_th,
					us.us_name
			FROM ".$this->ums_db.".ums_user_logs_menu ml
			LEFT JOIN ".$this->ums_db.".ums_menu mn ON ml.ml_mn_id = mn.mn_id
			LEFT JOIN ".$this->ums_db.".ums_user us ON ml.ml_us_id = us.us_id
			WHERE YEAR(ml.ml_date) = {$year}
				AND ml.ml_st_id = {$st_id}
			GROUP BY MONTH(ml.ml_date), ml_us_id, ml_st_id, ml_mn_id, ml_date, ml_changed, ml_ip, ml_agent, 
				mn.mn_name_th, us.us_name
			ORDER BY ml.ml_date DESC
		";
		$query = $this->ums->query($sql);
		return $query;
	}

} // end class M_umusergroup
?>
