<style>
  .card-dashed .card-body .card-icon {
    font-size: 32px;
    line-height: 0;
    width: 70px;
    /* height: 70px; */
    flex-shrink: 0;
    flex-grow: 0;
  }

  #dashboard-dashboard .card-body .card-icon {
    font-size: 32px;
    line-height: 0;
    width: 70px;
    height: 70px;
    flex-shrink: 0;
    flex-grow: 0;
  }

  .nav-pills .nav-link {
    /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
    border: 1px dashed #607D8B;
    color: #012970;
    margin: 8px;
  }

  .card-solid.border-primary-subtle {
    border: 1px solid #ddd !important;
    box-shadow: 0px 0 3px 0px rgba(1, 41, 112, 0.1);
  }

  .system-cut-name {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .small {
    font-size: 14px;
  }

  .partial-name2,
  .partial-name3 {
    width: 90%;
    text-align: left;
    line-height: 0.1em;
    margin: 10px 0 20px;
    position: relative;
  }

  .partial-name2 span,
  .partial-name3 span {
    background: #fff;
    padding: 0 10px;
  }

  .partial-name2::after,
  .partial-name3::after {
    content: '';
    position: absolute;
    bottom: 35px;
    height: 3px;
    background-color: var(--bs-primary);
  }

  .partial-name2::after {
    width: 20%;
  }

  .partial-name3::after {
    width: 20%;
  }
</style>

<?php
setlocale(LC_TIME, 'th_TH.utf8');
// Array of Thai month names
$thaiMonths = array(
  'มกราคม',
  'กุมภาพันธ์',
  'มีนาคม',
  'เมษายน',
  'พฤษภาคม',
  'มิถุนายน',
  'กรกฎาคม',
  'สิงหาคม',
  'กันยายน',
  'ตุลาคม',
  'พฤศจิกายน',
  'ธันวาคม'
);
?>
<?php if(true){ ?>
  <h4 class="partial-name2 pb-0">
    <span>[PD-WK] สถิติการมาทำงาน <span>ประจำเดือน</span>
      <select class="form-select form-control ms-2 w-15" style="display: inline;" data-placeholder="-- กรุณาเลือกเดือน --" name="DashboardMonthSearch1" id="DashboardMonthSearch1">
        <?php
        $i = 0;
        foreach ($thaiMonths as $row) {
          // Get current date
          if ((date('n') - 1) == $i)
            echo '<option value="' . ($i + 1) . '" selected>' . $row . '</option>';
          else
            echo '<option value="' . ($i + 1) . '">' . $row . '</option>';
          $i++;
        }
        ?>
      </select>
      <select class="form-select form-control ms-2 w-15" style="display: inline;" data-placeholder="-- กรุณาเลือกปี --" name="DashboardYearSearch1" id="DashboardYearSearch1">
        <option value="2567">2567</option>
      </select>
    </span>
  </h4>
  <span class="p-3">(ข้อมูล ณ วันที่ <?= abbreDate(date('d-m-Y')) ?>) <span class="text-danger font-24">ข้อมูลสำหรับการทดสอบเท่านั้น ไม่ใช่ข้อมูลจริง</span></span>
  <div class="row p-3">
    <div class="col-md-6">
      <div class="card card-solid border-primary-subtle">
        <div class="card-body">
          <div class="filter float-end">
            <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" data-bs-target="#dashboard-work-detail-modal"></a>
          </div>
          <div class="text-start pb-2">[PD-WK-1] การมาทำงาน</div>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info text-white">
              <i class="bi-briefcase"></i>
            </div>
            <div class="ps-4 row">
              <div class="col-md-9 font-18 text-start">มาทำงานจริง</div>
              <div class="col-md-3 font-18 text-end">6 วัน</div>
              <div class="col-md-9 font-18 text-start">
                <?php
                if (isset($actor_id) && $actor_id == 1) echo "ตารางเวรพยาบาล"; // พยาบาล
                else echo "ตารางแพทย์ออกตรวจ"; // แพทย์
                ?>
              </div>
              <div class="col-md-3 font-18 text-end">16 วัน</div>
              <div class="col-md-9 font-18 text-start">ร้อยละ</div>
              <div class="col-md-3 font-18 text-end">37.50</div>
              <!-- <h5><span class="float-start">การมาทำงาน</span><span class="float-end">6 วัน</span></h5>
                        <h5><span class="float-start">ตารางแพทย์ออกตรวจ</span><span class="float-end">8 วัน</span></h5>
                        <h5><span class="float-start">ร้อยละ</span><span class="float-end">75.00</span></h5> -->
              <!-- <h5>6 วัน / ตารางแพทย์ 6 วัน ร้อยละ 100.00 <br><span class="text-dark small"><i>(48 ชั่วโมง)</i></span></h5> -->
              <!-- <h4>79.74% </h4> -->
              <!-- <div class="text-dark small"> (จำนวนชั่วโมงที่มาทำงาน / จำนวนชั่วโมงทั้งหมด) * 100</div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-solid border-primary-subtle">
        <div class="card-body">
          <div class="filter float-end">
            <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" data-bs-target="#dashboard-learn-detail-modal"></a>
          </div>
          <div class="text-start pb-2">[PD-WK-2] การทำงานล่วงเวลา</div>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
              <i class="bi-clock-history"></i>
            </div>
            <div class="ps-4 row">
              <div class="col-md-9 font-18 text-start">จำนวนวัน</div>
              <div class="col-md-3 font-18 text-end">2 วัน</div>
              <div class="col-md-6 font-18 text-start">ระยะเวลา</div>
              <div class="col-md-6 font-18 text-end">4 ชั่วโมง 30 นาที</div>
              <div class="col-md-6 font-18 text-end"></div>
              <div class="col-md-6 font-18 text-end"></div>
              <!-- <div class="col-md-9 font-18 text-start">ร้อยละ</div>
                        <div class="col-md-3 font-18 text-end">37.50</div> -->


              <!-- <h4>10.00% <span class="text-dark small"><i>(16:00 ชั่วโมง)</i></span></h4> -->
              <!-- <h4>2 วัน <span class="text-dark small"><i>(04:30 ชั่วโมง)</i></span></h4> -->
              <!-- <h4>4 ครั้ง</h4>
                        <h4>20 นาที</h4> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-solid border-primary-subtle">
        <div class="card-body">
          <div class="filter float-end">
            <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" data-bs-target="#dashboard-leave-detail-modal"></a>
          </div>
          <div class="text-start pb-2">[PD-WK-3] การลา</div>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
              <i class="bi-clipboard-plus"></i>
            </div>
            <div class="ps-4 row">
              <div class="col-md-9 font-18 text-start">จำนวนวันลา</div>
              <div class="col-md-3 font-18 text-end">4 วัน</div>
              <div class="col-md-9 font-18 text-start">จำนวนครั้ง</div>
              <div class="col-md-3 font-18 text-end">3 ครั้ง</div>

              <!-- <div class="col-md-9 font-18 text-start">ร้อยละ</div>
                        <div class="col-md-3 font-18 text-end">37.50</div> -->
              <!-- <h4>20.00% <span class="text-dark small"><i>(32:00 ชั่วโมง / 160:00 ชั่วโมง)</i></span></h4>
                        <div class="text-dark small"> (จำนวนชั่วโมงที่ลา / จำนวนชั่วโมงทั้งหมด) * 100</div> -->
              <!-- <h4>4 ครั้ง</h4>
                        <h4>5 วัน</h4> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-solid border-primary-subtle">
        <div class="card-body">
          <div class="filter float-end">
            <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" data-bs-target="#dashboard-late-detail-modal"></a>
          </div>
          <div class="text-start pb-2">[PD-WK-4] การมาสาย</div>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
              <i class="bi-alarm"></i>
            </div>
            <div class="ps-4 row">
              <div class="col-md-9 font-18 text-start">จำนวนวันมาสาย</div>
              <div class="col-md-3 font-18 text-end">4 วัน</div>
              <div class="col-md-6 font-18 text-start">ระยะเวลา</div>
              <div class="col-md-6 font-18 text-end">20 นาที</div>

              <!-- <h4>0.26% <span class="text-dark small"><i>(00:20 ชั่วโมง / 128:00 ชั่วโมง)</i></span></h4>
                        <div class="text-dark small"> (จำนวนชั่วโมงที่มาสาย / จำนวนชั่วโมงที่ต้องมาทำงาน) * 100</div> -->
              <!-- <h4>4 ครั้ง</h4>
                        <h4>20 นาที</h4> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row p-3">
    <div class="col-md-6">
      <div class="card card-solid border-primary-subtle">
        <div class="card-body">
          <div class="filter float-end">
            <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" data-bs-target="#dashboard-chart1-detail-modal"></a>
          </div>
          <div class="text-start">[PD-WK-5] กราฟแสดงร้อยละการมาทำงาน การลา และมาสาย</div>
          <div class="text-center" id="chart-1" style="height:350px;"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-solid border-primary-subtle">
        <div class="card-body">
          <div class="filter float-end">
            <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" data-bs-target="#dashboard-chart2-detail-modal"></a>
          </div>
          <div class="text-start">[PD-WK-6] กราฟแสดงจำนวนวันที่เข้าเวร จำแนกตามวันของสัปดาห์ตารางเวร</div>
          <div class="text-center" id="chart-2" style="height:350px;">></div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>


  <?php
  if (!isset($rol) || $rol == 1) { // แพทย์ 
  ?>
    <h4 class="partial-name3"><span>[PD-AP] สถิติการนัดหมายผู้ป่วย ประจำเดือน
        <select class="form-select form-control ms-2 w-15" style="display: inline;" data-placeholder="-- กรุณาเลือกเดือน --" name="que_search_db_month" id="que_search_db_month" onchange="get_que_dashboard('filter')">
          <?php
          $i = 0;
          foreach ($thaiMonths as $row) {
            // Get current date
            if ((date('n') - 1) == $i)
              echo '<option value="' . ($i + 1) . '" selected>' . $row . '</option>';
            else
              echo '<option value="' . ($i + 1) . '">' . $row . '</option>';
            $i++;
          }
          ?>
        </select>
        <select class="form-select form-control ms-2 w-15" style="display: inline;" data-placeholder="-- กรุณาเลือกปี --" name="que_search_db_year" id="que_search_db_year" onchange="get_que_dashboard('filter')">
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
      </span></h4>
      <span class="text-danger font-24">ข้อมูลสำหรับการทดสอบเท่านั้น ไม่ใช่ข้อมูลจริง</span>
    <div class="row p-3">
      <div class="col-md-4">
        <div class="card card-solid border-primary-subtle">
          <div class="card-body">
            <div class="filter float-end">
              <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" onclick="get_que_dashboard('detail', 'dashboard-appointment-detail-modal', 'appointment', '')"></a>
            </div>
            <div class="text-start">[PD-AP-1] จำนวนการนัดหมาย</div>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
                <i class="bi-people-fill"></i>
              </div>
              <div class="ps-4" id="que_all_count">

              </div>
            </div>
          </div>
        </div>
        <div class="card card-solid border-primary-subtle">
          <div class="card-body">
            <div class="filter float-end">
              <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" onclick="get_que_dashboard('detail', 'dashboard-appointment-detail-modal', 'appointment', 'old')"></a>
            </div>
            <div class="text-start">[PD-AP-2] จำนวนผู้ป่วยเก่า</div>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                <i class="bi-person-lines-fill"></i>
              </div>
              <div class="ps-4 row">
                <div class="col-md-7 font-18 text-start">จำนวนครั้ง</div>
                <div class="col-md-5 font-18 text-end" id="que_old_count"></div>
                <div class="col-md-7 font-18 text-start">ร้อยละ</div>
                <div class="col-md-5 font-18 text-end" id="que_old_percent"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="card card-solid border-primary-subtle">
          <div class="card-body">
            <div class="filter float-end">
              <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" onclick="get_que_dashboard('detail', 'dashboard-appointment-detail-modal', 'appointment', 'new')"></a>
            </div>
            <div class="text-start">[PD-AP-3] จำนวนผู้ป่วยใหม่</div>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
                <i class="bi-person-plus-fill"></i>
              </div>
              <div class="ps-4 row">
                <div class="col-md-7 font-18 text-start">จำนวนครั้ง</div>
                <div class="col-md-5 font-18 text-end" id="que_new_count"></div>
                <div class="col-md-7 font-18 text-start">ร้อยละ</div>
                <div class="col-md-5 font-18 text-end" id="que_new_percent"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card card-solid border-primary-subtle">
          <div class="card-body">
            <div class="filter float-end">
              <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" onclick="get_que_dashboard('detail', 'dashboard-chart3-detail-modal', 'chart3', '')"></a>
            </div>
            <div class="text-start">[PD-AP-4] กราฟแสดงจำนวนวันที่ผู้ป่วยมีการนัดหมายแพทย์ จำแนกตามวันของสัปดาห์ตารางเวร</div>
            <div class="text-center" id="chart-3"></div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <h4 class="partial-name"><span>[PD-LOG] สถิติการเข้าใช้งานระบบ ใน 7 วันย้อนหลัง</span></h4>
  <div class="row p-3">
    <div class="col-md-8">
      <div class="card card-solid border-primary-subtle">
        <div class="card-body">
          <div class="filter float-end">
            <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" onclick="get_ums_dashboard('detail', 'dashboard-accessing-system2-detail-modal')"></a>
          </div>
          <div class="text-start">[PD-LOG-1] กราฟแสดงจำนวนการเข้าใช้งานระบบ</div>
          <div class="text-center" id="chart-4" style=" height: 800px;"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4" id="ums_log_card" style=" height: 850px; overflow-y: auto;">

    </div>
  </div>

<!-- JS General -->
<script>
  const day_short = ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'];
  const day_long = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
</script>

<!-- JS Chart -->
<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

<script>
  $(document).ready(function() {
    get_que_dashboard('filter');
    get_ums_dashboard('weekly');
  });

  function get_ums_dashboard(isAction, modal_id = "", system_log_id = "", system_name = "") {

    if (isAction == 'detail') {
      var modal = document.getElementById(modal_id);
      if (modal) {
        var modalInstance = new bootstrap.Modal(modal);
        modalInstance.toggle();
      }
    }
    $.ajax({
      url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_weekly_ums_dashboard",
      type: 'POST',
      data: {
        isAction: isAction,
        system_log_id: system_log_id,
        type: 'weekly'
      },
      success: function(data) {
        data = JSON.parse(data);
        // console.log(data);

        if (isAction == 'detail') {

          // detail for dashboard
          if (system_log_id == "" && system_name == "") {
            var type = "ums-log-db";
            var dataTable = $('#table-dashboard-' + type + '-detail-modal').DataTable();
            dataTable.clear().draw();
            $('#title-dashboard-' + type + '-detail-modal').text('รายละเอียดการเข้าใช้งานระบบ');
            $('#select_type_accessing2').val('weekly').change();
            $('#select_accessing').empty();
            $('#summary-dashboard-' + type + '-detail-modal').text(data.log_ums_type_card.length);
            data.log_ums_type_db.forEach((log, index) => {
              const option = document.createElement('option');
              option.value = log.log_system_id;
              option.textContent = `${log.ums_log_name}`;
              if (index === 0) {
                option.selected = true;
              }
              $('#select_accessing').append(option);
            });

          } else { //detail for card
            var type = "ums-log-card";
            var dataTable = $('#table-dashboard-' + type + '-detail-modal').DataTable();
            dataTable.clear().draw();
            $('#summary-dashboard-' + type + '-detail-modal').text("" + data.log_ums_type_card.length + "");
            // $('#summary2-dashboard-'+type+'-detail-modal').text("จำนวนการเข้าใช้งานเมนู " + data.log_ums_type_card_count.count_log + " รายการ");
            $('#title-dashboard-' + type + '-detail-modal').text('รายละเอียดการเข้าใช้งาน ' + system_name);
            $('#system-id-log-dashboard-' + type + '-detail-modal').val(system_log_id);
            $('#select_type_accessing').val('weekly').change();
          }

          data.log_ums_type_card.forEach(function(row, index) {
            dataTable.row.add([
              '<div class="text-center">' + (index + 1) + '</div>',
              '<div class="text-start">' + row.log_detail + '</div>',
              '<div class="text-center">' + row.log_date + '</div>',
              '<div class="text-center">' + row.log_ip + '</div>',
              '<div class="text-center">' + row.log_agent + '</div>'
            ]).draw();
          });

        } else {
          get_weekly_log_ums_card(data.weekly_log_ums_card);
          get_weekly_log_ums_dashboard(data.weekly_log_ums_dashboard);
        }
        $('[data-toggle="tooltip"]').tooltip();
      },
      error: function(xhr, status, error) {
        dialog_error({
          'header': text_toast_default_error_header,
          'body': text_toast_default_error_body
        });
      }
    });
  }

  function get_weekly_log_ums_dashboard(data) {

    // Initialize arrays to hold categories and series data
    var categories = []; // For xAxis categories
    var seriesData = {}; // For series based on log names

    // Format the data
    data.forEach(function(item) {
      var logDate = item.log_date;
      var logName = item.ums_log_name;
      var logCount = parseInt(item.ums_log_count);

      // Add unique dates to categories array
      if (!categories.includes(logDate)) {
        categories.push(logDate);
      }

      // Initialize seriesData for each logName if not already initialized
      if (!seriesData[logName]) {
        seriesData[logName] = [];
      }

      // Fill in the data for each date
      var index = categories.indexOf(logDate);
      if (index !== -1) {
        // Ensure the seriesData has an entry for each category (logDate)
        while (seriesData[logName].length < categories.length) {
          seriesData[logName].push(0); // Fill with zeros for missing days
        }
        seriesData[logName][index] = logCount; // Update the count for the specific date
      }
    });

    // Filter out series with all zero values
    var series = Object.keys(seriesData)
      .filter(function(key) {
        return seriesData[key].some(function(value) {
          return value !== 0; // Filter out series with all zeros
        });
      })
      .map(function(key) {
        var isEnabled = true; // Adjust this condition as per your logic

        // Example condition: Disable series based on log name
        if (key === "Login") {
          isEnabled = false;
        }

        return {
          name: key,
          data: seriesData[key],
          visible: isEnabled // Set enabled flag based on condition
        };
      });

    // Create Highcharts chart
    Highcharts.chart('chart-4', {
      chart: {
        type: 'spline',
        style: {
          fontSize: '16px',
          fontFamily: 'Sarabun'
        },
        height: 800,
        events: {
          load: function() {
            var chart = this;
            // ใส่เหตุการณ์ resize เพื่อให้กราฟปรับตัวอัตโนมัติเมื่อมีการ resize หน้าจอ
            window.addEventListener('resize', function() {
              chart.reflow();
            });
          }
        }
      },
      title: {
        text: ''
      },
      legend: {
        layout: 'horizontal', // จัดเรียง Legend ในแนวนอน
        align: 'center', // จัดให้ Legend อยู่ตรงกลาง
        verticalAlign: 'bottom', // จัดให้ Legend อยู่ที่ด้านล่าง
        symbolWidth: 1, // กำหนดความกว้างของสัญลักษณ์ใน Legend
        itemStyle: {
          fontSize: '16px', // กำหนดขนาดตัวอักษรใน Legend
          fontFamily: 'Sarabun', // กำหนดแบบอักษรใน Legend
          fontWeight: 'normal' // กำหนดความหนาของตัวอักษรใน Legend
        },
        itemMarginBottom: 10
      },
      credits: {
        enabled: false
      },
      exporting: {
        enabled: true
      },
      subtitle: {
        text: '',
        align: 'left'
      },
      xAxis: {
        categories: categories,
        title: {
          text: '7 วันย้อนหลังที่ผ่านมา',
          style: {
            fontSize: '16px',
            fontFamily: 'Sarabun'
          }
        },
        labels: {
          style: {
            fontSize: '16px',
            fontFamily: 'Sarabun'
          }
        }
      },
      yAxis: {
        title: {
          text: 'จำนวนการเข้าใช้งานระบบ',
          style: {
            fontSize: '16px',
            fontFamily: 'Sarabun'
          }
        }
      },
      tooltip: {
        valueSuffix: ' ครั้ง',
        stickOnContact: true,
        headerFormat: 'วันที่ {point.x}</br>',
        style: {
          fontSize: '16px',
          fontFamily: 'Sarabun'
        }
      },
      plotOptions: {
        series: {
          cursor: 'pointer',
          lineWidth: 2,
          marker: {
            enabled: true,
            symbol: 'circle',
            radius: 4
          }
        }
      },
      series: series
    });
  }

  function get_weekly_log_ums_card(data) {
    const ums_log_card = document.getElementById('ums_log_card');
    var index = 2;
    data.forEach(item => {
      const cardHTML = `
                <div class="card card-solid border-primary-subtle">
                    <div class="card-body">
                        <div class="filter float-end">
                            <a class="bi-search" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" onclick="get_ums_dashboard('detail', 'dashboard-accessing-system-detail-modal', ${item.log_system_id}, '[PD-LOG-${index}] ${item.ums_log_name}')"></a>
                        </div>
                        <div class="text-start system-cut-name">[PD-LOG-${index}] ${item.ums_log_name}</div>
                        <div class="text-center pt-3">
                            <h4>${item.ums_log_count} ครั้ง</h4>
                        </div>
                    </div>
                </div>`;
      ums_log_card.innerHTML += cardHTML;
      index++;
    });
  }

  function get_que_dashboard(isAction, modal_id = "", type = "", que_type = "") {
    var month = $("#que_search_db_month").val();
    var year = $("#que_search_db_year").val();


    if (isAction == 'detail') {
      var modal = document.getElementById(modal_id);
      var modalInstance = new bootstrap.Modal(modal);
      modalInstance.toggle();
    }
    $.ajax({
      url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_monthly_que_dashboard",
      type: 'POST',
      data: {
        month: month,
        year: year,
        isAction: isAction,
        que_type: que_type
      },
      success: function(data) {
        data = JSON.parse(data);
        // console.log(data);

        var que_type_text = "ทั้งหมด";

        if (que_type != "") {
          if (que_type == "old") {
            que_type_text = "เก่า";
          } else {
            que_type_text = "ใหม่";
          }
        }
        year = parseInt(year);
        year += 543;
        if (isAction == 'detail') {
          if (type == "appointment") {
            var dataTable = $('#table-dashboard-' + type + '-detail-modal').DataTable();
            dataTable.clear().draw();
            $('#summary-dashboard-' + type + '-detail-modal').text(data.que_table_list.length);
            $('#title-dashboard-' + type + '-detail-modal').text('รายละเอียดผู้ป่วยนัดพบ' + que_type_text + ' ประจำเดือน' + data.month_text + ' ปี พ.ศ. ' + year);
            $('#topic-dashboard-' + type + '-detail-modal').text('รายการรายละเอียดผู้ป่วย' + que_type_text);

            var button = '<div class="text-center option"><button class="btn btn-info"><i class="bi-search" title="คลิกเพื่อดูรายละเอียดผู้ป่วย" data-toggle="tooltip" data-placement="top"></i></button></div>';
            data.que_table_list.forEach(function(row, index) {
              dataTable.row.add([
                '<div class="text-center">' + (index + 1) + '</div>',
                row.pt_prefix + row.pt_fname + " " + row.pt_lname,
                '<div class="text-start">' + row.apm_cause + '</div>',
                row.apm_date,
                '<div class="text-center">' + row.apm_patient_type + '</div>',
                button
              ]).draw();
            });
          } else {
            render_detail_que_week_modal(data, type, que_type_text, year);
          }
        } else {
          $("#que_all_count").html("<h4>" + data.que_count_all + " ครั้ง<h4>");
          $("#que_old_count").text(data.que_count_old);
          $("#que_old_percent").text(data.old_percentage);

          $("#que_new_count").text(data.que_count_new);
          $("#que_new_percent").text(data.new_percentage);

          chart_que_dashboard(data.que_day_count_new, data.que_day_count_old);
        }
        $('[data-toggle="tooltip"]').tooltip();
      },
      error: function(xhr, status, error) {
        dialog_error({
          'header': text_toast_default_error_header,
          'body': text_toast_default_error_body
        });
      }
    });
  }
  // get_que_dashboard

  function chart_que_dashboard(que_day_count_new, que_day_count_old) {

    const que_data = day_long.reduce((acc, day) => {
      acc[`วัน${day}`] = {
        new_count: 0,
        old_count: 0
      };
      return acc;
    }, {});

    que_day_count_new.forEach(item => {
      que_data[item.day_of_week_thai].new_count = parseInt(item.count);
    });

    que_day_count_old.forEach(item => {
      que_data[item.day_of_week_thai].old_count = parseInt(item.count);
    });

    que_result = Object.keys(que_data).map(day => ({
      day_of_week_thai: day,
      new_count: que_data[day].new_count,
      old_count: que_data[day].old_count
    }));

    // Extract day labels and counts
    const que_day_label = que_result.map(item => item.day_of_week_thai);
    const que_count_new = que_result.map(item => item.new_count);
    const que_count_old = que_result.map(item => item.old_count);

    var chart = Highcharts.chart('chart-3', {
      chart: {
        type: 'column'
      },
      title: {
        text: '',
        align: '',
        style: {
          fontSize: '16px',
          fontFamily: 'Sarabun'
        }
      },
      credits: {
        enabled: false
      },
      exporting: {
        enabled: true
      },
      xAxis: {
        categories: que_day_label,
        title: {
          text: 'วันของสัปดาห์',
          style: {
            fontSize: '16px',
            fontFamily: 'Sarabun'
          }
        },
        labels: {
          style: {
            fontSize: '16px',
            fontFamily: 'Sarabun'
          }
        }
      },
      yAxis: {
        min: 0,
        title: {
          text: 'จำนวนรายการ',
          style: {
            fontSize: '16px',
            fontFamily: 'Sarabun'
          }
        },
        stackLabels: {
          enabled: true,
          style: {
            fontSize: '16px',
            fontFamily: 'Sarabun'
          }
        },
        labels: {
          formatter: function() {
            return Highcharts.numberFormat(this.value, 0, '', ',');
          },
          style: {
            fontSize: '16px',
            fontFamily: 'Sarabun'
          }
        }
      },
      tooltip: {
        formatter: function() {
          var point = this.point,
            series = point.series,
            index = series.data.indexOf(point);

          return '<b>' + que_day_label[index] + '</b><br/>' +
            point.series.name + ': ' + point.y + ' คน <br/>ยอดรวม: ' + point.stackTotal + ' คน';
        },
        style: {
          fontSize: '16px',
          fontFamily: 'Sarabun'
        }
      },
      plotOptions: {
        column: {
          stacking: 'normal',
          dataLabels: {
            enabled: true,
            formatter: function() {
              return this.y !== 0 ? Highcharts.numberFormat(this.y, 0, '', ',') : '';
            },
            style: {
              fontSize: '16px',
              fontFamily: 'Sarabun'
            }
          }
        }
      },
      series: [{
          name: 'ผู้ป่วยเก่า',
          data: que_count_old,
          color: Highcharts.getOptions().colors[0]
        },
        {
          name: 'ผู้ป่วยใหม่',
          data: que_count_new,
          color: Highcharts.getOptions().colors[2]
        }
      ]
    });
  }
  // chart_que_dashboard

  Highcharts.chart('chart-1', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
      style: {
        fontSize: '16px', // Set the font size for the entire chart
        fontFamily: 'Sarabun' // Set the font family for the entire chart
      }
    },
    title: {
      text: '',
      align: 'left'
    },
    // tooltip: {
    //     formatter: function () {
    //         var point = this.point;
    //         return point.name + ': <b>' + point.y + ' %</b> ('+ point.hours +' ชั่วโมง)';
    //     },
    //     style: {
    //         fontSize: '16px', // Set font size for tooltip
    //         fontFamily: 'Sarabun' // Set the font family for tooltip
    //     }
    // },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.y} %</b> ({point.detail})'
    },
    credits: {
      enabled: false
    },
    exporting: {
      enabled: false
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
          format: '<b>{point.name}</b>: {point.y} %',
          distance: -50 // Adjust the distance of labels from the center of the pie
        },
        showInLegend: true
      }
    },
    series: [{
      name: 'จำนวน',
      colorByPoint: true,
      colors: ['#7cb5ec', '#90ed7d', '#f7a35c', '#8085e9', '#f15c80', '#e4d354'], // Light colors
      data: [{
        name: 'มาทำงาน',
        y: 37.5,
        detail: '16 วัน',
        color: '#0dcaf0',
        sliced: true,
        selected: true
      }, {
        name: 'ลา',
        y: 25.00,
        detail: '4 วัน',
        color: '#ffc107'
      }, {
        name: 'มาสาย',
        y: 0.26,
        detail: '20 นาที',
        color: '#dc3545'
      }]
    }]
  });

  Highcharts.chart('chart-2', {
    chart: {
      type: 'spline',
      style: {
        fontSize: '16px', // Set the font size for the entire chart
        fontFamily: 'Sarabun' // Set the font family for the entire chart
      }
    },
    legend: {
      enabled: false,
      symbolWidth: 40
    },
    title: {
      text: '',
      align: ''
    },
    credits: {
      enabled: false
    },
    exporting: {
      enabled: false
    },
    subtitle: {
      text: '',
      align: 'left'
    },
    yAxis: {
      title: {
        text: 'จำนวนวันที่เข้าเวร',
        style: {
          fontSize: '16px', // Set the font size for the yAxis title
          fontFamily: 'Sarabun' // Set the font family for the yAxis title
        }
      }
    },
    xAxis: {
      title: {
        text: 'วันของสัปดาห์',
        style: {
          fontSize: '16px', // Set the font size for the xAxis title
          fontFamily: 'Sarabun'
        }
      },
      labels: {
        style: {
          fontSize: '16px', // Set the font size for the xAxis labels
          fontFamily: 'Sarabun'
        }
      },
      categories: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส']
    },
    tooltip: {
      // valueSuffix: ' วัน',
      stickOnContact: true,
      formatter: function() {
        var point = this.point,
          series = point.series,
          index = series.data.indexOf(point);

        return '<b>' + day_long[index] + '</b><br/>' +
          point.series.name + ': ' + point.y + ' วัน';
      },
      style: {
        fontSize: '16px' // Set the font size for the xAxis labels
      }
    },
    plotOptions: {
      series: {
        cursor: 'pointer',
        lineWidth: 2,
        dataLabels: {
          enabled: true,
          // format: '{y} วัน',
          style: {
            fontSize: '16px', // Set the font size for the dataLabels
            fontFamily: 'Sarabun'
          }
        }
      }
    },
    series: [{
      name: 'จำนวนวันที่เข้าเวร',
      data: [0, 0, 3, 4, 3, 5, 5],
      color: Highcharts.getOptions().colors[0],
      label: {
        style: {
          fontSize: '16px',
          fontFamily: 'Sarabun'
        }
      }
    }],
  });

  function render_detail_que_week_modal(data, type, que_type_text, year) {
    // Update summary text
    $('#summary-dashboard-' + type + '-old-detail-modal').text(data.que_week_table_list[0].week_detail.length);
    $('#summary-dashboard-' + type + '-new-detail-modal').text(data.que_week_table_list[1].week_detail.length);
    $('#title-dashboard-' + type + '-detail-modal').text('รายละเอียดผู้ป่วยนัดพบ' + que_type_text + ' ประจำเดือน' + data.month_text + ' ปี พ.ศ. ' + year);
    $('#topic-dashboard-' + type + '-detail-modal').text('รายการรายละเอียดผู้ป่วย' + que_type_text);

    const buttonHtml = '<div class="text-center option"><button class="btn btn-info"><i class="bi-search" title="คลิกเพื่อดูรายการ" data-toggle="tooltip" data-placement="top"></i></button></div>';

    let li_type = '';
    let tab_content_type = '';

    data.que_week_table_list.forEach((patientType, i) => {
      const totalAppointments = Object.values(patientType.week_detail).reduce((sum, dayAppointments) => sum + dayAppointments.length, 0);
      const activeClass = i === 0 ? "active" : "";
      const select = i === 0 ? "true" : "false";
      const show_active = i === 0 ? "show active" : "";

      li_type += `
                <li class="nav-item" role="presentation">
                    <button class="nav-link ${activeClass}" id="tab_que_type${i}" data-bs-toggle="tab" data-bs-target="#que_type_${i}" type="button" role="tab" aria-controls="que_type${i}" aria-selected="${select}">
                        ${patientType.name} <span class="badge bg-success" id="summary-dashboard-${type}-${i}-detail-modal">${totalAppointments}</span>
                    </button>
                </li>`;

      tab_content_type += `
                <div class="tab-pane fade ${show_active}" id="que_type_${i}" role="tabpanel" aria-labelledby="tab_que_type${i}">
                    <ul class="nav nav-pills mb-3" id="nav-${type}-${i}-day" role="tablist">`;

      Object.entries(patientType.week_detail).forEach(([day, dayAppointments], dayIndex) => {
        const dayActiveClass = dayIndex === 0 ? "active" : "";
        const daySelect = dayIndex === 0 ? "true" : "";
        const dayShowActive = dayIndex === 0 ? "show active" : "";

        tab_content_type += `
                    <li class="nav-item" role="presentation">
                        <button class="nav-link ${dayActiveClass}" id="tab_que_type_${i}-${dayIndex}" data-bs-toggle="tab" data-bs-target="#que_type_${i}-${dayIndex}" type="button" role="tab" aria-controls="que_type${i}" aria-selected="${daySelect}">
                            ${day} <span class="badge bg-success" id="summary-dashboard-${type}-${i}-detail-modal">${dayAppointments.length}</span>
                        </button>
                    </li>`;
      });

      tab_content_type += `
                    </ul>
                    <div class="tab-content pt-2" id="tab-content-${type}-${i}-day"></div>
                </div>`;
    });

    $("#nav-" + type).html(li_type);
    $("#tab-content-" + type).html(tab_content_type);

    data.que_week_table_list.forEach((patientType, i) => {
      Object.entries(patientType.week_detail).forEach(([day, dayAppointments], dayIndex) => {
        const show_active = dayIndex === 0 ? "show active" : "";

        let table = `
                    <div class="tab-pane fade ${show_active}" id="que_type_${i}-${dayIndex}" role="tabpanel" aria-labelledby="tab_que_type_${i}-${dayIndex}">
                        <div class="card">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button accordion-button-table" type="button">
                                            <i class="bi-clock-history icon-menu"></i><span> รายการ${patientType.name}มีการนัดหมายแพทย์ จำแนกตามวัน${day}</span><span class="badge bg-success">${dayAppointments.length}</span>
                                        </button>
                                    </h2>
                                    <div id="collapseShow" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <table class="table datatable" width="100%" id="table-que-${type}-day-${i}-${dayIndex}">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col">ชื่อ - นามสกุล ผู้ป่วย</th>
                                                        <th scope="col">รายละเอียด</th>
                                                        <th scope="col">วันที่เข้านัดพบ</th>
                                                        <th scope="col">ประเภทผู้ป่วย</th>
                                                        <th scope="col">การดำเนินการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-que-${type}-day-${i}-${dayIndex}"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

        $("#tab-content-" + type + "-" + i + "-day").append(table);

        const dataTable = $("#table-que-" + type + "-day-" + i + "-" + dayIndex).DataTable({
          language: {
            decimal: "",
            emptyTable: "ไม่มีรายการในระบบ",
            info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "_MENU_",
            loadingRecords: "Loading...",
            processing: "",
            search: "",
            searchPlaceholder: 'ค้นหา...',
            zeroRecords: "ไม่พบรายการ",
            paginate: {
              first: "«",
              last: "»",
              next: "›",
              previous: "‹"
            },
            aria: {
              orderable: "Order by this column",
              orderableReverse: "Reverse order this column"
            },
          },
          dom: 'lBfrtip',
          buttons: [{
              extend: 'print',
              text: '<i class="bi-file-earmark-fill"></i> Print',
              titleAttr: 'Print',
              title: 'รายการข้อมูล'
            },
            {
              extend: 'excel',
              text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
              titleAttr: 'Excel',
              title: 'รายการข้อมูล'
            },
            {
              extend: 'pdf',
              text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
              titleAttr: 'PDF',
              title: 'รายการข้อมูล',
              customize: function(doc) {
                doc.defaultStyle = {
                  font: 'THSarabun'
                };
              }
            }
          ]
        });

        dayAppointments.forEach((row, index) => {
          dataTable.row.add([
            `<div class="text-center">${index + 1}</div>`,
            `${row.pt_prefix}${row.pt_fname} ${row.pt_lname}`,
            `<div class="text-start">${row.apm_cause}</div>`,
            row.apm_date,
            `<div class="text-center">${row.apm_patient_type}</div>`,
            buttonHtml
          ]).draw();
        });
      });
    });
  }
</script>