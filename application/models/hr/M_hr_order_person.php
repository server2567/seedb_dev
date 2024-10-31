<?php
/*
 * M_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("Da_hr_order_person.php");

class M_hr_order_person extends Da_hr_order_person
{
	function get_order_person_type_active($delete = '2')
	{
		$sql = "SELECT * FROM" . $this->hr_db . ".hr_order_person_type WHERE ordt_active != '$delete'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_order_person_data_by_type($type)
	{
		$sql = "SELECT * FROM " . $this->hr_db . ".hr_order_data WHERE ord_ordt_id = '$type'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_order_person_data_by_option($type, $dp_id, $higest = 'Y', $pos_status = 'all')
	{
		if ($this->session->userdata('hr_hire_is_medical')) {
			$hr_hire = $this->session->userdata('hr_hire_is_medical');
			$hr_is_medical = "AND (";
			$count = count($hr_hire);
			foreach ($hr_hire as $key => $value) {
				if ($count - 1 == $key) {
					$hr_is_medical .= "hire.hire_is_medical = '{$value['type']}'";
				} else {
					$hr_is_medical .= "hire.hire_is_medical = '{$value['type']}' OR ";
				}
			}
			$hr_is_medical .= ')';
		}
		$sql = "SELECT 
            *,
            JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', ad.admin_name)) AS admin_position,
            JSON_ARRAYAGG(DISTINCT JSON_OBJECT('spcl_name', spcl.spcl_name)) AS spcl_position
        FROM " . $this->hr_db . ".hr_order_data as ord
        LEFT JOIN " . $this->hr_db . ".hr_person as ps
            ON ps.ps_id = ord.ord_ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix as pf 
            ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position as pos 
            ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire as hire
            ON pos.pos_hire_id = hire.hire_id
        LEFT JOIN " . $this->hr_db . ".hr_person_admin_position as pap
            ON pos.pos_admin_id = pap.psap_pos_id
        LEFT JOIN " . $this->hr_db . ".hr_person_special_position AS pssp 
            ON pos.pos_spcl_id = pssp.pssp_pos_id
        LEFT JOIN " . $this->hr_db . ".hr_base_admin_position as ad 
            ON pap.psap_admin_id = ad.admin_id
        LEFT JOIN " . $this->hr_db . ".hr_base_adline_position as alp
            ON pos.pos_alp_id = alp.alp_id
        LEFT JOIN " . $this->hr_db . ".hr_base_special_position as spcl
            ON pssp.pssp_spcl_id = spcl.spcl_id
        LEFT JOIN " . $this->hr_db . ".hr_person_education as psed
            ON ps.ps_id = psed.edu_ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_education_level as edulv
            ON psed.edu_edulv_id = edulv.edulv_id
        WHERE 
            (ord.ord_ordt_id = '$type' {$hr_is_medical} AND pos.pos_dp_id = '$dp_id' AND psed.edu_highest = '$higest'" . ($pos_status == 'all' ? '' : ' AND pos.pos_status = ' . $pos_status) . ") 
            OR 
            (ord.ord_ordt_id = '$type' {$hr_is_medical} AND pos.pos_dp_id = '$dp_id' AND psed.edu_id IS NULL" . ($pos_status == 'all' ? '' : ' AND pos.pos_status = ' . $pos_status) . ")
        GROUP BY ps.ps_id 
        ORDER BY ord.ord_seq ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	/*
	* get_all_profile_data
	* ข้อมูลบุคลากรทั้งหมด
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_person_by_id($id, $dp_id, $ordt_id = null, $higest = 'Y')
	{
		if ($this->session->userdata('hr_hire_is_medical')) {
			$hr_hire = $this->session->userdata('hr_hire_is_medical');
			$hr_is_medical = "AND (";
			$count = count($hr_hire);
			foreach ($hr_hire as $key => $value) {
				if ($count - 1 == $key) {
					$hr_is_medical .= "hire.hire_is_medical = '{$value['type']}'";
				} else {
					$hr_is_medical .= "hire.hire_is_medical = '{$value['type']}' OR ";
				}
			}
			$hr_is_medical .= ')';
		}
		$sql = "SELECT 
					*,
			    JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', ad.admin_name)) AS admin_position,
               JSON_ARRAYAGG(DISTINCT JSON_OBJECT('spcl_name', spcl.spcl_name)) AS spcl_position
				FROM " . $this->hr_db . ".hr_person as ps
				LEFT JOIN " . $this->hr_db . ".hr_base_prefix as pf 
					ON ps.ps_pf_id = pf.pf_id
					LEFT JOIN " . $this->hr_db . ".hr_order_data as ord
					ON ord.ord_ps_id = ps.ps_id
				LEFT JOIN " . $this->hr_db . ".hr_person_position as pos 
					ON pos.pos_ps_id = ps.ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_hire as hire
				    ON pos.pos_hire_id = hire.hire_id
				LEFT JOIN " . $this->hr_db . ".hr_person_admin_position as pap
				    ON pos.pos_admin_id = pap.psap_pos_id
				LEFT JOIN " . $this->hr_db . ".hr_person_special_position AS pssp 
                    ON pos.pos_spcl_id = pssp.pssp_pos_id
				LEFT JOIN " . $this->hr_db . ".hr_base_admin_position as ad 
					ON pap.psap_admin_id = ad.admin_id
				LEFT JOIN " . $this->hr_db . ".hr_base_adline_position as alp
					ON pos.pos_alp_id = alp.alp_id
				LEFT JOIN " . $this->hr_db . ".hr_base_special_position as spcl
					ON pssp.pssp_spcl_id = spcl.spcl_id
                LEFT JOIN " . $this->hr_db . ".hr_person_education as psed
					ON ps.ps_id = psed.edu_ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_education_level as edulv
					ON psed.edu_edulv_id = edulv.edulv_id
				WHERE ps_id = '$id' {$hr_is_medical} AND psed.edu_highest = '$higest' AND pos.pos_dp_id = '$dp_id'" . ($ordt_id != null ? ' AND ord.ord_ordt_id = ' . $ordt_id : '') . " OR (ps_id = '$id'" . ($ordt_id != null ? ' AND ord.ord_ordt_id =' . $ordt_id : '') . " AND pos.pos_dp_id = '$dp_id' AND  psed.edu_id IS NULL)
				GROUP BY ps.ps_id";
		$query = $this->hr->query($sql);
		return $query;
	} //end get_all_profile_data
	function get_all_order_type_by_person($ps_id, $dp_id)
	{
		$sql = "SELECT * FROM " . $this->hr_db . ".hr_order_data as ord 
	        WHERE ord.ord_ordt_id IN " . "(SELECT ordt_id FROM " . $this->hr_db . ".hr_order_data_type WHERE ordt_dp_id = '$dp_id'" . "AND ordt_id IN (SELECT ord_ordt_id FROM " . $this->hr_db . ".hr_order_data where ord_ps_id = '$ps_id' )) AND ord_ps_id != '$ps_id' ORDER BY ord_ordt_id ,ord_seq";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_menu_option()
	{
		$system = ['3', '10'];
		$mn_id = ['1000002', '1000003'];
		$sql = "SELECT *,
				JSON_ARRAYAGG(DISTINCT JSON_OBJECT('mn_name_th', mn.mn_name_th, 'mn_id', mn.mn_id)) AS mn_name
				FROM " . $this->ums_db . ".ums_system as st
				LEFT JOIN " . $this->ums_db . ".ums_menu as mn
				ON mn.mn_st_id = st.st_id
				WHERE 
					st.st_id IN ($system[0], $system[1])
				 AND (st.st_id != $system[1]  OR (mn.mn_id IN ($mn_id[0],$mn_id[1])))		
                 GROUP BY st.st_id";

		$query = $this->hr->query($sql);
		return $query;
	}
} // end class M_hr_person
