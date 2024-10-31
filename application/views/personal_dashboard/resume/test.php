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
                        <div class="col-2">
                            <label for="SearchFirstName" class="form-label">ชื่อ</label>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="SearchFirstName" id="SearchFirstName" placeholder="ชื่อ" value="<?php echo !empty($edit) ? $edit['SearchFirstName'] : ""; ?>">
                        </div>
                        <div class="col-2">
                            <label for="SearchLastName" class="form-label">นามสกุล</label>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="SearchLastName" id="SearchLastName" placeholder="นามสกุล" value="<?php echo !empty($edit) ? $edit['SearchLastName'] : ""; ?>">
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
                    <i class="bi-people icon-menu"></i><span> รายชื่อบุคลากร</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_add'"><i class="bi-plus"></i> เพิ่มรายชื่อบุคลากร </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">เลขที่ตำแหน่ง</th>
                                <th class="text-center" scope="col">ชื่อ - นามสกุล</th>
                                <th class="text-center" scope="col">หน่วยงานย่อย</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
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
                                        <div class="text-center">1150</div>
                                    </td>
                                    <td>
                                        <div class="text-center">ขจรศักดิ์ ผักใบเขียว</div>
                                    </td>
                                    <td>
                                        <div class="text-center">โรงพยาบาล</div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $i % 2 == 0 ? "text-success" : "text-danger"; ?>"></i> <?php echo $i % 2 == 0 ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?></div>
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