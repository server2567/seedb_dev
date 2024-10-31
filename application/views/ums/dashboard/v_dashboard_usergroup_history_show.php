<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span>  กำหนดช่วงเวลาในการค้นหา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/Dashboard_usergroup_history">
                        <div class="col-md-6">
                            <label for="date" class="form-label ">ระหว่าง วันที่</label>
                            <div class="input-group date input-daterange">
                                <input type="input" class="form-control" name="start_date" id="start_date" placeholder="วว/ดด/ปป">
                                <span class="input-group-text mb-3">ถึง</span>
                                <input type="input" class="form-control" name="end_date" id="end_date" placeholder="วว/ดด/ปป">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pos_ps_code" class="form-label">รหัสประจำตัวบุคลากรของผู้ใช้</label>
                            <input type="text" class="form-control" name="pos_ps_code" id="pos_ps_code" placeholder="" value="<?php echo !empty($search) && isset($search['pos_ps_code']) ? $search['pos_ps_code'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="us_username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="us_username" id="us_username" placeholder="" value="<?php echo !empty($search) && isset($search['us_username']) ? $search['us_username'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="us_name" class="form-label">ชื่อ - นามสกุลของผู้ใช้</label>
                            <input type="text" class="form-control" name="us_name" id="us_name" placeholder="" value="<?php echo !empty($search) && isset($search['us_name']) ? $search['us_name'] : "" ;?>">
                        </div>
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ประวัติการเพิ่มลดสิทธิ์ผู้ใช้</span><span class="badge bg-success"><?php echo count($usergroup_histories); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th width="20%">ชื่อ - นามสกุล</th>
                                <th width="10%" class="text-center">รหัสประจำตัวบุคลากร</th>
                                <th width="15%">ชื่อผู้ใช้</th>
                                <th width="25%">การดำเนินการ</th>
                                <th width="15%" class="text-center">วันที่บันทึกข้อมูลล่าสุด</th>
                                <th width="15%">ผู้บันทึกข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($usergroup_histories as $row) { ?>
                            <tr>
                                <td><?php echo $row['us_name']; ?></td>
                                <td class="text-center"><?php echo $row['pos_ps_code']; ?></td>
                                <td><?php echo $row['us_username']; ?></td>
                                <td><?php echo $row['ughi_changed']; ?></td>
                                <td class="text-center"><?php echo convertToThaiYear($row['ughi_date'], true); ?></td>
                                <td><?php echo $row['modified_user']; ?></td>
                                </tr>
                            <?php 
                                $i++; } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.datatable').DataTable().order([[0, '']]).draw();
    });
    
    flatpickr("#start_date", {
        plugins: [
            new rangePlugin({
                input: "#end_date"
            })
        ],
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        onReady: function(selectedDates, dateStr, instance) {
            document.getElementById('start_date').value = formatDateToThai('<?php echo !empty($search) && isset($search['start_date']) ? $search['start_date'] : ""; ?>');
            document.getElementById('end_date').value = formatDateToThai('<?php echo !empty($search) && isset($search['end_date']) ? $search['end_date'] : ""; ?>');
            // addMonthNavigationListeners();
            // convertYearsToThai();
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (selectedDates[0]) {
                document.getElementById('start_date').value = formatDateToThai(selectedDates[0]);
            }
            if (selectedDates[1]) {
                document.getElementById('end_date').value = formatDateToThai(selectedDates[1]);
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    function convertYearsToThai() {
        const calendar = document.querySelector('.flatpickr-calendar');
        if (!calendar) return;

        const years = calendar.querySelectorAll('.cur-year, .numInput');
        years.forEach(function(yearInput) {
            convertToThaiYear(yearInput);
        });

        const yearDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
        yearDropdowns.forEach(function(monthDropdown) {
            if (monthDropdown) {
                monthDropdown.querySelectorAll('option').forEach(function(option) {
                    convertToThaiYearDropdown(option);
                });
            }
        });

        const currentYearElement = calendar.querySelector('.flatpickr-current-year');
        if (currentYearElement) {
            const currentYear = parseInt(currentYearElement.textContent);
            if (currentYear < 2500) {
                currentYearElement.textContent = currentYear + 543;
            }
        }
    }

    function convertToThaiYear(yearInput) {
        const currentYear = parseInt(yearInput.value);
        if (currentYear < 2500) { // Convert to B.E. only if not already converted
            yearInput.value = currentYear + 543;
        }
    }

    function convertToThaiYearDropdown(option) {
        const year = parseInt(option.textContent);
        if (year < 2500) { // Convert to B.E. only if not already converted
            option.textContent = year + 543;
        }
    }

    function formatDateToThai(date) {
        if(date) {
            const d = new Date(date);
            const year = d.getFullYear() + 543;
            const month = ('0' + (d.getMonth() + 1)).slice(-2);
            const day = ('0' + d.getDate()).slice(-2);
            // const hour = ('0' + d.getHours()).slice(-2);
            // const min = ('0' + d.getMinutes()).slice(-2);
            return `${day}/${month}/${year}`;
        }
        return '';
    }
</script>

<script>
    $(document).ready(function() {
        // Setting Export Datatable.js
        var table = $('.datatable').DataTable();
        var buttons = table.buttons();

        buttons.each(function(button, buttonIdx) {
            if (button) {
                // get config
                var config = button.inst.s.buttons[buttonIdx].conf;
                // specify some config
                var columns = [0, 1, 2, 3, 4, 5]; // specify columns to export
                title = "รายการประวัติการเพิ่มลดสิทธิ์ผู้ใช้"; // specify title of head in file

                if(config.titleAttr == "Print") { // if need setting file Print
                    config.exportOptions = { columns: columns };
                    config.title = '<h3 class="font-weight-600 text-center">รายการประวัติการเพิ่มลดสิทธิ์ผู้ใช้</h3>';
                    // $("." + config.className).html("Print"); // specify text and style of button
                }
                if(config.titleAttr == "Excel") { // if need setting file Excel
                    config.exportOptions = { columns: columns };
                    config.title = title;
                    // $("." + config.className).html("Excel"); // specify text and style of button
                }
                if(config.titleAttr == "PDF") { // if need setting file PDF
                    config.exportOptions = { columns: columns };
                    config.title = title;
                    config.customize = function (doc) {
                        doc.defaultStyle = { font: 'THSarabun' };
                        doc.content[1].table.widths = ['20%', '10%', '15%', '25%', '10%', '20%'];
                        // doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto'];
                    };
                    // $("." + config.className).html("PDF"); // specify text and style of button
                }
            }
        });
    });
</script>