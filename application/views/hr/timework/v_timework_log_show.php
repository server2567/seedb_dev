<style>
    .card-icon i {
        font-size: 3rem;
        opacity: 0.5;
    }

    #card-sync,
    #card-history {
        display: none;
    }

    .password-toggle {
        cursor: pointer;
    }

    #collapse-sync,
    #collapse-history {
        display: none;
    }

    /* #card-sync, #card-history {
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    #card-sync.show, #card-history.show {
        display: block;
        opacity: 1;
    } */
</style>
<div class="row">
    <div class="d-flex justify-content-center">
        <div class="card card-button col-md-3 me-5" id="btn-sync">
            <div class="card-body">
                <h5 class="text-muted small">การเข้างาน</span></h5>
                <div class="card-icon rounded-circle float-start">
                <i class="ri-user-3-fill "></i>
                </div>
                <div class="float-end">
                    <h1>รายบุคคล</h1>
                </div>
            </div>
        </div>
        <div class="card card-button col-md-3" id="btn-history">
            <div class="card-body">
                <h5 class="text-muted small">การเข้างาน</span></h5>
                <div class="card-icon rounded-circle float-start">
                   <i class="bi bi-people-fill"></i>
                </div>
                <div class="float-end">
                    <h1>ทั้งหมด</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อผู้ใช้</span>
                </button>
            </h2>
            <div id="collapse-sync" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">ช่วงวันที่</label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control" placeholder="เริ่ม" aria-label="วันที่">
                                <span class="input-group-text mb-3">ถึง</span>
                                <input type="date" class="form-control" placeholder="วันที่สิ้นสุด" aria-label="วันที่สิ้นสุด">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">แผนก/ฝ่าย</label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">รายบุคคล</option>
                                <option value="1">รายกลุ่ม</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">ตำแหน่งงาน</label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">รายบุคคล</option>
                                <option value="1">รายกลุ่ม</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">บุคคลกร
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">นาย ขจรศัก ผักใบเขียว</option>
                                <option value="1">นาย ธนูถวย คงควรคอย</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div id="collapse-history" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">วันที่</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="SearchFirstName" id="SearchFirstName" placeholder="วันที่" value="<?php echo !empty($edit) ? $edit['SearchFirstName'] : ""; ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">แผนก/ฝ่าย</label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">รายบุคคล</option>
                                <option value="1">รายกลุ่ม</option>
                            </select>
                        </div>
                        <!-- <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">ประเภทบุคลากร </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">รายบุคคล</option>
                                <option value="1">รายกลุ่ม</option>
                            </select>
                        </div> -->
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">เวรเข้างาน
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- เลือกเวรการเข้างาน --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">เช้า</option>
                                <option value="1">บ่าย</option>
                                <option value="1">เย็น</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" id="card-sync">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>รูปแบบการเข้างานรายบุคล</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/timework/Timework_log/get_Time__log_edit_user/<?php echo 1 ?>'"><i class="bi-plus"></i>เพิ่มรูปแบบ</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">ลำดับ</th>
                                <th class="text-center" scope="col">วันที่-เวลา</th>
                                <th class="text-center" scope="col">การเข้างาน</th>
                                <th class="text-center" scope="col">แผนก</th>
                                <th class="text-center" scope="col">รหัสห้อง</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo $i + 1; ?>
                                    </td>
                                    <td class="text-center">
                                        1/02/66 เวลา 8.00 ถึง 12.00
                                    </td>
                                    <td class="text-center">
                                        <span class="text-primary"> กะเช้า</span>

                                    </td>
                                    <td class="text-center">
                                        อายุระกรรม
                                    </td>
                                    <td class="text-center">
                                        E201
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-info" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_log/get_Time__log_edit_user/<?php echo 1 ?>'"><i class="bi-eye-fill"></i></button>
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_log/get_Time__log_edit_user/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
                                        </div>
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

<div class="card" id="card-history">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>รายการเข้างานทั้งหมด</span><span class="badge bg-success">4</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/timework/Timework_log/get_Time__log_edit_all/<?php echo 1 ?>'"><i class="bi-plus"></i>เพิ่มรูปแบบ</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">ลำดับ</th>
                                <th class="text-center" scope="col">วันที่-เวลา</th>
                                <th class="text-center" scope="col">การเข้างาน</th>
                                <th class="text-center" scope="col">รหัสห้อง</th>
                                <th class="text-center" scope="col">จำนวนคน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $i; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center">2024-03-26 09:34:34</div>
                                    </td>
                                    <td>
                                        <div class="text-center">กะเช้า</div>
                                    </td>
                                    <td>
                                        <div class="text-center">E20</div>
                                    </td>
                                    <td class="text-center">
                                        <a href='#' data-bs-toggle="modal" data-bs-target="#exampleModal" title="ดูรายชื่อทั่งหมด">5</a>
                                    </td>

                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-info" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_log/get_Time__log_edit_all/<?php echo 1 ?>'"><i class="bi-eye-fill"></i></button>
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_log/get_Time__log_edit_all/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="modal modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addpermodal">บุคคลที่เข้าเวรทั้งหมด</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="tab-content">
                                    <table class="table datatable" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" scope="col">ลำดับ</th>
                                                <th class="text-center" scope="col">ชื่อ-สกุล</th>
                                                <th class="text-center" scope="col">ตำแหน่งงาน</th>
                                                <!-- <th class="text-center" scope="col">ดำเนินการ</th> -->
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
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
</div>


<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('btn-sync').onclick = function() {
            // document.getElementById('card-sync').classList.add('show');
            document.getElementById('card-sync').setAttribute('style', 'display: block; opacity: 1;');
            document.getElementById('card-history').setAttribute('style', 'display: none; opacity: 0; transition: opacity 0.5s ease-in-out;');
            document.getElementById('collapse-sync').setAttribute('style', 'display: block; opacity: 1;');
            document.getElementById('collapse-history').setAttribute('style', 'display: none; opacity: 0; transition: opacity 0.5s ease-in-out;');
        }

        document.getElementById('btn-history').onclick = function() {
            // document.getElementById('card-history').classList.add('show');
            document.getElementById('collapse-history').setAttribute('style', 'display: block; opacity: 1;');
            document.getElementById('collapse-sync').setAttribute('style', 'display: none; opacity: 0; transition: opacity 0.5s ease-in-out;');
            document.getElementById('card-history').setAttribute('style', 'display: block; opacity: 1;');
            document.getElementById('card-sync').setAttribute('style', 'display: none; opacity: 0; transition: opacity 0.5s ease-in-out;');
        }
    });

    function togglePassword(event) {
        var passwordInput = event.previousElementSibling;
        if (passwordInput.type == "password") {
            passwordInput.type = "text";
            if (event.children.length > 0) {
                Array.from(event.children).forEach(i => {
                    if (i.tagName.toLowerCase() === 'i') {
                        i.classList.remove('bi-eye-slash')
                        i.classList.add('bi-eye');
                    }
                });
            }
        } else {
            passwordInput.type = "password";
            if (event.children.length > 0) {
                Array.from(event.children).forEach(i => {
                    if (i.tagName.toLowerCase() === 'i') {
                        i.classList.remove('bi-eye')
                        i.classList.add('bi-eye-slash');
                    }
                });
            }
        }
    }
</script>