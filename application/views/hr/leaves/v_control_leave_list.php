<?php
/*
	* v_control_leaves_list
	* หน้าจอแสดงข้อมูลกฏการลา
	* @input leave_type_id = 1
	* $output -
	* @author Patcharapol  Sirimaneechot
	* @Create Date 2567-10-07
	*/
    
?>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูลควบคุมวันลา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-4">
                            <label for="SearchLastName" class="form-label">สายงาน</label>
                            <select class="select2" name="select_hire_is_medical" id="select_hire_is_medical">
                                <option value="-1" disabled>-- เลือกสายงาน --</option>
                                <option value="-99" selected>ทั้งหมด</option>
                                <?php 
                                    foreach ($hire_is_medical as $h) {
                                        echo "<option value=".$h['code'].">".$h['detail']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="SearchFirstName" class="form-label">เลือกประเภทการลา</label>
                            <select class="select2" name="select_leave" id="select_leave">
                                <option value="-1" disabled>-- เลือกประเภทการลา --</option>
                                <option value="-99" selected>ทั้งหมด</option>
                                <?php foreach ($leave as $l) {
                                    echo "<option value=".$l['leave_id'].">".$l['leave_name']."</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="SearchFirstName" class="form-label">เลือกประเภทการปฏิบัติงาน</label>
                            <select class="select2" name="select_hire_type" id="select_hire_type">
                                <option value="-1" disabled>-- เลือกประเภทการปฏิบัติงาน --</option>
                                <option value="-99" selected>ทั้งหมด</option>
                                <option value="1">เต็มเวลา</option>
                                <option value="2">บางเวลา</option>
                            </select>
                        </div>
                        <!-- <div class="col-3">
                            <label for="SearchLastName" class="form-label">ตำแหน่งในสายงาน</label>
                            <select class="select2" name="" id="">
                                <option value="-1" disabled>-- เลือกตำแหน่งในสายงาน --</option>
                                <option value="all" selected>ทั้งหมด</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">สถานะการทำงาน</label>
                            <select name="" class="form-select" id="">
                                <option value="-1" disabled>-- เลือกสถานะ --</option>
                                <option value="all" selected>ทั้งหมด</option>
                            </select>
                        </div> -->
                        <div class="col-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
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
                    <i class="bi-people icon-menu"></i><span> ข้อมูลควบคุมวันลา</span><span id="leave_control_table_row_amount" class="badge bg-success"><?= count($leave_control) ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                <div class="btn-option mb-3">
                    <?php $url = site_url() . "/" . $controller_dir . "control_leaves/control_leave_add"; ?>
                    <button class="btn btn-primary" onclick="location.href='<?= $url; ?>'">
                            <i class="bi-plus"></i> เพิ่มข้อมูลควบคุมวันลา
                        </button>
                    </div>
                    <table id="leave_control_table" class="table datatable text-center" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">สายงาน</th>
                                <th class="text-center" scope="col">ประเภทการลา</th>
                                <!-- <th class="text-center" scope="col" width="15%">ช่วงอายุ</th> -->
                                <th class="text-center" scope="col" width="15%">อายุการทำงานเริ่มต้น</th>
                                <th class="text-center" scope="col" width="15%">อายุการทำงานสิ้นสุด</th>
                                <th class="text-center" scope="col">จำนวนครั้งที่ลาได้</th>
                                <th class="text-center" scope="col">จำนวนวันที่ลาได้ต่อปี</th>
                                <th class="text-center" scope="col">จำนวนที่ลาได้ต่อครั้ง</th>
                                <th class="text-center" scope="col">จำนวนวันลาสะสมสูงสุด</th>
                                <!-- <th class="text-center" scope="col">ประเภทวัน</th> -->
                                <th class="text-center" scope="col">สถานะการได้รับเงินเดือน</th>
                                <th class="text-center" scope="col">จำนวนวันที่อนุญาตให้ลาล่วงหน้า</th>
                                <th class="text-center" scope="col">จำนวนวันที่อนุญาตให้ลาย้อนหลัง</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php /* 
                            <?php $count = 1; ?>
                            <?php function checkUnlimitedDay($data) {
                                if ((int)$data == -99) {
                                    return "ไม่จำกัด";
                                } else {
                                    return $data;
                                }
                            }
                            ?>
                            <?php // print_r($leave_control); ?>
                            <?php foreach ($leave_control as $l) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $count++; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $l['detail']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $l['leave_name']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo substr($l['ctrl_start_age'], 0, 2) ." ปี ".substr($l['ctrl_start_age'], 3, 2) ." เดือน ". substr($l['ctrl_start_age'], 6, 2) ." วัน" ; ?></div>
                                    </td>
                                    <td>
                                    <div class="text-center"><?php echo substr($l['ctrl_end_age'], 0, 2) ." ปี ".substr($l['ctrl_end_age'], 3, 2) ." เดือน ". substr($l['ctrl_end_age'], 6, 2) ." วัน" ; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo checkUnlimitedDay($l['ctrl_time_per_year']); ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo checkUnlimitedDay($l['ctrl_day_per_year']); ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo checkUnlimitedDay($l['ctrl_date_per_time']); ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $l['ctrl_pack_per_year']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php if($l['ctrl_money'] == 'Y') { echo '<i class="bi bi-check">'; } else { echo "ไม่ได้รับ"; } ?></i></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo checkUnlimitedDay($l['ctrl_day_before']); ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo checkUnlimitedDay($l['ctrl_day_after']); ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/Control_leaves/control_leave_update/<?php echo $l['ctrl_id'] ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/Control_leaves/control_leave_delete/<?php echo $l['ctrl_id'] ?>'"><i class="bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            */ ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_confirm_delete_data" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ยืนยันการลบข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal_detail">

                </div>
                <input type="hidden" name="modal_delete_id" id="modal_delete_id">
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="confirm_profile_delete_data()">ยืนยัน</button>
            </div>
        </div>
    </div>
</div><!-- End Modal-->


<script>
    $(document).ready(function() {
        // Initial DataTable update
        updateDataTable();
    });

    // $('#leave_control_table').dataTable({
    //   "columnDefs": [
    //     {"className": "dt-center", "targets": "_all"}
    //   ]});

     // Event listeners for select dropdowns
     $('#select_hire_is_medical, #select_leave, #select_hire_type').on('change', function() {
        // Update DataTable when a select dropdown changes
        updateDataTable();
    });

    // function setTooltipDefault(selector = ".option button") {
    //     const td_options = [...document.querySelectorAll(selector)];
    //     // console.log("td_options ", td_options);
    //     Array.from(td_options).forEach(btn => {
    //         const title = btn.getAttribute('title');
    //         btn.setAttribute('data-bs-toggle', 'tooltip');
    //         btn.setAttribute('data-bs-placement', 'top');
    //         // title case
    //         if (btn.classList.contains('btn-warning')) {
    //         btn.setAttribute('title', is_null(title) ? 'แก้ไขข้อมูล' : title);
    //         } else if (btn.classList.contains(is_null(title) ? 'btn-success' : title)) {
    //         btn.setAttribute('title', 'เพิ่มข้อมูล');
    //         } else if (btn.classList.contains(is_null(title) ? 'btn-danger' : title)) {
    //         btn.setAttribute('title', 'ลบข้อมูล');
    //         } else if (btn.classList.contains(is_null(title) ? 'btn-success' : title)) {
    //         btn.setAttribute('title', 'จัดการข้อมูล');
    //         }
    //         new bootstrap.Tooltip(btn);
    //     });
    // }

    // Function to update DataTable based on select dropdown values
    function updateDataTable() {
        // Initialize DataTable
        var dataTable = $('#leave_control_table').DataTable();

        var select_hire_is_medical = $('#select_hire_is_medical').val();
        var select_leave = $('#select_leave').val();
        var select_hire_type = $('#select_hire_type').val();

        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php site_url() . "/" . $controller_dir ?>' + "control_leaves/get_leave_control_by_condition/",
            type: 'POST',
            data: {
                select_hire_is_medical: select_hire_is_medical,
                select_leave: select_leave,
                select_hire_type
            },
            success: function(response) {
                data = JSON.parse(response)
                // console.log('response: ', data);
                // console.log('select_hire_is_medical: ', select_hire_is_medical);
                // console.log('select_leave: ', select_leave);

                
                // Clear existing DataTable data
                dataTable.clear().draw();

                // // Update summary count
                $("#leave_control_table_row_amount").text(data.result.length);

                // leave_control_table = document.getElementById('leave_control_table');
                // tbody = leave_control_table.children[1];
                // tbody.innerHTML = data.html;

                index = 1;
                data.result.forEach((item, index) => {
                    ctrl_start_age = (item.ctrl_start_age).substring(0, 2) + " ปี " + (item.ctrl_start_age).substring(3, 5) + " เดือน " + (item.ctrl_start_age).substring(6) + " วัน";
                    ctrl_end_age = (item.ctrl_end_age).substring(0, 2) + " ปี " + (item.ctrl_end_age).substring(3, 5) + " เดือน " + (item.ctrl_end_age).substring(6) + " วัน";
                    // ctrl_money = "ไม่ได้รับ";
                    ctrl_money = "<i class='bi bi-x-lg text-danger'></i>";
                    if (item.ctrl_money == "Y") {
                        ctrl_money = '<i style="gr" class="bi bi-check-lg text-success"></i>'
                    }

                    buttonZone = `<div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/Control_leaves/control_leave_update/${item.ctrl_id}'" 
                                                    title="คลิกเพื่อแก้ไขข้อมูล" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    ><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger" 
                                                    onclick="modal_confirm_delete(this)"
                                                    title="คลิกเพื่อลบข้อมูล" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-ctrl-id="${item.ctrl_id}"
                                                    data-topic="รูปแบบการลงเวลาทำงาน" 
                                                    data-index="${(index)+1}" 
                                                    data-detail="
                                                        <div>
                                                            <h6>สายงาน</h6>
                                                            <p>${item.detail}</p>
                                                        </div>
                                                        <div class='pt-2'>
                                                            <h6>ประเภทการลา</h6>
                                                            <p>${item.leave_name}</p>
                                                        </div>
                                                        <div class='pt-2'>
                                                            <h6>อายุการทำงานเริ่มต้น</h6>
                                                            <p>${ctrl_start_age}</p>
                                                        </div>
                                                        <div class='pt-2'>
                                                            <h6>อายุการทำงานสิ้นสุด</h6>
                                                            <p>${ctrl_end_age}</p>
                                                        </div>
                                                        <div>
                                                            <h6>จำนวนครั้งที่ลาได้</h6>
                                                            <p>${checkData(item.ctrl_time_per_year)}</p>
                                                        </div>
                                                    "
                                                    ><i class="bi-trash"></i></button>
                                        </div>`;
                    // onclick="window.location.href='<?php // echo base_url() ?>index.php/hr/leaves/Control_leaves/control_leave_delete/${item.ctrl_id}'" 
                                        
                    // element.dataset.ctrlId;

                    function checkData(data) {
                        if (Number(data) == -99) {
                            return "ไม่จำกัด";
                        } else {
                            return data;
                        }
                    }

                    // Add new row to DataTable
                    dataTable.row.add([
                            ++index,
                            item.detail,
                            item.leave_name,
                            ctrl_start_age,
                            ctrl_end_age,
                            checkData(item.ctrl_time_per_year),
                            checkData(item.ctrl_day_per_year),
                            checkData(item.ctrl_date_per_time),
                            item.ctrl_pack_per_year,
                            ctrl_money,
                            checkData(item.ctrl_day_before),
                            checkData(item.ctrl_day_after),
                            buttonZone
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

    function modal_confirm_delete(elements) {
        var id = elements.getAttribute("data-ctrl-id");
        var topic = elements.getAttribute("data-topic");
        var index = elements.getAttribute("data-index");
        var detail = elements.getAttribute("data-detail");

        // Change modal title
        $('#modal_confirm_delete_data .modal-title').html("ยืนยันการลบข้อมูล" + topic + " (#" + index + ")");
        // $('#modal_confirm_delete_data .modal-title').html("ยืนยันการลบข้อมูล");
        $('#modal_confirm_delete_data .modal-body .modal_detail').html(detail);
        // $('#modal_confirm_delete_data .modal-body .modal_detail');

        // set input hidden value
        $('#modal_delete_id').val(id);

        // Show modal
        var myModal = new bootstrap.Modal(document.getElementById('modal_confirm_delete_data'));
        myModal.show();
    }

    function confirm_profile_delete_data() {
        var delete_id = $('#modal_delete_id').val();
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>control_leaves/control_leave_delete/' + delete_id,
            type: 'POST',
            data: {
                // twac_id: delete_id
            },
            success: function(data) {
                data = JSON.parse(data);

                // Hide the modal before making the AJAX call
                var myModalEl = document.getElementById('modal_confirm_delete_data');
                var myModal = bootstrap.Modal.getInstance(myModalEl);
                myModal.hide();

                // if (data.status_response == status_response_success) {
                if (data == true) {
                    dialog_success({'header': text_toast_delete_success_header, 'body': text_toast_delete_success_body});
                    updateDataTable();
                // } else if (data.status_response == status_response_error) {
                } else if (data == false) {
                    dialog_error({'header': text_toast_delete_error_header, 'body': text_toast_default_error_body});
                }
                

            },
            error: function(xhr, status, error) {
                dialog_error({'header': text_toast_default_error_header, 'body': text_toast_default_error_body});
            }
        });
    }

</script>
   