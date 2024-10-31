<?php

    function renderTabs($tabs) {
        foreach ($tabs as $tab){ ?>
            <li class="nav-item pr-1 pt-1 pb-1" role="presentation">
                <a class="nav-link <?php echo $tab['active'] ? 'active' : ''; ?>" style="margin-right: 0.25rem;" id="<?php echo $tab['id']; ?>" data-bs-toggle="tab" href="<?php echo $tab['href']; ?>" role="tab" aria-controls="<?php echo $tab['aria']; ?>" aria-selected="<?php echo $tab['active'] ? 'true' : 'false'; ?>">
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
            "label" => "ทั้งหมด",
            "aria" => "all",
            "active" => true,
            "subTabs" => [
                ["id" => "detailsTable_all", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "working-tab",
            "href" => "#working",
            "label" => "ปฏิบัติงานจริง",
            "aria" => "working",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_working", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "out-tab",
            "href" => "#out",
            "label" => "ลาออก",
            "aria" => "out",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_out", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน", "วันที่ออกปฏิบัติงาน"]]
            ]
        ],
        [
            "id" => "medical-tab",
            "href" => "#medical",
            "label" => "สายแพทย์",
            "aria" => "medical",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_medical", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "nurse-tab",
            "href" => "#nurse",
            "label" => "สายพยาบาล",
            "aria" => "nurse",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_nurse", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "admin-tab",
            "href" => "#admin",
            "label" => "สายบริหาร",
            "aria" => "admin",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_admin", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "support_medical-tab",
            "href" => "#support_medical",
            "label" => "สายสนับสนุนทางการแพทย์",
            "aria" => "support_medical",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_support_medical", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "technical-tab",
            "href" => "#technical",
            "label" => "สายเทคนิคและบริการ",
            "aria" => "technical",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_technical", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
            ]
        ],
        [
            "id" => "support-tab",
            "href" => "#support",
            "label" => "สายสนับสนุน",
            "aria" => "support",
            "active" => false,
            "subTabs" => [
                ["id" => "detailsTable_support", "columns" => ["#", "ชื่อ-นามสกุล", "ประเภทบุคลากร", "ตำแหน่งในการบริหาร", "ตำแหน่งปฏิบัติงาน", "ตำแหน่งงานเฉพาะทาง", "สถานะการทำงาน"]]
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


<script>
    
function getHRMCard() {
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#detailsHRMCardLabel").text("[SEE-HRM-C] รายละเอียดกราฟบุคลากร"+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_card",
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
    var cardTypes = ['all', 'working', 'out', 'medical', 'nurse', 'admin', 'support_medical', 'technical', 'support',];
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
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_card_details",
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
    var dataTables = {
        all: $('#detailsTable_all').DataTable(),
        working: $('#detailsTable_working').DataTable(),
        out: $('#detailsTable_out').DataTable(),
        medical: $('#detailsTable_medical').DataTable(),
        nurse: $('#detailsTable_nurse').DataTable(),
        admin: $('#detailsTable_admin').DataTable(),
        support_medical: $('#detailsTable_support_medical').DataTable(),
        technical: $('#detailsTable_technical').DataTable(),
        support: $('#detailsTable_support').DataTable()
    };

    // Clear existing data
    var table = dataTables[cardType];
    table.clear().draw();  // Clear and redraw the table

    // Populate DataTable
    data.forEach(function(row, index) {
        var rowData = [
            '<div class="text-center">' + (index + 1) + '</div>',
            // '<div class="text-center">' + row.hipos_id + '</div>',
            '<div class="text-start">'+ row.full_name +'</div>',
            '<div class="text-start">'+ (row.ps_hire_name ? row.ps_hire_name : "") +'</div>',
            '<div class="text-start">'+ (row.ps_admin_name ? row.ps_admin_name : "") +'</div>',
            '<div class="text-start">'+ (row.ps_alp_name ? row.ps_alp_name : "") +'</div>',
            '<div class="text-start">'+ (row.ps_spcl_name ? row.ps_spcl_name : "") +'</div>',
            '<div class="text-center">'+ (row.ps_retire_name ? row.ps_retire_name : "") +'</div>',
        ];

        // Add extra columns for "out" card type
        if (cardType === 'out') {
            rowData.push(
                '<div class="text-center">'+ row.ps_work_end_date +'</div>'
            );
        }

        table.row.add(rowData);
    });
    // Draw the updated table
    table.draw();
}

function viewCardHRMDetails(cardType) {
    populateDataTableCardHRM(cardType);
    
    // Show the modal and switch to the relevant tab
    $('#detailsHRMCard').modal('show');
    $('#detailsTab a[href="#' + cardType + '"]').tab('show');
}
</script>