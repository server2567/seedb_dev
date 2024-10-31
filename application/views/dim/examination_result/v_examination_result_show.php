<style>
    body {
        /* font-family: "Open Sans", sans-serif; */
        font-family: var(--tp-font-family);
        font-size: 16px;
        background: #f6f9ff;
        color: #444444;
        color: var(--tp-font-color);
    }

    .card-button.active {
        background-color: #0d6efd;
        border-radius: var(--bs-border-radius);
    }

    .card-button.active>.card-body {
        color: #fff;
    }

    .badge-number, .wrapper {
      position: absolute;
      top: 0;
      right: 0;
      transform: translate(20%, -50%);
    }
    
    .pulse {
        width: 50px;
        height: 50px;
        background-color: var(--bs-danger) !important;
        border-radius: 50%;
        position: relative;
        animation: animate 3s linear infinite
    }

    .pulse h5 {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        height: 100%;
        cursor: pointer
    }

    @keyframes animate {
        0% {box-shadow: 0 0 0 0 rgb(255, 109, 74, 0.7) , 0 0 0 0 rgb(255, 109, 74, 0.7)}
        40%{box-shadow: 0 0 0 50px rgb(255, 109, 74, 0) , 0 0 0 0 rgb(255, 109, 74, 0.7)}
        80%{box-shadow: 0 0 0 50px rgb(255, 109, 74, 0) , 0 0 0 30px rgb(255, 109, 74, 0)}
        100%{box-shadow: 0 0 0 0 rgb(255, 109, 74, 0) , 0 0 0 30px rgb(255, 109, 74, 0)}
    }
    
    .border-dash {
        box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
        border: 3px dashed #607D8B;
        color: #012970;
    }

    .alert-success {
        margin-bottom: 0px;
    }

    .iconslist {
        padding-top: 0px;
    }
</style>

<!-- Searching -->
<div class="row mb-3">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> การค้นหาขั้นสูง</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" id="search-exr" method="post" action="<?php echo base_url(); ?>index.php/dim/Examination_result">
                        <div class="col-md-12">
                            <label for="date" class="form-label ">ระหว่าง วันที่</label>
                            <div class="input-group date input-daterange">
                                <input type="input" class="form-control" name="start_date" id="start_date" placeholder="">
                                <input type="input" class="form-control" name="start_time" id="start_time" placeholder="" value="<?php echo !empty($search) && !empty($search['start_time']) ? $search['start_time'] : ""; ?>" />
                                <span class="input-group-text mb-3">ถึง</span>
                                <input type="input" class="form-control" name="end_date" id="end_date" placeholder="">
                                <input type="input" class="form-control" name="end_time" id="end_time" placeholder="" value="<?php echo !empty($search) && !empty($search['end_time']) ? $search['end_time'] : ""; ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pt_id" class="form-label">Patient ID</label>
                            <input type="text" class="form-control" name="pt_id" id="pt_id" placeholder="" value="<?php echo !empty($search) && !empty($search['pt_id']) ? $search['pt_id'] : ""; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="pt_name" class="form-label">ชื่อ - นามสกุลผู้ป่วย</label>
                            <input type="text" class="form-control" name="pt_name" id="pt_name" placeholder="" value="<?php echo !empty($search) && !empty($search['pt_name']) ? $search['pt_name'] : ""; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="stde_id" class="form-label">หน่วยงาน/แผนก</label>
                            <select class="form-select select2" data-placeholder="-- ทั้งหมด --" name="stde_id" id="stde_id">
                                <option value=""></option>
                                <?php foreach ($departments as $dp) { ?>
                                    <optgroup label="<?php echo $dp['dp_name_th']; ?>">
                                        <?php foreach ($structure_details as $stde) { 
                                            if($stde['stuc_dp_id'] == $dp['dp_id']) {
                                        ?>
                                            <option value="<?php echo $stde['stde_id']; ?>" <?php echo (!empty($search['stde_id']) && (decrypt_id($stde['stde_id']) == $search['stde_id'])) ? "selected" : "" ; ?>><?php echo $stde['stde_name_th']; ?></option>
                                        <?php }} ?>
                                    </optgroup>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="eqs_id" class="form-label">เครื่องมือหัตถการ</label>
                            <select class="form-select select2" data-placeholder="-- ทั้งหมด --" name="eqs_id" id="eqs_id">
                                <option value=""></option>
                                <?php foreach ($rooms as $rm) { ?>
                                    <optgroup label="<?php echo $rm['rm_name']; ?>">
                                        <?php foreach ($equipments as $eqs) { 
                                            if($eqs['eqs_rm_id'] == $rm['rm_id']) {
                                        ?>
                                            <option value="<?php echo $eqs['eqs_id']; ?>" <?php echo (!empty($search['eqs_id']) && (decrypt_id($eqs['eqs_id']) == $search['eqs_id'])) ? "selected" : "" ; ?>><?php echo $eqs['eqs_name']; ?></option>
                                        <?php }} ?>
                                    </optgroup>
                                <?php } ?>
                            </select>
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

<!-- Table -->
<div class="row">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-clipboard-plus icon-menu"></i><span> รายชื่อผู้ป่วย</span><span class="badge bg-success" id="patients-count">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">เวลาทำที่การตรวจ</th>
                                <th class="text-center" width="5%">Patient ID</th>
                                <th width="15%">ชื่อ-นามสกุลผู้ป่วย</th>
                                <th width="20%">หน่วยงาน/แผนก</th>
                                <th width="15%">เครื่องมือหัตถการ</th>
                                <th width="20%">เจ้าหน้าที่ดำเนินการ</th>
                                <th class="text-center" width="5%">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($examination_results as $row) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo convertToThaiYear($row['exr_inspection_time'], true); ?></td>
                                <td class="text-center"><?php echo $row['exr_pt_id']; ?></td>
                                <td><?php echo $row['pt_full_name']; ?></td>
                                <td><?php echo $row['dp_stde_name']; ?></td>
                                <td><?php echo $row['eqs_name']; ?></td>
                                <td><?php echo $row['modified_ps_full_name']; ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href='<?php echo base_url().'index.php/dim/Examination_result/Examination_result_detail/'.$row['exr_id']; ?>'"><i class="bi-search"></i></button>
                                </td>
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

    flatpickr("#start_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
    flatpickr("#end_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
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
            document.getElementById('start_date').value = formatDateToThai('<?php echo !empty($search) && !empty($search['start_date']) ? $search['start_date'] : ""; ?>');
            document.getElementById('end_date').value = formatDateToThai('<?php echo !empty($search) && !empty($search['end_date']) ? $search['end_date'] : ""; ?>');
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
        const d = new Date(date);
        const year = d.getFullYear() + 543;
        const month = ('0' + (d.getMonth() + 1)).slice(-2);
        const day = ('0' + d.getDate()).slice(-2);
        // const hour = ('0' + d.getHours()).slice(-2);
        // const min = ('0' + d.getMinutes()).slice(-2);
        return `${day}/${month}/${year}`;
    }
</script>