<?php
                                $data = array(
                                    array(
                                        'pat_name' => 'ณัฐกิตติ์ เหล่าสุวรรณณา',
                                        'pat_type' => 'จักษุ',
                                        'pat_status' => 'ตรวจม่านตา',
                                        'pat_room' => 'ห้องตรวจม่านตา 1',
                                        'pat_time' => '6 นาที',
                                        'id' => 1
                                    ),
                                    array(
                                        'pat_name' => 'ธิติฌา ยุทธนาวิวัฒน์',
                                        'pat_type' => 'จักษุ', 
                                        'pat_status' => 'พบจักษุแพทย์',
                                        'pat_room' => 'ห้องตรวจโรคทั่วไป 2',
                                        'pat_time' => '5 นาที',
                                        'id' => 2
                                    ),
                                    array(
                                        'pat_name' => 'ณัฐวรา พินิจนันท์',
                                        'pat_type' => 'โสต ศอ นาสิก',
                                        'pat_status' => 'ตรวจภายในหู',
                                        'pat_room' => 'ห้องตรวจหู 2',
                                        'pat_time' => '10 นาที',
                                        'id' => 3
                                    ),
                                    array(
                                        'pat_name' => 'ตรีษา ธนาศุบินเจริญ',
                                        'pat_type' => 'จักษุ',
                                        'pat_status' => 'ตรวจม่านตา',
                                        'pat_room' => 'ห้องตรวจโรคทั่วไป 3',
                                        'pat_time' => '15 นาที',
                                        'id' => 4
                                    ),
                                    array(
                                        'pat_name' => 'ปัณยตา วิชิตรัตนาพร',
                                        'pat_type' => 'จักษุ',
                                        'pat_status' => 'จ่ายค่ารักษา',
                                        'pat_room' => 'ห้องการเงิน 2',
                                        'pat_time' => '15 นาที',
                                        'id' => 5
                                    ),
                                    array(
                                        'pat_name' => 'ธนินทร์ ก้องวัฒนะกุล',
                                        'pat_type' => 'จักษุ',
                                        'pat_status' => 'ตรวจม่านตา',
                                        'pat_room' => 'ห้องตรวจโรคทั่วไป 1',
                                        'pat_time' => '10 นาที',
                                        'id' => 6
                                    ),
                                    array(
                                        'pat_name' => 'พรพรรณ วงศ์พัฒนา',
                                        'pat_type' => 'รังสี',
                                        'pat_status' => 'พบรังสีแพทย์',
                                        'pat_room' => 'ห้องอัลตราซาวน์',
                                        'pat_time' => '15 นาที',
                                        'id' => 7
                                    ),
                                    array(
                                        'pat_name' => 'กานต์ สว่างเสนา',
                                        'pat_type' => 'โสต ศอ นาสิก',
                                        'pat_status' => 'ตรวจภายในหู',
                                        'pat_room' => 'ห้องตรวจหู 1',
                                        'pat_time' => '20 นาที',
                                        'id' => 8
                                    ),
                                    array(
                                        'pat_name' => 'ชัชชน ปิติโอภาสพงศ์',
                                        'pat_type' => 'จักษุ',
                                        'pat_status' => 'ตรวจม่านตา',
                                        'pat_room' => 'ห้องตรวจม่านตา 2',
                                        'pat_time' => '15 นาที',
                                        'id' => 9
                                    ),
                                    array(
                                        'pat_name' => 'ปัณฑา ตรีวุฒิ',
                                        'pat_type' => 'ทันตกรรม',
                                        'pat_status' => 'ทำทันตกรรม',
                                        'pat_room' => 'ห้องทันตกรรมจัดฟัน',
                                        'pat_time' => '20 นาที',
                                        'id' => 10
                                    )
                                );
                            ?>


<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลผู้ป่วยที่กำลังรอคอย</span><span class="badge bg-success">10</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ชื่อ - นามสกุลผู้ป่วย</th>
                                <th>แผนก</th>
                                <th>สถานะ</th>
                                <th class="text-center">ระยะเวลาที่เหลือ</th>
                                <th>ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['pat_name'] ?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['pat_type']?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['pat_status']?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item['pat_time']?></div>
                                    </td>
                                    <td>
                                    <div class="text-center option">
                                            <button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href='<?php echo base_url()?>index.php/wts/System_user_timeline'"><i class="bi-search"></i></button>
                                            <button class="btn btn-warning toastButton" title="แจ้งเตือน"><i class="bi-bell"></i></button>
                                        </div>
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

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="myToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">แจ้งเตือนใกล้สิ้นสุดเวลา</strong>
      <small><?php echo  date("h:i") . " น." ?></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      อีก 2 นาทีจะหมดเวลาการรักษาที่กำหนดไว้
    </div>
  </div>
</div>


<script>
document.querySelectorAll('.toastButton').forEach(button => {
  button.addEventListener('click', function () {
    var toastEl = document.getElementById('myToast');
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
  });
});
</script>
