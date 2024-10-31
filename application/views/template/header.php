<!DOCTYPE html>
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

  <!-- Google Icons -->
  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <!-- <link href="<?php echo base_url(); ?>assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->

  <!-- Plugin CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toast/bootstrap-show-toast.css" />
  <link href="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/css/select2.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/css/select2-bootstrap-5-theme.min.css" />

  <link href="<?php echo base_url(); ?>assets/vendor/dataTables/datatables.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/dataTables/buttons.dataTables.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo base_url() . "assets/plugins/flatpickr/flatpickr.min.css"; ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/plugins/flatpickr/material_blue.css"; ?>">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

  <!-- Vendor JS Files -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/chart.js/chart.umd.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/echarts/echarts.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/quill/quill.min.js"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/simple-datatables/simple-datatables.js"></script> -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/php-email-form/validate.js"></script>


  <!-- Plugin JS Files -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/toast/bootstrap-show-toast.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/js/select2.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/datatables.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/dataTables.buttons.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/buttons.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/jszip.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/pdfmake.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/vfs_fonts.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/vfs_fonts_thsarabun.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/buttons.html5.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/buttons.print.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/flatpickr/rangePlugin.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/flatpickr/flatpickr.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/flatpickr/th.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar-scheduler.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar-locales-all.min.js"></script>
 
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


  <!-- =======================================================
  * Template Name: BoomAdmin
  * Updated: 20/8/2566 with Bootstrap v1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: Boom
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="">
        <?php if($this->session->userdata('us_dp_id') == 1){ ?>
          <span class="d-none d-lg-block">โรงพยาบาลจักษุสุราษฎร์</span>
        <?php } else { ?>
          <span class="d-none d-lg-block">คลินิกบรรยงจักษุ</span>
        <?php } ?>
        </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <?php
        setlocale(LC_TIME, 'th_TH.utf8');
        $thaiMonths = array(
          'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
          'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        );
        echo '<span class="me-1">วันที่ ' . date('d') . ' ' . $thaiMonths[date('n') - 1] . ' พ.ศ. ' . (date('Y') + 543) . '</span>';
        ?>
        &nbsp;เวลา&nbsp;<div class="clock" id="clock"></div> &nbsp;น.
        <div class="ms-3 me-2 row g-0">
          <?php foreach ($systems as $row) { ?>
            <div class="col-4 ms-3 mb-4 border-custom" onclick="show_modal_system(<?php echo $row['st_id']; ?>, '<?php echo $row['st_name_th']; ?>')" data-toggle="tooltip" data-placement="top" title="<?php echo $row['st_name_th']; ?>">
              <div class="row">
                <div class="col-12">
                  <a class="dropdown-icon-item d-flex align-items-center flex-column p-2" href="#" style="height: 30px;">
                    <?php if (!empty($row['st_icon'])) { ?>
                      <img src="<?php echo base_url() . "index.php/ums/GetFile?type=system&image=" . $row['st_icon']; ?>" style="width:30px;">
                      <span class="system-cut-name font-12" style="color: #2d5568 !important; font-weight: 600;"><?php echo $row['st_name_abbr_en']; ?></span>
                    <?php } else { ?>
                      <h1><i class="<?php echo $icon[$i]; ?> w-100"></i></h1>
                    <?php } ?>
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div> <!-- end row-->
        <li class="nav-item dropdown pe-3">

        <?php if(!empty($profile_person)) { ?>
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($profile_person['person_detail']->psd_picture != '' ? $profile_person['person_detail']->psd_picture : "default.png")); ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $profile_person['person_detail']->pf_name_abbr . $profile_person['person_detail']->ps_fname; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6 class="mb-2"><?php echo $profile_person['person_detail']->pf_name_abbr.$profile_person['person_detail']->ps_fname." ".$profile_person['person_detail']->ps_lname; ?></h6>
              <?php
                $head = $profile_person['person_department_topic'][0];
                $row = $profile_person['person_department_detail'][0];
              ?>
              <span class="font-16 fw-medium"><?php echo (isset($row->pos_ps_code) ? $row->pos_ps_code : ""); ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a id="profile-link" class="dropdown-item d-flex align-items-center">
                <i class="bi bi-person"></i>
                <span>ข้อมูลส่วนตัว</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a id="change-key-link" class="dropdown-item d-flex align-items-center">
                <i class="bi bi-gear"></i>
                <span>เปลี่ยนรหัสผ่าน</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a id="user-manual-link" class="dropdown-item d-flex align-items-center">
                <i class="bi bi-question-circle"></i>
                <span>คู่มือการใช้งาน</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a id="logout-link" class="dropdown-item d-flex align-items-center" href="<?php echo base_url() ?>index.php/Gear/logout" style="background: #ffe9d9;">
                <i class="bi bi-box-arrow-right"></i>
                <span>ออกจากระบบ</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
        <?php } ?>

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
  <div class="alert alert-info" role="alert" id="countdownAlert" style="position: fixed; top: 65px; right: 30px; z-index: 1000; opacity: 0; transition: opacity 1s;"></div>
  <script>

    document.getElementById('profile-link').addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default link behavior
      var url = 'hr.profile.Profile_user.get_profile_user';
      window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + 3 + '/' + url;
      
    });
    document.getElementById('change-key-link').addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default link behavior
      var url = 'gear.changePassword';
      window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + 1 + '/' + url;
      
    });
    document.getElementById('user-manual-link').addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default link behavior
      
    });
    document.getElementById('logout-link').addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default link behavior

      Swal.fire({
        title: 'ออกจากระบบ ?',
        text: "คุณต้องการออกจากระบบหรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22a727  ',
        cancelButtonColor: '#eb5a5a',
        confirmButtonText: 'ใช่ ออกจากระบบ',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?php echo base_url() ?>index.php/Gear/logout"; // Redirect to logout URL
        }
      });
    });

    function updateClock() {
      let now = new Date();
      let hours = now.getHours().toString().padStart(2, '0');
      let minutes = now.getMinutes().toString().padStart(2, '0');
      let seconds = now.getSeconds().toString().padStart(2, '0');
      let time = hours + ':' + minutes + ':' + seconds;
      document.getElementById('clock').textContent = time;
    }

    setInterval(updateClock);
  </script>
  <script type="text/javascript">
      var originalCountdown = <?php echo $this->config->item('sess_time_to_update'); ?>;
      var countdown = originalCountdown;
      var alertShown = false;

      function resetCountdown() {
          countdown = originalCountdown;
          alertShown = false;
          var countdownAlert = document.getElementById('countdownAlert');
          if (countdownAlert) {
            countdownAlert.style.opacity = '0';
          }
      }

      function updateCountdown() {
          countdown--;

          if (countdown <= 100 && !alertShown) {
              var countdownAlert = document.getElementById('countdownAlert');
              if (countdownAlert) {
                countdownAlert.style.opacity = '1';
                alertShown = true;
              }
          }

          if (alertShown) {
              document.getElementById('countdownAlert').innerHTML = 'เมื่อไม่มีกิจกรรมใดๆ ในระบบฯ<br>ระบบจะปิดการทำงานในอีก: ' + countdown + ' วินาที';
          }

          if (countdown > 0) {
              setTimeout(updateCountdown, 1000);
          } else {
              window.location.href = '<?php echo site_url("gear/logout"); ?>';
          }
      }

      // เพิ่มการจับเหตุการณ์การขยับเมาส์, คลิก, หรือกดแป้นพิมพ์
      document.addEventListener('mousemove', resetCountdown);
      document.addEventListener('click', resetCountdown);
      document.addEventListener('keypress', resetCountdown);

      updateCountdown();
  </script>

  <!-- function for date flatpickr -->
  <script>
      function convertYearsToThai() {
          const calendar = document.querySelector('.flatpickr-calendar');
          if (!calendar) return;

          const years = calendar.querySelectorAll('.cur-year, .numInput');
          years.forEach(function(yearInput) {
              convertToThaiYear(yearInput);
          });

          const yearDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
          yearDropdowns.forEach(function(monthDropdown) {
              if (monthDropdown) {
                  monthDropdown.querySelectorAll('option').forEach(function(option) {
                      convertToThaiYearDropdown(option);
                  });
              }
          });

          const currentYearElement = calendar.querySelector('.flatpickr-current-year');
          if (currentYearElement) {
              const currentYear = parseInt(currentYearElement.textContent);
              if (currentYear < 2500) {
                  currentYearElement.textContent = currentYear + 543;
              }
          }
      }

      function convertToThaiYear(yearInput) {
          const currentYear = parseInt(yearInput.value);
          if (currentYear < 2500) { // Convert to B.E. only if not already converted
              yearInput.value = currentYear + 543;
          }
      }

      function convertToThaiYearDropdown(option) {
          const year = parseInt(option.textContent);
          if (year < 2500) { // Convert to B.E. only if not already converted
              option.textContent = year + 543;
          }
      }

      function formatDateToThai(date) {
          if(date) {
              const d = new Date(date);
              const year = d.getFullYear() + 543;
              const month = ('0' + (d.getMonth() + 1)).slice(-2);
              const day = ('0' + d.getDate()).slice(-2);
              return `${day}/${month}/${year}`;
          }
          return '';
      }

      function formatTime(time) {
          if(time) {
              // Assuming the input time format is HH:MM
              var parts = time.split(':');
              var hour = parts[0];
              var minute = parts[1];

              // Return the formatted time
              return `${hour}:${minute}`;
          }
          return '';
      }
  </script>

  <!-- alert by notifications_department -->
  <div class="toast-wts-alert-container position-fixed bottom-0 end-0 p-3"></div>
  <audio id="myAudio" src="<?php echo base_url(); ?>assets/mp3/wts/wts_notification_department_sound.mp3"></audio>

  <script>
      // from system's config 
      const wts_time_second_loop = "<?php echo $this->config->item('wts_time_second_loop'); ?>";
      
      // from user's config
      const wts_enable_to_alert = "<?php echo !empty($user_config) && !empty($user_config->usc_wts_is_noti) ? $user_config->usc_wts_is_noti : ""; ?>";
      const wts_enable_sound_alert = "<?php echo !empty($user_config) && !empty($user_config->usc_wts_is_noti_sound) ? $user_config->usc_wts_is_noti_sound : ""; ?>";
      
      function check_que_appointment_doctor_wts_js() {
          const url = '<?php echo base_url(); ?>index.php/ums/UMS_Controller/check_que_appointment_doctor_wts';
          $.post(url)
          .done(function(responseData) {
              var resultArray = JSON.parse(responseData);
              if (resultArray.result && resultArray.result.length > 0) {

                  // Delete old toast-alert
                  $('.toast-wts-alert-container .toast-wts-alert').remove();

                  // Iterate through the array using $.each
                  $.each(resultArray.result, function(index, item) {
                      // Create a new toast element
                      const toastId = 'toast-alert-que-appointment-' + index;
                      let toastElement = `
                              <div id="${toastId}" class="toast toast-wts-alert bg-warning" role="alert" aria-live="assertive" aria-atomic="true">
                                  <div class="toast-header bg-warning">
                                      <strong class="me-auto">${item.subject}</strong>
                                      <small>${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + " น."}</small>
                                      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                  </div>
                                  <div class="toast-body">
                                      ${item.detail}
                                  </div>
                              </div>`;

                      // Append the toast to the toast container
                      $('.toast-wts-alert-container').append(toastElement);

                      // Initialize and show the toast
                      var toast = new bootstrap.Toast(document.getElementById(toastId), {
                          autohide: false
                      });
                      toast.show();

                      if(wts_enable_sound_alert)
                          $("#myAudio")[0].play();
                  });
              }
          })
          .fail(function() {
              console.error("Error occurred");
          })
          .always(function() {
              // Optional: Code to execute always after request finishes
          });
      }

      // ถ้าต้องการให้ทำตลอด ต้องเอา if ออก
      // อนาคตย้ายไปทำใน background job
      if(wts_enable_to_alert) {
          // check_que_appointment_doctor_wts_js(); // Call initially
          setInterval(check_que_appointment_doctor_wts_js, wts_time_second_loop); // Call every x seconds
      }
  </script>

  <!-- Main Modal -->
  <!-- <div class="modal modal-lg" id="mainModal" tabindex="-1" aria-labelledby="mainModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mainModalTitle"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mainModalBody">

        </div>
        <div class="modal-footer" id="mainModalFooter">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div> -->
  <!-- End Main Modal -->