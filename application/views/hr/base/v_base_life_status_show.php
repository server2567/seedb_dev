<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลสถานะการมีชีวิต</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/profile/get_life_status_add'"><i class="bi-plus"></i> เพิ่มสถานะการมีชีวิต </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ข้อมูลสถานะการมีชีวิต (ภาษาไทย)</th>
                                <th class="text-center" scope="col">ข้อมูลสถานะการมีชีวิต (ภาษาอังกฤษ)</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ls_info as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1 ; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?= $item->psst_name ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?= $item->psst_name_en ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $item->psst_active == 'Y' ? "text-success" : "text-danger"; ?>"></i> <?php echo $item->psst_active == 'Y' ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Profile/get_life_status_edit/<?php echo $item->psst_id ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/Profile/delete_life_status/<?php echo $item->psst_id?>"><i class="bi-trash"></i></button>
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