<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>เพิ่มรูปแบบหมายเลขคิว</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form id="dynamicForm" class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Queue/add<?php echo isset($info) ? '/'.$info->cq_id : "" ?>">
                        <div class="col-md-6">
                            <label for="cq_name" class="form-label required">ชื่อหมายเลขคิว</label>
                            <input type="text" class="form-control" name="cq_name" id="cq_name" value="<?php echo isset($info) ? $info->cq_name : "" ?>" placeholder="ระบุชื่อเลขติดตาม" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cq_dpk_id" class="form-label required">ชื่อแผนก - ตัวย่อแผนก</label>
                            <select class="form-control select2" data-placeholder="-- เลือกแผนก --" name="cq_dpq_id" id="cq_dpq_id" required>
                                <option value=""></option>
                                <?php if (isset($keyword)) { ?>
                                    <?php foreach ($keyword as $key) : ?>
                                        <option value="<?php echo $key->dpq_id ?>" <?php echo isset($info)&& $info->cq_dpq_id==$key->dpq_id ? "selected" : "" ?>><?php echo $key->dpq_name.'-'.$key->dpq_keyword ?></option>
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="cq_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input <?php echo isset($info)&& $info->cq_active=='0' ? "" : "checked" ?> class="form-check-input" type="checkbox" name="cq_active" id="cq_active">
                                <label for="cq_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/que/Queue'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>