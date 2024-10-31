<div class="card-header text-center border-bottom">
  <!-- Avatar -->
  <div class="avatar avatar-xl position-relative mb-2">
    <?php if($user->ptd_img){ ?>
      <img class="avatar-img rounded-circle border border-2 border-white profileImage" style="width:126px; height:126px;" 
      src="data:image/<?php echo $user->ptd_img_type; ?>;base64,<?php echo $user->ptd_img_code; ?>" alt="">
    <?php } else { ?>
      <img class="avatar-img rounded-circle border border-2 border-white profileImage" style="width:126px; height:126px;" 
      src="<?php echo base_url(); ?>assets/img/default-person.png" alt="">
    <?php } ?>
  </div>
  <?php
    $pt_prefix = $this->session->userdata('pt_prefix') ? $this->session->userdata('pt_prefix') : $user->pt_prefix;
    $pt_fname = $this->session->userdata('pt_fname') ? $this->session->userdata('pt_fname') : $user->pt_fname;
    $pt_lname = $this->session->userdata('pt_lname') ? $this->session->userdata('pt_lname') : $user->pt_lname;
    $pt_member = $this->session->userdata('pt_member') ? $this->session->userdata('pt_member') : $user->pt_member;
    $pt_id = $this->session->userdata('pt_id') ? $this->session->userdata('pt_id') : $user->pt_id;
  ?>
  <h5 class="mb-0">
    <?php echo $pt_prefix; ?> <?php echo $pt_fname; ?> <?php echo $pt_lname; ?>
  </h5>
  <h6 href="#" class="text-reset text-primary-hover mt-2">HN : 
    <?php echo $pt_member; ?>
  </h6>
</div>
<div class="card-body p-0 mt-4">
  <!-- Sidebar menu item START -->
  <ul class="nav nav-pills-primary-border-start flex-column" id="sidebarMenu">
    <?php if(isset($session_view) && $session_view == 'frontend'){ ?>
      <li class="nav-item">
        <a class="nav-link active" id="homeLinkTab" data-bs-toggle="tab" href="#homeTab"><i class="bi bi-house-door-fill fa-fw me-2"></i>หน้าหลัก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="personalInfoLinkTab" data-bs-toggle="tab" href="#personalInfoTab"><i class="bi bi-person-circle fa-fw me-2"></i>ข้อมูลส่วนตัว</a>
      </li>
    <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link" id="homeLinkTab" data-bs-toggle="tab" href="#homeTab"><i class="bi bi-house-door-fill fa-fw me-2"></i>หน้าหลัก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" id="personalInfoLinkTab" data-bs-toggle="tab" href="#personalInfoTab"><i class="bi bi-person-circle fa-fw me-2"></i>ข้อมูลส่วนตัว</a>
      </li>
    <?php } ?>
    <li class="nav-item">
      <a class="nav-link" id="appointmentHistoryLinkTab" data-bs-toggle="tab" href="#appointmentHistoryTab"><i class="bi bi-bookmark-heart-fill fa-fw me-2"></i>ประวัติการเข้าโรงพยาบาล</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" id="labResultsLinkTab" data-bs-toggle="tab" href="#labResultsTab"><i class="bi bi-envelope-paper-heart-fill fa-fw me-2"></i>ผลตรวจจากห้องปฏิบัติการ</a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" id="ChangePasswordTab" data-bs-toggle="tab" href="#ChangePassword"><i class="bi bi-key-fill fa-fw me-2"></i>เปลี่ยนรหัสผ่าน</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="#" id="logoutBtn" ><i class="bi bi-house-dash-fill fa-fw me-2"></i>ออกจากระบบ</a>
    </li>
  </ul>
  <!-- Sidebar menu item END -->
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var menuItems = document.querySelectorAll('#sidebarMenu .nav-link');
    menuItems.forEach(function(item) {
      item.addEventListener('click', function(event) {
        var menuName = this.innerText.trim();
        logMenuClick(menuName);
      });
    });
  });

  function logMenuClick(menuName) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo site_url('ums/frontend/Register_login/log_menu_click'); ?>', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        console.log('Menu click logged successfully');
      }
    };
    xhr.send('menuName=' + encodeURIComponent(menuName));
  }

  document.getElementById('logoutBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default link behavior

    Swal.fire({
      icon: 'warning',
      title: 'ยืนยันการออกจากระบบ',
      showCancelButton: true,
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ไม่ยืนยัน',
      reverseButtons: true,
      customClass: {
        confirmButton: 'btn btn-danger btn-lg ms-5',
        cancelButton: 'btn btn-secondary btn-lg me-5'
      },
      buttonsStyling: false
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?php echo site_url('ums/frontend/Register_login/logout'); ?>";
      }
    });
  });
</script>
