<style>
  .card-icon i {
    font-size: 3rem;
    opacity: 0.5;
  }

  .card-button {
    cursor: default;
  }

  .active-card {
    background: #0076ab !important;
    color: #FFF !important;
    border-radius: 5px;
  }

  .active-card .card-body {
    color: #FFF !important;
  }

  .active-card .card-icon i {
    color: #FFF !important;
  }

  .active-card .btn {
    background: #005f87 !important;
  }
</style>
<div class="row justify-content-center mt-5">
  <div class="col-md-3">
    <div class="card card-button" data-id="3" onclick="get(3)">
      <div class="card-body">
        <h6>จำนวนผู้ลงทะเบียนใหม่ที่รอการอนุมัติ</h6>
        <div class="card-icon rounded-circle float-start">
          <i class="bi bi-person-fill text-warning"></i>
        </div>
        <div class="float-end">
          <h2 class="mt-3"><?= $coutapp ?> คน</h2>
        </div>
        <button type="button" class="btn btn-info" id="btn-new-pop" style="position: absolute; top: 6px; right: 6px; padding-left: 7px; font-size: 10px; padding-right: 7px;">
          <i class="bi bi-search text-white"></i>
        </button>
      </div>
    </div>
  </div>
  <?php //if($coutNow > 0){ ?>
  <div class="col-md-3">
    <div class="card card-button" data-id="1" onclick="get(1)">
      <div class="card-body">
        <h6>จำนวนผู้ลงทะเบียนใหม่วันปัจจุบัน</h6>
        <div class="card-icon rounded-circle float-start">
          <i class="bi bi-person-fill-check text-success"></i>
        </div>
        <div class="float-end">
          <h2 class="mt-3"><?= $coutNow ?> คน</h2>
        </div>
        <button type="button" class="btn btn-info" id="btn-new-pop" style="position: absolute; top: 6px; right: 6px; padding-left: 7px; font-size: 10px; padding-right: 7px;">
          <i class="bi bi-search text-white"></i>
        </button>
      </div>
    </div>
  </div>
  <?php //} ?>
  <div class="col-md-3">
    <div class="card card-button" data-id="2" onclick="get(2)">
      <div class="card-body">
        <h6>จำนวนผู้ลงทะเบียนทั้งหมด</h6>
        <div class="card-icon rounded-circle float-start">
          <i class="bi-people text-info"></i>
        </div>
        <div class="float-end">
          <h2 class="mt-3"><?= $coutall ?> คน</h2>
        </div>
        <button type="button" class="btn btn-info" id="btn-total-pop" style="position: absolute; top: 6px; right: 6px; padding-left: 7px; font-size: 10px; padding-right: 7px;">
          <i class="bi bi-search text-white"></i>
        </button>
      </div>
    </div>
  </div>
  <?php //if($coutedit > 0){ ?>
  <div class="col-md-3">
    <div class="card card-button" data-id="4" onclick="get(4)">
      <div class="card-body">
        <h6>จำนวนผู้ลงทะเบียนที่ขอเปลี่ยนแปลงข้อมูล</h6>
        <div class="card-icon rounded-circle float-start">
          <i class="bi-person-fill-gear text-danger"></i>
        </div>
        <div class="float-end">
          <h2 class="mt-3"><?= $coutedit ?> คน</h2>
        </div>
        <button type="button" class="btn btn-info" id="btn-total-pop" style="position: absolute; top: 6px; right: 6px; padding-left: 7px; font-size: 10px; padding-right: 7px;">
          <i class="bi bi-search text-white"></i>
        </button>
      </div>
    </div>
  </div>
  <?php //} ?>
</div>

<div class="card">
  <div class="accordion">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
          <i class="bi-search icon-menu"></i><span id="table-title-search">ค้นหาผู้ที่ลงทะเบียนทั้งหมด</span>
        </button>
      </h2>
      <div id="collapseAdd" class="accordion-collapse collapse" aria-labelledby="headingAdd">
        <div class="accordion-body">
          <form class="row g-3" id="searchForm">
            <div class="col-md-6">
              <label for="date" class="form-label ">วันที่ลงทะเบียน</label>
              <div class="input-group date input-daterange">
                <input type="input" class="form-control" name="data[]" id="start_date" placeholder="วว/ดด/ปป">
                <span class="input-group-text mb-3">ถึง</span>
                <input type="input" class="form-control" name="data[]" id="end_date" placeholder="วว/ดด/ปป">
              </div>
            </div>
            <div class="col-md-6">
              <label for="pos_ps_code" class="form-label">HN</label>
              <input type="text" class="form-control" name="data[]" id="pt_member" placeholder="">
            </div>
            <div class="col-md-6">
              <label for="us_username" class="form-label">เลขบัตรประจำตัวประชาชน / พาสปอร์ต / เลขบัตรต่างด้าว</label>
              <input type="text" class="form-control" name="data[]" id="card" placeholder="">
            </div>
            <div class="col-md-6">
              <label for="us_name" class="form-label">ชื่อ - นามสกุลของผู้ลงทะเบียน</label>
              <input type="text" class="form-control" name="data[]" id="us_name" placeholder="" value="<?php echo !empty($search) && isset($search['us_name']) ? $search['us_name'] : ""; ?>">
            </div>
            <div class="col-md-12">
              <!-- <button class="btn btn-secondary float-start">เคลียร์ข้อมูล</button> -->
              <a  onclick="saveFormSubmit()" class="btn btn-primary float-end"><i class="bi bi-search me-2"></i>ค้นหา</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="accordion">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button accordion-button-table" type="button">
          <i class="bi-card-list icon-menu"></i><span id="table-title">ตารางแสดงรายชื่อผู้ที่ลงทะเบียนทั้งหมด รวมทุกสถานะ เรียงตามวันที่ - เวลาลงทะเบียน</span>
          <div class="badge bg-success font-14" id="count">0</div>
        </button>
      </h2>
      <div id="collapseShow" class="accordion-collapse collapse show">
        <div class="accordion-body">
          <table id="patientTable" class="table datatable" width="100%">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">HN</th>
                <th class="text-center">เลขบัตร</th>
                <th>ชื่อ - นามสกุลผู้ลงทะเบียน</th>
                <th class="text-center">เบอร์โทร</th>
                <th class="text-center">อีเมล</th>
                <th class="text-center">สถานะ</th>
                <th class="text-center w-10" id="date-time-header">วันที่ - เวลาลงทะเบียน</th>
                <th class="text-center">ดำเนินการ</th>
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
<script>
  // ฟังก์ชันเพื่อฟอร์แมตวันที่เป็นรูปแบบภาษาไทย
  function formatDateToThai(dateString) {
    if (!dateString || isNaN(Date.parse(dateString))) {
      return "";
    }
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date(dateString);
    // ปรับปีให้เป็นพ.ศ.
    const thaiYear = date.getFullYear() + 543;
    const thaiDate = new Date(date.setFullYear(thaiYear));
    return thaiDate.toLocaleDateString('th-TH', options);
  }
  // ฟังก์ชันเพื่อปรับปีในปฏิทินให้เป็นพ.ศ.
function convertYearsToThai() {
  document.querySelectorAll('.flatpickr-current-month .cur-year').forEach(function(element) {
    const year = parseInt(element.textContent);
    if (year && !isNaN(year)) {
      element.textContent = year + 543;
    }
  });
}
  var ck = null;
// กำหนด flatpickr
flatpickr("#start_date", {
  plugins: [
    new rangePlugin({
      input: "#end_date"
    })
  ],
  dateFormat: 'd/m/Y',
  locale: 'th',
  defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฏิทิน พ.ศ.
  onReady: function(selectedDates, dateStr, instance) {
    document.getElementById('start_date').value = formatDateToThai('<?php echo !empty($search) && isset($search['start_date']) ? $search['start_date'] : ""; ?>');
    document.getElementById('end_date').value = formatDateToThai('<?php echo !empty($search) && isset($search['end_date']) ? $search['end_date'] : ""; ?>');
    convertYearsToThai();
  },
  onOpen: function(selectedDates, dateStr, instance) {
    convertYearsToThai();
  },
  onValueUpdate: function(selectedDates, dateStr, instance) {
    convertYearsToThai();
    if (selectedDates[0]) {
      document.getElementById('start_date').value = formatDateToThai(selectedDates[0]);
    }
    if (selectedDates[1]) {
      document.getElementById('end_date').value = formatDateToThai(selectedDates[1]);
    }
  },
  onMonthChange: function(selectedDates, dateStr, instance) {
    convertYearsToThai();
  },
  onYearChange: function(selectedDates, dateStr, instance) {
    convertYearsToThai();
  }
});

  function saveFormSubmit() {
    let formData = {};
    let hasSearchCriteria = false; // ตัวแปรเพื่อตรวจสอบว่ามีค่าการค้นหาหรือไม่
    $('[name^="data[]"]').each(function(i) {
      // เก็บค่าจาก element ลงใน formData โดยใช้ id ของ element เป็น key
      formData[this.id] = this.value;
      if (this.value.trim() !== "") {
        hasSearchCriteria = true; // ถ้ามีค่าการค้นหา ตั้งค่าตัวแปรเป็น true
      }
    });

    if (!hasSearchCriteria) {
      // ถ้าไม่มีค่าการค้นหา แสดงข้อความแจ้งเตือน
      Swal.fire({
        title: 'กรุณากรอกรายละเอียดที่ต้องการค้นหา',
        icon: 'warning'
      });
      return;
    }


    // ส่ง full_name เป็นฟิลด์เดียวไปยังฝั่งเซิร์ฟเวอร์
    formData['full_name'] = formData['us_name'];
    // console.log(formData);
    if ($.fn.DataTable.isDataTable('#patientTable')) {
      $('#patientTable').DataTable().destroy();
    }
    // Initialize DataTable with server-side processing
    var table = $('#patientTable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo site_url('ums/User_register/index_side'); ?>",
        "type": "POST",
        "data": {
          formData: formData
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
          "data": "card"
        },
        {
          "data": "name"
        },
        {
          "data": "phone"
        },
        {
          "data": function(row) {
    return row.email ? row.email : '<div class="text-center">-</div>';
  }
        },
        {
          "data": null,
          "render": function(data, type, row) {
            return '<div class="text-center"><span style="color: ' + row.color + '">' + row.status + '</span></div>';
          }
        },
        {
          "data": "pt_create_date"
        },
        {
          "data": "pt_id",
          "render": function(data, type, row, meta) {
            return `
                            <div class="text-center">
                                <form action="<?php echo site_url('ums/frontend/Dashboard_home_patient'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="pt_id" value=${data}>
                                    <button type="submit" class="btn btn-primary" >
                                        <i class="bi bi-pen-fill"></i> จัดการข้อมูล
                                    </button>
                                </form>
                            </div>`;
          }
        }
      ], // Default order set here
      "language": {
        decimal: "",
        emptyTable: "ไม่มีรายการในระบบ",
        info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoFiltered: "(filtered from _MAX_ total entries)",
        lengthMenu: "_MENU_",
        loadingRecords: "ไม่พบรายการ",
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
      "initComplete": function(settings, json) {
        // Update count based on the total records returned
        var totalRecords = json.recordsTotal; // Assuming your server-side script returns 'recordsTotal'
        $('#count').html(totalRecords + ' จำนวนผู้ลงทะเบียน');
      }
    });
  }
  // Listen for Enter key press on input fields within the form
  $('#searchForm input').on('keypress', function(event) {
    if (event.which === 13) {
      event.preventDefault();
      saveFormSubmit();
    }
  });
</script>
<script>
  
  function get(id) {

    // ลบคลาส active-card จากการ์ดทั้งหมดก่อน
    document.querySelectorAll('.card.card-button').forEach(card => {
      card.classList.remove('active-card');
    });

    // เพิ่มคลาส active-card ให้กับการ์ดที่ถูกคลิก
    var activeCard = document.querySelector(`.card.card-button[data-id="${id}"]`);
    if (activeCard) {
      activeCard.classList.add('active-card');
    }

    // เปลี่ยนข้อความเมื่อ id = 3
    if(id == 1){
      document.getElementById('table-title').textContent = 'ตารางแสดงรายชื่อผู้ลงทะเบียนใหม่ที่รอการอนุมัติ เรียงตามวันที่ - เวลาลงทะเบียน';
      document.getElementById('table-title-search').textContent = 'ค้นหาผู้ลงทะเบียนใหม่ที่รอการอนุมัติ';   
      document.getElementById('date-time-header').textContent = 'วันที่ - เวลาลงทะเบียน';
    } else if(id == 2) {
      document.getElementById('table-title').textContent = 'ตารางแสดงรายชื่อผู้ลงทะเบียนใหม่วันปัจจุบัน เรียงตามวันที่ - เวลาลงทะเบียน';
      document.getElementById('table-title-search').textContent = 'ค้นหาผู้ลงทะเบียนใหม่วันปัจจุบัน';   
      document.getElementById('date-time-header').textContent = 'วันที่ - เวลาลงทะเบียน';
    } else if (id == 3) {
      document.getElementById('table-title').textContent = 'ตารางแสดงรายชื่อผู้ลงทะเบียนสำเร็จทั้งหมด เรียงตามวันที่ - เวลาลงทะเบียน';
      document.getElementById('table-title-search').textContent = 'ค้นหาผู้ลงทะเบียนสำเร็จทั้งหมด';   
      document.getElementById('date-time-header').textContent = 'วันที่ - เวลาลงทะเบียน';
    } else if (id == 4) {
      document.getElementById('table-title').textContent = 'ตารางแสดงรายชื่อผู้ลงทะเบียนที่ขอเปลี่ยนแปลงข้อมูล เรียงตามวันที่ - เวลาลงทะเบียน';
      document.getElementById('table-title-search').textContent = 'ค้นหาผู้ลงทะเบียนที่ขอเปลี่ยนแปลงข้อมูล';   
      document.getElementById('date-time-header').textContent = 'วันที่ - เวลาที่ขอการเปลี่ยนแปลงข้อมูล';
    } else {
      document.getElementById('table-title').textContent = 'ตารางแสดงรายชื่อผู้ที่ลงทะเบียนทั้งหมด รวมทุกสถานะ เรียงตามวันที่ - เวลาลงทะเบียน';
      document.getElementById('table-title-search').textContent = 'ค้นหาผู้ที่ลงทะเบียนทั้งหมด';   
      document.getElementById('date-time-header').textContent = 'วันที่ - เวลาลงทะเบียน';

    }

    if ($.fn.DataTable.isDataTable('#patientTable')) {
      $('#patientTable').DataTable().destroy();
    }

    var table = $('#patientTable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo site_url('ums/User_register/index_side'); ?>",
        "type": "POST",
        "data": {
          id: id
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
          "data": "card"
        },
        {
          "data": "name"
        },
        {
          "data": "phone"
        },
        {
          "data": function(row) {
    return row.email ? row.email : '<div class="text-center">-</div>';
  }
        },
        {
          "data": null,
          "render": function(data, type, row) {
            return '<div class="text-center"><span style="color: ' + row.color + '">' + row.status + '</span></div>';
          }
        },
        { 
          "data": (id == 4) ? "pt_update_date" : "pt_create_date",
        },
        {
          "data": "pt_id",
          "render": function(data, type, row, meta) {
            return `
                            <div class="text-center">
                                <form action="<?php echo site_url('ums/frontend/Dashboard_home_patient'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="pt_id" value=${data}>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-pen-fill"></i> จัดการข้อมูล
                                    </button>
                                </form>
                            </div>`;
          }
        }
      ], // Default order set here
      "language": {
        decimal: "",
        emptyTable: "ไม่มีรายการในระบบ",
        info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoFiltered: "(filtered from _MAX_ total entries)",
        lengthMenu: "_MENU_",
        loadingRecords: "ไม่พบรายการ",
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
      "initComplete": function(settings, json) {
        // Update count based on the total records returned
        var totalRecords = json.recordsTotal; // Assuming your server-side script returns 'recordsTotal'
        $('#count').html(totalRecords + ' จำนวนผู้ลงทะเบียน');
      }
    });
  }
  $(document).ready(function() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#patientTable')) {
      $('#patientTable').DataTable().destroy();
    }

    // Initialize DataTable with server-side processing
    var table = $('#patientTable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo site_url('ums/User_register/index_side'); ?>",
        "type": "POST",
        "data": function(d) {
          // You can add additional data parameters if needed
          // d.customParam = 'value';
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
          "data": "card"
        },
        {
          "data": "name"
        },
        {
          "data": "phone"
        },
        {
          "data": function(row) {
    return row.email ? row.email : '<div class="text-center">-</div>';
  }
        },
        {
          "data": null,
          "render": function(data, type, row) {
            return '<div class="text-center"><span style="color: ' + row.color + '">' + row.status + '</span></div>';
          }
        },
        {
          "data": "pt_create_date"
        },
        {
          "data": "pt_id",
          "render": function(data, type, row, meta) {
            return `
                        <div class="text-center">
                            <form action="<?php echo site_url('ums/frontend/Dashboard_home_patient'); ?>" method="post" target="_blank">
                                <input type="hidden" name="pt_id" value=${data}>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-pen-fill"></i> จัดการข้อมูล
                                </button>
                            </form>
                        </div>`;
          }
        }
      ], // Default order set here
      "language": {
        decimal: "",
        emptyTable: "ไม่มีรายการในระบบ",
        info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoFiltered: "(filtered from _MAX_ total entries)",
        lengthMenu: "_MENU_",
        loadingRecords: "ไม่พบรายการ",
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
      "initComplete": function(settings, json) {
        // Update count based on the total records returned
        var totalRecords = json.recordsTotal; // Assuming your server-side script returns 'recordsTotal'
        $('#count').html(totalRecords + ' จำนวนผู้ลงทะเบียน');
      }
    });
    
  });
</script>