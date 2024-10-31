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
                            <label for="StNameT" class="form-label required">รหัสจากระบบบุคลากร </label>
                            <input disabled type="text" class="form-control" name="StNameT" id="mc_ps_code" placeholder="รหัสของบุคคุลากร" data-value="<?= !empty($matching_detail) ? $matching_detail->ps_id : null  ?>" value="<?php echo !empty($matching_detail) ? $matching_detail->pos_ps_code : ""; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StNameE" class="form-label required">ชื่อ-นามสกุล</label>
                            <input disabled type="text" class="form-control" name="StNameE" id="mc_ps_name" placeholder="ชื่อและนามสกุลของบุคลากร" value="<?php echo !empty($matching_detail) ? $matching_detail->pf_name_abbr . " " . $matching_detail->ps_fname . " " . $matching_detail->ps_lname : ""; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StDesc" class="form-label">รหัสจากเครื่องลงเวลาทำงาน</label>
                            <input type="text" class="form-control" name="StDesc" id="mc_code" placeholder="รหัสของเครื่องที่ใช้ลงเวลาทำงาน" value="<?php echo !empty($mc_code->mc_code) ? $mc_code->mc_code : ""; ?>">
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start">ย้อนกลับ</button>
                            <button type="button" onclick="saveMatchingCode(1)" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function saveMatchingCode(mc_id) {
        var ps_id = $('#mc_ps_code').data('value');
        var mc_code = $('#mc_code').val()
        console.log('เข้า');
    }
</script>