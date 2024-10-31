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
        <div class="col-4">
            <div class="card">
                <div class="card-body profile-card ">
                    <div class="text-center"><img src="https://surateyehospital.com/wp-content/uploads/2023/01/S__64995330-e1674529006351.jpg" width="200px" height="200px"></div>
                    <h3 class="text-center">นพ.บรรยง ขินกุลกิจนิวัฒน์</h3>
                    <div class="text-start"><b>ตำแหน่งในการบริหาร : </b>ผู้อำนวยการ</div>
                    <div class="text-start"><b>ตำแหน่งในสายงาน : </b>จักษุแพทย์ รักษาโรคตาทั่วไป</div>
                    <div class="text-start"><b>ตำแหน่งเฉพาะทาง : </b>เชี่ยวชาญการผ่าตัดต้อกระจก</div>
                </div>
            </div>
            <div class="list-group list-group-alternate mb-n">
                <a href="#user" role="tab" data-bs-target="#user" class="list-group-item active">
                    <i class="ti ti-user"></i> ข้อมูลส่วนตัว
                </a>
                <a href="#permission" role="tab" data-bs-toggle="tab" data-bs-target="#permission" class="list-group-item">
                    <i class="ti ti-home"></i> ที่อยู่
                </a>
                <a href="#permission" role="tab" data-bs-toggle="tab" data-bs-target="#Education" class="list-group-item">
                    <i class="ti ti-home"></i> ประวัติการศึกษา
                </a>
                <a href="#permission" role="tab" data-bs-toggle="tab" data-bs-target="#license" class="list-group-item">
                    <i class="ti ti-home"></i> ใบประกอบวิชาชีพ
                </a>
                <a href="#permission" role="tab" data-bs-toggle="tab" data-bs-target="#experience" class="list-group-item">
                    <i class="ti ti-home"></i> ประสบการณ์ทำงาน
                </a>
                <a href="#permission" role="tab" data-bs-toggle="tab" data-bs-target="#expert" class="list-group-item">
                    <i class="ti ti-home"></i> ความเชี่ยวชาญ/ความชำนาญ
                </a>
                <a href="#permission" role="tab" data-bs-toggle="tab" data-bs-target="#award" class="list-group-item">
                    <i class="ti ti-home"></i> รางวัล
                </a>
            </div>
        </div>
        <div class="col-8">
            <div class="card card-tabs">
                <ul class="nav nav-tabs nav-tabs-bordered bg-primary-light" id="borderedTab" role="tablist">
                    <div class="nav-item-left">
                        <i class="bi-person icon-menu"></i><span>จัดการข้อมูลบุคลากร</span>
                    </div>
                    <!-- <div class="<?php echo !isset($StID) ? "nav-item-right" : "none" ?> ">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab">แก้ไขข้อมูลส่วนตัว</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#permission" type="button" role="tab">ข้อมูลที่อยู่</button>
                        </li>
                    </div> -->
                </ul>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/User/update">
                        <div class="tab-content">
                            <div class="tab-pane fade row g-3 show active" id="user" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label for="UsTitle" class="form-label required">คำนำหน้า</label>
                                        <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                            <option value=""></option>
                                            <option value="1">นายแพทย์</option>
                                            <option value="1">แพทย์หญิง</option>
                                            <option value="1">อาจายร์นายแพทย์</option>
                                            <option value="1">ทันตแพทย์หญิง</option>
                                            <option value="1">ทันตแพทย์</option>
                                        </select>
                                    </div>
                                    <div class="col-6">

                                    </div>
                                    <div class="col-6">
                                        <label for="UsFirstName" class="form-label required">ชื่อ (ภาษาไทย)</label>
                                        <input type="text" class="form-control" name="UsFirstName" id="UsFirstName" placeholder="ชื่อภาษาไทย" value="<?php echo !empty($edit) ? $edit['UsFirstName'] : ""; ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsLastName" class="form-label required">นามสกุล (ภาษาไทย)</label>
                                        <input type="text" class="form-control" name="UsLastName" id="UsLastName" placeholder="นามสกุลภาษาไทย" value="<?php echo !empty($edit) ? $edit['UsLastName'] : ""; ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsFirstName" class="form-label required">ชื่อ (ภาษาอังกฤษ)</label>
                                        <input type="text" class="form-control" name="UsFirstName" id="UsFirstName" placeholder="ชื่อภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['UsFirstName'] : ""; ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsLastName" class="form-label required">นามสกุล (ภาษาอังกฤษ)</label>
                                        <input type="text" class="form-control" name="UsLastName" id="UsLastName" placeholder="นามสกุลภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['UsLastName'] : ""; ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsGpID" class="form-label required">เพศ</label>
                                        <select class="form-select select2" data-placeholder="-- กรุณาเลือกกลุ่มผู้ใช้ --" name="UsGpID" id="UsGpID1" required>
                                            <option value=""></option>
                                            <option value="1">หญิง</option>
                                            <option value="2">ชาย</option>
                                            <option value="3">อื่นๆ</option>
                                            <!-- <option value="3"></option> -->
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsLastName" class="form-label required">เลขบัตรประชาชน</label>
                                        <input type="text" class="form-control" name="UsLastName" id="UsLastName" placeholder="เลขบัตรประชาชน" value="<?php echo !empty($edit) ? $edit['UsLastName'] : ""; ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsEmail" class="form-label required">วันเกิด</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="UsEmail" class="form-label required">E-mail</label>
                                        <input type="email" class="form-control" name="UsEmail" id="UsEmail" placeholder="example@example.com" value="<?php echo !empty($edit) ? $edit['UsEmail'] : ""; ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="UsEmail" class="form-label ">facebook</label>
                                        <input type="text" class="form-control" name="UsEmail" id="UsEmail" placeholder="facebook" value="<?php echo !empty($edit) ? $edit['UsEmail'] : ""; ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="UsEmail" class="form-label">แนบรูป</label>
                                        <input type="file" class="form-control" name="UsEmail" id="UsEmail" placeholder="facebook" value="<?php echo !empty($edit) ? $edit['UsEmail'] : ""; ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="UsDesc" class="form-label">หมายเหตุ</label>
                                        <textarea class="form-control" name="UsDesc" id="UsDesc" placeholder="กรอกคำอธิบาย" rows="4" value="<?php echo !empty($edit) ? $edit['UsDesc'] : ""; ?>"></textarea>
                                    </div>
                                    <div class="mt-3 mb-3 col-12">
                                        <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/User'">ย้อนกลับ</button>
                                        <button type="submit" class="btn btn-success float-end">บันทึก</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade row g-" id="permission" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        ที่อยู่ตามทะเบีบนบ้าน
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label for="UsLastName" class="form-label required">ที่อยู่</label>
                                                                <input type="text" class="form-control" name="UsLastName" id="UsLastName" placeholder="ที่อยู่" value="<?php echo !empty($edit) ? $edit['UsLastName'] : ""; ?>" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="UsEmail" class="form-label required">ตำบล</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="UsEmail" class="form-label required">อำเภอ</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="UsEmail" class="form-label required">จังหวัด</label>
                                                                <input type="text" class=" form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="UsEmail" class="form-label required">รหัสไปรษณี</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mt-3">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        ที่อยู่ปัจจุบัน
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label for="UsLastName" class="form-label required">ที่อยู่</label>
                                                                <input type="text" class="form-control" name="UsLastName" id="UsLastName" placeholder="ที่อยู่" value="<?php echo !empty($edit) ? $edit['UsLastName'] : ""; ?>" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="UsEmail" class="form-label required">ตำบล</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="UsEmail" class="form-label required">อำเภอ</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="UsEmail" class="form-label required">จังหวัด</label>
                                                                <input type="text"" class=" form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="UsEmail" class="form-label required">รหัสไปรษณี</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-3 col-12">
                                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/User'">ย้อนกลับ</button>
                                                <button type="submit" class="btn btn-success float-end">บันทึก</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade row g-" id="Education" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        ข้อมูลที่ประวัติการศึกษา
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="UsLastName" class="form-label required">ระดับการศึกษา</label>
                                                                <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                                                    <option value=""></option>
                                                                    <option value="1">นายแพทย์</option>
                                                                    <option value="1">แพทย์หญิง</option>
                                                                    <option value="1">อาจายร์นายแพทย์</option>
                                                                    <option value="1">ทันตแพทย์หญิง</option>
                                                                    <option value="1">ทันตแพทย์</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <label for="UsEmail" class="form-label required">วุฒิการศึกษา</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <label for="UsEmail" class="form-label required">สาขาวิชา</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <label for="UsEmail" class="form-label required">สถานศึกษา</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="UsLastName" class="form-label required">ประเทศ</label>
                                                                <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                                                    <option value=""></option>
                                                                    <option value="1">ไทย</option>
                                                                    <option value="1">อังกฤษ</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <div>
                                                                    <label for="UsEmail" class="form-label required">วันที่เริ่มศึกษา</label>
                                                                    <input type="date" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div>
                                                                    <label for="UsEmail" class="form-label required">วันที่จบศึกษา</label>
                                                                    <input type="date" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12  mt-1 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="gridCheck2">
                                                                    <label for="UsEmail" class="form-check-label">วุฒิสูงสุด</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12  mt-1 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="gridCheck2">
                                                                    <label for="UsEmail" class="form-check-label">วุติบรรจุราชการ</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label mb-2">ประเภทสาขา</label>
                                                                <div id="div_dept_name">
                                                                    <div><label><input type="radio" class="form-check-input" name="edu_mjt" id="edu_mjt_4" value="4">สาขาทางการแพทย์</label></div><br>
                                                                    <div><label><input type="radio" class="form-check-input" name="edu_mjt" id="edu_mjt_5" value="5">สาขาอื่นๆ ที่เกี่ยวข้องกับการแพทย์</label></div><br>
                                                                    <div><label><input type="radio" class="form-check-input" name="edu_mjt" id="edu_mjt_6" value="6">สาขาวิทยาศาสตร์สุขภาพ</label></div><br>
                                                                    <div><label><input type="radio" class="form-check-input" name="edu_mjt" id="edu_mjt_7" value="7">สาขาอื่นๆ</label></div><br>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <label for="UsLastName" class="form-label required">เกียรตินิยม</label>
                                                                <select class="form-select select2" data-placeholder="-- ระดับเกียรตินิยม --" name="UsTitle" id="UsTitle" required>
                                                                    <option value=""></option>
                                                                    <option value="1">เกือบนิยมอันดับ1</option>
                                                                    <option value="1">เกือบนิยมอันดับ2</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="inputNumber" class="col-sm-4 col-form-label">แนบไฟล์เอกสารหลักฐาน</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file" id="formFile">
                                                                </div>
                                                            </div>
                                                            <div class=" mb-3 col-12">
                                                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/User'">เคลียร์ข้อมูล</button>
                                                                <button type="submit" class="btn btn-success float-end">บันทึก</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mt-3">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        ตารางข้อมูลการศึกษา
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table datatable" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">ระดับ</th>
                                                                    <th scope="col">วุฒิการศึกษา</th>
                                                                    <th scope="col">สาขาวิชา</th>
                                                                    <th scope="col">สถานศึกษา</th>
                                                                    <th scope="col">วันที่เริ่มศึกษา</th>
                                                                    <th scope="col">วันที่จบศึกษา</th>
                                                                    <th scope="col">ดำเนินงาน</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php for ($i = 0; $i < 15; $i++) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="text-center"><?php echo $i + 1; ?></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">อนุบาล</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">อนุบาล1</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">โรงเรียนหนองอีโกง</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">31 เมษายน 2560</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">31 เมษายน 2560</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">การผดุงครรภ์</div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="text-center option">
                                                                                <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
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
                                </div>
                            </div>
                            <div class="tab-pane fade row g-" id="license" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        บันทึกข้อมูลใบประกอบวิชาชีพ
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="UsLastName" class="form-label required">ชื่อวิชาชีพ </label>
                                                                <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="UsTitle" id="UsTitle" required>
                                                                    <option value=""></option>
                                                                    <option value="1">นายแพทย์</option>
                                                                    <option value="1">แพทย์หญิง</option>
                                                                    <option value="1">อาจายร์นายแพทย์</option>
                                                                    <option value="1">ทันตแพทย์หญิง</option>
                                                                    <option value="1">ทันตแพทย์</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="UsEmail" class="form-label required">เลขใบประกอบวิชาชีพ</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="col-12">
                                                                <div>
                                                                    <label for="UsEmail" class="form-label required">วันที่ออกบัตร</label>
                                                                    <input type="date" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12  mt-1 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="gridCheck2">
                                                                    <label for="UsEmail" class="form-check-label">ตลอดชีพ</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <label for="UsEmail" class="form-label required">วันหมดอายุ</label>
                                                                <input type="text"" class=" form-control">
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="inputNumber" class="col-sm-4 col-form-label">แนบไฟล์เอกสารหลักฐาน</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file" id="formFile">
                                                                </div>
                                                            </div>
                                                            <div class="mt-3 mb-3 col-12">
                                                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/User'">เคลียร์ข้อมูล</button>
                                                                <button type="submit" class="btn btn-success float-end">บันทึก</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mt-3">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        ตารางข้อมูลในประกอบวิชาชีพ
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table datatable" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">เลขที่ใบประกอบวิชาชีพ</th>
                                                                    <th scope="col">วันที่ออกบัตร</th>
                                                                    <th scope="col">วันที่บัตรหมดอายุ</th>
                                                                    <th scope="col">ชื่อวิชาชีพ</th>
                                                                    <th scope="col">ดำเนินการ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php for ($i = 0; $i < 15; $i++) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="text-center"><?php echo $i + 1; ?></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">1150</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">31 เมษายน 2560</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">31 เมษายน 2560</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center">การผดุงครรภ์</div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="text-center option">
                                                                                <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
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
                                </div>
                            </div>
                            <div class="tab-pane fade row g-" id="experience" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        บันทึกข้อมูลประสบการณ์การทำงาน
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body row">
                                                        <div class="col-8">
                                                            <label for="UsTitle" class="form-label required">วันที่ดำรงตำแหน่ง</label>
                                                            <div class="input-group date input-daterange">
                                                                <input type="date" class="form-control" name="StartDate" id="StartDate" placeholder="" value="">
                                                                <span class="input-group-text">ถึง</span>
                                                                <input type="date" class="form-control" name="EndDate" id="EndDate" placeholder="" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label required">รายละเอียด (ภาษาไทย)</label>
                                                            <textarea class="form-control" name="" id=""></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label required">รายละเอียด (ภาษาอังกฤษ)</label>
                                                            <textarea class="form-control" name="" id=""></textarea>
                                                        </div>
                                                        <div class="col-6 text-start">
                                                            <button type="button" class="btn btn-secondary">เคลียข้อมูล</button>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <button type="submit" class="btn btn-success">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mt-3">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        ตารางข้อมูลประสบการณ์การทำงาน
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table datatable" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-center">#</th>
                                                                    <th scope="col" class="text-center">รายละเอียด</th>
                                                                    <th scope="col" class="text-center">วันที่เริ่มต้น</th>
                                                                    <th scope="col" class="text-center">วันที่สิ้นสุด</th>
                                                                    <th scope="col" class="text-center">ดำเนินการ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php for ($i = 0; $i < 15; $i++) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="text-center"><?php echo $i + 1; ?></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-start">1150</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-start">31 เมษายน 2560</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-start">31 เมษายน 2560</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center option">
                                                                                <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
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
                                </div>
                            </div>
                            <div class="tab-pane fade row g-" id="expert" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        บันทึกข้อมูลความชำนาญ
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body row">
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label required">เรื่อง (ภาษาไทย)</label>
                                                            <input type="text" class="form-control" placeholder="ระบุเรื่องที่ชำนาญ เช่น การสอน การบริหาร ฯลฯ">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label ">เรื่อง (ภาษาอังกฤษ)</label>
                                                            <input type="text" class="form-control" placeholder="ระบุเรื่องที่ชำนาญ เช่น Tech Management Computer etc.">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label ">รายละเอียด (ภาษาไทย)</label>
                                                            <textarea class="form-control" name="" id=""></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label ">รายละเอียด (ภาษาอังกฤษ)</label>
                                                            <textarea class="form-control" name="" id=""></textarea>
                                                        </div>
                                                        <div class="col-6 text-start">
                                                            <button type="button" class="btn btn-secondary">เคลียข้อมูล</button>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <button type="submit" class="btn btn-success">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mt-3">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        ตารางข้อมูลความชำนาญ
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table datatable" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-center">#</th>
                                                                    <th scope="col" class="text-center">เรื่อง</th>
                                                                    <th scope="col" class="text-center">รายละเอียด</th>
                                                                    <th scope="col" class="text-center">ดำเนินการ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php for ($i = 0; $i < 4; $i++) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="text-center"><?php echo $i + 1; ?></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-start">การแพทย์</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-start">----</div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-center option">
                                                                                <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
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
                                </div>
                            </div>
                            <div class="tab-pane fade row g-" id="award" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        บันทึกข้อมูลรางวัล
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body row">
                                                        <div class="col-12 mb-2">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label for="UsTitle" class="form-label required">ด้านรางวัล</label>
                                                                    <select name="" class="select2 form-control" id="">
                                                                        <option value="" selected disabled>-- เลือกด้าน --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="UsTitle" class="form-label required">ระดับรางวัล</label>
                                                                    <select name="" class="select2 form-control" id="">
                                                                        <option value="" selected disabled>-- เลือกระดับ --</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label required">ชื่อรางวัลเชิดชูเกียรติ (ภาษาไทย)</label>
                                                            <textarea class="form-control" name="" id="" placeholder="ชื่อรางวัลเชิดชูเกียรติภาษาไทย"></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label ">ชื่อรางวัลเชิดชูเกียรติ (ภาษาอังกฤษ)</label>
                                                            <textarea class="form-control" name="" id="" placeholder="ชื่อชื่อรางวัลเชิดชูเกียรติภาษาอังกฤษ"></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label required">หน่วยงานที่มอบรางวัล (ภาษาอังกฤษ)</label>
                                                            <input type="text" class="form-control" placeholder="หน่วยงานที่มอบรางวัลภาษาไทย">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="UsTitle" class="form-label required">หน่วยงานที่มอบรางวัล (ภาษาไทย)</label>
                                                            <input type="text" class="form-control" placeholder="หน่วยงานที่มอบรางวัลภาษาอังกฤษ">
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <label for="UsTitle" class="form-label required">ปีที่เริ่มเผยแพร่</label>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label for="">พ.ศ.</label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="">ค.ศ.</label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="UsTitle" class="form-label ">วันที่ได้รับรางวัล</label>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <input class="form-check-input mb-2" id="Adate_none" type="radio" name="Adate"> ไม่ระบุวันที่ได้รับรางวัล <br>
                                                                    <input class="form-check-input" type="radio" id="Adate_input" name="Adate"> ระบุวันที่ได้รับรางวัล
                                                                </div>
                                                                <div class="col-6 Ainput" hidden>
                                                                    <label for="">เดือน/วัน/ปี</label>
                                                                    <input type="date" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for=""> รูปรางวัล</label>
                                                            <input type="file" class="form-control mt-2">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for=""> รูปประกาศนียบัตร</label>
                                                            <input type="file" class="form-control mt-2">
                                                        </div>
                                                        <!-- <div class="col-12">
                                                            <div class="card">
                                                                <div class="accordion">
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header">
                                                                            <button class="accordion-button accordion-button-table" type="button">
                                                                                <i class="bi-search icon-menu"></i><span> รายชื่อผู้รับรางวัล</span></span>
                                                                                <a class="btn btn-primary" id="addP" style="margin-left: auto;">เพิ่มผู้รับรางวัล</a>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseShow" class="accordion-collapse collapse show">
                                                                            <div class="accordion-body">
                                                                                <table class="table" id="personAward">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th scope="col">
                                                                                                <div class="text-center">#</div>
                                                                                            </th>
                                                                                            <th scope="col" width="20%" class="text-center">ชื่อผู้ได้รางวัล</th>
                                                                                            <th scope="col" class="text-center">หน่วยงาน</th>
                                                                                            <th scope="col" class="text-center">ดำเนินการ</th>
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
                                                        </div> -->
                                                        <div class="col-6 text-start">
                                                            <button type="button" class="btn btn-secondary">เคลียข้อมูล</button>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <button type="submit" class="btn btn-success">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mt-3">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        ตารางข้อมูลความชำนาญ
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table datatable" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-center">#</th>
                                                                    <th scope="col" class="text-center">ปีเผยแพร่</th>
                                                                    <th scope="col" class="text-center">รางวัล/นวัตกรรม</th>
                                                                    <th scope="col" class="text-center">ด้านรางวัล</th>
                                                                    <th scope="col" class="text-center">ประเภทรางวัล</th>
                                                                    <th scope="col" class="text-center">ผู้รับรางวัล</th>
                                                                    <th scope="col" class="text-center">ไฟล์</th>
                                                                    <th scope="col" class="text-center">ดำเนินการ</th>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script>
    const tabItems = document.querySelectorAll('.list-group-item');
    $('#Adate_input').change(function() {
        // ตรวจสอบว่า checkbox ถูกเลือกหรือไม่
        if ($(this).is(':checked')) {
            // ค้นหา element ที่มีคลาสชื่อ autoDate และลบ attribute hidden
            $('.Ainput').removeAttr('hidden');
        }
    });
    $('#Adate_none').change(function() {
        // ตรวจสอบว่า checkbox ถูกเลือกหรือไม่
        if ($(this).is(':checked')) {
            // ค้นหา element ที่มีคลาสชื่อ autoDate และลบ attribute hidden
            $('.Ainput').attr('hidden', true);
        }
    });
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