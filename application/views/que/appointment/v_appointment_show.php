<?php
function DateThai($strDate)
{
  $strYear = date("Y", strtotime($strDate)) + 543;
  $strMonth = date("n", strtotime($strDate));
  $strDay = date("j", strtotime($strDate));

  $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
  $strMonthThai = $strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
}
?>
<style>
  #dataTable td,
  #dataTable th {
    border: 1px solid #DDD;
    /* เพิ่มเส้นขอบสีดำ */
  }

  #dataTable {
    border-collapse: collapse;
    /* ทำให้เส้นขอบติดกัน */
    width: 100%;
  }
</style>
<span class="d-none" id="currentMonth"></span>
<div class="card">
  <div class="accordion">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
          <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูล</span><span class="badge bg-success"></span>
        </button>
      </h2>
      <div id="collapseCard" class="accordion-collapse collapse">
        <div class="accordion-body">
          <div class="row">

            <div class="col-md-4 mb-3">
              <label for="date" class="form-label ">วัน/เดือน/ปี ที่นัดหมายแพทย์</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control datepicker_th" name="year-bh" id="year-bh" step="1" placeholder="-- เลือกวันที่นัดหมาย --" value="">
                <span class="input-group-text btn btn-secondary" onclick="$('#year-bh').val(null);" title="clear" data-clear><i class="bi-x"></i></span>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="month" class="form-label ">เดือน</label><br>
              <select class="form-select select2" data-placeholder="-- กรุณาเลือกเดือน --" name="month" id="month">
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="department" class="form-label ">ชื่อแผนก</label><br>
              <select class="form-select select2" data-placeholder="-- กรุณาเลือกแผนก --" name="department" id="department">
                <option value=""></option>
                <?php foreach ($get_structure_detail as $dp) { ?>
                  <option value="<?php echo $dp['stde_id'] ?> "><?= $dp['stde_name_th'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">ชื่อแพทย์</label><br>
              <select class="form-select select2" data-placeholder="-- กรุณาเลือกชื่อแพทย์ --" name="doctor" id="doctor">
                <option value=""></option>
                <?php foreach ($get_doctors as $ps) { ?>
                  <option value="<?php echo $ps['ps_id'] ?> "><?= $ps['pf_name'] . '' . $ps['ps_fname'] . ' ' . $ps['ps_lname']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="date" class="form-label ">HN</label>
              <input type="number" class="form-control" name="" id="patient-id" step="" placeholder="HN" value="">
            </div>
            <div class="col-md-4 mb-3">
              <label for="date" class="form-label ">ชื่อ-นามสกุล ผู้ลงทะเบียน</label>
              <input type="text" class="form-control" name="" id="patient-name" step="" placeholder="ชื่อ-นามสกุล ผู้ลงทะเบียน" value="">
            </div>
            <div class="col-md-4 mb-3">
              <label for="date" class="form-label ">วัน/เดือน/ปี ที่บันทึกข้อมูล</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control datepicker_th2" name="update_date" id="update_date" step="1" placeholder="-- เลือกวันที่บันทึกข้อมูล --" value="">
                <span class="input-group-text btn btn-secondary" onclick="$('#update_date').val(null);" title="clear" data-clear><i class="bi-x"></i></span>
              </div>
            </div>
            <div class="col-md-12">
              <button type="submit" id="search" class="btn btn-primary float-end me-5"><i class="bi-search icon-menu"></i>&nbsp;ค้นหา&emsp;</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="accordion">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
          <div class="header-info">
            <i class="bi-clipboard icon-menu"></i><span>ตารางแสดงข้อมูลผู้ลงทะเบียนที่นัดหมายแพทย์ประจำวันที่ <?php echo DateThai(date("Y-m-d H:i:s")); ?> </span>
          </div>
          <span class="badge bg-success font-14 ms-1"><?php echo $count_apm->appointment_count; ?> ผู้ลงทะเบียนที่ทำเรื่องนัดหมายแพทย์</span>
          <!-- <span class="ms-3">- เรียงตามช่วงเวลาที่คาดว่าจะเข้าพบแพทย์น้อยไปมาก</span> -->
        </button>
      </h2>
      <div id="collapseTable" class="accordion-body">
        <div class="btn-option mb-2 d-flex align-items-center ps-2">
          <!-- <a class="btn btn-primary mb-4 mt-3" href="<?php echo site_url(); ?>/<?php echo $this->config->item('que_dir'); ?>appointment/add_appointment"><i class="bi-plus"></i> เพิ่มการลงทะเบียนผู้ป่วย - การนัดหมายแพทย์ (ล่วงหน้า)</a> -->
          <!-- <p class=" text-primary fw-bold font-weight-600 font-18 ms-2"> A = ผู้ลงทะเบียนนัดหมายแพทย์</p> -->
          <p class="  fw-bold font-weight-600 font-18 text-success ms-2"> W = ผู้ลงทะเบียนแบบ (Walk-In)</p>
        </div>
        <!-- <div class="text-right" style="margin-top: -30px;">
                    <label for="column-select">เลือกคอลัมน์:</label>
                    <select id="column-select" style="border-radius: 5px; margin-bottom: 10px; padding: 5px; border: 1px solid #2196F3;">
                        <option value="2">ชื่อ - นามสกุลผู้ลงทะเบียน</option>
                        <option value="3">วันที่นัดหมายแพทย์</option>
                        <option value="4" selected>ช่วงเวลาที่คาดว่าจะเข้าพบแพทย์</option>
                        <option value="5">แผนก</option>
                        <option value="6">แพทย์ที่นัดหมาย</option>
                        <option value="7">วันที่บันทึกข้อมูล</option>
                    </select>

                    <label for="order-select">เลือกทิศทาง:</label>
                    <select id="order-select" style="border-radius: 5px; margin-bottom: 10px; padding: 5px; border: 1px solid #2196F3;">
                        <option value="asc">จากน้อยไปมาก</option>
                        <option value="desc" selected>จากมากไปน้อย</option>
                    </select>
                </div> -->
        <div class="accordion-collapse collapse show">
          <div class="table-responsive">
            <table class="table table-bordered datatable" id="dataTable" width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>HN</th>
                  <th>visit</th>
                  <th>หมายเลขคิว</th>
                  <th class="w-15">ชื่อ - นามสกุลผู้ลงทะเบียน</th>
                  <th class="w-10">วันที่นัดพบแพทย์</th>
                  <th class="w-5">เวลา</th>
                  <th class="w-15">แผนก</th>
                  <th class="w-15">แพทย์ที่นัดพบ</th>
                  <th class="w-10">ขั้นตอนการบริการ</th>
                  <!-- <th class="w-10">วันที่บันทึกข้อมูล</th> -->
                  <th class="w-15">ดำเนินการ</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</div>
<script>


  $(document).on('click', '.swal-status', function() {
    const url = decodeURIComponent($(this).data('url'));
    const apm_id = $(this).data('apm');

         fetch('<?php echo site_url('que/Appointment/get_appointment_by_id/'); ?>' + '/' + apm_id, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json'
            }
          })

          .then(response => response.json())
          .then(appointmentData => {
            console.log(appointmentData);
            let htmlContent = '';
            appointmentData.appointmentData.forEach((appointment, index) => {
            const apm_date = appointment.apm_date;
            const apm_time = appointment.apm_time;
            const pt_name = appointment.pt_name;
            const stde_name_th = appointment.stde_name_th;
            const ps_name = appointment.ps_name;

            htmlContent += `
                <h6 class="text-start font-weight-600 fs-6 font-20 lh-lg">ชื่อ-นามสกุลผู้ลงทะเบียน : <span class="font-weight-400">${pt_name}</span></h6>
                <h6 class="text-start font-weight-600 fs-6 font-20 pt-2 lh-lg">วันที่ และเวลา : <span class="font-weight-400">${apm_date} ${apm_time} นาฬิกา</span></h6>
                <h6 class="text-start font-weight-600 fs-6 font-20 pt-2 lh-lg">แผนก : <span class="font-weight-400">${stde_name_th}</span></h6>
                <h6 class="text-start font-weight-600 fs-6 font-20 pt-2 lh-lg">ชื่อแพทย์ : <span class="font-weight-400">${ps_name ?? 'ไม่ระบุแพทย์'}</span></h6>
                <hr/>
            `;
        });

            
           
            Swal.fire({
              title: "ยืนยันการเข้าตรวจ",
              html: `
                <style>
                  select[disabled] + .select2-container--default .select2-selection--single .select2-selection__arrow {
                      display: none;
                  }
                </style>
                    
                    ${htmlContent}
                `,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#198754",
              cancelButtonColor: "#dc3545",
              confirmButtonText: "ยืนยัน",
              cancelButtonText: "ยกเลิก",
              // preConfirm: () => {
                // const selectedDepartment = document.getElementById('swal-select-department').value;
                // const selectedPriority = document.getElementById('swal-select-priority').value;
                // const selectedPhysician = document.getElementById('swal-select-physician').value;

              //   return {
              //     selectedDepartment,
              //     selectedPriority,
              //     selectedPhysician
              //   };
              // },
              
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url: url,
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    // stde_id: result.value.selectedDepartment,
                    // pri_id: result.value.selectedPriority,
                    // ps_id: result.value.selectedPhysician,
                    apm_id: apm_id // Including the apm_id in the request
                  },
                  success: function(data) {
                    if (data.status_response == "<?php echo $this->config->item('status_response_success'); ?>") {
                      
                      Swal.fire({
                        title: `ยืนยันการเข้าตรวจสำเร็จ`,
                        // html : `ก`,
                        // html: `<div style="text-align: left; font-family: Arial, sans-serif; line-height: 1.5;">
                        //                     <h6 class="font-20 font-weight-600 mt-4" >ชื่อ-นามสกุลผู้ลงทะเบียน:<span class="font-20 font-weight-400"> ${data.pt_name} </span> </h6>
                                            
                        //                     <h6 class="font-20 font-weight-600 mt-4" >วันที่ และเวลา: <span class="font-20 font-weight-400"> ${data.apm_date} ${data.apm_time} นาฬิกา </span></h6>
                                            
                        //                     <h6 class="font-20 font-weight-600 mt-4" >แผนกที่เข้ารับการตรวจ: <span class="font-20 font-weight-400"> ${data.stde_name_th} </span></h6>
                        //                     <h6 class="font-20 font-weight-600 mt-4" >แพทย์: <span class="font-20 font-weight-400"> ${data.ps_name || 'ไม่ระบุแพทย์'} </span></h6>
                                        
                        //                 </div>
                        //                 <div class="d-fles align-items-center mt-4">
                        //                     <h6 class="font-28 text-primary font-weight-600 "style="font-weight: bold; font-size: 16px; margin-bottom: 5px;">หมายเลขคิว <br> ${data.ql_code}</h6> 
                        //                     </div>`,
                        icon: 'success',
                        
                        // customClass: {
                          // htmlContainer: 'swal2-html-line-height'
                        // },
                        timer: 3000,
                        timerProgressBar: true,
                                willClose: () => {
                                    location.reload(); // Reload after the timer
                                }
                      });
                    } else {
                      Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                      });
                    }
                  },
                  error: function(xhr, status, error) {
                    console.error(xhr);
                    Swal.fire({
                      title: 'Error',
                      text: 'An error occurred while processing your request.',
                      icon: 'error',
                      confirmButtonText: 'OK'
                    });
                  }
                });
              }
            });
          });
      
      
});

  function navigateToAddAppointmentStep2(data) {
    localStorage.setItem('previousPage', window.location.href);
    window.location.href = '<?php echo site_url(); ?>/que/Appointment/add_appointment_step2/' + data;
  }

  function printcode(data) {
    localStorage.setItem('previousPage', window.location.href);
    window.location.href = '<?php echo site_url(); ?>/que/Appointment/printcode/' + data;
  }

  function updateBadge(count) {
    const badge = document.querySelector('.badge.bg-success.font-14.ms-1');
    if (badge) {
      const oldText = badge.textContent.replace(/^\d+/, '').trim(); // Remove old count, keep remaining text
      badge.innerHTML = `${count} ${oldText}`;
    }
  }
  $(document).ready(function() {
    var table = $('#dataTable').DataTable();
    table.destroy();

    var table = $('#dataTable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo site_url('que/Appointment/get_appointments'); ?>",
        "type": "POST",
        "data": function(d) {
          d.date = $('#year-bh').val();
          d.month = $('#month').val();
          d.department = $('#department').val();
          d.doctor = $('#doctor').val();
          d.patientId = $('#patient-id').val();
          d.patientName = $('#patient-name').val();
          d.update_date = $('#update_date').val();
        }
      },
      "lengthMenu": [[1000000, 10, 25, 50], ["ทั้งหมด", 10, 25, 50]], // เพิ่ม "All" ให้เลือกแสดงข้อมูลทั้งหมด
                "pageLength": 1000000, // ค่าเริ่มต้นให้แสดงทั้งหมด
      "columns": [{
          "data": "row_number",
          "orderable": false
        },
        {
          "data": "pt_member"
        },
        {
          "data": "apm_visit",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        {
          "data": "apm_ql_code"
        },
        {
          "data": "pt_name",
          "render": function(data, type, row, meta) {
            let color = "";
            if (row.apm_pri_id == "4") {
              color = "text-primary";
            } else if (row.apm_pri_id == "5") {
              color = "text-success";
            }
            let suffix = "";
            if (row.apm_app_walk == "A") {
              color = "text-primary"; // สีสำหรับผู้ป่วยเก่า
              suffix = "<b>(A)</b>";
            } else if (row.apm_app_walk == "W") {
              color = "text-success"; // สีสำหรับผู้ป่วยใหม่
              suffix = "<b>(W)</b>";
            }
            let patient_type = "";
            // ตรวจสอบประเภทผู้ป่วยตามค่า apm_patient_type
            if (row.apm_patient_type == "old") {
              patient_type = "<b style='color:#ab6600'>(ผู้ป่วยเก่า)</b>";
            } else if (row.apm_patient_type == "new") {
              patient_type = "<b style='color:#00665d'>(ผู้ป่วยใหม่)</b>";
            }

            return `
                    <div class="text-left">
                        ${patient_type}<br>${data}<p class="${color}"> ${suffix} </p>
                    </div>`;
          }
        },
        {
          "data": "apm_date"
        },
        {
          "data": "apm_time",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        {
          "data": "stde_name_th",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        {
          "data": "ps_name",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        {
          "data": "loc_name",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        // {
        //   "data": "apm_update_date",
        //   "render": function(data, type, row, meta) {
        //     // ถ้าข้อมูล apm_update_date เป็น null ให้แสดง apm_create_date แทน
        //     return data ? data : row.apm_create_date;
        //   }
        // },
        {
          "data": "apm_id",
          "render": function(data, type, row, meta) {
            // เริ่มต้นสร้าง HTML สำหรับปุ่มแรกและปุ่มที่สอง ซึ่งจะแสดงเสมอ
            //<button class="btn btn-warning" id="edit_btn" onclick="window.location.href='<?php //echo site_url(); 
                                                                                            ?>/que/Appointment/add_appointment/${data}'"><i class="bi-pencil-square"></i></button>
            let html = `
                        <div class="text-center option">
                            <button class="btn btn-dark" id="" onclick="printcode('${row.apm_visit}')">
                                <i class="bi bi-printer"></i>
                            </button>
                            <button class="btn btn-info" id="edit_btn" onclick="navigateToAddAppointmentStep2('${data}')">
                                <i class="bi-search"></i>
                            </button>`;

            // ตรวจสอบว่า stde_name_th มีค่า และ location ล่าสุดอยู่ใน 1(ลงทะเบียน), 2(คัดกรอง), 3(ตรวจสอบสิทธิ์รักษา) หรือไม่ ถ้ามีจึงจะแสดงปุ่มสุดท้าย
            if (row.stde_name_th && [1, 2, 3].includes(parseInt(row.ntdp_loc_Id))) {
              html += `
                            <button class="btn btn-primary swal-status" id="push_btn" data-url="${encodeURIComponent('<?php echo site_url(); ?>')}/que/Appointment/Referral/${row.apm_visit}" data-apm="${row.apm_visit}">
                                <i class="bi bi-symmetry-horizontal"></i>
                            </button>`;
            }
            if (row.apm_visit === null) {
              html += `
                            <button class="btn btn-danger swal-delete" id="delete-btn" data-url="${'<?php echo site_url(); ?>'}/que/Appointment/delete/${data}">
                                <i class="bi-trash"></i>
                            </button>`;
            }

            // ปิด div และคืนค่า HTML
            html += `</div>`;

            return html;
          }
        }
      ],
      "order": [{
        "column": 3, // คอลัมน์ที่ถูกเลือก
        "dir": "desc" // ทิศทางการเรียงลำดับ
      }],
      "drawCallback": function(settings) {
        mergeTableCells();
      },
      "language": {
        decimal: "",
        emptyTable: "ไม่มีรายการในระบบ",
        info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoEmpty: "แสดงรายการที่ 0 - 0 จากทั้งหมด 0 รายการ",
        infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
        lengthMenu: "_MENU_",
        loadingRecords: "กำลังโหลด...",
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
          sortAscending: ": เปิดใช้งานการเรียงลำดับคอลัมน์จากน้อยไปมาก",
          sortDescending: ": เปิดใช้งานการเรียงลำดับคอลัมน์จากมากไปน้อย"
        },
      },
      "dom": 'lBfrtip',
      "buttons": [{
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
          customize: function(doc) {
            doc.defaultStyle = {
              font: 'THSarabun'
            };
          }
        }
      ],
      "initComplete": function() {
        var api = this.api();
        api.on('draw', function() {
          if (api.rows({
              filter: 'applied'
            }).data().length === 0) {
            $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่มีผู้ลงทะเบียน</td></tr>');
          }
        });

        // เพิ่มการทำงานเมื่อผู้ใช้เลือกคอลัมน์และทิศทางการเรียงลำดับ
        $('#column-select, #order-select').on('change', function() {
          var column = parseInt($('#column-select').val(), 10); // แปลงค่า column-select เป็นตัวเลข
          var order = $('#order-select').val();
          table.order([column, order]).draw();
        });
      }
    });

//     function mergeTableCells() {
//     var rows = $('#dataTable').find('tbody tr');

//     var columnsToCheck = [10, 9, 8, 7, 6, 5, 4, 3, 2]; // เช็คจากคอลัมน์ที่ 2 ถึง 10 (ข้าม #)

//     columnsToCheck.forEach(function(colIndex) {
//         var lastCell = null;
//         var rowspan = 1;

//         rows.each(function() {
//             var currentCell = $(this).find('td:eq(' + colIndex + ')');
//             var visitCurrent = $(this).find('td:eq(2)').text(); // ค่า visit ปัจจุบัน
//             var visitLast = lastCell ? lastCell.closest('tr').find('td:eq(2)').text() : null; // ค่า visit ก่อนหน้า

//             // ถ้าค่าของ visit เหมือนกัน
//             if (lastCell && visitCurrent === visitLast) {
//                 if (currentCell.text() === lastCell.text()) {
//                     rowspan++;
//                     lastCell.attr('rowspan', rowspan);
//                     currentCell.remove();
//                 }

//                 // ผสานคอลัมน์ #, HN เมื่อ visit ถูกผสาน
//                 if (colIndex === 2) {
//                     var currentRowNumCell = $(this).find('td:eq(1)');
//                     var lastRowNumCell = lastCell.closest('tr').find('td:eq(1)');
//                     lastRowNumCell.attr('rowspan', rowspan);
//                     currentRowNumCell.remove();

//                     var currentRowNumCell = $(this).find('td:eq(0)');
//                     var lastRowNumCell = lastCell.closest('tr').find('td:eq(0)');
//                     lastRowNumCell.attr('rowspan', rowspan);
//                     currentRowNumCell.remove();
//                 }
//             } else {
//                 lastCell = currentCell;
//                 rowspan = 1;
//             }
//         });
//     });
// }

function mergeTableCells() {
    var rows = $('#dataTable').find('tbody tr');
    var columnsToCheck = [10, 9, 8, 7, 6, 5, 4, 3, 2]; // Columns to merge, from 2 to 10

    columnsToCheck.forEach(function(colIndex) {
        var lastCell = null;
        var rowspan = 1;
        var rowNumber = 1; // เริ่มต้นลำดับที่ 1

        rows.each(function() {
            var currentCell = $(this).find('td:eq(' + colIndex + ')');
            var visitCurrent = $(this).find('td:eq(2)').text(); // Current row visit value
            var visitLast = lastCell ? lastCell.closest('tr').find('td:eq(2)').text() : null; // Last row visit value

            if (lastCell && visitCurrent === visitLast) {
                if (currentCell.text() === lastCell.text()) {
                    // Same content, increment rowspan and remove current cell
                    rowspan++;
                    lastCell.attr('rowspan', rowspan);
                    currentCell.remove();
                } else {
                    // Different content, reset rowspan
                    lastCell = currentCell;
                    rowspan = 1;
                }

                // Merge the # and HN columns when visit is merged
                if (colIndex === 2) {
                    var currentRowNumCell = $(this).find('td:eq(1)');
                    var lastRowNumCell = lastCell.closest('tr').find('td:eq(1)');
                    lastRowNumCell.attr('rowspan', rowspan);
                    currentRowNumCell.remove();

                    var currentNumCell = $(this).find('td:eq(0)');
                    var lastNumCell = lastCell.closest('tr').find('td:eq(0)');
                    lastNumCell.attr('rowspan', rowspan);
                    currentNumCell.remove();
                }
            } else {
                // Different visit, reset the lastCell and rowspan
                lastCell = currentCell;
                rowspan = 1;
                 // อัปเดตลำดับแถวสำหรับแถวที่ไม่ถูกผสาน
                 var rowNumCell = $(this).find('td:eq(0)');
                rowNumCell.text(rowNumber);
                rowNumber++;
            }
        });
    });
}
function searchAppointments() {
      const searchParams = {
        date: document.getElementById('year-bh').value,
        month: document.querySelector('select[name="month"]').value,
        department: document.querySelector('select[name="department"]').value,
        doctor: document.querySelector('select[name="doctor"]').value,
        patientId: document.getElementById('patient-id').value,
        patientName: document.getElementById('patient-name').value,
        update_date: document.getElementById('update_date').value,
      };
      console.log(searchParams.date);

      if (searchParams.date) {
        updateHeader(searchParams.date);
      }
      if (searchParams.update_date) {
        updateHeader(searchParams.update_date);
      }
      if (searchParams.month) {
        updateHeader_month(searchParams.month);
      }
      $('#dataTable').DataTable().destroy();

      $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": "<?php echo site_url('que/Appointment/get_appointments'); ?>",
          "type": "POST",
          "data": searchParams,
          "dataSrc": function(json) {
            // Update the badge with the total appointment count
            updateBadge(json.totalAppointments);
            return json.data;
          }
        },
        "columns": [{
          "data": "row_number",
          "orderable": false
        },
        {
          "data": "pt_member"
        },
        {
          "data": "apm_visit",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        {
          "data": "apm_ql_code"
        },
        {
          "data": "pt_name",
          "render": function(data, type, row, meta) {
            let color = "";
            if (row.apm_pri_id == "4") {
              color = "text-primary";
            } else if (row.apm_pri_id == "5") {
              color = "text-success";
            }
            let suffix = "";
            if (row.apm_app_walk == "A") {
              color = "text-primary"; // สีสำหรับผู้ป่วยเก่า
              suffix = "<b>(A)</b>";
            } else if (row.apm_app_walk == "W") {
              color = "text-success"; // สีสำหรับผู้ป่วยใหม่
              suffix = "<b>(W)</b>";
            }
            let patient_type = "";
            // ตรวจสอบประเภทผู้ป่วยตามค่า apm_patient_type
            if (row.apm_patient_type == "old") {
              patient_type = "<b style='color:#ab6600'>(ผู้ป่วยเก่า)</b>";
            } else if (row.apm_patient_type == "new") {
              patient_type = "<b style='color:#00665d'>(ผู้ป่วยใหม่)</b>";
            }

            return `
                    <div class="text-left">
                        ${patient_type}<br>${data}<p class="${color}"> ${suffix} </p>
                    </div>`;
          }
        },
        {
          "data": "apm_date"
        },
        {
          "data": "apm_time",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        {
          "data": "stde_name_th",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        {
          "data": "ps_name",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        {
          "data": "loc_name",
          "render": function(data, type, row, meta) {
            // ถ้าข้อมูลเป็นค่าว่างหรือ null ให้แสดง "-"
            return data ? data : '-';
          }
        },
        // {
        //   "data": "apm_update_date",
        //   "render": function(data, type, row, meta) {
        //     // ถ้าข้อมูล apm_update_date เป็น null ให้แสดง apm_create_date แทน
        //     return data ? data : row.apm_create_date;
        //   }
        // },
        {
          "data": "apm_id",
          "render": function(data, type, row, meta) {
            // เริ่มต้นสร้าง HTML สำหรับปุ่มแรกและปุ่มที่สอง ซึ่งจะแสดงเสมอ
            //<button class="btn btn-warning" id="edit_btn" onclick="window.location.href='<?php //echo site_url(); 
                                                                                            ?>/que/Appointment/add_appointment/${data}'"><i class="bi-pencil-square"></i></button>
            let html = `
                        <div class="text-center option">
                            <button class="btn btn-info" id="edit_btn" onclick="navigateToAddAppointmentStep2('${data}')">
                                <i class="bi-search"></i>
                            </button>`;

            // ตรวจสอบว่า stde_name_th มีค่า และ location ล่าสุดอยู่ใน 1(ลงทะเบียน), 2(คัดกรอง), 3(ตรวจสอบสิทธิ์รักษา) หรือไม่ ถ้ามีจึงจะแสดงปุ่มสุดท้าย
            if (row.stde_name_th && [1, 2, 3].includes(parseInt(row.ntdp_loc_Id))) {
              html += `
                            <button class="btn btn-primary swal-status" id="push_btn" data-url="${encodeURIComponent('<?php echo site_url(); ?>')}/que/Appointment/Referral/${row.apm_visit}" data-apm="${row.apm_visit}">
                                <i class="bi bi-symmetry-horizontal"></i>
                            </button>`;
            }
            if (row.apm_visit === null) {
              html += `
                            <button class="btn btn-danger swal-delete" id="delete-btn" data-url="${'<?php echo site_url(); ?>'}/que/Appointment/delete/${data}">
                                <i class="bi-trash"></i>
                            </button>`;
            }

            // ปิด div และคืนค่า HTML
            html += `</div>`;

            return html;
          }
        }
      ],
        "order": [
          // [2, 'desc']
          {
            "column": 4, // คอลัมน์ที่ถูกเลือก
            "dir": "desc" // ทิศทางการเรียงลำดับ
          }
        ],
      "drawCallback": function(settings) {
        mergeTableCells();
      },
        "language": {
          decimal: "",
          emptyTable: "ไม่มีรายการในระบบ",
          info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
          infoEmpty: "แสดงรายการที่ 0 - 0 จากทั้งหมด 0 รายการ",
          infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
          lengthMenu: "_MENU_",
          loadingRecords: "กำลังโหลด...",
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
            sortAscending: ": เปิดใช้งานการเรียงลำดับคอลัมน์จากน้อยไปมาก",
            sortDescending: ": เปิดใช้งานการเรียงลำดับคอลัมน์จากมากไปน้อย"
          },
        },
        "dom": 'lBfrtip',
        "buttons": [{
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
            customize: function(doc) {
              doc.defaultStyle = {
                font: 'THSarabun'
              };
            }
          }
        ],
        "initComplete": function() {
          var api = this.api();
          api.on('draw', function() {
            if (api.rows({
                filter: 'applied'
              }).data().length === 0) {
              $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
            }
          });
          $('#column-select, #order-select').on('change', function() {
                    var column = parseInt($('#column-select').val(), 10);  // แปลงค่า column-select เป็นตัวเลข
                    var order = $('#order-select').val();
                    table.order([column, order]).draw();
                });
        }
      });
    }

    function updateHeader(date) {
      const formattedDate = date ? DateThai(date) : DateThai(new Date().toISOString().slice(0, 10));
      document.querySelector('.header-info').innerHTML = `
        <i class="bi-clipboard icon-menu"></i>
        <span>ข้อมูลผู้ลงทะเบียนที่นัดหมายแพทย์ประจำวันที่ ${formattedDate}</span>
        
    `;
    }

    function updateHeader_month(month) {
      const formattedMonth = month ? MonthThai(month) : MonthThai(new Date().getMonth() + 1);
      document.querySelector('.header-info').innerHTML = `
        <i class="bi-clipboard icon-menu"></i>
        <span>ข้อมูลผู้ลงทะเบียนที่นัดหมายแพทย์ประจำเดือน ${formattedMonth}</span>
    `;
    }

    function DateThai(dateStr) {
      console.log(dateStr);
      const dateParts = dateStr.split('/');
      const day = parseInt(dateParts[0]);
      const month = parseInt(dateParts[1]);
      const year = parseInt(dateParts[2]);

      const months = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];

      return `${day} ${months[month]} ${year}`;
    }

    function MonthThai(monthStr) {
      const monthInt = parseInt(monthStr);
      const months = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
      return months[monthInt - 1];
    }
    // Attach the search function to the button
    document.querySelector('#search').addEventListener('click', function(event) {
      event.preventDefault();
      searchAppointments();
    });



    // Set an interval to reload the table every 30 seconds (30000 milliseconds)
    setInterval(function() {
      var tableContainer = $('#dataTable').parents('.dataTables_scrollBody'); // or replace with appropriate container
      var scrollPosition = tableContainer.scrollTop();

      table.ajax.reload(function() {
        tableContainer.scrollTop(0); // Set the scroll position to the top after reload
      }, false); // false to keep the current page
    }, 30000);

    // Add event listener to search button
    $('#search').on('click', function() {
      table.ajax.reload(function() {
        var tableContainer = $('#dataTable').parents('.dataTables_scrollBody'); // or replace with appropriate container
        tableContainer.scrollTop(0); // Set the scroll position to the top after reload
      });
    });

  });
  document.addEventListener("DOMContentLoaded", function() {
    // Array of months in Thai
    const thaiMonths = [
      "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน",
      "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม",
      "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ];

    // Get the select element
    const selectElement = document.querySelector('select[name="month"]');

    // Create and append the default option
    const defaultOption = document.createElement('option');
    defaultOption.value = "";
    // defaultOption.disabled = true;
    // defaultOption.selected = true;
    // defaultOption.textContent = "กรุณาเลือกเดือน";
    selectElement.appendChild(defaultOption);

    // Create and append the month options
    thaiMonths.forEach((month, index) => {
      const option = document.createElement('option');
      option.value = index + 1;
      option.textContent = month;
      selectElement.appendChild(option);
    });
    const currentMonthIndex = new Date().getMonth();

    // Get the current month in Thai
    const currentMonthInThai = thaiMonths[currentMonthIndex];

    // Find the span where we want to insert the month
    const monthSpan = document.getElementById("currentMonth");

    // Set the month in the span
    monthSpan.textContent = currentMonthInThai;
  });

  function convertYearsToThai() {
    const calendar = document.querySelector('.flatpickr-calendar');
    if (!calendar) return;

    const years = calendar.querySelectorAll('.cur-year, .numInput');
    years.forEach(function(yearInput) {
      convertToThaiYear(yearInput);
    });

    const yearDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
    yearDropdowns.forEach(function(monthDropdown) {
      if (monthDropdown) {
        monthDropdown.querySelectorAll('option').forEach(function(option) {
          convertToThaiYearDropdown(option);
        });
      }
    });

    const currentYearElement = calendar.querySelector('.flatpickr-current-year');
    if (currentYearElement) {
      const currentYear = parseInt(currentYearElement.textContent);
      if (currentYear < 2500) {
        currentYearElement.textContent = currentYear + 543;

      }
    }
  }

  function convertToThaiYear(yearInput) {
    const currentYear = parseInt(yearInput.value);
    if (currentYear < 2500) { // Convert to B.E. only if not already converted
      yearInput.value = currentYear + 543;
    }

  }

  function convertToThaiYearDropdown(option) {
    const year = parseInt(option.textContent);
    if (year < 2500) { // Convert to B.E. only if not already converted
      option.textContent = year + 543;
    }
  }

  function formatDateToThai(date) {
    let d = new Date(date);
    let year = d.getFullYear();
    let month = ('0' + (d.getMonth() + 1)).slice(-2);
    let day = ('0' + d.getDate()).slice(-2);

    if (year < 2500) { // Convert to B.E. only if not already converted
      year = year + 543;
    }

    return `${day}/${month}/${year}`;
  }

  function updateDatepickerValues(selectedDates) {
    if (selectedDates.length > 0) {
      var date = selectedDates[0];
      var day = ('0' + date.getDate()).slice(-2);
      var month = ('0' + (date.getMonth() + 1)).slice(-2);
      var yearBE = date.getFullYear(); // Get year in BE (Buddhist Era)
      var yearTH = yearBE + 543; // Convert to Buddhist year
      var formattedDate = day + '/' + month + '/' + yearTH;
      $(".datepicker_th").val(formattedDate);
    }
  }

  function updateDatepickerValues2(selectedDates) {
    if (selectedDates.length > 0) {
      var date = selectedDates[0];
      var day = ('0' + date.getDate()).slice(-2);
      var month = ('0' + (date.getMonth() + 1)).slice(-2);
      var yearBE = date.getFullYear(); // Get year in BE (Buddhist Era)
      var yearTH = yearBE + 543; // Convert to Buddhist year
      var formattedDate = day + '/' + month + '/' + yearTH;
      $(".datepicker_th2").val(formattedDate);
    }
  }
  var today = new Date();
  var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  var maxDate = new Date();
  maxDate.setDate(maxDate.getDate() + 500);
  flatpickr(".datepicker_th", {
    dateFormat: 'd/m/Y',
    locale: 'th',
    // defaultDate: today, // Set to current Gregorian date
    //   minDate: minDate, // Minimum date is today
    //   maxDate: maxDate, // Maximum date is today + 500 days

    onReady: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
      updateDatepickerValues(selectedDates); // Display the default date in Buddhist year format
    },
    onOpen: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
    },
    onMonthChange: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
    },
    onYearChange: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
    },
    onValueUpdate: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
      updateDatepickerValues(selectedDates);
    },
  });
  flatpickr(".datepicker_th2", {
    dateFormat: 'd/m/Y',
    locale: 'th',
    // defaultDate: today, // Set to current Gregorian date
    //   minDate: minDate, // Minimum date is today
    //   maxDate: maxDate, // Maximum date is today + 500 days

    onReady: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
      updateDatepickerValues2(selectedDates); // Display the default date in Buddhist year format
    },
    onOpen: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
    },
    onMonthChange: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
    },
    onYearChange: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
    },
    onValueUpdate: function(selectedDates, dateStr, instance) {
      convertYearsToThai(instance);
      updateDatepickerValues2(selectedDates);
    },
  });

  $(document).ready(function() {
    $('.select2').select2({
      allowClear: true,
      width: '100%', // Ensure the Select2 widget itself is 100%
      language: {
        inputTooShort: function() {
          return 'กรุณาค้นหา'; // Placeholder for search input
        }
      }
    });

    // Add event listener for date input change

    function abbreDate2(date) {
      const dateParts = date.split('-');
      let [yy, mm, dd] = dateParts;

      dd = dd.replace(/^0+/, ''); // Remove leading zeros

      const months = {
        '01': 'ม.ค.',
        '02': 'ก.พ.',
        '03': 'มี.ค.',
        '04': 'เม.ย.',
        '05': 'พ.ค.',
        '06': 'มิ.ย.',
        '07': 'ก.ค.',
        '08': 'ส.ค.',
        '09': 'ก.ย.',
        '10': 'ต.ค.',
        '11': 'พ.ย.',
        '12': 'ธ.ค.'
      };

      mm = months[mm] || mm;
      yy = parseInt(yy) + 543; // Convert year to Buddhist Era

      return `${dd} ${mm} ${yy}`;
    }

    function abbreDate4(datetime) {
      const [date, time] = datetime.split(' ');
      const dateParts = date.split('-');
      let [yy, mm, dd] = dateParts;

      dd = dd.replace(/^0+/, ''); // Remove leading zeros

      const months = {
        '01': 'ม.ค.',
        '02': 'ก.พ.',
        '03': 'มี.ค.',
        '04': 'เม.ย.',
        '05': 'พ.ค.',
        '06': 'มิ.ย.',
        '07': 'ก.ค.',
        '08': 'ส.ค.',
        '09': 'ก.ย.',
        '10': 'ต.ค.',
        '11': 'พ.ย.',
        '12': 'ธ.ค.'
      };

      mm = months[mm] || mm;
      yy = parseInt(yy) + 543; // Convert year to Buddhist Era

      return `${dd} ${mm} ${yy} เวลา ${time} น.`;
    }
    // Function to perform search
    

  });
</script>