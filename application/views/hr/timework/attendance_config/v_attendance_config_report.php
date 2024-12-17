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
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="filter_report_select_dp_id" id="filter_report_select_dp_id">
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

                                echo '<option value="all" selected>ทั้งหมด</option>';

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
                    <i class="bi-people icon-menu"></i><span> รายงานรูปแบบการลงเวลาทำงาน</span><span class="leaves_approve_group_table_report_count badge bg-success"></span>
                </button>
            </h2>

            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table id="attendance_config_table_report" class="table table-striped table-bordered table-hover datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th class="text-center" width="25%">ชื่อ - นามสกุล</th>
                                <th class="text-center" width="35%">รูปแบบการทำงานปกติ</th>
                                <th class="text-center" width="35%">รูปแบบการทำงาน OT</th>
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
    $(document).ready(function() {
        initializeDataTableLeavesApproveGroup();
        // ใช้ off เพื่อแน่ใจว่ามีการผูกเหตุการณ์เพียงครั้งเดียว
        $('#filter_report_select_dp_id, #filter_report_select_hire_is_medical, #filter_report_select_hire_type, #filter_report_select_status_id').on('change', function() { // Trigger select2 update
            initializeDataTableLeavesApproveGroup(); // Reload DataTable
        });
        $('[data-bs-toggle="tooltip"]').tooltip();
    });


    function initializeDataTableLeavesApproveGroup() {

        var dataTable = $('#attendance_config_table_report').DataTable();

        var dp_id = $('#filter_report_select_dp_id').val();
        var hire_is_medical = $('#filter_report_select_hire_is_medical').val();

        var hire_type = $('#filter_report_select_hire_type').val();
        var status_id = $('#filter_report_select_status_id').val();




        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_attendance_config_report_list",
            type: 'POST',
            data: {
                dp_id: dp_id,
                hire_is_medical: hire_is_medical,
                hire_type: hire_type,
                status_id: status_id
            },
            success: function(response) {
                data = JSON.parse(response);

                // Clear existing DataTable data
                dataTable.clear().draw();

                // // Update summary count
                $("#leaves_approve_group_table_report_count").text(data.length);

                index = 1;
                data.forEach((item, index) => {
                    // Add new row to DataTable
                    dataTable.row.add([
                        '<div class="text-center option">' + (++index) + '</div>',
                        item.ps_name,
                        item.worktime_normal,
                        item.worktime_ot
                    ]).draw();
                });


                // Initialize tooltips for new buttons
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                // Handle errors
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }
</script>