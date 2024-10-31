<style>
  .step::before,
  .step::after {
    margin-left: -3px;
    width: 0.6%;
    opacity: 0.75;
  }
</style>
<div class="modal-header">
  <h5 class="modal-title" id="detailModalLabelTimeline">เส้นทางการรับบริการ</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mx-auto">
      <div class="card-header border-bottom d-flex justify-content-between align-items-center pt-0">
        <h6 class="mb-2 mb-sm-0 font-18" style="line-height: 1.7;">
          หมายเลขคิว : <b><?php echo !empty($que[0]['apm_ql_code']) ? $que[0]['apm_ql_code'] : '-'; ?></b><?php echo ' Visit : <b>'.$que[0]['apm_visit'].'</b>'; ?>
          <br>ชื่อแพทย์ : <b><?php echo !empty($que[0]['pf_name']) || !empty($que[0]['ps_fname']) || !empty($que[0]['ps_lname'])
                        ? $que[0]['pf_name'] . ' ' . $que[0]['ps_fname'] . ' ' . $que[0]['ps_lname']
                        : '-'; ?></b>
          <br>ชื่อแผนก : <b><?php echo !empty($que[0]['stde_name_th']) ? $que[0]['stde_name_th'] : '-'; ?></b>
          <br>วันที่เข้ารับบริการ : <b><?php echo !empty($que[0]['apm_date']) ? abbreDate2($que[0]['apm_date']) : '-'; ?></b>
        </h6>
        <button id="saveImageNews" class="btn btn-info mb-0"><i class="bi bi-image me-2"></i>บันทึกรูปภาพเส้นทาง</button>
      </div>
      <div id="cardToSave">
        <div class="card-body pb-2 pt-3">
          <div class="row fw-bold pb-2 ps-4 text-secondary">
            จุดบริการ
            <span class="btn btn-primary w-20 p-0 font-14 ms-5">จุดบริการปัจจุบัน
            </span>
            <span class="btn btn-warning w-30 p-0 font-14 ms-2" style="background: #977718; color: #ffffff; border: 1px solid #977718;">จุดบริการที่ดำเนินการแล้ว
            </span>
            <span class="btn btn-success w-20 p-0 font-14 ms-2">จุดบริการเริ่มต้น / สิ้นสุด
            </span>
          </div>
          <div class="row">
            <div class="steps steps-sm mt-3 font-18">
              <?php
              // ค้นหาลำดับสูงสุด (บนสุด)
              usort($ntdp[$que[0]['apm_id']], function ($a, $b) {
                return strcmp($b['ntdp_date_start'] . $b['ntdp_time_start'], $a['ntdp_date_start'] . $a['ntdp_time_start']);
                // return $b['ntdp_seq'] <=> $a['ntdp_seq']; // เรียงตาม ntdp_seq มากไปน้อย
              });

              $last_step_index = count($ntdp[$que[0]['apm_id']]);

              foreach ($ntdp[$que[0]['apm_id']] as $key_dt => $dt) {
                $step_number = $last_step_index - $key_dt; // ปรับลำดับจากมากไปน้อย

                if ($key_dt == 0) {
                  // จุดบนสุด
                  if ($dt['ntdp_in_out'] == 1) {
                    $step_color = 'background-color: #32c983; color:#003e02;'; // สีน้ำเงิน
                    $step_color_b = 'background-color: #d8ffc7;';
                    $date_time_text = '<b>จุดบริการที่ ' . $step_number . '</b>' . ' : ' . 
                    formatThaiDateTimeline($dt['ntdp_date_start'], $dt['ntdp_time_start'], $dt['ntdp_time_finish']).'';
                  } else {
                    $step_color = 'background-color: #47aeff; color:#003b56;'; // สีน้ำเงิน
                    $step_color_b = 'background-color: #b3d9ff;';
                    $date_time_text = '<b>จุดบริการที่ ' . $step_number . '</b>' . ' : ' . 
                    formatThaiDateTimeline($dt['ntdp_date_start'], $dt['ntdp_time_start'], $dt['ntdp_time_finish']).'';
                  }

                } elseif ($key_dt == $last_step_index - 1) {
                  // จุดล่างสุด
                  $step_color = 'background-color: #32c983; color:#003e02;'; // สีเขียว
                  $step_color_b = 'background-color: #d8ffc7;';
                  $date_time_text = '<b>จุดบริการที่ ' . $step_number . '</b>' . ' : ' . 
                  formatThaiDateTimeline($dt['ntdp_date_start'], $dt['ntdp_time_start'], $dt['ntdp_time_finish']).'';
                } else {
                  // จุดกลาง
                  $step_color = 'background-color: #cdb56e; color:#603900;'; // สีเทา (หรือสีอื่นๆ)
                  $step_color_b = 'background-color: #dbcfab;';
                  $date_time_text = '<b>จุดบริการที่ ' . $step_number . '</b>' . ' : ' . 
                  formatThaiDateTimeline($dt['ntdp_date_start'], $dt['ntdp_time_start'], $dt['ntdp_time_finish']).'';
                }

                // เพิ่มเงื่อนไขเพื่อตรวจสอบ ntdp_in_out = 1
                if ($dt['ntdp_in_out'] == 1) {
                  $date_time_text2 .= '<span class="font-weight-600 text-success"> (สิ้นสุดการเข้ารับบริการ </span><span class="text-success"> เวลาเข้ารับบริการทั้งหมด ' . $total_minutes . ' นาที)</span>';
                }
              ?>
                <div class="step">
                  <div class="step-number" style="top: <?php echo $key_dt == 0 ? '-20px;' : '0'; ?>; <?php echo $step_color_b; ?>">
                    <div class="step-number-inner" style="<?php echo $step_color; ?>"><?php echo $step_number; ?></div>
                  </div>
                  <div class="step-body">
                      <h5 class="mb-2">
                          <?php 
                          if ($dt['ntdp_function'] == 'location_step9') { 
                              echo 'นัดหมายครั้งถัดไป'; 
                          } elseif ($dt['ntdp_function'] == 'Manage_queue_trello_success') { 
                              echo 'คัดยา'; 
                          } else { 
                              echo $dt['loc_name']; 
                          } 
                          
                          // เงื่อนไขเพิ่มเติม ถ้า ntdp_in_out == 1
                          if ($dt['ntdp_in_out'] == 1) { 
                              echo $date_time_text2; 
                          } 
                          ?>
                      </h5>
                      <p class="mb-0"><?php echo $date_time_text; ?></p>
                  </div>
                </div>
              <?php
              } 
              ?>


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
  document.getElementById('saveImageNews').addEventListener('click', function() {
    html2canvas(document.getElementById('cardToSave')).then(function(canvas) {
      var link = document.createElement('a');
      link.download = '<?php echo $que[0]['apm_visit'];?>.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });
  });
</script>