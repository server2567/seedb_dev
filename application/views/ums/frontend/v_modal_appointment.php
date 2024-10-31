<?php
date_default_timezone_set('Asia/Bangkok');  // ตั้งค่า Timezone

function calculateDaysLeft($appointmentDate)
{
  $currentDate = new DateTime();
  $appointmentDate = new DateTime($appointmentDate);
  // คำนวณวันเหลือโดยใช้การเปรียบเทียบวันที่
  $interval = $currentDate->diff($appointmentDate);
  // ถ้าวันนี้เป็นวันนัดหมาย ให้แสดงผล 0 วัน
  if ($currentDate->format('Y-m-d') === $appointmentDate->format('Y-m-d')) {
    return 0;
  } else {
    return $interval->days + 1;
  }
}

function calculateTotalDays($startDate, $endDate)
{
  $start = new DateTime($startDate);
  $end = new DateTime($endDate);
  $interval = $start->diff($end);
  return $interval->days + 1;
}

function calculatePercentageLeft($startDate, $endDate)
{
  $currentDate = new DateTime();
  $start = new DateTime($startDate);
  $end = new DateTime($endDate);
  $totalDays = $start->diff($end)->days + 1;
  $daysPassed = $start->diff($currentDate)->days + 1;
  return ($daysPassed / $totalDays) * 100;
}

$app_date = new stdClass();
$app_date->ap_date = $app->ap_date;  // วันที่นัดหมาย (ตัวอย่าง)
$app_date->ap_time = $app->ap_time;   // เวลานัดหมาย (ตัวอย่าง)
$app_date->ap_create_date = $app->ap_create_date;  // วันที่สร้างการนัดหมาย (ตัวอย่าง)

// ตัดเวลาออกจากวันที่สร้างการนัดหมาย
$create_date_only = substr($app_date->ap_create_date, 0, 10);

$daysLeft = calculateDaysLeft($app_date->ap_date);
$totalDays = calculateTotalDays($create_date_only, $app_date->ap_date);
$percentageLeft = calculatePercentageLeft($create_date_only, $app_date->ap_date);
// echo $create_date_only;
// echo $que_date->apm_date;
?>
<div class="modal-header">
  <h5 class="modal-title" id="detailModalLabel">รายละเอียดการนัดหมายจากแพทย์</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12 col-sm-11 col-md-11 mx-auto">
      <div class="card border">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
          <h4 class="mb-2 mb-sm-0">สถานะ : <span class="badge" style="background-color:<?= $app->ast_color; ?>">นัดหมายแพทย์สำเร็จ</span></h4>
          <button id="saveImageBtnApp" class="btn btn-info mb-0"><i class="bi bi-image me-2"></i>บันทึกรูปภาพ</button>
        </div>
        <div id="cardToSaveApp">
          <div class="card-body">
            <div class="mt-1">
              <div class="d-flex justify-content-between mb-3">
                <p class="mb-0 font-24 text-danger fw-bold mt-3"><?php echo $app->ap_before_time; ?></p>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <p class="heading-color fw-bold mb-2 mb-sm-0 font-20 w-80">วันที่นัดหมาย : <?php echo formatThaiDateHi($app->ap_date, $app->ap_time); ?></p>
                <p class="mb-0 font-20"><span class="heading-color fw-bold">อีก</span> <?php echo $daysLeft; ?> วัน</p>
              </div>
              <div class="progress-stacked mb-2 bg-primary bg-opacity-25" style="height:25px;">
                <div class="progress progress-md" role="progressbar" aria-label="Segment one" aria-valuenow="<?php echo $percentageLeft; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentageLeft; ?>%; height:25px;">
                  <span class=" position-absolute <?php if($percentageLeft >= '10') { ?>text-white <?php } else { ?>text-dark<?php } ?> font-16" style="left:50px; margin-top: 0px;">วันที่ <?php echo formatThaiDatelogs($app->ap_create_date); ?></span>
                  <div class="progress-bar rounded-0"></div>
                </div>
              </div>
              <ul class="list-inline d-flex gap-2 mt-3 justify-content-between">
                
                <li class="list-inline-item heading-color font-20"><i class="bi bi-file-earmark-medical text-primary me-2"></i>วันที่แพทย์ลงวันที่ - เวลาการนัดหมาย</li>
                <li class="list-inline-item heading-color font-20"><i class="bi bi-calendar-check text-primary me-2"></i>จำนวนวันที่เหลือ</li>
              </ul>
            </div>
            <?php
              $current_date = date('Y-m-d');
              $day_before_current_date = date('Y-m-d', strtotime($current_date . ' +1 days'));

              if ($app->ap_date > $day_before_current_date) {
              ?>
                  <!-- <div class="d-grid d-flex justify-content-end gap-2 gap-3 mt-4">
                    สามารถยกเลิกการจองคิว และเปลี่ยนวันจองคิวได้ก่อนล่วงหน้า 1 วันก่อนจะถึงวันที่จองคิว - นัดหมายแพทย์
                  </div>
                  <div class="d-grid d-flex justify-content-end gap-2 gap-3 mt-1">
                      <a href="#" class="btn btn-danger mb-0" id="cancelAppointmentBtnApp">ยกเลิกการจองคิว - นัดหมายแพทย์</a>
                      <a href="#" class="btn btn-dark mb-0" id="changeAppointmentBtnApp">เปลี่ยนวันจองคิว - นัดหมายแพทย์</a>
                  </div> -->
              <?php
              } else { ?>
                <!-- <div class="d-grid d-flex justify-content-end gap-2 gap-3 mt-4">
                  ไม่สามารถยกเลิกการจองคิว และเปลี่ยนวันจองคิว - นัดหมายแพทย์ได้แล้ว เนื่องจากเลยวันที่ยกเลิก หรือเปลี่ยนแล้ว
                </div> -->
            <?php } ?>
          </div>
          <div class="card-body">
            <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between px-0 pt-0">
              <h5 class="card-header-title mb-2 mb-sm-0">รายละเอียดการนัดหมาย</h5>
            </div>
            <div class="card-body px-0">
              <div class="border rounded p-4 mb-0">
                <div class="d-sm-flex align-items-center">
                  <div class="flex-shrink-0 mb-2 mb-sm-0 w-20 text-center">
                    <img class="avatar rounded w-40" src="<?php echo base_url(); ?>/assets/img/logo/img_ppd_2.png">
                  </div>
                  <div class="flex-grow-1 ms-sm-3">
                    <div class="row align-items-center">
                      <div class="col-sm mb-3 mb-sm-0">
                        <p class="mb-1 fw-bold mb-2 font-18">ประเภทการนัดหมาย</p>
                        <p class="heading-color mb-0 mb-3 font-18"><?php echo $app->ap_detail_appointment; ?><span class="badge text-bg-primary"></span></p>
                        <?php if($app->ap_detail_prepare){ ?>
                        <p class="mb-1 fw-bold mb-2 font-18">เตรียมตัวก่อนมาพบแพทย์</p>
                        <p class="heading-color mb-0 mb-3 font-18"><?php echo $app->ap_detail_prepare; ?><span class="badge text-bg-primary"></span></p>
                        <?php } ?>
                      </div>
                      <div class="col-sm-auto">
                        <div class="d-flex gap-3">
                          <p></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php if ($app->ps_fname) { ?>
              <div class="card-body px-0 pt-0">
                <div class="border rounded p-4 mb-4">
                  <div class="d-sm-flex align-items-center">
                    <div class="flex-shrink-0 mb-2 mb-sm-0 w-20">
                      <img class="avatar rounded w-100" src="<?php echo site_url(); ?>/hr/getIcon?type=profile/profile_picture&image=<?php echo $app->psd_picture; ?>">
                    </div>
                    <div class="flex-grow-1 ms-sm-3">
                      <div class="row align-items-center">
                        <div class="col-sm mb-3 mb-sm-0">
                          <p class="mb-1 fw-bold font-18">แพทย์ที่นัดหมาย</p>
                          <p class="heading-color mb-0 font-18"><?php echo $app->pf_name . '' . $app->ps_fname . ' ' . $app->ps_lname; ?>
                            <span class="badge text-bg-primary"></span>
                          </p>
                          <?php if($app->pos_desc){ ?>
                          <p class="mt-3 font-18">
                            <b>ความเชี่ยวชาญ</b>
                            <br>
                            <?php echo $app->pos_desc; ?>
                          </p>
                          <?php } ?>
                          <br><br><br><br>
                          <a target="_blank" href="<?php echo site_url(); ?>/hr/frontend/profile/view_profile/<?= encrypt_id($app->ps_id); ?>" class="btn btn-primary" style="color: white;">ข้อมูลแพทย์เพิ่มเติม</a>

                        </div>
                        <div class="col-sm-auto">
                          <div class="d-flex gap-3">
                            <p></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
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
  document.getElementById('saveImageBtnApp').addEventListener('click', function() {
    html2canvas(document.getElementById('cardToSaveApp')).then(function(canvas) {
      var link = document.createElement('a');
      link.download = '<?php echo $app->apm_visit; ?>.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });
  });
</script>

<script>
  function stripHtml(html) {
    let tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
  }

  document.getElementById('cancelAppointmentBtnApp').addEventListener('click', function(event) {
    event.preventDefault();
    Swal.fire({
      title: 'ยกเลิกการนัดหมายติดตามผลจากแพทย์',
      html: `
            <form id="cancelFormApp" class="swal2-container">
              <div class="mb-3 mt-5" style="text-align:left;">
                <label for="cancelReasonApp" class="form-label">เหตุผลที่ยกเลิกนัด <span class="text-danger">*</span></label>
                <select class="form-select" id="cancelReasonApp" required>
                  <option value="">เลือกเหตุผล</option>
                  <?php foreach ($can as $key_c => $c) { ?>
                    <option value="<?php echo $c['can_id']; ?>"><?php echo $c['can_name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="mb-3" style="text-align:left;">
                <label for="cancelDetailsApp" class="form-label">รายละเอียดเพิ่มเติม</label>
                <textarea class="form-control tinymce-editor" id="cancelDetailsApp" rows="3" required></textarea>
              </div>
            </form>
            <style>
              .tox-tinymce{
                border:1px solid #9fb4bf !important;
              }
              .tox-editor-header{
                  display:none !important;
                }
              .tox-statusbar{
                  display:none !important;
                }
            </style>
        `,
      showCancelButton: true,
      cancelButtonText: 'ปิด',
      confirmButtonText: 'ยืนยันการยกเลิก',
      focusConfirm: false,
      didOpen: () => {
        // ลบ TinyMCE instance ก่อนหน้านี้ทั้งหมดถ้ามี
        if (typeof tinymce !== 'undefined') {
          tinymce.remove();
        }

        // Initialize TinyMCE
        tinymce.init({
          selector: 'textarea.tinymce-editor',
          height: 200,
          setup: function(editor) {
            editor.on('change', function() {
              tinymce.triggerSave();
            });
          }
        });
      },
      preConfirm: () => {
        const reason = Swal.getPopup().querySelector('#cancelReasonApp').value;
        const details = stripHtml(tinymce.get('cancelDetailsApp').getContent());
        if (!reason) {
          Swal.showValidationMessage('กรุณากรอกข้อมูลให้ครบถ้วน');
          return false;
        }
        return {
          reason: reason,
          details: details
        };
      }
    }).then((result) => {
      if (result.isConfirmed) {
        var reason = result.value.reason;
        var details = result.value.details;
        var appointmentId = '<?= $app->ap_id; ?>';
        var pt_id = '<?= $app->ntr_pt_id; ?>';
        $.ajax({
          url: '<?php echo site_url('ums/frontend/Dashboard_modal/cancel_ams'); ?>',
          type: 'POST',
          data: {
            pt_id: pt_id,
            appointment_id: appointmentId,
            reason: reason,
            details: details
          },
          success: function(response) {
            // การจัดการหลังจากบันทึกสำเร็จ
            Swal.fire({
              title: 'ยกเลิกการนัดหมายสำเร็จ',
              icon: 'success',
              timer: 1000,
              timerProgressBar: true,
              showConfirmButton: false
            }).then(() => {
              location.reload(); // รีเฟรชหน้า
            });
          },
          error: function(xhr, status, error) {
            // การจัดการเมื่อมีข้อผิดพลาด
            console.error(error);
            Swal.fire('เกิดข้อผิดพลาดในการยกเลิกการนัดหมาย', '', 'error');
          }
        });
      }
    });
  });
  // ฟังก์ชันสำหรับการเปลี่ยนวันจองคิว
  document.getElementById('changeAppointmentBtnApp').addEventListener('click', function(event) {
    event.preventDefault();

    Swal.fire({
      title: 'เปลี่ยนวันการนัดหมายติดตามผลจากแพทย์',
      html: '<p>สำหรับการเปลี่ยนวันจองคิว โปรดติดต่อเจ้าหน้าที่โรงพยาบาลจักษุสุราษฎร์ ที่เบอร์ <strong>077-276-999</strong></p>',
      icon: 'info',
      showConfirmButton: true,
      confirmButtonText: 'ปิด'
    });
  });
</script>