<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard -  SEE Dashborads Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo base_url();?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Agbalumo&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lily+Script+One&family=Pridi:wght@200;300;400;500;600;700&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <!-- Vendor CSS Files -->
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
      <h1 class="mb-2">สถิติบุคลากรของโรงพยาบาลจักษุสุราษฎร์</h1>
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
        <div class="col-lg-12">
          <div class="row">
            <div class="col-xxl-12 col-md-12">
              <div class="alert alert-info" role="alert">
                  วันที่ 31 มกราคม พ.ศ. 2567 เวลา 13.30 น.
              </div>
            </div>
            <div class="row" style="margin-left:1px;">
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card" style="border-bottom: 3px solid #FF9800;">
                  <div class="card-body pb-2">
                    <h5 class="card-title">[SEE-P-C1] บุคลากรทั้งหมด</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #FF9800; background: #ffeacc;">
                        <i class="bi bi-person-circle"></i>
                      </div>
                      <div class="ps-5">
                        <h6>142 คน</h6>
                      </div>
                    </div>
                  </div>
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li><a class="dropdown-item" href="#">ดูรายละเอียด</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card customers-card" style="border-bottom: 3px solid #00bcd4;">
                  <div class="card-body pb-2">
                    <h5 class="card-title">[SEE-P-C3] ทีมแพทย์</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #00BCD4; background: #d1faff;">
                        <i class="bi bi-person-hearts"></i>
                      </div>
                      <div class="ps-4">
                        <h6>16 คน</h6>
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
                <div class="card info-card revenue-card" style="border-bottom: 3px solid #4caf50;">
                  <div class="card-body pb-2">
                    <h5 class="card-title">[SEE-P-C2] เจ้าหน้าที่สายสนับสนุน</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-fill-up"></i>
                      </div>
                      <div class="ps-4">
                        <h6>126 คน</h6>
                      </div>
                    </div>
                  </div>
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li><a class="dropdown-item" href="#">ดูรายละเอียด</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
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
                  <h5 class="card-title">[SEE-P-C1] กราฟแสดงบุคลากร จำแนกตามแผนก และประเภทบุคลากร</h5>
                  <div id="container"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xxl-12 col-md-12 mb-3">
                <div class="alert alert-success" role="alert">
                    จำนวนผู้มาปฏิบัติงาน เลือกวัน / เดือน / ปีพ.ศ. <input type="date" class="form-control ms-2 w-25" style="display: inline;" value="">
                </div>
              </div>
              <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card" style="border-bottom: 3px solid #4caf50;">
                  <div class="card-body pb-2">
                    <h5 class="card-title">[SEE-P-C4] ปฏิบัติงาน</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4caf50; background: #e0f8e9;">
                        <i class="bi bi-person-circle"></i>
                      </div>
                      <div class="ps-5">
                        <h6>134 คน</h6>
                      </div>
                    </div>
                  </div>
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li><a class="dropdown-item" href="#">ดูรายละเอียด</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card" style="border-bottom: 3px solid #0051ff;">
                  <div class="card-body pb-2">
                    <h5 class="card-title">[SEE-P-C5] ลางาน</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #008cff; background: #ccdeff;">
                        <i class="bi bi-person-circle"></i>
                      </div>
                      <div class="ps-5">
                        <h6>8 คน</h6>
                      </div>
                    </div>
                  </div>
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li><a class="dropdown-item" href="#">ดูรายละเอียด</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card" style="border-bottom: 3px solid #ff004c;">
                  <div class="card-body pb-2">
                    <h5 class="card-title">[SEE-P-C6] เข้างานสาย</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #ff004c; background: #ffcce1;">
                        <i class="bi bi-person-circle"></i>
                      </div>
                      <div class="ps-5">
                        <h6>2 คน</h6>
                      </div>
                    </div>
                  </div>
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li><a class="dropdown-item" href="#">ดูรายละเอียด</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
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
                    <h5 class="card-title">[SEE-P-T1] ตารางแสดงรายละเอียดการเข้าปฏิบัติงาน</h5>
                    <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">วันเวลาที่เข้างาน</th>
                          <th scope="col">เลขที่พนักงาน</th>
                          <th scope="col">ชื่อ - นามสกุล</th>
                          <th scope="col">เบอร์โทร</th>
                          <th scope="col">สถานะ</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>08:05.23 น.</td>
                          <td>19970</td>
                          <td><a href="users-profile.html" target="_blank" class="text-primary">นายภาติยะ เพียรสวัสดิ์</a></td>
                          <td>0842259889</td>
                          <td><span class="badge bg-danger">เข้างานสาย 5 นาที 23 วินาที</span></td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>08:01.21 น.</td>
                          <td>19921</td>
                          <td><a href="users-profile.html" target="_blank" class="text-primary">นายมาโนชญ์ ใจกว้าง</a></td>
                          <td>0834456789</td>
                          <td><span class="badge bg-danger">เข้างานสาย 1 นาที 21 วินาที</span></td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>07:54.12 น.</td>
                          <td>19995</td>
                          <td><a href="users-profile.html" target="_blank" class="text-primary">นายอภิสิทธิ์ ศรีปลัด</a></td>
                          <td>0874658799</td>
                          <td><span class="badge bg-success">เข้างานปกติ</span></td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td>07:50.35 น.</td>
                          <td>19926</td>
                          <td><a href="users-profile.html" target="_blank" class="text-primary">นางสาวธัญวลัย พลประสิทธิ์</a></td>
                          <td>0874658799</td>
                          <td><span class="badge bg-success">เข้างานปกติ</span></td>
                        </tr>
                        <tr>
                          <th scope="row">5</th>
                          <td>07:50.35 น.</td>
                          <td>19947</td>
                          <td><a href="users-profile.html" target="_blank" class="text-primary">นายสมหมาย เที่ยงตรง</a></td>
                          <td>0845214563</td>
                          <td><span class="badge bg-success">เข้างานปกติ</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-4">
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
                    <h5 class="card-title">[SEE-P-P1] กราฟแสดงร้อยละการเข้าปฏิบัติงาน</h5>
                    <div id="container2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Left side columns -->
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
        type: 'column'
    },
    title: {
        text: '',
        align: '',
        style: {
            fontSize: '16px' // Set font size for title
        }
    },
    xAxis: {
        categories: ['จักษุแพทย์', 'โสต ศอ นาสิกแพทย์', 'รังสีแพทย์', 'ทันตแพทย์'],
        labels: {
            style: {
                fontSize: '16px' // Set font size for x-axis labels
            }
        }
    },
    yAxis: {
        min: 10,
        title: {
            text: '',
            style: {
                fontSize: '16px' // Set font size for y-axis title
            }
        },
        stackLabels: {
            enabled: true,
            formatter: function() {
                return this.total + ' คน'; // Add unit "คน" to the stack labels in the tooltip
            },
            style: {
                fontSize: '16px' // Set font size for stack labels
            }
        },
        labels: {
            enabled: true,
            format: '{value} คน', // Display unit as "คน"
            style: {
                fontSize: '16px' // Set font size for y-axis labels
            }
        }
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y:,.0f} คน<br/>', // Individual values
        style: {
            fontSize: '16px' // Set font size for tooltip
        },
        shared: true, // Display all points in the tooltip
        formatter: function () {
            var points = this.points;
            var total = 0;

            for (var i = 0; i < points.length; i++) {
                total += points[i].y;
            }

            var tooltip = '<b>' + points[0].key + '</b><br/>';

            for (var i = 0; i < points.length; i++) {
                tooltip += points[i].series.name + ': ' + points[i].y.toFixed(0) + ' คน<br/>';
            }

            tooltip += 'ทั้งหมด: ' + total.toFixed(0) + ' คน';
            return tooltip;
        }
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                format: '{y} คน', // Display unit as "คน"
                style: {
                    fontSize: '16px' // Set font size for data labels
                }
            }
        }
    },
    series: [
    {
        name: 'ทีมแพทย์',
        data: [10, 3, 1, 3],
        color: '#00BCD4'
    },{
        name: 'สายสนับสนุน',
        data: [72, 21, 27, 22],
        color:'#4caf50'
    }]
});


// Data retrieved from https://netmarketshare.com/
Highcharts.chart('container2', {
    chart: {
        height: 300, // Set the desired height here
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false,
    },
    title: {
        text: '',
        align: 'center',
        verticalAlign: 'middle',
        y: 60,
        style: {
            fontSize: '16px' // Set font size for title
        }
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br/>',
        pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>',
        footerFormat: '',
        style: {
            fontSize: '16px' // Set font size for tooltip
        }
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.percentage:.1f}%',
                distance: -60,
                style: {
                    fontSize: '14px', // Set font size for data labels
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '75%'],
            size: '120%',
            showInLegend: true // Display in the legend
        }
    },
    series: [{
        type: 'pie',
        name: '',
        innerSize: '50%',
        data: [
            { name: 'ปฏิบัติงาน', y: 90.28, color: '#4CAF50' }, // Green color
            { name: 'ลางาน', y: 7.72, color: '#00BCD4' },     // Yellow color
            { name: 'เข้างานสาย', y: 2.00, color: '#FFC107' } // Red color
        ]
    }]
});


</script>
</body>

</html>