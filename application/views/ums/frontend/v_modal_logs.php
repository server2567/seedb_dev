<div class="modal-header">
  <h5 class="modal-title" id="detailModalLabel">ประวัติการเข้าสู่ระบบ</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12 col-sm-11 col-md-11 mx-auto">
      <div class="card-body pb-2">
        <div class="table-responsive">
          <table class="table dataTablelogs" id="dataTable" width="100%">
            <thead>
              <tr>
                <th class="w-5">ลำดับ</th>
                <th class="w-40">เครื่องที่เข้า</th>
                <th class="w-20">สถานที่</th>
                <th class="w-35">วันที่เข้าสู่ระบบ</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($get_logs_login as $key_logs => $logs) { ?>
              <?php
                $logs2 = $logs['pl_ip']; // ตัวอย่างข้อมูล
                $parts = explode(' ', $logs2); // แยกข้อความด้วยช่องว่าง
              ?>
              <tr>
                <td><?php echo $key_logs+1; ?></td>
                <td><?php if($logs['pl_agent'] == 'mobile') { ?><i class="bi bi-phone fa-fw"></i><?php } else { ?><i class="bi bi-laptop fa-fw"></i><?php } ?>
                <?php echo $logs['pl_agent'].'&emsp;'; ?><?php if($key_logs == 0){ ?><span class="badge small text-bg-primary">กำลังใช้งาน</span><?php } ?></td>
                <td><?php 
                if (is_array($parts) && count($parts) > 1) {
                    $location = implode(' ', array_slice($parts, 1)); 
                    echo $location;
                } else {
                    echo 'ข้อมูลไม่ถูกต้อง'; // กรณีข้อมูลไม่ถูกต้อง
                }?></td>
                <td><?php echo formatThaiDatelogs($logs['pl_date']); ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('.dataTablelogs').DataTable({
      language: {
        "decimal": "",
        "emptyTable": "ไม่มีข้อมูลในตาราง",
        "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
        "infoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
        "infoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
        "loadingRecords": "กำลังโหลด...",
        "processing": "กำลังประมวลผล...",
        "search": "ค้นหา:",
        "zeroRecords": "ไม่พบข้อมูลที่ตรงกัน",
        "paginate": {
          "first": "หน้าแรก",
          "last": "หน้าสุดท้าย",
          "next": "ถัดไป",
          "previous": "ก่อนหน้า"
        },
        "aria": {
          "sortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
          "sortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
        }
      }
    });
  });
</script>