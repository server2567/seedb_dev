<?php
function phone_number_format($number) {
	// Allow only Digits, remove all other characters.
	$number = preg_replace("/[^\d]/","",$number);

	// get number length.
	$length = strlen($number);
	// if number = 10
	if($length == 10) {
		$number = preg_replace("/^1?(\d{2})(\d{4})(\d{4})$/", "$1-$2-$3", $number);
	}else if($length == 9){
		$number = preg_replace("/^1?(\d{1})(\d{4})(\d{4})$/", "$1-$2-$3", $number);
	}

	return $number;
}
function digi_to_thai($num)
{
	return str_replace(array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ), array( "๐" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙" ), $num); 
}
function thai_to_digi($num)
{
	return str_replace(array( "๐" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙" ), array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ), $num); 
}
function readNumber($number, $len) {
	if($number=='0') { $number = ""; }
	else if($number=='1') {
		if($len==2) { $number = ""; }
		else { $number = "หนึ่ง"; }
	}
	else if($number=='2') { 
		if($len==2) { $number = "ยี่"; }
		else { $number = "สอง"; }
	}
	else if($number=='3') { $number = "สาม"; }
	else if($number=='4') { $number = "สี่"; }
	else if($number=='5') { $number = "ห้า"; }
	else if($number=='6') { $number = "หก"; }
	else if($number=='7') { $number = "เจ็ด"; }
	else if($number=='8') { $number = "แปด"; }
	else if($number=='9') { $number = "เก้า"; }
	return $number;
}

function readUnit($len) {
	if($len=='1') { $len = ""; }
	else if($len=='2') { $len = "สิบ"; }
	else if($len=='3') { $len = "ร้อย"; }
	else if($len=='4') { $len = "พัน"; }
	else if($len=='5') { $len = "หมื่น"; }
	else if($len=='6') { $len = "แสน"; }
	else if($len=='7') { $len = "ล้าน"; }
	return $len;
}

// function num2thai($number){
// 	$t1 = array("ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
// 	$t2 = array("เอ็ด", "ยี่", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน");
// 	$zerobahtshow = 0; // ในกรณีที่มีแต่จำนวนสตางค์ เช่น 0.25 หรือ .75 จะให้แสดงคำว่า ศูนย์บาท หรือไม่ 0 = ไม่แสดง, 1 = แสดง
// 	(string) $number;
// 	$number = explode(".", $number);
// 	if (!empty($number[1])) {
// 		if (strlen($number[1]) == 1) {
// 			$number[1] .= "0";
// 		} else if (strlen($number[1]) > 2) {
// 			if ($number[1]{2} < 5) {
// 				$number[1] = substr($number[1], 0, 2);
// 			} else {
// 				$number[1] = $number[1]{0}.($number[1]{1}+1);
// 			}
// 		}
// 	}
// 	for ($i = 0; $i < count($number); $i++) {
// 		$countnum[$i] = strlen($number[$i]);
// 		if ($countnum[$i] <= 7) {
// 			$var[$i][] = $number[$i];
// 		} else {
// 			$loopround = ceil($countnum[$i]/6);
// 			for ($j = 1; $j <= $loopround; $j++) {
// 				if ($j == 1) {
// 					$slen = 0;
// 					$elen = $countnum[$i]-(($loopround-1)*6);
// 				} else {
// 					$slen = $countnum[$i]-((($loopround+1)-$j)*6);
// 					$elen = 6;
// 				}
// 				$var[$i][] = substr($number[$i], $slen, $elen);
// 			}
// 		}
// 		$nstring[$i] = "";
// 		for ($k = 0; $k < count($var[$i]); $k++) {
// 			if ($k > 0) $nstring[$i] .= $t2[7];
// 			$val = $var[$i][$k];
// 			$tnstring = "";
// 			$countval = strlen($val);
// 			for ($l = 7; $l >= 2; $l--) {
// 				if ($countval >= $l) {
// 					$v = substr($val, -$l, 1);
// 					if ($v > 0) {
// 						if ($l == 2 && $v == 1) {
// 							$tnstring .= $t2[($l)];
// 						} else if ($l == 2 && $v == 2) {
// 							$tnstring .= $t2[1].$t2[($l)];
// 						} else {
// 							$tnstring .= $t1[$v].$t2[($l)];
// 						}
// 					}
// 				}
// 			}
// 			if ($countval >= 1) {
// 				$v = substr($val, -1, 1);
// 				if ($v > 0) {
// 					if ($v == 1 && $countval > 1 && substr($val, -2, 1) > 0) {
// 						$tnstring .= $t2[0];
// 					} else {
// 						$tnstring .= $t1[$v];
// 					}
// 				}
// 			}
// 			$nstring[$i] .= $tnstring;
// 		}
// 	}
// 	$rstring = "";
// 	if (!empty($nstring[0]) || $zerobahtshow == 1 || empty($nstring[1])) {
// 		if ($nstring[0] == "") $nstring[0] = $t1[0];
// 		$rstring .= $nstring[0]."บาท";
// 	}
// 	if (count($number) == 1 || empty($nstring[1])) {
// 		$rstring .= "ถ้วน";
// 	} else {
// 		$rstring .= $nstring[1]."สตางค์";
// 	}
// 	return $rstring;
// }

function convertNumberToString($amount) {
	list($baht, $satang) = preg_split('[\.]', $amount);
	while (strlen($satang) < 2) {
		$satang .= '0';
	}
		
	$str = "";
	$len = strlen($baht);
	$i = 0;
	while ($i < strlen($baht)) {
		if ($len==1 && $baht[$i-1]!=0 && $baht[$i]==1) {
			$str .= "เอ็ด";
		} else {
			$str .= readNumber($baht[$i], $len);
		}
		
		if ($baht[$i] != 0) {
			$str .= readUnit($len);
		}
		
		$len--;
		$i++;
	}
	
	if ($str != "") {
		$str .= "บาท";
	}
	
	$len = strlen($satang);
	$i = 0;
	while ($i < strlen($satang)) {
		if ($len==1 && $satang[$i-1]!=0 && $satang[$i]==1) {
			$str .= "เอ็ด";
		} else {
			$str .= readNumber($satang[$i], $len);
		}

		if ($satang[$i] != 0) {
			$str .= readUnit($len);
		}
		
		$len--;
		$i++;
	}
	
	if ($satang != '00') {
		$str .= "สตางค์";
	}
	
	return $str;
}

function getval($varname, $rw, $v='') {
	if ( set_value($varname) <> '' ) {
		$v = set_value($varname);
	} else if ( !is_null($rw) ) {
		if ($rw->$varname == "0000-00-00") {
			$v = getNowDateFw2();
		} else {
			$v = $rw->$varname;		// varname เป็นชื่อฟิลด์จากตาราง
		}
	}
	return $v;
}

function checkFomatIdCard($id){//เช็ค fomat เลขบัตรประจำตัวประชาชน
	if(strlen($id)==13){
		$arr = substr($id, 0);
		$sumV = 0;
		for($i=0;$i<12;$i++) $sumV+=$arr[$i]*(13 - $i);
		$modV=11-($sumV%11);
		if($modV>9) $modV-=10;
		if($modV!=$arr[12]) return false;
		else return true;
	}else return false;
}

function pre($value="") { // Create Tag "<pre>...</pre>" 
	echo "<pre>"; 
	if($value!=""){
		if(is_array($value)) { 
			print_r($value); 
		} else { 
			var_dump($value); 
		} 
	}else{
		echo "Not value to function \"pre\".";
	}
	echo "</pre>"; 
}

function firstUpperText($text){
    return ucfirst(strtolower($text));
}

function openFile($path){
    
	$file = ''.$path; 
  if(file_exists($file)){

    $settype1 = pathinfo($file);

    $set=$settype1['extension'];
    if( $set == "pdf"){$typeset = "application/pdf";}
    if( $set == "js"){$typeset = "application/x-javascript";}
    if( $set == "json"){$typeset = "application/json";}

    if( ($set == "doc") || ($set == "docx") ){$typeset = "application/msword";}
    if( (($set == "jpg") || ($set == "jpeg")) ||  ($set == "jpe") || ($set == "JPG")  ){$typeset = "image/jpg";}
	if( $set == "png" ){$typeset = "image/png";}
    if( (($set == "xls") || ($set == "xlm")) ||  ($set == "xld") ){$typeset = "application/vnd.ms-excel";}


    if( ($set == "ppt") || ($set == "pps") ){$typeset = "application/vnd.ms-powerpoint";}
    if( $set == "rtf"){$typeset = "application/rtf";}
    if( $set == "txt"){$typeset = "text/plain";}
    if( $set == "zip"){$typeset = "application/zip";}
	if( $set == "mp4"){$typeset = "video/mp4";}

    if($typeset == "image/jpg" || $typeset == "image/png"){
      $contents = file_get_contents($file);
      $base64   = base64_encode($contents); 
      return ('data:' . $set . ';base64,' . $base64); 
    }else{
      
		  $hr = 'Content-type:'.' /'.$typeset;
		  header($hr);

			ob_clean();
			  flush();
		
		readfile($file);
	}
  }
}

function convertToThaiYear($dateString, $is_show_time = true, $is_show_second = false) {
	if (!empty($dateString)) {
		// Create a DateTime object from the input string
		$date = new DateTime($dateString);
		
		// Extract the year, month, day, hour, minute, and second components
		$year = $date->format('Y');
		$month = $date->format('m');
		$day = $date->format('d');
		$hour = $date->format('H');
		$minute = $date->format('i');
		$second = $date->format('s');
		
		// Add 543 years to the year component (Thai calendar year)
		$thaiYear = $year + 543;
		
		// Create a new DateTime object with the modified year
		$newDateString = "$thaiYear-$month-$day";
		if($is_show_time)
			$newDateString .= " $hour:$minute:$second";
		$newDate = new DateTime($newDateString);
		
		// Format the new date to 'd/m/Y H:i:s'
		if($is_show_time) {
			if($is_show_second) return $newDate->format('d/m/Y เวลา H:i:s น.');
			else return $newDate->format('d/m/Y เวลา H:i น.');
		} else
			return $newDate->format('d/m/Y');
	}
	return '';
}

// Function to detect device type based on user agent string
function detect_device_type() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	// Define patterns for different types of devices
	$mobile_patterns = '/mobile|android|iphone|ipod|blackberry|iemobile|opera mini|windows phone/i';
	$tablet_patterns = '/ipad|tablet|kindle|playbook|silk/i';
	$desktop_patterns = '/windows|macintosh|linux|cros/i';

	// Check for tablet devices first
	if (preg_match($tablet_patterns, $user_agent)) {
		return 'tablet';
	}
	// Check for mobile devices
	else if (preg_match($mobile_patterns, $user_agent)) {
		return 'mobile';
	}
	// Check for desktop devices
	else if (preg_match($desktop_patterns, $user_agent)) {
		return 'computer';
	}
	// Default to computer if none of the patterns match
	else {
		return 'computer';
	}
}

// Function to detect device type based on user agent string
function detect_device_type_ip() {
  $user_agent = $_SERVER['HTTP_USER_AGENT'];

  // Define patterns for different types of devices
  $mobile_patterns = [
      'iPhone' => '/iphone/i',
      'iPod' => '/ipod/i',
      'Android' => '/android/i',
      'BlackBerry' => '/blackberry/i',
      'Windows Phone' => '/windows phone/i',
      'Opera Mini' => '/opera mini/i'
  ];
  
  $tablet_patterns = [
      'iPad' => '/ipad/i',
      'Kindle' => '/kindle/i',
      'PlayBook' => '/playbook/i',
      'Silk' => '/silk/i',
      'Android Tablet' => '/android(?!.*mobile)/i'
  ];
  
  $desktop_patterns = [
      'Windows' => '/windows/i',
      'Macintosh' => '/macintosh/i',
      'Linux' => '/linux/i',
      'ChromeOS' => '/cros/i'
  ];

  // Check for tablet devices first
  foreach ($tablet_patterns as $device => $pattern) {
      if (preg_match($pattern, $user_agent)) {
          return 'tablet - ' . $device;
      }
  }

  // Check for mobile devices
  foreach ($mobile_patterns as $device => $pattern) {
      if (preg_match($pattern, $user_agent)) {
          return 'mobile - ' . $device;
      }
  }

  // Check for desktop devices
  foreach ($desktop_patterns as $device => $pattern) {
      if (preg_match($pattern, $user_agent)) {
          return 'computer - ' . $device;
      }
  }

  // Default to computer if none of the patterns match
  return 'computer';
}

function get_location_from_ip($ip) {
  $api_token = '828d1508e849b2'; // ใส่ API token ของคุณที่นี่
  $url = "http://ipinfo.io/{$ip}/json?token={$api_token}";

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($curl);
  curl_close($curl);

  return json_decode($response, true);
}

function complex_base64_encode($data) {
  $salt = "random_salt"; // Use a random string or a generated salt
  $data_with_salt = $salt . $data;
  $reversed_data = strrev($data_with_salt);
  $base64_encoded = base64_encode($reversed_data);
  return $base64_encoded;
}

function complex_base64_decode($encoded_data) {
  $decoded_data = base64_decode($encoded_data);
  $reversed_data = strrev($decoded_data);
  $salt = "random_salt"; // The same salt used in encoding
  $data = substr($reversed_data, strlen($salt));
  return $data;
}

/*
* convertToEngYearForDB
* convert date thai to eng for sent to query database
* @input date, time 
* $output format date Y-m-d H:i:s
* @author Areerat Pongurai
* @Create Date 30/07/2024
*/
function convertToEngYearForDB($date, $time = null) {
	if (!empty($date)) {
		if (empty($time))
			$time = '00:00:00';
		
		$date = explode("/",$date);
		$year = $date[count($date) - 1] - 543;
		$date_string = $date[0] . '-' . $date[1] . '-' . $year . ' ' . $time;
		return (new DateTime($date_string))->format('Y-m-d H:i:s');
	}
	return '';
}

/*
* formatShortDateThai
* convert date thai to eng for sent to query database
* @input strDate
* $output format date dd/m/yyyy
* @author Areerat Pongurai
* @Create Date 30/07/2024
*/
function formatShortDateThai($strDate, $isEng = true) {
	$strYear = $isEng ? date("Y",strtotime($strDate))+543 : date("Y",strtotime($strDate));
	$strMonth= date("n",strtotime($strDate));
	$strDay= date("j",strtotime($strDate));
	
	$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$strMonthThai=$strMonthCut[$strMonth];
	return "$strDay $strMonthThai $strYear";
}

/*
* formatShortDateTimeThai
* convert date time thai to eng for sent to query database
* @input strDate
* $output format date dd/m/yyyy hh:mm:ss น.
* @author Areerat Pongurai
* @Create Date 30/07/2024
*/
// function formatShortDateTimeThai($strDate, $isEng = true) {
// 	$strYear = $isEng ? date("Y",strtotime($strDate))+543 : date("Y",strtotime($strDate));
// 	$strMonth= date("n",strtotime($strDate));
// 	$strDay= date("j",strtotime($strDate));
	
// 	$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
// 	$strMonthThai=$strMonthCut[$strMonth];

// 	// Format the time
// 	$strTime = date("H:i:s", strtotime($strDate)) . " น.";

// 	return "$strDay $strMonthThai $strYear $strTime";
// }

/*
* getLongMonthThai
* convert int month to full month thai name
* @input int month
* $output full month thai name
* @author Areerat Pongurai
* @Create Date 30/07/2024
*/
function getLongMonthThai($intMonth) {
    $thaiMonths = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม'
    ];
    
    return isset($thaiMonths[$intMonth]) ? $thaiMonths[$intMonth] : null;
}
?>