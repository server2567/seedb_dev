<style>
  .error-message {
    display: none;
    color: red;
    font-size: 0.9em;
  }

  .select2-container--default .select2-results>.select2-results__options {
    max-height: 50vh;
  }

  .watermark {
    position: absolute;
    font-size: 25px;
    color: rgba(0, 0, 0, 0.1);
    transform: rotate(-30deg);
    white-space: nowrap;
    pointer-events: none;
    z-index: 10;
  }

  .watermark:nth-child(1) {
    top: 50%;
    left: 10%;
  }

  .watermark:nth-child(2) {
    top: 50%;
    left: 30%;
  }

  .watermark:nth-child(3) {
    top: 50%;
    left: 50%;
  }

  .watermark:nth-child(4) {
    top: 50%;
    left: 70%;
  }

  .content {
    position: relative;
    z-index: 1;
  }

  .pattern-square {
    position: relative;
    z-index: 2;
    box-shadow: 0 4px 13px rgb(174 186 255), 0 6px 14px rgb(207 207 207);
  }
</style>
<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingAdd">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
        <i class="bi bi-person-fill-add icon-menu font-20"></i><span> เพิ่มการนัดหมายแพทย์รายคน </span>
      </button>
    </h2>
    <form id="patientForm">
      <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
        <div class="accordion-body p-0" id="step1">
          <div class="card mb-0">
            <div class="card-body">
              <div class="row" style="height:75px; border-bottom: 1px solid #e1e1e1;">
                <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2" style="border-right: 1px solid #e1e1e1;">
                  <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3">ขั้นตอนที่ <i class="bi bi-1-square-fill fs-20"></i><br>การจองคิว - ข้อมูลนัดหมายแพทย์</span>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2">
                  <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3 text-secondary">ขั้นตอนที่ <i class="bi bi-2-square-fill fs-20 text-secondary"></i><br>ตรวจสอบการลงทะเบียน - ข้อมูลการนัดหมายแพทย์</span>
                </div>
              </div>
            </div>
            <input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo isset($appointment_id) ? $appointment_id : $get_appointment['apm_id'] ?? ''; ?>">
            <div class="card-body">
              <div class="row justify-content-md-center mt-1 mb-3">
                <?php if (empty($get_appointment)) { ?>
                  <h5 class="mb-4 font-weight-600 font-20 mb-5 ms-4">
                    <i class="bi bi-1-circle-fill font-24 me-3"></i>
                    ค้นหา หรือตรวจสอบข้อมูลผู้ป่วย
                  </h5>
                  <div class="row mt-0 mb-2 d-flex justify-content-center">
                    <div class="col-5 col-md-5 col-lg-5">
                      <div class="form-floating mb-2 text-center">
                        <input type="text" class="form-control mb-0 " id="floatingInput_identification" name="identification" maxlength="13" oninput="limitInputLength(this)" placeholder="">
                        <label for="floatingInput_identification">ระบุเลข บัตรประจำตัวประชาชน/หนังสือเดินทาง/บัตรต่างด้าว <span class="text-danger">*</span></label>
                        <button type="button" id="checkButton_identification" class="btn btn-success btn-lg mt-4"><i class="bi bi-patch-check"></i> ตรวจสอบเลขบัตร</button>
                      </div>
                    </div>
                    <div class="col-1 col-md-1 col-lg-1 text-center fw-bold font-18">หรือ </div>
                    <div class="col-4 col-md-4 col-lg-4">
                      <div class="form-floating mb-2 text-center">
                        <input type="number" class="form-control mb-0" id="floatingInput_member" name='member' placeholder="">
                        <label for="floatingInput_member"> ระบุ HN <span class="text-danger">*</span></label>
                        <button type="button" id="checkButton_member" class="btn btn-success btn-lg mt-4"><i class="bi bi-patch-check"></i> ตรวจสอบ HN</button>
                      </div>
                    </div>
                  </div>
                  <p class=" text-primary fw-bold mt-3"> *** ในกรณีที่ระบุเลขบัตรประจำตัวประชาชน หรือ HN แล้วไม่มีอยู่ในระบบ ท่านจำเป็นต้องกรอกรายละเอียดข้อมูลผู้ป่วยใหม่แค่ครั้งเดียว</p>
                  <hr class="mb-4">
                <?php } ?>
                <h5 class="mb-4 font-weight-600 font-20 mb-4 ms-4">
                  <i class="bi bi-2-circle-fill font-24 me-3"></i>
                  ข้อมูลผู้ป่วย
                </h5>
                <?php if (!empty($get_appointment)) { ?>
                <div class="row px-4 mb-4">
                  <div class="col-6 col-md-4 col-lg-4">
                    <div class="avatar avatar-xl position-relative mb-2">
                    <span class="avatar avatar-xl">
                      <?php if(isset($get_appointment['ptd_img_type'])){ ?>
                        <img style="width:126px; height:126px;" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" 
                        src="data:image/<?php echo $get_appointment['ptd_img_type']; ?>;base64,<?php echo $get_appointment['ptd_img_code']; ?>" alt="">
                      <?php } else { ?>
                        <img style="width:126px; height:126px;" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" 
                        src="<?php echo base_url(); ?>assets/img/default-person.png" alt="">
                      <?php } ?>
                    </span>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <div class="row px-4 mb-4">
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="idCard" class="fw-bold">1.1 เลขทีบัตรประจำตัวประชาชน/หนังสือเดินทาง/บัตรต่างด้าว  <span class=' text-danger'>*</span></label>
                    <div class=" mb-4 input-group-md">
                      <input type="text" class="form-control" id="idCard" name="idCard" value="<?= $get_appointment['pt_identification'] ?? ''; ?>" placeholder="1209700000099" oninput="limitInputLength(this)" required>
                    </div>
                  </div>
                  <div class="col-6 col-md-3 col-lg-3">
                    <label for="" class="fw-bold">1.2 ประเภทผู้ป่วย <span class=' text-danger'>*</span></label><br>
                    <div class=" d-flex justify-content-center">
                      <input class="form-check-input ms-5" type="radio" name="gridRadios" id="gridRadios1" value="old" <?= isset($get_appointment['apm_patient_type']) && $get_appointment['apm_patient_type'] == 'old' ? 'checked' : '' ?>>
                      <label class="form-check-label me-4" for="gridRadios1">
                        ผู้ป่วยเก่า
                      </label>
                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="new" <?= !isset($get_appointment['apm_patient_type']) || $get_appointment['apm_patient_type'] == 'new' ? 'checked' : '' ?>>
                      <label class="form-check-label" for="gridRadios2">
                        ผู้ป่วยใหม่
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row px-4 mb-4">
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="prefix" class="fw-bold">1.3 คำนำหน้าชื่อ <span class=' text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select class="form-select" aria-label="Default select example" id="prefix" name="prefix" value="" required>
                        <option selected="" disabled>เลือกคำนำหน้าชื่อ</option>
                        <?php foreach ($get_prefix as $pf) { ?>
                          <option value="<?php echo $pf['pf_name_abbr']; ?>" <?php echo (isset($get_appointment['pt_prefix']) && $get_appointment['pt_prefix'] == $pf['pf_name']) ? 'selected' : ''; ?>>
                            <?php echo $pf['pf_name_abbr']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="firstName" class=" fw-bold">1.4 ชื่อ <span class=' text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <input class="form-control" id="firstName" name="firstName" type="text" placeholder="จักษุ" value="<?= $get_appointment['pt_fname'] ?? ''; ?>" required>
                    </div>
                  </div>
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="lastName" class=" fw-bold">1.5 นามสกุล <span class=' text-danger'>*</span></label>
                    <div class=" mb-4 input-group-md">
                      <input class="form-control" id="lastName" name="lastName" type="text" placeholder="สุราษฎร์" value="<?= $get_appointment['pt_lname'] ?? ''; ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row px-4 mb-4">
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="phoneNumber" class=" fw-bold">1.6 เบอร์โทรศัพท์ (ที่สามารถติดต่อได้) <span class=' text-danger'>*</span></label>
                    <div class=" mb-4 input-group-md">
                      <input class="form-control" id="phoneNumber" name="phoneNumber" type="text" maxlength="10" value="<?= $get_appointment['pt_tel'] ?? ''; ?>" placeholder="077276999" required>
                    </div>
                  </div>
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="email" class=" fw-bold">1.7 อีเมล (ถ้ามี) </label>
                    <div class=" mb-4 input-group-md">
                      <input class="form-control" id="email" name="email" type="email" value="<?= $get_appointment['pt_email'] ?? ''; ?>" placeholder="surateyehospital@gmail.com">
                    </div>
                  </div>
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="prefix" class="fw-bold">1.8 ช่องทางการติดต่อกลับ <span class=' text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select class="form-select" aria-label="Default select example" id="notification" name="notification" value="" required>
                        <option selected="" disabled>เลือกช่องทางการติดต่อกลับ</option>
                        <?php foreach ($get_base_noti as $noti) { ?>
                          <option value="<?php echo $noti['ntf_id']; ?>" <?php echo (isset($get_appointment['apm_ntf_id']) && $get_appointment['apm_ntf_id'] == $noti['ntf_id']) ? 'selected' : ''; ?>>
                            <?php echo $noti['ntf_name']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                <hr class="mb-5">
                <h5 class="mb-4 font-weight-600 font-20 ms-4">
                  <i class="bi bi-3-circle-fill font-24 me-3"></i> วันที่ และเวลาที่ต้องการนัดหมายแพทย์ <span class="text-danger">*</span> (กรุณาเลือกตามลำดับ)
                </h5>
                <div class="row mt-3 px-4">
                  <div class="col-6 col-md-4 col-lg-3">
                    <label for="hospitalClinic" class="fw-bold">3.1 โรงพยาบาล หรือคลินิก <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select id="hospitalClinic" class="form-select select2" aria-label="Default select example" name="apm_dp_id" required>
                        <option selected disabled>เลือกโรงพยาบาล หรือคลินิก</option>
                        <?php foreach ($get_department as $dp) { ?>
                          <option value="<?php echo $dp['dp_id']; ?>" data-department="<?php echo $dp['dp_id']; ?>" <?php echo (isset($get_appointment['apm_dp_id']) && $get_appointment['apm_dp_id'] == $dp['dp_id']) ? 'selected' : ''; ?>>
                            <?php echo $dp['dp_name_th']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php
                  function convert_to_thai_date($date)
                  {
                    if ($date) {
                      $dateObj = new DateTime($date);
                      $year = $dateObj->format('Y') + 543; // แปลงปีเป็นพุทธศักราช
                      return $dateObj->format('d/m/') . $year;
                    }
                    return '';
                  }

                  $thai_date = isset($get_appointment['apm_date']) ? convert_to_thai_date($get_appointment['apm_date']) : '';
                  ?>
                  <div class="col-4 col-md-3 col-lg-3">
                    <label for="apm_date" class="fw-bold">3.2 เลือกวันที่นัดหมาย <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <input type="text" class="form-control datepicker_th" name="apm_date" id="apm_date" value="<?= $thai_date; ?>" placeholder="เลือกวันที่นัดหมาย" required>
                    </div>
                  </div>
                  <?php
                  function generate_time_ranges($start, $end, $interval)
                  {
                    $times = [];
                    $current = strtotime($start);
                    $end = strtotime($end);

                    while ($current <= $end) {
                      $next = strtotime("+$interval minutes", $current);
                      if ($next <= $end) {
                        $times[] = date('H:i', $current) . ' - ' . date('H:i', $next);
                      }
                      $current = $next;
                    }

                    return $times;
                  }

                  $time_ranges = generate_time_ranges('07:30', '20:00', 30);
                  ?>
                  <div class="col-4 col-md-3 col-lg-3">
                    <label for="timeRange" class="fw-bold">3.3 เวลาที่นัดหมาย <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select class="form-control select2" id="timeRange" name="apm_time" required>
                        <option selected disabled>เลือกเวลา</option>
                          <?php if(isset($get_appointment['apm_time']) && $get_appointment['apm_time']){ ?>
                            <?php foreach ($time_ranges as $time) { ?>
                                <option value="<?= $time; ?>" <?= isset($get_appointment['apm_time']) && $get_appointment['apm_time'] == $time ? 'selected' : ''; ?>>
                                    <?= $time; ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <p class=" text-primary fw-bold"> *** ในกรณีที่เลือกเวลาที่นัดหมายเรียบร้อยแล้ว แต่ต้องการเปลี่ยนโรงพยาบาล หรือคลินิก จำเป็นต้องเลือกวันที่ และเวลาที่นัดหมายใหม่อีกครั้ง</p>
                </div>
                <hr class="mb-5">
                <h5 class="mb-4 font-weight-600 font-20 ms-4">
                  <i class="bi bi-4-circle-fill font-24 me-3"></i> รายละเอียดอาการเบื้องต้นเกี่ยวกับโรค
                </h5>
                <div class="row mt-3 px-4">
                  <div class="col-6 col-md-4 col-lg-3">
                    <label for="disease" class="fw-bold">4.1 ต้องการเข้ารักษาเกี่ยวกับโรค <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select id="disease" class="form-select select2" aria-label="Default select example" name="apm_ds_id" required>
                        <option selected disabled>เลือกชื่อโรค</option>
                        <option value="0" data-department="0">ไม่ทราบ</option>
                        <?php foreach ($get_disease as $key => $ds) { ?>
                          <option value="<?php echo $ds['ds_id']; ?>" data-department="<?php echo $ds['ds_stde_id']; ?>"
                          <?php echo isset($get_appointment['apm_ds_id']) && $get_appointment['apm_ds_id'] == $ds['ds_id'] ? 'selected' : ''; ?>>
                            <?php echo $ds['ds_name_disease']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 col-md-4 col-lg-3">
                    <label for="department" class="fw-bold">4.2 แผนก <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select id="department" class="form-select" aria-label="Default select example" name="apm_stde_id" required>
                        <option selected disabled>เลือกแผนก</option>
                        <?php foreach ($get_structure_detail as $key => $sd) { ?>
                          <option value="<?php echo $sd['stde_id']; ?>" data-department='<?php echo $sd['stde_id']; ?>'
                          <?php echo isset($get_appointment['apm_stde_id']) && $get_appointment['apm_stde_id'] == $sd['stde_id'] ? 'selected' : ''; ?>>
                            <?php echo $sd['stde_name_th']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-12 col-lg-9">
                    <label for="" class="fw-bold mb-2">4.3 ระบุสาเหตุ หรืออาการเบื้องต้น</label>
                    <textarea id="apm_cause" class="tinymce-editor" name="apm_cause"><?= isset($get_appointment['apm_cause']) ? htmlspecialchars($get_appointment['apm_cause']) : ''; ?></textarea>
                  </div>
                </div>
                <hr class="mt-3 mb-5">
                <h5 class="mb-4 font-weight-600 font-20 ms-4">
                  <i class="bi bi-5-circle-fill font-24 me-3"></i> จัดการนัดหมายแพทย์
                </h5>
                <div class="row px-4">
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="med" class="fw-bold">5.1 เลือกแพทย์ที่ผู้ป่วยต้องการนัดหมาย <span class=' text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select id="doctor" class="form-select select2" aria-label="Default select example" name="apm_ps_id" required>
                        <option value="0">ไม่ต้องการระบุแพทย์</option>
                        <?php foreach ($get_doctors as $doctor) { ?>
                            <option value="<?php echo $doctor['ps_id']; ?>" <?php echo isset($get_appointment['apm_ps_id']) && $get_appointment['apm_ps_id'] == $doctor['ps_id'] ? 'selected' : ''; ?>>
                              <?php echo $doctor['pf_name_abbr'].''.$doctor['ps_fname'].' '.$doctor['ps_lname']; ?>
                            </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 col-md-8 col-lg-8 d-flex align-items-end">
                    <p class=" text-primary fw-bold"> *** รายชื่อแพทย์จะแสดงตามวันที่-เวลา ที่แพทย์ทำการออกตรวจ จากข้อที่ 3 และ 4.2 แผนก</p>
                  </div>
                </div>
                <!-- <div class="row px-4">
                  <div class="col-6 col-md-6 col-lg-6">
                    <label for="" class="fw-bold mb-2">ระบุสาเหตุที่นัดหมายแพทย์</label>
                    <textarea id="apm_need" class="tinymce-editor" name="apm_need"><?= isset($get_appointment['apm_need']) ? htmlspecialchars($get_appointment['apm_need']) : ''; ?></textarea>
                  </div>
                </div> -->
              </div>
              <div class="row mt-5 mb-3">
                <div class="col-12 col-md-12 col-lg-11">
                  <button type="button" class="btn btn-success float-end btn-lg" onclick="saveFormData()"><i class="bi bi-floppy2-fill"></i> บันทึก และทำรายการถัดไป</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      allowClear: true,
      width: '100%', // Ensure the Select2 widget itself is 100%
      language: {
        inputTooShort: function() {
          return 'กรุณาค้นหา'; // Placeholder for search input
        }
      }
    });

    // Function to update datepicker values
    function updateDatepickerValues(selectedDates) {
      if (selectedDates.length > 0) {
        var date = selectedDates[0];
        var day = ('0' + date.getDate()).slice(-2);
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var yearBE = date.getFullYear(); // Get year in BE (Buddhist Era)
        var yearTH = yearBE + 543; // Convert to Buddhist year
        var formattedDate = day + '/' + month + '/' + yearTH;
        $(".datepicker_th").val(formattedDate);
      }
    }

    // Function to update available times
    function updateAvailableTimes(selectedDate) {
      resetDateTimeSelection();
      var dpId = $('#hospitalClinic').val();
      if (dpId && selectedDate) {
        var dayName = selectedDate.toLocaleString('th-TH', {
          weekday: 'long'
        });
        fetchTimes(dpId, dayName);
      }
    }

    // Calculate min and max dates in Thai Buddhist year
    var today = new Date();
    var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    var maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 500);

    // Initialize Flatpickr with Thai locale and Thai Buddhist calendar

    flatpickr(".datepicker_th", {
      dateFormat: 'd/m/Y',
      locale: 'th',
      // defaultDate: today, // Set to current Gregorian date
      minDate: minDate, // Minimum date is today
      maxDate: maxDate, // Maximum date is today + 500 days
      onChange: function(selectedDates, dateStr, instance) {
        updateAvailableTimes(selectedDates[0]); // Trigger updateAvailableTimes with the selected date
      },
      onReady: function(selectedDates, dateStr, instance) {
        convertYearsToThai(instance);
        updateDatepickerValues(selectedDates); // Display the default date in Buddhist year format
      },
      onOpen: function(selectedDates, dateStr, instance) {
        convertYearsToThai(instance);
      },
      onMonthChange: function(selectedDates, dateStr, instance) {
        convertYearsToThai(instance);
      },
      onYearChange: function(selectedDates, dateStr, instance) {
        convertYearsToThai(instance);
      },
      onValueUpdate: function(selectedDates, dateStr, instance) {
        convertYearsToThai(instance);
        updateDatepickerValues(selectedDates);
      },
    });

    // Event listener for hospital/clinic change
    $('#hospitalClinic').change(function() {
      resetDateTimeSelection(); // Reset date and time selection
      updateAvailableTimes(); // Call updateAvailableTimes function on change
    });

    function fetchTimes(dpId, dayName) {
      $.ajax({
        url: '<?php echo site_url('que/appointment/check_time_dpid'); ?>',
        type: 'POST',
        data: {
          dp_id: dpId,
          day_name: dayName
        },
        success: function(response) {
          try {
            var data = JSON.parse(response);
            if (data.error) {
              updateTimeOptions(data.error);
            } else {
              if (Array.isArray(data.times)) {
                data.times.forEach(function(timeSlot) {
                  updateTimeOptions(null, timeSlot.dpt_date_name, timeSlot.dpt_period_1, timeSlot.dpt_time_start_1, timeSlot.dpt_time_end_1,
                    timeSlot.dpt_period_2, timeSlot.dpt_time_start_2, timeSlot.dpt_time_end_2);
                  console.log(timeSlot.dpt_time_start);
                });
              } else {
                console.error('Invalid data format - times is not an array:', data);
              }
            }
          } catch (e) {
            console.error('Invalid JSON response:', response);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error fetching times:', status, error);
        }
      });
    }

    function resetDateTimeSelection() {
      // $('.datepicker_th').empty(); // Clear the datepicker
      // $('.datepicker_th').flatpickr.clear();
      $('#timeRange').empty(); // Clear options in time range select

    }

    function updateTimeOptions(error, dateName, period_1, startTime_1, endTime_1, period_2, startTime_2, endTime_2) {
      var select = $('#timeRange');
      select.empty(); // Clear existing options

      if (error) {
        select.append(new Option(error));
        return;
      }

      // Convert startTime and endTime from Thai time format to JavaScript Date objects
      var startParts_1 = startTime_1.split(':');
      var endParts_1 = endTime_1.split(':');
      var startParts_2 = startTime_2.split(':');
      var endParts_2 = endTime_2.split(':');

      // Get the selected date from datepicker
      var dateString = $('.datepicker_th').val();
      var selectedDate = new Date(dateString.split('/').reverse().join('/'));

      // Create date objects with adjusted hours and minutes
      var start_1 = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), parseInt(startParts_1[0]), parseInt(startParts_1[1]), 0);
      var end_1 = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), parseInt(endParts_1[0]), parseInt(endParts_1[1]), 0);

      if (period_1 != 'เต็มวัน') {
        var start_2 = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), parseInt(startParts_2[0]), parseInt(startParts_2[1]), 0);
        var end_2 = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), parseInt(endParts_2[0]), parseInt(endParts_2[1]), 0);
      }

      for (var time_1 = start_1; time_1 < end_1; time_1.setMinutes(time_1.getMinutes() + 30)) {
        var optionText_1 = formatThaiTime_1(time_1) + ' - ' + formatThaiTime_1(new Date(time_1.getTime() + 30 * 60000));
        var optionValue_1 = formatThaiTime_1(time_1) + ' - ' + formatThaiTime_1(new Date(time_1.getTime() + 30 * 60000));
        select.append(new Option(optionText_1, optionValue_1));
      }

      if (period_1 != 'เต็มวัน') {
        for (var time_2 = start_2; time_2 < end_2; time_2.setMinutes(time_2.getMinutes() + 30)) {
          var optionText_2 = formatThaiTime_2(time_2) + ' - ' + formatThaiTime_2(new Date(time_2.getTime() + 30 * 60000));
          var optionValue_2 =  formatThaiTime_2(time_2) + ' - ' + formatThaiTime_2(new Date(time_2.getTime() + 30 * 60000));
          select.append(new Option(optionText_2, optionValue_2));
        }
      }
    }

    // Function to format time in Thai format (HH:mm)
    function formatThaiTime_1(date) {
      var hours = date.getHours().toString().padStart(2, '0');
      var minutes = date.getMinutes().toString().padStart(2, '0');
      return hours + ':' + minutes;
    }

    function formatThaiTime_2(date) {
      var hours = date.getHours().toString().padStart(2, '0');
      var minutes = date.getMinutes().toString().padStart(2, '0');
      return hours + ':' + minutes;
    }
  });


  tinymce.init({
    selector: 'textarea.tinymce-editor',
    height: 300 // Set the height of the editor to 300px
  });


  function goToStep1() {
    // Hide the current step (step 2)
    document.getElementById('step2').style.display = 'none';

    // Show the first step
    document.getElementById('step1').style.display = 'block';
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }



  function limitInputLength(input) {
    if (input.value.length > 13) {
      input.value = input.value.slice(0, 13);
    }
  }


  $(document).ready(function() {
    $('#checkButton_identification').click(function() {
      var identification = $('#floatingInput_identification').val();

      if (!identification) {
        Swal.fire({
          title: 'ข้อผิดพลาด',
          text: 'กรุณาระบุเลขบัตรประจำตัวประชาชน',
          icon: 'error',
          confirmButtonText: 'ยืนยัน'
        });
        $('#idCard').val('');
        $('#prefix').val('');
        $('#firstName').val('');
        $('#lastName').val('');
        $('#phoneNumber').val('');
        $('#email').val('');
        $('#gridRadios2').prop('checked', true);
        return;
      }
      
      $.ajax({
        url: '<?php echo site_url('que/Appointment/check_identification'); ?>',
        type: 'POST',
        data: {
          identification_id: identification
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (data.exists) {
            Swal.fire({
              title: 'เลขบัตรประชาชนมีอยู่ในระบบ',
              html: data.name,
              icon: 'success',
              customClass: {
                htmlContainer: 'swal2-html-line-height'
              },
              confirmButtonText: 'ยืนยัน'
            });
            $('#idCard').val(data.idCard);
            $('#prefix').val(data.prefix);
            $('#firstName').val(data.first_name);
            $('#lastName').val(data.last_name);
            $('#phoneNumber').val(data.phone_number);
            $('#email').val(data.email);

            // Check the "old patient" radio button
            $('#gridRadios1').prop('checked', true);
          } else {
            // Clear input fields
            $('#idCard').val('');
            $('#prefix').val('');
            $('#firstName').val('');
            $('#lastName').val('');
            $('#phoneNumber').val('');
            $('#email').val('');

            // Check the "new patient" radio button
            $('#gridRadios2').prop('checked', true);

            Swal.fire({
              title: 'ไม่พบข้อมูล',
              html: 'เลขบัตรประชาชนไม่มีอยู่ในระบบ <br>ถ้าไม่ทราบสามารถดำเนินการกรอกข้อที่ 2 ข้อมูลผู้ป่วยได้',
              icon: 'error',
              customClass: {
                htmlContainer: 'swal2-html-line-height'
              },
              confirmButtonText: 'ยืนยัน'
            });
          }
        },
        error: function() {
          $('#idCard').val('');
          $('#prefix').val('');
          $('#firstName').val('');
          $('#lastName').val('');
          $('#phoneNumber').val('');
          $('#email').val('');
          $('#gridRadios2').prop('checked', true);
          Swal.fire({
            title: 'ข้อผิดพลาด',
            html: 'เกิดข้อผิดพลาดขณะตรวจสอบเลขบัตรประจำตัวประชาชน <br>ถ้าไม่ทราบสามารถดำเนินการกรอกข้อที่ 2 ข้อมูลผู้ป่วยได้',
            icon: 'error',
            customClass: {
              htmlContainer: 'swal2-html-line-height'
            },
            confirmButtonText: 'ยืนยัน'
          });
        }
      });
    });
    $('#checkButton_member').click(function() {
      var member = $('#floatingInput_member').val();

      if (!member) {
        Swal.fire({
          title: 'ข้อผิดพลาด',
          html: 'กรุณาระบุ HN',
          icon: 'error',
          customClass: {
            htmlContainer: 'swal2-html-line-height'
          },
          confirmButtonText: 'ยืนยัน'
        });
        return;
      }

      $.ajax({
        url: '<?php echo site_url('que/Appointment/check_member'); ?>',
        type: 'POST',
        data: {
          member_id: member
        },
        success: function(response_member) {
          var data = JSON.parse(response_member);
          if (data.exists) {
            Swal.fire({
              title: 'เลขที่ HN มีอยู่ในระบบ',
              html: data.name,
              icon: 'success',
              customClass: {
                htmlContainer: 'swal2-html-line-height'
              },
              confirmButtonText: 'ยืนยัน'
            });
            $('#idCard').val(data.idCard);
            $('#prefix').val(data.prefix);
            $('#firstName').val(data.first_name);
            $('#lastName').val(data.last_name);
            $('#phoneNumber').val(data.phone_number);
            $('#email').val(data.email);

            // Check the "old patient" radio button
            $('#gridRadios1').prop('checked', true);
          } else {
            Swal.fire({
              title: 'ไม่พบข้อมูล',
              html: 'เลขที่ HN ไม่มีอยู่ในระบบ<br>ถ้าไม่ทราบสามารถดำเนินการกรอกข้อที่ 2 ข้อมูลผู้ป่วยได้',
              icon: 'error',
              customClass: {
                htmlContainer: 'swal2-html-line-height'
              },
              confirmButtonText: 'ยืนยัน'
            });
            $('#idCard').val('');
            $('#prefix').val('');
            $('#firstName').val('');
            $('#lastName').val('');
            $('#phoneNumber').val('');
            $('#email').val('');
            $('#gridRadios2').prop('checked', true);
          }
        },
        error: function() {
          Swal.fire({
            title: 'ข้อผิดพลาด',
            html: 'เกิดข้อผิดพลาดขณะตรวจสอบเลขที่ HN<br>ถ้าไม่ทราบสามารถดำเนินการกรอกข้อที่ 2 ข้อมูลผู้ป่วยได้',
            icon: 'error',
            customClass: {
              htmlContainer: 'swal2-html-line-height'
            },
            confirmButtonText: 'ยืนยัน'
          });
          $('#idCard').val('');
          $('#prefix').val('');
          $('#firstName').val('');
          $('#lastName').val('');
          $('#phoneNumber').val('');
          $('#email').val('');
          $('#gridRadios2').prop('checked', true);
        }
      });
    });


  });

  $(document).ready(function() {
    // Function to fetch doctors based on department
    function fetchDoctors(departmentId, showAll = false) {
      const doctorSelect = $('#doctor');

      // Clear previous options
      doctorSelect.html('<option value="0">ไม่ต้องการระบุแพทย์</option>');

      // Make AJAX request to fetch doctors
      $.ajax({
        url: '<?php echo site_url('que/appointment/get_doctors'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          stde_id: departmentId,
          show_all: showAll
        },
        success: function(data) {
          if (data.length === 0 && !showAll) {

            // Show SweetAlert2 notification if no doctors are found
            if (departmentId != 0) {
              Swal.fire({
                icon: 'warning',
                title: 'ไม่มีแพทย์ที่ลงตารางออกตรวจ',
                text: 'กรุณาเลือกแผนกอื่น หรือกดปุ่มเลือกแพทย์ทั้งหมด',
                showCancelButton: true,
                confirmButtonText: 'เปลี่ยนแผนก',
                cancelButtonText: 'เลือกแพทย์ทั้งหมด',
                customClass: {
                  htmlContainer: 'swal2-html-line-height'
                },
              }).then((result) => {
                if (result.isConfirmed) {
                  // User clicked "Change Department"
                  // $('#department').val('').trigger('change');
                  Swal.close(); // Close the SweetAlert2 dialog manually
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                  // User clicked "Show All Doctors"
                  fetchDoctors(null, true);
                  Swal.close(); // Close the SweetAlert2 dialog manually
                }
              });
            } else {
              Swal.fire({
                icon: 'warning',
                title: 'ในกรณีที่ไม่ทราบโรค',
                text: 'ต้องเลือกแผนกด้วยเพื่อที่จะออกเลขคิวตามแผนก',
                confirmButtonText: 'รับทราบ',
                customClass: {
                  htmlContainer: 'swal2-html-line-height'
                },
              }).then((result) => {
                if (result.isConfirmed) {
                  fetchDoctors(null, true);
                  Swal.close(); // Close the SweetAlert2 dialog manually
                }
              });
            }
          } else {

            // Populate the doctor select with received data
            $.each(data, function(index, doctor) {

              doctorSelect.append($('<option>', {
                value: doctor.ps_id,
                text: doctor.pf_name + ' ' + doctor.ps_fname + ' ' + doctor.ps_lname
              }));
            });
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error fetching doctors:', textStatus, errorThrown);
        }
      });
    }

    // Event listener for department change
    $('#department').change(function() {
      const selectedDepartment = $(this).val();
      fetchDoctors(selectedDepartment);
    });

    // Event listener for Show All Doctors button in SweetAlert2
    $(document).on('click', '.swal2-cancel', function() {
      fetchDoctors(null, true);
      Swal.close(); // Close the SweetAlert2 dialog manually
    });

    $('#disease').on('change', function() {
      var departmentId = $(this).find(':selected').data('department');
      $('#department').val(departmentId);
      // console.log(departmentId);
      // if (departmentId != '0') {
      fetchDoctors(departmentId);
      // }
    });


  });

  // function validateFormData(formData) {
  //   let isValid = true;
  //   for (const key in formData) {
  //     if (formData.hasOwnProperty(key)) {
  //       const element = document.getElementById(key);
  //       if (!formData[key] || formData[key].trim() === '') {
  //         isValid = false;
  //         if (element) {
  //           element.classList.add('is-invalid');
  //         }
  //       } else {
  //         if (element) {
  //           element.classList.remove('is-invalid');
  //         }
  //       }
  //     }
  //   }
  //   return isValid;
  // }
  function validateFormData(formData) {
    let isValid = true;
    const requiredFields = ['idCard', 'prefix', 'firstName', 'lastName', 'phoneNumber','notification', 'email', 'gridRadios', 'apm_dp_id', 'apm_date', 'apm_time', 'apm_ds_id', 'apm_stde_id', 'apm_ps_id'];

    requiredFields.forEach(field => {
      const value = formData[field];
      const element = document.getElementById(field);
      if (!value || value.trim() === '') {
        isValid = false;
        if (element) {
          element.classList.add('is-invalid');
        }
      } else {
        if (element) {
          element.classList.remove('is-invalid');
        }
      }
    });

    return isValid;
  }

  function saveFormData() {
    tinymce.triggerSave();

    var formData = {
      idCard: $('#idCard').val(),
      prefix: $('#prefix').val(),
      firstName: $('#firstName').val(),
      lastName: $('#lastName').val(),
      phoneNumber: $('#phoneNumber').val(),
      email: $('#email').val(),
      notification: $('#notification').val(),
      gridRadios: $('input[name="gridRadios"]:checked').val(),
      apm_dp_id: $('#hospitalClinic').val(),
      apm_date: $('#apm_date').val(),
      apm_time: $('#timeRange').val(),
      apm_ds_id: $('#disease').val(),
      apm_stde_id: $('#department').val(),
      apm_cause: tinymce.get('apm_cause').getContent(),
      apm_need: tinymce.get('apm_need').getContent(),
      apm_ps_id: $('#doctor').val(),
      appointment_id: $('#appointment_id').val()
    };

    // delete formData.apm_cause;
    // delete formData.apm_need;

    if (!validateFormData(formData)) {
      Swal.fire({
        title: 'ข้อผิดพลาด',
        text: 'กรุณากรอกข้อมูลในทุกช่องที่ขึ้น * (สีแดง)',
        icon: 'error',
        confirmButtonText: 'ตกลง'
      });
      return;
    }

    $.ajax({
      url: '<?php echo site_url("que/Appointment/insert_appointment") ?>', // Adjust the URL to your controller method
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(formData),
      success: function(response) {
        var data = JSON.parse(response);
        if (data.message == 'created' || data.message == 'updated') {
          $('#appointment_id').val(data.appointment_id);
        }
        if (response) {
          Swal.fire({
            title: 'ยืนยันการบันทึกข้อมูล',
            text: 'ข้อมูลของท่านได้รับการบันทึกเรียบร้อยแล้ว',
            icon: 'success',
            confirmButtonText: 'ตกลง และนำทางไปยังหน้าที่ 2',
            customClass: {
              htmlContainer: 'swal2-html-line-height'
            },
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: '<?php echo site_url("que/Appointment/add_appointment_step2") ?>' + '/' + data.appointment_id,
                type: 'GET', // หรือใช้ 'POST' ตามการตั้งค่าของ Controller ของคุณ
                success: function(response) {
                  // ตอบสนองหลังจากเรียก Controller สำเร็จ
                  console.log('Successfully called add_appointment controller');
                  // ทำการเรียกฟังก์ชันหรือการทำงานต่อไปที่คุณต้องการ
                  goToStep2(data.appointment_id); // ตัวอย่างการเรียกฟังก์ชันไปยัง step 2
                },
                error: function(xhr, status, error) {
                  console.error('Error calling add_appointment controller:', error);
                  // จัดการข้อผิดพลาดหากมี
                }
              });
            }
          });
        } else {
          Swal.fire({
            title: 'ข้อผิดพลาด',
            text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
            icon: 'error',
            confirmButtonText: 'ตกลง',
            customClass: {
              htmlContainer: 'swal2-html-line-height'
            },
          });
        }
      },
      error: function(error) {
        console.error("Error: ", error);
        Swal.fire({
          title: 'ข้อผิดพลาด',
          text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
          icon: 'error',
          confirmButtonText: 'ตกลง',
          customClass: {
            htmlContainer: 'swal2-html-line-height'
          },
        });
      }
    });
  }

  function goToStep2(appointment_id) {
    // const step1 = document.getElementById('step1');
    // const step2 = document.getElementById('step2');
    // const collapseStep2 = document.getElementById('collapseStep2');

    // if (step1 && step2 && collapseStep2) {
    //   step1.style.display = 'none';
    //   step2.style.display = 'block';
    //   collapseStep2.classList.add('show');
    //   setTimeout(() => {
    //     window.scrollTo({
    //       top: 0,
    //       behavior: 'smooth'
    //     });
    //   }, 200); // Delay to ensure rendering

    // Redirect to step2 with appointment_id as query parameter
    window.location.href = '<?php echo site_url("que/Appointment/add_appointment_step2/") ?>' + '/' + appointment_id;
    // }
  }

</script>