<style>
    /* Loading Spinner CSS */
    .loader {
        position: fixed;
        left: 50%;
        top: 50%;
        z-index: 1000;
        width: 50px;
        height: 50px;
        margin: -25px 0 0 -25px;
        border: 8px solid #f3f3f3;
        border-radius: 50%;
        border-top: 8px solid #3498db;
        animation: spin 1s linear infinite;
        display: none; /* ซ่อนเริ่มต้น */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* ปิดการทำงานของ scroll ขณะ loading */
    body.loading {
        overflow: hidden;
}

</style>

<?php
    setlocale(LC_TIME, 'th_TH.utf8');
    $thaiMonths = array(
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    );
?>

<div class="card mt-2">
    <div class="accordion">
        <!-- Accordion สำหรับค้นหารายชื่อบุคลากร -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <!-- ฟอร์มการค้นหาแบบฟิลเตอร์ -->
                    <form class="row g-3" method="get">
                        <!-- หน่วยงาน -->
                        <div class="col-md-3">
                            <label for="select_dp_id" class="form-label ">หน่วยงาน</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="filter_select_dp_id" id="filter_select_dp_id">
                                <?php foreach ($dp_info as $key => $row) { ?>
                                    <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- สายปฏิบัติงาน -->
                        <div class="col-md-3">
                            <label for="filter_select_hire_is_medical" class="form-label">สายปฏิบัติงาน</label>
                            <select class="form-select select2" name="filter_select_hire_is_medical" id="filter_select_hire_is_medical">
                                <option value="all">ทั้งหมด</option>
                                <?php
                                    $medical_types = [
                                        'M'  => 'สายการแพทย์',
                                        'N'  => 'สายการพยาบาล',
                                        'SM' => 'สายสนับสนุนทางการแพทย์',
                                        'T'  => 'สายเทคนิคและบริการ',
                                        'A'  => 'สายบริหาร'
                                    ];
                                    foreach ($this->session->userdata('hr_hire_is_medical') as $value) {
                                        $type = $value['type'];
                                        if (isset($medical_types[$type])) {
                                            echo '<option value="' . $type . '">' . $medical_types[$type] . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <!-- ประเภทการทำงาน -->
                        <div class="col-md-3">
                            <label for="filter_select_hire_type" class="form-label">ประเภทการทำงาน</label>
                            <select class="form-select select2" name="filter_select_hire_type" id="filter_select_hire_type">
                                <option value="all">ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานเต็มเวลา (Full-Time)</option>
                                <option value="2">ปฏิบัติงานบางเวลา (Part-Time)</option>
                            </select>
                        </div>

                        <!-- สถานะการทำงาน -->
                        <div class="col-md-3">
                            <label for="filter_select_status_id" class="form-label">สถานะการทำงาน</label>
                            <select class="form-select select2" id="filter_select_status_id" name="filter_select_status_id">
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานอยู่</option>
                                <option value="2">ออกจากการปฏิบัติงาน</option>
                            </select>
                        </div>

                        <!-- ช่วงวันที่ -->
                        <div class="col-md-6">
                            <label for="filter_select_date_day" class="form-label required">ช่วงวันที่</label>
                            <div class="input-group">
                                <span class="input-group-text">เดือน</span>
                                <select class="form-select" name="filter_select_date_month" id="filter_select_date_month">
                                    <?php
                                    $i = 0;
                                    foreach ($thaiMonths as $row) {
                                        echo '<option value="' . ($i + 1) . '">' . $row . '</option>';
                                        $i++;
                                    }
                                    ?>
                                </select>
                                <span class="input-group-text">ปี (พ.ศ.)</span>
                                <select class="form-select" name="filter_select_date_year" id="filter_select_date_year">
                                    <?php
                                    $currentYear = date('Y') + 543;
                                    for ($i = $currentYear; $i >= $currentYear - 60; $i--) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #cfe2ff; border-color: #cfe2ff; height: 52px;">
        <div>
            <i class="bi-people icon-menu font-20"></i><b>รายชื่อบุคลากร</b>
        </div>
    </div>
    <div class="card-body">
        <table id="person_status_table" class="table table-striped table-bordered table-hover datatables" cellspacing="0" width="100%">
            <thead id="table-header">
                <!-- ส่วนหัวตารางจะถูกสร้างโดย JavaScript -->
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div class="loader" id="loadingSpinner"></div>


<script>
    $(document).ready(function() {

    // ฟังก์ชันสร้างส่วนการทำงานของตารางพร้อมแสดงผลข้อมูล
    function loadTimeworkData() {
        showLoadingSpinner(); // แสดง loading spinner

        var dp_id = $('#filter_select_dp_id').val();
        var hire_is_medical = $('#filter_select_hire_is_medical').val();
        var hire_type = $('#filter_select_hire_type').val();
        var status_id = $('#filter_select_status_id').val();
        var month = $('#filter_select_date_month').val();
        var year = $('#filter_select_date_year').val() - 543;

        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_compile_list',
            type: 'POST',
            data: {
                dp_id: dp_id,
                hire_is_medical: hire_is_medical,
                hire_type: hire_type,
                status_id: status_id,
                month: month,
                year: year
            },
            dataType: 'json',
            success: function(response) {

                let seq = 0;
                let tableData = response.data.map(function(item) {
                    seq++;
                    return {
                        seq: seq,
                        ps_fullname : `<a href="<?php echo site_url() . "/" . $controller_dir; ?>get_timework_compile_user/${item.ps_id}" title="${item.pf_name}${item.ps_fname} ${item.ps_lname}" data-bs-toggle="tooltip" data-bs-placement="top">
                                ${item.pf_name}${item.ps_fname} ${item.ps_lname}
                            </a>`,
                        count_ws_id_10: item.count_ws_id_10 || '0',
                        count_ws_id_11: item.count_ws_id_11 || '0',
                        count_ws_id_12: item.count_ws_id_12 || '0',
                        count_ws_id_13: item.count_ws_id_13 || '0',
                        count_ws_id_20: item.count_ws_id_20 || '0',
                        count_ws_id_21: item.count_ws_id_21 || '0',
                        count_ws_id_22: item.count_ws_id_22 || '0',
                        count_ws_id_23: item.count_ws_id_23 || '0',
                        count_ws_id_24: item.count_ws_id_24 || '0',
                        count_ws_id_30: item.count_ws_id_30 || '0',
                        count_ws_id_31: item.count_ws_id_31 || '0',
                        count_ws_id_32: item.count_ws_id_32 || '0',
                        count_ws_id_33: item.count_ws_id_33 || '0',
                        count_ws_id_34: item.count_ws_id_34 || '0',
                        count_ws_id_35: item.count_ws_id_35 || '0',
                        count_ws_id_36: item.count_ws_id_36 || '0',
                        count_ws_id_37: item.count_ws_id_37 || '0',
                        count_ws_id_38: item.count_ws_id_38 || '0',
                        count_ws_id_39: item.count_ws_id_39 || '0',
                        count_ws_id_40: item.count_ws_id_40 || '0',
                        count_ws_id_41: item.count_ws_id_41 || '0',
                        count_ws_id_90: item.count_ws_id_90 || '0',
                        count_ws_id_91: item.count_ws_id_91 || '0',
                        count_ws_id_101: item.count_ws_id_101 || '0',
                        count_ws_id_102: item.count_ws_id_102 || '0',
                        count_ws_id_100: item.count_ws_id_100 || '0'
                    };
                });

                
            // สร้างคอลัมน์สำหรับ DataTable จากข้อมูล statuses ที่โหลดมา
            const columns = [
                { data: "seq", title: "ลำดับ", className: "text-center" },
                { data: "ps_fullname", title: "ชื่อ-นามสกุล" }
            ];

            // เพิ่มคอลัมน์จากข้อมูล statuses
            Object.keys(response.statuses).forEach(groupKey => {
                let group = response.statuses[groupKey];
                Object.keys(group).forEach(subGroupKey => {
                    let subGroup = group[subGroupKey];
                    subGroup.forEach(item => {
                        columns.push({
                            data: `count_ws_id_${item.ws_id}`,
                            title: item.ws_name,
                            className: `text-center ws_id_${item.ws_id}`
                        });
                    });
                });
            });

            $('#person_status_table').DataTable({
                destroy: true,
                data: tableData,
                autoWidth: false, // ปิด autoWidth เพื่อใช้ width 100%
                columns: columns,  // ใช้คอลัมน์ที่สร้างขึ้น
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                // createdRow: function(row, data, dataIndex) {
                //     $('td', row).each(function(index) {
                //         var cellValue = $(this).text();
                //         if (cellValue === '0') {
                //             $(this).hide(); // ซ่อน cell ถ้าค่าเป็น 0
                //         }
                //     });
                // },
                initComplete: function() {
                    hideLoadingSpinner();  // ซ่อน loading spinner เมื่อโหลดเสร็จ
                }
            });
            },
            error: function(error) {
                // console.error('Error fetching data:', error);
                hideLoadingSpinner();  // ซ่อน loading spinner เมื่อเกิดข้อผิดพลาด
            }
        });
    }

  
    // แสดง loading spinner ขณะโหลดข้อมูล
    function showLoadingSpinner() {
        $('#loadingSpinner').show();
        $('body').addClass('loading');  // ปิดการ scroll
    }

    // ซ่อน loading spinner เมื่อโหลดเสร็จ
    function hideLoadingSpinner() {
        $('#loadingSpinner').hide();
        $('body').removeClass('loading');  // เปิดการ scroll
    }

    // Load data เมื่อมีการเปลี่ยนแปลงการกรอง
    $('#filter_select_dp_id, #filter_select_hire_is_medical, #filter_select_hire_type, #filter_select_status_id, #filter_select_date_month, #filter_select_date_year').on('change', function() {
        loadTimeworkData();
    });

    // Initial load

    loadTimeworkData();  // โหลดข้อมูลในตาราง
});

</script>