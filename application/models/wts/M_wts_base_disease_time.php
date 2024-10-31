<?php

include_once("Da_wts_base_disease_time.php");

class M_wts_base_disease_time extends Da_wts_base_disease_time {

/*
* get_all_disease_time
* ดึงข้อมูลระยะเวลาของประเภทโรค
* @input -
* $output disease time list
* @author Supawee Sangrapee
* @Create Date 03/06/2024
*/
	function get_all_disease_time() {
		$sql = "SELECT dst_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, wts_base_disease.ds_name_disease_type, dst_name_point,dst_minute, ".$this->ums_db.".ums_user.us_name as user_name, dst_update_date, dst_active FROM `wts_base_disease_time`
                LEFT JOIN ".$this->ums_db.".ums_user
                ON dst_create_user = ".$this->ums_db.".ums_user.us_id
                LEFT JOIN wts_base_disease
                ON dst_ds_id = wts_base_disease.ds_id
                LEFT JOIN ".$this->hr_db.".hr_structure_detail
                ON ds_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
				WHERE dst_active != 2;
				";
		$query = $this->wts->query($sql);

		return $query;		
	}

/*
* get_disease_time_list
* ดึงข้อมูลระยะเวลาของประเภทโรคตามไอดีระยะเวลา
* @input -
* $output disease time list by dst_id
* @author Supawee Sangrapee
* @Create Date 03/06/2024
*/
	function get_disease_time_list($dst_id) {
		$sql = "SELECT dst_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, dst_patient_treatment_type, dst_ds_id, wts_base_disease.ds_name_disease_type, dst_name_point, dst_name_point_en, dst_minute, dst_active, dst_update_date, ".$this->ums_db.".ums_user.us_name as user_name
		FROM wts_base_disease_time
        Left join wts_base_disease
		on dst_ds_id = wts_base_disease.ds_id
		LEFT JOIN ".$this->ums_db.".ums_user
		ON ds_create_user = ".$this->ums_db.".ums_user.us_id
		LEFT JOIN ".$this->hr_db.".hr_structure_detail
		ON ds_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
		LEFT JOIN ".$this->hr_db.".hr_structure
		ON ".$this->hr_db.".hr_structure_detail.stde_stuc_id = ".$this->hr_db.".hr_structure.stuc_id
		WHERE dst_id = ?;
				";
		$query = $this->wts->query($sql, array($dst_id));
		return $query;		
	}

	function get_all_dst_name_point($dst_active="1") {
		$sql = "SELECT *
				FROM ".$this->wts_db.".wts_base_disease_time
				LEFT JOIN wts_base_route_time
				ON dst_id = rt_dst_id
				WHERE dst_active = '$dst_active'
				Group by dst_name_point" ;
		$query = $this->wts->query($sql);
		return $query;
	}

	function get_all_dst_name_point_by_stde($stde_id) {
		$sql = "SELECT dst_id, dst_ds_id, dst_name_point, dst_minute, dst_active, ds_id, ds_stde_id, rdp_stde_id
				FROM wts_base_disease_time
				LEFT JOIN wts_base_disease
				ON dst_ds_id = wts_base_disease.ds_id
				LEFT JOIN wts_base_route_department
				ON wts_base_disease.ds_stde_id = wts_base_route_department.rdp_stde_id
				WHERE wts_base_route_department.rdp_stde_id = $stde_id" ;
		$query = $this->wts->query($sql, array($stde_id));
		return $query;
	}

	function get_dst_patient_treatment_type() {
		$sql = "SELECT dst_patient_treatment_type
				FROM wts_base_disease_time
				GROUP BY dst_patient_treatment_type
		";
		$query = $this->wts->query($sql);
		return $query;		
	}

	function get_all_with_detail_server($start, $length, $order_dir, $params) {
		$where = '';
		if(!empty($params)) {
			if (!empty($params['dst_name_point'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['dst_name_point'];
				$where .= "(dst_name_point LIKE '%{$val}%')";
			}
			if (!empty($params['ds_stde_id'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['ds_stde_id'];
				$where .= "(ds_stde_id = {$val})";
			}
			if (!empty($params['ds_name_disease_type'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['ds_name_disease_type'];
				$where .= "(ds_name_disease_type LIKE '%{$val}%')";
			}
			if (!empty($params['search'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['search'];
				$where .= "((dst_name_point LIKE '%{$val}%') OR (ds_stde_id = {$val}) OR (ds_name_disease_type LIKE '%{$val}%'))";
			}
		}

		if (empty($where)) {
			$where .= "WHERE dst_active != 2";
		} else {
			$where .= " AND dst_active != 2";
		}

		$sql_in = "SELECT dst_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, dst_patient_treatment_type, dst_ds_id, wts_base_disease.ds_name_disease_type as ds_type, dst_name_point, dst_name_point_en, dst_minute, dst_active, dst_update_date, ".$this->ums_db.".ums_user.us_name as user_name
					FROM wts_base_disease_time
					Left join wts_base_disease
					on dst_ds_id = wts_base_disease.ds_id
					LEFT JOIN ".$this->ums_db.".ums_user
					ON ds_create_user = ".$this->ums_db.".ums_user.us_id
					LEFT JOIN ".$this->hr_db.".hr_structure_detail
					ON ds_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
					LEFT JOIN ".$this->hr_db.".hr_structure
					ON ".$this->hr_db.".hr_structure_detail.stde_stuc_id = ".$this->hr_db.".hr_structure.stuc_id
				".$where."
				";
		$count_sql = "SELECT COUNT(*) as total FROM (" . $sql_in .") AS a ";
		$count_query = $this->wts->query($count_sql);
		$total_records = $count_query->row()->total;
	
		$sql = "SELECT * FROM ( " . $sql_in . ") AS a ";
		// pre($sql); die;
	    // if (!empty($order_dir))
        // 	$sql .= " ORDER BY $order_dir";
    	$sql .= " LIMIT ".(int)$start.",  ".(int)$length;

		$query = $this->wts->query($sql);
		
		return ['query' => $query, 'total_records' => $total_records];
	
	}

	/*
	* get_all_dst_by_ds_id
	* ดึงข้อมูลระยะเวลาของประเภทโรคทั้งหมด
	* @input $dst_ds_id
	* $output disease time list
	* @author Areerat Pongurai
	* @Create Date 28/08/2024
	*/
	function get_all_dst_by_ds_id($dst_ds_id) {
		$sql = "SELECT *
				FROM wts_base_disease_time
				WHERE dst_ds_id = ?;
				";
		$query = $this->wts->query($sql, array($dst_ds_id));

		return $query;		
	}
} // end class M_wts_base_disease_time
?>
