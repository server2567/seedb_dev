<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลการเตรียมตัวก่อนวันพบแพทย์</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Base_prepare/add">   <!-- id="validate-form" data-parsley-validate   -->
                        <div class="col-md-6">
                            <label for="StNameT" class="form-label required">ประเภทโรค</label>
                            <input type="text" class="form-control" name="StNameT" id="StNameT" placeholder="ระบุชื่อกลุ่มโรค" value="<?php echo !empty($edit) ? $edit['StNameT'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StNameE" class="form-label required">ข้อมูลการเตรียมตัวก่อนวันพบแพทย์</label>
                            <input type="text" class="form-control" name="StNameE" id="StNameE" placeholder="รายละเอียดการเตรียมตัวก่อนมาพบแพทย์" value="<?php echo !empty($edit) ? $edit['StNameE'] : "" ;?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="StActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="StActive" id="StActive">
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_prepare'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>