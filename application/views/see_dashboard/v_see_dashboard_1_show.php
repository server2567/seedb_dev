<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SEE Dashborads</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo base_url();?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Agbalumo&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lily+Script+One&family=Pridi:wght@200;300;400;500;600;700&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name:  SEE Dashborads
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
      <a href="index.html" class="logo">
        <img src="<?php echo base_url();?>/assets/img/logo_2.png" class="w-80" alt="" style="max-height: 75px;">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?php echo base_url();?>assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?php echo base_url();?>assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?php echo base_url();?>assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?php echo base_url();?>assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">P. Patiya</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Patiya Peansawat</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link " href="<?php echo base_url()?>index.php/see_dashboard/See_dashboard_1">
          <i class="bi-bar-chart"></i>
          <span>Dashboards Queue</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url()?>index.php/see_dashboard/See_dashboard_2">
          <i class="bi-bar-chart"></i>
          <span>Dashboards Finance</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url()?>index.php/see_dashboard/See_dashboard_3">
          <i class="bi-bar-chart"></i>
          <span>Dashboards Person</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url()?>index.php/see_dashboard/See_dashboard_4">
          <i class="bi-bar-chart"></i>
          <span>Dashboards ครุภัณฑ์</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboards</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="https://getbootstrap.com/docs/5.0/getting-started/introduction/" target="_blank">
          <i class="bi bi-bootstrap-fill"></i>
          <span>Docs</span>
        </a>
      </li> -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1 class="mb-2">สถิติการให้บริการการนัดหนาย</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-12">
              <div class="alert alert-info" role="alert">
                  วันที่ 31 มกราคม พ.ศ. 2567 เวลา 13.30 น.
                <div class=" float-end" style="margin-top: -8px;"> 
                  <input type="radio" class="btn-check" name="options-outlined" id="primary-outlined" autocomplete="off" checked="">
                  <label class="btn btn-outline-primary me-3 ps-4 pe-4 fw-semibold" for="primary-outlined">วัน</label>
                  
                  <input type="radio" class="btn-check" name="options-outlined" id="outlined-1" autocomplete="off">
                  <label class="btn btn-outline-primary me-3 ps-4 pe-4 fw-semibold" for="outlined-1">สัปดาห์</label>

                  <input type="radio" class="btn-check" name="options-outlined" id="outlined-2" autocomplete="off">
                  <label class="btn btn-outline-primary me-3 ps-4 pe-4 fw-semibold" for="outlined-2">เดือน</label>

                  <input type="radio" class="btn-check" name="options-outlined" id="outlined-3" autocomplete="off">
                  <label class="btn btn-outline-primary me-3 ps-4 pe-4 fw-semibold" for="outlined-3">ปี</label>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>ศ.</span>
                  <h5 class="card-title p-0">26</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>ส.</span>
                  <h5 class="card-title p-0">27</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>อา.</span>
                  <h5 class="card-title p-0">28</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>จ.</span>
                  <h5 class="card-title p-0">29</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>อ.</span>
                  <h5 class="card-title p-0">30</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0" style="border: 1px solid #2196F3;border-radius: 10px; box-shadow: 0px 0 10px 0px rgb(0 170 255 / 32%);">
                  <span>พ.</span>
                  <h5 class="card-title p-0"><b>31</b></h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>พฤ.</span>
                  <h5 class="card-title p-0">1</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>ศ.</span>
                  <h5 class="card-title p-0">2</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>ส.</span>
                  <h5 class="card-title p-0">3</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>อา.</span>
                  <h5 class="card-title p-0">4</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <span>จ.</span>
                  <h5 class="card-title p-0">5</h5>
                </div>
              </div>
            </div>
            <div class="col-md-1 pe-0" style="cursor: pointer;">
              <div class="card text-center" style="border-radius:10px; margin-bottom:5px;">
                <div class="card-body p-0">
                  <i class="bi bi-arrow-right-square-fill text-primary"></i>
                </div>
              </div>
              <div class="card text-center" style="border-radius:10px;">
                <div class="card-body p-0">
                  <i class="bi bi-arrow-left-square"></i>
                </div>
              </div>
            </div>
            <div class="row" style="margin-left:1px;">
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card" style="border-bottom: 3px solid #2196F3;">
                  <div class="card-body pb-2">
                    <h5 class="card-title" style="padding-top: 1.7rem"><span class="position-absolute" style="top:3px;">[SEE-Q-C1]</span> การนัดหมาย</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-heart"></i>
                      </div>
                      <div class="ps-4">
                        <h6>145 คน</h6>
                      </div>
                    </div>
                    <div class="row mt-2" style="border-top: 1px solid #e1e1e1; padding-top: 10px;">
                      <div class="col-md-6 text-center">
                        <span class="text-success fw-bold">ผู้ป่วยใหม่<br>84</span><br>
                      </div>
                      <div class="col-md-6 text-center">
                        <span class="text-primary fw-bold">ผู้ป่วยเก่า<br>61</span>
                      </div>
                    </div>
                  </div>
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li><a class="dropdown-item" href="#">ดูรายละเอียด</a></li>
                      <li><a class="dropdown-item" href="#">ผู้ป่วยที่ยังไม่มาลงทะเบียน</a></li>
                      <li><a class="dropdown-item" href="#">ผู้ป่วยใหม่/ผู้ป่วยเก่า</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card" style="border-bottom: 3px solid #4caf50;">
                  <div class="card-body pb-2">
                    <h5 class="card-title" style="padding-top: 1.7rem"><span class="position-absolute" style="top:3px;">[SEE-Q-C2]</span> ขั้นตอนการบริการตรวจ</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-eye"></i>
                      </div>
                      <div class="ps-4">
                        <h6>109 คน</h6>
                      </div>
                    </div>
                    <div class="row mt-2" style="border-top: 1px solid #e1e1e1; padding-top: 10px;">
                      <div class="col-md-6 text-center">
                        <span class="text-success fw-bold">ผู้ป่วยใหม่<br>75</span><br>
                      </div>
                      <div class="col-md-6 text-center">
                        <span class="text-primary fw-bold">ผู้ป่วยเก่า<br>34</span>
                      </div>
                    </div>
                  </div>
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li><a class="dropdown-item" href="#">ดูรายละเอียด</a></li>
                      <li><a class="dropdown-item" href="#">ผู้ป่วยใหม่/ผู้ป่วยเก่า</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card customers-card" style="border-bottom: 3px solid #00bcd4;">
                  <div class="card-body pb-2">
                    <h5 class="card-title" style="padding-top: 1.7rem"><span class="position-absolute" style="top:3px;">[SEE-Q-C3]</span> ขั้นตอนการบริการจ่ายยา</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #00BCD4; background: #d1faff;">
                        <i class="bi bi-emoji-heart-eyes"></i>
                      </div>
                      <div class="ps-4">
                        <h6>24 คน</h6>
                      </div>
                    </div>
                    <div class="row mt-2" style="border-top: 1px solid #e1e1e1; padding-top: 10px;">
                      <div class="col-md-6 text-center">
                        <span class="text-success fw-bold">ผู้ป่วยใหม่<br>17</span><br>
                      </div>
                      <div class="col-md-6 text-center">
                        <span class="text-primary fw-bold">ผู้ป่วยเก่า<br>7</span>
                      </div>
                    </div>
                  </div>
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li><a class="dropdown-item" href="#">ดูรายละเอียด</a></li>
                      <li><a class="dropdown-item" href="#">ผู้ป่วยใหม่/ผู้ป่วยเก่า</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">[SEE-Q-L1] กราฟแสดงเวลาที่นัดหมาย จำแนกตามประเภทผู้ป่วย</h5>
                  <div id="container"></div>
                </div>

              </div>
            </div><!-- End Reports -->

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">[SEE-Q-T2] ตารางแสดงรายการนัดหมาย จำแนกรายผู้ป่วย</h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">วันเวลาที่ทำรายการ</th>
                        <th scope="col">ผู้ป่วย</th>
                        <th scope="col">ชื่อ - นามสกุล</th>
                        <th scope="col">ชื่อแพทย์</th>
                        <th scope="col">เวลานัด</th>
                        <th scope="col">เบอร์โทร</th>
                        <th scope="col">สถานะ</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#">1</a></th>
                        <td>30 ม.ค. 2566 10.00 น.</td>
                        <td class="text-success">ผู้ป่วยใหม่</td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">นายภาติยะ เพียรสวัสดิ์</a></td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">นพ.บรรยง ชินกุลกิจนิวัฒน์</a></td>
                        <td>18.00 น.</td>
                        <td>0842259889</td>
                        <td><span class="badge bg-success">ขั้นตอนการบริการตรวจ</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">2</a></th>
                        <td>27 ม.ค. 2566 12.00 น.</td>
                        <td class="text-success">ผู้ป่วยใหม่</td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">นายณัชพล โลหิตรัตน์</a></td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">นพ.บรรยง ชินกุลกิจนิวัฒน์</a></td>
                        <td>18.00 น.</td>
                        <td>0834456789</td>
                        <td><span class="badge bg-info">ขั้นตอนการบริการจ่ายยา</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">3</a></th>
                        <td>27 ม.ค. 2566 09.00 น.</td>
                        <td class="text-success">ผู้ป่วยเก่า</td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">นายมาโนชญ์ ใจกว้าง</a></td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">พญ.บัวขวัญ ชินกุลกิจนิวัฒน์</a></td>
                        <td>18.00 น.</td>
                        <td>0874658799</td>
                        <td><span class="badge bg-success">ขั้นตอนการบริการตรวจ</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">4</a></th>
                        <td>26 ม.ค. 2566 23.40 น.</td>
                        <td class="text-success">ผู้ป่วยเก่า</td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">นางสาวธัญวลัย พลประสิทธิ์</a></td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">พญ.บัวขวัญ ชินกุลกิจนิวัฒน์</a></td>
                        <td>18.00 น.</td>
                        <td>0865498722</td>
                        <td><span class="badge bg-warning text-dark">Walk in</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">5</a></th>
                        <td>25 ม.ค. 2566 09.00 น.</td>
                        <td class="text-success">ผู้ป่วยใหม่</td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">นายสมหมาย เที่ยงตรง</a></td>
                        <td><a href="users-profile.html" target="_blank" class="text-primary">พญ.บุณยดา ชินกุลกิจนิวัฒน์</a></td>
                        <td>18.00 น.</td>
                        <td>0845214563</td>
                        <td><span class="badge bg-success">ขั้นตอนการบริการตรวจ</span></td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div>
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4" style="margin-top: -80px;">

          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">[SEE-Q-T1] กิจกรรมล่าสุด <span>| วันปัจจุบัน</span></h5>

              <div class="activity">

                <div class="activity-item d-flex">
                  <div class="activite-label">32 นาที</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    นายภาติยะ เพียรสวัสดิ์ <a href="#" class="fw-bold text-dark">วัดระยะการมองเห็น</a>
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">35 นาที</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    นายณัชพล โลหิตรัตน์ <a href="#" class="fw-bold text-dark">พบจักษุแพทย์</a>
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">42 นาที</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    นายมาโนชญ์ ใจกว้าง <a href="#" class="fw-bold text-dark">ลงทะเบียน วัดส่วนสูง ชั้นน้ำหนัก</a>
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">1 ชั่วโมง</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    นายภาติยะ เพียรสวัสดิ์ <a href="#" class="fw-bold text-dark">ลงทะเบียน วัดส่วนสูง ชั้นน้ำหนัก</a>
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 ชั่วโมง</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class="activity-content">
                    นายณัชพล โลหิตรัตน์ <a href="#" class="fw-bold text-dark">ลงทะเบียน วัดส่วนสูง ชั้นน้ำหนัก</a>
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">4 ชั่วโมง</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class="activity-content">
                    นางสาวธัญวลัย พลประสิทธิ์ <a href="#" class="fw-bold text-dark">รับยา/คำแนะนำจากเภสัชกร</a>
                  </div>
                </div><!-- End activity item-->

              </div>

            </div>
          </div><!-- End Recent Activity -->

          <!-- Budget Report -->
          <!-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Budget Report <span>| This Month</span></h5>

              <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                    legend: {
                      data: ['Allocated Budget', 'Actual Spending']
                    },
                    radar: {
                      // shape: 'circle',
                      indicator: [{
                          name: 'Sales',
                          max: 6500
                        },
                        {
                          name: 'Administration',
                          max: 16000
                        },
                        {
                          name: 'Information Technology',
                          max: 30000
                        },
                        {
                          name: 'Customer Support',
                          max: 38000
                        },
                        {
                          name: 'Development',
                          max: 52000
                        },
                        {
                          name: 'Marketing',
                          max: 25000
                        }
                      ]
                    },
                    series: [{
                      name: 'Budget vs spending',
                      type: 'radar',
                      data: [{
                          value: [4200, 3000, 20000, 35000, 50000, 18000],
                          name: 'Allocated Budget'
                        },
                        {
                          value: [5000, 14000, 28000, 26000, 42000, 21000],
                          name: 'Actual Spending'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div> -->
          <!-- End Budget Report -->

          <!-- Website Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title" style="font-size: 16px;">[SEE-Q-C1] กราฟแสดงจำนวนนัดหมายแพทย์</h5>
              <div id="container2"></div>
            </div>
          </div><!-- End Website Traffic -->

          <!-- News & Updates Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">[SEE-Q-P1] กราฟแสดงร้อยละโรคของผู้ป่วย</h5>
              <div id="container3"></div>
            </div>
          </div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span> SEE Dashborads</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url();?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/quill/quill.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url();?>assets/js/main.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/high-contrast-light.js"></script>
<script>
  // Sample data for illustration
  const colors = Highcharts.getOptions().colors;

  Highcharts.chart('container', {
    chart: {
        type: 'spline',
        style: {
            fontSize: '14px', // Set the font size for the entire chart
        }
    },
    legend: {
        symbolWidth: 40
    },
    title: {
        text: '',
        align: ''
    },
    subtitle: {
        text: '',
        align: 'left'
    },
    yAxis: {
        title: {
            text: 'จำนวนการนัดหมาย',
            style: {
                fontSize: '14px' // Set the font size for the yAxis title
            }
        }
    },
    xAxis: {
        title: {
            text: 'Time',
            style: {
                fontSize: '14px' // Set the font size for the xAxis title
            }
        },
        labels: {
            style: {
                fontSize: '14px' // Set the font size for the xAxis labels
            }
        },
        categories: ['17.30', '18.00', '18.30', '19.00', '19.30', '20.00']
    },
    tooltip: {
        valueSuffix: ' คน',
        stickOnContact: true,
        style: {
          fontSize: '14px' // Set the font size for the xAxis labels
        }
    },
    plotOptions: {
        series: {
            cursor: 'pointer',
            lineWidth: 2,
            dataLabels: {
                enabled: true,
                format: '{y} คน',
                style: {
                    fontSize: '14px' // Set the font size for the dataLabels
                }
            }
        }
    },
    series: [
        {
            name: 'ผู้ป่วยใหม่',
            data: [10, 15, 10, 19, 12, 8],
            color: Highcharts.getOptions().colors[2],
            label: {
                style: {
                    fontSize: '16px'
                }
            }
        },
        {
            name: 'ผู้ป่วยเก่า',
            data: [20, 7, 9, 8, 7, 10],
            color: Highcharts.getOptions().colors[0],
            label: {
                style: {
                    fontSize: '16px'
                }
            }
        },
        {
            name: 'Walk In',
            data: [5, 3, 4, 6, 6, 20],
            color: Highcharts.getOptions().colors[7],
            label: {
                style: {
                    fontSize: '16px'
                }
            }
        }
    ],
});

Highcharts.chart('container2', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: ['นพ.บรรยง ชินกุลกิจนิวัฒน์', 'พญ.บัวขวัญ ชินกุลกิจนิวัฒน์', 'พญ.บุณยดา ชินกุลกิจนิวัฒน์', 'พญ.บุญพิสุทธิ์ ชินกุลกิจนิวัฒน์', 'นพ.นภัส เตชะเลิศไพศาล']
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    tooltip: {
        shared: true,
        formatter: function () {
            let tooltip = '<b>' + this.x + '</b><br>';
            this.points.forEach(point => {
                tooltip += '<span style="color:' + point.color + '">\u25CF</span> ' + point.series.name + ': ' + point.y + '<br>';
            });
            return tooltip;
        }
    },
    series: [
        {
            name: 'Walk in',
            data: [5, 15, 8, 5, 8],
            color: Highcharts.getOptions().colors[7]
        },{
            name: 'ผู้ป่วยเก่า',
            data: [5, 3, 12, 6, 11],
            color: Highcharts.getOptions().colors[0]
        },{
            name: 'ผู้ป่วยใหม่',
            data: [4, 4, 6, 15, 12],
            color: Highcharts.getOptions().colors[2]
        }]
});
Highcharts.chart('container3', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: '',
        align: 'left'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true, // Enable data labels
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                distance: -50 // Adjust the distance of labels from the center of the pie
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        colors: ['#7cb5ec', '#90ed7d', '#f7a35c', '#8085e9', '#f15c80', '#e4d354'], // Light colors
        data: [{
            name: 'โรคต้อเนื้อ',
            y: 74.77,
            sliced: true,
            selected: true
        },  {
            name: 'โรคจอประสาทตา',
            y: 12.82
        },  {
            name: 'โรคต้อหิน',
            y: 4.63
        }, {
            name: 'โรคกระจกตา',
            y: 2.44
        }, {
            name: 'โรคตาเด็ก',
            y: 3.28
        }, {
            name: 'โรคทางเส้นประสาท',
            y: 3.28
        }]
    }]
});



</script>
</body>

</html>