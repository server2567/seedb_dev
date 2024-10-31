<style>
  a.bi-search {
    cursor: pointer;
  }

  .filterDetail {
    right: 20px !important;
  }

  .nav-pills .nav-link {
    /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
    border: 1px dashed #607D8B;
    color: #012970;
  }

  .table {
    border-collapse: collapse !important;
  }

  .hidden {
    display: none;
  }

  .search-bar {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    margin-bottom: 40px !important;
    margin-top: 20px !important;
  }

  .search-bar input {
    width: 50%;
    border-radius: 20px;
    padding: 10px;
    border: 1px solid #ced4da;
    outline: none;
    transition: box-shadow 0.3s ease-in-out;
  }

  .search-bar input:focus {
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
  }

  #searchSection {
    display: none;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
  }

  #searchSection.show {
    display: block;
    opacity: 1;
  }

  .selected-filters {
    position: fixed;
    top: 9px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #bbddff;
    padding: 7px 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    display: none;
    border-radius: 10px;
    border: 1px solid #03A9F4;
  }

  .btn-filters {
    position: fixed;
    top: 10px;
    left: 30%;
    transform: translateX(-50%);
    z-index: 1000;
  }

  @media (max-width: 1600px) {
    .selected-filters {
      left: 50%;
      font-size: 14px;
    }

    .header-nav {
      font-size: 14px;
    }

    .btn-filters {
      position: fixed;
      top: 10px;
      left: 28%;
      transform: translateX(-50%);
      z-index: 1000;
      font-size: 14px;
    }
  }

  .loader {
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #3498db;
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .chart-container {
    position: relative;
    height: 400px;
  }

  .autocomplete-items {
    border: 1px solid #d4d4d4;
    border-top: none;
    z-index: 99;
    position: absolute;
    background-color: #fff;
    max-height: 150px;
    overflow-y: auto;
    width: 875px;
    margin-left: 15px;
  }

  .autocomplete-items div {
    padding: 10px;
    cursor: pointer;
  }

  .autocomplete-items div:hover {
    background-color: #e9e9e9;
  }

  .autocomplete-active {
    background-color: DodgerBlue !important;
    color: #ffffff;
  }

  #calendar {
    max-width: 100%;
    margin: 0 auto;
  }

  .details {
    margin-top: 0px;
  }

  .fc-day,
  .fc-day-top {
    cursor: pointer;
    /* เปลี่ยนเคอร์เซอร์เป็นนิ้วชี้เมื่อชี้ที่วันที่หรือช่องปฏิทิน */
  }

  .clicked-day {
    background-color: #4bc0c0 !important;
    /* สีพื้นหลังเมื่อวันที่ถูกคลิก */
  }

  .current-day {
    background-color: #d5f0f0 !important;
    /* สีพื้นหลังสำหรับวันที่ปัจจุบัน */
  }

  .fc-center>h2 {
    font-size: 24px !important;
  }

  .fc-icon-left-single-arrow:after {
    top: -50% !important;
  }

  .fc-icon-right-single-arrow:after {
    top: -50% !important;
  }

  .fc-unthemed .fc-content,
  .fc-unthemed .fc-divider,
  .fc-unthemed .fc-list-heading td,
  .fc-unthemed .fc-list-view,
  .fc-unthemed .fc-popover,
  .fc-unthemed .fc-row,
  .fc-unthemed tbody,
  .fc-unthemed td,
  .fc-unthemed th,
  .fc-unthemed thead {
    border-color: #84bdc5 !important;
  }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/th.js"></script>
<?php
setlocale(LC_TIME, 'th_TH.utf8');
// Array of Thai month names
$thaiMonths = array(
  'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
  'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
);
?>
<div class="container" style="margin-top: -30px;">
  <div class="d-flex align-items-center justify-content-center my-3 mb-5 search-bar">
    <button class="btn btn-outline-primary me-5 btn-filters" id="toggleSearchBtn">ตัวเลือกอื่นๆ</button>
    <div class="selected-filters" id="selectedFilters"></div>
    <div class="autocomplete" style="width:70%;">
      <input type="text" class="form-control w-100 mb-0" id="searchInput" placeholder="ค้นหาชื่อรายงาน">
    </div>
  </div>

  <div id="searchSection">
    <div class="row">
      <div class="col-md-4">
        <div class="form-floating mb-4">
          <select class="form-select mb-4" id="hrm_select_ums_department" name="hrm_select_ums_department" onchange="filterHRM()">
            <?php
            foreach ($ums_department_list as $key => $row) {
              if ($key == 0) {
                echo '<option value="' . $row->dp_id . '" selected>' . $row->dp_name_th . '</option>';
              } else {
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
    </div>
  </div>
</div>
<section class="section dashboard" id="cardContainer">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="filter filterDetail">
          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#detailsG1Modal"> ดูรายละเอียด</a>
        </div>
        <div class="card-body">
          <h3 class="card-title pt-1 pb-0 font-16 w-90">[HRM-12] รายงานจำนวนบุคลากร จำแนกตามสายงาน</h3>
          <hr>
          <div class="row">
            <!-- กราฟวงกลมด้านซ้าย -->
            <div class="col-md-6">
              <div class="chart-container">
                <div id="loader1" class="loader"></div>
                <div id="donutChartContainer"></div>
              </div>
            </div>
            <!-- การ์ดด้านขวา -->
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div id="card_all">
                    <div class="card info-card sales-card" style="border-bottom: 3px solid #FF9800; background: #fff5e8;">
                      <div class="card-body pb-2">
                        <h5 class="pt-1 pb-3 font-16">[HRM-C1] บุคลากรทั้งหมด</h5>
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
                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="all" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="card_admin">
                    <div class="card info-card revenue-card" style="border-bottom: 3px solid #E91E63; background: #ffe9f1;">
                      <div class="card-body pb-2">
                        <h5 class="pt-1 pb-3 font-16">[HRM-C2] สายบริหาร</h5>
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #E91E63;background: #ffc1d6;">
                            <i class="bi bi-person-fill-gear"></i>
                          </div>
                          <div class="ps-4">
                            <h6></h6>
                          </div>
                        </div>
                      </div>
                      <div class="filter filterDetail">
                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12  toggleCardHRMDetail" data-card-type="nurse" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="card_medical">
                    <div class="card info-card customers-card" style="border-bottom: 3px solid #00bcd4; background: #e8faff;">
                      <div class="card-body pb-2">
                        <h5 class="pt-1 pb-3  font-16">[HRM-C3] สายแพทย์เต็มเวลา / แพทย์บางเวลา</h5>
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #00BCD4; background: #a7f5ff;">
                            <i class="bi bi-person-hearts"></i>
                          </div>
                          <div class="ps-4">
                            <h6></h6>
                          </div>
                        </div>
                      </div>
                      <div class="filter filterDetail">
                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12  toggleCardHRMDetail" data-card-type="medical" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="card_nurse">
                    <div class="card info-card revenue-card" style="border-bottom: 3px solid #4bc0c0; background: #e8fff9;">
                      <div class="card-body pb-2">
                        <h5 class="pt-1 pb-3  font-16">[HRM-C4] สายพยาบาล</h5>
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #18a1a1;background: #b1ebeb;">
                            <i class="ri ri-nurse-fill"></i>
                          </div>
                          <div class="ps-4">
                            <h6></h6>
                          </div>
                        </div>
                      </div>
                      <div class="filter filterDetail">
                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12  toggleCardHRMDetail" data-card-type="nurse" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="card_support">
                    <div class="card info-card revenue-card" style="border-bottom: 3px solid #9866ff; background: #f5f1ff;">
                      <div class="card-body pb-2">
                        <h5 class="pt-1 pb-3 font-16">[HRM-C5] สายสนับสนุนทางการแพทย์</h5>
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9866ff; background: #e0d1ff;">
                            <i class="bi bi-person-fill-check"></i>
                          </div>
                          <div class="ps-4">
                            <h6></h6>
                          </div>
                        </div>
                      </div>
                      <div class="filter filterDetail">
                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="support" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="card_technical">
                    <div class="card info-card revenue-card" style="border-bottom: 3px solid #607D8B; background: #ebebeb;">
                      <div class="card-body pb-2">
                        <h5 class="pt-1 pb-3 font-16">[HRM-C6] สายเทคนิคและบริการ</h5>
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #3c5e6e; background: #cdcdcd;">
                            <i class="bi bi-person-fill"></i>
                          </div>
                          <div class="ps-4">
                            <h6></h6>
                          </div>
                        </div>
                      </div>
                      <div class="filter filterDetail">
                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="support" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div> <!-- .row -->
            </div> <!-- .col-md-6 -->
          </div> <!-- .row -->
        </div> <!-- .card-body -->
      </div> <!-- .card -->
    </div> <!-- .col-md-12 -->
    <div class="col-md-6">
      <div class="card">
        <div class="filter filterDetail">
          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#"></a>
        </div>
        <div class="card-body">
          <h5 class="card-title pt-1 pb-0 font-16 w-90">[HRM-2] รายงานจำนวนบุคลากร จำแนกตามฝ่าย</h5>
          <hr>
          <div class="row">
            <!-- กราฟวงกลมด้านซ้าย -->
            <div class="col-md-12">
              <div class="chart-containe">
                <div id="loader2" class="loader"></div>
                <div id="PictorialchartContainer" style="height:370px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="filter filterDetail">
          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#"></a>
        </div>
        <div class="card-body">
          <h5 class="card-title pt-1 pb-0 font-16 w-90">[HRM-3] รายงานอายุการทำงานของบุคลากร จำแนกตามฝ่าย</h5>
          <hr>
          <div class="row">
            <!-- กราฟวงกลมด้านซ้าย -->
            <div class="col-md-12">
              <div class="chart-containe">
                <div id="loader3" class="loader"></div>
                <div id="tenureChartContainer" style="height:370px;"></div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="filter filterDetail">
          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#"></a>
        </div>
        <div class="card-body">
          <h5 class="card-title pt-1 pb-0 font-16 w-90">[HRM-4] รายงานจำนวนแพทย์ และพยาบาลที่อยู่ในแผนก</h5>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="chart-containe">
                <div id="doctorTreeMap"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="filter filterDetail">
          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#"></a>
        </div>
        <div class="card-body">
          <h5 class="card-title pt-1 pb-0 font-16 w-90">[HRM-5] รายงานจำนวนวุฒิการศึกษาของแต่ละสายงาน จำแนกตามวุฒิการศึกษา</h5>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="chart-containe">
                <div id="educationChart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <p class="text-center font-20 text-primary fw-bold">ระบบ HRD อยู่ระหว่างดำเนินการพัฒนา <i class="bi bi-arrow-down-square-fill text-success font-30 ps-5"></i></p>
    <hr>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title pt-1 pb-0 font-16 w-90">[HRD-1] รายงานการมาทำงานปกติ การมาทำงานสาย การลางาน และจำนวนแพทย์ที่ออกตรวจ</h5>
          <hr>
          <div class="row">
            <div class="col-md-5">
              <div id="calendar"></div>
            </div>
            <div class="col-md-7">
              <div id="details" class="details"></div>
              <div class="row" style="border: 1px solid #ddd; border-radius: 10px; margin-left: 0px; margin-right: 0px; padding-top: 10px;">
                <div class="col-md-6">
                  <div id="leaveSummaryChart"></div>
                </div>
                <div class="col-md-6">
                  <div id="details_label" style="margin-top: 60px; line-height: 2.5;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title pt-1 pb-0 font-16 w-90 ">[HRD-2] รายงานจำนวนชั่วโมงการทำงานของพยาบาล ประจำเดือน
            <select id="month-select" class="form-select w-15 d-inline me-5 ms-3">
              <option value="มกราคม">มกราคม</option>
              <option value="กุมภาพันธ์">กุมภาพันธ์</option>
              <option value="มีนาคม">มีนาคม</option>
              <option value="เมษายน">เมษายน</option>
              <option value="พฤษภาคม">พฤษภาคม</option>
              <option value="มิถุนายน">มิถุนายน</option>
              <option value="กรกฎาคม">กรกฎาคม</option>
              <option value="สิงหาคม">สิงหาคม</option>
              <option value="กันยายน">กันยายน</option>
              <option value="ตุลาคม">ตุลาคม</option>
              <option value="พฤศจิกายน">พฤศจิกายน</option>
              <option value="ธันวาคม">ธันวาคม</option>
            </select>
          </h5>
          <hr>
          <div class="row">
            <!-- Container for Donut Chart -->
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="card info-card sales-card" style="border-bottom: 3px solid #4bc0c0; background: #e8fff9;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3 font-16">[HRD-C5] จำนวนพยาบาลทั้งหมด</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #18a1a1; background: #b1ebeb;">
                          <i class="ri ri-nurse-fill"></i>
                        </div>
                        <div class="ps-4">
                          <h6 id="total-nurses">120 คน</h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card info-card revenue-card" style="border-bottom: 3px solid #607D8B; background: #ebebeb;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3 font-16">[HRD-C6] ยังไม่ได้จัดลงตารางเวร</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #3c5e6e;background: #cdcdcd;">
                          <i class="bi bi-inboxes"></i>
                        </div>
                        <div class="ps-4">
                          <h6 id="unscheduled-nurses">20 คน</h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card info-card revenue-card" style="border-bottom: 3px solid #4CAF50; background: #f5fff6;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3 font-16">[HRD-C7] จำนวนชั่วโมงมากกว่า 220 ชั่วโมง</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4CAF50;background: #c8e6c9;">
                          <i class="bi bi-layer-forward"></i>
                        </div>
                        <div class="ps-4">
                          <h6 id="more-than-220">70 คน</h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card info-card revenue-card" style="border-bottom: 3px solid #FFC107; background: #fff8e1;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3 font-16">[HRD-C8] จำนวนชั่วโมงน้อยกว่า 220 ชั่วโมง</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #c39305;background: #ffecb3;">
                          <i class="bi bi-layer-backward"></i>
                        </div>
                        <div class="ps-4">
                          <h6 id="less-than-220">30 คน</h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14 float-end" title="คลิกเพื่อดูรายละเอียด"> ดูรายละเอียด</a>
              <div id="loader4" class="loader"></div>
              <div id="donut-chart" style="width: 100%; height: 400px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title pt-1 pb-0 font-16 w-90">[PAY-1] รายงานรายจ่ายค่าตอบแทนรายเดือน และค่าสวัสดิการต่างๆ ประจำเดือน
            <select id="month-select-pay" class="form-select w-15 d-inline me-5 ms-3">
              <option value="มกราคม">มกราคม</option>
              <option value="กุมภาพันธ์">กุมภาพันธ์</option>
              <option value="มีนาคม">มีนาคม</option>
              <option value="เมษายน">เมษายน</option>
              <option value="พฤษภาคม">พฤษภาคม</option>
              <option value="มิถุนายน">มิถุนายน</option>
              <option value="กรกฎาคม">กรกฎาคม</option>
              <option value="สิงหาคม">สิงหาคม</option>
              <option value="กันยายน">กันยายน</option>
              <option value="ตุลาคม">ตุลาคม</option>
              <option value="พฤศจิกายน">พฤศจิกายน</option>
              <option value="ธันวาคม">ธันวาคม</option>
            </select>
          </h5>
          <hr>
          <div class="row">
            <div class="col-md-3">
              <div class="card info-card revenue-card" style="border-bottom: 3px solid #4CAF50; background: #f5fff6;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[PAY-C1] สรุปยอดรายจ่าย</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4CAF50;background: #c8e6c9;">
                      <i class="bi bi-person-fill-gear"></i>
                    </div>
                    <div class="ps-4">
                      <h6 id="pay-c1-amount"><?php echo number_format('9878900', 2) ?> บาท</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card info-card revenue-card" style="border-bottom: 3px solid #00bcd4; background: #e8faff;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[PAY-C2] รายจ่ายเงินเดือน</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #00BCD4;background: #a7f5ff;">
                      <i class="bi bi-person-fill-gear"></i>
                    </div>
                    <div class="ps-4">
                      <h6 id="pay-c2-amount"><?php echo number_format('9154700', 2) ?> บาท</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card info-card revenue-card" style="border-bottom: 3px solid #9866ff; background: #f5f1ff;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[PAY-C3] รายการค่าสวัสดิการต่างๆ</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9866ff;background: #e0d1ff;">
                      <i class="bi bi-person-fill-gear"></i>
                    </div>
                    <div class="ps-4">
                      <h6 id="pay-c3-amount"><?php echo number_format('724200', 2) ?> บาท</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card info-card revenue-card" style="border-bottom: 3px solid #9bab00; background: #fbffd3;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[PAY-C4] จำนวนเลขที่ใบ Payroll</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #417800;background: #d9e374;">
                      <i class="bi bi-person-fill-gear"></i>
                    </div>
                    <div class="ps-4">
                      <h6 id="pay-c4-amount">30 ใบ</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#"> ดูรายละเอียด</a>
                </div>
                <div class="card-body">
                  <h5 class="card-title pt-1 pb-0 font-16 w-90" data-title-id="pay-2-title">[PAY-2] กราฟแสดงรายจ่าย จำแนกตามประเภทของรายจ่าย ประจำเดือนสิงหาคม</h5>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="chart-containe">
                        <div id="SplitPacked"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#"> ดูรายละเอียด</a>
                </div>
                <div class="card-body">
                  <h5 class="card-title pt-1 pb-0 font-16 w-90">[PAY-3] กราฟแสดงเปรียบเทียบรายจ่ายของแต่ละเดือน</h5>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="chart-containe">
                        <div id="barChartContainer"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<?php $this->load->view($view_dir . 'v_hrm_card'); ?>
<?php $this->load->view($view_dir . 'v_hrm_g1'); ?>
<?php $this->load->view($view_dir . 'v_hrm_g2'); ?>
<?php $this->load->view($view_dir . 'v_hrm_g3'); ?>
<?php $this->load->view($view_dir . 'v_hrm_g4'); ?>
<?php $this->load->view($view_dir . 'v_hrm_g5'); ?>
<!-- Bootstrap Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="employeeTable" class="table table-striped datatable" style="width:100%;">
          <thead>
            <tr>
              <th class="w-5">ลำดับ</th>
              <th>ชื่อ-นามสกุล</th>
              <th>ฝ่าย</th>
              <th>แผนก</th>
              <th class="w-20">วันที่เริ่มทำงาน</th>
              <th class="w-15">อายุงาน</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doctorModalLabel">รายชื่อแพทย์</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="doctorList">
        <!-- รายชื่อแพทย์จะถูกแทรกที่นี่ -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/sunburst.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/pictorial.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/grid-light.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/heatmap.js"></script>
<script src="https://code.highcharts.com/modules/treemap.js"></script>
<script>
  $(document).ready(function() {
    function updateCalendarTitle() {
      var titleText = $('.fc-center h2').text();
      var yearMatch = titleText.match(/\d{4}/);
      if (yearMatch) {
        var yearAD = parseInt(yearMatch[0]);
        var yearBE = yearAD + 543;
        var newTitleText = titleText.replace(yearAD, yearBE);
        $('.fc-center h2').text(newTitleText);
      }
    }

    function updateDateDetails(date) {
      var dateStr = date.format('LL'); // รูปแบบวันที่แบบไทย
      var dateStrBE = dateStr.replace(/\d{4}/, function(year) {
        return parseInt(year) + 543;
      });
      return dateStrBE;
    }

    var events = [{
        title: 'ปกติ: 20 คน',
        start: '2024-08-01',
        description: '[HRD-C1] มาทำงานปกติ',
        order: 1,
        color: '#4CAF50',
        textColor: '#FFFFFF'
      },
      {
        title: 'สาย: 5 คน',
        start: '2024-08-01',
        description: '[HRD-C2] มาทำงานสาย',
        order: 2,
        color: '#F44336',
        textColor: '#FFFFFF'
      },
      {
        title: 'ลา: 5 คน / 4 ครั้ง',
        start: '2024-08-01',
        description: '[HRD-C3] ลาป่วย ลาพักร้อน ลากิจ',
        order: 3,
        color: '#FFC107',
        textColor: '#000'
      },
      {
        title: 'แพทย์: 7 คน',
        start: '2024-08-01',
        description: '[HRD-C4] จำนวนแพทย์ออกตรวจ',
        order: 4,
        color: '#2196F3',
        textColor: '#FFFFFF'
      },
      {
        title: 'มาทำงานปกติ: 22 คน',
        start: '2024-08-04',
        description: '[HRD-C1] มาทำงานปกติ',
        order: 1,
        color: '#4CAF50',
        textColor: '#FFFFFF'
      },
      {
        title: 'สาย: 3 คน',
        start: '2024-08-04',
        description: '[HRD-C2] มาทำงานสาย',
        order: 2,
        color: '#F44336',
        textColor: '#FFFFFF'
      },
      {
        title: 'การลา: 3 คน / 30 ครั้ง',
        start: '2024-08-04',
        description: '[HRD-C3] ลาป่วย ลาพักร้อน ลากิจ',
        order: 3,
        color: '#FFC107',
        textColor: '#000'
      },
      {
        title: 'แพทย์: 8 คน',
        start: '2024-08-04',
        description: '[HRD-C4] จำนวนแพทย์ออกตรวจ',
        order: 4,
        color: '#2196F3',
        textColor: '#FFFFFF'
      }
    ];

    // แสดงรายละเอียดของวันที่ปัจจุบัน
    var today = moment();
    var todayStrBE = updateDateDetails(today);
    var dayName = today.format('dddd'); // แสดงชื่อวันในภาษาไทย
    var monthName = today.format('MMMM'); // แสดงชื่อวันในภาษาไทย
    $('#details').html(`
        <h5 class="mt-2 mb-4">ข้อมูลรายละเอียดสำหรับวัน${dayName} ที่ (${todayStrBE})</h5>
        <div class="row">
          <div class="col-md-6">
            <div id="card_work">
              <div class="card info-card sales-card" style="border-bottom: 3px solid #4CAF50; background: #e8f5e9;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[HRD-C1] มาทำงานปกติ</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4CAF50; background: #c8e6c9;">
                      <i class="bi bi-person-check"></i>
                    </div>
                    <div class="ps-4">
                      <h6>20 คน</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="work" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div id="card_late">
              <div class="card info-card sales-card" style="border-bottom: 3px solid #F44336; background: #ffebee;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[HRD-C2] มาทำงานสาย</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #F44336; background: #ffcdd2;">
                      <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="ps-4">
                      <h6>5 คน</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="late" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div id="card_leave">
              <div class="card info-card sales-card" style="border-bottom: 3px solid #FFC107; background: #fff8e1;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[HRD-C3] ลาป่วย ลาพักร้อน ลากิจ</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #FFC107; background: #ffecb3;">
                      <i class="bi bi-person-x"></i>
                    </div>
                    <div class="ps-4">
                      <h6>5 คน / 10 ครั้ง</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="leave" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div id="card_doctors">
              <div class="card info-card sales-card" style="border-bottom: 3px solid #2196F3; background: #e3f2fd;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[HRD-C4] จำนวนแพทย์ออกตรวจ</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #2196F3; background: #bbdefb;">
                      <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="ps-4">
                      <h6>7 คน</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="doctors" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      `);

    setTimeout(function() {
      // สร้างกราฟ Highcharts แบบครึ่งวงกลม
      Highcharts.chart('leaveSummaryChart', {
        chart: {
          type: 'pie',
          height: 300,
          style: {
            fontSize: '16px' // ขนาดฟอนต์ของทั้งกราฟ
          }
        },
        title: {
          text: `[HRD-C3-G1] ผลสรุปการลาประจำเดือน ${monthName}`,
          align: 'left', // ตัวอักษรอยู่ทางซ้าย
          style: {
            color: '#012970', // สีน้ำเงิน
            fontSize: '18px' // ขนาดฟอนต์ 16px
          }
        },
        colors: ['#36A2EB', '#4BC0C0', '#9966FF', '#F44336'], // สีสดใส
        tooltip: {
          useHTML: true,
          formatter: function() {
            return `
                    <span style="color: ${this.point.color}; font-size: 16px">${this.key}</span>: 
                    <span style="font-size: 16px">${this.y} ครั้ง</span>
                `;
          },
          style: {
            fontSize: '16px' // ขนาดฟอนต์ของทูลทิป
          }
        },
        plotOptions: {
          pie: {
            innerSize: '50%',
            depth: 45,
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '100%'],
            dataLabels: {
              distance: 0,
              enabled: true,
              style: {
                fontSize: '14px', // ขนาดฟอนต์ของป้ายข้อมูล
                color: '#000000'
              },
              format: '{point.name}: {point.y} คน'
            }
          }
        },
        legend: {
          itemStyle: {
            fontSize: '16px' // ขนาดฟอนต์ของตำนานกราฟ
          }
        },
        series: [{
          name: 'จำนวนการลา',
          data: [{
              name: 'ลาป่วย',
              y: 5
            },
            {
              name: 'ลาพักร้อน',
              y: 3
            },
            {
              name: 'ลากิจ',
              y: 2
            },
            {
              name: 'สาย',
              y: 2
            }
          ] // แทนที่ค่าด้วยค่าจริงที่ต้องการแสดง
        }]
      });
    }, 500); // Match the transition duration
    $('#details_label').html(`
      <span class="badge rounded-pill bg-primary font-16 me-4">ลาป่วย</span><span class="font-20 fw-bold" style="padding-left: 25px;"> 5 คน / 5 ครั้ง
      <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
      <span class="badge rounded-pill bg-success font-16 me-4">ลาพักร้อน</span><span class="font-20 fw-bold" style="padding-left: 3px;"> 3 คน / 3 ครั้ง
      <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
      <span class="badge rounded-pill font-16 me-4" style="background:#480ac7;">ลากิจ</span><span class="font-20 fw-bold" style="padding-left: 34px;"> 2 คน / 2 ครั้ง
      <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
      <span class="badge rounded-pill bg-danger font-16 me-1">มาทำงานสาย</span><span class="font-20 fw-bold" style="padding-left: 0px;"> 2 คน / 2 ครั้ง
      <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span>
      `);

    $('#calendar').fullCalendar({
      locale: 'th',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month'
      },
      events: events,
      eventOrder: "order",
      dayClick: function(date, jsEvent, view) {
        var dateStrBE = updateDateDetails(date);
        var dayName = today.format('dddd'); // แสดงชื่อวันในภาษาไทย
        // ลบคลาสที่เน้นสีจากวันที่ที่เคยถูกคลิกมาก่อนหน้า
        $('#calendar').find('.fc-day').removeClass('clicked-day');

        // เพิ่มคลาสเพื่อเน้นสีวันที่ที่ถูกคลิก
        $(this).addClass('clicked-day');

        // ลบการ์ดเก่าก่อนที่จะแสดงการ์ดใหม่
        $('#details').empty();
        $('#details_label').empty();

        // กรอง event ตามวันที่คลิก
        var filteredEvents = events.filter(function(event) {
          return moment(event.start).isSame(date, 'day');
        });

        // เรียงลำดับ event ตามประเภทของการ์ด
        filteredEvents.sort(function(a, b) {
          return a.order - b.order;
        });


        if (filteredEvents.length > 0) {
          // แสดงรายละเอียดวันที่ที่คลิกในคอลัมน์ขวา
          $('#details').html(`
          <h5 class="mt-2 mb-4">ข้อมูลรายละเอียดสำหรับวัน${dayName} ที่ ${dateStrBE}</h5>
          <div class="row"></div>
      `);

          filteredEvents.forEach(function(event) {
            var cardColor, iconClass, backgroundColor, iconBgColor;

            // กำหนดสีและไอคอนตามประเภทของการ์ด
            if (event.description.includes('[HRD-C1]')) {
              cardColor = '#4CAF50';
              iconClass = 'bi bi-person-check';
              backgroundColor = '#e8f5e9';
              iconBgColor = '#c8e6c9';
            } else if (event.description.includes('[HRD-C2]')) {
              cardColor = '#F44336';
              iconClass = 'bi bi-clock-history';
              backgroundColor = '#ffebee';
              iconBgColor = '#ffcdd2';
            } else if (event.description.includes('[HRD-C3]')) {
              cardColor = '#FFC107';
              iconClass = 'bi bi-person-x';
              backgroundColor = '#fff8e1';
              iconBgColor = '#ffecb3';
            } else if (event.description.includes('[HRD-C4]')) {
              cardColor = '#2196F3';
              iconClass = 'bi bi-person-badge';
              backgroundColor = '#e3f2fd';
              iconBgColor = '#bbdefb';
            }

            $('#details .row').append(`
              <div class="col-md-6">
                  <div class="card info-card sales-card" style="border-bottom: 3px solid ${cardColor}; background: ${backgroundColor};">
                      <div class="card-body pb-2">
                          <h5 class="pt-1 pb-3 font-16">${event.description}</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: ${cardColor}; background: ${iconBgColor};">
                                  <i class="${iconClass}"></i>
                              </div>
                              <div class="ps-4">
                                  <h6>${event.title.split(':')[1]}</h6>
                              </div>
                          </div>
                      </div>
                      <div class="filter filterDetail">
                          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="work" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                      </div>
                  </div>
              </div>
          `);
          });

          setTimeout(function() {
            // สร้างกราฟ Highcharts แบบครึ่งวงกลม
            Highcharts.chart('leaveSummaryChart', {
              chart: {
                type: 'pie',
                height: 300,
                style: {
                  fontSize: '16px' // ขนาดฟอนต์ของทั้งกราฟ
                }
              },
              title: {
                text: `[HRD-C3-G1] ผลสรุปการลาประจำเดือน ${monthName}`,
                align: 'left', // ตัวอักษรอยู่ทางซ้าย
                style: {
                  color: '#012970', // สีน้ำเงิน
                  fontSize: '18px' // ขนาดฟอนต์ 16px
                }
              },
              colors: ['#36A2EB', '#4BC0C0', '#9966FF', '#F44336'], // สีสดใส
              tooltip: {
                useHTML: true,
                formatter: function() {
                  return `
                        <span style="color: ${this.point.color}; font-size: 16px">${this.key}</span>: 
                        <span style="font-size: 16px">${this.y} ครั้ง</span>
                    `;
                },
                style: {
                  fontSize: '16px' // ขนาดฟอนต์ของทูลทิป
                }
              },
              plotOptions: {
                pie: {
                  innerSize: '50%',
                  depth: 45,
                  startAngle: -90,
                  endAngle: 90,
                  center: ['50%', '75%'],
                  dataLabels: {
                    distance: 0,
                    enabled: true,
                    style: {
                      fontSize: '14px', // ขนาดฟอนต์ของป้ายข้อมูล
                      color: '#000000'
                    },
                    format: '{point.name}: {point.y} ครั้ง'
                  }
                }
              },
              legend: {
                itemStyle: {
                  fontSize: '16px' // ขนาดฟอนต์ของตำนานกราฟ
                }
              },
              series: [{
                name: 'จำนวนการลา',
                data: [{
                    name: 'ลาป่วย',
                    y: 5
                  },
                  {
                    name: 'ลาพักร้อน',
                    y: 3
                  },
                  {
                    name: 'ลากิจ',
                    y: 2
                  },
                  {
                    name: 'สาย',
                    y: 2
                  }
                ] // แทนที่ค่าด้วยค่าจริงที่ต้องการแสดง
              }]
            });
          }, 500); // Match the transition duration
          $('#details_label').html(`
          <span class="badge rounded-pill bg-primary font-16 me-4">ลาป่วย</span><span class="font-20 fw-bold" style="padding-left: 25px;"> 5 คน / 5 ครั้ง
          <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
          <span class="badge rounded-pill bg-success font-16 me-4">ลาพักร้อน</span><span class="font-20 fw-bold" style="padding-left: 3px;"> 3 คน / 3 ครั้ง
          <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
          <span class="badge rounded-pill font-16 me-4" style="background:#480ac7;">ลากิจ</span><span class="font-20 fw-bold" style="padding-left: 34px;"> 2 คน / 2 ครั้ง
          <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
          <span class="badge rounded-pill bg-danger font-16 me-1">มาทำงานสาย</span><span class="font-20 fw-bold" style="padding-left: 0px;"> 2 คน / 2 ครั้ง
          <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span>
          `);
        } else {
          // แสดงข้อความไม่มีข้อมูลถ้าไม่มี event ในวันนั้น
          $('#details').html(`
          <h5 class="mt-2 mb-4">ข้อมูลรายละเอียดสำหรับวัน${dayName} ที่ ${dateStrBE}</h5>
          <p>ไม่มีข้อมูล</p>
      `);

          // ลบกราฟ Highcharts ถ้าไม่มีข้อมูล
          $('#leaveSummaryChart').empty();
        }
      },
      viewRender: function(view, element) {
        // เพิ่มคลาส current-day ให้กับวันที่ปัจจุบัน
        var todayElement = $('#calendar').find('.fc-today');
        todayElement.addClass('current-day');

        // แปลงปี ค.ศ. เป็นปี พ.ศ. ใน title
        setTimeout(updateCalendarTitle, 10);
      }
    });


    // เปลี่ยนข้อความ "วันนี้" เป็น "เปลี่ยนเดือน"
    $(".fc-today-button").text("เปลี่ยนเดือน");
  });

  document.getElementById('toggleSearchBtn').addEventListener('click', function() {
    var searchSection = document.getElementById('searchSection');
    if (searchSection.classList.contains('show')) {
      searchSection.classList.remove('show');
      setTimeout(function() {
        searchSection.style.display = 'none';
      }, 500); // Match the transition duration
    } else {
      searchSection.style.display = 'block';
      setTimeout(function() {
        searchSection.classList.add('show');
      }, 5); // Small delay to ensure display:block is applied
    }
  });

  var reports = [];
  document.querySelectorAll('.card-title').forEach(function(title) {
    reports.push(title.innerText || title.textContent);
  });

  document.getElementById('searchInput').addEventListener('input', function() {
    var filter = this.value.toUpperCase();
    var cards = document.querySelectorAll('#cardContainer .card');
    filterCards(filter);

    closeAllLists();
    if (!this.value) {
      return false;
    }
    var a, b, i, val = this.value;
    a = document.createElement("DIV");
    a.setAttribute("id", this.id + "autocomplete-list");
    a.setAttribute("class", "autocomplete-items");
    this.parentNode.appendChild(a);
    for (i = 0; i < reports.length; i++) {
      if (reports[i].toUpperCase().includes(val.toUpperCase())) {
        b = document.createElement("DIV");
        b.innerHTML = "<strong>" + reports[i].substr(0, val.length) + "</strong>";
        b.innerHTML += reports[i].substr(val.length);
        b.innerHTML += "<input type='hidden' value='" + reports[i] + "'>";
        b.addEventListener("click", function(e) {
          document.getElementById('searchInput').value = this.getElementsByTagName("input")[0].value;
          filterCards(this.getElementsByTagName("input")[0].value.toUpperCase());
          closeAllLists();
        });
        a.appendChild(b);
      }
    }
  });

  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != document.getElementById('searchInput')) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }

  document.addEventListener("click", function(e) {
    closeAllLists(e.target);
  });

  function filterCards(filter) {
    var cards = document.querySelectorAll('#cardContainer .card');
    cards.forEach(function(card) {
      var title = card.querySelector('.card-title');
      if (title) {
        var text = title.innerText || title.textContent;
        if (text.toUpperCase().indexOf(filter) > -1) {
          card.parentElement.classList.remove('hidden');
        } else {
          card.parentElement.classList.add('hidden');
        }
      }
    });
  }

  function updateSelectedFilters() {
    var department = document.getElementById('hrm_select_ums_department');
    var yearType = document.getElementById('hrm_select_year_type');
    var year = document.getElementById('hrm_select_year');

    var selectedFilters = document.getElementById('selectedFilters');
    selectedFilters.innerHTML = 'หน่วยงาน: ' + department.options[department.selectedIndex].text +
      ' | ประเภทปี: ' + yearType.options[yearType.selectedIndex].text +
      ' | ปีพ.ศ.: ' + year.options[year.selectedIndex].text;
    selectedFilters.style.display = 'block';
  }

  // Initial call to display default selected filters
  updateSelectedFilters();

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

  function filterHRM() {
    getHRMCard();
    getChartHRM_G1();
    getChartHRM_G2();
    getChartHRM_G3();
    getChartHRM_G4();
    getChartHRM_G5();
    updateSelectedFilters();
  }

  document.getElementById('loader1').classList.remove('hidden');
  document.getElementById('loader2').classList.remove('hidden');
  document.getElementById('loader3').classList.remove('hidden');
  document.getElementById('loader4').classList.remove('hidden');
  setTimeout(function() {
    const legendStatusKey = 'legendStatus';
    // ฟังก์ชันเก็บสถานะของตำนานใน LocalStorage
    function saveLegendStatus(chart) {
      const legendItems = chart.series[0].data;
      const legendVisibility = legendItems.map(item => item.visible);
      localStorage.setItem(legendStatusKey, JSON.stringify(legendVisibility));
    }

    function saveLegendStatus2(chart) {
      const seriesVisibility = chart.series.map(series => series.visible);
      localStorage.setItem(legendStatusKey, JSON.stringify(seriesVisibility));
    }
    // ฟังก์ชันตั้งค่าสถานะของตำนานจาก LocalStorage
    function loadLegendStatus(chart) {
      const legendStatus = localStorage.getItem(legendStatusKey);
      if (legendStatus) {
        const legendVisibility = JSON.parse(legendStatus);
        chart.series[0].data.forEach((item, index) => {
          item.setVisible(legendVisibility[index], false);
        });
        chart.redraw();
      }
    }
    // Function to load the visibility status of series from LocalStorage
    function loadLegendStatus2(chart) {
      const legendStatus = localStorage.getItem(legendStatusKey);
      if (legendStatus) {
        const seriesVisibility = JSON.parse(legendStatus);
        chart.series.forEach((series, index) => {
          series.setVisible(seriesVisibility[index], false);
        });
        chart.redraw();
      }
    }
    Highcharts.chart('donutChartContainer', {
      chart: {
        type: 'pie',
        height: 500,
        events: {
          load: function() {
            // ซ่อนตัวโหลดเมื่อกราฟโหลดเสร็จ
            document.getElementById('loader1').classList.add('hidden');

            // โหลดสถานะการแสดงตำนาน
            loadLegendStatus(this);

            // เพิ่มการฟังเหตุการณ์คลิกที่ตำนานเพื่อตั้งค่าสถานะใหม่
            this.series[0].data.forEach(point => {
              Highcharts.addEvent(point, 'legendItemClick', function() {
                saveLegendStatus(this.series.chart);
              });
            });
          }
        }
      },
      title: {
        text: ''
      },
      plotOptions: {
        pie: {
          innerSize: '60%',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: <br>{point.y} คน ({point.percentage:.1f}%)',
            style: {
              fontSize: '14px',
              color: '#000000'
            }
          },
          showInLegend: true
        }
      },
      tooltip: {
        useHTML: true,
        formatter: function() {
          return `<span style="color:${this.color}">\u25CF</span> <b>${this.point.name}</b>:<br> ${this.y} คน ร้อยละ (${this.percentage.toFixed(1)}%)`;
        },
        style: {
          fontSize: '14px',
          color: '#000000'
        }
      },
      colors: ['#FF6384', '#36A2EB', '#4BC0C0', '#9966FF', '#607d8b'], // สีสดใส
      series: [{
        name: 'บุคลากร',
        data: [{
            name: 'สายบริหาร',
            y: 50
          },
          {
            name: 'สายแพทย์เต็มเวลา / บางเวลา',
            y: 30
          },
          {
            name: 'สายพยาบาล',
            y: 50
          },
          {
            name: 'สายสนับสนุนทางการแพทย์',
            y: 20
          },
          {
            name: 'สายเทคนิคและบริการ',
            y: 20
          }
        ]
      }],
    });

    Highcharts.chart('PictorialchartContainer', {
      chart: {
        type: 'pictorial',
        events: {
          load: function() {
            // ซ่อนตัวโหลดเมื่อกราฟโหลดเสร็จ
            document.getElementById('loader2').classList.add('hidden');

            // โหลดสถานะการแสดงตำนาน
            loadLegendStatus2(this);

            // เพิ่มการฟังเหตุการณ์คลิกที่ตำนานเพื่อตั้งค่าสถานะใหม่
            this.series.forEach(series => {
              Highcharts.addEvent(series, 'legendItemClick', function() {
                saveLegendStatus2(this.chart);
              });
            });
          }
        }
      },

      colors: ['#36A2EB', '#FF6384', '#4BC0C0', '#FF9F40', '#9966FF', '#607d8b'], // สีสดใส
      title: {
        text: ''
      },
      accessibility: {
        screenReaderSection: {
          beforeChartFormat: '<{headingTagName}>' +
            '{chartTitle}</{headingTagName}><p>{typeDescription}</p><p>' +
            '{chartSubtitle}</p><p>{chartLongdesc}</p>'
        },
        point: {
          valueDescriptionFormat: '{value} คน'
        },
        series: {
          descriptionFormat: ''
        },
        landmarkVerbosity: 'one'
      },

      xAxis: {
        visible: false,
        min: 0.18
      },

      yAxis: {
        visible: false
      },
      legend: {
        align: 'right',
        floating: true,
        itemMarginTop: 5,
        itemMarginBottom: 5,
        layout: 'vertical',
        margin: 10,
        padding: 10,
        verticalAlign: 'middle'
      },
      tooltip: {
        formatter: function() {
          if (this.point.drilldown) {
            return '<span style="color:' + this.series.color + '">\u25CF</span> <b>' + this.series.name + '</b><br/>' +
              'จำนวน: ' + Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน' +
              '<br/>ร้อยละ: ' + this.percentage.toFixed(1) + '%';
          } else {
            return '<span style="color:' + this.point.color + '">\u25CF</span> <b>' + this.point.name + '</b><br/>' +
              'จำนวน: ' + Highcharts.numberFormat(this.point.value, 0, '.', ',') + ' คน';
          }
        },
        style: {
          fontSize: '16px'
        }
      },
      plotOptions: {
        series: {
          pointPadding: 0,
          groupPadding: 0,
          borderWidth: 0,
          dataLabels: {
            enabled: true,
            align: 'center',
            formatter: function() {
              if (this.point.drilldown) {
                return Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน' + ' (' + this.point.percentage.toFixed(1) + '%)';
              } else {
                return this.point.name + ': ' + Highcharts.numberFormat(this.point.value, 0, '.', ',') + ' คน';
              }
            },
            style: {
              fontSize: '14px'
            }
          },
          stacking: 'percent',
          paths: [{
            definition: 'M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1l32 0 0 160.4c0 35.3 28.7 64 64 64l320.4 0c35.5 0 64.2-28.8 64-64.3l-.7-160.2 32 0zM256 208c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 48 48 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-48 0 0 48c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-48-48 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16l48 0 0-48z'
          }]
        }
      },

      series: [{
        name: 'ฝ่ายพัฒนาคุณภาพและทรัพยากรบุคคล',
        data: [{
          y: 25,
          drilldown: 'qualityAndHR'
        }]
      }, {
        name: 'ฝ่ายบริหารทั่วไป',
        data: [{
          y: 40,
          drilldown: 'admin'
        }]
      }, {
        name: 'ฝ่ายการเงินและบัญชี',
        data: [{
          y: 35,
          drilldown: 'finance'
        }]
      }, {
        name: 'ฝ่ายการพยาบาล',
        data: [{
          y: 30,
          drilldown: 'nursing'
        }]
      }, {
        name: 'ฝ่ายสนับสนุนทางการแพทย์',
        data: [{
          y: 25,
          drilldown: 'support'
        }]
      }, {
        name: 'ฝ่ายเทคนิคและบริการ',
        data: [{
          y: 18,
          drilldown: 'technical'
        }]
      }],
      drilldown: {
        activeAxisLabelStyle: {
          textDecoration: 'none'
        },
        activeDataLabelStyle: {
          textDecoration: 'none'
        },
        chart: {
          events: {
            drillup: function() {
              this.update({
                xAxis: {
                  visible: false,
                  min: 0.18
                },
                yAxis: {
                  visible: false
                },
                legend: {
                  align: 'right',
                  floating: true,
                  itemMarginTop: 5,
                  itemMarginBottom: 5,
                  layout: 'vertical',
                  margin: 10,
                  padding: 10,
                  verticalAlign: 'middle'
                },
              });
            }
          }
        },

        series: [{
          id: 'qualityAndHR',
          type: 'packedbubble', // Switch to Packed Bubble Chart
          minSize: '20%',
          maxSize: '80%',
          zMin: 0,
          zMax: 20,
          name: 'ฝ่ายพัฒนาคุณภาพและทรัพยากรบุคคล',
          showInLegend: true,
          data: [{
            name: 'แผนกพัฒนาคุณภาพ',
            value: 20, // The number of people
            color: '#36A2EB' // Specific color for this sub-department
          }, {
            name: 'แผนกทรัพยากรบุคคล',
            value: 5, // The number of people
            color: '#36A2EB' // Specific color for this sub-department
          }]
        }, {
          id: 'admin',
          type: 'packedbubble', // Switch to Packed Bubble Chart
          minSize: '20%',
          maxSize: '80%',
          zMin: 0,
          zMax: 20,
          name: 'ฝ่ายบริหารทั่วไป',
          showInLegend: true,
          data: [{
            name: 'แผนกพัฒนาคุณภาพ',
            value: 20, // The number of people
            color: '#FF6384' // Specific color for this sub-department
          }, {
            name: 'แผนกทรัพยากรบุคคล',
            value: 5, // The number of people
            color: '#FF6384' // Specific color for this sub-department
          }]
        }, {
          id: 'finance',
          type: 'packedbubble', // Switch to Packed Bubble Chart
          minSize: '20%',
          maxSize: '80%',
          zMin: 0,
          zMax: 20,
          name: 'ฝ่ายการเงินและบัญชี',
          showInLegend: true,
          data: [{
            name: 'แผนกพัฒนาคุณภาพ',
            value: 20, // The number of people
            color: '#4BC0C0' // Specific color for this sub-department
          }, {
            name: 'แผนกทรัพยากรบุคคล',
            value: 5, // The number of people
            color: '#4BC0C0' // Specific color for this sub-department
          }]
        }, {
          id: 'nursing',
          type: 'packedbubble', // Switch to Packed Bubble Chart
          minSize: '20%',
          maxSize: '80%',
          zMin: 0,
          zMax: 20,
          name: 'ฝ่ายการพยาบาล',
          showInLegend: true,
          data: [{
            name: 'แผนกพัฒนาคุณภาพ',
            value: 20, // The number of people
            color: '#FF9F40' // Specific color for this sub-department
          }, {
            name: 'แผนกทรัพยากรบุคคล',
            value: 5, // The number of people
            color: '#FF9F40' // Specific color for this sub-department
          }]
        }, {
          id: 'support',
          type: 'packedbubble', // Switch to Packed Bubble Chart
          minSize: '20%',
          maxSize: '80%',
          zMin: 0,
          zMax: 20,
          name: 'ฝ่ายสนับสนุนทางการแพทย์',
          showInLegend: true,
          data: [{
            name: 'แผนกพัฒนาคุณภาพ',
            value: 20, // The number of people
            color: '#9966FF' // Specific color for this sub-department
          }, {
            name: 'แผนกทรัพยากรบุคคล',
            value: 5, // The number of people
            color: '#9966FF' // Specific color for this sub-department
          }]
        }, {
          id: 'technical',
          type: 'packedbubble', // Switch to Packed Bubble Chart
          minSize: '20%',
          maxSize: '80%',
          zMin: 0,
          zMax: 20,
          name: 'ฝ่ายเทคนิคและบริการ',
          showInLegend: true,
          data: [{
            name: 'แผนกพัฒนาคุณภาพ',
            value: 20, // The number of people
            color: '#607d8b' // Specific color for this sub-department
          }, {
            name: 'แผนกทรัพยากรบุคคล',
            value: 5, // The number of people
            color: '#607d8b' // Specific color for this sub-department
          }]
        }]
      }
    });

    // Sample employee data for drilldown
    var employeeData = {
      '0-0': [{
          name: 'Alice',
          department: 'ฝ่าย 1',
          section: 'แผนก 1',
          startDate: '02/07/2567',
          tenure: '2'
        },
        {
          name: 'Bob',
          department: 'ฝ่าย 2',
          section: 'แผนก 2',
          startDate: '02/07/2567',
          tenure: '3'
        }
      ],
      '0-1': [{
          name: 'David',
          department: 'ฝ่าย 1',
          section: 'แผนก 1',
          startDate: '02/07/2567',
          tenure: '4'
        },
        {
          name: 'Eve',
          department: 'ฝ่าย 2',
          section: 'แผนก 2',
          startDate: '02/07/2567',
          tenure: '5'
        }
      ]
      // Add other entries as needed
    };

    function showModal(data, department, tenure) {
      var employeeTable = $('#employeeTable').DataTable();
      employeeTable.clear().draw();
      // data.forEach(function(name) {
      //   employeeTable.row.add([name]).draw();
      // });
      data.forEach(function(item, index) {
        employeeTable.row.add([
          index + 1,
          item.name,
          item.department,
          item.section,
          item.startDate,
          item.tenure
        ]).draw();
      });
      var modalTitle = 'ตารางแสดงอายุการทำงาน ' + tenure + ' ของ' + department;
      document.getElementById('exampleModalLabel').innerText = modalTitle;


      $('#myModal').modal('show');
    }

    Highcharts.chart('tenureChartContainer', {
      chart: {
        type: 'heatmap',
        marginTop: 40,
        marginBottom: 80,
        plotBorderWidth: 1,
        events: {
          load: function() {
            // ซ่อนตัวโหลดเมื่อกราฟโหลดเสร็จ
            document.getElementById('loader3').classList.add('hidden');

            // โหลดสถานะการแสดงตำนาน
            loadLegendStatus2(this);

            // เพิ่มการฟังเหตุการณ์คลิกที่ตำนานเพื่อตั้งค่าสถานะใหม่
            this.series.forEach(series => {
              Highcharts.addEvent(series, 'legendItemClick', function() {
                saveLegendStatus2(this.chart);
              });
            });
          }
        }
      },
      title: {
        text: ''
      },
      xAxis: {
        categories: ['พัฒนาคุณภาพและทรัพยากรบุคคล', 'บริหารทั่วไป', 'การเงินและบัญชี', 'การพยาบาล', 'สนับสนุนทางการแพทย์', 'เทคนิคและบริการ', 'รวม'],
        labels: {
          style: {
            fontSize: '14px'
          }
        }
      },
      yAxis: {
        categories: ['0-1 ปี', '1-3 ปี', '3-4 ปี', '5+ ปี'],
        title: {
          text: null,
          style: {
            fontSize: '14px'
          }
        },
        labels: {
          style: {
            fontSize: '14px'
          }
        }
      },
      colorAxis: {
        min: 0,
        minColor: '#FFFFFF',
        maxColor: '#4BC0C0'
      },
      legend: {
        align: 'right',
        layout: 'vertical',
        margin: 0,
        verticalAlign: 'top',
        y: 25,
        symbolHeight: 280
      },
      tooltip: {
        formatter: function() {
          return '<b>' + this.series.xAxis.categories[this.point.x] + '</b><br><b>' +
            this.point.value + ' คน</b><br><b>' + this.series.yAxis.categories[this.point.y] + '</b>';
        },
        style: {
          fontSize: '14px'
        }
      },
      plotOptions: {
        series: {
          cursor: 'pointer',
          point: {
            events: {
              click: function() {
                var drilldownKey = this.x + '-' + this.y;
                if (employeeData[drilldownKey]) {
                  var department = this.series.xAxis.categories[this.x];
                  var tenure = this.series.yAxis.categories[this.y];
                  showModal(employeeData[drilldownKey], department, tenure);
                }
              }
            }
          }
        }
      },
      series: [{
        name: 'อายุการทำงาน',
        borderWidth: 1,
        data: [
          [0, 0, 10],
          [0, 1, 19],
          [0, 2, 8],
          [0, 3, 24],
          [1, 0, 92],
          [1, 1, 58],
          [1, 2, 78],
          [1, 3, 117],
          [2, 0, 35],
          [2, 1, 15],
          [2, 2, 123],
          [2, 3, 64],
          [3, 0, 72],
          [3, 1, 132],
          [3, 2, 114],
          [3, 3, 19],
          [4, 0, 68],
          [4, 1, 83],
          [4, 2, 47],
          [4, 3, 58],
          [5, 0, 20],
          [5, 1, 25],
          [5, 2, 10],
          [5, 3, 50],
          [6, 0, 20],
          [6, 1, 25],
          [6, 2, 10],
          [6, 3, 50]
        ], // Sample data, replace with your actual data        
        dataLabels: {
          enabled: true,
          color: '#000000',
          style: {
            fontSize: '14px'
          },
          formatter: function() {
            return this.point.value + ' คน';
          }
        }
      }],
      drilldown: {
        series: []
      }
    });

  }, 500); // หน่วงเวลา 1000 มิลลิวินาที (1 วินาที)





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
      data: [{
          name: 'ปฏิบัติงาน',
          y: 90.28,
          color: '#4CAF50'
        }, // Green color
        {
          name: 'ลางาน',
          y: 7.72,
          color: '#00BCD4'
        }, // Yellow color
        {
          name: 'เข้างานสาย',
          y: 2.00,
          color: '#FFC107'
        } // Red color
      ]
    }]
  });
</script>

<script>
  const doctorData = {
    'fulltime_department1': ['แพทย์ 1', 'แพทย์ 2', 'แพทย์ 3'],
    'parttime_department1': ['แพทย์ 4', 'แพทย์ 5'],
    'nurse_department1': ['พยาบาล 1', 'พยาบาล 2'],
    // ข้อมูลรายชื่อแพทย์อื่น ๆ
  };
  setTimeout(function() {
    Highcharts.chart('doctorTreeMap', {
      chart: {
        style: {
          fontSize: '16px'
        }
      },
      series: [{
        type: 'treemap',
        layoutAlgorithm: 'squarified',
        dataLabels: {
          enabled: true,
          style: {
            fontSize: '16px'
          }
        },
        levels: [{
          level: 1,
          dataLabels: {
            enabled: true,
            align: 'left',
            verticalAlign: 'top',
            style: {
              fontSize: '16px'
            }
          },
          borderWidth: 3
        }, {
          level: 2,
          dataLabels: {
            enabled: true,
            align: 'center',
            verticalAlign: 'middle',
            style: {
              color: '#0022ff',
              fontSize: '14px',
              cursor: 'pointer'
            }
          }
        }],
        data: [{
          id: 'department1',
          name: 'แผนกที่ 1 : 50 คน',
          value: 50, // จำนวนแพทย์ทั้งหมดในแผนกที่ 1
          color: '#7cb5ec'
        }, {
          id: 'fulltime_department1',
          name: 'FT : 20 คน',
          parent: 'department1',
          value: 20,
          color: '#7cb5ec',
          events: {
            click: function() {
              const doctors = doctorData['fulltime_department1'] || [];
              $('#doctorList').html(doctors.map(name => `<p>${name}</p>`).join(''));
              $('#doctorModalLabel').text('รายชื่อแพทย์ (เต็มเวลา)');
              $('#doctorModal').modal('show');
            }
          }
        }, {
          id: 'parttime_department1',
          name: 'PT : 10 คน',
          parent: 'department1',
          value: 10,
          color: '#7cb5ec',
          events: {
            click: function() {
              const doctors = doctorData['parttime_department1'] || [];
              $('#doctorList').html(doctors.map(name => `<p>${name}</p>`).join(''));
              $('#doctorModalLabel').text('รายชื่อแพทย์ (บางเวลา)');
              $('#doctorModal').modal('show');
            }
          }
        }, {
          id: 'nurse_department1',
          name: 'พยบ. : 20 คน',
          parent: 'department1',
          value: 20,
          color: '#7cb5ec',
          events: {
            click: function() {
              const staff = staffData['nurse_department1'] || [];
              $('#staffList').html(staff.map(name => `<p>${name}</p>`).join(''));
              $('#staffModalLabel').text('รายชื่อพยาบาล');
              $('#staffModal').modal('show');
            }
          }
        }, {
          id: 'department2',
          name: 'แผนกที่ 2',
          value: 20, // จำนวนแพทย์ทั้งหมดในแผนกที่ 2
          color: '#434348'
        }, {
          id: 'fulltime_department2',
          name: 'FT : 15 คน',
          parent: 'department2',
          value: 15,
          color: '#434348'
        }, {
          id: 'parttime_department2',
          name: 'PT : 5 คน',
          parent: 'department2',
          value: 5,
          color: '#434348'
        }, {
          id: 'department3',
          name: 'แผนกที่ 3',
          value: 25, // จำนวนแพทย์ทั้งหมดในแผนกที่ 3
          color: '#90ed7d'
        }, {
          id: 'fulltime_department3',
          name: 'FT : 18 คน',
          parent: 'department3',
          value: 18,
          color: '#90ed7d'
        }, {
          id: 'parttime_department3',
          name: 'PT : 7 คน',
          parent: 'department3',
          value: 7,
          color: '#90ed7d'
        }, {
          id: 'department4',
          name: 'แผนกที่ 4',
          value: 15, // จำนวนแพทย์ทั้งหมดในแผนกที่ 4
          color: '#f7a35c'
        }, {
          id: 'fulltime_department4',
          name: 'FT : 10 คน',
          parent: 'department4',
          value: 10,
          color: '#f7a35c'
        }, {
          id: 'parttime_department4',
          name: 'PT : 5 คน',
          parent: 'department4',
          value: 5,
          color: '#f7a35c'
        }, {
          id: 'department5',
          name: 'แผนกที่ 5',
          value: 18, // จำนวนแพทย์ทั้งหมดในแผนกที่ 5
          color: '#8085e9'
        }, {
          id: 'fulltime_department5',
          name: 'FT : 12 คน',
          parent: 'department5',
          value: 12,
          color: '#8085e9'
        }, {
          id: 'parttime_department5',
          name: 'PT : 6 คน',
          parent: 'department5',
          value: 6,
          color: '#8085e9'
        }, {
          id: 'department6',
          name: 'แผนกที่ 6',
          value: 22, // จำนวนแพทย์ทั้งหมดในแผนกที่ 6
          color: '#f15c80'
        }, {
          id: 'fulltime_department6',
          name: 'FT : 15 คน',
          parent: 'department6',
          value: 15,
          color: '#f15c80'
        }, {
          id: 'parttime_department6',
          name: 'PT : 7 คน',
          parent: 'department6',
          value: 7,
          color: '#f15c80'
        }]
      }],
      title: {
        text: 'แพทย์เต็มเวลา = "FT" (Full-time) และ แพทย์บางเวลา = "PT" (Part-time)',
        style: {
          fontSize: '16px'
        }
      }
    });
  }, 500); // หน่วงเวลา 1000 มิลลิวินาที (1 วินาที)
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const data = [{
        name: 'บริหาร',
        data: [5, 2, 3, 0, 3] // ตัวอย่างข้อมูลแต่ละวุฒิการศึกษา
      },
      {
        name: 'แพทย์เต็มเวลา / แพทย์บางเวลา',
        data: [3, 2, 4, 0, 0]
      },
      {
        name: 'พยาบาล',
        data: [4, 3, 4, 0, 4]
      },
      {
        name: 'สนับสนุนทางการแพทย์',
        data: [7, 2, 2, 0, 4]
      },
      {
        name: 'เทคนิคและบริการ',
        data: [2, 1, 5, 0, 3]
      }
    ];

    const categories = ['ต่ำกว่าปริญญาตรี', 'ปริญญาตรี', 'ปริญญาโท', 'ปริญญาเอก', 'เฉพาะทาง'];

    // ตรวจสอบและกรองข้อมูลที่เป็น 0 ทั้งหมด
    const filteredCategories = categories.filter((category, index) => {
      return data.some(series => series.data[index] !== 0);
    });

    const filteredData = data.map(series => {
      return {
        ...series,
        data: series.data.filter((value, index) => filteredCategories.includes(categories[index]))
      };
    });

    setTimeout(function() {
      Highcharts.chart('educationChart', {
        chart: {
          type: 'column'
        },
        title: {
          text: '',
          style: {
            fontSize: '16px'
          }
        },
        colors: ['#FF6384', '#36A2EB', '#4BC0C0', '#9966FF', '#607d8b'], // สีสดใส
        xAxis: {
          categories: categories,
          labels: {
            style: {
              fontSize: '14px'
            }
          }
        },
        yAxis: {
          min: 0,
          title: {
            text: 'จำนวนบุคลากร',
            style: {
              fontSize: '14px'
            }
          },
          labels: {
            style: {
              fontSize: '14px'
            }
          },
          stackLabels: {
            enabled: true,
            style: {
              fontSize: '14px',
              color: (Highcharts.defaultOptions.title.style && Highcharts.defaultOptions.title.style.color) || 'gray'
            }
          }
        },
        legend: {
          itemStyle: {
            fontSize: '14px'
          }
        },
        tooltip: {
          headerFormat: '<b>{point.x}</b><br/>',
          pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}',
          style: {
            fontSize: '16px'
          }
        },
        plotOptions: {
          column: {
            stacking: 'normal',
            dataLabels: {
              enabled: true,
              style: {
                fontSize: '14px'
              }
            }
          }
        },
        series: filteredData
      });
    });
  }, 500); // หน่วงเวลา 1000 มิลลิวินาที (1 วินาที)
</script>



<script>
  document.getElementById('month-select').addEventListener('change', function() {
    updateChart(this.value);
    updateCards(this.value);
  });

  function updateChart(month) {
    setTimeout(function() {
      Highcharts.chart('donut-chart', {
        chart: {
          type: 'pie',
          events: {
            load: function() {
              // ซ่อนตัวโหลดเมื่อกราฟโหลดเสร็จ
              document.getElementById('loader4').classList.add('hidden');
            }
          }
        },
        title: {
          text: '',
        },
        tooltip: {
          style: {
            fontSize: '18px'
          },
          pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y} คน ({point.percentage:.1f}%)</b>'
        },
        colors: ['#FF9F40', '#4CAF50', '#607d8b'], // สีสดใส
        plotOptions: {
          pie: {
            innerSize: '50%',
            dataLabels: {
              enabled: true,
              formatter: function() {
                return '<span>' + this.point.name + ':<br>' + this.point.y + ' คน (' + this.point.percentage.toFixed(1) + '%)</span>';
              },
              style: {
                fontSize: '14px',
                color: '#000000'
              }
            },
            showInLegend: true
          }
        },
        series: [{
          name: 'พยาบาล',
          colorByPoint: true,
          data: [{
            name: 'น้อยกว่า 220 ชั่วโมง',
            y: 30 // เปลี่ยนเป็นจำนวนพยาบาลที่ทำงานน้อยกว่า 220 ชั่วโมงจริง
          }, {
            name: 'มากกว่า 220 ชั่วโมง',
            y: 70 // เปลี่ยนเป็นจำนวนพยาบาลที่ทำงานมากกว่า 220 ชั่วโมงจริง
          }, {
            name: 'ยังไม่ได้จัดลงตารางเวร',
            y: 20 // เปลี่ยนเป็นจำนวนพยาบาลที่ยังไม่ได้จัดลงตารางเวรจริง
          }]
        }],
        legend: {
          enabled: true,
          itemStyle: {
            fontSize: '14px'
          },
          labelFormatter: function() {
            return '<span style="font-size:14px">' + this.name + '</span>';
          }
        }
      });
    }, 500); // หน่วงเวลา 1000 มิลลิวินาที (1 วินาที)
  }

  function updateCards(month) {
    // ตัวอย่างข้อมูล สามารถเปลี่ยนให้เป็นข้อมูลที่เหมาะสมจากฐานข้อมูลหรือ API
    const data = {
      "พฤษภาคม": {
        total: 120,
        unscheduled: 20,
        moreThan220: 70,
        lessThan220: 30
      },
      "มิถุนายน": {
        total: 130,
        unscheduled: 22,
        moreThan220: 72,
        lessThan220: 36
      },
      "กรกฎาคม": {
        total: 125,
        unscheduled: 18,
        moreThan220: 68,
        lessThan220: 39
      },
      // เพิ่มข้อมูลสำหรับเดือนอื่นๆ ที่เหลือ
    };

    const monthData = data[month];
    if (monthData) {
      document.getElementById('total-nurses').innerText = `${monthData.total} คน`;
      document.getElementById('unscheduled-nurses').innerText = `${monthData.unscheduled} คน`;
      document.getElementById('more-than-220').innerText = `${monthData.moreThan220} คน`;
      document.getElementById('less-than-220').innerText = `${monthData.lessThan220} คน`;
    }
  }

  // Set the current month in the dropdown and initialize the chart and cards
  document.addEventListener('DOMContentLoaded', function() {
    const monthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    const currentMonth = new Date().getMonth(); // Get the current month (0-11)
    document.getElementById('month-select').value = monthNames[currentMonth];
    updateChart(monthNames[currentMonth]);
    updateCards(monthNames[currentMonth]);
  });

  // Set the current month in the dropdown and initialize the chart and cards
  document.addEventListener('DOMContentLoaded', function() {
    const monthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    const currentMonth = new Date().getMonth(); // Get the current month (0-11)
    document.getElementById('month-select-pay').value = monthNames[currentMonth];
    updateChart(monthNames[currentMonth]);
    updateCards(monthNames[currentMonth]);
  });
</script>

<script>
  // ฟังก์ชันเพื่อหาค่าเดือนปัจจุบัน
  function setCurrentMonth() {
    var monthNames = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    var now = new Date();
    var currentMonth = monthNames[now.getMonth()]; // หาค่าเดือนปัจจุบัน
    document.getElementById('month-select-pay').value = currentMonth; // ตั้งค่า selected ให้กับ dropdown
    updatePackedBubbleChart(currentMonth); // อัปเดตกราฟตามเดือนปัจจุบัน
    updateBarChart(currentMonth, now.getMonth()); // อัปเดตกราฟแท่งตามเดือนปัจจุบัน
  }

  document.getElementById('month-select-pay').addEventListener('change', function() {
    var selectedMonth = this.value;
    var monthNamesFull = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    var monthIndex = monthNamesFull.indexOf(selectedMonth);
    updatePackedBubbleChart(selectedMonth);
    updateBarChart(selectedMonth, monthIndex);
  });

  function updatePackedBubbleChart(month) {
    setTimeout(function() {

      // ตัวอย่างข้อมูลรายจ่ายในแต่ละเดือน
      var data = {
        'กรกฎาคม': {
          salary: [{
            name: 'เงินเดือน',
            value: 9154700
          }, {
            name: 'ค่าเวร',
            value: 465210
          }, {
            name: 'เบี้ยขยัน',
            value: 241032
          }, {
            name: 'ค่าขึ้นเวร',
            value: 150000
          }, {
            name: 'OT',
            value: 80000
          }, {
            name: 'ค่าเบี้ยขยัน',
            value: 30000
          }, {
            name: 'แพทย์FT ',
            value: 7300000
          }, {
            name: 'แพทย์PT ',
            value: 5003000
          }],
          allowances: [{
            name: 'ค่าอาหาร',
            value: 125000
          }, {
            name: 'ค่าประกันอุบัติเหตุ',
            value: 100000
          }, {
            name: 'ค่าเช่าที่พัก',
            value: 210000
          }],
          deductions: [{
            name: 'สาย',
            value: 15000
          }, {
            name: 'ขาดงาน',
            value: 30000
          }],
          totalSalary: 9154700,
          totalAllowances: 724200,
          totalDeductions: 20,
          totalExpenses: 9878900
        },
        'สิงหาคม': {
          salary: [{
            name: 'เงินเดือน',
            value: 8000000
          }, {
            name: 'ค่าเวร',
            value: 400000
          }, {
            name: 'เบี้ยขยัน',
            value: 200000
          }, {
            name: 'ค่าขึ้นเวร',
            value: 130000
          }, {
            name: 'OT',
            value: 70000
          }, {
            name: 'ค่าเบี้ยขยัน',
            value: 25000
          }, {
            name: 'แพทย์FT ',
            value: 6800000
          }, {
            name: 'แพทย์PT ',
            value: 4500000
          }],
          allowances: [{
            name: 'ค่าอาหาร',
            value: 115000
          }, {
            name: 'ค่าประกันอุบัติเหตุ',
            value: 95000
          }, {
            name: 'ค่าเช่าที่พัก',
            value: 200000
          }],
          deductions: [{
            name: 'สาย',
            value: 14000
          }, {
            name: 'ขาดงาน',
            value: 28000
          }],
          totalSalary: 8000000,
          totalAllowances: 645000,
          totalDeductions: 50,
          totalExpenses: 8688000
        },
        // เพิ่มข้อมูลสำหรับเดือนอื่นๆ ตามต้องการ
      };

      var selectedData = data[month] || {
        salary: [],
        allowances: [],
        deductions: [],
        totalSalary: 0,
        totalAllowances: 0,
        totalDeductions: 0,
        totalExpenses: 0
      };
      document.getElementById('pay-c1-amount').textContent = new Intl.NumberFormat().format(selectedData.totalExpenses) + ' บาท';
      document.getElementById('pay-c2-amount').textContent = new Intl.NumberFormat().format(selectedData.totalSalary) + ' บาท';
      document.getElementById('pay-c3-amount').textContent = new Intl.NumberFormat().format(selectedData.totalAllowances) + ' บาท';
      document.getElementById('pay-c4-amount').textContent = new Intl.NumberFormat().format(selectedData.totalDeductions) + ' ใบ';
      document.querySelector('[data-title-id="pay-2-title"]').textContent = `[PAY-2] กราฟแสดงรายจ่าย จำแนกตามประเภทของรายจ่าย ประจำเดือน${month}`;

      Highcharts.chart('SplitPacked', {
        chart: {
          type: 'packedbubble'
        },
        title: {
          text: '',
          style: {
            fontSize: '16px'
          }
        },
        tooltip: {
          useHTML: true,
          formatter: function() {
            return '<b>' + this.point.name + ':</b> ' + Highcharts.numberFormat(this.point.value, 0, '.', ',') + ' บาท';
          },
          style: {
            fontSize: '16px'
          }
        },
        plotOptions: {
          packedbubble: {
            minSize: '50%',
            maxSize: '80%',
            zMin: 100000,
            zMax: 500000,
            layoutAlgorithm: {
              splitSeries: true,
              gravitationalConstant: 0.02
            },
            dataLabels: {
              enabled: true,
              format: '{point.name}',
              style: {
                fontSize: '16px',
                color: 'black',
                textOutline: 'none',
                fontWeight: 'normal'
              }
            }
          }
        },
        series: [{
          name: 'เงินเดือน',
          color: '#00BCD4',
          data: selectedData.salary
        }, {
          name: 'ค่าสวัสดิการต่างๆ',
          color: '#7634ff',
          data: selectedData.allowances
        }, {
          name: 'รายการหักเงิน',
          color: '#ff877e',
          data: selectedData.deductions
        }]
      });
    }, 500); // หน่วงเวลา 1000 มิลลิวินาที (1 วินาที)

  }
  // เรียกฟังก์ชันนี้เมื่อโหลดหน้าเว็บครั้งแรก
  setCurrentMonth();
  // เรียกฟังก์ชันนี้เมื่อโหลดหน้าเว็บครั้งแรก
  updatePackedBubbleChart(document.getElementById('month-select-pay').value);

  function updateBarChart(month, currentMonthIndex) {
    setTimeout(function() {
      var data = {
        salary: [9154700, 8000000, 7500000, 9200000, 8900000, 9400000, 9700000, 9154700, 8000000, 7500000, 9200000, 8900000],
        allowances: [724200, 680000, 600000, 750000, 720000, 770000, 800000, 724200, 680000, 600000, 750000, 720000],
        deductions: [45000, 40000, 35000, 50000, 48000, 52000, 55000, 45000, 40000, 35000, 50000, 48000]
      };

      var monthNamesShort = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

      Highcharts.chart('barChartContainer', {
        chart: {
          zoomType: 'xy'
        },
        title: {
          text: '',
          style: {
            fontSize: '16px'
          }
        },
        xAxis: [{
          categories: monthNamesShort.slice(0, currentMonthIndex + 1),
          crosshair: true,
          labels: {
            style: {
              fontSize: '14px'
            }
          }
        }],
        yAxis: [{ // Primary yAxis
          labels: {
            enabled: false
          },
          title: {
            text: null
          },
          max: 10001000 // ตั้งค่า max เป็น 10 ล้าน
        }, { // Secondary yAxis
          labels: {
            enabled: false
          },
          title: {
            text: null
          },
          opposite: true,
          max: 1000000 // ตั้งค่า max สำหรับรายการหักเงินให้สูงขึ้น
        }, { // Secondary yAxis
          labels: {
            enabled: false
          },
          title: {
            text: null
          },
          opposite: true,
          max: 5000000 // ตั้งค่า max สำหรับรายการหักเงินให้สูงขึ้น
        }],
        tooltip: {
          shared: true,
          style: {
            fontSize: '16px'
          },
          formatter: function() {
            return '<b>' + this.x + '</b><br/>' +
              this.points.map(point => `<span style="color:${point.series.color}">${point.series.name}</span>: <b>${Highcharts.numberFormat(point.y, 2, '.', ',')}</b> บาท<br/>`).join('');
          }
        },
        plotOptions: {
          column: {
            dataLabels: {
              enabled: true,
              formatter: function() {
                let y = this.y;
                if (y >= 1000000) {
                  return (y / 1000000).toFixed(2) + 'M';
                } else if (y >= 1000) {
                  return (y / 1000).toFixed(2) + 'k';
                }
                return y;
              },
              style: {
                color: '#000',
                fontSize: '14px'
              }
            }
          }
        },
        series: [{
          name: 'เงินเดือน',
          type: 'column',
          yAxis: 0,
          data: data.salary.slice(0, currentMonthIndex + 1),
          color: '#00BCD4',
          tooltip: {
            valueSuffix: ' บาท'
          }
        }, {
          name: 'ค่าสวัสดิการต่างๆ',
          type: 'column',
          yAxis: 2,
          data: data.allowances.slice(0, currentMonthIndex + 1),
          color: '#7634ff',
          tooltip: {
            valueSuffix: ' บาท'
          }
        }, {
          name: 'รายการหักเงิน',
          type: 'column',
          yAxis: 1,
          data: data.deductions.slice(0, currentMonthIndex + 1),
          color: '#ff877e',
          tooltip: {
            valueSuffix: ' บาท'
          }
        }, {
          name: 'สรุปยอดรายจ่าย',
          type: 'spline',
          yAxis: 0,
          data: data.salary.slice(0, currentMonthIndex + 1).map(function(value, index) {
            return (value + data.allowances[index] - data.deductions[index]); // ตัวอย่างการคำนวณเส้นแนวโน้ม
          }),
          color: '#4caf50', // กำหนดสีของเส้นแนวโน้มเป็นสีเขียว
          tooltip: {
            valueSuffix: ' บาท'
          }
        }]
      });
    }, 500); // หน่วงเวลา 500 มิลลิวินาที (0.5 วินาที)
  }
</script>