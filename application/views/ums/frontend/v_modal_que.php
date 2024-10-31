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

$que_date = new stdClass();
$que_date->apm_date = $que->apm_date;  // วันที่นัดหมาย (ตัวอย่าง)
$que_date->apm_time = $que->apm_time;   // เวลานัดหมาย (ตัวอย่าง)
$que_date->apm_create_date = $que->apm_create_date;  // วันที่สร้างการนัดหมาย (ตัวอย่าง)

// ตัดเวลาออกจากวันที่สร้างการนัดหมาย
$create_date_only = substr($que_date->apm_create_date, 0, 10);

$daysLeft = calculateDaysLeft($que_date->apm_date);
$totalDays = calculateTotalDays($create_date_only, $que_date->apm_date);
$percentageLeft = calculatePercentageLeft($create_date_only, $que_date->apm_date);
// echo $create_date_only;
// echo $que_date->apm_date;
?>
<div class="modal-header">
  <h5 class="modal-title" id="detailModalLabel">รายละเอียดการเข้ารับบริการ</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12 col-sm-11 col-md-11 mx-auto">
      <div class="card border">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
          <h4 class="mb-2 mb-sm-0">สถานะ : <span class="badge" style="background-color:<?= $que->sta_color; ?>"><?php echo $que->sta_name; ?></span></h4>
          <button id="saveImageBtn" class="btn btn-info mb-0"><i class="bi bi-image me-2"></i>บันทึกรูปภาพ</button>
        </div>
        <div id="cardToSave">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div class="mb-3 mb-sm-0 w-10">
                <img src="<?php echo base_url(); ?>/assets/img/logo/img_ppd_1.png" class="w-100">
              </div>

              <div>
                <h6 class="h4 mb-1"><?= $que->stde_name_th; ?></h6>
              </div>
            </div>
            <div class="mt-5">
              <div class="d-flex justify-content-between mb-3">
                <p class="heading-color fw-bold mb-2 mb-sm-0 font-18 w-80">วันที่เข้ารับบริการ : <?php echo formatThaiDate($que->apm_date, $que->apm_time); ?></p>
                <?php if($daysLeft > 0) { ?>
                  <p class="mb-0"><span class="heading-color fw-bold">อีก</span> <?php echo $daysLeft; ?> วัน</p>
                <?php } else { ?>
                  <p class="mb-0"><span class="heading-color fw-bold">วันนี้</span></p>
                <?php } ?>
              </div>
              <div class="progress-stacked mb-2 bg-success bg-opacity-25" style="height:25px;">
                <div class="progress progress-md" role="progressbar" aria-label="Segment one" aria-valuenow="<?php echo $percentageLeft; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentageLeft; ?>%; height:25px;">
                  <span class=" position-absolute text-white font-16" style="left:50px; margin-top: 0px;">วันที่ <?php echo formatThaiDatelogs($que->apm_create_date); ?></span>
                  <div class="progress-bar bg-success rounded-0"></div>
                </div>
              </div>
              <ul class="list-inline d-flex gap-2 mt-3 justify-content-between">
                <li class="list-inline-item heading-color"><i class="bi bi-telephone-fill text-success me-2"></i>วันที่เข้ารับบริการ / โทรจองคิว / นัดหมายล่วงหน้า</li>
                <li class="list-inline-item heading-color"><i class="bi bi-calendar-check text-success me-2"></i>จำนวนวันที่เหลือ</li>
              </ul>
            </div>
            <?php
              $current_date = date('Y-m-d');
              $day_before_current_date = date('Y-m-d', strtotime($current_date . ' +1 days'));

              if ($que->apm_date > $day_before_current_date) {
              ?>
                  <!-- <div class="d-grid d-flex justify-content-end gap-2 gap-3 mt-4">
                    สามารถยกเลิกการจองคิว และเปลี่ยนวันจองคิวได้ก่อนล่วงหน้า 1 วันก่อนจะถึงวันที่จองคิว - นัดหมายแพทย์
                  </div>
                  <div class="d-grid d-flex justify-content-end gap-2 gap-3 mt-1">
                      <a href="#" class="btn btn-danger mb-0" id="cancelAppointmentBtn">ยกเลิกการจองคิว - นัดหมายแพทย์</a>
                      <a href="#" class="btn btn-dark mb-0" id="changeAppointmentBtn">เปลี่ยนวันจองคิว - นัดหมายแพทย์</a>
                  </div> -->
              <?php
              } else { ?>
                <!-- <div class="d-grid d-flex justify-content-end gap-2 gap-3 mt-4">
                  ไม่สามารถยกเลิกการจองคิว และเปลี่ยนวันจองคิว - นัดหมายแพทย์ได้ เนื่องจากเลยวันที่ยกเลิก หรือเปลี่ยนแล้ว
                  <a href="#" class="btn btn-danger mb-0 d-none" id="cancelAppointmentBtn">ยกเลิกการจองคิว - นัดหมายแพทย์</a>
                  <a href="#" class="btn btn-dark mb-0 d-none" id="changeAppointmentBtn">เปลี่ยนวันจองคิว - นัดหมายแพทย์</a>
                </div> -->
            <?php } ?>
          </div>
          <div class="card-body">
            <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between px-0 pt-0">
              <h5 class="card-header-title mb-2 mb-sm-0">รายละเอียดแพทย์ที่ได้รับบริการ</h5>
            </div>
            <?php if($que->ps_fname) { ?>
              <div class="card-body px-0">
                <div class="border rounded p-4 mb-4">
                  <div class="d-sm-flex align-items-center">
                    <div class="flex-shrink-0 mb-2 mb-sm-0 w-20">
                      <img class="avatar rounded w-100" src="<?php echo site_url(); ?>/hr/getIcon?type=profile/profile_picture&image=<?php echo $que->psd_picture; ?>">
                    </div>
                    <div class="flex-grow-1 ms-sm-3">
                      <div class="row align-items-center">
                        <div class="col-sm mb-3 mb-sm-0 font-18">
                          <p class="mb-1 fw-bold">ชื่อแพทย์</p>
                          <p class="heading-color mb-0">
                            <?php echo $que->pf_name . '' . $que->ps_fname . ' ' . $que->ps_lname; ?>
                            <span class="badge text-bg-primary"></span>
                          </p>
                          <?php if($que->pos_desc){ ?>
                          <p class="mt-3">
                            <b>ความเชี่ยวชาญ</b>
                            <br>
                            <?php echo $que->pos_desc; ?>
                          </p>
                          <?php } ?>
                          <br><br><br><br>
                          <a target="_blank" href="<?php echo site_url(); ?>/hr/frontend/profile/view_profile/<?= encrypt_id($que->ps_id); ?>" class="btn btn-primary" style="color: white;">ข้อมูลแพทย์เพิ่มเติม</a>
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
  document.getElementById('saveImageBtn').addEventListener('click', function() {
    html2canvas(document.getElementById('cardToSave')).then(function(canvas) {
      var link = document.createElement('a');
      link.download = '<?php echo $que->apm_cl_code; ?>.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });
  });
</script>

<script>
function stripHtml(html){
    let tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}

  document.getElementById('cancelAppointmentBtn').addEventListener('click', function(event) {
    event.preventDefault();
    Swal.fire({
      title: 'ยกเลิกการจองคิว - นัดหมายแพทย์',
      html: `
            <form id="cancelForm" class="swal2-container">
              <div class="mb-3 mt-5" style="text-align:left;">
                <label for="cancelReason" class="form-label">เหตุผลที่ยกเลิก <span class="text-danger">*</span></label>
                <select class="form-select" id="cancelReason" required>
                  <option value="">เลือกเหตุผล</option>
                  <?php foreach ($can as $key_c => $c) { ?>
                    <option value="<?php echo $c['can_id']; ?>"><?php echo $c['can_name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="mb-3" style="text-align:left;">
                <label for="cancelDetails" class="form-label">รายละเอียดเพิ่มเติม</label>
                <textarea class="form-control tinymce-editor" id="cancelDetails" rows="3" required></textarea>
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
        const reason = Swal.getPopup().querySelector('#cancelReason').value;
        const details = stripHtml(tinymce.get('cancelDetails').getContent());
        if (!reason) {
          Swal.showValidationMessage('กรุณากรอกข้อมูลให้ครบถ้วน');
          return false;
        }
        return { reason: reason, details: details };
      }
    }).then((result) => {
      if (result.isConfirmed) {
        var reason = result.value.reason;
        var details = result.value.details;
        var appointmentId = '<?= $que->apm_id; ?>'; // สมมติว่าคุณมี ID ของการนัดหมาย
        var pt_id = '<?= $que->apm_pt_id; ?>'; // สมมติว่าคุณมี ID ของการนัดหมาย
        $.ajax({
          url: '<?php echo site_url('ums/frontend/Dashboard_modal/cancel_que'); ?>',
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
                  title: 'ยกเลิกการจองคิวสำเร็จ',
                  icon: 'success',
                  timer: 1000,
                  timerProgressBar: true,
                  showConfirmButton: false
              }).then(() => {
                  location.reload();  // รีเฟรชหน้า
              });
          },
          error: function(xhr, status, error) {
            // การจัดการเมื่อมีข้อผิดพลาด
            console.error(error);
            Swal.fire('เกิดข้อผิดพลาดในการยกเลิกการจองคิว', '', 'error');
          }
        });
      }
    });
  });
  // ฟังก์ชันสำหรับการเปลี่ยนวันจองคิว
  document.getElementById('changeAppointmentBtn').addEventListener('click', function(event) {
      event.preventDefault();

      Swal.fire({
          title: 'เปลี่ยนวันจองคิว - นัดหมายแพทย์',
          html: '<p>สำหรับการเปลี่ยนวันจองคิว โปรดติดต่อเจ้าหน้าที่โรงพยาบาลจักษุสุราษฎร์ ที่เบอร์ <strong>077-276-999</strong></p>',
          icon: 'info',
          showConfirmButton: true,
          confirmButtonText: 'ปิด'
      });
  });
</script>