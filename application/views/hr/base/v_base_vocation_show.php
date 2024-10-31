<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลประเภทวิชาชีพ</span><span class="badge bg-success"><?= isset($voc_info)? count($voc_info) : 0?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/vocation/get_vocation_add'"><i class="bi-plus"></i> เพิ่มวิชาชีพ</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อประเภทวิชาชีพ (ภาษาไทย)</th>
                                <th class="text-center" scope="col">สิทธิในการรับเงินไม่ทำเวชปฏิบัติ</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($voc_info as $key => $item ) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key + 1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->voc_name; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->voc_done == 'Y' ? 'มี':'ไม่มี'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill  <?php echo $item->voc_active == '1' ? 'text-success':'text-danger'; ?>"></i> <?php echo $item->voc_active == '1'? 'เปิดใช้งาน':'ปิดใช้งาน'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/vocation/get_vocation_edit/<?php echo $item->voc_id ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/vocation/delete_vocation/<?php echo $item->voc_id ?>"><i class="bi-trash"></i></button>
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

