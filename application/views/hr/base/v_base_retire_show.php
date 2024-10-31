<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลสถานะปัจจุบัน</span><span class="badge bg-success"><?= isset($re_info) ?count($re_info):0 ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/retire/get_retire_add'"><i class="bi-plus"></i> เพิ่มสถานะปัจจุบัน</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อสถานะปัจุบันของบุคลากร</th>
                                <th class="text-center" scope="col">สถานะการปฏิบัติงาน</th>
                                <th class="text-center" scope="col">สถานะการลงเวลาทำงาน</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($re_info as $key => $item ) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key + 1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->retire_name; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><i class="bi-circle-fill  <?php echo $item->retire_ps_status == '1' ? 'text-success':'text-danger'; ?>"></i> <?php echo $item->retire_ps_status == '1' ? 'ปฏิบัติงานอยู่':'ออกจากหน้าที่'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><i class="bi-circle-fill  <?php echo $item->retire_timestamp== 'Y' ? 'text-success':'text-danger'; ?>"></i> <?php echo $item->retire_timestamp == 'Y' ? 'ต้องสแกนนิ้วมือ':'ไม่ต้องสแกนนิ้วมือ'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill  <?php echo $item->retire_active == '1' ? 'text-success':'text-danger'; ?>"></i> <?php echo $item->retire_active == '1'? 'เปิดใช้งาน':'ปิดใช้งาน'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/retire/get_retire_edit/<?php echo $item->retire_id ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/retire/delete_retire/<?php echo $item->retire_id ?>"><i class="bi-trash"></i></button>
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

