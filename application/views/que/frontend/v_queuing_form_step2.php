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
    <span class='text-white font-16'>บันทึกข้อมูลการนัดหมายแพทย์ ขั้นตอนที่ 2</span>
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
        <a href="" class="btn btn-primary mt-5 fs-6">ข้อมูลแพทย์เพิ่มเติม</a>
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
                        <i class="bi bi-1-square-fill fs-2 text-success"></i>
                        <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3 text-success">บันทึกข้อมูลการนัดหมายแพทย์<br>ขั้นตอนที่ 1</span>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 pt-2">
                        <i class="bi bi-2-square-fill fs-2"></i>
                        <span class="card-title pt-0 font-weight-600 fs-6 position-absolute ms-3">ตรวจสอบการลงทะเบียน - <br>ข้อมูลการนัดหมายแพทย์ ขั้นตอนที่ 2</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4" style="margin-top:-20px;">
                  <div class="col-12">
                    <a href="<?php echo base_frontend_url('index.php').'/'.$this->config->item('que_frontend_path').'/Queuing_form_step1'; ?>" 
                    type="button" class="btn btn-secondary float-start"><i class="bi bi-backspace"></i> กลับไปขั้นตอนที่ 1</a>
                  </div>
                </div>
                <div class="row mt-2 mb-4">
                  <div class="col-12 text-center">
                    <h6 class="text-info-emphasis font-18">ถ้าต้องการให้การจองคิว - นัดหมายแพทย์ที่สมบูรณ์ กรุณาระบุเลขบัตรประจำตัวประชาชน เพื่อทำการตรวจสอบการลงทะเบียน </h6>
                  </div>
                </div>
                <div class="row mt-0 mb-4">
                    <div class="col-12">
                        <h6 class=" font-weight-600 font-18">ตรวจสอบเลขบัตรประจำตัวประชาชน <span class="text-danger">*</span>
                            <hr class="style-two" style="margin-top: -10px; background-image: linear-gradient(to left, #e9d494 75%, transparent 25%);">
                        </h6>
                    </div>
                </div>
                <div class="row mt-0 mb-2">
                  <div class="col-6 col-md-6 col-lg-6">
                    <div class="form-floating mb-2">
                      <input type="number" class="form-control mb-0" id="floatingInput" placeholder="ภาติยะ">
                      <label for="floatingInput">ระบุเลขบัตรประจำตัวประชาชน <span class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="col-6 col-md-6 col-lg-6">
                    <button type="button" id="checkButton" class="btn btn-success btn-lg"><i class="bi bi-patch-check"></i> กดตรวจสอบเลขบัตรประจำตัวประชาชน </button>
                  </div>
                </div>
                <div class="row mt-0 mb-5">
                  <form class="needs-validation mb-6 d-none" novalidate="">
                    <div class="row">
                      <div class="col-6 col-md-6 col-lg-4">
                        <div class="mb-3 mt-4">
                            <label for="" class="form-label">คำนำหน้าชื่อ <span class="text-danger">*</span></label>
                            <div class="position-relative">
                              <select class="form-select" id="" required="">
                                <option selected="" disabled="" value="">เลือก</option>
                                <option value="1">นาย</option>
                                <option value="2">นาง</option>
                                <option value="3">นางสาว</option>
                              </select>
                            </div>
                        </div>
                      </div>
                      <div class="col-6 col-md-6 col-lg-4">
                        <div class="mb-3 mt-4">
                            <label for="" class="form-label">ชื่อ <span class="text-danger">*</span></label>
                            <div class="position-relative">
                              <input type="text" class="form-control " id="" required="" placeholder='ตัวอย่าง : จักษุ'>
                            </div>
                        </div>
                      </div>
                      <div class="col-6 col-md-6 col-lg-4">
                        <div class="mb-3 mt-4">
                            <label for="" class="form-label">นามสกุล <span class="text-danger">*</span></label>
                            <div class="position-relative">
                              <input type="text" class="form-control " id="" required="" placeholder='ตัวอย่าง : สุราษฎร์'>
                            </div>
                        </div>
                      </div>
                      <div class="col-6 col-md-6 col-lg-4">
                        <div class="mb-3 mt-4">
                            <label for="validation_tel" class="form-label">เบอร์โทรศัพท์ (ที่สามารถติดต่อได้) <span class="text-danger">*</span></label>
                            <div class="position-relative">
                              <input type="number" class="form-control " id="validation_tel" required="" placeholder="ตัวอย่าง : 077276999">
                            </div>
                        </div>
                      </div>
                      <!-- <div class="col-6 col-md-6 col-lg-4">
                        <div class="mb-3 mt-4">
                            <label for="formSignUpPassword" class="form-label">รหัสผ่าน <span class="text-danger">*</span></label>
                            <div class="password-field position-relative">
                              <input type="password" class="form-control fakePassword" id="formSignUpPassword" required="">
                              <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                            </div>
                        </div>
                      </div>
                      <div class="col-6 col-md-6 col-lg-4">
                        <div class="mb-3 mt-4">
                            <label for="formSignUpPassword" class="form-label">ยืนยันรหัสผ่าน - อีกครั้ง <span class="text-danger">*</span></label>
                            <div class="password-field position-relative">
                              <input type="password" class="form-control fakePassword" id="formSignUpPassword" required="">
                              <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                            </div>
                        </div>
                      </div> -->
                      <div class="col-12 col-md-12 col-lg-12">
                        <div class="mb-4 d-flex align-items-center justify-content-between mt-5">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="rememberMeCheckbox"><div class="invalid-feedback">กรุณาระบุข้อมูล</div>
                              <label class="form-check-label" for="rememberMeCheckbox">ยืนยันการเก็บข้อมูลนโยบายคุ้มครองข้อมูลส่วนบุคคล (Privacy Policy) 
                              <a target="_blank" href="<?php echo site_url(); ?>/gear/frontend_privacy_policy">อ่านรายละเอียดเพิ่มเติม</a></label>
                            </div>
                        </div>
                      </div>
                      <div class=" offset-3 col-6 col-md-6 col-lg-6">
                        <div class="d-grid mb-5">
                            <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-person-hearts"></i> ลงทะเบียน</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="row mt-5 mb-4">
                    <div class="col-12">
                        <h6 class=" font-weight-600 font-18">วันที่ - เวลา ที่ทำการจองคิว - นัดหมายแพทย์</h6>
                    </div>
                </div>
                <div class="row ms-4">
                  <div class="col-12 col-sm-12 col-md-12">
                    <p class="fs-5">วันที่ 9 พฤษภาคม พ.ศ.2567 เวลา 10:00 - 12:00 น.</p>
                    <p class="fs-5">แพทย์ที่จองคิว - นัดหมายแพทย์ นพ.บรรยง ชินกุลกิจนิวัฒน์</p>
                  </div>
                </div>
                <hr class="mt-2">
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="row mb-4 mt-4">
                      <div class="col-12">
                          <h6 class=" font-weight-600 font-18">ประเภทผู้ป่วย</h6>
                      </div>
                    </div>
                    <div class="row ms-4">
                      <div class="col-12 col-md-12 col-lg-12">
                      <p class="fs-5">ผู้ป่วยใหม่</p>
                      </div>
                    </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="row mb-4 mt-4">
                      <div class="col-12">
                          <h6 class=" font-weight-600 font-18">รายละเอียดการจองคิว - นัดหมายแพทย์</h6>
                      </div>
                    </div>
                    <div class="row ms-4">
                      <div class="col-12 col-md-12 col-lg-12">
                      <p class="fs-5">โรคจอประสาทตา</p>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="mt-2">
                <div class="row mb-4 mt-4">
                  <div class="col-12">
                      <h6 class=" font-weight-600 font-18">สาเหตุที่นัดหมายแพทย์</h6>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-12 col-md-12 col-lg-12">
                  <p class="fs-5">ตอบสนองต่อแสงในจอประสาทตา รู้สึกไม่ค่อยชัด มีจุดๆในตา เป็นบางครั้ง</p>
                  </div>
                </div>
                <hr class="mt-2">
                <div class="row mb-4 mt-4">
                  <div class="col-12">
                      <h6 class=" font-weight-600 font-18">ความต้องการเพิ่มเติม</h6>
                  </div>
                </div>
                <div class="row ms-4">
                  <div class="col-12 col-md-12 col-lg-12">
                  <p class="fs-5">ต้องการรถเข็นมารับที่ทางเข้า</p>
                  </div>
                </div>
                <div class="offset-2 col-8 col-md-8 col-lg-8 mt-4">
                  <div class="text-center bg-primary bg-opacity-25 p-md-7 p-4 rounded-4 pattern-square">
                      <div class="mb-6">
                        <h5 class="font-24 fw-bold">หมายเลขการจองคิว - นัดหมายแพทย์</h5>
                      </div>
                      <div class="d-flex flex-column align-items-center mb-5 mt-4">
                        <span class="me-3 font-20 bg-success p-2 text-white fw-bold rounded-5">
                          &emsp;&emsp;
                          SEH-25670146
                          &emsp;&emsp;
                        </span>
                      </div>
                      <div class="mb-6">
                        <h5 class="font-24 fw-bold">การเตรียมตัวก่อนมาพบแพทย์</h5>
                      </div>
                      <div class="d-flex flex-column align-items-start ps-5 pe-5">
                        <span class="me-3 font-18">
                            <i class="bi bi-1-circle-fill font-24"></i>
                            <span class="text-dark ms-2">ควรพักผ่อนให้เพียงพอ</span>
                        </span>
                        <span class="me-3 font-18">
                            <i class="bi bi-2-circle-fill font-24"></i>
                            <span class="text-dark ms-2">อดอาหาร-น้ำดื่ม-ยา เพื่อรอการผ่าตัด</span>
                        </span>
                        <span class="me-3 font-18">
                            <i class="bi bi-3-circle-fill font-24"></i>
                            <span class="text-dark ms-2">ไม่ควรเครียด</span>
                        </span>
                      </div>
                      <div class="d-flex flex-column align-items-center mt-5">
                        <span class="me-3 font-20 text-danger fw-bold ">หรือ ติดต่อสอบถามเพิ่มเติมได้ที่ แผนกจักษุแพทย์ โทร. 077-276-999</span>
                      </div>
                  </div>
                </div>
                <div class="row mt-5 mb-3">
                  <div class="col-12 col-md-12 col-lg-11">
                    <a href="<?php echo base_frontend_url('index.php').'/'.$this->config->item('que_frontend_path').'/Queuing_form_step2'; ?>" 
                    type="button" class="btn btn-success float-end btn-lg"><i class="bi bi-floppy2-fill"></i> ยืนยันการจองคิว - นัดหมายแพทย์</a>
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

// Add event listener to the button
document.getElementById("checkButton").addEventListener("click", function() {
    // Show the Swal2 modal
    Swal.fire({
        title: 'ไม่พบการข้อมูลการลงทะเบียน กรุณาลงทะเบียน',
        html: '<span class="font-20">ระบุชื่อ นามสกุล <br> เบอร์โทรศัพท์ที่สามารถติดต่อได้ <br>และสร้างรหัสผ่าน</span>',
        icon: 'warning',
        confirmButtonText: 'ลงทะเบียน'
    }).then((result) => {
            if (result.isConfirmed) {
                // Show registration form
                document.querySelector('.needs-validation').classList.remove('d-none');
            }
        });
});

</script>
<script src="<?php echo base_url(); ?>assets/vendor/password/password.js"></script>