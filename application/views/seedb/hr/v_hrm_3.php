<!-- Modal for details_chart_3_Modal -->
<div class="modal fade" id="details_chart_3_Modal" tabindex="-1" aria-labelledby="details_chart_3_ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="details_chart_3_ModalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills d-flex" id="details_chart_3_Tab" role="tablist">
                    <!-- Main tabs will be dynamically generated here -->
                </ul>
                <div class="tab-content mb-5 mt-5" id="details_chart_3_TabContent">
                    <!-- Sub-tabs and tables will be dynamically generated here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function getChartHRM_3(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#details_chart_3_ModalLabel").text("[HRM-3] รายละเอียดรายงานอายุการทำงานของบุคลากร จำแนกตามฝ่าย "+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_3",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);
            renderChartHRM_3(data.chart);
            renderChartHRM_3_detail(data.chart);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header, 
                'body': text_toast_default_error_body
            });
        }
    });
}

function renderChartHRM_3_detail(data) {
    if (!Array.isArray(data)) {
        return;
    }

    const columns = [
        { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
            return meta.row + 1;
        }},
        { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
        { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-start' },
        // { title: "ตำแหน่งในการบริหาร", data: 'ps_admin_name', className: 'text-start' },
        { title: "ตำแหน่งปฏิบัติงาน", data: 'ps_alp_name', className: 'text-start' },
        { title: "ตำแหน่งงานเฉพาะทาง", data: 'ps_spcl_name', className: 'text-start' },
        { title: "ฝ่าย/แผนก", data: 'stde_name_position', className: 'text-start' },
        { title: "อายุการทำงาน", data: 'tenure_display', className: 'text-center' }, // เพิ่มคอลัมน์สำหรับอายุการทำงานในรูปแบบ ปี เดือน
        { title: "วันที่เริ่มทำงาน", data: 'hipos_pos_work_start_date_text', className: 'text-center' },
        { title: "วันที่ออกทำงาน", data: 'hipos_pos_work_end_date_text', className: 'text-center' },
        { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' }
    ];

    // ลบเนื้อหาก่อนหน้าใน modal
    $('#details_chart_3_Tab').empty();
    $('#details_chart_3_TabContent').empty();

    // หมวดหมู่อายุงาน
    const tenureCategories = {
        1: '0-1 ปี',
        2: '1-3 ปี',
        3: '3-4 ปี',
        4: '5+ ปี'
    };

    data.forEach((detail, index) => {
        if (!Array.isArray(detail.chart_detail)) {
            return;
        }

        const filterOption = [];
        // สร้างตัวเลือกการกรองสำหรับฝ่าย/แผนก
        detail.chart_detail.forEach(item => {
            filterOption.push({
                type: 'department',
                value: item.stde_id,
                text: item.chart_name
            });
        });

        // สร้าง ID เฉพาะสำหรับแต่ละแท็บและตาราง
        const tabId = `tab_chart_3_${index}`;
        const tableId = `table_chart_3_${index}`;

        // เพิ่มแท็บใหม่สำหรับหมวดหมู่ระดับ 3
        $('#details_chart_3_Tab').append(`
            <li class="nav-item">
                <a class="nav-link ${index === 0 ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="pill" href="#${tabId}" role="tab" aria-controls="${tabId}" aria-selected="${index === 0 ? 'true' : 'false'}" style="margin-right: 10px; margin-top: 10px;">
                    ${detail.chart_name}
                </a>
            </li>
        `);

        // เพิ่มเนื้อหาแท็บที่สอดคล้องกัน
        $('#details_chart_3_TabContent').append(`
            <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                <table id="${tableId}" class="table datatable table-bordered table-hover" width="100%"></table>
            </div>
        `);

        // แปลง array ของ structure_person ในแต่ละ chart_detail เป็นข้อมูลแบบเรียบ
        const personData = detail.chart_detail.flatMap(item => {
            return item.structure_person.map(person => {
                const startDate = new Date(person.hipos_pos_work_start_date);
                let endDate = person.hipos_pos_work_end_date ? new Date(person.hipos_pos_work_end_date) : new Date();

                // คำนวณจำนวนปีและเดือน
                let totalMonths = (endDate.getFullYear() - startDate.getFullYear()) * 12 + (endDate.getMonth() - startDate.getMonth());
                if (totalMonths < 0) totalMonths = 0; // ป้องกันค่าติดลบ

                const years = Math.floor(totalMonths / 12); // คำนวณจำนวนปี
                const months = totalMonths % 12; // คำนวณจำนวนเดือนที่เหลือ

                // Build the display string conditionally
                let tenureDisplay = '';

                if (years > 0) {
                    tenureDisplay += `${years} ปี `;
                }

                if (months > 0) {
                    tenureDisplay += `${months} เดือน`;
                }

                // If both years and months are zero, you may want to handle it as well
                if (tenureDisplay === '') {
                    tenureDisplay = '0 เดือน'; // Or some other default value
                }

                let tenureCategoryId = 1; // ค่าเริ่มต้นสำหรับ '0-1 ปี'
                if (years > 1 && years <= 3) {
                    tenureCategoryId = 2;
                } else if (years > 3 && years <= 4) {
                    tenureCategoryId = 3;
                } else if (years > 4) {
                    tenureCategoryId = 4;
                }

                return {
                    ...person,
                    tenure_category_id: tenureCategoryId,
                    tenure_display: tenureDisplay, // เพิ่มอายุการทำงานที่คำนวณแล้ว
                    stde_name_th: item.chart_name // เพิ่มชื่อแผนก
                };
            });
        });

        // เพิ่มข้อมูลสำหรับ "ช่วงอายุงาน"
        Object.keys(tenureCategories).forEach(tenureCategoryId => {
            filterOption.push({
                type: 'tenure',
                value: parseInt(tenureCategoryId),
                text: tenureCategories[tenureCategoryId]
            });
        });

        // เริ่มต้น DataTable พร้อมกับข้อมูลที่เกี่ยวข้อง
        initializeDataTableDashboard_HRM3(`#${tableId}`, personData, columns, filterOption, 'อายุการทำงาน');
    });
}



function initializeDataTableDashboard_HRM3(selector, data, columns, filterOption = [], filterTopic = '') {

    $(selector).each(function() {
        var $table = $(this);

        if ($.fn.DataTable.isDataTable($table)) {
            $table.DataTable().clear().destroy();
        }

        var tableColumns = columns.slice();

        // เฉพาะกรณี filterTopic == 'อายุการทำงาน'
        if (filterTopic === 'อายุการทำงาน') {
            tableColumns.unshift({ title: "ฝ่าย", data: "stde_id", visible: false });
            tableColumns.unshift({ title: "อายุการทำงาน", data: "tenure_category_id", visible: false });
        }

        var table = $table.DataTable({
            data: data,
            columns: tableColumns,
            order: [[2, 'asc']],
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
                // กำหนด attribute สำหรับการกรองในกรณี filterTopic == 'อายุการทำงาน'
                if (filterTopic === 'อายุการทำงาน') {
                    $(row).attr('data-stde-id', data.stde_id);
                    $(row).attr('data-tenure-category', data.tenure_category_id);
                }
                $(row).attr('data-seq', dataIndex + 1);
            },
            initComplete: function() {
                var api = this.api();

                // เฉพาะกรณี filterTopic == 'อายุการทำงาน'
                if (filterTopic === 'อายุการทำงาน') {
                    $table.closest('.dt-container').css('justify-content', 'space-between');

                    var filterWrapper = $('<div class="filter-wrapper" style="display: flex; gap: 10px; width: 100%;"></div>')
                        .appendTo($table.closest('.dt-container').find('.dt-filter'));

                    // Filter for "ฝ่าย"
                    var selectIdDepartment = $table.attr('id') + '-department-filter';
                    var $selectDepartment = $('<select id="' + selectIdDepartment + '" class="form-select select2" style="width: 100%;" data-placeholder="-- เลือก --"><option value="0">เลือกทั้งหมด</option></select>')
                        .appendTo(filterWrapper);

                    filterOption.forEach(function(option) {
                        if (option.type === 'department') {
                            $selectDepartment.append('<option value="' + option.value + '">' + option.text + '</option>');
                        }
                    });

                    initializeSelect2('#' + selectIdDepartment);

                    $selectDepartment.on('change', function() {
                        var val = $(this).val();
                        if (val === '0' || val === 0) {
                            api.column(1).search('').draw();
                        } else {
                            api.column(1).search('^' + val + '$', true, false).draw();
                        }
                        updateFilteredInfo(api);
                    });

                    // Filter for "อายุการทำงาน"
                    var selectIdTenure = $table.attr('id') + '-tenure-filter';
                    var $selectTenure = $('<select id="' + selectIdTenure + '" class="form-select select2" style="width: 100%;" data-placeholder="-- อายุการทำงาน --"><option value="0">เลือกอายุการทำงานทั้งหมด</option></select>')
                        .appendTo(filterWrapper);

                    filterOption.forEach(function(option) {
                        if (option.type === 'tenure') {
                            $selectTenure.append('<option value="' + option.value + '">' + option.text + '</option>');
                        }
                    });

                    initializeSelect2('#' + selectIdTenure);

                    $selectTenure.on('change', function() {
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

        // ถ้ามี filterOption ให้ปรับแต่ง CSS สำหรับ DataTable container
        if (filterOption.length > 0 && filterTopic === 'อายุการทำงาน') {
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

function renderChartHRM_3(data){
    const departments = data.map(department => department.chart_name);
    departments.push('รวม'); // เพิ่มช่องสำหรับผลรวม
    const tenureCategories = ['0-1 ปี', '1-3 ปี', '3-4 ปี', '5+ ปี'];

    const heatmapData = [];

    // กำหนดค่าเริ่มต้นเป็น 0 สำหรับทุกตำแหน่งใน Heatmap
    departments.forEach((dept, deptIndex) => {
        tenureCategories.forEach((tenure, tenureIndex) => {
            heatmapData.push([deptIndex, tenureIndex, 0]);
        });
    });

    const currentYear = new Date().getFullYear();

    data.forEach((departmentData, deptIndex) => {
        departmentData.chart_detail.forEach(section => {
            section.structure_person.forEach(person => {
                const startDate = new Date(person.hipos_pos_work_start_date);
                let endDate = person.hipos_pos_work_end_date ? new Date(person.hipos_pos_work_end_date) : null;

                // ถ้า endDate คือ null หรือเป็น '9999-12-31' ให้ใช้วันที่ปัจจุบันแทน
                if (!endDate || person.hipos_pos_work_end_date === '9999-12-31') {
                    endDate = new Date();
                }

                let tenureGroup = '';
                let tenure = endDate.getFullYear() - startDate.getFullYear();

                // กรณีวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นหรือไม่ถูกต้อง ให้จัดกลุ่มใน 0-1 ปี
                if (tenure < 0 || !startDate || !endDate) {
                    tenureGroup = '0-1 ปี';
                    tenure = 0;  // กำหนดค่าอายุการทำงานเป็น 0 สำหรับกรณีนี้
                } else {
                    if (tenure <= 1) {
                        tenureGroup = '0-1 ปี';
                    } else if (tenure <= 3) {
                        tenureGroup = '1-3 ปี';
                    } else if (tenure <= 4) {
                        tenureGroup = '3-4 ปี';
                    } else {
                        tenureGroup = '5+ ปี';
                    }
                }

                const tenureIndex = tenureCategories.indexOf(tenureGroup);

                if (tenureIndex > -1) {
                    // เพิ่มค่าในตำแหน่งที่ตรงกันของแผนก
                    heatmapData.forEach(point => {
                        if (point[0] === deptIndex && point[1] === tenureIndex) {
                            point[2] += 1;
                        }
                    });

                    // เพิ่มค่าในตำแหน่งที่ตรงกันของผลรวม
                    heatmapData.forEach(point => {
                        if (point[0] === departments.length - 1 && point[1] === tenureIndex) {
                            point[2] += 1;
                        }
                    });
                }
            });
        });
    });

    Highcharts.chart('hrm-chart-3', {
        chart: {
        type: 'heatmap',
        marginTop: 40,
        marginBottom: 120,
        plotBorderWidth: 1,
        events: {
          load: function() {
            // ซ่อนตัวโหลดเมื่อกราฟโหลดเสร็จ
            document.getElementById('loader3').classList.add('hidden');
          }
        }
      },
        title: {
            text: ''
        },
        xAxis: {
            categories: departments,
            labels: {
                style: {
                    fontSize: '14px'
                }
            }
        },
        yAxis: {
            categories: tenureCategories,
            title: null,
            labels: {
                style: {
                    fontSize: '14px'
                }
            }
        },
        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: '#4BC0C0',
            labels: {
                format: '{value} คน'
            }
        },
        legend: {
          
            align: 'right',
            layout: 'vertical',
            margin: 0,
            verticalAlign: 'top',
            y: 25,
            symbolHeight: 280
        },
        tooltip: {
            formatter: function() {
                return '<b>' + this.series.xAxis.categories[this.point.x] + '</b><br><b>' +
                    this.point.value + ' คน</b><br><b>' + this.series.yAxis.categories[this.point.y] + '</b>';
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            var drilldownKey = this.x + '-' + this.y;
                            // if (employeeData[drilldownKey]) {
                            //     var department = this.series.xAxis.categories[this.x];
                            //     var tenure = this.series.yAxis.categories[this.y];
                            //     showModal(employeeData[drilldownKey], department, tenure);
                            // }
                        }
                    }
                }
            }
        },
        series: [{
            name: 'อายุการทำงาน',
            borderWidth: 1,
            data: heatmapData,
            dataLabels: {
                enabled: true,
                color: '#000000',
                style: {
                    fontSize: '14px'
                },
                formatter: function() {
                    return this.point.value;
                }
            }
        }]
    });
}






function renderChartHRM_chart_3_detail(data){
   
}

</script>