<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลตำแหน่งงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                        <div class="col-md-6">
                            <label for="StNameT" class="form-label required">ชื่อตำแหน่งงาน(ท)</label>
                            <input type="text" class="form-control" name="StNameT" id="StNameT" placeholder="ชื่อตำแหน่งงานภาษาไทย" value="<?php echo !empty($edit) ? $edit['StNameT'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StAbbrT" class="form-label">ชื่อย่อตำแหน่งงาน(ท)</label>
                            <input type="text" class="form-control" name="StAbbrT" id="StAbbrT" placeholder="ชื่อย่อตำแหน่งงานภาษาไทย" value="<?php echo !empty($edit) ? $edit['StAbbrT'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="StNameE" class="form-label required">ชื่อตำแหน่งงาน(E)</label>
                            <input type="text" class="form-control" name="StNameE" id="StNameE" placeholder="ชื่อตำแหน่งงานภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['StNameE'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StAbbrE" class="form-label">ชื่อย่อตำแหน่งงาน(E)</label>
                            <input type="text" class="form-control" name="StAbbrE" id="StAbbrE" placeholder="ชื่อย่อตำแหน่งงานภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['StAbbrE'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="StDesc" class="form-label">คำอธิบาย</label>
                            <input type="text" class="form-control" name="StDesc" id="StDesc" placeholder="คำอธิบายตำแหน่งงาน" value="<?php echo !empty($edit) ? $edit['StDesc'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="FileMenu" class="form-label required">กลุ่มตำแหน่งงาน</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกกลุ่มตำแหน่งงาน --" name="FileMenu" id="FileMenu" required>
                                <option value=""></option>
                                <option value="2">จักษุแพทย์</option>
                                <option value="3">โสต ศอ นาสิกแพทย์</option>
                                <option value="4">รังสีแพทย์</option>
                                <option value="1">ทันตแพทย์</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="StActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="StActive" id="StActive">
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Base_position'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>