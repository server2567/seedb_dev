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

<body>
  <div class="pattern-square"></div>
  <section class="py-4 py-lg-8">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="brand" class="mb-3 ms-3" style="width:150px">
            <h3 class="mb-3">กรุณากรอก Email โรงพยาบาลจักษุสุราษฎร์ ของท่านเพื่อเปลี่ยนรหัสผ่าน</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
          <div class="card shadow-sm mb-6">
            <div class="card-body p-5">
              <form class="needs-validation mb-6" novalidate="" method="post" action="<?php echo base_url(); ?>index.php/ums/forgotpassword">
                <div class="mb-5">
                  <label for="" class="form-label font-18">
                    Email (โรงพยาบาลจักษุสุราษฎร์)
                    <span class="text-danger">*</span>
                  </label>
                  <input type="email" class="form-control form-control-lg" name="email" required id= "email"  placeholder="Email Address">
                </div>
                <div class="d-grid mb-5 mt-5 col-6 mx-auto">
                  <button type="submit" class="btn btn-info btn-lg">ส่ง Email เพื่อเปลี่ยนรหัสผ่าน</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.js"></script>
<script>
  <?php if (isset($status) && $status === 'success'): ?>
    Swal.fire({
      icon: '<?php echo $status; ?>' === 'success' ? 'success' : 'error',
      title: '<?php echo $message; ?>',
      confirmButtonText: 'ยืนยัน'
    }).then((result) => {
      if (result.isConfirmed) {
        if ('<?php echo $status; ?>' === 'success') {
          // Show another modal to confirm redirection after a delay
          Swal.fire({
            title: 'กำลังจะเปลี่ยนหน้า...',
            text: 'คุณจะถูกพาไปยัง Gmail ใน 5 วินาที',
            timer: 5000,
            timerProgressBar: true,
            onBeforeOpen: () => {
              Swal.showLoading()
            },
            willClose: () => {
              window.location.href = "<?php echo site_url(); ?>/gear";
              window.open("https://mail.google.com", "_blank");
            }
          }).then((result) => {
            // Close the window after the second modal is closed
            window.close();
          });
        } else {
          window.location.href = "<?php echo site_url(); ?>/gear";
        }
      }
    });
  <?php endif; ?>
  <?php if (isset($status) && $status === 'error'): ?>
    Swal.fire({
      icon: '<?php echo $status; ?>' === 'success' ? 'success' : 'error',
      title: '<?php echo $message; ?>',
      confirmButtonText: 'ยืนยัน'
    }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = "<?php echo site_url(); ?>/ums/forgotpassword";
      }
    });
  <?php endif; ?>
</script>
<script>
   function reset_password(){
    $.ajax({
      type : "POST", 
      url  : "<?php echo site_url(); ?>/ums/forgotpassword/reset",
      data : {
        email : $('#email').val()
      },
      dataType : "JSON",
      success:function(data) {
        // let html =  `<div class="alert alert-${data.status}" role="alert">
        //                     <h3>${data.message}</h3>
        //               </div>`
        //   $('#label-noti').html(html)
        Swal.fire({
              icon: data.status === 'success' ? 'success' : 'error',
              title: data.message,
              confirmButtonText: 'ยืนยัน'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (data.status === 'success') {
                        // Show another modal to confirm redirection after a delay
                        Swal.fire({
                            title: 'กำลังจะเปลี่ยนหน้า...',
                            text: 'คุณจะถูกพาไปยัง Gmail ใน 5 วินาที',
                            timer: 5000,
                            timerProgressBar: true,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                window.open("https://mail.google.com", "_blank");
                            }
                        });
                    } else {
                        location.reload();
                    }
                }
          });
      }
    })
    }
</script>
  <script src="<?php echo base_url(); ?>assets/vendor/password/password.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>

  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script> -->
</body>

</html>