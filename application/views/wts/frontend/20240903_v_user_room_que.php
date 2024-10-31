<?php if (isset($session_view) && $session_view == 'frontend') { ?>
  <div class="row topbar toggle-sidebar-btn" style="display: none;">
    <div class="col-md-12 nav_topbar">
      <a href="<?php echo $this->config->item('ums_webstie'); ?>">
        <i class="bi bi-globe-asia-australia"></i>&nbsp;
        <span class="font-14">เว็บไซต์หลัก</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a href="<?php echo site_url(); ?>/ums/frontend/Dashboard_home_patient">
        <i class="bi bi-house-door"></i>&nbsp;
        <span class='font-16'>หน้าหลัก</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a href="<?php echo site_url(); ?>/ums/frontend/Dashboard_home_patient/news_all">
        <i class="bi bi-card-checklist"></i>&nbsp;
        <span class='font-16'>หน้าตรวจสอบคิวของแผนก</span>
      </a>
    </div>
  </div>
<?php } else { ?>
  <div class="row topbar toggle-sidebar-btn" style="display: none;">
    <div class="col-md-12 nav_topbar">
      <a href="<?php echo site_url() . '/personal_dashboard/Personal_dashboard_Controller' ?>">
        <span class='font-16'>หน้า PD</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a id="prevPageLink" href="#">
        <span id="prevPageText" class='font-16'>จัดการข้อมูลผู้ลงทะเบียน / ผู้ป่วย</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <i class="bi bi-person-circle text-white"></i>&nbsp;
      <span class='font-16 text-white'>หน้าข้อมูลส่วนตัวผู้ลงทะเบียน / ผู้ป่วย</span>
    </div>
  </div>
  <script>
    function setPreviousPage() {
      var prevPage = document.referrer;
      var prevPageText = 'จัดการข้อมูลผู้ลงทะเบียน / ผู้ป่วย'; // Default text

      if (prevPage.includes('personal_dashboard/Personal_dashboard_Controller')) {
        prevPageText = 'หน้าหลัก (PD)';
      } else if (prevPage.includes('some_other_page')) {
        prevPageText = 'หน้าอื่นๆ'; // Adjust this condition and text based on your needs
      }

      var prevPageLink = document.getElementById('prevPageLink');
      var prevPageTextElement = document.getElementById('prevPageText');

      if (prevPageLink && prevPageTextElement) {
        prevPageLink.href = prevPage;
        prevPageTextElement.textContent = prevPageText;
      }
    }

    document.addEventListener('DOMContentLoaded', setPreviousPage);
  </script>
<?php } ?>

<style>
  .nav_topbar {
    height: 50px;	
    overflow: hidden;
    position: relative;
  }
  .nav_topbar div {
    position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    line-height: 50px;
    text-align: center;
    transform: translateX(100%);
    animation: scroll-left 20s linear infinite;
  }
  @keyframes scroll-left {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
  }
  .btn-login {
    display: none;
  }
  .bg-warning-que { 
    background-color: #95f3ff !important;
  }
</style>

<?php
$locale = 'th_TH';
$fmt = new IntlDateFormatter(
    $locale,
    IntlDateFormatter::LONG,
    IntlDateFormatter::FULL,
    'Asia/Bangkok',
    IntlDateFormatter::GREGORIAN
);

$now = new DateTime();
$formattedDate = $fmt->format($now);
$year = $now->format('Y') + 543;
$formattedDate = str_replace(
    array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
    array('มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'),
    $formattedDate
);
$formattedDate = str_replace(date('Y'), $year, $formattedDate);
?>

<div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar scroll-left">
    <div>คิวปัจจุบัน <?php echo $pre_que[0]['apm_ql_code']; ?></div>
  </div>
</div>

<div class="row mt-4">
  <h2 class="text-center">
    <?php echo $stde_name . ' วันที่ ' ?>
    <span id="current-time"></span>
  </h2>
</div>

<div class="row g-3 mt-3 queue-container">
  <?php 
  $colorSchemes = [
    1 => ['background-color' => '#FFDAB9', 'color' => '#811d0b'], 
    2 => ['background-color' => '#d7efff', 'color' => '#0033A0'], 
    3 => ['background-color' => '#BFFFC6', 'color' => '#004d3b'], 
    4 => ['background-color' => '#E6E6FA', 'color' => '#3f3578'], 
    5 => ['background-color' => '#fafac8', 'color' => '#574900'], 
    6 => ['background-color' => '#ffc5ea', 'color' => '#5f0b41'], 
    7 => ['background-color' => '#B0E57C', 'color' => '#1e651e'], 
    8 => ['background-color' => '#ffe5c4', 'color' => '#d37400'], 
    9 => ['background-color' => '#F0D9FF', 'color' => '#371359'], 
    10 => ['background-color' => '#ffa1a1', 'color' => '#7f2200'], 
  ];
  ?>
  <?php if (empty($room_que) || empty(array_filter($room_que))) { ?>
    <div class="col-md-12">
      <div class="card mb-0">
        <div class="card-header text-center fw-bold" style="font-size: 40px; background-color: #006897;">
          <!-- Empty card header -->
        </div>
        <div class="card-body text-center">
            <h3>ไม่มีรายการคิว</h3>
        </div>
      </div>
    </div>
  <?php } else { 
    $index_room = 1; ?>
    <?php foreach ($room_que as $room_id => $room) {
        $colors = $colorSchemes[$index_room];
        $rightBorderStyle = 'border-right: 3px solid ' . $colors['background-color'] . ';';
        $bgClass = $key == 0 ? 'bg-warning-que' : ''; 
    ?>
    <div class="col-md-4">
      <div class="card mb-0">
        <div class="card-header text-center fw-bold" style="font-size: 40px; background-color: <?php echo $colors['background-color']; ?>; color: <?php echo $colors['color']; ?>;">
          <?php echo $room[0]['rm_name'] ?? ''; ?>
          <div class="col-12" style="font-size: 20px;">
            <?php 
              $fullName = '';
              if (isset($room[0]['pf_name']) || isset($room[0]['ps_fname']) || isset($room[0]['ps_lname'])) {
                $fullName = ($room[0]['pf_name'] ?? '') . ($room[0]['ps_fname'] ?? '') . ' ' . ($room[0]['ps_lname'] ?? '');
              }
              echo $fullName;
            ?>
          </div>
        </div>
        <div class="card-body p-0">
        <table class="table table-borderless mb-0" style="font-size: 45px; width: 100%; table-layout: fixed;">
  <thead>
    <tr>
      <th class="text-center" style="font-size: 30px; width: 50%; <?php echo $rightBorderStyle; ?>">
        ปกติ
      </th>
      <th class="text-center" style="font-size: 30px; width: 50%;">
        นัดหมาย
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
    <td class="text-center " style=" width: 50%; <?php echo $rightBorderStyle; ?>">
    <?php foreach ($room as $key => $item) { 
        if ($item['apm_app_walk'] == 'W') { 
            ?>
            <div style="width: 100%; height: 100%;">
                <?php echo $item['apm_ql_code']; ?>
            </div>
        <?php } 
    } ?>
</td>

<td class="text-center" style="width: 50%;">
    <?php foreach ($room as $key => $item) { 
        if ($item['apm_app_walk'] == 'A') { 
            $bgClass = $key == 0 ? 'bg-warning-que' : ''; ?>
            <div class="<?php echo $item['apm_sta_id'] == '2' ? $bgClass : ''; ?>" style="width: 100%; height: 100%;">
                <?php echo $item['apm_ql_code']; ?>
                <?php if ($item['apm_pri_id'] == '1') { ?>
                    <span class='text-danger me-2'>*<br></span>
                <?php } ?>
            </div>
        <?php } 
    } ?>
</td>
    </tr>
    
    <!-- Additional Rows for Emergency or High-Priority Cases -->
    <?php foreach ($room as $key => $item) { ?>
      <?php if ($item['apm_pri_id'] == '1') { ?>
        <tr>
  <td class="text-center <?php echo $item['apm_sta_id'] == '2' ? $bgClass : ''; ?>" style="padding: 20px; display: flex; justify-content: center; align-items: center; position: relative; <?php echo $rightBorderStyle; ?>">
    <span class='text-danger me-2 fw-bold' style='font-size: 26px; position: absolute; top: 50%; margin-top: -30px;'>* ผู้ป่วยฉุกเฉิน</span>
  </td>
</tr>
      <?php } ?>
      <?php if ($item['apm_pri_id'] == '2') { ?>
      <tr>
        <td colspan="2" class="text-center <?php echo $item['apm_sta_id'] == '2' ? $bgClass : ''; ?>" style="padding: 20px;">
          <span class='text-warning fw-bold' style='font-size: 26px;'>เฝ้าระวัง</span>
        </td>
      </tr>
      <?php } ?>
    <?php } ?>

  </tbody>
</table>
        </div>
      </div>
    </div>
    <?php $index_room++; } ?>
  <?php } ?>
</div>

<script>
  function updateTime() {
    const now = new Date();
    const options = { 
      year: 'numeric', month: 'long', day: 'numeric',
      hour: '2-digit', minute: '2-digit', second: '2-digit', 
      timeZone: 'Asia/Bangkok'
    };
    const formatter = new Intl.DateTimeFormat('th-TH', options);
    document.getElementById('current-time').textContent = `เวลา ${formatter.format(now)}`;
  }

  updateTime();
  setInterval(updateTime, 1000);
</script>

<!-- <script>
function updateQueue() {
  fetch('<?php echo site_url('wts/frontend/User_room_que/get_room_queue/' . urlencode($stde_name)); ?>')
    .then(response => response.json())
    .then(data => {
      // Clear the current queue
      let queueContainer = document.querySelector('.queue-container');
      queueContainer.innerHTML = '';

      // Convert room_que object to an array, sort by rm_name, and then render
      const sortedRoomQue = Object.entries(data.room_que).sort(([, a], [, b]) => {
        if (a[0].rm_name < b[0].rm_name) return -1;
        if (a[0].rm_name > b[0].rm_name) return 1;
        return 0;
      });

      // Check if there are any items in the queue
      if (sortedRoomQue.length === 0) {
        let emptyCard = document.createElement('div');
        emptyCard.className = 'col-md-12';
        emptyCard.innerHTML = `
          <div class="card mb-0">
            <div class="card-header text-center fw-bold" style="font-size: 40px; background-color: #006897;">

            </div>
            <div class="card-body text-center">
                <h3>ไม่มีรายการคิว</h3>
            </div>
          </div>
        `;
        queueContainer.appendChild(emptyCard);
      } else {
        // Render sorted queue data
        sortedRoomQue.forEach(([room_id, room], index) => {
          let colors = <?php echo json_encode($colorSchemes); ?>[index+1] || <?php echo json_encode($colorSchemes); ?>[index+1];
          let rightBorderStyle = `border-right: 3px solid ${colors['background-color']};`;

          let card = document.createElement('div');
          card.className = 'col-md-4';

          card.innerHTML = `
            <div class="card mb-0">
              <div class="card-header text-center fw-bold" style="font-size: 40px; background-color: ${colors['background-color']}; color: ${colors['color']};">
                ${room[0].rm_name}
                <div class="col-12" style="font-size: 20px;">
                  ${room[0].pf_name || ''}${room[0].ps_fname || ''} ${room[0].ps_lname || ''}
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table table-borderless mb-0" style="font-size: 45px; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; overflow: hidden;">
                            <thead>
              <th class="text-center" style="font-size: 30px;">
                ปกติ
              </th>
              <th class="text-center" style="font-size: 30px;">
                นัดหมาย
              </th>
            </thead>

                  <tbody>
                    ${room.map((item, key) => `
                      <tr>
                        <td class="text-center ${key === 0 && item.apm_sta_id == '2' ? 'bg-warning-que' : ''}" style="${rightBorderStyle}">
                          ${key + 1}
                        </td>
                        <td class="text-center ${key === 0  && item.apm_sta_id == '2' ? 'bg-warning-que' : ''}">
                          ${item.apm_ql_code}
                          ${item.apm_pri_id === '1' ? "<span class='text-danger me-2'>*<br></span>" : ""}
                        </td>
                      </tr>
                      ${item.apm_pri_id === '1' ? `
                      <tr>
                        <td class="text-center ${key === 0 && item.apm_sta_id == '2' ? 'bg-warning-que' : ''}" style="${rightBorderStyle}"></td>
                        <td colspan="2" style="padding: 20px;" class="text-center ${key === 0 && item.apm_sta_id == '2' ? 'bg-warning-que' : ''}">
                          <span class='text-danger me-2 fw-bold' style='font-size: 26px; margin-top: -30px; position: absolute; left: 34%;'>ผู้ป่วยฉุกเฉิน</span>
                        </td>
                      </tr>
                      ` : ''}
                    `).join('')}
                  </tbody>
                </table>
              </div>
            </div>
          `;

          queueContainer.appendChild(card);
        });
      }
    })
    .catch(error => console.error('Error updating queue:', error));
}

// Update the queue every 5 seconds
setInterval(updateQueue, 5000);
</script> -->
