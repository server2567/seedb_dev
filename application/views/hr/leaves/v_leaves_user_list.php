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
                        <div class="col-6">
                            <label for="SearchLastName" class="form-label">เลือกปีงบประมาณ</label>
                            <select class="select2" name="" id="">
                                <option value="-1" disabled>-- เลือกประเภทหน่วยงาน --</option>
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="all">ภายใน</option>
                                <option value="all">ภายนอก</option>
                            </select>
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
                                <th class="text-center" scope="col">ชื่อ-นามสกุล</th>
                                <th class="text-center" scope="col">ประเภทบุตลากร</th>
                                <th class="text-center" scope="col" width="15%">ประเภทสายงาน</th>
                                <th class="text-center" scope="col">อายุราชการ</th>
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
                                        <div class="text-start">นพ.บรรยง ชินกุลกิจนิวัฒน์</div>
                                    </td>
                                    <td>
                                        <div class="text-start">ข้าราชการ</div>
                                    </td>
                                    <td>
                                        <div class="text-start">สายสอน</div>
                                    </td>
                                    <td>
                                        <div class="text-start">35</div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
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