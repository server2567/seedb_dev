<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="get">
                        <div class="col-md-3">
                            <label for="select_dp_id" class="form-label">หน่วยงาน</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="select_dp_id" id="select_dp_id">
                                <?php
                                foreach ($base_ums_department_list as $key => $row) {
                                ?>
                                    <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <!-- <div class="col-md-3">
                            <label for="select_adline_id" class="form-label">ประเภทบุคลากร</label>
                            <select class="form-select select2" name="select_hire_id" id="select_hire_id">
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="none" >ไม่ระบุ</option>
                                <?php
                                    foreach($base_hire_list as $key=>$row){
                                ?>
                                    <option value="<?php echo $row->hire_id; ?>"><?php echo $row->hire_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div> -->
                        <div class="col-md-3">
                            <label for="select_adline_id" class="form-label">สายปฏิบัติงาน</label>
                            <select class="form-select select2" name="select_hire_id" id="select_hire_id">
                                <?php
                                    // Assuming $hire_is_medical is already available as an array
                                    $medical_types = [
                                        'M'  => 'สายการแพทย์',
                                        'N'  => 'สายการพยาบาล',
                                        'SM' => 'สายสนับสนุนทางการแพทย์',
                                        'T'  => 'สายเทคนิคและบริการ',
                                        'A'  => 'สายบริหาร'
                                    ];
                                    echo '<option value="all">ทั้งหมด</option>';
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
                        <!-- <div class="col-md-3">
                            <label for="SearchFirstName" class="form-label">ตำแหน่งในการบริหารงาน</label>
                            <select class="select2" name="select_admin_id" id="select_admin_id">
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="none" >ไม่ระบุ</option>
                                <?php
                                foreach ($base_admin_position_list as $key => $row) {
                                ?>
                                    <option value="<?php echo $row->admin_id; ?>"><?php echo $row->admin_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div> -->
                        <div class="col-md-3">
                            <label for="SearchFirstName" class="form-label">ประเภทการทำงาน</label>
                            <select class="form-select select2" name="select_hire_type" id="select_hire_type">
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานเต็มเวลา (Full-Time)</option>
                                <option value="2">ปฏิบัติงานบางเวลา (Part-Time)</option>
                            </select>
                        </div>
                        <!-- <div class="col-md-3">
                            <label for="SearchLastName" class="form-label">ตำแหน่งปฏิบัติงาน</label>
                            <select class="select2" name="select_adline_id" id="select_adline_id">
                                <option value="all" selected>ทั้งหมด</option>
                            </select>
                        </div> -->
                        
                        <div class="col-md-3">
                            <label for="select_status_id" class="form-label">สถานะการทำงาน</label>
                            <select class="form-select select2" class="form-select" id="select_status_id" name="select_status_id">
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานอยู่</option>
                                <option value="2">ออกจากการปฏิบัติงาน</option>
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
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> รายชื่อบุคลากรทั้งหมด</span><span class="summary_person badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table id="person_list" class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ชื่อ - นามสกุล</th>
                                <th class="text-center">หน่วยงาน</th>
                                <th class="text-center">ประเภทบุคลากร</th>
                                <th class="text-center">ตำแหน่งในการบริหารงาน</th>
                                <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                <th class="text-center">สถานะการทำงาน</th>
                                <th class="text-center">ดำเนินการ</th>
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

<script>
    $(document).ready(function() {
        // Initial DataTable update
        updateDataTable();
    });

    // Function to update DataTable based on select dropdown values
    function updateDataTable() {
        // Initialize DataTable
        var dataTable = $('#person_list').DataTable();

        var hire_id = $('#select_hire_id').val();
        var hire_type = $('#select_hire_type').val();
        var status_id = $('#select_status_id').val();
        var dp_id = $('#select_dp_id').val();

        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_profile_user_list',
            type: 'GET',
            data: {
                dp_id: dp_id,
                hire_id: hire_id,
                hire_type: hire_type,
                status_id: status_id
            },
            success: function(data) {
                // Clear existing DataTable data
                data = JSON.parse(data);
                dataTable.clear().draw();

                $(".summary_person").text(data.length);
                // Add new data to DataTable
                data.forEach(function(row, index) {
                    var status_text = "";
                    if (row.pos_status == 1) {
                        status_text = '<div class="text-center"><i class="bi-circle-fill text-success"></i> ปฏิบัติงานอยู่</div>';
                    } else {
                        status_text = '<div class="text-center"><i class="bi-circle-fill text-danger"></i> ออกจากการปฏิบัติงาน</div>';
                    }
                    var button = `  <div class="text-center option">
                                            <button class="btn btn-primary" title="คลิกเพื่อทำเรื่องการลา" data-toggle="tooltip" data-bs-placement="top" onclick="window.location.href='<?php echo site_url() . "/" . $controller_dir; ?>get_leaves_person_list/${row.ps_id}'">
                                                <i class="bi-receipt"></i>
                                            </button>
                                        </div>
                                    `;
                    var admin_name_ul = ``
                    row.admin_position.forEach(element => {
                        var li = `<li> ${element} </li>`
                        admin_name_ul += li
                    });
                    if (admin_name_ul == ``) {
                        admin_name_ul = '-'
                    }
                    var admin_name_group = `<ul> ${admin_name_ul} </ul>`
                    dataTable.row.add([
                        (index + 1),
                        row.pf_name + row.ps_fname + " " + row.ps_lname,
                        row.dp_name_th,
                        (row.hire_name == null ? '-' : row.hire_name),
                        admin_name_group,
                        (row.alp_name == null ? '-' : row.alp_name),
                        status_text,
                        button
                    ]).draw();
                    $('[data-toggle="tooltip"]').tooltip();
                });
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }

    // Event listeners for select dropdowns
    $('#select_dp_id, #select_hire_type, #select_hire_id, #select_status_id').on('change', function() {
        // Update DataTable when a select dropdown changes
        updateDataTable();
    });
</script>