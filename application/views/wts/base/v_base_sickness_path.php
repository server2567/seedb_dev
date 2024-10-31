<!-- Search Sickness Path Card -->
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
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="rdp_name" class="form-label">ชื่อเส้นทาง</label>
                            <select class="form-select select2" name="rdp_name" id="rdp_name" data-placeholder="-- กรุณาเลือกชื่อเส้นทาง --">
                                <option value=""></option>
                                <?php if (isset($route_name)) { ?>
                                    <?php foreach ($route_name as $item) : ?>
                                        <option value="<?php echo $item->rdp_name ?>"><?php echo $item->rdp_name ?></option> 
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="rdp_stde_id" class="form-label">แผนกการรักษา</label>
                            <select class="form-select select2" name="rdp_stde_id" id="rdp_stde_id" data-placeholder="-- กรุณาเลือกแผนกการรักษา --">
                                <option value=""></option>
                                <?php if (isset($stde)) { ?>
                                    <?php foreach ($stde as $dep) : ?>
                                        <option value="<?php echo $dep->stde_id ?>"><?php echo $dep->stde_name_th ?></option> 
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="rdp_active" class="form-label">สถานะการใช้งาน</label>
                            <select class="form-select select2" name="rdp_active" id="rdp_active" data-placeholder="-- กรุณาเลือกสถานะการใช้งาน --">
                                <option value=""></option>
                                <option value="1">เปิดใช้งาน</option> 
                                <option value="0">ปิดใช้งาน</option> 

                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="button" id="search" class="btn btn-primary float-end" onclick="searchDataTable()">ค้นหา</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sickness Path Table Card -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลเส้นทางการรักษาแต่ละประเภทโรค</span><span class="badge bg-success"><?php echo count($route); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_sickness_path/route_add'"><i class="bi-plus"></i> เพิ่มเส้นทางการรักษา </button>
                    </div>
                    
                    <table class="table" width="100%" id="route_table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">เส้นทางการรักษา</th>
                                <th class="text-center">แผนกการรักษา</th>
                                <th class="text-center">ระยะเวลา</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php foreach ($route as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['rdp_name'] ?></div>
                                    </td>
                                    <td>
                                    <div class="text-center"><?php echo isset($item['stde_name']) ? $item['stde_name'] : 'ค่าเริ่มต้น'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item['sum_time'] . " นาที" ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo  $item['rdp_active'] % 2 != 0 ? "text-success" : "text-danger"; ?>"></i> <?php echo  $item['rdp_active'] % 2 != 0 ? "เปิดการใช้งาน" : "ปิดการใช้งาน"; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_sickness_path/route_edit/<?php echo $item['rdp_id']?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-primary" title="จัดการจุดบริการ" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_sickness_path/route_time_edit/<?php echo $item['rdp_id']?>'"><i class="bi-card-list"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/wts/Base_sickness_path/route_delete/<?php echo $item['rdp_id']?>"><i class="bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?> -->
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
    url = "<?php echo site_url('wts/Base_sickness_path/Route_get_list'); ?>";
    disease_table = createDataTableServer('#route_table', url);

    $('#route_table_filter input').on('keyup change', function() {
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
            { "data": "rdp_id" },
            { "data": "rdp_name" },
            { "data": "stde_name" },
            { "data": "sum_time" },
            { "data": "rdp_active" },
            { "data": "actions" },
        ],
        "order": [['rdp_id', 'desc']],
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