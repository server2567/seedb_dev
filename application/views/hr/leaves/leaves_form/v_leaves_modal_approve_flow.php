
<style>
  .step::before,
  .step::after {
    margin-left: -3px;
    width: 0.6%;
    opacity: 0.75;
  }
  .step-number{
    color: #fff;
  }
</style>

<div class="container">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mx-auto">
      
      <!-- Leave Topic Section -->
      <div class="card-header border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-2 font-18" style="line-height: 1.7;">
          <b> ผู้ทำเรื่องการลา: </b> <?php echo $leave_topic->pf_name.$leave_topic->ps_fname." ".$leave_topic->ps_lname; ?><br>
          <b> ประเภทการลา: </b> <?php echo $leave_topic->leave_name; ?><br>
          <b> ชื่อหัวข้อ: </b> <?php echo $leave_topic->lhis_topic; ?><br>
          <b> ช่วงวันที่ลา: </b> <?php echo abbreDate2($leave_topic->lhis_start_date) . " ถึง " . abbreDate2($leave_topic->lhis_end_date); ?><br>
          <b> จำนวนวันที่ลา: </b> <?php echo $leave_topic->lhis_num_day; ?> วัน <?php echo $leave_topic->lhis_num_hour; ?> ชั่วโมง <?php echo $leave_topic->lhis_num_minute; ?> นาที <br>
          <?php  
         
            if($leave_topic->lhis_attach_file != ""){ ?>
              <b> ไฟล์เอกสาร: </b>
              <a href="javascript:void(0);" class="" 
                data-file-name="<?php echo $leave_topic->lhis_attach_file; ?>" 
                data-preview-path="<?php echo site_url($this->config->item('hr_dir') . 'Getpreview?path=' . $this->config->item('hr_upload_leaves') . '&doc='); ?><?php echo $leave_topic->lhis_attach_file; ?>" 
                data-download-path="<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_leaves') . '&doc='); ?><?php echo $leave_topic->lhis_attach_file; ?>&rename=<?php echo $leave_topic->lhis_attach_file; ?>"
                data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" 
                title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน" data-toggle="tooltip" data-bs-placement="top">
                <?php echo $leave_topic->lhis_attach_file; ?>
              </a>

          <?php  
          }
          ?>
        </h6>
      </div>

      <!-- Approval Status Indicators and Steps -->
      <div id="cardToSave">
        <div class="card-body pb-2 pt-3">

          <!-- Approval Status Legend -->
          <div class="fw-bold pb-2 ps-4 text-secondary">
            สถานะอนุมัติการลา <br>
            <span class="btn btn-primary w-20 p-0 font-14">ขั้นตอนอนุมัติปัจจุบัน</span>
            <span class="btn btn-secondary w-20 p-0 font-14 ms-1">รอดำเนินการ</span>
            <span class="btn btn-success w-20 p-0 font-14 ms-1">ดำเนินการอนุมัติ</span>
            <span class="btn btn-danger w-20 p-0 font-14 ms-1">ดำเนินการไม่อนุมัติ</span>
          </div>

          <!-- Approval Flow Steps -->
          <div class="row">
            <div class="steps steps-sm mt-3 font-18">
              
              <?php 
                // Loop through each flow item in the leave approval process
                foreach ($leave_flow as $flow) { 
                  $bg_color = "";  // Background color based on approval status
                  $text_status = "";  // Status text based on approval
                  $text_approve_date = "";

                  // Determine the background color and status text based on approval conditions
                  if ($leave_topic->lhis_status == $flow->lafw_seq && $flow->lafw_status == 'W') {
                    // Current step in the process and pending approval
                    $bg_color = "#0d6efd";  // Blue for current step
                    $text_status = $flow->last_name;
                  } else if ($flow->lafw_status == 'Y') {
                    // Approved step
                    $bg_color = "#198754";  // Green for approved
                    $text_status = $flow->last_yes;
                    $text_approve_date = abbreDate4($flow->lafw_update_date);
                  } else if ($leave_topic->lhis_status == "N" && $flow->lafw_status == 'N') {
                    // Rejected step
                    $bg_color = "#dc3545";  // Red for rejected
                    $text_status = $flow->last_no;
                    $text_approve_date = abbreDate4($flow->lafw_update_date);
                  } else {
                    // Default to pending if no other status is set
                    $bg_color = "#6c757d";  // Gray for pending or unknown
                    $text_status = $flow->last_name;
                  }
              ?>

              <!-- Single Approval Step -->
              <div class="step">
                <div class="step-number" style="background-color: <?php echo $bg_color; ?>;">
                  <?php echo $flow->lafw_seq; ?>
                </div>
                <div class="step-body">
                  <h5><?php echo $flow->text_approver; ?></h5>
                  <p>ตำแหน่ง: <?php echo $flow->admin_position ?: '-'; ?></p>
                  <?php
                    if($text_approve_date != ""){
                  ?>
                    <p>วันที่ดำเนินการ: <?php echo $text_approve_date; ?></p>
                  <?php
                    }
                  ?>
                  <p>สถานะ: <?php echo $text_status; ?></p>
                  <p>ความคิดเห็น: <?php echo $flow->lafw_comment ?: '-'; ?></p>
                </div>
              </div>
              

              <?php } // End of leave_flow loop ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
