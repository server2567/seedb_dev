<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span></span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <!-- <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_add'"><i class="bi-plus"></i> เพิ่มรายชื่อบุคลากร </button>
                    </div> -->
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">เลขที่ตำแหน่ง</th>
                                <th class="text-center" scope="col">ชื่อ - นามสกุล</th>
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
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $i % 2 == 0 ? "text-success" : "text-danger"; ?>"></i> <?php echo $i % 2 == 0 ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/timework/Timework_person/get_format/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
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

