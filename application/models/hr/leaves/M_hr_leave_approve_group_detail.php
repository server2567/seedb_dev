<?php
/*
 * hr_leave_approve_group_detail
 * Model for Manage about hr_leave_approve_group_detail Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 26/10/2024
 */
include_once("Da_hr_leave_approve_group_detail.php");

class M_hr_leave_approve_group_detail extends Da_hr_leave_approve_group_detail
{


    /*
	* get_structure_detail_by_stuc_id
	* แสดงโครงสร้างองค์กร ตามรหัสโครงสร้างหน่วยงาน
	* @input 
	* @output leave approve person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
    function get_structure_detail_by_stuc_id($stuc_id)
    {
        $sql = "
            SELECT 
                stde_id,
                stde_name_th
            FROM " . $this->hr_db . ".hr_structure_detail AS sd
        
            WHERE 
                sd.stde_stuc_id = {$stuc_id}
                AND sd.stde_active = 1
                AND sd.stde_id NOT IN (
                    SELECT lapg_parent_id 
                    FROM " . $this->hr_db . ".hr_leave_approve_group
                    WHERE lapg_type = 'stuc' 
                )
        
            GROUP BY 
                sd.stde_id
            ORDER BY 
                sd.stde_level ASC";

        $query = $this->hr->query($sql);
        return $query;
    }
    // get_structure_detail_by_stuc_id

    /*
	* get_structure_detail_all_by_level_desc
	* แสดงโครงสร้างองค์กรตามรหัสโครงสร้างหน่วยงาน และรหัสโครงสร้างองค์กรที่เริ่มต้น
	* @input 
	* @output leave approve person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
    function get_structure_detail_all_by_level_desc($stuc_id, $stde_id)
    {
        $sql = "
            WITH RECURSIVE hierarchy AS (

                SELECT 
                    stde_id,
                    stde_name_th,
                    stde_level,
                    stde_parent
                FROM " . $this->hr_db . ".hr_structure_detail
                WHERE stde_id = {$stde_id} AND stde_stuc_id = {$stuc_id} AND stde_active = 1
    
                UNION ALL
    
                SELECT 
                    parent.stde_id,
                    parent.stde_name_th,
                    parent.stde_level,
                    parent.stde_parent
                FROM " . $this->hr_db . ".hr_structure_detail AS parent
                INNER JOIN hierarchy AS child ON parent.stde_id = child.stde_parent
                WHERE parent.stde_stuc_id = {$stuc_id} AND parent.stde_active = 1
            )
            SELECT 
                stde_id,
                stde_name_th,
                stde_level
            FROM hierarchy
            ORDER BY stde_level DESC;
        ";

        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }
    // get_structure_detail_all_by_level_asc


    /*
	* get_person_list_by_stde_id
	* รายชื่อบุคลากรตามโครงสร้างองค์กร
	* @input 
	* @output leave approve person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
    function get_person_list_by_stde_id($stde_id)
    {
        $sql = "
            SELECT  		
                ps.ps_id,
                pf.pf_name,
                ps.ps_fname,
                ps.ps_lname,
                pos.pos_status,
                hire.hire_name,
                alp.alp_name,
                CONCAT('<ul>',
                    GROUP_CONCAT(
                        DISTINCT CONCAT('<li>', ad.admin_name, '</li>')
                        SEPARATOR ''
                    ),
                    '</ul>'
                ) AS admin_position, 
                CASE 
                    WHEN hire.hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire.hire_is_medical = 'N' THEN 'สายพยาบาล'
                    WHEN hire.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire.hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire.hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE '(ไม่ระบุ)'
                END AS hire_is_medical_label,
                stde.stde_name_th
            FROM " . $this->hr_db . ".hr_person AS ps
            LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
            LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
            LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
            LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS pap ON pos.pos_admin_id = pap.psap_pos_id
            LEFT JOIN " . $this->hr_db . ".hr_base_adline_position AS alp ON pos.pos_alp_id = alp.alp_id
            LEFT JOIN " . $this->hr_db . ".hr_base_admin_position AS ad ON pap.psap_admin_id = ad.admin_id
            LEFT JOIN " . $this->hr_db . ".hr_structure_person AS stdp ON stdp.stdp_ps_id = ps.ps_id
            LEFT JOIN " . $this->hr_db . ".hr_structure_detail AS stde ON stde.stde_id = stdp.stdp_stde_id
            WHERE stde.stde_id = {$stde_id}
                    AND pos.pos_status = 1
                    AND pos.pos_active = 'Y'
            GROUP BY ps.ps_id
            ORDER BY stdp.stdp_seq ASC
            LIMIT 1

        ";

        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }
    // get_person_list_by_stde_id

    /*
	* get_base_leave_approve_status
	* แสดงสถานะการดำเนินอนุมัติเส้นทางการลา
	* @input 
	* @output get base leave approve status
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
    function get_base_leave_approve_status()
    {
        $sql = "
            SELECT 
                *
            FROM " . $this->hr_db . ".hr_base_leave_approve_status
            WHERE last_active = 1
            ORDER BY last_id ASC";

        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }
    // get_base_leave_approve_status

    /*
	* get_leave_approve_detail_hire_ps_by_lapg_id
	* แสดงรายละเอียดเส้นทางอนุมัติการลา
	* @input lapg_id
	* @output get leave approve detail by lapg id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/10/2567
	*/
    function get_leave_approve_detail_hire_ps_by_lapg_id($lapg_id)
    {
        $sql = "
            SELECT 
                *
            FROM " . $this->hr_db . ".hr_leave_approve_group_detail
            WHERE lage_lapg_id = {$lapg_id}";

        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }
    // get_leave_approve_detail_hire_ps_by_lapg_id
    public function find_common_stde($ps_id_1, $ps_id_2)
    {
        $sql = "
            SELECT h1.stdp_stde_id
            FROM " . $this->hr_db . ".hr_structure_person AS h1
            INNER JOIN hr_structure_person AS h2
                ON h1.stdp_stde_id = h2.stdp_stde_id
            WHERE h1.stdp_ps_id = {$ps_id_1}
                AND h1.stdp_po_id IN (1,3,6)
                AND h1.stdp_active = 1
                AND h2.stdp_ps_id = {$ps_id_2}
                AND h2.stdp_active = 1
        ";
        
        $query = $this->hr->query($sql);
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($query->num_rows() > 0) {
            return 'true'; // ส่งผลลัพธ์กลับมาเป็น Array
        } else {
            return 'false'; // ไม่มีข้อมูล
        }
    }

    /*
	* get_leave_approve_detail_stuc_by_lapg_id
	* รายชื่อบุคลากรตามโครงสร้างองค์กร ที่อยู่ในกลุ่มเส้นทางผู้อนุมัติการลา
	* @input 
	* @output leave approve person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
    function get_leave_approve_detail_stuc_by_lapg_id($lapg_id = '', $stde_id = '', $ps_id = '')
    {
        $conditions = [];

        // Base SQL
        $sql = "
            SELECT  		
                ps.ps_id,
                pf.pf_name,
                ps.ps_fname,
                ps.ps_lname,
                pos.pos_status,
                hire.hire_name,
                alp.alp_name,
                CONCAT('<ul>',
                    GROUP_CONCAT(
                        DISTINCT CONCAT('<li>', ad.admin_name, '</li>')
                        SEPARATOR ''
                    ),
                    '</ul>'
                ) AS admin_position, 
                CASE 
                    WHEN hire.hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire.hire_is_medical = 'N' THEN 'สายพยาบาล'
                    WHEN hire.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire.hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire.hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE '(ไม่ระบุ)'
                END AS hire_is_medical_label,
                stde.stde_name_th,
                lage.lage_id,
                lage.lage_lapg_id,
                lage.lage_ps_id,
                lage.lage_last_id,
                lage.lage_stde_id,
                lage.lage_desc,
                lage.lage_seq
            FROM " . $this->hr_db . ".hr_leave_approve_group_detail as lage 
            LEFT JOIN " . $this->hr_db . ".hr_person AS ps ON lage.lage_ps_id = ps.ps_id
            LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
            LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
            LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
            LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS pap ON pos.pos_admin_id = pap.psap_pos_id
            LEFT JOIN " . $this->hr_db . ".hr_base_adline_position AS alp ON pos.pos_alp_id = alp.alp_id
            LEFT JOIN " . $this->hr_db . ".hr_base_admin_position AS ad ON pap.psap_admin_id = ad.admin_id
            LEFT JOIN " . $this->hr_db . ".hr_structure_person AS stdp ON stdp.stdp_ps_id = ps.ps_id
            LEFT JOIN " . $this->hr_db . ".hr_structure_detail AS stde ON stde.stde_id = stdp.stdp_stde_id
            WHERE 1 = 1
        ";

        // Check parameters and add conditions
        if (!empty($lapg_id)) {
            $conditions[] = "lage.lage_lapg_id = " . intval($lapg_id);
        }

        if (!empty($stde_id)) {
            $conditions[] = "lage.lage_stde_id = " . intval($stde_id);
        }

        if (!empty($ps_id)) {
            $conditions[] = "lage.lage_ps_id = " . intval($ps_id);
        }

        // Always add these conditions
        $conditions[] = "pos.pos_status = 1";
        $conditions[] = "pos.pos_active = 'Y'";

        // Append conditions to SQL
        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        // Group by and order by
        $sql .= " GROUP BY lage.lage_id ORDER BY lage.lage_seq ASC";

        // Execute query
        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }

    // get_leave_approve_detail_stuc_by_lapg_id

    /*
	* get_structure_detail_by_stde_id
	* แสดงรายละเอียดเส้นทางอนุมัติการลา
	* @input stde_id
	* @output structure, department, all by stde_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/10/2567
	*/
    function get_structure_detail_by_stde_id($stde_id)
    {
        $sql = "
            SELECT 
                dp_id,
                dp_name_th,
                stde_name_th,
                stuc_confirm_date,
                stuc_status
            FROM " . $this->hr_db . ".hr_structure
            LEFT JOIN " . $this->hr_db . ".hr_structure_detail
                ON stuc_id = stde_stuc_id
            LEFT JOIN " . $this->ums_db . ".ums_department
                ON dp_id = stuc_dp_id
            
            WHERE stde_id = {$stde_id}";

        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }
    // get_structure_detail_by_stde_id



} // end class hr_leave_approve_group_detail
