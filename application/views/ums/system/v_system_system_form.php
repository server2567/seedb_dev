<style>
    .modal-body img {
        width: 100px;
        cursor: pointer;
    }
    .iconslist {
        grid-template-columns: repeat(auto-fit, minmax(133px, 1fr)) !important;
    }
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($st_id) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลระบบ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url()."index.php/ums/System/"; ?><?php echo !empty($st_id) ? "system_update/".$st_id : "system_insert"; ?>">
                        <input type="hidden" name="st_seq" value="<?php echo !empty($edit) ? $edit['st_seq'] : "0" ;?>">
                        <div class="col-md-6">
                            <label for="st_name_th" class="form-label required">ชื่อระบบ(ท)</label>
                            <input type="text" class="form-control" name="st_name_th" id="st_name_th" placeholder="ชื่อระบบภาษาไทย" value="<?php echo !empty($edit) ? $edit['st_name_th'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="st_name_abbr_th" class="form-label">ชื่อย่อระบบ(ท)</label>
                            <input type="text" class="form-control" name="st_name_abbr_th" id="st_name_abbr_th" placeholder="ชื่อย่อระบบภาษาไทย" value="<?php echo !empty($edit) ? $edit['st_name_abbr_th'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="st_name_en" class="form-label required">ชื่อระบบ(E)</label>
                            <input type="text" class="form-control" name="st_name_en" id="st_name_en" placeholder="ชื่อระบบภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['st_name_en'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="st_name_abbr_en" class="form-label">ชื่อย่อระบบ(E)</label>
                            <input type="text" class="form-control" name="st_name_abbr_en" id="st_name_abbr_en" placeholder="ชื่อย่อระบบภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['st_name_abbr_en'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="st_detail" class="form-label">คำอธิบาย</label>
                            <input type="text" class="form-control" name="st_detail" id="st_detail" placeholder="คำอธิบายระบบ" value="<?php echo !empty($edit) ? $edit['st_detail'] : "" ;?>">
                        </div>
                        <!-- <div class="col-md-3">
                            <label for="st_seq" class="form-label">ลำดับที่</label>
                            <input type="number" class="form-control" name="st_seq" id="st_seq" placeholder="ลำดับที่" value="<?php echo !empty($edit) ? $edit['st_seq'] : "" ;?>">
                        </div> -->
                        <div class="col-md-6">
                            <label for="st_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="st_active" id="st_active" <?php echo !empty($edit) && $edit['st_active'] == 1 ? "checked" : "" ;?>>
                                <label for="st_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="st_url" class="form-label required">หน้าแรกของระบบ</label>
                            <input type="text" class="form-control" name="st_url" id="st_url" placeholder="URL หน้าแรกของระบบ" value="<?php echo !empty($edit) ? $edit['st_url'] : "" ;?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="st_icon" class="form-label required">ไอคอนของระบบ</label>
                            <input type="text" class="form-control" name="st_icon" id="st_icon" placeholder="ไอคอนของระบบ" data-bs-toggle="modal" data-bs-target="#iconsModal" value="<?php echo !empty($edit) ? $edit['st_icon'] : "" ;?>" required>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="iconsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เลือกไอคอนของระบบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 iconslist">
                <?php foreach ($icons as $row) { ?>
                    <div class="icon">
                        <a href="#" onclick="chooseIcon('<?php echo $row['ic_name'];?>');">
                            <img src="<?php echo base_url()."index.php/ums/GetFile?type=".$row['ic_type']."&image=".$row['ic_name'];?>">
                        </a>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function chooseIcon(ic_name) {
        document.getElementById('st_icon').value = ic_name;
        var modal = bootstrap.Modal.getInstance(document.getElementById('iconsModal'));
        modal.hide();
    }
</script>