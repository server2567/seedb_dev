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
        <i class="bi bi-person-fill icon-menu font-20"></i><span> รายละเอียดการนัดหมาย </span>
      </button>
    </h2>
    <form id="patientForm">
      <div class="accordion-item"  id="step2">
        <h2 class="accordion-header" id="headingStep2"></h2>
        <div id="collapseStep2" class="accordion-collapse collapse show" aria-labelledby="headingStep2">
          <div class="accordion-body p-0">
            <div class="card mb-0">
              <div class="card-body">
                <div class="row" style="height:75px; border-bottom: 1px solid #e1e1e1;">
                  <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2 " style="border-right: 1px solid #e1e1e1;">
                    <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3 text-secondary">ขั้นตอนที่ <i class="bi bi-1-square-fill fs-20 text-secondary"></i><br>บันทึกข้อมูลการนัดหมายแพทย์</span>
                  </div>
                  <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2">
                    <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3 ">ขั้นตอนที่ <i class="bi bi-2-square-fill fs-20"></i><br>ตรวจสอบการลงทะเบียน - ข้อมูลการนัดหมายแพทย์</span>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row justify-content-md-center mt-1">
                  <div class="col-12">
                    <button type="button" class="btn btn-secondary m-1 p-2 float-start" onclick="goToStep1()">
                      <i class="bi bi-arrow-left"></i> ย้อนกลับ
                    </button>
                  </div>
                </div>
              </div>
              <div class="info-validation row ms-3">
                <div class="row mt-3">
                  <div class="col-12">
                    <h5 class="mb-4 font-weight-600 font-20 mb-4">
                      <i class="bi bi-1-circle-fill font-24 me-3"></i>ข้อมูลผู้ป่วย
                    </h5>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-2 ps-3">
                    <label class="fw-bold">
                      <p class="mb-2">ประเภทผู้ป่วย</p>
                    </label>
                    <p>
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
                  <div class="col-2">
                    <label class="fw-bold">
                      <p class="mb-2">เลขที่บัตรประชาชน</p>
                    </label>
                    <p>
                      <?= $get_appointment['pt_identification'] ?? '-'; ?>
                    </p>
                  </div>
                  <div class="col-2">
                    <label class="fw-bold">
                      <p class="mb-2">ชื่อ - นามสกุล</p>
                    </label>
                    <p><?= $get_appointment['pt_prefix'].''.$get_appointment['pt_fname'].' '.$get_appointment['pt_lname']; ?></p>
                  </div>
                  <div class="col-2">
                    <label class="fw-bold">
                      <p class="mb-2">เบอร์โทร</p>
                    </label>
                    <p><?= $get_appointment['pt_tel'] ?? '-'; ?></p>
                  </div>
                  <div class="col-2">
                    <label class="fw-bold">
                      <p class="mb-2">อีเมล</p>
                    </label>
                    <p><?= $get_appointment['pt_email'] ?? '-'; ?></p>
                  </div>
                </div>
                <div class="row ms-4">
                <div class="col-2">
                    <label class="fw-bold">
                      <p class="mb-2">ช่องทางการติดต่อกลับ</p>
                    </label>
                    <p><?= $notification_name ?? '-'; ?></p>
                  </div>
                </div>
                <hr class="mt-2 mb-4">
                <div class="row mt-3">
                  <div class="col-12">
                    <h5 class="mb-4 font-weight-600 font-20 mb-4">
                      <i class="bi bi-2-circle-fill font-24 me-3"></i>วันที่ และเวลาที่ต้องการนัดหมายแพทย์
                    </h5>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-12 col-sm-12 col-md-12">
                    <p>วันที่ <?= fullDateTH3($get_appointment['apm_date']) ?? '-'; ?> เวลา <?= $get_appointment['apm_time'] ?? '-'; ?> น.</p>
                  </div>
                </div>
                <hr class="mt-2 mb-4">
                <div class="row mt-3">
                  <div class="col-12">
                    <h5 class="mb-4 font-weight-600 font-20 mb-4">
                      <i class="bi bi-3-circle-fill font-24 me-3"></i>รายละเอียดอาการเบื้องต้นเกี่ยวกับโรค
                    </h5>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-3 ps-3">
                    <label class="fw-bold">
                      <p class="mb-2">ตัองการเข้ารักษาเกี่ยวกับโรค</p>
                    </label>
                    <p><?= $get_appointment['ds_name_disease'] ?? '-'; ?></p>
                  </div>
                  <div class="col-3 ps-3">
                    <label class="fw-bold">
                      <p class="mb-2">แผนก</p>
                    </label>
                    <p><?= $get_appointment['stde_name_th'].' ('.$get_appointment['stde_name_en'].')' ?? '-'; ?></p>
                  </div>
                  <div class="col-12 ps-3 mt-3">
                    <label class="fw-bold">
                      <p class="mb-2">อาการเบื้องต้น</p>
                    </label>
                    <p><?= $get_appointment['apm_cause'] ?? '----'; ?></p>
                  </div>
                </div>
                <hr class="mt-2 mb-4">
                <div class="row mt-3">
                  <div class="col-12">
                    <h5 class="mb-4 font-weight-600 font-20 mb-4">
                      <i class="bi bi-4-circle-fill font-24 me-3"></i>จัดการนัดหมายแพทย์
                    </h5>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-2 ps-3">
                    <label class="fw-bold">
                      <p class="mb-2">ชื่อแพทย์</p>
                    </label>
                    <p><?= $get_appointment['pf_name'].''.$get_appointment['ps_fname'].' '.$get_appointment['ps_lname'] ?? '-'; ?></p>
                  </div>
                  <div class="col-12 ps-3 mt-3">
                    <label class="fw-bold">
                      <p class="mb-2">สาเหตุที่นัดหมายแพทย์</p>
                    </label>
                    <p><?= $get_appointment['apm_need'] ?? '-'; ?></p>
                  </div>
                </div>
                <hr class="mt-2 mb-4">
                <div class="row d-flex justify-content-center mb-5 pb-3">
                  <div class="col-9 col-md-9 col-lg-9 mt-4 content">
                    <div class="watermark"><?= $this->config->item('site_name_th'); ?></div>
                    <div class="watermark"><?= $this->config->item('site_name_th'); ?></div>
                    <div class="watermark"><?= $this->config->item('site_name_th'); ?></div>
                    <div class="watermark"><?= $this->config->item('site_name_th'); ?></div>
                    <div class="text-center bg-primary bg-opacity-25 p-md-7 p-5 rounded-4 pattern-square">
                      <div class="mb-4">
                        <h5 class="font-24 fw-bold">หมายเลขการจองคิว - นัดหมายแพทย์</h5>
                      </div>
                      <div class="d-flex flex-column align-items-center mb-5 mt-4">
                        <span class="me-3 font-20 bg-success p-2 text-white fw-bold rounded-5">
                          &emsp;&emsp;
                          <?= $get_appointment['apm_cl_code'] ?? '-'; ?>
                          &emsp;&emsp;
                        </span>
                      </div>
                      <div class="row d-flex justify-content-center">
                        <div class="col-4">
                          <div class="mb-4">
                            <h5 class="font-20 fw-bold">เลขทะเบียนผู้ป่วย</h5>
                          </div>
                          <div class="d-flex flex-column align-items-center">
                            <span class="me-3 font-22">
                              <span class="text-dark fw-bold"><?= $get_appointment['pt_member'] ?? '-'; ?></span>
                            </span>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="mb-4">
                            <h5 class="font-20 fw-bold">แผนก</h5>
                          </div>
                          <div class="d-flex flex-column align-items-center">
                            <span class="me-3 font-22">
                              <span class="text-dark fw-bold"><?= $get_appointment['stde_name_th'] ?? '-'; ?></span>
                            </span>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="mb-4">
                            <h5 class="font-20 fw-bold">วันที่ - เวลา</h5>
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
function goToStep1() {
  window.location.href = '<?php echo site_url("wts/Manage_queue/"); ?>';
}
</script>
