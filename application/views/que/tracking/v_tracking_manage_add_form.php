<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>เพิ่มรูปแบบหมายเลขนัดหมาย</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form id="dynamicForm" class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Tracking_manage/add">
                        <div class="col-md-6">
                            <label for="ct_name" class="form-label required">ชื่อหมายเลขนัดหมาย</label>
                            <input type="text" class="form-control" name="ct_name" id="ct_name" placeholder="ระบุชื่อหมายเลขนัดหมาย" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ct_dpk_id" class="form-label required">ชื่อแผนก - ตัวย่อแผนก</label>
                            <select class="form-control select2" data-placeholder="-- เลือกแผนก --" name="ct_dpk_id" id="ct_dpk_id" required>
                                <option value=""></option>
                                <?php if (isset($keyword)) { ?>
                                    <?php foreach ($keyword as $key) : ?>
                                        <option value="<?php echo $key->dpk_id ?>" ><?php echo $key->dpk_name.'-'.$key->dpk_keyword ?></option>
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ct_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input checked class="form-check-input" type="checkbox" name="ct_active" id="ct_active">
                                <label for="ct_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking_manage'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>