<style>
    .nav-pills .nav-link {
        border: 1px dashed #607D8B;
        color: #012970;
        background-color: #fff;
    }
    /* ไฮไลต์ td ที่มีข้อผิดพลาด */
    .highlight-error {
        background-color: #f8d7da !important; /* สีพื้นหลังแดงอ่อน */
        color: #721c24 !important; /* สีตัวหนังสือแดงเข้ม */
        border-color: #f5c6cb !important; /* สีเส้นขอบที่เข้ากัน */
    }
    .space-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
  
<ul class="nav nav-pills" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal-record" type="button" role="tab" aria-controls="personal-record" aria-selected="true">บันทึกเวลารายบุคคล</button>
    </li>
    <li class="nav-item ms-1" role="presentation">
        <button class="nav-link" id="excel-tab" data-bs-toggle="tab" data-bs-target="#excel-upload" type="button" role="tab" aria-controls="excel-upload" aria-selected="false">นำเข้าข้อมูลด้วย Excel</button>
    </li>
</ul>

<div class="tab-content pt-2" id="myTabContent">
    <!-- บันทึกเวลารายบุคคล -->
    <div class="tab-pane fade show active" id="personal-record" role="tabpanel" aria-labelledby="personal-tab">
        <div class="card mt-2">
            <div class="accordion">
                <!-- Accordion สำหรับค้นหารายชื่อบุคลากร -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                            <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อบุคลากร</span>
                        </button>
                    </h2>
                    <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body">
                            <!-- ฟอร์มการค้นหาแบบฟิลเตอร์ -->
                            <form class="row g-3" method="get">
                                 
                                  <!-- หน่วยงาน -->
                                  <div class="col-md-3">
                                      <label for="select_dp_id" class="form-label ">หน่วยงาน</label>
                                      <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="filter_select_dp_id" id="filter_select_dp_id">
                                          <?php
                                          foreach ($dp_info as $key => $row) {
                                          ?>
                                              <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                          <?php
                                          }
                                          ?>
                                      </select>
                                  </div>

                                  <!-- สายปฏิบัติงาน -->
                                  <div class="col-md-3">
                                      <label for="filter_select_hire_is_medical" class="form-label">สายปฏิบัติงาน</label>
                                      <select class="form-select select2" name="filter_select_hire_is_medical" id="filter_select_hire_is_medical">
                                      <option value="all">ทั้งหมด</option>
                                          <?php
                                              // Assuming $hire_is_medical is already available as an array
                                              $medical_types = [
                                                  'M'  => 'สายการแพทย์',
                                                  'N'  => 'สายการพยาบาล',
                                                  'SM' => 'สายสนับสนุนทางการแพทย์',
                                                  'T'  => 'สายเทคนิคและบริการ',
                                                  'A'  => 'สายบริหาร'
                                              ];

                                              // Loop through hire_is_medical and display corresponding options
                                              foreach ($this->session->userdata('hr_hire_is_medical') as $value) {
                                                  $type = $value['type'];
                                                  if (isset($medical_types[$type])) {
                                                      echo '<option value="' . $type . '">' . $medical_types[$type] . '</option>';
                                                  }
                                              }
                                          ?>
                                      </select>
                                  </div>

                                  <!-- ประเภทการทำงาน -->
                                  <div class="col-md-3">
                                      <label for="filter_select_hire_type" class="form-label">ประเภทการทำงาน</label>
                                      <select class="form-select select2" name="filter_select_hire_type" id="filter_select_hire_type">
                                          <option value="all">ทั้งหมด</option>
                                          <option value="1">ปฏิบัติงานเต็มเวลา (Full-Time)</option>
                                          <option value="2">ปฏิบัติงานบางเวลา (Part-Time)</option>
                                      </select>
                                  </div>

                                  <!-- สถานะการทำงาน -->
                                  <div class="col-md-3">
                                      <label for="filter_select_status_id" class="form-label">สถานะการทำงาน</label>
                                      <select class="form-select select2" id="filter_select_status_id" name="filter_select_status_id">
                                          <option value="all" selected>ทั้งหมด</option>
                                          <option value="1">ปฏิบัติงานอยู่</option>
                                          <option value="2">ออกจากการปฏิบัติงาน</option>
                                      </select>
                                  </div>

                                   <!-- ช่วงวันที่ -->
                                   <div class="col-md-3">
                                      <label for="filter_select_date" class="form-label">ช่วงวันที่</label>
                                      <input type="text" class="form-control" id="filter_select_date" name="filter_select_date">
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #cfe2ff; border-color: #cfe2ff; height: 52px;">
                <div>
                    <i class="bi-people icon-menu font-20" style="margin-left: 10px;"></i><b>รายชื่อบุคลากร</b>
                </div>
            </div>
            <!-- card-header -->
            <div class="card-body">
              <table id="timework_record_list" class="table table-striped table-bordered table-hover datatables" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th class="text-center" width="10%">#</th>
                          <th class="text-center" width="25%">ชื่อ - นามสกุล</th>
                          <th class="text-center" width="20%">รหัสบุคลากร</th>
                          <th class="text-center" width="20%">รหัสจับคู่เครื่องลงเวลาทำงาน</th>
                          <th class="text-center" width="10%">วันที่</th>
                          <th class="text-center" width="15%">เวลา</th>
                      </tr>
                  </thead>
                  <tbody>
                  <!-- ข้อมูลจะถูกเติมด้วย DataTable -->
                  </tbody>
              </table>
            </div>
            <!-- card-body -->
        </div>
        <!-- card -->
        </div>

        <!-- นำเข้าข้อมูลด้วย Excel -->
        <div class="tab-pane fade" id="excel-upload" role="tabpanel" aria-labelledby="excel-tab">
          <?php echo $this->load->view($view_dir . 'v_timework_record_import_excel', '', TRUE); ?>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    

      // ใช้ off เพื่อแน่ใจว่ามีการผูกเหตุการณ์เพียงครั้งเดียว
      $('#filter_select_date, #filter_select_hire_is_medical, #filter_select_hire_type, #filter_select_status_id, #filter_select_dp_id').off('change').on('change', function() {
            
        initializeDataTableTimeworkRecord();

          
      });

      // Initialize Flatpickr with date range and min/max dates
      flatpickr("#filter_select_date", {
          mode: 'range',
          dateFormat: 'd/m/Y',
          locale: 'th',
          defaultDate: [
              new Date(new Date().getFullYear() +543, new Date().getMonth(), 1), // วันแรกของเดือนปัจจุบัน
              new Date(new Date().getFullYear() +543, new Date().getMonth() + 1, 0) // วันสุดท้ายของเดือนปัจจุบัน
          ],
          onReady: function(selectedDates, dateStr, instance) {
              // addMonthNavigationListeners();
              // convertYearsToThai();
          },
          onOpen: function(selectedDates, dateStr, instance) {
              convertYearsToThai();
          },
          onValueUpdate: function(selectedDates, dateStr, instance) {
              convertYearsToThai();
              
              if (selectedDates[0]) {
                  document.getElementById(`filter_select_date`).value = formatDateToThai(selectedDates[0]);
              }
              if (selectedDates[1]) {
                  document.getElementById(`filter_select_date`).value += ' ถึง ' + formatDateToThai(selectedDates[1]);
              }
          },
          onMonthChange: function(selectedDates, dateStr, instance) {
              convertYearsToThai();
          },
          onYearChange: function(selectedDates, dateStr, instance) {
              convertYearsToThai();
          }
      });

      initializeDataTableTimeworkRecord();

      $('[data-bs-toggle="tooltip"]').tooltip();
  });

// ฟังก์ชันแปลงปี พ.ศ. เป็น ค.ศ.
function convertToChristianYear(date_th) {
    // ตรวจสอบว่าค่า date_th ไม่เป็น undefined หรือไม่ใช่ค่าว่าง
    if (!date_th || date_th.trim() === "") {
        // console.log("Invalid date: empty or undefined");
        return null; // หรือส่งคืนค่าที่เหมาะสม เช่น null หรือ string แจ้งข้อผิดพลาด
    }

    // แยกวัน เดือน ปีจากรูปแบบวันที่ที่ส่งเข้ามา
    var parts = date_th.split('/');
    
    // ตรวจสอบว่า parts มี 3 ส่วน (วัน/เดือน/ปี)
    if (parts.length !== 3) {
        // console.log("Invalid date format");
        return null; // หรือส่งคืนค่าที่เหมาะสม เช่น null หรือ string แจ้งข้อผิดพลาด
    }

    var day = parts[0];
    var month = parts[1];
    var year = parseInt(parts[2]) - 543; // แปลง พ.ศ. เป็น ค.ศ.

    // ส่งคืนวันที่ในรูปแบบ ค.ศ. (YYYY-MM-DD)
    return year + '-' + month + '-' + day;
}

  function initializeDataTableTimeworkRecord() {

    
      var hire_is_medical = $('#filter_select_hire_is_medical').val();
      var dp_id = $('#filter_select_dp_id').val();
      
      var hire_type = $('#filter_select_hire_type').val();
      var status_id = $('#filter_select_status_id').val();
      var date = $('#filter_select_date').val();

      // แยกวันที่เริ่มต้นและสิ้นสุด
      var dates = date.split(' ถึง ');
      var start_date_th = dates[0];
      var end_date_th = dates[1];

      // แปลง start_date และ end_date เป็นรูปแบบ Y-m-d
      var start_date = convertToChristianYear(start_date_th);
      var end_date = convertToChristianYear(end_date_th);

      $("#timework_record_list").DataTable({
          initComplete: function() {
              // ปุ่มการจัดการ
          },
          "lengthMenu": [
              [10, 25, 50, -1],
              [10, 25, 50, "ทั้งหมด"]
          ],
          language: {
          decimal: "",
          emptyTable: "ไม่มีรายการในระบบ",
          info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
          infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
          infoFiltered: "(filtered from _MAX_ total entries)",
          infoPostFix: "",
          thousands: ",",
          lengthMenu: "_MENU_",
          loadingRecords: "Loading...",
          processing: "",
          search: "",
          searchPlaceholder: 'ค้นหา...',
          zeroRecords: "ไม่พบรายการ",
          paginate: {
              first: "«",
              last: "»",
              next: "›",
              previous: "‹"
          },
          aria: {
              orderable: "Order by this column",
              orderableReverse: "Reverse order this column"
          },
          },
          dom: 'lBfrtip',
          buttons: [
              {
                  extend: 'print',
                  text: '<i class="bi-file-earmark-fill"></i> Print',
                  titleAttr: 'Print',
                  title: 'รายการข้อมูล'
              },
              {
                  extend: 'excel',
                  text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
                  titleAttr: 'Excel',
                  title: 'รายการข้อมูล'
              },
              {
                  extend: 'pdf',
                  text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
                  titleAttr: 'PDF',
                  title: 'รายการข้อมูล',
                  "customize": function (doc) {
                      doc.defaultStyle = { font: 'THSarabun' };
                  }
              },
          ],
          "ordering": false,
          "columnDefs": [
              { "visible": false, "targets": [1] } // ซ่อนคอลัมน์ "ชื่อ - นามสกุล" ในการจัดกลุ่ม
          ],
          "drawCallback": function(settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null;

              // จัดกลุ่มโดยคอลัมน์ "ชื่อ - นามสกุล"
              api.column(1, { page: 'current' }).data().each(function(group, i) {
                  // console.log(group);
                  if (last !== group) {
                      // var buttonHtml = `
                      //     <button class="btn btn-danger btn-sm" style="float: right;" title="คลิกเพื่อส่งออกเอกสาร PDF" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</button>
                      //     <button class="btn btn-success btn-sm me-2" style="float: right;" title="คลิกเพื่อส่งออกเอกสาร Excel" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                      //     <button class="btn btn-secondary btn-sm me-2" style="float: right;" title="คลิกเพื่อ Print" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-printer-fill"></i> Print</button>
                      // `;
                      
                      $(rows).eq(i).before(
                          // '<tr class="group"><td colspan="4" style="background: #e0e0e0; font-weight: bold;" style="justify-content: space-between; align-items: center;">' + group + '</td></tr>'
                          '<tr class="group"><td colspan="6" style="background: #e0e0e0">' + group + '</td></tr>'
                      );
                      last = group;
                  }
              });
              $('[data-bs-toggle="tooltip"]').tooltip();
          },
          bDestroy: true, // ลบ DataTable เดิมเมื่อมีการ reinitialize ใหม่
          ajax: {
              type: "POST",
              url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_record_list',
              data: {
                  hire_is_medical: hire_is_medical,
                  dp_id: dp_id,
                  hire_type: hire_type,
                  status_id: status_id,
                  start_date: start_date,
                  end_date: end_date
              },
              dataSrc: function(data) {
                  var return_data = new Array();

                  data.forEach(function(row, index) {
                      // console.log("row", row.pf_name + row.ps_fname);
                      var seq = index + 1;


                      var button = `
                          <div class="space-between"><b> ${row.pf_name + " " + row.ps_fname + " " + row.ps_lname} </b>
                              <div class="d-flex justify-content-end">
                                  <button class="btn btn-warning btn-sm me-2" title="คลิกเพื่อแก้ไขข้อมูล" data-bs-toggle="modal" data-bs-target="#edit_time_record_modal">
                                      <i class="bi-pencil"></i>
                                  </button>
                                  <button class="btn btn-primary btn-sm" title="คลิกเพื่อดูรายละเอียด" data-bs-toggle="tooltip" data-bs-placement="top" onclick="view_timework_person_record_detail('${row.ps_id}')">
                                      <i class="bi-search"></i>
                                  </button>
                              </div>
                          </div>
                      `;

                      var button = `
                          <div class="space-between"><b> ${row.pf_name + " " + row.ps_fname + " " + row.ps_lname} </b>
                              <div class="d-flex justify-content-end">
                                 
                                  <button class="btn btn-primary btn-sm" title="คลิกเพื่อดูรายละเอียด" data-bs-toggle="tooltip" data-bs-placement="top" onclick="view_timework_person_record_detail('${row.ps_id}')">
                                      <i class="bi-search"></i>
                                  </button>
                              </div>
                          </div>
                      `;

                      // Return data to push into array
                      return_data.push({
                          "seq": seq, // ลำดับ
                          "button": button, // ปุ่มดำเนินการ
                          "twpc_ps_code": row.twpc_ps_code,
                          "twpc_mc_code": row.twpc_mc_code,
                          "twpc_date": row.twpc_date_text,
                          "twpc_time": row.twpc_time_text
                        
                      });
                  });
                  return return_data;
              } //end dataSrc
          }, //end ajax
          "columns": [
              {
                  "data": "seq",
                  className: "text-center"
              },
              { "data": "button" },
              { "data": "twpc_ps_code", className: "text-center" },
              { "data": "twpc_mc_code", className: "text-center" },
              { "data": "twpc_date", className: "text-center" },
              { "data": "twpc_time" }
          ]
      });
  }

  function view_timework_person_record_detail(ps_id, isPublic){
        var date = $('#filter_select_date').val();

        // แยกวันที่เริ่มต้นและสิ้นสุด
        var dates = date.split(' ถึง ');
        var start_date_th = dates[0];
        var end_date_th = dates[1];

        // แปลง start_date และ end_date เป็นรูปแบบ Y-m-d
        var start_date = convertToChristianYear(start_date_th);
        var end_date = convertToChristianYear(end_date_th);

        window.open('<?php echo site_url($controller_dir . 'preview_timework_record_person'); ?>/' + ps_id + '/' + start_date + "/" + end_date, '_blank');
    }
</script>