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
  <link href="<?php echo base_url(); ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.min.css" rel="stylesheet">
  <!-- Plugin CSS Files -->
  <!-- <link href="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.min.css" rel="stylesheet"> -->
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">


  <style>
    .iconlist i {
      font-size: 2.5rem;
      padding: 2px;
    }

    a:hover:not(.logo) {
      text-decoration: underline;
    }

    .logo img {
      max-height: 100px;
    }

    .logo span {
      font-size: 26px;
    }

    .card {
      --bs-card-bg: #ffffffe8;
    }

    input[type=hidden]>.invalid-feedback {
      border-color: var(--bs-form-invalid-border-color);
      padding-right: calc(1.5em + .75rem);
      background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e);
      background-repeat: no-repeat;
      background-position: right calc(.375em + .1875rem) center;
      background-size: calc(.75em + .375rem) calc(.75em + .375rem);
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
    div:where(.swal2-container) button:where(.swal2-styled).swal2-cancel {
      font-size: 1.25em;
    }
  </style>
</head>

<body>
  <div class="pattern-square"></div>
  <section class="py-4 py-lg-8">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="brand" class="mb-3 ms-3" style="width:150px">
            <h3 class="mb-3">เปลี่ยนรหัสผ่านระบบสารสนเทศองค์กร โรงพยาบาลจักษุสุราษฎร์</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container" id="forgotpassword-form">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
          <div class="card shadow-sm mb-6">
          <div class="card-body p-5">
            <?php if ($status == true){ ?>
              <?php if (isset($code)){ ?>
                <div class="row">
                    <div class="col-md-12" style="text-align:center;">
                    <?php if ($code) {?>
                      <i class="fa fa-check-circle-o" aria-hidden="true" style="font-size: 8em;color: #4caf50;"></i>
                    <?php }else {?>
                      <i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 7em;"></i>
                    <?php }?>
                      <h3 class="text-success"><?php echo $message;?></h3>
                      <a href="<?php echo base_url();?>" class="btn btn-secondary btn-lg mt-5">กลับสู่หน้าแรก</a>
                    </div>
                  </div>
              <?php } else { ?>
              <form class="needs-validation mb-6" novalidate="" method="post" action="<?php echo site_url(); ?>/ums/forgotpassword/input_generate_password" id="frmresetPassword">
                <div class="mb-3">
                  <label for="" class="form-label font-18">Password <span class="text-danger">*</span></label>
                  <div class="password-field position-relative">
                    <input type="password" class="form-control form-control-lg fakePassword " name="password" id="password" required="">
                    <span><i class="bi bi-eye-slash passwordToggler font-20"></i></span>
                  </div>
                </div>
                <div class="mb-3 mt-4">
                  <label for="" class="form-label font-18">Password - ยืนยันอีกครั้ง <span class="text-danger">*</span></label>
                  <div class="password-field position-relative">
                    <input type="password" class="form-control form-control-lg fakePassword " id="confirm-password" name="confirm-password" required="">
                    <span><i class="bi bi-eye-slash passwordToggler font-20"></i></span>
                  </div>
                </div>
                <input type="hidden" id="email" name="email" value="<?php echo $email??'' ;?>">
                <input type="hidden" id="token" name="token" value="<?php echo $token??'' ;?>">
              </form>
                <div class="d-grid mb-5 mt-5">
                  <button class="btn btn-success btn-lg" onclick="submit_reset_password()">ยืนยัน Password</button>
                </div>

            <?php } ?>
            <?php } else { ?>
              <?php if (isset($code)){?>
                <div class="row">
                  <div class="col-md-12" style="text-align:center;">
                      <?php if ($code) {?>
                        <i class="fa fa-check-circle-o" aria-hidden="true" style="font-size: 8em; color: #4caf50;"></i>
                      <?php }else {?>
                        <i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 7em;"></i>
                      <?php }?>
                    <h3><?php echo $message;?></h3>
                    <a href="<?php echo base_url();?>" class="btn btn-secondary btn-lg mt-5">กลับสู่หน้าแรก</a>
                  </div>
                </div>
              <?php }else {?>
                <div class="row">
                  <div class="col-md-12" style="text-align:center;">
                    <i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 7em;"></i>
                    <h3><?php echo $message;?></h3>
                    <a href="<?php echo base_url();?>" class="btn btn-secondary btn-lg mt-5">กลับสู่หน้าแรก</a>
                  </div>
                </div>
              <?php }?>
            <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="<?php echo base_url(); ?>assets/vendor/password/password.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.js"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script> -->
</body>
<script>

                      
    function validatePassword() {
      var count_valid = 0;

      $('#password').css('border-color','#ced4da');
      $('#confirm-password').css('border-color','#ced4da');

      
      if ($('#password').val().trim() == '' || $('#password').val().length  < 4) {
          count_valid++
          $('#password').css('border-color','red')
      }
      
      if ($('#confirm-password').val().trim() == '') {
          count_valid++
          $('#confirm-password').css('border-color','red')
      }

      if ($('#password').val().trim() != $('#confirm-password').val().trim()) {
          $('#confirm-password').css('border-color','red')
          $('#password').css('border-color','red')
          count_valid++
      }

      return (count_valid == 0) ? true : false;

    }
    function submit_reset_password() {
        if(validatePassword()){
            Swal.fire({
                title: 'แจ้งเตือน การเปลี่ยนรหัสผ่าน',
                text: "ท่านต้องการยืนยันการเปลี่ยนรหัสผ่านนี้หรือไม่",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
              }).then((result) => {
                if (result.isConfirmed) {
                    $('form#frmresetPassword').submit();
                }
              })
        }
    }
</script>
</html>