<style>
  .valid-id {
    border-color: green;
    margin-top: 5px;
  }

  .error-message {
    color: red;
    margin-top: 5px;
  }

  .success-message {
    color: green;
    margin-top: 0px;
  }

  .invalid-feedback {
    display: none !important;
  }

  .hidden {
    display: none;
  }
</style>
<div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar">
    <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
    &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    <a href="<?php echo site_url(); ?>/gear/frontend_login">
      &nbsp;<i class="bi bi-box-arrow-in-right"></i>&nbsp;
      <span class='font-16'>ล็อกอินเข้าสู่ระบบ</span>
    </a>
    &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    <span class='text-white font-16'>ลงทะเบียน</span>
  </div>
</div>
<div class="pattern-square"></div>
<section class="py-5 py-lg-4">
  <div class="container">
    <div class="row">
      <div class="col-xl-6 offset-xl-3 col-md-12 col-12">
        <div class="text-center">
          <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="brand" class="mb-3 ms-3" style="width:140px">
          <h1 class="mb-1">ลงทะเบียน</h1>
          <p class="mb-0">
            หน้าจอการลงทะเบียนของโรงพยาบาลจักษุสุราษฎร์ เพื่อเข้าใช้งานระบบ
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-8 col-lg-8 col-md-8 col-12">
        <div class="card shadow-sm mb-6">
          <div class="card-body">
            <form id="registrationForm" class="needs-validation mb-6" novalidate method="post" action="<?php echo site_url('ums/frontend/Register_patient/register'); ?>">
              <div class="mb-3">
                <label for="registrationType" class="form-label">ประเภทการลงทะเบียน (ถ้าไม่มีเลขบัตรประจำตัวประชาชน กรุณาเลือก) <span class="text-danger">*</span></label>
                <select class="form-select" id="registrationType" name="registrationType">
                  <option disabled value="">เลือก</option>
                  <option value="citizen" selected>เลขบัตรประจำตัวประชาชน</option>
                  <option value="passport">พาสปอร์ต</option>
                  <option value="alien">เลขบัตรต่างด้าว</option>
                </select>
              </div>
              <div class="mb-3" id="citizenField" style="display:none;">
                <label for="identification" class="form-label">เลขบัตรประจำตัวประชาชน <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="identification" id="identification" placeholder="1209700000000">
                <div id="id-feedback" class="mt-2"></div>
              </div>
              <div class="mb-3" id="passportField" style="display:none;">
                <label for="passport" class="form-label">พาสปอร์ต <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="passport" id="passport" placeholder="ME027400">
                <div id="passport-feedback" class="mt-2"></div>
              </div>
              <div class="mb-3" id="alienField" style="display:none;">
                <label for="alien" class="form-label">เลขบัตรต่างด้าว <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="alien" id="alien" placeholder="0209700000000">
                <div id="alien-feedback" class="mt-2"></div>
              </div>
              <div class="mb-3 mt-4">
                <label for="" class="form-label">คำนำหน้าชื่อ <span class="text-danger">*</span> <span class="text-secondary">(ถ้ากรอกคำนำหน้าชื่อ แล้วถ้ามีข้อมูลจะแสดงโดยอัตโนมัติ)</span></label>
                <div class="position-relative">
                  <!-- <select class="form-select" id="" required="" name="prefix">
                    <option selected="" disabled="" value="">เลือก</option>
                    <?php //foreach ($get_prefix as $key => $pf) { 
                    ?>
                      <option value="<?php //echo $pf['pf_name']; 
                                      ?>"><?php //echo $pf['pf_name']; 
                                          ?></option>
                    <?php //} 
                    ?>
                  </select> -->
                  <input type="text" class="form-control" id="prefix" name="prefix" placeholder="นาย นาง นางสาว" required>
                </div>
              </div>
              <div class="mb-3 mt-4">
                <label for="" class="form-label">ชื่อ <span class="text-danger">*</span></label>
                <div class="position-relative">
                  <input type="text" class="form-control" name="fname" id="" required="" placeholder="จักษุ">
                </div>
              </div>
              <div class="mb-3 mt-4">
                <label for="" class="form-label">นามสกุล <span class="text-danger">*</span></label>
                <div class="position-relative">
                  <input type="text" class="form-control" name="lname" id="" required="" placeholder="สุราษฎร์">
                </div>
              </div>
              <div class="mb-3 mt-4">
                <label for="" class="form-label">วัน เดือน ปีเกิด <span class="text-danger">*</span></label>
                <div class="position-relative">
                  <div class="row">
                    <div class="col-6 col-md-3 mb-2  mb-md-0">
                      <select id="day" class="form-select" name='day' id="day">
                        <option value="">เลือกวัน</option>
                        <!-- Generate days options dynamically -->
                        <?php for ($i = 1; $i <= 31; $i++) : ?>
                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                      <select id="month" class="form-select" name='month'>
                        <option value="">เลือกเดือน</option>
                        <?php
                        $months = [
                          1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
                          7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
                        ];
                        foreach ($months as $num => $name) :
                        ?>
                          <option value="<?php echo $num; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                      <select id="year" class="form-select" name='year' id="year">
                        <option value="">เลือกปี</option>
                        <!-- Generate years options dynamically -->
                        <?php $currentYear = date('Y');
                        for ($i = $currentYear; $i >= $currentYear - 100; $i--) : ?>
                          <option value="<?php echo $i; ?>">
                            <?php echo $i + 543; ?>
                          </option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                      <input type="text" class="form-control" id="age" disabled style="cursor: not-allowed;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-3 mt-4">
                <label for="validation_tel" class="form-label">เบอร์โทรศัพท์ (ที่สามารถติดต่อได้) <span class="text-danger">*</span></label>
                <div class="position-relative">
                  <input type="number" class="form-control" name="tel" id="validation_tel" required="" placeholder="077276999">
                </div>
              </div>
              <hr class="mt-4">
              <div class="mb-3 mt-4">
                <label for="formSignUpPassword" class="form-label">รหัสผ่าน <span class="text-danger">*</span></label>
                <div class="password-field position-relative">
                  <input type="password" class="form-control mb-2 fakePassword" name="password" id="formSignUpPassword" required>
                  <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                </div>
                <div id="password-error" class="error-message"></div>
              </div>
              <div class="mb-3 mt-4">
                <label for="formSignUpPassword" class="form-label">ยืนยันรหัสผ่าน - อีกครั้ง <span class="text-danger">*</span></label>
                <div class="password-field position-relative">
                  <input type="password" class="form-control fakePassword" name="password_confirm" id="formSignUpPasswordConfirm" required>
                  <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                </div>
                <div id="password-confirm-error" class="error-message"></div>
              </div>
              <div class="mb-4 d-flex align-items-center justify-content-between mt-5">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="privacy" id="rememberMeCheckbox" value="Y">
                  <label class="form-check-label" for="rememberMeCheckbox">ยืนยันการเก็บข้อมูลนโยบายคุ้มครองข้อมูลส่วนบุคคล (Privacy Policy)
                    <a target="_blank" href="<?php echo site_url(); ?>/gear/frontend_privacy_policy">อ่านรายละเอียดเพิ่มเติม</a></label>
                </div>
              </div>
              <div class="d-grid mb-5">
                <button class="btn btn-secondary btn-lg" type="button" id="registerButton">ลงทะเบียน</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(function() {
    $("#prefix").autocomplete({
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

    document.getElementById('age').value = 'อายุ ' + (age - 543) + ' ปี';
  }
  // Function to check password validity
  function checkPassword() {
    const passwordInput = document.getElementById('formSignUpPassword');
    const passwordConfirmInput = document.getElementById('formSignUpPasswordConfirm');
    const passwordError = document.getElementById('password-error');
    const passwordConfirmError = document.getElementById('password-confirm-error');

    let valid = true;

    if (passwordInput.value.length < 8) {
      passwordError.textContent = 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร';
      valid = false;
    } else {
      passwordError.textContent = '';
    }

    // Check if passwords match
    if (passwordInput.value !== passwordConfirmInput.value) {
      passwordConfirmError.textContent = 'รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน';
      valid = false;
    } else {
      passwordConfirmError.textContent = '';
    }

    return valid;
  }

  // Show and hide fields based on registration type
  function toggleRegistrationFields() {
    const type = document.getElementById('registrationType').value;
    document.getElementById('citizenField').style.display = type === 'citizen' ? 'block' : 'none';
    document.getElementById('passportField').style.display = type === 'passport' ? 'block' : 'none';
    document.getElementById('alienField').style.display = type === 'alien' ? 'block' : 'none';

    // Clear inputs and feedbacks when switching types
    document.querySelectorAll('input').forEach(input => input.value = '');
    document.querySelectorAll('.success-message, .error-message').forEach(feedback => feedback.textContent = '');
    document.querySelectorAll('.form-control').forEach(input => input.classList.remove('is-invalid', 'valid-id'));
  }

  document.getElementById('registrationType').addEventListener('change', toggleRegistrationFields);

  // Call the function initially to set the default state
  toggleRegistrationFields();


  // Add event listeners to password fields
  document.getElementById('formSignUpPassword').addEventListener('input', checkPassword);
  document.getElementById('formSignUpPasswordConfirm').addEventListener('input', checkPassword);

  // Disable register button initially
  document.getElementById('registerButton').disabled = true;

  // Add event listener to checkbox
  document.getElementById('rememberMeCheckbox').addEventListener('change', function() {
    const registerButton = document.getElementById('registerButton');
    if (this.checked) {
      registerButton.disabled = false;
      registerButton.classList.remove('btn-secondary');
      registerButton.classList.add('btn-success');
    } else {
      registerButton.disabled = true;
      registerButton.classList.remove('btn-success');
      registerButton.classList.add('btn-secondary');
    }
  });

  // Function to validate Thai ID
  function validateThaiID(id) {
    if (id.length !== 13) return false;

    let sum = 0;
    for (let i = 0; i < 12; i++) {
      sum += parseInt(id.charAt(i)) * (13 - i);
    }
    const checkDigit = (11 - (sum % 11)) % 10;
    return checkDigit === parseInt(id.charAt(12));
  }

  // Select ID input and feedback elements
  const idInput = document.querySelector('input[name="identification"]');
  const idFeedback = document.getElementById('id-feedback');
  const alienInput = document.querySelector('input[name="alien"]');
  const alienFeedback = document.getElementById('alien-feedback');
  const passportInput = document.querySelector('input[name="passport"]');
  const passportFeedback = document.getElementById('passport-feedback');

  idInput.addEventListener('input', function() {
    if (this.value.length > 13) {
      this.value = this.value.slice(0, 13);
    }
  });

  // Function to validate Alien ID
  function validateAlienID(id) {
    if (id.length !== 13 || id.charAt(0) !== '0') return false;

    let sum = 0;
    for (let i = 0; i < 12; i++) {
      sum += parseInt(id.charAt(i)) * (13 - i);
    }
    const checkDigit = (11 - (sum % 11)) % 10;
    return checkDigit === parseInt(id.charAt(12));
  }

  alienInput.addEventListener('input', function() {
    if (this.value.length > 13) {
      this.value = this.value.slice(0, 13);
    }
  });

  alienInput.addEventListener('blur', function() {
    const alienNumber = alienInput.value;
    const type = 'alien';

    if (validateAlienID(alienNumber)) {
      checkIDInDatabase(alienNumber, type).then(exists => {
        if (exists) {
          alienInput.classList.remove('valid-id');
          alienInput.classList.add('is-invalid');
          alienFeedback.textContent = 'เลขบัตรต่างด้าวนี้มีอยู่แล้วในระบบ !';
          alienFeedback.className = 'error-message';
          document.getElementById('registerButton').disabled = true; // Disable register button
        } else {
          alienInput.classList.add('valid-id');
          alienInput.classList.remove('is-invalid');
          alienFeedback.textContent = 'ตรวจสอบเลขบัตรต่างด้าวแล้วถูกต้อง สามารถใช้งานได้';
          alienFeedback.className = 'success-message';
          document.getElementById('registerButton').disabled = false; // Enable register button
        }
      });
    } else {
      alienInput.classList.remove('valid-id');
      alienInput.classList.add('is-invalid');
      alienFeedback.textContent = 'เลขบัตรต่างด้าวไม่ถูกต้อง !';
      alienFeedback.className = 'error-message';
      document.getElementById('registerButton').disabled = true; // Disable register button
    }
  });

  passportInput.addEventListener('blur', function() {
    const passportNumber = passportInput.value;
    const type = 'passport';

    // Assuming a simple validation for passport numbers
    if (passportNumber.length > 0) {
      checkIDInDatabase(passportNumber, type).then(exists => {
        if (exists) {
          passportInput.classList.remove('valid-id');
          passportInput.classList.add('is-invalid');
          passportFeedback.textContent = 'พาสปอร์ตนี้มีอยู่แล้วในระบบ !';
          passportFeedback.className = 'error-message';
          document.getElementById('registerButton').disabled = true; // Disable register button
        } else {
          passportInput.classList.add('valid-id');
          passportInput.classList.remove('is-invalid');
          passportFeedback.textContent = 'ตรวจสอบพาสปอร์ตแล้วถูกต้อง สามารถใช้งานได้';
          passportFeedback.className = 'success-message';
          document.getElementById('registerButton').disabled = false; // Enable register button
        }
      });
    } else {
      passportInput.classList.remove('valid-id');
      passportInput.classList.add('is-invalid');
      passportFeedback.textContent = 'พาสปอร์ตไม่ถูกต้อง !';
      passportFeedback.className = 'error-message';
      document.getElementById('registerButton').disabled = true; // Disable register button
    }
  });


  // Function to check ID in the database
  function checkIDInDatabase(id, type) {
    return fetch('<?php echo site_url(); ?>/ums/frontend/Register_patient/check_id', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          id: id,
          type: type // Include type in the request
        }),
      })
      .then(response => response.json())
      .then(data => {
        return data.exists; // Assuming the server responds with { exists: true/false }
      });
  }

  // Add blur event listener to ID input
  idInput.addEventListener('blur', function() {
    const idNumber = idInput.value;
    const type = 'citizen';
    if (validateThaiID(idNumber)) {
      checkIDInDatabase(idNumber, type).then(exists => {
        if (exists) {
          idInput.classList.remove('valid-id');
          idInput.classList.add('is-invalid');
          idFeedback.textContent = 'เลขบัตรประชาชนนี้มีอยู่แล้วในระบบ !';
          idFeedback.className = 'error-message';
          document.getElementById('registerButton').disabled = true; // Disable register button
        } else {
          idInput.classList.add('valid-id');
          idInput.classList.remove('is-invalid');
          idFeedback.textContent = 'ตรวจสอบเลขบัตรประชาชนแล้วถูกต้อง สามารถใช้งานได้';
          idFeedback.className = 'success-message';
          document.getElementById('registerButton').disabled = false; // Enable register button
        }
      });
    } else {
      idInput.classList.remove('valid-id');
      idInput.classList.add('is-invalid');
      idFeedback.textContent = 'เลขบัตรประชาชนไม่ถูกต้อง !';
      idFeedback.className = 'error-message';
      document.getElementById('registerButton').disabled = true; // Disable register button
    }
  });




  document.getElementById('registerButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission

    const form = document.getElementById('registrationForm');
    const isPasswordValid = checkPassword(); // Check password validity

    if (!form.checkValidity() || !isPasswordValid) {
      event.stopPropagation();
      form.classList.add('was-validated');
      const firstInvalidField = document.querySelector('.needs-validation .form-control:invalid');
      if (firstInvalidField) {
        const fieldLabelElement = firstInvalidField.closest('.mb-3').querySelector('label');
        const fieldLabel = fieldLabelElement ? fieldLabelElement.textContent.trim() : 'ข้อมูลที่ต้องกรอก';
        Swal.fire({
          icon: 'error',
          title: 'ข้อมูลไม่ครบถ้วน',
          text: `กรุณากรอกข้อมูลในช่อง ${fieldLabel}`,
          confirmButtonText: 'รับทราบ'
        });
      }
      return;
    }

    const idNumber = idInput.value;
    const alienNumber = alienInput.value;
    const passportNumber = passportInput.value;
    const type = registrationType.value;

    if (idFeedback.textContent === 'เลขบัตรประชาชนนี้มีอยู่แล้วในระบบ !' || idFeedback.textContent === 'เลขบัตรประชาชนไม่ถูกต้อง !' ||
      alienFeedback.textContent === 'เลขบัตรต่างด้าวนี้มีอยู่แล้วในระบบ !' || alienFeedback.textContent === 'เลขบัตรต่างด้าวไม่ถูกต้อง !' ||
      passportFeedback.textContent === 'พาสปอร์ตนี้มีอยู่แล้วในระบบ !' || passportFeedback.textContent === 'พาสปอร์ตไม่ถูกต้อง !') {
      Swal.fire({
        icon: 'error',
        title: 'ตรวจสอบไม่สำเร็จ',
        text: idFeedback.textContent || alienFeedback.textContent || passportFeedback.textContent,
        confirmButtonText: 'รับทราบ'
      });
    } else if ((type === 'citizen' && validateThaiID(idNumber)) ||
      (type === 'alien' && validateAlienID(alienNumber)) ||
      (type === 'passport' && passportNumber.length > 0)) {
      const idToCheck = idNumber || alienNumber || passportNumber;
      checkIDInDatabase(idToCheck, type).then(exists => {
        if (exists) {
          Swal.fire({
            icon: 'error',
            title: 'ตรวจสอบไม่สำเร็จ',
            text: 'เลขบัตรนี้มีอยู่แล้วในระบบ !',
            confirmButtonText: 'รับทราบ'
          });
        } else {
          Swal.fire({
            icon: 'success',
            title: 'ตรวจสอบแล้วสำเร็จ',
            text: 'ข้อมูลทั้งหมดถูกต้อง ! และสามารถลงทะเบียนได้ คุณจะลงทะเบียนหรือไม่',
            confirmButtonText: 'ลงทะเบียน',
            showCancelButton: true,
            cancelButtonText: 'ยกเลิก'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        }
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'ตรวจสอบไม่สำเร็จ',
        text: 'เลขบัตรไม่ถูกต้อง !',
        confirmButtonText: 'รับทราบ'
      });
    }
  });
</script>
<?php if (isset($success) && $success) : ?>
  <script>
    <?php if ($this->config->item('ums_register') == 1) { ?>
      Swal.fire({
        icon: 'success',
        title: 'กรุณารอการอนุมัติจากเจ้าหน้าที่ ของโรงพยาบาล',
        html: 'คุณได้ลงทะเบียนเรียบร้อยแล้ว !',
        showConfirmButton: true,
        confirmButtonText: 'รับทราบ',
        allowOutsideClick: false, // Prevents closing by clicking outside the alert
        allowEscapeKey: false, // Prevents closing by pressing the escape key
        willClose: () => {
          window.location.href = "<?php echo site_url('gear/frontend_login'); ?>"; // Redirect after user confirmation
        }
      });
    <?php } else { ?>
      document.addEventListener("DOMContentLoaded", function() {
        let timerInterval;
        Swal.fire({
          icon: 'success',
          title: 'ลงทะเบียนสำเร็จ',
          html: 'คุณได้ลงทะเบียนเรียบร้อยแล้ว!<br>กำลังเปลี่ยนหน้าใน <b></b> วินาที.',
          timer: 3000, // Set the timer for 3 seconds
          timerProgressBar: true,
          showConfirmButton: false, // Hide the confirm button
          willOpen: () => {
            const b = Swal.getHtmlContainer().querySelector('b');
            timerInterval = setInterval(() => {
              b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
            }, 100);
          },
          willClose: () => {
            clearInterval(timerInterval);
            window.location.href = "<?php echo site_url('gear/frontend_login'); ?>"; // Redirect after 3 seconds
          }
        });
      });
    <?php  } ?>
  </script>
<?php endif; ?>
<script src="<?php echo base_url(); ?>assets/vendor/password/password.js"></script>