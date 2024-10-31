<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>โรงพยาบาลจักษุสุราษฎร์</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo base_url();?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/css/fonts/Sarabun/css/Sarabun.css" rel="stylesheet">

  <!-- Google Icons -->
  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Plugin CSS Files -->
  <link href="<?php echo base_url();?>assets/plugins/sweetalert2-11.10.6/sweetalert2.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url();?>assets/css/gear/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: BoomAdmin
  * Updated: 20/8/2566 with Bootstrap v1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: Boom
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
    .iconlist i {
        font-size: 2.5rem;
        padding: 2px;
    }
    a:hover:not(.logo){
        text-decoration: underline;
    }
    .logo img {
        max-height: 100px;
    }
    .logo span {
        font-size: 26px;
    }
    /* body {
        background-image: url("<?php echo base_url();?>assets/img/slides-1.jpg") ; 
        background-size: cover;
    } */
  </style>

  <!-- =======================================================
  * Template Name: BoomAdmin
  * Updated: 20/8/2566 with Bootstrap v1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: Boom
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 d-flex align-items-center justify-content-center">
                            <a href="#" class="logo d-flex flex-column align-items-center w-auto">
                                <img src="<?php echo base_url();?>assets/img/logo.png" alt="">
                                <br>
                                <span class="text-center">โรงพยาบาลจักษุสุราษฎร์</span>
                            </a>
                        </div>
                        <div class="col-lg-8"> <!-- style="overflow-y: auto; height: 600px;" -->
                        <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Forget your password?</h5>
                                <p class="text-center small">Please enter the email address you'd like your new password information sent to</p>
                            </div>
                            <form class="row g-3 needs-validation" novalidate>
                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Enter email address</label>
                                    <div class="input-group has-validation">
                                        <input type="email" name="Email" id="Email" class="form-control" required>
                                        <div class="invalid-feedback">Please enter your email.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Login</button>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-outline-secondary w-100" type="button">Back to login</button>
                                </div>
                            </form>
                            <div> <!-- style="overflow-y: auto; height: 600px;" -->
                                <div class="text-center pt-4">Link ...</div>
                                <div class="row iconlist mb-4">
                                    <?php for($i=0; $i<5; $i++){ ?>
                                    <div class="col-sm-3 under text-center mt-2">
                                        <a href="#" target="_blank" class="col-sm-3 under text-center mt-2">
                                            <i class="bi-person-circle"></i><br><span>ข้อมูลบุคลากร</span>
                                        </a>
                                    </div>
                                    <?php } ?>
                                    <!-- <div class="col-sm-3 under text-center mt-2 iconlist">
                                        <a href="#" target="_blank">
                                            <i class="ri-flask-fill"></i><br><span>สืบค้นผลงานวิจัย</span>
                                        </a>
                                    </div>
                                    <div class="col-sm-3 under text-center mt-2 iconlist">
                                        <a href="#" target="_blank">
                                            <i class="bi-suit-heart-fill"></i><br><span>สืบค้นผลงานวิชาการ</span>
                                        </a>
                                    </div>
                                    <div class="col-sm-3 under text-center mt-2 iconlist">
                                        <a href="#" target="_blank">
                                            <i class="bi-bookmark-fill"></i><br><span>หลักสูตรที่เปิดสอน</span>
                                        </a>
                                    </div>
                                    <div class="col-sm-3 under text-center mt-2 iconlist">
                                        <a href="#" target="_blank">
                                            <i class="bi-flag-fill"></i><br><span>โปรแกรมการศึกษา</span>
                                        </a>
                                    </div>
                                    <div class="col-sm-3 under text-center mt-2 iconlist">
                                        <a href="#" target="_blank">
                                            <i class="bi-journal-bookmark-fill"></i><br><span>รายวิชาที่เปิดสอน</span>
                                        </a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <!-- <script type="text/javascript" src="<?php echo base_url();?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/vendor/chart.js/chart.umd.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/vendor/echarts/echarts.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/vendor/quill/quill.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/vendor/php-email-form/validate.js"></script> -->

  <!-- Template Main JS File -->
  <!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/ums/main.js"></script> -->

  <script>
    (function() {
        document.addEventListener("DOMContentLoaded", function(event) {
            var form = document.querySelector('.needs-validation');
            form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                // invalid-feedback (not done)
                var validate = document.createElement("div", { class: "invalid-feedback", text: "กรุณาระบุ"});
                form.querySelectorAll('input').forEach(function(input) {
                if(!input.value.trim().length) {
                    // input.appendChild(newChild);
                    input.insertAdjacentElement('afterend', validate);
                }
                });
            }

            form.classList.add('was-validated')
            }, false)
        });
    })();
  </script>

</body>

</html>