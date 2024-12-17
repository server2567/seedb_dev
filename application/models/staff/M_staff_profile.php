<?php
/*
 * M_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("Da_staff_profile.php");

class M_staff_profile extends Da_staff_profile
{
    // get_structure_detail_by_confirm
    /*
	* get_structure_detail_by_confirm
	* ข้อมูลรายละเอียดโครงสร้างองค์กร
	* @input -
	* @output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-08-1
	*/
    function get_medical_profile($is_medical, $ps_id = null, $fl_name = null, $fl_stde = null)
    {
        if ($ps_id == null) {
            if (is_array($is_medical)) {
                $cond = '( ';
                foreach ($is_medical as $key => $value) {
                    $cond .= "hire.hire_is_medical = '$value'";
                    if ($key != (count($is_medical) - 1)) {
                        $cond .= ' OR ';
                    }
                }
                $cond .= ')';
            } else {
                if ($is_medical == 'lvl') {
                    $cond = "stuc.stuc_status = 1 AND stde.stde_level <= 2 ";
                } else {
                    $cond = "hire.hire_is_medical = '$is_medical'";
                }
            }
            if ($fl_name != null) {
                $cond .= "AND CONCAT(pf.pf_name_abbr, ' ', ps.ps_fname, ' ', ps.ps_lname) LIKE '%$fl_name%'" ;
            }
            if ($fl_stde != null) {
                $cond .= "AND stde.stde_id = '$fl_stde'";
            }
        } else {
            $cond = "ps.ps_id  = '$ps_id'";
        }
        $sql = "SELECT *,CONCAT(pf.pf_name_abbr,' ',ps.ps_fname,' ',ps.ps_lname) as ps_fullname,alp.alp_name,hire.hire_is_medical,psd.psd_picture,
                JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', admin.admin_name)) AS admin_position,
                JSON_ARRAYAGG(DISTINCT JSON_OBJECT('spcl_name', spcl.spcl_name)) AS spcl_position
				FROM " . $this->hr_db . ".hr_person as ps
                LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf on pf.pf_id = ps.ps_pf_id
                LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos on ps.ps_id = pos.pos_ps_id
                LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire on hire.hire_id = pos.pos_hire_id
                LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd on ps.ps_id = psd.psd_ps_id
                LEFT JOIN " . $this->hr_db . ".hr_base_adline_position AS alp on alp.alp_id = pos.pos_alp_id
                LEFT JOIN " . $this->hr_db . ".hr_person_special_position AS pssp on pssp.pssp_pos_id = pos.pos_spcl_id
                LEFT JOIN " . $this->hr_db . ".hr_base_special_position AS spcl on spcl.spcl_id = pssp.pssp_spcl_id
                LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS psap on psap.psap_pos_id = pos.pos_admin_id
                LEFT JOIN " . $this->hr_db . ".hr_base_admin_position AS admin on admin.admin_id = psap.psap_admin_id
                LEFT JOIN " . $this->hr_db . ".hr_structure_person AS stdp on ps.ps_id = stdp.stdp_ps_id
                LEFT JOIN " . $this->hr_db . ".hr_structure_detail AS stde on stde.stde_id = stdp.stdp_stde_id
                LEFT JOIN " . $this->hr_db . ".hr_structure AS stuc on stuc.stuc_id = stde.stde_stuc_id
				WHERE $cond AND pos.pos_dp_id = 1 AND stdp.stdp_active = 1 AND pos.pos_public_display = 1
                GROUP BY ps.ps_id, pf.pf_name, ps.ps_fname, ps.ps_lname, alp.alp_name, hire.hire_is_medical, psd.psd_picture;";
        $query = $this->hr->query($sql);
        return $query;
    }
    function filter_profile_option($stuc_lvl)
    {
        $where = 'where ';
        if ($stuc_lvl == 'SM' || $stuc_lvl == 'M' || $stuc_lvl == 'N') {
            if ($stuc_lvl == 'M' || $stuc_lvl == 'N') {
                $where .= "stde.stde_level = '4' AND " . ($stuc_lvl == 'N' ? "( stde.stde_is_medical = 'Y' OR stde.stde_is_medical = 'N') AND " : "stde.stde_is_medical = 'Y' AND ");
            } else {
                $where .= "stde.stde_is_medical != 'Y' AND stde.stde_level > '2' AND ";
            }
        } else if ($stuc_lvl == 'E') {
            $where .= "stde.stde_level <= '2' AND ";
        }
        $sql = "SELECT stde.stde_id,stde.stde_name_th FROM " . $this->hr_db . ".hr_structure_detail as stde
        LEFT JOIN " . $this->hr_db . ".hr_structure as stuc on stuc.stuc_id = stde.stde_stuc_id " . $where . 'stuc.stuc_status = 1 AND stde.stde_active = 1';
        $query = $this->hr->query($sql);
        return $query;
    }
} // end class M_hr_person
