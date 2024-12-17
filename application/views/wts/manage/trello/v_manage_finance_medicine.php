<?php if($room_sta == 'finance') { ?>
<div style='position: absolute; top: 63px; left: 205px;'><a href="<?php echo site_url() ;?>/wts/Manage_queue_finance_medicine/medicine" class="btn btn-primary">เปลี่ยนห้องจ่ายยา</a></div>
<?php } else { ?>
<div style='position: absolute; top: 63px; left: 205px;'><a href="<?php echo site_url() ;?>/wts/Manage_queue_finance_medicine/finance" class="btn btn-primary">เปลี่ยนห้องการเงิน</a></div>
<?php } ?>
<div class="card">
  <ul class="nav nav-tabs" id="patientTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active font-18" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true"><b>รอการดำเนินการ</b></button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link font-18" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false"><b>ดำเนินการเสร็จสิ้น</b></button>
    </li>
  </ul>
  <div class="tab-content" id="patientTabsContent">
    <!-- Tab รอการดำเนินการ -->
    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
      <div class="accordion">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button"  data-bs-target="#collapsePending" aria-expanded="true" aria-controls="collapsePending">
              <i class="bi-folder2-open icon-menu"></i><span>ข้อมูลผู้ป่วยที่รอรับบริการของ<?php if($room_sta == 'finance'){ echo 'แผนกการเงิน'; } else if($room_sta == 'medicine'){ echo 'แผนกเภสัชกรรม'; }?></span>
            </button>
          </h2>
          <div id="collapsePending" class="accordion-collapse " aria-labelledby="headingPending">
            <div class="accordion-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table" width="100%">
                    <thead>
                      <tr>
                        <th width="10%" class="text-center text-primary-emphasis">หมายเลขคิว</th>
                        <th width="10%" class="text-center text-primary-emphasis">หมายเลขคิวของการเงินและยา</th>
                        <th width="10%" class="text-center text-primary-emphasis">ชื่อผู้ป่วย</th>
                        <th width="10%" class="text-center text-primary-emphasis">Visit</th>
                        <th width="10%" class="text-center text-primary-emphasis">HN</th>
                        <th width="10%" class="text-center text-primary-emphasis">เวลาเข้าแผนก</th>
                        <th width="10%" class="text-center text-primary-emphasis">สถานะการเรียก</th>
                        <th width="10%" class="text-center text-primary-emphasis">ดำเนินการ</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($que_finance_medicine as $fm) { ?>
                        <tr>
                          <td class="font-18 text-center"><?php echo $fm['apm_ql_code']; ?></td>
                          <td class="font-18 text-center"><?php echo $fm['apm_rm_code']; ?></td>
                          <td><?php echo $fm['pt_prefix'] . '' . $fm['pt_fname'] . ' ' . $fm['pt_lname']; ?><br><b><span style='color:<?php echo $fm['pri_color']; ?>'><?php echo $fm['pri_name']; ?></span></b></td>
                          <td class="text-center"><?php echo $fm['apm_visit']; ?></td>
                          <td class="text-center"><?php echo $fm['pt_member']; ?></td>
                          <td class="text-center"><?php echo $fm['apm_rm_time']; ?></td>
                          <td class="text-left" style="color:<?php echo $fm['sta_color']; ?>">
                            <?php echo $fm['sta_name']; ?><br>
                            <?php foreach ($que_status_all as $qa) {
                              if ($fm['qus_status'] == $qa['sta_id']) {
                                echo '<span style="color:' . $qa['sta_color'] . '">' . '&nbsp; - ' . $qa['sta_name'] . '</span><br>';
                              }
                            }
                            ?>
                            <?php
                            $qus_channels = explode(',', $fm['qus_channel']);
                            foreach ($qus_channels as $channel_id) {
                              foreach ($que_status_all as $qa) {
                                if (trim($channel_id) == $qa['sta_id']) {
                                  echo '<span style="color:' . $qa['sta_color'] . '">' . '&nbsp; - ' . $qa['sta_name'] . '</span><br>';
                                }
                              }
                            }
                            ?>
                          </td>
                          <td class="text-center">
                            <?php
                            $encrypted_id = encrypt_id($fm['apm_id']);
                            $btn_apm_url = site_url('wts/Manage_queue_trello/Manage_queue_trello_apm_info') . '/' . $encrypted_id;
                            ?>
                            <button class="btn btn-info tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="ข้อมูลผู้ป่วย" onclick="showModalApm('<?php echo $btn_apm_url; ?>')">
                              <i class="bi-search"></i>
                            </button>
                            <?php if(($room_sta == 'finance' && $fm['apm_sta_id'] == 16) || ($room_sta == 'medicine' && $fm['apm_sta_id'] == 17)) { ?>
                              <?php if($fm['sta_name'] != 'กำลังเตรียมยา'){ ?>
                              <button class="btn btn-primary tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="ปรับสถานะผู้ป่วย" onclick="showPatientStatusModal(<?php echo $fm['apm_id']; ?>,'<?php echo $room_sta; ?>')">
                                <i class="bi bi-inboxes-fill"></i>
                              </button>
                              <?php } ?>
                            <?php } else { ?>
                              <button class="btn btn-primary tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="ปรับสถานะผู้ป่วย" onclick="showPatientStatusModal(<?php echo $fm['apm_id']; ?>,'<?php echo $room_sta; ?>')">
                                <i class="bi bi-inboxes-fill"></i>
                              </button>
                              <button class="btn btn-success tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="เสร็จสิ้น" onclick="confirmCompletion(<?php echo $fm['apm_id']; ?>,'<?php echo $room_sta; ?>')">
                                <i class="bi bi-check-circle"></i>
                              </button>
                            <?php } ?>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Tab ดำเนินการเสร็จสิ้น -->
    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
      <div class="accordion">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-target="#collapseCompleted" aria-expanded="true" aria-controls="collapseCompleted">
              <i class="bi-folder2-open icon-menu"></i><span>ข้อมูลผู้ป่วยที่ดำเนินการเสร็จสิ้น</span>
            </button>
          </h2>
          <div id="collapseCompleted" class="accordion-collapse collapse show" aria-labelledby="headingCompleted">
            <div class="accordion-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table" width="100%">
                    <thead>
                      <tr>
                        <th width="10%" class="text-center text-primary-emphasis">หมายเลขคิว</th>
                        <th width="10%" class="text-center text-primary-emphasis">หมายเลขคิวของการเงินและยา</th>
                        <th width="10%" class="text-center text-primary-emphasis">ชื่อผู้ป่วย</th>
                        <th width="10%" class="text-center text-primary-emphasis">Visit</th>
                        <th width="10%" class="text-center text-primary-emphasis">HN</th>
                        <th width="10%" class="text-center text-primary-emphasis">เวลาเข้าแผนก</th>
                        <th width="10%" class="text-center text-primary-emphasis">สถานะการเรียก</th>
                        <th width="10%" class="text-center text-primary-emphasis">ดำเนินการ</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($que_success as $fm) {
                      ?>
                        <tr>
                          <td class="font-18 text-center"><?php echo $fm['apm_ql_code']; ?></td>
                          <td class="font-18 text-center"><?php echo $fm['apm_rm_code']; ?></td>
                          <td><?php echo $fm['pt_prefix'] . '' . $fm['pt_fname'] . ' ' . $fm['pt_lname']; ?><b><span style='color:<?php echo $fm['pri_color']; ?>'><?php echo $fm['pri_name']; ?></span></b></td>
                          <td class="text-center"><?php echo $fm['apm_visit']; ?></td>
                          <td class="text-center"><?php echo $fm['pt_member']; ?></td>
                          <td class="text-center"><?php echo $fm['apm_rm_time']; ?></td>
                          <td class="text-left" style="color:<?php echo $fm['sta_color']; ?>">
                            <?php echo $fm['sta_name']; ?><br>
                            <?php foreach ($que_status_all as $qa) {
                              if ($fm['qus_status'] == $qa['sta_id']) {
                                echo '<span style="color:' . $qa['sta_color'] . '">' . '&nbsp; - ' . $qa['sta_name'] . '</span><br>';
                              }
                            }
                            ?>
                            <?php
                            $qus_channels = explode(',', $fm['qus_channel']);
                            foreach ($qus_channels as $channel_id) {
                              foreach ($que_status_all as $qa) {
                                if (trim($channel_id) == $qa['sta_id']) {
                                  echo '<span style="color:' . $qa['sta_color'] . '">' . '&nbsp; - ' . $qa['sta_name'] . '</span><br>';
                                }
                              }
                            }
                            ?>
                          </td>
                          <td class="text-center">
                            <?php
                              $encrypted_id = encrypt_id($fm['apm_id']);
                              $btn_apm_url = site_url('wts/Manage_queue_trello/Manage_queue_trello_apm_info') . '/' . $encrypted_id;
                            ?>
                            <button class="btn btn-info tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="ข้อมูลผู้ป่วย" onclick="showModalApm('<?php echo $btn_apm_url; ?>')">
                              <i class="bi-search"></i>
                            </button>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-apm" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-card-heading icon-menu font-20"></i>
          <span>รายละเอียดการลงทะเบียน</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div id="appointment-data"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
<script>
  // ฟังก์ชันสำหรับเคลียร์เนื้อหาใน Modal
  function clearModalContent(selector) {
    $(selector).empty();
  }

  // Initialize tooltips
  document.addEventListener('DOMContentLoaded', function () {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('.tooltips'));
      tooltipTriggerList.forEach(function (tooltipTriggerEl) {
          new bootstrap.Tooltip(tooltipTriggerEl);
      });
  });

  // ฟังก์ชันสำหรับแสดง Loading Spinner
  function showLoadingSpinner(selector) {
    const spinnerHTML = `
      <div class="center-container text-center">
        <div class="spinner-border text-info" role="status">
          <span class="visually-hidden">กำลังโหลด...</span>
        </div>
      </div>
    `;
    $(selector).append(spinnerHTML);
  }

  // ฟังก์ชันสำหรับลบ Loading Spinner ออก
  function clearLoadingSpinner(selector) {
    $(selector).find('.center-container').remove();
  }

  // ฟังก์ชันสำหรับแสดงข้อความข้อผิดพลาด
  function showErrorMessage() {
    const errorHTML = `
      <div class="text-center text-danger font-20">
        <p>เกิดข้อผิดพลาดในการโหลดข้อมูล กรุณาลองใหม่อีกครั้ง</p>
      </div>
    `;
    $('#appointment-data').html(errorHTML);
  }

  // ฟังก์ชันหลักสำหรับเปิด Modal และโหลดข้อมูล
  function showModalApm(url) {
    let selector = '#appointment-data';

    // เคลียร์เนื้อหาใน Modal
    clearModalContent(selector);

    // แสดง Modal
    $('#modal-apm').modal('show');

    // แสดง Loading Spinner ระหว่างรอข้อมูล
    showLoadingSpinner(selector);

    // ใช้ setTimeout เพื่อให้ Loading Spinner แสดงก่อนที่จะโหลดข้อมูลใหม่
    setTimeout(function() {
      $(selector).load(url, function(response, status, xhr) {
        if (status === "error") {
          console.log('เกิดข้อผิดพลาดในการโหลดข้อมูล:', xhr.status, xhr.statusText);
          showErrorMessage(); // แสดงข้อความข้อผิดพลาดหากโหลดไม่สำเร็จ
        } else {
          // ลบ Loading Spinner หลังจากข้อมูลถูกโหลดสำเร็จ
          clearLoadingSpinner(selector);
        }
      });
    }, 100); // สามารถปรับเวลาหน่วง (delay) ได้ตามต้องการ
  }
</script>

<script>
  function showPatientStatusModal(apm_id,room_sta) {
    // เรียกใช้ AJAX เพื่อดึงข้อมูลตาม apm_id
    fetch(`<?php echo site_url('wts/Manage_queue_finance_medicine/getQueueStatus'); ?>/${apm_id}`)
      .then(response => response.json())
      .then(data => {
        // ตรวจสอบข้อมูลที่ได้รับจากฐานข้อมูล
        const selectedStatus = data.length > 0 ? data[0].qus_status : '';
        const selectedChannel = data.length > 0 ? data[0].qus_channel : '';

        // แยก qus_channel ออกเป็นอาเรย์โดยใช้คอมม่า
        const qusChannel = data.length > 0 && data[0].qus_channel ? data[0].qus_channel.split(',') : [];

        // หากมีมากกว่าหนึ่งค่า ให้ใช้ค่าหลังสุดเป็น selectedCall
        const selectedCall = qusChannel.length > 1 ? qusChannel[1].trim() : qusChannel[0] || '';
        const selectedCha = qusChannel.length > 1 ? qusChannel[0].trim() : qusChannel[0] || '';

        Swal.fire({
          title: '<?php if($room_sta != 'finance') { ?>ปรับสถานะผู้ป่วย<?php } else { ?>เรียกผู้ป่วยชำระเงิน<?php } ?>',
          width: '50%', // เพิ่มความกว้างของ modal (สามารถปรับเป็นค่าอื่นตามต้องการ เช่น '800px')
          html: `
                    <div style="text-align: left;">
                      <?php if($room_sta != 'finance') { ?>
                        <?php if($room_sta != 'medicine') { ?>
                            <label for="status-select" style="margin-top: 10px; color:#004881;"><b>สถานะ :</b></label>
                            <select id="status-select" class="swal2-input" name="status-select" style="width: 100%;">
                              <option value="">กรุณาเลือกสถานะ</option>
                              <?php foreach ($que_status_1 as $s1) { ?>
                                <option value="<?php echo $s1['sta_id']; ?>" ${selectedStatus == '<?php echo $s1['sta_id']; ?>' ? 'selected' : ''}
                                style="color:<?php echo $s1['sta_color']; ?>;"><?php echo $s1['sta_name']; ?></option>
                              <?php } ?>
                            </select>
                          <?php } else { ?>
                            <select id="status-select" class="swal2-input" name="status-select" style="width: 100%; display: none;">
                              <option value="">กรุณาเลือกสถานะ</option>
                              <?php foreach ($que_status_1 as $s1) { ?>
                                <option value="<?php echo $s1['sta_id']; ?>" ${selectedStatus == '<?php echo $s1['sta_id']; ?>' ? 'selected' : ''}
                                style="color:<?php echo $s1['sta_color']; ?>;"><?php echo $s1['sta_name']; ?></option>
                              <?php } ?>
                            </select>
                          <?php } ?>
                          <label for="channel-select" style="margin-top: 10px; color:#004881;"><b>ช่องทำการ :</b></label>
                          <div style="display: flex; align-items: center;">
                          <select id="channel-select" class="swal2-input" name="channel-select" style="width: 100%;">
                            <option value="">กรุณาเลือกช่องทำการ</option>
                            <?php foreach ($que_status_2 as $s2) { ?>
                              <option value="<?php echo $s2['sta_id']; ?>" ${selectedCha == '<?php echo $s2['sta_id']; ?>' ? 'selected' : ''}
                              style="color:<?php echo $s2['sta_color']; ?>;"><?php echo $s2['sta_name']; ?></option>
                            <?php } ?>
                          </select>
                          <?php if($room_sta != 'finance') { ?>
                            <button id="draftButton" class="swal2-deny swal2-styled ms-5" style="background-color: #22c55e; font-size:20px; width:40%;">บันทึก<br>(อัปเดตสถานะ)</button>
                          <?php } else { ?>
                            <button id="draftButton" class="swal2-deny swal2-styled" style="background-color: #22c55e; width: 0%; padding-left: 5px; padding-right: 5px; display: none;"></button>
                          <?php } ?>
                          </div>
                      <?php } else { ?>
                          <select id="status-select" class="swal2-input" name="status-select" style="width: 100%; display: none;">
                            <?php foreach ($que_status_1 as $s1) { ?>
                              <option value="<?php echo $s1['sta_id']; ?>" ${selectedStatus == '<?php echo $s1['sta_id']; ?>' ? 'selected' : ''}
                              style="color:<?php echo $s1['sta_color']; ?>;"><?php echo $s1['sta_name']; ?></option>
                            <?php } ?>
                          </select>
                          <select id="channel-select" class="swal2-input" name="channel-select" style="width: 100%; display: none;">
                            <?php foreach ($que_status_2 as $s2) { ?>
                              <option value="<?php echo $s2['sta_id']; ?>" ${selectedCha == '<?php echo $s2['sta_id']; ?>' ? 'selected' : ''}
                              style="color:<?php echo $s2['sta_color']; ?>;"><?php echo $s2['sta_name']; ?></option>
                            <?php } ?>
                          </select>
                      <?php } ?>
                        <label for="call-select" style="margin-top: 10px; color:#004881;"><b>การเรียก :</b>
                        <?php if($room_sta == 'medicine'){ ?>
                          <br><span style="color:#dc2626; position: absolute; ">ถ้าอยู่ในระหว่างการคัดยา ไม่ต้องเลือกการเรียก</span>
                        <?php } ?>
                      </label>
                      <div style="display: flex; align-items: center;">
                      <?php if($room_sta != 'finance') { ?>
                        
                        <select id="call-select" class="swal2-input" name="call-select" style="width: 100%;">
                          <option value="">กรุณาการเรียก</option>
                          <?php foreach ($que_status_3 as $s3) { ?>
                            <option value="<?php echo $s3['sta_id']; ?>" ${selectedCall == '<?php echo $s3['sta_id']; ?>' ? 'selected' : ''}
                            style="color:<?php echo $s3['sta_color']; ?>;"><?php echo $s3['sta_name']; ?></option>
                          <?php } ?>
                        </select>
                        <button id="confirmButton" class="swal2-confirm swal2-styled ms-5" style="background-color: #1d4ed8; font-size:20px;  width:40%;">บันทึกและเรียกผู้ป่วย</button>
                      <?php } else { ?>
                        <select id="call-select" class="swal2-input" name="call-select" style="width: 100%;">
                          <?php foreach ($que_status_3 as $s3) { ?>
                            <option value="<?php echo $s3['sta_id']; ?>" ${selectedCall == '<?php echo $s3['sta_id']; ?>' ? 'selected' : ''}
                            style="color:<?php echo $s3['sta_color']; ?>;"><?php echo $s3['sta_name']; ?></option>
                          <?php } ?>
                        </select>
                          <button id="confirmButton" class="swal2-confirm swal2-styled ms-5" style="background-color: #1d4ed8; font-size:20px;  width:40%;">เรียกผู้ป่วยชำระเงิน</button>
                          <button id="draftButton" class="swal2-deny swal2-styled" style="background-color: #22c55e; width: 0%; padding-left: 5px; padding-right: 5px; display: none;"></button>
                        <?php } ?>
                      </div>
                    </div>
                    <div style="display: flex; justify-content: flex-start; margin-top: 40px;">
                      <button id="cancelButton" class="swal2-styled" style="background-color: #dc2626; width: 30%; border: 0; border-radius: .25em; color: #fff;">ยกเลิก</button>
                    </div>
          `,


          showConfirmButton: false,
          showCancelButton: false,
          showDenyButton: false,
          didOpen: () => {
            // ตั้งค่า selected สำหรับแต่ละ select หลังจากที่ Swal แสดงผลแล้ว
            document.getElementById('status-select').value = selectedStatus;
            document.getElementById('channel-select').value = selectedCha;
            if(room_sta != 'finance'){
              document.getElementById('call-select').value = selectedCall;
            } else {
              document.getElementById('call-select').value = 10;
            }
            document.getElementById('cancelButton').addEventListener('click', () => Swal.close());

            document.getElementById('draftButton').addEventListener('click', () => {
              const selectedData = {
                apm_id: apm_id,
                room_sta : room_sta,
                status: document.getElementById('status-select').value,
                channel: document.getElementById('channel-select').value,
                call: document.getElementById('call-select').value
              };

              fetch('<?php echo site_url('wts/Manage_queue_finance_medicine/saveDraft'); ?>', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json'
                  },
                  body: JSON.stringify(selectedData)
                })
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    Swal.fire({
                      icon: 'success',
                      title: 'บันทึกสำเร็จ',
                      showConfirmButton: false,
                      timer: 1000
                    }).then(() => {
                          location.reload(); // รีเฟรชหน้าหลังจากอัปเดตเสร็จ
                      });
                  } else {
                    Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกได้', 'error');
                  }
                })
                .catch(error => {
                  Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                  console.error('Error:', error);
                });

              Swal.close();
            });

            document.getElementById('confirmButton').addEventListener('click', () => {
              const selectedData = {
                apm_id: apm_id,
                room_sta : room_sta,
                status: document.getElementById('status-select').value,
                channel: document.getElementById('channel-select').value,
                call: document.getElementById('call-select').value
              };
              console.log("บันทึกและเรียกผู้ป่วย", selectedData);
              Swal.close();
            });

            document.getElementById('confirmButton').addEventListener('click', () => {
              const selectedData = {
                  apm_id: apm_id,
                  room_sta : room_sta,
                  status: document.getElementById('status-select').value,
                  channel: document.getElementById('channel-select').value,
                  call: document.getElementById('call-select').value
              };

              // บันทึกข้อมูลและปรับสถานะการเรียกผู้ป่วย
              fetch('<?php echo site_url('wts/Manage_queue_finance_medicine/saveandcall'); ?>', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify(selectedData)
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      Swal.fire({
                          icon: 'success',
                          title: 'บันทึกและเรียกผู้ป่วยสำเร็จ',
                          showConfirmButton: false,
                          timer: 1000
                        }).then(() => {
                          location.reload(); // รีเฟรชหน้าหลังจากอัปเดตเสร็จ
                      });
                  } else {
                      Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเรียกผู้ป่วยได้', 'error');
                  }
              })
              .catch(error => {
                  Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                  console.error('Error:', error);
              });

              Swal.close();
          });

          }
        });
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
</script>

<script>
  function confirmCompletion(apm_id,room_sta) {
    Swal.fire({
      title: 'ยืนยันการเสร็จสิ้น?',
      text: "คุณต้องการเปลี่ยนสถานะผู้ป่วยนี้เป็นเสร็จสิ้นหรือไม่?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#198754',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        // หากผู้ใช้ยืนยันให้ส่งข้อมูลไปยัง Controller เพื่ออัปเดตสถานะ
        fetch('<?php echo site_url('wts/Manage_queue_finance_medicine/updatePatientStatus'); ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ apm_id: apm_id , room_sta: room_sta})
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'ดำเนินการเสร็จสิ้น',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              location.reload(); // รีเฟรชหน้าหลังจากอัปเดตสถานะเสร็จสิ้น
            });
          } else {
            Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถอัปเดตสถานะได้', 'error');
          }
        })
        .catch(error => {
          Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
          console.error('Error:', error);
        });
      }
    });
  }
</script>
<script>
let currentRoomSta = window.location.href.endsWith('/finance') ? 'finance' : 'medicine';
let activeTabId = "pending"; // ตั้งค่าเริ่มต้นที่แท็บ pending

// ฟังก์ชัน refreshTable ที่รับค่า room_sta แบบไดนามิก
function refreshTable(room_sta) {
  const tableSelector = "#patientTabsContent";

  $.ajax({
    url: "<?php echo site_url('wts/Manage_queue_finance_medicine/getQueueData'); ?>/" + room_sta,
    method: "GET",
    dataType: "json",
    success: function(data) {
      console.log('Data received:', data); // เพิ่มการ log เพื่อดูข้อมูลที่รับมา
        let tableHtml = generateTableHtml(data);
        $(tableSelector).html(tableHtml);
        initializeTooltips();
      // คงสถานะแท็บที่กำลังแสดงอยู่

      // คืนค่า active ให้กับแท็บที่บันทึกไว้
      $(`#${activeTabId}`).addClass("show active");
      $(`button[data-bs-target="#${activeTabId}"]`).addClass("active");
    }
    // ,
    // error: function(xhr, status, error) {
    //     console.log('Status:', status);
    //     console.log('Error:', error);
    //     console.log('Response Text:', xhr.responseText); // ดูข้อความตอบกลับจากเซิร์ฟเวอร์
    //     Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้', 'error');
    // }
  });
}

// ฟังก์ชันสำหรับเปิดใช้งาน tooltips
function initializeTooltips() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('.tooltips'));
  tooltipTriggerList.forEach(function(tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
}

// อัพเดท activeTabId เมื่อผู้ใช้คลิกที่แท็บ
$('button[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
  activeTabId = $(e.target).attr("data-bs-target").substring(1); // บันทึก activeTabId เมื่อคลิกแท็บ
});

// เรียก refreshTable ทุก ๆ 5 วินาทีด้วยค่า currentRoomSta ที่ดึงจาก URL
setInterval(function() {
  refreshTable(currentRoomSta);
}, 5000);

</script>
<script>
function generateTableHtml(data, activeTabId) {
  let html = `
    <div class="card">
      <div class="tab-content" id="patientTabsContent">
        <div class="tab-pane fade ${activeTabId === "pending" ? "show active" : ""}" id="pending" role="tabpanel" aria-labelledby="pending-tab">
          <div class="accordion">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-target="#collapsePending" aria-expanded="true" aria-controls="collapsePending">
                  <i class="bi-folder2-open icon-menu"></i><span>ข้อมูลผู้ป่วยที่รอรับบริการของ ${data.room_sta === 'finance' ? 'แผนกการเงิน' : 'แผนกเภสัชกรรม'}</span>
                </button>
              </h2>
              <div id="collapsePending" class="accordion-collapse" aria-labelledby="headingPending">
                <div class="accordion-body">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table" width="100%">
                        <thead>
                          <tr>
                            <th width="10%" class="text-center text-primary-emphasis">หมายเลขคิว</th>
                            <th width="10%" class="text-center text-primary-emphasis">หมายเลขคิวของการเงินและยา</th>
                            <th width="10%" class="text-center text-primary-emphasis">ชื่อผู้ป่วย</th>
                            <th width="10%" class="text-center text-primary-emphasis">Visit</th>
                            <th width="10%" class="text-center text-primary-emphasis">HN</th>
                            <th width="10%" class="text-center text-primary-emphasis">เวลาเข้าแผนก</th>
                            <th width="10%" class="text-center text-primary-emphasis">สถานะการเรียก</th>
                            <th width="10%" class="text-center text-primary-emphasis">ดำเนินการ</th>
                          </tr>
                        </thead>
                        <tbody>
  `;

  data.que_finance_medicine.forEach(fm => {
    html += `
                          <tr>
                            <td class="font-18 text-center">${fm.apm_ql_code}</td>
                            <td class="font-18 text-center">${fm.apm_rm_code}</td>
                            <td>${fm.pt_prefix} ${fm.pt_fname} ${fm.pt_lname}<br><b><span style="color:${fm.pri_color};">${fm.pri_name}</span></b></td>
                            <td class="text-center">${fm.apm_visit}</td>
                            <td class="text-center">${fm.pt_member}</td>
                            <td class="text-center">${fm.apm_rm_time}</td>
                            <td class="text-left" style="color:${fm.sta_color};">
                              ${fm.sta_name}<br>
    `;

    data.que_status_all.forEach(qa => {
      if (fm.qus_status == qa.sta_id) {
        html += `<span style="color:${qa.sta_color};">&nbsp; - ${qa.sta_name}</span><br>`;
      }
    });

    let qus_channels = fm.qus_channel ? fm.qus_channel.split(',') : [];
    qus_channels.forEach(channel_id => {
      data.que_status_all.forEach(qa => {
        if (channel_id.trim() == qa.sta_id) {
          html += `<span style="color:${qa.sta_color};">&nbsp; - ${qa.sta_name}</span><br>`;
        }
      });
    });

    html += `</td>
              <td class="text-center">
                <button class="btn btn-info tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="ข้อมูลผู้ป่วย" onclick="showModalApm('${fm.apm_id}')">
                  <i class="bi-search"></i>
                </button>
    `;

    if ((data.room_sta == 'finance' && fm.apm_sta_id == 16) || (data.room_sta == 'medicine' && fm.apm_sta_id == 17)) {
      if(fm.sta_name != 'กำลังเตรียมยา'){
      html += `
                <button class="btn btn-primary tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="ปรับสถานะผู้ป่วย" onclick="showPatientStatusModal(${fm.apm_id}, '${data.room_sta}')">
                  <i class="bi bi-inboxes-fill"></i>
                </button>
      `;
      }
    } else {
      html += `
                <button class="btn btn-primary tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="ปรับสถานะผู้ป่วย" onclick="showPatientStatusModal(${fm.apm_id}, '${data.room_sta}')">
                  <i class="bi bi-inboxes-fill"></i>
                </button>
                <button class="btn btn-success tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="เสร็จสิ้น" onclick="confirmCompletion(${fm.apm_id}, '${data.room_sta}')">
                  <i class="bi bi-check-circle"></i>
                </button>
      `;
    }

    html += `</td>
          </tr>
    `;
  });

  html += `
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="tab-pane fade ${activeTabId === "completed" ? "show active" : ""}" id="completed" role="tabpanel" aria-labelledby="completed-tab">
          <div class="accordion">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-target="#collapseCompleted" aria-expanded="true" aria-controls="collapseCompleted">
                  <i class="bi-folder2-open icon-menu"></i><span>ข้อมูลผู้ป่วยที่ดำเนินการเสร็จสิ้น</span>
                </button>
              </h2>
              <div id="collapseCompleted" class="accordion-collapse collapse show" aria-labelledby="headingCompleted">
                <div class="accordion-body">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table" width="100%">
                        <thead>
                          <tr>
                            <th width="10%" class="text-center text-primary-emphasis">หมายเลขคิว</th>
                            <th width="10%" class="text-center text-primary-emphasis">หมายเลขคิวของการเงินและยา</th>
                            <th width="10%" class="text-center text-primary-emphasis">ชื่อผู้ป่วย</th>
                            <th width="10%" class="text-center text-primary-emphasis">Visit</th>
                            <th width="10%" class="text-center text-primary-emphasis">HN</th>
                            <th width="10%" class="text-center text-primary-emphasis">เวลาเข้าแผนก</th>
                            <th width="10%" class="text-center text-primary-emphasis">สถานะการเรียก</th>
                            <th width="10%" class="text-center text-primary-emphasis">ดำเนินการ</th>
                          </tr>
                        </thead>
                        <tbody>
  `;

  data.que_success.forEach(fm => {
    html += `
                          <tr>
                            <td class="font-18 text-center">${fm.apm_ql_code}</td>
                            <td class="font-18 text-center">${fm.apm_rm_code}</td>
                            <td>${fm.pt_prefix} ${fm.pt_fname} ${fm.pt_lname}<br><b><span style="color:${fm.pri_color};">${fm.pri_name}</span></b></td>
                            <td class="text-center">${fm.apm_visit}</td>
                            <td class="text-center">${fm.pt_member}</td>
                            <td class="text-center">${fm.apm_rm_time}</td>
                            <td class="text-left" style="color:${fm.sta_color};">
                              ${fm.sta_name}<br>
    `;

    data.que_status_all.forEach(qa => {
      if (fm.qus_status == qa.sta_id) {
        html += `<span style="color:${qa.sta_color};">&nbsp; - ${qa.sta_name}</span><br>`;
      }
    });

    let qus_channels = fm.qus_channel ? fm.qus_channel.split(',') : [];
    qus_channels.forEach(channel_id => {
      data.que_status_all.forEach(qa => {
        if (channel_id.trim() == qa.sta_id) {
          html += `<span style="color:${qa.sta_color};">&nbsp; - ${qa.sta_name}</span><br>`;
        }
      });
    });

    html += `
                            </td>
                            <td class="text-center">
                              <button class="btn btn-info tooltips ms-1 ps-2 pe-2 pt-1 pb-1" title="ข้อมูลผู้ป่วย" onclick="showModalApm('${fm.apm_id}')">
                                <i class="bi-search"></i>
                              </button>
                            </td>
                          </tr>
    `;
  });

  html += `
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;

  return html;
}


</script>

