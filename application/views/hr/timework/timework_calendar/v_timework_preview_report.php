<style>
    .space-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
<div class="card mt-2">
    <div class="accordion">
        <!-- Accordion สำหรับค้นหารายชื่อบุคลากร -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="get">

                        <!-- หน่วยงาน -->
                        <div class="col-md-3">
                            <label for="filter_report_select_dp_id" class="form-label">หน่วยงาน</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="filter_report_select_dp_id" id="filter_report_select_dp_id" onchange="get_report_stucture(value)">
                                <?php foreach ($base_ums_department_list as $key => $row) { ?>
                                    <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- สายปฏิบัติงาน -->
                        <div class="col-md-3">
                            <label for="filter_report_select_hire_is_medical" class="form-label">สายปฏิบัติงาน</label>
                            <select class="form-select select2" name="filter_report_select_hire_is_medical" id="filter_report_select_hire_is_medical">
                                <?php
                                    // Assuming $hire_is_medical is already available as an array
                                    $medical_types = [
                                        'M'  => 'สายการแพทย์',
                                        'N'  => 'สายการพยาบาล',
                                        'SM' => 'สายสนับสนุนทางการแพทย์',
                                        'T'  => 'สายเทคนิคและบริการ',
                                        'A'  => 'สายบริหาร'
                                    ];

                                    // Loop through hire_is_medical and display corresponding options
                                    foreach ($this->session->userdata('hr_hire_is_medical') as $value) {
                                        $type = $value['type'];
                                        if (isset($medical_types[$type])) {
                                            echo '<option value="' . $type . '">' . $medical_types[$type] . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <!-- ประเภทการทำงาน -->
                        <div class="col-md-3">
                            <label for="filter_report_select_hire_type" class="form-label">ประเภทการทำงาน</label>
                            <select class="form-select select2" name="filter_report_select_hire_type" id="filter_report_select_hire_type">
                                <option value="all">ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานเต็มเวลา (Full-Time)</option>
                                <option value="2">ปฏิบัติงานบางเวลา (Part-Time)</option>
                            </select>
                        </div>

                        <!-- สถานะการทำงาน -->
                        <div class="col-md-3">
                            <label for="filter_report_select_status_id" class="form-label">สถานะการทำงาน</label>
                            <select class="form-select select2" id="filter_report_select_status_id" name="filter_report_select_status_id">
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานอยู่</option>
                                <option value="2">ออกจากการปฏิบัติงาน</option>
                            </select>
                        </div>

                        <!-- โครงสร้างหน่วยงาน -->
                        <div class="col-md-3" id="div_filter_report_select_stuc_id">
                            <label for="filter_report_select_stuc_id" class="form-label">โครงสร้างหน่วยงาน</label>
                            <select class="form-select select2" name="filter_report_select_stuc_id" id="filter_report_select_stuc_id" onchange="get_report_stucture_detail(value)">
                                
                            </select>
                        </div>

                        <!-- หน่วยงานที่สังกัด -->
                        <div class="col-md-6" id="div_filter_report_select_stde_id">
                            <label for="filter_report_select_stde_id" class="form-label">หน่วยงานที่สังกัด</label>
                            <select class="form-select select2" name="filter_report_select_stde_id" id="filter_report_select_stde_id">
                                
                            </select>
                        </div>

                        <!-- ช่วงวันที่ -->
                        <div class="col-md-3" id="div_filter_report_select_date">
                            <label for="filter_report_select_date" class="form-label">ช่วงวันที่</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="filter_report_select_date" placeholder="เลือกเวลาเริ่มต้น">
                            </div>
                        </div>

                        <!-- ประเภทตารางแพทย์ออกตรวจ -->
                        <div class="col-md-3" id="div_filter_report_select_public">
                            <label for="filter_report_select_public" class="form-label">ประเภทตารางแพทย์ออกตรวจ</label>
                            <select class="form-select select2" id="filter_report_select_public" name="filter_report_select_public">
                                <option value="0" selected>ตารางแพทย์ออกตรวจภายใน (In)</option>
                                <option value="1">ตารางแพทย์ออกตรวจภายนอก (Public)</option>
                            </select>
                        </div>

    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> รายงานลงเวลาทำงาน (ภาพรวม) </span><span class="summary_preview_report badge bg-success"></span>
                </button>
            </h2>
                
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table id="timework_report_list" class="table table-striped table-bordered table-hover datatables" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">#</th>
                                <th class="text-center" width="35%">ชื่อ - นามสกุล</th>
                                <th class="text-center" width="25%">รายการทำงาน</th>
                                <th class="text-center" width="20%">รายละเอียดทำงาน</th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- ข้อมูลจะถูกเติมด้วย DataTable -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        get_report_stucture($('#filter_report_select_dp_id').val());

         // โค้ดที่คุณต้องการเรียกใช้เมื่อหน้าโหลดเสร็จ
        var selectedValue = $('#filter_report_select_hire_is_medical').val();
        
        if (selectedValue === "M") {
            $('#div_filter_report_select_public').fadeIn(300);
            $('#div_filter_report_select_stde_id').removeClass('col-md-6').addClass('col-md-3');
        } else {
            $('#div_filter_report_select_public').fadeOut(300);
            $('#div_filter_report_select_stde_id').removeClass('col-md-3').addClass('col-md-6');
        }

        // ใช้ off เพื่อแน่ใจว่ามีการผูกเหตุการณ์เพียงครั้งเดียว
        $('#filter_report_select_dp_id, #filter_report_select_hire_is_medical, #filter_report_select_hire_type, #filter_report_select_status_id, #filter_report_select_stuc_id, #filter_report_select_stde_id, #filter_report_select_date, #filter_report_select_public')
            .off('change').on('change', function() {
                // ดึงค่าจากแต่ละ select
                var dp_id = $('#filter_report_select_dp_id').val();
                var hire_is_medical = $('#filter_report_select_hire_is_medical').val();
                var hire_type = $('#filter_report_select_hire_type').val();
                var status_id = $('#filter_report_select_status_id').val();
                var stuc_id = $('#filter_report_select_stuc_id').val();
                var stde_id = $('#filter_report_select_stde_id').val();
                var date = $('#filter_report_select_date').val();
                var public = $('#filter_report_select_public').val();

                if(hire_is_medical != "M"){
                    var public = $('#filter_report_select_public').val();
                }
                else{
                    var public = 0;
                }

                // แสดงค่าที่ได้ใน console เพื่อตรวจสอบ
                // console.log('dp_id:', dp_id);
                // console.log('hire_is_medical:', hire_is_medical);
                // console.log('hire_type:', hire_type);
                // console.log('status_id:', status_id);
                // console.log('stuc_id:', stuc_id);
                // console.log('stde_id:', stde_id);
                // console.log('date:', date);
                // console.log('public:', public);

                initializeDataTableTimeworkPreview();

               
                // // ตัวอย่างการตรวจสอบค่า
                // if (dp_id == 0 || hire_is_medical == "" || hire_type == "" || status_id == "" || stuc_id == "" || stde_id == "" || date == "" || public == "") {
                //     // updateDataTable(); // เรียกใช้ฟังก์ชันนี้ถ้าทุกค่าถูกต้อง
                //     initializeDataTableTimeworkPreview();
                    
                // } else {
                //     initializeDataTableTimeworkPreview();
                // }
            });


        // ทำงานเมื่อเลือกตัวเลือกใหม่
        $('#filter_report_select_stde_id').on('select2:select', function(e) {
            cleanSelect2Text();
        });

        
        $('#filter_report_select_stuc_id').on('select2:select', function(e) {
            var selectedValue = e.params.data.id; // รับค่า ID ที่เลือกจาก select2
            
            if (selectedValue == 0) {
                // ถ้าค่าเป็น 0 ให้ซ่อน div
                $('#div_filter_report_select_stde_id').fadeOut(300);
            } else {
                // ถ้าค่าไม่ใช่ 0 ให้แสดง div
                $('#div_filter_report_select_stde_id').fadeIn(300);
            }
        });

        // Initialize Flatpickr with date range and min/max dates
        flatpickr("#filter_report_select_date", {
            mode: 'range',
            dateFormat: 'd/m/Y',
            locale: 'th',
            defaultDate: [
                new Date(new Date().getFullYear() +543, new Date().getMonth(), 1), // วันแรกของเดือนปัจจุบัน
                new Date(new Date().getFullYear() +543, new Date().getMonth() + 1, 0) // วันสุดท้ายของเดือนปัจจุบัน
            ],
            onReady: function(selectedDates, dateStr, instance) {
                // addMonthNavigationListeners();
                // convertYearsToThai();
            },
            onOpen: function(selectedDates, dateStr, instance) {
                convertYearsToThai();
            },
            onValueUpdate: function(selectedDates, dateStr, instance) {
                convertYearsToThai();
               
                if (selectedDates[0]) {
                    document.getElementById(`filter_report_select_date`).value = formatDateToThai(selectedDates[0]);
                }
                if (selectedDates[1]) {
                    document.getElementById(`filter_report_select_date`).value += ' ถึง ' + formatDateToThai(selectedDates[1]);
                }
            },
            onMonthChange: function(selectedDates, dateStr, instance) {
                convertYearsToThai();
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                convertYearsToThai();
            }
        });


        $('#filter_report_select_hire_is_medical').on('change', function() {
            var selectedValue = $(this).val();
            
            if (selectedValue === "M") {
                // แสดง #div_filter_report_select_public
                $('#div_filter_report_select_public').fadeIn(300);

                // เปลี่ยนคลาส #div_filter_report_select_stde_id เป็น col-md-3
                $('#div_filter_report_select_stde_id').removeClass('col-md-6').addClass('col-md-3');
            } else {
                // ซ่อน #div_filter_report_select_public
                $('#div_filter_report_select_public').hide();

                // เปลี่ยนคลาส #div_filter_report_select_stde_id เป็น col-md-6
                $('#div_filter_report_select_stde_id').removeClass('col-md-3').addClass('col-md-6');
            }
        });

        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    function get_report_stucture(filter_dp_id){

        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_all_structure_list',
            type: 'GET',
            data: {
                dp_id: filter_dp_id
            },
            success: function(data) {
                // Parse the returned data
                data = JSON.parse(data);

                $('#filter_report_select_stuc_id').empty();
                $('#filter_report_select_stuc_id').append(`<option value="all">ไม่เลือกโครงสร้างหน่วยงาน</option>`);

                // Populate options with indentation for child levels, but not for the selected option
                data.forEach(function(row, index) {
                    const isSelected = index === 0 ? 'selected' : ''; // Select the first option

                    if(isSelected == 'selected'){
                        get_report_stucture_detail(row.stuc_id);
                    }
                    
                    // Create the option element with or without indentation
                    const option = `<option value="${row.stuc_id}" ${isSelected}>${row.stuc_confirm_date} ${row.stuc_status == 1 ? " (โครงสร้างปัจจุบัน)" : " (โครงสร้างเก่า)"}</option>`;
                    
                    // Append the option to the select element
                    $('#filter_report_select_stuc_id').append(option);
                });

                // Trigger the change event to load time configs (if needed)
                $('#filter_report_select_stuc_id').trigger('change');

            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }

    function get_report_stucture_detail(stuc_id){
        var filter_dp_id = $("#filter_report_select_dp_id").val();

        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_structure_detail_by_stuc_id',
            type: 'GET',
            data: {
                dp_id: filter_dp_id,
                stuc_id: stuc_id,
                actor_type: actor_type
            },
            success: function(data) {
                // Parse the returned data
                data = JSON.parse(data);

                $('#filter_report_select_stde_id').empty();

                // Populate options with indentation for child levels, but not for the selected option
                data.forEach(function(row, index) {
                    const isSelected = index === 0 ? 'selected' : ''; // Select the first option

                    // Apply indentation only if it's not the selected option and if it's a child level (stde_level > 1)
                    const indent = isSelected === '' && row.stde_level > 0 ? '&nbsp;&nbsp;'.repeat((row.stde_level - 1) * 4) : '';
                    
                    // Create the option element with or without indentation
                    const option = `<option value="${row.stde_id}" ${isSelected}>${indent}${row.stde_name_th}</option>`;
                    
                    // Append the option to the select element
                    $('#filter_report_select_stde_id').append(option);
                });

                // Trigger the change event to load time configs (if needed)
                $('#filter_report_select_stde_id').trigger('change');

            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }

    function export_print_person(ps_id, isPublic, actor_type) {
        var dp_id = $('#filter_report_select_dp_id').val();
        var date = $('#filter_report_select_date').val();

        // แยกวันที่เริ่มต้นและสิ้นสุด
        var dates = date.split(' ถึง ');
        var start_date_th = dates[0];
        var end_date_th = dates[1];

        // แปลง start_date และ end_date เป็นรูปแบบ Y-m-d
        var start_date = convertToChristianYear(start_date_th);
        var end_date = convertToChristianYear(end_date_th);

        // เปิดหน้าต่างใหม่เพื่อส่งออกข้อมูล
        window.open('<?php echo site_url($controller_dir . 'export_print_timework_calendar'); ?>/' + ps_id + '/' + isPublic + '/' + actor_type + '/' + dp_id + "/" + start_date + "/" + end_date, '_blank');
    }

    function export_excel_person(ps_id, isPublic, actor_type) {
        var dp_id = $('#filter_report_select_dp_id').val();
        var date = $('#filter_report_select_date').val();

        // แยกวันที่เริ่มต้นและสิ้นสุด
        var dates = date.split(' ถึง ');
        var start_date_th = dates[0];
        var end_date_th = dates[1];

        // แปลง start_date และ end_date เป็นรูปแบบ Y-m-d
        var start_date = convertToChristianYear(start_date_th);
        var end_date = convertToChristianYear(end_date_th);

        // เปิดหน้าต่างใหม่เพื่อส่งออกข้อมูล
        window.open('<?php echo site_url($controller_dir . 'export_excel_timework_calendar'); ?>/' + ps_id + '/' + isPublic + '/' + actor_type + '/' + dp_id + "/" + start_date + "/" + end_date, '_blank');
    }

    function export_pdf_person(ps_id, isPublic, actor_type) {
        var dp_id = $('#filter_report_select_dp_id').val();
        var date = $('#filter_report_select_date').val();

        // แยกวันที่เริ่มต้นและสิ้นสุด
        var dates = date.split(' ถึง ');
        var start_date_th = dates[0];
        var end_date_th = dates[1];

        // แปลง start_date และ end_date เป็นรูปแบบ Y-m-d
        var start_date = convertToChristianYear(start_date_th);
        var end_date = convertToChristianYear(end_date_th);

        // เปิดหน้าต่างใหม่เพื่อส่งออกข้อมูล
        window.open('<?php echo site_url($controller_dir . 'export_pdf_timework_calendar'); ?>/' + ps_id + '/' + isPublic + '/' + actor_type + '/' + dp_id + "/" + start_date + "/" + end_date, '_blank');
    }

    function view_timework_person_detail(ps_id, isPublic){
        var date = $('#filter_report_select_date').val();
        var dp_id = $('#filter_report_select_dp_id').val();

        // แยกวันที่เริ่มต้นและสิ้นสุด
        var dates = date.split(' ถึง ');
        var start_date_th = dates[0];
        var end_date_th = dates[1];

        // แปลง start_date และ end_date เป็นรูปแบบ Y-m-d
        var start_date = convertToChristianYear(start_date_th);
        var end_date = convertToChristianYear(end_date_th);

        window.open('<?php echo site_url($controller_dir . 'preview_timework_calendar_person'); ?>/' + ps_id + '/' + isPublic + '/' + dp_id + "/" + start_date + "/" + end_date, '_blank');
    }

    function getIndentation(seq) {
        // Count the number of periods in the sequence to determine the depth
        const depth = (seq.match(/\./g) || []).length;

        // Return a string of non-breaking spaces for indentation
        // Using `\u00A0` for non-breaking space (HTML entity &nbsp; equivalent)
        return '\u00A0'.repeat(depth * 4); // 4 non-breaking spaces per depth level
    }

    function cleanSelect2Text() {
        // ดึงข้อความที่แสดงใน select2
        var select2Element = $('#filter_report_select_stde_id').siblings('.select2-container').find('.select2-selection__rendered');
        var innerHtml = select2Element.html();

        // ลบช่องว่างที่เป็น &nbsp; ออก
        var cleanedHtml = innerHtml.replace(/&nbsp;/g, '').trim();

        // อัปเดตข้อความที่แสดงอยู่ใน select2
        select2Element.html(cleanedHtml);
    }

    // ฟังก์ชันแปลงปี พ.ศ. เป็น ค.ศ.
    function convertToChristianYear(date_th) {
        var parts = date_th.split('/');
        var day = parts[0];
        var month = parts[1];
        var year = parseInt(parts[2]) - 543; // แปลง พ.ศ. เป็น ค.ศ.
        return year + '-' + month + '-' + day;
    }

    function initializeDataTableTimeworkPreview() {

        var dp_id = $('#filter_report_select_dp_id').val();
        var hire_is_medical = $('#filter_report_select_hire_is_medical').val();

        if(hire_is_medical == "M"){
            var public = $('#filter_report_select_public').val();
        }
        else{
            var public = 0;
        }
        var hire_type = $('#filter_report_select_hire_type').val();
        var status_id = $('#filter_report_select_status_id').val();
        var stuc_id = $('#filter_report_select_stuc_id').val();
        var stde_id = $('#filter_report_select_stde_id').val();
        var date = $('#filter_report_select_date').val();

        // แยกวันที่เริ่มต้นและสิ้นสุด
        var dates = date.split(' ถึง ');
        var start_date_th = dates[0];
        var end_date_th = dates[1];

        // แปลง start_date และ end_date เป็นรูปแบบ Y-m-d
        var start_date = convertToChristianYear(start_date_th);
        var end_date = convertToChristianYear(end_date_th);
        
        $("#timework_report_list").DataTable({
            initComplete: function() {
                // ปุ่มการจัดการ
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "ทั้งหมด"]
            ],
            language: {
            decimal: "",
            emptyTable: "ไม่มีรายการในระบบ",
            info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
            infoFiltered: "(filtered from _MAX_ total entries)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "_MENU_",
            loadingRecords: "Loading...",
            processing: "",
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
                orderable: "Order by this column",
                orderableReverse: "Reverse order this column"
            },
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: '<i class="bi-file-earmark-fill"></i> Print',
                    titleAttr: 'Print',
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
                    "customize": function (doc) {
                        doc.defaultStyle = { font: 'THSarabun' };
                    }
                },
            ],
            "ordering": false,
            "columnDefs": [
                { "visible": false, "targets": [1] } // ซ่อนคอลัมน์ "ชื่อ - นามสกุล" ในการจัดกลุ่ม
            ],
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({ page: 'current' }).nodes();
                var last = null;

                // จัดกลุ่มโดยคอลัมน์ "ชื่อ - นามสกุล"
                api.column(1, { page: 'current' }).data().each(function(group, i) {
                    // console.log(group);
                    if (last !== group) {
                        // var buttonHtml = `
                        //     <button class="btn btn-danger btn-sm" style="float: right;" title="คลิกเพื่อส่งออกเอกสาร PDF" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</button>
                        //     <button class="btn btn-success btn-sm me-2" style="float: right;" title="คลิกเพื่อส่งออกเอกสาร Excel" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                        //     <button class="btn btn-secondary btn-sm me-2" style="float: right;" title="คลิกเพื่อ Print" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-printer-fill"></i> Print</button>
                        // `;
                        
                        $(rows).eq(i).before(
                            // '<tr class="group"><td colspan="4" style="background: #e0e0e0; font-weight: bold;" style="justify-content: space-between; align-items: center;">' + group + '</td></tr>'
                            '<tr class="group"><td colspan="4" style="background: #e0e0e0">' + group + '</td></tr>'
                        );
                        last = group;
                    }
                });
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            bDestroy: true, // ลบ DataTable เดิมเมื่อมีการ reinitialize ใหม่
            ajax: {
                type: "GET",
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_plan_person_preview_report_list',
                data: {
                    dp_id: dp_id,
                    hire_is_medical: hire_is_medical,
                    hire_type: hire_type,
                    status_id: status_id,
                    stde_id: stde_id,
                    start_date: start_date,
                    end_date: end_date,
                    public: public,
                    actor_type: '<?php echo $actor_type; ?>'
                },
                dataSrc: function(data) {
                    var return_data = new Array();

                    data.forEach(function(row, index) {
                        // console.log("row", row.pf_name + row.ps_fname);
                        var seq = index + 1;
                      
                        // สร้างปุ่ม 3 ปุ่ม (Print, Excel, PDF)
                        // var button = `
                        //     <div class="space-between"><b> ${row.pf_name + " " + row.ps_fname + " " + row.ps_lname} </b>
                        //         <div class="d-flex justify-content-end">
                        //             <button class="btn btn-secondary btn-sm me-2" title="คลิกเพื่อ Print" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_print_person('${row.twpp_ps_id}', ${row.twpp_is_public}, '${row.actor_type}')">
                        //                 <i class="bi bi-printer-fill"></i> Print
                        //             </button>
                        //             <button class="btn btn-success btn-sm me-2" title="คลิกเพื่อส่งออกเอกสาร Excel" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_excel_person('${row.twpp_ps_id}', ${row.twpp_is_public}, '${row.actor_type}')">
                        //                 <i class="bi bi-file-earmark-excel-fill"></i> Excel
                        //             </button>
                        //             <button class="btn btn-danger btn-sm me-2" title="คลิกเพื่อส่งออกเอกสาร PDF" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_pdf_person('${row.twpp_ps_id}', ${row.twpp_is_public}, '${row.actor_type}')">
                        //                 <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                        //             </button>
                        //             <button class="btn btn-primary btn-sm" title="คลิกเพื่อดูรายละเอียด" data-bs-toggle="tooltip" data-bs-placement="top" onclick="view_timework_person_detail('${row.twpp_ps_id}', ${row.twpp_is_public})">
                        //                 <i class="bi-search"></i> รายละเอียด
                        //             </button>
                        //         </div>
                        //     </div>
                        // `;

                        var button = `
                            <div class="space-between"><b> ${row.pf_name + " " + row.ps_fname + " " + row.ps_lname} </b>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm" title="คลิกเพื่อดูรายละเอียด" data-bs-toggle="tooltip" data-bs-placement="top" onclick="view_timework_person_detail('${row.twpp_ps_id}', ${row.twpp_is_public})">
                                        <i class="bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        `;

                        // Return data to push into array
                        return_data.push({
                            "seq": seq, // ลำดับ
                            "button": button, // ปุ่มดำเนินการ
                            "work_details": (row.rm_name != null ? row.rm_name : "") + " " + (row.twpp_desc != "" ? row.twpp_desc : ""), // ประเภทการทำงาน
                            "work_date": row.twpp_start_date_text + " " + row.twpp_start_time_text + " - " + row.twpp_end_time_text, // เวลาเริ่ม-สิ้นสุด
                           
                        });
                    });
                    return return_data;
                } //end dataSrc
            }, //end ajax
            "columns": [
                {
                    "data": "seq",
                    className: "text-center"
                },
                { "data": "button" },
                { "data": "work_date" },
                { "data": "work_details" }
            ]
        });
    }



</script>