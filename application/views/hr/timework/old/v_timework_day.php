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
                <h5 class="text-muted small">บันทึกเวลา</span></h5>
                <div class="card-icon rounded-circle float-start">
                </div>
                <div class="float-end">
                    <h1>รายบุคคล</h1>
                </div>
            </div>
        </div>
        <div class="card card-button col-md-3" id="btn-history">
            <div class="card-body">
                <h5 class="text-muted small">นำเข้าข้อมูลด้วย Excel</span></h5>
                <div class="card-icon rounded-circle float-start">
                    <i class="bi bi-download text-warning"></i>
                </div>
                <div class="float-end">
                    <h1>Excel</h1>
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
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">วันที่</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="SearchFirstName" id="SearchFirstName" placeholder="วันที่" value="<?php echo !empty($edit) ? $edit['SearchFirstName'] : ""; ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">โครงสร้างบริหาร (แผนก/ฝ่าย) </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">รายบุคคล</option>
                                <option value="1">รายกลุ่ม</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">ประเภทบุคลากร </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">รายบุคคล</option>
                                <option value="1">รายกลุ่ม</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">ตำแหน่งงาน
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
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

<div class="card" id="card-sync">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> รายชื่อผู้ใช้</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">ลำดับ</th>
                                <th class="text-center" scope="col">ชื่อ-นามสกุล</th>
                                <th class="text-center" scope="col">เวลาเข้างาน</th>
                                <th class="text-center" scope="col">เวลาออกงาน</th>
                                <th class="text-center" scope="col">หมายเหตุ</th>
                                <th class="text-center" scope="col">สถานะ</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $i + 1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center">ณฐกร พงษ์สาริกิจ</div>
                                    </td>
                                    <td><input type="time" class="form-control" name="Email"></td>
                                    <td><input type="time" class="form-control" name="Email"></td>
                                    <td>
                                        <div class="text-center"><textarea></textarea></div>
                                    </td>
                                    <td>
                                        <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                            <option value=""></option>
                                            <option value="1">รายบุคคล</option>
                                            <option value="1">รายกลุ่ม</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-success" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-save"></i></button>
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
                    <i class="bi-people icon-menu"></i><span>อัพโหลดเอกสาร</span><span class="badge bg-success">4</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table" width="100%">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"class="text-center" >ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><h5>เลือกไฟล์ Excel (.xls,.xlsx)</h5></td>
                                <td><input class="form-control-sm" type="file" name="" id=""></td>
                                <td>
                                    <div class="text-center option">
                                        <button class="btn btn-success" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-save"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
        }

        document.getElementById('btn-history').onclick = function() {
            // document.getElementById('card-history').classList.add('show');
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