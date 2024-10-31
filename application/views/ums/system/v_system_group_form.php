<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($gp_id) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลสิทธิ์รายระบบ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url()."index.php/ums/System_group/"; ?><?php echo !empty($gp_id) ? "system_group_update/".$gp_id : "system_group_insert"; ?>">
                        <div class="col-md-6">
                            <label for="gp_name_th" class="form-label required">ชื่อสิทธิ์การใช้งาน(ท)</label>
                            <input type="text" class="form-control" name="gp_name_th" id="gp_name_th" placeholder="ชื่อสิทธิ์การใช้งานภาษาไทย" value="<?php echo !empty($edit) ? $edit['gp_name_th'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="gp_name_en" class="form-label required">ชื่อสิทธิ์การใช้งาน(E)</label>
                            <input type="text" class="form-control" name="gp_name_en" id="gp_name_en" placeholder="ชื่อสิทธิ์การใช้งานภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['gp_name_en'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="gp_detail" class="form-label">คำอธิบาย</label>
                            <input type="text" class="form-control" name="gp_detail" id="gp_detail" placeholder="คำอธิบายกลุ่มงาน" value="<?php echo !empty($edit) ? $edit['gp_detail'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="gp_st_id" class="col-form-label required">ระบบงานหลัก</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกระบบ --" name="gp_st_id" id="gp_st_id" required>
                                <option value=""></option>
                                <?php foreach ($systems as $row) { ?>
                                <option value="<?php echo $row['st_id']; ?>" <?php echo (!empty($edit) && (decrypt_id($row['st_id']) == $edit['gp_st_id'])) ? "selected" : "" ; ?>><?php echo $row['st_name_th']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="gp_url" class="form-label">URL หน้าแรก</label>
                            <input type="text" class="form-control" name="gp_url" id="gp_url" placeholder="URL หน้าแรกของสิทธิ์" value="<?php echo !empty($edit) ? $edit['gp_url'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="gp_is_medical" class="form-label">ขอบเขตการจัดการข้อมูล</label>
                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gp_is_medical[]" value="M" id="gp_is_medical_1" <?php echo !empty($edit) && in_array("M", explode(",", $edit['gp_is_medical'])) ? 'checked' :  '' ?>>
                                    <label for="gp_is_medical_1" class="form-check-label">สายแพทย์</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gp_is_medical[]" value="N" id="gp_is_medical_2" <?php echo !empty($edit) && in_array("N", explode(",", $edit['gp_is_medical'])) ? 'checked' :  '' ?>>
                                    <label for="gp_is_medical_2" class="form-check-label">สายการพยาบาล</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gp_is_medical[]" value="SM" id="gp_is_medical_3" <?php echo !empty($edit) && in_array("SM", explode(",", $edit['gp_is_medical'])) ? 'checked' :  '' ?>>
                                    <label for="gp_is_medical_3" class="form-check-label">สายสนับสนุนทางการแพทย์</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gp_is_medical[]" value="A" id="gp_is_medical_4" <?php echo !empty($edit) && in_array("A", explode(",", $edit['gp_is_medical'])) ? 'checked' :  '' ?>>
                                    <label for="gp_is_medical_4" class="form-check-label">สายบริหาร</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gp_is_medical[]" value="T" id="gp_is_medical_5" <?php echo !empty($edit) && in_array("T", explode(",", $edit['gp_is_medical'])) ? 'checked' :  '' ?>>
                                    <label for="gp_is_medical_5" class="form-check-label">สายเทคนิคและบริการ</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="gp_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="gp_active" id="gp_active" <?php echo !empty($edit) && $edit['gp_active'] == 1 ? "checked" : "" ;?>>
                                <label for="gp_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System_group'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>