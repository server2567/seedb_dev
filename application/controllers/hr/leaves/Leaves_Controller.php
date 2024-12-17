<?php
/*
* Leaves_Controller
* Controller หลักของ  leave
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 13/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../HR_Controller.php");
class Leaves_Controller extends HR_Controller {
	
	protected $view;
	protected $model;
	protected $controller; 

	public function __construct()
	{
        parent::__construct();
		$this->view = $this->config->item('hr_dir').$this->config->item('hr_leaves_dir');
		$this->model = $this->config->item('hr_dir').$this->config->item('hr_leaves_dir');
		$this->controller = $this->config->item('hr_dir').$this->config->item('hr_leaves_dir');
		
    }

    /*
	* update_leave_summary_data
	* อัพเดทข้อมูลผลรวมการลาของบุคลากรตามปี และประเภทการลา
	* @input $encrypt_id(ps_id), $year, $leave_id, $days = 0, $hours = 0, $minutes = 0, $is_cancellation = false
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/11/2567
	*/
    public function update_leave_summary_data($ps_id, $year, $leave_id, $days = 0, $hours = 0, $minutes = 0, $is_cancellation = false) {
        $this->load->model($this->model . 'M_hr_leave_summary');

        $ps_id = decrypt_id($ps_id);

        $leave_data = $this->M_hr_leave_summary->get_leave_summary_by_param($ps_id, $year, $leave_id)->row_array();
        
        if (empty($leave_data)) {
            return;
        }

        $total_minutes = ($days * 8 * 60) + ($hours * 60) + $minutes;
        $factor = $is_cancellation ? -1 : 1;

        // คำนวณการลา
        $used_days = $factor * floor($total_minutes / (8 * 60));
        $remaining_minutes = $factor * ($total_minutes % (8 * 60));
        $used_hours = floor(abs($remaining_minutes) / 60) * $factor;
        $used_minutes = ($remaining_minutes % 60) * $factor;

        $new_num_day = $leave_data['lsum_num_day'] + $used_days;
        $new_num_hour = $leave_data['lsum_num_hour'] + $used_hours;
        $new_num_minute = $leave_data['lsum_num_minute'] + $used_minutes;

        $new_remain_day = $leave_data['lsum_per_day'] - $new_num_day;
        $new_remain_hour = $leave_data['lsum_per_hour'] - $new_num_hour;
        $new_remain_minute = $leave_data['lsum_per_minute'] - $new_num_minute;

        // if ($leave_id == 2) {
        //     $new_remain_day += $leave_data['lsum_leave_old'];
        // }

        list($new_remain_day, $new_remain_hour, $new_remain_minute) = $this->normalize_leave_time($new_remain_day, $new_remain_hour, $new_remain_minute);

        $this->M_hr_leave_summary->update_leave_summary_by_param($new_num_day, $new_num_hour, $new_num_minute, $new_remain_day, $new_remain_hour, $new_remain_minute, $ps_id, $year, $leave_id);
    }
    // update_leave_summary_data

	/**
	 * check_leave_balance_data
	 * ตรวจสอบว่ายอดคงเหลือการลาพอเพียงสำหรับการลาหรือไม่
	 *
	 * @param int $ps_id - รหัสบุคลากร
	 * @param int $year - ปี
	 * @param int $leave_id - รหัสประเภทการลา
	 * @param int $days - จำนวนวันที่ใช้ไป
	 * @param int $hours - จำนวนชั่วโมงที่ใช้ไป
	 * @param int $minutes - จำนวนนาทีที่ใช้ไป
	 * @return array - ผลลัพธ์การตรวจสอบและข้อมูลยอดคงเหลือ
	 * @author Tanadon Tangjaimongkhon
	 * @Create Date 02/11/2567
	 */
	public function check_leave_balance_data($ps_id, $year, $leave_id, $days = 0, $hours = 0, $minutes = 0) {
		$this->load->model($this->model . 'M_hr_leave_summary');
		$ps_id = decrypt_id($ps_id);

		// แสดงจำนวนวัน ชั่วโมง และนาทีที่ขอลา
		// Requested Leave: Days = $days, Hours = $hours, Minutes = $minutes

		// echo "days : " . $days . "<br>";
		// echo "hours : " . $hours . "<br>";
		// echo "minutes : " . $minutes . "<br>";

		// ดึงข้อมูลยอดการลาปัจจุบัน
		$leave_data = $this->M_hr_leave_summary->get_leave_summary_by_param($ps_id, $year, $leave_id)->row_array();

		if (empty($leave_data)) {
			// กรณีที่ไม่พบข้อมูลการลา
			return ['status' => false, 'message' => "ไม่สามารถตรวจสอบยอดคงเหลือการลาได้"];
		}

		// แปลงการลาเป็นนาที
		$total_minutes = ($days * 8 * 60) + ($hours * 60) + $minutes;

		// คำนวณการลาในหน่วย วัน ชั่วโมง และนาที
		$used_days = floor($total_minutes / (8 * 60));
		$remaining_minutes = $total_minutes % (8 * 60);
		$used_hours = floor($remaining_minutes / 60);
		$used_minutes = $remaining_minutes % 60;

		// แปลงการลาเป็นนาที
		$total_minutes = ($days * 8 * 60) + ($hours * 60) + $minutes;

		// คำนวณการลาในหน่วย วัน ชั่วโมง และนาที
		$used_days = floor($total_minutes / (8 * 60));
		$remaining_minutes = $total_minutes % (8 * 60);
		$used_hours = floor($remaining_minutes / 60);
		$used_minutes = $remaining_minutes % 60;
	
		// คำนวณยอดคงเหลือหลังจากการลา
		$new_remain_day = $leave_data['lsum_remain_day'] - $used_days;
		$new_remain_hour = $leave_data['lsum_remain_hour'] - $used_hours;
		$new_remain_minute = $leave_data['lsum_remain_minute'] - $used_minutes;
	
		// echo "lsum_remain_day : ". $leave_data['lsum_remain_day'] . "<br>";
		// echo "lsum_remain_hour : ". $leave_data['lsum_remain_hour'] . "<br>";
		// echo "lsum_remain_minute : ". $leave_data['lsum_remain_minute'] . "<br>";
	
		// เรียกใช้ normalize_leave_time เพื่อจัดการค่าติดลบ
		list($new_remain_day, $new_remain_hour, $new_remain_minute) = $this->normalize_leave_time($new_remain_day, $new_remain_hour, $new_remain_minute);

		// ตรวจสอบว่าการลาน้อยกว่าหรือเท่ากับยอดคงเหลือในทุกหน่วย
		// $is_balance_sufficient = ($remain_days >= $days) && ($remain_hours >= $hours) && ($remain_minutes >= $minutes);

		if ($new_remain_day >= 0 && $new_remain_hour >= 0 && $new_remain_minute >= 0) {
			// หากยอดคงเหลือเพียงพอ
			return [
				'status' => 1,
				'message' => "ยอดคงเหลือการลาของคุณเพียงพอสำหรับการขอลาครั้งนี้"
			];
		} else {
			 // แปลงค่าที่เหลือในฐานข้อมูล
			 $remain_days = $leave_data['lsum_remain_day'];
			 $remain_hours = $leave_data['lsum_remain_hour'];
			 $remain_minutes = $leave_data['lsum_remain_minute'];
		 
			 // คำนวณส่วนต่างของนาที
			 $result_minutes = $remain_minutes - $minutes;
			 $borrowed_hours = 0;
			 if ($result_minutes < 0) {
				 // หากนาทีไม่พอ ยืมชั่วโมงโดยเพิ่ม 60 นาที
				 $borrowed_hours = ceil(abs($result_minutes) / 60);
				 $result_minutes += $borrowed_hours * 60;
			 } else {
				 $borrowed_hours = 0;
			 }
		 
			 // คำนวณความแตกต่างของชั่วโมงโดยรวมชั่วโมงที่ยืมจากนาที
			 $result_hours = $remain_hours - $hours - $borrowed_hours;
			 if ($result_hours < 0) {
				 $result_hours = abs($result_hours);
				 // แปลงชั่วโมงเกินและนาทีที่เหลือเป็นผลลัพธ์ที่คาดหวัง
				 if ($result_minutes > 0) {
					 $result_hours -= 1;
					 $result_minutes = 60 - $result_minutes;
				 }
			 } else {
				 $result_hours = 0;
				 $result_minutes = abs($result_minutes);
			 }
		 
			 // คำนวณความแตกต่างของวัน (หากยอดวันคงเหลือเพียงพอจะให้ค่า 0)
			 $result_days = $remain_days - $days;

			 if($result_days < 0){
				$result_days = abs($result_days);
			 }
		 
			 // สร้างข้อความสำหรับยอดเกินเฉพาะหน่วยที่มีค่าเกิน 0
			 $excess_message = [];
			 if ($result_days > 0) {
				 $excess_message[] = "$result_days วัน";
			 }
			 if ($result_hours > 0) {
				 $excess_message[] = "$result_hours ชั่วโมง";
			 }
			 if ($result_minutes > 0) {
				 $excess_message[] = "$result_minutes นาที";
			 }
			 $message = empty($excess_message)
						 ? "ยอดคงเหลือการลาเพียงพอ" 
						 : "ยอดคงเหลือการลาเกินมา " . implode(" ", $excess_message);
		 
			 // ผลลัพธ์สุดท้าย
			 return [
				 'status' => 0,
				 'excess_leave' => [
					 'days' => $result_days,
					 'hours' => $result_hours,
					 'minutes' => $result_minutes
				 ],
				 'message' => $message
			 ];
		}


		
	}
	// check_leave_balance_data

	/**
	 * normalize_leave_time
	 * ปรับค่าเวลาของวัน ชั่วโมง และนาทีให้เป็นหน่วยที่เหมาะสมก่อนการอัพเดทฐานข้อมูล
	 *
	 * @param int $days - จำนวนวัน
	 * @param int $hours - จำนวนชั่วโมง
	 * @param int $minutes - จำนวนนาที
	 * @return array - ค่า normalized ของวัน ชั่วโมง และนาที
	 * @author Tanadon Tangjaimongkhon
	 * @Create Date 02/11/2567
	 */
	public function normalize_leave_time($days, $hours, $minutes) {
		// ถ้านาทีเกิน 60 ให้เปลี่ยนเป็นชั่วโมง
		if ($minutes >= 60) {
			$hours += floor($minutes / 60);
			$minutes %= 60;
		} elseif ($minutes < 0) {
			// กรณีที่นาทีติดลบ ยืมชั่วโมง
			$hours -= ceil(abs($minutes) / 60);
			$minutes = 60 + ($minutes % 60);
		}

		// ถ้าชั่วโมงเกิน 8 ให้เปลี่ยนเป็นวัน
		if ($hours >= 8) {
			$days += floor($hours / 8);
			$hours %= 8;
		} elseif ($hours < 0) {
			// กรณีที่ชั่วโมงติดลบ ยืมวัน
			$days -= ceil(abs($hours) / 8);
			$hours = 8 + ($hours % 8);
		}

		return [$days, $hours, $minutes];
	}
	// normalize_leave_time

	

}

?>