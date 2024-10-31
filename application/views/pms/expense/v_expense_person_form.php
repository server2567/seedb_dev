<style>
    .dataTables_wrapper .dataTables_scrollHead th.text-center {
        text-align: center;
    }
</style>
<div id="mycontent">
    <div class="card">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button accordion-button-table" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd" type="button">
                        <i class="bi-search icon-menu"></i><span> เลือกเดือนที่ต้องการดำเนินการของข้อมูล</span><span class="badge bg-success">15</span>
                    </button>
                </h2>
                <div id="collapseAdd" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">เดือน / ปี:</label>
                                <input type="month" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($edit == '3') { ?>
        <div class="card">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd2" aria-expanded="true" aria-controls="collapseAdd2">
                            <i class="bi-window-dock icon-menu"></i>
                            <span>
                                <?php if (isset($edit)) { ?>
                                    รายชื่อบุคคลแบบกลุ่ม
                                <?php } ?>

                            </span>
                        </button>
                    </h2>
                    <div id="collapseAdd2" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table datatable" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-start">#</th>
                                                        <th>ชื่อ-นามสกุล</th>
                                                        <th>ตำแหน่งในการบริหารงาน</th>
                                                        <th>ตำแหน่งในสายงาน</th>
                                                        <th class="text-start">รายการ</th>
                                                        <th class="text-start">จำนวนเงิน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (isset($edit)) { ?>
                                                        <?php for ($i = 0; $i < 3; $i++) { ?>
                                                            <?php if ($i != 2) { ?>
                                                                <tr>
                                                                    <td class="text-start"><?php echo $i + 1; ?></td>
                                                                    <td>แอดมิน ระบบ</td>
                                                                    <td>ตำแหน่งในการบริหารงาน</td>
                                                                    <td>ตำแหน่งในสายงาน</td>
                                                                    <td class="text-start">-</td>
                                                                    <td class="text-start">0 บาท</td>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <td class="text-start"><?php echo $i + 1; ?></td>
                                                                <td>แอดมิน ระบบ</td>
                                                                <td>ตำแหน่งในการบริหารงาน</td>
                                                                <td>ตำแหน่งในสายงาน</td>
                                                                <td class="text-start">4</td>
                                                                <td class="text-start">300 บาท <a href="#"><i style="color: red;" class="bi bi-info-circle" title="บุคคลากรมีรายการอยู่แล้ว"></i></a></td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
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
        </div>
    <?php } ?>
    <?php if ($edit == '2') { ?>
        <div class="card">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd2" aria-expanded="true" aria-controls="collapseAdd2">
                            <i class="bi-window-dock icon-menu"></i>
                            <span>
                                เพิ่มข้อมูลบุคคลภายนอก
                            </span>
                        </button>
                    </h2>
                    <div id="collapseAdd2" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="">คำนำหน้า : </label>
                                                    <input class="form-control" type="text">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">ชื่อ :</label>
                                                    <input class="form-control" type="text">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">นามสกุล :</label>
                                                    <input class="form-control" type="text">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">เลขบัตรประชาชน :</label>
                                                    <input class="form-control" type="text">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">ชื่อธนาคาร :</label>
                                                    <input class="form-control" type="text">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">เลขที่บัญชี :</label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="card">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd3" aria-expanded="true" aria-controls="collapseAdd2">
                        <i class="bi-window-dock icon-menu"></i>
                        <span>
                            <?php if (isset($insert)) {
                                if ($insert == '1') { ?>
                                    ตารางข้อมูลรายจ่ายรายบุคคล
                                <?php } else if ($insert == '2') { ?>
                                    ตารางข้อมูลรายจ่ายบุคคลภายนอก
                                <?php } else { ?>
                                    ตารางข้อมูลรายจ่ายบุคคลแบบกลุ่ม
                            <?php }
                            } else ?>
                            <?php if (isset($edit)) {
                                if ($edit == '1') { ?>
                                    ตารางข้อมูลรายจ่ายรายบุคคล
                                <?php } else if ($edit == '2') { ?>
                                    ตารางข้อมูลรายจ่ายบุคคลภายนอก
                                <?php } else { ?>
                                    ตารางข้อมูลรายจ่ายบุคคลแบบกลุ่ม
                            <?php }
                            } ?>
                        </span>
                    </button>
                </h2>
                <div id="collapseAdd3" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="row">
                                    <?php if ($edit == '1') { ?>
                                        <div class="col-md-1">
                                            <label for="" class="form-label">ชื่อบุคลากร <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-3 form-start">
                                            <select class="form-control select2" name="" id="">
                                                <option value="0">-- เลือกบุคลากร --</option>
                                                <option value="1" <?= isset($edit) ? 'selected' : '' ?>>นายอธิเดช บุญมั้งมี</option>
                                            </select>
                                        </div>
                                    <?php } else if ($edit == '3') { ?>
                                        <div class="col-md-5">
                                            <label>คัดลอกจากบุคคล :</label>

                                            <select class="select2 form-control" id="pid" name="" id="">
                                                <option value="-1">-- เลือกบุคคล --</option>
                                                <option value="0">นายอธิเดช บุญมั้งมี</option>
                                                <option value="1">นายอธิเดช บุญมั้งมี</option>
                                                <option value="2">นายอธิเดช บุญมั้งมี</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="width: 10%;">
                                            <br>
                                            <button onclick="copy()" class="btn btn-success">คัดลอก</button>
                                        </div>
                                        <div class="col-md-3">
                                            <br>
                                            <button class="btn btn-danger"><i class="bi-x-lg"></i>ล้างข้อมูล</button>
                                        </div>
                                    <?php }  ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="form-label">
                                    <button id="addTest" onclick="add(1)" data-bs-toggle="modal" data-bs-target="#mainModal" class="btn btn-primary">
                                        <i class="bi-plus"><span>
                                                <?php if (isset($insert)) { ?>
                                                    เพิ่มรายการรายจ่าย
                                                <?php } else if (isset($edit)) { ?>
                                                    เพิ่มรายการรายจ่าย
                                                <?php } ?>
                                        </i>
                                    </button>
                                </label>
                                <div class="row">
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-12">
                                        <table id="myTable" class="table datatable" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">รายการ</th>
                                                    <th class="text-center">รายละเอียด</th>
                                                    <th class="text-center">จำนวนเงิน</th>
                                                    <th class="text-center">ดำเนินการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($edit) && isset($copy)) { ?>
                                                    <?php for ($i = 0; $i < $copy; $i++) { ?>
                                                        <tr>
                                                            <td class="text-start"><?php echo $i + 1; ?></td>
                                                            <td>แอดมิน ระบบ</td>
                                                            <td>admin</td>
                                                            <td class="text-start">300 บาท</td>
                                                            <td class="text-center">
                                                                <button class="btn btn-warning" onclick="edit(1)" data-bs-toggle="modal" data-bs-target="#mainModal"><i class="bi-pencil-square"></i></button>
                                                                <button class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url(); ?>/<?php echo $this->config->item('pms_path') ?>/Expense_person'">ย้อนกลับ</button>
                                <input type="submit" class="btn btn-success float-end" value="บันทึก">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var expenseData = [];
    var index = 0;
    // $(document).ready(function() {
    //     // เรียกใช้งานเมื่อมีการคลิกที่แท็บ
    //     $('.nav-link').click(function() {
    //         // ตรวจสอบว่าแท็บที่ถูกคลิกอยู่คือแท็บไหน
    //         if ($(this).attr('id') === 'home-tab') {
    //             $('.btn.btn-primary').html('<i class="bi-plus"></i> เพิ่มรายการรายรับ');
    //             $('.btn.btn-primary').attr('onclick', 'add(1)');
    //             $('.btn.btn-warning').attr('onclick', 'edit(1)');
    //         } else if ($(this).attr('id') === 'profile-tab') {
    //             $('.btn.btn-primary').html('<i class="bi-plus"></i> เพิ่มรายการรายจ่าย');
    //             $('.btn.btn-primary').attr('onclick', 'add(2)');
    //             $('.btn.btn-warning').attr('onclick', 'edit(2)');
    //         }
    //     });
    // });

    function add(type) {
        $.ajax({
            method: "post",
            url: '../getAddForm',
            data: {
                add: type
            }
        }).done(function(returnData) {
            $('#mainModalTitle').html(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#mainModalFooter').html(returnData.footer);
            // $('#mainModal').modal('show');
        });
    }

    function reTable() {
        var table = $('#myTable').DataTable();
        table.destroy();
        $('#myTable').DataTable({
            data: expenseData,
            columns: [{
                    title: "ลำดับ"
                },
                {
                    title: "รายการ"
                },
                {
                    title: "รายละเอียด"
                },
                {
                    title: "จำนวนเงิน",
                },
                {
                    title: "ดำเนินการ"
                }
            ],
            language: {
                emptyTable: "ไม่มีรายการในระบบ"
            },
            "drawCallback": function(settings) {
                var api = this.api();
                // กำหนดให้แต่ละคอลัมน์ชิดซ้าย
                api.columns().every(function() {
                    var column = this;
                    $(column.header()).addClass("text-center");
                    $(column.footer()).addClass("text-center");
                });
                var table = $('#myTable').DataTable();
                table.column(0).nodes().each(function(cell, i) {
                    $(cell).addClass('text-center');
                });
                table.column(1).nodes().each(function(cell, i) {
                    $(cell).addClass('text-start');
                });
                table.column(2).nodes().each(function(cell, i) {
                    $(cell).addClass('text-start');
                });
                table.column(3).nodes().each(function(cell, i) {
                    $(cell).addClass('text-start');
                });
                table.column(4).nodes().each(function(cell, i) {
                    $(cell).addClass('text-center');
                });
                $('#myTable thead th').css({
                    "text-align": "center"
                });
            }
        });
    }

    function addExpense() {
        var eid = $('#expenseId option:selected').text()
        var ecost = $('#expenseCost').val()
        var edetail = $('#expenseDetail').val()
        console.log( $('#expenseId').val());
        if (ecost == '' || $('#expenseId').val() == null) {
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            return 0;
        } else {
            expenseData.push([index + 1, eid, edetail, ecost, `<button class="btn btn-warning"><i class="bi-pencil"></i></button> <button onclick="delExpense(${index})" class="btn btn-danger"><i class="bi-trash"></i></button>`])
            index++
            reTable()
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "บันทึกข้อมูลสำเร็จ",
                showConfirmButton: false,
                timer: 300
            });
            $('#mainModal').modal('hide');
        }
    }

    function delExpense(i) {
        swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการลบข้อมูลนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                index--;
                expenseData.splice(i, 1);
                expenseData = expenseData.map((item, ix) => {
                    return [ix + 1, item[1], item[2], item[3], `<button class="btn btn-warning"><i class="bi-pencil"></i></button> <button onclick="delExpense(${ix})" class="btn btn-danger"><i class="bi-trash"></i></button>`];
                });
                reTable()
                swal.fire(
                    'ลบสำเร็จ!',
                    'ข้อมูลถูกลบแล้ว',
                    'success'
                );
            }
        });
    }

    function edit(type) {
        $.ajax({
            method: "post",
            url: '../getEditForm',
            data: {
                edit: type
            }
        }).done(function(returnData) {
            $('#mainModalTitle').html(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#mainModalFooter').html(returnData.footer);
        });
    }

    function copy() {
        $.ajax({
            url: '../editExpense/' + $('#type').val(),
            method: 'post',
            data: {
                copy: $('#pid').val()
            }
        }).done(function(returnedData) {
            $('#listDiv2').html(returnedData.html);
        })
    }
</script>