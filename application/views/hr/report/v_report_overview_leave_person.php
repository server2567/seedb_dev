<style>
    /* ปรับขนาดฟอนต์ในส่วนหัวตาราง (thead) */
    #person_info_list thead th {
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        /* Center align headers */
    }



    /* ปรับขนาดฟอนต์ในส่วนข้อมูลตาราง (tbody) */
    #person_info_list tbody td {
        font-size: 16px;
        /* ปรับขนาดฟอนต์ในข้อมูล */
    }

    #person_info_list {
        /* Helps with consistent column widths */
        width: 100%;
        /* Full width */
    }

    /* Ensure header and cells align properly */
    #person_info_list th,
    #person_info_list td {
        overflow: hidden;
        /* Prevent overflow */
        text-overflow: ellipsis;
        /* Show ellipsis for overflowed text */
        white-space: nowrap;
        /* Prevent wrapping */
    }

    /* บังคับให้ header และ body ของ DataTable สอดคล้องกัน */
    .dataTables_scrollHeadInner,
    .dataTables_scrollBody {
        width: 100% !important;
    }

    .dataTables_scrollBody {
        overflow-y: auto;
    }

    .dataTables_scrollBody table {
        margin: 0 auto;
    }

    .dataTables_scrollHeadInner table {
        width: 100% !important;
        margin: 0 auto;
    }

    #person_info_list tbody tr {
        cursor: pointer;
    }


    /* เพิ่มเอฟเฟกต์สีพื้นหลังเมื่อ hover บนแถว */
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-door-open icon-menu"></i><span> ตารางรายงานวันลาบุคลากร ประจำปี </span>
                    <select class="form-select" id="filter_year" onchange="filter_report()" style="width: 20%;">
                        <?php $year = date("Y") + 543; ?>
                        <?php for ($i = 0; $i < 5; $i++) { ?>
                            <option value="<?= $year - $i ?>"><?= $year - $i ?></option>
                        <?php } ?>
                    </select>
                    <span class="btn btn-primary btn-sm p-0 m-1"><label class="text-warning required">&nbsp; ถ้าตารางรายงานแสดงผลไม่ถูกต้องให้ทำการ Refresh หน้าจอ</label></span>
                </button>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="text-center mb-2">
                        <span class="font-18">
                            <b> รายงานการลาของบุคลากร</b> ประจำปี <span class="year"></span> (1 มกราคม พ.ศ. <span class="year"></span> - 31 ธันวาคม พ.ศ. <span class="year"></span>) <br>
                            <b>ชื่อ</b> <?= $person->pf_name . ' ' . $person->ps_fname . ' ' . $person->ps_lname ?> <b>หน่วยงาน </b> <?= $person_position->dp_name_th ?> <b> ตำแหน่งปฏิบัติงาน </b> <?= $person_position->alp_name ?>
                        </span>
                    </div>
                    <div id="overflow">
                        <table class="table table-striped table-bordered" id="person_info_list" width="auto">
                            <thead>
                                <tr>

                                    <th rowspan="2" class="text-center" style="background-color: #0076ab; color: white;">#</th>
                                    <th rowspan="2" width="29%" class="text-center" style="background-color: #0076ab; color: white;">วัน เดือน ปี ที่ลา</th>
                                    <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">ลาป่วย</th>
                                    <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">ลาวันหยุดตามประเพณี</th>
                                    <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">ลาวันหยุดพักผ่อน</th>
                                    <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">ลากิจได้รับค่าจ้าง</th>
                                    <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">ลากิจไม่รับค่าจ้าง</th>
                                    <th colspan="3" class="text-center" style="background-color: #0076ab; color: white;">ลาคลอดบุตร</th>
                                </tr>
                                <tr>
                                    <th>วัน</th>
                                    <th>ชั่วโมง</th>
                                    <th>นาที</th>
                                    <th>วัน</th>
                                    <th>ชั่วโมง</th>
                                    <th>นาที</th>
                                    <th>วัน</th>
                                    <th>ชั่วโมง</th>
                                    <th>นาที</th>
                                    <th>วัน</th>
                                    <th>ชั่วโมง</th>
                                    <th>นาที</th>
                                    <th>วัน</th>
                                    <th>ชั่วโมง</th>
                                    <th>นาที</th>
                                    <th>วัน</th>
                                    <th>ชั่วโมง</th>
                                    <th>นาที</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align:right">รวม:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade modal-lg" id="infoModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body">
                <!-- เนื้อหาจะแสดงที่นี่ -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        initializeDataTableTimeworkPreview();

        function formatDateTH(dateString) {
            // แปลงวันที่จากสตริงเป็น Date object
            const date = new Date(dateString);

            // ตรวจสอบว่าวันที่ถูกต้องหรือไม่
            if (isNaN(date)) return 'วันที่ไม่ถูกต้อง';

            // ชื่อเดือนภาษาไทย
            const thaiMonths = [
                "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ];

            // ดึงค่า วัน เดือน ปี
            const day = date.getDate();
            const month = thaiMonths[date.getMonth()];
            const year = date.getFullYear() + 543; // แปลงเป็นปีพุทธศักราช

            // คืนค่ารูปแบบที่ต้องการ
            return `${day} ${month} ${year}`;
        }
        $('#person_info_list tbody').on('click', 'tr', function() {
            var table = $('#person_info_list').DataTable();
            var rowData = table.row(this).data(); // Get data of the clicked row
            if (rowData) {
                // Populate modal fields with row data
                var dataId = $(rowData.leave_date).attr('data-id');
                $.ajax({
                    url: '<?php echo site_url($controller_dir . "get_overview_leave_detail"); ?>',
                    type: 'POST',
                    data: {
                        leave_id: dataId
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        var tabelContent = `
                         <span class="font-16 text-center mb-3">
                            <b> การลาของบุคลากร</b> ระหว่าง ${rowData.leave_date} <br>
                        </span>
                        <button class="dt-button btn btn-success mb-2 mt-2" onclick="export_excel_leave_detail_person(${dataId})"><i class="bi bi-file-earmark-excel"></i>Excel</button>
                        <table class="table table-bordered"> 
                          <thead> 
                              <tr>
                             <th class="text-center" style="background-color:#0076ab;color:white" rowspan="2">#</th>
                                 <th class="text-center" style="background-color:#0076ab;color:white" rowspan="2">วันที่</th>
                                 <th class="text-center" style="background-color:#0076ab;color:white" colspan="3">${data[0].leave_name}</th>
                              </tr>
                              <tr>
                                 <th class="text-center" style="color:#012970">ชั่วโมง</th>
                                 <th class="text-center" style="color:#012970">นาที</th>
                              </tr>
                          </thead>
                          <tbody>

                        `;
                        let index = 1;
                        data.forEach(element => {
                            tabelContent += '<tr>'
                            tabelContent += `<td class="text-center">${index++}</td>`
                            tabelContent += `<td class="text-center">${formatDateTH(element.lhde_date)+(element.clnd_name != null ? '<br>('+element.clnd_name+') '+(element.clnd_start_date != element.clnd_end_date?formatDateRange(element.clnd_start_date,element.clnd_end_date):formatDateTH(element.clnd_start_date)):'') }</td>`
                            tabelContent += `<td class="text-center">${element.lhde_num_hour}</td>`
                            tabelContent += `<td class="text-center">${element.lhde_num_minute}</td>`
                            tabelContent += '<tr>'
                        });
                        tabelContent += '</tbdoy></table>';
                        $('#modal-title').text('รายงานรายละเอียดวันลา');
                        $('#modal-body').html(tabelContent);
                        // let options = data.map(item => {
                        //     return {
                        //         id: item.stde_id, // หรือใช้ item.id ถ้า key คือ id
                        //         text: item.stde_name_th // หรือใช้ item.name ถ้า key คือ name
                        //     };
                        // });
                        // $('#inputName').select2({
                        //     theme: 'bootstrap-5',
                        //     dropdownParent: $('#editModal'),
                        //     allowClear: true,
                        //     default: stde,
                        //     data: options
                        // });
                        // if (stde) {
                        //     $('#inputName').val(stde).trigger('change');
                        // }
                    },
                    error: function(xhr, error, thrown) {
                        console.error("AJAX Error: ", xhr.responseText);
                    }
                })

                // Show the modal
                $('#infoModal').modal('show');
            }
        });
    });

    function initializeDataTableTimeworkPreview() {
        $('.year').text($('#filter_year').val());
        if ($.fn.DataTable.isDataTable('#person_info_list')) {
            $('#person_info_list').DataTable().destroy();
        }
        $('#person_info_list').on('init.dt', function(e, settings, json) {
            console.log('DataTable initialized', settings);
        });
        $('#person_info_list').DataTable({
            scrollX: false, // เปิดใช้งานการเลื่อนแนวนอน
            scrollY: 500, // กำหนดความสูงของการเลื่อนแนวตั้ง
            scrollCollapse: true, // ลดขนาดความสูงตารางหากข้อมูลไม่เต็ม
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: '<?php echo site_url($controller_dir . "get_overview_leave_summary_person"); ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_year = $('#filter_year').val();
                    d.ps_id = <?= $ps_id ?>;
                    d.dp_id = <?= $dp_id ?>;
                },
                timeout: 500,
                error: function(xhr, error, thrown) {
                    console.error("AJAX Error: ", xhr.responseText);
                },
                dataSrc: function(json) {
                    // อัปเดตค่าใน tfoot
                    var footer = json.footer;

                    $('#person_info_list tfoot th').eq(2).html(footer.lsum_one_per_day);
                    $('#person_info_list tfoot th').eq(3).html(footer.lsum_one_per_hour);
                    $('#person_info_list tfoot th').eq(4).html(footer.lsum_one_per_minute);
                    $('#person_info_list tfoot th').eq(5).html(footer.lsum_two_per_day);
                    $('#person_info_list tfoot th').eq(6).html(footer.lsum_two_per_hour);
                    $('#person_info_list tfoot th').eq(7).html(footer.lsum_two_per_minute);
                    $('#person_info_list tfoot th').eq(8).html(footer.lsum_three_per_day);
                    $('#person_info_list tfoot th').eq(9).html(footer.lsum_three_per_hour);
                    $('#person_info_list tfoot th').eq(10).html(footer.lsum_three_per_minute);
                    $('#person_info_list tfoot th').eq(11).html(footer.lsum_four_per_day);
                    $('#person_info_list tfoot th').eq(12).html(footer.lsum_four_per_hour);
                    $('#person_info_list tfoot th').eq(13).html(footer.lsum_four_per_minute);
                    $('#person_info_list tfoot th').eq(14).html(footer.lsum_five_per_minute);
                    $('#person_info_list tfoot th').eq(15).html(footer.lsum_five_per_minute);
                    $('#person_info_list tfoot th').eq(16).html(footer.lsum_five_per_minute);
                    $('#person_info_list tfoot th').eq(17).html(footer.lsum_six_per_minute);
                    $('#person_info_list tfoot th').eq(18).html(footer.lsum_six_per_minute);
                    $('#person_info_list tfoot th').eq(19).html(footer.lsum_six_per_minute);
                    // ทำซ้ำสำหรับคอลัมน์ที่เหลือ
                    return json.data;
                },
            },
            columns: [{
                    data: 'sequence',
                    className: 'text-center'
                },
                {
                    data: 'leave_date',
                    className: 'text-start',
                    render: function(data, type, row) {
                        // เพิ่มสไตล์แบบ inline
                        return `<span style="color: #007bff;">${data}</span>`;
                    }
                },
                {
                    data: 'lsum_one_per_day',
                    className: 'text-center'
                },
                {
                    data: 'lsum_one_per_hour',
                    className: 'text-center'
                },
                {
                    data: 'lsum_one_per_minute',
                    className: 'text-center'
                },
                {
                    data: 'lsum_two_per_day',
                    className: 'text-center'
                },
                {
                    data: 'lsum_two_per_hour',
                    className: 'text-center'
                },
                {
                    data: 'lsum_two_per_minute',
                    className: 'text-center'
                },
                {
                    data: 'lsum_three_per_day',
                    className: 'text-center'
                },
                {
                    data: 'lsum_three_per_hour',
                    className: 'text-center'
                },
                {
                    data: 'lsum_three_per_minute',
                    className: 'text-center'
                },
                {
                    data: 'lsum_four_per_day',
                    className: 'text-center'
                },
                {
                    data: 'lsum_four_per_hour',
                    className: 'text-center'
                },
                {
                    data: 'lsum_four_per_minute',
                    className: 'text-center'
                },
                {
                    data: 'lsum_five_per_day',
                    className: 'text-center'
                },
                {
                    data: 'lsum_five_per_hour',
                    className: 'text-center'
                },
                {
                    data: 'lsum_five_per_minute',
                    className: 'text-center'
                },
                {
                    data: 'lsum_six_per_day',
                    className: 'text-center'
                },
                {
                    data: 'lsum_six_per_hour',
                    className: 'text-center'
                },
                {
                    data: 'lsum_six_per_minute',
                    className: 'text-center'
                }
                // เพิ่มคอลัมน์ที่เหลือทั้งหมดตามที่คุณกำหนด
            ],

            dom: 'Brti',
            buttons: [{
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success',
                action: function(e, dt, node, config) {
                    export_excel_leave_person(); // ฟังก์ชันส่งออก Excel
                }
            }],
            initComplete: function(settings, json) {
                $('#person_info_list').DataTable().columns.adjust(); // ปรับขนาดคอลัมน์เมื่อโหลดเสร็จ
            },
            drawCallback: function(settings) {
                $('#person_info_list').DataTable().columns.adjust(); // ปรับขนาดเมื่อวาดใหม่
            },
            language: {
                emptyTable: "ไม่พบข้อมูลในตาราง",
                info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                infoEmpty: "ไม่มีข้อมูลที่จะแสดง",
                zeroRecords: "ไม่พบรายการที่ตรงกับคำค้นหา",
                loadingRecords: "กำลังโหลด...",
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ถัดไป",
                    previous: "ก่อนหน้า"
                },
                search: "ค้นหา:",
                searchPlaceholder: "กรอกคำค้น..."
            },
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();
                var json = api.ajax.json();
                if (json && json.footer) {
                    var footer = json.footer;

                    $(api.column(2).footer()).html(footer.lsum_one_per_day);
                    $(api.column(3).footer()).html(footer.lsum_one_per_hour);
                    $(api.column(4).footer()).html(footer.lsum_one_per_minute);
                    $(api.column(5).footer()).html(footer.lsum_two_per_day);
                    $(api.column(6).footer()).html(footer.lsum_two_per_hour);
                    $(api.column(7).footer()).html(footer.lsum_two_per_minute);
                    $(api.column(8).footer()).html(footer.lsum_three_per_day);
                    $(api.column(9).footer()).html(footer.lsum_three_per_hour);
                    $(api.column(10).footer()).html(footer.lsum_three_per_minute);
                    $(api.column(11).footer()).html(footer.lsum_four_per_day);
                    $(api.column(12).footer()).html(footer.lsum_four_per_hour);
                    $(api.column(13).footer()).html(footer.lsum_four_per_minute);
                    $(api.column(14).footer()).html(footer.lsum_five_per_day);
                    $(api.column(15).footer()).html(footer.lsum_five_per_hour);
                    $(api.column(16).footer()).html(footer.lsum_five_per_minute);
                    $(api.column(17).footer()).html(footer.lsum_six_per_day);
                    $(api.column(18).footer()).html(footer.lsum_six_per_hour);
                    $(api.column(19).footer()).html(footer.lsum_six_per_minute);
                    // ทำซ้ำสำหรับคอลัมน์ที่เหลือ
                }
                // คำนวณผลรวมจาก data ที่แสดง
                // var total_days_one = 0;
                // var total_hours_one = 0;
                // var total_minutes_one = 0;
                // var total_days_two = 0;
                // var total_hours_two = 0;
                // var total_minutes_two = 0;
                // var total_days_three = 0;
                // var total_hours_three = 0;
                // var total_minutes_three = 0;
                // var total_days_four = 0;
                // var total_hours_four = 0;
                // var total_minutes_four = 0;
                // var total_days_five = 0;
                // var total_hours_five = 0;
                // var total_minutes_five = 0;
                // var total_days_six = 0;
                // var total_hours_six = 0;
                // var total_minutes_six = 0;
                // data.forEach(function(row) {
                //     total_days_one += parseInt(row.lsum_one_per_day) || 0;
                //     total_hours_one += parseInt(row.lsum_one_per_hour) || 0;
                //     total_minutes_one += parseInt(row.lsum_one_per_minute) || 0;
                //     total_days_two += parseInt(row.lsum_two_per_day) || 0;
                //     total_hours_two += parseInt(row.lsum_two_per_hour) || 0;
                //     total_minutes_two += parseInt(row.lsum_two_per_minute) || 0;
                //     total_days_three += parseInt(row.lsum_three_per_day) || 0;
                //     total_hours_three += parseInt(row.lsum_three_per_hour) || 0;
                //     total_minutes_three += parseInt(row.lsum_three_per_minute) || 0;
                //     total_days_four += parseInt(row.lsum_four_per_day) || 0;
                //     total_hours_four += parseInt(row.lsum_four_per_hour) || 0;
                //     total_minutes_four += parseInt(row.lsum_four_per_minute) || 0;
                //     total_days_five += parseInt(row.lsum_five_per_day) || 0;
                //     total_hours_five += parseInt(row.lsum_five_per_hour) || 0;
                //     total_minutes_five += parseInt(row.lsum_five_per_minute) || 0;
                //     total_days_six += parseInt(row.lsum_six_per_day) || 0;
                //     total_hours_six += parseInt(row.lsum_six_per_hour) || 0;
                //     total_minutes_six += parseInt(row.lsum_six_per_minute) || 0;
                // });

                // // อัปเดต footer
                // $(api.column(2).footer()).html(total_days_one);
                // $(api.column(3).footer()).html(total_hours_one);
                // $(api.column(4).footer()).html(total_minutes_one);
                // $(api.column(5).footer()).html(total_days_two);
                // $(api.column(6).footer()).html(total_hours_two);
                // $(api.column(7).footer()).html(total_minutes_two);
                // $(api.column(8).footer()).html(total_days_three);
                // $(api.column(9).footer()).html(total_hours_three);
                // $(api.column(10).footer()).html(total_minutes_three);
                // $(api.column(11).footer()).html(total_days_four);
                // $(api.column(12).footer()).html(total_hours_four);
                // $(api.column(13).footer()).html(total_minutes_four);
                // $(api.column(14).footer()).html(total_days_five);
                // $(api.column(15).footer()).html(total_hours_five);
                // $(api.column(16).footer()).html(total_minutes_five);
                // $(api.column(17).footer()).html(total_days_six);
                // $(api.column(18).footer()).html(total_hours_six);
                // $(api.column(19).footer()).html(total_minutes_six);
            }
        });




    }

    function filter_report() {
        initializeDataTableTimeworkPreview()
    }

    function export_excel_leave_person(ps_id = null) {
        // สร้างตัวแปรสำหรับเก็บ filter ที่ผู้ใช้ป้อน
        var filter = {};

        // ดึงข้อมูลจากฟอร์มที่มีชื่อขึ้นต้นด้วย "filter"
        filter['filter_year'] = ($('#filter_year').val() - 543);
        filter['ps_id'] = <?= $ps_id ?>;
        filter['dp_id'] = <?= $dp_id ?>;
        console.log(filter);

        // สร้าง query string จาก object filter
        var queryString = $.param(filter);

        // ตรวจสอบและแนบ g_id ลงใน URL หากมีค่า
        var url = '<?php echo site_url($controller_dir . "export_excel_leave_person"); ?>' +
            '/' + encodeURIComponent(queryString);

        // เปิดลิงก์ในหน้าต่างใหม่
        window.open(url, '_blank');
    }

    function export_excel_leave_detail_person(leave_id = null) {
        // สร้างตัวแปรสำหรับเก็บ filter ที่ผู้ใช้ป้อน
        var filter = {};

        // ดึงข้อมูลจากฟอร์มที่มีชื่อขึ้นต้นด้วย "filter"
        filter['leave_id'] = leave_id;
        filter['ps_id'] = <?= $ps_id ?>;
        filter['dp_id'] = <?= $dp_id ?>;
        console.log(filter);

        // สร้าง query string จาก object filter
        var queryString = $.param(filter);

        // ตรวจสอบและแนบ g_id ลงใน URL หากมีค่า
        var url = '<?php echo site_url($controller_dir . "export_excel_leave_detail_person"); ?>' +
            '/' + encodeURIComponent(queryString);

        // เปิดลิงก์ในหน้าต่างใหม่
        window.open(url, '_blank');
    }

    function formatDateRange(start_date, end_date) {
        // แมปชื่อเดือนภาษาไทย
        const monthsThai = {
            '01': 'มกราคม',
            '02': 'กุมภาพันธ์',
            '03': 'มีนาคม',
            '04': 'เมษายน',
            '05': 'พฤษภาคม',
            '06': 'มิถุนายน',
            '07': 'กรกฎาคม',
            '08': 'สิงหาคม',
            '09': 'กันยายน',
            '10': 'ตุลาคม',
            '11': 'พฤศจิกายน',
            '12': 'ธันวาคม'
        };

        // แปลงวันที่เป็น Date object
        const start = new Date(start_date);
        const end = new Date(end_date);

        // ดึงข้อมูลวันที่ เดือน และปี
        const startDay = start.getDate();
        const startMonth = monthsThai[(start.getMonth() + 1).toString().padStart(2, '0')];
        const startYear = start.getFullYear() + 543; // แปลงปีเป็นพ.ศ.

        const endDay = end.getDate();
        const endMonth = monthsThai[(end.getMonth() + 1).toString().padStart(2, '0')];
        const endYear = end.getFullYear() + 543; // แปลงปีเป็นพ.ศ.

        // ตรวจสอบว่าอยู่ในเดือนและปีเดียวกันหรือไม่
        if (start.getMonth() === end.getMonth() && start.getFullYear() === end.getFullYear()) {
            // เดือนเดียวกัน
            return `${startDay}-${endDay} ${startMonth} ${startYear}`;
        } else {
            // คนละเดือนหรือคนละปี
            return `${startDay} ${startMonth} ${startYear} ถึง ${endDay} ${endMonth} ${endYear}`;
        }
    }
</script>