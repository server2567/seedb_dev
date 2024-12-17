<style>
  #priority-text {
    font-size: 25px;
  }

  #main {
    padding: 0px;
  }

  @media (min-width: 1400px) {

    .container-xxl,
    .container-xl,
    .container-lg,
    .container-md,
    .container-sm,
    .container {
      max-width: 100% !important;
    }
  }

  .logo {
    margin-left: 0px !important;
  }

  #profile_picture {
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
    background-color: #333;
    /* Background color for the announce section */
    color: white;
    text-align: center;
    margin-bottom: -1px;
    /* Space between the announcement section and the footer */
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
  }

  .announce-animation {
    display: inline-block;
    animation: scroll-left 20s linear infinite;
    white-space: nowrap;
    position: absolute;

  }

  .announce-item {
    overflow: hidden;
    /* To hide the text that moves outside the container */
    white-space: nowrap;
    /* Keep the text in a single line */
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
      transform: translateX(100%);
      /* Start from the right */
    }

    100% {
      transform: translateX(-100%);
      /* Exit from the left */
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
    animation: fadeOut 0.2s ease-in-out forwards;
    /* forwards ensures the element stays hidden */
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
    padding-bottom: 10px;
    /* Add padding to separate it from the rest of the footer */
  }

  #footer {
    position: relative;
    /* Ensure footer's position context is defined */
  }

  .btn-login {
    display: none;
  }

  .bg-warning-que {
    background-color: #005d87 !important;
    color: #FFF;
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
  footer#footer {
    position: absolute;
    bottom: 0px;
  }
  td {
  position: relative;
  vertical-align: middle;
  height: 50px; /* ปรับความสูงตามที่ต้องการ */
}

.blink-switch, .blink-switch-alt {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: inline-block;
  width:100%;
}

.blink-switch {
  animation: fade-in-out 10s steps(10, end) infinite;
}

.blink-switch-alt {
  animation: fade-in-out-alt 10s steps(10, end) infinite;
}

@keyframes fade-in-out {
  0%, 40% {
    opacity: 1;
  }
  50%, 100% {
    opacity: 0;
  }
}

@keyframes fade-in-out-alt {
  0%, 40% {
    opacity: 0;
  }
  50%, 100% {
    opacity: 1;
  }
}


@media (min-width: 1200px) {
    .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 100%;
    }
}
@media (min-width: 992px) {
    .container-lg, .container-md, .container-sm, .container {
        max-width: 100%;
    }
}
footer#footer {
    display: none;
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
    <h5 style="position: absolute; bottom: 0; right: 0; top:-10px; font-size:30px;">
      <?php echo $stde_name . ' วันที่ '; ?>
      <span id="current-time"></span>
    </h5>
  </div>
</div>
<!-- Marquee message -->
<div class="row" style="margin-top: -65px;">
    <div class="col-12">
        <div class="marquee-container" style="width: 102%; margin-left: -11px;">
            <p style="padding-bottom: 0px; padding-left:12%;">ขณะนี้อยู่ในช่วงทดสอบระบบคิว ขออภัยในความไม่สะดวก</p>
        </div>
    </div>
</div>
<style>
  .marquee-container {
      width: 100%;
      overflow: hidden;
      white-space: nowrap;
      background-color: #ffedb3; /* Light background color */
      color: #d9534f; /* Text color */
      font-size: 40px;
      font-weight: bold;
      padding-top: 10px;
      
  }

  .marquee-container p {
      display: inline-block;
      padding-left: 20%;
      animation: marquee 10s linear infinite;
  }

</style>
<div class="row" style="margin-top: 0px;">
  <div class="card mb-0">
    <div class="card-body p-0 row">
      <div class="col-md-12" style="padding-right: 0px; padding-left: 0px;">
        <table class="table table-bordered mb-0" style="width: 100%; ">
          <thead>
            <tr>
              <th class="text-center" style="width:25%; font-size: 30px; border-right: 2px solid #936a00;  color:#FFF;   background: #936a00;">คิวรับยา</th>
              <th class="text-center" style="width:35%; font-size: 30px; border-right: 2px solid #936a00;  color:#FFF;   background: #936a00;">สถานะ</th>
              <th class="text-center" style="font-size: 30px;  color:#FFF;  background: #936a00;">ช่องทำการ</th>
            </tr>
          </thead>
          <tbody id="roomQueueBody">
            <?php
            if (empty($room_que)) {
              // ถ้าไม่มีข้อมูล แสดงข้อความ
              echo "<tr><td colspan='3' class='font-30 text-center p-5'><b>ไม่มีข้อมูลคิว</b></td></tr>";
            } else {
              // ถ้ามีข้อมูล แสดงรายการคิว
              $counter = 0;
              foreach ($room_que as $rm) {
                if ($counter < 4) {
            ?>
                  <tr style="line-height: 1.7;">
                    <td class="text-center" style="border-right: 2px solid #936a00; font-size:50px;">
                      <?php if ($rm['apm_sta_id'] == 18 || $rm['apm_sta_id'] == 19) { ?>
                        <i class="bi-caret-right-fill icon-see-doctor" 
                        <?php if ($rm['apm_pri_id'] == 1 || $rm['apm_pri_id'] == 6) { ?>
                        style="margin-top: -35px; margin-left: -110px;"
                        <?php } ?>
                        ></i>
                      <?php } ?>
                      <?php if ($rm['apm_pri_id'] == 1 || $rm['apm_pri_id'] == 6) { ?>
                        <span class="blink-switch"><b><?php echo $rm['apm_ql_code']; ?></b></span>
                        <span class="blink-switch-alt" style="color:<?php echo $rm['pri_color']; ?>"><b><?php echo $rm['pri_name']; ?></b></span>
                      <?php } else { ?>
                        <b><?php echo $rm['apm_ql_code']; ?></b>
                      <?php } ?>
                    </td>
                    <!-- Blink-switch for status_name and status_name_en -->
                    <td style="color:<?php echo $rm['status_color']; ?>; border-right: 2px solid #936a00; font-size:50px;">
                      <span class="blink-switch"><b><?php echo $rm['status_name']; ?></b></span>
                      <span class="blink-switch-alt font-40" style="line-height: 1.4;"><b><?php echo $rm['status_name_en']; ?></b></span>
                    </td>
                    <!-- Blink-switch for channel_names and channel_names_en -->
                    <td style="color:<?php echo $rm['status_color']; ?>; font-size:50px;">
                      <span class="blink-switch"><b><?php echo $rm['channel_names']; ?></b></span>
                      <span class="blink-switch-alt font-40" style="line-height: 1.4;"><b><?php echo $rm['channel_names_en']; ?></b></span>
                    </td>
                  </tr>
            <?php }
                $counter++;
              }
            }
            ?>
          </tbody>
          <tfoot id="roomQueueFooter">
            <?php 
            if (!empty($room_que) && count($room_que) > 4): 
            ?>
              <tr>
                <td colspan='3' class="font-40" style="background: #1b4f69; color: #FFF; text-align:left;">
                  <?php 
                  $codes = [];
                  foreach($room_que as $index => $rm) {
                    if ($index >= 4) {
                      $codes[] = $rm['apm_ql_code'];
                    }
                  }
                  echo implode(', ', $codes);
                  ?>
                </td>
              </tr>
            <?php endif; ?>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Select all elements with the class 'col-md-3 mt-2 d-none d-lg-block'
    const elements = document.querySelectorAll('.col-md-3.mt-2.d-none.d-lg-block');

    // Loop through each element and apply 'display: none !important'
    elements.forEach(element => {
      element.style.setProperty('display', 'none', 'important');
    });



    setTimeout(function() {}, 500); // Adjust the time as needed to wait for the operations to complete
  });

  function updateTime() {
    const now = new Date();
    const options = {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      timeZone: 'Asia/Bangkok'
    };
    const formatter = new Intl.DateTimeFormat('th-TH', options);
    document.getElementById('current-time').textContent = ` ${formatter.format(now)} น.`;
  }
  updateTime();
  setInterval(updateTime, 1000);
</script>
<script>
  // // รีโหลดหน้าเว็บทุก ๆ 5 วินาที
  setInterval(function() {
    location.reload();
  }, 180000);
</script>
<script>
function refreshTableData() {
  $.ajax({
    url: '<?php echo site_url("wts/frontend/User_room_que/get_finance_medicine_data"); ?>', // ใส่ URL ของ endpoint ที่จะใช้
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      let bodyHtml = '';
      let footerHtml = '';
      const roomQue = response.room_que; // สมมติว่าคุณส่ง 'room_que' กลับมาใน JSON

      if (roomQue.length === 0) {
        bodyHtml += "<tr><td colspan='3' class='font-30 text-center p-5'><b>ไม่มีข้อมูลคิว</b></td></tr>";
      } else {
        roomQue.forEach((rm, index) => {
          if (index < 4) {
            bodyHtml += `
              <tr style="line-height: 1.7;">
                <td class="text-center" style="border-right: 2px solid #936a00; font-size:50px;">
                  ${rm.apm_sta_id === 18 || rm.apm_sta_id === 19 ? `
                    <i class="bi-caret-right-fill icon-see-doctor" 
                    ${rm.apm_pri_id === 1 || rm.apm_pri_id === 6 ? 'style="margin-top: -35px; margin-left: -110px;"' : ''}
                    ></i>` : ''}
                  ${rm.apm_pri_id === 1 || rm.apm_pri_id === 6 ? `
                    <span class="blink-switch"><b>${rm.apm_ql_code}</b></span>
                    <span class="blink-switch-alt" style="color:${rm.pri_color}; "><b>${rm.pri_name}</b></span>
                  ` : `
                    <b>${rm.apm_ql_code}</b>
                  `}
                </td>
                <td style="color:${rm.status_color}; border-right: 2px solid #936a00; font-size:50px;">
                  <span class="blink-switch"><b>${rm.status_name}</b></span>
                  <span class="blink-switch-alt font-36" style="line-height: 1.4;"><b>${rm.status_name_en}</b></span>
                </td>
                <td style="color:${rm.status_color}; font-size:50px;">
                  <span class="blink-switch"><b>${rm.channel_names}</b></span>
                  <span class="blink-switch-alt font-36" style="line-height: 1.4;"><b>${rm.channel_names_en}</b></span>
                </td>
              </tr>
            `;
          } else {
            footerHtml += rm.apm_ql_code + ', ';
          }
        });

        if (footerHtml !== '') {
          footerHtml = `
            <tr>
              <td colspan='3' style="background: #1b4f69; color: #FFF; text-align:left; padding-left:90px; font-size:50px;">
                ${footerHtml.slice(0, -2)} <!-- ตัด ', ' ที่ท้ายสุด -->
              </td>
            </tr>
          `;
        }
      }

      $('#roomQueueBody').html(bodyHtml);
      $('#roomQueueFooter').html(footerHtml);
    },
    error: function() {
      console.error('เกิดข้อผิดพลาดในการโหลดข้อมูล');
    }
  });
}

// เรียกฟังก์ชัน refreshTableData ทุก ๆ 5 วินาที
setInterval(refreshTableData, 7000);

// โหลดข้อมูลเมื่อหน้าเว็บเปิดครั้งแรก
$(document).ready(function() {
  refreshTableData();
});

</script>