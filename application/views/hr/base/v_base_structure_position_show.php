<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลตำแหน่งในโครงสร้าง</span><span class="badge bg-success"><?= isset($stpo_info) ? count($stpo_info): 0?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/structure_position/get_structure_position_add'"><i class="bi-plus"></i> เพิ่มตำแหน่งในโครงสร้าง </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อตำแหน่งในโครงสร้าง (ภาษาไทย)</th>
                                <th class="text-center" scope="col">ชื่อตำแหน่งในโครงสร้าง (ภาษาอังกฤษ)</th>
                                <th class="text-center" scope="col">ชื่อตำแหน่งในโครงสร้าง (แสดงในระบบ)</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stpo_info as $key => $item) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo $key +1 ?>                                                           
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->stpo_name; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->stpo_name_en; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->stpo_used; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $item->stpo_active == '1'? 'text-success':'text-danger' ?>"></i> <?php echo $item->stpo_active == '1'? 'เปิดใช้งาน':'ปิดใช้งาน' ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/structure_position/get_structure_position_edit/<?php echo $item->stpo_id ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/structure_position/structure_position_delete/<?php echo $item->stpo_id ?>"><i class="bi-trash"></i></button>
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