<style>
    .card-tabs ul.nav-tabs {
        border-top-right-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
        border-top-left-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
    }

    .card-tabs li button.nav-link,
    .card-tabs .nav-item-left {
        padding: 14px 1.25rem;
    }

    .card-tabs .nav-tabs {
        font-weight: bold;
    }

    .card-tabs .card-body {
        padding: 0 1.25rem var(--bs-card-spacer-y) 1.25rem;
    }

    .card form button.accordion-button:not(.collapsed) {
        color: var(--bs-primary);
    }

    .none {
        display: none;
    }

    .block {
        display: block;
    }
</style>

<div class="col-12">
    <div class="row">
        <div class='col-12'>
            <div class="card card-tabs">
                <ul class="nav nav-tabs nav-tabs-bordered bg-primary-light" id="borderedTab" role="tablist">
                    <div class="nav-item-left">
                        <i class="bi-person icon-menu"></i><span>รูปแบบการลงเวลาการทำงาน</span>
                    </div>
                </ul>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/User/update">
                        <div class="tab-content">
                            <div class="list-group list-group-alternate ">
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label for="UsTitle" class="form-label required">แผนก</label>
                                        <select class="form-select select2" data-placeholder="-- รูบแบบการลงเวลา --" name="UsTitle" id="UsTitle" required>
                                            <option value=""></option>
                                            <option value="1">รายบุคคล</option>
                                            <option value="1">รายกลุ่ม</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsFirstName" class="form-label required">วันที่เข้างาน</label>
                                        <input type="date" class="form-control" name="UsFirstName" id="UsFirstName" placeholder="ชื่อภาษาไทย" value="<?php echo !empty($edit) ? $edit['UsFirstName'] : ""; ?>" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label for="UsFirstName" class="form-label required">เวลาเข้างาน</label>
                                        <input type="time" class="form-control" name="UsFirstName" id="UsFirstName" placeholder="เวลาเข้างาน" value="<?php echo !empty($edit) ? $edit['UsFirstName'] : ""; ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsFirstName" class="form-label required">เวลาออกงาน</label>
                                        <input type="time" class="form-control" name="UsFirstName" id="UsFirstName" placeholder="เวลาเข้างาน" value="<?php echo !empty($edit) ? $edit['UsFirstName'] : ""; ?>" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <label for="UsLastName" class="form-label required">เวรเข้างาน</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="shift" id="shiftMorning">
                                            <label class="form-check-label" for="shiftMorning">กะเช้า</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="shift" id="shiftEvening">
                                            <label class="form-check-label" for="shiftEvening">กะบ่าย</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="shift" id="shiftAfternoon">
                                            <label class="form-check-label" for="shiftAfternoon">กะเย็น</label>
                                        </div>
                                    </div>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row">
        <div class='col-12'>
            <div class="card card-tabs">
                <ul class="nav nav-tabs nav-tabs-bordered bg-primary-light" id="borderedTab" role="tablist">
                    <div class="nav-item-left">
                        <i class="bi-person icon-menu"></i><span>รายชื่อบุคคลเข้าเวร</span>
                    </div>
                </ul>
                <div class="card-body">
                    <div class="btn-option mt-3">
                        <button class="btn btn-primary" onclick="window.location.href='#'" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-plus"></i> เพิ่มบุคคลเข้าเวร
                        </button>
                    </div>
                    <form class="needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/User/update">
                        <div class="tab-content">
                            <table class="table datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">ลำดับ</th>
                                        <th class="text-center" scope="col">ชื่อ-สกุล</th>
                                        <th class="text-center" scope="col">ตำแหน่งงาน</th>
                                        <th class="text-center" scope="col">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <tr>
                                            <td>
                                                <div class="text-center"><?php echo $i; ?></div>
                                            </td>
                                            <td>
                                                <div class="text-center">ณฐกร พงษ์สาริกิจ</div>
                                            </td>
                                            <td>
                                                <div class="text-center">เจ้าหน้าที่</div>
                                            </td>
                                            <td>
                                                <div class="text-center option">
                                                    <!-- <button class="btn btn-info" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_log/get_Time__log_edit_all/<?php echo 1 ?>'"><i class="bi-eye-fill"></i></button> -->
                                                    <!-- <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_log/get_Time__log_edit_all/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button> -->
                                                    <button class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addpermodal">รูปแบบการลงเวลาการทำงาน</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="accordion">
                                    <div class="card">
                                        <div class="card card-tabs">
                                            <ul class="nav nav-tabs nav-tabs-bordered bg-primary-light" id="borderedTab" role="tablist">
                                                <div class="nav-item-left">
                                                    <i class="bi-person icon-menu"></i><span>เพิ่มบุคคลเข้าเวร</span>
                                                </div>
                                            </ul>
                                            <div>
                                                <div class="accordion-body">
                                                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                                                        <div class="col-12 text-center">
                                                            <h2 for="StNameT" class="text-center">เพิ่มบุคคลเข้าเวร</h2>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="SearchFirstName" class="form-label">โครงสร้างบริหาร (แผนก/ฝ่าย) </label>
                                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsT" required>
                                                                <option value=""></option>
                                                                <option value="1">รายบุคคล</option>
                                                                <option value="1">รายกลุ่ม</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="SearchFirstName" class="form-label">ตำแหน่งงาน</label>
                                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกบุคลากร --" name="UsTitle" id="Us" required>
                                                                <option value=""></option>
                                                                <option value="1">รายบุคคล</option>
                                                                <option value="1">รายกลุ่ม</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="SearchFirstName" class="form-label">บุคคลกร</label>
                                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกบุคลากร --" name="UsTitle" id="UsTitle" required>
                                                                <option value=""></option>
                                                                <option value="1">รายบุคคล</option>
                                                                <option value="1">รายกลุ่ม</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"> <!-- Moved inside modal body -->
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">บันทึก</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    const tabItems = document.querySelectorAll('.list-group-item');

    tabItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove 'active' class from all tab items
            tabItems.forEach(tab => {
                tab.classList.remove('active');
            });

            // Add 'active' class to the clicked tab item
            this.classList.add('active');

            // Get the target tab pane
            const targetTabPaneId = this.getAttribute('data-bs-target');
            const targetTabPane = document.querySelector(targetTabPaneId);

            // Remove 'show active' class from all tab panes
            const tabContents = document.querySelectorAll('.tab-pane');
            tabContents.forEach(content => {
                content.classList.remove('show', 'active');
            });

            // Add 'show active' class to the target tab pane
            targetTabPane.classList.add('show', 'active');
        });
    });
</script>