<div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar">
    <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
    &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    <a href="<?php echo site_url(); ?>/gear/frontend_login">
      &nbsp;<i class="bi bi-box-arrow-in-right"></i>&nbsp;
      <span class='font-16'>ล็อกอินเข้าสู่ระบบ</span>
    </a>
    &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    <span class='text-white font-16'>ลืมรหัสผ่าน</span>
  </div>
</div>
<div class="pattern-square"></div>
<section class="py-5 py-lg-4">
  <div class="container">
    <div class="row">
      <div class="col-xl-6 offset-xl-3 col-md-12 col-12">
        <div class="text-center">
          <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="brand" class="mb-3 ms-3" style="width:140px">
          <h2 class="mb-1">ลืมรหัสผ่าน</h2>
          <p class="mb-0 font-18 mt-2">
            ผู้ลงทะเบียนจะต้องกรอกข้อมูลที่ท่านทำการลงทะเบียนไว้ให้ถูกต้องครบถ้วน<br>ถ้าผู้ลงทะเบียนจำรายละเอียดไม่ได้ กรุณาติดต่อเจ้าหน้าที่ของโรงพยาบาลจักษุสุราษฎร์
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
            <form class="mb-6" id="verifyForm">
              <div class="mb-3">
                <label for="id_number" class="form-label">
                  เลขบัตรประจำตัวประชาชน / พาสปอร์ต / เลขบัตรต่างด้าว ที่ลงทะเบียน
                  <span class="text-danger">*</span>
                </label>
                <input type="number" class="form-control" id="id_number" name="id_number" required="" placeholder="1209700000000">
              </div>
              <div class="mb-3 mt-4">
                <label for="first_name" class="form-label">
                  ชื่อ <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" id="first_name" name="first_name" required="" placeholder="จักษุ">
              </div>
              <div class="mb-3 mt-4">
                <label for="last_name" class="form-label">
                  นามสกุล<span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" id="last_name" name="last_name" required="" placeholder="สุราษฎร์">
              </div>
              <div class="mb-3 mt-4">
                <label for="birthdate" class="form-label">วัน เดือน ปีเกิด <span class="text-danger">*</span></label>
                <div class="position-relative">
                  <div class="row">
                    <div class="col-3">
                      <select id="day" class="form-select" name='day' id="day" required>
                        <option value="">เลือกวัน</option>
                        <!-- Generate days options dynamically -->
                        <?php for ($i = 1; $i <= 31; $i++) : ?>
                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="col-3">
                      <select id="month" class="form-select" name='month' required>
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
                    <div class="col-3">
                      <select id="year" class="form-select" name='year' id="year" required>
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
                    <div class="col-3">
                      <input type="text" class="form-control" id="age" disabled style="cursor: not-allowed;" placeholder="อายุ">
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-5">
                <label for="phone" class="form-label"> เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="phone" name="phone" required="" placeholder="077276999">
              </div>
              <div class="d-grid mb-5 mt-3">
                <button type="button" id="verifyButton" class="btn btn-primary btn-lg">ยืนยันตัวตน</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
  calculateAge();

  document.getElementById('day').addEventListener('change', calculateAge);
  document.getElementById('month').addEventListener('change', calculateAge);
  document.getElementById('year').addEventListener('input', calculateAge);

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

    document.getElementById('age').value = 'อายุ ' + (age - 543 ) + ' ปี';
  }
});

$(document).ready(function() {
  $('#verifyButton').click(function() {
      var id_number = $('#id_number').val();
      var first_name = $('#first_name').val();
      var last_name = $('#last_name').val();
      var phone = $('#phone').val();
      var birth_date = $('#year').val() + '-' + $('#month').val() + '-' + $('#day').val();

      $.ajax({
          url: '<?php echo site_url('ums/frontend/Register_login/verify_user'); ?>',
          type: 'POST',
          data: {
              id_number: id_number,
              first_name: first_name,
              last_name: last_name,
              phone: phone,
              birth_date: birth_date
          },
          success: function(response) {
              try {
                  var data = JSON.parse(response);
                  if (data.status == 'success') {
                      Swal.fire({
                          icon: 'success',
                          title: 'ยืนยันตัวตนสำเร็จ',
                          text: 'คุณสามารถเปลี่ยนรหัสผ่านได้',
                          confirmButtonText: 'ยืนยัน',
                          showCancelButton: true,
                          cancelButtonText: 'ยกเลิก'
                      }).then((result) => {
                          if (result.isConfirmed) {
                            window.location.href = data.redirect_url;
                          }
                      });
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'ข้อมูลไม่ตรงกับที่ลงทะเบียน',
                          text: data.message
                      });
                  }
              } catch (e) {
                  console.error('Invalid JSON response from server:', response);
                  Swal.fire({
                      icon: 'error',
                      title: 'เกิดข้อผิดพลาด',
                      text: 'Server returned invalid response.'
                  });
              }
          },
          error: function(xhr, status, error) {
              console.error('AJAX error:', status, error);
              Swal.fire({
                  icon: 'error',
                  title: 'เกิดข้อผิดพลาด',
                  text: 'Could not complete the request. Please try again later.'
              });
          }
      });
  });
});


</script>