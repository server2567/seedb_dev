<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลประเภทบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อประเภทบุคลากรภาษาไทย (ท)</label>
                            <input type="text" class="form-control" name="StNameT" id="StNameT" placeholder="ชื่อประเภทบุคลากรภาษาไทย" value="<?php echo !empty($edit) ? $edit['StNameT'] : "" ;?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อประเภทบุคลากรภาษาอังกฤษ (EN)</label>
                            <input type="text" class="form-control" name="StAbbrT" id="StAbbrT" placeholder="ชื่อย่อประเภทบุคลากรภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['StAbbrT'] : "" ;?>">
                        </div>
                        <div class="col-6">
                            <label for="StDesc" class="form-label">คำอธิบาย</label>
                            <input type="text" class="form-control" name="StDesc" id="StDesc" placeholder="คำอธิบายตำแหน่งบริหารงาน" value="<?php echo !empty($edit) ? $edit['StDesc'] : "" ;?>">
                        </div>
                        <div class="col-6">
                            <label for="StActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="StActive" id="StActive">
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/hr/Structure_base_type_people'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>