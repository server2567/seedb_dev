<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลจับคู่รหัสเครื่องลงเวลาทำงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/hr/Time_matching_code/add">   <!-- id="validate-form" data-parsley-validate   -->
                        <div class="col-md-6">
                            <label for="StNameT" class="form-label required">รหัสจากระบบบุคลากร </label>
                            <input disabled type="text" class="form-control" name="StNameT" id="StNameT" placeholder="รหัสของบุคคุลากร" value="<?php echo !empty($edit) ? $edit['StNameT'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StNameE" class="form-label required">ชื่อ-นามสกุล</label>
                            <input disabled type="text" class="form-control" name="StNameE" id="StNameE" placeholder="ชื่อและนามสกุลของบุคลากร" value="<?php echo !empty($edit) ? $edit['StNameE'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StDesc" class="form-label">รหัสจากเครื่องลงเวลาทำงาน</label>
                            <input type="text" class="form-control" name="StDesc" id="StDesc" placeholder="รหัสของเครื่องที่ใช้ลงเวลาทำงาน" value="<?php echo !empty($edit) ? $edit['StDesc'] : "" ;?>">
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/hr/Time_matching_code'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>