<?php
/*
 * m_hr_structure_detail
 * Model for Manage about hr_structure_detail Table.
 * @Author Dechathon Prajit
 * @Create Date 2567-05-28
*/
include_once("Da_hr_structure.php");

class M_hr_structure extends Da_hr_structure
{

	function get_all_by_active($active = "3")
	{
		$sql = "SELECT * 
				FROM " . $this->hr_db . ".hr_structure
				WHERE stuc_status != '$active' 
				ORDER BY 
				CASE stuc_status
					WHEN '1' THEN 1
					WHEN '2' THEN 2
					WHEN '0' THEN 3
					ELSE 4 -- กำหนดลำดับสุดท้ายสำหรับค่าอื่นๆ (ถ้ามี)
				END,stuc_create_date DESC;";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_department_active()
	{
		$sql = "SELECT * 
				FROM " . $this->ums_db . ".ums_department";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_department_by_id($dp_id)
	{
		$sql = "SELECT * 
				FROM " . $this->ums_db . ".ums_department
				WHERE dp_id = '$dp_id'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_stde_detail_by_id($id, $active = '2')
	{
		$sql = "SELECT * 
				FROM " . $this->hr_db . ".hr_structure_detail
				WHERE stde_stuc_id = '$id' and stde_active != '$active'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_stuc_by_id($id)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_structure
				WHERE stuc_id = '$id'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_person($status = 1)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_person  as ps
				INNER JOIN hr_base_prefix as pf on pf.pf_id = ps.ps_pf_id
				WHERE ps_status = '$status'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_person_position($id, $dp_id)
	{
		$sql = "SELECT COALESCE(adline.alp_name, '-') AS alp_name,
		        JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', COALESCE(ad.admin_name, '-'))) AS admin_position,
                JSON_ARRAYAGG(DISTINCT JSON_OBJECT('spcl_name', COALESCE(spcl.spcl_name, '-'))) AS spcl_position FROM " . $this->hr_db . ".hr_person_position AS pp
				LEFT JOIN 
					hr_person_admin_position AS pap ON pp.pos_admin_id = pap.psap_pos_id
				LEFT JOIN 
					hr_person_special_position AS pssp ON pp.pos_spcl_id = pssp.pssp_pos_id
				LEFT JOIN 
					hr_base_admin_position AS ad ON pap.psap_admin_id = ad.admin_id
				LEFT JOIN 
					hr_base_adline_position AS adline ON adline.alp_id = pp.pos_alp_id
				LEFT JOIN 
					hr_base_special_position AS spcl ON pssp.pssp_spcl_id = spcl.spcl_id
				WHERE pos_ps_id = '$id' AND pos_dp_id = '$dp_id'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_department_id_by_stuc($id)
	{
		$sql = "SELECT stuc_dp_id FROM " . $this->hr_db . ".hr_structure 
		where stuc_id = '$id'";
		$query = $this->hr->query($sql);
		return $query;
	}
} // end class M_hr_prefix
