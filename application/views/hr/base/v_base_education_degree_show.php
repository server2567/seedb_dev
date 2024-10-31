<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลวุฒิการศึกษา</span><span class="badge bg-success"><?= isset($edudg_info)? count($edudg_info) : 0?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_degree/get_education_degree_add'"><i class="bi-plus"></i> เพิ่มวุฒิการศึกษา</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" width="25%" scope="col">วุฒิการศึกษา (ภาษาไทย)</th>
                                <th class="text-center" width="25%" scope="col">วุฒิการศึกษา (ภาษาอังกฤษ)</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($edudg_info as $key => $item ) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key + 1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->edudg_name.' ('.$item->edudg_abbr.')'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->edudg_name_en.' ('.$item->edudg_abbr_en.')'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill  <?php echo !empty($edudg_info) && $item->edudg_active == '1' ? 'text-success' : 'text-danger' ; ?>"></i> <?php echo !empty($edudg_info) && $item->edudg_active == '1' ? 'เปิดใช้งาน' : 'ปิดใช้งาน' ; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_degree/get_education_degree_edit/<?php echo $item->edudg_id ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/Education_degree/delete_education_degree/<?php echo $item->edudg_id ?>"><i class="bi-trash"></i></button>
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

