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
    <?php $this->load->view($view_dir . 'v_personal_dashboard'); ?>   
    <?php $this->load->view($view_dir . 'v_develop_dashboard'); ?>    
    <?php $this->load->view($view_dir . 'v_payroll_dashboard'); ?>    
</section>

<?php $this->load->view($view_dir . 'v_hrm_1'); ?>
<?php $this->load->view($view_dir . 'v_hrm_2'); ?>
<?php $this->load->view($view_dir . 'v_hrm_3'); ?>
<?php $this->load->view($view_dir . 'v_hrm_4'); ?>
<?php $this->load->view($view_dir . 'v_hrm_5'); ?>
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

    function filterHRM() {
        // getHRMCard_1();
        // getChartHRM_1();
        // getChartHRM_2();
        // getChartHRM_3();
        // getChartHRM_4();
        // getChartHRM_5();
        updateSelectedFilters();

        setTimeout(function() {
    
          getHRMCard_1();
          getChartHRM_1();
          getChartHRM_2();
          getChartHRM_3();
          getChartHRM_4();
          getChartHRM_5();


        }, 500); // หน่วงเวลา 1000 มิลลิวินาที (1 วินาที)
    }

    document.getElementById('loader1').classList.remove('hidden');
    document.getElementById('loader2').classList.remove('hidden');
    document.getElementById('loader3').classList.remove('hidden');
    document.getElementById('loader4').classList.remove('hidden');

  function initializeDataTableDashboard(selector, data, columns, filterOption = [], filterTopic = '') {

    // ตรวจสอบ selector และวนลูปเพื่อรองรับหลายตาราง
    $(selector).each(function() {
        var $table = $(this);

        // สร้างและแทรก CSS เฉพาะสำหรับตารางนี้
        var tableId = $table.attr('id');

        // ตรวจสอบและทำลาย DataTable ที่มีอยู่แล้วหากมีอยู่
        if ($.fn.DataTable.isDataTable($table)) {
            $table.DataTable().clear().destroy();
        }

        // เพิ่มคอลัมน์ที่ซ่อนอยู่สำหรับ hire_type หรือ stde_id เพื่อการกรองข้อมูล
        var tableColumns = columns.slice(); // Copy the columns array to avoid modifying the original

        // Determine which column to add based on filterTopic
        if (filterTopic === 'ประเภทการทำงาน') {  //hrm_1
            tableColumns.unshift({ title: "ประเภทการทำงาน", data: "hire_type", visible: false });
        } else if (filterTopic === 'ฝ่าย') { //hrm_2
            tableColumns.unshift({ title: "ฝ่าย", data: "stde_id", visible: false });
        } else if (filterTopic === 'แผนก') {  //hrm_4
            tableColumns.unshift({ title: "แผนก", data: "stde_id", visible: false });
        }  else if (filterTopic === 'สายงาน') {  //hrm_5
            tableColumns.unshift({ title: "สายงาน", data: "hire_is_medical", visible: false });
        }

        // เริ่มต้นการตั้งค่า DataTable
        var table = $table.DataTable({
            data: data, // ข้อมูลที่จะแสดงในตาราง
            columns: tableColumns, // คอลัมน์ในตาราง
            order: [[1, 'asc']],  // ตั้งค่าเรียงลำดับเริ่มต้นที่คอลัมน์ "#"
            language: {
                decimal: "",
                emptyTable: "ไม่มีรายการในระบบ",
                info: "แสดงรายการที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                infoEmpty: "แสดงรายการที่ 0 ถึง 0 จากทั้งหมด 0 รายการ",
                infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                lengthMenu: "_MENU_",
                loadingRecords: "กำลังโหลด...",
                processing: "กำลังประมวลผล...",
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
                    sortAscending: ": เปิดการเรียงลำดับจากน้อยไปมาก",
                    sortDescending: ": เปิดการเรียงลำดับจากมากไปน้อย"
                }
            },
            dom: '<"dt-container"<"dt-length"l><"dt-buttons"B>' + (filterOption.length > 0 ? '<"dt-filter">f' : '<"dt-search"f>') + '>tip', // โครงสร้าง DOM ที่กำหนดเอง
            buttons: [
                {
                    extend: 'print',
                    text: '<i class="bi-file-earmark-fill"></i> พิมพ์',
                    titleAttr: 'พิมพ์',
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
                    customize: function (doc) {
                        doc.defaultStyle = { font: 'THSarabun' };
                    }
                }
            ],
            createdRow: function(row, data, dataIndex) {
                // เพิ่ม attribute data-hire-type หรือ data-stde-id และ data-seq ให้แต่ละแถว
                if (filterTopic === 'ประเภทการทำงาน') {
                    $(row).attr('data-hire-type', data.hire_type);
                } else if (filterTopic === 'ฝ่าย') {
                    $(row).attr('data-stde-id', data.stde_id);
                } else if (filterTopic === 'แผนก') {
                    $(row).attr('data-stde-id', data.stde_id);
                } else if (filterTopic === 'สายงาน') {
                    $(row).attr('data-hire-is-medical', data.hire_is_medical);
                } 
                $(row).attr('data-seq', dataIndex + 1);  // ใช้ dataIndex + 1 เป็นลำดับ
            },
            initComplete: function() {
                var api = this.api();  // อ้างอิง API ของ DataTables

                // ตรวจสอบว่ามีตัวเลือกการกรอง (filterOption) หรือไม่
                if (filterOption.length > 0) {
                    $table.closest('.dt-container').css('justify-content', 'space-between');

                    // สร้างและแทรก select element สำหรับการกรองใน div .dt-filter
                    var selectId = $table.attr('id') + '-global-filter';
                    var $select = $('<select id="' + selectId + '" class="form-select select2" style="width: 100%;" data-placeholder="-- ' + filterTopic + ' --"><option value="0">เลือกทั้งหมด</option></select>')
                        .appendTo($table.closest('.dt-container').find('.dt-filter'));

                    // เติม select element ด้วยตัวเลือกจาก filterOption
                    filterOption.forEach(function(option) {
                        $select.append('<option value="' + option.value + '">' + option.text + '</option>');
                    });

                    // เริ่มใช้งาน select2 สำหรับ select element
                    initializeSelect2('#' + selectId);

                    // Event handler สำหรับการกรองข้อมูลและเรียงลำดับเมื่อเปลี่ยนค่าใน Select2
                    $select.on('change', function() {
                        var val = $(this).val();
                        
                        if (val === '0' || val === 0) {  // ตรวจสอบว่ามีการเลือก "ทั้งหมด"
                            api.search('').columns().search('').draw();
                            api.order([1, 'asc']).draw();  // สั่งให้เรียงลำดับตามคอลัมน์ "#"
                        } else {
                            // กรองข้อมูลตาม hire_type หรือ stde_id และเรียงลำดับตามคอลัมน์ "#"
                            api.column(0).search('^' + val + '$', true, false).draw();
                            api.order([1, 'asc']).draw();  // สั่งให้เรียงลำดับตามคอลัมน์ "#"
                        }

                        // อัปเดตข้อความที่แสดงผลตามข้อมูลที่กรอง
                        updateFilteredInfo(api);
                    });
                } else {
                    $table.closest('.dt-container').css('display', '');
                    $table.closest('.dt-container').css('justify-content', '');
                }

                // Event handler สำหรับการ redraw ของ DataTable เพื่ออัปเดตข้อความที่แสดงข้อมูลที่กรอง
                api.on('draw', function() {
                    if (api.rows({ filter: 'applied' }).data().length === 0) {
                        $table.closest('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
                    }
                    updateFilteredInfo(api); // อัปเดตการแสดงผลของข้อมูลที่กรอง
                });

                function updateFilteredInfo(api) {
                    var info = api.page.info();
                    var totalFiltered = api.rows({ filter: 'applied' }).data().length;

                    if (totalFiltered !== info.recordsTotal) {
                        $table.closest('.dataTables_info').html(
                            'แสดงรายการที่ ' + (info.start + 1) + ' ถึง ' + info.end + ' จากทั้งหมด ' + totalFiltered + ' รายการ (กรองจากทั้งหมด ' + info.recordsTotal + ' รายการ)'
                        );
                    } else {
                        $table.closest('.dataTables_info').html(
                            'แสดงรายการที่ ' + (info.start + 1) + ' ถึง ' + info.end + ' จากทั้งหมด ' + info.recordsTotal + ' รายการ'
                        );
                    }
                }

                updateFilteredInfo(api);
            }
        });

        // ตรวจสอบว่ามีตัวเลือกการกรอง (filterOption) หรือไม่
        if (filterOption.length > 0) {
            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    #${selector.replace('#', '')}_wrapper .dt-container {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        flex-wrap: wrap;
                        width: 100%;
                        gap: 10px;
                        margin-bottom: 10px;
                    }

                    #${selector.replace('#', '')}_wrapper .dt-filter {
                        order: 1;
                        flex-grow: 1;
                        display: flex;
                        justify-content: flex-start;
                    }

                    #${selector.replace('#', '')}_wrapper .dt-buttons {
                        order: 1;
                        display: flex;
                        gap: 5px;
                        margin-top: 3px;
                    }

                    #${selector.replace('#', '')}_wrapper .dt-search {
                        order: 3;
                    }

                    #${selector.replace('#', '')}_wrapper .dataTables_length {
                        order: 4;
                    }

                    #${selector.replace('#', '')}_wrapper .dataTables_filter {
                        display: none;
                    }

                    #${selector.replace('#', '')}_wrapper .dataTables_info,
                    #${selector.replace('#', '')}_wrapper .dataTables_paginate {
                        display: block !important;
                        margin-top: 10px;
                    }

                    #${selector.replace('#', '')}_wrapper .dataTables_paginate {
                        text-align: right;
                    }
                `)
                .appendTo('head');
        }

        // เริ่มใช้งาน select2 สำหรับ tab แรก
        initializeSelect2('#' + selector.replace('#', '') + '-global-filter');

        // Event listener สำหรับการเปลี่ยน tab
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            initializeSelect2(target + ' .select2');
        });
    });
}



</script>
