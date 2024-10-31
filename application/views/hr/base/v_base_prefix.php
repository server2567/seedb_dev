<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>คำนำหน้า</span><span class="badge bg-success"><?= isset($pf) ? count($pf) : 0 ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/prefix/get_prefix_add'"><i class="bi-plus"></i> เพิ่มคำนำหน้า </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">คำนำหน้า (ภาษาไทย)</th>
                                <th class="text-center" scope="col">คำนำหน้า (ภาษาอังกฤษ)</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($pf)) {
                                foreach ($pf as $key => $item) { ?>
                                    <tr>
                                        <td>
                                            <div class="text-center"><?php echo $key + 1; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->pf_name; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->pf_name_en; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="text-center"><i class="bi-circle-fill  <?php echo $item->pf_active == '1' ? "text-success" : "text-danger"; ?>"></i> <?php echo $item->pf_active == '1' ? "กำลังใช้งาน" : "ยกเลิกการใช้งาน"; ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center option">
                                                <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/prefix/get_prefix_edit/<?php echo $item->pf_id ?>'"><i class="bi-pencil-square"></i></button>
                                                <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() . 'index.php/hr/base/Prefix/prefix_delete/'.$item->pf_id ?>"><i class="bi-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>