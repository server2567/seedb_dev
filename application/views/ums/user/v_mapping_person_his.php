<?php if ($mapping_users != false) : ?>
    <div class="card">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button accordion-button-table" type="button">
                        <i class="bi-people icon-menu"></i><span> รายชื่อการจับคู่ผู้ใช้</span><span class="badge bg-success"><?php echo count($mapping_users); ?></span>
                    </button>
                </h2>
                <div id="collapseShow" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table datatable" style="width:100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th class="text-center" width="20%">ไอดีผู้ใช้ระบบ UMS</th>
                                    <th width="20%">ชื่อ-นามสกุล</th>
                                    <th width="20%">ชื่อเข้าใช้ระบบ UMS</th>
                                    <th width="20%">ชื่อเข้าใช้ระบบ HIS</th>
                                    <th class="text-center" width="20%">ไอดีผู้ใช้ระบบ HIS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($mapping_users as $row) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i + 1; ?></td>
                                        <td class="text-center" id="ums_<?= $i ?>"><?= $row['us_ums_id'] != 0 ? $row['us_ums_id']  : '<button class="btn btn-warning ums_insert" data-id="' . $row['us_his_id'] . '"  data-index="' . $i . '"><i class="bi bi-plus"> </i></button>' ?></td>
                                        <td><?= isset($row['us_name']) ? $row['us_name'] : $row['U_name'] . ' ' . $row['U_lastname']; ?></td>
                                        <td><?= isset($row['us_username']) ? $row['us_username'] : 'ยังไม่ได้ลงทะเบียน'; ?></td>
                                        <td><?= isset($row['Username']) ? $row['Username'] : 'ยังไม่ได้ลงทะเบียน'; ?></td>
                                        <td class="text-center" id="his_<?= $i ?>"><?= $row['us_his_id'] != 0 ? $row['us_his_id']  : '<button class="btn btn-warning his_insert" data-id="' . $row['us_ums_id'] . '" data-index="' . $i . '"><i class="bi bi-plus"> </i></button>' ?></td>
                                    </tr>
                                <?php
                                    $i++;
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
        $(document).ready(function() {
            // Setting Export Datatable.js
            var table = $('.datatable').DataTable();
            $('.datatable').on('click', '.ums_insert', function() {
                var userId = $(this).data('id');
                var index = $(this).data('index');
                Swal.fire({
                    title: 'ยืนยันการเพิ่มผู้ใช้งาน?',
                    text: "คุณต้องการเพิ่มผู้ใช้งานในระบบ UMS ใช่หรือไม่?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ถ้าผู้ใช้กดยืนยัน ให้ทำการเพิ่มข้อมูลที่นี่
                        $.ajax({
                            url: '<?php echo site_url() . "/" ?>ums/Mapping_person_his/insert_ums_user',
                            type: 'POST',
                            data: {
                                userId: userId
                            },
                            success: function(data) {
                                data = JSON.parse(data);
                                $("#ums_" + index).html(data.data.last_id);
                                // console.log(data.data.status_response)
                                if (data.data.status_response == status_response_success) {
                                    dialog_success({
                                        'header': text_toast_default_error_header,
                                        'body': data.data.message_dialog
                                    });
                                } else if (data.data.status_response == status_response_error) {
                                    dialog_error({
                                        'header': text_toast_default_error_header,
                                        'body': data.data.message_dialog
                                    });
                                }

                            },
                            error: function(xhr, status, error) {
                                dialog_error({
                                    'header': text_toast_default_error_header,
                                    'body': text_toast_default_error_body
                                });
                            }
                        });
                    }
                });
                // คุณสามารถเพิ่มการทำงานที่ต้องการได้ที่นี่
            });
            $('.datatable').on('click', '.his_insert', function() {
                var userId = $(this).data('id');
                var index = $(this).data('index');
                Swal.fire({
                    title: 'ยืนยันการเพิ่มผู้ใช้งาน?',
                    text: "คุณต้องการเพิ่มผู้ใช้งานในระบบ HIS ใช่หรือไม่?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ถ้าผู้ใช้กดยืนยัน ให้ทำการเพิ่มข้อมูลที่นี่
                        $.ajax({
                            url: '<?php echo site_url() . "/" ?>ums/Mapping_person_his/insert_his_user',
                            type: 'POST',
                            data: {
                                userId: userId
                            },
                            success: function(data) {
                                data = JSON.parse(data);
                                $("#his_" + index).html(data.data.last_id);
                                // console.log(data.data.status_response)
                                if (data.data.status_response == status_response_success) {
                                    dialog_success({
                                        'header': text_toast_default_error_header,
                                        'body': data.data.message_dialog
                                    });
                                } else if (data.data.status_response == status_response_error) {
                                    dialog_error({
                                        'header': text_toast_default_error_header,
                                        'body': data.data.message_dialog
                                    });
                                }

                            },
                            error: function(xhr, status, error) {
                                dialog_error({
                                    'header': text_toast_default_error_header,
                                    'body': text_toast_default_error_body
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
<?php else: ?>
    <div class="d-flex justify-content-center align-items-center" style="height: 500px;">
        <div class="card w-40 p-2" >
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <i class="bi bi bi-wifi-off text-info" style="font-size: 100px;"></i>
                    </div>
                    <div class="col-12">
                          <h2 class="text-danger">เกิดข้อผิดพลาด ! <br> การเชื่อมต่อกับฐานข้อมูลระบบ HIS ล้มเหลว</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>