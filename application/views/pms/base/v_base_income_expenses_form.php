<div class="card">
  <div class="accordion">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
          <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลประเภทรายจ่าย</span>
        </button>
      </h2>
      <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
        <div class="accordion-body">
          <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo site_url(); ?>/<?php echo $this->config->item('pms_path')?>/Base_income_expenses/add">
            <div class="col-md-6">
              <label for="" class="form-label">ชื่อประเภทรายจ่าย (ภาษาไทย) <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="" id="" placeholder="ชื่อประเภทรายจ่ายภาษาไทย" value="" required>
            </div>
            <div class="col-md-6">
              <label for="" class="form-label required">ชื่อประเภทรายจ่าย (ภาษาอังกฤษ)</label>
              <input type="text" class="form-control" name="" id="" placeholder="ชื่อประเภทรายจ่ายภาษาอังกฤษ" value="" required>
            </div>
            <div class="col-md-6">
              <label for="" class="form-label">คำอธิบาย</label>
              <textarea type="text" rows="5" class="form-control" name="" id="" placeholder="คำอธิบาย"></textarea>
            </div>
            <div class="col-md-6">
              <label for="StActive" class="form-label">สถานะ</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="StActive" id="StActive" checked>
                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
              </div>
            </div>
            <div class="col-md-12">
              <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url(); ?>/<?php echo $this->config->item('pms_path')?>/Base_income_expenses'">ย้อนกลับ</button>
              <input type="submit" class="btn btn-success float-end" value="บันทึก">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>