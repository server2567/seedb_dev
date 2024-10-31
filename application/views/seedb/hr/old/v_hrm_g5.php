<!-- Modal for detailsG5Modal -->
<div class="modal fade" id="detailsG5Modal" tabindex="-1" aria-labelledby="detailsG5ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsG5ModalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs d-flex" id="detailsG5Tab" role="tablist">
                    <!-- Main tabs will be dynamically generated here -->
                </ul>
                <div class="tab-content mb-5 mt-5" id="detailsG5TabContent">
                    <!-- Sub-tabs and tables will be dynamically generated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getChartHRM_G5(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#detailsG5ModalLabel").text("[SEE-HRM-G5] รายละเอียดกราฟจำนวนบุคลากรจำแนกตามอายุและเพศ"+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_G5",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            renderChartHRM_G5(data.chart);
            renderChartHRM_G5_detail(data.detail);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_G5_detail(data) {
    var mainTabsHtml = '';
    var mainTabContentsHtml = '';
    var mainTabCounter = 0;

    // Iterate over each age group to create main tabs and sub-tabs
    $.each(data, function(index, group) {
        var mainTabId = 'main-tab-' + mainTabCounter++;
        mainTabsHtml += `
            <li class="nav-item" role="presentation">
                <a class="nav-link ${mainTabCounter === 1 ? 'active' : ''}" id="${mainTabId}-tab" data-bs-toggle="tab" href="#${mainTabId}" role="tab" aria-controls="${mainTabId}" aria-selected="${mainTabCounter === 1 ? 'true' : 'false'}">${group.age_group}</a>
            </li>
        `;

        var subTabsHtml = '';
        var subTabContentsHtml = '';
        var subTabCounter = 0;

        $.each(group.genders, function(genderName, personList) {
            var subTabId = mainTabId + '-sub-' + subTabCounter++;
            subTabsHtml += `
                <li class="nav-item" role="presentation">
                    <a class="nav-link ${subTabCounter === 1 ? 'active' : ''}" id="${subTabId}-tab" style="margin-right: 0.25rem;" data-bs-toggle="tab" href="#${subTabId}" role="tab" aria-controls="${subTabId}" aria-selected="${subTabCounter === 1 ? 'true' : 'false'}">${genderName}</a>
                </li>
            `;

            subTabContentsHtml += `
                <div class="tab-pane fade ${subTabCounter === 1 ? 'show active' : ''}" id="${subTabId}" role="tabpanel" aria-labelledby="${subTabId}-tab">
                    <table class="table datatable table-bordered table-hover" id="detailsTable_${subTabId}" width="100%">
                        <thead>
                            <tr>
                                <th scope="row" class="text-center">#</th>
                                <th class="text-center">ชื่อ-นามสกุล</th>
                                <th class="text-center">ประเภทบุคลากร</th>
                                <th class="text-center">ตำแหน่งในการบริหาร</th>
                                <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                <th class="text-center">ตำแหน่งงานเฉพาะทาง</th>
                                <th class="text-center">สถานะการทำงาน</th>
                                <th class="text-center">วันเกิด</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            `;
        });

        mainTabContentsHtml += `
            <div class="tab-pane fade ${mainTabCounter === 1 ? 'show active' : ''}" id="${mainTabId}" role="tabpanel" aria-labelledby="${mainTabId}-tab">
                <ul class="nav nav-pills" id="detailsG5-${mainTabId}-Tab" role="tablist">
                    ${subTabsHtml}
                </ul>
                <div class="tab-content mb-5 mt-3" id="detailsG5-${mainTabId}-Content">
                    ${subTabContentsHtml}
                </div>
            </div>
        `;
    });

    $('#detailsG5Tab').html(mainTabsHtml);
    $('#detailsG5TabContent').html(mainTabContentsHtml);

    // Initialize DataTables for each table after the DOM is ready
    $.each(data, function(index, group) {
        var mainTabId = 'main-tab-' + index;
        var subTabCounter = 0;
        $.each(group.genders, function(genderName, personList) {
            var subTabId = mainTabId + '-sub-' + subTabCounter++;
            
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
                { data: 'birthdate', className: 'text-center' }
            ];

            initializeDataTable('#detailsTable_' + subTabId, personList, columns);
        });
    });
}


function renderChartHRM_G5(data) {
    // Prepare data for Highcharts
    var categories = ['น้อยกว่า 30 ปี', '31 ปี - 40 ปี', '41 ปี - 50 ปี', '51 ปี - 60 ปี', '60 ปีขึ้นไป'];
    var maleData = [];
    var femaleData = [];

    // Initialize data arrays with zeros
    for (var i = 0; i < categories.length; i++) {
        maleData[i] = 0;
        femaleData[i] = 0;
    }

    // Populate data arrays with actual data
    data.forEach(function(item) {
        var index = categories.indexOf(item.age_group);
        if (item.gender_name === 'ชาย') {
            maleData[index] = parseInt(item.person_count, 10);
        } else if (item.gender_name === 'หญิง') {
            femaleData[index] = parseInt(item.person_count, 10);
        }
    });

    // Column chart for gender distribution by age groups
    Highcharts.chart('g5', {
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
        subtitle: {
            text: '',
            align: 'left'
        },
        xAxis: {
            categories: categories,
            crosshair: true,
            accessibility: {
                description: 'ช่วงอายุ'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'จำนวนคน'
            }
        },
        tooltip: {
            valueSuffix: ' คน'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'ชาย',
                data: maleData
            },
            {
                name: 'หญิง',
                data: femaleData
            }
        ]
    });
}




</script>