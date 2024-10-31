<?php

    function renderTabs($tabs) {
        foreach ($tabs as $tab){ ?>
            <li class="nav-item pr-1 pt-1 pb-1" role="presentation">
                <a class="nav-link <?php echo $tab['active'] ? 'active' : ''; ?>" style="margin-right: 10px; margin-top: 10px;" id="<?php echo $tab['id']; ?>" data-bs-toggle="tab" href="<?php echo $tab['href']; ?>" role="tab" aria-controls="<?php echo $tab['aria']; ?>" aria-selected="<?php echo $tab['active'] ? 'true' : 'false'; ?>">
                    <?php echo $tab['label']; ?>
                </a>
            </li>
        <?php }
    }

    function renderTabContent($tabs) {
        foreach ($tabs as $tab){ ?>
            <div class="tab-pane fade <?php echo $tab['active'] ? 'show active' : ''; ?>" id="<?php echo substr($tab['href'], 1); ?>" role="tabpanel" aria-labelledby="<?php echo $tab['id']; ?>">
                <?php foreach ($tab['subTabs'] as $subTab){ ?>
                    <table class="table datatable table-bordered table-hover" id="<?php echo $subTab['id']; ?>" width="100%">
                        <thead>
                            <tr>
                                <?php foreach ($subTab['columns'] as $column){ ?>
                                    <th scope="row" class="text-center"><?php echo $column; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        <?php }
    }

    // Define the main tabs and their respective sub-tabs for the first modal
    $tab = [
        [
            "id" => "all-tab",
            "href" => "#all",
            "label" => "บุคลากรทั้งหมด",
            "aria" => "all",
            "active" => true,
            "subTabs" => [
                ["id" => "detailsTable_all", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "medical-tab",
            "href" => "#medical",
            "label" => "สายแพทย์",
            "aria" => "medical",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_medical", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งงานเฉพาะทาง", "ประเภทการทำงาน", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "nurse-tab",
            "href" => "#nurse",
            "label" => "สายพยาบาล",
            "aria" => "nurse",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_nurse", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "support_medical-tab",
            "href" => "#support_medical",
            "label" => "สายสนับสนุนทางการแพทย์",
            "aria" => "support_medical",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_support_medical", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "admin-tab",
            "href" => "#admin",
            "label" => "สายบริหาร",
            "aria" => "admin",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_admin", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "technical-tab",
            "href" => "#technical",
            "label" => "สายเทคนิคและบริการ",
            "aria" => "technical",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_technical", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "สถานะการทำงาน"]]
            ]
        ]
    ];
    
?>

<?php
    // Define the main tabs and their respective sub-tabs for the second modal
    $tab_chart = [
        [
            "id" => "chart1-hire-M-tab",
            "href" => "#chart1-hire-M",
            "label" => "สายแพทย์",
            "aria" => "chart1-hire-M",
            "active" => true,
            "subTabs" => [
                ["id" => "chart1_detailsTable_hire_M", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งงานเฉพาะทาง", "ประเภทการทำงาน", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "chart1-hire-N-tab",
            "href" => "#chart1-hire-N",
            "label" => "สายพยาบาล",
            "aria" => "chart1-hire-N",
            "active" => false,
            "subTabs" => [
                ["id" => "chart1_detailsTable_hire_N", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "chart1-hire-SM-tab",
            "href" => "#chart1-hire-SM",
            "label" => "สายสนับสนุนทางการแพทย์",
            "aria" => "chart1-hire-SM",
            "active" => false,
            "subTabs" => [
                ["id" => "chart1_detailsTable_hire_SM", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "chart1-hire-A-tab",
            "href" => "#chart1-hire-A",
            "label" => "สายบริหาร",
            "aria" => "chart1-hire-A",
            "active" => false,
            "subTabs" => [
                ["id" => "chart1_detailsTable_hire_A", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "chart1-hire-T-tab",
            "href" => "#chart1-hire-T",
            "label" => "สายเทคนิคและบริการ",
            "aria" => "chart1-hire-T",
            "active" => false,
            "subTabs" => [
                ["id" => "chart1_detailsTable_hire_T", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งปฏิบัติงาน", "สถานะการทำงาน"]]
            ]
        ]
    ];

?>

<!-- Modal for detailsHRMCard -->
<div class="modal fade" id="detailsHRMCard" tabindex="-1" aria-labelledby="detailsHRMCardLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsHRMCardLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" id="detailsTab" role="tablist">
                    <?php renderTabs($tab); ?>
                </ul>
                <div class="tab-content mb-5 mt-5" id="detailsTabContent">
                    <?php renderTabContent($tab); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for details_chart_1_modal -->
<div class="modal fade" id="details_chart_1_modal" tabindex="-1" aria-labelledby="details_chart_1_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="details_chart_1_modalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" id="detailschart1Tab" role="tablist">
                    <?php renderTabs($tab_chart); ?>
                </ul>
                <div class="tab-content mb-5 mt-5" id="detailschart1TabContent">
                    <?php renderTabContent($tab_chart); ?>
                </div>
            </div>
        </div>
    </div>
</div>

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
function getChartHRM_1(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#details_chart_1_modalLabel").text("[HRM-1] รายละเอียดจำนวนบุคลากร จำแนกตามสายงาน"+ hrm_select_year_type + " พ.ศ." + year_text);
    $("#detailsG1ModalLabel").text("[HRM-1] รายละเอียดจำนวนบุคลากร จำแนกตามสายงาน"+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_1",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            renderChartHRM_1(data.chart);
            renderChartHRM_1_detail(data.detail);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_1_detail(data) {

// Initialize DataTables for each hire type
data.forEach(function(detail) {
    
    // Add "ประเภทการทำงาน" column only if type is "M"
    if (detail.type === "M") {
        var columns = [
            { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
                return meta.row + 1;
            }},
            { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
            { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-start' },
            { title: "ตำแหน่งงานเฉพาะทาง", data: 'ps_spcl_name', className: 'text-start' },
            { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' }
        ];
    }
    else{
        var columns = [
            { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
                return meta.row + 1;
            }},
            { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
            { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-start' },
            { title: "ตำแหน่งปฏิบัติงาน", data: 'ps_alp_name', className: 'text-start' },
            { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' }
        ];
    }

    // Set filterOption based on cardType
    var filterOption = [];
    if (detail.type === "M") {
        filterOption = [
            { value: '1', text: 'เต็มเวลา (Full-Time)' },
            { value: '2', text: 'บางเวลา (Part-Time)' }
        ];
    }

    initializeDataTableDashboard('#chart1_detailsTable_hire_' + detail.type, detail.person_list, columns, filterOption, 'ประเภทการทำงาน');
});
}




function renderChartHRM_1(data) {
    // แปลงข้อมูลให้เป็นรูปแบบที่ Highcharts ใช้ได้
    const formattedData = data.map(item => ({
        name: item.chart_name,
        y: parseInt(item.chart_count)
    }));

    // สร้างกราฟ
    Highcharts.chart('hrm-chart-1', {
        chart: {
            type: 'pie',
            height: 500,
            events: {
                load: function() {
                    document.getElementById('loader1').classList.add('hidden');
                    loadProcessStatus(this);

                    this.series[0].data.forEach(point => {
                        Highcharts.addEvent(point, 'legendItemClick', function() {
                            saveProcessStatus(this.series.chart);
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
        colors: ['#00BCD4', '#18a1a1', '#9866ff', '#E91E63', '#3c5e6e'], // สีสดใส
        series: [{
            name: 'บุคลากร',
            data: formattedData
        }],
        credits: {
            enabled: false
        }
    });
}

function getHRMCard_1() {
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#detailsHRMCardLabel").text("[SEE-HRM-C] รายละเอียดกราฟบุคลากร"+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_1_card",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            // Update the HTML elements with the received data
            data.forEach(function(card) {
                var cardCount = card.card_count;
                var cardType = card.card_type;

                // Update the respective card
                $('#card_' + cardType + ' .card-body h6').text(cardCount + ' คน');
            });
            loadHRMCardType();
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}

function loadHRMCardType() {
    var cardTypes = ['all', 'medical', 'nurse', 'admin', 'support_medical', 'technical'];
    cardTypes.forEach(function(cardType) {
        renderHRMCard_detail(cardType, function(data) {
            fetchedData[cardType] = data;
        });
    });

    $('[data-toggle="tooltip"]').tooltip();
}


function renderHRMCard_detail(cardType, callback) {
    var ums_dp_select = document.getElementById('hrm_select_ums_department').value;
    var year_select = document.getElementById('hrm_select_year').value;
    var year_type_select = $('#hrm_select_year_type').val();
    // var month_select = document.getElementById('hrm_select_month').value;

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_1_card_details",
        type: 'GET',
        data: {
            dp_id: ums_dp_select,
            year: year_select,
            year_type: year_type_select,
            card_type: cardType
        },
        success: function(data) {
            data = JSON.parse(data);
            if (typeof callback === 'function') {
                callback(data);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}

function populateDataTableCardHRM(cardType) {
    var data = fetchedData[cardType];
    // var columns = [
    //     { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) { return meta.row + 1; } },
    //     { title: "ชื่อ-นามสกุล", data: "full_name", className: 'text-start' },
    //     { title: "ประเภทบุคลากร", data: "ps_hire_name", className: 'text-start' },
    //     // { title: data: "ps_admin_name", className: 'text-start' },
    //     { title: "ตำแหน่งปฏิบัติงาน", data: "ps_alp_name", className: 'text-start' },
    //     { title: "ตำแหน่งงานเฉพาะทาง", data: "ps_spcl_name", className: 'text-start' },
    //     { title: "สถานะการทำงาน", data: "ps_retire_name", className: 'text-center' }
    // ];

     // Add "ประเภทการทำงาน" column only if type is "medical"
     if (cardType === "medical") {
        var columns = [
            { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
                return meta.row + 1;
            }},
            { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
            { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-start' },
            { title: "ตำแหน่งงานเฉพาะทาง", data: 'ps_spcl_name', className: 'text-start' },
            { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' }
        ];
    }
    else{
        var columns = [
            { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
                return meta.row + 1;
            }},
            { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
            { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-start' },
            { title: "ตำแหน่งปฏิบัติงาน", data: 'ps_alp_name', className: 'text-start' },
            { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' }
        ];
    }

    // Set filterOption based on cardType
    var filterOption = [];
    if (cardType == "medical") {
        filterOption = [
            { value: '1', text: 'เต็มเวลา (Full-Time)' },
            { value: '2', text: 'บางเวลา (Part-Time)' }
        ];
    } else {
        filterOption = [];
    }

    initializeDataTableDashboard('#detailsTable_' + cardType, data, columns, filterOption, 'ประเภทการทำงาน');    //v_seedb_hr
    
}

function viewCardHRMDetails(cardType) {
    populateDataTableCardHRM(cardType);
    
    // Show the modal and switch to the relevant tab
    $('#detailsHRMCard').modal('show');
    $('#detailsTab a[href="#' + cardType + '"]').tab('show');
}



</script>