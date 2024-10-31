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
        <i class="bi bi-person-fill-add icon-menu font-20"></i><span> รายละเอียดการนัดหมาย </span>
      </button>
    </h2>
    <form id="patientForm">
      <div class="accordion-item"  id="step2">
        <h2 class="accordion-header" id="headingStep2"></h2>
        <div id="collapseStep2" class="accordion-collapse collapse show" aria-labelledby="headingStep2">
          <div class="accordion-body p-0">
            <div class="card mb-0">
            <div class="row justify-content-md-center mt-3 ms-3 mb-1">
                <div class="col-12 mt-0 mb-3">
                  <button type="button" class="btn btn-secondary m-1 p-2 float-start" id="backButton" >
                    <i class="bi bi-arrow-left"></i> ย้อนกลับ
                  </button>
                </div>
              </div>
              <div class="info-validation row ms-3">
                <div class="row mt-3">
                  <div class="col-md-12">
                    <h5 class="mb-4 font-weight-600 font-20 mb-4">
                      <i class="bi bi-1-circle-fill font-24 me-3"></i>ข้อมูลผู้ลงทะเบียน
                    </h5>
                  </div>
                </div>
                <div class="row ms-4 font-18">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-12 ps-3 pb-5">
                        <?php if (isset($get_appointment['ptd_img_code'])) { ?>
                          <img style="width:180px; height:180px;" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" src="data:image/<?php echo $get_appointment['ptd_img_type']; ?>;base64,<?php echo $get_appointment['ptd_img_code']; ?>" alt="">
                        <?php } else { ?>
                          <img style="width:180px; height:180px;" id="profileImage" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" src="<?php echo base_url(); ?>assets/img/default-person.png" alt="">
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row ms-4 font-18">
                  <div class="col-md-4">
                    <label class="fw-bold">
                      <p class="mb-2">1.1 ประเภทผู้ลงทะเบียน</p>
                    </label>
                    <p class="">
                        <?php 
                        if (isset($get_appointment) && !empty($get_appointment)) {
                            if ($get_appointment['apm_patient_type'] == 'old') {
                                echo 'ผู้ป่วยเก่า';
                            } else {
                                echo 'ผู้ป่วยใหม่';
                            }
                        } ?>
                    </p>
                  </div>
                  <div class="col-md-6">
                    <label class="fw-bold">
                      <p class="mb-2">1.2 เลขที่บัตรประจำตัวประชาชน/หนังสือเดินทาง/บัตรต่างด้าว</p>
                    </label>
                    <p>
                      <?= $get_appointment['pt_identification'] ?? '-'; ?>
                    </p>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-md-4">
                    <label class="fw-bold">
                      <p class="mb-2">1.3 ชื่อ - นามสกุล</p>
                    </label>
                    <p><?= $get_appointment['pt_prefix'].''.$get_appointment['pt_fname'].' '.$get_appointment['pt_lname']; ?></p>
                  </div>
                  <div class="col-md-4">
                    <label class="fw-bold">
                      <p class="mb-2">1.4 เบอร์โทร</p>
                    </label>
                    <p><?= $get_appointment['pt_tel'] ?? '-'; ?></p>
                  </div>
                  <div class="col-md-4">
                    <label class="fw-bold">
                      <p class="mb-2">1.5 อีเมล</p>
                    </label>
                    <p><?= $get_appointment['pt_email'] ?? '-'; ?></p>
                  </div>
                  <!-- <div class="col-md-3">
                    <label class="fw-bold">
                      <p class="mb-2">1.6 ช่องทางการติดต่อกลับ</p>
                    </label>
                    <p><?= $notification_name ?? '-'; ?></p>
                  </div> -->
                </div>
                <hr class="mt-2 mb-4">
                <div class="row mt-3">
                  <div class="col-md-12">
                    <h5 class="mb-4 font-weight-600 font-20 mb-4">
                      <i class="bi bi-2-circle-fill font-24 me-3"></i>วันที่ และเวลาที่ต้องการนัดหมายแพทย์
                    </h5>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-md-12 col-sm-12 col-md-12">
                    <p>วันที่ <?= fullDateTH3($get_appointment['apm_date']) ?? '-'; ?> เวลา <?= $get_appointment['apm_time'] ?? '-'; ?> น.</p>
                  </div>
                </div>
                <hr class="mt-2 mb-4">
                <div class="row mt-3">
                  <div class="col-12">
                    <h5 class="mb-4 font-weight-600 font-20 mb-4">
                      <i class="bi bi-3-circle-fill font-24 me-3"></i>รายละเอียดแพทย์และแผนก
                    </h5>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-md-8 ps-3">
                    <!-- <label class="fw-bold"> -->
                      <!-- <p class="mb-2">3.1 แผนก</p> -->
                    <!-- </label> -->
                    <?php foreach ($get_appointment_by_visit as $index => $get_appointment): ?>
    <p><?= '3.'.($index + 1) . '. '; ?> 
    <?php 
        if (empty($get_appointment['pf_name']) && empty($get_appointment['ps_fname']) && empty($get_appointment['ps_lname'])) {
            echo 'ไม่ระบุแพทย์';
        } else {
            // Concatenate the name parts if they are not empty
            echo ($get_appointment['pf_name'] ?? '') . ' ' . ($get_appointment['ps_fname'] ?? '') . ' ' . ($get_appointment['ps_lname'] ?? '');
        }
        // Add the department information
        echo ' - ' . ($get_appointment['stde_name_th'] ?? '') . ' (' . ($get_appointment['stde_name_en'] ?? '') . ')';
    ?>
    </p>
<?php endforeach; ?>
                    <!-- <p><?= $get_appointment['stde_name_th'].' ('.$get_appointment['stde_name_en'].')' ?? '-'; ?></p> -->
                  </div>
                  <!-- <div class="col-md-6 ps-3">
                    <label class="fw-bold">
                      <p class="mb-2">3.2 โรค</p>
                    </label>
                    <p><?= $get_appointment['ds_name_disease'] ?? '- ไม่ทราบโรค '; ?></p>
                  </div>
                  <div class="col-md-12 ps-3 mt-3">
                    <label class="fw-bold">
                      <p class="mb-2">3.3 ระบุสาเหตุ หรืออาการเบื้องต้น</p>
                    </label>
                    <p><?= !empty(trim($get_appointment['apm_cause'])) ? $get_appointment['apm_cause'] : '-'; ?></p>
                  </div> -->
                </div>
                <!-- <hr class="mt-2 mb-4"> -->
                <!-- <div class="row mt-3">
                  <div class="col-md-12">
                    <h5 class="mb-4 font-weight-600 font-20 mb-4">
                      <i class="bi bi-4-circle-fill font-24 me-3"></i>แพทย์ที่ต้องการนัดหมาย
                    </h5>
                  </div>
                </div> -->
                <div class="row ms-4">
                <!-- <?php 
$counter = 1; // Start the counter at 1
foreach ($get_appointment_by_visit as $get_appointment): ?>
    <div class="col-md-3 ps-3">
        <label class="fw-bold">
            <p class="mb-2">
                <?= "4.$counter ชื่อแพทย์ (" . ($get_appointment['stde_name_th'] ?? '-') . ")"; ?>
            </p>
        </label>
        <p>
            <?php
            // Check if any part of the name is empty or null
            if (empty($get_appointment['pf_name']) && empty($get_appointment['ps_fname']) && empty($get_appointment['ps_lname'])) {
                echo ' - ไม่ระบุแพทย์';
            } else {
                // Concatenate the name parts if they are not empty
                echo ($get_appointment['pf_name'] ?? '') . ' ' . ($get_appointment['ps_fname'] ?? '') . ' ' . ($get_appointment['ps_lname'] ?? '');
            }
            ?>
        </p>
    </div>
    <?php $counter++; // Increment the counter for the next iteration ?>
<?php endforeach; ?> -->
                  <!-- <div class="col-12 ps-3 mt-3">
                    <label class="fw-bold">
                      <p class="mb-2">สาเหตุที่นัดหมายแพทย์</p>
                    </label>
                    <p><?php //echo $get_appointment['apm_need'] ?? '-'; ?></p>
                  </div> -->
                </div>

                <!-- <hr class="mt-2 mb-4">
                <div class="row d-flex justify-content-center mb-3">
                  <div class="col-md-9 col-lg-9 mt-4 content">
                    <div class="watermark"><?= $this->config->item('site_name_th'); ?></div>
                    <div class="watermark"><?= $this->config->item('site_name_th'); ?></div>
                    <div class="watermark"><?= $this->config->item('site_name_th'); ?></div>
                    <div class="watermark"><?= $this->config->item('site_name_th'); ?></div>
                    <div class="text-center bg-primary bg-opacity-25 p-md-7 p-5 rounded-4 pattern-square">
                      <div class="mb-4">
                        <h5 class="font-24 fw-bold">หมายเลขนัดหมายแพทย์</h5>
                      </div>
                      <div class="d-flex flex-column align-items-center mb-5 mt-4">
                        <span class="me-3 font-20 bg-success p-2 text-white fw-bold rounded-5">
                          &emsp;&emsp;
                          <?php //echo $get_appointment['apm_cl_code'] ?? '-'; ?>
                          &emsp;&emsp;
                        </span>
                      </div>
                      <div class="row d-flex justify-content-center">
                        <div class="col-md-4">
                          <div class="mb-4">
                            <h5 class="font-20 fw-bold">เลขทะเบียนผู้ป่วย(HN)</h5>
                          </div>
                          <div class="d-flex flex-column align-items-center">
                            <span class="me-3 font-22">
                              <span class="text-dark fw-bold"><?= $get_appointment['pt_member'] ?? '-'; ?></span>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-4">
                            <h5 class="font-20 fw-bold">แผนกที่เข้ารับการรักษา</h5>
                          </div>
                          <div class="d-flex flex-column align-items-center">
                            <span class="me-3 font-22">
                              <span class="text-dark fw-bold"><?= $get_appointment['stde_name_th'] ?? '-'; ?></span>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-4">
                            <h5 class="font-20 fw-bold">วันที่ และเวลา</h5>
                          </div>
                          <div class="d-flex flex-column align-items-center">
                            <span class="me-3 font-18">
                              <span class="text-dark fw-bold"><?= fullDateTH3($get_appointment['apm_date']) ?? '-'; ?><br>เวลา <?= $get_appointment['apm_time'] ?? '-'; ?> น.</span>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                 -->
                <div class="row mt-5 mb-5">
                  <div class="col-md-12 col-md-12 col-lg-11">
                  
                    <!-- <button type="button" class="btn btn-success float-end btn-lg" onclick="confirmAppointment()">
                      <i class="bi bi-floppy2-fill"></i> ยืนยันการนัดหมายแพทย์</button> -->
                  </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const previousPage = localStorage.getItem('previousPage');
    const backButton = document.getElementById('backButton');

    if (previousPage) {
        backButton.innerHTML = '<i class="bi bi-arrow-left"></i> ย้อนกลับ';
    }

    backButton.addEventListener('click', function() {
        if (previousPage) {
            window.location.href = previousPage;
        } else {
            goToStep1(); // Fallback to step 1 if no previous page is found
        }
    });
});
function goToStep1() {
    const previousPage = localStorage.getItem('previousPage');
    if (previousPage) {
      localStorage.removeItem('previousPage'); 
        window.location.href = previousPage;
    } else {
      window.location.href = '<?php echo site_url("que/Appointment/add_appointment/".$get_appointment['apm_id'].""); ?>'; 
    }
}

function confirmAppointment() {
    Swal.fire({
      title: 'ยืนยันการนัดหมายแพทย์',
      html: `<div class="text-start font-20 " >
              <h6 class="font-weight-600 font-20 pt-2" >ชื่อ-นามสกุลผู้ป่วย: <span class="font-weight-400"> <?php if (empty($get_appointment['pt_name']) && empty($get_appointment['pt_fname']) && empty($get_appointment['pt_lname'])) {
                          echo ' - ไม่มีชื่อ';
                      } else {
                          // Concatenate the name parts if they are not empty
                          echo $get_appointment['pt_name'] ?? '';
                      } ?></span></h6>
              <h6 class="font-weight-600 font-20 pt-2">วันที่ และเวลานัดหมาย: <span class="font-weight-400"> <?php if (empty($get_appointment['apm_date']) ) {
                          echo ' - ไม่ลงเวลา';
                      } else {
                          // Concatenate the name parts if they are not empty
                          echo fullDateTH3($get_appointment['apm_date']) ?? '-';  ;
                      } ?></span></h6>
              <h6 class="font-weight-600 font-20 pt-2">แผนก: <span class="font-weight-400"> <?php if (empty($get_appointment['stde_name_th'])) {
                          echo ' - ไม่มีแผนก';
                      } else {
                          // Concatenate the name parts if they are not empty
                          echo $get_appointment['stde_name_th'] ?? '' ;
                      } ?></span></h6>
              
              <h6 class="font-weight-600 font-20 pt-2">แพทย์ที่นัดมาย: <span class="font-weight-400"><?php if (empty($get_appointment['pf_name']) && empty($get_appointment['ps_fname']) && empty($get_appointment['ps_lname'])) {
                          echo ' - ไม่ระบุแพทย์';
                      } else {
                          // Concatenate the name parts if they are not empty
                          echo ($get_appointment['pf_name_abbr'] ?? '') . ' ' . ($get_appointment['ps_fname'] ?? '') . ' ' . ($get_appointment['ps_lname'] ?? '');
                      } ?> </span></h6>
              
              
              </div>`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#198754',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ยืนยันการนัดหมายแพทย์',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
          let timerInterval;
          Swal.fire({
              title: 'สำเร็จ !',
              html: 'การนัดหมายแพทย์ของท่านสำเร็จแล้ว <br>กำลังนำทางไปที่หน้าหลักใน <b></b> วินาที',
              icon: 'success',
              timer: 3000, // 5000 milliseconds = 5 seconds
              showConfirmButton: false,
              willOpen: () => {
                  const b = Swal.getHtmlContainer().querySelector('b');
                  timerInterval = setInterval(() => {
                      b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                  }, 100);
              },
              willClose: () => {
                  clearInterval(timerInterval);
              }
          }).then(() => {
              window.location.href = '<?php echo site_url('que/Appointment');?>';
          });
      }
    });
  }
</script>
