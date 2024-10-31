<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>สถานะการอนุมัติการลา</span><span id="count_data" class="badge bg-success"> <?= isset($Leave_approve_status)? count($Leave_approve_status) : 0?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Leave_approve_status/get_Leave_approve_status_form'"><i class="bi-plus"></i>เพิ่มสถานะการอนุมัติการลา</button>
                    </div>
                    <table id="tableList" class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" width="25%" scope="col">ชื่อหน้าที่ผู้อนุมัติ</th>
                                <th class="text-center" scope="col">ชื่อทางการ</th>
                                <th class="text-center" scope="col">ชื่อเมื่ออนุมัติ</th>
                                <th class="text-center" scope="col">ชื่อเมื่อไม่อนุมัติ</th>
                                <th class="text-center" scope="col">รายละเอียด</th>
                                <th class="text-center" scope="col">สถานะ</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Leave_approve_status as $index => $value) : ?>
                                <tr>
                                    <td>
                                        <?= $index + 1 ?>
                                    </td>
                                    <td class="text-start">
                                        <?= $value->last_name ?>
                                    </td>
                                    <td class="text-start">
                                        <?= $value->last_mean ?>
                                    </td>
                                    <td class="text-start">
                                        <?= $value->last_yes ?>
                                    </td>
                                    <td class="text-start">
                                        <?= $value->last_no ?>
                                    </td>
                                    <td class="text-start">
                                        <?= $value->last_desc == '' || $value->last_desc == null ? '-' : $value->last_desc ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-center"><i class="bi-circle-fill  <?php echo $value->last_active == '1' ? "text-success" : "text-danger"; ?>"></i> <?php echo $value->last_active == '1' ? "กำลังใช้งาน" : "ยกเลิกการใช้งาน"; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Leave_approve_status/get_Leave_approve_status_form/<?php echo $value->last_id ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/Leave_approve_status/delete_Leave_approve_status/<?php echo $value->last_id ?>"><i class="bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
