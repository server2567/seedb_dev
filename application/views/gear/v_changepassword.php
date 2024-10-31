<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>โรงพยาบาลจักษุสุราษฎร์</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url(); ?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo base_url(); ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/fonts/Sarabun/css/Sarabun.css" rel="stylesheet">

  <!-- Vendor CSS Files --> 
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.min.css" rel="stylesheet">
  <!-- Plugin CSS Files -->
  <!-- <link href="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.min.css" rel="stylesheet"> -->
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">


  <style>
    .iconlist i {
      font-size: 2.5rem;
      padding: 2px;
    }

    a:hover:not(.logo) {
      text-decoration: underline;
    }

    .logo img {
      max-height: 100px;
    }

    .logo span {
      font-size: 26px;
    }

    .card {
      --bs-card-bg: #ffffffe8;
    }

    input[type=hidden]>.invalid-feedback {
      border-color: var(--bs-form-invalid-border-color);
      padding-right: calc(1.5em + .75rem);
      background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e);
      background-repeat: no-repeat;
      background-position: right calc(.375em + .1875rem) center;
      background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }

    .pattern-square:after {
      background-image: url(<?php echo base_url(); ?>assets/img/pattern/pattern-square.svg);
      background-position: top;
      bottom: 0;
      content: "";
      height: 312px;
      left: 0;
      -webkit-mask-image: linear-gradient(0deg, transparent 35%, #000 75%);
      mask-image: linear-gradient(0deg, transparent 35%, #000 75%);
      padding: 40px 0;
      position: absolute;
      right: 0;
      top: -20px;
      z-index: -1;
    }

    .passwordToggler {
      color: var(--bs-gray-800);
      cursor: pointer;
      font-size: 16px;
      line-height: 1;
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
    }
    div:where(.swal2-container) button:where(.swal2-styled).swal2-cancel {
      font-size: 1.25em;
    }
    .invalid-feedback {
      display: block; /* Ensure the feedback message is shown */
      color: red;     /* Color for visibility */
      font-size: 0.875rem;
      margin-top: 0.1rem;
    }

  </style>
</head>

<body>
  <div class="pattern-square"></div>
  <section class="py-4 py-lg-8">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="brand" class="mb-3 ms-3" style="width:150px">
            <h3 class="mb-3">เปลี่ยนรหัสผ่านระบบสารสนเทศองค์กร โรงพยาบาลจักษุสุราษฎร์</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container" id="forgotpassword-form">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
          <div class="card shadow-sm mb-6">
            <div class="row mt-5" style="display:none;" id="change_password_success">
              <div class="col-md-12" style="text-align:center;">
                <i class="fa fa-check-circle-o" aria-hidden="true" style="font-size: 8em;color: #4caf50;"></i>
                  <h3 class="text-success">ท่านได้เปลี่ยนรหัสผ่านสำเร็จแล้ว</h3>
                <a href="<?php echo site_url()."/".$this->config->item('pd_dir')."Home"; ?>" class="btn btn-secondary btn-lg mt-5 mb-5">กลับสู่หน้าแรก</a>
              </div>
            </div>
            <div class="card-body p-5" style="display:block;" id="form_change_password">
              <form class="needs-validation mb-6" novalidate="" method="post" action="" id="frmChangePassword">
                <div class="mb-3">
                  <label for="" class="form-label font-18">Password เก่า <span class="text-danger">*</span></label>
                  <div class="password-field position-relative">
                    <input type="password" class="form-control form-control-lg fakePassword" name="old-password" id="old-password" required="">
                    <span><i class="bi bi-eye-slash passwordToggler font-20"></i></span>
                    
                  </div>
                  <div id="old-password-feedback" class="invalid-feedback"></div>
                </div>
                <div class="mb-3 mt-4">
                  <label for="" class="form-label font-18">Password ใหม่ <span class="text-danger">*</span></label>
                  <div class="password-field position-relative">
                    <input type="password" class="form-control form-control-lg fakePassword" name="password" id="password" required="">
                    <span><i class="bi bi-eye-slash passwordToggler font-20"></i></span>
                  </div>
                  <div id="password-feedback" class="invalid-feedback"></div>
                </div>
                <div class="mb-3 mt-4">
                  <label for="" class="form-label font-18">Password ใหม่ - ยืนยันอีกครั้ง <span class="text-danger">*</span></label>
                  <div class="password-field position-relative">
                    <input type="password" class="form-control form-control-lg fakePassword" id="confirm-password" name="confirm-password" required="">
                    <span><i class="bi bi-eye-slash passwordToggler font-20"></i></span>
                  </div>
                  <div id="confirm-password-feedback" class="invalid-feedback"></div>
                </div>
              </form>
              <div class="d-grid mb-5 mt-5">
                <button type="button" class="btn btn-success btn-lg" onclick="submit_change_password()">ยืนยัน Password</button>
              </div>
            </div>
        </div>
      </div>
    </div>
  </section>
  <script src="<?php echo base_url(); ?>assets/vendor/password/password.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.js"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script> -->
</body>
<script>
  function validatePasswords() {
      let isValid = true; // ตัวแปรเพื่อเก็บสถานะว่าการตรวจสอบผ่านหรือไม่
      let oldPasswordFeedback = ''; // ข้อความแจ้งเตือนสำหรับรหัสผ่านเก่า
      let passwordFeedback = ''; // ข้อความแจ้งเตือนสำหรับรหัสผ่านใหม่
      let confirmPasswordFeedback = ''; // ข้อความแจ้งเตือนสำหรับการยืนยันรหัสผ่านใหม่

      // รีเซ็ตสีของกรอบอินพุต
      $('#old-password').css('border-color', '#ced4da');
      $('#password').css('border-color', '#ced4da');
      $('#confirm-password').css('border-color', '#ced4da');

      // ตรวจสอบความยาวของรหัสผ่านเก่า
      if ($('#confirm-password').val().trim() === '') {
          oldPasswordFeedback += 'กรุณากรอกรหัสผ่านเก่า';
          $('#old-password').css('border-color', 'red'); // เปลี่ยนสีกรอบเป็นสีแดงถ้าไม่ผ่าน
          isValid = false; // ตั้งค่าสถานะการตรวจสอบว่าไม่ผ่าน
      }

      // ตรวจสอบความยาวของรหัสผ่านใหม่
      if ($('#password').val().trim().length < 8) {
          passwordFeedback += 'รหัสผ่านใหม่ต้องมีอย่างน้อย 8 ตัวอักษร';
          $('#password').css('border-color', 'red'); // เปลี่ยนสีกรอบเป็นสีแดงถ้าไม่ผ่าน
          isValid = false; // ตั้งค่าสถานะการตรวจสอบว่าไม่ผ่าน
      }

      // ตรวจสอบการยืนยันรหัสผ่านใหม่
      if ($('#confirm-password').val().trim() === '') {
          confirmPasswordFeedback += 'กรุณายืนยันรหัสผ่านใหม่';
          $('#confirm-password').css('border-color', 'red'); // เปลี่ยนสีกรอบเป็นสีแดงถ้าไม่ผ่าน
          isValid = false; // ตั้งค่าสถานะการตรวจสอบว่าไม่ผ่าน
      } else if ($('#password').val().trim() !== $('#confirm-password').val().trim()) {
          confirmPasswordFeedback += 'รหัสผ่านไม่ตรงกัน';
          $('#confirm-password').css('border-color', 'red'); // เปลี่ยนสีกรอบเป็นสีแดงถ้าไม่ผ่าน
          $('#password').css('border-color', 'red'); // เปลี่ยนสีกรอบเป็นสีแดงถ้าไม่ผ่าน
          isValid = false; // ตั้งค่าสถานะการตรวจสอบว่าไม่ผ่าน
      }

      // แสดงข้อความแจ้งเตือน
      $('#old-password-feedback').text(oldPasswordFeedback).show();
      $('#password-feedback').text(passwordFeedback).show();
      $('#confirm-password-feedback').text(confirmPasswordFeedback).show();

      return isValid; // คืนค่าผลลัพธ์การตรวจสอบ
  }

  function validateOldPassword(callback) {
    let oldPasswordFeedback = ''; // ข้อความแจ้งเตือนสำหรับรหัสผ่านเก่า

    // การตรวจสอบรหัสผ่านเก่าโดยใช้ AJAX
    $.ajax({
        url: '<?php echo site_url(); ?>/Gear/check_old_password', // URL สำหรับตรวจสอบรหัสผ่านเก่า
        type: 'POST',
        data: { 'old-password': $('#old-password').val() }, // ส่งรหัสผ่านเก่าไปยังเซิร์ฟเวอร์
        success: function(data) { // เมื่อได้รับผลลัพธ์จากเซิร์ฟเวอร์
            let response = JSON.parse(data); // แปลงผลลัพธ์ที่ได้จาก JSON
            if (response > 0) { // ถ้ารหัสผ่านเก่าถูกต้อง
                callback(true); // เรียก callback ด้วยค่า true
            } else { // ถ้ารหัสผ่านเก่าไม่ถูกต้อง
                oldPasswordFeedback = response.message || 'รหัสผ่านเก่าไม่ถูกต้อง'; // แสดงข้อความแจ้งเตือนที่ได้จากเซิร์ฟเวอร์
                $('#old-password').css('border-color', 'red'); // เปลี่ยนสีกรอบเป็นสีแดง
                $('#old-password-feedback').text(oldPasswordFeedback).show(); // แสดงข้อความแจ้งเตือน
                callback(false); // เรียก callback ด้วยค่า false
            }
        },
        error: function() { // ถ้าเกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์
            oldPasswordFeedback = 'ไม่สามารถตรวจสอบรหัสผ่านเก่าได้'; // แสดงข้อความแจ้งเตือนข้อผิดพลาด
            $('#old-password').css('border-color', 'red'); // เปลี่ยนสีกรอบเป็นสีแดง
            $('#old-password-feedback').text(oldPasswordFeedback).show(); // แสดงข้อความแจ้งเตือน
            callback(false); // เรียก callback ด้วยค่า false
        }
    });
}

function submit_change_password() {
    if (validatePasswords()) { // ตรวจสอบรหัสผ่านทั้งหมด
        validateOldPassword(function (isValidOldPassword) { // ตรวจสอบรหัสผ่านเก่า
            if (isValidOldPassword) { // ถ้ารหัสผ่านเก่าถูกต้อง
                Swal.fire({ // แสดงข้อความยืนยันการเปลี่ยนรหัสผ่าน
                    title: 'แจ้งเตือน การเปลี่ยนรหัสผ่าน',
                    text: "ท่านต้องการยืนยันการเปลี่ยนรหัสผ่านนี้หรือไม่",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) { // ถ้าผู้ใช้ยืนยันการเปลี่ยนรหัสผ่าน
                        $.ajax({
                            url: '<?php echo site_url(); ?>/Gear/changePasswordUpdate', // URL สำหรับการบันทึกรหัสผ่าน
                            type: 'POST',
                            data: { 'password': $('#password').val() }, // ส่งรหัสผ่านไปยังเซิร์ฟเวอร์เพื่อบันทึกข้อมูล
                            success: function (data) { // เมื่อได้รับผลลัพธ์จากเซิร์ฟเวอร์
                                // ตรวจสอบสถานะจากเซิร์ฟเวอร์ว่าการบันทึกสำเร็จหรือไม่
                                data = JSON.parse(data); // แปลงผลลัพธ์ที่ได้จาก JSON
                                if (data == "success") {
                                    // ใช้เอฟเฟ็กต์ fadeOut เพื่อซ่อนแบบฟอร์มเปลี่ยนรหัสผ่าน
                                    $('#form_change_password').fadeOut('slow', function () {
                                        // หลังจากซ่อนแล้วให้แสดงข้อความสำเร็จด้วย fadeIn
                                        $('#change_password_success').fadeIn('slow');
                                    });
                                } else {
                                    // แสดงข้อความแจ้งเตือนถ้าการบันทึกล้มเหลว
                                    Swal.fire({
                                        title: 'เกิดข้อผิดพลาด',
                                        text: 'ไม่สามารถเปลี่ยนรหัสผ่านได้ กรุณาลองอีกครั้ง',
                                        icon: 'error',
                                        confirmButtonText: 'ตกลง'
                                    });
                                }
                            },
                            error: function () { // ถ้าเกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    text: 'ไม่สามารถเปลี่ยนรหัสผ่านได้ กรุณาลองอีกครั้ง',
                                    icon: 'error',
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                        });
                    }
                });
            }
        });
    }
}

</script>
</html>