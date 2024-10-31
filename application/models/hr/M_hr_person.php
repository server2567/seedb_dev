<?php
/*
 * M_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("Da_hr_person.php");

class M_hr_person extends Da_hr_person
{

	/*
	* get_all_profile_data
	* ข้อมูลบุคลากรทั้งหมด
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_profile_data($dp_id, $admin_id, $hire_id, $status_id, $pos_active = 'Y')
	{
		$cond = "";

		if ($admin_id == 'none') {
			$cond .= " AND pos.pos_admin_id IS NULL";
		} elseif ($admin_id != "all") {
			// หาค่า psap_pos_id ที่ตรงกับ admin_id ที่ส่งมา

			$cond .= " AND pos.pos_admin_id IN (
            SELECT pap.psap_pos_id
            FROM " . $this->hr_db . ".hr_person_admin_position AS pap
            WHERE pap.psap_admin_id = " . $this->hr->escape($admin_id) . "
           )";
		}

		if ($hire_id == 'none') {
			$cond .= " AND pos.pos_hire_id IS NULL";
		} elseif ($hire_id != "all") {
			$cond .= " AND hire.hire_id = " . $this->hr->escape($hire_id);
		}

		if ($status_id != "all") {
			$cond .= " AND pos.pos_status = " . $this->hr->escape($status_id);
		}

		$hr_is_medical = "";
		if ($this->session->userdata('hr_hire_is_medical')) {
			$hr_hire = $this->session->userdata('hr_hire_is_medical');
			$hr_is_medical = " AND (";
			foreach ($hr_hire as $key => $value) {
				if ($key > 0) {
					$hr_is_medical .= " OR ";
				}
				$hr_is_medical .= "hire.hire_is_medical = " . $this->hr->escape($value['type']);
			}
			$hr_is_medical .= ')';
		}

		$sql = "
    SELECT 
        ps.ps_id,
        pf.pf_name,
        ps.ps_fname,
        ps.ps_lname,
		psd.psd_picture,
        pos.pos_status,
        hire.hire_name,
        alp.alp_name,
        dp.dp_name_th,
        JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', ad.admin_name)) AS admin_position
    FROM " . $this->hr_db . ".hr_person AS ps
	LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
    LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
    LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
    LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
    LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS pap ON pos.pos_admin_id = pap.psap_pos_id
    LEFT JOIN " . $this->hr_db . ".hr_base_adline_position AS alp ON pos.pos_alp_id = alp.alp_id
    LEFT JOIN " . $this->hr_db . ".hr_base_admin_position AS ad ON pap.psap_admin_id = ad.admin_id
    LEFT JOIN " . $this->ums_db . ".ums_department AS dp ON dp.dp_id = pos.pos_dp_id
    WHERE 
        pos.pos_dp_id = " . $this->hr->escape($dp_id) . " 
        {$hr_is_medical} 
        {$cond} 
        AND pos.pos_active = " . $this->hr->escape($pos_active) . "
    GROUP BY ps.ps_id
    ORDER BY pos.pos_status ASC";

		$query = $this->hr->query($sql);
		return $query;
	}




	/*
	* get_profile_detail_data_by_id
	* ข้อมูลบุคลากรทั้งหมด
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_profile_detail_data_by_id()
	{
		$sql = "SELECT 
					ps_id,
					ps_pf_id,
					pf_name,
					pf_name_en,
					pf_name_abbr,
					pf_name_abbr_en,
					ps_fname,
					ps_lname,
					ps_fname_en,
					ps_lname_en,
					ps_nickname,
					ps_nickname_en,
					psd_id_card_no,
					psd_picture,
					psd_blood_id,
					psd_reli_id,
					psd_nation_id,
					psd_race_id,
					psd_psst_id,
					psd_birthdate,
					psd_gd_id,
					psd_desc,
					psd_facebook,
					psd_line,
					psd_email,
					psd_cellphone,
					psd_phone,
					psd_ex_phone,
					psd_work_phone,
					psd_addcur_no,
					psd_addcur_pv_id,
					psd_addcur_amph_id,
					psd_addcur_dist_id,
					psd_addcur_zipcode,
					psd_addhome_no,
					psd_addhome_pv_id,
					psd_addhome_amph_id,
					psd_addhome_dist_id,
					psd_addhome_zipcode,
					pos.pos_ps_code,
					gd.gd_name,
					race.race_name,
					reli.reli_name,
					blood.blood_name,
					country.country_name,
					psst.psst_name,
					dist.dist_name,
					pv.pv_name,
					amph.amph_name
				FROM " . $this->hr_db . ".hr_person as ps
				LEFT JOIN " . $this->hr_db . ".hr_base_prefix as pf 
					ON ps.ps_pf_id = pf.pf_id
				LEFT JOIN " . $this->hr_db . ".hr_person_detail as psd 
					ON psd.psd_ps_id = ps.ps_id
				LEFT JOIN " . $this->hr_db . ".hr_person_position as pos
				   ON pos.pos_ps_id = ps.ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_gender as gd
				   ON gd.gd_id = psd.psd_gd_id
				LEFT JOIN " . $this->hr_db . ".hr_base_blood as blood
				   ON blood.blood_id = psd.psd_blood_id
				LEFT JOIN " . $this->hr_db . ".hr_base_religion as reli
				   ON reli.reli_id = psd.psd_reli_id
				LEFT JOIN " . $this->hr_db . ".hr_base_race as race
				   ON race.race_id = psd.psd_race_id
				LEFT JOIN " . $this->hr_db . ".hr_base_country as country
				   ON country.country_id = psd.psd_nation_id
				LEFT JOIN " . $this->hr_db . ".hr_base_person_status as psst
				   ON psst.psst_id = psd.psd_psst_id
				LEFT JOIN " . $this->hr_db . ".hr_base_district as dist
				   ON dist.dist_id = psd.psd_addcur_dist_id
				LEFT JOIN " . $this->hr_db . ".hr_base_province as pv
				   ON pv.pv_id = psd.psd_addcur_pv_id
				LEFT JOIN " . $this->hr_db . ".hr_base_amphur as amph
				   ON amph.amph_id = psd.psd_addcur_amph_id
				WHERE 	ps.ps_id = ?";
		$query = $this->hr->query($sql, array($this->ps_id));
		return $query;
		// 	LEFT JOIN ".$this->hr_db.".hr_blood as blood 
		// 	ON psd.psd_blood_id = blood.blood_id
		// LEFT JOIN ".$this->hr_db.".hr_religion as reli 
		// 	ON psd.psd_reli_id = reli.reli_id
		// LEFT JOIN ".$this->hr_db.".hr_nation as nation 
		// 	ON psd.psd_nation_id = nation.nation_id
		// LEFT JOIN ".$this->hr_db.".hr_race as race 
		// 	ON psd.psd_race_id = race.race_id
		// LEFT JOIN ".$this->hr_db.".hr_person_status as psst 
		// 	ON psd.psd_psst_id = psst.psst_id
		// LEFT JOIN ".$this->hr_db.".hr_gender as gd 
		// 	ON psd.psd_gd_id = gd.gd_id
	} //end get_all_profile_data

	function get_addhome_addr($pv_id, $amph_id, $dist_id)
	{
		$sql = "SELECT pv.pv_name,amph.amph_name,dist.dist_name 
		 FROM " . $this->hr_db . ".hr_base_province as pv
		 INNER JOIN " . $this->hr_db . ".hr_base_amphur as amph 
		  ON amph.amph_pv_id = pv.pv_id
		INNER JOIN " . $this->hr_db . ".hr_base_district as dist
		  ON dist.dist_amph_id  = amph.amph_id
		WHERE pv.pv_id = ? AND amph.amph_id = ? AND dist.dist_id = ?";
		$query = $this->hr->query($sql, array($pv_id, $amph_id, $dist_id));
		return $query;
	}
	/*
	* get_person_ums_department_by_ps_id
	* ข้อมูลหน่วยงานตามรหัสบุคลากร
	* @input -
	* @output get position by ums department
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-23
	*/
	function get_person_education_by_id()
	{
		$sql = "SELECT 	
		                edu.*,
						edudg_name,
						edulv_name,
						edumj_name,
						place_name
				FROM " . $this->hr_db . ".hr_person_education as edu
				LEFT JOIN " . $this->hr_db . ".hr_base_education_degree as edudg
				   ON edudg.edudg_id = edu.edu_edudg_id
				LEFT JOIN " . $this->hr_db . ".hr_base_education_level as edulv
				   ON edulv.edulv_id = edu.edu_edulv_id  
				LEFT JOIN " . $this->hr_db . ".hr_base_education_major as edumj
				   ON edumj.edumj_id = edu.edu_edumj_id 
				 LEFT JOIN " . $this->hr_db . ".hr_base_place as place
				   ON place.place_id = edu.edu_place_id 
				WHERE 	edu.edu_ps_id = ?
				ORDER BY 
				CASE 
					WHEN edu.edu_highest = 'Y' THEN 1
					WHEN edu.edu_highest = 'N' THEN 2
					ELSE 3
				END , edu.edu_hon_id ASC";
		$query = $this->hr->query($sql, array($this->ps_id));
		return $query;
	}
	/*
	* get_person_ums_department_by_ps_id
	* ข้อมูลหน่วยงานตามรหัสบุคลากร
	* @input -
	* @output get position by ums department
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-23
	*/
	function get_person_ums_department_by_ps_id()
	{
		$sql = "SELECT 	
						dp.dp_id,
						dp.dp_name_th,
						pos.pos_id,
						pos.pos_active,
						pos.pos_status
				FROM " . $this->hr_db . ".hr_person_position as pos
				LEFT JOIN " . $this->ums_db . ".ums_department as dp 
					ON dp.dp_id = pos.pos_dp_id
				WHERE 	pos.pos_ps_id = ? AND
						pos.pos_active = 'Y'";
		$query = $this->hr->query($sql, array($this->ps_id));
		return $query;
	}
	// get_person_ums_department_by_ps_id

	/*
	* get_person_position_by_ums_department_detail
	* ข้อมูลตำแหน่งงานตามหน่วยงานของบุคลากร
	* @input -
	* @output get position by ums department detail
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-23
	*/
	function get_person_position_by_ums_department_detail($ps_id, $dp_id)
	{
		$sql = "SELECT 	
            pos.pos_id,
            pos.pos_dp_id,
            pos.pos_ps_code,
            pos.pos_admin_id,
            pos.pos_alp_id,
            pos.pos_spcl_id,
            pos.pos_hire_id,
			pos.pos_trial_day,
			pos.pos_work_start_date,
            pos.pos_status,
            pos.pos_retire_id,
            pos.pos_desc,
            pos.pos_active,
            JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', ad.admin_name)) AS admin_position,
            JSON_ARRAYAGG(DISTINCT JSON_OBJECT('spcl_name', spcl.spcl_name)) AS spcl_position,
            alp.alp_name,
            spcl.spcl_name,
            hire.hire_name,
			hire.hire_is_medical,
			
		   (SELECT JSON_ARRAYAGG(JSON_OBJECT('stdp_po_id', stdp.stdp_po_id, 'stde_name_th', stde_name_th) ORDER BY stde_level ASC) 
				FROM  " . $this->hr_db . ".hr_structure_person AS stdp 
				LEFT JOIN see_hrdb.hr_structure_detail ON stdp_stde_id = stde_id 
				LEFT JOIN see_hrdb.hr_structure ON stde_stuc_id = stuc_id 
				WHERE stdp_ps_id = pos.pos_ps_id 
				AND stdp_active = 1 
				AND stde_active = 1 
				AND stuc_dp_id = pos.pos_dp_id 
				AND stuc_status = 1) AS stde_name_th_group 
        FROM " . $this->hr_db . ".hr_person_position as pos
        LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS pap 
            ON pos.pos_admin_id = pap.psap_pos_id
        LEFT JOIN " . $this->hr_db . ".hr_person_special_position AS pssp 
            ON pos.pos_spcl_id = pssp.pssp_pos_id
        LEFT JOIN " . $this->hr_db . ".hr_base_admin_position as ad 
            ON pap.psap_admin_id = ad.admin_id
        LEFT JOIN " . $this->hr_db . ".hr_base_adline_position as alp
            ON pos.pos_alp_id = alp.alp_id
        LEFT JOIN " . $this->hr_db . ".hr_base_special_position as spcl
            ON pssp.pssp_spcl_id = spcl.spcl_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire as hire
            ON pos.pos_hire_id = hire.hire_id
        WHERE pos.pos_ps_id = {$ps_id}
            AND pos.pos_dp_id = {$dp_id}
            AND pos.pos_active = 'Y'";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_person_position_by_ums_department_detail

	/*
	* get_hr_base_adline_position_data
	* ข้อมูลพื้นฐานตำแหน่งในสายงาน
	* @input -
	* @output base adline position by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_adline_position_data()
	{
		$sql = "SELECT 	
						alp_id, 
						alp_name,
						alp_name_abbr,
						alp_name_en,
						alp_name_abbr_en,
						alp_active 
				FROM " . $this->hr_db . ".hr_base_adline_position
				WHERE alp_active = 1
				ORDER BY alp_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}

	/*
	* get_hr_base_hire_data
	* ข้อมูลพื้นฐานประเภทบุคลากร
	* @input -
	* @output base hire position by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_hire_data()
	{
		// Get the hire_is_medical values from session
		$hire_is_medical = $this->session->userdata('hr_hire_is_medical');

		// Build an array of the hire types (M, N, SM, A, T)
		$allowed_hire_types = array_map(function ($hire) {
			return $hire['type'];
		}, $hire_is_medical);

		// Convert the array into a string for the SQL query
		$allowed_hire_types_str = implode("','", $allowed_hire_types);

		// SQL query, filtering by allowed hire types
		$sql = "SELECT hire_id, 
					   hire_name,
					   hire_abbr,
					   hire_type,
					   hire_active 
				FROM " . $this->hr_db . ".hr_base_hire
				WHERE hire_active = 1
				  AND hire_is_medical IN ('" . $allowed_hire_types_str . "')
				ORDER BY hire_name ASC";

		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_hire_data


	/*
	* get_hr_base_admin_position_data
	* ข้อมูลพื้นฐานตำแหน่งบริหาร
	* @input -
	* @output base admin position by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_admin_position_data()
	{
		$sql = "SELECT 	
						admin_id, 
						admin_name,
						admin_name_en,
						admin_name_abbr,
						admin_name_abbr_en,
						admin_active
				FROM " . $this->hr_db . ".hr_base_admin_position
				WHERE admin_active = 1
				ORDER BY admin_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_admin_position_data

	/*
	* get_hr_base_special_position_data
	* ข้อมูลพื้นฐานตำแหน่งเฉพาะทาง
	* @input -
	* @output base special position by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_special_position_data()
	{
		$sql = "SELECT 	
						spcl_id, 
						spcl_name,
						spcl_name_en,
						spcl_name_abbr,
						spcl_name_abbr_en,
						spcl_active
				FROM " . $this->hr_db . ".hr_base_special_position
				WHERE spcl_active = 1
				ORDER BY spcl_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_special_position_data

	/*
	* get_hr_base_amphur_data
	* ข้อมูลพื้นฐานอำเภอ
	* @input -
	* @output base amphur by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_amphur_data()
	{
		$sql = "SELECT 	
						amph_id, 
						amph_name,
						amph_name_en,
						amph_pv_id,
						amph_active
				FROM " . $this->hr_db . ".hr_base_amphur
				WHERE amph_active = 1
				ORDER BY amph_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_amphur_data

	/*
	* get_hr_base_blood_data
	* ข้อมูลพื้นฐานหมู่โลหิต
	* @input -
	* @output base blood by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_blood_data()
	{
		$sql = "SELECT 	
						blood_id, 
						blood_name,
						blood_name_en,
						blood_active
				FROM " . $this->hr_db . ".hr_base_blood
				WHERE blood_active = 1
				ORDER BY blood_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_blood_data

	/*
	* get_hr_base_country_data
	* ข้อมูลพื้นฐานตำแหน่งในสายงาน
	* @input -
	* @output base country by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_country_data()
	{
		$sql = "SELECT 	
						country_id, 
						country_name,
						country_name_en,
						country_active
				FROM " . $this->hr_db . ".hr_base_country
				WHERE country_active = 1
				ORDER BY country_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_country_data

	/*
	* get_hr_base_district_data
	* ข้อมูลพื้นฐานตำบล
	* @input -
	* @output base district by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_district_data()
	{
		$sql = "SELECT 	
						dist_id, 
						dist_name,
						dist_name_en,
						dist_amph_id,
						dist_pv_id,
						dist_pos_code,
						dist_active
				FROM " . $this->hr_db . ".hr_base_district
				WHERE dist_active = 1
				ORDER BY dist_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_district_data

	/*
	* get_hr_base_education_degree_data
	* ข้อมูลพื้นฐานวุฒิการศึกษา
	* @input -
	* @output base education degree by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_education_degree_data()
	{
		$sql = "SELECT 	
						edudg_id, 
						edudg_name,
						edudg_name_en,
						edudg_abbr,
						edudg_abbr_en,
						edudg_edulv_id,
						edudg_active
				FROM " . $this->hr_db . ".hr_base_education_degree
				WHERE edudg_active = 1
				ORDER BY edudg_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_education_degree_data

	/*
	* get_hr_base_education_level_data
	* ข้อมูลพื้นฐานระดับการศึกษา
	* @input -
	* @output base education level by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_education_level_data()
	{
		$sql = "SELECT 	
						edulv_id, 
						edulv_name,
						edulv_name_en,
						edulv_abbr,
						edulv_abbr_en,
						edulv_active
				FROM " . $this->hr_db . ".hr_base_education_level
				WHERE edulv_active = 1
				ORDER BY edulv_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_education_level_data

	/*
	* get_hr_base_education_major_data
	* ข้อมูลพื้นฐานสาขาวิชา
	* @input -
	* @output base education major by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_education_major_data()
	{
		$sql = "SELECT 	
						edumj_id, 
						edumj_name,
						edumj_name_en,
						edumj_parent,
						edumj_parent_en,
						edumj_voc_id,
						edumj_active
				FROM " . $this->hr_db . ".hr_base_education_major
				WHERE edumj_active = 1
				ORDER BY edumj_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_education_major_data

	/*
	* get_hr_base_gender_data
	* ข้อมูลพื้นฐานเพศ
	* @input -
	* @output base gender by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_gender_data()
	{
		$sql = "SELECT 	
						gd_id, 
						gd_name,
						gd_name_en,
						gd_name_abbr,
						gd_name_abbr_en,
						gd_active
				FROM " . $this->hr_db . ".hr_base_gender
				WHERE gd_active = 1";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_gender_data

	/*
	* get_hr_base_hire_type_data
	* ข้อมูลพื้นฐานประเภทบุคลากร
	* @input -
	* @output base hire type by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_hire_type_data()
	{
		$sql = "SELECT 	
						hire_id, 
						hire_name,
						hire_abbr,
						hire_type,
						CASE 
							WHEN hire_is_medical = 'M' THEN '(สายการแพทย์)'
							WHEN hire_is_medical = 'N' THEN '(สายพยาบาล)'
							WHEN hire_is_medical = 'SM' THEN '(สายสนับสนุนทางการแพทย์)'
							WHEN hire_is_medical = 'T' THEN '(สายเทคนิคและบริการ)'
							WHEN hire_is_medical = 'A' THEN '(สายบริหาร)'
							ELSE '(ไม่ระบุ)'
						END AS hire_is_medical_label,
						hire_active
				FROM " . $this->hr_db . ".hr_base_hire
				WHERE hire_active = 1
				ORDER BY hire_is_medical_label ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_hire_type_data

	/*
	* get_hr_base_nation_data
	* ข้อมูลพื้นฐานสัญชาติ
	* @input -
	* @output base nation by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_nation_data()
	{
		$sql = "SELECT 	
						nation_id, 
						nation_name,
						nation_name_en,
						nation_active
				FROM " . $this->hr_db . ".hr_base_nation
				WHERE nation_active = 1
				ORDER BY nation_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_nation_data

	/*
	* get_hr_base_person_status_data
	* ข้อมูลพื้นฐานสถานภาพ
	* @input -
	* @output base person status by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_person_status_data()
	{
		$sql = "SELECT 	
						psst_id, 
						psst_name,
						psst_name_en,
						psst_active
				FROM " . $this->hr_db . ".hr_base_person_status
				WHERE psst_active = 1
				ORDER BY psst_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_person_status_data

	/*
	* get_hr_base_place_data
	* ข้อมูลพื้นฐานสถานที่
	* @input -
	* @output base place by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_place_data()
	{
		$sql = "SELECT 	
						place_id, 
						place_name,
						place_name_en,
						place_abbr,
						place_abbr_en,
						place_active
				FROM " . $this->hr_db . ".hr_base_place
				WHERE place_active = 1
				ORDER BY place_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_place_data

	/*
	* get_hr_base_prefix_data
	* ข้อมูลพื้นฐานคำนำหน้าชื่อ/ยศ
	* @input -
	* @output base prefix by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_prefix_data($gd_id = '')
	{
		$cond = "";
		if ($gd_id != '') {
			$cond = "AND pf_gd_id = {$gd_id}";
		}
		$sql = "SELECT 	
						pf_id, 
						pf_name,
						pf_name_en,
						pf_name_abbr,
						pf_name_abbr_en,
						pf_gd_id,
						pf_active
				FROM " . $this->hr_db . ".hr_base_prefix
				WHERE pf_active = 1 {$cond}
				ORDER BY pf_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_prefix_data

	/*
	* get_hr_base_province_data
	* ข้อมูลพื้นฐานจังหวัด
	* @input -
	* @output base province by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_province_data()
	{
		$sql = "SELECT 	
						pv_id, 
						pv_name,
						pv_name_en,
						pv_active
				FROM " . $this->hr_db . ".hr_base_province
				WHERE pv_active = 1
				ORDER BY pv_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_province_data

	/*
	* get_hr_base_race_data
	* ข้อมูลพืนฐานเชื้อชาติ
	* @input -
	* @output base race by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_race_data()
	{
		$sql = "SELECT 	
						race_id, 
						race_name,
						race_active
				FROM " . $this->hr_db . ".hr_base_race
				WHERE race_active = 1
				ORDER BY race_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_race_data

	/*
	* get_hr_base_religion_data
	* ข้อมูลพื้นฐานศาสนา
	* @input -
	* @output base religion by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_religion_data()
	{
		$sql = "SELECT 	
						reli_id, 
						reli_name,
						reli_name_en,
						reli_active
				FROM " . $this->hr_db . ".hr_base_religion
				WHERE reli_active = 1
				ORDER BY reli_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_religion_data

	/*
	* get_hr_base_retire_data
	* ข้อมูลพื้นฐานสถานะปัจจุบันของบุคลากร
	* @input -
	* @output base retire by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_retire_data()
	{
		$sql = "SELECT 	
						retire_id, 
						retire_name,
						retire_ps_status,
						retire_timestamp,
						retire_active
				FROM " . $this->hr_db . ".hr_base_retire
				WHERE retire_active = 1
				ORDER BY retire_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_retire_data

	/*
	* get_hr_base_reward_level_data
	* ข้อมูลพื้นฐานระดับรางวัล
	* @input -
	* @output base reward level by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_reward_level_data()
	{
		$sql = "SELECT 	
						rwlv_id, 
						rwlv_name,
						rwlv_name_en,
						rwlv_seq,
						rwlv_active
				FROM " . $this->hr_db . ".hr_base_reward_level
				WHERE rwlv_active = 1
				ORDER BY rwlv_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_reward_level_data

	/*
	* get_hr_base_reward_type_data
	* ข้อมูลพื้นฐานด้านรางวัล
	* @input -
	* @output base reward type by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_reward_type_data()
	{
		$sql = "SELECT 	
						rwt_id, 
						rwt_name,
						rwt_name_en,
						rwt_seq,
						rwt_active
				FROM " . $this->hr_db . ".hr_base_reward_type
				WHERE rwt_active = 1
				ORDER BY rwt_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_reward_type_data

	/*
	* get_hr_base_vocation_data
	* ข้อมูลพื้นฐานวิชาชีพ
	* @input -
	* @output base vocation by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_vocation_data()
	{
		$sql = "SELECT 	
						voc_id, 
						voc_name,
						voc_done,
						voc_seq,
						voc_active
				FROM " . $this->hr_db . ".hr_base_vocation
				WHERE voc_active = 1
				ORDER BY voc_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_vocation_data

	/*
	* get_hr_base_external_service_data
	* ข้อมูลพื้นฐานบริการหน่วยงานภายนอก
	* @input -
	* @output base external service by active data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_hr_base_external_service_data()
	{
		$sql = "SELECT 	
						exts_id, 
						exts_name_th,
						exts_name_en,
						exts_active
				FROM " . $this->hr_db . ".hr_base_external_service
				WHERE exts_active = 1
				ORDER BY exts_name_th ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_external_service_data

	/*
	* get_ums_department_data
	* ชื่อหน่วยงานหลักจากระบบ UMS
	* @input -
	* @output base UMS department data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function get_ums_department_data()
	{
		$sql = "SELECT 	
						dp_id, 
						dp_name_th,
						dp_name_abbr_th,
						dp_name_en,
						dp_name_abbr_en
				FROM " . $this->ums_db . ".ums_department";
		$query = $this->ums->query($sql);
		return $query;
	}
	// get_ums_department_data

	/*
	* check_profile_duplicate
	* ตรวจสอบข้อมูลรายชื่อบุคลากร
	* @input -
	* @output ps_fname, ps_lname, psd_id_card_no
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-20
	*/
	function check_profile_duplicate($action_type, $fname, $lname, $id_card, $ps_id = "")
	{
		$params = [$fname, $lname, $id_card];
		$cond = "";

		if ($action_type != 'insert') {
			$cond = "AND ps_id != ?";
			$params[] = $ps_id;
		}

		$sql = "SELECT COUNT(*) as count_person
				FROM {$this->hr_db}.hr_person
				LEFT JOIN {$this->hr_db}.hr_person_detail ON ps_id = psd_ps_id
				WHERE (ps_fname = ? AND ps_lname = ?) 
				OR psd_id_card_no = ?
				{$cond}";

		$query = $this->hr->query($sql, $params);

		return $query;
	}

	// check_profile_duplicate

	/*
	* get_amphur_by_province_id
	* ดึงข้อมูลอำเภอตามไอดีจังหวัด
	* @input pv_id
	* $output amphur list by pv_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/05/2024
	*/
	function get_amphur_by_province_id($pv_id)
	{
		$sql = "SELECT 	
					amph_id, 
					amph_name
		FROM " . $this->hr_db . ".hr_base_amphur
				WHERE 	amph_pv_id = {$pv_id}
						AND amph_active = 1
				ORDER BY amph_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_amphur_by_province_id

	/*
	* get_district_by_amphur_id
	* ดึงข้อมูลตำบลตามไอดีอำเภอ
	* @input amph_id
	* $output district list by amph_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/05/2024
	*/
	function get_district_by_amphur_id($amph_id)
	{
		$sql = "SELECT 	
					dist_id, 
					dist_name
		FROM " . $this->hr_db . ".hr_base_district
				WHERE 	dist_amph_id = {$amph_id}
						AND dist_active = 1
				ORDER BY dist_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_district_by_amphur_id

	/*
	* get_zipcode_by_dist_id
	* ดึงข้อมูลเลขไปรษณีย์ตามไอดีของตำบล
	* @input dist_id
	* $output zipcode list by dist_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/05/2024
	*/
	function get_zipcode_by_dist_id($dist_id)
	{
		$sql = "SELECT 	
					dist_pos_code
		FROM " . $this->hr_db . ".hr_base_district
				WHERE 	dist_id = {$dist_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_zipcode_by_dist_id


	/*
	* get_personal_dashboard_profile_detail_data_by_id
	* ข้อมูลบุคลากรทั้งหมดที่ personal dashboard
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_personal_dashboard_profile_detail_data_by_id()
	{
		$sql = "SELECT 
					*,
					CEIL(DATEDIFF(NOW(), psd_birthdate) / 365) AS psd_year,
					
					addcur_pv.pv_name AS psd_addcur_pv_name,
					addcur_amph.amph_name AS psd_addcur_amph_name,
					addcur_dist.dist_name AS psd_addcur_dist_name,
					addhome_pv.pv_name AS psd_addhome_pv_name,
					addhome_amph.amph_name AS psd_addhome_amph_name,
					addhome_dist.dist_name AS psd_addhome_dist_name


				FROM " . $this->hr_db . ".hr_person as ps
				LEFT JOIN " . $this->hr_db . ".hr_base_prefix as pf 
					ON ps.ps_pf_id = pf.pf_id
				LEFT JOIN " . $this->hr_db . ".hr_person_detail as psd 
					ON psd.psd_ps_id = ps.ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_blood as blood 
					ON psd.psd_blood_id = blood.blood_id
				LEFT JOIN " . $this->hr_db . ".hr_base_religion as reli 
					ON psd.psd_reli_id = reli.reli_id
				LEFT JOIN " . $this->hr_db . ".hr_base_nation as nation 
					ON psd.psd_nation_id = nation.nation_id
				LEFT JOIN " . $this->hr_db . ".hr_base_race as race 
					ON psd.psd_race_id = race.race_id
				LEFT JOIN " . $this->hr_db . ".hr_base_person_status as psst 
					ON psd.psd_psst_id = psst.psst_id
				LEFT JOIN " . $this->hr_db . ".hr_base_gender as gd 
					ON psd.psd_gd_id = gd.gd_id

				LEFT JOIN " . $this->hr_db . ".hr_base_province as addcur_pv 
					ON psd.psd_addcur_pv_id = addcur_pv.pv_id
				LEFT JOIN " . $this->hr_db . ".hr_base_amphur as addcur_amph
					ON psd.psd_addcur_amph_id = addcur_amph.amph_id
				LEFT JOIN " . $this->hr_db . ".hr_base_district as addcur_dist
					ON psd.psd_addcur_dist_id = addcur_dist.dist_id

				LEFT JOIN " . $this->hr_db . ".hr_base_province as addhome_pv 
					ON psd.psd_addhome_pv_id = addhome_pv.pv_id
				LEFT JOIN " . $this->hr_db . ".hr_base_amphur as addhome_amph
					ON psd.psd_addhome_amph_id = addhome_amph.amph_id
				LEFT JOIN " . $this->hr_db . ".hr_base_district as addhome_dist
					ON psd.psd_addhome_dist_id = addhome_dist.dist_id

				WHERE 	ps.ps_id = ?";
		$query = $this->hr->query($sql, array($this->ps_id));
		return $query;
	} //end get_personal_dashboard_profile_detail_data_by_id


	/*
	* manage_triggers_person_history
	* ลบข้อมูลประวัติบุคลากรของวันปัจจุบัน
	* @input 
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function manage_triggers_person_history()
	{

		$sql = "DELETE FROM " . $this->hr_db . ".hr_person_history
                WHERE hips_start_date = CURDATE() 
				AND hips_end_date = CURDATE()";
		$this->hr->query($sql);
	}
	// manage_triggers_person_history

	/*
	* manage_triggers_person_history_ps_id
	* ลบข้อมูลประวัติบุคลากรของวันปัจจุบัน
	* @input 
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function manage_triggers_person_history_ps_id()
	{

		$sql = "DELETE FROM " . $this->hr_db . ".hr_person_history
                WHERE hips_ps_id=? 
				AND hips_start_date = CURDATE() 
				AND hips_end_date = CURDATE()";
		$this->hr->query($sql, array($this->ps_id));
	}
	// manage_triggers_person_history_ps_id

	/*
	* get_person_history_by_ps_id
	* ข้อมูลประวัติข้อมูลส่วนตัว
	* @input -
	* @output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-07-15
	*/
	function get_person_history_by_ps_id($ps_id)
	{
		$sql = "SELECT 
				*,
				ums_user.us_name as ps_update_user

			FROM {$this->hr_db}.hr_person_history AS h1
			LEFT JOIN {$this->hr_db}.hr_base_prefix as pf
				ON pf.pf_id = h1.hips_ps_pf_id
			LEFT JOIN {$this->ums_db}.ums_user
			    ON h1.hips_update_user = ums_user.us_id

			WHERE h1.hips_ps_id = {$ps_id}
			
			ORDER BY h1.hips_id DESC";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_person_history_by_ps_id

	/*
	* get_structure_detail_by_confirm
	* ข้อมูลรายละเอียดโครงสร้างองค์กร
	* @input -
	* @output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-08-1
	*/
	function get_structure_detail_by_confirm($stuc_id = null, $dp_id = null)
	{
		if ($stuc_id == null) {
			$where = 'WHERE stuc_dp_id = 1 
					AND stuc_status = 1 
					AND stde_active = 1 ';
		} else {
			$where = 'WHERE ';
			if ($stuc_id != null) {
				$where .= "stuc_id = '$stuc_id' AND ";
			}
			if ($dp_id != null) {
				$where .= "stuc_dp_id = '$dp_id' AND ";
			}
			$where .= "stde_active = 1";
		}
		$sql = "SELECT stuc_id, stde_id, stde_name_th, stde_seq
			FROM {$this->hr_db}.hr_structure_detail
			LEFT JOIN hr_structure 
				ON stde_stuc_id = stuc_id 
		" . $where . " ORDER BY stde_seq ASC;";

		$query = $this->hr->query($sql);
		return $query;
	}
	// get_structure_detail_by_confirm

	/*
	* get_structure_detail_by_dp_level
	* ข้อมูลรายละเอียดโครงสร้างองค์กร ตามหน่วยงานและลำดับชั้น
	* @input -
	* @output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-08-1
	*/
	function get_structure_detail_by_dp_level($dp_id = null, $level = null)
	{
		if ($level != null) {
			$where = "WHERE stuc_dp_id = {$dp_id} 
					AND stuc_status = 1 
					AND stde_active = 1 
					AND stde_level >= {$level} ";
		}

		$sql = "SELECT 	stuc_id, 
						stde_id, 
						stde_name_th, 
						stde_seq, 
						stde_level
			FROM {$this->hr_db}.hr_structure_detail
			LEFT JOIN hr_structure 
				ON stde_stuc_id = stuc_id 
		" . $where . "ORDER BY stde_seq ASC;";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_structure_detail_by_dp_level

	/*
	* get_structure_detail_by_dpid_psid
	* ข้อมูลรายละเอียดโครงสร้างองค์กร
	* @input -
	* @output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-08-1
	*/
	function get_structure_detail_by_dpid_psid($dp_id, $ps_id)
	{

		$sql = "SELECT stuc_id, stde_id, stde_name_th, stde_seq
			FROM {$this->hr_db}.hr_structure_detail
			LEFT JOIN {$this->hr_db}.hr_structure 
				ON stde_stuc_id = stuc_id 
			LEFT JOIN {$this->hr_db}.hr_structure_person 
				ON stdp_stde_id = stde_id
			WHERE stuc_dp_id = {$dp_id}
					AND stuc_status = 1 
					AND stde_active = 1
					AND stdp_active = 1
					AND stdp_ps_id = {$ps_id}
			ORDER BY stde_seq ASC";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_structure_detail_by_dpid_psid

	/*
	* get_all_structure_had_confirm
	* ข้อมูลรายละเอียดโครงสร้างองค์กร
	* @input -
	* @output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-08-1
	*/
	function get_all_structure_had_confirm($dp_id = '1', $active = "2")
	{
		$sql = "SELECT * 
				FROM " . $this->hr_db . ".hr_structure
				WHERE stuc_dp_id = '$dp_id' AND stuc_status < '$active' 
				ORDER BY 
				CASE stuc_status
					WHEN '1' THEN 1
					WHEN '0' THEN 2
				END,stuc_create_date DESC;";
		$query = $this->hr->query($sql);
		return $query;
	}

	/*
	* get_structure_detail_by_ps_id
	* ข้อมูลรายละเอียดโครงสร้างองค์กรรายบุคคล
	* @input - $ps_id (Person ID), $dp_id (Department ID)
	* @output - Query result with grouped structure details
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-08-13
	*/
	function get_structure_detail_by_ps_id($ps_id, $dp_id)
	{
		$sql = "SELECT GROUP_CONCAT(stde_name_th ORDER BY stde_level ASC SEPARATOR ', ') AS stde_name_th_group
				FROM " . $this->hr_db . ".hr_structure_person
				LEFT JOIN " . $this->hr_db . ".hr_structure_detail ON stdp_stde_id = stde_id
				LEFT JOIN " . $this->hr_db . ".hr_structure ON stde_stuc_id = stuc_id
				WHERE stdp_ps_id = ? 
				AND stdp_active = 1
				AND stde_active = 1
				AND stuc_dp_id = ?
				AND stuc_status = 1
				ORDER BY stde_level ASC;";

		// Using parameterized queries to prevent SQL injection
		$query = $this->hr->query($sql, array($ps_id, $dp_id));

		return $query;
	}
	// get_structure_detail_by_ps_id
	function get_matching_code($ps_id)
	{
		$sql = "SELECT * FROM " . $this->hr_db . ".hr_timework_matching_code
		    WHERE mc_ps_id = ? ";
		$query = $this->hr->query($sql, array($ps_id));

		return $query;
	}
	// get_structure_detail_list()
	function get_structure_detail_list($ps_id, $dp_id, $status = 1)
	{
		$sql = "SELECT 
                stuc.stuc_id,
                stuc.stuc_confirm_date, 
                stuc.stuc_status,
                JSON_ARRAYAGG(
                    DISTINCT JSON_OBJECT(
                        'stdp_id', stdp.stdp_id,
                        'stdp_po_id', stdp.stdp_po_id,
                        'stde_pos', COALESCE(stpo.stpo_name, '-'), -- ใช้ COALESCE เพื่อตั้งค่าเริ่มต้นเป็น '-'
                        'stdp_stde_id', stdp.stdp_stde_id,
                        'stde_name', stde.stde_name_th,
                        'stdp_active', stdp.stdp_active
                    )
                ) AS stde_list 
            FROM 
                see_hrdb.hr_structure_person AS stdp
            LEFT JOIN 
                see_hrdb.hr_structure_detail AS stde ON stde.stde_id = stdp.stdp_stde_id
            LEFT JOIN 
                see_hrdb.hr_structure AS stuc ON stuc.stuc_id = stde.stde_stuc_id 
            LEFT JOIN
                see_hrdb.hr_base_structure_position AS stpo ON stpo.stpo_id = stdp.stdp_po_id
            WHERE 
                stuc.stuc_dp_id = ? 
                AND stdp.stdp_ps_id = ? 
                AND stuc.stuc_status <= ? 
                AND stdp.stdp_active = $status
            GROUP BY 
                stuc.stuc_id, stuc.stuc_confirm_date, stuc.stuc_status
            ORDER BY 
                stuc.stuc_status DESC, stuc.stuc_confirm_date DESC;";


		// Execute query with bound parameters
		$query = $this->hr->query($sql, array($dp_id, $ps_id, $status));
		return $query;
	}
	function get_current_stucture_by_department($dp_id, $status = 1)
	{
		$sql = "SELECT  stuc.stuc_id,
                stuc.stuc_confirm_date, 
                stuc.stuc_status,
				 JSON_ARRAY() AS stde_list
				FROM 
				   see_hrdb.hr_structure as stuc
				WHERE stuc.stuc_dp_id = $dp_id AND stuc.stuc_status = $status";
		$query = $this->hr->query($sql);
		return $query;
	}
} // end class M_hr_person
