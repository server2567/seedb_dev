<!-- Modal for details_chart_4_modal -->
<div class="modal fade" id="details_chart_4_modal" tabindex="-1" aria-labelledby="details_chart_4_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="details_chart_4_modalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills d-flex" id="details_chart_4_Tab" role="tablist">
                    <!-- Main tabs will be dynamically generated here -->
                </ul>
                <div class="tab-content mb-5 mt-5" id="details_chart_4_TabContent">
                    <!-- Sub-tabs and tables will be dynamically generated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getChartHRM_4(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#details_chart_4_modalLabel").text("[HRM-4] รายละเอียดสายงานจำนวนแพทย์ และพยาบาลที่อยู่ในแผนก "+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_4",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            renderChartHRM_chart_4(data.chart);
            renderChartHRM_chart_4_detail(data.chart);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_chart_4_detail(data) {
    if (!Array.isArray(data)) {
        return;
    }

    const columns = [
        { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
            return meta.row + 1;
        }},
        { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
        { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-center' },
        // { title: "ตำแหน่งในการบริหาร", data: 'ps_admin_name', className: 'text-start' },
        { title: "ตำแหน่งปฏิบัติงาน", data: 'ps_alp_name', className: 'text-start' },
        { title: "ตำแหน่งงานเฉพาะทาง", data: 'ps_spcl_name', className: 'text-start' },
        { title: "ฝ่าย/แผนก", data: 'stde_name_position', className: 'text-start' },
        { title: "ประเภทสายงาน", data: 'hire_is_medical_label', className: 'text-center' },
        { title: "ประเภทการทำงาน", data: 'hire_type_label', className: 'text-center' },
        { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' },
    ];

    $('#details_chart_4_Tab').empty();
    $('#details_chart_4_TabContent').empty();

    data.forEach((detail, index) => {

        // ตรวจสอบว่า `chart_detail` มีค่าและเป็น array หรือไม่
        const chartDetail = Array.isArray(detail.structure_person) ? detail.structure_person : [];

        // สร้างตัวเลือกการกรองสำหรับฝ่าย/แผนก, สายงาน, และประเภทการทำงาน
        const filterOption = [];

        chartDetail.forEach(person => {

            // Filter for work type (สายงาน)
            filterOption.push({
                type: 'hire_is_medical',
                value: person.hire_is_medical,
                text: person.hire_is_medical_label
            });

            // Filter for employment type (ประเภทการทำงาน)
            filterOption.push({
                type: 'hire_type',
                value: person.hire_type,
                text: person.hire_type_label
            });
        });
        

        // Remove duplicates from filterOption
        const uniqueFilterOptions = filterOption.filter((option, index, self) =>
            index === self.findIndex((t) => (
                t.value === option.value && t.type === option.type
            ))
        );

        // Create a unique ID for each tab and table
        const tabId = `hrm_4_tab_${index}`;
        const tableId = `hrm_4_table_${index}`;

        $('#details_chart_4_Tab').append(`
            <li class="nav-item">
                <a class="nav-link ${index === 0 ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="pill" href="#${tabId}" role="tab" aria-controls="${tabId}" aria-selected="${index === 0 ? 'true' : 'false'}" style="margin-right: 10px; margin-top: 10px;">
                    ${detail.chart_name}
                </a>
            </li>
        `);

        $('#details_chart_4_TabContent').append(`
            <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                <table id="${tableId}" class="table datatable table-bordered table-hover" width="100%"></table>
            </div>
        `);

        // ตรวจสอบว่ามีข้อมูลใน `chartDetail` และรวมข้อมูลบุคลากร
        const personData = chartDetail.flatMap(item => item ? item : []);

        // Initialize DataTable with the relevant data and filter options
        initializeDataTableDashboard_HRM4(`#${tableId}`, personData, columns, uniqueFilterOptions, 'สายงาน');
    });
}



function initializeDataTableDashboard_HRM4(selector, data, columns, filterOption = [], filterTopic = '') {
    $(selector).each(function() {
        var $table = $(this);

        if ($.fn.DataTable.isDataTable($table)) {
            $table.DataTable().clear().destroy();
        }

        var tableColumns = columns.slice();

        // Add hidden columns for filtering when filterTopic is 'สายงาน'
        if (filterTopic === 'สายงาน') {
            tableColumns.unshift({ title: "แผนก", data: "stde_id", visible: false });
            tableColumns.unshift({ title: "สายงาน", data: "hire_is_medical", visible: false });
            tableColumns.unshift({ title: "ประเภทการทำงาน", data: "hire_type", visible: false });
        }

        var table = $table.DataTable({
            data: data,
            columns: tableColumns,
            order: [[3, 'asc']],
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
            dom: '<"dt-container"<"dt-length"l><"dt-buttons"B><"dt-filter"><"dt-search"f>>tip',
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
                // Set attributes for filtering if filterTopic == 'สายงาน'
                if (filterTopic === 'สายงาน') {
                    $(row).attr('data-hire-id', data.stde_id);
                    $(row).attr('data-hire-is-medical', data.hire_is_medical);
                    $(row).attr('data-hire-type', data.hire_type);
                }
                $(row).attr('data-seq', dataIndex + 1);
            },
            initComplete: function() {
                var api = this.api();

                // If filterTopic is 'สายงาน', set up filters
                if (filterTopic === 'สายงาน') {
                    $table.closest('.dt-container').css('justify-content', 'space-between');

                    var filterWrapper = $('<div class="filter-wrapper" style="display: flex; gap: 10px; width: 100%;"></div>')
                        .appendTo($table.closest('.dt-container').find('.dt-filter'));

                    // Filter for "สายงาน"
                    var selectIdWorkType = $table.attr('id') + '-worktype-filter';
                    var $selectWorkType = $('<select id="' + selectIdWorkType + '" class="form-select select2" style="width: 100%;" data-placeholder="-- สายงาน --"><option value="0">เลือกสายงานทั้งหมด</option></select>')
                        .appendTo(filterWrapper);

                    filterOption.filter(option => option.type === 'hire_is_medical').forEach(function(option) {
                        $selectWorkType.append('<option value="' + option.value + '">' + option.text + '</option>');
                    });

                    initializeSelect2('#' + selectIdWorkType);

                    $selectWorkType.on('change', function() {
                        var val = $(this).val();
                        if (val === '0' || val === 0) {
                            api.column(1).search('').draw();
                        } else {
                            api.column(1).search('^' + val + '$', true, false).draw();
                        }
                        updateFilteredInfo(api);
                    });

                    // Filter for "ประเภทการทำงาน"
                    var selectIdEmploymentType = $table.attr('id') + '-employmenttype-filter';
                    var $selectEmploymentType = $('<select id="' + selectIdEmploymentType + '" class="form-select select2" style="width: 100%;" data-placeholder="-- ประเภทการทำงาน --"><option value="0">เลือกประเภทการทำงานทั้งหมด</option></select>')
                        .appendTo(filterWrapper);

                    filterOption.filter(option => option.type === 'hire_type').forEach(function(option) {
                        $selectEmploymentType.append('<option value="' + option.value + '">' + option.text + '</option>');
                    });

                    initializeSelect2('#' + selectIdEmploymentType);

                    $selectEmploymentType.on('change', function() {
                        var val = $(this).val();
                        if (val === '0' || val === 0) {
                            api.column(0).search('').draw();
                        } else {
                            api.column(0).search('^' + val + '$', true, false).draw();
                        }
                        updateFilteredInfo(api);
                    });
                }

                api.on('draw', function() {
                    if (api.rows({ filter: 'applied' }).data().length === 0) {
                        $table.closest('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
                    }
                    updateFilteredInfo(api);
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

        // Adjust CSS for the DataTable container if filterOption is provided
        if (filterTopic === 'สายงาน') {
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
    });
}




function renderChartHRM_chart_4(data) {
  
    // สร้างข้อมูลตามประเภท FT, PT, และ พยาบาล
    let chartData = [];

    if (data && data.length > 0) {  // Check if data is not null and not empty

        data.forEach(department => {
            let ftCount = 0;
            let ptCount = 0;
            let nurseCount = 0;
            
            let ftStaff = [];
            let ptStaff = [];
            let nurseStaff = [];

            department.structure_person.forEach(person => {
                if (person.hire_is_medical === 'M') {
                    if (person.hire_type === "1") {
                        ftCount++;
                        ftStaff.push(person.full_name);
                    } else if (person.hire_type === "2") {
                        ptCount++;
                        ptStaff.push(person.full_name);
                    }
                } else if (person.hire_is_medical === 'N') {
                    nurseCount++;
                    nurseStaff.push(person.full_name);
                }
            });

            if (ftCount > 0) {
                chartData.push({
                    id: `fulltime_${department.stde_id}`,
                    name: `FT : ${ftCount} คน`,
                    parent: `department_${department.stde_id}`,
                    value: ftCount,
                    color: '#7cb5ec',
                    events: {
                        click: function() {
                            $('#doctorList').html(ftStaff.map(name => `<p>${name}</p>`).join(''));
                            $('#doctorModalLabel').text('รายชื่อแพทย์ (เต็มเวลา)');
                            $('#doctorModal').modal('show');
                        }
                    }
                });
            }

            if (ptCount > 0) {
                chartData.push({
                    id: `parttime_${department.stde_id}`,
                    name: `PT : ${ptCount} คน`,
                    parent: `department_${department.stde_id}`,
                    value: ptCount,
                    color: '#434348',
                    events: {
                        click: function() {
                            $('#doctorList').html(ptStaff.map(name => `<p>${name}</p>`).join(''));
                            $('#doctorModalLabel').text('รายชื่อแพทย์ (บางเวลา)');
                            $('#doctorModal').modal('show');
                        }
                    }
                });
            }

            if (nurseCount > 0) {
                chartData.push({
                    id: `nurse_${department.stde_id}`,
                    name: `พยบ. : ${nurseCount} คน`,
                    parent: `department_${department.stde_id}`,
                    value: nurseCount,
                    color: '#90ed7d',
                    events: {
                        click: function() {
                            $('#doctorList').html(nurseStaff.map(name => `<p>${name}</p>`).join(''));
                            $('#doctorModalLabel').text('รายชื่อพยาบาล');
                            $('#doctorModal').modal('show');
                        }
                    }
                });
            }

            chartData.push({
                id: `department_${department.stde_id}`,
                name: `${department.chart_name} : ${ftCount + ptCount + nurseCount} คน`,
                value: ftCount + ptCount + nurseCount,
                color: '#f7a35c'
            });
        });

    }

    // สีสำหรับแสดงผลสูงสุดถึง 10 สี
    const colors = [
        '#7cb5ec', // Blue
        '#434348', // Dark Grey
        '#90ed7d', // Light Green
        '#f7a35c', // Orange
        '#8085e9', // Purple
        '#f15c80', // Pink
        '#e4d354', // Yellow
        '#2b908f', // Turquoise
        '#f45b5b', // Red
        '#91e8e1'  // Light Blue
    ];

    // Render Chart
    Highcharts.chart('hrm-chart-4', {
        chart: {
            style: {
                fontSize: '16px'
            }
        },
        colors: colors,
        series: [{
            type: 'treemap',
            layoutAlgorithm: 'squarified',
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '16px'
                }
            },
            levels: [{
                level: 1,
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    verticalAlign: 'top',
                    style: {
                        fontSize: '16px'
                    }
                },
                borderWidth: 3
            }, {
                level: 2,
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    verticalAlign: 'middle',
                    style: {
                        color: '#0022ff',
                        fontSize: '14px',
                        cursor: 'pointer'
                    }
                }
            }],
            data: chartData
        }],
        title: {
            text: 'แพทย์เต็มเวลา = "FT" (Full-time) และ แพทย์บางเวลา = "PT" (Part-time)',
            style: {
                fontSize: '16px'
            }
        }
    });
}




</script>