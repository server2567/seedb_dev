<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> รายการข่าวสาร</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/News/show'"><i class="bi-plus"></i> เพิ่มรายการข่าวสาร </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>หัวเรื่อง</th>
                                <th class="text-center">วันที่เริ่มต้น</th>
                                <th class="text-center">วันที่สิ้นสุด</th>
                                <th class="text-center">ประเภทข่าวสาร</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($get as $key => $value) : ?>
                                <tr>
                                    <td class="text-center"><?php echo $key + 1; ?></td>
                                    <td><?php echo $value->news_name; ?></td>
                                    <td><?php echo  abbreDate4($value->news_start_date); ?></td>
                                    <td><?php echo abbreDate4($value->news_stop_date); ?></td>
                                    <td class="text-center">
                                        <i class="bi-circle-fill <?php echo $value->news_type == 1 ? "text-primary" : "text-warning"; ?>"></i>
                                        <?php echo $value->news_type == 1 ? "ปกติ" : "ด่วน"; ?>
                                    </td>
                                    <td class="text-center">
                                        <i class="bi-circle-fill <?php echo $value->news_active == 1 ? "text-success" : "text-danger"; ?>"></i>
                                        <?php echo $value->news_active == 1 ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?>
                                    </td>
                                    <td class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/News/edit/<?php echo $value->news_id ?>'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/ums/News/delete/<?php echo $value->news_id ?>"><i class="bi-trash"></i></button>
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