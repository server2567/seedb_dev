
<div class="card">
   
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>เพิ่มเวลาการแจ้งเตือน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show"  aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate id="departmentForm" method="post" action="<?php echo base_url(); ?>index.php/ams/Base_alarm/update/<?php echo $info->al_id ?></form>" >
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="al_ntf_id" class="form-label font-weight-600 font-18 required">ประเภทช่องทางการแจ้งเตือน </label>
                                <select class="form-control" name="al_ntf_id" id="al_ntf_id" required>
                                    <option value="" disabled selected>--- เลือกแผนก ---</option>
                                    <?php if (isset($alarm)) { ?>
                                        <?php foreach ($alarm as $key) : ?>
                                            <option value="<?php echo $key->ntf_id ?>" ><?php echo $key->ntf_name ?></option>
                                        <?php endforeach ?>
                                        
                                            <option value="<?php echo $info->al_ntf_id ?>"  selected><?php echo $info->notify_name ?></option>
                                        
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="row mt-1 font-weight-600 font-18 required">
                                <label  class="form-label font-weight-600 font-18 ">การแจ้งล้วงหน้าก่อนการนัดหมาย</label>                                  </div>
                            <div class="col-md-4 mt-3">
                                <label for="al_number" class="form-label required">จำนวนครั้ง </label>
                                <input type="number" class="form-control" name="al_number" id="al_number" value="<?php echo $info->al_number ?>" placeholder="ชื่อประเภทการแจ้งเตือนภาษาอังกฤษ"  oninput="validateEnglishInput(this)" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="al_day" class="form-label required">วันที่แจ้ง </label>
                                <input type="number" class="form-control" name="al_day" id="al_day" value="<?php echo $info->al_day ?>" placeholder="ชื่อประเภทการแจ้งเตือนภาษาอังกฤษ"  oninput="validateEnglishInput(this)" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="al_minute" class="form-label required">เวลา (นาที) </label>
                                <input type="number" class="form-control" name="al_minute" id="al_minute" value="<?php echo $info->al_minute ?>" placeholder="ชื่อประเภทการแจ้งเตือนภาษาอังกฤษ"  oninput="validateEnglishInput(this)" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="al_time" class="form-label required"> ระยะเวลาระหว่างการแจ้งเตือน (นาที) </label>
                                <input type="number" class="form-control" name="al_time" id="al_time" value="<?php echo $info->al_time ?>" placeholder="ชื่อประเภทการแจ้งเตือนภาษาอังกฤษ"  oninput="validateEnglishInput(this)" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="al_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input <?php if($info->al_active=='1'){echo 'checked';} ?> class="form-check-input" type="checkbox" name="al_active" id="al_active" >
                                <label for="al_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ams/Base_alarm'">ย้อนกลับ</button>
                            <button type="submit" id="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
