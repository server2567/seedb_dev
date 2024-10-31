<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                            <i class="bi-search icon-menu"></i><span> ค้นหา</span>
                        </button>
                    </h2>
                    <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body">
                            <form class="row g-3" method="get">
                                <div class="col-md-4">
                                    <label for="select_dp_id" class="form-label">ปีปฏิทิน</label>
                                    <select class="form-select select2  filter" onchange="filter_dev()" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="filter[]" id="filter_year">
                                        <?php
                                        foreach ($year_filter as $key => $row) {
                                        ?>
                                            <option value="<?php echo $row->year + 543; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->year + 543; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_admin_id" class="form-label">ปรเภทบุคลากร</label>
                                    <select class="form-select select2 filter" onchange="filter_dev()" name="filter[]" id="filter_hire">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <?php foreach ($base_hire_list as $key => $value) : ?>
                                            <option value="<?= $value->hire_id ?>"><?= $value->hire_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_status_id" class="form-label">ประเภทสายงาน</label>
                                    <select class="form-select select2 filter" onchange="filter_dev()" class="form-select" id="filter_adline" name="filter[]">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <?php foreach ($base_adline_list as $key => $value) : ?>
                                            <option value="<?= $value->alp_id ?>"><?= $value->alp_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_adline_id" class="form-label">รูปแบบการไปพัฒนาบุคลากร</label>
                                    <select class="form-select select2 filter" onchange="filter_dev()" name="filter[]" id="filter_org_type">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <option value="1">ภายใน</option>
                                        <option value="2">ภายนอก</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_status_id" class="form-label">ประเภทการอบรม</label>
                                    <select class="form-select select2 filter" onchange="filter_dev()" class="form-select" id="filter_devb_type" name="filter[]">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <?php foreach ($base_develop_type_list as $key => $value) : ?>
                                            <option value="<?= $value->devb_id ?>"><?= $value->devb_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_admin_id" class="form-label">ประเภทการพัฒนา</label>
                                    <select class="form-select select2 filter" onchange="filter_dev()" name="filter[]" id="filter_dev_type">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <option value="1">พัฒนาตามความต้องการของตนเอง</option>
                                        <option value="2">พัฒนาตามนโยบายของโรงพยาบาลจักษุสุราษฏร์</option>
                                        ?>
                                    </select>
                                </div>
                                <!-- <div class="col-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                        </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button accordion-button-table" type="button">
                            <i class="bi-people icon-menu"></i><span> รายงานพัฒนาบุคลากร (ภาพรวม) </span><span class="summary_preview_report badge bg-success"></span>
                        </button>
                    </h2>

                    <div id="collapseShow" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <table id="timework_report_list" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th class="text-center" width="15%">ชื่อ - นามสกุล</th>
                                        <th class="text-center" width="20%">เรื่องไปอบรม</th>
                                        <th class="text-center" width="15%">วันที่เริ่มอบรม</th>
                                        <th class="text-center" width="15%">ประเภทการไปอบรม</th>
                                        <th class="text-center" width="20%">สถานที่</th>
                                        <th class="text-center" width="10%">จำนวนชั่วโมง</th>
                                        <th class="text-center" width="30%">รวมชั่วโมง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- ข้อมูลจะถูกเติมด้วย DataTable -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

<script>
    $(document).ready(function() {
        initializeDataTableTimeworkPreview();
    });

    function export_print_person(ps_id = null) {
        // สร้างตัวแปรสำหรับเก็บ filter ที่ผู้ใช้ป้อน
        var filter = {};

        // ดึงข้อมูลจากฟอร์มที่มีชื่อขึ้นต้นด้วย "filter"
        $('[name^="filter"]').each(function() {
            filter[this.id] = this.value; // เก็บค่า ID และ value ของฟิลด์
        });

        // สร้าง query string จาก object filter
        var queryString = $.param(filter);

        // ตรวจสอบและแนบ g_id ลงใน URL หากมีค่า
        var url = '<?php echo site_url($controller_dir . "export_print_develop_person"); ?>' +
            '/' + encodeURIComponent(queryString) +
            '/' + (ps_id ? ps_id : '');

        // เปิดลิงก์ในหน้าต่างใหม่
        window.open(url, '_blank');
    }

    function export_excel_person(ps_id = null) {
        // สร้างตัวแปรสำหรับเก็บ filter ที่ผู้ใช้ป้อน
        var filter = {};

        // ดึงข้อมูลจากฟอร์มที่มีชื่อขึ้นต้นด้วย "filter"
        $('[name^="filter"]').each(function() {
            filter[this.id] = this.value; // เก็บค่า ID และ value ของฟิลด์
        });

        // สร้าง query string จาก object filter
        var queryString = $.param(filter);

        // ตรวจสอบและแนบ g_id ลงใน URL หากมีค่า
        var url = '<?php echo site_url($controller_dir . "export_excel_develop_person"); ?>' +
            '/' + encodeURIComponent(queryString) +
            '/' + (ps_id ? ps_id : '');

        // เปิดลิงก์ในหน้าต่างใหม่
        window.open(url, '_blank');
    }

    function export_pdf_person(ps_id, isPublic, actor_type) {
        var filter = {};

        // ดึงข้อมูลจากฟอร์มที่มีชื่อขึ้นต้นด้วย "filter"
        $('[name^="filter"]').each(function() {
            filter[this.id] = this.value; // เก็บค่า ID และ value ของฟิลด์
        });

        // สร้าง query string จาก object filter
        var queryString = $.param(filter);

        // ตรวจสอบและแนบ g_id ลงใน URL หากมีค่า
        var url = '<?php echo site_url($controller_dir . "export_pdf_develop_person"); ?>' +
            '/' + encodeURIComponent(queryString) +
            '/' + (ps_id ? ps_id : '');

        // เปิดลิงก์ในหน้าต่างใหม่
        window.open(url, '_blank');
    }

    function initializeDataTableTimeworkPreview() {
        $('#timework_report_list').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "ทั้งหมด"]
            ],
            language: {
                emptyTable: "ไม่มีรายการในระบบ",
                info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                infoEmpty: "แสดงรายการที่ 0 - 0 จากทั้งหมด 0 รายการ",
                lengthMenu: "_MENU_",
                loadingRecords: "กำลังโหลด...",
                searchPlaceholder: "ค้นหา...",
                zeroRecords: "ไม่พบรายการที่ตรงกัน",
                paginate: {
                    first: "«",
                    last: "»",
                    next: "›",
                    previous: "‹"
                }
            },
            dom: 'lBfrtip',
            buttons: [
                // {
                //     extend: 'print',
                //     text: '<i class="bi bi-printer-fill"></i> Print',
                //     title: 'รายงานการพัฒนาบุคลากร',
                //     customize: function(win) {
                //         // สร้างตัวแปรเพื่อเก็บข้อมูลจากแต่ละแถว
                //         var $win = $(win.document.body);

                //         // ปรับแต่งตาราง

                //         // ปรับแต่งแต่ละแถว
                //         var rows = $win.find('tr').each(function() {
                //             $(this).find('th, td').eq(7).hide(); // ซ่อนเซลล์ที่ 8 (index 7)
                //             $(this).find('th').eq(1).hide(); // ซ่อนคอลัมน์ที่ 2
                //         });

                //         var preName = '';
                //         var sumHour = 0;

                //         // ลูปเพื่อเข้าถึงแต่ละแถวและล็อกข้อมูล
                //         rows.each(function(index, row) {
                //             var rowData = $(row).find('td').map(function() {
                //                 return $(this).text(); // ดึงข้อมูลจากแต่ละเซลล์ในแถว
                //             }).get();

                //             if (rowData.length > 0) {
                //                 if (rowData[1] == preName) {
                //                     $(row).find('td').eq(1).hide(); // ซ่อนเซลล์ที่ซ้ำ
                //                     $(row).find('td').eq(0).css({
                //                         'border': 'none'
                //                     });
                //                     $(row).find('td').eq(2).css({
                //                         'border': 'none'
                //                     });
                //                     $(row).find('td').eq(3).css({
                //                         'border': 'none'
                //                     });
                //                     $(row).find('td').eq(4).css({
                //                         'border': 'none'
                //                     });
                //                     $(row).find('td').eq(5).css({
                //                         'border': 'none'
                //                     });
                //                     $(row).find('td').eq(6).css({
                //                         'border': 'none'
                //                     });
                //                     sumHour += parseFloat(rowData[6]) || 0; // คำนวณชั่วโมงรวม
                //                 } else {
                //                     if (preName != '') {
                //                         var sumRow = $('<tr></tr>');
                //                         // เพิ่มเซลล์ที่มี colspan 6
                //                         var sumCell = $('<td class="text-right"></td>').attr('colspan', 6).text('รวมทั้งหมด: ' + sumHour + ' ชั่วโมง').css({
                //                             'border': 'none', // ลบเส้นขอบทั้งหมด
                //                             'border-bottom': '1px solid black' // เพิ่มเส้นขอบด้านล่าง
                //                         });
                //                         sumRow.append(sumCell); // เพิ่มเซลล์ใหม่ในแถวสรุป
                //                         $(row).before(sumRow); // เพิ่มแถวรวมก่อนแถวปัจจุบัน
                //                     }

                //                     var newRow = $('<tr></tr>');
                //                     // เพิ่มเซลล์ที่มีข้อมูลทั้งหมดจากแถวปัจจุบัน
                //                     rowData.forEach(function(data, index2) {
                //                         if (index2 != 1 && index2 != 7) {
                //                             // สร้างเซลล์ใหม่
                //                             var newCell = $('<td></td>').text(data); // สร้างเซลล์ใหม่
                //                             newCell.css({
                //                                 'border': 'none'
                //                             }); // ตั้งค่าสไตล์สำหรับเซลล์ใหม่
                //                             newRow.append(newCell); // เพิ่มเซลล์ใหม่ในแถวใหม่
                //                         }
                //                     });

                //                     // เพิ่มแถวใหม่หลังแถวปัจจุบัน
                //                     $(row).after(newRow);

                //                     // ตั้งค่า colspan สำหรับเซลล์ที่ซ่อน
                //                     $(row).find('td').eq(1).attr('colspan', 6).css({
                //                         'border': 'none'
                //                     });; // ปรับ colspan

                //                     // ซ่อนเซลล์ที่ต้องการในแถวปัจจุบัน
                //                     $(row).find('td').eq(0).hide();
                //                     $(row).find('td').eq(2).hide();
                //                     $(row).find('td').eq(3).hide();
                //                     $(row).find('td').eq(4).hide();
                //                     $(row).find('td').eq(5).hide();
                //                     $(row).find('td').eq(6).hide();
                //                     $(row).css({
                //                         'border': 'none', // ลบเส้นขอบทั้งหมด
                //                         'border-bottom': '1px solid black' // เพิ่มเส้นขอบด้านล่าง
                //                     });
                //                     sumHour = parseFloat(rowData[6]) || 0; // รีเซ็ตชั่วโมงรวม
                //                     preName = rowData[1]; // อัปเดตค่าของ preName
                //                 }
                //             }
                //         });

                //         // เพิ่มแถวรวมสุดท้าย
                //         if (preName != '') {
                //             var sumRow = $('<tr></tr>');
                //             var sumCell = $('<td class="text-right"></td>').attr('colspan', 6).text('รวมทั้งหมด: ' + sumHour + ' ชั่วโมง');
                //             sumRow.append(sumCell); // เพิ่มเซลล์ใหม่ในแถวสรุป
                //             sumCell.css({
                //                 'border': 'none', // ลบเส้นขอบทั้งหมด
                //                 'border-bottom': '1px solid black' // เพิ่มเส้นขอบด้านล่าง
                //             });
                //             $win.find('table').append(sumRow); // เพิ่มแถวรวมสุดท้ายลงในตาราง
                //         }
                //     }
                // },
                {
                    text: '<i class="bi bi-printer"></i> Print',
                    className: 'btn btn-secondary',
                    action: function(e, dt, node, config) {
                        export_print_person()
                    }
                },
                {
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                    className: 'btn btn-success',
                    action: function(e, dt, node, config) {
                        export_excel_person()
                    }
                },
                {
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className: 'btn btn-danger',
                    action: function(e, dt, node, config) {
                        export_pdf_person()
                    }
                },
            ],
            ordering: false,
            "columnDefs": [{
                    "visible": false,
                    "targets": [1, 7]
                } // ซ่อนคอลัมน์ "ชื่อ - นามสกุล" ในการจัดกลุ่ม
            ],
            drawCallback: function(settings) {
                const api = this.api();
                const rows = api.rows({
                    page: 'current'
                }).nodes();
                let last = null;
                let totalHours = 0;
                let totalHours_lastrow = 0;

                // จัดกลุ่มแถวตามคอลัมน์ "ชื่อ - นามสกุล"
                api.column(1, {
                    page: 'current'
                }).data().each(function(group, i) {
                    const currentRow = api.row(i).data();

                    totalHours += parseFloat(currentRow.hour) || 0;
                    // หากเป็นกลุ่มใหม่ ให้สร้างแถวกลุ่ม
                    if (last !== group) {
                        if (last !== null) {
                            // เพิ่มแถวสำหรับแสดงผลรวมของกลุ่มก่อนหน้าในคอลัมน์ที่ 9
                            $(rows).eq(i - 1).after(
                                `<tr class="group-total">
                        <td colspan="7" style="text-align: right; font-weight: bold; background: #d4faff;">
                            รวมชั่วโมงทั้งหมด: ${totalHours} ชั่วโมง
                        </td>
                    </tr>`
                            );
                        }
                        // เริ่มต้นกลุ่มใหม่
                        $(rows).eq(i).before(
                            `<tr class="group">
                    <td colspan="7" style="background: #e0e0e0; font-weight: bold;">${group}</td>
                </tr>`
                        );
                        last = group;
                        totalHours = 0; // รีเซ็ตผลรวมของชั่วโมงสำหรับกลุ่มใหม่
                        totalHours_lastrow = 0;
                    }

                    // รวมชั่วโมงสำหรับกลุ่มปัจจุบัน (คอลัมน์ที่ 9)
                    totalHours_lastrow += parseFloat(currentRow.hour) || 0; // เข้าถึงคอลัมน์ที่ 9 โดยใช้ดัชนี 8
                });

                // เพิ่มแถวผลรวมสำหรับกลุ่มสุดท้าย (หากมี)
                if (last !== null) {
                    $(rows).eq(rows.length - 1).after(
                        `<tr class="group-total">
                <td colspan="7" style="text-align: right; font-weight: bold; background: #d4faff;">
                    รวมชั่วโมงทั้งหมด: ${totalHours_lastrow} ชั่วโมง
                </td>
            </tr>`
                    );
                }

                // Initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            ajax: {
                type: "GET",
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_develop_report_list',
                dataSrc: function(data) {
                    const return_data = [];
                    // const returnData = JSON.parse(data)

                    console.log(data.data.result);
                    data.data.result.forEach((row, index) => {
                        var button = `
                            <div class="d-flex justify-content-between align-items-center">
                                <b>${row.pf_name + " " + row.ps_fname + " " + row.ps_lname}</b>
                                <div class="d-flex">
                                    <button class="btn btn-secondary btn-sm me-2" title="คลิกเพื่อ Print" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_print_person('${row.devps_ps_id}')">
                                        <i class="bi bi-printer-fill"></i> 
                                    </button>
                                    <button class="btn btn-success btn-sm me-2" title="คลิกเพื่อส่งออกเอกสาร Excel" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_excel_person('${row.devps_ps_id}')">
                                        <i class="bi bi-file-earmark-excel-fill"></i> 
                                    </button>
                                    <button class="btn btn-danger btn-sm me-2" title="คลิกเพื่อส่งออกเอกสาร PDF" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_pdf_person('${row.devps_ps_id}')">
                                        <i class="bi bi-file-earmark-pdf-fill"></i> 
                                    </button>
                                </div>
                            </div>
                        `;
                        return_data.push({
                            seq: row.dev_seq,
                            name: button,
                            topic: row.devh_name_th ?? "",
                            date: `${row.dev_start_date} ถึง ${row.dev_end_date}`,
                            type: row.devb_name,
                            location: row.dev_place ?? "",
                            hour: row.dev_hour ?? "",
                            total_hours: row.total_hours
                        });
                    });
                    return return_data;
                }
            },
            columns: [{
                    data: "seq",
                    className: "text-center"
                },
                {
                    data: "name"
                },
                {
                    data: "topic"
                },
                {
                    data: "date"
                },
                {
                    data: "type"
                },
                {
                    data: "location"
                },
                {
                    data: "hour",
                    className: "text-center"
                },
                {
                    data: "total_hours"
                }
            ]
        });
    }
</script>