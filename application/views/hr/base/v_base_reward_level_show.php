<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-trophy-fill icon-menu"></i><span>ระดับรางวัล</span><span class="badge bg-success"><?= isset($rwlv_info)? count($rwlv_info):0 ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/reward_level/get_reward_level_add'"><i class="bi-plus"></i> เพิ่มระดับรางวัล </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อระดับรางวัลภาษาไทย</th>
                                <th class="text-center" scope="col">ชื่อระดับรางวัลภาษาอังกฤษ</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($rwlv_info)) {
                                foreach ($rwlv_info as $key => $item) { ?>
                                    <tr>
                                        <td>
                                            <div class="text-center"><?php echo $key + 1; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->rwlv_name; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->rwlv_name_en; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="text-center"><i class="bi-circle-fill  <?php echo $item->rwlv_active == '1' ? "text-success" : "text-danger"; ?>"></i> <?php echo $item->rwlv_active == '1' ? "กำลังใช้งาน" : "ยกเลิกการใช้งาน"; ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center option">
                                                <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/reward_level/get_reward_level_edit/<?php echo $item->rwlv_id ?>'"><i class="bi-pencil-square"></i></button>
                                                <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() . 'index.php/hr/base/reward_level/delete_reward_level/'.$item->rwlv_id ?>"><i class="bi-trash"></i></button>
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