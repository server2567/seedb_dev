<style>
  // dev
  #queue-section .card {
    height: 100%; /* กำหนดให้การ์ดกินพื้นที่เต็ม */
  }

  #queue-section {
    display: flex;
    flex-wrap: wrap; /* จัดเรียงเมื่อเนื้อหาเกิน */
  }
  .queue-container {
    display: flex;
  }
  .custom-announce-item {
    color: #ffffff; /* สีขาว */
    font-size: 36px; /* เพิ่มขนาดฟอนต์ */
    text-shadow: 2px 2px 4px #000000; /* เพิ่มเงาสีดำ */
    padding: 10px; /* เพิ่มระยะห่าง */
    background-color: rgba(255, 0, 0, 0.5); /* เพิ่มพื้นหลังโปร่งแสง */
  }

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
    transform: translateX(10%);
    animation: scroll-left 10s linear infinite;
  }
  .queue-more {
  white-space: nowrap;
  overflow: hidden;
  position: relative;
  display: block;
}
.announce-section {
  padding: 10px;
  background-color: #333; /* Background color for the announce section */
  color: white;
  text-align: center;
  margin-bottom: -1px; /* Space between the announcement section and the footer */
}


.que-animation {
  white-space: nowrap;
  position: absolute;
  display: inline-block;
  animation: scroll-left 15s linear infinite;
}
.announce-slide-left {
  animation: slideLeft 20s linear infinite;
  white-space: nowrap;
  overflow: hidden;
  position: absolute;
}
.announce-animation {
  display: inline-block;
  animation: scroll-left 20s linear infinite;
  white-space: nowrap;
  position: absolute;
  
}
.announce-item {
  overflow: hidden; /* To hide the text that moves outside the container */
  white-space: nowrap; /* Keep the text in a single line */
}
@keyframes slideLeft {
  from {
    transform: translateX(100%);
  }
  to {
    transform: translateX(-100%);
  }
}
@keyframes slide-left {
  0% {
    transform: translateX(100%); /* Start from the right */
  }
  100% {
    transform: translateX(-100%); /* Exit from the left */
  }
}


@keyframes scroll-left {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-100%);
  }
}
.fade-in {
  animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.fade-out {
  animation: fadeOut 0.2s ease-in-out forwards;  /* forwards ensures the element stays hidden */
}

@keyframes fadeOut {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
  }
}
.announce-section {
  padding-bottom: 10px; /* Add padding to separate it from the rest of the footer */
}

#footer {
  position: relative; /* Ensure footer's position context is defined */
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
  span.font-24 {
    position: absolute;
    top: 42px;
    left: 190px;
  }

  div#topbar_head {
    margin-top: -15px;
  }
    .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 100%;
    }
    html {
      zoom: 95%;
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

<div class="row mt-0" style="
    margin-top: -40px !important;
    z-index: 9999;
    position: fixed;
    top: 10%;
    left: 0;
    width: 100%;
">
    <!-- Left partition -->
    <div class="col-12 d-flex justify-content-end align-items-end" style="position: relative; height: 50px;">
        <h5 style="position: absolute; bottom: 0; right: 20px; top:-25px; font-size: 26px;">
            <?php echo $stde_name . ' วันที่ '; ?>
            <span id="current-time"></span>
        </h5>
    </div>

    <!-- Right partition -->
    <!-- <div class="col-7 d-flex justify-content-center align-items-center" style="margin-top: -35px;">
        <h2 class="text-center " style="color: #7a4900;" >
            <span id="current-time">ข่าวประชาสัมพันธ์</span> 
        </h2>
    </div> -->
    </div>
<!-- Marquee message -->
<div class="row" style="position: absolute; top: 20px; z-index: 1000; width:100%;">
    <div class="col-12">
    <div class="marquee-container">
        <p style="padding-bottom: 0px; padding-left:7%;">ขณะนี้อยู่ในช่วงทดสอบระบบคิว ขออภัยในความไม่สะดวก</p>
</div>
    </div>
</div>
<style>
  .marquee-container {
      width: 100%;
      overflow: hidden;
      white-space: nowrap;
      /* background-color: #ffedb3; Light background color */
      color: #d9534f; /* Text color */
      font-size: 18px;
      font-weight: bold;
      padding-top: 10px;
      
  }
  footer#footer {
    display: none;
  }
  /* .marquee-container p {
      display: inline-block;
      padding-left: 20%;
      animation: marquee 10s linear infinite;
  } */

  @keyframes marquee {
      from {
          transform: translateX(100%);
      }
      to {
          transform: translateX(-100%);
      }
  }
</style>
<div class="row queue-container" style="margin-top: -100px">
  <?php 
  $colorSchemes = [
    1 => ['background-color' => '#603601', 'color' => '#FFF', 'border' => '4px solid #603601;'], 
    2 => ['background-color' => '#BE3144', 'color' => '#FFF', 'border' => '4px solid #BE3144;'], 
    3 => ['background-color' => '#227C70', 'color' => '#FFF', 'border' => '4px solid #227C70;'], 
    4 => ['background-color' => '#7A316F', 'color' => '#FFF', 'border' => '4px solid #7A316F;'], 
    5 => ['background-color' => '#2E236C', 'color' => '#FFF', 'border' => '4px solid #2E236C;'], 
    6 => ['background-color' => '#BC4873', 'color' => '#FFF', 'border' => '4px solid #BC4873;'], 
    7 => ['background-color' => '#346751', 'color' => '#FFF', 'border' => '4px solid #346751;'], 
    8 => ['background-color' => '#F0A500', 'color' => '#FFF', 'border' => '4px solid #F0A500;'], 
    9 => ['background-color' => '#512B81', 'color' => '#FFF', 'border' => '4px solid #512B81;'], 
    10 => ['background-color' => '#CC561E', 'color' => '#FFF', 'border' => '4px solid #CC561E;'], 
  ];
  ?>

  <!-- Queue Section -->
  <div id="queue-section" class="col-6 g-3 mt-3">
    <!-- คิวจะถูกแสดงที่นี่โดย JavaScript -->
  </div>

  <div id="news-section" class="col-6 mt-3 ms-0 px-0">
    <div class="card">
    <div class="card-body p-0" >
        <?php
        function truncateText($text, $limit = 5)
        {
            $words = explode(' ', $text);
            if (count($words) > $limit) {
                return implode(' ', array_slice($words, 0, $limit)) . '...';
            } else {
                return $text;
            }
        }
        ?>

        <div class="">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators mb-0">
                    <?php for ($index = 0; $index < count($news); $index++) : ?>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-label="Slide <?= $index + 1 ?>" <?= $index === 0 ? 'aria-current="true"' : '' ?>></button>
                    <?php endfor; ?>
                </div>

                <div class="carousel-inner">
                    <?php for ($index = 0; $index < count($news); $index++) : ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="p-0">
                        <!-- <h3><?= $news[$index]->news_name ?></h3> -->
                                
                        <div class="mx-auto">
                          <div class="row">
                                <div class="col-12 ">
                                  <button type="button" class="btn" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" style="display:none;">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            </button>
                                            <div class="flex-shrink-1 mx-0" style="height:100vh;">
                                                <img class="border img-thumbnail" style="height: 690px; width:100%;" src="<?= site_url($this->config->item('ums_dir') . 'getIcon?type=' . $this->config->item('ums_news_dir') . 'img&image=' . ($news[$index]->news_img_name != '' ? $news[$index]->news_img_name : 'default.png')) ?>" alt="News Image" class="img-fluid">
                                            </div>
                                  <button type="button" class="btn" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" style="display:none;">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>

<!-- <div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar scroll-left">
    <div style="margin-top: -10px; font-size: 32px; font-weight: 600;">คิวปัจจุบัน <?php //echo $pre_que[0]['apm_ql_code']; ?></div>
  </div>
</div> -->

<script>
  var queue_more = [];
  var queue_announce = [];
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
        show_announce();
        // show_custom_announcement();
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

        // If there are matching priorities, construct the text
        // if (filteredPriorities.length > 0) {
        //   var priorityText = 'หมายเหตุ: ';
        //   filteredPriorities.forEach(function(priority, index) {
        //     priorityText += (index + 1 === filteredPriorities.length) ? '**' : '*';
        //     priorityText += ' คือ ' + priority.pri_name;
        //     if (index + 1 < filteredPriorities.length) {
        //       priorityText += ' และ ';
        //     }
        //   });
        //     // Set the text to the element
        //   $('#priority-text').html(priorityText); // this element from template/footer_frontend
        //   $('#priority-div').removeClass('d-none'); // this element from template/footer_frontend
        // }
    }
  }

  function isMultiline(element) {
    const lineHeight = parseFloat(window.getComputedStyle(element).lineHeight);
    const elementHeight = element.clientHeight;
    // console.log("Element height:", elementHeight, "Line height:", lineHeight);
    return elementHeight > lineHeight;
  }

  function show_queue_more() {
  // Condition for adding the class
  if (queue_more.length > 0) {
    // console.log(queue_more);
    // Select elements
    const copyright = document.querySelector('.copyright');
    const credits = document.querySelector('.credits');
    const footer = document.querySelector('#footer');
    // Add the 'd-none' class to both .copyright and .credits
    copyright.classList.add('d-none');
    credits.classList.add('d-none');
    // Clear the new div if it exists
    const queue_more_div = footer.querySelector('.queue-more');
    // if (queue_more_div != null) {
    //   footer.removeChild(queue_more_div);
    // }

    // Group queue_more by qus_psrm_id
    // Check if the row div already exists in the footer
    let rowDiv = footer.querySelector('.row');
    if (!rowDiv) {
      // If not, create a new div with class 'row'
      rowDiv = document.createElement('div');
      rowDiv.classList.add('row');
      footer.appendChild(rowDiv);
    }

    // Group queue_more by qus_psrm_id
    const groupedByPsrmId = queue_more.reduce((acc, item) => {
      const psrmId = item['index'];
      if (!acc[psrmId]) {
        acc[psrmId] = [];
      }
      acc[psrmId].push(item);
      return acc;
    }, {});

    // Iterate over each group and either create or update div for each qus_psrm_id
    Object.keys(groupedByPsrmId).forEach(psrmId => {
      // Check if the div for this qus_psrm_id already exists
      let newdiv = rowDiv.querySelector(`.queue-more[data-psrm-id='${psrmId}']`);

      // If not, create a new one
      if (!newdiv) {
        newdiv = document.createElement('div');
        newdiv.classList.add('col-md-3', 'queue-more', 'text-white', 'font-30');
        newdiv.setAttribute('data-psrm-id', psrmId); // Add custom attribute to identify the group
        rowDiv.appendChild(newdiv);
      }

      // Create HTML content
      const joinedString = groupedByPsrmId[psrmId].map(item => {
        let prefix = '';

        if (item['apm_sta_id'] === '2') {
          prefix += "<i class='bi-caret-right-fill text-white'></i> ";
        }

        if (item['apm_pri_id'] === '2') {
          prefix += "<span class='text-danger badge-priority-footer'>*</span> ";
        } else if (item['apm_pri_id'] === '1') {
          prefix += "<span class='text-danger badge-priority-footer'>**</span> ";
        }

        return prefix + '' + item['apm_ql_code'];
      }).join(", ");

      // Update innerHTML
      newdiv.innerHTML = `${joinedString}`;

      // Check if the text length exceeds the available space
      if (newdiv.scrollWidth > newdiv.offsetWidth) {
        // If text is too long, add scrolling animation
        let animatedText = document.createElement('div');
        animatedText.classList.add('que-animation');
        animatedText.innerHTML = newdiv.innerHTML;

        newdiv.innerHTML = ''; // Clear the original content
        newdiv.appendChild(animatedText); // Add the animated text inside
      } else {
        newdiv.style.whiteSpace = 'normal'; // No animation if no overflow
      }
    });
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

// Call show_queue_more every 5 seconds
setInterval(show_queue_more, 15000);

  function updateTime() {
    const now = new Date();
    const options = { 
      year: 'numeric', month: 'long', day: 'numeric',
      hour: '2-digit', minute: '2-digit', second: '2-digit', 
      timeZone: 'Asia/Bangkok'
    };
    const formatter = new Intl.DateTimeFormat('th-TH', options);
    document.getElementById('current-time').textContent = ` ${formatter.format(now)} น.`;
  }
  updateTime();
  setInterval(updateTime, 1000);
</script>

<script>
// Define a global variable to store the queue data
let queueItems = [];

function updateQueue() {
  fetch('<?php if($floor == 2 ) {echo site_url('wts/frontend/User_room_que/get_room_queue_by_floor_den/' . $floor); } else { echo site_url('wts/frontend/User_room_que/get_room_queue_lasik');} ?>')
    .then(response => response.json())
    .then(data => {
      console.log("data : ",data)
      // Clear the current queue
      const queueContainer = document.querySelector('#queue-section');
      const newsContainer = document.querySelector('#news-section');
      queueContainer.innerHTML = '';
      // reset queue more, pri_ids
      let pri_ids = [];
      queue_more = [];
      queueItems = []; // Reset queueItems on each update
      queue_announce = [];

      const nonEmptyKeys = Object.keys(data.room_que).filter(key => {
          return data.room_que[key].length > 0; // นับเฉพาะ key ที่มีค่า
      });

      // Check if there are any items in the queue
      if (nonEmptyKeys.length === 0) {
        newsContainer.classList.remove('col-6');
        newsContainer.classList.add('col-12');
        // let emptyCard = document.createElement('div');
        // emptyCard.className = 'col-md-12';
        // emptyCard.innerHTML = `
        //   <div class="card mb-0">
        //     <div class="card-header text-center fw-bold" style="font-size: 40px; background-color: #006897;">
        //     </div>
        //     <div class="card-body text-center">
        //         <h3>ไม่มีรายการคิว</h3>
        //     </div>
        //   </div>
        // `;
        // queueContainer.appendChild(emptyCard);
      } else {
          if(nonEmptyKeys.length > 1){
            queueContainer.classList.add('col-12');
          }else{
            queueContainer.classList.remove('col-12');
            queueContainer.classList.add('col-6');  
          }
        newsContainer.classList.remove('col-12');
        newsContainer.classList.add('col-6');
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
        // console.log("data:", data.announce);
          data.announce.forEach(item => {
            // console.log("item : ", item);
              if (item.qus_announce) {
                  queue_announce.push({
                      rm_name: item.rm_name,
                      pf_name_abbr: item.pf_name_abbr,
                      ps_fname: item.ps_fname,
                      qus_announce: item.qus_announce ,
                      qus_time_end: item.qus_time_end,
                      qus_time_start: item.qus_time_start
                  });
              }
          });

        // Render sorted queue data
        sortedEntries.reverse().forEach(([room_id, room], index) => {
          let colors = <?php echo json_encode($colorSchemes); ?>[index + 1] || <?php echo json_encode($colorSchemes); ?>[index + 1];
          let rightBorderStyle = `border-right: 2px solid ${colors['background-color']};`;
          let leftBorderStyle = `border-left: 2px solid ${colors['background-color']};`;
          let card = document.createElement('div');
          card.className = 'col card mb-0';
          // Loop through the array using jQuery
          var firstMatch = null;
          if (room.length === 0) {
              return; // ใช้ return เพื่อข้าม iteration นี้
          }
          $.each(room, function(index, entry) {
              if (entry.ps_id === room[0].ps_id && entry.rm_name) {
                  firstMatch = entry;
                  return false; // Exit loop after first match
              }
          });
          let count_walkin = 0;
          let count_appointment = 0;

          queueItems.push(...room);
          // Store room data in queueItems for access in changeText function
          // console.log("room : ",room)
          card.innerHTML = `
            
              <div class="card-header text-center fw-bold d-flex align-items-center justify-content-center" style="font-size: 44px; <?php echo 'min-height: 150px;' ?> background-color: ${colors['background-color']}; color: ${colors['color']};">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9b2500; background: #fbd4c7;">
                  <img id="profile_picture" class="rounded-circle" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon_que?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image="); ?>${room[0].psd_picture ?? "default.png"}">
                </div>
                <div class="ps-4 text-center">
               
                  <span style="font-size: 40px;">${firstMatch != null ? firstMatch.rm_name ?? "-" : "-"}</span><br>
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
                      ${room.filter(item => {
                        
                        let isShow = false;
                        // Check if 'qus_app_walk' is not null and equals 'W'
                        if (item.qus_app_walk !== null) {
                            if (item.qus_app_walk === 'W') {
                                isShow = true;
                                // console.log("if : ",item.apm_ql_code);
                            }
                        } 
                        // // Else, check conditions on 'apm_app_walk' and 'apm_pri_id'
                        else {
                            // console.log("else : ",item.apm_ql_code);
                            if (item.apm_app_walk === 'W' && (item.apm_pri_id === '2' || item.apm_pri_id === '5')) {
                              // console.log("else if : ",item.apm_ql_code);
                              isShow = true;
                            }
                        }
                        if (isShow) {
                          if (count_walkin >= 6) {
                            queue_more.push({ apm_ql_code: item.apm_ql_code, apm_pri_id: item.apm_pri_id, apm_sta_id:item.apm_sta_id, index: index })
                            isShow = false;
                          } else 
                            count_walkin++;

                          if (!pri_ids.includes(item.apm_pri_id)) pri_ids.push(item.apm_pri_id);
                        }

                        return isShow;
                      }).map(item => `
                        <tr class="text-center" style="width: 50%;">
                          <td class="p-0">
                            <div ${item.apm_pri_id == 1 || item.apm_pri_id == 2 || item.apm_pri_id == 6 || item.apm_sta_id == 11 || item.apm_sta_id == 12 ? 'class="que-type"' : ''} 
                              data-content="${item.apm_ql_code}" 
                              style="width: 100%; height: 100%;">
                              ${(item.apm_sta_id == 2)
                                ? `<i class='bi-caret-right-fill icon-see-doctor'></i>` 
                                : ""}
                              <span class="que-text" style="color: ${item.apm_sta_id == 11 || item.apm_sta_id == 12 ? '#603601' : ''}; ${item.apm_ql_code.startsWith('I-') ? 'font-size: 40px;' : ''}">
                                ${item.apm_ql_code}
                              </span>
                            </div>
                          </td>
                        </tr>
                      `).join('')}
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6" style="${leftBorderStyle}">
                  <table class="table table-borderless mb-0" style="font-size: 45px; width: 100%; table-layout: fixed;">
                    <thead>
                      <tr>
                        <th class="text-center" style="font-size: 30px;">นัดหมาย</th>
                      </tr>
                    </thead>
                    <tbody>
                      ${room.filter(item => {
                        
                        let isShow = false;
                        if (item.qus_app_walk != null) {
                          if (item.qus_app_walk && item.qus_app_walk === 'A') {
                            isShow = true;
                          } 
                        } else {
                          if (item.apm_app_walk === 'A' || [1, 4,5].includes(item.apm_pri_id)) {
                            isShow = true;
                          }
                        }

                        if (isShow) {
                          if (count_appointment > 6) {
                            queue_more.push({ apm_ql_code: item.apm_ql_code, apm_pri_id: item.apm_pri_id, apm_sta_id:item.apm_sta_id, qus_psrm_id: item.qus_psrm_id })
                            isShow = false;
                          } else 
                            count_appointment++;

                          if (!pri_ids.includes(item.apm_pri_id)) pri_ids.push(item.apm_pri_id);
                        }
                        

                        return isShow;
                      }).map(item => `
                        <tr class="text-center" style="width: 50%;">
                          <td class="p-0">
                            <div ${item.apm_pri_id == 1 || item.apm_pri_id == 2 || item.apm_pri_id == 6 || item.apm_sta_id == 11 || item.apm_sta_id == 12 ? 'class="que-type text-primary-emphasis"' : ''} 
                              data-content="${item.apm_ql_code}" 
                              style="width: 100%; height: 100%;">
                              ${(item.apm_sta_id == 2)
                                ? `<i class='bi-caret-right-fill icon-see-doctor'></i>` 
                                : ""}
                              <span class="que-text" style="color: ${item.apm_sta_id == 11 || item.apm_sta_id == 12 ? '#603601' : '#052C65'}; ${item.apm_ql_code.startsWith('I-') ? 'font-size: 40px;' : ''}">
                                ${item.apm_ql_code}
                              </span>
                            </div>
                          </td>
                        </tr>
                      `).join('')}
                    </tbody> 
                  </table>
                </div>
              </div>
            
          `;

          queueContainer.appendChild(card);
        });
      }
      show_priority(pri_ids);
    })
    .catch(error => console.error('Error updating queue:', error));

    // console.log('queue :'+queue_announce);
}

// Update the queue every 5 seconds
setInterval(updateQueue, 5000);
function show_announce() {
  // Check if there are any announcements in the queue_announce array
  if (queue_announce.length > 0) {
    // Select the footer
    const footer = document.querySelector('#footer');

    // Check if the announce section already exists
    let announceDiv = document.querySelector('.announce-section');
    if (!announceDiv) {
      // Create a new div for announcements if it doesn't exist
      announceDiv = document.createElement('div');
      announceDiv.classList.add('row', 'announce-section');
      
      // Insert the announce section right before the footer, outside of it
      footer.parentNode.insertBefore(announceDiv, footer);
    }

    // Clear previous content
    announceDiv.innerHTML = '';

    // Create the formatted string for the announcement
    const formattedAnnouncements = queue_announce.map(announcement => {
      const timeStart = announcement.qus_time_start.substring(0, 5); // Get only HH:mm
      const timeEnd = announcement.qus_time_end.substring(0, 5); // Get only HH:mm

      // Format announcement text
      return `${announcement.rm_name} ${announcement.pf_name_abbr} ${announcement.ps_fname} ${announcement.qus_announce} ณ เวลา ${timeStart}-${timeEnd} น.`;
    }).join(' | | ');

    // Create a new div for the announcement content
    let announceItem = document.createElement('div');
    announceItem.classList.add('col-md-12', 'announce-item', 'text-white', 'font-30');

    // Create animated div for sliding effect
    let animatedText = document.createElement('div');
    animatedText.classList.add('announce-slide-left');
    animatedText.innerHTML = formattedAnnouncements;

    // Add the animated text inside the announcement item
    announceItem.appendChild(animatedText);

    // Append the announcement item to the announcement section
    announceDiv.appendChild(announceItem);

  } else {
    // If no announcements, remove the announcement section
    const announceDiv = document.querySelector('.announce-section');
    if (announceDiv) {
      announceDiv.remove();
    }
  }
}

  function changeText() {
    // Access elements with 'que-type' class
    var elements = document.getElementsByClassName('que-type');
    // console.log("elements : ",elements)

    if (elements.length > 0) {
      for (var i = 0; i < elements.length; i++) {
        (function(i) {  // Create a closure to capture the current index
          var element = elements[i];
          var textElement = element.querySelector('.que-text');  // Select the text span

          // Find the corresponding queue item from queueItems based on apm_ql_code
          var item = queueItems.find(q => q.apm_ql_code === element.getAttribute('data-content'));
          // console.log('Queue Item:', item);

          if (item) {  // Only apply to items with apm_pri_id == 1
            // Add the fade-out class
            textElement.classList.add('fade-out');

            // Wait for fade-out to complete (0.5s = 500ms)
            setTimeout(function() {
              // Toggle between apm_ql_code and "ฉุกเฉิน"
              var currentContent = textElement.textContent.trim();

              if ((item.apm_pri_id == 1 || item.apm_pri_id == 2 || item.apm_pri_id == 6) && (item.apm_sta_id == 11 || item.apm_sta_id == 12)) {  
                // Combined condition for Priority 1, 2, or 6 + Status 11 or 12
                if (currentContent === item.apm_ql_code) {
                  if (item.apm_pri_id == 1) {
                    textElement.textContent = 'ฉุกเฉิน';
                    textElement.style.color = "red"; // Custom color for emergency
                  } else if (item.apm_pri_id == 2) {
                    textElement.textContent = 'เฝ้าระวัง';
                    textElement.style.color = "#ff9800"; // Custom color for surveillance
                  } else if (item.apm_pri_id == 6) {
                    textElement.textContent = 'ผ่าตัด';
                    textElement.style.color = "#872400"; // Custom color for surgery
                  }
                } else if (currentContent === 'ฉุกเฉิน' || currentContent === 'เฝ้าระวัง' || currentContent === 'ผ่าตัด') {
                  textElement.textContent = item.sta_show;
                  textElement.style.color = "#603601"; // Custom color for sta_show
                } else if (currentContent === item.sta_show) {
                  textElement.textContent = item.sta_show_en;
                  textElement.style.color = "#603601"; // Custom color for sta_show_en
                } else {
                  textElement.textContent = item.apm_ql_code;
                  textElement.style.color = "black"; // Reset to default color
                }
              } else if (item.apm_pri_id == 1) {  // Emergency case
                if (currentContent === item.apm_ql_code) {
                  textElement.textContent = 'ฉุกเฉิน';
                  textElement.style.color = "red"; // Change text color to red for emergency
                } else {
                  textElement.textContent = item.apm_ql_code;
                  textElement.style.color = "black"; // Reset to default color
                }
              } else if (item.apm_pri_id == 2) {  // Surveillance case
                if (currentContent === item.apm_ql_code) {
                  textElement.textContent = 'เฝ้าระวัง';
                  textElement.style.color = "#ff9800"; // Change text color to orange for surveillance
                } else {
                  textElement.textContent = item.apm_ql_code;
                  textElement.style.color = "black"; // Reset to default color
                }
              } else if (item.apm_pri_id == 6) {  // Surgery case
                if (currentContent === item.apm_ql_code) {
                  textElement.textContent = 'ผ่าตัด';
                  textElement.style.color = "#872400"; // Custom color for surgery
                } else {
                  textElement.textContent = item.apm_ql_code;
                  textElement.style.color = "black"; // Reset to default color
                }
              } else if (item.apm_sta_id == 11 || item.apm_sta_id == 12) {  // Specific status 11 or 12 without Priority
                if (currentContent === item.apm_ql_code) {
                  textElement.textContent = item.sta_show;
                  textElement.style.color = "#603601"; // Custom color for sta_show
                } else if (currentContent === item.sta_show) {
                  textElement.textContent = item.sta_show_en;
                  textElement.style.color = "#603601"; // Custom color for sta_show_en
                } else {
                  textElement.textContent = item.apm_ql_code;
                  textElement.style.color = "black"; // Reset to default color
                }
              }

              // Remove the fade-out class
              textElement.classList.remove('fade-out');

              // Add the fade-in class
              textElement.classList.add('fade-in');

              // Remove the fade-in class after the animation completes (0.5s = 500ms)
              setTimeout(function() {
                textElement.classList.remove('fade-in');
              }, 200);  // Duration of the fade-in animation
            }, 200);  // Duration of the fade-out effect
          }
        })(i);  // Immediately invoke the function to capture the current index
      }
    }
  }

  // Change text every 3 seconds
  setInterval(changeText, 2000);

  // function show_custom_announcement() {
  //   // Select the footer
  //   const footer = document.querySelector('#footer');

  //   // Check if the custom announce section already exists
  //   let customAnnounceDiv = document.querySelector('.custom-announce-section');
  //   if (!customAnnounceDiv) {
  //     // Create a new div for the custom announcement if it doesn't exist
  //     customAnnounceDiv = document.createElement('div');
  //     customAnnounceDiv.classList.add('row', 'custom-announce-section');

  //     // Insert the custom announce section right before the footer
  //     footer.parentNode.insertBefore(customAnnounceDiv, footer);
  //   }

  //   // Clear previous content
  //   customAnnounceDiv.innerHTML = '';

  //   // Create a new div for the custom announcement content
  //   let customAnnounceItem = document.createElement('div');
  //   customAnnounceItem.classList.add('col-md-12', 'custom-announce-item');
    
  //   // Inline CSS for custom styling
  //   customAnnounceItem.style.color = '#ffffff'; // สีข้อความ
  //   customAnnounceItem.style.fontSize = '30px'; // ขนาดฟอนต์
  //   customAnnounceItem.style.textShadow = '2px 2px 4px #000000'; // เงาของข้อความ
  //   customAnnounceItem.style.padding = '10px'; // ระยะห่างภายใน
  //   customAnnounceItem.style.backgroundColor = '#795548'; // พื้นหลังโปร่งแสง
  //   customAnnounceItem.style.textAlign = 'center'; // จัดข้อความให้อยู่กลาง
  //   customAnnounceItem.style.marginTop = '10px'; // ระยะห่างจากด้านบน
  //   customAnnounceItem.style.position = 'absolute'; // ระยะห่างจากด้านบน
  //   customAnnounceItem.style.height = '55px'; // ระยะห่างจากด้านบน
  //   customAnnounceItem.style.bottom = '-3%'; // ระยะห่างจากด้านบน

  //   // Create animated div for sliding effect
  //   let animatedText = document.createElement('div');
  //   animatedText.classList.add('announce-slide-left');
  //   animatedText.innerHTML = 'ขณะนี้อยู่ในช่วงทดสอบระบบคิว ขออภัยในความไม่สะดวก';

  //   // Add the animated text inside the custom announcement item
  //   customAnnounceItem.appendChild(animatedText);

  //   // Append the custom announcement item to the custom announcement section
  //   customAnnounceDiv.appendChild(customAnnounceItem);
  // }

  // Call show_custom_announcement once to display the message
  // setInterval(show_custom_announcement, 20000);
</script>
<script>
  // // รีโหลดหน้าเว็บทุก ๆ 5 วินาที
  setInterval(function() {
    location.reload();
  }, 300000);
</script>