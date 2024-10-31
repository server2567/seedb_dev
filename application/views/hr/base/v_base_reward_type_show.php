<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-trophy-fill icon-menu"></i><span>ด้านรางวัล</span><span class="badge bg-success"><?= isset($rwt_info)? count($rwt_info):0 ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/reward_type/get_reward_type_add'"><i class="bi-plus"></i> เพิ่มด้านรางวัล </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อด้านรางวัลภาษาไทย</th>
                                <th class="text-center" scope="col">ชื่อด้านรางวัลภาษาอังกฤษ</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($rwt_info)) {
                                foreach ($rwt_info as $key => $item) { ?>
                                    <tr>
                                        <td>
                                            <div class="text-center"><?php echo $key + 1; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->rwt_name; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->rwt_name_en; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="text-center"><i class="bi-circle-fill  <?php echo $item->rwt_active == '1' ? "text-success" : "text-danger"; ?>"></i> <?php echo $item->rwt_active == '1' ? "กำลังใช้งาน" : "ยกเลิกการใช้งาน"; ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center option">
                                                <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/reward_type/get_reward_type_edit/<?php echo $item->rwt_id ?>'"><i class="bi-pencil-square"></i></button>
                                                <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() . 'index.php/hr/base/reward_type/delete_reward_type/'.$item->rwt_id ?>"><i class="bi-trash"></i></button>
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