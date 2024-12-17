<style>
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
      font-size: 16px;
    }
    .mt-140 {
      margin-top: -140px;
    }
    .table-responsive {
      zoom: 100%;
      padding: 0px;
    }
    table.dataTable thead > tr > th.dt-orderable-asc, table.dataTable thead > tr > th.dt-orderable-desc, table.dataTable thead > tr > th.dt-ordering-asc, table.dataTable thead > tr > th.dt-ordering-desc, table.dataTable thead > tr > td.dt-orderable-asc, table.dataTable thead > tr > td.dt-orderable-desc, table.dataTable thead > tr > td.dt-ordering-asc, table.dataTable thead > tr > td.dt-ordering-desc {
      font-size: 16px;
    }
  }
</style>
<h1 class="h3 mb-0 mt-140">ประวัติการเข้าโรงพยาบาล</h1>
<div class="card-body pt-0 px-0">
  <div class="row g-3">
    <div class="col-12">
      <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center p-0 pt-3">
        <h6 class="card-title mb-0">ตารางแสดงรายการประวัติการเข้าโรงพยาบาล</h6>
      </div>
      <div class="card-body p-0">
        <div class="row align-items-md-center">
          <div class="table-responsive">
            <table class="table dataTableApp" id="dataTable" width="100%">
              <thead>
                <tr>
                  <th class="w-5" >ลำดับ</th>
                  <th class="w-30">วันที่นัดหมายแพทย์</th>
                  <th class="w-20">แผนก</th>
                  <th class="w-30">แพทย์ที่นัดหมาย</th>
                  <th class="w-15">ดูรายละเอียด</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_quet as $key_quet => $quet) { ?>
                  <tr>
                    <td><?php echo $key_quet + 1; ?></td>
                    <td><?php echo formatThaiDate($quet['apm_date'], $quet['apm_time']); ?></td>
                    <td><?php echo $quet['stde_name_th']; ?></td>
                    <td><?php echo $quet['pf_name_abbr'] . '' . $quet['ps_fname'] . ' ' . $quet['ps_lname']; ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-primary mb-0 p-1 ps-2 pe-2" data-bs-toggle="modal" data-bs-target="#detailModal2" onclick="loadModalContentHis(<?php echo $quet['apm_id']; ?>)">
                        <i class="bi bi-search font-14"></i>
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
  <!-- ส่วนของ Modal -->
  <div class="modal fade" id="detailModal2" tabindex="-1" aria-labelledby="detailModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" id="modalContent2">
        <!-- เนื้อหาจะถูกโหลดที่นี่ -->
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('.dataTableApp').DataTable({
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

    function loadModalContentHis(appointment_id) {
      // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
      $.ajax({
        url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_que'); ?>/" + appointment_id,
        method: "GET",
        success: function(data) {
          $('#modalContent2').html(data);
          $('#detailModal2').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log('AJAX error:', textStatus, errorThrown); // Debug line
        }
      });
    }
  </script>