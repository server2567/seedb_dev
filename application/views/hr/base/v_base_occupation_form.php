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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>อาชีพของบุคคุลที่เกี่ยวข้อง</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                        <div class="col-12 text-center">
                            <h2 for="StNameT" class="text-center">ข้อมูลอาชีพ</h2>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่ออาชีพ (TH)</label>
                            <input type="text" class="form-control" name="StNameT" id="StNameT" placeholder="ระดับการศึกษาภาษาไทย" value="<?php echo !empty($edit) ? $edit['StNameT'] : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่ออาชีพ (EN)</label>
                            <input type="text" class="form-control" name="StAbbrT" id="StAbbrT" placeholder="ระดับการศึกษาภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['StAbbrT'] : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <input type="checkbox" name="StDesc" id="gridCheck1" class="form-check-input m-1" value="<?php echo !empty($edit) ? $edit['StDesc'] : ""; ?>">
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile/get_occupation'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>