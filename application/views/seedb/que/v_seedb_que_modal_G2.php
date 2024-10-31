
<ul class="nav nav-pills pb-5" id="detailsTab" role="tablist">
    
</ul>
<!-- 
<div class="card">
                        <div class="accordion">
                          <div class="accordion-item">
                            <h2 class="accordion-header">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                                <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูล</span><span class="badge bg-success"></span>
                              </button>
                            </h2>
                            <div id="collapseCard" class="accordion-collapse collapse-show">
                              <div class="accordion-body ">
                                <div class="row">
                                  <div class="col-12 mb-3">
                                    <label for="date" class="form-label ">ค้นหาชื่อแพทย์</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกแพทย์ --" name="ps_name" id="ps_name" step="" placeholder="-- กรุณาเลือกแพทย์ --" value="">
                                    </select>
                                  </div>

                                  <div class="col-md-12">
                                    <button type="submit" id="search" class="btn btn-primary float-end me-5"><i class="bi-search icon-menu"></i>&nbsp;ค้นหา&emsp;</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div> -->
<table id="dynamicTable" class="table table-striped table-bordered w-100" >
    <thead>
        <tr>
            <th class="text-center" >#</th>
            <th class="w-10">HN</th>
            <th class="w-10">visit</th>
            <th class="w-20">ชื่อ-นามสกุลผู้ป่วย</th>
            <th class="w-10">วันที่นัดพบแพทย์</th>
            <th class="w-20">แพทย์</th>
            <th class="w-10">เวลาเริ่มต้น</th>
            <th class="w-10">เวลาสิ้นสุด</th>
            <th class="w-10">เวลาทั้งหมด (นาที)</th>

            
            
        </tr>
    </thead>    
</table>
<script> 
  // Reference to the UL element where tabs will be added
  var tabContainer = document.getElementById('detailsTab');
  $(document).ready(function () {
    // $('.select2').select2({
    //   allowClear: true,
    //   width: '100%', // Ensure the Select2 widget itself is 100%
    //   language: {
    //     inputTooShort: function() {
    //       return 'กรุณาค้นหา'; // Placeholder for search input
    //     }
    //   }
    // });
        // Send an AJAX request to fetch doctors when the page loads
        function createTabs(response) {
          var defaultLi = createTab('ทั้งหมด', '0', true);
          tabContainer.appendChild(defaultLi);
          console.log(response);
          response.forEach(function(time, index) {
          
          var li = createTab(time.ps_name, time.ps_id, false);
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
                handleDataTable(id);
            });
        
            li.appendChild(a);
            return li;
        }

        $.ajax({
            url: "<?php echo site_url('seedb/que/Que_dashboard/get_doctors'); ?>", // Adjust the URL accordingly
            type: "GET",
            dataType: "json",
            data: {

                dateSelect: dateSelect,
                type: type
            },
            success: function(response) {
                console.log("Response received:", response); // Confirm response
                createTabs(response);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching doctors:", error);
            }
        });


        function handleDataTable(id) {
      if (id == 0){
        id = null;
      }
      var department = document.getElementById('que_select_ums_department').value;
  
      if ($.fn.DataTable.isDataTable('#dynamicTable')) {
          $('#dynamicTable').DataTable().clear().destroy();
      }
  
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
                  d.ps_id = id
                  d.type = type
                  d.department = department;
                  d.columns = [
                              { data: 'row' },
                              { data: 'pt_member' },
                              { data: 'apm_visit' },
                              { data: 'pt_name' },
                              { data: 'apm_date' },
                              { data: 'ps_name' },
                              { data: 'loc8_ntdp_time_start'},
                              { data: 'loc8_ntdp_time_finish'},
                              { data: 'loc8_ntdp_time_total'}
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
              { data: 'ps_name' },
              { data: 'loc8_ntdp_time_start'},
              { data: 'loc8_ntdp_time_finish'},
              { data: 'loc8_ntdp_time_total' , 
                render : function(data,type,row,meta){
                  let color = "";
                  if (row.loc8_ntdp_time_finish <= row.loc8_ntdp_time_end){
                    color = "text-success";
                  } else {
                    color = "text-danger";
                  }
                  return `<div class="text-left ${color}">
                        ${data}
                    </div>`;
                  
                }
               }
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
    });

  // $('#search').on('click', function() {
  //   $(document.getElementById("dynamicTable")).DataTable({
  //                   "processing": true,
  //                       "serverSide": true,
  //                       "ajax": {
  //                           "url": "<?php echo site_url('seedb/que/Que_dashboard/get_data'); ?>",
  //                           "type": "POST",
  //                           "data": function(d) {
  //                           if (dateSelect !== null) {
  //                               d.dateSelect = dateSelect;
  //                           } else {
  //                               d.dateSelect = getCurrentDateFormatted(); // Optionally use the current date if selectedDate is null
  //                           }
  //                          d.ps_id = $('#ps_name').val();
  //                           d.type = type;
  //                           d.columns = [
  //                             { data: 'row' },
  //                             { data: 'pt_member' },
  //                             { data: 'apm_visit' },
  //                             { data: 'pt_name' },
  //                             { data: 'apm_date' },
  //                             { data: 'ps_name' }
  //                         ];
  //                           },
  //                           "dataSrc": function(json) {
  //                           // If no data is returned, return an empty array to prevent showing old data
  //                           if (!json.data || json.data.length === 0) {
  //                               return [];
  //                           }
  //                           return json.data;
  //                           }
  //                       },
  //                       "columns":  [
  //                                   { data: 'row' },
  //                                   { data: 'pt_member' },
  //                                   { data: 'apm_visit' },
  //                                   { data: 'pt_name' ,
  //         "render": function(data, type, row, meta) {
  //           let color = "";
  //           if (row.apm_pri_id == "4") {
  //             color = "text-primary";
  //           } else if (row.apm_pri_id == "5") {
  //             color = "text-success";
  //           }
  //           let suffix = "";
  //           if (row.apm_app_walk == "A") {
  //             color = "text-primary"; // สีสำหรับผู้ป่วยเก่า
  //             suffix = "<b>(A)</b>";
  //           } else if (row.apm_app_walk == "W") {
  //             color = "text-success"; // สีสำหรับผู้ป่วยใหม่
  //             suffix = "<b>(W)</b>";
  //           }
  //           let patient_type = "";
  //           // ตรวจสอบประเภทผู้ป่วยตามค่า apm_patient_type
  //           if (row.apm_patient_type == "old") {
  //             patient_type = "<b style='color:#ab6600'>(ผู้ป่วยเก่า)</b>";
  //           } else if (row.apm_patient_type == "new") {
  //             patient_type = "<b style='color:#00665d'>(ผู้ป่วยใหม่)</b>";
  //           }

  //           return `
  //                   <div class="text-left">
  //                       ${patient_type}<br>${data}<p class="${color}"> ${suffix} </p>
  //                   </div>`;
  //         }},
  //                                   { data: 'apm_date' },
  //                                   { data: 'ps_name' },
                                    
  //                           ],
  //                       "destroy": true,
  //                       "language": {
  //                       decimal: "",
  //                       emptyTable: "ไม่มีรายการในระบบ",
  //                       info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
  //                       infoEmpty: "แสดงรายการที่ 0 - 0 จากทั้งหมด 0 รายการ",
  //                       infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
  //                       lengthMenu: "_MENU_",
  //                       loadingRecords: "กำลังโหลด...",
  //                       processing: "",
  //                       search: "",
  //                       searchPlaceholder: 'ค้นหา...',
  //                       zeroRecords: "ไม่พบรายการ",
  //                       paginate: {
  //                       first: "«",
  //                       last: "»",
  //                       next: "›",
  //                       previous: "‹"
  //                       },
  //                       aria: {
  //                       sortAscending: ": เปิดใช้งานการเรียงลำดับคอลัมน์จากน้อยไปมาก",
  //                       sortDescending: ": เปิดใช้งานการเรียงลำดับคอลัมน์จากมากไปน้อย"
  //                       },
  //                   },
  //                   "dom": 'lBfrtip',
  //                   "buttons": [{
  //                       extend: 'print',
  //                       text: '<i class="bi-file-earmark-fill"></i> Print',
  //                       titleAttr: 'Print',
  //                       title: 'รายการข้อมูล'
  //                       },
  //                       {
  //                       extend: 'excel',
  //                       text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
  //                       titleAttr: 'Excel',
  //                       title: 'รายการข้อมูล'
  //                       },
  //                       {
  //                       extend: 'pdf',
  //                       text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
  //                       titleAttr: 'PDF',
  //                       title: 'รายการข้อมูล',
  //                       customize: function(doc) {
  //                           doc.defaultStyle = {
  //                           font: 'THSarabun'
  //                           };
  //                       }
  //                       }
  //                   ],
  //                   })
    
  // });
</script>

