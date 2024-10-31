<!-- Modal for detailsG4Modal -->
<div class="modal fade" id="detailsG4Modal" tabindex="-1" aria-labelledby="detailsG4ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsG4ModalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs d-flex" id="detailsG4Tab" role="tablist">
                    <!-- Main tabs will be dynamically generated here -->
                </ul>
                <div class="tab-content mb-5 mt-5" id="detailsG4TabContent">
                    <!-- Sub-tabs and tables will be dynamically generated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getChartHRM_G4(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#detailsG4ModalLabel").text("[SEE-HRM-G4] รายละเอียดกราฟจำนวนบุคลากรใบอนุญาติประกอบวิชาชีพจะหมดอายุ"+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_G4",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            renderChartHRM_G4(data.chart);
            renderChartHRM_G4_detail(data.detail);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_G4_detail(data) {
    var mainTabsHtml = '';
    var subTabsHtml = '';
    var mainTabCounter = 0;

    // Iterate over each expiration period to create main tabs and sub-tabs
    $.each(data, function(expirationPeriod, details) {
        var mainTabId = 'g4-tab-' + mainTabCounter++;
        mainTabsHtml += `
            <li class="nav-item" role="presentation">
                <a class="nav-link ${mainTabCounter === 1 ? 'active' : ''}" id="${mainTabId}-tab" data-bs-toggle="tab" href="#${mainTabId}" role="tab" aria-controls="${mainTabId}" aria-selected="${mainTabCounter === 1 ? 'true' : 'false'}">${expirationPeriod}</a>
            </li>
        `;

        var subTabs = '';
        var subTabContents = '';
        var subTabCounter = 0;

        // Create sub-tabs for each vocation in the expiration period
        var vocationGroups = {};

        $.each(details.person_list, function(index, person) {
            var vocationName = person.vocation_name || 'ไม่มีข้อมูล';
            if (!vocationGroups[vocationName]) {
                vocationGroups[vocationName] = [];
            }
            vocationGroups[vocationName].push(person);
        });

        $.each(vocationGroups, function(vocationName, personList) {
            var subTabId = mainTabId + '-' + subTabCounter++;
            subTabs += `
                <li class="nav-item" role="presentation">
                    <a class="nav-link ${subTabCounter === 1 ? 'active' : ''}" id="${subTabId}-tab" style="margin-right: 0.25rem;" data-bs-toggle="tab" href="#${subTabId}" role="tab" aria-controls="${subTabId}" aria-selected="${subTabCounter === 1 ? 'true' : 'false'}">${vocationName}</a>
                </li>
            `;

            subTabContents += `
                <div class="tab-pane fade ${subTabCounter === 1 ? 'show active' : ''}" id="${subTabId}" role="tabpanel" aria-labelledby="${subTabId}-tab">
                    <table class="table datatable table-bordered table-hover" id="detailsTable_g4_${subTabId}" width="100%">
                        <thead>
                            <tr>
                                <th scope="row" class="text-center">#</th>
                                <th class="text-center">ชื่อ-นามสกุล</th>
                                <th class="text-center">ประเภทบุคลากร</th>
                                <th class="text-center">ตำแหน่งในการบริหาร</th>
                                <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                <th class="text-center">ตำแหน่งงานเฉพาะทาง</th>
                                <th class="text-center">สถานะการทำงาน</th>
                                <th class="text-center">วันที่เริ่มต้น</th>
                                <th class="text-center">วันที่สิ้นสุด</th>
                                <th class="text-center">ชื่อวิชาชีพ</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            `;
        });

        subTabsHtml += `
            <div class="tab-pane fade ${mainTabCounter === 1 ? 'show active' : ''}" id="${mainTabId}" role="tabpanel" aria-labelledby="${mainTabId}-tab">
                <ul class="nav nav-pills" id="detailsG4-${mainTabId}-Tab" role="tablist">
                    ${subTabs}
                </ul>
                <div class="tab-content mb-5 mt-3" id="detailsG4-${mainTabId}-Content">
                    ${subTabContents}
                </div>
            </div>
        `;
    });

    $('#detailsG4Tab').html(mainTabsHtml);
    $('#detailsG4TabContent').html(subTabsHtml);

    // Initialize DataTables for each tab and subtab
    var initializedTabs = [];
    $.each(data, function(expirationPeriod, details) {
        var mainTabId = 'g4-tab-' + initializedTabs.length;
        initializedTabs.push(mainTabId);

        var vocationGroups = {};

        $.each(details.person_list, function(index, person) {
            var vocationName = person.vocation_name || 'ไม่มีข้อมูล';
            if (!vocationGroups[vocationName]) {
                vocationGroups[vocationName] = [];
            }
            vocationGroups[vocationName].push(person);
        });

        var subTabCounter = 0;

        $.each(vocationGroups, function(vocationName, personList) {
            var subTabId = mainTabId + '-' + subTabCounter++;

            var columns = [
                { data: null, className: 'text-center', render: function(data, type, row, meta) {
                    return meta.row + 1;
                }},
                { data: 'full_name', className: 'text-start' },
                { data: 'ps_hire_name', className: 'text-start' },
                { data: 'ps_admin_name', className: 'text-start' },
                { data: 'ps_alp_name', className: 'text-start' },
                { data: 'ps_spcl_name', className: 'text-start' },
                { data: 'ps_retire_name', className: 'text-center' },
                { data: 'licn_start_date', className: 'text-center' },
                { data: 'licn_end_date', className: 'text-center' },
                { data: 'vocation_name', className: 'text-center' }
            ];

            initializeDataTable('#detailsTable_g4_' + subTabId, personList, columns);
        });
    });
}

function renderChartHRM_G4(data) {
    // Extract unique categories and vocation names from the data
    var categories = Object.keys(data);
    var vocationNames = new Set();

    // Collect all unique vocation names
    categories.forEach(function(category) {
        data[category].forEach(function(item) {
            vocationNames.add(item.vocation_name);
        });
    });

    vocationNames = Array.from(vocationNames);
    
    // Initialize data series for each vocation
    var seriesData = {};
    vocationNames.forEach(function(vocationName) {
        seriesData[vocationName] = categories.map(function(category) {
            var count = 0;
            if (data[category]) {
                data[category].forEach(function(item) {
                    if (item.vocation_name === vocationName) {
                        count += parseInt(item.person_count, 10);
                    }
                });
            }
            return count;
        });
    });

    // Prepare series for Highcharts
    var series = vocationNames.map(function(vocationName) {
        return {
            name: vocationName,
            marker: {
                symbol: 'square'
            },
            data: seriesData[vocationName]
        };
    });

    // Create the line chart
    Highcharts.chart('g4', {
        chart: {
            type: 'line',
            style: {
                fontSize: '16px',
                fontFamily: 'Sarabun'
            }
        },
        title: {
            text: '',
            style: {
                fontSize: '16px',
                fontFamily: 'Sarabun'
            }
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: categories,
            accessibility: {
                description: 'อายุใบอนุญาติประกอบวิชาชีพ'
            }
        },
        yAxis: {
            title: {
                text: 'จำนวนคน'
            },
            labels: {
                format: '{value} คน'
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                },
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: series
    });
}


</script>