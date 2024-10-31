<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/UMS_Controller.php"); //Include file มาเพื่อ extend

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

class Forgotpassword extends UMS_Controller{	
public function __construct(){
parent::__construct();
	$this->load->model('ums/m_ums_user');
}


	//ติดตั้ง composer require firebase/php-jwt
	//Set THEDBJWTSECRET ที่ ums_config
	//เรียนกใช้ use Firebase\JWT\JWT
	//ติดตั้งตาราง ums_forgot_password
	//ติดตั้ง composer require phpmailer/phpmailer
	
	// create 29/05/2024
	public function index (){

		if ( isset($_POST['email']) ){

			$data['error'] = NULL;
			$data['success'] = NULL;

			$ums = $this->load->database('ums', TRUE);
			$hr = $this->load->database('hr', TRUE);
			$hr_db = $hr->database;


			$dp_name = '';
			$sql = "SELECT us_dp_id,dp_name_th FROM ums_user 
					LEFT JOIN ums_department ON us_dp_id = dp_id
					WHERE us_dp_id IS NOT NULL LIMIT 1";
			$rs_dp = $ums->query($sql)->row();
			if($rs_dp){
				$dp_name = $rs_dp->dp_name_th;
			}


			$email = $_POST['email'];			
			$sql = "SELECT * FROM ums_user 
					LEFT JOIN {$hr_db}.hr_person_detail ON us_ps_id = psd_ps_id
					WHERE (us_email = ? OR psd_email = ?) AND us_active = 1";
			// echo $sql;die;
			$rs_check = $ums->query($sql,array($email, $email));
			// echo $ums->last_query();die;
			if ($rs_check->row()){
				if ($this->send_email($email)){
          $data['status'] = 'success';
          $data['message'] = 'Email ถูกต้อง<br><br><span class="font-18">กรุณาตรวจสอบที่ Email <br>ของท่านเพื่อทำการเปลี่ยน Password</span>';
				} else {
          $data['status'] = 'error';
          $data['message'] = 'ไม่สามารถส่ง Email ของท่านในระบบ <br><br><span class="font-18">ถ้ากรอก Email ถูกแล้ว แต่ยังขึ้นไม่พบข้อมูล <br>กรุณาติดต่อเจ้าหน้าที่สารสนเทศ '.$dp_name.'</span>';
				}
			} else {
        $data['status'] = 'error';
        $data['message'] = 'ไม่พบข้อมูล Email ของท่านในระบบ <br><br><span class="font-18">ถ้ากรอก Email ถูกแล้ว แต่ยังขึ้นไม่พบข้อมูล <br>กรุณาติดต่อเจ้าหน้าที่สารสนเทศ '.$dp_name.'</span>';
			}
		
			$this->load->view('gear/v_forgotpassword',$data);
		}else {

			$this->load->view('gear/v_forgotpassword');
		}
	}

	function send_email($email = NULL) {

		if ($email != NULL){

			$key = $this->config->item('THEDBJWTSECRET');

			$ums = $this->load->database('ums', TRUE);
			$hr = $this->load->database('hr', TRUE);
			$hr_db = $hr->database;

			$sql = "SELECT * FROM ums_user 
					LEFT JOIN {$hr_db}.hr_person_detail ON us_ps_id = psd_ps_id
					WHERE (us_email = ? OR psd_email = ?) AND us_active = 1";
			$rs_user = $ums->query($sql,array($email, $email))->row();

			$payload = array(
				"iss" => base_url(),
				"aud" => base_url(),
				"sub" => $rs_user->us_name,
				"action" => "password_reset",
				"email" => ($rs_user->psd_email == '')?$rs_user->us_email : $rs_user->psd_email,
				"iat" => time(),
    			"exp" => time() + 900 //  15 นาที
			);

			$jwt = JWT::encode($payload, $key, 'HS256');


			$sql = "DELETE FROM `ums_forgot_password` WHERE umfp_email = ? AND umfp_status = 0";
			$ums->query($sql,array($email));
			
			$sql = "INSERT INTO ums_forgot_password 
					(
						umfp_email,
						umfp_token,
						umfp_status
					)
					VALUES (?,?,?)";
			$ums->query($sql,array($email, $jwt, 0));


			$url = site_url().'/ums/forgotpassword/chang_password/'.$jwt;
			
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
				$mail->addAddress($email);   
                $mail->isHTML(true);

				$mail->Subject = 'คำขอเปลี่ยนรหัสผ่าน';

				$html = '<div style="background-color: #f5f5f5; font-family: Arial, sans-serif; ">
					<div style="width:100%;height:410px;margin:auto;">
						<div>
							<h1 style="font-size: 28px; color: #333; margin-bottom: 20px; text-align: center;">Reset password</h1>
						</div>
						<div style="width:570px;height: 229px;background-color:white;text-align: center;margin:auto;padding-top: 20px; margin-bottom: 40px;">
							<h2 >ระบบได้พบคำร้องขอการเปลี่ยนรหัสผ่านในระบบสารสนเทศองค์กร<br>โรงพยาบาลจักษุสุราษฎร์<br>(See Dashboard)</h2>
							<p style="font-size: 18px;">โปรดคลิกปุ่มด้านล่างเพื่อทำการเปลี่ยนรหัสผ่าน</p>
							<p style="font-size: 16px; color: #555; text-align: center;margin-bottom: 20px;">กรุณาเปลี่ยนรหัสผ่าน ภายในเวลา 15 นาที</p>
							<a href="'.$url.'" style="text-decoration: none; background-color: #4CAF50; color: white; padding: 10px 20px;
							border-radius: 5px; font-size: 20px;">กดเพื่อเปลี่ยนรหัสผ่าน</a>
						</div>
						<div style="font-size: 14px; color: #777; text-align: center; margin-top: 50px;">
							<p class="white"><br>'.$this->config->item('txt_copyright').'</p>
						</div>
					</div>
				</div>';

				// echo $html;die;
				$mail->Body = $html;
				$mail->send();

			} catch (Exception $e) {

            }
			

			return true;
		}else {
			return false;
		}

	
	}


	function chang_password($token = NULL) {

		$ums = $this->load->database('ums', TRUE);
		if ($token){

			$key = $this->config->item('THEDBJWTSECRET');
			$decoded = NULL;

			try {
				$decoded = JWT::decode($token, new Key($key, 'HS256'));
				$mail = $decoded->email;
				$sql = "SELECT * FROM ums_forgot_password 
						WHERE  umfp_token = '$token' AND umfp_email = '$mail' AND umfp_status = 0";

				if ($ums->query($sql)->num_rows() == 0) {
					$data['message'] = ' Email ของท่านได้เปลี่ยนรหัสผ่าน จาก URL นี้ได้สำเร็จแล้ว';
					$data['status'] = false;

				}else {
					
					$decoded = JWT::decode($token, new Key($key, 'HS256'));
					$data['email'] = $decoded->email;
					$data['token'] = $token;
					$data['message'] = 'สำเร็จ';
					$data['status'] = true;
				}
			} catch (ExpiredException $e) {
				if ($e->getMessage() == 'Expired token'){
					$data['message'] = '<span class="text-warning">URL สำหรับการเปลี่ยนรหัสผ่านของท่านหมดอายุ</span>';
					$data['status'] = false;
				}else {
					$data['message'] = 'เกิดข้อผิดพลาดในการขอเปลีย่นรหัสผ่าน กรุณาติดต่อพนักงาน';
					$data['status'] = false;
				}
		
			}
		
			$this->load->view('gear/v_resetpassword',$data);
		}else {

			$data['message'] = 'ไม่พบข้อมูลสำหรับเปลี่ยนรหัสผ่าน';
			$data['status'] = false;
			$this->load->view('gear/v_resetpassword',$data);
		}
	}

	function input_generate_password(){

		$ums = $this->load->database('ums', TRUE);
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$token = $this->input->post('token');

		$sql = "SELECT * FROM `ums_forgot_password` 
				WHERE umfp_email = ? AND umfp_token =  ? AND umfp_status = 1";

		$data['email'] = $email;
		$data['token'] = $token;

		$rs_check = $ums->query($sql, array($email, $token));
		if ($rs_check->row()){
			
			$data['status'] = false;
			$data['code'] = false;
			$data['message'] = 'URL ของท่านถูกเปลี่ยนรหัสผ่านเรียบร้อยแล้ว';
			$this->load->view('gear/v_resetpassword',$data);
		}else {
			
			$return = $this->select_by_email2($email);
			
			if($return){
				$this->m_ums_user->us_password = md5("O]O".$password."O[O");
				$this->m_ums_user->us_password_confirm = md5("O]O".$password."O[O");
				$this->m_ums_user->us_id = $return->us_id;
				$this->m_ums_user->resetpassword();

				$sql = "UPDATE `ums_forgot_password` SET `umfp_status`=1  
						WHERE umfp_email = ? AND umfp_token =  ? ";
				$ums->query($sql, array($email, $token));

				$data['status'] = true;
				$data['code'] = true;
				$data['message'] = 'ท่านได้เปลี่ยนรหัสผ่านสำเร็จแล้ว';
				$this->load->view('gear/v_resetpassword',$data);
			}else {
				$data['status'] = false;
				$data['code'] = false;
				$data['message'] = 'ไม่พบข้อมูลของท่าน';
				$this->load->view('gear/v_resetpassword', $data);
			}
		}

	}

	function select_by_email2($email) {

		$ums = $this->load->database('ums', TRUE);
		$hr = $this->load->database('hr', TRUE);
		$hr_db = $hr->database;

		$sql = "SELECT * FROM ums_user 
				LEFT JOIN {$hr_db}.hr_person_detail ON us_ps_id = psd_ps_id
				WHERE (us_email = ? OR psd_email = ?)";
		$query = $ums->query($sql, array($email, $email));

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}

		
	}
	
		
	function generatePassword($length = 9, $add_dashes = false, $available_sets = 'lud')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
		$password = str_shuffle($password);
	if(!$add_dashes)
		return $password;
		$dash_len = floor(sqrt($length));
		$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}	
	
	public function mail()
	{
		$this->load->library('email');
			$email=$this->input->post('email');	
			$return = $this->m_ums_user->select_by_email($email);
			// print_r($return); 
			if($return){
				// echo $return->UsID;
				$data['pass'] = $this->generatePassword();
				$this->m_ums_user->us_password = md5("O]O".$data['pass']."O[O");
				$this->m_ums_user->us_password_confirm = md5("O]O".$data['pass']."O[O");
				$this->m_ums_user->us_id = $return->UsID;
				$this->m_ums_user->resetpassword();
				$this->email->from('patiya@aos.in.th', 'SMEs');//ตั้งชื่อและที่อยู่ Email ์ของคนที่กำลังจะส่ง Email ์
				
				// echo $email; die;
				// $username=$this->input->post('username');
				$this->email->to($email); //กำหนดที่อยู่ E-mail ของผู้รับ
				//$this->email->cc('sayamon@buu.ac.th');//กำหนดที่อยู่ E-mail ของผู้รับ
				//$this->email->bcc('sayamon@buu.ac.th');//กำหนดที่อยู่ E-mail ของผู้รับ
				$this->email->subject('ยืนยันการเปลี่ยนรหัสผ่าน'); //กำหนดหัวเรื่อง Email 
				/*$this->email->message 
				( 'ตามที่ท่านขอเปลี่ยนรหัสผ่านการเข้าสู่ระบบ user management systems โปรดคลิ๊กเพื่อเข้าสู่ระบบ  '.'<a href="'.index.php/UMS/forgotpassword/mail3/.';');*/
				$Link = "index.php/UMS/forgotpassword/mail3";
				// echo md5($Link);
				$this->email->message('ตามที่ท่านขอเปลี่ยนรหัสผ่านการเข้าสู่ระบบ ทางผู้ดูแลระบบได้เปลี่ยนรหัสผ่านของท่านเป็น '.$data['pass'].' กรุณาเปลี่ยนรหัสผ่านหลังจากเข้าสู่ระบบแล้ว');
					
				//( 'ตามที่ท่านขอเปลี่ยนรหัสผ่านการเข้าสู่ระบบ user management systems   ' .base_url() . 'index.php/UMS/forgotpassword/mail3'.'/ หรือเข้าสู่ระบบ user management systems '. base_url() .'');
				
				
			/*	$this->email->message 
				( 'ตามที่ท่านขอเปลี่ยนรหัสผ่านการเข้าสู่ระบบ user management systems ขอให้ท่านทำการยืนยันการเปลี่ยนรหัสผ่าน  <a href="'.base_url().'"index.php/UMS/forgotpassword/mail3/"> คลิ๊กที่นี่ </a>');*/
				
				
				//echo $this->email->message('<a href="'.base_url().'"index.php/UMS/forgotpassword/mail3/"> คลิ๊กที่นี่ </a>';);
				

				//กำหนดข้อความเนื้อหาภายใน Email ์
				
				$this->email->send();//ฟังก์ชันส่งเมล์ คืนค่าเป็นตรรกะ TRUE หรือ FALSE ขึ้นอยู่กับการส่งสำเร็จหรือผิดพลาด สามารถใช้มันอยู่ในเงื่อนไขได้
				//echo $this->email->print_debugger();//ส่งกลับสตริงที่มีข้อความใด ๆ ที่เซิร์ฟเวอร์ส่วนหัวของ Email และหลักฐานทาง Email ์ ที่เป็นประโยชน์สำหรับการแก้จุดบกพร่อง
		
				$data['OK'] = 0;
				$this->load->view('UMS/v_showmail2',$data);
				}else{
				$data['OK'] = 1;
				$this->load->view('UMS/v_extras-forgotpassword',$data);
				}
}

public function mail3(){
		$data['OK'] = 1;
		$this->load->view('UMS/v_showmail3',$data);
}


public function update(){

	$this->m_ums_user->us_username = $this->input->post('us_username');
	$this->m_ums_user->us_password = $this->input->post('password');
	$this->m_ums_user->update();
		$data['OK'] = 1;
		$data['username']  = $this->m_ums_user->update_mail();

		
		$this->load->view('UMS/v_showmail4',$data);
}


	function reset(){

		$ums = $this->load->database('ums', TRUE);
		$ums_db = $ums->database;
		$hr = $this->load->database('hr', TRUE);
		$hr_db = $hr->database;



		if (isset($_POST['us_id'])){

			$usid = $_POST['us_id'];
			$sql = "SELECT * FROM {$ums_db}.us_id 
							LEFT JOIN {$hr_db}.hr_person_detail ON us_ps_id = psd_ps_id
							LEFT JOIN {$hr_db}.hr_person ON psd_ps_id = ps_id
							WHERE (us_id = ?)";

			$query = $ums->query($sql, array($usid));
			// pre($ums->last_query());die;
			$lname = strtolower($query->row()->ps_lname_en);
			$bir = $query->row()->psd_birthdate;
			$arr = explode('-', $bir);
			$last = '';
			if (sizeof($arr) > 0) {
				$last = '' . (intval($arr[0]) + 543);
			}

			$password = $lname . $last;

			$this->m_ums_user->us_password = md5("O]O" . $password . "O[O");
			$this->m_ums_user->us_password_confirm = md5("O]O" . $password . "O[O");
			$this->m_ums_user->us_id = $query->row()->us_id;
			$this->m_ums_user->resetpassword();
			// $data['s'] = $query->row()->UsID;
			$data['status'] = 'success';
			$data['message'] = 'รีเซ็ต Password สำเร็จ';

			echo json_encode($data);
		}else {

			$email  = $this->input->post('email');
			$res = $this->select_by_email2($email);
			if ($res === false) {
				$data['status'] = 'warning';
				$data['message'] = 'ไม่พบข้อมูล Email ของท่านในระบบ <br><br><span class="font-18">ถ้ากรอก Email ถูกแล้ว แต่ยังขึ้นไม่พบข้อมูล <br>กรุณาติดต่อเจ้าหน้าที่สารสนเทศโรงพยาบาลจักษุสุราษฎร์</span>';
				echo json_encode($data);
			}else {

					$sql = "SELECT * FROM {$ums_db}.ums_user 
							LEFT JOIN {$hr_db}.hr_person_detail ON us_ps_id = psd_ps_id
							LEFT JOIN {$hr_db}.hr_person ON psd_ps_id = ps_id
							WHERE (us_email = ? OR psd_email = ?)";
						
					$query = $ums->query($sql, array($email, $email));
					// pre($ums->last_query());die;
					$lname  =  strtolower($query->row()->ps_lname_en);
					$bir = $query->row()->psd_birthdate;
					$arr = explode('-',$bir);
					$last = '';
					if (sizeof($arr) > 0 ){
						$last = ''.(intval($arr[0])+543);
					}
	
					$password = $lname.$last;
	
					$this->m_ums_user->us_password = md5("O]O".$password."O[O");
					$this->m_ums_user->us_password_confirm = md5("O]O".$password."O[O");
					$this->m_ums_user->us_id = $query->row()->us_id;
					$this->m_ums_user->resetpassword();
					// $data['s'] = $query->row()->UsID;
					$data['status'] = 'success';
          $data['message'] = 'Email ถูกต้อง<br><br><span class="font-18">กรุณาตรวจสอบที่ Email <br>ของท่านเพื่อทำการเปลี่ยน Password</span>';
					echo json_encode($data);
			}
		}

	}
	
}
?>