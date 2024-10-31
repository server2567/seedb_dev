<!-- Modal for detailsG1Modal -->
<div class="modal fade" id="detailsG1Modal" tabindex="-1" aria-labelledby="detailsG1ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsG1ModalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs d-flex" id="detailsG1Tab" role="tablist">
                    <!-- Main tabs will be dynamically generated here -->
                </ul>
                <div class="tab-content mb-5 mt-5" id="detailsG1TabContent">
                    <!-- Sub-tabs and tables will be dynamically generated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function getChartHRM_G1(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#detailsG1ModalLabel").text("[SEE-HRM-G1] รายละเอียดกราฟแสดงบุคลากรสายแพทย์และสายพยาบาลจำแนกตามแผนก"+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_G1",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            renderChartHRM_G1(data.chart);
            renderChartHRM_G1_detail(data.detail);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_G1_detail(data) {
    var mainTabsHtml = '';
    var subTabsHtml = '';
    var mainTabCounter = 0;

    // Iterate over each department to create main tabs and sub-tabs
    data.forEach(department => {
        var mainTabId = 'tab-' + mainTabCounter++;
        mainTabsHtml += `
            <li class="nav-item" role="presentation">
                <a class="nav-link ${mainTabCounter === 1 ? 'active' : ''}" id="${mainTabId}-tab" data-bs-toggle="tab" href="#${mainTabId}" role="tab" aria-controls="${mainTabId}" aria-selected="${mainTabCounter === 1 ? 'true' : 'false'}">${department.stde_name}</a>
            </li>
        `;

        var subTabs = '';
        var subTabContents = '';
        var subTabCounter = 0;

        // Create sub-tabs for each hire group
        Object.keys(department.hire_groups).forEach(hireType => {
            var hireName = hireType === 'M' ? 'สายแพทย์' : hireType === 'N' ? 'สายพยาบาล' : 'สายสนับสนุน';
            var subTabId = mainTabId + '-' + subTabCounter++;
            subTabs += `
                <li class="nav-item" role="presentation">
                    <a class="nav-link ${subTabCounter === 1 ? 'active' : ''}" id="${subTabId}-tab" style="margin-right: 0.25rem;" data-bs-toggle="tab" href="#${subTabId}" role="tab" aria-controls="${subTabId}" aria-selected="${subTabCounter === 1 ? 'true' : 'false'}">${hireName}</a>
                </li>
            `;

            subTabContents += `
                <div class="tab-pane fade ${subTabCounter === 1 ? 'show active' : ''}" id="${subTabId}" role="tabpanel" aria-labelledby="${subTabId}-tab">
                    <table class="table datatable table-bordered table-hover" id="detailsTable_g1_${subTabId}" width="100%">
                        <thead>
                            <tr>
                                <th scope="row" class="text-center">#</th>
                                <th class="text-center">ชื่อ-นามสกุล</th>
                                <th class="text-center">ประเภทบุคลากร</th>
                                <th class="text-center">ตำแหน่งในการบริหาร</th>
                                <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                <th class="text-center">ตำแหน่งงานเฉพาะทาง</th>
                                <th class="text-center">แผนก</th>
                                <th class="text-center">สถานะการทำงาน</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            `;
        });

        subTabsHtml += `
            <div class="tab-pane fade ${mainTabCounter === 1 ? 'show active' : ''}" id="${mainTabId}" role="tabpanel" aria-labelledby="${mainTabId}-tab">
                <ul class="nav nav-pills" id="detailsG1-${mainTabId}-Tab" role="tablist">
                    ${subTabs}
                </ul>
                <div class="tab-content mb-5 mt-3" id="detailsG1-${mainTabId}-Content">
                    ${subTabContents}
                </div>
            </div>
        `;
    });

    $('#detailsG1Tab').html(mainTabsHtml);
    $('#detailsG1TabContent').html(subTabsHtml);

    // Initialize DataTables for each tab and subtab
    var initializedTabs = [];
    data.forEach((department, departmentIndex) => {
        var mainTabId = 'tab-' + departmentIndex;
        initializedTabs.push(mainTabId);

        var subTabCounter = 0;

        Object.keys(department.hire_groups).forEach(hireType => {
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
                { data: 'ps_stde_name', className: 'text-start' },
                { data: 'ps_retire_name', className: 'text-center' }
            ];

            var personData = department.hire_groups[hireType];

            initializeDataTable('#detailsTable_g1_' + subTabId, personData, columns);
        });
    });
}


function renderChartHRM_G1(data) {
    let categories = [];
    let seriesData = {
        'M': [],
        'N': [],
        'S': []
    };

    data.forEach(department => {
        categories.push(department.stde_name);
        let counts = {'M': 0, 'N': 0, 'S': 0};
        department.hire_list.forEach(hire => {
            counts[hire.hire_is_medical] = parseInt(hire.hire_person_count);
        });
        seriesData['M'].push(counts['M']);
        seriesData['N'].push(counts['N']);
        seriesData['S'].push(counts['S']);
    });

    Highcharts.chart('g1', {
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
            categories: categories,
            labels: {
                style: {
                    fontSize: '16px' // Set font size for x-axis labels
                }
            }
        },
        yAxis: {
            min: 0,
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
                let points = this.points;
                let total = 0;

                points.forEach(point => {
                    total += point.y;
                });

                let tooltip = `<b>${points[0].key}</b><br/>`;

                points.forEach(point => {
                    tooltip += `${point.series.name}: ${point.y.toFixed(0)} คน<br/>`;
                });

                tooltip += `ทั้งหมด: ${total.toFixed(0)} คน`;
                return tooltip;
            }
        },
        credits: {
            enabled: false
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
                name: 'สายแพทย์',
                data: seriesData['M']
            },
            {
                name: 'สายพยาบาล',
                data: seriesData['N']
            }
        ]
    });
}

</script>