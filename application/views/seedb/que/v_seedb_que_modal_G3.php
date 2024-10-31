<ul class="nav nav-pills pb-5" id="detailsTab" role="tablist">
    
</ul>

            <table id="dynamicTable" class="table table-striped table-bordered w-100" >
    <thead>
        <tr>
            <th>#</th>
            <th>HN</th>
            <th>visit</th>
            <th class="w-20">ชื่อ-นามสกุลผู้ป่วย</th>
            <th class="w-10">วันที่พบแพทย์</th>
            <th class="w-10">เวลาเข้าแผนก</th>

            <th class="w-15">แผนก</th>
            <th class="w-20">แพทย์</th>
            
            
        </tr>
    </thead>    
</table>
<script> 
var tabContainer = document.getElementById('detailsTab');
function getDateSelect() {
      return dateSelect !== null ? dateSelect : getCurrentDateFormatted();
  }
  
  function createTabs(stde_name_th) {
    // var colors = ['#7cb5ec', '#90ed7d', '#f7a35c', '#8085e9', '#f15c80', '#e4d354'];
      var defaultLi = createTab('ทั้งหมด', '0', true );
      tabContainer.appendChild(defaultLi);
    console.log(stde_name_th);
    Object.entries(stde_name_th).forEach(function([key, value], index) {
        var color = colors[index % colors.length]; // Use colors cyclically
        var label = value.stde_name_th + ' (' + value.total_count + ')';
        
        // Pass both the label and the key as parameters to createTab
        var li = createTab(label, key, false, color);
        tabContainer.appendChild(li);
    });
  }
  function createTab(label, id, isActive ) {
      var li = document.createElement('li');
      li.className = 'nav-item pr-1 pt-1 pb-1';
      li.setAttribute('role', 'presentation');
  
      var a = document.createElement('a');
      a.className = 'nav-link' + (isActive ? ' active' : '');
      a.style.marginRight = '10px';
      a.style.marginTop = '10px';
    //   a.style.backgroundColor = color;
      a.id = id;
      a.setAttribute('data-bs-toggle', 'tab');
      a.setAttribute('href', '#walk');
      a.setAttribute('role', 'tab');
      
      a.setAttribute('aria-controls', 'Walk');
      a.setAttribute('aria-selected', isActive);
      a.textContent = label;
  
      a.addEventListener('click', function() {
          handleDataTable(id);
      });
  
      li.appendChild(a);
      return li;
  }
  function handleDataTable(id) {
      if (id == 0){
        id = null;
      }
  
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
                if (dateSelect !== null) {
                                d.dateSelect = dateSelect;
                            } else {
                                d.dateSelect = getCurrentDateFormatted(); // Optionally use the current date if selectedDate is null
                            }
                  d.stde_id = id
                  d.department = department
                  d.type = type;
                  d.columns = [
                    { data: 'row' },
                    { data: 'pt_member' },
                    { data: 'apm_visit' },
                    { data: 'pt_name' },
                    { data: 'apm_date' },
                    { data: 'loc6_ntdp_time_start'},
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
              { data: 'loc6_ntdp_time_start' ,
                render : function(data,type,row,meta ){
                    return data ? data : '-';
                }

              },
              { data: 'stde_name_th' },
              { data: 'ps_name'},
              
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
  
//   function createTabs(stde) {
//     console.log(stde);
//     Object.entries(stde).forEach(([key, value], index) => {
//         // Create list item
//         var li = document.createElement('li');
//         li.className = 'nav-item pr-1 pt-1 pb-1';
//         li.setAttribute('role', 'presentation');

//         // Create link element
//         var a = document.createElement('a');
//         a.className = 'nav-link';
//         a.style.marginRight = '10px';
//         a.style.marginTop = '10px';
//         a.id = `tab${index + 1}`; // Set unique ID for each tab
//         a.setAttribute('data-bs-toggle', 'tab');
//         a.setAttribute('href', `#tabContent${index + 1}`); // Update href to match tab content ID
//         a.setAttribute('role', 'tab');
//         a.setAttribute('aria-controls', `tabContent${index + 1}`); // Update aria-controls to match tab content ID
//         a.setAttribute('aria-selected', index === 0 ? 'true' : 'false');
//         a.textContent = `${value.stde_name_th} (${value.total_count})`; // Set the display text
//             // Add click event listener
//             a.addEventListener('click', function() {
//                 let test = key;
//                 console.log(test);
//                 $(document.getElementById("dynamicTable")).DataTable({
//                     "processing": true,
//                         "serverSide": true,
//                         "ajax": {
//                             "url": "<?php echo site_url('seedb/que/Que_dashboard/get_data'); ?>",
//                             "type": "POST",
//                             "data": function(d) {
//                             if (dateSelect !== null) {
//                                 d.dateSelect = dateSelect;
//                             } else {
//                                 d.dateSelect = getCurrentDateFormatted(); // Optionally use the current date if selectedDate is null
//                             }
//                            if (key !== null)
//                             {
//                                 d.stde_id = key;
//                             } else {
//                                 d.syde_id = null;
//                             }
//                             d.type = type;
//                             d.columns = [
//                     { data: 'row' },
//                     { data: 'pt_member' },
//                     { data: 'apm_visit' },
//                     { data: 'pt_name' },
//                     { data: 'apm_date' },
//                     { data: 'stde_name_th'},
//                     { data: 'ps_name' }
//                 ];
//                             },
//                             "dataSrc": function(json) {
//                             // If no data is returned, return an empty array to prevent showing old data
//                             if (!json.data || json.data.length === 0) {
//                                 return [];
//                             }
//                             return json.data;
//                             }
//                         },
//                         "columns":  [
//                                     { data: 'row' },
//                                     { data: 'pt_member' },
//                                     { data: 'apm_visit' },
//                                     { data: 'pt_name' },
//                                     { data: 'apm_date' },
                                    
//                                     { data: 'stde_name_th' },
//                                     { data: 'ps_name' },
                                    
//                             ],
//                         "destroy": true,
//                         "language": {
//                         decimal: "",
//                         emptyTable: "ไม่มีรายการในระบบ",
//                         info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
//                         infoEmpty: "แสดงรายการที่ 0 - 0 จากทั้งหมด 0 รายการ",
//                         infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
//                         lengthMenu: "_MENU_",
//                         loadingRecords: "กำลังโหลด...",
//                         processing: "",
//                         search: "",
//                         searchPlaceholder: 'ค้นหา...',
//                         zeroRecords: "ไม่พบรายการ",
//                         paginate: {
//                         first: "«",
//                         last: "»",
//                         next: "›",
//                         previous: "‹"
//                         },
//                         aria: {
//                         sortAscending: ": เปิดใช้งานการเรียงลำดับคอลัมน์จากน้อยไปมาก",
//                         sortDescending: ": เปิดใช้งานการเรียงลำดับคอลัมน์จากมากไปน้อย"
//                         },
//                     },
//                     "dom": 'lBfrtip',
//                     "buttons": [{
//                         extend: 'print',
//                         text: '<i class="bi-file-earmark-fill"></i> Print',
//                         titleAttr: 'Print',
//                         title: 'รายการข้อมูล'
//                         },
//                         {
//                         extend: 'excel',
//                         text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
//                         titleAttr: 'Excel',
//                         title: 'รายการข้อมูล'
//                         },
//                         {
//                         extend: 'pdf',
//                         text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
//                         titleAttr: 'PDF',
//                         title: 'รายการข้อมูล',
//                         customize: function(doc) {
//                             doc.defaultStyle = {
//                             font: 'THSarabun'
//                             };
//                         }
//                         }
//                     ],
//                     })
//             });

//             // Append link to list item
//             li.appendChild(a);

//             // Append list item to the tab container
//             tabContainer.appendChild(li);
//         });
//     }
   

    createTabs(stde_name_th);
</script>

