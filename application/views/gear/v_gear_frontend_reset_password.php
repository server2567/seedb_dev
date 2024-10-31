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

<div class="row topbar">
  <div class="col-md-12 nav_topbar">
    <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
    &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    <a href="<?php echo site_url(); ?>/gear/frontend_login">
      &nbsp;<i class="bi bi-box-arrow-in-right"></i>&nbsp;
      <span class='font-16'>ล็อกอินเข้าสู่ระบบ</span>
    </a>
    <a href="<?php echo site_url(); ?>/gear/frontend_forget">
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <span class='font-16'>ลืมรหัสผ่าน</span>
    </a>
    &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    <span class='text-white font-16'>เปลี่ยนรหัสผ่าน</span>
  </div>
</div>

<div class="pattern-square"></div>
<section class="py-5 py-lg-4">
  <div class="container">
    <div class="row">
      <div class="col-xl-6 offset-xl-3 col-md-12 col-12">
        <div class="text-center">
          <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="brand" class="mb-3 ms-3" style="width:140px">
          <h2 class="mb-1">เปลี่ยนรหัสผ่าน</h2>
          <p class="mb-0 font-18 mt-2">
            ผู้ลงทะเบียนทำการกรอกรหัสผ่าน และยืนยันรหัสผ่านให้ถูกต้อง
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <div class="card shadow-sm mb-6">
          <div class="card-body">
            <form class="mb-6" id="changePasswordForm">
              <div class="mb-3 mt-4">
                <label for="formSignUpPassword" class="form-label">รหัสผ่าน <span class="text-danger">*</span> (รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร)</label>
                <div class="password-field position-relative">
                  <input type="password" class="form-control mb-2 fakePassword" name="new_password" id="formSignUpPassword" required>
                  <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                </div>
                <div id="password-error" class="error-message"></div>
              </div>
              <div class="mb-3 mt-4">
                <label for="formSignUpPasswordConfirm" class="form-label">ยืนยันรหัสผ่าน - อีกครั้ง <span class="text-danger">*</span></label>
                <div class="password-field position-relative">
                  <input type="password" class="form-control fakePassword" name="confirm_password" id="formSignUpPasswordConfirm" required>
                  <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                </div>
                <div id="password-confirm-error" class="error-message"></div>
              </div>
              <div class="mb-4 d-flex align-items-center justify-content-between mt-5">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="privacy" id="rememberMeCheckbox" value="Y">
                  <label class="form-check-label d-flex flex-column" for="rememberMeCheckbox">ยืนยันการเก็บข้อมูลนโยบายคุ้มครองข้อมูลส่วนบุคคล (Privacy Policy)
                    <a target="_blank" href="<?php echo site_url(); ?>/gear/frontend_privacy_policy">อ่านรายละเอียดเพิ่มเติม</a></label>
                </div>
              </div>
              <div class="d-grid mb-5">
                <button class="btn btn-secondary btn-lg" type="button" id="registerButton">ยืนยันการเปลี่ยนรหัสผ่าน</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
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

    if (passwordInput.value !== passwordConfirmInput.value) {
      passwordConfirmError.textContent = 'รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน';
      valid = false;
    } else {
      passwordConfirmError.textContent = '';
    }

    return valid;
  }

  $('#formSignUpPassword').on('input', checkPassword);
  $('#formSignUpPasswordConfirm').on('input', checkPassword);

  $('#registerButton').prop('disabled', true);

  $('#rememberMeCheckbox').change(function() {
    if (this.checked) {
      $('#registerButton').prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
    } else {
      $('#registerButton').prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
    }
  });

  $('#registerButton').click(function() {
    if (checkPassword()) {
      $.ajax({
        url: '<?php echo site_url('ums/frontend/Register_login/change_password'); ?>',
        type: 'POST',
        data: {
          new_password: $('#formSignUpPassword').val(),
          confirm_password: $('#formSignUpPasswordConfirm').val(),
          privacy: $('#rememberMeCheckbox').is(':checked') ? 'Y' : 'N'
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (data.status == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'เปลี่ยนรหัสผ่านสำเร็จ',
              text: 'รหัสผ่านของคุณถูกเปลี่ยนเรียบร้อยแล้ว',
              confirmButtonText: 'ไปยังหน้าเข้าสู่ระบบ'
            }).then(() => {
              <?php if($this->session->userdata('line_using_menu') == 'login'){ ?>
                  window.location.href = '<?php echo site_url('line/Frontend/frontend_login'); ?>';
                <?php }else{ ?>
                  window.location.href = '<?php echo site_url('gear/frontend_login'); ?>';
                <?php } ?>
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด',
              text: data.message
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'เกิดข้อผิดพลาดในการส่งคำขอ'
          });
        }
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด',
        text: 'รหัสผ่านไม่ตรงกันหรือไม่ถูกต้อง'
      });
    }
  });
});

</script>