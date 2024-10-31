<div class="col-12 d-flex border-bottom pt-3 mt-3 pb-2 mb-2 log-item" id="log-item-<?php echo $log->pl_id; ?>">
    <!-- Icon -->
    <span class="fs-3 heading-color"><?php echo $log->pl_agent == 'mobile' ? '<i class="bi bi-phone fa-fw"></i>' : '<i class="bi bi-laptop fa-fw"></i>'; ?></span>
    <!-- Info -->
    <div class="ms-2">
        <p class="heading-color fw-bold mb-0"><?php echo $log->pl_agent; ?> </p>
        <ul class="nav nav-divider small">
            <li class="nav-item w-100">
            <?php
              $logs2 = $log->pl_ip; // ตัวอย่างข้อมูล
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
            <li class="nav-item w-100"><?php echo formatThaiDatelogs($log->pl_date); ?></li>
        </ul>
    </div>
    <!-- Dropdown button -->
    <div class="dropdown ms-auto">
        <a href="#" class="text-primary-hover fs-6" role="button" id="dropdownAction1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-three-dots-vertical"></i>
        </a>
        <!-- dropdown button -->
        <ul class="dropdown-menu dropdown-menu-end min-w-auto shadow" aria-labelledby="dropdownAction1">
            <li>
                <a class="dropdown-item text-danger d-flex align-items-center delete-log-btn" href="#" data-log-id="<?php echo $log->pl_id; ?>">
                    <i class="bi bi-slash-circle me-2"></i>ลบ
                </a>
            </li>
        </ul>
    </div>
</div>

<?php 
function formatThaiDatelogs($dateTime) {
  // Convert datetime string to a DateTime object
  $date = new DateTime($dateTime);
  
  // Month names in Thai
  $months = [
      1 => 'ม.ค.',
      2 => 'ก.พ.',
      3 => 'มี.ค.',
      4 => 'เม.ย.',
      5 => 'พ.ค.',
      6 => 'มิ.ย.',
      7 => 'ก.ค.',
      8 => 'ส.ค.',
      9 => 'ก.ย.',
      10 => 'ต.ค.',
      11 => 'พ.ย.',
      12 => 'ธ.ค.'
  ];
  
  // Format the date
  $day = $date->format('j');
  $month = $months[(int)$date->format('n')];
  $year = (int)$date->format('Y') + 543;
  $time = $date->format('H:i น.');

  return "$day $month $year เวลา $time";
}
?>