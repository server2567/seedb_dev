<?php

include_once("Da_dim_examination_result.php");

class M_dim_examination_result extends Da_dim_examination_result {
	/*
	* get_all_with_detail_server
	* get examination_results server site that owner by user session (officer)
	* @input 
			include_ntr_ast_id: status ที่จะกรอง
			exr_update_user(ums_user id): id ผู้ใช้งานตาม session จาก UMS ที่เป็นเจ้าของ dim_examination_result
	* $output list examination_results
	* @author Areerat Pongurai
	* @Create Date 30/07/2024
	*/
  function get_all_with_detail_server($include_ntr_ast_id, $start, $length, $order_column, $order_dir, $params) {
    $where_in = "";
	
	// if status W then get all
	if (in_array('W', $include_ntr_ast_id)) {
		// if(!empty($this->exr_update_user)) {
		    if(!empty($where_in)) $where_in .= " AND ";
		    else $where_in .= " WHERE ";
		    $where_in .= " (exr.exr_status = 'W') ";
		// }
	}
	// if status Y then get update user is session user
	if (in_array('Y', $include_ntr_ast_id)) {
		if(!empty($this->exr_update_user)) {
		    if(!empty($where_in)) $where_in .= " AND ";
		    else $where_in .= " WHERE ";
		    // $where_in .= " (exr.exr_status = 'Y' AND ((exr.exr_create_user = ".$this->exr_update_user.") OR (exr.exr_update_user IS NOT NULL AND exr.exr_update_user = ".$this->exr_update_user."))) ";
		    $where_in .= " (exr.exr_status = 'Y' AND (exr.exr_update_user IS NOT NULL AND exr.exr_update_user = ".$this->exr_update_user.")) ";
		}
	}
	// if status C then get all
	if (in_array('C', $include_ntr_ast_id)) {
		if(!empty($this->exr_update_user)) {
		    if(!empty($where_in)) $where_in .= " OR ";
		    else $where_in .= " WHERE ";
		    $where_in .= " (exr.exr_status = 'C') ";
		}
	}
	
	// if (in_array('Y', $include_ntr_ast_id) || in_array('C', $include_ntr_ast_id)) {
	// 	if(!empty($this->exr_update_user)) {
	// 	    if(!empty($where_in)) $where_in .= " AND ";
	// 	    else $where_in .= " WHERE ";
	// 	    $where_in .= " ((exr.exr_create_user = ".$this->exr_update_user.") OR (exr.exr_update_user IS NOT NULL AND exr.exr_update_user = ".$this->exr_update_user.")) ";
	// 	}
	// }

    // if (!empty($include_ntr_ast_id)) {
    //     if (empty($where_in)) $where_in .= " WHERE ";
    //     else $where_in .= " AND ";
    //     $include_ntr_ast_id_string = implode(", ", array_map(function($item) {
    //         return "'$item'";
    //     }, $include_ntr_ast_id));
    //     $where_in .= " exr.exr_status IN ({$include_ntr_ast_id_string}) ";
    // }
	// die($where_in);

    $where = '';
    if(!empty($params)) {
        if (!empty($params['month'])) {
            if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
            $val = $params['month'];
            $where .= " (MONTH(exr_inspection_time) = '{$val}')";
        }

        if (!empty($params['date'])) {
            if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
            $val = $params['date'];
            $val = date('Y-m-d', strtotime($val));
            $where .= " (DATE(exr_inspection_time) = '{$val}')";
        }

        if (!empty($params['pt_member'])) {
            if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
            $val = $params['pt_member'];
            $where .= " (pt_member LIKE '%{$val}%')";
        }

        if (!empty($params['pt_name'])) {
            if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
            $val = $params['pt_name'];
            $where .= " (pt_full_name LIKE '%{$val}%')";
        }

        if (!empty($params['eqs_rm_id'])) {
            if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
            $val = $params['eqs_rm_id'];
            $where .= " (eqs_rm_id = {$val})";
        }

        if (!empty($params['eqs_id'])) {
            if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
            $val = $params['eqs_id'];
            $where .= " (eqs_id = {$val})";
        }

        if (!empty($params['search'])) {
            if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
            $val = $params['search'];
            $where .= " (
                    (pt_full_name LIKE '%{$val}%') OR (ps_full_name LIKE '%{$val}%') OR 
                    (pt_member LIKE '%{$val}%') OR (exr_status_text LIKE '%{$val}%') OR (dp_stde_name_th LIKE '%{$val}%') OR
                    (rm_eqs_name LIKE '%{$val}%') OR (DATE_FORMAT(exr_inspection_time, '%d/%m/%Y เวลา %H:%i น.') LIKE '%{$val}%')
                  ) ";
        }
    }

    $sql_in = " SELECT exr.exr_id, exr.exr_inspection_time, exr.exr_pt_id, exr.exr_status, eqs.eqs_id, eqs.eqs_rm_id, 
                CASE WHEN exr.exr_status = 'W' THEN 'รอการตรวจ' 
                    WHEN exr.exr_status = 'Y' THEN 'บันทึกสำเร็จ' 
                    WHEN exr.exr_status = 'C' THEN 'ยกเลิกการตรวจ' 
                    ELSE 'รอการตรวจ' END AS exr_status_text,
                CASE WHEN exr.exr_update_date IS NOT NULL THEN exr.exr_update_date ELSE exr.exr_create_date END AS modified_date,
                CONCAT(rm.rm_name, '/', eqs.eqs_name) rm_eqs_name, 
                CONCAT(dp.dp_name_th, '/', stde.stde_name_th) dp_stde_name_th, 
                CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname) pt_full_name, pt.pt_member, 
                CONCAT(IFNULL(alp.alp_name_abbr, ''), ps.ps_fname, ' ', ps.ps_lname) ps_full_name, 
				apm.apm_visit, apm.apm_ql_code
            FROM dim_examination_result exr
			LEFT JOIN ".$this->ams_db.".ams_notification_results ntr ON ntr.ntr_id = exr.exr_ntr_id
			LEFT JOIN ".$this->que_db.".que_appointment apm ON apm.apm_id = ntr.ntr_apm_id
            LEFT JOIN ".$this->ums_db.".ums_patient pt ON pt.pt_id = exr.exr_pt_id
            LEFT JOIN ".$this->eqs_db.".eqs_equipments eqs ON eqs.eqs_id = exr.exr_eqs_id 
            LEFT JOIN ".$this->eqs_db.".eqs_room rm ON rm.rm_id = eqs.eqs_rm_id 
            LEFT JOIN ".$this->hr_db.".hr_person ps ON ps.ps_id = exr.exr_ps_id
            LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stde.stde_id = exr.exr_stde_id
            LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
            LEFT JOIN ".$this->ums_db.".ums_department dp ON dp.dp_id = stuc.stuc_dp_id
            LEFT JOIN ".$this->hr_db.".hr_person_position pos ON pos.pos_ps_id = ps.ps_id AND stuc.stuc_dp_id = pos.pos_dp_id
            LEFT JOIN ".$this->hr_db.".hr_base_adline_position alp ON alp.alp_id = pos.pos_alp_id
            ".$where_in."
            GROUP BY exr.exr_id, exr.exr_inspection_time, exr.exr_pt_id, exr.exr_status, eqs.eqs_id, eqs.eqs_rm_id, 
                CASE WHEN exr.exr_status = 'W' THEN 'รอการตรวจ' 
                    WHEN exr.exr_status = 'Y' THEN 'บันทึกสำเร็จ' 
                    WHEN exr.exr_status = 'C' THEN 'ยกเลิกการตรวจ' 
                    ELSE 'รอการตรวจ' END,
                CASE WHEN exr.exr_update_date IS NOT NULL THEN exr.exr_update_date ELSE exr.exr_create_date END,
                CONCAT(rm.rm_name, '/', eqs.eqs_name), 
                CONCAT(dp.dp_name_th, '/', stde.stde_name_th), 
                CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname), pt.pt_member, 
                CONCAT(IFNULL(alp.alp_name_abbr, ''), ps.ps_fname, ' ', ps.ps_lname), 
				apm.apm_visit, apm.apm_ql_code
            ORDER BY exr.exr_inspection_time DESC ";

    // get total amount
    $count_sql = "SELECT COUNT(*) as total FROM ( " . $sql_in . ") AS a {$where} ";
    $count_query = $this->dim->query($count_sql);
    $total_records = $count_query->row()->total;

    // get data limit
    $sql = "SELECT * FROM ( " . $sql_in . ") AS a {$where} ";
    if (!empty($order_column) && !empty($order_dir))
        $sql .= " ORDER BY $order_column $order_dir";
    if (!empty($start) && !empty($length))
    	$sql .= " LIMIT ".(int)$start.",  ".(int)$length;

    $query = $this->dim->query($sql);
    
    return ['query' => $query, 'total_records' => $total_records];
  }


	/*
	* get_all_with_detail
	* get examination_results that user session ia a doctor
	* @input 
			exr_status: status ที่จะกรอง
			exr_ps_id(ums_user.us_ps_id): id บุคลากรใน session จาก UMS ที่เป็นแพทย์ผู้รักษา dim_examination_result
	* $output list examination_results
	* @author Areerat Pongurai
	* @Create Date 01/07/2024
	*/
	// (Doctor) get only examination result that owner is session
	// (Doctor) get Y status
	// (Doctor) filter and condition
	function get_all_with_detail_by_filter($exr_status, $filter) {
		$sql = "SELECT exr.exr_id, exr.exr_inspection_time, exr.exr_pt_id, exr.exr_status, eqs.eqs_name, 
					CASE WHEN exr.exr_update_date IS NOT NULL THEN exr.exr_update_date ELSE exr.exr_create_date END AS modified_date,
					CONCAT(dp.dp_name_th, '/', stde.stde_name_th) dp_stde_name, 
					CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname) pt_full_name, pt.pt_member,
					CONCAT(alp.alp_name_abbr, ps.ps_fname, ' ', ps.ps_lname) ps_full_name,
 					CONCAT(alp2.alp_name_abbr, ps2.ps_fname, ' ', ps2.ps_lname) modified_ps_full_name, apm.apm_visit
				FROM dim_examination_result exr
				LEFT JOIN ".$this->ams_db.".ams_notification_results ntr ON ntr.ntr_id = exr.exr_ntr_id
				LEFT JOIN ".$this->que_db.".que_appointment apm ON apm.apm_id = ntr.ntr_apm_id
				LEFT JOIN ".$this->ums_db.".ums_patient pt ON pt.pt_id = exr.exr_pt_id
				LEFT JOIN ".$this->eqs_db.".eqs_equipments eqs ON eqs.eqs_id = exr.exr_eqs_id 
				LEFT JOIN ".$this->hr_db.".hr_person ps ON ps.ps_id = exr.exr_ps_id
				LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stde.stde_id = exr.exr_stde_id
				LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
				LEFT JOIN ".$this->ums_db.".ums_department dp ON dp.dp_id = stuc.stuc_dp_id
				LEFT JOIN ".$this->hr_db.".hr_person_position pos ON pos.pos_ps_id = ps.ps_id AND stuc.stuc_dp_id = pos.pos_dp_id
				LEFT JOIN ".$this->hr_db.".hr_base_adline_position alp ON alp.alp_id = pos.pos_alp_id 
				LEFT JOIN ".$this->hr_db.".hr_person ps2 ON ps2.ps_id = (
					CASE 
						WHEN exr.exr_update_user IS NULL THEN exr.exr_create_user 
						ELSE exr.exr_update_user 
					END
				)
				LEFT JOIN ".$this->hr_db.".hr_person_position pos2 ON pos2.pos_ps_id = ps2.ps_id
				LEFT JOIN ".$this->hr_db.".hr_base_adline_position alp2 ON alp2.alp_id = pos2.pos_alp_id 
				WHERE (exr.exr_ps_id = ".$this->exr_ps_id.") 
					  AND (exr.exr_status = '".$exr_status."') 
					  AND (CONCAT(alp2.alp_name_abbr, ps2.ps_fname, ' ', ps2.ps_lname) IS NOT NULL) ";
		if(is_array($filter) && !empty($filter)) {
			if (isset($filter['eqs_id']) && !empty($filter['eqs_id']))
				$sql .= " AND (exr.exr_eqs_id = ".$filter['eqs_id'].") ";
			if (isset($filter['pt_id']) && !empty($filter['pt_id']))
				$sql .= " AND (exr.exr_pt_id = ".$filter['pt_id'].") ";
			if (isset($filter['stde_id']) && !empty($filter['stde_id']))
				$sql .= " AND (exr.exr_stde_id = ".$filter['stde_id'].") ";
			if (isset($filter['pt_name']) && !empty($filter['pt_name']))
				$sql .= " AND (CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname) LIKE '%".$filter['pt_name']."%') ";
			if ((isset($filter['start_date']) && !empty($filter['start_date'])) || (isset($filter['end_date']) && !empty($filter['end_date']))) 
			{
				$sql .= " AND ((exr_inspection_time >= '".$filter['start_date']."' OR '".$filter['start_date']."' IS NULL)
						  	AND (exr_inspection_time <= '".$filter['end_date']."' OR '".$filter['end_date']."' IS NULL)) ";
			}
		}
		$sql .= "GROUP BY exr.exr_id, exr.exr_status, eqs.eqs_name, 
					CASE WHEN exr.exr_update_date IS NOT NULL THEN exr.exr_update_date ELSE exr.exr_create_date END,
					CONCAT(dp.dp_name_th, '/', stde.stde_name_th), 
					CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname), pt.pt_member,
					CONCAT(alp.alp_name_abbr, ps.ps_fname, ' ', ps.ps_lname),
					CONCAT(alp2.alp_name_abbr, ps2.ps_fname, ' ', ps2.ps_lname), apm.apm_visit
				ORDER BY exr.exr_inspection_time DESC ";
		$query = $this->dim->query($sql);
		return $query;
	}
	
	/*
	* get_detail_by_id
	* get examination_result detail data by exr_id
	* @input exr_id(examination_result id): id ผลตรวจเครื่องมือหัตถการ
	* $output examination_result detail data
	* @author Areerat Pongurai
	* @Create Date 12/07/2024
	*/
	function get_detail_by_id() {
		$sql = "SELECT exr.exr_id, exr.exr_inspection_time, exr.exr_pt_id, exr.exr_status, exr.exr_round, exr.exr_update_user, 
					exr.exr_ntr_id, exr.exr_directory, exr.exr_eqs_id, exr.exr_ps_id, us.us_ps_id update_us_ps_id, 
					rm.rm_name, rm.rm_id, eqs.eqs_name, apm.apm_visit, apm.apm_ql_code, 
					CASE WHEN exr.exr_update_date IS NOT NULL THEN exr.exr_update_date ELSE exr.exr_create_date END AS modified_date,
					dp.dp_name_th, stde.stde_name_th,
					CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname) pt_full_name, pt.pt_member, 
					CONCAT(IFNULL(alp.alp_name_abbr, ''), ps.ps_fname, ' ', ps.ps_lname) ps_full_name,
          eqs_id
				FROM dim_examination_result exr
				LEFT JOIN ".$this->ums_db.".ums_user us ON us.us_id = exr.exr_update_user
				LEFT JOIN ".$this->ums_db.".ums_patient pt ON pt.pt_id = exr.exr_pt_id
				LEFT JOIN ".$this->eqs_db.".eqs_equipments eqs ON eqs.eqs_id = exr.exr_eqs_id 
				LEFT JOIN ".$this->eqs_db.".eqs_room rm ON rm.rm_id = eqs.eqs_rm_id 
				LEFT JOIN ".$this->hr_db.".hr_person ps ON ps.ps_id = exr.exr_ps_id
				LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stde.stde_id = exr.exr_stde_id
				LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
				LEFT JOIN ".$this->ums_db.".ums_department dp ON dp.dp_id = stuc.stuc_dp_id
				LEFT JOIN ".$this->hr_db.".hr_person_position pos ON pos.pos_ps_id = ps.ps_id AND stuc.stuc_dp_id = pos.pos_dp_id
				LEFT JOIN ".$this->hr_db.".hr_base_adline_position alp ON alp.alp_id = pos.pos_alp_id
				LEFT JOIN ".$this->ams_db.".ams_notification_results ntr ON ntr.ntr_id = exr.exr_ntr_id 
				LEFT JOIN ".$this->que_db.".que_appointment apm ON apm.apm_id = ntr.ntr_apm_id 
				WHERE exr.exr_id = ?
				GROUP BY exr.exr_id, exr.exr_inspection_time, exr.exr_status, exr.exr_round, exr.exr_update_user, 
					exr.exr_ntr_id, exr.exr_directory, exr.exr_eqs_id, exr.exr_ps_id, us.us_ps_id, 
					rm.rm_name, eqs.eqs_name, apm.apm_visit, 
					CASE WHEN exr.exr_update_date IS NOT NULL THEN exr.exr_update_date ELSE exr.exr_create_date END,
					dp.dp_name_th, stde.stde_name_th, 
					CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname), pt.pt_member, 
					CONCAT(IFNULL(alp.alp_name_abbr, ''), ps.ps_fname, ' ', ps.ps_lname)
				ORDER BY exr.exr_inspection_time DESC ";
		$query = $this->dim->query($sql, array($this->exr_id));
		return $query;
	}

	/*
	* get_by_ntr_id
	* get examination_result detail data by ntr_id
	* @input ntr_id(ams_notification_results id): id บันทึกผลตรวจจาก AMS
	* $output examination_result detail data
	* @author Areerat Pongurai
	* @Create Date 10/07/2024
	*/
	function get_by_ntr_id() {
		$sql = "SELECT exr.exr_id, exr.exr_ntr_id, exr.exr_round, exr.exr_inspection_time, exr.exr_directory, exr.exr_status, apm.apm_visit, apm.apm_date, 
					rm.rm_name, eqs.eqs_name, exr.exr_eqs_id, rm.rm_id, CONCAT(alp.alp_name_abbr, ps.ps_fname, ' ', ps.ps_lname) update_ps_full_name
				FROM dim_examination_result exr
				LEFT JOIN ".$this->eqs_db.".eqs_equipments eqs ON eqs.eqs_id = exr.exr_eqs_id 
				LEFT JOIN ".$this->eqs_db.".eqs_room rm ON rm.rm_id = eqs.eqs_rm_id 
				LEFT JOIN ".$this->ums_db.".ums_user us ON us.us_id = exr.exr_update_user
				LEFT JOIN ".$this->hr_db.".hr_person ps ON ps.ps_id = us.us_ps_id
				LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stde.stde_id = exr.exr_stde_id
				LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
				LEFT JOIN ".$this->hr_db.".hr_person_position pos ON pos.pos_ps_id = ps.ps_id AND stuc.stuc_dp_id = pos.pos_dp_id
				LEFT JOIN ".$this->hr_db.".hr_base_adline_position alp ON alp.alp_id = pos.pos_alp_id 
				LEFT JOIN ".$this->ams_db.".ams_notification_results ntr ON ntr.ntr_id = exr.exr_ntr_id 
				LEFT JOIN ".$this->que_db.".que_appointment apm ON apm.apm_id = ntr.ntr_apm_id 
				WHERE exr.exr_ntr_id = ? 
				GROUP BY exr.exr_id, exr.exr_ntr_id, exr.exr_round, exr.exr_inspection_time, exr.exr_directory, exr.exr_status, apm.apm_visit, apm.apm_date, 
					rm.rm_name, eqs.eqs_name, exr.exr_eqs_id, rm.rm_id, CONCAT(alp.alp_name_abbr, ps.ps_fname, ' ', ps.ps_lname) ";
		$query = $this->dim->query($sql, array($this->exr_ntr_id));
		return $query;
	}

	/*
	* get_by_ap_id
	* get draft tools data by ap_id
	* @input ap_id(ams_appointment id): id แจ้งเตือนนัดหมายจาก AMS
	* $output draft tool list
	* @author Areerat Pongurai
	* @Create Date 19/08/2024
	*/
	function get_by_ap_id() {
		$sql = "SELECT exr.exr_id, exr.exr_ap_id, exr.exr_status, 
					rm.rm_name, eqs.eqs_name, exr.exr_eqs_id, rm.rm_id
				FROM dim_examination_result exr
				LEFT JOIN ".$this->eqs_db.".eqs_equipments eqs ON eqs.eqs_id = exr.exr_eqs_id 
				LEFT JOIN ".$this->eqs_db.".eqs_room rm ON rm.rm_id = eqs.eqs_rm_id 
				WHERE exr.exr_ap_id = ? 
				GROUP BY exr.exr_id, exr.exr_ap_id, exr.exr_status, 
					rm.rm_name, eqs.eqs_name, exr.exr_eqs_id, rm.rm_id ";
		$query = $this->dim->query($sql, array($this->exr_ap_id));
		return $query;
	}

	/*
	* check_amount_by_ntr_id
	* get count of examination_results by ntr_id
	* @input ntr_id(ams_notification_results id): id บันทึกผลตรวจจาก AMS
	* $output count of examination_results
	* @author Areerat Pongurai
	* @Create Date 24/07/2024
	*/
	function check_amount_by_ntr_id($exr_status = null) {
		$where = '';
		if(!empty($exr_status))
			$where = " AND exr.exr_status = '{$exr_status}' ";

		$sql = "SELECT DISTINCT COUNT(exr.exr_id) amount_exr
				FROM dim_examination_result exr
				WHERE exr.exr_ntr_id = ? {$where}";
		$query = $this->dim->query($sql, array($this->exr_ntr_id));
		return $query;
	}

	/*
	* update_status
	* update status
	* @input 
			exr_status: status ที่จะอัปเดต
			exr_id(dim_examination_result id): id ผลตรวจเครื่องมือหัตถการ
			exr_update_user(ums_user id): id ผู้ใช้งานตาม session จาก UMS
	* $output count of examination_results
	* @author Areerat Pongurai
	* @Create Date 15/07/2024
	*/
	function update_status() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE dim_examination_result 
				SET	exr_status=?, exr_update_user=?, exr_update_date=NOW()
				WHERE exr_id=? ";	
		 
		$this->dim->query($sql, array($this->exr_status, $this->exr_update_user, $this->exr_id));
	}

	/*
	* update_status_dir
	* update status and directory data
	* @input 
			exr_directory: path เก็บไฟล์
			exr_inspection_time: เวลาที่สั่งตรวจ
			exr_status: status ที่จะอัปเดต
			exr_id(dim_examination_result id): id ผลตรวจเครื่องมือหัตถการ
			exr_update_user(ums_user id): id ผู้ใช้งานตาม session จาก UMS
	* $output count of examination_results
	* @author Areerat Pongurai
	* @Create Date 15/07/2024
	*/
	function update_status_dir() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE dim_examination_result 
				SET	exr_status=?, exr_directory=?, exr_inspection_time=?, exr_update_user=?, exr_update_date=NOW()
				WHERE exr_id=? ";	
		 
		$this->dim->query($sql, array($this->exr_status, $this->exr_directory, $this->exr_inspection_time, $this->exr_update_user, $this->exr_id));
	}

	/*
	* get_department_id_with_exr_stde_id
	* get hr_structure.stuc_dp_id by exr_stde_id
	* @input exr_stde_id(hr_structure_detail id): id แผนกจาก HR
	* $output hr_structure.stuc_dp_id
	* @author Areerat Pongurai
	* @Create Date 01/07/2024
	*/
	function get_department_id_with_exr_stde_id(){
		$sql = "SELECT DISTINCT stuc.stuc_dp_id
				FROM ".$this->hr_db.".hr_structure_detail stde
				LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
				WHERE stde.stde_id = ?";
		$query = $this->dim->query($sql, array($this->exr_stde_id));
		return $query;
	}

	/*
	* get_check_round_by_patient_id
	* get max_round of patient in that date
	* @input 
			exr_pt_id(ums_patient id): id ผู้ป่วยจาก UMS
			exr_inspection_time: วันที่จะเช็ครอบ
	* $output max_round
	* @author Areerat Pongurai
	* @Create Date 01/07/2024
	*/
	function get_check_round_by_patient_id(){
		// Assuming $this->exr_inspection_time is in 'Y-m-d H:i:s' format
		$date = date('Y-m-d', strtotime($this->exr_inspection_time));
		$sql = "SELECT MAX(exr_round) AS max_round
				FROM dim_examination_result
				WHERE exr_pt_id = ? AND DATE(exr_inspection_time) = ?";
		$query = $this->dim->query($sql, array($this->exr_pt_id, $date));
		return $query;
	}

	/*
	* get_check_round_by_not_ntr_id
	* get max_round of notification result in that date that have another notification result or not
	* @input 
			exr_ntr_id(ams_notification_result id): id ผลตรวจจาก AMS ที่ไม่ต้องการเช็ค
			exr_inspection_time: วันที่จะเช็ครอบ
	* $output max_round
	* @author Areerat Pongurai
	* @Create Date 31/07/2024
	*/
	function get_check_round_by_not_ntr_id(){
		// Assuming $this->exr_inspection_time is in 'Y-m-d H:i:s' format
		$date = date('Y-m-d', strtotime($this->exr_inspection_time));
		$sql = "SELECT MAX(exr_round) AS max_round
				FROM dim_examination_result
				WHERE exr_ntr_id <> ? AND DATE(exr_inspection_time) = ?";
		$query = $this->dim->query($sql, array($this->exr_ntr_id, $date));
		return $query;
	}

	/*
	* get_persons_by_structure
	* ดึงข้อมูลบุคลากรของแผนกที่เลือก (HR)
	* @input stuc_id(structure detail id): id แผนก
	* $output list of บุคลากรของแผนกที่เลือก
	* @author Areerat Pongurai
	* @Create Date 09/07/2024
	*/
	function get_persons_by_structure($stuc_id = null){
		$sql = "SELECT 
					*,
					CONCAT(ps.ps_fname, ' ', ps.ps_lname) AS full_name,
					JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', ad.admin_name)) AS admin_position,
					JSON_ARRAYAGG(DISTINCT JSON_OBJECT('spcl_name', spcl.spcl_name)) AS spcl_position
				FROM  " . $this->hr_db . ".hr_structure_person AS sp
				INNER JOIN " . $this->hr_db . ".hr_person AS ps ON sp.stdp_ps_id = ps.ps_id
				INNER JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
				INNER JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
				LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS psap ON psap.psap_pos_id = pos.pos_admin_id
				LEFT JOIN " . $this->hr_db . ".hr_base_admin_position AS ad ON ad.admin_id = psap.psap_admin_id
				LEFT JOIN " . $this->hr_db . ".hr_person_special_position AS pssp ON pssp.pssp_pos_id = pos.pos_spcl_id
				LEFT JOIN " . $this->hr_db . ".hr_base_special_position AS spcl ON spcl.spcl_id = pssp.pssp_spcl_id
				LEFT JOIN " . $this->hr_db . ".hr_base_adline_position AS adline ON adline.alp_id = pos.pos_alp_id
				WHERE sp.stdp_stde_id = $stuc_id AND sp.stdp_active != 2
				GROUP BY ps.ps_id";
		$query = $this->dim->query($sql);
		return $query;
	}
	
	/*
	* update_ams_ntr_ast_id
	* อัปเดตสถานะบันทึกผลตรวจที่ AMS เพื่อให้แพทย์ดูผลตรวจเครื่องมือหัตถการและดำเนินการบันทึกผล จากสถานะ 5-"รอผลตรวจจากเครื่องมือหัตถการ (TW)" เป็น 10-"ได้รับผลตรวจจากเครื่องมือหัตถการ (TS)"
	* @input exr_id(dim_examination_result id): id บันทึกผลเครื่องมือหัตถการ เพื่อไปหา ams_notification_results id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 10/07/2024
	*/
	function update_ams_ntr_ast_id(){
		$sql = "UPDATE " . $this->ams_db . ".ams_notification_results 
				SET ntr_ast_id = (SELECT MAX(DISTINCT ast_id) FROM " . $this->ams_db . ".ams_base_status WHERE ast_character = 'TS') 
				WHERE ntr_id = (SELECT DISTINCT exr_ntr_id FROM dim_examination_result WHERE exr_id = ?)";
		$query = $this->dim->query($sql, array($this->exr_id));
		return $query;
	}
	
	/*
	* update_wts_apm_sta_id
	* อัปเดตสถานะคิวที่ WTS เพื่อให้ จนท แผนก เห็นแล้วเรียกคิวได้ จากสถานะ 11-"กำลังตรวจในห้องปฏิบัติการ (TW)" เป็น 12-"ตรวจในห้องปฏิบัติการเสร็จแล้ว (TS)"
	* @input exr_id(dim_examination_result id): id บันทึกผลเครื่องมือหัตถการ เพื่อไปหา que_appointment id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 19/07/2024
	*/
	function update_wts_apm_sta_id(){
		$sql = "UPDATE " . $this->que_db . ".que_appointment
				SET apm_sta_id = (SELECT MAX(DISTINCT sta_id) FROM " . $this->que_db . ".que_base_status WHERE sta_character = 'TS') 
				WHERE apm_id = (
					SELECT DISTINCT ntr_apm_id FROM " . $this->ams_db . ".ams_notification_results WHERE ntr_id = (
						SELECT DISTINCT exr_ntr_id FROM dim_examination_result WHERE exr_id = $this->exr_id)
					) ";
		$query = $this->dim->query($sql, array($this->exr_id));
		return $query;
	}
	
	/*
	* update_exr
	* update data from DIM when upload files and need to change status
	* @input exr_status=, exr_ip_internet=, exr_ip_computer=, exr_update_user=, exr_update_date=NOW()
	* $output -
	* @author Areerat Pongurai
	* @Create Date 12/07/2024
	*/
	function update_exr() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE dim_examination_result 
				SET	exr_status=?, exr_ip_internet=?, exr_ip_computer=?, exr_update_user=?, exr_update_date=NOW()
				WHERE exr_id=? ";	
		 
		$this->dim->query($sql, array($this->exr_status, $this->exr_ip_internet, $this->exr_ip_computer, $this->exr_update_user, $this->exr_id));
	}

	/*
	* get_exr_id_by_ntr_id
	* get exr_id by ntr_id for check have examination_result before
	* @input ntr_id(ams_notification_results id): id บันทึกผลตรวจจาก AMS
	* $output examination_result id
	* @author Areerat Pongurai
	* @Create Date 19/07/2024
	*/
	function get_exr_id_by_ntr_id() {
		$sql = "SELECT exr_id
				FROM dim_examination_result
				WHERE exr_ntr_id = ? ";
		$query = $this->dim->query($sql, array($this->exr_ntr_id));
		return $query;
	}

	/*
	* update_remove_draft_exclude_id
	* update draft tool is not use anymore
	* @input exclude_id(dim_examination_result id): id คำสั่งตรวจจาก AMS
	* $output -
	* @author Areerat Pongurai
	* @Create Date 09/08/2024
	*/
	function update_remove_draft_exclude_id($exclude_id) {
		$sql = "UPDATE dim_examination_result 
				SET	exr_status = ?
				WHERE exr_status = 'D' AND exr_ntr_id = ? AND exr_id not in ({$exclude_id})";
		$query = $this->dim->query($sql, array($this->exr_status, $this->exr_ntr_id));
	}
	
	/*
	* update_exr_ntr_id_by_apm_id
	* update exr_ntr_id from apm_parent_id (que_appointment id) that insert from ams_appointment
	* @input exr_ntr_id, apm_parent_id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 19/08/2024
	*/
	function update_exr_ntr_id_by_apm_id($apm_parent_id) {
		$sql = "UPDATE dim_examination_result 
				SET	exr_ntr_id = ?
				WHERE exr_ap_id = (
					SELECT ap_id FROM see_amsdb.ams_appointment WHERE ap_ntr_id = (
						SELECT ntr_id FROM see_amsdb.ams_notification_results WHERE ntr_apm_id = ?)
					)
				); ";	
		 
		$this->dim->query($sql, array($this->exr_ntr_id, $apm_parent_id));
	}

	/*
	* get_exr_by_tool_and_pt_id
	* get all DIM - examination result files by tool(eqs_id)
	* @input 
			$exr_eqs_id(eqs_equipment id), 
			$apm_pt_id(ums_patient id), 
			$apm_ds_id(wts_disease id)
	* $output examination_result id
	* @author Areerat Pongurai
	* @Create Date 05/09/2024
	*/
	function get_exr_by_tool_and_pt_id($exr_eqs_id, $apm_pt_id, $apm_stde_id, $apm_ds_id = null) {
		$where = " WHERE exr_eqs_id = {$exr_eqs_id} AND apm.apm_pt_id = {$apm_pt_id} AND apm.apm_stde_id = {$apm_stde_id} ";
		if(!empty($apm_ds_id)) $where .= " AND apm.apm_ds_id = {$apm_ds_id} ";
		$sql = "SELECT exr.exr_id
				FROM dim_examination_result exr
				LEFT JOIN see_amsdb.ams_notification_results ntr ON exr.exr_ntr_id = ntr.ntr_id 
				LEFT JOIN see_quedb.que_appointment apm ON ntr.ntr_apm_id = apm.apm_id 
				{$where} ";
		$query = $this->dim->query($sql, array($exr_eqs_id));
		return $query;
	}

	function get_eqs_id($exr_id)
    {
        $sql = "SELECT * FROM `dim_examination_result` WHERE exr_id = '".$exr_id."'";
        $query = $this->dim->query($sql);
        $result = $query->row();
        return $result;
    }
	function get_exrd_id($exrd_exr_id, $exrd_file_name)
    {
        $sql = "SELECT * FROM `dim_examination_result_doc` WHERE exrd_exr_id = '".$exrd_exr_id."' 
		        AND exrd_file_name = '".$exrd_file_name."' AND exrd_status = 1";
        $query = $this->dim->query($sql);
        $result = $query->row();
		// pre($result);
		// die();
        return $result;
    }

	function insert_pre_lab_result($data) {
		// pre($data);
		// die();
		// เตรียมข้อมูลสำหรับการแทรกลงในฐานข้อมูล
		$insert_data = [
			'exrdtp_exrd_id'    => $data['exrd_id'],
			'exrdtp_pt_id'      => $data['pt_id'],
			'exrdtp_type'       => $data['test_type'],
			'exrdtp_test'       => $data['test_name'],
			'exrdtp_given_name' => $data['test_given_name'],
			'exrdtp_value'      => $data['test_value'],
			'exrdtp_unit'       => $data['test_unit'],
			'exrdtp_level'      => $data['test_level'],
			'exrdtp_range'      => $data['test_range'],
			'exrdtp_date'       => $data['test_date'],
			'exrdtp_created'    => date('Y-m-d H:i:s'), // เพิ่มเวลาที่บันทึก
			'exrdtp_updated'    => date('Y-m-d H:i:s')  // เพิ่มเวลาที่อัปเดตล่าสุด
		];
	
		// แทรกข้อมูลลงในตาราง dim_examination_result_doc_test_pre
		$this->dim->insert('dim_examination_result_doc_test_pre', $insert_data);
	
		// ตรวจสอบว่าแทรกข้อมูลสำเร็จหรือไม่
		if ($this->dim->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function insert_lab_result($data) {
		// เตรียมข้อมูลสำหรับการแทรกลงในฐานข้อมูล
		$insert_data = [
			'exrdt_exrd_id'    => $data['exrd_id'],
			'exrdt_pt_id'      => $data['pt_id'],
			'exrdt_type'       => $data['test_type'],
			'exrdt_test'       => $data['test_name'],
			'exrdt_given_name' => $data['test_given_name'],
			'exrdt_value'      => $data['test_value'],
			'exrdt_unit'       => $data['test_unit'],
			'exrdt_level'	   => $data['test_level'],
			'exrdt_range'  	   => $data['test_range'],
			'exrdt_date'       => $data['test_date'],
			'exrdt_created'    => date('Y-m-d H:i:s'), // เพิ่มเวลาที่บันทึก
			'exrdt_updated'    => date('Y-m-d H:i:s')  // เพิ่มเวลาที่อัปเดตล่าสุด
		];
	
		// แทรกข้อมูลลงในตาราง dim_examination_result_doc_test
		$this->dim->insert('dim_examination_result_doc_test', $insert_data);
	
		// ตรวจสอบว่าแทรกข้อมูลสำเร็จหรือไม่
		if ($this->dim->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function update_lab_result($id, $data)
	{
		$this->db->where('exrdt_id', $id);
		$this->db->update('lab_results', $data);
	}

	public function get_results_by_exrd_id($exrd_id)
	{
		$sql = "SELECT * FROM `dim_examination_result_doc_test_pre` WHERE exrdtp_exrd_id = '".$exrd_id."'";
        $query = $this->dim->query($sql);
        $result = $query->result();
        return $result;
	}

	public function get_patient_info($exrd_id)
	{
		$sql = "SELECT CONCAT(UP.pt_prefix,UP.pt_fname,' ',UP.pt_lname) AS fullname, UP.pt_member, UPD.ptd_sex, CONCAT(HBP.pf_name_abbr,HP.ps_fname,' ',HP.ps_lname) AS doctor, DER.exr_create_date, 
					CASE 
						WHEN UPD.ptd_birthdate IS NOT NULL THEN TIMESTAMPDIFF(YEAR, UPD.ptd_birthdate, CURDATE()) 
						ELSE '' 
					END AS age FROM see_dimdb.dim_examination_result_doc AS DERD
				LEFT JOIN  see_dimdb.dim_examination_result AS DER ON (DERD.exrd_exr_id  = DER.exr_id)
				LEFT JOIN  see_umsdb.ums_patient AS UP ON (DER.exr_pt_id  = UP.pt_id)
				LEFT JOIN  see_umsdb.ums_patient_detail AS UPD ON (UP.pt_id  = UPD.ptd_pt_id)
				LEFT JOIN  see_hrdb.hr_person AS HP ON (DER.exr_ps_id  = HP.ps_id)
				LEFT JOIN  see_hrdb.hr_base_prefix AS HBP ON (HP.ps_pf_id  = HBP.pf_id)
				WHERE DERD.exrd_id  = '".$exrd_id."'";
        $query = $this->dim->query($sql);
        $result = $query->row();
		// pre($result);
		// die();
        return $result;
	}

} // end class M_dim_examination_result

?>
