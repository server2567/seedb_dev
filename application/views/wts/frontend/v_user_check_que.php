<?php if (isset($session_view) && $session_view == 'frontend') { ?>
  <div class="row topbar toggle-sidebar-btn">
    <div class="col-md-12 nav_topbar">
      <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a href="<?php echo site_url(); ?>/ums/frontend/Dashboard_home_patient">
        &nbsp;<i class="bi bi-house-door"></i>&nbsp;
        <span class='font-16'>หน้าหลัก</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a href="<?php echo site_url(); ?>/ums/frontend/Dashboard_home_patient/news_all">
        &nbsp;<i class="bi bi-card-checklist"></i>&nbsp;
        <span class='font-16'>หน้าตรวจสอบคิว</span>
      </a>
    </div>
  </div>
<?php } else { ?>
  <div class="row topbar toggle-sidebar-btn">
    <div class="col-md-12 nav_topbar">
      <a href="<?php echo site_url() . '/personal_dashboard/Personal_dashboard_Controller' ?>">
        <span class='font-16'>หน้า PD</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a id="prevPageLink" href="#">
        <span id="prevPageText" class='font-16'>จัดการข้อมูลผู้ลงทะเบียน / ผู้ป่วย</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      &nbsp;<i class="bi bi-person-circle text-white"></i>&nbsp;
      <span class='font-16 text-white'>หน้าข้อมูลส่วนตัวผู้ลงทะเบียน / ผู้ป่วย</span>
    </div>
  </div>
  <script>
    // Function to set the previous page URL and text
    function setPreviousPage() {
      var prevPage = document.referrer;
      var prevPageText = 'จัดการข้อมูลผู้ลงทะเบียน / ผู้ป่วย'; // Default text

      if (prevPage.includes('personal_dashboard/Personal_dashboard_Controller')) {
        prevPageText = 'หน้าหลัก (PD)';
      } else if (prevPage.includes('some_other_page')) {
        prevPageText = 'หน้าอื่นๆ'; // Adjust this condition and text based on your needs
      }

      var prevPageLink = document.getElementById('prevPageLink');
      var prevPageTextElement = document.getElementById('prevPageText');

      if (prevPageLink && prevPageTextElement) {
        prevPageLink.href = prevPage;
        prevPageTextElement.textContent = prevPageText;
      }
    }

    // Set the previous page on page load
    document.addEventListener('DOMContentLoaded', setPreviousPage);
  </script>
<?php } ?>
<div class="card mt-5">
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">ตรวจสอบคิวของผู้ป่วย<?php echo $stde_name[0]->stde_name_th; ?></h5>
        </div>
        <br>
        <form class="row g-3 needs-validation" novalidate method="post" id="check_que_form">
            <div class="mb-3">
                <label for="que_id" class="form-label required">หมายเลขคิว (กรอกเฉพาะตัวเลข)</label>
                <div class="input-group">
                  <!-- <span class="input-group-text" id="basic-addon1"><?php echo isset($key) ? $key : ''; ?></span> -->
                  <input type="text" class="form-control" name="que_id" id="que_id" placeholder="000" minlength="3" maxlength="3" style="height: 90px; font-size: 26px;" required pattern="\d*" inputmode="numeric">
                </div>
            </div>
            <input type="hidden" class="form-control" name="stde" id="stde" value="<?php echo $stde; ?>">
            <input type="hidden" class="form-control" name="qr_id" id="qr_id" value="<?php echo $qr_id; ?>">
            <div class="col-12">
                <button type="button" class="btn btn-success w-100 btn-lg swal-delete" id="check_que_btn">ตรวจสอบ</button>
            </div>
        </form>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#check_que_btn').on('click', function() {
        var formData = $('#check_que_form').serializeArray(); // Serialize form data

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/wts/frontend/User_check_que/que_check',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    Swal.fire({
                        icon: "error",
                        title: "เลขคิวของท่านไม่ถูกต้อง",
                        text: "หรือ ไม่พบเลขนัดหมาย",
                    });
                } else if (response.status === 'success') {
                    setTimeout(function() {
                        window.location.href = response.returnUrl;
                    }, 1000);
                }
            }
        });
    });
});

    function dialog_error(options) {
        // Custom function to show error dialog
        alert(options.header + '\n' + options.body);
    }

    function dialog_success(options) {
        // Custom function to show success dialog
        alert(options.header + '\n' + options.body);
    }
</script>
