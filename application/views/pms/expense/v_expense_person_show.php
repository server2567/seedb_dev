<style>
    .table {
        table-layout: fixed;
        width: 100%;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd" type="button">
                    <i class="bi-search icon-menu"></i><span> เลือกรายชื่อบุคลากรสำหรับที่ต้องการดำเนินการของข้อมูล</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">เดือน / ปี:</label>
                            <input type="month" class="form-control" id="monthPicker">
                        </div>
                    </div>
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
                    <i class="bi-people icon-menu"></i><span> ตารางแสดงข้อมูลรายจ่ายของบุคคล</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-3" style="width: 16%;">
                            <div class="mb-3">
                                <button class="btn btn-primary" onclick="window.location.href='<?php echo site_url(); ?>/pms/Expense_person/editExpenses/2'"><i class="bi-plus"></i> เพิ่มบุคลากรภายนอก </button>
                            </div>
                        </div>
                        <div class="col-md-3 text-start" style="width: 20%;">
                            <button class="btn btn-secondary"><i class="bi bi-clipboard-plus-fill"></i> คัดลอกข้อมูลจากเดือนที่แล้ว</button>
                        </div>
                        <div class="col-md-3 text-start" style="width: 14%;">
                            <button class="btn btn-success"><i class="ri-file-excel-2-fill"></i> ส่งออกข้อมูล</button>
                        </div>
                        <div id="myButton" style="display: none;">
                        </div>
                    </div>
                    <div class="tab-content pt-2" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <table class="table datatable" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th class="text-start checkbox-col" width="10%">เลือก</th>
                                        <th class="text-start">เดือน/ปี</th>
                                        <th width="20%">ชื่อ-นามสกุล </th>
                                        <th width="15%">ตำแหน่งในการบริหารงาน</th>
                                        <th width="15%">ตำแหน่งในสายงาน</th>
                                        <th>รายการ</th>
                                        <th>จำนวนเงิน</th>
                                        <th class="text-center">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 15; $i++) { ?>
                                        <tr>
                                            <td class="text-start checkbox-col"> <!-- ให้ใช้ class checkbox-col -->
                                                <input type="checkbox" name="selectedRows[]" value="<?php echo $i + 1; ?>">
                                            </td>
                                            <td class="text-start"> ม.ค./2567</td>
                                            <td>นายอธิเดช บุญมั้งมี</td>
                                            <td>หัวหน้างาน</td>
                                            <td>พนักงานทางการเงิน</td>
                                            <td>4 รายการ</td>
                                            <td> 10000 บาท</td>
                                            <td class="text-center option">
                                                <button class="btn btn-warning" onclick="window.location.href='<?php echo site_url(); ?>/pms/Expense_person/editExpenses/1'"><i class="bi-pencil-square"></i></button>
                                                <button class="btn btn-danger" data-url="<?php echo site_url() ?>/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
                                            </td>
                                        </tr>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // $(document).ready(function() {
    //     // เรียกใช้งานเมื่อมีการคลิกที่แท็บ
    //     $('.nav-link').click(function() {
    //         // ตรวจสอบว่าแท็บที่ถูกคลิกอยู่คือแท็บไหน
    //         if ($(this).attr('id') === 'home-tab') {
    //             $('.btn.btn-primary').html('<i class="bi-plus"></i> เพิ่มรายรับของบุคคล');
    //             $('.btn.btn-primary').attr('onclick', 'window.location.href=\'<?php echo site_url(); ?>/pms/Income_person/insertIncome\'');
    //             $('.btn.btn-warning').attr('onclick', 'window.location.href=\'<?php echo site_url(); ?>/pms/Income_person/edittIncome\'');
    //         } else if ($(this).attr('id') === 'profile-tab') {
    //             $('.btn.btn-primary').html('<i class="bi-plus"></i> เพิ่มรายจ่ายของบุคคล');
    //             $('.btn.btn-primary').attr('onclick', 'window.location.href=\'<?php echo site_url(); ?>/pms/Income_person/insertExpenses\'');
    //             $('.btn.btn-warning').attr('onclick', 'window.location.href=\'<?php echo site_url(); ?>/pms/Income_person/editExpenses\'');
    //         }
    //     });
    // });
    $(document).ready(function() {
        $('.checkbox-col input[type="checkbox"]').change(function() {
            var checkedCount = $('.checkbox-col input[type="checkbox"]:checked').length;
            if (checkedCount > 1) {
                var div = document.getElementById('myButton')
                if (div.innerHTML == '') {
                    div.classList.add("col-md-2", "text-start");
                    var button = document.createElement("button");
                    button.innerHTML = '<i class="bi bi-pencil-fill"></i> แก้ไขข้อมูลแบบกลุ่ม';
                    button.classList.add("btn", "btn-warning");
                    button.setAttribute("id", "testButton");
                    button.setAttribute("onclick", "window.location.href='<?php echo site_url(); ?>/pms/Expense_person/editExpenses/3'");
                    var btn = document.getElementById('myButton')
                    btn.appendChild(button);
                    $('#myButton').show();
                }
            } else {
                var div = document.getElementById('myButton')
                div.innerHTML = '';
                $('#myButton').hide();
            }
        });

    });
    function add() {
        $.ajax({
            method: "post",
            url: 'income_person/getAddForm'
        }).done(function(returnData) {
            $('#mainModalTitle').html(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#mainModalFooter').html(returnData.footer);
            // $('#mainModal').modal('show');
        });
    }

    function edit() {
        $.ajax({
            method: "post",
            url: 'income_person/getEditForm',
            data: {
                edit: '1'
            }
        }).done(function(returnData) {
            $('#mainModalTitle').html(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#mainModalFooter').html(returnData.footer);
            // $('#mainModal').modal('show');
        });
    }
    // function editGroup() {
    //     $.ajax({
    //         method: "post",
    //         url: 'income_person/getEditForm',
    //         data: {
    //             edit: '3'
    //         }
    //     }).done(function(returnData) {
    //         $('#mainModalTitle').html(returnData.title);
    //         $('#mainModalBody').html(returnData.body);
    //         $('#mainModalFooter').html(returnData.footer);
    //         // $('#mainModal').modal('show');
    //     });
    // }
</script>