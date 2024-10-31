<?php $order = 1; ?>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-bell-fill icon-menu"></i><span>รายละเอียดการตั้งค่าการแจ้งเตือน<?php echo !empty($person_data->ps_name) ? 'ของ'.$person_data->ps_name : ""; ?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url()."index.php/ams/Setting_doctor/Setting_doctor_update/"; ?><?php echo !empty($usc_id) ? $usc_id : ""; ?>">
                        <!-- <input type="hidden" name="usc_us_id" value="<?php //echo !empty($usc_us_id) ? $usc_us_id : "" ;?>"> -->
                        <input type="hidden" name="usc_ps_id" value="<?php echo !empty($usc_ps_id) ? $usc_ps_id : "" ;?>">
                        <div class="col-md-6">
                            <label for="usc_wts_is_noti" class="form-label"><?php echo $order.'.'; $order++; ?> เปิดการแจ้งเตือนใกล้หมดเวลาพบผู้ป่วย</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="usc_wts_is_noti" id="usc_wts_is_noti" <?php echo !empty($edit) && $edit['usc_wts_is_noti'] == 1 ? "checked" : "" ;?>>
                                <label for="usc_wts_is_noti" class="form-check-label"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="usc_wts_is_noti_sound" class="form-label"><?php echo $order.'.'; $order++; ?> เปิดการแจ้งเตือนใกล้หมดเวลาด้วยเสียงหรือไม่</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="usc_wts_is_noti_sound" id="usc_wts_is_noti_sound" <?php echo !empty($edit) && $edit['usc_wts_is_noti_sound'] == 1 ? "checked" : "" ;?>>
                                <label for="usc_wts_is_noti_sound" class="form-check-label"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="usc_ams_minute" class="form-label required"><?php echo $order.'.'; $order++; ?> ระยะเวลาในการพบผู้ป่วย (นาที)</label>
                            <input type="number" class="form-control" name="usc_ams_minute" id="usc_ams_minute" placeholder="ระยะเวลาในการพบผู้ป่วย (นาที)" value="<?php echo !empty($edit) ? $edit['usc_ams_minute'] : 15 ;?>" required>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ams/Setting_doctor'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>