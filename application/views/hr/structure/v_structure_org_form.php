<style>
    ul {
        list-style-type: none;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลโครงสร้างหน่วยงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                        <div class="col-12 text-center">
                            <h2 for="StNameT" class="text-center">หน่วยงานที่รับผิดชอบข้อมูล: วิทยาลัยพยาบาลบรมราชชนนี กรุงเทพ</h2>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อโครงสร้าง (ภาษาไทย)</label>
                            <input type="text" class="form-control" name="StNameT" id="StNameT" placeholder="ชื่อโครงสร้างภาษาไทย" value="<?php echo !empty($edit) ? $edit['StNameT'] : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อโครงสร้าง (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="StAbbrT" id="StAbbrT" placeholder="ชื่อโครงสร้างภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['StAbbrT'] : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">ชื่อโครงสร้างเดิมที่อ้างอิง</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <input type="checkbox" name="StDesc" id="gridCheck1" class="form-check-input" value="<?php echo !empty($edit) ? $edit['StDesc'] : ""; ?>">
                                            <label for="gridCheck1" class="form-check-label">วิทยาลัยพยาบาลบรมราชชนนี กรุงเทพ</label>
                                            <ul>
                                                <input type="checkbox" name="StDesc" id="gridCheck1-1" class="form-check-input" value="<?php echo !empty($edit) ? $edit['StDesc'] : ""; ?>">
                                                <label for="gridCheck1-1" class="form-check-label">ผู้อำนวยการวิทยาลัย</label>
                                                <li>
                                                    <ul>
                                                        <li>
                                                            <input type="checkbox" name="StDesc" id="gridCheck1-2" class="form-check-input" value="<?php echo !empty($edit) ? $edit['StDesc'] : ""; ?>">
                                                            <label for="gridCheck1-2" class="form-check-label">ฝ่ายบริหาร</label>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul> 
                                                <input type="checkbox" name="StDesc" id="gridCheck1-3" class="form-check-input" value="<?php echo !empty($edit) ? $edit['StDesc'] : ""; ?>"> 
                                                <label for="gridCheck1-3" class="form-check-label">ฝ่ายวิชาการ</label>
                                                <li>
                                                    <ul>
                                                        <li>
                                                            <input type="checkbox" name="StDesc" id="gridCheck1-4" class="form-check-input" value="<?php echo !empty($edit) ? $edit['StDesc'] : ""; ?>"> 
                                                            <label for="gridCheck1-4" class="form-check-label">งานภาควิชา</label>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>