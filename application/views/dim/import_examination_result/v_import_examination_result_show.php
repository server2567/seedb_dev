<!-- Search -->
<div class="card">
  <div class="accordion">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
          <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูล</span><span class="badge bg-success"></span>
        </button>
      </h2>
      <div id="collapseCard" class="accordion-collapse collapse">
        <div class="accordion-body">
          <form class="form-search-datatable-server">
            <div class="row">
              <div class="col-md-4">
                <label for="date" class="form-label ">วัน/เดือน/ปี ที่ดำเนินการ</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="date" id="date" value="" placeholder="วว/ดด/ปป">
                  <span class="input-group-text btn btn-secondary" onclick="$('#date').val(null);" title="clear" data-clear><i class="bi-x"></i></span>
                </div>
              </div>
              <div class="col-md-4">
                <label for="" class="form-label ">ประจำเดือน</label><br>
                <select class="form-select select2" data-placeholder="-- กรุณาเลือกเดือน --" name="month" id="month">
                  <option value=""></option>
                  <?php foreach ($months as $row) { ?>
                    <option value="<?php echo $row['index']; ?>"><?php echo $row['name_th']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="rm_id" class="form-label">ห้องปฏิบัติการ</label>
                <select class="form-select select2" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="rm_id" id="rm_id">
                  <option value=""></option>
                  <?php foreach ($rooms as $row) {
                    $selected = decrypt_id($row['rm_id']) == decrypt_id($eqs_rm_id) ? 'selected' : '';
                  ?>
                    <option value="<?php echo $row['rm_id']; ?>" <?php echo $selected; ?>><?php echo $row['rm_name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="eqs_id" class="form-label">เครื่องมือหัตถการ</label>
                <select class="form-select select2" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="eqs_id" id="eqs_id" disabled>
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="date" class="form-label ">HN</label>
                <input type="number" class="form-control" name="pt_member" id="pt_member" placeholder="HN">
              </div>
              <div class="col-md-4">
                <label for="date" class="form-label ">ชื่อ - นามสกุล ผู้ป่วย</label>
                <input type="text" class="form-control" name="pt_name" id="pt_name" placeholder="ชื่อ - นามสกุล ผู้ป่วย">
              </div>
              <div class="col-md-12">
                <button type="button" id="search" class="btn btn-primary float-end" onclick="searchDataTable()"><i class="bi-search icon-menu"></i>&nbsp;ค้นหา&emsp;</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Table -->
<div class="card" style="background-color: transparent;">
  <div class="nav nav-tabs d-flex justify-content-start" role="tablist">
    <button class="nav-link w-20 active" id="nav_waiting" data-bs-toggle="tab" data-bs-target="#waiting_content" type="button" role="tab" aria-controls="waiting_content" aria-selected="true"> รอดำเนินการ </button>
    <button class="nav-link w-20" id="nav_complete" data-bs-toggle="tab" data-bs-target="#complete_content" type="button" role="tab" aria-controls="complete_content" aria-selected="false"> ดำเนินการเสร็จสิ้น </button>
  </div>
  <div class="tab-content" id="nav-tabcontent">
    <div class="tab-pane fade active show" id="waiting_content" role="tabpanel" aria-labelledby="nav_waiting">
      <div class="row">
        <div class="accordion">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button accordion-button-table" type="button">
                <i class="bi-clipboard-plus icon-menu"></i><span> รายการผลตรวจจากเครื่องมือหัตถการ </span><span class="span-date pe-1"> ประจำวันที่ <?php echo formatShortDateThai(date("Y-m-d H:i:s")); ?></span> <span class="badge bg-success font-14">0 จำนวนผลการตรวจรอดำเนินการ </span>
              </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <table class="table" id="wait-table" width="100%">
                  <thead>
                    <tr>
                      <th class="text-center" width="5%">Visit</th>
                      <th class="text-center" width="5%">หมายเลขคิว</th>
                      <th class="text-center" width="5%">HN</th>
                      <th width="15%">ชื่อ-นามสกุลผู้ป่วย</th>
                      <th width="15%">ชื่อแพทย์เจ้าของไข้</th>
                      <th width="15%">หน่วยงาน/แผนก</th>
                      <th class="text-center" width="10%">วัน-เวลาที่ส่งตรวจ</th> <!-- moved here -->
                      <th width="10%">ห้อง/เครื่องมือหัตถการ</th>
                      <th class="text-center" width="10%">สถานะ</th>
                      <th class="text-center" width="10%">ดำเนินการ</th>
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
    <div class="tab-pane fade" id="complete_content" role="tabpanel" aria-labelledby="nav_complete">
      <div class="row">
        <div class="accordion">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button accordion-button-table" type="button">
                <i class="bi-clipboard-plus icon-menu"></i><span> รายการผลตรวจเครื่องมือหัตถการ </span><span class="span-date pe-1"> ประจำวันที่ <?php echo formatShortDateThai(date("Y-m-d H:i:s")); ?></span> <span class="badge bg-success font-14">0 จำนวนผลการตรวจที่ดำเนินการเสร็จสิ้น </span>
              </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <table class="table" id="complete-table" width="100%">
                  <thead>
                    <tr>
                      <th class="text-center" width="5%">Visit</th>
                      <th class="text-center" width="5%">หมายเลขคิว</th>
                      <th class="text-center" width="5%">HN</th>
                      <th width="15%">ชื่อ-นามสกุลผู้ป่วย</th>
                      <th width="15%">ชื่อแพทย์เจ้าของไข้</th>
                      <th width="15%">หน่วยงาน/แผนก</th>
                      <th class="text-center" width="10%">วัน-เวลาที่ส่งตรวจ</th> <!-- moved here -->
                      <th width="10%">ห้อง/เครื่องมือหัตถการ</th>
                      <th class="text-center" width="10%">สถานะ</th>
                      <th class="text-center" width="10%">ดำเนินการ</th>
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
</div>

<script>
  let eqs_rm_id_session = '<?php echo $eqs_rm_id; ?>';

  $(document).ready(function() {
    if (is_null(eqs_rm_id_session)) {
      let html = `<select class="form-select select2" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="eqs_rm_id" id="eqs_rm_id">
                <option value=""></option>
                <?php foreach ($rooms as $row) { ?>
                    <option value="<?php echo $row['rm_id']; ?>"><?php echo $row['rm_name']; ?></option>
                <?php } ?>
            </select>`
      let url = "<?php echo base_url() ?>index.php/dim/Import_examination_result/Import_examination_result_set_eqs_rm_id"
      Swal.fire({
        title: "กรุณาเลือกห้องปฏิบัติการที่กำลังประจำการ",
        html: html,
        icon: "warning",
        confirmButtonColor: "#198754",
        confirmButtonText: "ยืนยัน",
        allowOutsideClick: false,
        preConfirm: () => {
          const selectedId = document.getElementById('eqs_rm_id').value;
          return selectedId ? selectedId : Swal.showValidationMessage('-- กรุณาเลือกห้องปฏิบัติการ --');
        },
        didOpen: () => {
          $('#eqs_rm_id').select2({
            dropdownParent: $('.swal2-popup')
          });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
              eqs_rm_id: result.value
            },
            success: function(data) {
              if (data.data.status_response == status_response_success) {
                window.location.reload();
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
    } else {
      search_data_log = getSearchParams();
      set_select_eqs_id();
    }

    $('#rm_id').on('change', function() {
      set_select_eqs_id();
    });
  });

  function set_select_eqs_id() {
    clear_select_eqs_id();
    let url = "<?php echo base_url() ?>index.php/dim/Import_examination_result/Import_examination_result_get_equipments"
    get_select_onchange("rm_id", "eqs_id", url);
  }

  function clear_select_eqs_id() {
    if (!$('#eqs_id').prop('disabled')) $('#eqs_id').val(null).trigger('change');
  }

  function get_select_onchange(select2Id, targetId, url) {
    let select2Value = $('#' + select2Id).val();
    let target = $('#' + targetId);

    let data = {};
    data[select2Id] = select2Value;

    if (!is_null(select2Value)) {
      $.post(url, data)
        .done(function(responseData) {
          target.empty();
          target.prop('disabled', false);
          target.html(responseData);
        })
        .fail(function() {
          console.error("Error occurred");
        })
        .always(function() {
          // Optional: Code to execute always after request finishes
        });
    } else {
      target.val(null);
      target.prop('disabled', true);
    }

  }

  flatpickr("#date", {
    dateFormat: 'd/m/Y',
    locale: 'th',
    onReady: function(selectedDates, dateStr, instance) {},
    onOpen: function(selectedDates, dateStr, instance) {
      convertYearsToThai();
    },
    onValueUpdate: function(selectedDates, dateStr, instance) {
      convertYearsToThai();
      if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
        document.getElementById('date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
      } else {
        document.getElementById('date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
      }
    },
    onMonthChange: function(selectedDates, dateStr, instance) {
      convertYearsToThai();
    },
    onYearChange: function(selectedDates, dateStr, instance) {
      convertYearsToThai();
    }
  });

  // datatable server side
  let refreshInterval;
  let search_data_log = {};
  let wait_table = null;
  let save_table = null;
  $(document).ready(function() {
    url = "<?php echo site_url('dim/Import_examination_result/Import_examination_result_get_list'); ?>";
    wait_table = createDataTableServer('#wait-table', url, 1);
    save_table = createDataTableServer('#complete-table', url, 2);

    // เพิ่มฟังก์ชันในการผสานเซลล์
    save_table.on('draw', function() {
      mergeCells('#complete-table');
    });

    wait_table.on('draw', function() {
      mergeCells('#complete-table');
    });
    configExport(wait_table, "รายการผลตรวจ (ยังไม่ได้ทำการตรวจ)");
    configExport(save_table, "รายการผลตรวจ");

    // Event listener for the search box
    $('#complete-table_filter input').on('keyup change', function() {
        searchDataTable();
    });
    
    // Initial call to set the interval
    resetInterval();

    
  });

  function createDataTableServer(selector, url, index = null) {
    if (index) {
        search_data_log['tb_index'] = index;
    }
    return $(selector).DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": url,
            "type": "POST",
            "data": function(d) {
                // Merge search parameters with the default DataTable parameters
                const searchParams = getSearchParams();
                return $.extend({}, d, searchParams, { tb_index: index });
            },
            "dataSrc": function(json) {
                updateBadgeCount(selector, json.recordsTotal);
                if (json.badge) updateBadgeText(json.badge);
                return json.data;
            }
        },
        "columns": [
            { "data": "apm_visit" },
            { "data": "apm_ql_code" },
            { "data": "pt_member" },
            { "data": "pt_full_name" },
            { "data": "ps_full_name" },
            { "data": "dp_stde_name_th" },
            { "data": "exr_inspection_time", "orderable": false },
            { "data": "rm_eqs_name" },
            { "data": "status_text" },
            { "data": "actions" },
        ],
        "order": [['exr_inspection_time', 'desc']],
        "language": {
            "decimal": "",
            "emptyTable": "ไม่มีรายการในระบบ",
            "info": "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoEmpty": "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "lengthMenu": "_MENU_",
            "loadingRecords": "Loading...",
            "processing": "",
            "search": "",
            "searchPlaceholder": 'ค้นหา...',
            "zeroRecords": "ไม่พบรายการ",
            "paginate": {
                "first": "«",
                "last": "»",
                "next": "›",
                "previous": "‹"
            },
            "aria": {
                "orderable": "Order by this column",
                "orderableReverse": "Reverse order this column"
            },
        },
        "dom": 'lBfrtip',
        "buttons": [
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
                customize: function(doc) {
                    doc.defaultStyle = { font: 'THSarabun' };
                }
            }
        ],
        "initComplete": function() {
            var api = this.api();
            api.on('draw', function() {
                if (api.rows({ filter: 'applied' }).data().length === 0) {
                    $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
                }
            });
        },
        "drawCallback": function(settings) {
            // setTooltipDefault(); // from main.js
            mergeCells(selector); // เรียก mergeCells เมื่อทำการวาดตาราง
        }
    });
  }

  // old solution
  // function mergeCells(selector) {
  //   const table = $(selector).DataTable();
  //   const mergeByIndex = 4; // Index of the column to merge by (วันที่ส่งตรวจ)
  //   const columnsToMerge = [0, 1, 2, 3, 4]; // Column indexes to merge

  //   let lastMergeValue = null;
  //   let lastMergeCells = {};
  //   let rowspan = {};

  //   table.rows({
  //     page: 'current'
  //   }).nodes().each(function(row, i) {
  //     const fullDateText = $(table.cell(row, mergeByIndex).node()).text();
  //     const mergeValue = fullDateText.split(' ')[0]; // Extract date part only

  //     if (mergeValue === lastMergeValue) {
  //       columnsToMerge.forEach(colIdx => {
  //         if (!rowspan[colIdx]) {
  //           rowspan[colIdx] = 1;
  //         }
  //         rowspan[colIdx]++;
  //         $(table.cell(row, colIdx).node()).hide();
  //         $(table.cell(lastMergeCells[colIdx]).node()).attr('rowspan', rowspan[colIdx]);
  //       });
  //     } else {
  //       lastMergeValue = mergeValue;
  //       lastMergeCells = {};
  //       columnsToMerge.forEach(colIdx => {
  //         lastMergeCells[colIdx] = table.cell(row, colIdx).node();
  //         rowspan[colIdx] = 1;
  //       });
  //     }
  //   });
  // }

  function mergeCells(selector) {
    const table = $(selector).DataTable();
    const mergeByIndex = 4; // Index of the column to merge by (วันที่ส่งตรวจ)
    const columnsToMerge = [0, 1, 2, 3, 4, 5]; // Column indexes to merge
    const columnsToCheck = [0, 1, 2, 3, 4]; // Column indexes to check for differences

    let lastMergeValues = []; // Array to store last row's values for columns to check
    let lastMergeCells = {};
    let rowspan = {};

    table.rows({ page: 'current' }).nodes().each(function(row, i) {
        const currentRowValues = columnsToMerge.map(colIdx => $(table.cell(row, colIdx).node()).text());
        const checkRowValues = columnsToCheck.map(colIdx => $(table.cell(row, colIdx).node()).text());

        // Check if any of the columns 0 - 3 values are different
        const isDifferent = lastMergeValues.length === 0 || columnsToCheck.some((colIdx, index) => {
            return checkRowValues[index] !== lastMergeValues[index];
        });

        if (!isDifferent) {
            columnsToMerge.forEach(colIdx => {
                if (!rowspan[colIdx]) {
                    rowspan[colIdx] = 1;
                }
                rowspan[colIdx]++;
                $(table.cell(row, colIdx).node()).hide();
                $(table.cell(lastMergeCells[colIdx]).node()).attr('rowspan', rowspan[colIdx]);
            });
        } else {
            lastMergeValues = checkRowValues;
            lastMergeCells = {};
            columnsToMerge.forEach(colIdx => {
                lastMergeCells[colIdx] = table.cell(row, colIdx).node();
                rowspan[colIdx] = 1;
            });
        }
    });
}



  function searchDataTable() {
    search_data_log = getSearchParams();
    reloadDataTable();
    resetInterval(); // Reset the interval whenever searchDataTable is called
  }

  function reloadDataTable() {
    wait_table.ajax.reload(null, false); // false to stay on the current page
    save_table.ajax.reload(null, false); // false to stay on the current page
  }

  function getSearchParams() {
    const forms = document.getElementsByClassName("form-search-datatable-server");
    const searchParams = {};

    for (let j = 0; j < forms.length; j++) {
        const form = forms[j];
        const inputs = form.querySelectorAll('input[name], select[name]'); // Select both input and select elements with name attributes

        inputs.forEach(input => {
            searchParams[input.name] = input.value;
        });
    }
    
    // ดึงค่าจากฟิลด์ค้นหาหลักของ DataTable
    const searchInput = document.querySelector('#complete-table_filter input');
    if (searchInput) {
        searchParams['search'] = searchInput.value;
    }

    return searchParams;
}

  function resetInterval() {
    if (refreshInterval) {
      clearInterval(refreshInterval);
    }
    refreshInterval = setInterval(function() {
      reloadDataTable();
    }, datatable_second_reload);
  }

  function updateBadgeCount(tableId, count) {
    const badge = $(tableId).closest('.accordion-collapse').prev('.accordion-header').find('.badge.bg-success.font-14').first();
    if (badge.length) {
      const oldText = badge.text().replace(/^\d+/, '').trim(); // Remove old count, keep remaining text
      badge.html(`${count} ${oldText}`);
    }
  }

  function updateBadgeText(text) {
    const badges = document.querySelectorAll('.span-date');
    badges.forEach(badge => {
      badge.innerHTML = `${text}`;
    });
  }

  function configExport(dataTable, title) {
    var buttons = dataTable.buttons();

    buttons.each(function(button, buttonIdx) {
      // get config
      var config = button.inst.s.buttons[buttonIdx].conf;
      // specify some config
      var columns = [0, 1, 2, 3, 4, 5, 6]; // specify columns to export

      if (config.titleAttr == "Print") { // if need setting file Print
        config.exportOptions = {
          columns: columns
        };
        config.title = '<h3 class="font-weight-600 text-center">' + title + '</h3>';
        // $("." + config.className).html("Print"); // specify text and style of button
      }
      if (config.titleAttr == "Excel") { // if need setting file Excel
        config.exportOptions = {
          columns: columns
        };
        config.title = title;
        // $("." + config.className).html("Excel"); // specify text and style of button
      }
      if (config.titleAttr == "PDF") { // if need setting file PDF
        config.exportOptions = {
          columns: columns
        };
        config.title = title;
        config.customize = function(doc) {
          doc.defaultStyle = {
            font: 'THSarabun'
          };
          doc.content[1].table.widths = ['10%', '15%', '20%', '20%', '15%', '10%', '10%'];
          // doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto'];
        };
        // $("." + config.className).html("PDF"); // specify text and style of button
      }
    });
  }
</script>