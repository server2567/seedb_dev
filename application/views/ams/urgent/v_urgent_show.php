<head>
    <style>
        #selected-patients-table tbody tr.hovered {
            background-color: #f0f0f0;
            /* Change background color on hover */
            cursor: pointer;
            /* Change cursor to pointer on hover */
        }

        /* Custom CSS to center-align the 1st and 3rd columns */
        .datatable td:nth-child(1),
        .datatable td:nth-child(6),
        .datatable td:nth-child(7) {
            text-align: center;
        }

        #patient-list td:nth-child(2),
        .datatable td:nth-child(3),
        .datatable td:nth-child(4),
        .datatable td:nth-child(5) {
            text-align: left;
        }

        #patient-draft-list td:nth-child(2),
        .datatable td:nth-child(3),
        .datatable td:nth-child(4),
        .datatable td:nth-child(5) {
            text-align: left;
        }

        @media (forced-colors: active) {
            body {
                background-color: black;
                /* ตั้งค่าตามที่ต้องการ */
                color: white;
                /* ตั้งค่าตามที่ต้องการ */
            }
        }

        .spinner-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            /* Ensure spinner is on top of modal content */
        }

        .spinner {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<div class="card">
    <div class="nav nav-tabs d-flex justify-content-start" role="tablist">
        <button class="nav-link w-20 active" id="ums-noti-tab" data-bs-toggle="tab" data-bs-target="#ums-noti" type="button" role="tab" aria-controls="ums-noti" aria-selected="true">การนัดหมาย</button>
        <button class="nav-link w-20" id="ums-his-tab" data-bs-toggle="tab" data-bs-target="#ums-his" type="button" role="tab" aria-controls="ums-his" aria-selected="false" tabindex="-1">ฉบับร่าง</button>
    </div>
    <div class="tab-content p-3">
        <div class="tab-pane fade active show" id="ums-noti" role="tabpanel" aria-labelledby="ums-noti-tab">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#filterCard" aria-expanded="falseCard" aria-controls="filterCard">
                                <i class="bi-newspaper icon-menu"></i><span>ค้นหาการนัดการหมาย</span>
                            </button>
                        </h2>
                        <div id="filterCard" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-3">
                                        <span>วันเริ่ม: </span>
                                        <input type="text" id="stardate_list" name="stratdate_list" class="form-control datepicker_th" placeholder="วว/ดด/ปปปป">
                                    </div>
                                    <div class="col-3">
                                        <span>วันที่สิ้นสุด: </span>
                                        <input type="text" id="enddate_list" name="enddate_list" class="form-control datepicker_th" placeholder="วว/ดด/ปปปป">
                                    </div>
                                    <div class="col-3">
                                        <span>สถานะการนัดหมาย: </span>
                                        <select name="" class="form-select select2" id="appoint_status">
                                            <option value="1" selected>รอการแจ้งเตือน</option>
                                            <option value="2">แจ้งเตือนแล้ว</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <span>แผนก: </span>
                                        <select name="" class="form-select select2 " id="stde_id">
                                            <?php foreach ($stde_info as $key => $value) { ?>
                                                <option value="<?= $value->stde_id ?>" <?= $key == 0 ? 'selected' : '' ?>><?= $value->stde_name_th ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-secondary float-start clear_filter_info">เคลียร์ข้อมูล</button>
                                        <div class="float-end">
                                            <button type="button" onclick="" class="btn btn-primary filter_info">ค้นหา</button>
                                        </div>
                                    </div>
                                </div>
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
                                <i class="bi-bell icon-menu"></i><span> ตารางรายชื่อผู้ป่วย</span><span class="badge bg-success" id="number"></span>
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table datatable" width="100%" id="patient-list">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-orderable="false">
                                                    <button id="selectAllPatientss" class="btn btn-primary btn-sm selectAllPatients"><i class="bi bi-check-square"></i> เลือกทั้งหมด</button>
                                                </th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">ชื่อ-นามสกุล</th>
                                                <th class="text-center">วันที่นัดหมาย</th>
                                                <th class="text-center">วันที่แจ้งเตือน</th>
                                                <th class="text-center">สถานะการนัดหมาย</th>
                                                <th class="text-center">ดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="patient-list-body">
                                            <?php foreach ($notify_list as $key => $item) { ?>
                                                <tr>
                                                    <td class="text-center "><input class="form-check-input group-select" type="checkbox" value='<?= $item->ap_id ?>'></td>
                                                    <td class="text-start patient-id"><?php echo $item->pt_member ?></td>
                                                    <td class="text-start patient-name"><?php echo $item->pt_prefix . ' ' . $item->pt_fname . ' ' . $item->pt_lname ?></td>
                                                    <td class="text-start"><?php echo  fullDateTH3($item->ap_date) ?></td>
                                                    <td class="text-start <?= $item->ap_ast_id == 1 ? 'text-warning' : 'text-success' ?>"><?php echo $item->ap_ast_id == 1 ? 'รอการแจ้งเตือน' : 'แจ้งเตือนแล้ว'  ?></td>
                                                    <td class="text-center option">
                                                        <button class="btn btn-warning single-urgent" id="single-urgent"><i class="bi bi-bell"></i></button>
                                                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="folat-start mt-2">
                                        <button id="urgent-patient-list" disabled class="btn btn-warning urgent-group">+ แจ้งเตือนด่วนแบบกลุ่ม</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="ums-his" role="tabpanel" aria-labelledby="ums-his-tab">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#filterCard" aria-expanded="falseCard" aria-controls="filterCard">
                                <i class="bi-newspaper icon-menu"></i><span>ค้นหาการนัดการหมาย</span>
                            </button>
                        </h2>
                        <div id="filterCard" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-4">
                                        <span>วันเริ่ม: </span>
                                        <input id="stardate_draft_list" type="date" class="form-control datepicker_th" placeholder="วว/ดด/ปปปป">
                                    </div>
                                    <div class="col-4">
                                        <span>วันที่สิ้นสุด: </span>
                                        <input id="enddate_draft_list" type="date" class="form-control datepicker_th" placeholder="วว/ดด/ปปปป">
                                    </div>
                                    <div class="col-4">
                                        <span>แผนก: </span>
                                        <select name="" class="form-select select2" id="stde_draft_id">
                                            <?php foreach ($stde_info as $key => $value) { ?>
                                                <option value="<?= $value->stde_id ?>" <?= $key == 0 ? 'selected' : '' ?>><?= $value->stde_name_th ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-secondary float-start clear_filter_draft_info">เคลียร์ข้อมูล</button>
                                        <div class="float-end">
                                            <button type="button" onclick="" class="btn btn-primary filter_draft_info">ค้นหา</button>
                                        </div>
                                    </div>
                                </div>
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
                                <i class="bi-bell icon-menu"></i><span> ตารางรายชื่อผู้ป่วย</span><span class="badge bg-success" id="numer-draft"></span>
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table datatable" width="100%" id="patient-draft-list">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-orderable="false">
                                                    <button id="selectAllPatientsDraft" class="btn btn-primary btn-sm selectAllPatients"><i class="bi bi-check-square"></i> เลือกทั้งหมด</button>
                                                </th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">ชื่อ-นามสกุล</th>
                                                <th class="text-center">วันที่นัดหมาย</th>
                                                <th class="text-center">วันที่แจ้งเตือน</th>
                                                <th class="text-center">สถานะการนัดหมาย</th>
                                                <th class="text-center">ดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="patient-draft-list-body">
                                            <?php foreach ($draft_list as $key => $item) { ?>
                                                <tr>
                                                    <td class="text-center "><input class="form-check-input group-select" type="checkbox" value='<?= $item->ap_id ?>'></td>
                                                    <td class="text-start patient-id"><?php echo $item->pt_member ?></td>
                                                    <td class="text-start patient-name"><?php echo $item->pt_prefix . ' ' . $item->pt_fname . ' ' . $item->pt_lname ?></td>
                                                    <td class="text-start"><?php echo  fullDateTH3($item->ap_date) ?></td>
                                                    <td class="text-start"><?php echo $item->cd_date ?></td>
                                                    <td class="text-start text-warning"><?php echo $item->ap_ast_id == 6 ? 'ฉบับร่าง' : ''  ?></td>
                                                    <td class="text-center option">
                                                        <button class="btn btn-warning single-urgent" id="single-urgent"><i class="bi bi-bell"></i></button>
                                                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="folat-start mt-2">
                                        <button id="urgent-patient-draft-list" disabled class="btn btn-warning urgent-group">+ แจ้งเตือนด่วนแบบกลุ่ม</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModal"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="spinner" class="spinner-container text-info" style="display: none;">
                    <div class="">Loading...</div>
                </div>
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#Selectedlist" aria-expanded="falseCard" aria-controls="filterCard">
                                <i class="bi-newspaper icon-menu"></i><span>ตารางรายชื่อผู้ป่วย</span>
                            </button>
                        </h2>
                        <div id="Selectedlist" class="accordion-collapse collapse show">
                            <div class="accordion-body m-1">
                                <table class="table table-bordered table-hover" id="selected-patients-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">HN</th>
                                            <th class="text-center">ชื่อ-นามสกุล</th>
                                            <th class="text-center">ระยะเวลาที่จะแจ้งเตือนโดยระบบ</th>
                                            <!-- <th class="text-center">ช่องทางการแจ้งเตือน</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Content will be dynamically added here -->
                                    </tbody>
                                </table>
                                <nav>
                                    <ul class="pagination de-flex justify-content-end" id="modalPagination">
                                        <!-- Pagination links for modal will be added dynamically here -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#SelectedDetail" aria-expanded="falseCard" aria-controls="SelectedDetail">
                                <i class="bi-newspaper icon-menu"></i><span>รายละเอียดการแจ้งนัดหมายเร่งด่วน</span>
                            </button>
                        </h2>
                        <div id="SelectedDetail" class="accordion-collapse collapse show" style="overflow-y: scroll;max-height:500px">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary float-start" data-bs-dismiss="modal">ปิด</button>
                <div class="float-end">
                    <button type="button" onclick="updateNotifyData('draft')" class="btn btn-warning">บันทึกฉบับร่าง</button>
                    <button type="button" id="urgent-button" onclick="updateNotifyData()" class="btn btn-primary">แจ้งเตือน</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var personInfo = {}
    var notify_list = {}
    var draft_list = {}
    var patient_list = []
    var encrypt_pt = []
    var selectedPatients = ''
    var status = '1';

    function updateDatepickerValues(selectedDates, instance) {
        if (selectedDates.length > 0) {
            var date = selectedDates[0];
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var yearBE = date.getFullYear();
            var yearTH = yearBE + 543;
            var formattedDate = day + '/' + month + '/' + yearTH;
            $(instance.element).val(formattedDate);
        }
    }

    function convertYearsToThai(instance) {
        const calendar = instance.calendarContainer;
        if (!calendar) return;

        // แปลงปีในปีปัจจุบันและปีที่เลือก
        const yearElements = calendar.querySelectorAll('.flatpickr-current-year, .cur-year, .numInput');
        yearElements.forEach(function(element) {
            const year = parseInt(element.value || element.textContent, 10);
            if (!isNaN(year)) {
                const thaiYear = year + 543;
                if (element.tagName === 'SPAN' || element.tagName === 'DIV') {
                    element.textContent = thaiYear;
                } else {
                    element.value = thaiYear;
                }
            }
        });

        // แปลงปีใน dropdown ปี
        const monthDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
        monthDropdowns.forEach(function(dropdown) {
            dropdown.querySelectorAll('option').forEach(function(option) {
                const year = parseInt(option.textContent, 10);
                if (!isNaN(year)) {
                    option.textContent = year + 543;
                }
            });
        });

        // อัปเดตปฏิทินในกรณีที่มีการเลือกวันที่
        const dateInput = instance.input;
        if (dateInput) {
            const date = new Date(dateInput.value);
            if (!isNaN(date.getTime())) {
                const yearBE = date.getFullYear();
                const yearTH = yearBE + 543;
                instance.input.value = instance.formatDate(date, 'd/m/Y', {
                    locale: 'th'
                });
            }
        }
    }
    flatpickr("#enddate_list", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        onReady: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates, instance);
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates, instance);
        },
    });
    flatpickr("#stardate_list", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        onReady: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates, instance);
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates, instance);
        },
    });
    flatpickr("#enddate_draft_list", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        onReady: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates, instance);
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates, instance);
        },
    });
    flatpickr("#stardate_draft_list", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        onReady: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates, instance);
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates, instance);
        },
    });

    $(document).ready(function() {
        // Inline edit button click handler
        // Bulk edit button click handler
        function parseDate(dateString) {
            var parts = dateString.split('/');
            // Note: parts[2] is the year in Buddhist Era (BE) format
            // Convert to Christian Era (CE) year
            var yearBE = parseInt(parts[2]);
            var yearCE = yearBE - 543;
            // Create a new Date object
            var date = new Date(yearCE, parts[1] - 1, parts[0]); // month is 0-based
            return date;
        }

        function convertYearsToThai(instance) {
            const calendar = instance.calendarContainer;
            if (!calendar) return;

            // ตรวจสอบปีที่แสดงอยู่
            const yearElements = calendar.querySelectorAll('.flatpickr-current-year, .cur-year, .numInput');
            yearElements.forEach(function(element) {
                let year = parseInt(element.value || element.textContent);
                if (!isNaN(year) && year < 2500) {
                    const thaiYear = year + 543;
                    // ตรวจสอบปีที่แสดงอยู่แล้ว
                    if (element.textContent !== thaiYear.toString()) {
                        if (element.tagName === 'SPAN' || element.tagName === 'DIV') {
                            element.textContent = thaiYear;
                        } else {
                            element.value = thaiYear;
                        }
                    }
                }
            });

            const monthDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
            monthDropdowns.forEach(function(dropdown) {
                dropdown.querySelectorAll('option').forEach(function(option) {
                    let year = parseInt(option.textContent);
                    if (!isNaN(year) && year < 2500) {
                        const thaiYear = year + 543;
                        if (option.textContent !== thaiYear.toString()) {
                            option.textContent = thaiYear;
                        }
                    }
                });
            });
        }
        $('#exampleModal').on('shown.bs.modal', function() {
            var now = new Date(); // วันที่ปัจจุบันd
            var minDate;
            $('#spinner').show();
            setTimeout(function() {
                // ซ่อน spinner เมื่อเนื้อหาโหลดเสร็จ
                $('#spinner').hide();
            }, 2000);
            tinymce.remove()
            tinymce.init({
                selector: 'textarea.tinymce-editor',
                height: 250,
                setup: function(editor) {
                    editor.on('init', function() {
                        // ทำให้ TinyMCE เต็มขนาดของคอนเทนเนอร์
                        editor.getContainer().style.width = '100%';
                    });
                }

            }); // Destroy existing TinyMCE editor
            // Check if current time is after 12:00 PM
            if (now.getHours() > 12 || (now.getHours() === 12 && now.getMinutes() > 1)) {
                // If time is after 12:00 PM, set minDate to tomorrow
                minDate = new Date(now);
                minDate.setDate(now.getDate() + 1);
            } else {
                // If time is before or exactly 12:00 PM, set minDate to today
                minDate = new Date(now);
            }
            // var minTime = minDate.toLocaleTimeString([], {
            //     hour: '2-digit',
            //     minute: '2-digit',
            //     hour12: false
            // });
            var currentTime = minDate.toTimeString().split(' ')[0].substring(0, 5);
            var input1 = document.querySelectorAll('[id^="appointdate-"]');
            input1.forEach(function(element) {
                patientId = element.id.replace('appointdate-', '')
                flatpickr(`#appointdate-${patientId}`, {
                    dateFormat: 'd/m/Y',
                    locale: 'th',
                    minDate: 'today',
                    onReady: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                        const [day, month, year] = element.value.split('-');
                        if (month) {
                            selectedDates = [new Date(year, month - 1, day)];
                        }
                        updateDatepickerValues(selectedDates, instance);
                    },
                    onOpen: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                    },
                    onMonthChange: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                    },
                    onYearChange: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                    },
                    onValueUpdate: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                        updateDatepickerValues(selectedDates, instance);
                    },
                    onChange: function(selectedDates, dateStr, instance) {
                        var selectedDate = parseDate(dateStr)
                        if (selectedDate.toDateString() === minDate.toDateString()) {
                            currentTime = minDate.toTimeString().split(' ')[0].substring(0, 5)
                        } else {
                            currentTime = '00:00'
                        }
                        flatpickr(".timepicker_th", {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: true,
                            minTime: currentTime,
                            allowInput: true,
                            defaultDate: currentTime
                        })
                    }
                });
                var maxDate = parseDate(element.value);
                var input2 = document.getElementById('reportDateInput-' + patientId);
                flatpickr(`#reportDateInput-${patientId}`, {
                    dateFormat: 'd/m/Y',
                    locale: 'th',
                    minDate: minDate, // ไม่ให้เลือกวันที่น้อยกว่าวันปัจจุบัน
                    maxDate: maxDate, // ไม่ให้เลือกวันที่มากกว่า input ที่ 1 หรือวันปัจจุบัน
                    onReady: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                        const [day, month, year] = input2.value.split('-');
                        if (month) {
                            selectedDates = [new Date(year, month - 1, day)];
                        }
                        updateDatepickerValues(selectedDates, instance);
                    },
                    onOpen: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                    },
                    onMonthChange: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                    },
                    onYearChange: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                    },
                    onValueUpdate: function(selectedDates, dateStr, instance) {
                        convertYearsToThai(instance);
                        updateDatepickerValues(selectedDates, instance);
                    }
                });
                flatpickr(".timepicker_th", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    // minDate: minDate,
                    allowInput: true,
                    time_24hr: true
                });
            })
            // document.querySelectorAll('.text-editor').forEach(function(element) {
            //     console.log(element);
            //     if (!tinymce.get(element)) { // Check if TinyMCE is already initialized
            //         tinymce.init({
            //             selector: `#${element.id}`,
            //             plugins: 'advlist autolink lists link image charmap preview anchor textcolor',
            //             toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            //             content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            //         });
            //     }
            // });
        });
        $('#exampleModal').on('hidden.bs.modal', function() {
            tinymce.remove()
        });

        function convertYearsToThai(instance) {
            const calendar = instance.calendarContainer;
            if (!calendar) return;

            // ตรวจสอบปีที่แสดงอยู่
            const yearElements = calendar.querySelectorAll('.flatpickr-current-year, .cur-year, .numInput');
            yearElements.forEach(function(element) {
                let year = parseInt(element.value || element.textContent);
                if (!isNaN(year) && year < 2500) {
                    const thaiYear = year + 543;
                    // ตรวจสอบปีที่แสดงอยู่แล้ว
                    if (element.textContent !== thaiYear.toString() && (element.tagName === 'SPAN' || element.tagName === 'DIV')) {
                        element.textContent = thaiYear;
                    } else if (element.value !== thaiYear.toString() && element.tagName !== 'SPAN' && element.tagName !== 'DIV') {
                        element.value = thaiYear;
                    }
                }
            });

            const monthDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
            monthDropdowns.forEach(function(dropdown) {
                dropdown.querySelectorAll('option').forEach(function(option) {
                    let year = parseInt(option.textContent);
                    if (!isNaN(year) && year < 2500) {
                        const thaiYear = year + 543;
                        if (option.textContent !== thaiYear.toString()) {
                            option.textContent = thaiYear;
                        }
                    }
                });
            });
        }
        $(document).on('change', '#patient-list .group-select', function() {
            const button = document.getElementById('urgent-patient-list');
            if ($('#patient-list .group-select:checked').length > 1) {
                button.disabled = false;
            } else {
                button.disabled = true;
            }
        });
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_patient_info',
            type: 'POST',
            contentType: 'application/json', // Set the content type to application/json
            processData: false, // No need to process the data
            success: function(data) {
                var json = JSON.parse(data);
                notify_list = json['notify_list']
                draft_list = json['draft_list']
                patient_list = patient_list.concat(notify_list, draft_list);
            },
            error: function(error) {
                dialog_error({
                    'header': 'แจ้งเตือนไม่สำเร็จ',
                    'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
                });
            }
        })
        $(document).on('change', '#patient-draft-list .group-select', function() {
            const button = document.getElementById('urgent-patient-draft-list');
            if ($('#patient-draft-list .group-select:checked').length > 1) {
                button.disabled = false;
            } else {
                button.disabled = true;
            }
        });

        function fullDateTH3(dateStr) {
            // Dummy implementation for fullDateTH3
            var date = new Date(dateStr);
            return date.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
        $('#urgent-patient-list').click(function() {
            selectedPatients = $('#patient-list .group-select:checked').closest('tr');
            var en_id = []
            selectedPatients.each(function() {
                // ดึงค่าของ .group-select ภายในแต่ละ <tr>
                var groupSelectValue = $(this).find('.group-select').val();
                const patientId = $(this).find('.patient-id').text().trim();
                en_id.push({
                    ap_id: groupSelectValue,
                    patientId: patientId
                });
            });
            const selectedCount = selectedPatients.length;
            if (selectedCount < 2) {
                return;
            }
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>encrypt_pt_id',
                type: 'POST',
                data: JSON.stringify(en_id),
                contentType: 'application/json', // Set the content type to application/json
                processData: false, // No need to process the data
                success: function(data) {
                    var json = JSON.parse(data);
                    var ap_id = json['ap_id']
                    personInfo = {};
                    json.forEach(element => {
                        var filtered = patient_list.filter(function(obj) {
                            return obj.ap_id === element.ap_id;
                        });
                        filtered.forEach(ft_info => {
                            if (!personInfo[ft_info.pt_member]) {
                                personInfo[ft_info.pt_member] = {
                                    ap_id: element.non_ap_id,
                                    contact_method: ft_info.ntf_name,
                                    ap_ast_id: ft_info.ap_ast_id,
                                    cd_date: ft_info.cd_date,
                                    al_day: element.al_day,
                                    days: ft_info.days,
                                    detail_appointment: ft_info.ap_detail_appointment,
                                    detail_prepare: ft_info.ap_detail_prepare,
                                    reportType: ft_info.ap_report_type,
                                    reportDate: ft_info.ap_rp_date,
                                    reportTime: ft_info.ap_rp_time,
                                    fixedDate: ft_info.ap_date,
                                    fixedTime: ft_info.ap_time
                                };
                            }
                        });
                    });
                    urgent_modal()
                    $('#TitleModal').html('แจ้งเตือนเร่งด่วนแบบรายบุคคล')
                },
                error: function(error) {
                    dialog_error({
                        'header': 'แจ้งเตือนไม่สำเร็จ',
                        'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
                    });
                }
            })
            $('#TitleModal').html('แจ้งเตือนเร่งด่วนแบบกลุ่ม');
            urgent_modal();
        });
        $(document).on('click', '.clear_filter_info', function() {
            const appointElement = document.getElementById('appoint_status');
            const stdeElement = document.getElementById('stde_id');
            const startElement = document.getElementById('stardate_list');
            const endElement = document.getElementById('enddate_list');
            appointElement.selectedIndex = 0;
            stdeElement.selectedIndex = 0;
            startElement.value = ''
            endElement.value = ''
            fetchPatientList(1);
        })
        $(document).on('click', '.clear_filter_draft_info', function() {
            const stdeElement = document.getElementById('stde_draft_id');
            const startElement = document.getElementById('stardate_draft_list');
            const endElement = document.getElementById('enddate_draft_list');
            stdeElement.selectedIndex = 0;
            startElement.value = ''
            endElement.value = ''
            fetchPatientList(2);
        })
        $(document).on('click', '.filter_info', function() {
            fetchPatientList(1);
        });
        $(document).on('click', '.filter_draft_info', function() {
            fetchPatientList(2);
        });
        fetchPatientList(1);
        fetchPatientList(2);
        // ในตาราง patient-draft-list

        $('#urgent-patient-draft-list').click(function() {
            selectedPatients = $('#patient-draft-list .group-select:checked').closest('tr');
            var en_id = []
            selectedPatients.each(function() {
                // ดึงค่าของ .group-select ภายในแต่ละ <tr>
                var groupSelectValue = $(this).find('.group-select').val();
                const patientId = $(this).find('.patient-id').text().trim();
                en_id.push({
                    ap_id: groupSelectValue,
                    patientId: patientId
                });
            });
            const selectedCount = selectedPatients.length;
            if (selectedCount < 2) {
                return;
            }
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>encrypt_pt_id',
                type: 'POST',
                data: JSON.stringify(en_id),
                contentType: 'application/json', // Set the content type to application/json
                processData: false, // No need to process the data
                success: function(data) {
                    var json = JSON.parse(data);
                    personInfo = {};
                    json.forEach(element => {
                        var filtered = patient_list.filter(function(obj) {
                            return obj.ap_id === element.ap_id;
                        });
                        filtered.forEach(ft_info => {
                            if (!personInfo[ft_info.pt_member]) {
                                personInfo[ft_info.pt_member] = {
                                    ap_id: element.non_ap_id,
                                    ap_ast_id: ft_info.ap_ast_id,
                                    contact_method: ft_info.ntf_name,
                                    cd_date: ft_info.cd_date,
                                    al_day: element.al_day,
                                    days: ft_info.days,
                                    detail_appointment: ft_info.ap_detail_appointment,
                                    detail_prepare: ft_info.ap_detail_prepare,
                                    reportType: ft_info.ap_report_type,
                                    reportDate: ft_info.ap_rp_date,
                                    reportTime: ft_info.ap_rp_time,
                                    fixedDate: ft_info.ap_date,
                                    fixedTime: ft_info.ap_time
                                };
                            }
                        });
                    });
                    urgent_modal()
                    $('#TitleModal').html('แจ้งเตือนเร่งด่วนแบบรายบุคคล')
                },
                error: function(error) {
                    dialog_error({
                        'header': 'แจ้งเตือนไม่สำเร็จ',
                        'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
                    });
                }
            })
            $('#TitleModal').html('แจ้งเตือนเร่งด่วนแบบกลุ่ม');
            urgent_modal();
        });
        $(document).on('click', '.single-urgent', function() {
            selectedPatients = $(this).closest('tr');
            var groupSelectValue = selectedPatients.find('.group-select').val();
            var en_id = [{
                ap_id: groupSelectValue
            }]
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>encrypt_pt_id',
                type: 'POST',
                data: JSON.stringify(en_id),
                contentType: 'application/json', // Set the content type to application/json
                processData: false, // No need to process the data
                success: function(data) {
                    var json = JSON.parse(data);
                    var ap_id = json[0]['ap_id']
                    var non_ap_id = json[0]['non_ap_id']
                    var patientId = selectedPatients.find('.patient-id').text().trim();
                    personInfo = {};
                    patient_list.forEach(element => {
                        if (element.ap_id == ap_id) {
                            if (!personInfo[patientId]) {
                                personInfo[patientId] = {
                                    ap_id: non_ap_id,
                                    ap_ast_id: element.ap_ast_id,
                                    contact_method: element.ntf_name,
                                    cd_date: element.cd_date,
                                    al_day: element.al_day,
                                    days: element.days,
                                    detail_appointment: element.ap_detail_appointment,
                                    detail_prepare: element.ap_detail_prepare,
                                    reportType: element.ap_report_type,
                                    reportDate: element.ap_rp_date,
                                    reportTime: element.ap_rp_time,
                                    fixedDate: element.ap_date,
                                    fixedTime: element.ap_time
                                };
                            }
                        }
                    });
                    urgent_modal()
                    $('#TitleModal').html('แจ้งเตือนเร่งด่วนแบบรายบุคคล')
                },
                error: function(error) {
                    dialog_error({
                        'header': 'แจ้งเตือนไม่สำเร็จ',
                        'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
                    });
                }
            })
        });
        $('.selectAllPatients').click(function() {
            const tableId = $(this).closest('table').attr('id'); // ดึง ID ของตารางที่คลิกอยู่
            const checkboxes = $('#' + tableId + ' .group-select'); // เลือก checkbox ภายในตารางนั้นๆ
            const isChecked = $(this).hasClass('active');
            if (isChecked) {
                checkboxes.prop('checked', false);
                $(this).removeClass('active');
            } else {
                checkboxes.prop('checked', true);
                $(this).addClass('active');
            }
            const button = $('#urgent-' + tableId);
            const selectedCount = $('#' + tableId + ' .group-select:checked').length;
            if (selectedCount > 1) {
                button.prop('disabled', false);
            } else {
                button.prop('disabled', true);
            }
        });

        function fetchPatientList(type_table) {
            var tbody, stde_id, appoint_status, table, dataTable;
            if (type_table == 1) {
                tbody = $('#patient-list-body');
                start_date = $('#stardate_list').val()
                end_date = $('#enddate_list').val()
                stde_id = $('#stde_id').val();
                appoint_status = $('#appoint_status').val();
                table = document.querySelector("#patient-list");
                dataTable = new DataTable(table);
            } else {
                tbody = $('#patient-draft-list-body');
                start_date = $('#stardate_draft_list').val()
                end_date = $('#enddate_draft_list').val()
                stde_id = $('#stde_draft_id').val();
                appoint_status = 6;
                table = document.querySelector("#patient-draft-list");
                dataTable = new DataTable(table);
            }
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_patien_list_by_filter',
                method: 'POST',
                data: {
                    stde_id: stde_id,
                    start_date: start_date,
                    end_date: end_date,
                    appoint_status: appoint_status
                }
            }).done(function(returnedData) {
                var data = JSON.parse(returnedData);
                dataTable.clear().draw();
                var dataInfo;
                if (type_table == 1) {
                    dataInfo = data['patien-list'];
                    $('#number').html(dataInfo.length);
                } else {
                    dataInfo = data['patien-draft'];
                    $('#numer-draft').html(dataInfo.length);
                }
                // if (dataInfo.length <= 0) {
                //     dataTable.row.add([
                //         'ไม่มีข้อมูลบุคลากร', '', '', '', '', ''
                //     ]).draw();
                //     return 0;
                // }
                dataInfo.forEach(function(item) {
                    var appointmentStatusClass = item.ap_ast_id == 6 ? 'text-warning' : item.ap_ast_id == 2 ? 'text-success' : 'text-warning';
                    var appointmentStatusText = item.ap_ast_id == 6 ? 'ฉบับร่าง' : item.ap_ast_id == 2 ? 'แจ้งเตือนแล้ว' : 'รอการแจ้งเตือน';

                    dataTable.row.add([
                        `<input class="form-check-input group-select" type="checkbox" value="${item.ap_id}">`,
                        `<span class="patient-id">${item.pt_member} </span>`,
                        `<span class="patient-name">${item.pt_prefix} ${item.pt_fname} ${item.pt_lname}</span>`,
                        fullDateTH3(item.ap_date),
                        `<span class="${item.days >= 0 ? 'text-warning':item.ap_ast_id == 2 ?'':'text-danger'}">${item.cd_date} </span>`,
                        `<span class="${appointmentStatusClass}">${appointmentStatusText}</span>`,
                        `<button class="btn btn-warning single-urgent" id="single-urgent"><i class="bi bi-bell"></i></button>
                         <button class="btn btn-primary"><i class="bi bi-search"></i></button>`
                    ]).draw();
                });
            });
        }

        // Function to handle patient selection
        function handlePatientSelection(row) {
            var selectedPatients = []; // สร้างอาร์เรย์เพื่อเก็บข้อมูลผู้ป่วยที่ถูกเลือก
            var htmlContent = '';
            $(row).each(function(index, element) {
                // แสดงค่า value ของ option ที่ถูกเลือกใน dropdown
                const patientId = $(element).find('.patient-id').text().trim();
                const patientName = $(element).find('.patient-name').text().trim();
                // กำหนดค่าเริ่มต้นในกรณีที่ไม่มีข้อมูลใน personInfo
                const person = personInfo[patientId]
                if (person) {
                    htmlContent += `
                    <div class="accordion-body m-1">
                        <div class="row">
                            <div class="col-12 text-end">
                                <button name="copy_by_${patientId}" class="btn btn-warning copy_info">คัดลอกข้อมูลการนัดหมาย</button>
                            </div>
                            <div class="col-12">
                                <p><b>HN: </b><span id="selectedPatientId">${patientId}</span></p>
                            </div>
                            <div class="col-12">
                                <p><b>ชื่อ-นามสกุล: </b><span id="selectedPatientName">${patientName}</span></p>
                            </div>
                            <div class="col-6">
                                <p><b>เหตุผลการแจ้งเตือนการนัดหมาย </b> <span class="text-danger"> *</span></p>
                                <textarea class="form-control mt-2 infoTextarea " style="height:100px;" name="" id="infoTextarea-${patientId}">${person.detail_appointment}</textarea>
                            </div>
                            <div class="col-6">
                                <p><b>การเตรียมตัวก่อนมาพบแพทย์ </b><span class="text-danger"> *</span></p>
                                <textarea class="form-control mt-2 prepareTextarea " style="height:100px;" name="" id="prepareTextarea-${patientId}">${person.detail_prepare}</textarea>
                            </div>
                            <div class="col-6 row mt-4">
                                            <div class="col-sm-12 col-md-6">
                                            <b class="mb-2">กำหนดวันที่ต้องการนัดหมาย</b>
                                            <input type="text" id="appointdate-${patientId}" class="mt-3 form-control  datepicker_th" value="${person.fixedDate}">
                                            </div>
                                            <div class="col-sm-12 col-md-6 ">
                                            <b>กำหนดเวลาที่ต้องการนัดหมาย</b>
                                            <input type="time" id="appointtime-${patientId}" class="mt-3 form-control appointTimeInput timepicker_th" value="${person.fixedTime}">
                                            </div>                                     
                            </div>
                            <div class="col-6 row mt-4">
                                <div class="col-md-12 col-lg-3">
                                    <input type="radio" name="report${patientId}" id="nowReport" class="form-check-input report " ${person.reportType === '2' ? 'checked' : ''}> แจ้งเตือนทันที
                                </div>
                                <div class="col-md-12 col-lg-5">
                                    <input type="radio" name="report${patientId}" id="fixDate" class="form-check-input report " ${person.reportType === '1' ? 'checked' : ''}> กำหนดวันและเวลาแจ้งเตือน
                                </div>
                                <div class="col-12 mt-2">
                                    <div id="date-time" class="row">
                                        ${person.reportType === '1' ? `
                                        <div class="col-md-6 col-sm-12">
                                            <input type="text" id="reportDateInput-${patientId}" class="form-control mt-2 fixedDateInput" value="${person.reportDate}">
                                        </div>
                                         <div class="col-md-6 col-sm-12">
                                          <span class="text-danger"><u> Note</u></span><br>
                                          <span class="text-danger">- ระบบจะแจ้งเตือน ณ เวลา 12.30 น. ของทุกวัน</span><br>
                                          <span class="text-danger">- ผู้ใช้ต้องกำหนดวันนัดหมายให้ถูกต้องก่อนกำหนดวันแจ้งเตือน</span><br>
                                        </div>    ` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    `;
                }
                $(document).on('click', '.copy_info', function(e) {
                    e.stopPropagation();
                    // หาธาตุที่มีคลาส .row ที่ใกล้ที่สุด
                    var row = $(this).closest('.row');
                    var clickedButtonName = $(this).attr('name');
                    var numberOnly = clickedButtonName.replace('copy_by_', '');
                    copy_info(numberOnly).then((selectedId) => {
                        if (selectedId !== undefined && selectedId !== null) {
                            var infoTextarea = row.find('.infoTextarea')
                            var editorInfo = tinymce.get(infoTextarea.attr('id'));
                            var prepareTextarea = row.find('.prepareTextarea')
                            var editorPrepare = tinymce.get(prepareTextarea.attr('id'));
                            personInfo[numberOnly]['detail_appointment'] = personInfo[selectedId]['detail_appointment']
                            personInfo[numberOnly]['detail_prepare'] = personInfo[selectedId]['detail_prepare']
                            editorInfo.setContent(personInfo[selectedId]['detail_appointment'])
                            editorPrepare.setContent(personInfo[selectedId]['detail_prepare'])
                            var nowReport = row.find('#nowReport')
                            var fixDate = row.find('#fixDate')
                            if (personInfo[selectedId]['reportType'] == 2) {
                                nowReport.attr('checked', '');
                                fixDate.removeAttr('data-value');
                                personInfo[numberOnly]['reportType'] = personInfo[selectedId]['reportType']
                                row.find('#date-time').html('');
                            } else {
                                fixDate.attr('checked', '');
                                nowReport.removeAttr('data-value');
                                personInfo[numberOnly]['reportType'] = personInfo[selectedId]['reportType']
                                var fixedDateInput = row.find(`#appointdate-${numberOnly}`)
                                var fixedTimeInput = row.find(`#appointtime-${numberOnly}`)
                                var [day, month, yearTH] = personInfo[selectedId]['fixedDate'].split('/')
                                const [hour, minute] = personInfo[selectedId]['fixedTime'].split(':');
                                if (!month) {
                                    [day, month, yearTH] = personInfo[selectedId]['fixedDate'].split('-')
                                    const yearAD = parseInt(yearTH, 10) + 543;
                                    fixedDateInput.val(`${day}/${month}/${yearAD}`)
                                } else {
                                    fixedDateInput.val(personInfo[selectedId]['fixedDate'])
                                }
                                fixedTimeInput.val(`${hour}:${minute}`)
                                var [day2, month2, yearTH2] = personInfo[patientId]['reportDate'].split('-');
                                // แปลงปี พ.ศ. เป็น ค.ศ.
                                if (yearTH2) {
                                    const yearAD = parseInt(yearTH2, 10) + 543;
                                    var adDateString = `${day2}/${month2}/${yearAD}`;
                                } else {
                                    var adDateString = personInfo[patientId]['reportDate']
                                }
                                row.find('#date-time').html(`
                                    <div class="col-md-6 col-sm-12">
                                    <input type="text" id="reportDateInput-${numberOnly}" class="form-control fixedDateInput mt-2 " value="${adDateString || ''}">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                          <span class="text-danger"><u> Note</u></span><br>
                                          <span class="text-danger">- ระบบจะแจ้งเตือน ณ เวลา 12.30 น. ของทุกวัน</span><br>
                                          <span class="text-danger">- ผู้ใช้ต้องกำหนดวันนัดหมายให้ถูกต้องก่อนกำหนดวันแจ้งเตือน</span><br>
                                    </div>
                                `);
                                // var now = new Date(); // วันที่ปัจจุบัน
                                // var minDate;
                                // // Check if current time is after 12:00 PM
                                // if (now.getHours() > 12 || (now.getHours() === 12 && now.getMinutes() > 1)) {
                                //     // If time is after 12:00 PM, set minDate to tomorrow
                                //     minDate = new Date(now);
                                //     minDate.setDate(now.getDate() + 1);
                                // } else {
                                //     // If time is before or exactly 12:00 PM, set minDate to today
                                //     minDate = new Date(now);
                                // }
                                personInfo[numberOnly]['fixedDate'] = personInfo[selectedId]['fixedDate']
                                personInfo[numberOnly]['reportDate'] = personInfo[selectedId]['reportDate']
                                personInfo[numberOnly]['fixedTime'] = personInfo[selectedId]['fixedTime']
                                personInfo[numberOnly]['reportTime'] = personInfo[selectedId]['reportTime']
                                var input1 = document.getElementById('appointdate-' + selectedId);
                                var maxDate = parseDate(input1.value);
                                var now = new Date(); // วันที่ปัจจุบัน
                                var minDate;
                                // Check if current time is after 12:00 PM
                                if (now.getHours() > 12 || (now.getHours() === 12 && now.getMinutes() > 1)) {
                                    // If time is after 12:00 PM, set minDate to tomorrow
                                    minDate = new Date(now);
                                    minDate.setDate(now.getDate() + 1);
                                } else {
                                    // If time is before or exactly 12:00 PM, set minDate to today
                                    minDate = new Date(now);
                                }
                                flatpickr(`#reportDateInput-${numberOnly}`, {
                                    dateFormat: 'd/m/Y',
                                    locale: 'th',
                                    maxDate: maxDate,
                                    minDate: minDate,
                                    onReady: function(selectedDates, dateStr, instance) {
                                        convertYearsToThai(instance);
                                        updateDatepickerValues(selectedDates, instance);
                                    },
                                    onOpen: function(selectedDates, dateStr, instance) {
                                        convertYearsToThai(instance);
                                    },
                                    onMonthChange: function(selectedDates, dateStr, instance) {
                                        convertYearsToThai(instance);
                                    },
                                    onYearChange: function(selectedDates, dateStr, instance) {
                                        convertYearsToThai(instance);
                                    },
                                    onValueUpdate: function(selectedDates, dateStr, instance) {
                                        convertYearsToThai(instance);
                                        updateDatepickerValues(selectedDates, instance);
                                    },
                                });
                                flatpickr(".fixedTimeInput", {
                                    enableTime: true,
                                    noCalendar: true,
                                    dateFormat: "H:i",
                                    time_24hr: true,
                                    allowInput: true
                                });
                            }
                            // Further actions with selectedId
                        } else {

                        }
                    }).catch((error) => {
                        console.error('Error:', error);
                        // Handle errors if any
                    });
                });
                var lastChecked;
                // เพิ่ม Event Listener สำหรับ Radio Buttons
                $(document).on('click', `input[type="radio"]`, function() {
                    if (lastChecked && lastChecked[0] === this) {
                        $(this).prop('checked', false);
                        lastChecked = null;
                        const selectedPatientRow = $(this).closest('.accordion-body');
                        personInfo[patientId]['reportType'] = 'NULL';
                        selectedPatientRow.find('#date-time').html('');
                    } else {
                        lastChecked = $(this);
                    }
                });
                $(document).on('change', `input[name="report${patientId}"]`, function() {
                    const $selectedPatientRow = $(this).closest('.accordion-body');
                    if (!personInfo[patientId]) {
                        personInfo[patientId] = {
                            detail: '',
                            reportType: '',
                            fixedDate: '',
                            fixedTime: ''
                        };
                    }
                    if ($(this).is(':checked')) {
                        if ($(this).attr('id') === 'nowReport') {
                            // Update report type to 'now' and clear date-time inputs
                            personInfo[patientId]['reportType'] = '2';
                            const isoDateString = new Date().toLocaleString('en-CA', {
                                timeZone: 'Asia/Bangkok'
                            }).split(',')[0];
                            const [year, month, day] = isoDateString.split('-');
                            personInfo[patientId]['reportDate'] = `${day}-${month}-${year}`;
                            // Get current time in HH:MM format
                            personInfo[patientId]['reportTime'] = new Date().toLocaleTimeString('en-US', {
                                timeZone: 'Asia/Bangkok',
                                hour12: false
                            });
                            $selectedPatientRow.find('#date-time').html('');
                        } else if ($(this).attr('id') === 'fixDate') {
                            // Update report type to 'fixDate' and show date-time inputs
                            personInfo[patientId]['reportType'] = '1';
                            $selectedPatientRow.find('#date-time').html(`
                            <div class="col-md-6 col-sm-12">
                                <input type="text" id="reportDateInput-${patientId}" class="form-control mt-2 fixedDateInput " value="${personInfo[patientId]['reportDate'] || ''}">
                            </div>
                            <div class="col-md-6 col-sm-12">
                                        <span class="text-danger"><u> Note</u></span><br>
                                          <span class="text-danger">- ระบบจะแจ้งเตือน ณ เวลา 12.30 น. ของทุกวัน</span><br>
                                          <span class="text-danger">- ผู้ใช้ต้องกำหนดวันนัดหมายให้ถูกต้องก่อนกำหนดวันแจ้งเตือน</span><br>
                             </div>`);
                        }
                        var appoint = document.getElementById('appointdate-' + patientId);
                        var fixedDate = document.getElementById('reportDateInput-' + patientId);
                        var maxDate = parseDate(appoint.value);
                        var now = new Date();
                        var minDate;

                        // Check if current time is after 12:00 PM
                        if (now.getHours() > 12 || (now.getHours() === 12 && now.getMinutes() > 1)) {
                            // If time is after 12:00 PM, set minDate to tomorrow
                            minDate = new Date(now);
                            minDate.setDate(now.getDate() + 1);
                        } else {
                            // If time is before or exactly 12:00 PM, set minDate to today
                            minDate = new Date(now);
                        }
                        var minTime = minDate.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        });
                        flatpickr(`#reportDateInput-${patientId}`, {
                            dateFormat: 'd/m/Y',
                            locale: 'th',
                            maxDate: maxDate,
                            minDate: minDate,
                            defaultDate: minDate,
                            onReady: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                                const [day, month, year] = personInfo[patientId]['reportDate'] != null ? personInfo[patientId]['reportDate'].split('-') : '';
                                if (month) {
                                    selectedDates = [new Date(year, month - 1, day)];
                                }
                                updateDatepickerValues(selectedDates, instance);
                            },
                            onOpen: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                            },
                            onMonthChange: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                            },
                            onYearChange: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                            },
                            onValueUpdate: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                                updateDatepickerValues(selectedDates, instance);
                            },
                        });
                        // flatpickr(`#reportTimeInput-${patientId}`, {
                        //     enableTime: true,
                        //     noCalendar: true,
                        //     dateFormat: "H:i",
                        //     time_24hr: true,
                        //     minTime: minTime,
                        //     defaultDate: minTime
                        // });
                    }
                });
                $(document).on('change', '[id^=appointdate]', function() {
                    const patientId = $(this).attr('id').split('-')[1]; // Extract patientId from the ID attribute
                    personInfo[patientId]['fixedDate'] = $(this).val();
                    var input1 = document.getElementById('appointdate-' + patientId);
                    var input2 = document.getElementById('reportDateInput-' + patientId);
                    var maxDate = parseDate(input1.value);
                    var now = new Date(); // วันที่ปัจจุบัน
                    var check = false;
                    var minDate;
                    if (now.getHours() > 12 || (now.getHours() === 12 && now.getMinutes() > 1)) {
                        // If time is after 12:00 PM, set minDate to tomorrow
                        minDate = new Date(now);
                        minDate.setDate(now.getDate() + 1);
                    } else {
                        // If time is before or exactly 12:00 PM, set minDate to today
                        minDate = new Date(now);
                    }
                    // Check if current time is after 12:00 PM
                    var selectedDate = parseDate($(this).val())
                    if (selectedDate.toDateString() === now.toDateString()) {
                        currentTime = now.toTimeString().split(' ')[0].substring(0, 5)
                        if (check == true) {
                            maxDate = minDate
                        }
                    } else {
                        currentTime = '00:00'
                    }
                    personInfo[patientId]['fixedTime'] = currentTime
                    if (input2) {
                        flatpickr(input2, {
                            dateFormat: 'd/m/Y',
                            locale: 'th',
                            minDate: minDate, // ไม่ให้เลือกวันที่น้อยกว่าวันปัจจุบัน
                            maxDate: maxDate, // ไม่ให้เลือกวันที่มากกว่า input ที่ 1 หรือวันปัจจุบัน
                            defaultDate: minDate,
                            onReady: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                                updateDatepickerValues(selectedDates, instance);
                            },
                            onOpen: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                            },
                            onMonthChange: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                            },
                            onYearChange: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                            },
                            onValueUpdate: function(selectedDates, dateStr, instance) {
                                convertYearsToThai(instance);
                                updateDatepickerValues(selectedDates, instance);
                            },
                        });
                    }
                    flatpickr(`#appointtime-${patientId}`, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true,
                        minTime: currentTime,
                        allowInput: true,
                        defaultDate: currentTime
                    });
                });
                // Handle change event for fixedTimeInput
                $(document).on('change', '[id^=appointtime]', function() {
                    const patientId = $(this).attr('id').split('-')[1]; // Extract patientId from the ID attribute
                    personInfo[patientId]['fixedTime'] = $(this).val();
                });
                $(document).on('change', '[id^=reportDateInput]', function() {
                    const patientId = $(this).attr('id').split('-')[1]; // Extract patientId from the ID attribute
                    personInfo[patientId]['reportDate'] = $(this).val();
                    // var minDate = new Date(); // วันที่ปัจจุบันd
                    // var minTime = minDate.toLocaleTimeString([], {
                    //     hour: '2-digit',
                    //     minute: '2-digit',
                    //     hour12: false
                    // });
                    // var selectedDate = parseDate($(this).val())
                    // if (selectedDate.toDateString() === minDate.toDateString()) {
                    //     currentTime = minDate.toTimeString().split(' ')[0].substring(0, 5)
                    // } else {
                    //     currentTime = '00:00'
                    // }
                    // flatpickr(`#reportTimeInput-${patientId}`, {
                    //     enableTime: true,
                    //     noCalendar: true,
                    //     dateFormat: "H:i",
                    //     time_24hr: true,
                    //     minTime: currentTime,
                    //     defaultDate: currentTime
                    // });
                });
                // Handle change event for fixedTimeInput
                // $(document).on('change', '[id^=reportTimeInput]', function() {
                //     const patientId = $(this).attr('id').split('-')[1]; // Extract patientId from the ID attribute
                //     personInfo[patientId]['reportTime'] = $(this).val();
                // });
            });
            // อัพเดทเนื้อหาใน element ที่มี id="SelectedDetail"
            $('#SelectedDetail').html(htmlContent);
            $(document).on('input', '.infoTextarea', function() {
                const $selectedPatientRow = $(this).closest('.accordion-body'); // หากข้อมูลใน textarea ในหน้าต่างที่เปิดอยู่
                const patientId = $selectedPatientRow.find('#selectedPatientId').text().trim(); // รับ ID ของผู้ป่วยที่เลือก
                const infoText = $(this).val(); // รับค่าของ textarea ที่กรอก
                if (!personInfo[patientId]) {
                    personInfo[patientId] = {};
                }
                console.log(infoText);
                
                // บันทึกข้อมูลของผู้ป่วยที่เลือกไว้ใน key 'detail'
                personInfo[patientId]['detail_appointment'] = infoText;
            });
            $(document).on('change', '.prepareTextarea', function() {
                const $selectedPatientRow = $(this).closest('.accordion-body'); // หากข้อมูลใน textarea ในหน้าต่างที่เปิดอยู่
                const patientId = $selectedPatientRow.find('#selectedPatientId').text().trim(); // รับ ID ของผู้ป่วยที่เลือก
                const infoText = $(this).val(); // รับค่าของ textarea ที่กรอก
                if (!personInfo[patientId]) {
                    personInfo[patientId] = {};
                }
                // บันทึกข้อมูลของผู้ป่วยที่เลือกไว้ใน key 'detail'
                personInfo[patientId]['detail_prepare'] = infoText;
            });

        }

        function urgent_modal() {
            // Populate the modal with selected patients
            const modalTableBody = $('#selected-patients-table tbody');
            modalTableBody.empty();
            var index = 1
            selectedPatients.each(function() {
                var patientId = $(this).find('.patient-id').text().trim();
                const patientName = $(this).find('.patient-name').text();
                if (personInfo[patientId]) {
                    modalTableBody.append(`
                        <tr>
                            <td class="text-center">${index}</td>
                            <td class="patient-id">${patientId}</td>
                            <td class="patient-name">${patientName}</td>
                            <td class="${personInfo[patientId]['days'] < 0 ? personInfo[patientId]['ap_ast_id'] == 2 ? '' : 'text-danger' :'text-warning'}">${personInfo[patientId]['cd_date']}</td>
                        </tr>
                    `); //       <td>${personInfo[patientId]['contact_method']}</td>
                    index++;
                }
            });
            tinymce.init({
                selector: 'textarea.tinymce-editor',
                height: 300
            });
            // Show the modal
            $('#exampleModal').modal('show');

            const rowsPerPage = 5;
            // Add pagination for the modal table
            const rows = $('#selected-patients-table tbody tr');
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const pagination = $('#modalPagination');
            // Function to save textarea data when it changes
            // $(document).on('input', '.infoTextarea', function() {
            //     const $selectedPatientRow = $(this).closest('.accordion-body'); // หากข้อมูลใน textarea ในหน้าต่างที่เปิดอยู่
            //     const patientId = $selectedPatientRow.find('#selectedPatientId').text().trim(); // รับ ID ของผู้ป่วยที่เลือก
            //     const infoText = $(this).val(); // รับค่าของ textarea ที่กรอก
            //     if (!personInfo[patientId]) {
            //         personInfo[patientId] = {};
            //     }
            //     // บันทึกข้อมูลของผู้ป่วยที่เลือกไว้ใน key 'detail'
            //     personInfo[patientId]['detail_appointment'] = infoText;
            // });
            pagination.empty();
            for (let i = 1; i <= totalPages; i++) {
                const pageItem = `<li class="page-item"><a class="page-link" href="#">${i}</a></li>`;
                pagination.append(pageItem);
            }

            pagination.on('click', '.page-link', function(e) {
                e.preventDefault();
                const pageIndex = $(this).text() - 1;
                rows.hide();
                rows.slice(pageIndex * rowsPerPage, (pageIndex + 1) * rowsPerPage).show();
            });

            // Show the first page
            rows.hide();
            rows.slice(0, rowsPerPage).show();
            // Select the first patient by default
            handlePatientSelection(rows);
        }
        // Event listener for clicking on a patient row

        // Event listener for hovering on a patient row
        $('#selected-patients-table tbody').on('mouseenter', 'tr', function() {
            $(this).addClass('hovered');
        }).on('mouseleave', 'tr', function() {
            $(this).removeClass('hovered');
        });

        // Handle change event for fixedDateInput
        function copy_info(id) {
            return new Promise((resolve, reject) => {
                if (personInfo[id]) {
                    let optionsHtml = '';
                    Object.keys(personInfo).forEach((key) => {
                        optionsHtml += `<option value="${key}">${key}</option>`;
                    });

                    Swal.fire({
                        title: 'คัดลอกข้อมูลการแจ้งเตือนนัดผู้ป่วย',
                        html: `<select class="form-select select2" id="swalSelect" style="width: 100%;">
                        <option value="" disabled selected>เลือก HN เพื่อคัดลอก</option>
                        ${optionsHtml}
                      </select>`,
                        showCancelButton: true,
                        allowOutsideClick: false,
                        cancelButtonText: 'ยกเลิก',
                        confirmButtonText: 'ตกลง',
                        preConfirm: () => {
                            return $('#swalSelect').val();
                        }
                        // didOpen: () => {
                        //     $('.select2').select2();
                        // }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Resolve the selected value
                            resolve(result.value);
                        } else {
                            // User canceled the dialog or didn't select anything
                            resolve(null); // Resolve with null if no option selected
                        }
                    }).catch((error) => {
                        reject(error); // Reject if there's an error
                    });

                } else {
                    resolve(null); // Resolve with null if there's an error
                }
            });
        }
    });

    function initTinyMCE() {
        // Destroy any existing TinyMCE instance
        if (tinymce.get('ap_detail_appointment')) {
            tinymce.get('ap_detail_appointment').remove();
        }
        if (tinymce.get('ap_detail_prepare')) {
            tinymce.get('ap_detail_prepare').remove();
        }

        // Initialize TinyMCE
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 300
        });
    }

    function updateNotifyData(type) {
        if (type == 'draft') {
            status = '6'
        }
        
        let check = true
        Object.entries(personInfo).forEach(([key, value]) => {
            if (value['detail_appointment'] == '' || value['detail_prepare'] == '') {
                dialog_error({
                    'header': 'แจ้งเตือนไม่สำเร็จ',
                    'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
                });
                check = false
            }
        });
        if (check == false) {
            return;
        }
        
        var urgent_button = document.getElementById("urgent-button")
        urgent_button.innerHTML = `<div class="spinner-border text-primary" role="status">
              </div>` // เปลี่ยน content ให้เป็น spinner
        urgent_button.disabled = true; // ทำการ disable ปุ่ม
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>report_urgent',
            type: 'POST',
            data: JSON.stringify({
                data: personInfo,
                type: status
            }),
            contentType: 'application/json', // Set the content type to application/json
            processData: false, // No need to process the data
            success: function(data) {
                dialog_success({
                    'header': '',
                    'body': 'บันทึกการแจ้งเตือนสำเร็จ'
                });
                $('#exampleModal').modal('hide');
                // setInterval(function() {
                //     location.reload();
                // }, 1000);
            },
            error: function(error) {
                dialog_error({
                    'header': 'แจ้งเตือนไม่สำเร็จ',
                    'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
                });
            }
        })
    }
</script>