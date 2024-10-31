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
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar-locales-all.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

  <!-- =======================================================
  * Template Name: BoomAdmin
  * Updated: 20/8/2566 with Bootstrap v1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: Boom
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<style>
  .badge-number-system {
    position: absolute;
    transform: translate(0%, -50%);
    margin-left: 45px;
  }
  .border-custom {
  border: 0px solid #e1e1e199;
  box-sizing: border-box;
  border-right: 0;
  border-radius: 5px;
  transition: background-color 0.3s ease; /* Smooth transition for the hover effect */
  }

  .row > .col-4:nth-child(3n) {
    border-right: 0px solid #e1e1e199;
  }
  .row > .border-custom {
    margin-bottom: 10px; /* Space between rows to avoid overlap */
  }

  .border-custom:hover {
    background-color: #b7f7ff; /* Light blue background on hover */
    cursor: pointer; /* Change cursor to pointer on hover */
  }
  a{
    cursor: pointer;
  }
  .header-nav .profile .dropdown-item {
    font-size: 16px;
  }
  .header {
    height: 80px;
  }
  #main {
    margin-top: 90px;
  }
  @media (min-width: 1200px) {
    .logo {
        width: 400px;
    }
    #main, #footer {
        margin-left: 0px;
    }
  }
  
</style>

<body>
  <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center toggle-sidebar-btn">
    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="" style="max-height: 85px; margin-top: -5px;">
        <?php if($this->session->userdata('us_dp_id') == 1){ ?>
          <span class="d-none d-lg-block">โรงพยาบาลจักษุสุราษฎร์</span>
        <?php } else { ?>
          <span class="d-none d-lg-block">คลินิกบรรยงจักษุ</span>
        <?php } ?>
      </a>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <?php
        setlocale(LC_TIME, 'th_TH.utf8');
        // Array of Thai month names
        $thaiMonths = array(
          'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
          'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        );
        // Get current date
        echo '<span class="me-2">วันที่ ' . date('d') . ' ' . $thaiMonths[date('n') - 1] . ' พ.ศ. ' . (date('Y') + 543) . '</span>';
        ?>
        เวลา&nbsp;<div class="clock" id="clock"></div> &nbsp;น.
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <li class="nav-item dropdown ms-3 me-1">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="true">
            <i class="bi bi-grid font-24"></i>
            <span class="badge bg-success badge-number" style="inset: -5px -10px auto auto;"><?php echo $notification_person['count_noti_system']; ?></span>
          </a><!-- End Messages Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-25px, 35px); width:350px;">
            <div class="p-2">
              <div class="row g-0">
                <?php
                $icon = [
                  'bi-bar-chart-line-fill',
                  'bi-list-ol',
                  'bi-stopwatch-fill',
                  'ri-map-pin-time-fill',
                  'bi-aspect-ratio-fill',
                  'bi-people-fill',
                  'bi-person-lines-fill',
                  'bi-cash-coin',
                  'bi-house-door-fill',
                  'bi-line'
                ];
                $i = 0;
                foreach ($notification_person['systems'] as $row) {
                 ?>
                    <div class="col-4 mb-3 border-custom" onclick="show_modal_system(<?php echo $row['st_id']; ?>, '<?php echo $row['st_name_th']; ?>',<?php echo $row['st_count_noti']; ?>)"   data-toggle="tooltip" data-placement="top" title="<?php echo $row['st_name_th']; ?>">
                      <div class="row">
                        <div class="col-12">
                          <a class="dropdown-icon-item d-flex align-items-center flex-column p-4" href="#" style="height: 80px;">
                            <?php if (!empty($row['st_icon'])) { ?>
                              <span class="badge bg-danger badge-number-system"><?php echo ($row['st_count_noti'] != 0 ? $row['st_count_noti'] : ""); ?></span>
                              <img src="<?php echo base_url() . "index.php/ums/GetFile?type=system&image=" . $row['st_icon']; ?>" style="width:40px;">
                            <?php } else { ?>
                              <h1><i class="<?php echo $icon[$i]; ?> w-100"></i></h1>
                            <?php } ?>
                          </a>
                        </div>
                      </div>
                      <div class="row text-center">
                        <div class="col-12 p-2">
                          <a class="" href="#">
                            <span class="system-cut-name" style="color: #2d5568 !important; font-weight: 600;"><?php echo $row['st_name_abbr_en']; ?></span>
                          </a>
                        </div>
                      </div>
                    </div>
                <?php
                  $i++;
                } ?>
              </div> <!-- end row-->
            </div>
          </ul><!-- End Messages Dropdown Items -->

        </li>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?php echo site_url($this->config->item('hr_dir')."getIcon?type=".$this->config->item('hr_profile_dir')."profile_picture&image=".($profile_person['person_detail']->psd_picture!=''?$profile_person['person_detail']->psd_picture:"default.png"));?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $profile_person['person_detail']->pf_name_abbr.$profile_person['person_detail']->ps_fname; ?></span>
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

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

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

  <script>
    // When the button is clicked, load the modal content via AJAX
    function show_modal_system(st_id, st_name, st_count_noti) {
      
      switch (st_id) {
        case 1: // UMS
          window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
          break;
        case 2: // DIM
          if(st_count_noti > 0){
            $('#dim_system_modal').modal('show');
            $('#dim_system_modal .modal-title').text(st_name);
            $('#dim_system_modal #dim_hidden_st_id').val(st_id); // Set the hidden input field
          }
          else{
            window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
          }
          
          break;
        case 3: // HR
          window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
          // $('#hr_system_modal').modal('show');
          // $('#hr_system_modal .modal-title').text(st_name);
          // $('#hr_system_modal #hr_hidden_st_id').val(st_id); // Set the hidden input field
          break;
        case 4: // PMS
          if(st_count_noti > 0){
            window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
          }
          else{
            $('#pms_system_modal').modal('show');
            $('#pms_system_modal .modal-title').text(st_name);
            $('#pms_system_modal #pms_hidden_st_id').val(st_id); // Set the hidden input field
          }
          break;
        case 5: // AMS
          if(st_count_noti > 0){
            $('#ams_system_modal').modal('show');
            $('#ams_system_modal .modal-title').text(st_name);
            $('#ams_system_modal #ams_hidden_st_id').val(st_id); // Set the hidden input field
          }
          else{
            window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
          }
          break;
        case 6: // WTS
          window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
          break;
        case 7: // QUE
          if(st_count_noti > 0){
            $('#que_system_modal').modal('show');
            $('#que_system_modal .modal-title').text(st_name);
            $('#que_system_modal #que_hidden_st_id').val(st_id); // Set the hidden input field
          }
          else{
            window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
          }
          break;
        case 8: // LINE
        case 9: // STAFF
        case 10: // SEEDB
          window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
          break;
        default:
          dialog_error({'header': text_toast_default_error_header, 'body': 'ไม่สามารถเข้าสู่ระบบได้'});
          break;
      }
    }


    function redirect_to_gear(keyword) {
      const keywordToIdMap = {
        'ums': 1,
        'dim': '#dim_system_modal #dim_hidden_st_id',
        'hr': 3,
        'pms': '#pms_system_modal #pms_hidden_st_id',
        'ams': '#ams_system_modal #ams_hidden_st_id',
        'wts': 6,
        'que': '#que_system_modal #que_hidden_st_id',
        'line': 8,
        'staff': 9,
        'seedb': 10
      };

      let st_id;

      if (typeof keywordToIdMap[keyword] === 'string') {
        st_id = $(keywordToIdMap[keyword]).val();
      } else if (typeof keywordToIdMap[keyword] === 'number') {
        st_id = keywordToIdMap[keyword];
      } else {
        dialog_error({'header': text_toast_default_error_header, 'body': 'ไม่สามารถเข้าสู่ระบบได้'});
        return;
      }

      window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id;
    }



  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });

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

<!-- alert by notifications_department -->
<div class="toast-wts-alert-container position-fixed bottom-0 end-0 p-3"></div>
<audio id="myAudio" src="<?php echo base_url(); ?>assets/mp3/wts/wts_notification_department_sound.mp3"></audio>

<script>
    const wts_enable_to_alert = "<?php echo $this->config->item('wts_enable_to_alert'); ?>";
    const wts_enable_sound_alert = "<?php echo $this->config->item('wts_enable_sound_alert'); ?>";
    const wts_time_second_loop = "<?php echo $this->config->item('wts_time_second_loop'); ?>";
    
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
                            <div id="${toastId}" class="toast toast-wts-alert" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
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

    if(wts_enable_to_alert) {
        // check_que_appointment_doctor_wts_js(); // Call initially
        setInterval(check_que_appointment_doctor_wts_js, wts_time_second_loop); // Call every x seconds
    }
</script>