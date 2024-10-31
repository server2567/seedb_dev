<?php
/*
* M_wts_base_disease
* Model for Manage about wts_base_disease Table.
* @input -
* $output -
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
include_once("Da_wts_base_disease.php");

class M_wts_base_disease extends Da_wts_base_disease {
	
/*
* get_all_disease
* ดึงค่าข้อมูลประเภทโรคทั้งหมด
* @input -
* $output disease
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
	function get_all() {
		$sql = "SELECT ds_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, ds_name_disease_type, ds_name_disease, ds_update_date, ".$this->ums_db.".ums_user.us_name as user_name, ds_active
				FROM wts_base_disease
				LEFT JOIN ".$this->ums_db.".ums_user
				ON ds_create_user = ".$this->ums_db.".ums_user.us_id
				LEFT JOIN ".$this->hr_db.".hr_structure_detail
				ON ds_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
				LEFT JOIN ".$this->hr_db.".hr_structure
				ON ".$this->hr_db.".hr_structure_detail.stde_stuc_id = ".$this->hr_db.".hr_structure.stuc_id
				WHERE ds_active != 2;
				";
		$query = $this->wts->query($sql);

		return $query;		
	}

/*
* get_disease_list
* ดึงค่าข้อมูลประเภทโรคตามไอดีประเภทโรค
* @input ds_id
* $output disease list by ds_id
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
	function get_disease_list($ds_id) {
		$sql = "SELECT ds_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, ds_name_disease_type, ds_name_disease_type_en, ds_name_disease, ds_name_disease_en, ds_detail, ds_detail_en, ds_stde_id, ds_update_date, ".$this->ums_db.".ums_user.us_name as user_name, ds_active
				FROM wts_base_disease
				LEFT JOIN ".$this->ums_db.".ums_user
				ON ds_create_user = ".$this->ums_db.".ums_user.us_id
				LEFT JOIN ".$this->hr_db.".hr_structure_detail
				ON ds_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
				LEFT JOIN ".$this->hr_db.".hr_structure
				ON ".$this->hr_db.".hr_structure_detail.stde_stuc_id = ".$this->hr_db.".hr_structure.stuc_id
				WHERE ds_id = ?;
				";
		$query = $this->wts->query($sql, array($ds_id));
		return $query;		
	}
	
	function get_all_with_detail_server($start, $length, $order_dir, $params) {
		$where = '';
		if(!empty($params)) {
			if (!empty($params['ds_name_disease'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['ds_name_disease'];
				$where .= "(ds_name_disease LIKE '%{$val}%')";
			}
			if (!empty($params['ds_name_disease_type'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['ds_name_disease_type'];
				$where .= "(ds_name_disease_type LIKE '%{$val}%')";
			}
			if (!empty($params['ds_stde_id'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['ds_stde_id'];
				$where .= "(ds_stde_id = {$val})";
			}
			if (!empty($params['search'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['search'];
				$where .= "((ds_name_disease LIKE '%{$val}%') OR (ds_name_disease_type LIKE '%{$val}%') OR (ds_stde_id = {$val}))";
			}
		}

		if (empty($where)) {
			$where .= "WHERE ds_active != 2";
		} else {
			$where .= " AND ds_active != 2";
		}

		$sql_in = "SELECT ds_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, ds_name_disease_type, ds_name_disease, ds_update_date, ".$this->ums_db.".ums_user.us_name as user_name, ds_active
				FROM wts_base_disease
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
* get_all_disease_name_type
* ดึงค่าข้อมูลชื่อประเภทโรคทั้งหมดที่มีการเปิดใช้งาน
* @input ds_id
* $output disease name type by ds_active = 1
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
	function get_all_disease_name_type($ds_active="1") {
		$sql = "SELECT *
				FROM ".$this->wts_db.".wts_base_disease
				WHERE ds_active = '$ds_active'
				GROUP BY ds_name_disease_type
				" ;
		$query = $this->wts->query($sql);
		return $query;
	}

	// function get_all_disease_search($dn_id, $dnt_id, $stde_id)
	// {
	// 	$cond = "";
	// 	if($dn_id != "all"){
	// 		$cond .= "AND ".$this->wts_db.".ds_name_disease = {$dn_id}";
	// 	}
	// 	if($dnt_id != "all"){
	// 		$cond .= "AND ".$this->wts_db.".ds_name_disease_type = {$dnt_id}";
	// 	}
	// 	if($stde_id != "all"){
	// 		$cond .= "AND ".$this->wts_db.".ds_stde_id = {$stde_id}";
	// 	}
	// 	$sql = "SELECT ds_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, ds_name_disease_type, ds_name_disease_type_en, ds_name_disease, ds_name_disease_en, ds_detail, ds_detail_en, ds_stde_id, ds_update_date, ".$this->ums_db.".ums_user.us_name as user_name, ds_active
	// 			FROM wts_base_disease
	// 			LEFT JOIN ".$this->ums_db.".ums_user
	// 			ON ds_create_user = ".$this->ums_db.".ums_user.us_id
	// 			LEFT JOIN ".$this->hr_db.".hr_structure_detail
	// 			ON ds_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
	// 			LEFT JOIN ".$this->hr_db.".hr_structure
	// 			ON ".$this->hr_db.".hr_structure_detail.stde_stuc_id = ".$this->hr_db.".hr_structure.stuc_id
	// 			WHERE 	ds_id = {$ds_id}
	// 					{$cond}";
	// 	$query = $this->wts->query($sql);
	// 	return $query;
	// }

	function get_all_stde_by_level($is_medical = "Y", $status = '2')
	{
		$sql = "SELECT stde.*
				FROM " . $this->hr_db . ".hr_structure_detail stde
				LEFT JOIN " . $this->hr_db . ".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id 
				WHERE stde.stde_is_medical = '$is_medical' AND stuc.stuc_status = 1
				AND stde.stde_active != $status ";
		$query = $this->hr->query($sql);
		return $query;
	}

} // end class M_wts_disease
?>
