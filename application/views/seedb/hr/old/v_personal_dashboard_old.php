<style>
a.bi-search {
   cursor: pointer;
}
.filterDetail{
   right: 20px !important;  
}
.nav-pills .nav-link {
    /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
    border: 1px dashed #607D8B;
    color: #012970;
}
.table{
    border-collapse: collapse !important;
}

</style>

<?php
setlocale(LC_TIME, 'th_TH.utf8');
// Array of Thai month names
$thaiMonths = array(
    'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
);
?>

<section class="section dashboard">
   <div class="row">
      <!-- Left side columns -->
      <div class="col-md-12">
         <div class="row">
            <!-- <div class="col-md-12">
               <div class="alert alert-info" role="alert">
                  วันที่ 31 มกราคม พ.ศ. 2567 เวลา 13.30 น.
               </div>
            </div> -->

            <!-- start filter -->
            <div class="col-md-4">
               <div class="form-floating mb-4">
                  <select class="form-select mb-4" id="hrm_select_ums_department" name="hrm_select_ums_department" onchange="filterHRM()">
                     <?php
                     foreach ($ums_department_list as $key=>$row) {
                        if($key==0){
                           echo '<option value="' . $row->dp_id . '" selected>' . $row->dp_name_th . '</option>';
                        }
                        else{
                           echo '<option value="' . $row->dp_id . '">' . $row->dp_name_th . '</option>';
                        }
                     }
                     ?>
                  </select>
               <label for="ums_department">หน่วยงาน</label>
               </div>
            </div>
            <div class="col-md-4" id="filter_hrm_select_year_type">
               <div class="form-floating mb-3">
                    <select class="form-select mb-3" id="hrm_select_year_type" name="hrm_select_year_type" onchange="filterHRM()">
                        <option value="1" selected>ปีปฏิทิน</option>
                    </select>
                    <label for="hrm_select_year_type">ประเภทปี</label>
               </div>
            </div>
            <div class="col-md-4" id="filter_hrm_select_year">
               <div class="form-floating mb-3">
                  <select class="form-select mb-3" id="hrm_select_year" name="hrm_select_year" onchange="filterHRM()">
                        <?php
                     $i = 0;
                     foreach ($default_year_list as $year) {
                        // Get current date
                        if ($year == getNowYearTh())
                              echo '<option value="' . ($year - 543) . '" selected>' . $year . '</option>';
                        else
                              echo '<option value="' . ($year - 543) . '">' . $year . '</option>';
                        $i++;
                     }
                     ?>
                  </select>
                  <label for="hrm_select_year">ปีพ.ศ.</label>
               </div>
            </div>
            
            <!-- <div class="col-md-4" id="filter_hrm_select_month">
               <div class="form-floating mb-3">
                  <select class="form-select form-select-lg mb-3" id="hrm_select_month" name="hrm_select_month" onchange="filterHRM()">
                    <option value="all" selected>ทั้งหมด</option>
                    <?php
                    $i = 0;
                    foreach ($thaiMonths as $row) {
                        echo '<option value="' . ($i + 1) . '" >' . $row . '</option>';
                        $i++;
                    }
                    ?>
                  </select>
                  <label for="hrm_select_month">เดือน</label>
               </div>
            </div> -->
            <!-- end filter -->
           
            <!-- start CARD -->
            <div class="col-md-4" id="card_all">
               <div class="card info-card sales-card" style="border-bottom: 3px solid #FF9800;">
                  <div class="card-body pb-2">
                     <h5 class="card-title">[SEE-HRM-C1] บุคลากรทั้งหมด</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #FF9800; background: #ffeacc;">
                           <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ps-4">
                           <h6></h6>
                        </div>
                     </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="all" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- บุคลากรทั้งหมด -->

            <div class="col-md-4" id="card_working">
               <div class="card info-card customers-card" style="border-bottom: 3px solid #1fe1a3; background: linear-gradient(to right bottom, rgb(150, 234, 218), rgb(255, 255, 255), rgb(255, 255, 255));">
                  <div class="card-body pb-2">
                     <h5 class="card-title">[SEE-HRM-C2] ปฏิบัติงานจริง</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #fff; background: #1fe1a3;">
                           <i class="bi bi-person-check-fill"></i>
                        </div>
                        <div class="ps-4">
                           <h6></h6>
                        </div>
                     </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="working" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- ปฏิบัติงานจริง -->

            <div class="col-md-4" id="card_out">
               <div class="card info-card customers-card" style="border-bottom: 3px solid #ff5d5d; background: linear-gradient(to right bottom, rgb(255, 125, 125), rgb(255, 255, 255), rgb(255, 255, 255));">
                  <div class="card-body pb-2">
                     <h5 class="card-title">[SEE-HRM-C3] ลาออก</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #fff; background: #ff5d5d;">
                           <i class="bi bi-person-dash-fill"></i>
                        </div>
                        <div class="ps-4">
                           <h6></h6>
                        </div>
                     </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="out" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- ลาออก -->

            <div class="col-md-4" id="card_medical">
               <div class="card info-card customers-card" style="border-bottom: 3px solid #00bcd4;">
                  <div class="card-body pb-2">
                        <h5 class="card-title">[SEE-HRM-C4] สายแพทย์</h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #00BCD4; background: #d1faff;">
                              <i class="bi bi-person-hearts"></i>
                           </div>
                           <div class="ps-4">
                              <h6></h6>
                           </div>
                        </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="medical" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- สายแพทย์ -->

            <div class="col-md-4" id="card_nurse">
               <div class="card info-card revenue-card" style="border-bottom: 3px solid #5b2fc1;">
                  <div class="card-body pb-2">
                     <h5 class="card-title">[SEE-HRM-C5] สายพยาบาล</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #5b2fc1; background: #dee2f9;">
                           <i class="ri ri-nurse-fill"></i>
                        </div>
                        <div class="ps-4">
                           <h6></h6>
                        </div>
                     </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="nurse" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- สายพยาบาล -->

            <div class="col-md-4" id="card_admin">
               <div class="card info-card revenue-card" style="border-bottom: 3px solid #8e412e;">
                  <div class="card-body pb-2">
                     <h5 class="card-title">[SEE-HRM-C6] สายบริหาร</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #8e412e; background: #ebd6d1;">
                           <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="ps-4">
                           <h6></h6>
                        </div>
                     </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="admin" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- สายบริหาร -->

            <div class="col-md-4" id="card_support_medical">
               <div class="card info-card revenue-card" style="border-bottom: 3px solid #687259;">
                  <div class="card-body pb-2">
                     <h5 class="card-title">[SEE-HRM-C7] สายสนับสนุนทางการแพทย์</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #687259; background: #e4ebda;">
                           <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="ps-4">
                           <h6></h6>
                        </div>
                     </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="support_medical" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- สายสนับสนุนทางการแพทย์ -->

            <div class="col-md-4" id="card_technical">
               <div class="card info-card revenue-card" style="border-bottom: 3px solid #0e606b;">
                  <div class="card-body pb-2">
                     <h5 class="card-title">[SEE-HRM-C8] สายเทคนิคและบริการ</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #0e606b; background: #d8e8eb;">
                           <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="ps-4">
                           <h6></h6>
                        </div>
                     </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="technical" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- สายเทคนิคและบริการ -->

            <div class="col-md-4" id="card_support">
               <div class="card info-card revenue-card" style="border-bottom: 3px solid #454545;">
                  <div class="card-body pb-2">
                     <h5 class="card-title">[SEE-HRM-C9] สายสนับสนุน</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #454545; background: #cbcbcb;">
                           <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="ps-4">
                           <h6></h6>
                        </div>
                     </div>
                  </div>
                  <div class="filter filterDetail">
                     <a class="bi-search toggleCardHRMDetail" data-card-type="support" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                  </div>
               </div>
            </div>
            <!-- end CARD -->

            <div class="col-md-12">
               <div class="card">
                    <div class="filter filterDetail">
                        <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#detailsG1Modal"></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">[SEE-HRM-G1] กราฟแสดงบุคลากรสายแพทย์และสายพยาบาลจำแนกตามแผนก</h5>
                        <div id="g1"></div>
                    </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card">
                    <div class="filter filterDetail">
                        <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#detailsG2Modal"></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">[SEE-HRM-G2] กราฟแสดงประเภทบุคลากร</h5>
                        <div id="g2"></div>
                    </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card">
                    <div class="filter filterDetail">
                        <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#detailsG3Modal"></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">[SEE-HRM-G3] กราฟแสดงข้อมูลจำนวนบุคลากรสายแพทย์และประเภทการปฏิบัติงาน</h5>
                        <div id="g3"></div>
                    </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="card">
                    <div class="filter filterDetail">
                        <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#detailsG4Modal"></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">[SEE-HRM-G4] กราฟจำนวนบุคลากรใบอนุญาติประกอบวิชาชีพจะหมดอายุ</h5>
                        <div id="g4"></div>
                    </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="card">
                     <div class="filter filterDetail">
                        <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#detailsG5Modal"></a>
                    </div>
                  <div class="card-body">
                     <h5 class="card-title">[SEE-HRM-G5] กราฟจำนวนบุคลากรจำแนกตามอายุและเพศ</h5>
                     <div id="g5"></div>
                  </div>
               </div>
            </div>

            <?php if(false){ ?>
            <div class="col-md-12">
               <div class="alert alert-success" role="alert">
                  จำนวนผู้มาปฏิบัติงาน เลือกวัน / เดือน / ปีพ.ศ. <input type="date" class="form-control ms-2 w-25" style="display: inline;" value="">
               </div>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
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
            <div class="col-md-4">
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
            <div class="col-md-8">
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
                              <th>#</th>
                              <th>วันเวลาที่เข้างาน</th>
                              <th>เลขที่พนักงาน</th>
                              <th>ชื่อ - นามสกุล</th>
                              <th>เบอร์โทร</th>
                              <th>สถานะ</th>
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
            <div class="col-md-4">
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
            <?php } ?>
         </div>
      </div>
      <!-- End Left side columns -->
   </div>
</section>

<?php $this->load->view($view_dir.'v_hrm_card'); ?>
<?php $this->load->view($view_dir.'v_hrm_g1'); ?>
<?php $this->load->view($view_dir.'v_hrm_g2'); ?>
<?php $this->load->view($view_dir.'v_hrm_g3'); ?>
<?php $this->load->view($view_dir.'v_hrm_g4'); ?>
<?php $this->load->view($view_dir.'v_hrm_g5'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/grid-light.js"></script>

<script>
var fetchedData = {};

$(document).ready(function() {

    // Example event binding for a card to trigger viewCardHRMDetails function
    $('.toggleCardHRMDetail').on('click', function() {
        var cardType = $(this).data('card-type'); // Assuming card type is stored in data-card-type attribute
        viewCardHRMDetails(cardType);
    });

    // Event binding for tab change to populate DataTable
    $('#detailsTab a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        var cardType = $(e.target).attr('href').substring(1); // Get the card type from the tab href
        populateDataTableCardHRM(cardType);
    });

    filterHRM();

});

function filterHRM(){
   getHRMCard();
   getChartHRM_G1();
   getChartHRM_G2();
   getChartHRM_G3();
   getChartHRM_G4();
   getChartHRM_G5();
}


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
    credits: {
        enabled: false
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