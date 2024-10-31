<style>
  .topbar {
    position: absolute;
    top: 105px;
    background: #006897;
    width: 100.65%;
    font-size: 16px;
    left: 0;
    z-index: 1;
  }

  .topbar2 {
    position: absolute;
    top: 105px;
    background: #006897;
    width: 100.65%;
    font-size: 16px;
    left: 0;
    z-index: -1;
  }

  .btn-login {
    position: absolute;
    right: 15%;
    top: 106px;
    z-index: 2;
  }

  @media (max-width: 992px) {
    .topbar {
      top: 96px;
    }

    .topbar2 {
      top: 96px;
    }

    .btn-login {
      top: 97px;
      right: 2%;
    }

    .main {
      zoom: 70%;
    }

    ul.dropdown-menu.dropdown-menu-end.dropdown-menu-arrow.profile.show {
      transform: translate(-30px, 145px) !important;
    }

    .dropdown-menu-arrow::before {
      z-index: -10 !important;
    }

    a.nav-link.nav-profile.d-flex.align-items-center.pe-0 {
      top: 100px !important;
      right: 5% !important;
    }

    .container-md,
    .container-sm,
    .container {
      max-width: 100%;
    }
  }

  @media (min-width: 992px) and (max-width: 1200px) {
    .header {
      zoom: 67%;
    }

    .topbar {
      top: 71px !important;
    }

    .btn-login {
      top: 72px;
      right: 10%;
    }

    a.nav-link.nav-profile.d-flex.align-items-center.pe-0 {
      top: 72px !important;
    }
  }

  @media (min-width: 1201px) and (max-width: 1473px) {
    .topbar {
      top: 84px;
    }

    .topbar2 {
      top: 84px;
    }

    .btn-login {
      top: 85px;
      right: 10%;
    }

    a.nav-link.nav-profile.d-flex.align-items-center.pe-0 {
      top: 87px !important;
    }
  }


  .nav_topbar {
    padding-left: 40px;
    padding-top: 8px;
    padding-bottom: 8px;
    color: beige;
  }

  .nav_topbar a {
    color: beige;
  }

  .nav_topbar a:hover {
    color: #ffca28;
  }

  #main {
    margin-top: 140px;
  }

  .form-floating>.form-control:focus~label,
  .form-floating>.form-control:not(:placeholder-shown)~label,
  .form-floating>.form-control-plaintext~label,
  .form-floating>.form-select~label {
    color: rgb(1 41 112);
  }

  hr.style-two {
    border: 2px;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), #cd9a00, rgba(0, 0, 0, 0));
    opacity: 1;
  }

  .btn-primary-search {
    background-color: #006897;
    border: 1.5px solid #FFC107;
    color: #FFF;
  }

  .btn-primary-search:hover {
    background-color: #0582bb;
    border: 1.5px solid #FFC107;
    color: #FFF;
  }

  .text-container {
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }

  .card-hover {
    cursor: pointer;
    display: block;
    transition: .3s ease-in-out;
    border: 1px solid #b9ccd5;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05);
  }

  .card-hover:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05);
    transform: translateY(-.50rem);
    border: 1px solid;
  }

  .card-hover .card-lift.active,
  .card-lift:focus,
  .card-lift:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05);
    transform: translateY(-.50rem);
    border: 1px solid;
    border-color: #717ff5 !important;
    background: #ebfdff !important;
  }

  .border-1 {
    border: 1px solid #e1e1e1;
  }

  .card-hover:focus,
  .card-hover:hover .border-1 {
    border-color: #717ff5;
  }

  .card-hover.active .border-1 {
    border-color: #717ff5;
  }

  .card-hover.active {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05);
    transform: translateY(-.50rem);
    border: 1px solid;
    border-color: #717ff5 !important;
    background: #ebfdff !important;
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

  .pattern-square {
    position: relative;
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

  .pattern-square2 {
    position: relative;
  }

  .pattern-square2:after {
    background-image: url(<?php echo base_url(); ?>assets/img/pattern/pattern-square2.svg);
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
    z-index: 1;
  }

  .card {
    --bs-card-spacer-y: 1.5rem;
    --bs-card-spacer-x: 1.5rem;
    --bs-card-title-spacer-y: 0.5rem;
    --bs-card-title-color: ;
    --bs-card-subtitle-color: ;
    --bs-card-border-width: var(--bs-border-width);
    --bs-card-border-color: var(--bs-border-color);
    --bs-card-border-radius: var(--bs-border-radius-lg);
    --bs-card-box-shadow: ;
    --bs-card-inner-border-radius: calc(var(--bs-border-radius-lg) - var(--bs-border-width));
    --bs-card-cap-padding-y: 0.75rem;
    --bs-card-cap-padding-x: 1.5rem;
    --bs-card-cap-bg: var(--bs-card-bg);
    --bs-card-cap-color: ;
    --bs-card-height: ;
    --bs-card-color: ;
    --bs-card-bg: var(--bs-white);
    --bs-card-img-overlay-padding: 1rem;
    --bs-card-group-margin: 1rem;
    word-wrap: break-word;
    background-clip: border-box;
    background-color: var(--bs-card-bg);
    border: var(--bs-card-border-width) solid var(--bs-card-border-color);
    border-radius: var(--bs-card-border-radius);
    color: var(--bs-body-color);
    display: flex;
    flex-direction: column;
    height: var(--bs-card-height);
    min-width: 0;
    position: relative;
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
</style>
<main id="main" class="main" style="min-height: 80vh;">
  <div class="container">
    <?php if (isset($session_view) && $session_view == 'frontend' && isset($user)) { ?>
      <?php if (!$this->session->userdata('pt_id')) { ?>
        <a type="button" class="btn btn-warning fw-bold btn-login" href="<?php echo site_url() . '/gear/frontend_login'; ?>"><i class="bi bi-box-arrow-in-right me-2"></i> ล็อกอินเข้าสู่ระบบ</a>
      <?php } else { ?>
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false" style="z-index: 2; position: absolute; right: 15%; color: #FFF; top:108px;">
          <?php if ($user->ptd_img) { ?>
            <img src="data:image/<?php echo $user->ptd_img_type; ?>;base64,<?php echo $user->ptd_img_code; ?>" alt="Profile" class="profileImage rounded-circle" style="width: 35px; height:35px;">
          <?php } else { ?>
            <img src="<?php echo base_url(); ?>assets/img/default-person.png" alt="Profile" class="profileImage rounded-circle" style="width: 35px; height:35px;">
          <?php } ?>
          <span class="d-md-block dropdown-toggle ps-2">
            <?php
            $pt_prefix = $this->session->userdata('pt_prefix') ? $this->session->userdata('pt_prefix') : $user->pt_prefix;
            $pt_fname = $this->session->userdata('pt_fname') ? $this->session->userdata('pt_fname') : $user->pt_fname;
            $pt_lname = $this->session->userdata('pt_lname') ? $this->session->userdata('pt_lname') : $user->pt_lname;
            $pt_member = $this->session->userdata('pt_member') ? $this->session->userdata('pt_member') : $user->pt_member;
            $pt_id = $this->session->userdata('pt_id') ? $this->session->userdata('pt_id') : $user->pt_id;
            ?>
            <?php echo $pt_prefix; ?> <?php echo $pt_fname; ?> <?php echo $pt_lname; ?>
          </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" style="">
          <li class="dropdown-header">
            <h6 class=" text-black ">HN : <?php echo $this->session->userdata('pt_member'); ?></h6>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <div class="nav d-flex flex-column">
          <?php if ($this->session->userdata('line_using_menu') == 'profile') { ?>
            <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center" id="homeLinkTab" data-bs-toggle="tab" href="#homeTab">
                <i class="bi bi-house-door-fill fa-fw"></i>
                <span>หน้าหลัก</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center active" id="personalInfoLinkTab" data-bs-toggle="tab" href="#personalInfoTab">
                <i class="bi bi-person-circle fa-fw"></i>
                <span>ข้อมูลส่วนตัว</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" id="appointmentHistoryLinkTab" data-bs-toggle="tab" href="#appointmentHistoryTab">
                <i class="bi bi-bookmark-heart-fill fa-fw"></i>
                <span>ประวัติการเข้าโรงพยาบาล</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <?php } else if ($this->session->userdata('line_using_menu') == 'history') { ?>
            <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center" id="homeLinkTab" data-bs-toggle="tab" href="#homeTab">
                <i class="bi bi-house-door-fill fa-fw"></i>
                <span>หน้าหลัก</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center" id="personalInfoLinkTab" data-bs-toggle="tab" href="#personalInfoTab">
                <i class="bi bi-person-circle fa-fw"></i>
                <span>ข้อมูลส่วนตัว</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center active" id="appointmentHistoryLinkTab" data-bs-toggle="tab" href="#appointmentHistoryTab">
                <i class="bi bi-bookmark-heart-fill fa-fw"></i>
                <span>ประวัติการนัดหมายแพทย์</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <?php } else if (isset($session_view) && $session_view == 'frontend') { ?>
            <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center active" id="homeLinkTab" data-bs-toggle="tab" href="#homeTab">
                <i class="bi bi-house-door-fill fa-fw"></i>
                <span>หน้าหลัก</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center" id="personalInfoLinkTab" data-bs-toggle="tab" href="#personalInfoTab">
                <i class="bi bi-person-circle fa-fw"></i>
                <span>ข้อมูลส่วนตัว</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" id="appointmentHistoryLinkTab" data-bs-toggle="tab" href="#appointmentHistoryTab">
                <i class="bi bi-bookmark-heart-fill fa-fw"></i>
                <span>ประวัติการเข้าโรงพยาบาล</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <?php } else { ?>
              <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center" id="homeLinkTab" data-bs-toggle="tab" href="#homeTab">
                <i class="bi bi-house-door-fill fa-fw"></i>
                <span>หน้าหลัก</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="dropdown-item d-flex align-items-center active" id="personalInfoLinkTab" data-bs-toggle="tab" href="#personalInfoTab">
                <i class="bi bi-person-circle fa-fw"></i>
                <span>ข้อมูลส่วนตัว</span>
              </a>  
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" id="appointmentHistoryLinkTab" data-bs-toggle="tab" href="#appointmentHistoryTab">
                <i class="bi bi-bookmark-heart-fill fa-fw"></i>
                <span>ประวัติการเข้าโรงพยาบาล</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <?php } ?>
            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" id="labResultsLinkTab" data-bs-toggle="tab" href="#labResultsTab">
                <i class="bi bi-envelope-paper-heart-fill fa-fw"></i>
                <span>ผลตรวจจากห้องปฏิบัติการ</span>
              </a>
            </li> -->
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" id="ChangePasswordTab" data-bs-toggle="tab" href="#ChangePassword">
                <i class="bi bi-key-fill fa-fw"></i>
                <span>เปลี่ยนรหัสผ่าน</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center text-danger" href="#" id="logoutBtnHome">
                <i class="bi bi-house-dash-fill fa-fw"></i>
                <span>ออกจากระบบ</span>
              </a>
            </li>
          </div>
        </ul>
      <?php } ?>
    <?php } ?>

    <?php
      $line_user_id = $this->session->userdata('line_user_id');
      $url_logout = isset($line_user_id) && $line_user_id ? site_url('line/Frontend/logout') : site_url('ums/frontend/Register_login/logout');
    ?>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn = document.getElementById('logoutBtnHome');
        if (logoutBtn) {
          logoutBtn.addEventListener('click', function(event) {
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
                window.location.href = "<?php echo $url_logout; ?>";
              }
            });
          });
        }

        var menuItems = document.querySelectorAll('.dropdown-item');
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
    </script>