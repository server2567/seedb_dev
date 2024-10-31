<?php
/*
 * m_hr_structure_detail
 * Model for Manage about hr_structure_detail Table.
 * @Author Dechathon Prajit
 * @Create Date 2567-05-28
*/
include_once("Da_hr_structure_person.php");

class M_hr_structure_person extends Da_hr_structure_person
{

	function get_all_by_level($level = "3")
	{
		$sql = "SELECT * 
				FROM " . $this->hr_db . ".hr_structure_detail 
				WHERE stde_level = '$level' ";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_by_id($id)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_structure_person as sp
				LEFT JOIN hr_base_structure_position as stpo ON sp.stdp_po_id = stpo.stpo_id
				LEFT JOIN hr_structure_detail as stde on stde.stde_id = sp.stdp_stde_id
				LEFT JOIN hr_person as ps on sp.stdp_ps_id = ps.ps_id
				LEFT JOIN hr_person_position as pos on pos.pos_ps_id = ps.ps_id
				LEFT JOIN hr_base_prefix as pf on pf.pf_id = ps.ps_pf_id
				LEFT JOIN hr_base_adline_position as alp on alp.alp_id = pos.pos_alp_id
				LEFT JOIN hr_base_admin_position as admin on admin.admin_id = pos.pos_admin_id
				LEFT JOIN hr_base_special_position as spcl on spcl.spcl_id = pos.pos_spcl_id
				LEFT JOIN hr_person_detail as psd on psd.psd_ps_id = ps.ps_id
			    WHERE stdp_id = '$id'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_all_by_structure($dp_id = null, $id, $delete = 2)
	{
		$sql = "SELECT 
    *,
    CONCAT(pf_name_abbr,' ',ps.ps_fname, ' ', ps.ps_lname) AS full_name,
    JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', ad.admin_name)) AS admin_position,
    JSON_ARRAYAGG(DISTINCT JSON_OBJECT('spcl_name', spcl.spcl_name)) AS spcl_position
FROM  " . $this->hr_db . ".hr_structure_person AS sp
LEFT JOIN hr_base_structure_position as stpo ON sp.stdp_po_id = stpo.stpo_id
INNER JOIN hr_person AS ps ON sp.stdp_ps_id = ps.ps_id
INNER JOIN hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
INNER JOIN hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
LEFT JOIN hr_person_admin_position AS psap ON psap.psap_pos_id = pos.pos_admin_id
LEFT JOIN hr_base_admin_position AS ad ON ad.admin_id = psap.psap_admin_id
LEFT JOIN hr_person_special_position AS pssp ON pssp.pssp_pos_id = pos.pos_spcl_id
LEFT JOIN hr_base_prefix AS pf ON pf.pf_id = ps.ps_pf_id
LEFT JOIN hr_base_special_position AS spcl ON spcl.spcl_id = pssp.pssp_spcl_id
LEFT JOIN hr_base_adline_position AS adline ON adline.alp_id = pos.pos_alp_id
WHERE sp.stdp_stde_id = '$id' AND sp.stdp_active != '$delete'" . ($dp_id != null ? 'AND pos.pos_dp_id = ' . $dp_id : '') . "
GROUP BY ps.ps_id ORDER BY CAST(sp.stdp_seq AS UNSIGNED) ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_all_by_active($delete = "2")
	{
		$sql = "SELECT * 
				FROM " . $this->hr_db . ".hr_structure_person as sp
					INNER JOIN hr_person as ps on sp.stdp_ps_id = ps.ps_id
				LEFT JOIN hr_base_structure_position as stpo ON sp.stdp_po_id = stpo.stpo_id
				INNER JOIN hr_person_detail as psd on psd.psd_ps_id = ps.ps_id
				WHERE sp.stdp_active != '$delete' ";
		$query = $this->hr->query($sql);
		return $query;
	}
	function find_structure_person($stde_id, $ps_id, $delete = 2)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_structure_person 
				WHERE stdp_stde_id = '$stde_id' AND stdp_ps_id = '$ps_id' AND stdp_active != '$delete'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_by_stde_id($stde_id)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_structure_person as sp
				LEFT JOIN hr_base_structure_position as stpo ON sp.stdp_po_id = stpo.stpo_id
				LEFT JOIN hr_structure_detail as stde on stde.stde_id = sp.stdp_stde_id
				LEFT JOIN hr_person as ps on sp.stdp_ps_id = ps.ps_id
				LEFT JOIN hr_person_position as pos on pos.pos_ps_id = ps.ps_id
				LEFT JOIN hr_base_prefix as pf on pf.pf_id = ps.ps_pf_id
				LEFT JOIN hr_base_adline_position as alp on alp.alp_id = pos.pos_alp_id
				LEFT JOIN hr_base_admin_position as admin on admin.admin_id = pos.pos_admin_id
				LEFT JOIN hr_base_special_position as spcl on spcl.spcl_id = pos.pos_spcl_id
				LEFT JOIN hr_person_detail as psd on psd.psd_ps_id = ps.ps_id
			    WHERE stde.stde_id = '$stde_id' AND alp_id = '732'";
		$query = $this->hr->query($sql);
		return $query;
	}
} // end class M_hr_prefix
