<?php

/**
 * This is Line Service
 * User: Tanadon Tangjaimongkhon
 * Date: 2024-07-17 dev
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
require(dirname(dirname(dirname(__FILE__))) . '/libraries/REST_Controller.php');
class Services extends REST_Controller
{

	protected $view;
	protected $model;
	protected $controller;
	protected $line_token;

	public function __construct()
	{
		parent::__construct();

		// Directory path
		$this->view = $this->config->item('line_dir');
		$this->model = $this->config->item('line_dir');
		$this->controller = $this->config->item('line_dir');

		//load model
		$this->load->model($this->model . 'M_line_patient');
		$this->load->model($this->model . 'M_line_message_log');

		//Line Token The DB
		$this->line_token = $this->config->item('line_token');
	}

	/*
	 * insert_message_log
     * insert message log in database
	 * input : data[array]
	 * author: Tanadon
	 * Create Date : 2024-07-17
	 */
	function insert_message_log($message_line_data)
	{
		$this->M_line_message_log->msl_detail = $message_line_data['detail'];
		$this->M_line_message_log->msl_lpt_id = $message_line_data['lpt_pt_id'];
		$this->M_line_message_log->msl_msst_id = $message_line_data['type'];
		$this->M_line_message_log->msl_status = $message_line_data['status'];
		$this->M_line_message_log->insert();
	}
	// insert_message_log

	/*
	 * send_message_que_to_patient
     * ส่ง Message ให้ User ในห้อง Chat เมื่อมีการจองคิว/นัดหมาย
	 * input : msst_id, pt_id, apm_id
	 * author: Tanadon
	 * Create Date : 2024-07-17
	 */
	public function send_message_que_to_patient_post()
	{
		//ขั้นตอนการทำ ref : https://medium.com/linedevth/จัดการ-dynamic-flex-message-ด้วย-php-ep-5-df1510f3cfcd
		$msst_id = $this->post('msst_id');  //รหัสข้อความไลน์
		$pt_id = $this->post('pt_id');      //รหัสผู้ป่วย
		$apm_id = $this->post('apm_id');    //รหัสคิว
		$ntdp_loc_Id = $this->post('ntdp_loc_Id');    //ลำดับการให้บริการปัจจุบันของผู้ป่วย
		$ntdp_loc_ft_Id = $this->post('ntdp_loc_ft_Id');    //ลำดับการให้บริการถัดไปของผู้ป่วย

		// echo "msst_id: " . $msst_id . ", pt_id: " . $pt_id . ", apm_id: " . $apm_id;
		// die(); // หยุดการทำงานหลังจากแสดงค่า เพื่อดูใน Postman

		$this->M_line_message_log->msst_id = $msst_id;
		$qu_mst = $this->M_line_message_log->get_by_message_sub_type_by_id()->row();

		if (isset($msst_id) && isset($pt_id) && isset($apm_id) && $qu_mst->mst_active == "Y" && $qu_mst->msst_active == "Y") {
			$this->load->model($this->config->item('que_dir') . 'M_que_appointment');
			$this->load->model($this->config->item('wts_dir') . 'M_wts_notifications_department');

			$this->M_line_patient->lpt_pt_id = $pt_id;
			$qu_psl = $this->M_line_patient->get_person_by_send_message();

			if ($qu_psl->num_rows() > 0) { // หากเคยได้เข้าสู่ระบบผ่านไลน์
				$row_lpt = $qu_psl->row();
				$apm_que = $this->M_que_appointment->get_appointment_by_id($apm_id)->row();
				
				if(!empty($ntdp_loc_Id)){
					$current_service_point_obj = $this->db->query('SELECT loc_name FROM see_wtsdb.wts_location WHERE loc_seq = "'.$ntdp_loc_Id.'"')->row();
					$current_service_point = $current_service_point_obj->loc_name;
				}else{
					$current_service_point = "ไม่ระบุจุดบริการปัจจุบัน";
				}

				if(!empty($ntdp_loc_ft_Id)){
					$next_service_point_obj = $this->db->query('SELECT rm_name FROM see_eqsdb.eqs_room WHERE rm_his_id = "'.$ntdp_loc_ft_Id.'"')->row();
					$next_service_point = $next_service_point_obj->rm_name;
				}else{
					$next_service_point = "ไม่ระบุจุดบริการถัดไป";
				}

				$next_service_point_show = true;
				if($ntdp_loc_Id == 11 && empty($ntdp_loc_ft_Id)){
					$next_service_point_show = false;
				}

				// ตรวจสอบข้อมูลการจองคิว
				if ($apm_que) {

					$location = !empty($apm_que->dp_name_th) ? $apm_que->dp_name_th : 'ไม่ระบุสถานที่';
					$department = !empty($apm_que->stde_name_th) ? $apm_que->stde_name_th : 'ไม่ระบุแผนก';
					$doctor_name = !empty($apm_que->ps_name) ? $apm_que->ps_name : 'ไม่ระบุชื่อแพทย์';

					$flexDataJson = '
					{
						"type": "flex",
						"altText": "แจ้งเตือนการจองคิวของคุณ",
						"contents": {
							"type": "bubble",
							"body": {
								"type": "box",
								"layout": "vertical",
								"contents": [
									{
										"type": "text",
										"text": "นัดหมาย/จองคิว",
										"weight": "bold",
										"color": "#1DB446",
										"size": "sm"
									},
									{
										"type": "text",
										"text": "หมายเลขคิว ' . $apm_que->apm_ql_code . '",
										"weight": "bold",
										"size": "xl",
										"margin": "md"
									},
									{
										"type": "separator",
										"margin": "xxl"
									},
									{
										"type": "box",
										"layout": "vertical",
										"margin": "xxl",
										"spacing": "sm",
										"contents": [
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "สถานที่",
														"size": "sm",
														"color": "#555555",
														"flex": 2
													},
													{
														"type": "text",
														"text": "' . $location . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"flex": 3
													}
												]
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "แผนก",
														"size": "sm",
														"color": "#555555",
														"flex": 2
													},
													{
														"type": "text",
														"text": "' . $department . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"flex": 3,
														"wrap": true
													}
												]
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "วันที่เข้ารับบริการ",
														"size": "sm",
														"color": "#555555",
														"flex": 5
													},
													{
														"type": "text",
														"text": "' . fullDateTH3($apm_que->apm_date) . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"wrap": true,
														"flex": 3
													}
												]
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
												{
													"type": "text",
													"text": "เวลา",
													"size": "sm",
													"color": "#555555"
												},
												{
													"type": "text",
													"text": "' . DateTime::createFromFormat("H:i", $apm_que->apm_time)->format("H:i") . ' น.",
													"size": "sm",
													"color": "#111111",
													"align": "end",
													"wrap": true,
													"flex": 4
												}
												]
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "จุดบริการปัจจุบัน",
														"size": "sm",
														"color": "#555555",
														"flex": 5
													},
													{
														"type": "text",
														"text": "' . $current_service_point . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"wrap": true,
														"flex": 3
													}
												]
											},';
						// เงื่อนไขเพื่อไม่แสดงจุดบริการถัดไปหากตอนนี้เป็นจุดสุดท้าย และจุดถัดไปไม่ถูกส่งมา
						if ($next_service_point_show) {
							$flexDataJson .= '	
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "จุดบริการถัดไป",
														"size": "sm",
														"color": "#555555",
														"flex": 5
													},
													{
														"type": "text",
														"text": "' . $next_service_point . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"wrap": true,
														"flex": 3
													}
												]
											},';
						}
						$flexDataJson .= '
											{
												"type": "separator",
												"margin": "xxl"
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "VISIT",
														"size": "sm",
														"color": "#555555",
														"flex": 2
													},
													{
														"type": "text",
														"text": "' . ($apm_que->apm_visit == null ? "-" : $apm_que->apm_visit) . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"flex": 3
													}
												],
												"flex": 2,
												"margin": "xxl"
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "HN",
														"size": "sm",
														"color": "#555555",
														"flex": 2
													},
													{
														"type": "text",
														"text": "' . ($apm_que->pt_member == null ? "-" : $apm_que->pt_member) . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"flex": 3
													}
												]
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "ชื่อผู้ป่วย",
														"size": "sm",
														"color": "#555555",
														"flex": 2
													},
													{
														"type": "text",
														"text": "' . $apm_que->pt_name . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"wrap": true,
														"flex": 3
													}
												]
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "ว/ด/ป เกิด",
														"size": "sm",
														"color": "#555555",
														"flex": 2
													},
													{
														"type": "text",
														"text": "' . getbirthDate($apm_que->ptd_birthdate) . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"wrap": true,
														"flex": 3
													}
												]
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "อายุ",
														"size": "sm",
														"color": "#555555",
														"flex": 2
													},
													{
														"type": "text",
														"text": "' . calAge3($apm_que->ptd_birthdate) . ' ปี",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"wrap": true,
														"flex": 3
													}
												]
											},
											{
												"type": "box",
												"layout": "horizontal",
												"contents": [
													{
														"type": "text",
														"text": "เพศ",
														"size": "sm",
														"color": "#555555",
														"flex": 2
													},
													{
														"type": "text",
														"text": "' . ($apm_que->ptd_sex == "M" ? "ชาย" : "หญิง") . '",
														"size": "sm",
														"color": "#111111",
														"align": "end",
														"wrap": true,
														"flex": 3
													}
												]
											}
										]
									},
									{
										"type": "separator",
										"margin": "xxl"
									},
									{
										"type": "box",
										"layout": "horizontal",
										"margin": "md",
										"contents": [
											{
												"type": "text",
												"text": "โรงพยาบาลจักษุสุราษฎร์",
												"size": "xs",
												"color": "#aaaaaa",
												"flex": 0
											},
											{
												"type": "text",
												"text": "📞 077-276-999",
												"color": "#aaaaaa",
												"size": "xs",
												"align": "end"
											}
										]
									}
								]
							},
							"styles": {
								"footer": {
									"separator": true
								}
							}
						}
					}';

					$message_line_data = array(
						"detail" => $flexDataJson,
						"lpt_pt_id" => $row_lpt->lpt_pt_id,
						"type" => $qu_mst->msst_id,
						"status" => "Y"
					);

					$flexDataJsonDeCode = json_decode($flexDataJson, true);
					
					if (json_last_error() !== JSON_ERROR_NONE) {
						echo 'JSON Decode Error: ' . json_last_error_msg();
					}
					
					$datas['url'] = $this->config->item('api_line_message_push');
					$datas['token'] = $this->line_token;
					$messages['to'] = $row_lpt->lpt_user_line_id;
					$messages['messages'][] = $flexDataJsonDeCode;
					$encodeJson = json_encode($messages);

					$this->convert_flexmessage_for_sent_message($encodeJson, $datas, $message_line_data);
				} else {
					// หากไม่พบข้อมูลการจองคิว
					error_log("ไม่พบข้อมูลการจองคิวสำหรับ apm_id: $apm_id");
				}
			} else {
				// หากไม่พบข้อมูลผู้ป่วยในระบบ Line
				error_log("ไม่พบข้อมูลผู้ป่วยที่เข้าสู่ระบบผ่าน Line สำหรับ pt_id: $pt_id");
			}
		} else {
			// หากการตั้งค่า message หรือสถานะไม่ถูกต้อง
			error_log("Message หรือการตั้งค่าไม่ถูกต้องสำหรับ msst_id: $msst_id, pt_id: $pt_id, apm_id: $apm_id");
		}
	}
	
	/*
	 * send_message_appointment_to_patient
     * ส่ง Message ให้ User ในห้อง Chat เพื่อแจ้งกำหนดการนัดหมาย
	 * input : msst_id, pt_id, ap_id
	 * author: JIRADT
	 * Create Date : 2024-07-17
	 */
	public function send_message_appointment_to_patient_post()
	{
		//ขั้นตอนการทำ ref : https://medium.com/linedevth/จัดการ-dynamic-flex-message-ด้วย-php-ep-5-df1510f3cfcd
		$msst_id = $this->post('msst_id');	//รหัสข้อความไลน์
		$hn_id = $this->post('hn_id');	// รหัสผู้ป่วย
		$ap_id = $this->post('ap_id');	//รหัสคิว

		$this->M_line_message_log->msst_id = $msst_id;
		$amsu_mst = $this->M_line_message_log->get_by_message_sub_type_by_id()->row();
		if (isset($msst_id) && isset($hn_id) && isset($ap_id) && $amsu_mst->mst_active == "Y" && $amsu_mst->msst_active == "Y") {
			$this->load->model($this->config->item('ams_dir') . 'M_ams_appointment');
			$this->load->model($this->config->item('wts_dir') . 'M_wts_notifications_department');
			$ap_ams = $this->M_ams_appointment->get_email_patient(false, $ap_id, $hn_id)->row();
			$this->M_line_patient->lpt_pt_id = $ap_ams->pt_id;
			$qu_psl = $this->M_line_patient->get_person_by_send_message();
			if ($qu_psl->num_rows() > 0) { //หากเคยได้เข้าสู่ระบบผ่านไลน์
				$row_lpt = $qu_psl->row();
				if ($ap_ams) {
					$department = !empty($ap_ams->stde_name_th) ? $ap_ams->stde_name_th : 'ไม่ระบุแผนก';
					$doctor_name = !empty($ap_ams->doctor_name) ? $ap_ams->doctor_name : 'ไม่ระบุชื่อแพทย์';
					$flexDataJson = '
					{
						"type": "flex",
						"altText": "แจ้งเตือนการจองคิวของคุณ",
						"contents": {
							"type": "bubble",
							"body": {
							"type": "box",
							"layout": "vertical",
							"contents": [
								{
								"type": "text",
								"text": "การนัดหมายติดตามผลจากแพทย์",
								"weight": "bold",
								"color": "#1DB446",
								"size": "md",
								"margin": "none"
								},
								{
								"type": "box",
								"layout": "vertical",
								"margin": "sm",
								"spacing": "sm",
								"contents": [
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "' . ($ap_ams->ap_before_time == null ? "-" : $ap_ams->ap_before_time) . '",
										"size": "lg",
										"color": "#B22222",
										"flex": 4,
										"margin": "none"
										}
									]
									},
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "วันที่นัดหมาย",
										"size": "sm",
										"color": "#555555",
										"flex": 2
										},
										{
										"type": "text",
										"text": "' . fullDateTH3($ap_ams->ap_date) . '",
										"size": "sm",
										"color": "#111111",
										"align": "end",
										"flex": 3
										}
									]
									},
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "เวลา",
										"size": "sm",
										"color": "#555555",
										"flex": 2
										},
										{
										"type": "text",
										"text": "' . DateTime::createFromFormat("H:i:s", $ap_ams->ap_time)->format("H:i") . ' น.",
										"size": "sm",
										"color": "#111111",
										"align": "end",
										"wrap": true,
										"flex": 3
										}
									]
									},
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "ชื่อแพทย์",
										"size": "sm",
										"color": "#555555",
										"flex": 2
										},
										{
										"type": "text",
										"text": "' . $ap_ams->doctor_name . '",
										"size": "sm",
										"color": "#111111",
										"align": "end",
										"wrap": true,
										"flex": 4
										}
									]
									},
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "แผนก",
										"size": "sm",
										"color": "#555555",
										"flex": 2
										},
										{
										"type": "text",
										"text": "แผนกผู้ป่วยนอกจักษุฯ",
										"size": "sm",
										"color": "#111111",
										"align": "end",
										"wrap": true,
										"flex": 4
										}
									]
									},
									{
									"type": "separator",
									"margin": "xxl"
									},
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "เหตุผลการนัดหมาย:",
										"size": "sm",
										"color": "#555555",
										"flex": 5
										}
									],
									"margin": "xxl"
									},
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "' . $ap_ams->ap_detail_appointment . '",
										"size": "sm",
										"color": "#111111",
										"align": "start",
										"flex": 3,
										"wrap": true,
										"margin": "md"
										}
									]
									},
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "การเตรียมตัวก่อนพบแพทย์:",
										"size": "sm",
										"color": "#555555",
										"flex": 5
										}
									],
									"margin": "xxl"
									},
									{
									"type": "box",
									"layout": "horizontal",
									"contents": [
										{
										"type": "text",
										"text": "' . $ap_ams->ap_detail_prepare . '",
										"size": "sm",
										"color": "#111111",
										"align": "start",
										"flex": 3,
										"wrap": true,
										"margin": "md"
										}
									]
									}
								]
								},
								{
								"type": "separator",
								"margin": "xxl"
								},
								{
								"type": "box",
								"layout": "horizontal",
								"margin": "md",
								"contents": [
									{
									"type": "text",
									"text": "โรงพยาบาลจักษุสุราษฎร์",
									"size": "xs",
									"color": "#aaaaaa",
									"flex": 0
									},
									{
									"type": "text",
									"text": "📞 077-276-999",
									"color": "#aaaaaa",
									"size": "xs",
									"align": "end"
									}
								]
								}
							]
							},
							"styles": {
							"footer": {
								"separator": true
							}
							}
						}
						}';

					$message_line_data = array(
						"detail" => $flexDataJson,
						"lpt_pt_id" => $row_lpt->lpt_pt_id,
						"type" => $amsu_mst->msst_id,
						"status" => "Y"
					);

					$flexDataJsonDeCode = json_decode($flexDataJson, true);
					$datas['url'] = $this->config->item('api_line_message_push');
					$datas['token'] = $this->line_token;
					$messages['to'] = $row_lpt->lpt_user_line_id;
					$messages['messages'][] = $flexDataJsonDeCode;
					$encodeJson = json_encode($messages);
				} else {
					// หากไม่พบข้อมูลการจองคิว
					error_log("ไม่พบข้อมูลการนัดหมายสำหรับ ap_id: $ap_id");
				}

				$this->convert_flexmessage_for_sent_message($encodeJson, $datas, $message_line_data);
			}	//check login line

		}	//check active message
	}
	/*
	 * convert_flexmessage_for_sent_message
     * แปลงข้อความ flexmessage ที่ออกแบบไว้ แล้วส่งให้ user ทางแชท
	 * input : $encodeJson, $datas
	 * author: Tanadon
	 * Create Date : 2024-07-17
	 */
	function convert_flexmessage_for_sent_message($encodeJson, $datas, $message_line_data = array())
	{
		$datasReturn = [];
		$curl = curl_init();

		// ตั้งค่า cURL เพื่อส่งข้อมูล
		curl_setopt_array($curl, array(
			CURLOPT_URL => $datas['url'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $encodeJson,
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $datas['token'],
				"Cache-Control: no-cache",
				"Content-Type: application/json; charset=UTF-8",
			),
		));

		// ดำเนินการ cURL request
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // เก็บ HTTP status code

		curl_close($curl); // ปิด cURL

		// ตรวจสอบข้อผิดพลาด cURL หรือ HTTP Code
		if ($err) {
			$datasReturn = [
				'result' => 'N',
				'message' => 'cURL Error: ' . $err,
			];
			$message_line_data['detail'] = 'cURL Error: ' . $err;
			$message_line_data['status'] = 'N';
		} elseif ($httpCode !== 200) {
			$datasReturn = [
				'result' => 'N',
				'message' => 'HTTP Error: ' . $httpCode,
			];
			$message_line_data['detail'] = 'HTTP Code: ' . $httpCode . ' - Response: ' . $response;
			$message_line_data['status'] = 'N';
		} else {
			// ตรวจสอบ response body ว่าเป็น JSON ที่ถูกต้องหรือไม่
			$responseDecoded = json_decode($response, true);
			if (json_last_error() === JSON_ERROR_NONE) {
				$datasReturn = [
					'result' => 'Y',
					'message' => 'Success',
				];
				$message_line_data['detail'] = 'Success';
				$message_line_data['status'] = 'Y';
			} else {
				$datasReturn = [
					'result' => 'N',
					'message' => 'Invalid JSON response',
				];
				$message_line_data['detail'] = 'Invalid JSON response';
				$message_line_data['status'] = 'N';
			}
		}

		// pre($message_line_data); die;
		// บันทึก log เฉพาะเมื่อมีข้อมูล message_line_data
		if (!empty($message_line_data)) {
			$this->insert_message_log($message_line_data);
		}

		return $datasReturn;
	}
	//convert_flexmessage_for_sent_message

}
