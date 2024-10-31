<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <?php if (!empty($dp_info)) { ?>
        <?php foreach ($dp_info as $key => $value) { ?>
            <?php
            $filtered = array_filter($order_data_type,  function ($item) use ($value) {
                return decrypt_id($item->ordt_dp_id) == decrypt_id($value->dp_id);
            });
            ?>
            <div class="card m-1">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $key == 0 ? 'active' : '' ?>" id="depart-<?= decrypt_id($value->dp_id) ?>-tab" data-bs-toggle="pill" data-bs-target="#depart<?= decrypt_id($value->dp_id) ?>" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><?= $value->dp_name_th ?> <span class="badge bg-success"><?= count($filtered) ?></span></button>
                </li>
            </div>
        <?php } ?>
    <?php } ?>
</ul>
<div class="tab-content pt-2" id="myTabContent">
    <?php if (!empty($dp_info)) { ?>
        <?php foreach ($dp_info as $key => $value) { ?>
            <?php
            $filtered = array_filter($order_data_type,  function ($item) use ($value) {
                return decrypt_id($item->ordt_dp_id) == decrypt_id($value->dp_id);
            });
            ?>
            <?php $index = 0; ?>
            <div class="tab-pane fade <?= $key == 0 ? 'active' : '' ?> show" id="depart<?= decrypt_id($value->dp_id) ?>" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-people icon-menu"></i><span> ประเภทการเรียงข้อมูลบุคลากร<?= $hire_is_medical ?></span><span class="summary_person badge bg-success"></span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="btn-option mb-3">
                                        <a class="btn btn-primary" href="<?php echo site_url() . "/" . $controller_dir . "get_order_person_type_add/$value->dp_id"; ?>" title="คลิกเพื่อเพิ่มรายชื่อบุคลากร" data-toggle="tooltip" data-placement="top"><i class="bi-plus"></i> เพิ่มประเภทการจัดเรียงข้อมูล </a>
                                    </div>
                                    <table id="person_list" class="table datatable" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">ชื่อระบบ</th>
                                                <th class="text-center">ชื่อเมนู</th>
                                                <th class="text-center">ประเภทการเรียงข้อมูล</th>
                                                <th class="text-center">วันที่แก้ไขล่าสุด</th>
                                                <th class="text-center">สถานะการทำงาน</th>
                                                <th class="text-center">ดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($filtered)) : ?>
                                                <?php $index = 0; ?>
                                                    <?php foreach ($filtered as $key => $item) : ?>
                                                        <tr>
                                                            <td>
                                                                <div class="text-center"><?php echo ++$index; ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-start"><?php echo $item->ordt_st_name ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-start"><?php echo $item->ordt_mn_name ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-start"><?php echo $item->ordt_name ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-start"><?php echo $item->ordt_update ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-center"><i class="bi-circle-fill <?php echo $item->ordt_active == '1' ? 'text-success' : 'text-danger' ?>"></i> <?php echo $item->ordt_active == '1' ? 'เปิดใช้งาน' : 'ปิดใช้งาน' ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-center option">
                                                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/order_person/get_order_person_type_edit/<?= $item->ordt_id ?>'"><i class="bi-pencil-square"></i></button>
                                                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/profile/order_person/delete_oreder_perton_type/<?= $item->ordt_id ?>"><i class="bi-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>