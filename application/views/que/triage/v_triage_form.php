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

  .spinner-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1050;
    /* Ensure it is above other content */
    /* Hidden by default */
  }
  .swal2-large {
    width: 900px; /* ปรับตามขนาดที่ต้องการ */
    max-width: 80%; /* ทำให้มันสามารถปรับขนาดได้ตามหน้าจอ */
    font-size: 1.2em; /* ปรับขนาดของฟอนต์ในหน้าต่าง */
  }
  /* ซ่อนลูกศรของ select เมื่อถูกปิดใช้งาน */
  select:disabled {
    appearance: none;  /* สำหรับเบราว์เซอร์ที่รองรับ */
    -moz-appearance: none;  /* สำหรับ Firefox */
    -webkit-appearance: none;  /* สำหรับ Chrome และ Safari */
    background-color: #e9ecef;  /* เปลี่ยนสีพื้นหลังให้เหมือนเดิม */
  }

  /* กำหนดขนาดและความกว้างของ select ตามปกติ */
  select.form-select:disabled {
    background-image: none;  /* ซ่อนภาพลูกศร */
  }
</style>
<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingAdd">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
        <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
        <i class="bi bi-person-fill-add icon-menu font-20"></i><span> <?php echo isset($appointment_id) && !empty($appointment_id) ? "ลงทะเบียนผู้ป่วย - นัดหมายแพทย์" : "ลงทะเบียนผู้ป่วย - นัดหมายแพทย์"; ?> </span>
        <?php } else { ?>
        <i class="bi bi-person-fill-add icon-menu font-20"></i><span> นัดพบแพทย์ </span>
        <?php } ?>
      </button>
    </h2>
    <form id="patientForm">
      <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
        <div class="accordion-body p-0" id="step1">
          <div class="card mb-0">
            <!-- <div class="card-body">
              <div class="row" style="height:75px; border-bottom: 1px solid #e1e1e1;">
                <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2" style="border-right: 1px solid #e1e1e1;">
                  <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3">ขั้นตอนที่ <i class="bi bi-1-square-fill fs-20"></i><br>ข้อมูลการลงทะเบียนผู้ป่วย</span>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2">
                  <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3 text-secondary" style="color: #bcbfc1 !important;">ขั้นตอนที่ <i class="bi bi-2-square-fill fs-20 text-secondary"></i><br>ตรวจสอบข้อมูลการลงทะเบียนผู้ป่วย - ข้อมูลการนัดหมายแพทย์</span>
                </div>
              </div>
            </div> -->
            <input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo isset($appointment_id) ? $appointment_id : $get_appointment['apm_id'] ?? ''; ?>">
            <div class="card-body">
             <div class="row justify-content-md-center mb-1">
                <div class="col-12 mt-0 mb-3">
                  <button type="button" class="btn btn-secondary m-1 p-2 float-start" id="backButton" onclick="goBack()">
                    <i class="bi bi-arrow-left"></i> ย้อนกลับ
                  </button>
                </div>
              </div>
              <?php if (empty($get_appointment)) { ?>
              <div class="row justify-content-md-center mt-1 mb-3">
                <h5 class="mb-2 font-weight-600 font-20 ms-4">
                  <i class="bi bi-1-circle-fill font-24 me-3 "></i>
                  ประเภทผู้ลงทะเบียน
                </h5>
                <div class="col-12 col-md-12 col-lg-12 ms-5 ps-5 mb-3 pb-3">
                  <div class="">
                    <input class="form-check-input mt-2" type="radio" name="gridRadios" id="gridRadios1" value="old" <?php if (!empty($get_appointment)) {echo "disabled";} ?> <?= isset($get_appointment['apm_patient_type']) && $get_appointment['apm_patient_type'] == 'old' ? 'checked' : '' ?>>
                    <label class="form-check-label me-4 mt-2" for="gridRadios1">
                      ผู้ป่วยเก่า
                    </label>
                    <input class="form-check-input mt-2" type="radio" name="gridRadios" id="gridRadios2" value="new" <?php if (!empty($get_appointment)) {echo "disabled";} ?> <?= !isset($get_appointment['apm_patient_type']) || $get_appointment['apm_patient_type'] == 'new' ? 'checked' : '' ?>>
                    <label class="form-check-label mt-2" for="gridRadios2">
                      ผู้ป่วยใหม่
                    </label>
                  </div>
                </div>
                <hr class="mb-4">
              </div>
              <?php } ?>
              <div class="row justify-content-md-center mt-1 mb-3 d-none" id="dynamicContent">
                <?php if (empty($get_appointment)) { ?>
                  <h5 class="mb-2 font-weight-600 font-20 ms-4" id="dynamic-content_1">
                    <i class="bi bi-2-circle-fill font-24 me-3"></i>
                    ค้นหา หรือตรวจสอบข้อมูลผู้ป่วย
                  </h5>
                  <p class=" text-primary fw-bold ps-5 ms-5 mt-3"> *** ในกรณีที่ระบุเลขบัตรประจำตัวประชาชน และ/หรือเลข HN และ/หรือชื่อผู้ป่วย แล้วไม่พบข้อมูลให้ทำการระบุเป็นผู้ป่วยใหม่</p>
                  <div class="pb-5 pe-5 d-flex flex-row-reverse bd-highlight form-floating text-center">
                    <button type="button" id="checkPatient" class="btn btn-primary btn-lg mt-4"><i class="bi bi-clipboard-fill"></i> ค้นหาชื่อผู้ป่วย</button>

                  </div>

                  <div class="row mt-0 mb-5 d-flex justify-content-center">
                    <div class="col-5 col-md-5 col-lg-5">
                      <div class="form-floating mb-2 text-center">
                        <input type="text" class="form-control mb-0 " id="floatingInput_identification" name="identification" maxlength="13" oninput="limitInputLength(this)" placeholder="">
                        <label for="floatingInput_identification">ระบุเลขบัตรประจำตัวประชาชน/หนังสือเดินทาง/บัตรต่างด้าว <span class="text-danger">*</span></label>
                        <button type="button" id="checkButton_identification" class="btn btn-success btn-lg mt-4"><i class="bi bi-patch-check"></i> ตรวจสอบเลขบัตรประจำตัวประชาชน</button>
                      </div>
                    </div>
                    <div class="col-1 col-md-1 col-lg-1 text-center fw-bold font-18">หรือ </div>
                    <div class="col-4 col-md-4 col-lg-4">
                      <div class="form-floating mb-2 text-center">
                        <input type="number" class="form-control mb-0" id="floatingInput_member" name='member' placeholder="">
                        <label for="floatingInput_member">ระบุเลข HN <span class="text-danger">*</span></label>
                        <button type="button" id="checkButton_member" class="btn btn-success btn-lg mt-4"><i class="bi bi-patch-check"></i> ตรวจสอบเลข HN</button>
                      </div>
                    </div>
                  </div>

                  <hr class="mb-4">
                <?php } ?>
              </div>

              <!-- Modal for detailsHRMCard -->
              <div class="modal fade" id="detailsHRMCard" tabindex="-1" aria-labelledby="detailsHRMCardLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="detailsHRMCardLabel">ค้นหาชื่อ-นามสกุลผู้ป่วย</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="card">
                        <div class="accordion">
                          <div class="accordion-item">
                            <h2 class="accordion-header">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                                <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูล</span><span class="badge bg-success"></span>
                              </button>
                            </h2>
                            <div id="collapseCard" class="accordion-collapse collapse-show">
                              <div class="accordion-body ">
                                <div class="row">
                                  <div class="col-12 mb-3">
                                    <label for="date" class="form-label ">ค้นหาด้วยชื่อ</label>
                                    <input type="text" class="form-control" name="" id="patient-name" step="" placeholder="ชื่อ-นามสกุล ผู้ป่วย" value="">
                                  </div>

                                  <div class="col-md-12">
                                    <button type="submit" id="search" class="btn btn-primary float-end me-5"><i class="bi-search icon-menu"></i>&nbsp;ค้นหา&emsp;</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <table id="dataTable" class="table table-striped table-bordered w-100 d-none">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>เลขที่บัตรประจำตัวประชาชน/หนังสือเดินทาง/บัตรต่างด้าว</th>
                            <th>คำนำหน้าชื่อ</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>อีเมล</th>
                            <th>ดำเนินการ</th>

                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-md-center mt-1 mb-3">
                <?php if (empty($get_appointment)) { ?>
                <h5 class="mb-4 font-weight-600 font-20 mb-4 ms-4">
                  <i class="bi bi-2-circle-fill font-24 me-3" id="patientInfoIcon"></i>
                  ข้อมูลผู้ลงทะเบียน
                </h5>
                <?php } ?>
                <?php if (!empty($get_appointment)) { ?>
                <h5 class="mb-4 font-weight-600 font-20 mb-4 ms-4">
                  <i class="bi bi-1-circle-fill font-24 me-3" ></i>
                  ข้อมูลผู้ลงทะเบียน
                </h5>
                <?php } ?>
                <div class="row px-4 mb-4">
                  <h7 class="mb-4 font-weight-600 font-20 mb-4 ms-2">
                    รูปภาพผู้ลงทะเบียน
                  </h7>

                </div>
                <div class="row px-4 mb-1" style="margin-top: -30px;">
                  <div class="col-6 col-md-4 col-lg-4 d-flex justify-content-center align-items-center">

                    <div class="avatar avatar-xl position-relative mb-2">

                      <span class="avatar avatar-xl">
                        <?php if (isset($get_appointment['ptd_img_type'])) { ?>
                          <img style="width:180px; height:180px;" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" src="data:image/<?php echo $get_appointment['ptd_img_type']; ?>;base64,<?php echo $get_appointment['ptd_img_code']; ?>" alt="">
                        <?php } else { ?>
                          <img style="width:180px; height:180px;" id="profileImage" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" src="<?php echo base_url(); ?>assets/img/default-person.png" alt="">
                        <?php } ?>
                      </span>
                    </div>
                  </div>
                  <div class="col-6 col-md-8 col-lg-8 mt-0 pt-0">
                    <div class="row">
                    <?php if (!empty($get_appointment)){ ?>
                      <div class="col-12">
                        <label for="idCard" class="fw-bold">1.1 ประเภทผู้ลงทะเบียน</label>
                        <div class=" mb-4 input-group-md">
                          <input class="form-check-input mt-2 opacity-0 position-absolute" type="radio" name="gridRadios" id="gridRadios1" value="old" <?php if (!empty($get_appointment)) {echo "disabled";} ?> <?= isset($get_appointment['apm_patient_type']) && $get_appointment['apm_patient_type'] == 'old' ? 'checked' : '' ?>>
                          <input class="form-check-input mt-2 opacity-0 position-absolute" type="radio" name="gridRadios" id="gridRadios2" value="new" <?php if (!empty($get_appointment)) {echo "disabled";} ?> <?= !isset($get_appointment['apm_patient_type']) || $get_appointment['apm_patient_type'] == 'new' ? 'checked' : '' ?>>
                          <input type="text" class="form-control font-20 fw-bold" style="border: 1px solid #FFF; background-color: #FFF; " id="gridRadios1" name="gridRadios" disabled value="<?php if($get_appointment['apm_patient_type'] == 'old'){ echo 'ผู้ป่วยเก่า'; } else { echo 'ผู้ป่วยใหม่'; } ?>">
                        </div>
                      </div>
                    <?php } ?>
                      <div class="col-12">
                        <label for="idCard" class="fw-bold">
                        <?php if (!empty($get_appointment)){ echo "1.2 เลขที่บัตรประจำตัวประชาชน/หนังสือเดินทาง/บัตรต่างด้าว"; } else { echo "2.1 เลขที่บัตรประจำตัวประชาชน/หนังสือเดินทาง/บัตรต่างด้าว "; } ?>
                        <?php if (!empty($get_appointment)) {echo "";} else {echo "<span class=' text-danger'>*</span>";} ?>
                        </label>
                        <div class=" mb-4 input-group-md">
                          <input type="text" class="form-control" id="idCard" 
                          style="
                          <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                          <?php } else { ?>
                          border: 1px solid #FFF; background-color: #FFF;
                          <?php } ?>" 
                          name="idCard" <?php if (!empty($get_appointment)) {echo "disabled";} ?> value="<?= $get_appointment['pt_identification'] ?? ''; ?>" placeholder="1209700000099" oninput="limitInputLength(this)" required>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="row px-4 mb-4">
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="prefix" class="fw-bold">
                    <?php if (!empty($get_appointment)){ echo "1.3 คำนำหน้าชื่อ"; } else { echo "2.2 คำนำหน้าชื่อ"; } ?>
                    <?php if (!empty($get_appointment)) {echo "";} else {echo "<span class=' text-danger'>*</span>";} ?>
                    </label>
                    <div class="mb-4 input-group-md">
                      <select class="form-select" id="prefix" name="prefix" value="" style="
                      <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <?php } else { ?>
                        border: 1px solid #FFF; background-color: #FFF;
                      <?php } ?>
                      " required <?php if (!empty($get_appointment)) {echo "disabled";} ?> >
                        <option selected="" disabled> - เลือกคำนำหน้าชื่อ - </option>
                        <?php foreach ($get_prefix as $pf) { ?>
                          <option value="<?php echo $pf['pf_name_abbr']; ?>" <?php echo (isset($get_appointment['pt_prefix']) && $get_appointment['pt_prefix'] == $pf['pf_name']) ? 'selected' : ''; ?>>
                            <?php echo $pf['pf_name_abbr']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="firstName" class=" fw-bold">
                    <?php if (!empty($get_appointment)){ echo "1.4 ชื่อ-นามสกุล"; } else { echo "2.3 ชื่อ"; } ?>
                    <?php if (!empty($get_appointment)) {echo "";} else {echo "<span class=' text-danger'>*</span>";} ?>
                    </label>
                    <div class="mb-4 input-group-md">
                      <input class="form-control" id="firstName" name="firstName" style="
                      <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <?php } else { ?>
                        border: 1px solid #FFF; background-color: #FFF;
                      <?php } ?>
                      " type="text" placeholder="จักษุ" <?php if (!empty($get_appointment)) {echo "disabled";} ?> value="<?= $get_appointment['pt_fname'] ?? ''; ?>" required>
                    </div>
                  </div>
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="lastName" class=" fw-bold">
                    <?php if (!empty($get_appointment)){ echo "1.5 นามสกุล"; } else { echo "2.4 นามสกุล"; } ?>
                    <?php if (!empty($get_appointment)) {echo "";} else {echo "<span class=' text-danger'>*</span>";} ?>
                    </label>
                    <div class=" mb-4 input-group-md">
                      <input class="form-control" id="lastName" name="lastName" style="
                      <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <?php } else { ?>
                        border: 1px solid #FFF; background-color: #FFF;
                      <?php } ?>
                      " type="text" placeholder="สุราษฎร์" <?php if (!empty($get_appointment)) {echo "disabled";} ?> value="<?= $get_appointment['pt_lname'] ?? ''; ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row px-4 mb-4">
                  <div class="col-6 col-md-4 col-lg-4">
                    <label for="phoneNumber" class=" fw-bold">
                    <?php if (!empty($get_appointment)){ echo "1.6 เบอร์โทรศัพท์"; } else { echo "2.5 เบอร์โทรศัพท์"; } ?>
                    <?php if (!empty($get_appointment)) {echo "";} else {echo "<span class=' text-danger'>*</span>";} ?>
                    </label>
                    <div class=" mb-4 input-group-md">
                      <input class="form-control" id="phoneNumber" name="phoneNumber" type="text"  style="
                      <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <?php } else { ?>
                        border: 1px solid #FFF; background-color: #FFF;
                      <?php } ?>
                      " maxlength="10" <?php if (!empty($get_appointment)) {echo "disabled";} ?> value="<?= $get_appointment['pt_tel'] ?? ''; ?>" placeholder="077276999" required>
                    </div>
                  </div>
                  <div class="col-6 col-md-8 col-lg-8">
                    <label for="email" class=" fw-bold">
                    <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <?php if (!empty($get_appointment)){ echo "1.7 อีเมล (ถ้ามี เอาไว้สำหรับแจ้งผลการนัดหมายแพทย์)"; } else { echo "2.6 อีเมล (ถ้ามี เอาไว้สำหรับแจ้งผลการนัดหมาย)"; } ?>
                    <?php } else { ?>
                      <?php if (!empty($get_appointment)){ echo "1.7 อีเมล (ถ้ามี เอาไว้สำหรับแจ้งผลการนัดพบแพทย์)"; }?>
                    <?php } ?>
                    </label>
                    <div class=" mb-4 input-group-md">
                      <input class="form-control font-18" id="email" name="email" type="email" value="<?= $get_appointment['pt_email'] ?? ''; ?>" placeholder="surateyehospital@gmail.com">
                    </div>
                  </div>
                  <!-- <div class="col-6 col-md-4 col-lg-4">
                    <label for="prefix" class="fw-bold">2.8 ช่องทางการติดต่อกลับ <span class=' text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select class="form-select" id="notification" name="notification" value="" required>
                        <option selected="" disabled> - เลือกช่องทางการติดต่อกลับ - </option>
                        <?php foreach ($get_base_noti as $noti) { ?>
                          <option value="<?php echo $noti['ntf_id']; ?>" <?php echo (isset($get_appointment['apm_ntf_id']) && $get_appointment['apm_ntf_id'] == $noti['ntf_id']) ? 'selected' : ''; ?>>
                            <?php echo $noti['ntf_name']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div> -->
                </div>

                <hr class="mb-5">
                <h5 class="mb-4 font-weight-600 font-20 ms-4">
                <?php if (empty($get_appointment)) { ?>
                  <i class="bi bi-3-circle-fill font-24 me-3" id="patientInfoIcon1"></i><?php } ?>
                  <?php if (!empty($get_appointment)) { ?>
                    <i class="bi bi-2-circle-fill font-24 me-3" ></i><?php } ?>
                    <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                     วันที่และเวลาที่ต้องการเข้ารับบริการ/นัดหมายแพทย์ <span class="text-danger">*</span> (กรุณาเลือกตามลำดับ)
                    <?php } else { ?>
                      วันที่ และเวลาที่ต้องการเข้ารับบริการ <span class="text-danger">*</span> (กรุณาเลือกตามลำดับ)
                    <?php } ?>
                </h5>
                <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                <p class=" text-primary fw-bold ms-4"> *** ในกรณีที่เลือกเวลาที่นัดหมายเรียบร้อยแล้ว แต่ต้องการเปลี่ยนสถานที่เข้ารับบริการ (รพ. จักษุสุราษฎร์ หรือคลินิกบรรยงจักษุ) ให้เลือกวันที่ และเวลาที่นัดหมายใหม่อีกครั้ง</p>
                <?php } ?>
                <div class="row mt-3 px-4">
                  <div class="col-6 col-md-4 col-lg-3">
                    <label for="apm_dp_id" class="fw-bold">
                    <?php if (!empty($get_appointment)){ echo "2.1 สถานที่ที่ต้องการเข้ารับบริการ"; } else { echo "3.1 สถานที่ที่ต้องการเข้ารับบริการ"; } ?>
                      <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select id="apm_dp_id" class="form-select select2" data-placeholder="-- กรุณาเลือกโรงพยาบาล หรือคลินิก --" name="apm_dp_id" required>
                        <option val=""></option>
                        <?php foreach ($get_department as $index => $dp) { ?>
                          <option value="<?php echo $dp['dp_id']; ?>" data-department="<?php echo $dp['dp_id']; ?>" <?php echo ($index == 0 || (isset($get_appointment['apm_dp_id']) && $get_appointment['apm_dp_id'] == $dp['dp_id'])) ? 'selected' : ''; ?>>
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

                  $current_date = new DateTime(); // สร้าง object ของวันที่ปัจจุบัน
                  $thai_date = isset($get_appointment['apm_date']) ? convert_to_thai_date($get_appointment['apm_date']) : convert_to_thai_date($current_date->format('Y-m-d'));
                  ?>
                  <div class="col-4 col-md-3 col-lg-3">
                    <label for="apm_date" class="fw-bold">
                    <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <?php if (!empty($get_appointment)){ echo "2.2 เลือกวันที่เข้ารับบริการ/นัดหมาย "; } else { echo "3.2 เลือกวันที่เข้ารับบริการ/นัดหมาย "; } ?>
                    <?php } else { ?>
                      <?php if (!empty($get_appointment)){ echo "2.2 เลือกวันที่เข้ารับบริการ "; } ?>
                    <?php } ?>
                      <span class='text-danger'>*</span></label>
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

                  $time_ranges = generate_time_ranges('8:30', '20:00', 30);
                  ?>
                  
                  <div class="col-4 col-md-3 col-lg-3">
                    <label for="apm_time" class="fw-bold">
                    <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <?php if (!empty($get_appointment)){ echo "2.3 เวลาที่เข้ารับบริการ/นัดหมาย"; } else { echo "3.3 เวลาที่เข้ารับบริการ/นัดหมาย"; } ?>
                      <?php } else { ?>
                        <?php if (!empty($get_appointment)){ echo "2.3 เวลาที่เข้ารับบริการ"; } ?>
                      <?php } ?>
                      <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select class="form-select select2" id="apm_time" data-placeholder="-- กรุณาเลือกเวลา --" name="apm_time" required>
                        <option val=""></option>
                        <?php if (isset($get_appointment['apm_time']) && $get_appointment['apm_time']) { ?>
                          <?php foreach ($time_ranges as $time) { ?>
                            <option value="<?= $time; ?>" <?= isset($get_appointment['apm_time']) && $get_appointment['apm_time'] == $time ? 'selected' : ''; ?>>
                              <?= $time; ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                </div>
                <hr class="">
                <h5 class="mb-4 font-weight-600 font-20 ms-4">
                  <?php if (empty($get_appointment)) { ?>
                    <i class="bi bi-4-circle-fill font-24 me-3" id="patientInfoIcon2"></i><?php } ?>
                  <?php if (!empty($get_appointment)) { ?>
                    <i class="bi bi-3-circle-fill font-24 me-3" ></i><?php } ?>
                  รายละเอียดอาการเบื้องต้นเกี่ยวกับโรค
                </h5>
                <div class="row mt-3 px-4">
                  <div class="col-6 col-md-4 col-lg-3">
                    <label for="apm_stde_id" class="fw-bold">
                      <?php if (!empty($get_appointment)){ echo "3.1 แผนก "; } else { echo "4.1 แผนก "; } ?>
                      <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select id="apm_stde_id" class="form-select select2" data-placeholder="-- กรุณาเลือกแผนก --" name="apm_stde_id" required>
                        <option val=""></option>
                        <?php foreach ($get_structure_detail as $key => $sd) { ?>
                          <option value="<?php echo $sd['stde_id']; ?>" data-department='<?php echo $sd['stde_id']; ?>' <?php echo isset($get_appointment['apm_stde_id']) && $get_appointment['apm_stde_id'] == $sd['stde_id'] ? 'selected' : ''; ?>>
                            <?php echo $sd['stde_name_th']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 col-md-4 col-lg-3">
                    <label for="apm_ds_id" class="fw-bold">
                      
                      <?php if (!empty($get_appointment)){ echo "3.2 โรคของผู้ป่วย"; } else { echo "4.2 โรคของผู้ป่วย"; } ?>
                      <span class='text-danger'>*</span></label>
                    <div class="mb-4 input-group-md">
                      <select id="apm_ds_id" class="form-select select2" data-placeholder="-- กรุณาเลือกชื่อโรค --" name="apm_ds_id" required>
                        <option val=""></option>
                        <option value="0" data-department="0">ไม่ทราบ</option>
                        <?php foreach ($get_disease_dp as $key => $dis) { ?>
                          <option value="<?php echo $dis['ds_id']; ?>" data-department='<?php echo $dis['ds_id']; ?>' <?php echo isset($get_appointment['apm_ds_id']) && $get_appointment['apm_ds_id'] == $dis['ds_id'] ? 'selected' : ''; ?>>
                            <?php echo $dis['ds_name_disease']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-12 col-lg-9">
                    <label for="" class="fw-bold mb-2">
                      
                      <?php if (!empty($get_appointment)){ echo "3.3 ระบุสาเหตุ และ/หรืออาการเบื้องต้น"; } else { echo "4.3 ระบุสาเหตุ และ/หรืออาการเบื้องต้น"; } ?>
                    </label>
                    <textarea id="apm_cause" class="tinymce-editor" name="apm_cause"><?= isset($get_appointment['apm_cause']) ? htmlspecialchars($get_appointment['apm_cause']) : ''; ?></textarea>
                  </div>
                </div>
                <hr class="mt-3 mb-5">
                
                <h5 class="mb-4 font-weight-600 font-20 ms-4">
                <?php if (empty($get_appointment)) { ?>
                    <i class="bi bi-5-circle-fill font-24 me-3" id="patientInfoIcon3"></i><?php } ?>
                  <?php if (!empty($get_appointment)) { ?>
                    <i class="bi bi-4-circle-fill font-24 me-3" ></i><?php } ?>
                    <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                    ระบุแพทย์ที่ต้องการนัดหมาย
                    <?php } else { ?>
                    ระบุแพทย์ที่ต้องการเข้าพบ
                    <?php } ?>
                </h5>

                <div class="row px-4">
                  <div class="col-12 col-md-9 col-lg-9">
                    <label for="med" class="fw-bold">
                    <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <?php if (!empty($get_appointment)){ echo "4.1 เลือกแพทย์ที่ผู้ป่วยต้องการนัดหมาย "; } else { echo "5.1 เลือกแพทย์ที่ผู้ป่วยต้องการนัดหมาย "; } ?>
                    <?php } else { ?>
                      <?php if (!empty($get_appointment)){ echo "4.1 เลือกแพทย์ที่ผู้ลงทะเบียนต้องการเข้าพบ "; }?>
                    <?php } ?>
                      <span class=' text-danger'>*</span></label>
                      <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                      <p class=" text-primary fw-bold ps-4"> *** รายชื่อแพทย์จะแสดงตามวันที่และเวลาที่แพทย์ทำการออกตรวจ ตามตารางเวรแพย์ </p>
                    <?php } else { ?>
                      <p class=" text-primary fw-bold ps-4"></p>
                    <?php } ?>
                    <div class="mb-4 input-group-md">
                      <select id="apm_ps_id" class="form-select select2" data-placeholder="-- กรุณาเลือกแพทย์ --" name="apm_ps_id" required>
                        <option value="0">ไม่ต้องการระบุแพทย์</option>
                        <?php foreach ($get_doctors as $doctor) { ?>
                          <option value="<?php echo $doctor['ps_id']; ?>" <?php echo isset($get_appointment['apm_ps_id']) && $get_appointment['apm_ps_id'] == $doctor['ps_id'] ? 'selected' : ''; ?>>
                            <?php echo $doctor['pf_name_abbr'] . '' . $doctor['ps_fname'] . ' ' . $doctor['ps_lname']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 col-md-8 col-lg-8 d-flex align-items-end">

                  </div>
                </div>
                 <!-- <div class="row px-4">
                  <div class="col-6 col-md-6 col-lg-6">
                    <label for="" class="fw-bold mb-2">ระบุสาเหตุที่นัดหมายแพทย์</label>
                    <textarea id="apm_need" class="tinymce-editor" name="apm_need"><?= isset($get_appointment['apm_need']) ? htmlspecialchars($get_appointment['apm_need']) : ''; ?></textarea>
                  </div>
                </div>  -->
              </div>
              <div class="row mt-1 mb-4">
                <div class="col-12 col-md-12 col-lg-11">
                  <?php if (!isset($get_appointment['apm_app_walk']) || $get_appointment['apm_app_walk'] == 'A' || $get_appointment['apm_app_walk'] == '') { ?>
                    <button type="button" class="btn btn-success float-end btn-lg" onclick="saveFormData()"><i class="bi bi-floppy2-fill"></i> บันทึกการลงทะเบียนผู้ป่วย </button>
                  <?php } else { ?>
                    <button type="button" class="btn btn-success float-end btn-lg" onclick="saveFormData_api()"><i class="bi bi-floppy2-fill"></i> บันทึกการพบแพทย์ </button>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>
<div class="spinner-wrapper" id="spinnerWrapper">
  <div class="spinner-border" role="status">
  </div>
  <span class="">Loading...</span>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const gridRadios1 = document.getElementById('gridRadios1');
    const gridRadios2 = document.getElementById('gridRadios2');
    const dynamicContent = document.getElementById('dynamicContent');
    const patientInfoIcon = document.getElementById('patientInfoIcon');
    const patientInfoIcon1 = document.getElementById('patientInfoIcon1');
    // const patientInfoIcon2 = document.getElementById('patientInfoIcon2');
    // const patientInfoIcon3 = document.getElementById('patientInfoIcon3');

    function updateDynamicContent() {
      if (gridRadios1.checked) {
        dynamicContent.classList.remove('d-none');
        patientInfoIcon.classList.remove('bi-2-circle-fill');
        patientInfoIcon.classList.add('bi-3-circle-fill');
        patientInfoIcon1.classList.remove('bi-3-circle-fill');
        patientInfoIcon1.classList.add('bi-4-circle-fill');
        // patientInfoIcon2.classList.remove('bi-4-circle-fill');
        // patientInfoIcon2.classList.add('bi-5-circle-fill');
        // patientInfoIcon3.classList.remove('bi-5-circle-fill');
        // patientInfoIcon3.classList.add('bi-6-circle-fill');
      } else if (gridRadios2.checked) {
        dynamicContent.classList.add('d-none');
        patientInfoIcon.classList.remove('bi-3-circle-fill');
        patientInfoIcon.classList.add('bi-2-circle-fill');
        patientInfoIcon1.classList.remove('bi-4-circle-fill');
        patientInfoIcon1.classList.add('bi-3-circle-fill');
        // patientInfoIcon2.classList.remove('bi-5-circle-fill');
        // patientInfoIcon2.classList.add('bi-4-circle-fill');
        // patientInfoIcon3.classList.remove('bi-6-circle-fill');
        // patientInfoIcon3.classList.add('bi-5-circle-fill');
      }
    }

    gridRadios1.addEventListener('change', updateDynamicContent);
    gridRadios2.addEventListener('change', updateDynamicContent);

    // Initial check
    updateDynamicContent();
  });
  $(document).ready(function() {
    var table;
    $('#checkPatient').on('click', function() {
      // Show the modal
      $('#detailsHRMCard').modal('show');
    });
    $('#search').on('click', function() {
      // Show the modal
      $('#detailsHRMCard').modal('show');
      $('#dataTable').removeClass('d-none');
      // Initialize or reinitialize DataTable
      if (!$.fn.DataTable.isDataTable('#dataTable')) {
        table = $('#dataTable').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
            "url": "<?php echo site_url('que/Appointment/get_patient'); ?>",
            "type": "POST",
            "data": function(d) {
              // Include the search value
              d.patientName = $('#patient-name').val();
              if (!d.patientName) {
                return false; // Abort the Ajax request if no search value
              }
            },
            "dataSrc": function(json) {
              // If no data is returned, return an empty array to prevent showing old data
              if (!json.data || json.data.length === 0) {
                return [];
              }
              return json.data;
            }
          },
          "columns": [{
              "data": "row_number",
              "orderable": false
            },
            {
              "data" : "pt_identification"
            },
            {
              "data": "pt_prefix"
            },
            {
              "data": "pt_fname"
            },
            {
              "data": "pt_lname"
            },
            {
              "data" : "pt_tel"
            },
            {
              "data" : "pt_email"
            },
            {
              "data": "pt_id",
              "render": function(data, type, row, meta) {
                return `
                            <div class="text-center">
                                <button class="btn btn-success checkButton_patient" title="เลือกผู้ป่วย" data-pt="${data}">
                                <i class="bi bi-symmetry-horizontal"></i>
                                </button>
                            </div>`;
              }
            }
          ],
          "order": [
            [4, 'asc']
          ], // Order by the pt_id column, index 4
          "language": {
            decimal: "",
            emptyTable: "ไม่พบรายการ กรุณาค้นหาข้อมูลชื่อผู้ป่วย",
            info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
            infoFiltered: "(filtered from _MAX_ total entries)",
            lengthMenu: "_MENU_",
            loadingRecords: "Loading...",
            processing: "",
            search: "",
            searchPlaceholder: 'ค้นหา...',
            zeroRecords: "ไม่พบรายการ",
            paginate: {
              first: "«",
              last: "»",
              next: "›",
              previous: "‹"
            },
            aria: {
              orderable: "Order by this column",
              orderableReverse: "Reverse order this column"
            }
          },
          "dom": 'lfrtip',
          "buttons": [{
              extend: 'print',
              text: '<i class="bi-file-earmark-fill"></i> Print',
              titleAttr: 'Print',
              title: 'รายการข้อมูล'
            },
            {
              extend: 'excel',
              text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
              titleAttr: 'Excel',
              title: 'รายการข้อมูล'
            },
            {
              extend: 'pdf',
              text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
              titleAttr: 'PDF',
              title: 'รายการข้อมูล',
              customize: function(doc) {
                doc.defaultStyle = {
                  font: 'THSarabun'
                };
              }
            }
          ],
          "initComplete": function() {
            var api = this.api();
            api.on('draw', function() {
              if (api.rows({
                  filter: 'applied'
                }).data().length === 0) {
                $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ กรุณาค้นหาข้อมูลชื่อผู้ป่วย</td></tr>');
              }
            });
          }
        });
      } else {
        table.ajax.reload();
      }
    });

    // Handle the search button click
    $('#search').on('click', function() {
      if ($.fn.DataTable.isDataTable('#dataTable')) {
        table.ajax.reload();
      }
    });

    // Use event delegation for dynamically generated elements
    $('#dataTable').on('click', '.checkButton_patient', function() {
      var pt_id = $(this).data('pt');
      $.ajax({
        url: '<?php echo site_url('que/Appointment/check_patient'); ?>',
        type: 'POST',
        data: {
          pt_id: pt_id
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (data.exists) {
            Swal.fire({
              title: 'พบข้อมูลผู้ป่วยในระบบ',
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
            if (data.ptd_img_code && data.ptd_img_type) {
              var imageSrc = 'data:image/' + data.ptd_img_type + ';base64,' + data.ptd_img_code;
              $('#profileImage').attr('src', imageSrc);
            }

            // Check the "old patient" radio button
            $('#gridRadios1').prop('checked', true);
            $('#detailsHRMCard').modal('hide');
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
              title: 'ไม่พบข้อมูลผู้ป่วยในระบบ',
              html: 'ไม่มีชื่ออยู่ในระบบ <br>ถ้าไม่ทราบสามารถดำเนินการกรอกข้อที่ 2 ข้อมูลผู้ป่วยได้',
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
  });

  function goBack() {


    window.location.href = '<?php echo site_url("que/Triage/"); ?>';

  }
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
      var dpId = $('#apm_dp_id').val();
      var apmDate = $('#apm_date').val();
      if (dpId && selectedDate) {
        var dayName = selectedDate.toLocaleString('th-TH', {
          weekday: 'long'
        });
        fetchTimes(dpId, dayName, apmDate);
      }
    }
    // Call updateAvailableTimes with the current date on page load
    $(document).ready(function() {
      var currentDate = new Date(); // Get the current date
      updateAvailableTimes(currentDate); // Update available times for the current date
    });

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
    $('#apm_dp_id').change(function() {
      resetDateTimeSelection(); // Reset date and time selection
      updateAvailableTimes(); // Call updateAvailableTimes function on change
    });

    function fetchTimes(dpId, dayName, apmDate) {
      $.ajax({
        url: '<?php echo site_url('que/Appointment/check_time_dpid'); ?>',
        type: 'POST',
        data: {
          dp_id: dpId,
          day_name: dayName,
          apm_date: apmDate
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
      $('#apm_time').empty(); // Clear options in time range select

    }

    function updateTimeOptions(error, dateName, period_1, startTime_1, endTime_1, period_2, startTime_2, endTime_2) {
    var select = $('#apm_time');
    select.empty(); // Clear existing options

    if (error) {
        select.append(new Option(error));
        return;
    }

    var startParts_1 = startTime_1.split(':');
    var endParts_1 = endTime_1.split(':');
    var startParts_2 = startTime_2.split(':');
    var endParts_2 = endTime_2.split(':');

    var dateString = $('.datepicker_th').val();
    var selectedDateParts = dateString.split('/');
    var selectedYear = parseInt(selectedDateParts[2], 10) - 543;
    var selectedMonth = selectedDateParts[1].padStart(2, '0');
    var selectedDay = selectedDateParts[0].padStart(2, '0');
    var selectedDateFormatted = selectedYear + '-' + selectedMonth + '-' + selectedDay;

    var currentDate = new Date();
    var formattedCurrentDate = currentDate.toISOString().split('T')[0];

    var start_1 = new Date(selectedYear, selectedMonth - 1, selectedDay, parseInt(startParts_1[0]), parseInt(startParts_1[1]), 0);
    var end_1 = new Date(selectedYear, selectedMonth - 1, selectedDay, parseInt(endParts_1[0]), parseInt(endParts_1[1]), 0);
    
    if (period_1 != 'เต็มวัน') {
        var start_2 = new Date(selectedYear, selectedMonth - 1, selectedDay, parseInt(startParts_2[0]), parseInt(startParts_2[1]), 0);
        var end_2 = new Date(selectedYear, selectedMonth - 1, selectedDay, parseInt(endParts_2[0]), parseInt(endParts_2[1]), 0);
    }

    // Loop through time slots for period_1
    for (var time_1 = start_1; time_1 < end_1; time_1.setMinutes(time_1.getMinutes() + 30)) {
        var optionText_1 = formatThaiTime_1(time_1) + ' - ' + formatThaiTime_1(new Date(time_1.getTime() + 30 * 60000));
        var optionValue_1 = formatThaiTime_1(time_1) + ' - ' + formatThaiTime_1(new Date(time_1.getTime() + 30 * 60000));
        var isSelected = optionValue_1 === '<?php echo !empty($get_appointment["apm_time"]) ? $get_appointment["apm_time"] : ""; ?>' && selectedDateFormatted === formattedCurrentDate;
        select.append(new Option(optionText_1, optionValue_1, false, isSelected));
    }

    // Loop through time slots for period_2 if it exists
    if (period_1 != 'เต็มวัน') {
        for (var time_2 = start_2; time_2 < end_2; time_2.setMinutes(time_2.getMinutes() + 30)) {
            var optionText_2 = formatThaiTime_2(time_2) + ' - ' + formatThaiTime_2(new Date(time_2.getTime() + 30 * 60000));
            var optionValue_2 = formatThaiTime_2(time_2) + ' - ' + formatThaiTime_2(new Date(time_2.getTime() + 30 * 60000));
            var isSelected = optionValue_2 === '<?php echo !empty($get_appointment["apm_time"]) ? $get_appointment["apm_time"] : ""; ?>' && selectedDateFormatted === formattedCurrentDate;
            select.append(new Option(optionText_2, optionValue_2, false, isSelected));
        }
    }

    // Add the final option from end_1 to 23:59
    var finalOptionText = formatThaiTime_1(end_1) + ' - 23:59';
    var finalOptionValue = formatThaiTime_1(end_1) + ' - 23:59';
    var isFinalSelected = finalOptionValue === '<?php echo !empty($get_appointment["apm_time"]) ? $get_appointment["apm_time"] : ""; ?>' && selectedDateFormatted === formattedCurrentDate;
    select.append(new Option(finalOptionText, finalOptionValue, false, isFinalSelected));
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
    $('#checkButton_patient').click(function() {
      var pt_id = $(this).data('pt');
      $.ajax({
        url: '<?php echo site_url('que/Appointment/check_patient'); ?>',
        type: 'POST',
        data: {
          pt_id: pt_id
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
            if (data.ptd_img_code && data.ptd_img_type) {
              var imageSrc = 'data:image/' + data.ptd_img_type + ';base64,' + data.ptd_img_code;
              $('#profileImage').attr('src', imageSrc);
            }

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
            if (data.ptd_img_code && data.ptd_img_type) {
              var imageSrc = 'data:image/' + data.ptd_img_type + ';base64,' + data.ptd_img_code;
              $('#profileImage').attr('src', imageSrc);
            }

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
            if (data.ptd_img_code && data.ptd_img_type) {
              var imageSrc = 'data:image/' + data.ptd_img_type + ';base64,' + data.ptd_img_code;
              $('#profileImage').attr('src', imageSrc);
            }

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
      const doctorSelect = $('#apm_ps_id');

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
                Swal.close(); // Close the SweetAlert2 dialog manually
              } else if (result.dismiss === Swal.DismissReason.cancel) {
                fetchDoctors(null, true);
                Swal.close(); // Close the SweetAlert2 dialog manually
              }
            });
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

    // Function to fetch diseases based on department
    function fetchDiseases(departmentId) {
      const diseaseSelect = $('#apm_ds_id');

      // Clear previous options
      diseaseSelect.html('<option selected disabled>เลือกชื่อโรค</option><option value="0" data-department="0">ไม่ทราบ</option>');

      // Make AJAX request to fetch diseases
      $.ajax({
        url: '<?php echo site_url('que/appointment/get_diseases'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          stde_id: departmentId
        },
        success: function(data) {
          // Populate the disease select with received data
          $.each(data, function(index, disease) {
            diseaseSelect.append($('<option>', {
              value: disease.ds_id,
              text: disease.ds_name_disease,
              'data-department': disease.ds_stde_id
            }));
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error fetching diseases:', textStatus, errorThrown);
        }
      });
    }

    // Event listener for department change
    $('#apm_stde_id').change(function() {
      const selectedDepartment = $(this).val();
      fetchDoctors(selectedDepartment);
      fetchDiseases(selectedDepartment);
    });

    // Event listener for Show All Doctors button in SweetAlert2
    $(document).on('click', '.swal2-cancel', function() {
      fetchDoctors(null, true);
      Swal.close(); // Close the SweetAlert2 dialog manually
    });
  });


  function validateFormData(formData) {
    let isValid = true;
    // const requiredFields = ['idCard', 'prefix', 'firstName', 'lastName', 'phoneNumber','notification', 'email', 'gridRadios', 'apm_dp_id', 'apm_date', 'apm_time', 'apm_ds_id', 'apm_stde_id', 'apm_ps_id'];
    const requiredFields = ['idCard', 'prefix', 'firstName', 'lastName', 'phoneNumber', 'email', 'gridRadios', 'apm_dp_id', 'apm_date', 'apm_time', 'apm_ds_id', 'apm_stde_id', 'apm_ps_id'];
    // const requiredFields = ['idCard', 'prefix', 'firstName', 'lastName', 'phoneNumber', 'email', 'gridRadios', 'apm_dp_id', 'apm_date', 'apm_time'];
    requiredFields.forEach(field => {
      const value = formData[field];
      const element = document.getElementById(field);
      if (!value || value.trim() === '') {
        isValid = false;
        if (element) {
          element.classList.add('is-invalid');
        }

        var select2_errors = [...document.querySelectorAll('select[name="' + field + '"] + .select2-container')];
        select2_errors.forEach(sl_er => {
          var child = sl_er.children;
          child = child[0].children[0];
          child.classList.add('is-invalid');
        });

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
    gridRadios: $('input[name="gridRadios"]:checked').val(),
    apm_dp_id: $('#apm_dp_id').val(),
    apm_date: $('#apm_date').val(),
    apm_time: $('#apm_time').val(),
    apm_ds_id: $('#apm_ds_id').val(),
    apm_stde_id: $('#apm_stde_id').val(),
    apm_cause: tinymce.get('apm_cause').getContent(),
    apm_ps_id: $('#apm_ps_id').val(),
    appointment_id: $('#appointment_id').val()
  };

  if (!validateFormData(formData)) {
    Swal.fire({
      title: 'ข้อผิดพลาด',
      text: 'กรุณากรอกข้อมูลในทุกช่องที่ขึ้น * (สีแดง)',
      icon: 'error',
      confirmButtonText: 'ตกลง'
    });
    return;
  }

  // แสดงหน้าต่างยืนยันก่อนบันทึกข้อมูล
  let patientType = formData.gridRadios === 'old' ? 'ผู้ป่วยเก่า' : 'ผู้ป่วยใหม่';
  // ดึงชื่อแผนกจากตัวเลือกที่ถูกเลือก
  let departmentName = $('#apm_stde_id option:selected').text();
  let DoctorName = $('#apm_ps_id option:selected').text();
  let ds_id = $('#apm_ds_id option:selected').text();
  Swal.fire({
    title: 'ตรวจสอบข้อมูลการลงทะเบียนผู้ป่วย',
    html: `
    <div class="row">
        <div class="col-5 text-right">
          <strong>เลขบัตรประชาชน/หนังสือเดินทาง/บัตรต่างด้าว:</strong>
        </div>
        <div class="col-7" style='text-align: left;'>
          ${formData.idCard}
        </div>
        <div class="col-5 text-right">
          <strong>ประเภทผู้ลงทะเบียน:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${patientType}
        </div>
        <div class="col-5 text-right">
          <strong>ชื่อ-นามสกุลผู้ลงทะเบียน:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.prefix}${formData.firstName} ${formData.lastName}
        </div>
        <div class="col-5 text-right">
          <strong>เบอร์โทร:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.phoneNumber}
        </div>
        <div class="col-5 text-right">
          <strong>อีเมล:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.email}
        </div>
        <div class="col-5 text-right">
          <strong>แผนก:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${departmentName} (${ds_id})
        </div>
        <div class="col-5 text-right">
          <strong>แพทย์ที่นัดหมาย:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${DoctorName}
        </div>
        <div class="col-5 text-right">
          <strong>วันที่นัดหมาย:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.apm_date}
        </div>
        <div class="col-5 text-right">
          <strong>เวลาที่นัดหมาย:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.apm_time}
        </div>
    </div>
    `,
    icon: 'success',
    showCancelButton: true,
    confirmButtonText: 'ยืนยันการลงทะเบียนผู้ป่วย',
    cancelButtonText: 'ยกเลิก',
    customClass: {
      popup: 'swal2-large',  // กำหนดคลาสชื่อ swal2-large เพื่อควบคุมขนาด
      htmlContainer: 'swal2-html-line-height'
    },
  }).then((result) => {
    if (result.isConfirmed) {
      // หากผู้ใช้กดยืนยัน ให้บันทึกข้อมูลลงฐานข้อมูล
      $.ajax({
        url: '<?php echo site_url("que/Triage/insert_appointment") ?>',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
          var data = JSON.parse(response);
          if (data.message == 'created' || data.message == 'updated') {
            $('#appointment_id').val(data.appointment_id);
          }
          Swal.fire({
            title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
            text: 'ข้อมูลของท่านได้รับการบันทึกเรียบร้อยแล้ว',
            icon: 'success',
            timer: 2000,  // แสดงข้อความ 2 วินาที (2000 มิลลิวินาที)
            showConfirmButton: false,
            customClass: {
              htmlContainer: 'swal2-html-line-height'
            }
          }).then(() => {
            window.location.href = '<?php echo site_url("que/Triage"); ?>';
          });
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
  });
}



function saveFormData_api() {
  tinymce.triggerSave();

  var formData = {
    idCard: $('#idCard').val(),
    prefix: $('#prefix').val(),
    firstName: $('#firstName').val(),
    lastName: $('#lastName').val(),
    phoneNumber: $('#phoneNumber').val(),
    email: $('#email').val(),
    gridRadios: $('input[name="gridRadios"]:checked').val(),
    apm_dp_id: $('#apm_dp_id').val(),
    apm_date: $('#apm_date').val(),
    apm_time: $('#apm_time').val(),
    apm_ds_id: $('#apm_ds_id').val(),
    apm_stde_id: $('#apm_stde_id').val(),
    apm_cause: tinymce.get('apm_cause').getContent(),
    apm_ps_id: $('#apm_ps_id').val(),
    appointment_id: $('#appointment_id').val()
  };

  if (!validateFormData(formData)) {
    Swal.fire({
      title: 'ข้อผิดพลาด',
      text: 'กรุณากรอกข้อมูลในทุกช่องที่ขึ้น * (สีแดง)',
      icon: 'error',
      confirmButtonText: 'ตกลง'
    });
    return;
  }

  // แสดงหน้าต่างยืนยันก่อนบันทึกข้อมูล
  let patientType = formData.gridRadios === 'old' ? 'ผู้ป่วยเก่า' : 'ผู้ป่วยใหม่';
  // ดึงชื่อแผนกจากตัวเลือกที่ถูกเลือก
  let departmentName = $('#apm_stde_id option:selected').text();
  let DoctorName = $('#apm_ps_id option:selected').text();
  let ds_id = $('#apm_ds_id option:selected').text();
  Swal.fire({
    title: 'ตรวจสอบข้อมูลการลงทะเบียนผู้ป่วย',
    html: `
    <div class="row">
        <div class="col-5 text-right">
          <strong>เลขบัตรประชาชน/หนังสือเดินทาง/บัตรต่างด้าว:</strong>
        </div>
        <div class="col-7" style='text-align: left;'>
          ${formData.idCard}
        </div>
        <div class="col-5 text-right">
          <strong>ประเภทผู้ลงทะเบียน:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${patientType}
        </div>
        <div class="col-5 text-right">
          <strong>ชื่อ-นามสกุลผู้ลงทะเบียน:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.prefix}${formData.firstName} ${formData.lastName}
        </div>
        <div class="col-5 text-right">
          <strong>เบอร์โทร:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.phoneNumber}
        </div>
        <div class="col-5 text-right">
          <strong>อีเมล:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.email}
        </div>
        <div class="col-5 text-right">
          <strong>แผนก:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${departmentName} (${ds_id})
        </div>
        <div class="col-5 text-right">
          <strong>แพทย์ที่นัดหมาย:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${DoctorName}
        </div>
        <div class="col-5 text-right">
          <strong>วันที่นัดหมาย:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.apm_date}
        </div>
        <div class="col-5 text-right">
          <strong>เวลาที่นัดหมาย:</strong>
        </div>
        <div class="col-7 "  style='text-align: left;'>
          ${formData.apm_time}
        </div>
    </div>
    `,
    icon: 'success',
    showCancelButton: true,
    confirmButtonText: 'ยืนยันการลงทะเบียนผู้ป่วย',
    cancelButtonText: 'ยกเลิก',
    customClass: {
      popup: 'swal2-large',  // กำหนดคลาสชื่อ swal2-large เพื่อควบคุมขนาด
      htmlContainer: 'swal2-html-line-height'
    },
  }).then((result) => {
    if (result.isConfirmed) {
      // หากผู้ใช้กดยืนยัน ให้บันทึกข้อมูลลงฐานข้อมูล
      $.ajax({
        url: '<?php echo site_url("que/Triage/insert_appointment_api") ?>',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
          var data = JSON.parse(response);
          if (data.message == 'created' || data.message == 'updated') {
            $('#appointment_id').val(data.appointment_id);
          }
          Swal.fire({
            title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
            text: 'ข้อมูลของท่านได้รับการบันทึกเรียบร้อยแล้ว',
            icon: 'success',
            timer: 2000,  // แสดงข้อความ 2 วินาที (2000 มิลลิวินาที)
            showConfirmButton: false,
            customClass: {
              htmlContainer: 'swal2-html-line-height'
            }
          }).then(() => {
            window.location.href = '<?php echo site_url("que/Triage"); ?>';
          });
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
  });
}


  function goToStep2(appointment_id) {
    window.location.href = '<?php echo site_url("que/Appointment/add_appointment_step2/") ?>' + '/' + appointment_id;
    // }
  }
</script>