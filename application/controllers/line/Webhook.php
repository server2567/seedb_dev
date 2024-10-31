<?php
/**
 * This is Line Service
 * User: Tanadon Tangjaimongkhon
 * Date: 2024-07-17
 */


class Webhook extends CI_Controller
{
	
	protected $view;
	protected $model;
	protected $controller; 
	protected $line_token;

	public function __construct(){
		parent::__construct();
	
		// Directory path
		$this->view = $this->config->item('line_dir');
		$this->model = $this->config->item('line_dir');
		$this->controller = $this->config->item('line_dir');

		//load model
		$this->load->model($this->model.'M_line_patient');
		$this->load->model($this->model.'M_line_message_log');

        //Line Token The DB
        $this->line_token = $this->config->item('line_token');
	}

	 /*
     * get_webhook_line_data
     * get webhook line data
     * input : 
     * author: Tanadon
     * Create Date : 2024-07-17
     */
	public function get_webhook_line_data() {
		$input = file_get_contents('php://input');
		$events = json_decode($input, true);
	
		if (!is_null($events['events'])) {
			foreach ($events['events'] as $event) {
				if ($event['type'] == 'message') {
					$messageType = $event['message']['type'];
					$messageText = isset($event['message']['text']) ? $event['message']['text'] : '';
					$imageUrl = isset($event['message']['originalContentUrl']) && $messageType == 'image' ? $event['message']['originalContentUrl'] : '';
					$videoUrl = isset($event['message']['originalContentUrl']) && $messageType == 'video' ? $event['message']['originalContentUrl'] : '';
					$sourceType = $event['source']['type'];
					$userId = $event['source']['userId'];
					$replyToken = $event['replyToken'];
					$reply_message = "";
					if($messageText == "นัดหมาย/จองคิว"){
						$reply_message = "ท่านสามารถติดต่อได้ที่โรงพยาบาลจักษุสุราษฎร์\n"."หรือ โทร. 077276999";
					}
					else{
						// $reply_message = 'Reply message : '.$messageText."\nUser ID : ".$userId."\n" ;        
						// $reply_message .= 'type : '. $event['type']."\n";
						// $reply_message .= 'messageType : '. $messageType."\n";
						// $reply_message .= 'img url : '. $imageUrl."\n";
						// $reply_message .= 'video url : '. $videoUrl."\n";
						// $reply_message .= 'sourceType : '. $sourceType."\n";
					}
					
					$send_result = $this->send_line_reply_message($this->line_token, $replyToken, $reply_message);
				}
			}
		}
	
		// $this->response(['status' => 'success'], 200);
	}

	 /*
     * send_broadcast_message
     * ส่งข้อความบอร์ดแคสต์
     * input : $messageText, $imageUrl, $videoUrl
     */
	public function send_broadcast_message($messageText, $imageUrl = '', $videoUrl = '') {
		$accessToken = $this->line_token;
	
		$data = [
			'messages' => [[
				'type' => 'text',
				'text' => $messageText
			]]
		];
	
		$ch = curl_init('https://api.line.me/v2/bot/message/broadcast');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer ' . $accessToken
		]);
	
		$result = curl_exec($ch);
		curl_close($ch);
	
		// ตรวจสอบการตอบกลับจาก API และบันทึกข้อมูลในฐานข้อมูล
		if ($result) {
			// $this->log_broadcast_message($messageText, $imageUrl, $videoUrl);
		}
	}
	
	private function log_broadcast_message($messageText, $imageUrl, $videoUrl) {
		$insertSql = "INSERT INTO broadcasts (message, image_url, video_url, timestamp) VALUES (?, ?, ?, NOW())";
		$stmt = $this->db->conn_id->prepare($insertSql);
		$stmt->bind_param("sss", $messageText, $imageUrl, $videoUrl);
		$stmt->execute();
		$stmt->close();
	}
	
	

     /*
	 * send_line_reply_message
     * ส่ง Message ให้ User ในห้อง Chat
	 * input : $access_token, $reply_token, $reply_message
	 * author: tanadon
	 * Create Date : 2022-02-26
	 */

	 protected function send_line_reply_message($access_token, $reply_token, $reply_message)
	 {
		 $url = 'https://api.line.me/v2/bot/message/reply';
		 $post_header = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
 
 
		 $data = [
			 'replyToken' => $reply_token,
			 'messages' => [
				 [
					 'type' => 'text', 
					 'text' => $reply_message,
				 ]
			 ],
		 ];
		 $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
 
 
		 $ch = curl_init($url);
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		 $result = curl_exec($ch);
		 curl_close($ch);
 
		 $obj_result = json_decode($result);
		 return $obj_result;
	 }//send_line_reply_message
	
}
?>