<?php
function renderTabs($tab) {
    $tabs = [
        'all' => 'ทั้งหมด',
        'working' => 'ปฏิบัติงาน',
        'out' => 'ออก',
        'medical' => 'การแพทย์',
        'nurse' => 'พยาบาล',
        'admin' => 'งานบุคคล',
        'support_medical' => 'การแพทย์สนับสนุน',
        'support_nurse' => 'พยาบาลสนับสนุน'
    ];
    
    foreach ($tabs as $key => $label) {
        $activeClass = $tab === $key ? 'active' : '';
        echo "<li class='nav-item'>
                <a class='nav-link $activeClass' id='{$key}-tab' data-bs-toggle='pill' href='#{$key}' role='tab' aria-controls='{$key}' aria-selected='true'>{$label}</a>
            </li>";
    }
}

function renderTabContent($tab) {
    $contents = [
        'all' => 'รายละเอียดทั้งหมด',
        'working' => 'รายละเอียดปฏิบัติงาน',
        'out' => 'รายละเอียดออก',
        'medical' => 'รายละเอียดการแพทย์',
        'nurse' => 'รายละเอียดพยาบาล',
        'admin' => 'รายละเอียดงานบุคคล',
        'support_medical' => 'รายละเอียดการแพทย์สนับสนุน',
        'support_nurse' => 'รายละเอียดพยาบาลสนับสนุน'
    ];

    foreach ($contents as $key => $content) {
        $activeClass = $tab === $key ? 'show active' : '';
        echo "<div class='tab-pane fade $activeClass' id='{$key}' role='tabpanel' aria-labelledby='{$key}-tab'>
                <table id='{$key}' class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th>Column 1</th>
                            <th>Column 2</th>
                            <th>Column 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Populate table rows dynamically here -->
                    </tbody>
                </table>
            </div>";
    }
}
?>

<style>
a.bi-search {
   cursor: pointer;
}
.filterDetail {
   right: 20px !important;  
}
.nav-pills .nav-link {
    border: 1px dashed #607D8B;
    color: #012970;
}
.table {
    border-collapse: collapse !important;
}
.card-icon {
    font-size: 32px;
    line-height: 0;
    width: 64px;
    height: 64px;
    flex-shrink: 0;
    flex-grow: 0;
}
.info-card h6 {
    font-size: 28px;
    color: var(--tp-font-color);
    font-weight: 700;
    margin: 0;
    padding: 0;
}
</style>

<?php
setlocale(LC_TIME, 'th_TH.utf8');
$thaiMonths = array(
    'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
);
?>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                    <i class="bi-people icon-menu"></i><span>รายงานผู้ป่วยในแผนก</span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row">
                        <!-- Filters -->
                        <div class="col-md-4">
                            <div class="form-floating mb-4">
                                <select class="form-select form-select-lg mb-4" id="hrm_select_ums_department" name="hrm_select_ums_department" onchange="filterHRM()">
                                    <?php foreach ($ums_department_list as $key => $row): ?>
                                        <option value="<?= $row->dp_id ?>" <?= $key == 0 ? 'selected' : '' ?>><?= $row->dp_name_th ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="ums_department">หน่วยงาน</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select form-select-lg mb-3 " id="hrm_select_year_type" name="hrm_select_year_type" onchange="filterHRM()">
                                    <option value="1" selected>ปีปฏิทิน</option>
                                </select>
                                <label for="hrm_select_year_type">ประเภทปี</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select form-select-lg mb-3" id="hrm_select_year" name="hrm_select_year" onchange="filterHRM()">
                                    <?php foreach ($default_year_list as $year): ?>
                                        <option value="<?= $year - 543 ?>" <?= $year == getNowYearTh() ? 'selected' : '' ?>><?= $year ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="hrm_select_year">ปีพ.ศ.</label>
                            </div>
                        </div>
                    </div>

                    <!-- Cards -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card sales-card" style="border-bottom: 3px solid #FF9800;">
                                <div class="m-0 p-0 text-end me-2 mt-1">
                                    <a class="bi-search toggleCardHRMDetail" data-card-type="all" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                                </div>
                                <div class="card-body mt-0 mb-3 pt-0 pb-2">
                                    
                                    <h5 class="card-title pt-0">[QUE-AP-C1] จำนวนการนัดหมาย</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #FF9800; background: #ffeacc;">
                                            <i class="bi bi-person-circle"></i>
                                        </div>
                                        <div class="ps-4">
                                            <h6>20</h6>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card customers-card" style="border-bottom: 3px solid #1fe1a3; background: linear-gradient(to right bottom, rgb(150, 234, 218), rgb(255, 255, 255), rgb(255, 255, 255));">
                                <div class="filter m-0 p-0 text-end me-2 mt-1">
                                    <a class="bi-search toggleCardHRMDetail" data-card-type="new" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                                </div>
                                <div class="card-body mt-0 mb-3 pt-0 pb-2">
                                    <h5 class="card-title pt-0">[QUE-AP-C2] จำนวนการนัดหมาย(ผู้ป่วยใหม่)</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #fff; background: #1fe1a3;">
                                            <i class="bi bi-person-fill-add"></i>
                                        </div>
                                        <div class="ps-4">
                                            <h6>20</h6>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card customers-card" style="border-bottom: 3px solid #00FF80; background: linear-gradient(to right bottom, rgb(0, 255, 125), rgb(255, 255, 255), rgb(255, 255, 255));">
                                <div class="filter m-0 p-0 text-end me-2 mt-1">
                                    <a class="bi-search toggleCardHRMDetail" data-card-type="old" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                                </div>
                                <div class="card-body mt-0 mb-3 pt-0 pb-2">
                                    <h5 class="card-title pt-0">[QUE-AP-C3] จำนวนการนัดหมาย(ผู้ป่วยเก่า)</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #fff; background: #00FF80;">
                                            <i class="bi bi-person-fill-check"></i>
                                        </div>
                                        <div class="ps-4">
                                            <h6>20</h6>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-6">
                                <div id="chart-container" style="width:100%; height:400px;"></div>
                            </div>
                            <div class="col-6">
                                <div id="stacked-column--chartcontainer" style="width:100%; height:400px;"></div>
                            </div>
                        </div>
                        <div class="row g-6">
                            <div id="bar-chart-container" style="width:100%; height:400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for detailsHRMCard -->
<div class="modal fade" id="detailsHRMCard" tabindex="-1" aria-labelledby="detailsHRMCardLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsHRMCardLabel">รายละเอียด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <table id="dataTable" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>
                                <th>หัวตาราง</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<!-- Include Highcharts library -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
$(document).ready(function() {
    renderCharts();
    // Handle card click to open modal
    $('.toggleCardHRMDetail').on('click', function() {
        var cardType = $(this).data('card-type');
        showCardHRMDetail(cardType);
    });

    function showCardHRMDetail(cardType) {
        $('#detailsHRMCard').modal('show');
        loadDataTable(cardType);
        
    }

    function loadDataTable(cardType) {
        $('#dataTable').DataTable().destroy(); // Destroy existing table

        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('que/Statistic/get_appointments'); ?>",
                "type": "POST",
                "data": function (d) {
                    d.cardType = cardType; // Pass cardType to server
                }
            },
            "columns": [
                { "data": "row_number", "orderable": false },
                { "data": "pt_member" },
                { "data": "apm_cl_code" },
                { "data": "stde_name_th" },
                { "data": "pt_name" },
                { "data": "apm_date" },
                { "data": "apm_time" },
                { "data": "ps_name" },
                { "data": "apm_create_date" },
                { "data": "apm_id",
                  "render": function(data, type, row, meta){
                    return `
                        <div class="text-center">
                            <button class="btn btn-warning" id="edit_btn" onclick="window.location.href='<?php echo site_url(); ?>/que/Appointment/add_appointment/${data}'">
                            <i class="bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-info" id="edit_btn" onclick="navigateToAddAppointmentStep2('${data}')">
                            <i class="bi-search"></i>
                            </button>
                        </div>`;
                  }
                }
            ],
            "order": [[2, 'desc']], // Default order
            "language": {
                "emptyTable": "ไม่มีรายการในระบบ",
                "info": "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "infoEmpty": "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "lengthMenu": "_MENU_",
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "",
                "searchPlaceholder": 'ค้นหา...',
                "zeroRecords": "ไม่พบรายการ",
                "paginate": {
                    "first": "«",
                    "last": "»",
                    "next": "›",
                    "previous": "‹"
                }
            },
            "dom": 'lBfrtip',
            "buttons": [
                {
                    "extend": 'print',
                    "text": '<i class="bi-file-earmark-fill"></i> Print',
                    "titleAttr": 'Print',
                    "title": 'รายการข้อมูล'
                },
                {
                    "extend": 'excel',
                    "text": '<i class="bi-file-earmark-excel-fill"></i> Excel',
                    "titleAttr": 'Excel',
                    "title": 'รายการข้อมูล'
                },
                {
                    "extend": 'pdf',
                    "text": '<i class="bi-file-earmark-pdf-fill"></i> PDF',
                    "titleAttr": 'PDF',
                    "title": 'รายการข้อมูล',
                    "customize": function (doc) {
                        doc.defaultStyle = { font: 'THSarabun' };
                    }
                }
            ]
        });
    }

    function renderCharts() {
        // Donut chart
        const colors = Highcharts.getOptions().colors,
            categories = ['Chrome', 'Safari', 'Edge', 'Firefox', 'Other'],
            data = [
                    { y: 55.60, color: colors[2], drilldown: { name: 'Chrome', categories: ['Chrome v97.0', 'Chrome v96.0', 'Chrome v95.0'], data: [36.60, 14.00, 5.00] }},
                    { y: 9.40, color: colors[3], drilldown: { name: 'Safari', categories: ['Safari v15.3', 'Safari v15.2'], data: [5.20, 4.20] }},
                    { y: 9.50, color: colors[5], drilldown: { name: 'Edge', categories: ['Edge v97', 'Edge v96'], data: [6.62, 2.88] }},
                    { y: 8.15, color: colors[1], drilldown: { name: 'Firefox', categories: ['Firefox v96.0', 'Firefox v95.0'], data: [4.17, 3.98] }},
                    { y: 17.35, color: colors[6], drilldown: { name: 'Other', categories: ['Other'], data: [17.35] }}
                ];
            browserData = [],
            versionsData = [];

        for (let i = 0; i < data.length; i++) {
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });

            for (let j = 0; j < data[i].drilldown.data.length; j++) {
                const name = data[i].drilldown.categories[j];
                const brightness = 0.2 - (j / data[i].drilldown.data.length) / 5;
                versionsData.push({
                    name,
                    y: data[i].drilldown.data[j],
                    color: Highcharts.color(data[i].color).brighten(brightness).get(),
                    custom: { version: name.split(' ')[1] || name.split(' ')[0] }
                });
            }
        }

        Highcharts.chart('chart-container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Browser market share, January, 2022',
                align: 'left'
            },
            subtitle: {
                text: 'Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>',
                align: 'left'
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            tooltip: {
                valueSuffix: '%'
            },
            series: [{
                name: 'Browsers',
                data: browserData,
                size: '45%',
                dataLabels: {
                    color: '#ffffff',
                    distance: '-50%'
                }
            }, {
                name: 'Versions',
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    format: '<b>{point.name}:</b> <span style="opacity: 0.5">' +
                        '{y}%</span>',
                    filter: {
                        property: 'y',
                        operator: '>',
                        value: 1
                    },
                    style: {
                        fontWeight: 'normal'
                    }
                },
                id: 'versions'
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 400
                    },
                    chartOptions: {
                        series: [{
                        }, {
                            id: 'versions',
                            dataLabels: {
                                distance: 10,
                                format: '{point.custom.version}',
                                filter: {
                                    property: 'percentage',
                                    operator: '>',
                                    value: 2
                                }
                            }
                        }]
                    }
                }]
            }
        });


        // Stacked Column Chart
        Highcharts.chart('stacked-column--chartcontainer', {
            chart: { type: 'column' },
            title: { text: 'Stacked Column Chart' },
            xAxis: { categories: ['Category1', 'Category2', 'Category3'] },
            yAxis: { 
                title: { text: 'Values' },
                stackLabels: { enabled: true }
            },
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            series: [{
                name: 'Data Series 1',
                data: [1, 2, 3]
            }, {
                name: 'Data Series 2',
                data: [3, 2, 1]
            }]
        });

        // Bar Chart
        Highcharts.chart('bar-chart-container', {
            chart: { type: 'bar' },
            title: { text: 'Bar Chart' },
            xAxis: { categories: ['Category1', 'Category2', 'Category3'] },
            yAxis: { title: { text: 'Values' } },
            series: [{
                name: 'Data Series',
                data: [1, 2, 3]
            }]
        });
    }
});
</script>
