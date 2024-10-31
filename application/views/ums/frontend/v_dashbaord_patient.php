<style>
  .truncate {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    /* จำนวนบรรทัดที่ต้องการแสดง */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .dt-paging-button.disabled,
  .dt-paging-button.disabled:focus,
  .dt-paging-button.disabled:hover {
    font-size: 16px;
  }
</style>

<h1 class="h3 mb-0">หน้าหลัก</h1>
<div class="card-header bg-transparent border-bottom p-0 pb-3 mt-4">
  <h5 class="mb-0">การให้บริการของระบบโรงพยาบาลจักษุสุราษฎร์</h5>
</div>
<div class="card-body pt-4 px-0">
  <div class="row g-3">
    <?php if (!empty($get_ap) && is_array($get_ap)) { ?>
      <?php foreach ($get_ap as $key_ap => $ap) { ?>
        <div class="col-12">
          <div class="position-relative d-flex align-items-center bg-info bg-opacity-10 border rounded border-info mb-4 p-3">
            <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle lh-1 h-20px">
              <i class="bi bi-tags-fill text-info fs-3"></i>
            </div>
            <h2 class="fs-1 mb-0 me-3 w-10"><img src="<?php echo base_url(); ?>assets/img/logo/img_ppd_2.png" class="w-100"></h2>
            <div class="me-md-3 mb-3 mb-md-0">
              <h5 class="mb-3 fw-bold">การนัดหมายติดตามผลจากแพทย์</h5>
              <p class="mb-0 font-18 ">ประเภทการนัดหมาย : <?php echo $ap['ap_detail_appointment'];?></p>
              <p class="mb-0 font-20 text-danger fw-bold mt-3"><?php echo $ap['ap_before_time'];?></p>
              <p class="mb-0 font-18 mt-3">วันที่นัดหมาย <?php echo formatThaiDateHi($ap['ap_date'], $ap['ap_time']); ?></p>
            </div>
            <div class="ms-auto">
              <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="loadModalAppointment(<?php echo $ap['ap_id']; ?>)">รายละเอียดการนัดหมาย</button>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
    <?php if (!empty($get_que) && is_array($get_que)) { ?>
      <?php foreach ($get_que as $key_que => $que) { ?>
        <div class="col-12">
          <div class="position-relative d-flex align-items-center bg-success bg-opacity-10 border rounded border-success mb-4 p-3">
            <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle lh-1 h-20px">
              <i class="bi bi-check-circle-fill text-success fs-3"></i>
            </div>
            <h2 class="fs-1 mb-0 me-3 w-10"><img src="<?php echo base_url(); ?>assets/img/logo/img_ppd_1.png" class="w-100"></h2>
            <div class="me-md-3 mb-3 mb-md-0">
              <h5 class="mb-3 fw-bold">การเข้ารับบริการ</h5>
              <?php echo formatThaiDate($que['apm_date'], $que['apm_time']); ?></p>
              <p class="mb-0 font-16">Visit : <?php echo $que['apm_visit']; ?></p>
              <p class="mb-0 font-16">
                <?php
                echo 'ชื่อแพทย์ : <b class="font-16">' .
                  (!empty($que['pf_name']) || !empty($que['ps_fname']) || !empty($que['ps_lname'])
                    ? $que['pf_name'] . ' ' . $que['ps_fname'] . ' ' . $que['ps_lname']
                    : '-') . '</b>';
                ?>
                <br>
              <p class="mb-0 font-16">
                <?php
                echo 'แผนก : <b class="font-16">' .
                  (!empty($que['stde_name_th']) ? $que['stde_name_th'] : '-') . '</b>';
                ?>
                <br>
              <p class="mb-0 font-14 mt-2 text-danger"></p>
            </div>
            <div class="ms-auto d-flex flex-column">
              <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="loadModalContent(<?php echo $que['apm_id']; ?>)">รายละเอียดการเข้ารับบริการ</button>
              <button type="button" class="btn btn-success mb-0 mt-3" data-bs-toggle="modal" data-bs-target="#detailModalTimeline" onclick="loadModalTimeline(<?php echo $que['apm_id']; ?>)">เส้นทางการรับบริการ</button>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="col-12">
        <div class="position-relative d-flex align-items-center bg-success bg-opacity-10 border rounded border-success mb-4 p-3">
          <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle lh-1 h-20px">
            <i class="bi bi-check-circle-fill text-success fs-3"></i>
          </div>
          <h2 class="fs-1 mb-0 me-3 w-10"><img src="<?php echo base_url(); ?>assets/img/logo/img_ppd_1.png" class="w-100"></h2>
          <div class="me-md-3 mb-3 mb-md-0">
            <h5 class="mb-3 fw-bold">การจองคิว / นัดหมายแพทย์</h5>
            <p class="mb-0 font-16">กรุณาติดต่อเจ้าหน้าที่โรงพยาบาลจักษุสุราษฎร์ <br>หรือโทรได้ที่ <a style="color:#012970;" href="tel:077-276-999">077-276-999</a></p>
          </div>
          <div class="ms-auto">
            <a type="button" class="btn btn-primary mb-0" target="_blank" href="https://surateyehospital.com/service/%E0%B8%95%E0%B8%B2%E0%B8%A3%E0%B8%B2%E0%B8%87%E0%B8%AD%E0%B8%AD%E0%B8%81%E0%B8%95%E0%B8%A3%E0%B8%A7%E0%B8%88%E0%B9%81%E0%B8%9E%E0%B8%97%E0%B8%A2%E0%B9%8C/">
              <i class="bi bi-table"></i> ตารางออกตรวจแพทย์
            </a>
          </div>
        </div>
      </div>
    <?php } ?>
    <!-- <?php if (!empty($get_ntr) && is_array($get_ntr)) { ?>
      <?php foreach ($get_ntr as $key_ntr => $ntr) { ?>
        <div class="col-12">
          <div class="position-relative d-flex align-items-center bg-white bg-opacity-10 border rounded border-muted mb-4 p-3">
            <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle lh-1 h-20px">
              <i class="bi bi-chat-text text-muted fs-3"></i>
            </div>
            <h2 class="fs-1 mb-0 me-3 w-10"><img src="<?php echo base_url(); ?>assets/img/logo/img_ppd_3.png" class="w-100"></h2>
            <div class="me-md-3 mb-3 mb-md-0">
              <h5 class="mb-3 fw-bold">
                    <?php if (count($get_ntr) > 1) {
                      echo ($key_ntr + 1) . '. ';
                    } ?>ผลการตรวจจากห้องปฏิบัติการ
              </h5>
              <p class="mb-0 font-16">ตรวจ<?php echo formatThaiDateNts($ntr['ntr_create_date']); ?><br>โดยแพทย์ 
              <a target="_blank" href="<?php echo site_url("/hr/frontend/profile/"); ?>"><?php echo $ntr['full_name']; ?></a></p>
              <br>
            </div>
            <div class="ms-auto">
              <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="loadModalNtr(<?php echo $ntr['ntr_id']; ?>)">ดูรายละเอียด</button>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?> -->

    <?php
    if (isset($get_news)) {
    ?>
      <div class="col-md-8 col-12" style="border-right: 1px solid #e1e1e1;">
        <div class="card-header bg-transparent border-bottom p-0 pb-3">
          <h5 class="mb-0 font-18"><b>ประชาสัมพันธ์</b>
            <a href="<?php echo site_url(); ?>/ums/frontend/Dashboard_home_patient/news_all" class="text-secondary">
              <span class="float-end font-16 text-primary">อ่านข่าวทั้งหมด <?php echo count($get_news); ?> ข่าว</span>
            </a>
          </h5>
        </div>
        <?php
        $max_news = 3; // กำหนดจำนวนข่าวสูงสุดที่จะแสดง
        foreach ($get_news as $key_news => $news) {
          if ($key_news >= $max_news) break; // หยุดการวนลูปเมื่อครบ 3 รอบ
        ?>
          <div class="col-12 border-bottom pb-3">
            <div class="row align-items-xl-center mt-3">
              <div class="col-4 col-md-4">
                <div class="p-2 w-100">
                  <img src="<?php echo site_url(); ?>/ums/getIcon?type=News/img&image=<?php echo $news['news_img_name']; ?>" alt="" class="w-100 rounded-3">
                </div>
              </div>
              <div class="col-8 col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    <h6 class="mb-1 font-16" style="line-height: 1.5"><?php echo $news['news_name']; ?></h6>
                    <small class="text-muted">วันที่ประกาศ <?php echo formatThaiDateNews($news['news_start_date']); ?></small>
                    <ul class="nav nav-divider align-items-center mt-3">
                      <li class="nav-item ">
                        <span class="truncate w-100"><?php echo $news['news_text']; ?></span>
                      </li>
                      <li class="nav-item icon-link icon-link-hover text-primary mt-3" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="loadModalNews(<?php echo $news['news_id']; ?>)">
                        อ่านรายละเอียดเพิ่มเติม <i class="bi bi-arrow-right d-flex"></i>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>

    <?php
    }
    ?>
    <div class="col-md-4 col-12">
      <div class="card-header bg-transparent border-bottom p-0 pb-3">
        <h5 class="mb-0 font-18"><b>ประวัติการเข้าสู่ระบบ</b> <span class="float-end font-16"><span id="log-count"><?php echo count($get_logs_login); ?></span> ครั้ง</span></h5>
      </div>
      <div id="log-list">
        <?php
        $max_logs = 5; // กำหนดจำนวนข่าวสูงสุดที่จะแสดง
        foreach ($get_logs_login as $key_logs => $logs) {
          if ($key_logs >= $max_logs) break; // หยุดการวนลูปเมื่อครบ 5 รอบ  
        ?>
          <div class="col-12 d-flex border-bottom pt-3 mt-3 pb-2 mb-2 log-item" id="log-item-<?php echo $logs['pl_id']; ?>">
            <!-- Icon -->
            <span class="fs-3 heading-color"><?php if ($logs['pl_agent'] == 'mobile') { ?><i class="bi bi-phone fa-fw"></i><?php } else { ?><i class="bi bi-laptop fa-fw"></i><?php } ?></span>
            <!-- Info -->
            <div class="ms-2">
              <p class="heading-color fw-bold mb-0"><?php echo $logs['pl_agent']; ?> <?php if ($key_logs == 0) { ?><span class="badge small text-bg-primary">กำลังใช้งาน</span><?php } ?></p>
              <ul class="nav nav-divider small">
                <li class="nav-item w-100">
                  <?php
                  $logs2 = $logs['pl_ip']; // ตัวอย่างข้อมูล
                  $parts = explode(' ', $logs2); // แยกข้อความด้วยช่องว่าง

                  // ตรวจสอบว่า explode คืนค่าเป็น array และมีจำนวนองค์ประกอบที่มากกว่า 1
                  if (is_array($parts) && count($parts) > 1) {
                    $location = implode(' ', array_slice($parts, 1)); // นำส่วนที่สองเป็นต้นไปมารวมกัน
                    echo '<li class="nav-item w-100">' . $location . '</li>'; // แสดงผลเฉพาะส่วนที่ต้องการ
                  } else {
                    echo '<li class="nav-item w-100">ข้อมูลไม่ถูกต้อง</li>'; // กรณีข้อมูลไม่ถูกต้อง
                  }
                  ?>
                </li>
                <li class="nav-item w-100"><?php echo formatThaiDatelogs($logs['pl_date']); ?></li>
              </ul>
            </div>

            <!-- Dropdown button -->
            <div class="dropdown ms-auto">
              <!-- Share button -->
              <a href="#" class="text-primary-hover fs-6" role="button" id="dropdownAction1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
              </a>
              <!-- dropdown button -->
              <ul class="dropdown-menu dropdown-menu-end min-w-auto shadow" aria-labelledby="dropdownAction1">
                <li>
                  <a class="dropdown-item text-danger d-flex align-items-center delete-log-btn" href="#" data-log-id="<?php echo $logs['pl_id']; ?>">
                    <i class="bi bi-slash-circle me-2"></i>ลบ
                  </a>
                  <input type='hidden' id='pt_id' value="<?php echo $logs['pl_pt_id']; ?>">
                </li>
              </ul>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-dark btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="loadModallogs(<?php echo $user->pt_id; ?>)">ดูรายละเอียดทั้งหมด</button>
      </div>
    </div>
  </div>

</div>

<!-- ส่วนของ Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" id="modalContent">
      <!-- เนื้อหาจะถูกโหลดที่นี่ -->
    </div>
  </div>
</div>
<!-- ส่วนของ Modal -->
<div class="modal fade" id="detailModalTimeline" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modalContentTimeline">
      <!-- เนื้อหาจะถูกโหลดที่นี่ -->
    </div>
  </div>
</div>
<script>
  function loadModalContent(appointment_id) {
    // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
    $.ajax({
      url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_que'); ?>/" + appointment_id,
      method: "GET",
      success: function(data) {
        $('#modalContent').html(data);
        $('#detailModal').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('AJAX error:', textStatus, errorThrown); // Debug line
      }
    });
  }

  function loadModalTimeline(appointment_id) {
    // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
    $.ajax({
      url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_timeline'); ?>/" + appointment_id,
      method: "GET",
      success: function(data) {
        $('#modalContentTimeline').html(data);
        $('#detailModalTimeline').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('AJAX error:', textStatus, errorThrown); // Debug line
      }
    });
  }

  function loadModalAppointment(appointment_id) {
    // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
    $.ajax({
      url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_Appointment'); ?>/" + appointment_id,
      method: "GET",
      success: function(data) {
        $('#modalContent').html(data);
        $('#detailModal').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('AJAX error:', textStatus, errorThrown); // Debug line
      }
    });
  }

  function loadModalNtr(ntr_id) {
    // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
    $.ajax({
      url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_ntr'); ?>/" + ntr_id,
      method: "GET",
      success: function(data) {
        $('#modalContent').html(data);
        $('#detailModal').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('AJAX error:', textStatus, errorThrown); // Debug line
      }
    });
  }

  function loadModallogs(pt_id) {
    // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
    $.ajax({
      url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_logs'); ?>/" + pt_id,
      method: "GET",
      success: function(data) {
        $('#modalContent').html(data);
        $('#detailModal').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('AJAX error:', textStatus, errorThrown); // Debug line
      }
    });
  }

  function loadModalNews(news_id) {
    // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
    $.ajax({
      url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_News'); ?>/" + news_id,
      method: "GET",
      success: function(data) {
        $('#modalContent').html(data);
        $('#detailModal').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('AJAX error:', textStatus, errorThrown); // Debug line
      }
    });
  }
</script>
<script>
  $(document).on('click', '.delete-log-btn', function(event) {
    event.preventDefault();

    var logId = $(this).data('log-id');
    var ptId = $('#pt_id').val();

    Swal.fire({
      icon: 'warning',
      title: 'ยืนยันการลบ',
      showCancelButton: true,
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก',
      reverseButtons: true,
      customClass: {
        confirmButton: 'btn btn-danger btn-lg ms-5',
        cancelButton: 'btn btn-secondary btn-lg me-5'
      },
      buttonsStyling: false
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/delete_log'); ?>',
          type: 'POST',
          data: {
            log_id: logId
          },
          success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
              // Remove the deleted log item
              $('#log-item-' + logId).remove();
              var logCount = parseInt($('#log-count').text(), 10);
              $('#log-count').text(logCount - 1);
              // Load the next log item
              $.ajax({
                url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/get_next_log_item'); ?>',
                type: 'POST',
                data: {
                  log_id: logId,
                  pt_id: ptId
                },
                success: function(nextData) {
                  try {
                    var result = JSON.parse(nextData);
                    if (result.status === 'success') {
                      $('#log-list').append(result.html);
                    } else {
                      Swal.fire({
                        icon: 'info',
                        title: 'ไม่มีข้อมูลเพิ่มเติม'
                      });
                    }
                  } catch (e) {
                    console.error('Parsing error:', e);
                    Swal.fire({
                      icon: 'error',
                      title: 'เกิดข้อผิดพลาด',
                      text: 'ไม่สามารถประมวลผลข้อมูลได้'
                    });
                  }
                }
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: response.message
              });
            }
          }
        });
      }
    });
  });



  function loadNextLogItem() {

    $.ajax({
      url: '<?php echo site_url('ums/frontend/Dashboard_home_patient/get_next_log_item/' . $user->pt_id . ''); ?>',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          // Append the next log item to the list
          $('#log-list').append(response.html);
        } else {
          console.log('No more log items to load');
        }
      }
    });
  }
</script>