<?php

include_once("Da_wts_base_route_department.php");

class M_wts_base_route_department extends Da_wts_base_route_department {

/*
* get_all_disease_time
* ดึงข้อมูลระยะเวลาของประเภทโรค
* @input -
* $output disease time list
* @author Supawee Sangrapee
* @Create Date 03/06/2024
*/
	function get_all() {
		$sql = "SELECT rdp_id, rdp_name, rdp_ds_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, rdp_active, rdp_update_user, rdp_update_date
                FROM ".$this->wts_db.".wts_base_route_department
                LEFT JOIN ".$this->hr_db.".hr_structure_detail
                ON rdp_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
                WHERE rdp_active != 2;
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
	function get_route_dept_list($rdp_id) {
		$sql = "SELECT rdp_id, rdp_name, rdp_ds_id, rdp_stde_id, ".$this->hr_db.".hr_structure_detail.stde_name_th, rdp_active, rdp_update_user, rdp_update_date
                FROM ".$this->wts_db.".wts_base_route_department
                LEFT JOIN ".$this->hr_db.".hr_structure_detail
                ON rdp_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
                WHERE rdp_id = ?;
				";
		$query = $this->wts->query($sql, array($rdp_id));
		return $query;		
	}

    function get_all_rdp_name() {
		$sql = "SELECT *
				FROM ".$this->wts_db.".wts_base_route_department
				WHERE rdp_active != 2
				GROUP BY rdp_name
				" ;
		$query = $this->wts->query($sql);
		return $query;
	}

	function get_rdp_stde_id_by_rdp_id($rdp_id) {

		$sql = "SELECT *
				FROM wts_base_route_department
				WHERE rdp_id = ?
		";
		$query = $this->wts->query($sql, array($rdp_id));

		return $query;
	}

	function get_rdp_name_by_stde_id() {
		$sql = "SELECT *
		FROM wts_base_route_department
		WHERE rdp_id = ?
		";
		$query = $this->wts->query($sql, array($rdp_id));

		return $query;

	}

	function get_rdp_id_and_rt_dst_id ($ds_id){
		$sql = "SELECT 
					*
				FROM 
					wts_base_route_department
				LEFT JOIN 
					".$this->wts_db.".wts_base_route_time
					ON rt_rdp_id = `rdp_id` AND rt_seq = 1
				WHERE rdp_ds_id = ?" ; 
		$query = $this->wts->query($sql , array(
				$ds_id	
		));
		return $query;
	}

    /*
    * get_by_stde_and_ds
    * get base_route_department data by stde_id and ds_id
    * @input 
		stde_id(hr_structure_detail id): ไอดีแผนก
		ds_id(wts_base_disease id): ไอดีประเภทโรคผู้ป่วย
    * $output base_route_department data
    * @author Areerat Pongurai
    * @Create Date 17/07/2024
    */
    function get_by_stde_and_ds() {
        $sql = "SELECT rdp_id
                FROM ".$this->wts_db.".wts_base_route_department
                WHERE rdp_stde_id = ? AND rdp_ds_id = ? ";
        $query = $this->wts->query($sql, array($this->rdp_stde_id, $this->rdp_ds_id));
        return $query;		
    }

	function get_all_with_detail_server($start, $length, $order_dir, $params) {
		$where = '';
		if(!empty($params)) {
			if (!empty($params['rdp_name'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['rdp_name'];
				$where .= "(rdp_name LIKE '%{$val}%')";
			}
			if (isset($params['rdp_stde_id']) && $params['rdp_stde_id'] !== '') {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['rdp_stde_id'];
				$where .= "(rdp_stde_id = {$val})";
			}
			if (isset($params['rdp_active']) && $params['rdp_active'] !== '') {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['rdp_active'];
				$where .= "(rdp_active = {$val})";
			}
			if (!empty($params['search'])) {
				if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
				$val = $params['search'];
				$where .= "((rdp_name LIKE '%{$val}%') OR (rdp_stde_id = {$val}) OR (rdp_active = {$val}))";
			}
		}

		if (empty($where)) {
			$where .= "WHERE rdp_active != 2";
		} else {
			$where .= " AND rdp_active != 2";
		}
		
		$sql_in = "SELECT rdp_id, rdp_name, rdp_ds_id, rdp_stde_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, rdp_active, rdp_update_user, rdp_update_date
					FROM ".$this->wts_db.".wts_base_route_department
					LEFT JOIN ".$this->hr_db.".hr_structure_detail
					ON rdp_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
				".$where."
				";
		$count_sql = "SELECT COUNT(*) as total FROM (" . $sql_in .") AS a ";
		$count_query = $this->wts->query($count_sql);
		$total_records = $count_query->row()->total;
	
		$sql = "SELECT * FROM ( " . $sql_in . ") AS a ";
		// if (!empty($order_dir))
		//     $sql .= " ORDER BY $order_dir";
		$sql .= " LIMIT ".(int)$start.",  ".(int)$length;
	
		$query = $this->wts->query($sql);
		
		return ['query' => $query, 'total_records' => $total_records];
	}
	
} // end class M_wts_base_disease_time
?>
