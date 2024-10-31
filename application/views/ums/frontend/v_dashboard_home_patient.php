<style>.main{ background: #FFF; }</style>
<?php if (isset($session_view) && $session_view == 'frontend') { ?>
<div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar">
    <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
    &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
    <a href="<?php echo site_url(); ?>/ums/frontend/Dashboard_home_patient">
      &nbsp;<i class="bi bi-house-door"></i>&nbsp;
      <span class='font-16'>หน้าหลัก</span>
    </a>
  </div>
</div>
<?php } else { ?>
<div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar">
    <a href="<?php echo site_url().'/personal_dashboard/Personal_dashboard_Controller'?>">
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
<section class="py-5 py-lg-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12 col-12">
        <div class="mb-6 row">
          <div class="card-body">
            <div class="row">
              <div class="border rounded col-md-3 p-3 d-none d-md-block">
                <?php $this->load->view('ums/frontend/v_dashboard_menu'); ?>
              </div>
              <div class="col-md-9">
                <div class="col-lg-12 col-xl-12 ps-lg-4 ps-xl-6">
                  <div class="tab-content" id="tabContent">
                  <?php if ($this->session->userdata('line_using_menu') == 'profile') { ?>
                    <div class="tab-pane fade" id="homeTab" role="tabpanel" aria-labelledby="homeLinkTab">
                      <?php $this->load->view('ums/frontend/v_dashbaord_patient'); ?>
                    </div>
                    <div class="tab-pane fade show active" id="personalInfoTab" role="tabpanel" aria-labelledby="personalInfoLinkTab">
                      <?php $this->load->view('ums/frontend/v_personal_info'); ?>
                    </div>
                    <div class="tab-pane fade" id="appointmentHistoryTab" role="tabpanel" aria-labelledby="appointmentHistoryLinkTab">
                      <?php $this->load->view('ums/frontend/v_appointment_history'); ?>
                    </div>
                    <?php }else if ($this->session->userdata('line_using_menu') == 'history') { ?>
                    <div class="tab-pane fade" id="homeTab" role="tabpanel" aria-labelledby="homeLinkTab">
                      <?php $this->load->view('ums/frontend/v_dashbaord_patient'); ?>
                    </div>
                    <div class="tab-pane fade" id="personalInfoTab" role="tabpanel" aria-labelledby="personalInfoLinkTab">
                      <?php $this->load->view('ums/frontend/v_personal_info'); ?>
                    </div>
                    <div class="tab-pane fade show active" id="appointmentHistoryTab" role="tabpanel" aria-labelledby="appointmentHistoryLinkTab">
                      <?php $this->load->view('ums/frontend/v_appointment_history'); ?>
                    </div>
                    <?php } else if (isset($session_view) && $session_view == 'frontend') { ?>
                    <div class="tab-pane fade show active" id="homeTab" role="tabpanel" aria-labelledby="homeLinkTab">
                      <?php $this->load->view('ums/frontend/v_dashbaord_patient'); ?>
                    </div>
                    <div class="tab-pane fade" id="personalInfoTab" role="tabpanel" aria-labelledby="personalInfoLinkTab">
                      <?php $this->load->view('ums/frontend/v_personal_info'); ?>
                    </div>
                    <div class="tab-pane fade" id="appointmentHistoryTab" role="tabpanel" aria-labelledby="appointmentHistoryLinkTab">
                      <?php $this->load->view('ums/frontend/v_appointment_history'); ?>
                    </div>
                  <?php } else { ?>
                    <div class="tab-pane fade" id="homeTab" role="tabpanel" aria-labelledby="homeLinkTab">
                      <?php $this->load->view('ums/frontend/v_dashbaord_patient'); ?>
                    </div>
                    <div class="tab-pane fade show active" id="personalInfoTab" role="tabpanel" aria-labelledby="personalInfoLinkTab">
                      <?php $this->load->view('ums/frontend/v_personal_info'); ?>
                    </div>
                    <div class="tab-pane fade" id="appointmentHistoryTab" role="tabpanel" aria-labelledby="appointmentHistoryLinkTab">
                      <?php $this->load->view('ums/frontend/v_appointment_history'); ?>
                    </div>
                  <?php } ?>
                    <div class="tab-pane fade" id="labResultsTab" role="tabpanel" aria-labelledby="labResultsLinkTab">
                      <?php $this->load->view('ums/frontend/v_lab_results'); ?>
                    </div>
                    <div class="tab-pane fade" id="ChangePassword" role="tabpanel" aria-labelledby="ChangePasswordTab">
                      <?php $this->load->view('ums/frontend/v_change_password'); ?>
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
<script>
  <?php if ($this->session->flashdata('success')) : ?>
    Swal.fire({
      icon: 'success',
      title: 'ยินดีต้อนรับเข้าสู่<br>ระบบโรงพยาบาลจักษุสุราษฎร์',
      html: '<span class="font-24 text-success">เข้าสู่ระบบสำเร็จ</span>',
      text: '<?php echo $this->session->flashdata('success'); ?>',
      timer: 1000,
      timerProgressBar: true,
      showConfirmButton: false
    });
  <?php endif; ?>
  document.addEventListener('DOMContentLoaded', function() {
    const triggerTabList = document.querySelectorAll('#sidebarMenu a[data-toggle="tab"]');
    triggerTabList.forEach(triggerEl => {
      triggerEl.addEventListener('click', function (event) {
        event.preventDefault();
        const tabTarget = new bootstrap.Tab(document.querySelector(triggerEl.getAttribute('href')));
        tabTarget.show();
      });
    });
  });

</script>