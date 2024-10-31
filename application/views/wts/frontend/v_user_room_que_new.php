<style>
  #priority-text {
    font-size:25px;
  }
  #main {
    padding: 0px;
  }
  @media (min-width: 1400px) {
    .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 100% !important;
    }
  }
  .logo {
    margin-left: 0px !important;
  }
  #profile_picture{
    max-height: 120px;
  }
  /* .card-header {
    display: flex;
    justify-content: space-between;
  } */
  .badge-priority {
      position: absolute;
      transform: translate(0%, -25%);
      margin-left: 65px;
      font-size: 25px;
  }
  .badge-priority-footer {
      position: absolute;
      transform: translate(100%, -25%);
      margin-left: 65px;
      font-size: 25px;
  }
  .icon-see-doctor {
    position: absolute;
    transform: translate(0%, -3%);
    margin-left: -50px;
    color: #005d87 !important;
    font-weight: 600;
  }
  .card-body {
    min-height: calc(3.7em* 9);
  }

  .card-room {
    margin-left: auto;
    margin-right: auto;
  }
</style>
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
  .que-animetion {
    /* position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    line-height: 50px;
    text-align: center; */
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
    background-color: #005d87 !important;
    color:#FFF;
    /* color: #005d87 !important; */
    font-weight: 600;
  }

  #main {
    min-height: 67vh !important;
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

<div class="row mt-0" style="margin-top: -40px !important;
    z-index: 9999;
    position: absolute;
    left: 45%;">
  <h2 class="text-center">
    <span class="font-40"><?php echo $stde_name ; ?></span>
    <span class="ms-5">วันที่</span>
    <span id="current-time"></span>
  </h2>
</div>

<div class="row g-3 mt-3 queue-container" style='zoom:90%;margin-top: -50px !important;'>
  <?php 
  $colorSchemes = [
    1 => ['background-color' => '#9a581c', 'color' => '#FFF', 'border' => '4px solid #9a581c;'], 
    2 => ['background-color' => '#ad1f4d', 'color' => '#FFF', 'border' => '4px solid #ad1f4d;'], 
    3 => ['background-color' => '#0fa174', 'color' => '#FFF', 'border' => '4px solid #0fa174;'], 
    4 => ['background-color' => '#81447c', 'color' => '#FFF', 'border' => '4px solid #81447c;'], 
    5 => ['background-color' => '#fafac8', 'color' => '#FFF', 'border' => '4px solid #FFEB3B;'], 
    6 => ['background-color' => '#ffc5ea', 'color' => '#FFF', 'border' => '4px solid #FFEB3B;'], 
    7 => ['background-color' => '#B0E57C', 'color' => '#FFF', 'border' => '4px solid #FFEB3B;'], 
    8 => ['background-color' => '#ffe5c4', 'color' => '#FFF', 'border' => '4px solid #FFEB3B;'], 
    9 => ['background-color' => '#F0D9FF', 'color' => '#FFF', 'border' => '4px solid #FFEB3B;'], 
    10 => ['background-color' => '#ffa1a1', 'color' => '#FFF', 'border' => '4px solid #FFEB3B;'], 
  ];
  ?>
</div>

<!-- <div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar scroll-left">
    <div style="margin-top: -10px; font-size: 32px; font-weight: 600;">คิวปัจจุบัน <?php //echo $pre_que[0]['apm_ql_code']; ?></div>
  </div>
</div> -->

<script>
  var queue_more = [];
  let priorities = <?php echo json_encode(!empty($priorities) ? $priorities : []); ?>;

  $(document).ready(function() {
    // Select all elements with the class 'col-md-3 mt-2 d-none d-lg-block'
    const elements = document.querySelectorAll('.col-md-3.mt-2.d-none.d-lg-block');

    // Loop through each element and apply 'display: none !important'
    elements.forEach(element => {
        element.style.setProperty('display', 'none', 'important');
    });

    // let pri_ids = <?php //echo json_encode(!empty($pri_ids) ? $pri_ids : []); ?>;
    // show_priority(pri_ids);

    updateQueue();
    setTimeout(function() {
        show_queue_more();
    }, 500); // Adjust the time as needed to wait for the operations to complete
  });

  function show_priority(pri_ids) {
    if (pri_ids.length > 0) {
        // Filter the priorities to include only those with pri_ids in pri_ids array
        var filteredPriorities = priorities.filter(function(priority) {
            return pri_ids.includes(priority.pri_id); // Check if pri_id exists in pri_ids
        });

        // Further filter the priorities to include only pri_id 1 and 2
        filteredPriorities = filteredPriorities.filter(function(priority) {
            return priority.pri_id === "1" || priority.pri_id === "2";
        });

        // เขียนใหม่
        // If there are matching priorities, construct the text
        filteredPriorities.reverse();
        if (filteredPriorities.length > 0) {
            var priorityText = 'หมายเหตุ: ';
            filteredPriorities.forEach(function(priority, index) {
                priorityText += (index + 1 === filteredPriorities.length) ? '**' : '*';
                priorityText += ' ' + priority.pri_name;
                if (index + 1 < filteredPriorities.length) {
                    priorityText += ' และ ';
                }
            });

            // Set the text to the element
            $('#priority-text').html(priorityText); // this element from template/footer_frontend
            $('#priority-div').removeClass('d-none'); // this element from template/footer_frontend
        }
    }
  }

  function show_queue_more() {
    // Condition for adding the class
    if (queue_more.length > 0) {
      console.log(queue_more);
      // Select elements
      const copyright = document.querySelector('.copyright');
      const credits = document.querySelector('.credits');
      const footer = document.querySelector('#footer');

      // Add the 'd-none' class to both .copyright and .credits
      copyright.classList.add('d-none');
      credits.classList.add('d-none');

      // Clear the new div if it exists
      const queue_more_div = footer.querySelector('.queue-more');
      if (queue_more_div) {
        footer.removeChild(queue_more_div);
      }

      // Create a new div element
      const newDiv = document.createElement('div');
      // Add both 'queue-more' and 'que-animetion' classes
      newDiv.classList.add('queue-more', 'text-white', 'font-30');
      if(queue_more.length > 12)
        newDiv.classList.add('que-animetion');
      else
        newDiv.classList.add('text-center');

      // Map each item with conditional formatting based on apm_sta_id and apm_pri_id
      var joinedString = queue_more.map(item => {
          let prefix = '';

          if (item['apm_sta_id'] === '2') {
              prefix += "<i class='bi-caret-right-fill text-white'></i> ";
          }

          if (item['apm_pri_id'] === '2') {
              prefix += "<span class='text-danger badge-priority-footer'>*</span> ";
          } else if (item['apm_pri_id'] === '1') {
              prefix += "<span class='text-danger badge-priority-footer'>**</span> ";
          }

          return prefix + 'คิวที่ ' + item['apm_ql_code'];
      }).join(" , ");

      newDiv.innerHTML = joinedString;
      // Append the new div to the footer
      footer.appendChild(newDiv);
    } else {
      // Select elements
      const copyright = document.querySelector('.copyright');
      const credits = document.querySelector('.credits');
      const footer = document.querySelector('#footer');

      // Remove the 'd-none' class from both .copyright and .credits
      copyright.classList.remove('d-none');
      credits.classList.remove('d-none');

      // Remove the new div if it exists
      const newDiv = footer.querySelector('.queue-more');
      if (newDiv) {
        footer.removeChild(newDiv);
      }
    }
  }
  setInterval(show_queue_more, 15000);

  function updateTime() {
    const now = new Date();
    const options = { 
      year: 'numeric', month: 'long', day: 'numeric',
      hour: '2-digit', minute: '2-digit', second: '2-digit', 
      timeZone: 'Asia/Bangkok'
    };
    const formatter = new Intl.DateTimeFormat('th-TH', options);
    document.getElementById('current-time').textContent = ` ${formatter.format(now)}`;
  }

  updateTime();
  setInterval(updateTime, 1000);
</script>

<script>
function updateQueue() {
  fetch('<?php echo site_url('wts/frontend/User_room_que/get_room_queue_by_floor/' . $floor); ?>')
    .then(response => response.json())
    .then(data => {
      // Clear the current queue
      let queueContainer = document.querySelector('.queue-container');
      queueContainer.innerHTML = '';
      // reset queue more, pri_ids
      let pri_ids = [];
      queue_more = [];

      // Check if there are any items in the queue
      if (Object.keys(data.room_que).length === 0) {
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
        // Parse the map_seq_room data
        let mapSeqRoom = data.map_seq_room;

        // Create a mapping from qus_psrm_id to index
        const idToIndexMap = mapSeqRoom.reduce((acc, item) => {
            acc[item.qus_psrm_id] = item.index;
            return acc;
        }, {});

        // Get entries and sort them based on the index
        const sortedEntries = Object.entries(data.room_que).sort((a, b) => {
            const indexA = idToIndexMap[a[0]];
            const indexB = idToIndexMap[b[0]];
            return indexA - indexB;
        });

        // Render sorted queue data
        sortedEntries.forEach(([room_id, room], index) => {
          let colors = <?php echo json_encode($colorSchemes); ?>[index + 1] || <?php echo json_encode($colorSchemes); ?>[index + 1];
          let rightBorderStyle = `border-right: 2px solid ${colors['background-color']};`;
          let leftBorderStyle = `border-left: 2px solid ${colors['background-color']};`;

          let card = document.createElement('div');
          card.className = 'col-md-3 p-0 card-room';

          // Loop through the array using jQuery
          var firstMatch = null;
          $.each(room, function(index, entry) {
              if (entry.ps_id === room[0].ps_id) {
                  firstMatch = entry;
                  return false; // Exit loop after first match
              }
          });
          let count_walkin = 0;
          let count_appointment = 0;

          card.innerHTML = `
            <div class="card mb-0">
              <div class="card-header text-center fw-bold d-flex align-items-center justify-content-center" style="font-size: 44px; background-color: ${colors['background-color']}; color: ${colors['color']};">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9b2500; background: #fbd4c7;">
                  <img id="profile_picture" class="rounded-circle" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon_que?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image="); ?>${room[0].psd_picture ?? "default.png"}">
                </div>
                <div class="ps-4 text-center">
                  <span>${firstMatch != null ? firstMatch.rm_name ?? "-" : "-"}</span>
                  <div class="col-12" style="font-size: 30px;">
                    ${room[0].pf_name_abbr || ''}${room[0].ps_fname || ''}
                  </div>
                </div>
              </div>
              <div class="card-body p-0 row">
                <div class="col-md-6" style="${rightBorderStyle} padding-right: 0px;">
                  <table class="table table-borderless mb-0" style="font-size: 45px; width: 100%; table-layout: fixed;">
                    <thead>
                      <tr>
                        <th class="text-center" style="font-size: 30px;">ปกติ</th>
                      </tr>
                    </thead>
                    <tbody>
                      ${
                        room.filter(item => {
                        let isShow = false;
                        if (item.qus_app_walk != null) {
                          if (item.qus_app_walk && item.qus_app_walk === 'W') {
                            isShow = true;
                          } 
                        } else {
                          if (item.apm_app_walk === 'W' && (item.apm_pri_id === 2 || item.apm_pri_id === 5)) {
                            isShow = true;
                          }
                        }

                        if(isShow) {
                          if (count_walkin > 6) {
                            queue_more.push({ apm_ql_code: item.apm_ql_code, apm_pri_id: item.apm_pri_id, apm_sta_id:item.apm_sta_id })
                            isShow = false;
                          } else 
                            count_walkin++;

                          if (!pri_ids.includes(item.apm_pri_id)) pri_ids.push(item.apm_pri_id);
                        }

                        return isShow;
                      }).map(item => `
                        <tr class="text-center" style="width: 50%;">
                          <td class="p-0">
                            <div style="width: 100%; height: 100%;">
                              ${
                                item.apm_pri_id == 1 ? "<span class='text-danger badge-priority'>**</span>" : 
                                item.apm_pri_id == 2 ? "<span class='text-danger badge-priority'>*</span>" :
                                ""
                              }
                              ${
                                item.apm_sta_id == 2 ? "<i class='bi-caret-right-fill icon-see-doctor'></i> " : ""
                              }
                              ${item.apm_ql_code}
                            </div>
                          </td>
                        </tr>
                      `).join('')}
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6" style="${leftBorderStyle} padding: 0px;">
                  <table class="table table-borderless mb-0" style="font-size: 45px; width: 100%; table-layout: fixed;">
                    <thead>
                      <tr>
                        <th class="text-center" style="font-size: 30px;">นัดหมาย</th>
                      </tr>
                    </thead>
                    <tbody>
                      ${
                        room.filter(item => {
                        let isShow = false;
                        if (item.qus_app_walk != null) {
                          if (item.qus_app_walk && item.qus_app_walk === 'A') {
                            isShow = true;
                          } 
                        } else {
                          if (item.apm_app_walk === 'A' || [1, 4].includes(item.apm_pri_id)) {
                            isShow = true;
                          }
                        }

                        if(isShow) {
                          if (count_appointment > 6) {
                            queue_more.push({ apm_ql_code: item.apm_ql_code, apm_pri_id: item.apm_pri_id, apm_sta_id:item.apm_sta_id })
                            isShow = false;
                          } else 
                            count_appointment++;

                          if (!pri_ids.includes(item.apm_pri_id)) pri_ids.push(item.apm_pri_id);
                        }

                        return isShow;
                      }).map(item => `
                        <tr class="text-center" style="width: 50%;">
                          <td class="p-0">
                            <div style="width: 100%; height: 100%;">
                              ${
                                item.apm_pri_id == 1 ? "<span class='text-danger badge-priority'>**</span>" : 
                                item.apm_pri_id == 2 ? "<span class='text-danger badge-priority'>*</span>" :
                                ""
                              }
                              ${
                                item.apm_sta_id == 2 ? "<i class='bi-caret-right-fill icon-see-doctor'></i> " : ""
                              }
                              ${item.apm_ql_code}
                            </div>
                          </td>
                        </tr>
                      `).join('')}
                    </tbody> 
                  </table>
                </div>
              </div>
            </div>
          `;

          queueContainer.appendChild(card);
        });
      }
      show_priority(pri_ids);
      // show_queue_more();
    })
    .catch(error => console.error('Error updating queue:', error));
}

// Update the queue every 5 seconds
setInterval(updateQueue, 5000);


</script>