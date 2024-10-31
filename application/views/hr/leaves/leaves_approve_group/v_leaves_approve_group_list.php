<style>
    .nav-pills .nav-link {
        border: 1px dashed #607D8B;
        color: #012970;
        background-color: #fff;
    }

    .space-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
<ul class="nav nav-pills" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="group-tab" data-bs-toggle="tab" data-bs-target="#group-approve" type="button" role="tab" aria-controls="group-approve" aria-selected="true">กำหนดเส้นทางอนุมัติการลา</button>
    </li>
    <li class="nav-item ms-1" role="presentation">
        <button class="nav-link" id="report-tab" data-bs-toggle="tab" data-bs-target="#report-list" type="button" role="tab" aria-controls="report-list" aria-selected="false">รายงานเส้นทางอนุมัติการลา</button>
    </li>
</ul>

<div class="tab-content pt-2" id="myTabContent">
    <!-- บันทึกเวลารายบุคคล -->
    <div class="tab-pane fade show active" id="group-approve" role="tabpanel" aria-labelledby="group-tab">
        <div class="card mt-2">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                            <i class="bi-search icon-menu"></i><span> ค้นหารายการเส้นทางอนุมัติการลา</span>
                        </button>
                    </h2>
                    <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body">
                            <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">

                                <!-- ประเภทกลุ่มเส้นทาง -->
                                <div class="col-md-3">
                                    <label for="select_leaves_approve_group" class="form-label">ประเภทกลุ่มเส้นทาง</label>
                                    <select class="select2" name="select_leaves_approve_group" id="select_leaves_approve_group">
                                        <option value="-1" disabled>-- เลือกประเภทกลุ่มเส้นทาง --</option>
                                        <!-- <option value="all" selected>ทั้งหมด</option> -->
                                        <option value="stuc" selected>โครงสร้างองค์กร</option>
                                        <option value="hire">สายปฏิบัติงาน</option>
                                        <option value="ps">เฉพาะบุคคล</option>
                                    </select>
                                </div> 
                                
                                <!-- หน่วยงาน -->
                                <div class="col-md-3" id="div_select_dp_id">
                                    <label for="select_dp_id" class="form-label">หน่วยงาน</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="select_dp_id" id="select_dp_id" onchange="get_report_stucture(value)">
                                        <?php foreach ($base_ums_department_list as $key => $row) { ?>
                                            <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-3" id="div_select_stuc">
                                    <label for="select_stuc" class="form-label">โครงสร้างหน่วยงาน</label>
                                    <select class="select2" name="select_stuc" id="select_stuc">

                                    </select>
                                </div>
                                <!-- โครงสร้างองค์กร -->

                                <div class="col-md-3" id="div_select_hire">
                                    <label for="select_hire_is_medical" class="form-label">สายปฏิบัติงาน</label>
                                    <select class="form-select select2" name="select_hire_is_medical" id="select_hire_is_medical">
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
                                <!-- สายปฏิบัติงาน -->

                                <div class="col-md-3">
                                    <label for="select_leaves_approve_group_status" class="form-label">สถานะการใช้งาน</label>
                                    <select class="select2" name="select_leaves_approve_group_status" id="select_leaves_approve_group_status">
                                        <option value="-1" disabled>-- เลือกสถานะการใช้งาน --</option>
                                        <option value="all" selected>ทั้งหมด</option>
                                        <option value="Y">เปิดการใช้งาน</option>
                                        <option value="N">ปิดการใช้งาน</option>
                                    </select>
                                </div>
                                <!-- สถานะการใช้งาน -->

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
                            <i class="bi-table icon-menu"></i><span> ตารางรายการแสดงข้อมูลเส้นทางอนุมัติการลา</span><span class="badge bg-success" id="leaves_approve_group_table_list_count"></span>
                        </button>
                    </h2>
                    <div id="collapseShow" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="btn-option mb-3">
                                <button class="btn btn-primary" onclick="window.location.href='<?php echo site_url().'/'.$controller_dir.'insert_approve_group/'; ?>'"><i class="bi-plus"></i> เพิ่มข้อมูลเส้นทางอนุมัติการลา </button>
                            </div>
                
                            <table class="table table-striped table-bordered table-hover datatable" id="leaves_approve_group_table_list" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th class="text-center" width="30%">ชื่อเส้นทางการอนุมัติ</th>
                                        <th class="text-center" width="15%">ประเภท</th>
                                        <th class="text-center" width="20%">สำหรับ</th>
                                        <th class="text-center" width="15%">สถานะการใช้งาน</th>
                                        <th class="text-center" width="15%">ดำเนินการ</th>
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
    <!-- นำเข้าข้อมูลด้วย Excel -->
    <div class="tab-pane fade" id="report-list" role="tabpanel" aria-labelledby="report-tab">
        <?php echo $this->load->view($view_dir . 'v_leaves_approve_group_report', '', TRUE); ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ยืนยันการลบเส้นทางการอนุมัติ</h5>
            </div>
            <div class="modal-body">
                <p>คุณต้องการลบเส้นทางการอนุมัติข้อมูลต่อไปนี้ ใช่หรือไม่?</p>
                <ul class="list-group">
                    <li class="list-group-item"><strong>ชื่อเส้นทาง:</strong> <span id="modalItemName"></span></li>
                    <li class="list-group-item"><strong>ประเภท:</strong> <span id="modalItemType"></span></li>
                    <li class="list-group-item"><strong>สำหรับ:</strong> <span id="modalItemParent"></span></li>
                    <li class="list-group-item"><strong>สถานะการใข้งาน:</strong> <span id="modalItemActive"></span></li>
                </ul>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" id="confirmDeleteButton" class="btn btn-danger">ลบ</button>
            </div>
        </div>
    </div>
</div>




<script>

$(document).ready(function() {

    get_report_stucture($('#select_dp_id').val());

    // Initial DataTable update
    updateDataTable();

     // Event listeners for select dropdowns
     $('#select_leaves_approve_group, #select_dp_id, #select_stuc, #select_hire_is_medical, #select_leaves_approve_group_status').on('change', function() {
        // Update DataTable when a select dropdown changes
        updateDataTable();
    });
    
    // Event listener for confirm delete button
    $(document).on('click', '#confirmDeleteBtn', function() {
        // Retrieve the ID from the button's data attribute and call the delete function
        const lapgId = $(this).data('lapg-id');
        path_delete_approve_group(lapgId);
    });
   
});

// Function to update DataTable based on select dropdown values
function updateDataTable() {
    // Initialize DataTable
    var dataTable = $('#leaves_approve_group_table_list').DataTable();

    var lapg_type = $('#select_leaves_approve_group').val();
    var lapg_parent_id = "";
    var lapg_stuc_id = "";

    var lapg_active = $('#select_leaves_approve_group_status').val();
    

    if(lapg_type == "stuc"){
        $("#div_select_dp_id").show();
        $("#div_select_stuc").show();
        $("#div_select_hire").hide();
        lapg_stuc_id = $('#select_stuc').val();
        lapg_parent_id = "all";
    }
    else if(lapg_type == "hire"){
        $("#div_select_dp_id").hide();
        $("#div_select_stuc").hide();
        $("#div_select_hire").show();
        lapg_parent_id = $('#select_hire_is_medical').val();
    }
    else {
        $("#div_select_dp_id").hide();
        $("#div_select_stuc").hide();
        $("#div_select_hire").hide();
        lapg_parent_id = "";
    }

    // Make AJAX request to fetch updated data
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_leaves_approve_group_list_by_param",
        type: 'POST',
        data: {
            lapg_type : lapg_type,
            lapg_parent_id : lapg_parent_id,
            lapg_stuc_id : lapg_stuc_id,
            lapg_active : lapg_active
        },
        success: function(response) {
            data = JSON.parse(response);

            // Clear existing DataTable data
            dataTable.clear().draw();

            // // Update summary count
            $("#leaves_approve_group_table_list_count").text(data.length);

            index = 1;
            data.forEach((item, index) => {
                // console.log(item);
                var button = `
                    <div class="text-center option">
                        <button class="btn btn-warning" onclick="path_update_approve_group('${item.lapg_id}')">
                            <i class="bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger" data-lapg-id="${item.lapg_id}" data-lapg-name="${item.lapg_name}" data-lapg-type="${item.lapg_type}" data-lapg-parent="${item.lapg_parent_name}" data-lapg-active="${item.lapg_active}" onclick="showDeleteConfirmModal(this)">
                            <i class="bi-trash"></i>
                        </button>
                    </div>
                `;



                var status;
                var type_text = "";

                if(item.lapg_active == "Y"){
                    status = '<span class="badge rounded-pill bg-success">เปิดการใช้งาน</span>'
                }
                else {
                    status = '<span class="badge rounded-pill bg-danger">ปิดการใช้งาน</span>'
                }

                if(item.lapg_type == "stuc"){
                    type_text = "โครงสร้างองค์กร";
                }
                else if(item.lapg_type == "hire"){
                    type_text = "สายปฏิบัติงาน";
                }
                else{
                    type_text = "เฉพาะบุคคล";
                }

                // Add new row to DataTable
                dataTable.row.add([
                        '<div class="text-center option">' + (++index) + '</div>',
                        item.lapg_name,
                        '<div class="text-center option">' + type_text + '</div>',
                        item.lapg_parent_name,
                        '<div class="text-center option">' + status + '</div>',
                        button
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

function path_update_approve_group(lapg_id){
    window.location.href = '<?php echo site_url($controller_dir . 'update_approve_group'); ?>/' + lapg_id;
}

function showDeleteConfirmModal(button) {
    var lapgName = button.getAttribute('data-lapg-name');
    var lapg_active = button.getAttribute('data-lapg-active');
    var lapg_type = button.getAttribute('data-lapg-type');
    var lapg_parent = button.getAttribute('data-lapg-parent');
    

    var status;
    var type_text = "";

    if(lapg_active == "Y"){
        status = '<span class="badge rounded-pill bg-success">เปิดการใช้งาน</span>'
    }
    else {
        status = '<span class="badge rounded-pill bg-danger">ปิดการใช้งาน</span>'
    }

    if(lapg_type == "stuc"){
        type_text = "โครงสร้างองค์กร";
    }
    else if(lapg_type == "hire"){
        type_text = "สายปฏิบัติงาน";
    }
    else{
        type_text = "เฉพาะบุคคล";
    }

    // ตรวจสอบให้แน่ใจว่าองค์ประกอบมีอยู่จริงก่อนจะตั้งค่า textContent
    const modalItemName = document.getElementById('modalItemName');
    const modalItemType = document.getElementById('modalItemType');
    const modalItemParent = document.getElementById('modalItemParent');
    const modalItemActive = document.getElementById('modalItemActive');

    if (modalItemName) {
        modalItemName.textContent = lapgName;
    } else {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': text_toast_default_error_body
        });
    }

    if (modalItemType) {
        modalItemType.textContent = type_text;
    } else {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': text_toast_default_error_body
        });
    }

    if (modalItemParent) {
        modalItemParent.textContent = lapg_parent;
    } else {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': text_toast_default_error_body
        });
    }

    if (modalItemActive) {
        modalItemActive.innerHTML = status;
    } else {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': text_toast_default_error_body
        });
    }

    // ตั้งค่าเพื่อให้ปุ่มลบทำงานได้
    const confirmButton = document.getElementById('confirmDeleteButton');
    if (confirmButton) {
        confirmButton.setAttribute('onclick', `path_delete_approve_group('${button.getAttribute('data-lapg-id')}')`);
    } else {
        // console.error('ไม่พบองค์ประกอบ confirmDeleteButton');
        dialog_error({
            'header': text_toast_default_error_header,
            'body': text_toast_default_error_body
        });
    }

    // เปิด modal
    $('#deleteConfirmModal').modal('show');
}



function path_delete_approve_group(lapg_id){
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>delete_approve_group',
        type: 'POST',
        data: {
            lapg_id: lapg_id
        },
        success: function(response) {
            var data = JSON.parse(response);

            // Hide the modal before making the AJAX call
            var myModalEl = document.getElementById('deleteConfirmModal');
            var myModal = bootstrap.Modal.getInstance(myModalEl);
            myModal.hide();


            if (data.status_response == status_response_success) {
                dialog_success({'header': text_toast_save_success_header, 'body': data.message_dialog}, data.return_url, false);
            } else if (data.status_response == status_response_error) {
                dialog_error({'header':text_toast_default_error_header, 'body': data.message_dialog});
            } 

        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


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

            $('#select_stuc').empty();
            // $('#select_stuc').append(`<option value="all">ไม่เลือกโครงสร้างหน่วยงาน</option>`);

            // Populate options with indentation for child levels, but not for the selected option
            data.forEach(function(row, index) {
                const isSelected = index === 0 ? 'selected' : ''; // Select the first option
                
                // Create the option element with or without indentation
                const option = `<option value="${row.stuc_id}" ${isSelected}>${row.stuc_confirm_date} ${row.stuc_status == 1 ? " (โครงสร้างปัจจุบัน)" : " (โครงสร้างเก่า)"}</option>`;
                
                // Append the option to the select element
                $('#select_stuc').append(option);
            });

            // Trigger the change event to load time configs (if needed)
            $('#select_stuc').trigger('change');

        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}

</script>