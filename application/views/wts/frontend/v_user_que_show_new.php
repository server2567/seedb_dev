<div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar">
    &nbsp;<i class="bi bi-caret-right text-white"></i>&nbsp;
      &nbsp;<i class="bi bi-sort-numeric-down text-white"></i>&nbsp;
      <span class='font-16 text-white'>หน้าแสดงคิว</span>
  </div>
</div>
<style>
  .card {
    border: none;
  }

  .card-header {
    border-bottom: 6px dashed #fff;
    border-radius: 10px 10px 0 0;
    background-color: #8f6302;
    position: relative;
  }

  .card-header-success {
    border-radius: 10px;
    background-color: #2a9f2e;
    position: relative;
    padding: 50px;
  }
  .mt-80 {
      margin-top: 0px;
    }
  @media (max-width: 1473px) {
    .header {
        zoom: 80%;
        display: none !important;
    }
  }
  @media (max-width: 992px) {
    .topbar {
        top: 0px;
    }
    a.nav-link.nav-profile.d-flex.align-items-center.pe-0 {
        top: 5px !important;
        right: 5% !important;
    }
    ul.dropdown-menu.dropdown-menu-end.dropdown-menu-arrow.profile.show {
        transform: translate(-30px, 40px) !important;
    }
    .dropdown-toggle {
      white-space: nowrap;
      font-size: 18px;
    }
    .mt-80 {
      margin-top: -80px;
    }
  }
</style>
<?php if(count($pt_que) > 0) { ?>
  <?php if ($que_person[0]['apm_sta_id'] != 15) { ?>
    <div class="card mt-80" >
      <div class="card-header">
        <div class="d-flex flex-column align-items-center mt-4">
          <div class="d-flex flex-column align-items-center" style="margin-top: -40px;">
            <h3 class=" text-white pt-2 text-center" style="line-height: 1.7;">
              <?php if ($que_person[0]['apm_rm_code']) { ?>
                คิวชำระเงิน และรับยา
              <?php } else { ?>
                <?php echo $que_person[0]['rm_name']; ?><br>
                หมายเลขคิวปัจจุบัน
              <?php } ?>
            </h3>
            <?php if ($que_person[0]['apm_rm_code']) { ?>

            <?php } else { ?>
              <h1 class="text-center text-white mt-1 mb-1" style="font-size:50px;">
                <?php echo isset($que_current_stde[0]['apm_ql_code']) ? $que_current_stde[0]['apm_ql_code'] : 'ยังไม่มีการเรียกคิว'; ?>
              </h1>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php
      // แปลง apm_sta_id เป็น array เพื่อเปรียบเทียบ
      $completed_status = [2, 4, 11, 12];

      // กำหนดข้อความประเภทคิวตาม apm_pri_id
      $priority_labels = [
        1 => '<span style="color: #FF1515; font-weight: bold;">(ฉุกเฉิน)</span>',
        2 => '<span style="color: #ff9800; font-weight: bold;">(เฝ้าระวัง)</span>',
        4 => '<span style="color: #007e22; font-weight: bold;">(แบบนัดหมาย)</span>',
        5 => '<span style="color: #012970; font-weight: bold;">(แบบปกติ)</span>',
        6 => '<span style="color: #872400; font-weight: bold;">(ผ่าตัด)</span>',
      ];
      $priority_sta_id = [
        11 => '<span style="color: #872400; font-weight: bold;" class="pt-3">ทำหัตถการ</span>',
        12 => '<span style="color: #872400; font-weight: bold;" class="pt-3">ทำหัตถการ</span>'
      ]
      ?>
      <?php if (in_array($que_person[0]['apm_sta_id'], $completed_status)) { ?>
        <div class="card-body mb-3">
          <?php
          // ตรวจสอบและแสดงผลข้อความประเภทคิว
          $priority_text = isset($que_person[0]['apm_pri_id']) && isset($priority_labels[$que_person[0]['apm_pri_id']])
            ? $priority_labels[$que_person[0]['apm_pri_id']]
            : ''; // แสดงข้อความนี้หาก apm_pri_id ไม่มีในรายการ
          ?>
          <?php
          // ตรวจสอบและแสดงผลข้อความประเภทคิว
          $priority_sta_id = isset($que_person[0]['apm_sta_id']) && isset($priority_sta_id[$que_person[0]['apm_sta_id']])
            ? $priority_sta_id[$que_person[0]['apm_sta_id']]
            : ''; // แสดงข้อความนี้หาก apm_pri_id ไม่มีในรายการ
          ?>
          <h3 class="text-dark text-center pt-1">
            หมายเลขคิวของท่าน <?php echo $priority_text; ?>
          </h3>
          <h1 class="text-center text-primary" style="font-size:50px;">
            <?php echo $que_person[0]['apm_ql_code']; ?><br><?php echo $priority_sta_id; ?>
          </h1>

          <?php if (!empty($que_current_stde) && !empty($que_person)): ?>
            <?php if ($que_current_stde[0]['apm_ql_code'] == $que_person[0]['apm_ql_code']): ?>
              <h1 class="text-center text-success">ถึงคิวของท่านแล้ว</h1>
            <?php endif; ?>
          <?php else: ?> <?php endif; ?>

          <h3 class="text-dark text-center pt-4">แพทย์</h3>
          <h2 class="text-center pt-2">
            <?php
            if (!empty($que_person) && isset($que_person[0]['pf_name_abbr'], $que_person[0]['ps_fname'], $que_person[0]['ps_lname'])) {
              echo $que_person[0]['pf_name_abbr'] . '' . $que_person[0]['ps_fname'] . ' ' . $que_person[0]['ps_lname'];
            } else {
              echo '<span class="h4">รอการระบุแพทย์</span>';
            }
            ?>
          </h2>
          <h2 class="text-center pt-2"><?php echo $que_person[0]['stde_name_th']; ?></h2>
          <?php if (isset($remaining_que) && is_numeric($remaining_que)): ?>
            <h3 class="text-primary text-center pt-3" style="line-height: 2;">
              <?php if ($remaining_que == 0): ?>
                <span class="fw-bold text-success h1">(กรุณารอเรียกคิวถัดไป)</span>
              <?php else: ?>
                กรุณารออีก
                &emsp;<b class="h1 text-primary-emphasis fw-bold"><?php echo $remaining_que; ?></b>&emsp;คิว<br>
                เวลาที่คาดว่าจะได้รับการตรวจ หรือเวลาอาจะคลาดเคลื่อน<br>
                <b class="h1 text-primary-emphasis fw-bold">
                  <?php echo !empty($expected_time) ? $expected_time . ' น.' : 'ไม่ทราบเวลา'; ?>
                </b>
              <?php endif; ?>
            </h3>
          <?php else: ?>
            <!-- <h3 class="text-danger text-center pt-4">ไม่พบข้อมูลคิว</h3> -->
          <?php endif; ?>

        </div>
      <?php } else { ?>
        <div class="card-body mb-3">
          <?php
          // ตรวจสอบและแสดงผลข้อความประเภทคิว
          $priority_text = isset($que_person[0]['apm_pri_id']) && isset($priority_labels[$que_person[0]['apm_pri_id']])
            ? $priority_labels[$que_person[0]['apm_pri_id']]
            : ''; // แสดงข้อความนี้หาก apm_pri_id ไม่มีในรายการ
          ?>
          <h3 class="text-dark text-center pt-4">
            หมายเลขคิวของท่าน <?php echo $priority_text; ?>
          </h3>
          <h1 class="text-center text-primary">
            <?php echo $que_person[0]['apm_ql_code']; ?>
          </h1>
          <?php if (!empty($que_pay)): ?>
            <h1 class="text-center pt-4 fw-bold" style="color:<?php echo $que_pay[0]['wts_status1_sta_color']; ?>;">สถานะ: <?php echo $que_pay[0]['wts_status1_sta_name']; ?></h1>
            <h1 class="text-center pt-4 fw-bold" style="color:<?php echo $que_pay[0]['wts_status2_sta_color']; ?>;">ช่องทำการ: <?php echo $que_pay[0]['wts_status2_sta_name']; ?></h1>
          <?php else: ?>

          <?php endif; ?>
        </div>
      <?php } ?>
      <div class="card-body mb-3 pt-0">
        <h3 class="text-center text-secondary-emphasis">เส้นทางการให้บริการ</h3>
        <ul class="route-list">
          <?php foreach (array_reverse($que_nav) as $key => $nav): ?>
            <li class="<?php echo $key === 0 ? 'current-step' : 'current'; ?>">
              <?php echo $key === 0 ? '' : '<i class="bi bi-arrow-up-circle"></i>'; ?>
              <span class="step-number mb-2">
                <?php echo 'จุดบริการที่ ' . (count($que_nav) - $key); ?>
              </span>
              <span class="room-name">
                <?php echo $key === 0 ? 'ปัจจุบันอยู่ที่ <b style="color:#004f12;">(' . $nav['rm_name'] . ')</b>' : '' . $nav['rm_name'] . ''; ?>
              </span>
              
              <!-- <span class="location-name">จาก <?php echo $nav['loc_name']; ?></span> -->
            </li>

          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php } else { ?>
    <div class="card">
      <div class="card-header-success">
        <div class="d-flex flex-column align-items-center mt-4">
          <div class="d-flex flex-column align-items-center" style="margin-top: -40px;">
            <h1 class="text-center text-white mt-3 mb-3">
              สิ้นสุดการให้บริการแล้ว
            </h1>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
<?php } else { ?>
  <div class="card">
      <div class="card-header-success">
        <div class="d-flex flex-column align-items-center mt-4">
          <div class="d-flex flex-column align-items-center" style="margin-top: -40px;">
            <h1 class="text-center text-white mt-3 mb-3">
              สิ้นสุดการให้บริการแล้ว
            </h1>
          </div>
        </div>
      </div>
    </div>
<?php } ?>

<style>
  @media (max-width: 1199px) {
    #main {
      padding: 0px;
    }
  }

  .route-list {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 18px;
    color: #333;
  }

  .route-list li {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f8f9fa;
    flex-direction: column;
  }

  .route-list li.current-step {
    background-color: #deeeff;
    /* สีพื้นหลังของจุดปัจจุบัน */
    color: #28a745;
    /* สีข้อความ */
    font-weight: bold;
    border-color: #0056b3;
    font-size:22px;
  }



  .route-list li.current-step .step-number,
  .route-list li.current-step .room-name {
    color: #28a745;
    /* สีข้อความของจุดปัจจุบัน */
  }

  .route-list li .step-number {
    font-weight: bold;
    color: #007bff;
    margin-right: 10px;
  }

  .route-list li .location-name {
    font-weight: bold;
    color: #0d4b68;
    margin-right: 0px;
  }

  .route-list li .room-name {
    font-weight: bold;
    color: #0d4b68;
  }

  .route-list li i {
    margin: 0 10px;
    /* font-size: 1.2rem; */
    font-size: 26px;
    color: #ff9800;
  }
</style>