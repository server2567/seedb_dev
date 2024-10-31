<style>
    ul {
        list-style-type: none;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($clnd_info) ? 'แก้ไข' : 'เพิ่ม' ?>วันหยุด</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row g-3 needs-validation">
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อวันหยุด</label>
                            <?php if (!empty($clnd_info->clnd_id)) { ?>
                                <input type="text" name="calendar[]" id="clnd_id" value="<?php echo !empty($clnd_info) ? $clnd_info->clnd_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="calendar[]" id="clnd_name" placeholder="ชื่อวันหยุด" value="<?php echo !empty($clnd_info) ? $clnd_info->clnd_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="clnd_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="toolID" class="form-label">ประเภทวันหยุด</label>
                            <select class="form-select" name="calendar[]" id="clnd_type_date" required>
                                <option value="" selected disabled>-- เลือกประเภท --</option>
                                <?php if (!empty($lct_info)) { ?>
                                    <?php foreach ($lct_info as $item) { ?>
                                        <option value="<?php echo $item->lct_id ?>" <?php echo !empty($clnd_info) && $clnd_info->clnd_type_date == $item->lct_id ? 'selected' : '' ?>><?php echo $item->lct_name ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="date" class="form-label ">ระหว่างวันที่</label>
                            <div class="input-group date input-daterange">
                                <input type="text" class="form-control" name="calendar[]" id="clnd_start_date" placeholder="" value="">
                                <span class="input-group-text mb-3">ถึง</span>
                                <input type="text" class="form-control" name="calendar[]" id="clnd_end_date" placeholder="" value="<?php echo !empty($clnd_info) ? $clnd_info->clnd_end_date : ""; ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($clnd_info->clnd_id)) { ?>
                                                <input type="checkbox" name="calendar[]" id="clnd_active" class="form-check-input m-1" value="<?php echo !empty($clnd_info) ? $clnd_info->clnd_active : ""; ?>" <?php echo !empty($clnd_info) && $clnd_info->clnd_active == '1' ? 'checked' : ''; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="clnd_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/calendar'">ย้อนกลับ</button>
                            <?php if (!empty($clnd_info->clnd_id)) { ?>
                                <button type="button" onclick="submitEdit()" class="btn btn-success float-end">บันทึก</button>
                            <?php } else { ?>
                                <button type="button" onclick="submitAdd()" class="btn btn-success float-end">บันทึก</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var formData = {};

    function submitAdd() {
        $('[name^="calendar"]').each(function() {
            var checkbox = document.getElementById('clnd_active');
            if (this.id != 'clnd_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.clnd_id;
        if (!formData.clnd_name) {
            !formData.clnd_name ? $('#clnd_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }

        // $.ajax({
        //     url: '<?php echo site_url() . '/' . $controller . 'calendar/checkValue'; ?>',
        //     method: 'POST',
        //     data: {
        //         clnd_name: formData['clnd_name'],
        //     }
        // }).done(function(returnedData) {
        //     var data = JSON.parse(returnedData)
        //     var inputElement = document.getElementById('clnd_msg');
        //     if (data.status_response == 1) {
        //         dialog_error({
        //             'header': 'ไม่สามารถเพิ่มข้อมูลได้',
        //             'body': 'วันหยุดนี้ถูกใช้งานแล้ว'
        //         });
        //         $('#clnd_name').get(0).focus()
        //         inputElement.innerHTML = "วันหยุดนี้ถูกใช้งานแล้ว";
        //         return false;
        //     } else {
        // inputElement.innerHTML = "";
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'calendar/calendar_insert'; ?>',
            method: 'POST',
            data: formData
        }).done(function(returnedData) {
            dialog_success({
                'header': 'ดำเนินการเสร็จสิ้น',
                'body': 'บันทึกข้อมูลเสร็จสิ้น'
            });
            setTimeout(function() {
                window.location.href = '<?php echo site_url() ?>/hr/base/calendar'
            }, 1500);
        })
        //     }
        // })
    }

    function submitEdit() {
        $('[name^="calendar"]').each(function() {
            var checkbox = document.getElementById('clnd_active');
            if (this.id != 'clnd_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        console.log(formData);
        if (!formData.clnd_name) {
            !formData.clnd_name ? $('#clnd_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        // $.ajax({
        //     url: '<?php echo site_url() . '/' . $controller . 'calendar/checkValue'; ?>',
        //     method: 'POST',
        //     data: {
        //         clnd_name: formData['clnd_name'],
        //         clnd_id: formData['clnd_id']
        //     }
        // }).done(function(returnedData) {
        //     var data = JSON.parse(returnedData)
        // var inputElement = document.getElementById('clnd_msg');
        //     if (data.status_response == 1) {
        //         dialog_error({
        //             'header': 'ไม่สามารถเพิ่มข้อมูลได้',
        //             'body': 'วันหยุดนี้ถูกใช้งานแล้ว'
        //         });
        //         $('#clnd_name').get(0).focus()
        //         inputElement.innerHTML = "วันหยุดนี้ถูกใช้งานแล้ว";
        //         return false;
        //     } else {
        // inputElement.innerHTML = "";
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'calendar/calendar_update'; ?>',
            method: 'POST',
            data: formData
        }).done(function(returnedData) {
            dialog_success({
                'header': 'ดำเนินการเสร็จสิ้น',
                'body': 'บันทึกข้อมูลเสร็จสิ้น'
            });
            setTimeout(function() {
                window.location.href = '<?php echo site_url() ?>/hr/base/calendar'
            }, 1500);
        })
        //     }
        // })
    }

    flatpickr("#clnd_start_date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: "<?php echo isset($clnd_info) ? date('d/m/Y', strtotime($clnd_info->clnd_start_date . ' +543 years')) : date('d/m/Y', strtotime('+543 years')); ?>",
        onReady: function(selectedDates, dateStr, instance) {
            // addMonthNavigationListeners();
            // convertYearsToThai();
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
                document.getElementById('clnd_start_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('clnd_start_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    flatpickr("#clnd_end_date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: "<?php echo isset($clnd_info) ? date('d/m/Y', strtotime($clnd_info->clnd_end_date . ' +543 years')) : date('d/m/Y', strtotime('+543 years')); ?>",
        onReady: function(selectedDates, dateStr, instance) {
            // addMonthNavigationListeners();
            // convertYearsToThai();
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
                document.getElementById('clnd_end_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('clnd_end_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });
</script>