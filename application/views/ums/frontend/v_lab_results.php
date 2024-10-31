<h1 class="h3 mb-0">ผลตรวจจากห้องปฏิบัติการ</h1>
<div class="card-body pt-0 px-0">
  <div class="row g-3">
    <!-- Card header -->
    <div class="col-12">
      <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center p-0 pt-3">
        <h6 class="card-title mb-0">ตารางแสดงรายการผลตรวจจากห้องปฏิบัติการ</h6>
      </div>
      <div class="card-body p-0">
        <div class="row align-items-md-center">
          <div class="table-responsive">
            <table class="table dataTablents" id="dataTable" width="100%">
              <thead>
                <tr>
                  <th class="w-5" >ลำดับ</th>
                  <th class="w-10">เลขนัดหมาย</th>
                  <th class="w-45">วันที่รักษา</th>
                  <th class="w-30">แพทย์ที่นัดหมาย</th>
                  <th class="w-10">ดูรายละเอียด</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_ntrt as $key_ntrt => $ntrt) { ?>
                  <tr>
                    <td><?php echo $key_ntrt + 1; ?></td>
                    <td><?php echo $ntrt['apm_cl_code']; ?></td>
                    <td><?php echo formatThaiDateNts($ntrt['ntr_create_date']); ?></td>
                    <td><?php echo $ntrt['pf_name'] . '' . $ntrt['ps_fname'] . ' ' . $ntrt['ps_lname']; ?></td>
                    <td><button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#detailModalNts" onclick="loadModalContentNts(<?php echo $ntrt['ntr_id']; ?>)">ดูรายละเอียด</button></td>
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
  <!-- ส่วนของ Modal -->
  <div class="modal fade" id="detailModalNts" tabindex="-1" aria-labelledby="detailModalLabelNts" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" id="modalContentNts">
        <!-- เนื้อหาจะถูกโหลดที่นี่ -->
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('.dataTablents').DataTable({
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

    function loadModalContentNts(ntr_id) {
      // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
      $.ajax({
        url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_ntr'); ?>/" + ntr_id,
        method: "GET",
        success: function(data) {
          $('#modalContentNts').html(data);
          $('#detailModalNts').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log('AJAX error:', textStatus, errorThrown); // Debug line
        }
      });
    }
  </script>