<div class="modal-header">
  <h5 class="modal-title" id="detailModalLabel">รายละเอียดผลตรวจเครื่องมือหัตถการจากห้องปฏิบัติการ</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12 col-sm-11 col-md-11 mx-auto">
      <div class="card border">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
          <h4 class="mb-2 mb-sm-0">สถานะ : <span class="badge" style="background-color:<?= $ntr->ast_color; ?>">ได้รับการแจ้งผลตรวจเครื่องมือหัตถการจากห้องปฏิบัติการแล้ว</span></h4>
          <button id="saveImageBtn" class="btn btn-info mb-0"><i class="bi bi-image me-2"></i>บันทึกรูปภาพ</button>
        </div>
        <div id="cardToSave">
          <div class="card-body pb-2">
            <div class="d-flex justify-content-between align-items-center">
              <div class="mb-3 mb-sm-0 w-10">
                <img src="<?php echo base_url(); ?>/assets/img/logo/img_ppd_3.png" class="w-100">
              </div>
              <div>
                <h6 class="h4 mb-1">ของเลขนัดหมาย</h6>
                <h6 class="h2 mb-2"><?= $ntr->apm_cl_code; ?></h6>
                <span class='font-16  '><?= $ntr->stde_name_th; ?></span>
              </div>
            </div>
            <div class="mt-5">
              <div class="d-flex justify-content-between mb-3">
                <p class="heading-color fw-bold mb-2 mb-sm-0 font-18 w-80">วันที่ทำการตรวจ : <?php echo formatThaiDateNts($ntr->ntr_create_date); ?></p>
                <?php if($ntr->ntup_name_file){ ?>
                <a href="<?php echo site_url('ums/frontend/Dashboard_home_patient/getfile?path=' . rawurlencode($ntr->ntup_name_file) . '&patient_id=' . $ntr->ntr_pt_id); ?>" class="btn btn-success mb-0" id=""><i class="bi bi-file-pdf me-2"></i>ดาวน์โหลดผลตรวจ</a>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="card-body pt-0 pb-0">
            <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between px-0 pt-0">
              <h5 class="card-header-title mb-2 mb-sm-0">แพทย์ผู้ที่ตรวจ</h5>
            </div>
            <?php if ($ntr->ps_fname) { ?>
              <div class="card-body px-0">
                <div class="border rounded p-4 mb-4">
                  <div class="d-sm-flex align-items-center">
                    <div class="flex-shrink-0 mb-2 mb-sm-0 text-center w-15">
                      <img class="avatar rounded w-100" src="<?php echo site_url(); ?>/hr/getIcon?type=profile/profile_picture&image=<?php echo $ntr->psd_picture; ?>">
                    </div>
                    <div class="flex-grow-1 ms-sm-3">
                      <div class="row align-items-center">
                        <div class="col-sm mb-3 mb-sm-0">
                          <p class="mb-1 fw-bold">แพทย์ที่นัดหมาย</p>
                          <p class="heading-color mb-0"><?php echo $ntr->pf_name . '' . $ntr->ps_fname . ' ' . $ntr->ps_lname; ?>
                            <span class="badge text-bg-primary"></span>
                          </p>
                          <p class="mt-3">
                            <b>ความเชี่ยวชาญ</b>
                            <br>
                            <?php echo $ntr->pos_desc; ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="card-body pt-0">
            <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between px-0 pt-0">
              <h5 class="card-header-title mb-2 mb-sm-0">ผลการตรวจจากห้องปฏิบัติการทางการแพทย์</h5>
            </div>
            <div class="card-body px-0">
              <div class="border rounded p-4 mb-4">
                <div class="d-sm-flex align-items-center">
                  <div class="flex-grow-1 ms-sm-3">
                    <div class="row align-items-center">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <p class="mb-3 fw-bold">ผลสรุปการตรวจจากห้องปฏิบัติการทางการแพทย์</p>
                        <p class="heading-color mb-0"><?php echo $ntr->ntr_detail_lab; ?></p>
                      </div>
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <p class="mb-3 fw-bold">การให้คำแนะนำของแพทย์</p>
                        <p class="heading-color mb-0"><?php echo $ntr->ntr_detail_advice; ?></p>
                      </div>
                      <?php if($ntr->ntup_name_file){ ?>
                      <div class="col-sm-12 mb-3 mt-5 mb-sm-0 text-center">
                        <a href="<?php echo site_url('ums/frontend/Dashboard_home_patient/getfile?path=' . rawurlencode($ntr->ntup_name_file) . '&patient_id=' . $ntr->ntr_pt_id); ?>" class="btn btn-success mb-0" id=""><i class="bi bi-file-pdf me-2"></i>ดาวน์โหลดผลตรวจจากห้องปฏิบัติการทางการแพทย์</a>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
</div>
<script>
  document.getElementById('saveImageBtn').addEventListener('click', function() {
    html2canvas(document.getElementById('cardToSave')).then(function(canvas) {
      var link = document.createElement('a');
      link.download = '<?php echo $ntr->apm_cl_code; ?>.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });
  });
</script>