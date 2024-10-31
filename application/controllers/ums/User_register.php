<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class User_register extends UMS_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('ums/m_ummenu');
		$this->load->model('ums/Genmod', 'genmod');
	}

	public function index()
	{
		$data['get'] = $this->genmod->getAll(
			'see_umsdb',                        // Database name
			'ums_patient',                      // Table name
			'ums_patient.*, ums_patient_status.sta_name as status,ums_patient_status.sta_color as color', // Columns to select
			array('pt_sta_id' => 1),                                 // Where conditions (empty in this case)
			'pt_create_date DESC',              // Order by pt_create_date DESC
			array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'), // Join conditions
			''                                  // Group by (empty in this case)
		);
		$data['get_app'] = $this->genmod->getAll(
			'see_umsdb',                        // Database name
			'ums_patient',                      // Table name
			'ums_patient.*, ums_patient_status.sta_name as status,ums_patient_status.sta_color as color', // Columns to select
			array('pt_sta_id' => 4),                                 // Where conditions (empty in this case)
			'pt_create_date DESC',              // Order by pt_create_date DESC
			array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'), // Join conditions
			''                                  // Group by (empty in this case)
		);
		$data['get_edit'] = $this->genmod->getAll(
			'see_umsdb',                        // Database name
			'ums_patient',                      // Table name
			'ums_patient.*, ums_patient_status.sta_name as status,ums_patient_status.sta_color as color', // Columns to select
			array('pt_sta_id' => 5),                                 // Where conditions (empty in this case)
			'pt_create_date DESC',              // Order by pt_create_date DESC
			array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'), // Join conditions
			''                                  // Group by (empty in this case)
		);

		$coutNow = 0;
		$Now = [];
		for ($i = 0; $i < count($data['get']); $i++) {
			if ($data['get'][$i]->pt_identification) {
				$data['get'][$i]->card = "ประชาชน : " . $data['get'][$i]->pt_identification;
			} else if ($data['get'][$i]->pt_passport) {
				$data['get'][$i]->card = "พาสปอร์ต :" . $data['get'][$i]->pt_passport;
			} else {
				$data['get'][$i]->card = "บัตรต่างด้าว :" . $data['get'][$i]->pt_peregrine;
			}
			$timezone = new DateTimeZone('Asia/Bangkok');
			$Date = new DateTime('now', $timezone);
			$Date = $Date->format('Y-m-d');
			$date = new DateTime($data['get'][$i]->pt_create_date);
			$formattedDate = $date->format('Y-m-d');
			if ($formattedDate == $Date) {
				$coutNow++;
				$data['Now'][$i] = $data['get'][$i];
			}
		}
		$data['Now'] = implode('', $Now);
		$data['Now'] = (string) $data['Now'];
		$data['coutNow'] = $coutNow;
		$data['coutall'] = count($data['get']);
		$data['coutapp'] = count($data['get_app']);

    if ($data['get_app'] !== false) {
      $data['coutapp'] = count($data['get_app']);
    } else {
      $data['coutapp'] = 0; // หรือจัดการในกรณีที่ไม่มีข้อมูล
    }

    if ($data['get_edit'] !== false) {
      $data['coutedit'] = count($data['get_edit']);
    } else {
      $data['coutedit'] = 0; // หรือจัดการในกรณีที่ไม่มีข้อมูล
    }

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ums/user/v_user_register_show', $data);
	}

	public function edit($RegisterID = "")
	{
		$data['RegisterID'] = $RegisterID;

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ums/user/v_user_register_form', $data);
	}
	public function getfilter()
	{
		$data = $this->input->post();
		$fromdata = [];
		$date = [];

		foreach ($data as $key => $value) {
			if ($key == 'card') {
				$fromdata['card'] = $value;
			} else if ($value != "") {
				$fromdata[$key . " LIKE"] = $value . "%";
			}
		}

		if (!empty($fromdata['start_date LIKE']) && !empty($fromdata['end_date LIKE'])) {
			$start_date_parts = explode("/", $fromdata['start_date LIKE']);
			$start_year = $start_date_parts[count($start_date_parts) - 1] - 543;
			$start_string = $start_year . '-' . $start_date_parts[1] . '-' . $start_date_parts[0] . ' 00:00:00';
			$start_date = (new DateTime($start_string))->format('Y-m-d H:i:s');
			$end_date_parts = explode("/", $fromdata['end_date LIKE']);
			$end_year = $end_date_parts[count($end_date_parts) - 1] - 543;
			$end_string = $end_year . '-' . $end_date_parts[1] . '-' . $end_date_parts[0] . ' 23:59:59';
			$end_date = (new DateTime($end_string))->format('Y-m-d H:i:s');

			$date = array(
				'pt_create_date >=' => $start_date,
				'pt_create_date <=' => $end_date
			);
		}

		if (!empty($fromdata['card'])) {
			$orConditions = "pt_identification LIKE '%" . $fromdata['card'] . "%' OR pt_passport LIKE '%" . $fromdata['card'] . "%' OR pt_peregrine LIKE '%" . $fromdata['card'] . "%'";
			$results = $this->genmod->getAll(
				'see_umsdb',
				'ums_patient',
				'pt_id',
				$orConditions
			);
			$pt_ids = array_map(function ($result) {
				return $result->pt_id;
			}, $results);
			if (!empty($pt_ids)) {
				unset($fromdata['card']);
				unset($fromdata['us_name LIKE']);
				unset($fromdata['start_date LIKE']);
				unset($fromdata['end_date LIKE']);
				foreach ($pt_ids as $key => $value) {
					$fromdata['pt_id'] = $value;
					$whereConditions = array_merge($fromdata, $date);
					$get[$key] = $this->genmod->getOne(
						'see_umsdb',
						'ums_patient',
						'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
						$whereConditions,
						'pt_create_date DESC',
						array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'),
						''
					);
					$data['get'][$key] = $get[$key];
				}
			} else {
				$fromdata['pt_id IN'] = [0]; // หรือจัดการอื่นๆ ที่เหมาะสม
			}
		} else {
			unset($fromdata['pt_id']);
			unset($fromdata['card']);
			unset($fromdata['us_name LIKE']);
			unset($fromdata['start_date LIKE']);
			unset($fromdata['end_date LIKE']);
			$whereConditions = array_merge($fromdata, $date);
			$data['get'] = $this->genmod->getAll(
				'see_umsdb',
				'ums_patient',
				'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
				$whereConditions,
				'pt_create_date DESC',
				array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'),
				''
			);
		}
		for ($i = 0; $i < count($data['get']); $i++) {
			if ($data['get'][$i]->pt_identification) {
				$data['get'][$i]->card = "ประชาชน : " . $data['get'][$i]->pt_identification;
			} else if ($data['get'][$i]->pt_passport) {
				$data['get'][$i]->card = "พาสปอร์ต : " . $data['get'][$i]->pt_passport;
			} else {
				$data['get'][$i]->card = "บัตรต่างด้าว : " . $data['get'][$i]->pt_peregrine;
			}
			$data['get'][$i]->pt_create_date = abbreDate4($data['get'][$i]->pt_create_date);
		}
		echo json_encode($data['get']);
	}


	public function update()
	{
		//// case success
		$data['returnUrl'] = base_url() . 'index.php/ums/User_register';
		$data['status_response'] = $this->config->item('status_response_success');

		//// case error about server db
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// case error some condition of input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function index_side()
	{
		$draw = intval($this->input->post('draw'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$search = $this->input->post('search');
		$data = $this->input->post('formData'); // รับข้อมูลฟอร์ม
		$id = $this->input->post('id');
		$fromdata = [];
		$date = [];
		$patients = [];
		$totalRecords = 0;
    $recordsFiltered = 0;
    
		if (!empty($id)) {
			$id = $this->input->post();
      $searchValue = isset($search['value']) ? $search['value'] : NULL;
      if (!empty($searchValue)) {
        $where = "(ums_patient.pt_member LIKE '%$searchValue%' OR 
         ums_patient.pt_member LIKE '%$searchValue%' OR
         ums_patient.pt_identification LIKE '%$searchValue%' OR
         ums_patient.pt_passport LIKE '%$searchValue%' OR
         ums_patient.pt_peregrine LIKE '%$searchValue%' OR
         ums_patient.pt_prefix LIKE '%$searchValue%' OR
         ums_patient.pt_fname LIKE '%$searchValue%' OR
         ums_patient.pt_lname LIKE '%$searchValue%' OR
         ums_patient.pt_email LIKE '%$searchValue%' OR
         ums_patient.pt_create_date LIKE '%$searchValue%' OR
         ums_patient.pt_update_date LIKE '%$searchValue%' OR
         ums_patient_status.sta_name LIKE '%$searchValue%' OR
         ums_patient.pt_tel LIKE '%$searchValue%')";
      } else {
        $where = '';
      }


			$data['get'] = $this->genmod->getAll(
				'see_umsdb',                        // Database name
				'ums_patient',                      // Table name
				'ums_patient.*, ums_patient_status.sta_name as status,ums_patient_status.sta_color as color', // Columns to select
				$where,                                 // Where conditions (empty in this case)
				'pt_create_date DESC',              // Order by pt_create_date DESC
				array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'), // Join conditions
				''                                  // Group by (empty in this case)
			);



			$timezone = new DateTimeZone('Asia/Bangkok');
			$currentDate = new DateTime('now', $timezone);
			$currentDateFormatted = $currentDate->format('Y-m-d');

			$data['get_now'] = array_filter($data['get'], function ($patient) use ($currentDateFormatted) {
				$patientDate = new DateTime($patient->pt_create_date);
				$formattedDate = $patientDate->format('Y-m-d');
				return $patient->pt_sta_id == 1 && $formattedDate == $currentDateFormatted;
			});

			if ($id['id'] == 1) {
				// เงื่อนไขสำหรับ id = 1 เพื่อแสดงเฉพาะผู้ที่ pt_sta_id = 1 และลงทะเบียนในวันปัจจุบัน
				$patients = $data['get_now'];
				$totalRecords = count($patients);
        $recordsFiltered = $totalRecords;
			} else if ($id['id'] == 2) {
				// เงื่อนไขสำหรับ id = 2 เพื่อแสดงข้อมูลทั้งหมดที่ pt_sta_id = 1
        $searchValue = isset($search['value']) ? $search['value'] : NULL;
        $where = " (ums_patient.pt_member LIKE '%$searchValue%' OR 
        ums_patient.pt_member LIKE '%$searchValue%' OR
        ums_patient.pt_identification LIKE '%$searchValue%' OR
        ums_patient.pt_passport LIKE '%$searchValue%' OR
        ums_patient.pt_peregrine LIKE '%$searchValue%' OR
        ums_patient.pt_prefix LIKE '%$searchValue%' OR
        ums_patient.pt_fname LIKE '%$searchValue%' OR
        ums_patient.pt_lname LIKE '%$searchValue%' OR
        ums_patient.pt_email LIKE '%$searchValue%' OR
        ums_patient.pt_create_date LIKE '%$searchValue%' OR
        ums_patient.pt_update_date LIKE '%$searchValue%' OR
        sta_name LIKE '%$searchValue%' OR
        ums_patient.pt_tel LIKE '%$searchValue%') AND pt_sta_id = 1";

        // คำนวณจำนวนรายการทั้งหมด และ คำนวณจำนวนรายการที่ถูกกรอง
        $totalRecords = $this->genmod->countAll('ums_patient', $where,array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'));

        // คำนวณจำนวนรายการที่ถูกกรอง
        $recordsFiltered = $totalRecords;
        
        // ดึงข้อมูลที่ถูกจำกัดผลลัพธ์
        $patients = $this->genmod->getAll_limit(
            'see_umsdb',
            'ums_patient',
            'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
            $where,
            'pt_create_date DESC',
            array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'),
            '',
            $start,
            $length
        );
        
        
				// $totalRecords = count($patients);
			} else if ($id['id'] == 3) {
				$filtered_patients = array_filter($data['get'], function ($patient) {
					return $patient->pt_sta_id == 4;
				});
				$patients = array_values($filtered_patients); // รีเซ็ตคีย์อาร์เรย์
        $totalRecords = count($patients);
        // คำนวณจำนวนรายการที่ถูกกรอง
        $recordsFiltered = $totalRecords;


				
			} else if($id['id'] == 4){
        $searchValue = isset($search['value']) ? $search['value'] : NULL;
        $where = " (ums_patient.pt_member LIKE '%$searchValue%' OR 
        ums_patient.pt_member LIKE '%$searchValue%' OR
        ums_patient.pt_identification LIKE '%$searchValue%' OR
        ums_patient.pt_passport LIKE '%$searchValue%' OR
        ums_patient.pt_peregrine LIKE '%$searchValue%' OR
        ums_patient.pt_prefix LIKE '%$searchValue%' OR
        ums_patient.pt_fname LIKE '%$searchValue%' OR
        ums_patient.pt_lname LIKE '%$searchValue%' OR
        ums_patient.pt_email LIKE '%$searchValue%' OR
        ums_patient.pt_create_date LIKE '%$searchValue%' OR
        ums_patient.pt_update_date LIKE '%$searchValue%' OR
        ums_patient_status.sta_name LIKE '%$searchValue%' OR
        ums_patient.pt_tel LIKE '%$searchValue%') AND pt_sta_id = 5";

        // คำนวณจำนวนรายการทั้งหมด และ คำนวณจำนวนรายการที่ถูกกรอง
        $totalRecords = $this->genmod->countAll('ums_patient', $where,array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'));

        // คำนวณจำนวนรายการที่ถูกกรอง
        $recordsFiltered = $totalRecords;


				$patients = $this->genmod->getAll_limit(
					'see_umsdb',
					'ums_patient',
					'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
					$where,
					'pt_update_date DESC',
					array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'),
          '',
          $start,
          $length
				);
        // $totalRecords = count($patients); // ตอนนี้สามารถใช้ count() ได้โดยไม่ต้องตรวจสอบว่าเป็น false หรือไม่
			}

			$data = [];
			foreach ($patients as $key => $patient) {
				$card = '';
				if ($patient->pt_identification) {
					$card = "ประชาชน : " . $patient->pt_identification;
				} elseif ($patient->pt_passport) {
					$card = "พาสปอร์ต : " . $patient->pt_passport;
				} else {
					$card = "บัตรต่างด้าว : " . $patient->pt_peregrine;
				}

				$data[] = [
					"row_number" => $start + $key + 1,
					'pt_member' => $patient->pt_member,
					'name' => $patient->pt_prefix . "" . $patient->pt_fname . " " . $patient->pt_lname,
					'phone' => $patient->pt_tel,
					'email' => $patient->pt_email,
					'status' => $patient->status,
					'color' => $patient->color,
					'card' => $card,
					'pt_create_date' => formatThaiDatelogs($patient->pt_create_date),
					'pt_update_date' => formatThaiDatelogs($patient->pt_update_date), // Add this line
					'pt_id' => $patient->pt_id,
				];
			}
			$output = [
				"draw" => $draw,
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $recordsFiltered,
				"data" => $data
			];
		} else {
			if (isset($data)) {
        foreach ($data as $key => $value) {
          if ($key == 'card') {
            $fromdata['card'] = $value;
          } else if ($value != "") {
            $fromdata[$key . " LIKE"] =  $value . "%";
          }
        }
            
        // ตรวจสอบว่ามี start_date และ end_date หรือไม่
        if (!empty($fromdata['start_date LIKE']) && !empty($fromdata['end_date LIKE'])) {
          $start_date = isset($fromdata['start_date LIKE']) ? $this->convertDateToGregorian($fromdata['start_date LIKE']) : '0000-00-00 00:00:00';
          $end_date = isset($fromdata['end_date LIKE']) ? $this->convertDateToGregorian($fromdata['end_date LIKE'], true) : '0000-00-00 23:59:59';          
          $date = [
            'pt_create_date >=' => $start_date,
            'pt_create_date <=' => $end_date
          ];
        } else {
          $date = [];
        }
      
        if (!empty($fromdata['card'])) {
          $orConditions = "pt_identification LIKE '%" . $fromdata['card'] . "%' OR pt_passport LIKE '%" . $fromdata['card'] . "%' OR pt_peregrine LIKE '%" . $fromdata['card'] . "%'";
          $results = $this->genmod->getAll('see_umsdb', 'ums_patient', 'pt_id', $orConditions);
          $pt_ids = array_map(function ($result) {
            return $result->pt_id;
          }, $results);
      
          if (!empty($pt_ids)) {
            unset($fromdata['card'], $fromdata['us_name LIKE'], $fromdata['start_date LIKE'], $fromdata['end_date LIKE']);
            // เพิ่มเงื่อนไขการค้นหา full_name
            if (isset($fromdata['full_name LIKE'])) {
              $fullNameSearch = $fromdata['full_name LIKE'];
              unset($fromdata['full_name LIKE']);
              $fromdata["CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE "] = $fullNameSearch;
            }
          
            foreach ($pt_ids as $key => $value) {
              $fromdata['pt_id'] = $value;
              $whereConditions = array_merge($fromdata, $date);
              $pat[$key] = $this->genmod->getOne(
                'see_umsdb',
                'ums_patient',
                'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
                $whereConditions,
                'pt_create_date DESC',
                array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'),
                '',
              );
            }
            if ($start > 0) {
              $length = $length + $start;
            }
            if ($length >= count($pt_ids)) {
              $length = count($pt_ids);
            }
            for ($i = $start; $i < $length; $i++) {
              $patients[$i] = $pat[$i];
            };
            $totalRecords = count($pt_ids);
          } else {
            $fromdata['pt_id IN'] = [0];
          }
        } else {
          unset($fromdata['pt_id'], $fromdata['card'], $fromdata['us_name LIKE'], $fromdata['start_date LIKE'], $fromdata['end_date LIKE']);
          
          // เพิ่มเงื่อนไขการค้นหา full_name
          if (isset($fromdata['full_name LIKE'])) {
            $fullNameSearch = $fromdata['full_name LIKE'];
            unset($fromdata['full_name LIKE']);
            $fromdata["CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE "] = $fullNameSearch;
          }
          
          $whereConditions = array_merge($fromdata, $date);
          $patients = $this->genmod->getAll_limit(
            'see_umsdb',
            'ums_patient',
            'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
            $whereConditions,
            'pt_create_date DESC',
            array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'),
            '',
            $start,
            $length
          );
          $totalRecords = count($this->genmod->getAll(
            'see_umsdb',
            'ums_patient',
            'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
            $whereConditions,
            'pt_create_date DESC',
            array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id')
          ));
        }
      }
       else {
				$searchValue = isset($search['value']) ? $search['value'] : NULL;

				if (!empty($searchValue)) {
					$where = "(ums_patient.pt_member LIKE '%$searchValue%' OR 
           ums_patient.pt_member LIKE '%$searchValue%' OR
           ums_patient.pt_identification LIKE '%$searchValue%' OR
           ums_patient.pt_passport LIKE '%$searchValue%' OR
           ums_patient.pt_peregrine LIKE '%$searchValue%' OR
           ums_patient.pt_prefix LIKE '%$searchValue%' OR
           ums_patient.pt_fname LIKE '%$searchValue%' OR
           ums_patient.pt_lname LIKE '%$searchValue%' OR
           ums_patient.pt_email LIKE '%$searchValue%' OR
           ums_patient.pt_create_date LIKE '%$searchValue%' OR
           ums_patient.pt_update_date LIKE '%$searchValue%' OR
           ums_patient_status.sta_name LIKE '%$searchValue%' OR
           ums_patient.pt_tel LIKE '%$searchValue%')";
					$patients = $this->genmod->getAll_limit(
						'see_umsdb',
						'ums_patient',
						'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
						$where,
						'pt_create_date DESC',
						array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'),
						'',
						$start,
						$length
					);
					$totalRecords = count($patients);
				} else {
					$patients = $this->genmod->getAll_limit(
						'see_umsdb',
						'ums_patient',
						'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
						'',
						'pt_create_date DESC',
						array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id'),
						'',
						$start,
						$length
					);
					$totalRecords = count($this->genmod->getAll(
						'see_umsdb',
						'ums_patient',
						'ums_patient.*, ums_patient_status.sta_name as status, ums_patient_status.sta_color as color',
						'',
						'pt_create_date DESC',
						array('ums_patient_status' => 'ums_patient.pt_sta_id = ums_patient_status.sta_id')
					));
				}
			}

			$data = [];
			foreach ($patients as $key => $patient) {
				$card = '';
				if ($patient->pt_identification) {
					$card = "ประชาชน : " . $patient->pt_identification;
				} elseif ($patient->pt_passport) {
					$card = "พาสปอร์ต : " . $patient->pt_passport;
				} else {
					$card = "บัตรต่างด้าว : " . $patient->pt_peregrine;
				}

				$data[] = [
					"row_number" => $start + $key + 1,
					'pt_member' => $patient->pt_member,
					'name' => $patient->pt_prefix . "" . $patient->pt_fname . " " . $patient->pt_lname,
					'phone' => $patient->pt_tel,
					'email' => $patient->pt_email,
					'status' => $patient->status,
					'color' => $patient->color,
					'card' => $card,
					'pt_create_date' => formatThaiDatelogs($patient->pt_create_date),
					'pt_update_date' => formatThaiDatelogs($patient->pt_update_date), // Add this line
					'pt_id' => $patient->pt_id,
				];
			}

			$output = [
				"draw" => $draw,
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $totalRecords,
				"data" => $data
			];
		}
		echo json_encode($output);
	}

	private function convertDateToGregorian($dateString, $endOfDay = false)
  {
      if (empty($dateString)) {
          return $endOfDay ? '0000-00-00 23:59:59' : '0000-00-00 00:00:00';
      }
  
      $date_parts = explode("/", $dateString);
      if (count($date_parts) != 3) {
          // ถ้าจำนวนส่วนของวันที่ไม่ครบ 3 ส่วน ให้คืนค่าเป็นวันที่เริ่มต้น
          return $endOfDay ? '0000-00-00 23:59:59' : '0000-00-00 00:00:00';
      }
  
      $year = intval($date_parts[count($date_parts) - 1]) - 543;
      $formattedDate = $year . '-' . $date_parts[1] . '-' . $date_parts[0];

      return $endOfDay ? $formattedDate . ' 23:59:59' : $formattedDate . ' 00:00:00';
  }
  
}
