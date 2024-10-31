<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <?php if (!empty($dp_info)) { ?>
        <?php foreach ($dp_info as $key => $value) { ?>
            <?php
            $filtered = array_filter($stuc_info,  function ($item) use ($value) {
                return decrypt_id($item->stuc_dp_id) == decrypt_id($value->dp_id);
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
            $filtered = array_filter($stuc_info,  function ($item) use ($value) {
                return decrypt_id($item->stuc_dp_id) == decrypt_id($value->dp_id);
            });
            ?>
            <?php $index = 0; ?>
            <div class="tab-pane fade <?= $key == 0 ? 'active' : '' ?> show" id="depart<?= decrypt_id($value->dp_id) ?>" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-server icon-menu"></i><span> จัดการข้อมูลโครงสร้าง<?= $value->dp_name_th ?></span><span class="badge bg-success"><?= count($filtered) ?></span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="btn-option mb-3">
                                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/structure/Structure_org/stucture_org_add/<?= $value->dp_id ?>'"><i class="bi-plus"></i> สร้างโครงสร้าง<?= $value->dp_name_th ?> </button>
                                    </div>
                                    <table class="table datatable" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <div class="text-center">#</div>
                                                </th>
                                                <th scope="col" class="text-center">วันที่มีผลบังคับใช้</th>
                                                <th scope="col" class="text-center">วันที่สิ้นสุด</th>
                                                <th scope="col" class="text-center">สถานะการใช้งานโครงสร้าง<?= $value->dp_name_th ?></th>
                                                <th scope="col" class="text-center">วันที่สร้าง</th>
                                                <th scope="col" class="text-center">ดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($stuc_info)) { ?>
                                                <?php foreach ($stuc_info as $keys => $value2) { ?>
                                                    <?php if (decrypt_id($value2->stuc_dp_id) == decrypt_id($value->dp_id)) { ?>
                                                        <tr>
                                                            <td>
                                                                <div class="text-center"><?= ++$index ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-start"><?= $value2->stuc_confirm_date != null ?fullDateTH3($value2->stuc_confirm_date):'ยังไม่มีการบังคับใช้'  ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-start"><?= $value2->stuc_end_date != '9999-12-31' ? ($value2->stuc_end_date != null? fullDateTH3($value2->stuc_end_date) : '-'):'กำลังใช้งาน'  ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-center"><i class="bi-circle-fill  <?= $value2->stuc_status == '1' ? "text-success" : ($value2->stuc_status == '0' ? "text-danger" : "text-warning") ?>"></i> <?= $value2->stuc_status == '1' ? "โครงสร้างปัจจุบัน" : ($value2->stuc_status == '0' ? 'โครงสร้างเก่า' : 'รอการยืนยันโครงสร้าง') ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-start"><?= $value2->stuc_create_date != null ?formatThaiDateNews($value2->stuc_create_date):'ยังไม่มีการบังคับใช้'  ?></div>
                                                            </td>
                                                            <td>
                                                                <div class="text-center option">
                                                                    <?php if ($value2->stuc_status == 1) : ?>
                                                                        <button class="btn btn-success" title="โครงสร้างปัจจุบัน" data-value='<?= json_encode([$value2->stuc_dp_id, $value2->stuc_id]) ?>'><i class="bi bi-patch-check-fill"></i></button>
                                                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/structure/Structure_org/stucture_org_edit/<?= $value2->stuc_id ?>'"><i class="bi-pencil-square"></i></button>
                                                                    <?php else : ?>
                                                                        <button class="btn btn-light myButton" title="ยืนยันโครงสร้าง" data-value=' <?= json_encode([$value2->stuc_dp_id, $value2->stuc_id]) ?>'><i class="bi bi-patch-check"></i></button>
                                                                    <?php endif; ?>
                                                                    <button class="btn btn-info" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/structure/Structure_org/view/<?= $value2->stuc_id ?>'"><i class="bi-search"></i></button>
                                                                    <?php if ($value2->stuc_status == 2) : ?>
                                                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/structure/Structure_org/stucture_org_edit/<?= $value2->stuc_id ?>'"><i class="bi-pencil-square"></i></button>
                                                                        <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/structure/Structure_org/delete_structure_org/<?= $value2->stuc_id ?>"><i class="bi-trash"></i></button>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to attach event listeners to buttons
        function attachListeners() {
            document.querySelectorAll('.myButton').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    const dataValue = button.getAttribute('data-value');
                    if (dataValue) {
                        try {
                            const arrayValue = JSON.parse(dataValue);
                            Swal.fire({
                                title: 'ต้องการยืนยันโครงสร้าง',
                                text: "คุณต้องการยืนยันใช้งานโครงสร้างใช่ หรือไม่",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#198754',
                                cancelButtonColor: '#dc3545',
                                confirmButtonText: 'ตกลง',
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var today = new Date().toISOString().slice(0, 10);
                                    $.ajax({
                                        url: '<?php echo site_url() . '/' . $controller . 'structure_org/change_stuc_status'; ?>',
                                        method: 'POST',
                                        data: {
                                            id: arrayValue[1],
                                            dp_id: arrayValue[0],
                                            stuc_confirm_date: today
                                        }
                                    }).done(function(returnedData) {
                                        Swal.fire({
                                            position: "center",
                                            icon: "success",
                                            title: "บันทึกข้อมูลสำเร็จ",
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    });
                                }
                            });
                        } catch (error) {
                            console.error('Invalid JSON:', error);
                        }
                    } else {
                        console.error('Data value is empty or invalid JSON');
                    }
                });
            });
        }

        // Initial call to attach listeners
        attachListeners();

        // Re-attach listeners after each DataTable draw event
        $('.datatable').on('draw.dt', function() {
            attachListeners();
        });
    });
</script>