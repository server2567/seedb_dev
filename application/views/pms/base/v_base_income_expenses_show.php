<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> ตารางแสดงข้อมูลพื้นฐานประเภทรายจ่าย</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo site_url(); ?>/<?php echo $this->config->item('pms_path') ?>/Base_income_expenses/insert'"><i class="bi-plus"></i> เพิ่มประเภทรายจ่าย </button>
                    </div>
                    <table class="table datatable" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ประเภทรายจ่าย</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 15; $i++) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $i + 1; ?></td>
                                    <td>แอดมิน ระบบ</td>
                                    <td class="text-center"><i class="bi-circle-fill <?php echo $i % 2 == 0 ? "text-success" : "text-danger"; ?>"></i> <?php echo $i % 2 == 0 ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?></td>
                                    <td class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/pms/Base_income_expenses/edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
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