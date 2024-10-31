<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('AMS_Controller.php');
// dev
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

class urgent_notify extends AMS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ams/M_ams_appointment');
		$this->load->model('que/M_que_appointment');
		$this->controller = $this->config->item('ams_dir') . 'urgent_notify/';
	}

	function index()
	{
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['stde_info'] = $this->M_ams_appointment->get_stde_id()->result();
		// pre($data['stde_info']);
		// die;
		$data['status_response'] = $this->config->item('status_response_show');
		$post['stde_id'] = $this->session->userdata('us_id');
		$post['appoint_status'] = 1;
		$data['notify_list'] = $this->M_ams_appointment->get_nonti_patient_by_doctor_id($post, 2)->result();
		date_default_timezone_set('Asia/Bangkok');
		$currentDateTime = new DateTime('now');
		$currentTimestamp = $currentDateTime->getTimestamp();
		foreach ($data['notify_list'] as $key => $value) {
			$dateTime = new DateTime($value->ap_date . ' ' . $ntl->ap_time);
			$dateTime->sub(new DateInterval('P' . $value->al_day . 'D'));
			$previousTimestamp = $dateTime->getTimestamp();
			$totalSeconds = ($previousTimestamp - $currentTimestamp);
			$days = floor($totalSeconds / 86400);
			$hours = floor(($totalSeconds % 86400) / 3600);
			if ($days < 0) {
				$value->cd_date = 'เกินกำหนดการแจ้งเตือน';
			} else {
				$value->cd_date = 'อีก ' . $days . ' วัน ' . $hours . ' ชั่วโมง';
			}
			$value->ap_id = encrypt_id($value->ap_id);
		}
		$data['draft_list'] = $this->M_ams_appointment->get_nonti_patient_by_doctor_id($post, 6)->result();
		foreach ($data['draft_list'] as $key => $value2) {
			$dateTime = new DateTime($value2->ap_date . ' ' . $value2->ap_time);
			$dateTime->sub(new DateInterval('P' . $value2->al_day . 'D'));
			$previousTimestamp = $dateTime->getTimestamp();
			$totalSeconds = ($previousTimestamp - $currentTimestamp);
			$days = floor($totalSeconds / 86400);
			$hours = floor(($totalSeconds % 86400) / 3600);
			if ($days < 0) {
				$value2->cd_date = 'เกินกำหนดการแจ้งเตือน';
			} else {
				$value2->cd_date = 'อีก ' . $days . ' วัน ' . $hours . ' ชั่วโมง';
			}
			$value2->ap_id = encrypt_id($value2->ap_id);
		}
		$data['controller_dir']  = $this->controller;
		$this->output('ams/urgent/v_urgent_show', $data);
	}
	function get_patient_info()
	{
		$ps_id = $this->session->userdata('us_id');
		$data['notify_list'] = $this->M_ams_appointment->get_nonti_patient_by_doctor_id(null, 2)->result();
		date_default_timezone_set('Asia/Bangkok');
		$currentDateTime = new DateTime('now');
		$currentTimestamp = $currentDateTime->getTimestamp();
		foreach ($data['notify_list'] as $key => $ntl) {
			$dateTime = new DateTime($ntl->ap_rp_date . '  12:30:00');
			$previousTimestamp = $dateTime->getTimestamp();
			$totalSeconds = ($previousTimestamp - $currentTimestamp);
			$days = floor($totalSeconds / 86400);
			$hours = floor(($totalSeconds % 86400) / 3600);
			if ($ntl->ap_ast_id == 1) {
				if ($days < 0) {
					$ntl->cd_date = 'เกินกำหนดการแจ้งเตือน';
				} else {
					$ntl->cd_date = 'อีก ' . $days . ' วัน ' . $hours . ' ชั่วโมง';
				}
			} else if ($ntl->ap_ast_id == 2) {
				$ntl->cd_date = 'แจ้งเตือนแล้ว';
			}
			$ntl->ap_date =  date('d-m-Y', strtotime($ntl->ap_date));
			if ($ntl->ap_rp_date != null) {
				$ntl->ap_rp_date = date('d-m-Y', strtotime($ntl->ap_rp_date));
			}
			$ntl->days = $days;
		}
		$data['draft_list'] = $this->M_ams_appointment->get_nonti_patient_by_doctor_id(null, 6)->result();
		foreach ($data['draft_list'] as $key => $dfl) {
			$dateTime = new DateTime($dfl->ap_rp_date . '  12:30:00');
			$previousTimestamp = $dateTime->getTimestamp();
			$totalSeconds = ($previousTimestamp - $currentTimestamp);
			$days = floor($totalSeconds / 86400);
			$hours = floor(($totalSeconds % 86400) / 3600);
			if ($days < 0) {
				$dfl->cd_date = 'เกินกำหนดการแจ้งเตือน';
			} else {
				$dfl->cd_date = 'อีก ' . $days . ' วัน ' . $hours . ' ชั่วโมง';
			}
			$dfl->ap_date =  date('d-m-Y', strtotime($dfl->ap_date));
			$dfl->ap_rp_date = date('d-m-Y', strtotime($dfl->ap_rp_date));
			$dfl->days = $days;
		}

		echo json_encode($data);
	}
	function encrypt_pt_id()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json, true);
		$index = 0;
		foreach ($data as $key => $value) {
			$return_info[$index]['ap_id'] = decrypt_id($value['ap_id']);
			if (isset($value['patientId'])) {
				$return_info[$index]['patientId'] = $value['patientId'];
			}
			$return_info[$index]['non_ap_id'] = $value['ap_id'];
			$index++;
		}
		echo json_encode($return_info);
	}
	public function report_urgent()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json, true);
		$personInfo = $data['data'];
		$status = $data['type'];
		foreach ($personInfo as $key => $value) {
			$value['ap_id'] = decrypt_id($value['ap_id']);
			$this->M_ams_appointment->ap_id = $value['ap_id'];
			$this->M_ams_appointment->ap_detail_appointment = $value['detail_appointment'];
			$this->M_ams_appointment->ap_detail_prepare = $value['detail_prepare'];
			$dateParts = preg_split("/[\/-]/", $value['fixedDate']);
			list($day, $month, $year) = array_slice($dateParts, 0, 3);
			if (strpos($value['fixedDate'], '/') !== false) {
				$year = (int)$year - 543;
			}
			$this->M_ams_appointment->ap_date = "$year-$month-$day";
			$this->M_ams_appointment->ap_time = $value['fixedTime'];
			if ($status == '6') {
				$this->M_ams_appointment->ap_ast_id = 6;
				$this->M_ams_appointment->ap_report_type = $value['reportType'];
			} else {
				$this->M_ams_appointment->ap_ast_id = $value['reportType'];
				$this->M_ams_appointment->ap_report_type = $value['reportType'];
			}
			if ($value['reportType'] == 2) {
				$this->M_ams_appointment->ap_rp_date = date('Y-m-d');
				$this->M_ams_appointment->ap_rp_time = date('H:i:s');
				// if ($status != '6') {
				// // 	$post_ap_date = escapeshellarg($this->M_ams_appointment->ap_date);
				// // 	$post_ap_time = escapeshellarg($value['fixedTime']);
				// // 	// // แปลง JSON เป็น argument ที่ปลอดภัยสำหรับ shell
				// // 	// // $email_safe = escapeshellarg($email_json);
				// $post_ap_id = escapeshellarg($value['ap_id']);
				// $post_pt_number = escapeshellarg($key);
				// // 	// echo "Return status: $return_var\n";
				// // 	// echo "Output: " . implode("\n", $output) . "\n";
				// }
			} else if ($value['reportType'] == 1) {
				$dateParts = preg_split("/[\/-]/", $value['reportDate']);
				list($day, $month, $year) = array_slice($dateParts, 0, 3);
				if (strpos($value['reportDate'], '/') !== false) {
					$year = (int)$year - 543;
				}
				$this->M_ams_appointment->ap_rp_date = "$year-$month-$day";
				$this->M_ams_appointment->ap_rp_time = $value['reportTime'];
			} else if ($value['reportType'] == 'NULL' || $value['reportType'] == 0) {
				$dateParts = preg_split("/[\/-]/", $value['fixedDate']);
				$this->M_ams_appointment->ap_ast_id = 1;
				list($day3, $month3, $year3) = array_slice($dateParts, 0, 3);
				if (strpos($value['fixedDate'], '/') !== false) {
					$year3 = (int)$year3 - 543;
				}
				$value['fixedDate'] = "$year3-$month3-$day3";
				$this->M_ams_appointment->ap_rp_date = date('Y-m-d', strtotime($value['fixedDate'] . " -{$value['al_day']} day"));
				$this->M_ams_appointment->ap_rp_time = $value['fixedTime'];
			}
			$this->M_ams_appointment->ap_update_user = $this->session->userdata('us_id');
			$this->M_ams_appointment->update();
			if ($value['reportType'] == 2 && $status != '6') {
				$post_ap_id = escapeshellarg($value['ap_id']);
				$post_pt_number = escapeshellarg($key);
				// $this->send_line($post_ap_id, $post_pt_number);
				// ส่งอีเมล์ใน background
				$command_email = "php " . escapeshellarg(FCPATH . "index.php") . " ams/Urgent_notify send_email {$post_ap_id} {$post_pt_number} > /dev/null 2>&1 &";
				exec($command_email, $output_email, $return_var_email);
				$line_data = array(
					"msst_id" => $this->config->item('message_ams_line_id'),
					"hn_id" =>$post_pt_number,
					"ap_id" => $post_ap_id
				);
				$url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_appointment_to_patient";
				get_url_line_service($url_service_line, $line_data);
				// // ส่งข้อความผ่าน LINE ใน background
				// $command_line = "php " . escapeshellarg(FCPATH . "index.php") . " ams/Urgent_notify send_line {$post_ap_id} {$post_pt_number} > /dev/null 2>&1 &";
				// exec($command_line, $output_line, $return_var_line);
			}
		}
	}
	public function send_line($ap_id, $pt_number)
	{
		$line_data = array(
			"msst_id" => $this->config->item('message_ams_line_id'),
			"hn_id" => $pt_number,
			"ap_id" => $ap_id
		);
		$url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_appointment_to_patient";
		get_url_line_service($url_service_line, $line_data);
	}
	public function send_email($post_ap_id, $post_pt_number)
	{
		$info = $this->M_ams_appointment->get_email_patient(false, $post_ap_id, $post_pt_number)->row();

		$key = $this->config->item('THEDBJWTSECRET');
		$ums = $this->load->database('ums', TRUE);
		$hr = $this->load->database('hr', TRUE);
		$hr_db = $hr->database;

		// $sql = "SELECT * FROM ums_user 
		// 		LEFT JOIN {$hr_db}.hr_person_detail ON us_ps_id = psd_ps_id
		// 		WHERE (us_email = ? OR psd_email = ?) AND us_active = 1";
		// $rs_user = $ums->query($sql, array($email, $email))->row();
		$payload = array(
			"iss" => base_url(),
			"aud" => base_url(),
			"sub" => 'test',
			"action" => "password_reset",
			"email" => $info->pt_email,
			"iat" => time(),
			"exp" => time() + 900 //  15 นาที
		);

		$jwt = JWT::encode($payload, $key, 'HS256');
		// $url = site_url() . '/ums/forgotpassword/chang_password/' . $jwt;

		$mail = new PHPMailer(true);
		try {
			$mail->SMTPDebug = false;                             //Enable verbose debug output
			$mail->isSMTP();                                      //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                 //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                             //Enable SMTP authentication
			$mail->Username   = $this->config->item('emailer');           //SMTP username
			$mail->Password   = $this->config->item('passwordForApp');
			$mail->SMTPSecure = 'ssl';                            //SMTP password
			$mail->Port       = 465;                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
			$mail->CharSet = "UTF-8";
			$mail->Encoding = 'base64';

			$mail->setFrom($this->config->item('emailer'), 'ระบบสารสนเทศองค์กร โรงพยาบาลจักษุสุราษฎร์ (See Dashboard)');
			$mail->addAddress($info->pt_email);
			$mail->isHTML(true);
			$mail->Subject = 'กำหนดการนัดหมายผู้ป่วย';
			$html = '
                    <div style="background-color: #f5f5f5; font-family: Arial, sans-serif;">
                        <div style="width:100%; height:700px; margin:auto; padding: 20px;">
                            <div class="col-6" style="width:570px; min-height:500px; max-height: auto; background-color:white; text-align: center; margin:auto; padding-top: 20px; margin-bottom: 40px; padding:20px">
                                <h2>
									<img src="https://surateyehospital.com/wp-content/uploads/2020/08/surateyehospital-nobg.png" alt="" style="max-height: 60px; margin-top: -5px;">
                                    <img src="https://seedb.aos.in.th/assets/img/logo.png" alt="Success" style=" bottom: 20px; right: 10px; max-height: 65px;margin-left: 10px;">
									<br>
									ใบนัดหมาย
								</h2>
                                <p style="text-align:start; font-size: 16px;">วันที่นัดหมาย: <b>' . abbreDate2($info->ap_date) . ' ณ เวลา ' . substr($info->ap_time, 0, 5) . ' น.</b></p>
                                <p style="text-align:start; font-size: 16px;"><b>' . $info->ap_before_time . '</b></p>
                                <hr>
                                <h3 style="text-align:start">เหตุผลการนัดหมาย:</h3>
                                <div style="padding:10px; text-align:start">' . $info->ap_detail_appointment . '</div>
                                <h3 style="text-align:start">การเตรียมตัวก่อนพบแพทย์:</h3>
                                <div style="padding:10px; text-align:start">' . $info->ap_detail_prepare . '</div>
                            </div>
                            <div style="font-size: 14px; color: #777; text-align: center;">
                                <p class="white"><br>' . $this->config->item('txt_copyright') . '</p>
                            </div>
                        </div>
                    </div>
                    ';
			$html1 = '';
			// echo $html;die;
			$mail->Body = $html;
			// $mail->Timeout = 20;
			$mail->send();
			// pre($mail);
			// if ($mail->send()) {
			// 	echo "Email sent successfully.";
			// }
		} catch (Exception $e) {
		}


		return true;
		// } else {
		// 	return false;
		// }
	}
	public function get_patien_list_by_filter()
	{
		function thaiDateToGregorianDate($thaiDate)
		{
			$parts = explode('/', $thaiDate);
			$day = intval($parts[0]);
			$month = intval($parts[1]);
			$yearBE = intval($parts[2]);
			$year = $yearBE - 543;

			return sprintf('%04d-%02d-%02d', $year, $month, $day);
		}
		$data = $this->input->post();
		if (!$data) {
			return;
		}
		$data['start_date'] = $data['start_date'] != '' ? thaiDateToGregorianDate($data['start_date']) : '';
		$data['end_date'] = $data['end_date'] != '' ? thaiDateToGregorianDate($data['end_date']) : '';
		$data['patien-list'] = $this->M_ams_appointment->get_nonti_patient_by_doctor_id($data, 2)->result();
		$data['patien-draft'] = $this->M_ams_appointment->get_nonti_patient_by_doctor_id($data, 6)->result();
		$currentDateTime = new DateTime('now');
		$currentTimestamp = $currentDateTime->getTimestamp();
		foreach ($data['patien-list'] as $key => $value) {
			$dateTime = new DateTime($value->ap_rp_date . '  12:30:00');
			$previousTimestamp = $dateTime->getTimestamp();
			$totalSeconds = ($previousTimestamp - $currentTimestamp);
			$days = floor($totalSeconds / 86400);
			$hours = floor(($totalSeconds % 86400) / 3600);
			if ($value->ap_ast_id == 1) {
				if ($days < 0) {
					$value->cd_date = 'เกินกำหนดการแจ้งเตือน';
				} else {
					$value->cd_date = 'อีก ' . $days . ' วัน ' . $hours . ' ชั่วโมง';
				}
				$value->days = $days;
			} else if ($value->ap_ast_id == 2) {
				$value->cd_date = fullDateTH3($value->ap_rp_date);
				$value->days = -1;
			}
			$value->ap_id = encrypt_id($value->ap_id);
		}
		foreach ($data['patien-draft'] as $key => $value2) {
			$dateTime = new DateTime($value2->ap_rp_date . '  12:30:00');
			$previousTimestamp = $dateTime->getTimestamp();
			$totalSeconds = ($previousTimestamp - $currentTimestamp);
			$days = floor($totalSeconds / 86400);
			$hours = floor(($totalSeconds % 86400) / 3600);
			if ($days < 0) {
				$value2->cd_date = 'เกินกำหนดการแจ้งเตือน';
			} else {
				$value2->cd_date = 'อีก ' . $days . ' วัน ' . $hours . ' ชั่วโมง';
			}
			$value2->ap_id = encrypt_id($value2->ap_id);
			$value2->days = $days;
		}
		echo json_encode($data);
	}
	public function show_info($id)
	{
		$data['id'] = $id;
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
		$this->output('que/patient/v_patient_info', $data);
	}
	public function return_status($status)
	{
		if ($status == '1') {
			return 'รอการแจ้งเตือน';
		} else if ($status == '2') {
			return 'แจ้งเตือนแล้ว';
		} else if ($status == '6') {
			return 'ฉบับร่าง แจ้งเตือนแบบเร่งด่วน';
		}
	}
	public function show_patient($id)
	{
		$data['id'] = $id;
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
		$this->output('que/patient/v_patient_show', $data);
	}
	public function send_email_update_status($pt_id, $apm_id, $ntdp_loc_Id, $ntdp_loc_ft_Id) {
		// ดึงข้อมูลผู้ป่วยจากฐานข้อมูล
		$info = $this->db->query("SELECT * FROM see_umsdb.ums_patient WHERE pt_id = ?", array($pt_id))->row();
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

		$location = !empty($apm_que->dp_name_th) ? $apm_que->dp_name_th : 'ไม่ระบุสถานที่';
		$department = !empty($apm_que->stde_name_th) ? $apm_que->stde_name_th : 'ไม่ระบุแผนก';

		// การตั้งค่า PHPMailer
		$mail = new PHPMailer(true);
		try {
			$mail->SMTPDebug = false;                             //Enable verbose debug output
			$mail->isSMTP();                                      //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                 //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                             //Enable SMTP authentication
			$mail->Username   = $this->config->item('emailer');   //SMTP username
			$mail->Password   = $this->config->item('passwordForApp');
			$mail->SMTPSecure = 'ssl';                            //SMTP password
			$mail->Port       = 465;                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
			$mail->CharSet = "UTF-8";
			$mail->Encoding = 'base64';
	
			$mail->setFrom($this->config->item('emailer'), 'ระบบสารสนเทศองค์กร โรงพยาบาลจักษุสุราษฎร์ (See Dashboard)');
			$mail->addAddress($info->pt_email);
			$mail->isHTML(true);
			$mail->Subject = 'กำหนดการนัดหมายผู้ป่วย';

			$html = '
					<div style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
						<div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 10px;">
							<div style="text-align: center; margin-bottom: 20px;">
								<img src="https://surateyehospital.com/wp-content/uploads/2020/08/surateyehospital-nobg.png" 
									alt="Surat Eye Hospital" 
									style="max-height: 60px; margin-top: -5px;">
								<h2 style="margin-top: 10px; font-size: 24px; color: #4a4a4a;">นัดหมาย/จองคิว</h2>
							</div>
							<h3>หมายเลขคิว ' . $apm_que->apm_ql_code . '</h3>
							<hr>
							<p><strong>สถานที่:</strong> ' . $location . '</p>
							<p><strong>แผนก:</strong> ' . $department . '</p>
							<p><strong>วันที่เข้ารับบริการ:</strong> ' . fullDateTH3($apm_que->apm_date) . '</p>
							<p><strong>เวลา:</strong> ' . DateTime::createFromFormat("H:i", $apm_que->apm_time)->format("H:i") . ' น.</p>
							<p><strong>จุดบริการปัจจุบัน:</strong> ' . $current_service_point . '</p>
							<p><strong>จุดบริการถัดไป:</strong> ' . $next_service_point . '</p>
							<hr>
							<p><strong>VISIT:</strong> ' . ($apm_que->apm_visit == null ? "-" : $apm_que->apm_visit) . '</p>
							<p><strong>HN:</strong> ' . ($apm_que->pt_member == null ? "-" : $apm_que->pt_member) . '</p>
							<p><strong>ชื่อผู้ป่วย:</strong> ' . $apm_que->pt_name . '</p>
							<p><strong>ว/ด/ป เกิด:</strong> ' . getbirthDate($apm_que->ptd_birthdate) . '</p>
							<p><strong>อายุ:</strong> ' . calAge3($apm_que->ptd_birthdate) . ' ปี</p>
							<p><strong>เพศ:</strong> ' . ($apm_que->ptd_sex == "M" ? "ชาย" : "หญิง") . '</p>
							<hr>
							<p style="text-align: center; color: #777;">
								โรงพยาบาลจักษุสุราษฎร์: <a href="tel:077-276-999">077-276-999</a>
							</p>
						</div>
					</div>
				';

			$mail->Body = $html;
			$mail->send();
		} catch (Exception $e) {
			// การจัดการข้อผิดพลาด
		}
		return true;
	}
	

}
