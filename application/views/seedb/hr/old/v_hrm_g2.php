<?php
    // Define the main tabs and their respective sub-tabs for the second modal
    $tab = [
        [
            "id" => "g2-hire-M-tab",
            "href" => "#g2-hire-M",
            "label" => "สายแพทย์",
            "aria" => "g2-hire-M",
            "active" => true,
            "subTabs" => [
                ["id" => "g2_detailsTable_hire_M", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "g2-hire-N-tab",
            "href" => "#g2-hire-N",
            "label" => "สายพยาบาล",
            "aria" => "g2-hire-N",
            "active" => false,
            "subTabs" => [
                ["id" => "g2_detailsTable_hire_N", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "g2-hire-A-tab",
            "href" => "#g2-hire-A",
            "label" => "สายบริหาร",
            "aria" => "g2-hire-A",
            "active" => false,
            "subTabs" => [
                ["id" => "g2_detailsTable_hire_A", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "g2-hire-SM-tab",
            "href" => "#g2-hire-SM",
            "label" => "สายสนับสนุนทางการแพทย์",
            "aria" => "g2-hire-SM",
            "active" => false,
            "subTabs" => [
                ["id" => "g2_detailsTable_hire_SM", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "g2-hire-T-tab",
            "href" => "#g2-hire-T",
            "label" => "สายเทคนิคและบริการ",
            "aria" => "g2-hire-T",
            "active" => false,
            "subTabs" => [
                ["id" => "g2_detailsTable_hire_T", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "g2-hire-S-tab",
            "href" => "#g2-hire-S",
            "label" => "สายสนับสนุน",
            "aria" => "g2-hire-S",
            "active" => false,
            "subTabs" => [
                ["id" => "g2_detailsTable_hire_S", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ]
    ];

?>

<!-- Modal for detailsG2Modal -->
<div class="modal fade" id="detailsG2Modal" tabindex="-1" aria-labelledby="detailsG2ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsG2ModalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" id="detailsG2Tab" role="tablist">
                    <?php renderTabs($tab); ?>
                </ul>
                <div class="tab-content mb-5 mt-5" id="detailsG2TabContent">
                    <?php renderTabContent($tab); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function getChartHRM_G2(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#detailsG2ModalLabel").text("[SEE-HRM-G2] รายละเอียดกราฟประเภทบุคลากร"+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_G2",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            renderChartHRM_G2(data.chart);
            renderChartHRM_G2_detail(data.detail);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_G2_detail(data) {

    // Define columns for DataTables
    var columns = [
        { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
            return meta.row + 1;
        }},
        { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
        { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-start' },
        { title: "ตำแหน่งในการบริหาร", data: 'ps_admin_name', className: 'text-start' },
        { title: "ตำแหน่งปฏิบัติงาน", data: 'ps_alp_name', className: 'text-start' },
        { title: "ตำแหน่งงานเฉพาะทาง", data: 'ps_spcl_name', className: 'text-start' },
        { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' }
    ];

    // Initialize DataTables for each hire type
    data.forEach(function(detail) {
        // Initialize DataTables
        initializeDataTable('#g2_detailsTable_hire_' + detail.type, detail.person_list, columns);
    });
}



function renderChartHRM_G2(data){
    // Filter data to include only items with chart_count > 0
    let filteredData = data.filter(item => parseInt(item.chart_count) > 0);

    // Extract data for the pie chart
    let chartData = filteredData.map(item => {
        return {
            name: item.chart_name,
            y: parseInt(item.chart_count)
        };
    });

    Highcharts.chart('g2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
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
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> <br>จำนวน: <b>{point.y}</b> คน'
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
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'สัดส่วน',
            colorByPoint: true,
            data: chartData
        }]
    });
}
</script>