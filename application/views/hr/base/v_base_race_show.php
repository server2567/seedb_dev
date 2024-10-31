<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลเชื้อชาติ</span><span class="badge bg-success"><?= isset($rc_info) ? count($rc_info) : 0 ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Race/get_race_add'"><i class="bi-plus"></i> เพิ่มเชื้อชาติ </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อเชื้อชาติ (ภาษาไทย)</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rc_info as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key + 1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->race_name; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $item->race_active == '1' ? 'text-success' : 'text-danger' ;?>"></i> <?php echo $item->race_active == '1'? 'กำลังใช้งาน' : 'ปิดการใช้งาน' ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Race/get_race_edit/<?php echo $item->race_id?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/Race/delete_race/<?php echo $item->race_id;?>"><i class="bi-trash"></i></button>
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

