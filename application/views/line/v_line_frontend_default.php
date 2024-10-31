<?php

/*
* v_line_login
* (หน้าจอสำหรับ LINE การกดคลิกเลือกเมนู)
* input : LINE id
* author: Tanadon
* Create Date : 2024-07-17
*/
?>
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

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Plugin CSS Files -->
  <link href="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.min.css" rel="stylesheet">
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

  <style>
      body{
            background-color: #fff;
      }
      #loader {
            border: 12px solid #f3f3f3;
            border-radius: 50%;
            border-top: 12px solid #008eff;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
      }

      .center {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
      }

      @keyframes spin {
            100% {
                  transform: rotate(360deg);
            }
      }
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
  </style>
</head>
<body>
      <input type='hidden' id='selected_system' value='<?php echo $selected_system; ?>'>
      <div id="loader" class="center"></div>
</body>
</html>

<!-- LINE LIFF -->
<script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
<script type="text/javascript">

// Main function to handle the LINE LIFF initialization and login
async function main() {
    
    // Get the selected system value from the hidden input field
    var selected_system = $('#selected_system').val();
    
    // Set the default LIFF ID
    var liff_id = '<?php echo $this->config->item('default_liff_id'); ?>';  //default of liff ID 

    // Change the LIFF ID based on the selected system
    if(selected_system == 'profile'){
        liff_id = '<?php echo $this->config->item('profile_liff_id'); ?>';       //ข้อมูลส่วนตัว
    }
    else if(selected_system == 'noti'){
        liff_id = '<?php echo $this->config->item('noti_liff_id'); ?>';       //การแจ้งเตือน
    }
    else if(selected_system == 'wts'){
        liff_id = '<?php echo $this->config->item('wts_liff_id'); ?>';       //จัดการการรอคอย
    }
    else if(selected_system == 'rch'){
        liff_id = '<?php echo $this->config->item('rch_liff_id'); ?>';       //ตารางแพทย์ออกตรวจ
    }
    else if(selected_system == 'que'){
        liff_id = '<?php echo $this->config->item('que_liff_id'); ?>';       //จัดการคิว
    }

    // Initialize the LIFF app
    try {
        await liff.init({ liffId: liff_id, withLoginOnExternalBrowser: true });
        if (!liff.isLoggedIn()) {
            // If the user is not logged in, redirect to the login page
            liff.login();
        } else {
            // If the user is logged in and a system is selected, trigger the system click
            if (selected_system != '') {
                click_system(selected_system);
            }
        }
    } catch (err) {
      //   console.error('LIFF initialization failed', err);
        alert('LIFF initialization failed: ' + JSON.stringify(err));
    }
}

// Call the main function
main();

// Function to handle system click actions
async function click_system(system) {
    try {
        // Get the user's LINE profile
        const profile = await liff.getProfile();
        let line_user_id = profile.userId;

        // Redirect to the system access URL with the user's LINE ID
        window.location.href = "<?php echo site_url();?>/line/Frontend/access_system/" + system + '/' + line_user_id;
    } catch (error) {
      //   console.error('Error in click_system:', error);
        alert('Error: ' + error.message);
    }
}

</script>

