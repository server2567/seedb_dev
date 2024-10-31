<style>
    .card:first-of-type {
        background-color: transparent; 
    }
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button"  data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
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
                                    <input type="text" class="form-control" name="date" id="date" value="" placeholder="เลือกวันที่บันทึกข้อมูลล่าสุด">
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
                                <label for="" class="form-label ">สถานะ</label><br>
                                <select class="form-select select2" data-placeholder="-- กรุณาเลือกสถานะ --" name="ast_id" id="ast_id">
                                    <option value=""></option>
                                    <?php foreach ($base_statuses as $row) { ?>
                                        <option value="<?php echo $row['ast_id']; ?>"><?php echo $row['ast_name']; ?></option>
                                    <?php } ?>
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

<div class="card"  style="background-color: transparent;">
    <div class="nav nav-tabs d-flex justify-content-start" role="tablist">
        <button class="nav-link w-20 active" id="nav_ams_wait" data-bs-toggle="tab" data-bs-target="#wait_content" type="button" role="tab" aria-controls="wait_content" aria-selected="true"> รอดำเนินการ </button>
        <!-- <button class="nav-link w-20" id="nav_ams_save" data-bs-toggle="tab" data-bs-target="#save_content" type="button" role="tab" aria-controls="save_content" aria-selected="false"> ฉบับร่าง </button> -->
        <button class="nav-link w-20" id="nav_ams_noti" data-bs-toggle="tab" data-bs-target="#noti_content" type="button" role="tab" aria-controls="noti_content" aria-selected="false"> ดำเนินการเสร็จสิ้น </button>
    </div>
    
    <div class="tab-content" id="nav-tabcontent">
        <div class="tab-pane fade active show" id="wait_content" role="tabpanel" aria-labelledby="nav_ams_wait">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button accordion-button-table" type="button">
                                <i class="bi-newspaper icon-menu"></i><span> รอดำเนินการสรุปผลการตรวจจากห้องปฏิบัติการทางการแพทย์ </span><span class="span-date pe-1"> ประจำวันที่ <?php echo formatShortDateThai(date("Y-m-d H:i:s")) ;?></span> <span class="badge bg-success font-14">0 จำนวนผลการตรวจรอดำเนินการ </span>
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <!-- ดึงข้อมูล:
                                1 - ผู้ป่วยที่มาจาก WTS (หลังเลือกแพทย์) ตาราง que_appointment ที่ apm_sta_id = 2
                                2 - ผู้ป่วยที่มาจาก DIM (รอผลตรวจเครื่องมือหัตถการ) ตาราง ams_notification_results ที่ ntr_ast_id = 5
                                3 - ผู้ป่วยที่มาจาก DIM (หลังตรวจเครื่องมือหัตถการ) ตาราง ams_notification_results ที่ ntr_ast_id = 3 -->
                                <table class="table" id="wait-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Visit</th>
                                            <th class="text-center">HN</th>
                                            <th>ชื่อ - นามสกุล ผู้ป่วย</th>
                                            <th>ชื่อแพทย์เจ้าของไข้</th>
                                            <th class="text-center"> วันที่บันทึกข้อมูลล่าสุด </th>
                                            <th>ผู้บันทึกข้อมูล </th>
                                            <th class="text-center">สถานะดำเนินการ</th>
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
        </div>
        <!-- <div class="tab-pane fade" id="save_content" role="tabpanel" aria-labelledby="nav_ams_save">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button accordion-button-table" type="button">
                                <i class="bi-newspaper icon-menu"></i><span> ฉบับร่างผลการตรวจจากห้องปฏิบัติการทางการแพทย์ </span><span class="span-date pe-1"> ประจำวันที่ <?php echo formatShortDateThai(date("Y-m-d H:i:s")) ;?></span> <span class="badge bg-success font-14">0 จำนวนผลการตรวจรอการแจ้งเตือน </span>
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <table class="table" id="save-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Visit</th>
                                            <th class="text-center">HN</th>
                                            <th>ชื่อ - นามสกุล ผู้ป่วย</th>
                                            <th>ชื่อแพทย์เจ้าของไข้</th>
                                            <th class="text-center"> วันที่บันทึกข้อมูลล่าสุด </th>
                                            <th>ผู้บันทึกข้อมูล </th>
                                            <th class="text-center">สถานะดำเนินการ</th>
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
        </div> -->
        <div class="tab-pane fade" id="noti_content" role="tabpanel" aria-labelledby="nav_ams_noti">
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-newspaper icon-menu"></i><span> การแจ้งเตือนผลการตรวจจากห้องปฏิบัติการทางการแพทย์ </span><span class="span-date pe-1"> ประจำวันที่ <?php echo formatShortDateThai(date("Y-m-d H:i:s")) ;?></span> <span class="badge bg-success font-14">0 จำนวนผลการตรวจดำเนินการแจ้งเตือน </span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <table class="table" id="noti-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Visit</th>
                                                <th class="text-center">HN</th>
                                                <th>ชื่อ - นามสกุล ผู้ป่วย</th>
                                                <th>ชื่อแพทย์เจ้าของไข้</th>
                                                <th class="text-center"> วันที่บันทึกข้อมูลล่าสุด </th>
                                                <th>ผู้บันทึกข้อมูล </th>
                                                <th class="text-center">สถานะดำเนินการ</th>
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
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.option .swal-cancel-noti', function () {
        const url = $(this).data('url');
        Swal.fire({
            title: "ยกเลิกการแจ้งเตือน",
            text: "คุณต้องการยกเลิกการแจ้งเตือนหรือไม่",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#dc3545",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        if (data.status_response == "<?php echo $this->config->item('status_response_success'); ?>") {
                            Swal.fire({
                                title: data.header,
                                text: data.body,
                                icon: 'success',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                window.location.href = data.returnUrl;
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong!',
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr);
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while processing your request.',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                });
            }
        });
    });
    $(document).on('click', '.option .swal-do-noti', function () {
        const url = $(this).data('url');
        Swal.fire({
            title: "ดำเนินการแจ้งเตือน",
            text: "คุณต้องการดำเนินการแจ้งเตือนหรือไม่",
            icon: "warning",
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#35cbdc",
            denyButtonColor: "#6c757d",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ดูผลสรุป",
            denyButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        if (data.status_response == "<?php echo $this->config->item('status_response_success'); ?>") {
                            Swal.fire({
                                title: data.header,
                                text: data.body,
                                icon: 'success',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                window.location.href = data.returnUrl;
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong!',
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr);
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while processing your request.',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                const ntr_id = url.split('/').pop(); // Extract ntr_id from the URL
                window.location.href = "<?php echo base_url()?>index.php/ams/Notification_result/update_form/1/" + ntr_id;
            }
        });
    });
    
    flatpickr("#date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        onReady: function(selectedDates, dateStr, instance) {
        },
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
    let noti_table = null;
    $(document).ready(function() {
        url = "<?php echo site_url('ams/Notification_result/get_notis_and_ques'); ?>";
        wait_table = createDataTableServer('#wait-table', url, 1);
        // save_table = createDataTableServer('#save-table', url, 2);
        noti_table = createDataTableServer('#noti-table', url, 3);

        // Initial call to set the interval
        resetInterval();
    });

    function createDataTableServer(selector, url, index = null) {
        if(index)
            search_data_log['tb_index'] = index;
        return $(selector).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": url,
                "type": "POST",
                "data": search_data_log, 
                "data": function(d) {
                    // Merge search parameters with the default DataTable parameters
                    if(index)
                        return $.extend({}, d, search_data_log, { tb_index: index });
                    else
                        return $.extend({}, d, search_data_log);
                },
                "dataSrc": function(json){
                    updateBadgeCount(selector, json.recordsTotal);
                    if(json.badge) updateBadgeText(json.badge);
                    return json.data;
                }
            },
            "columns": [
                { "data": "row_number", "orderable": false },
                { "data": "apm_visit" },
                { "data": "pt_member" },
                { "data": "pt_name" },
                { "data": "ps_name" },
                { "data": "ntr_update_date" },
                { "data": "update_us_name" },
                { "data": "status_text" },
                { "data": "actions" },
            ],
            "order": [['ntr_update_date', 'desc']],
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
                    customize: function (doc) {
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
                setTooltipDefault(); // from main.js
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
        // save_table.ajax.reload(null, false); // false to stay on the current page
        noti_table.ajax.reload(null, false); // false to stay on the current page
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
        const badge = $(tableId).closest('.card').find('.badge.bg-success.font-14');
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
</script>