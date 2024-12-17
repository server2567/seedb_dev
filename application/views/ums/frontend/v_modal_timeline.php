<style>
  .step::before,
  .step::after {
    margin-left: -3px;
    width: 0.6%;
    opacity: 0.75;
  }

  @media (max-width: 600px) {
    #timeline {
      zoom: 80%;
    }

    #timeline button#saveImageNews {
      display: none;
    }

    #timeline .card-header.border-bottom.d-flex.justify-content-between.align-items-center.pt-0 {
      display: block !important;
    }
    #timeline .row.fw-bold.pb-2.ps-4.text-secondary {
      font-size: 18px;
      color: #002639 !important;
    }
    #timeline span.btn.btn-primary.w-20.p-0.font-14.ms-5 {
      font-size: 18px !important;
    }
    #timeline span.btn.btn-warning.w-30.p-0.font-14.ms-2 {
      font-size: 18px !important;
    }
    #timeline span.btn.btn-success.w-20.p-0.font-14.ms-2 {
      font-size: 18px !important;
    }
  }
</style>
<div class="modal-header">
  <h5 class="modal-title" id="detailModalLabelTimeline">เส้นทางการรับบริการ</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" id="timeline">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mx-auto">
      <div class="card-header border-bottom d-flex justify-content-between align-items-center pt-0">
        <h6 class="mb-2 mb-sm-0 font-18" style="line-height: 1.7;">
          หมายเลขคิว : <b><?php echo !empty($que[0]['apm_ql_code']) ? $que[0]['apm_ql_code'] : '-'; ?></b><?php echo ' Visit : <b>' . $que[0]['apm_visit'] . '</b>'; ?>
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
            <div class="steps steps-sm mt-5 font-18">
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
                      formatThaiDateTimeline($dt['ntdp_date_start'], $dt['ntdp_time_start'], $dt['ntdp_time_finish']) . '';
                  } else {
                  $step_color = 'background-color: #47aeff; color:#003b56;'; // สีน้ำเงิน
                  $step_color_b = 'background-color: #b3d9ff;';
                  $date_time_text = '<b>จุดบริการที่ ' . $step_number . '</b>' . ' : ' . 
                      formatThaiDateTimeline($dt['ntdp_date_start'], $dt['ntdp_time_start'], $dt['ntdp_time_finish']) . '';
                  }
                } elseif ($key_dt == $last_step_index - 1) {
                  // จุดล่างสุด
                  $step_color = 'background-color: #32c983; color:#003e02;'; // สีเขียว
                  $step_color_b = 'background-color: #d8ffc7;';
                  $date_time_text = '<b>จุดบริการที่ ' . $step_number . '</b>' . ' : ' . 
                    formatThaiDateTimeline_strat($dt['ntdp_date_start'], $dt['ntdp_time_start']) . '';
                } else {
                  // จุดกลาง
                  $step_color = 'background-color: #cdb56e; color:#603900;'; // สีเทา (หรือสีอื่นๆ)
                  $step_color_b = 'background-color: #dbcfab;';
                  $date_time_text = '<b>จุดบริการที่ ' . $step_number . '</b>' . ' : ' . 
                    formatThaiDateTimeline($dt['ntdp_date_start'], $dt['ntdp_time_start'], $dt['ntdp_time_finish']) . '';
                }

                // เพิ่มเงื่อนไขเพื่อตรวจสอบ ntdp_in_out = 1
                if ($dt['ntdp_in_out'] == 1) {
                  $date_time_text2 .= '<span class="font-weight-600 font-22 text-success mb-3" style="position: absolute; top: -15px;">(เวลาเข้ารับบริการทั้งหมด ' . $total_minutes . ' นาที)<br></span>';
                }
              ?>
                <div class="step">
                  <div class="step-number" style="top: <?php echo $key_dt == 0 ? '-20px;' : '0'; ?>; <?php echo $step_color_b; ?>">
                    <div class="step-number-inner" style="<?php echo $step_color; ?>"><?php echo $step_number; ?></div>
                  </div>
                  <div class="step-body">
                    <?php
                    // ค้นหา index สุดท้ายของ "จ่ายยา"
                    $last_dispense_key = null;
                    foreach ($ntdp[$que[0]['apm_id']] as $key => $value) {
                      if ($value['loc_name'] === 'จ่ายยา') {
                        $last_dispense_key = $key; // บันทึกตำแหน่งของ "จ่ายยา" แถวสุดท้าย
                      }
                    }
                    ?>
                      <h5 class="mb-2">
                          <?php 
                        if ($dt['ntdp_in_out'] == 1) {
                          echo $date_time_text2.'</br>';
                        }
                      ?>
                      <?php
                          if ($dt['ntdp_function'] == 'location_step9') { 
                        echo 'นัดหมายผู้ป่วย';
                          } elseif ($dt['ntdp_function'] == 'Manage_queue_trello_success') { 
                        echo $dt['rm_name'];
                          } else { 
                        if ($dt['loc_name'] === 'จ่ายยา') {
                          // ตรวจสอบว่าคือแถวสุดท้ายของ "จ่ายยา"
                          if ($key_dt === $last_dispense_key) {
                            echo 'คัดยา/ผสมยา'; // แสดง "คัดยา/ผสมยา" สำหรับแถวสุดท้าย
                          } else {
                            echo 'จ่ายยา'; // แสดง "จ่ายยา" สำหรับแถวก่อนหน้า
                          }
                        } else {
                          if ($dt['loc_name'] === 'หน้าห้องตรวจ') {
                            echo $dt['loc_name'] . ' - ' . $dt['rm_name']; // แสดง loc_name และ rm_name
                          } else if ($dt['loc_name'] === 'เข้าห้องตรวจ - พบแพทย์'){
                            echo $dt['loc_name'] . ' (' . $que[0]['pf_name_abbr'] . '' . $que[0]['ps_fname'].')'; // แสดง loc_name และ rm_name
                          } else {
                            echo $dt['loc_name'].''; // แสดงเฉพาะ loc_name
                          }
                        }
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
      link.download = '<?php echo $que[0]['apm_visit']; ?>.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });
  });
</script>