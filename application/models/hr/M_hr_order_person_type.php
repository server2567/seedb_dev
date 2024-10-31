<?php
/*
 * M_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("Da_hr_order_person_type.php");

class M_hr_order_person_type extends Da_hr_order_person_type
{
	function get_order_person_type_active($delete = '2')
	{
		$sql = "SELECT *,st.st_name_th as ordt_st_name ,mn.mn_name_th as ordt_mn_name FROM " . $this->hr_db . ".hr_order_data_type as ordt
		LEFT JOIN ".$this->ums_db.".ums_menu as mn 
		   ON mn.mn_id = ordt.ordt_menu_id
		 LEFT JOIN ".$this->ums_db.".ums_system as st 
		   ON st.st_id = mn.mn_st_id
		WHERE ordt_active != '$delete'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_order_person_type_by_id($id)
	{
		$sql = "SELECT * FROM " . $this->hr_db . ".hr_order_data_type WHERE ordt_id = '$id'";
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
	function get_person_default($dp_id, $highest = 'Y', $ps_status= '2',$delete = 'N')
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
					*,JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', ad.admin_name)) AS admin_position,
               JSON_ARRAYAGG(DISTINCT JSON_OBJECT('spcl_name', spcl.spcl_name)) AS spcl_position 
				FROM " . $this->hr_db . ".hr_person as ps
				LEFT JOIN " . $this->hr_db . ".hr_base_prefix as pf 
					ON ps.ps_pf_id = pf.pf_id
				LEFT JOIN " . $this->hr_db . ".hr_person_position as pos 
					ON pos.pos_ps_id = ps.ps_id
				LEFT JOIN " . $this->hr_db . ".hr_person_admin_position as pap
				    ON pos.pos_admin_id = pap.psap_pos_id
				LEFT JOIN " . $this->hr_db . ".hr_person_special_position AS pssp 
                    ON pos.pos_spcl_id = pssp.pssp_pos_id
				LEFT JOIN " . $this->hr_db. ".hr_base_hire as hire
				    ON pos.pos_hire_id = hire.hire_id
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
				WHERE ps.ps_status != '$ps_status' {$hr_is_medical} AND pos.pos_dp_id = '$dp_id'  AND psed.edu_highest = '$highest' AND pos.pos_active != '$delete'  or (psed.edu_ps_id IS NULL {$hr_is_medical} AND ps.ps_status != '$ps_status'  AND pos.pos_dp_id = '$dp_id' AND pos.pos_active != '$delete' )
				GROUP BY ps.ps_id ORDER BY ps.ps_fname ASC;";
			
		$query = $this->hr->query($sql);
		return $query;
	} //end get_all_profile_data
	function get_order_person_type_option($dp_id, $id = null, $delete = "2")
	{
		$sql = "SELECT * FROM " . $this->hr_db . ".hr_order_data_type WHERE ordt_dp_id = '$dp_id'  AND ordt_active !='$delete'" . ($id != null ? " AND ordt_id != '$id'" : '');
		$query = $this->hr->query($sql);
		return $query;
	}
} // end class M_hr_person
