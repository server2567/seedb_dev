<div class="row topbar">
  <div class="col-md-12 nav_topbar">
    <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    <a href="<?php echo $this->config->item('base_frontend_url').'index.php/que/frontend/Search_queuing_home'; ?>">
      &nbsp;<i class="bi bi-person-bounding-box"></i>&nbsp;
    <span class='font-16'>จัดการคิว และนัดหมายแพทย์</span>
    </a>
    &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    &nbsp;<i class="bi bi-person-fill-add text-white"></i>&nbsp;
    <span class='text-white font-16'>บันทึกข้อมูลการนัดหมายแพทย์ ขั้นตอนที่ 1</span>
  </div>
</div>
<div class="row justify-content-md-center mt-2">
    <div class="col-3 col-sm-3 col-md-3">
        <img src="https://surateyehospital.com/wp-content/uploads/2023/01/S__64995330-e1674529006351.jpg" alt="Profile" class="rounded-circle col-12 col-sm-12 col-md-9">
    </div>
    <div class="col-9 col-sm-9 col-md-9">
        <h4 class="card-title pb-0 font-weight-600 pt-3 fs-4">นพ.บรรยง ชินกุลกิจนิวัฒน์</h5>
        <h4 class="card-title pb-0 font-weight-500 pt-3 fs-5">จักษุแพทย์ เชี่ยวชาญการผ่าตัดต้อกระจก</h5>
        <h4 class="card-title pb-0 font-weight-400 pt-3 fs-6">จักษุแพทย์ รักษาโรคตาทั่วไปเชี่ยวชาญการผ่าตัดต้อกระจก Subspecialty General Ophthalmology and Cataract</h5>
        <a href="<?php echo site_url();?>/hr/frontend/profile" class="btn btn-primary mt-5 fs-6">ข้อมูลแพทย์เพิ่มเติม</a>
        <button class="btn btn-info mt-5 fs-6 ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample_1" aria-expanded="false" aria-controls="collapseExample_1">
            ตารางแพทย์ออกตรวจ
        </button>
        <div class="collapse" id="collapseExample_1">
            <div class="card card-body mt-3">
            <table class='table border-warning'>
                <thead>
                <tr>
                    <th>วันที่ออกตรวจ</th>
                    <th>เวลาที่ออกตรวจ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>วันจันทร์</td>
                    <td>08.30 - 16.00</td>
                </tr>
                <tr>
                    <td>อังคาร</td>
                    <td>08.30 - 16.00</td>
                </tr>
                <tr>
                    <td>พุธ</td>
                    <td>08.30 - 16.00</td>
                </tr>
                <tr>
                    <td>พฤหัสบดี</td>
                    <td>08.30 - 16.00</td>
                </tr>
                <tr>
                    <td>ศุกร์</td>
                    <td>08.30 - 16.00</td>
                </tr>
                <tr>
                    <td>เสาร์</td>
                    <td>08.30 - 16.00</td>
                </tr>
                <tr>
                    <td>อาทิตย์</td>
                    <td>08.30 - 16.00</td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-md-center mt-5">
    <div class="col-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row" style="height:75px; border-bottom: 1px solid #e1e1e1;">
                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2" style="border-right: 1px solid #e1e1e1;">
                        <i class="bi bi-1-square-fill fs-2"></i>
                        <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3">บันทึกข้อมูลการนัดหมายแพทย์<br>ขั้นตอนที่ 1</span>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2">
                        <i class="bi bi-2-square-fill fs-2 text-secondary"></i>
                        <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3 text-secondary">ตรวจสอบการลงทะเบียน - ข้อมูลการนัดหมายแพทย์<br>ขั้นตอนที่ 2</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-0 mb-4">
                    <div class="col-12">
                        <h6 class=" font-weight-600 font-18">วันที่ต้องการจองคิว - นัดหมายแพทย์  <span class="text-danger">*</span>
                            <hr class="style-two" style="margin-top: -10px; background-image: linear-gradient(to left, #e9d494 75%, transparent 20%);">
                        </h6>
                    </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-4">
                      <div class="form-floating mb-4">
                          <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                          <?php
                              $currentYear = date("Y") + 543; // Get current year in Gregorian calendar and convert to Buddhist calendar
                              for ($year = $currentYear; $year <= $currentYear + 1; $year++) {
                                  $buddhistYear = $year; // Convert back to Buddhist calendar
                              ?>
                                  <option value="<?php echo $buddhistYear; ?>"><?php echo $buddhistYear; ?></option>
                              <?php } ?>
                          </select>
                          <label for="floatingSelect">เลือกปี พ.ศ. <span class="text-danger">*</span></label>
                      </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-4">
                      <div class="form-floating mb-4">
                      <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                          <?php
                          $currentMonth = date("n");
                          $thaiMonths = array(
                              "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                              "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                          );

                          for ($month = $currentMonth; $month <= 12; $month++) { // เริ่มต้นที่เดือนปัจจุบัน
                              $selected = ($month == $currentMonth) ? "selected" : "";
                          ?>
                              <option value="<?php echo $month; ?>" <?php echo $selected; ?>><?php echo $thaiMonths[$month - 1]; ?></option>
                          <?php } ?>
                      </select>
                          <label for="floatingSelect">เลือกเดือน <span class="text-danger">*</span></label>
                      </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-4">
                      <div class="form-floating mb-4">
                          <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                          <?php
                            $currentDay = date("j");
                            for ($d = 1; $d <= 31; $d++) {
                                // Check if the day is in the past
                                $isPastDay = ($d < $currentDay);
                                // If it's a past day, skip this iteration of the loop
                                if ($isPastDay) {
                                    continue;
                                }
                                // Otherwise, proceed to create the option
                                $selected = ($d == $currentDay) ? "selected" : "";
                            ?>
                                <option value="<?php echo $d; ?>" <?php echo $selected; ?>><?php echo $d; ?></option>
                            <?php } ?>
                          </select>
                          <label for="floatingSelect">เลือกวัน <span class="text-danger">*</span></label>
                      </div>
                  </div>
                </div>
                <div class="row mb-4 mt-4">
                    <div class="col-12">
                        <h6 class=" font-weight-600 font-18">เวลาที่ต้องการจองคิว - นัดหมายแพทย์  <span class="text-danger">*</span>
                            <hr class="style-two" style="margin-top: -10px; background-image: linear-gradient(to left, #e9d494 75%, transparent 20%);">
                        </h6>
                    </div>
                </div>
                <div class="row">
                  <?php 
                    $startHour = 8; // Starting hour
                    $endHour = 20; // Ending hour
                    $interval = 2; // Interval in hours
                  for ($hour = $startHour; $hour < $endHour; $hour += $interval) { 
                    $startTime = sprintf('%02d', $hour) . ':00'; 
                    $endTime = sprintf('%02d', ($hour + $interval)) . ':00'; ?>
                  <div class="col-lg-2 col-md-4 col-6">
                    <a href="#!" class="card-hover bg-white card card-lift text-center p-4 d-flex align-items-center " onclick="handleClick(this)">
                        <span class="border-1 rounded-circle mb-4" style="height: 60px; display: inline-block; width: 60px; padding-top: 8px;">
                        <i class="bi bi-alarm font-26"></i>
                        </span>
                        <h4 class="mb-0 card-text fs-5"><?php echo $startTime . ' - ' . $endTime; ?></h4>
                        <h4 class="mb-0 card-text font-18 mt-3">ว่าง 7 คิว</h4>
                    </a>
                  </div>
                  <?php } ?>
                </div>
                <div class="row mb-2 mt-4">
                  <div class="col-12">
                      <h6 class=" font-weight-600 font-18">รายละเอียดการจองคิว - นัดหมายแพทย์  <span class="text-danger">*</span>
                          <hr class="style-two" style="margin-top: -10px; background-image: linear-gradient(to left, #e9d494 75%, transparent 20%);">
                      </h6>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-12 col-lg-6">
                    <label for="" class="form-label">ระบุประเภทผู้ป่วย  <span class="text-danger">*</span></label>
                    <div class="form-check ms-2">
                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked="">
                      <label class="form-check-label" for="gridRadios1">
                        ผู้ป่วยเก่า
                      </label>
                    </div>
                    <div class="form-check ms-2">
                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                      <label class="form-check-label" for="gridRadios2">
                        ผู้ป่วยใหม่
                      </label>
                    </div>
                  </div>
                  <div class="col-12 col-md-12 col-lg-6">
                    <div class="form-floating mb-3">
                      <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <option selected="">ไม่ทราบ หรือสามารถระบุได้ กรุณาเลือก</option>
                        <option value="1">โรคต้อเนื้อ</option>
                        <option value="2">โรคจอประสาทตา</option>
                        <option value="3">โรคต้อหิน</option>
                        <option value="4">โรคกระจกตา</option>
                        <option value="5">โรคของเปลือกตา ท่อน้ำตา และเบ้าตา</option>
                        <option value="6">โรคตาเด็ก</option>
                        <option value="7">โรคทางเส้นประสาท</option>
                      </select>
                      <label for="floatingSelect">ประเภทโรคผู้ป่วย (ถ้าทราบ)</label>
                    </div>
                  </div>
                </div>
                <div class="row mt-3 mb-4">
                  <div class="col-6 col-md-6 col-lg-6">
                    <label for="" class="form-label">ระบุสาเหตุที่นัดหมายแพทย์ (ถ้ามี)</label>
                      <div class="quill-editor-default"></div>
                  </div>
                  <div class="col-6 col-md-6 col-lg-6">
                    <label for="" class="form-label">ระบุความต้องการเพิ่มเติม (ถ้ามี)</label>
                      <div class="quill-editor-default2"></div>
                  </div>
                </div>
                <div class="row mt-5 mb-3">
                  <div class="col-12 col-md-12 col-lg-11">
                    <a href="<?php echo base_frontend_url('index.php').'/'.$this->config->item('que_frontend_path').'/Queuing_form_step2'; ?>" type="button" class="btn btn-success float-end btn-lg"><i class="bi bi-floppy2-fill"></i> บันทึก และทำรายการถัดไป</a>
                    <a type="button" class="btn btn-outline-success float-end me-4 btn-lg"><i class="bi bi-floppy2-fill"></i> บันทึก ฉบับร่าง</a>
                  </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function handleClick(element) {
  // ลบคลาส active จากทุก elements ที่มีคลาส active อยู่
  var activeElements = document.querySelectorAll('.active');
  activeElements.forEach(function(el) {
    el.classList.remove('active');
  });

  // เพิ่มคลาส active ให้กับ element ที่ถูกคลิก
  element.classList.add('active');
}
if (document.querySelector('.quill-editor-default')) {
  new Quill('.quill-editor-default', {
    theme: 'snow'
  });
  $('.ql-container').addClass('custom-height').css('height', '200px');
}
if (document.querySelector('.quill-editor-default2')) {
  new Quill('.quill-editor-default2', {
    theme: 'snow'
  });
  $('.ql-container').addClass('custom-height').css('height', '200px');
}
</script>