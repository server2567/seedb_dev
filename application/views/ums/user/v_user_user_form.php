<style>
    .card-tabs ul.nav-tabs {
        border-top-right-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
        border-top-left-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
    }
    .card-tabs li button.nav-link, .card-tabs .nav-item-left {
        padding: 14px 1.25rem;
    }
    .card-tabs .nav-tabs {
        font-weight: bold;
    }
    .card-tabs .card-body {
        padding: 0 1.25rem var(--bs-card-spacer-y) 1.25rem;
    }

    .card form button.accordion-button:not(.collapsed) {
        color: var(--bs-primary);
    }

    .password-toggle {
        cursor: pointer;
    }
</style>

<div class="card card-tabs">
    <ul class="nav nav-tabs nav-tabs-bordered bg-primary-light" id="borderedTab" role="tablist">
        <div class="nav-item-left">
            <i class="bi-person icon-menu"></i><span><?php echo !empty($us_id) ? "แก้ไข" : "เพิ่ม"; ?>ข้อมูลผู้ใช้งานระบบ - กำหนดสิทธิ์</span>
        </div>
        <div class="nav-item-right">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab">แก้ไขข้อมูลผู้ใช้</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#permission" type="button" role="tab">กำหนดกลุ่มผู้ใช้</button>
            </li>
        </div>
    </ul>
    <div class="card-body">
		<form class="needs-validation" novalidate method="post" action="<?php echo base_url()."index.php/ums/User/"; ?><?php echo !empty($us_id) ? "user_update/".$us_id : "user_insert"; ?>">
            <div class="tab-content">
                <div class="tab-pane fade row g-3 show active" id="user" role="tabpanel">
                    <div class="row g-3">
                        <input type="hidden" name="us_ps_id" value="<?php echo !empty($edit) ? encrypt_id($edit['us_ps_id']) : "" ;?>">
                        <input type="hidden" name="us_sync" value="<?php echo !empty($edit) ? $edit['us_sync'] : "" ;?>">
                        <div class="col-md-12">
                            <label for="" class="form-label"><b>ข้อมูลส่วนตัว</b></label>
                        </div>
                        <div class="col-md-6">
                            <label for="us_name" class="form-label required">ชื่อ - นามสกุล</label>
                            <input type="text" class="form-control" name="us_name" id="us_name" placeholder="ชื่อ - นามสกุล" value="<?php echo !empty($edit) ? $edit['us_name'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="us_psd_id_card_no" class="form-label required">เลขบัตรประชาชน</label>
                            <input type="text" class="form-control" name="us_psd_id_card_no" id="us_psd_id_card_no" placeholder="เลขบัตรประชาชน" maxlength="17" value="<?php echo !empty($edit) ? $edit['us_psd_id_card_no'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="us_dp_id" class="form-label required">หน่วยงาน</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="us_dp_id" id="us_dp_id" required>
                                <option value=""></option>
                                <?php foreach ($departments as $row) { ?>
                                <option value="<?php echo $row['dp_id']; ?>" <?php echo (!empty($edit) && (decrypt_id($row['dp_id']) == $edit['us_dp_id'])) ? "selected" : "" ; ?>><?php echo $row['dp_name_th']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="us_bg_id" class="form-label">กลุ่มผู้ใช้</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกกลุ่มผู้ใช้ --" name="us_bg_id" id="us_bg_id">
                                <option value=""></option>
                                <?php foreach ($base_groups as $row) { ?>
                                <option value="<?php echo $row['bg_id']; ?>" <?php echo (!empty($edit) && (decrypt_id($row['bg_id']) == $edit['us_bg_id'])) ? "selected" : "" ; ?>><?php echo $row['bg_name_th']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="form-label"><b>ข้อมูลการเข้าใช้งานระบบ</b></label>
                        </div>
                        <div class="col-md-6">
                            <label for="us_username" class="form-label required">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" name="us_username" id="us_username" placeholder="กรุณากรอกชื่อผู้ใช้" value="<?php echo !empty($edit) ? $edit['us_username'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="us_username" class="form-label <?php echo !empty($us_id) ? "" : "required"; ?>">รหัสผ่าน</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="us_password" id="us_password" placeholder="กรุณากรอกเพื่อเปลี่ยนรหัสผ่าน" value="" <?php echo !empty($us_id) ? "" : "required"; ?>>
                                <span class="input-group-text password-toggle" onclick="togglePassword(this, 'us_password')"><i class="bi-eye-slash"></i></span>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <label for="UsQuestion" class="form-label required">คำถามส่วนตัว</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำถามส่วนตัว --" name="UsQuestion" id="UsQuestion" required>
                                <option value=""></option>
                                <option value="1">ชื่อสัตว์เลี้ยงของท่านคือ</option>
                                <option value="2">อาหารที่ท่านชอบทานที่สุด</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="UsAnswer" class="form-label required">คำตอบ</label>
                            <input type="text" class="form-control" name="UsAnswer" id="UsAnswer" placeholder="กรุณากรอกคำตอบ" value="<?php echo !empty($edit) ? $edit['UsAnswer'] : "" ;?>" required>
                        </div> -->
                        <div class="col-md-6">
                            <label for="us_email" class="form-label required">E-mail</label>
                            <input type="email" class="form-control" name="us_email" id="us_email" placeholder="example@example.com" value="<?php echo !empty($edit) ? $edit['us_email'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="us_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="us_active" id="us_active" <?php echo !empty($edit) && $edit['us_active'] == 1 ? "checked" : "" ;?>>
                                <label for="us_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="us_detail" class="form-label">หมายเหตุ</label>
                            <textarea class="form-control" name="us_detail" id="us_detail" placeholder="กรอกคำอธิบาย" rows="4" value="<?php echo !empty($edit) ? $edit['us_detail'] : "" ;?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade row g-" id="permission" role="tabpanel">
                    <div class="row g-3">
                        <?php
                            $i=0;
                            foreach ($systems as $sys) {
                                $count_group = 0;
                                foreach ($groups as $grp) {
                                    if($sys['st_id'] == $grp['gp_st_id'])
                                    $count_group++;
                                }
                        ?>
                        <div class="col-md-6">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $i+1; ?>">
                                        <button class="accordion-button bg-warning-subtle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i+1; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i+1; ?>">
                                            <?php echo $sys['st_name_th'] . (!empty($sys['st_name_abbr_en']) ? ' ('.$sys['st_name_abbr_en'].')' : ''); ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $i+1; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $i+1; ?>" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <?php
                                                if($count_group == 0) {
                                            ?>
                                                <div class="text-center"><?php echo $this->config->item('text_table_no_data'); ?></div>
                                            <?php } else { ?>
                                            <?php
                                                foreach ($groups as $grp) {
                                                    if($sys['st_id'] == $grp['gp_st_id']) {
                                                        $gp_id = encrypt_id($grp['gp_id']);
                                                        $is_checked = ""; //$menu['gpn_active'] == 1 ? "checked" :
                                                        if(!empty($edit_usergroups)) {
                                                            foreach ($edit_usergroups as $ug) {
                                                                if($ug['ug_gp_id'] == $grp['gp_id'])
                                                                $is_checked = "checked";
                                                            }
                                                        }
                                            ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="is_active-<?php echo $gp_id; ?>" id="is_active-<?php echo $gp_id; ?>" <?php echo $is_checked; ?>>
                                                    <input class="groups" type="hidden" name="checkbox_id[]" value="is_active-<?php echo $gp_id; ?>">
                                                    <label class="form-check-label" for="<?php echo $gp_id; ?>"><?php echo $grp['gp_name_th']; ?></label>
                                                </div>
                                            <?php
                                                } } }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $i++; }
                        ?>
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-3 col-md-12">
                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/User'">ย้อนกลับ</button>
                <button type="submit" class="btn btn-success float-end">บันทึก</button>
            </div>
        </form>
    </div>
</div>

<script>
    var old_us_bg_id = null;
    $(document).on('select2:selecting', '#us_bg_id', function (evt) {
        if(!is_null($(this).val()))
            old_us_bg_id = $(this).val()
    });

    $(document).on('select2:select', '#us_bg_id', function (evt) {
        let new_us_bg_id = $(this).val();
        
        Swal.fire({
            title: 'คำเตือน',
            text: 'เมื่อแก้ไขข้อมูลกลุ่มผู้ใช้งานจะมีผลต่อการตั้งค่าสิทธิ์การใช้งานของแต่ละระบบของผู้ใช้ท่านนี้ คุณต้องการให้ข้อมูลสิทธิ์การใช้งานของแต่ละระบบยังคงเดิมหรือไม่',
            icon: "warning",
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#dc3545",
            denyButtonColor: "#6c757d",
            confirmButtonText: 'คงเดิม',
            cancelButtonText: 'เคลียร์ข้อมูลทั้งหมด',
            denyButtonText: 'ยกเลิกการแก้ไข'
            }).then((result) => {
            if (result.isDenied) { // select deny button
                $(this).val(old_us_bg_id).trigger("change");
            }
            else if (!result.isConfirmed) { // select clear usergroup
                $('input.groups').each(function(){
                    var gp_id = $(this).val();
                    
                    $.ajax({
                        url: "<?php echo base_url()."index.php/ums/User/user_usergroup_check_group/"; ?>",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            bg_id: new_us_bg_id,
                            gp_id: gp_id,
                        },
                        success: function (data) {
                            if(data) // (true) if group is member in base_group
                                $('input[name="' + gp_id + '"]').prop('checked', true);
                            else
                                $('input[name="' + gp_id + '"]').prop('checked', false);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                })
            }
        });
    });


    document.addEventListener("DOMContentLoaded", function(event) {
        const numberInput = document.getElementById('us_psd_id_card_no');

        numberInput.addEventListener('input', (e) => {
            const cursorPosition = numberInput.selectionStart;
            const rawValue = numberInput.value.replace(/\D/g, ''); // Remove any non-digit characters
            const previousFormattedValue = numberInput.value;
            const formattedValue = formatNumber(rawValue);

            numberInput.value = formattedValue;

            adjustCursorPosition(numberInput, cursorPosition, previousFormattedValue, formattedValue);
        });
    });

    function formatNumber(value) {
        if (value.length === 0) {
            return '';
        }

        const part1 = value.substring(0, 1);
        const part2 = value.substring(1, 5);
        const part3 = value.substring(5, 10);
        const part4 = value.substring(10, 12);
        const part5 = value.substring(12, 13);

        let formatted = part1;
        if (part2) formatted += ' ' + part2;
        if (part3) formatted += ' ' + part3;
        if (part4) formatted += ' ' + part4;
        if (part5) formatted += ' ' + part5;

        return formatted;
    }

    function adjustCursorPosition(input, originalPosition, previousValue, currentValue) {
        // Calculate the cursor position based on changes in the value
        let formattedOriginalPos = formatNumber(previousValue.substring(0, originalPosition).replace(/\D/g, '')).length;

        // Count spaces added or removed
        let spacesBefore = (previousValue.substring(0, formattedOriginalPos).match(/ /g) || []).length;
        let spacesAfter = (currentValue.substring(0, formattedOriginalPos).match(/ /g) || []).length;

        // Adjust the position based on space differences
        let newPosition = originalPosition + (spacesAfter - spacesBefore);

        setTimeout(() => {
            input.setSelectionRange(newPosition, newPosition);
        }, 0);
    }

    function togglePassword(event, id) {
        var passwordInput = document.getElementById(id);
        console.log(passwordInput);
        if (passwordInput.type == "password") {
            passwordInput.type = "text";
            if (event.children.length > 0) {
                Array.from(event.children).forEach(i => {
                    if (i.tagName.toLowerCase() === 'i') {
                        i.classList.remove('bi-eye-slash')
                        i.classList.add('bi-eye');
                    }
                });
            }
        }
        else {
            passwordInput.type = "password";
            if (event.children.length > 0) {
                Array.from(event.children).forEach(i => {
                    if (i.tagName.toLowerCase() === 'i') {
                        i.classList.remove('bi-eye')
                        i.classList.add('bi-eye-slash');
                    }
                });
            }
        }
    }
</script>