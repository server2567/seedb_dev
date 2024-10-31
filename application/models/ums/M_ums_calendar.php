<?php
/*
* m_ums_manage_calendar
* Model for Manage about ums_calendar Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 20/06/2024
*/
include_once("Da_ums_calendar.php");

class m_ums_calendar extends Da_ums_calendar
{

	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
	function get_all($aOrderBy = "")
	{
		$orderBy = "";
		if (is_array($aOrderBy)) {
			$orderBy .= "ORDER BY ";
			foreach ($aOrderBy as $key => $value) {
				$orderBy .= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy) - 2);
		}
		$sql = "SELECT *
				FROM " . $this->ums_db . ".ums_calendar
				$orderBy";
		$query = $this->hr->query($sql);
		return $query;
	}

	/*
	 * create array of pk field and value for generate select list in view, must edit PK_FIELD and FIELD_NAME manually
	 * the first line of select list is '-----เลือก-----' by default.
	 * if you do not need the first list of select list is '-----เลือก-----', please pass $optional parameter to other values.
	 * you can delete this function if it not necessary.
	 */
	function get_options($optional = 'y')
	{
		$qry = $this->get_all();
		if ($optional == 'y') $opt[''] = '-----เลือก-----';
		foreach ($qry->result() as $row) {
			$opt[$row->PK_FIELD] = $row->FIELD_NAME;
		}
		return $opt;
	}

	/*
	* get_calendar_person
	* get calendar by person
	* @input ps_id, start_date, end_date
	* $output ข้อมูลปฏิทินของบุคลากร
	* @author Tanadon Tangjaimongkhon
	* @Create Date 20/06/2567
	*/
	function get_calendar_person_date($start_date, $end_date, $ps_id){
		$sql = "
			SELECT 
				clnd_id,
				clnd_ps_id,
				clnd_topic,
				clnd_detail, 
				clnd_start_date, 
				clnd_end_date, 
				clnd_start_time, 
				clnd_end_time, 
				clnd_parent_id,
				clnd_clt_id AS id, 
				clt.clt_name AS category, 
				clt.clt_color AS color,
				(
					SELECT CONCAT(pf_name, ps_fname, ' ', ps_lname)
					FROM ".$this->ums_db.".ums_calendar AS pa
					LEFT JOIN ".$this->hr_db.".hr_person ON pa.clnd_ps_id = ps_id
					LEFT JOIN ".$this->hr_db.".hr_base_prefix ON ps_pf_id = pf_id
					WHERE pa.clnd_id = clnd.clnd_parent_id
				) AS create_calender_by
			FROM ".$this->ums_db.".ums_calendar AS clnd
			LEFT JOIN ".$this->ums_db.".ums_calendar_type AS clt ON clnd.clnd_clt_id = clt.clt_id 
			WHERE clnd_start_date >= '{$start_date}' AND clnd_end_date <= '{$end_date}' 
				AND clnd_ps_id = {$ps_id}
	
			UNION
			
			SELECT 
				que.apm_id AS clnd_id,
				que.apm_ps_id AS clnd_ps_id,
				CONCAT('การนัดหมายจากระบบคิว', IF(dpk.dpk_name IS NOT NULL, CONCAT(' (', dpk.dpk_name, ')'), '')) AS clnd_name,
				CONCAT(
					'รหัสคิว ', que.apm_cl_code, '\nโดยผู้ป่วย ', CONCAT(pt.pt_prefix,pt.pt_fname, ' ', pt.pt_lname), 
					'\nเบอร์โทร ', pt.pt_tel, '\nสถานที่', dp.dp_name_th, ' ', dpk.dpk_name
				) AS clnd_detail, 
				que.apm_date AS clnd_start_date,
				que.apm_date AS clnd_end_date, 
				STR_TO_DATE(SUBSTRING_INDEX(que.apm_time, ' - ', 1), '%H:%i') AS clnd_start_time, 
				STR_TO_DATE(SUBSTRING_INDEX(que.apm_time, ' - ', -1), '%H:%i') AS clnd_end_time, 
				NULL AS clnd_parent_id,
				6 AS id, 
				clt.clt_name AS category, 
				clt.clt_color AS color,
				CONCAT(pf_name, ps_fname, ' ', ps_lname) AS create_calender_by
			FROM " . $this->que_db . ".que_appointment AS que
			LEFT JOIN ".$this->hr_db.".hr_person ON que.apm_ps_id = ps_id
			LEFT JOIN ".$this->hr_db.".hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN ".$this->que_db.".que_code_list AS cl ON cl.cl_id = que.apm_cl_id
			LEFT JOIN ".$this->que_db.".que_base_department_keyword AS dpk ON dpk.dpk_keyword = cl.cl_dpk_keyword
			LEFT JOIN " . $this->ums_db . ".ums_patient AS pt ON que.apm_pt_id = pt.pt_id
			LEFT JOIN ".$this->ums_db.".ums_calendar_type AS clt ON clt.clt_id = 6
			LEFT JOIN ".$this->ums_db.".ums_department AS dp ON dp.dp_id = que.apm_dp_id
			WHERE que.apm_date >= '{$start_date}' AND que.apm_date <= '{$end_date}' 
				AND que.apm_sta_id = 1
				AND que.apm_ps_id = {$ps_id}
			
			UNION
			
			SELECT 
				c.clnd_id AS clnd_id,
				".$this->session->userdata('us_ps_id')." AS clnd_ps_id,
				c.clnd_name AS clnd_name,
				CONCAT('วันหยุด',ct.lct_name) AS clnd_detail, 
				c.clnd_start_date AS clnd_start_date, 
				c.clnd_end_date AS clnd_end_date, 
				'00:00:00' AS clnd_start_time, 
				'00:00:00' AS clnd_end_time, 
				NULL AS clnd_parent_id,
				7 AS id, 
				clt.clt_name AS category, 
				clt.clt_color AS color,
				'".$this->config->item('site_name_th')."' AS create_calender_by
			FROM ".$this->hr_db . ".hr_base_calendar AS c
			INNER JOIN ".$this->hr_db.".hr_base_calendar_type AS ct ON c.clnd_type_date = ct.lct_id
			LEFT JOIN ".$this->ums_db.".ums_calendar_type AS clt ON clt.clt_id = 7
			WHERE clnd_start_date >= '{$start_date}' AND clnd_end_date <= '{$end_date}' 
				AND c.clnd_active = 1
	
			UNION
			
			SELECT 
				ap.ap_id AS clnd_id,
				ntr.ntr_ps_id AS clnd_ps_id,
				CONCAT('การนัดหมายติดตามผล (', dpk.dpk_name, ') (',ntr.ntr_patient_treatment_type,')' ) AS clnd_name,
				CONCAT(
					'รหัสคิว ', que.apm_cl_code, '\nโดยผู้ป่วย ', CONCAT(pt.pt_prefix,pt.pt_fname, ' ', pt.pt_lname), 
					'\nเบอร์โทร ', pt.pt_tel, '\nสถานที่', dp.dp_name_th, ' ', dpk.dpk_name, ' (',ntr.ntr_patient_treatment_type,')',
					' เหตุผลการแจ้งเตือนการนัดหมาย ', ap.ap_detail_appointment, '\n'
				) AS clnd_detail, 
				ap.ap_date AS clnd_start_date, 
				ap.ap_date AS clnd_end_date, 
				ap.ap_time AS clnd_start_time, 
				ap.ap_time AS clnd_end_time, 
				NULL AS clnd_parent_id,
				8 AS id, 
				clt.clt_name AS category, 
				clt.clt_color AS color,
				CONCAT(pf_name, ps_fname, ' ', ps_lname) AS create_calender_by
			FROM ".$this->ams_db.".ams_appointment AS ap
			LEFT JOIN ".$this->ams_db.".ams_notification_results AS ntr ON ntr.ntr_id = ap.ap_ntr_id
			LEFT JOIN ".$this->hr_db.".hr_person ON ntr.ntr_ps_id = ps_id
			LEFT JOIN ".$this->hr_db.".hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN ".$this->que_db.".que_appointment AS que ON que.apm_id = ntr.ntr_apm_id
			LEFT JOIN ".$this->que_db.".que_code_list AS cl ON cl.cl_id = que.apm_cl_id
			LEFT JOIN ".$this->que_db.".que_base_department_keyword AS dpk ON dpk.dpk_keyword = cl.cl_dpk_keyword
			LEFT JOIN ".$this->ums_db.".ums_patient AS pt ON que.apm_pt_id = pt.pt_id
			LEFT JOIN ".$this->ums_db.".ums_calendar_type AS clt ON clt.clt_id = 8
			LEFT JOIN ".$this->ums_db.".ums_department AS dp ON dp.dp_id = que.apm_dp_id
			WHERE ap.ap_date >= '{$start_date}' AND ap.ap_date <= '{$end_date}' 
				AND ap.ap_ast_id = 2
				AND ntr.ntr_ps_id = {$ps_id}
			
			ORDER BY clnd_start_date ASC
		";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	

	/*
	* get_count_parent_calendar_id
	* get calendar by person
	* @input ps_id, start_date, end_date
	* $output ข้อมูลปฏิทินของบุคลากร
	* @author Tanadon Tangjaimongkhon
	* @Create Date 20/06/2567
	*/
	function get_count_parent_calendar_id($clnd_id){
		$sql = "SELECT 
					COUNT(*) as count_parent
				FROM ".$this->ums_db.".ums_calendar as clnd
				WHERE clnd_parent_id = {$clnd_id}
				ORDER BY clnd_start_date ASC";
		$query = $this->ums->query($sql);
		return $query;
	}
	// get_count_parent_calendar_id

	/*
	* get_calendar_person
	* get calendar by person
	* @input ps_id, start_date, end_date
	* $output ข้อมูลปฏิทินของบุคลากร
	* @author Tanadon Tangjaimongkhon
	* @Create Date 20/06/2567
	*/
	function get_group_calendar_type_person_date($start_date, $end_date){
		$sql = "SELECT 
					clt.clt_id AS id,
					clt.clt_name AS category, 
					clt.clt_color AS color,
					clt.clt_seq AS seq 
				FROM ".$this->ums_db.".ums_calendar as clnd
				JOIN ".$this->ums_db.".ums_calendar_type as clt
						ON clnd.clnd_clt_id = clt.clt_id 
				WHERE clnd_start_date >= '{$start_date}' AND clnd_end_date <= '{$end_date}' 
					  AND clnd_parent_id IS NULL
					  AND clt.clt_id NOT IN (7)
					  AND clnd_ps_id = ".$this->session->userdata('us_ps_id')."
				GROUP BY clnd_clt_id
				
				UNION

				SELECT 
					6 AS id,
					clt.clt_name AS category, 
					clt.clt_color AS color,
					clt.clt_seq AS seq 
				FROM " . $this->que_db . ".que_appointment AS que
				LEFT JOIN ".$this->hr_db.".hr_person ON que.apm_ps_id = ps_id
				LEFT JOIN ".$this->hr_db.".hr_base_prefix ON ps_pf_id = pf_id
				LEFT JOIN ".$this->que_db.".que_code_list AS cl ON cl.cl_id = que.apm_cl_id
				LEFT JOIN ".$this->que_db.".que_base_department_keyword AS dpk ON dpk.dpk_keyword = cl.cl_dpk_keyword
				LEFT JOIN " . $this->ums_db . ".ums_patient AS pt ON que.apm_pt_id = pt.pt_id
				LEFT JOIN ".$this->ums_db.".ums_calendar_type AS clt ON clt.clt_id = 6
				LEFT JOIN ".$this->ums_db.".ums_department AS dp ON dp.dp_id = que.apm_dp_id
				WHERE que.apm_date >= '{$start_date}' AND que.apm_date <= '{$end_date}' 
					AND que.apm_sta_id = 1
					AND que.apm_ps_id = ".$this->session->userdata('us_ps_id')."
				GROUP BY id
				
				UNION
				
				SELECT 
					7 AS id,
					clt.clt_name AS category, 
					clt.clt_color AS color,
					clt.clt_seq AS seq 
				FROM " . $this->hr_db . ".hr_base_calendar AS c
				INNER JOIN " . $this->hr_db . ".hr_base_calendar_type AS ct ON c.clnd_type_date = ct.lct_id
				LEFT JOIN ".$this->ums_db.".ums_calendar_type AS clt ON clt.clt_id = 7
				WHERE clnd_start_date >= '{$start_date}' AND clnd_end_date <= '{$end_date}' 
					AND c.clnd_active = 1
				GROUP BY id

				UNION
			
				SELECT 
					8 AS id,
					clt.clt_name AS category, 
					clt.clt_color AS color,
					clt.clt_seq AS seq 
				FROM ".$this->ams_db.".ams_appointment AS ap
				LEFT JOIN ".$this->ams_db.".ams_notification_results AS ntr ON ntr.ntr_id = ap.ap_ntr_id
				LEFT JOIN ".$this->hr_db.".hr_person ON ntr.ntr_ps_id = ps_id
				LEFT JOIN ".$this->hr_db.".hr_base_prefix ON ps_pf_id = pf_id
				LEFT JOIN ".$this->que_db.".que_appointment AS que ON que.apm_id = ntr.ntr_apm_id
				LEFT JOIN ".$this->que_db.".que_code_list AS cl ON cl.cl_id = que.apm_cl_id
				LEFT JOIN ".$this->que_db.".que_base_department_keyword AS dpk ON dpk.dpk_keyword = cl.cl_dpk_keyword
				LEFT JOIN ".$this->ums_db.".ums_patient AS pt ON que.apm_pt_id = pt.pt_id
				LEFT JOIN ".$this->ums_db.".ums_calendar_type AS clt ON clt.clt_id = 8
				LEFT JOIN ".$this->ums_db.".ums_department AS dp ON dp.dp_id = que.apm_dp_id
				WHERE ap.ap_date >= '{$start_date}' AND ap.ap_date <= '{$end_date}' 
					AND ap.ap_ast_id = 2
					AND ntr.ntr_ps_id = ".$this->session->userdata('us_ps_id')."
				GROUP BY id

				ORDER BY seq ASC
				";
		$query = $this->ums->query($sql);
		return $query;
	}

	function get_all_ums_department(){
		$sql = "SELECT 
					dp_id,
					dp_name_th
				FROM ".$this->ums_db.".ums_department";
		$query = $this->ums->query($sql);
		return $query;
	}

	function get_person_all_by_ums_department($dp_id, $ps_id){
		$sql = "SELECT 
					ps_id,
					pf_name,
					ps_fname,
					ps_lname,
					CONCAT(pf_name,ps_fname,' ',ps_lname) AS fullname,
					pos.pos_admin_id,
					pos.pos_alp_id,
					pos.pos_spcl_id,
					pos.pos_hire_id,
					pos.pos_desc,
					pos.pos_active,
					ad.admin_name,
					alp.alp_name,
					spcl.spcl_name,
					hire.hire_name
				FROM ".$this->hr_db.".hr_person
				LEFT JOIN ".$this->hr_db.".hr_base_prefix 
					ON ps_pf_id = pf_id
				LEFT JOIN ".$this->hr_db.".hr_person_position as pos
					ON pos_ps_id = ps_id
				LEFT JOIN ".$this->hr_db.".hr_base_admin_position as ad 
					ON pos.pos_admin_id = ad.admin_id
				LEFT JOIN ".$this->hr_db.".hr_base_adline_position as alp
					ON pos.pos_alp_id = alp.alp_id
				LEFT JOIN ".$this->hr_db.".hr_base_special_position as spcl
					ON pos.pos_spcl_id = spcl.spcl_id
				LEFT JOIN ".$this->hr_db.".hr_base_hire as hire
					ON pos.pos_hire_id = hire.hire_id
				WHERE 	pos.pos_dp_id = {$dp_id}
						AND pos.pos_active = 'Y'
						AND pos.pos_ps_id != {$ps_id}
				ORDER BY ps_fname ASC";
		$query = $this->hr->query($sql);
		return $query;
	}

	function get_person_all_by_ums_calendar_id($clnd_id, $ps_id, $isView){
		

		if($isView == 1){
			$cond = 'AND clnd_ps_id != ' . $ps_id;
		}
		else{
			$cond = "";
		}
		

		$sql = "SELECT 
					ps_id,
					pf_name,
					ps_fname,
					ps_lname,
					CONCAT(pf_name,ps_fname,' ',ps_lname) AS fullname,
					pos.pos_admin_id,
					pos.pos_alp_id,
					pos.pos_spcl_id,
					pos.pos_hire_id,
					pos.pos_desc,
					pos.pos_active,
					ad.admin_name,
					alp.alp_name,
					spcl.spcl_name,
					hire.hire_name,
					clnd_id,
					clnd_parent_id
				FROM ".$this->hr_db.".hr_person
				LEFT JOIN ".$this->hr_db.".hr_base_prefix 
					ON ps_pf_id = pf_id
				LEFT JOIN ".$this->hr_db.".hr_person_position as pos
					ON pos_ps_id = ps_id
				LEFT JOIN ".$this->hr_db.".hr_base_admin_position as ad 
					ON pos.pos_admin_id = ad.admin_id
				LEFT JOIN ".$this->hr_db.".hr_base_adline_position as alp
					ON pos.pos_alp_id = alp.alp_id
				LEFT JOIN ".$this->hr_db.".hr_base_special_position as spcl
					ON pos.pos_spcl_id = spcl.spcl_id
				LEFT JOIN ".$this->hr_db.".hr_base_hire as hire
					ON pos.pos_hire_id = hire.hire_id
				LEFT JOIN ".$this->ums_db.".ums_calendar 
					ON clnd_ps_id = ps_id
				WHERE clnd_parent_id = {$clnd_id} {$cond}
				GROUP BY ps_id
				ORDER BY ps_fname ASC";
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}


} // end class M_ums_calendar
