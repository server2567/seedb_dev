<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลหัวเรื่องการอบรม</span><span class="badge bg-success"><?= isset($re_info) ? count($re_info) : 0 ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/develop/Develop_heading/get_Develop_heading_form'"><i class="bi-plus"></i> เพิ่มหัวเรื่องอบรม</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-start" scope="col" width="90%">หัวเรื่องการอบรม</th>
                                <th class="text-center" scope="col" data-orderable="false">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($devh_heading_list as $key => $value) : ?>
                                <tr>
                                    <td class="text-center"><?php echo $key + 1; ?></td>
                                    <td>
                                        <!-- ปุ่มสำหรับเปิด/ปิดข้อมูลย่อย -->
                                        <button class="btn btn-secondary p-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseChild<?php echo $key; ?>" aria-expanded="false" aria-controls="collapseChild<?php echo $key; ?>">
                                            <span class="f-18"><?php echo 'ชื่อหัวเรื่อง: ' . $value['devh_g_name']; ?> </span>
                                        </button>
                                        <!-- ข้อมูลย่อยที่ซ่อนอยู่ในแถวเดียวกัน -->
                                        <div id="collapseChild<?php echo $key; ?>" class="collapse mt-2 show">
                                            <table class="table table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" scope="col">ลำดับ</th>
                                                        <th class="text-center" scope="col">ชื่อหัวเรื่องการอบรม (ภาษาไทย)</th>
                                                        <th class="text-center" scope="col">ชื่อหัวเรื่องการอบรม (ภาษาอังกฤษ)</th>
                                                        <th class="text-center" scope="col">ครั้งที่</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($value['devh_child'] as $child_key => $child_value) : ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo ($key + 1) . '.' . ($child_key + 1); ?></td>
                                                            <td><?php echo $child_value['devh_name_th']; ?></td>
                                                            <td><?php echo $child_value['devh_name_en']; ?></td>
                                                            <td class="text-center"><?php echo $child_value['devh_seq']; ?></td>

                                                        </tr>

                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="text-center"><button class="btn btn-xl btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/develop/Develop_heading/get_Develop_heading_form/<?= $value['devh_g_id'] ?>'"><i class="bi-pencil"></i></button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function delete_develop_heading(devh_id) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการลบหัวการอบรมครั้งนี้ ใช่หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>delete_develop_heading',
                    data: {
                        devh_id: devh_id
                    }
                }).done(function(data) {
                    data = JSON.parse(data);
                    if (data.data.status_response == 1) {
                        dialog_success({
                            'header': text_toast_default_success_header,
                            'body': 'ลบข้อมูลสำเร็จ'
                        });
                        // Reload the page or update the table
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500)
                    } else {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': 'ลบข้อมูลไม่สำเร็จ'
                        });
                    }
                });
            }
        });
    }
</script>