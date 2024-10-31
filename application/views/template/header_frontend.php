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
  <link href="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/css/select2.min.css" /> -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/css/select2-bootstrap-5-theme.min.css" />
  <link href="<?php echo base_url(); ?>assets/vendor/dataTables/datatables.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/dataTables/buttons.dataTables.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo base_url() . "assets/plugins/flatpickr/flatpickr.min.css"; ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/plugins/flatpickr/material_blue.css"; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . "assets/plugins/jquery/jquery-ui-1.13.3.css"; ?>">

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
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/html2canvas/html2canvas.min.js"></script>


  <!-- Plugin JS Files -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/toast/bootstrap-show-toast.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-ui-1.13.3.min.js"></script>
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

</head>
<style>
@media (max-width: 1473px) {
 .header {
  zoom:80%
 }
 .logo img {
  max-height: 50px; 
 }
}
@media (min-width: 1473px) {
  .logo img {
    max-height: 75px; 
  }
}
div:where(.swal2-container) .swal2-html-container {
  line-height: 2;
}
.logo {
    margin-left: 0px !important;
}
</style>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center p-3" style="height: auto">
  <div class="container" style="max-width: 100%;">
    <div class="row w-100">
        <div id ="topbar_head" class="col-12 col-sm-12 col-md-12 col-lg-3">
          <a href="#" class="logo align-items-center">
            <img  src="<?php echo base_url(); ?>assets/img/apple-touch-icon2.png" alt="" class="img-width" style="margin-right: 20px; margin-right: 0px;">
            <span class="font-24"><?php echo $this->config->item('ums_dp_name'); ?></span>
          </a>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-3 mt-2 d-none d-lg-block  ">
              <i class="bi bi-telephone-fill font-24" style="position: absolute; margin-top: 5px;"></i>
              <b class="font-16" style="margin-left: 33px;"><a style="color:#012970;" href="tel:<?php echo $this->config->item('ums_tel'); ?>"><?php echo $this->config->item('ums_tel'); ?></a></b><br>
              <p class="font-16" style="margin-left: 33px;"><a style="color:#012970;" href="mailto:<?php echo $this->config->item('ums_email'); ?>"><?php echo $this->config->item('ums_email'); ?></a></p>
            </div>
            <div class="col-md-3 mt-2 d-none d-lg-block">
              <i class="bi bi-house-door font-24" style="position: absolute; margin-top: 5px;"></i>
              <b class="font-16" style="margin-left: 33px;"><a style="color:#012970;" target="_blank" href="<?php echo $this->config->item('ums_google_map');?>"><?php echo $this->config->item('ums_address_top'); ?></a></b><br>
              <p class="font-16" style="margin-left: 33px;"><a style="color:#012970;" target="_blank" href="<?php echo $this->config->item('ums_google_map');?>"><?php echo $this->config->item('ums_address_bottom'); ?></a></p>
            </div>
            <div class="col-md-3 mt-2 d-none d-lg-block">
              <i class="bi bi-calendar3 font-24" style="position: absolute; margin-top: 5px;"></i>
              <b class="font-16" style="margin-left: 33px;"><?php echo $this->config->item('ums_date_top'); ?></b><br>
              <p class="font-16" style="margin-left: 33px;"><?php echo $this->config->item('ums_date_bottom'); ?></p>
            </div>
            <div class="col-md-3 mt-2 d-none d-lg-block" style="color: #0ba111;">
              <i class="bi bi-line font-30" ></i>
              <b class="font-16" style="margin-left: 5px;">
                <a target="_blank" style="color: #0ba111;" href="//line.me/ti/p/~<?php echo $this->config->item('ums_line'); ?>">
                  <?php echo $this->config->item('ums_line'); ?>
                </a>
              </b>
            </div>
          </div>
        </div>
    </div>
  </div>
  </header>
  <div class="alert alert-info" role="alert" id="countdownAlert" style="position: fixed; top: 150px; right: 30px; z-index: 1000; opacity: 0; transition: opacity 1s;"></div>
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
              window.location.href = '<?php echo site_url("ums/frontend/Register_login/logout"); ?>';
          }
      }

      // เพิ่มการจับเหตุการณ์การขยับเมาส์, คลิก, หรือกดแป้นพิมพ์
      document.addEventListener('mousemove', resetCountdown);
      document.addEventListener('click', resetCountdown);
      document.addEventListener('keypress', resetCountdown);

      updateCountdown();
  </script>

