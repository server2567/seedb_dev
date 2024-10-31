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
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">ประเภทบุคลากร</label>
                            <select class="select2" name="" id="">
                                <option value="-1" disabled>-- เลือกประเภทหน่วยงาน --</option>
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="all" >ภายใน</option>
                                <option value="all" >ภายนอก</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="SearchFirstName" class="form-label">ตำแหน่งในการบริหารงาน</label>
                            <select class="select2" name="" id="">
                                <option value="-1" disabled>-- ตำแหน่งในการบริหารงาน --</option>
                                <option value="all" selected>ทั้งหมด</option>
                            </select>
                        </div>
                        <div class="col-3">
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
                        </div>
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
                    <i class="bi-people icon-menu"></i><span> ข้อมูลควบคุมวันลา</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ประเภทบุคลากร</th>
                                <th class="text-center" scope="col">ประเภทการลา</th>
                                <th class="text-center" scope="col" width="15%">ช่วงอายุ</th>
                                <th class="text-center" scope="col">จำนวนครั้งที่ลาได้</th>
                                <th class="text-center" scope="col">จำนวนวันที่ลาได้ต่อปี</th>
                                <th class="text-center" scope="col">จำนวนที่ลาได้ต่อครั้ง</th>
                                <th class="text-center" scope="col">จำนวนวันลาสะสมสูงสุด</th>
                                <th class="text-center" scope="col">ประเภทวัน</th>
                                <th class="text-center" scope="col">สถานการได้รับเงินเดือน</th>
                                <th class="text-center" scope="col">จำนวนวันที่อนุญาตให้ลาล่วงหน้า</th>
                                <th class="text-center" scope="col">จำนวนวันที่อนุญาตให้ลาย้อนหลัง</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 15; $i++) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $i + 1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center">ข้าราชการ</div>
                                    </td>
                                    <td>
                                        <div class="text-start">ลาป่วย (ปกติ)</div>
                                    </td>
                                    <td>
                                        <div class="text-center">01 วัน - 60 ปี</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">99</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">0</div>
                                    </td>
                                    <td>
                                        <div class="text-center">วันทำการ</div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi bi-check"></i></div>
                                    </td>
                                    <td>
                                        <div class="text-center">1</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/Control_leaves/control_leave_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger"><i class="bi-trash"></i></button>
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