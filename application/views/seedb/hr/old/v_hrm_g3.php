<!-- Modal for detailsG3Modal -->
<div class="modal fade" id="detailsG3Modal" tabindex="-1" aria-labelledby="detailsG3ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsG3ModalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs d-flex" id="detailsG3Tab" role="tablist">
                    <!-- Main tabs will be dynamically generated here -->
                </ul>
                <div class="tab-content mb-5 mt-5" id="detailsG3TabContent">
                    <!-- Sub-tabs and tables will be dynamically generated here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function getChartHRM_G3(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#detailsG3ModalLabel").text("[SEE-HRM-G3] รายละเอียดกราฟแสดงข้อมูลจำนวนบุคลากรสายแพทย์และประเภทการปฏิบัติงาน"+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_G3",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);
            renderChartHRM_G3(data.chart);
            renderChartHRM_G3_detail(data.detail);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_G3(data){
    // Parse data
    let categories = [];
    let fullTimeData = [];
    let partTimeData = [];

    data.forEach(item => {
        if (!categories.includes(item.chart_name)) {
            categories.push(item.chart_name);
        }

        if (item.chart_subtype === "Full") {
            fullTimeData[categories.indexOf(item.chart_name)] = parseInt(item.chart_count);
        } else if (item.chart_subtype === "Part") {
            partTimeData[categories.indexOf(item.chart_name)] = parseInt(item.chart_count);
        }
    });

    // Fill missing values with 0
    categories.forEach((category, index) => {
        if (fullTimeData[index] === undefined) fullTimeData[index] = 0;
        if (partTimeData[index] === undefined) partTimeData[index] = 0;
    });

    // Column chart for major trophies
    Highcharts.chart('g3', {
        chart: {
            type: 'column',
            style: {
                fontSize: '16px',
                fontFamily: 'Sarabun'
            }
        },
        title: {
            text: '',
            align: 'left',
            style: {
                fontSize: '16px',
                fontFamily: 'Sarabun'
            }
        },
        xAxis: {
            categories: categories
        },
        yAxis: {
            min: 0,
            title: {
                text: 'จำนวนคน'
            },
            stackLabels: {
                enabled: true
            }
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>ทั้งหมด: {point.stackTotal}'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [{
            name: 'เต็มเวลา (Full Time)',
            data: fullTimeData
        }, {
            name: 'บางเวลา (Part Time)',
            data: partTimeData
        }]
    });
}

function renderChartHRM_G3_detail(data) {

    // Initialize HTML structure for main tabs and sub-tabs
    var mainTabsHtml = '';
    var subTabsHtml = '';

    $.each(data, function(index, tab) {
        var tabId = tab.hire_name.replace(/\s+/g, '').toLowerCase();
        mainTabsHtml += `
            <li class="nav-item" role="presentation">
                <a class="nav-link ${index === 0 ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="tab" href="#${tabId}" role="tab" aria-controls="${tabId}" aria-selected="${index === 0 ? 'true' : 'false'}">${tab.hire_name}</a>
            </li>
        `;

        subTabsHtml += `
            <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                <ul class="nav nav-pills" id="detailsG3-${tabId}-Tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="${tabId}-all-tab" style="margin-right: 0.25rem;" data-bs-toggle="tab" href="#${tabId}-all" role="tab" aria-controls="${tabId}-all" aria-selected="true">ทั้งหมด</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="${tabId}-full-tab" style="margin-right: 0.25rem;" data-bs-toggle="tab" href="#${tabId}-full" role="tab" aria-controls="${tabId}-full" aria-selected="false">เต็มเวลา</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="${tabId}-part-tab" data-bs-toggle="tab" href="#${tabId}-part" role="tab" aria-controls="${tabId}-part" aria-selected="false">บางเวลา</a>
                    </li>
                </ul>
                <div class="tab-content mb-5 mt-3" id="detailsG3-${tabId}-Content">
                    <div class="tab-pane fade show active" id="${tabId}-all" role="tabpanel" aria-labelledby="${tabId}-all-tab">
                        <table class="table datatable table-bordered table-hover" id="detailsTable_g3_${tabId}-all" width="100%">
                            <thead>
                                <tr>
                                    <th scope="row" class="text-center">#</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">ประเภทบุคลากร</th>
                                    <th class="text-center">ตำแหน่งในการบริหาร</th>
                                    <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                    <th class="text-center">ตำแหน่งงานเฉพาะทาง</th>
                                    <th class="text-center">สถานะการทำงาน</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="${tabId}-full" role="tabpanel" aria-labelledby="${tabId}-full-tab">
                        <table class="table datatable table-bordered table-hover" id="detailsTable_g3_${tabId}-full" width="100%">
                            <thead>
                                <tr>
                                    <th scope="row" class="text-center">#</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">ประเภทบุคลากร</th>
                                    <th class="text-center">ตำแหน่งในการบริหาร</th>
                                    <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                    <th class="text-center">ตำแหน่งงานเฉพาะทาง</th>
                                    <th class="text-center">สถานะการทำงาน</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="${tabId}-part" role="tabpanel" aria-labelledby="${tabId}-part-tab">
                        <table class="table datatable table-bordered table-hover" id="detailsTable_g3_${tabId}-part" width="100%">
                            <thead>
                                <tr>
                                    <th scope="row" class="text-center">#</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">ประเภทบุคลากร</th>
                                    <th class="text-center">ตำแหน่งในการบริหาร</th>
                                    <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                    <th class="text-center">ตำแหน่งงานเฉพาะทาง</th>
                                    <th class="text-center">สถานะการทำงาน</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
    });

    $('#detailsG3Tab').html(mainTabsHtml);
    $('#detailsG3TabContent').html(subTabsHtml);

    // Initialize DataTables for each tab and subtab
    $.each(data, function(index, tab) {
        var tabId = tab.hire_name.replace(/\s+/g, '').toLowerCase();
        var fullTabId = tabId + '-full';
        var partTabId = tabId + '-part';
        var allTabId = tabId + '-all';

        var columns = [
            { data: null, className: 'text-center', render: function(data, type, row, meta) {
                return meta.row + 1;
            }},
            { data: 'full_name', className: 'text-start' },
            { data: 'ps_hire_name', className: 'text-start' },
            { data: 'ps_admin_name', className: 'text-start' },
            { data: 'ps_alp_name', className: 'text-start' },
            { data: 'ps_spcl_name', className: 'text-start' },
            { data: 'ps_retire_name', className: 'text-center' }
        ];

        initializeDataTable('#detailsTable_g3_' + fullTabId, tab.hire_detail.full, columns);
        initializeDataTable('#detailsTable_g3_' + partTabId, tab.hire_detail.part, columns);
        initializeDataTable('#detailsTable_g3_' + allTabId, tab.hire_detail.all, columns);
    });
}

</script>