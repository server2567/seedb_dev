<form method="post" class="needs-validation" id="timework_setting_form" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="twst_id" id="twst_id" value="">
    <input type="hidden" name="twst_status" id="twst_status" value="">

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bi bi-postcard icon-menu font-20"></i>กำหนดเวลาการลงเวลาทำงาน
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="row">

                                <!-- Select Month -->
                                <div class="col-md-4 mb-4">
                                    <label for="twst_month" class="form-label required">เดือน</label>
                                    <select class="form-select select2" name="twst_month" id="twst_month" required>
                                        <option value="">-- เลือกเดือน --</option>
                                        <option value="1">มกราคม</option>
                                        <option value="2">กุมภาพันธ์</option>
                                        <option value="3">มีนาคม</option>
                                        <option value="4">เมษายน</option>
                                        <option value="5">พฤษภาคม</option>
                                        <option value="6">มิถุนายน</option>
                                        <option value="7">กรกฎาคม</option>
                                        <option value="8">สิงหาคม</option>
                                        <option value="9">กันยายน</option>
                                        <option value="10">ตุลาคม</option>
                                        <option value="11">พฤศจิกายน</option>
                                        <option value="12">ธันวาคม</option>
                                    </select>
                                </div>

                                <!-- Select Year (Buddhist year) -->
                                <div class="col-md-4 mb-4">
                                    <label for="twst_year" class="form-label required">ปีพ.ศ.</label>
                                    <select id="twst_year" name="twst_year" class="form-select select2" required></select>
                                </div>

                                <div class="col-md-4 mb-4"></div>

                                <hr>
                                
                              
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required" for="twst_start_date_label">วันที่เริ่มดำเนินการ</label>
                                    <div class="input-group">
                                        <span class="input-group-text">วันที่</span>
                                        <input type="text" class="form-control" id="twst_start_date" name="twst_start_date" placeholder="เลือกวันที่เริ่มต้น">
                                        <span class="input-group-text">เวลา</span>
                                        <input type="text" class="form-control" id="twst_start_time" name="twst_start_time" placeholder="เลือกเวลาเริ่มต้น">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required" for="twst_end_date_label">วันที่สิ้นสุดดำเนินการ</label>
                                    <div class="input-group">
                                        <span class="input-group-text">วันที่</span>
                                        <input type="text" class="form-control" id="twst_end_date" name="twst_end_date" placeholder="เลือกวันที่สิ้นสุด">
                                        <span class="input-group-text">เวลา</span>
                                        <input type="text" class="form-control" id="twst_end_time" name="twst_end_time" placeholder="เลือกเวลาสิ้นสุด">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary float-start" onclick="location.href='<?php echo site_url($controller_dir); ?>'">ย้อนกลับ</button>
                                    <button type="button" onclick="timework_setting_save_form()" class="btn btn-success float-end">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-table icon-menu"></i>
                            <span> ตารางข้อมูลกำหนดเวลาการลงเวลาทำงาน</span><span class="summary_timework_setting badge bg-success"></span>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#headingTwo">
                        <div class="accordion-body">
                            <table class="table datatable" id="timework_setting_list" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>เดือนที่ลงเวลาทำงาน</th>
                                        <th>ปีพ.ศ.</th>
                                        <th>วันที่เริ่มดำเนินการ</th>
                                        <th>วันที่สิ้นสุดดำเนินการ</th>
                                        <th>ผู้สร้างข้อมูล</th>
                                        <th>ดำเนินการ</th>
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
</form>


<script>
document.addEventListener('DOMContentLoaded', function() {
    setDefaultDateSetting();

    // Get the current year in Buddhist calendar (Thai format)
    const currentYear = new Date().getFullYear() + 543;
    const maxYear = currentYear + 1; // Maximum year will be the next year

    // Populate the select options for the year select2
    let yearOptions = '';
    for (let year = currentYear; year <= maxYear; year++) {
        yearOptions += `<option value="${year}">${year}</option>`;
    }

    // Initialize select2 for year selection with default year set
    $('#twst_year').html(yearOptions).val(currentYear).select2({
        placeholder: 'เลือกปีพ.ศ.',
        allowClear: true
    });

    // Use event delegation for dynamically loaded elements
    document.addEventListener('click', function(event) {
        const button = event.target.closest('.change_status');
        if (button) {
            const dataValue = button.getAttribute('data-value');
            if (dataValue) {
                try {
                    Swal.fire({
                        title: 'ต้องการยืนยันสถานะกำหนดเวลาการลงเวลาทำงาน',
                        text: "คุณต้องการยืนยันสถานะกำหนดเวลาการลงเวลาทำงาน หรือไม่",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'ตกลง',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var today = new Date().toISOString().slice(0, 10);
                            $.ajax({
                                url: '<?php echo site_url() . "/" . $controller_dir; ?>change_status_timework_setting',
                                method: 'POST',
                                data: {
                                    twst_id: dataValue
                                }
                            }).done(function(returnedData) {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "บันทึกข้อมูลสำเร็จ",
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    updateTimeworkSettingTable();
                                });
                            });
                        }
                    });
                } catch (error) {
                    console.error('An error occurred:', error);
                }
            } else {
                console.error('Data value is empty or invalid');
            }
        }
    });

    updateTimeworkSettingTable();
});


function updateTimeworkSettingTable() {
    var timework_setting_table = $('#timework_setting_list').DataTable();
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_setting_list',
        type: 'GET',
        success: function(data) {
            data = JSON.parse(data);
            timework_setting_table.clear().draw();

             // Update summary count
             $(".summary_timework_setting").text(data.length);

            // Add new data to table
            data.forEach(function(row, index) {
                let button = '';
                let status_btn = '';
                
                button = `
                         <button class="btn btn-warning" title="คลิกเพื่อแก้ไขข้อมูล" data-bs-toggle="tooltip" data-bs-placement="top" onclick="get_timework_setting_detail_by_id('${row.twst_id}')">
                            <i class="bi-pencil-square"></i>
                        </button>
                `;

                if(row.twst_status == "Y"){
                    status_btn = `
                        
                            <button class="btn btn-success" title="กำหนดการปัจจุบัน" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="bi bi-patch-check-fill"></i>
                            </button>
                    `;
                }
                else{
                    status_btn = `
                        
                        <button class="btn btn-secondary change_status" title="คลิกเพื่อกำหนดสถานะใช้งาน" data-bs-toggle="tooltip" data-bs-placement="top" data-value="${row.twst_id}">
                            <i class="bi bi-patch-check"></i>
                        </button>
                    `;
                }
                

                
                // เพิ่มข้อมูลเข้าไปในตาราง
                timework_setting_table.row.add([
                    index + 1,
                    row.month_text,
                    row.twst_year,
                    row.start_date_text,
                    row.end_date_text,
                    '<div class="text-center option">' + status_btn + button +'</div>',
                    row.us_name,
                    
                ]).draw();

            });

            $('[data-toggle="tooltip"]').tooltip();

        },
        error: function() {
            dialog_error({'header': text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
}

function get_timework_setting_detail_by_id(twst_id) {
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_setting_by_id',
        type: 'POST',
        data: { twst_id: twst_id },
        dataType: 'json',
        success: function(data) {
            data = JSON.parse(data);

            // Populate the form fields with the response data
            $('#twst_id').val(data.twst_id);
            $('#twst_month').val(data.twst_month);
            $('#twst_year').val(data.twst_year);
            $('#twst_is_medical').val(data.twst_is_medical).trigger('change');
            $('#twst_start_date').val(data.twst_start_date);
            $('#twst_start_time').val(data.twst_start_time);
            $('#twst_end_date').val(data.twst_end_date);
            $('#twst_end_time').val(data.twst_end_time);
            $('#twst_status').val(data.twst_status);
           
        },
        error: function(xhr, status, error) {
            // console.log(xhr.responseText);
            alert('An error occurred while processing the request.');
        }
    });
}


function timework_setting_save_form(actionType){
    var form = $('#timework_setting_form')[0];
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    var form_attendance_setting = new FormData(form);

    $.ajax({
        url: '<?php echo site_url($controller_dir . "timework_setting_save"); ?>',
        type: 'POST',
        data: form_attendance_setting,
        processData: false,
        contentType: false,
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status_response == status_response_success) {
                dialog_success({'header': text_toast_default_success_header, 'body': data.message_dialog});
                setTimeout(function() {
                    window.location.href = '<?php echo site_url() . "/" . $controller_dir; ?>calendar_list/<?php echo $actor_type; ?>'
                }, 1500);
            } else if (data.status_response == status_response_error) {
                dialog_error({'header':text_toast_default_error_header, 'body': data.message_dialog});
            } 
        },
        error: function(xhr, status, error) {
            dialog_error({'header': text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
}
function setDefaultDateSetting() {

   
    flatpickr("#twst_start_date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        defaultDate: "<?php echo isset($row_twst) ? date('d/m/Y', strtotime($row_twst->twst_start_date . ' +543 years')) : date('d/m/Y', strtotime(date('Y/m/d') . ' +543 years')); ?>",
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
                document.getElementById('twst_start_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('twst_start_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    flatpickr("#twst_end_date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        // defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        defaultDate: "<?php echo isset($row_twst) ? date('d/m/Y', strtotime($row_twst->twst_end_date . ' +543 years')) : date('d/m/Y', strtotime(date('Y/m/d') . ' +543 years')); ?>",
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
                document.getElementById('twst_end_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('twst_end_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    flatpickr(`#twst_start_time`, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        defaultDate: "12:00"
    });

    flatpickr(`#twst_end_time`, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        defaultDate: "13:00"
    });
}
</script>