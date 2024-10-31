<!-- Search Sickness Group Card -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                    <i class="bi-search icon-menu"></i><span>ค้นหาข้อมูล</span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 form-search-datatable-server">
                        <div class="col-md-4">
                            <label for="ds_name_disease" class="form-label">ชื่อโรคผู้ป่วย</label>
                            <select class="form-select select2" name="ds_name_disease" id="ds_name_disease" data-placeholder="-- กรุณาเลือกชื่อโรคผู้ป่วย --">
                                <option value=""></option>
                                <?php 
                                    if (isset($disease)) { 
                                        // สร้าง array ชั่วคราวสำหรับเก็บค่า ds_name_disease ที่ไม่ซ้ำกัน
                                        $unique_disease_names = [];
                                        foreach ($disease as $ds_name) {
                                            if (!empty($ds_name['ds_name_disease']) && !in_array($ds_name['ds_name_disease'], $unique_disease_names)) {
                                                $unique_disease_names[] = $ds_name['ds_name_disease'];
                                ?>
                                                <option value="<?php echo $ds_name['ds_name_disease'] ?>"><?php echo $ds_name['ds_name_disease'] ?></option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>                        
                        </div>
                        <div class="col-md-4">
                            <label for="ds_name_disease_type" class="form-label">ประเภทโรค</label>
                            <select class="form-select select2" name="ds_name_disease_type" id="ds_name_disease_type" data-placeholder="-- กรุณาเลือกประเภทโรค --">
                                <option value=""></option>
                                <?php 
                                    if (isset($ds_type)) { 
                                        // สร้าง array ชั่วคราวสำหรับเก็บค่า ds_name_disease ที่ไม่ซ้ำกัน
                                        foreach ($ds_type as $type) {     
                                ?>
                                                <option value="<?php echo $type['ds_name_disease_type'] ?>"><?php echo $type['ds_name_disease_type'] ?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>                        
                        </div>
                        <div class="col-md-4">
                            <label for="ds_stde_id" class="form-label">แผนกการรักษา</label>
                            <select class="form-select select2" name="ds_stde_id" id="ds_stde_id" data-placeholder="-- กรุณาเลือกแผนกการรักษา --">
                                <option value=""></option>
                                <?php if (isset($stde)) { ?>
                                    <?php foreach ($stde as $dep) : ?>
                                        <option value="<?php echo $dep->stde_id ?>"><?php echo $dep->stde_name_th ?></option> 
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="button" id="search" class="btn btn-primary float-end" onclick="searchDataTable()">ค้นหา</button>
                            <!-- <button type="submit" class="btn btn-primary float-end" name="sg_searchBtn">ค้นหา</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Table Sickness Group Table Card -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-heart-pulse-fill icon-menu"></i><span> ข้อมูลประเภทโรคผู้ป่วย</span><span class="badge bg-success"><?php echo count($disease) ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                    <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_disease/disease_add'"><i class="bi-plus"></i> เพิ่มประเภทโรคผู้ป่วย </button>
                    </div>
                    <table class="table" width="100%" id="disease_table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">แผนกการรักษา</th>
                                <th class="text-center">ประเภทโรค</th>
                                <th class="text-center">ชื่อโรค</th>
                                <th class="text-center">วันที่บันทึกข้อมูลล่าสุด</th>
                                <th class="text-center">ผู้บันทึกข้อมูล</th0>
                                <th class="text-center">สถานะการใช้งาน</th>
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
let refreshInterval;
let search_data_log = {};
let disease_table = null;

$(document).ready(function() {
    url = "<?php echo site_url('wts/Base_disease/Disease_get_list'); ?>";
    disease_table = createDataTableServer('#disease_table', url);

    $('#disease_table_filter input').on('keyup change', function() {
        searchDataTable();
    });
    
    resetInterval();
});

function createDataTableServer(selector, url, index = null) {
    return $(selector).DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": url,
            "type": "POST",
            "data": function(d) {
                const searchParams = getSearchParams();
                return $.extend({}, d, searchParams, { tb_index: index });
            },
            "dataSrc": function(json) {
                    updateBadgeCount(selector, json.recordsTotal);
                    if (json.badge) updateBadgeText(json.badge);
                    return json.data; // Ensure it returns an empty array if no data
            }
        },
        "columns": [
            { "data": "ds_id" },
            { "data": "stde_name" },
            { "data": "ds_name_disease_type" },
            { "data": "ds_name_disease" },
            { "data": "ds_update_date" },
            { "data": "user_name" },
            { "data": "ds_active" },
            { "data": "actions" },
        ],
        "order": [['ds_id', 'desc']],
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
    });
}

function searchDataTable() {
    search_data_log = getSearchParams();
    reloadDataTable(); // Just reload, don't reinitialize
    resetInterval();
}

function reloadDataTable() {
        disease_table.ajax.reload(null, false); // Reload without resetting the pagination or reinitializing
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
    const searchInput = document.querySelector('#disease_table_filter input');
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
        const oldText = badge.text().replace(/^\d+/, '').trim();
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
        var config = button.inst.s.buttons[buttonIdx].conf;
        var columns = [0, 1, 2, 3, 4, 5, 6];

        if (config.titleAttr == "Print") {
            config.exportOptions = {
                columns: columns
            };
            config.title = '<h3 class="font-weight-600 text-center">' + title + '</h3>';
        }
        if (config.titleAttr == "Excel") {
            config.exportOptions = {
                columns: columns
            };
            config.title = title;
        }
        if (config.titleAttr == "PDF") {
            config.exportOptions = {
                columns: columns
            };
            config.title = title;
            config.customize = function(doc) {
                doc.defaultStyle = {
                    font: 'THSarabun'
                };
                doc.content[1].table.widths = ['10%', '15%', '20%', '20%', '15%', '10%', '10%'];
            };
        }
    });
}
</script>