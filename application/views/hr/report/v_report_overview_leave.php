<style>
    /* ปรับขนาดฟอนต์ในส่วนหัวตาราง (thead) */
    #person_info_list thead th {
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        /* Center align headers */
    }

    /* ปรับขนาดฟอนต์ในส่วนข้อมูลตาราง (tbody) */
    #person_info_list tbody td {
        font-size: 16px;
        /* ปรับขนาดฟอนต์ในข้อมูล */
    }

    #person_info_list {
        table-layout: fixed;
        /* Helps with consistent column widths */
        width: 100%;
        /* Full width */
    }

    /* Ensure header and cells align properly */
    #person_info_list th,
    #person_info_list td {
        overflow: hidden;
        /* Prevent overflow */
        text-overflow: ellipsis;
        /* Show ellipsis for overflowed text */
        white-space: nowrap;
        /* Prevent wrapping */
    }

    /* ปรับขนาดฟอนต์ในส่วนการแบ่งหน้า (paging) */
    .dataTables_paginate .paginate_button {
        font-size: 14px;
    }

    /* ปรับขนาดฟอนต์ในส่วนกล่องค้นหา */
    .dataTables_filter input {
        font-size: 14px;
    }

    /* ปรับขนาดฟอนต์ในส่วนข้อมูลจำนวนรายการ */
    .dataTables_info {
        font-size: 14px;
    }

    /* ปรับขนาดฟอนต์ในส่วนการเลือกจำนวนรายการต่อหน้า */
    .dataTables_length select {
        font-size: 14px;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="true" aria-controls="collapseAdd">
                            <i class="bi-search icon-menu"></i><span> ค้นหา</span>
                        </button>
                    </h2>
                    <div id="collapseFilter" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body">
                            <form class="row g-3" method="get">
                                <div class="col-md-4">
                                    <label for="select_dp_id" class="form-label required">ปีปฏิทิน</label>
                                    <select class="form-select select2  filter" onchange="filter_report()" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="filter[]" id="filter_year">
                                        <?php $year = date("Y") + 543 ?>
                                        <?php
                                        for ($i = 0; $i <= 5; $i++) { ?>
                                            <?php $year_option = $year - $i; ?>
                                            <option value="<?php echo  $year_option; ?>" <?php echo $year_option == $year ? 'selected' : ''; ?>><?= $year_option; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_dp_id" class="form-label required">หน่วยงาน</label>
                                    <select class="form-select select2  filter" onchange="filter_report()" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="filter[]" id="filter_depart">
                                        <?php
                                        foreach ($department_list as $key => $row) {
                                        ?>
                                            <option value="<?php echo $row['dp_id'] ?>" <?php echo ($this->session->userdata('us_dp_id') == $row['dp_id'] ? "selected" : ""); ?>><?php echo $row['dp_name_th']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_admin_id" class="form-label">ปรเภทบุคลากร</label>
                                    <select class="form-select select2 filter" onchange="filter_report()" name="filter[]" id="filter_hire">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <?php foreach ($base_hire_list as $key => $value) : ?>
                                            <option value="<?= $value->hire_id ?>"><?= $value->hire_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_status_id" class="form-label">ประเภทสายงาน</label>
                                    <select class="form-select select2 filter" onchange="filter_report()" class="form-select" id="filter_adline" name="filter[]">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <?php foreach ($base_adline_list as $key => $value) : ?>
                                            <option value="<?= $value->alp_id ?>"><?= $value->alp_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_status_id" class="form-label">ตำแหน่งในการบริหารงาน</label>
                                    <select class="form-select select2 filter" onchange="filter_report()" class="form-select" id="filter_admin" name="filter[]">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <?php foreach ($base_admin_position_list as $key => $value) : ?>
                                            <option value="<?= $value->admin_id ?>"><?= $value->admin_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_status_id" class="form-label">สถานะการทำงาน</label>
                                    <select class="form-select select2 filter" onchange="filter_report()" class="form-select" id="filter_status" name="filter[]">
                                        <option value="1" selected>ปฏิบัติงานอยู่</option>>
                                        <option value="0">ออกจากการปฏิบัติงาน</option>
                                    </select>
                                </div>
                                <!-- <div class="col-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                        </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button accordion-button-table" type="button">
                            <i class="bi-person icon-menu"></i><span> ข้อมูลบุคลากร <span class="btn btn-info btn-sm p-1"><label for="" class="required">กดปุ่ม Excel เพื่อส่งออกข้อมูล</label></span></span>
                        </button>
                    </h2>
                    <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body ">
                            <div id="overflow">
                                <table class="table table-striped table-bordered" id="person_info_list" width="auto">
                                    <thead>
                                        <tr>

                                            <th rowspan="2" class="text-center" style="background-color: #0076ab; color: white;">#</th>
                                            <th rowspan="2" class="text-center" style="background-color: #0076ab; color: white;">ประเภทการลา</th>
                                            <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">จำนวนที่ลาได้</th>
                                            <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">จำนวนลาที่ใช้ไป</th>
                                            <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">จำนวนวันคงเหลือ</th>
                                            <th rowspan="2" class="text-center" style="background-color: #0076ab; color: white;">จำนวนวันที่ยกยอดมา</th>
                                        </tr>
                                        <tr>
                                            <th>วัน</th>
                                            <th>ชั่วโมง</th>
                                            <th>นาที</th>
                                            <th>วัน</th>
                                            <th>ชั่วโมง</th>
                                            <th>นาที</th>
                                            <th>วัน</th>
                                            <th>ชั่วโมง</th>
                                            <th>นาที</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        initializeDataTableTimeworkPreview();
    });

    function initializeDataTableTimeworkPreview() {
        if ($.fn.DataTable.isDataTable('#person_info_list')) {
            $('#person_info_list').DataTable().destroy();
        }

        $('#person_info_list').DataTable({
            pageLength: 10, 
            lengthMenu: [
                [10, 25, 50, 0],
                [10, 25, 50, "ทั้งหมด"]
            ],
            processing: true, // แสดงสถานะการประมวลผล
            serverSide: true, // เปิดใช้งาน Server-side processing
            ajax: {
                url: '<?php echo site_url($controller_dir . "get_overview_leave_summary"); ?>',
                type: 'POST',
                data: function(d) {
                    // ส่งข้อมูลตัวกรองไปกับการเรียก AJAX
                    d.filter_depart = $('#filter_depart').val();
                    d.filter_hire = $('#filter_hire').val();
                    d.filter_year = $('#filter_year').val();
                    d.filter_adline = $('#filter_adline').val();
                    d.filter_admin = $('#filter_admin').val();
                    d.filter_status = $('#filter_status').val();
                },
                // Call column.adjust() after the data is loaded
                complete: function(settings, json) {
                    $('#person_info_list').DataTable().columns.adjust();
                }
            },
            language: {
                emptyTable: "ไม่มีรายการในระบบ",
                info: "ทั้งหมด _TOTAL_ รายการ",
                infoEmpty: "แสดงรายการที่ 0 - 0 จากทั้งหมด 0 รายการ",
                lengthMenu: "_MENU_",
                loadingRecords: "กำลังโหลด...",
                search: "ค้นหา:",
                searchPlaceholder: "ค้นหา...",
                zeroRecords: "ไม่พบรายการที่ตรงกัน",
                infoFiltered: "",
                recordsFiltered: '',
                paginate: {
                    first: "«",
                    last: "»",
                    next: "›",
                    previous: "‹" 
                }
            },
            dom: 'lBfrti',
            buttons: [{
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success',
                action: function(e, dt, node, config) {
                    export_excel_person();
                }
            }],
            ordering: false,
            scrollX: true, // Enable horizontal scrolling
            scrollY: '620px',
            columns: [{
                    data: 'sequence'
                },
                {
                    data: 'lsum_leave_id'
                },
                {
                    data: 'lsum_per_day'
                },
                {
                    data: 'lsum_per_hour'
                },
                {
                    data: 'lsum_per_minute'
                },
                {
                    data: 'lsum_num_day'
                },
                {
                    data: 'lsum_num_hour'
                },
                {
                    data: 'lsum_num_minute'
                },
                {
                    data: 'lsum_remain_day'
                },
                {
                    data: 'lsum_remain_hour'
                },
                {
                    data: 'lsum_remain_minute'
                },
                {
                    data: 'lsum_leave_old'
                }
            ],
            columnDefs: [{
                    targets: 0,
                    className: 'text-center',
                    width: '50px'
                }, // Set width for column 0
                {
                    targets: 1,
                    width: '100px'
                }, // Set width for column 1
                {
                    targets: 2,
                    width: '100px'
                }, // Set width for column 2
                // Add other column widths as needed
            ]
        });
    }

    function filter_report() {
        initializeDataTableTimeworkPreview()
    }

    function export_excel_person(ps_id = null) {
        // สร้างตัวแปรสำหรับเก็บ filter ที่ผู้ใช้ป้อน
        var filter = {};

        // ดึงข้อมูลจากฟอร์มที่มีชื่อขึ้นต้นด้วย "filter"
        $('[name^="filter"]').each(function() {
            filter[this.id] = this.value; // เก็บค่า ID และ value ของฟิลด์
        });
        console.log(filter);
        
        // สร้าง query string จาก object filter
        var queryString = $.param(filter);

        // ตรวจสอบและแนบ g_id ลงใน URL หากมีค่า
        var url = '<?php echo site_url($controller_dir . "export_excel_develop_person"); ?>' +
            '/' + encodeURIComponent(queryString);

        // เปิดลิงก์ในหน้าต่างใหม่
        window.open(url, '_blank');
    }
</script>