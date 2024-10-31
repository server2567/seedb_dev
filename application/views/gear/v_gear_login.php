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
  </style>
</head>

<body style="zoom:85%;">
  <div class="pattern-square"></div>
  <section class="py-4 py-lg-8">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="brand" class="mb-3 ms-3" style="width:150px">
            <h3 class="mb-3">เข้าสู่ระบบสารสนเทศองค์กร โรงพยาบาลจักษุสุราษฎร์</h3>
            <h4 class="mb-0">(สำหรับเจ้าหน้าที่)</h4>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section  style="margin-bottom: 150px;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
          <div class="card shadow-sm mb-6">
            <div class="card-body p-5">
              <form class="needs-validation mb-6" novalidate="" method="post" action="<?php echo base_url(); ?>index.php/Gear/check_login">
                <div class="mb-3">
                  <label for="" class="form-label font-18">
                    Username
                    <span class="text-danger">*</span>
                  </label>
                  <input type="text" class="form-control form-control-lg" name="username" id="" required="">
                </div>
                <div class="mb-3 mt-4">
                  <label for="" class="form-label font-18">Password <span class="text-danger">*</span></label>
                  <div class="password-field position-relative">
                    <input type="password" class="form-control form-control-lg fakePassword " name="password" id="" required="">
                    <span><i class="bi bi-eye-slash passwordToggler font-20"></i></span>
                  </div>
                </div>
                <!-- Select Department -->
                <div class="mb-3 mt-4">
                  <label for="department" class="form-label font-18">เลือกหน่วยงาน <span class="text-danger">*</span></label>
                  <select class="form-select form-select-lg" name="department" id="department" required="">
                    <?php foreach ($departments as $department): ?>
                      <option value="<?php echo $department['dp_id']; ?>" <?php echo ($department['dp_id'] == 1) ? 'selected' : ''; ?>>
                        <?php echo $department['dp_name_th']; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="mb-4 d-flex align-items-center justify-content-between mt-5">
                  <div class="form-check">
                  </div>
                  <div class="form-check"><a href="<?php echo site_url(); ?>/ums/forgotpassword" class="text-primary font-18">ลืมรหัสผ่าน</a></div>
                </div>
                <div class="d-grid mb-5">
                  <button class="btn btn-primary btn-lg" type="submit">เข้าสู่ระบบ</button>
                </div>
              </form>
              <div class="col-12">
                <div class="row iconlist mb-4 d-flex justify-content-center">
                  <div class="col-sm-3 under text-center mt-2">
                    <a href="<?php echo site_url('staff/Directory_profile') ?>" target="_blank" class="col-sm-3 under text-center mt-2" style="color:#b36b00;">
                      <i class="bi-person-circle"></i><br><span>ข้อมูลบุคลากร</span>
                    </a>
                  </div>
                  <div class="col-sm-3 under text-center mt-2 iconlist">
                    <a href="https://surateyehospital.com/" target="_blank" class="col-sm-3 under text-center mt-2" style="color:#009688;">
                      <i class="bi bi-browser-chrome"></i><br><span>Website</span>
                    </a>
                  </div>
                  <div class="col-sm-3 under text-center mt-2 iconlist">
                    <a href="https://www.facebook.com/profile.php?id=100090453678504" target="_blank" class="col-sm-3 under text-center mt-2" style="color:#00599f;">
                      <i class="bi bi-facebook"></i><br><span>Facebook</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
      <?php if (isset($login) && $login === 'loginfailed'): ?>
          Swal.fire({
              icon: 'error',
              title: 'เข้าสู่ระบบผิดพลาด',
              text: 'ไม่สามารถเข้าสู่ระบบได้ เนื่องจาก Username หรือ Password ผิดพลาด',
              confirmButtonText: 'ยืนยัน',
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?php echo site_url(); ?>/gear';
            }
          });
      <?php endif; ?>
  </script>
  <script src="<?php echo base_url(); ?>assets/vendor/password/password.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.js"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script> -->
</body>

</html>