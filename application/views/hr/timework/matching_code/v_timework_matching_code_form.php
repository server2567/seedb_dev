<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($matching_detail) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลจับคู่รหัสเครื่องลงเวลาทำงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="#"> <!-- id="validate-form" data-parsley-validate   -->
                        <div class="col-md-6">
                            <label for="StNameT" class="form-label">รหัสจากระบบบุคลากร </label>
                            <input disabled type="text" class="form-control" name="StNameT" id="mc_ps_code" placeholder="รหัสของบุคคุลากร" data-value="<?= !empty($matching_detail) ? $matching_detail->ps_id : null  ?>" value="<?php echo !empty($matching_detail) ? $matching_detail->pos_ps_code : ""; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StNameE" class="form-label">ชื่อ-นามสกุล</label>
                            <input disabled type="text" class="form-control" name="StNameE" id="mc_ps_name" placeholder="ชื่อและนามสกุลของบุคลากร" value="<?php echo !empty($matching_detail) ? $matching_detail->pf_name_abbr . " " . $matching_detail->ps_fname . " " . $matching_detail->ps_lname : ""; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StDesc" class="form-label required">รหัสจากเครื่องลงเวลาทำงาน</label>
                            <input type="text" class="form-control" name="StDesc" id="mc_code" placeholder="รหัสของเครื่องที่ใช้ลงเวลาทำงาน" value="<?php echo !empty($mc_code->mc_code) ? $mc_code->mc_code : ""; ?>">
                        </div>
                        <div class="col-md-12">
                            <button type="button" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/timework/Timework_matching_code'" class="btn btn-secondary float-start">ย้อนกลับ</button>
                            <button type="button" onclick="saveMatchingCode(<?= !empty($mc_code) ? $mc_code->mc_id : 'null' ?>,<?= !empty($dp_id) ? $dp_id : 'null' ?>)" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function saveMatchingCode(mc_id, dp_id) {
        var ps_id = $('#mc_ps_code').data('value');
        var mc_code = $('#mc_code').val()
        if (!mc_code) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            $('#mc_code').focus();
            return 0;
        }
        var mc_post_id = mc_id
        var mc_post_dp_id = dp_id
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>check_code_already_use',
            type: 'POST',
            data: {
                mc_code: mc_code,
            },
            success: function(data) {
                var data = JSON.parse(data)
                if (data.data.status_response == 2) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'รหัสเครื่องลงเวลาทำงานนี้ถูกใช้งานแล้ว'
                    });
                    return 0
                } else {
                    $.ajax({
                        url: '<?php echo site_url() . "/" . $controller_dir; ?>submitMactingCode',
                        type: 'POST',
                        data: {
                            mc_id: mc_post_id,
                            mc_ps_id: ps_id,
                            mc_code: mc_code,
                            mc_dp_id: mc_post_dp_id
                        },
                        success: function(data) {
                            var data = JSON.parse(data)
                            if (data.data.method == 1) {
                                dialog_success({
                                    'header': text_toast_default_success_header,
                                    'body': text_toast_default_success_body
                                });
                                setInterval(() => {
                                    location.reload()
                                }, 2000);
                            } else {
                                dialog_success({
                                    'header': text_toast_default_success_header,
                                    'body': text_toast_default_success_body
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
            },
            error: function(xhr, status, error) {}
        });
    }
</script>