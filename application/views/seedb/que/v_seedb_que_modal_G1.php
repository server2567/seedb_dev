<ul class="nav nav-pills pb-5" id="detailsTab" role="tablist">
    
</ul>

            <table id="dynamicTable" class="table table-striped table-bordered w-100" >
    <thead>
        <tr>
            <th>#</th>
            <th class="w-10">HN</th>
            <th class="w-10">visit</th>
            <th class="w-20">ชื่อ-นามสกุลผู้ป่วย</th>
            <th class="w-10">วันที่นัดพบแพทย์</th>
            <th >เวลา</th>
            <th class="w-15">แผนก</th>
            <th>แพทย์</th>
        </tr>
    </thead>    
</table>
<script> 
  var tabContainer = document.getElementById('detailsTab');
  
  function createTabs(timeCategories) {
      var defaultLi = createTab('ทั้งหมด', 'tab-1', true);
      tabContainer.appendChild(defaultLi);
  
      timeCategories.forEach(function(time, index) {
          var li = createTab(time, 'tab-' + (index + 2), false);
          tabContainer.appendChild(li);
      });
  }

  function createTab(label, id, isActive) {
      var li = document.createElement('li');
      li.className = 'nav-item pr-1 pt-1 pb-1';
      li.setAttribute('role', 'presentation');
  
      var a = document.createElement('a');
      a.className = 'nav-link' + (isActive ? ' active' : '');
      a.style.marginRight = '10px';
      a.style.marginTop = '10px';
      a.id = id;
      a.setAttribute('data-bs-toggle', 'tab');
      a.setAttribute('href', '#walk');
      a.setAttribute('role', 'tab');
      a.setAttribute('aria-controls', 'Walk');
      a.setAttribute('aria-selected', isActive);
      a.textContent = label;
  
      a.addEventListener('click', function() {
          handleDataTable(label);
      });
  
      li.appendChild(a);
      return li;
  }

  function handleDataTable(time) {
      var times = time.replace(/\./g, ':').split('-');
      var start_time = times[0];
      if (start_time == 'ทั้งหมด' ){
        start_time = null;
      }
      var end_time = times[1];
  
      if ($.fn.DataTable.isDataTable('#dynamicTable')) {
          $('#dynamicTable').DataTable().clear().destroy();
      }
      var department = document.getElementById('que_select_ums_department').value;
      $('#dynamicTable').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
              "url": "<?php echo site_url('seedb/que/Que_dashboard/get_data'); ?>",
              "type": "POST",
              "data": function(d) {
                  d.dateSelect = getDateSelect();
                  d.start_time = start_time || null;
                  d.end_time = end_time || null;
                  d.type = type;
                  d.department = department;
                  d.columns = [
                      { data: 'row' },
                      { data: 'pt_member' },
                      { data: 'apm_visit' },
                      { data: 'pt_name' },
                      { data: 'apm_date' },
                      { data: 'apm_time'},
                      { data: 'stde_name_th'},
                      { data: 'ps_name' }
                  ];
              },
              "dataSrc": function(json) {
                  return json.data || [];
              }
          },
          "columns": [
              { data: 'row' },
              { data: 'pt_member' },
              { data: 'apm_visit' },
              { data: 'pt_name' },
              { data: 'apm_date' },
              { data: 'apm_time' },
              { data: 'stde_name_th' },
              { data: 'ps_name' }
          ],
          "destroy": true,
          "language": {
              emptyTable: "ไม่มีรายการในระบบ",
              info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
              infoEmpty: "แสดงรายการที่ 0 - 0 จากทั้งหมด 0 รายการ",
              infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
              lengthMenu: "_MENU_",
              loadingRecords: "กำลังโหลด...",
              zeroRecords: "ไม่พบรายการ",
              paginate: {
                  first: "«",
                  last: "»",
                  next: "›",
                  previous: "‹"
              },
          },
          "dom": 'lBfrtip',
          "buttons": [
              { extend: 'print', text: 'Print', title: 'รายการข้อมูล' },
              { extend: 'excel', text: 'Excel', title: 'รายการข้อมูล' },
              { extend: 'pdf', text: 'PDF', title: 'รายการข้อมูล', customize: function(doc) {
                  doc.defaultStyle = { font: 'THSarabun' };
              }}
          ]
      });
  }

  function getDateSelect() {
      return dateSelect !== null ? dateSelect : getCurrentDateFormatted();
  }

  // Call the function to create tabs
  createTabs(category_time);
</script>
