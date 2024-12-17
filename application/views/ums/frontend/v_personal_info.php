<style>.status_request { margin-top: -15px; color: #198754; } </style>
<style>.reason_request { margin-top: -15px; color: #723924; } </style>
<style>
  @media (max-width: 600px) {
    #patientStatusSection {
      margin-top: -100px;
      zoom: 130%;
      width: 108%;
      margin-left: -14px;
    }
    #patientStatusSection .row.g-4 {
      margin-top: -30px;
    }
    #patientStatusSection .col-md-4 {
      margin-top: 0px;
    }
    #patientStatusSection h5.mb-0 {
      padding-left: 13px;
    }
  }
</style>
<div id="patientStatusSection">
<h1 class="h3 mb-0 ">ข้อมูลผู้ป่วย</h1>
<div class="card-header bg-transparent border-bottom p-0 pb-0 mt-4 "></div>
    <div class="card-body pt-3 px-0 pb-2">
      <div class="row g-4">
        <input type="hidden" id="pt_id_img" value="<?php echo complex_base64_encode($user->pt_id); ?>">
        <?php if ($this->session->userdata('us_id')) { ?>
          <div class="col-8">
            <label class="form-label">รูปภาพ <span class=" text-muted">(ขนาด 126 * 126px) ไฟล์รูปภาพต้องไม่เกิน 2 MB</span></label>
            <div class="d-flex align-items-center">
              <label class="position-relative me-2" title="Replace this pic">
                <span class="avatar avatar-xl">
                  <?php if ($user->ptd_img) { ?>
                    <img style="width:126px; height:126px;" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" src="data:image/<?php echo $user->ptd_img_type; ?>;base64,<?php echo $user->ptd_img_code; ?>" alt="">
                  <?php } else { ?>
                    <img style="width:126px; height:126px;" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" src="<?php echo base_url(); ?>assets/img/default-person.png" alt="">
                  <?php } ?>
                </span>
              </label>
              <label class="position-relative me-3" title="Replace this pic" style="top:-60px; right:10px;">
                <button id="removeImage" type="button" class="uploadremove"><i class="bi bi-x text-white"></i></button>
              </label>
              <label class="btn btn-sm btn-primary mb-0" id="changeImageBtn">อัปรูปภาพ / เปลี่ยนรูปภาพ</label>
              <input class="form-control d-none" type="file" id="uploadImage">
            </div>
          </div>
        <?php } else { ?>
          <div class="col-8">
            <button id="removeImage" type="button" class="uploadremove d-none"><i class="bi bi-x text-white"></i></button>
            <label class="btn btn-sm btn-primary mb-0 d-none" id="changeImageBtn">อัปรูปภาพ / เปลี่ยนรูปภาพ</label>
            <input class="form-control d-none" type="file" id="uploadImage">
          </div>
        <?php } ?>
        <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
          <div class="col-4" style="border: 1px solid #009688;border-radius: 10px;padding: 10px;box-shadow: 0 0px 5px rgb(0 150 136 / 54%) !important;">
            <label class="form-label">สถานะผู้ลงทะเบียน</label>
            <select class="form-select" name="pt_sta_id" id="pt_sta_id">
              <?php foreach ($base_patient_status as $psta) { ?>
                <option value="<?php echo $psta['sta_id']; ?>" <?php if ($user->pt_sta_id == $psta['sta_id']) {
                                                                  echo 'selected';
                                                                } ?>><?php echo $psta['sta_name']; ?></option>
              <?php } ?>
            </select> 
              <input type="hidden" name="user_requests_1_id" value="<?php echo isset($user_requests_1) ? $user_requests_1->id : ''; ?>">
              <input type="hidden" name="user_requests_2_id" value="<?php echo isset($user_requests_2) ? $user_requests_2->id : ''; ?>">
              <input type="hidden" name="user_requests_3_id" value="<?php echo isset($user_requests_3) ? $user_requests_3->id : ''; ?>">
          </div>
        <?php } else { ?>
          <div class="col-4"></div>
        <?php } ?>

        <div class="col-md-4">
          <label class="form-label">HN</label>
          <div class="input-group-md">
            <input type="text" name="pt_member" id="pt_member" class="form-control" value="<?php echo $user->pt_member; ?>" disabled style="cursor: not-allowed;">
            <input type="hidden" name="pt_id" id='pt_id' value="<?php echo $user->pt_id; ?>" />
          </div>
        </div>
        <?php if ($user->pt_identification) { ?>
          <div class="col-md-4 pt-sm-0">
            <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
            <div class="input-group-md">
              <input type="text" name="pt_identification" id="pt_identification" class="form-control" value="<?php echo $user->pt_identification; ?>" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                        echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                      } ?>>
              <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_identification) && $user->pt_identification != $user_requests_1->pt_identification) { ?>
                <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_identification">
                <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_identification; ?></p>
                <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                  <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_identification; ?>','pt_identification')">ยืนยัน</button>
                  <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_identification; ?>','pt_identification')">ไม่ยืนยัน</button>
                <?php } ?>
                </div>
                <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_identification"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_identification"></div>
              <?php } ?>
            </div>
          </div>
        <?php } else if ($user->pt_passport) { ?>
          <div class="col-md-4">
            <label class="form-label">เลขพาสปอร์ต</label>
            <div class="input-group-md">
              <input type="text" name="pt_passport" id="pt_passport" class="form-control" value="<?php echo $user->pt_passport; ?>" placeholder="" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                      echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                    } ?>>
              <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_passport) && $user->pt_passport != $user_requests_1->pt_passport) { ?>
                <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_passport">
                <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_passport; ?></p>
                <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                  <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_passport; ?>','pt_passport')">ยืนยัน</button>
                  <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_passport; ?>','pt_passport')">ไม่ยืนยัน</button>
                <?php } ?>
                </div>
                <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_passport"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_passport"></div>
              <?php } ?>
            </div>
          </div>
        <?php } else if ($user->pt_peregrine) { ?>
          <div class="col-md-4">
            <label class="form-label">เลขบัตรต่างด้าว</label>
            <div class="input-group-md">
              <input type="text" name="pt_peregrine" id="pt_peregrine" class="form-control" value="<?php echo $user->pt_peregrine; ?>" placeholder="" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                        echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                      } ?>>
              <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_peregrine) && $user->pt_peregrine != $user_requests_1->pt_peregrine) { ?>
                <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_peregrine">
                <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_peregrine; ?></p>
                <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                  <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_peregrine; ?>','pt_peregrine')">ยืนยัน</button>
                  <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_peregrine; ?>','pt_peregrine')">ไม่ยืนยัน</button>
                <?php } ?>
                </div>
                <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_peregrine"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_peregrine"></div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>

        <div class="col-md-4">
          <label class="form-label">สิทธิ์การรักษา</label>
          <div class="input-group-md">
            <input type="text" name="ptd_rightname" id="ptd_rightname" class="form-control" value="<?php echo $user->ptd_rightname; ?>" placeholder="ชำระเงินสด" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                                    echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                                  } ?>>
            <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->ptd_rightname) && $user->ptd_rightname != $user_requests_1->ptd_rightname) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_rightname">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->ptd_rightname; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->ptd_rightname; ?>','ptd_rightname')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->ptd_rightname; ?>','ptd_rightname')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_rightname"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_rightname"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">คำนำหน้าชื่อ</label>
          <div class="input-group-md">
            <input type="text" name="pt_prefix" id="pt_prefix" class="form-control" value="<?php echo $user->pt_prefix; ?>" placeholder="นาย" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                              } ?>>
            <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_prefix) && $user->pt_prefix != $user_requests_1->pt_prefix) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_prefix">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_prefix; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_prefix; ?>','pt_prefix')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_prefix; ?>','pt_prefix')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_prefix"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_prefix"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">ชื่อ</label>
          <div class="input-group-md">
            <input type="text" name="pt_fname" id="pt_fname" class="form-control" value="<?php echo $user->pt_fname; ?>" placeholder="จักษุ" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                              } ?>>
            <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_fname) && $user->pt_fname != $user_requests_1->pt_fname) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_fname">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_fname; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_fname; ?>','pt_fname')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_fname; ?>','pt_fname')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_fname"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_fname"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">นามสกุล</label>
          <div class="input-group-md">
            <input type="text" name="pt_lname" id="pt_lname" class="form-control" value="<?php echo $user->pt_lname; ?>" placeholder="สุราษฎร์" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                  echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                } ?>>
            <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_lname) && $user->pt_lname != $user_requests_1->pt_lname) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_lname">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_lname; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_lname; ?>','pt_lname')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_lname; ?>','pt_lname')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_lname"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_lname"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">เบอร์โทรศัพท์ (ที่สามารถติดต่อได้) ที่ 1</label>
          <div class="input-group-md">
            <input type="number" name="pt_tel" id="pt_tel" class="form-control" value="<?php echo $user->pt_tel; ?>" placeholder="077276999" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                              } ?>>
            <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_tel) && $user->pt_tel != $user_requests_1->pt_tel) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_tel">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_tel; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_tel; ?>','pt_tel')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_tel; ?>','pt_tel')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_tel"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_tel"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">เบอร์โทรศัพท์ (ที่สามารถติดต่อได้) ที่ 2</label>
          <div class="input-group-md">
            <input type="number" name="pt_tel_2" id="pt_tel_2" class="form-control" value="<?php echo $user->pt_tel_2; ?>" placeholder="077276999" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                      echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                    } ?>>
            <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_tel_2) && $user->pt_tel_2 != $user_requests_1->pt_tel_2) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_tel_2">
                <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_tel_2; ?></p>
                <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                  <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_tel_2; ?>','pt_tel_2')">ยืนยัน</button>
                  <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_tel_2; ?>','pt_tel_2')">ไม่ยืนยัน</button>
                <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_tel_2"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_tel_2"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">อีเมล</label>
          <div class="input-group-md">
            <input type="text" name="pt_email" id="pt_email" class="form-control" value="<?php echo $user->pt_email; ?>" placeholder="surateyehospital@gmail.com" <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) {
                                                                                                                                                                    echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                                  } ?>>
            <?php if (isset($user) && isset($user_requests_1) && !is_null($user_requests_1->pt_email) && $user->pt_email != $user_requests_1->pt_email) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="pt_email">
                <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_1->pt_email; ?></p>
                <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                  <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_email; ?>','pt_email')">ยืนยัน</button>
                  <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_1->pt_email; ?>','pt_email')">ไม่ยืนยัน</button>
                <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_email"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="pt_email"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-12 text-end">
          <?php if ($user_requests_1 && !is_null($user_requests_1->ptd_seq)) { ?>
            <button class="btn btn-secondary mb-0">รอการเปลี่ยนแปลงข้อมูลส่วนตัว (เจ้าหน้ากำลังตรวจสอบ)</button><br><br>
          <?php } else { ?>
            <a href="#" class="btn btn-success mb-0" id="btnSavePersonal">บันทึกการเปลี่ยนแปลงข้อมูลส่วนตัว (ส่งข้อมูลให้เจ้าหน้าที่ตรวจสอบ)</a><br><br>
          <?php } ?>

          <span class="text-danger">ถ้ามีการแจ้งเปลี่ยนข้อมูลจะไม่สามารถแจ้งเปลี่ยนใหม่อีกครั้งได้ ต้องรอจนกว่าเจ้าหน้าที่จะทำการเปลี่ยนแปลงข้อมูล</span>
        </div>
        <div class="card-body border-bottom pt-0 px-0 pb-1">
          <div class="card-header bg-transparent px-0">
            <h5 class="mb-0">สถานภาพผู้ป่วย</h5>
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">เพศ</label>
          <div class="input-group">
            <div class="form-control" style="height: 38px; <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                              echo 'background: #e9ecef;';
                                                            } ?>">
              <div class="form-check radio-bg-light mb-0">
                <label class="form-check-label" for="ptd_sex_m">
                  <input class="form-check-input" type="radio" name="ptd_sex" id="ptd_sex_m" value="M" <?php if ($user->ptd_sex == 'M') {
                                                                                                                  echo 'checked';
                                                                                                                } ?> <?php if ($user_requests_2) {
                                                                                                                        echo 'disabled style="cursor: not-allowed;"';
                                                                                                                      } ?>>
                  ชาย
                </label>
              </div>
            </div>
            <div class="form-control" style="height: 38px; <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                              echo 'background: #e9ecef;';
                                                            } ?>">
              <div class="form-check radio-bg-light mb-0">
                <label class="form-check-label" for="ptd_sex_f">
                  <input class="form-check-input" type="radio" name="ptd_sex" id="ptd_sex_f" value="F" <?php if ($user->ptd_sex == 'F') {
                                                                                                                  echo 'checked';
                                                                                                                } ?> <?php if ($user_requests_2) {
                                                                                                                        echo 'disabled style="cursor: not-allowed;"';
                                                                                                                      } ?>>
                  หญิง
                </label>
              </div>
            </div>
            <div class="form-control" style="height: 38px; <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                              echo 'background: #e9ecef;';
                                                            } ?>">
              <div class="form-check radio-bg-light mb-0">
                <label class="form-check-label" for="ptd_sex_nl">
                  <input class="form-check-input" type="radio" name="ptd_sex" id="ptd_sex_nl" value="N/L" <?php if ($user->ptd_sex == 'N/L') {
                                                                                                                    echo 'checked';
                                                                                                                  } ?> <?php if ($user_requests_2) {
                                                                                                                          echo 'disabled style="cursor: not-allowed;"';
                                                                                                                        } ?>>
                  อื่นๆ
                </label>
              </div>
            </div>
          </div>
          <?php if (isset($user) && isset($user_requests_2) && !is_null($user_requests_2->ptd_seq) && $user->ptd_sex != $user_requests_2->ptd_sex) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_sex">
            <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo ($user_requests_2->ptd_sex == 'M') ? 'ชาย' : (($user_requests_2->ptd_sex == 'F') ? 'หญิง' : 'อื่นๆ'); ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_sex; ?>','ptd_sex')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_sex; ?>','ptd_sex')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_sex"  style="margin-top:0px;"></div>
            <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_sex"  style="margin-top:0px;"></div>
          <?php } ?>
        </div>
        <div class="col-md-4">
          <label class="form-label">สถานะ</label>
          <select class="form-select" name="ptd_psst_id" id="ptd_psst_id" <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                                            echo 'disabled style="cursor: not-allowed;"';
                                                                          } ?>>
            <option value="">กรุณาเลือก</option>
            <?php foreach ($base_person_status as $bps) { ?>
              <option value="<?php echo $bps['psst_id']; ?>" <?php if ($user->ptd_psst_id == $bps['psst_id']) {
                                                                echo 'selected';
                                                              } ?>><?php echo $bps['psst_name']; ?></option>
            <?php } ?>
          </select>
          <?php if (isset($user) && isset($user_requests_2) && !is_null($user_requests_2->ptd_seq) && $user->ptd_psst_id != $user_requests_2->ptd_psst_id) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_psst_id">
            <p class="mb-0 text-success">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_2->psst_name; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_psst_id; ?>','ptd_psst_id')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_psst_id; ?>','ptd_psst_id')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_psst_id"  style="margin-top:0px;"></div>
            <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_psst_id"  style="margin-top:0px;"></div>
          <?php } ?>
        </div>
        <div class="col-md-4 mt-3">
          <label class="form-label">กรุ๊ปเลือด</label>
          <select class="form-select" name="ptd_blood_id" id="ptd_blood_id" <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                                              echo 'disabled style="cursor: not-allowed;"';
                                                                            } ?>>
            <option value="">กรุณาเลือก</option>
            <?php foreach ($base_blood as $bbl) { ?>
              <option value="<?php echo $bbl['blood_id']; ?>" <?php if ($user->ptd_blood_id == $bbl['blood_id']) {
                                                                echo 'selected';
                                                              } ?>><?php echo $bbl['blood_name']; ?></option>
            <?php } ?>
          </select>
          <?php if (isset($user) && isset($user_requests_2) && !is_null($user_requests_2->ptd_seq) && $user->ptd_blood_id != $user_requests_2->ptd_blood_id) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_blood_id">
            <p class="mb-0 text-success">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_2->blood_name; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_blood_id; ?>','ptd_blood_id')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_blood_id; ?>','ptd_blood_id')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_blood_id"  style="margin-top:0px;"></div>
            <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_blood_id"  style="margin-top:0px;"></div>
          <?php } ?>
        </div>

        <div class="col-md-2">
          <label class="form-label">วันที่เกิด</label>
          <select id="day" class="form-select" name='day' id="day" <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                                      echo 'disabled style="cursor: not-allowed;"';
                                                                    } ?>>
            <option value="">เลือกวัน</option>
            <!-- Generate days options dynamically -->
            <?php for ($i = 1; $i <= 31; $i++) : ?>
              <option value="<?php echo $i; ?>" <?php if ($day == $i) echo 'selected'; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
          <?php if (isset($user) && isset($user_requests_2) && !is_null($user_requests_2->ptd_seq) && $user->ptd_birthdate != $user_requests_2->ptd_birthdate) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_birthdate">
            <p class="mb-0 text-success position-absolute">ข้อมูลที่แจ้งเปลี่ยนแปลง :</p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-5" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_birthdate; ?>','ptd_birthdate')">ยืนยัน</button>
              <button class="btn btn-danger" style="position: absolute; margin-top: 48px !important; margin-left: 20px;" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_birthdate; ?>','ptd_birthdate')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_birthdate" style="margin-top:0px;"></div>
            <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_birthdate" style="margin-top:0px;"></div>
          <?php } ?>
        </div>
        <div class="col-md-2">
          <label class="form-label">เดือนที่เกิด</label>
          <select id="month" class="form-select" name="month" <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                                echo 'disabled style="cursor: not-allowed;"';
                                                              } ?>>
            <option value="">เลือกเดือน</option>
            <?php
            $months = [
              1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
              7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
            ];
            foreach ($months as $num => $name) :
            ?>
              <option value="<?php echo $num; ?>" <?php if ($month == $num) echo 'selected'; ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">ปี พ.ศ.ที่เกิด</label>
          <select id="year" class="form-select" name='year' id="year" <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                                        echo 'disabled style="cursor: not-allowed;"';
                                                                      } ?>>
            <option value="">เลือกปี</option>
            <!-- Generate years options dynamically -->
            <?php $currentYear = date('Y');
            for ($i = $currentYear; $i >= $currentYear - 100; $i--) : ?>
              <option value="<?php echo $i; ?>" <?php if ($year == $i) echo 'selected'; ?>>
                <?php echo $i + 543; ?>
              </option>
            <?php endfor; ?>
          </select>
          <?php if (isset($user) && isset($user_requests_2) && !is_null($user_requests_2->ptd_seq) && $user->ptd_birthdate != $user_requests_2->ptd_birthdate) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_birthdate">
              <p class="mb-0 text-success position-absolute"><?php echo fullDateTH3($user_requests_2->ptd_birthdate); ?></p>
            </div>
          <?php } ?>
        </div>

        <div class="col-md-2">
          <label class="form-label">อายุ</label>
          <input type="text" class="form-control" id="age" disabled style="cursor: not-allowed;">
        </div>
        <div class="col-md-4">
          <label class="form-label">สัญชาติ</label>
          <select class="form-select" name="ptd_nation_id" id="ptd_nation_id" <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                                                echo 'disabled style="cursor: not-allowed;"';
                                                                              } ?>>
            <option value="">กรุณาเลือก</option>
            <?php foreach ($base_nation as $bn) { ?>
              <option value="<?php echo $bn['nation_id']; ?>" <?php if ($user->ptd_nation_id == $bn['nation_id']) {
                                                                echo 'selected';
                                                              } ?>><?php echo $bn['nation_name']; ?></option>
            <?php } ?>
          </select>
          <?php if (isset($user) && isset($user_requests_2) && !is_null($user_requests_2->ptd_seq) && $user->ptd_nation_id != $user_requests_2->ptd_nation_id) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_nation_id">
            <p class="mb-0 text-success">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_2->nation_name; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_nation_id; ?>','ptd_nation_id')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_nation_id; ?>','ptd_nation_id')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_nation_id" style="margin-top:0px;"></div>
            <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_nation_id" style="margin-top:0px;"></div>
          <?php } ?>
        </div>
        <div class="col-md-4 mt-3">
          <label class="form-label">ศาสนา</label>
          <select class="form-select" name="ptd_reli_id" id="ptd_reli_id" <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) {
                                                                            echo 'disabled style="cursor: not-allowed;"';
                                                                          } ?>>
            <option value="">กรุณาเลือก</option>
            <?php foreach ($base_religion as $br) { ?>
              <option value="<?php echo $br['reli_id']; ?>" <?php if ($user->ptd_reli_id == $br['reli_id']) {
                                                              echo 'selected';
                                                            } ?>><?php echo $br['reli_name']; ?></option>
            <?php } ?>
          </select>
          <?php if (isset($user) && isset($user_requests_2) && !is_null($user_requests_2->ptd_seq) && $user->ptd_reli_id != $user_requests_2->ptd_reli_id) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_reli_id">
            <p class="mb-0 text-success">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_2->reli_name; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_reli_id; ?>','ptd_reli_id')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_reli_id; ?>','ptd_reli_id')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_reli_id" style="margin-top:0px;"></div>
            <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_reli_id" style="margin-top:0px;"></div>
          <?php } ?>
        </div>
        <div class="col-md-8">
          <label class="form-label">อาชีพ</label>
          <input type="text" name="ptd_occupation" id="ptd_occupation" class="form-control" value="<?php echo isset($user) ? $user->ptd_occupation : ''; ?>" placeholder="พยาบาล" <?php if ($user_requests_2) {
                                                                                                                                                                                    echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                                                  } ?>>
          <?php if (isset($user) && isset($user_requests_2) && !is_null($user_requests_2->ptd_seq) && $user->ptd_occupation != $user_requests_2->ptd_occupation) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_occupation">
            <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_2->ptd_occupation; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_occupation; ?>','ptd_occupation')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_2->ptd_occupation; ?>','ptd_occupation')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_occupation"></div>
            <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_occupation"></div>
          <?php } ?>
        </div>
        <div class="col-12 text-end">
          <?php if ($user_requests_2 && !is_null($user_requests_2->ptd_seq)) { ?>
            <button class="btn btn-secondary mb-0">รอการเปลี่ยนแปลงข้อมูลสถานภาพ (เจ้าหน้ากำลังตรวจสอบ)</button><br><br>
          <?php } else { ?>
            <a href="#" class="btn btn-success mb-0" id="btnSaveContact">บันทึกการเปลี่ยนแปลงข้อมูลสถานภาพ (ส่งข้อมูลให้เจ้าหน้าที่ตรวจสอบ)</a><br><br>
          <?php } ?>
          <span class="text-danger">ถ้ามีการแจ้งเปลี่ยนข้อมูลจะไม่สามารถแจ้งเปลี่ยนใหม่อีกครั้งได้ ต้องรอจนกว่าเจ้าหน้าที่จะทำการเปลี่ยนแปลงข้อมูล</span>
        </div>
      </div>
    </div>
    <div class="card-body pt-0 px-0 pb-4">
      <div class="card-header border-bottom bg-transparent px-0">
        <h5 class="mb-0">ที่อยู่ปัจจุบัน </h5>
      </div>
      <div class="row g-4 mt-2">
        <div class="col-md-3">
          <label class="form-label">บ้านเลขที่</label>
          <div class="input-group-md">
            <input type="text" name="ptd_house_number" id="ptd_house_number" class="form-control" value="<?php echo $user->ptd_house_number; ?>" placeholder="44/1" <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) {
                                                                                                                                                                      echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                                    } ?>>
            <?php if (isset($user) && isset($user_requests_3) && !is_null($user_requests_3->ptd_seq) && $user->ptd_house_number != $user_requests_3->ptd_house_number) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_house_number">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_3->ptd_house_number; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_house_number; ?>','ptd_house_number')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_house_number; ?>','ptd_house_number')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_house_number"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_house_number"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label">หมู่ที่</label>
          <div class="input-group-md">
            <input type="text" name="ptd_group" id="ptd_group" class="form-control" value="<?php echo $user->ptd_group; ?>" placeholder="หมู่ที่" <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) {
                                                                                                                                                    echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                                  } ?>>
            <?php if (isset($user) && isset($user_requests_3) && !is_null($user_requests_3->ptd_seq) && $user->ptd_group != $user_requests_3->ptd_group) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_group">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_3->ptd_group; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_group; ?>','ptd_group')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_group; ?>','ptd_group')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_group"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_group"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label">ซอย</label>
          <div class="input-group-md">
            <input type="text" name="ptd_alley" id="ptd_alley" class="form-control" value="<?php echo $user->ptd_alley; ?>" placeholder="ซอย" <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) {
                                                                                                                                                echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                              } ?>>
            <?php if (isset($user) && isset($user_requests_3) && !is_null($user_requests_3->ptd_seq) && $user->ptd_alley != $user_requests_3->ptd_alley) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_alley">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_3->ptd_alley; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_alley; ?>','ptd_alley')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_alley; ?>','ptd_alley')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_alley"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_alley"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label">ถนน</label>
          <div class="input-group-md">
            <input type="text" name="ptd_road" id="ptd_road" class="form-control" value="<?php echo $user->ptd_road; ?>" placeholder="ถนน" <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) {
                                                                                                                                              echo 'disabled style="cursor: not-allowed;"';
                                                                                                                                            } ?>>
            <?php if (isset($user) && isset($user_requests_3) && !is_null($user_requests_3->ptd_seq) && $user->ptd_road != $user_requests_3->ptd_road) { ?>
              <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_road">
              <p class="mb-0 text-success" style="margin-top: -15px;">ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_3->ptd_road; ?></p>
              <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
                <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_road; ?>','ptd_road')">ยืนยัน</button>
                <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_road; ?>','ptd_road')">ไม่ยืนยัน</button>
              <?php } ?>
              </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_road"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_road"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label">จังหวัด</label>
          <select class="form-select" name="ptd_pv_id" id="ptd_pv_id" <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) {
                                                                        echo 'disabled style="cursor: not-allowed;"';
                                                                      } ?>>
            <option value="">กรุณาเลือก</option>
          </select>
          <?php if (isset($user) && isset($user_requests_3) && !is_null($user_requests_3->ptd_seq) && $user->ptd_pv_id != $user_requests_3->ptd_pv_id) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_pv_id">
            <p class="mb-0 text-success">1. ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_3->pv_name; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_pv_id; ?>','ptd_pv_id')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_pv_id; ?>','ptd_pv_id')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
              <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_pv_id" style="margin-top: 0;"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_pv_id" style="margin-top: 0;"></div>
          <?php } ?>
        </div>
        <div class="col-md-3">
          <label class="form-label">อำเภอ</label>
          <select class="form-select" name="ptd_amph_id" id="ptd_amph_id" <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) {
                                                                            echo 'disabled style="cursor: not-allowed;"';
                                                                          } ?>>
            <?php if ($user->ptd_amph_id) { ?>
              <option value="<?php echo $user->ptd_amph_id; ?>" selected><?php echo $user->amph_name; ?></option>
            <?php } else { ?>
              <option value="">กรุณาเลือก</option>
            <?php } ?>
          </select>
          <?php if (isset($user) && isset($user_requests_3) && !is_null($user_requests_3->ptd_seq) && $user->ptd_amph_id != $user_requests_3->ptd_amph_id) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_amph_id">
            <p class="mb-0 text-success">2. ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_3->amph_name; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_amph_id; ?>','ptd_amph_id')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_amph_id; ?>','ptd_amph_id')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_amph_id" style="margin-top: 0;"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_amph_id" style="margin-top: 0;"></div>
          <?php } ?>
        </div>
        <div class="col-md-3">
          <label class="form-label">ตำบล</label>
          <select class="form-select" name="ptd_dist_id" id="ptd_dist_id" <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) {
                                                                            echo 'disabled style="cursor: not-allowed;"';
                                                                          } ?>>
            <?php if ($user->ptd_dist_id) { ?>
              <option value="<?php echo $user->ptd_dist_id; ?>" selected><?php echo $user->dist_name; ?></option>
            <?php } else { ?>
              <option value="">กรุณาเลือก</option>
            <?php } ?>
          </select>
          <?php if (isset($user) && isset($user_requests_3) && !is_null($user_requests_3->ptd_seq) && $user->ptd_dist_id != $user_requests_3->ptd_dist_id) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_dist_id">
            <p class="mb-0 text-success">3. ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_3->dist_name; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_dist_id; ?>','ptd_dist_id')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_dist_id; ?>','ptd_dist_id')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_dist_id" style="margin-top: 0;"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_dist_id" style="margin-top: 0;"></div>
          <?php } ?>
        </div>
        <div class="col-md-3">
          <label class="form-label">รหัสไปรษณีย์</label>
          <select class="form-select" name="ptd_pos_code" id="ptd_pos_code" <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) {
                                                                              echo 'disabled style="cursor: not-allowed;"';
                                                                            } ?>>
            <?php if ($user->ptd_pos_code) { ?>
              <option value="<?php echo $user->ptd_pos_code; ?>" selected><?php echo $user->ptd_pos_code; ?></option>
            <?php } else { ?>
              <option value="">กรุณาเลือก</option>
            <?php } ?>
          </select>
          <?php if (isset($user) && isset($user_requests_3) && !is_null($user_requests_3->ptd_seq) && $user->ptd_pos_code != $user_requests_3->ptd_pos_code) { ?>
            <div class="changeRequest" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_pos_code">
            <p class="mb-0 text-success">4. ข้อมูลที่แจ้งเปลี่ยนแปลง : <?php echo $user_requests_3->ptd_pos_code; ?></p>
            <?php if ($this->session->userdata('us_id') && $session_view == 'backend' && $this->input->post('pt_id')) { ?>
              <button class="btn btn-success mt-2" onclick="confirmChange(true, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_pos_code; ?>','ptd_pos_code')">ยืนยัน</button>
              <button class="btn btn-danger mt-2" onclick="confirmChange(false, '<?php echo $user->pt_id; ?>','<?php echo $user_requests_3->ptd_pos_code; ?>','ptd_pos_code')">ไม่ยืนยัน</button>
            <?php } ?>
            </div>
            <div class="status_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_pos_code" style="margin-top: 0;"></div>
              <div class="reason_request" data-id="<?php echo $user->pt_id; ?>" data-field="ptd_pos_code" style="margin-top: 0;"></div>
          <?php } ?>
        </div>
        <div class="col-12 text-end mt-5">
            <?php if ($user_requests_3 && !is_null($user_requests_3->ptd_seq)) { ?>
              <div class="badge bg-danger-subtle font-16 text-black" style="display: flex; justify-content: center; font-size: 16px; margin-top: -20px; margin-bottom: 30px; padding: 10px;">
                ถ้ามีการขอเปลี่ยนข้อมูล จังหวัด อำเภอ ตำบล รหัสไปรษณีย์ ต้องกดยืนยัน/ไม่ยืนยันเรียงลำดับ
              </div><br>
              <button class="btn btn-secondary mb-0">รอการเปลี่ยนแปลงที่อยู่ปัจจุบัน (เจ้าหน้ากำลังตรวจสอบ)</button><br><br>
            <?php } else { ?>
              <a href="#" class="btn btn-success mb-0" id="btnSaveAddress">บันทึกการเปลี่ยนแปลงที่อยู่ปัจจุบัน (ส่งข้อมูลให้เจ้าหน้าที่ตรวจสอบ)</a><br><br>
            <?php } ?>
          <span class="text-danger">ถ้ามีการแจ้งเปลี่ยนข้อมูลจะไม่สามารถแจ้งเปลี่ยนใหม่อีกครั้งได้ ต้องรอจนกว่าเจ้าหน้าที่จะทำการเปลี่ยนแปลงข้อมูล</span>
        </div>
      </div>
    </div>
  </div>

<style>
  .uploadremove {
    width: 20px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    border: 0;
    padding: 0;
    background: var(--bs-danger);
    border-radius: 50%;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 1;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
  }
</style>

<script>
  function confirmChange(isConfirmed, userId, newValue, fieldName) {

    if (newValue === null) {
    return; // ถ้า newValue เป็น null ให้หยุดการทำงาน
  }

    if (isConfirmed) {
      // Confirm the change
      updateStatus(userId, '1', '', newValue, fieldName);
    } else {
      // Ask for reason
      Swal.fire({
        title: 'เหตุผลในการไม่ยืนยัน',
        input: 'textarea',
        inputLabel: 'เหตุผล',
        inputPlaceholder: 'พิมพ์เหตุผลของคุณที่นี่...',
        inputAttributes: {
          'aria-label': 'พิมพ์เหตุผลของคุณที่นี่'
        },
        showCancelButton: true,
        confirmButtonText: 'ส่ง',
        cancelButtonText: 'ยกเลิก',
        preConfirm: (reason) => {
          if (!reason) {
            Swal.showValidationMessage('กรุณาใส่เหตุผลในการไม่ยืนยัน');
          }
          return reason;
        }
      }).then((result) => {
        if (result.isConfirmed) {
          updateStatus(userId, '6', result.value, newValue, fieldName);
        }
      });
    }
  }

  function updateStatus(userId, status, reason, newValue, fieldName) {
    console.log('Sending data:', {
      user_id: userId,
      status: status,
      reason: reason,
      new_value: newValue,
      field_name: fieldName
    }); // Log ข้อมูลที่ถูกส่ง 
    $.ajax({
      url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/update_status_requests'); ?>', // URL ของ Controller และ Method
      method: 'POST',
      data: {
        user_id: userId,
        status: status,
        reason: reason,
        new_value: newValue,
        field_name: fieldName
      },
      success: function(response) {
        try {
          var res = JSON.parse(response);
          console.log('Response from server:', res); // ดู response จากเซิร์ฟเวอร์
          if (res.success) {
            // ซ่อนปุ่มและข้อความที่แจ้งการเปลี่ยนแปลง
            $(`.changeRequest[data-id='${userId}'][data-field='${fieldName}']`).hide();
            // แสดงข้อความสถานะ
            if (status === '1') {
              $(`.status_request[data-id='${userId}'][data-field='${fieldName}']`).text('ยืนยันแล้ว');
            }
            if (status == '6') {
              $(`.reason_request[data-id='${userId}'][data-field='${fieldName}']`).text('ไม่ยืนยัน เหตุผล: ' + reason);
            }
            Swal.fire({
              title: 'สำเร็จ',
              text: 'การเปลี่ยนแปลงของคุณถูกบันทึกเรียบร้อยแล้ว',
              icon: 'success'
            }).then(() => {
              // อัปเดตข้อมูลในหน้าโดยไม่ต้องรีเฟรช
              updateUI(userId, newValue, fieldName, status, reason);
              calculateAge(); // Calculate age again after update
            });
          } else {
            Swal.fire({
              title: 'ผิดพลาด',
              text: res.message || 'เกิดข้อผิดพลาดบางอย่าง',
              icon: 'error'
            });
          }
        } catch (e) {
          Swal.fire({
            title: 'ผิดพลาด',
            text: 'รูปแบบข้อมูลที่ส่งกลับมาไม่ถูกต้อง',
            icon: 'error'
          });
        }
      },
      error: function() {
        console.log(xhr.responseText); // แสดงข้อความข้อผิดพลาดจากเซิร์ฟเวอร์
        Swal.fire({
          title: 'ผิดพลาด',
          text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
          icon: 'error'
        });
      }
    });
  }


  function updateUI(userId, newValue, fieldName, status, reason) {
  if (status === '1') {
    switch (fieldName) {
      case 'pt_identification':
      case 'pt_passport':
      case 'pt_peregrine':
      case 'ptd_rightname':
      case 'pt_prefix':
      case 'pt_fname':
      case 'pt_lname':
      case 'pt_tel':
      case 'pt_tel_2':
      case 'pt_email':
      case 'ptd_psst_id':
      case 'ptd_blood_id':
      case 'ptd_birthdate':
      case 'ptd_nation_id':
      case 'ptd_reli_id':
      case 'ptd_occupation':
      case 'ptd_house_number':
      case 'ptd_group':
      case 'ptd_alley':
      case 'ptd_road':
      case 'ptd_pv_id':
      $(`#${fieldName}`).val(newValue).change();
      break;
      case 'ptd_amph_id':
      $('#ptd_amph_id').val(newValue).change();
      break;
      case 'ptd_dist_id':
      $('#ptd_dist_id').val(newValue).change();
      break;
      case 'ptd_pos_code':
      $('#ptd_pos_code').val(newValue).change();
      break;
      case 'ptd_sex':
        $(`input[name='ptd_sex'][value='${newValue}']`).prop('checked', true);
        break;
      default:
        console.log(`Field name ${fieldName} is not recognized.`);
    }
  }

  // อัปเดตวัน เดือน ปีเกิด
  if (fieldName === 'ptd_birthdate') {
    const dateParts = newValue.split('-');
    const year = parseInt(dateParts[0]);
    const month = parseInt(dateParts[1]);
    const day = parseInt(dateParts[2]);

    $('#day').val(day);
    $('#month').val(month);
    $('#year').val(year);
  }

  // อัปเดตสถานะ
  let statusElement = $(`#status[data-id='${userId}'][data-field='${fieldName}']`);
  let reasonElement = $(`#reason[data-id='${userId}'][data-field='${fieldName}']`);

  if (status === '1') {
    statusElement.text('ยืนยันแล้ว');
    reasonElement.text('');
  } else if (status === '6') {
    statusElement.text('ไม่ยืนยัน');
    reasonElement.text('เหตุผล: ' + reason);
  }
    // ลบ UI ที่แสดงการร้องขอการเปลี่ยนแปลง
    $(`.changeRequest[data-id='${userId}'][data-field='${fieldName}']`).remove();
}

  document.getElementById('changeImageBtn').addEventListener('click', function() {
    document.getElementById('uploadImage').click();
  });
  document.getElementById('uploadImage').addEventListener('change', function(event) {
    console.log('File input changed');
    var file = event.target.files[0];
    if (file) {
      var formData = new FormData();
      formData.append('image', file);
      formData.append('pt_id', $('#pt_id_img').val());
      console.log(formData);
      console.log('Sending AJAX request to upload image');
      $.ajax({
        url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/upload_image'); ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          response = JSON.parse(response); // แปลงเป็น JSON Object
          if (response.status === 'success') {
            $('.profileImage').attr('src', response.image_url);
            Swal.fire({
              icon: 'success',
              title: 'อัปโหลดสำเร็จ',
              text: 'รูปภาพของคุณถูกอัปโหลดเรียบร้อยแล้ว',
              timer: 1000,
              timerProgressBar: true,
              showConfirmButton: false
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด',
              text: response.error
            });
          }
        }
      });
    }
  });

  document.getElementById('removeImage').addEventListener('click', function() {
    Swal.fire({
      title: 'คุณแน่ใจหรือไม่?',
      text: 'คุณต้องการลบรูปภาพนี้หรือไม่?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        // If confirmed, proceed with the delete request
        $.ajax({
          url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/delete_image'); ?>',
          type: 'POST',
          data: {
            pt_id: $('#pt_id_img').val()
          },
          success: function(response) {
            console.log(response);
            response = JSON.parse(response); // Parse the JSON response
            if (response.status === 'success') {
              $('.profileImage').attr('src', '<?php echo base_url(); ?>assets/img/default-person.png');
              Swal.fire({
                icon: 'success',
                title: 'ลบสำเร็จ',
                text: 'รูปภาพของคุณถูกลบเรียบร้อยแล้ว',
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: response.error
              });
            }
          }
        });
      }
    });
  });
</script>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    calculateAge();

    document.getElementById('day').addEventListener('change', calculateAge);
    document.getElementById('month').addEventListener('change', calculateAge);
    document.getElementById('year').addEventListener('input', calculateAge);
  });

  function calculateAge() {
    var day = document.getElementById('day').value;
    var month = document.getElementById('month').value;
    var year = document.getElementById('year').value;

    if (!day || !month || !year) {
      return;
    }

    // Convert Thai Buddhist year to Gregorian year
    var gregorianYear = year - 543;

    var today = new Date();
    var birthDate = new Date(gregorianYear, month - 1, day);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }

    document.getElementById('age').value = age - 543 + ' ปี';
  }

  $(document).ready(function() {
    var previousStatus = $('#pt_sta_id').val();
    $('#pt_sta_id').change(function() {
      var newStatus = $(this).val();
      var pt_id = <?php echo json_encode($user->pt_id); ?>; // Assuming pt_id is available
      var user_requests_1_id = "<?php echo isset($user_requests_1) ? $user_requests_1->id : ''; ?>";
      var user_requests_2_id = "<?php echo isset($user_requests_2) ? $user_requests_2->id : ''; ?>";
      var user_requests_3_id = "<?php echo isset($user_requests_3) ? $user_requests_3->id : ''; ?>";

      Swal.fire({
        title: 'ยืนยันการเปลี่ยนแปลงสถานะ ?',
        text: "คุณต้องการเปลี่ยนสถานะผู้ลงทะเบียนใช่หรือไม่ ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ยืนยันการเปลี่ยนแปลง',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/update_status'); ?>',
            type: 'POST',
            data: {
              pt_id: pt_id,
              pt_sta_id: newStatus,
              user_requests_1_id: user_requests_1_id,
              user_requests_2_id: user_requests_2_id,
              user_requests_3_id: user_requests_3_id
            },
            success: function(response) {
              response = JSON.parse(response); // Assuming the response is JSON encoded
              if (response.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'สำเร็จ',
                  text: 'สถานะผู้ลงทะเบียนได้ถูกเปลี่ยนแปลงเรียบร้อยแล้ว',
                  timer: 1000,
                  timerProgressBar: true,
                  showConfirmButton: false
                });
                // Refresh the specific part of the page
                refreshPatientStatus(pt_id);
                previousStatus = newStatus; // Update previous status on successful change
              } else {
                Swal.fire(
                  'เกิดข้อผิดพลาด!',
                  response.error,
                  'error'
                );
                $('#pt_sta_id').val(previousStatus); // Reset to previous status on error
              }
            },
              error: function(xhr, status, error) {
                Swal.fire({
                  icon: 'error',
                  title: 'เกิดข้อผิดพลาด!',
                  text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
                });
                $('#pt_sta_id').val(previousStatus); // Reset to previous status on error
              }
          });
        } else {
          $('#pt_sta_id').val(previousStatus); // Reset to previous status on cancel
        }
      });
    });


    function refreshPatientStatus(pt_id) {
      $.ajax({
        url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/get_patient_status'); ?>', // URL to get updated patient status
        type: 'POST',
        data: {
          pt_id: pt_id
        },
        success: function(response) {
          
          // Assuming the response contains the updated HTML for the patient status section
          $('#patientStatusSection').html(response); // Update the patient status section with new content
          calculateAge();
          // Remove the h1 and div elements
          // $('.remove_status').remove();
        }
      });
    }

    
    $('#btnSavePersonal').click(function() {
      var data = {
        pt_id: $('#pt_id').val(),
        pt_identification: $('#pt_identification').val(),
        pt_passport: $('#pt_passport').val(),
        pt_peregrine: $('#pt_peregrine').val(),
        pt_member: $('#pt_member').val(),
        ptd_rightname: $('#ptd_rightname').val(),
        pt_prefix: $('#pt_prefix').val(),
        pt_fname: $('#pt_fname').val(),
        pt_lname: $('#pt_lname').val(),
        pt_tel: $('#pt_tel').val(),
        pt_tel_2: $('#pt_tel_2').val(),
        pt_email: $('#pt_email').val()
      };
      $.ajax({
        url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/personal_info_insert'); ?>',
        type: 'POST',
        data: data,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'แจ้งการเปลี่ยนข้อมูลสำเร็จ',
            text: 'ข้อมูลส่วนตัวถูกแจ้งให้กับเจ้าหน้าที่เรียบร้อยแล้ว',
            confirmButtonText: 'ยืนยัน'
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload(); // เพื่อรีเฟรชหน้า
            }
          });
        }
      });
    });


    
    $('#btnSaveContact').click(function() {
      var data = {
        pt_id: $('#pt_id').val(),
        ptd_sex: $('input[name="ptd_sex"]:checked').val(),
        ptd_psst_id: $('#ptd_psst_id').val(),
        ptd_blood_id: $('#ptd_blood_id').val(),
        day: $('#day').val(),
        month: $('#month').val(),
        year: $('#year').val(),
        age: $('#age').val(),
        ptd_nation_id: $('#ptd_nation_id').val(),
        ptd_reli_id: $('#ptd_reli_id').val(),
        ptd_occupation: $('#ptd_occupation').val()
      };
      console.log(data);
      $.ajax({
        url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/contact_info_insert'); ?>',
        type: 'POST',
        data: data,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'แจ้งการเปลี่ยนข้อมูลสำเร็จ',
            text: 'ข้อมูลส่วนตัวถูกแจ้งให้กับเจ้าหน้าที่เรียบร้อยแล้ว',
            confirmButtonText: 'ยืนยัน'
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload(); // เพื่อรีเฟรชหน้า
            }
          });
        }
      });
    });



    $('#btnSaveAddress').click(function() {
      var data = {
        pt_id: $('#pt_id').val(),
        ptd_house_number: $('#ptd_house_number').val(),
        ptd_group: $('#ptd_group').val(),
        ptd_alley: $('#ptd_alley').val(),
        ptd_road: $('#ptd_road').val(),
        ptd_pv_id: $('#ptd_pv_id').val(),
        ptd_amph_id: $('#ptd_amph_id').val(),
        ptd_dist_id: $('#ptd_dist_id').val(),
        ptd_pos_code: $('#ptd_pos_code').val()
      };
      $.ajax({
        url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/address_info_insert'); ?>',
        type: 'POST',
        data: data,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'แจ้งการเปลี่ยนข้อมูลสำเร็จ',
            text: 'ข้อมูลส่วนตัวถูกแจ้งให้กับเจ้าหน้าที่เรียบร้อยแล้ว',
            confirmButtonText: 'ยืนยัน'
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload(); // เพื่อรีเฟรชหน้า
            }
          });
        }
      });
    });

  });

  $(document).ready(function() {
    // The previously saved province ID
    var savedProvinceId = "<?php echo $user->ptd_pv_id; ?>";
    var savedDistrictId = "<?php echo $user->ptd_amph_id; ?>";
    var savedSubdistrictId = "<?php echo $user->ptd_dist_id; ?>";
    var savedPostcode = "<?php echo $user->ptd_pos_code; ?>";
    
    $.ajax({
      url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/get_provinces'); ?>',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        var options = '<option value="">กรุณาเลือก</option>';
        $.each(data, function(index, value) {
          var selected = (value.pv_id == savedProvinceId) ? ' selected' : '';
          options += '<option value="' + value.pv_id + '"' + selected + '>' + value.pv_name + '</option>';
        });
        $('#ptd_pv_id').html(options);

        // Trigger change to load districts if a province is already selected
        if (savedProvinceId) {
            $('#ptd_pv_id').trigger('change');
        }
      }
    });

    // Load districts based on province
    $('#ptd_pv_id').change(function() {
      var provinceId = $(this).val();
      if (provinceId) {
        $.ajax({
          url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/get_districts'); ?>',
          type: 'POST',
          data: {
            province_id: provinceId
          },
          dataType: 'json',
          success: function(data) {
            var options = '<option value="">กรุณาเลือก</option>';
            $.each(data, function(index, value) {
              var selected = (value.amph_id == savedDistrictId) ? ' selected' : '';
              options += '<option value="' + value.amph_id + '"' + selected + '>' + value.amph_name + '</option>';
            });
            $('#ptd_amph_id').html(options);
            // $('#ptd_dist_id').html('<option value="">กรุณาเลือก</option>');
            // $('#ptd_pos_code').html('<option value="">กรุณาเลือก</option>');

            // Trigger change to load sub-districts if a district is already selected
            if (savedDistrictId) {
              $('#ptd_amph_id').trigger('change');
            }
          }
        });
      } else {
        $('#ptd_amph_id').html('<option value="">กรุณาเลือก</option>');
        $('#ptd_dist_id').html('<option value="">กรุณาเลือก</option>');
        $('#ptd_pos_code').html('<option value="">กรุณาเลือก</option>');
      }
    });

    // Load sub-districts based on district
    $('#ptd_amph_id').change(function() {
      var districtId = $(this).val();
      if (districtId) {
        $.ajax({
          url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/get_subdistricts'); ?>',
          type: 'POST',
          data: {
            district_id: districtId
          },
          dataType: 'json',
          success: function(data) {
            var options = '<option value="">กรุณาเลือก</option>';
            $.each(data, function(index, value) {
              var selected = (value.dist_id == savedSubdistrictId) ? ' selected' : '';
              options += '<option value="' + value.dist_id + '"' + selected + '>' + value.dist_name + '</option>';
            });
            $('#ptd_dist_id').html(options);
            // $('#ptd_pos_code').html('<option value="">กรุณาเลือก</option>');
            // Trigger change to load postal codes if a sub-district is already selected
            if (savedSubdistrictId) {
              $('#ptd_dist_id').trigger('change');
            }
          }
        });
      } else {
        $('#ptd_dist_id').html('<option value="">กรุณาเลือก</option>');
        $('#ptd_pos_code').html('<option value="">กรุณาเลือก</option>');
      }
    });

    // Load postal codes based on sub-district
    $('#ptd_dist_id').change(function() {
      var subdistrictId = $(this).val();
      var districtId = $('#ptd_amph_id').val();
      var provinceId = $('#ptd_pv_id').val();
      var distName = $('#ptd_dist_id option:selected').text();

      if (subdistrictId) {
        $.ajax({
          url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/get_postcodes'); ?>',
          type: 'POST',
          data: {
            district_id: districtId,
            province_id: provinceId,
            dist_name: distName
          },
          dataType: 'json',
          success: function(data) {
            var options = '<option value="">กรุณาเลือก</option>';
            $.each(data, function(index, value) {
              var selected = (value.dist_pos_code == savedPostcode) ? ' selected' : '';
              options += '<option value="' + value.dist_pos_code + '"' + selected + '>' + value.dist_pos_code + '</option>';
            });
            $('#ptd_pos_code').html(options);
          }
        });
      } else {
        $('#ptd_pos_code').html('<option value="">กรุณาเลือก</option>');
      }
    });

    // Trigger change to load districts if a district is already selected
    if (savedDistrictId) {
      $('#ptd_amph_id').trigger('change');
    }

    // Trigger change to load sub-districts if a sub-district is already selected
    if (savedSubdistrictId) {
      $('#ptd_dist_id').trigger('change');
    }

    $("#ptd_road").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "<?php echo site_url('ums/frontend/Dashboard_home_patient/search_roads'); ?>", // Adjust the URL to your actual controller method
          data: {
            term: request.term
          },
          dataType: "json",
          success: function(data) {
            response(data);
          }
        });
      },
      minLength: 1 // Minimum characters before triggering the autocomplete
    });

    $("#ptd_occupation").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "<?php echo site_url('ums/frontend/Dashboard_home_patient/search_occupation'); ?>", // Adjust the URL to your actual controller method
          data: {
            term: request.term
          },
          dataType: "json",
          success: function(data) {
            response(data);
          }
        });
      },
      minLength: 1 // Minimum characters before triggering the autocomplete
    });
    $("#ptd_rightname").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "<?php echo site_url('ums/frontend/Dashboard_home_patient/search_rightname'); ?>", // Adjust the URL to your actual controller method
          data: {
            term: request.term
          },
          dataType: "json",
          success: function(data) {
            response(data);
          }
        });
      },
      minLength: 1 // Minimum characters before triggering the autocomplete
    });
  });
  $(function() {
    $("#pt_prefix").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "<?php echo site_url('ums/frontend/Register_patient/get_prefix'); ?>",
          dataType: "json",
          data: {
            term: request.term // ใช้ 'term' แทน 'prefix'
          },
          success: function(data) {
            response(data);
          }
        });
      },
      minLength: 1
    });
  });
</script>