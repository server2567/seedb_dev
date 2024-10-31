<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหารายการลา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                       
                        <div class="col-md-4">
                            <label for="leaves_date" class="form-label">วันที่ลา</label>
                            <div class="input-group" id="leaves_date" name="leaves_date">
                                <input type="text" class="form-control" name="leaves_start_date" id="leaves_start_date" value="">
                                <span class="input-group-text">ถึง</span>
                                <input type="text" class="form-control" name="leaves_end_date" id="leaves_end_date" value="">
                            </div>
                        </div> 
                        <div class="col-4">
                            <label for="leaves_type" class="form-label">ประเภทการลา</label>
                            <select class="select2" name="leaves_type" id="leaves_type">
                                <option value="-1" disabled>-- เลือกประเภทการลา --</option>
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="1">ลาป่วย</option>
                                <option value="2">ลากิจส่วนตัว</option>
                                <option value="3">ลาพักผ่อน</option>
                                <option value="4">ลาคลอดบุตร</option>
                                <option value="5">ลาอุปสมบทหรือลาไปประกอบพิธีฮัจย์</option>
                                <option value="6">ลาไปศึกษา ฝึกอบรม ปฏิบัติการวิจัย หรือดูงาน</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="leaves_status" class="form-label">สถานะการลา</label>
                            <select class="select2" name="leaves_status" id="leaves_status">
                                <option value="-1" disabled>-- เลือกสถานะ --</option>
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="W"><i class="bi-circle-fill text-primary"></i> รอดำเนินการ</option>
                                <option value="E"><i class="bi-circle-fill text-warning"></i> ส่งกลับแก้ไข</option>
                                <option value="Y"><i class="bi-circle-fill text-success"></i> สิ้นสุดการอนุมัติ</option>
                                <option value="N"><i class="bi-circle-fill text-danger"></i> ไม่อนุมัติ</option>
                            </select>
                        </div>
                       
                        <div class="col-12">
                        <div class="col-md-12 text-end"><button class="btn btn-secondary"><i class="bi bi-x-lg"></i> เคลียข้อมูล</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"><i class="bi bi-search"></i> ค้นหา</button></div>

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
                    <i class="bi-table icon-menu"></i><span> ตารางรายการแสดงข้อมูลการลา</span><span class="badge bg-success">4</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo site_url().'/'.$controller.'/leaves_type' ; ?>'"><i class="bi-plus"></i> ทำเรื่องการลา </button>
                    </div>
           
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">#</th>
                                <th class="text-center" width="20%">วันที่ลา</th>
                                <th class="text-center" width="30%">รายละเอียดการลา</th>
                                <th class="text-center" width="15%">ประเภทการลา</th>
                                <th class="text-center" width="15%">สถานะการลา</th>
                                <th class="text-center" width="10%">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="text-center">1</div>
                                </td>
                                <td>
                                    <div class="text-start"><?php echo abbreDate2(date("Y-m-d", strtotime("-3 day"))) . " ถึง " . abbreDate2(date("Y-m-d")); ?></div>
                                </td>
                                <td>
                                    <div class="text-start">เป็นไข้เลือดออก</div>
                                </td>
                                <td>
                                    <div class="text-center">ลาป่วย</div>
                                </td>
                                <td>
                                    <div class="text-center"><i class="bi-circle-fill text-primary"></i> รอดำเนินการ</div>
                                </td>
                                <td>
                                    <div class="text-center option">
                                        <a class="btn btn-secondary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-tag"></i></a>
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo $controller.'leaves_preview/1' ; ?>"><i class="bi bi-printer"></i>พิมพ์</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-word"></i>Word</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-text"></i>ไฟล์อัพโหลด</a></li>
                                        </ul>
                                        <a class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-center">2</div>
                                </td>
                                <td>
                                    <div class="text-start"><?php echo abbreDate2(date("Y-m-d", strtotime("-20 day"))) . " ถึง " . abbreDate2(date("Y-m-d", strtotime("-15 day"))); ?></div>
                                </td>
                                <td>
                                    <div class="text-start">ไปเที่ยวต่างจังหวัดกับครอบครัว</div>
                                </td>
                                <td>
                                    <div class="text-center">ลาพักผ่อน</div>
                                </td>
                                <td>
                                    <div class="text-center"><i class="bi-circle-fill text-warning"></i> ส่งกลับแก้ไข</div>
                                </td>
                                <td>
                                    <div class="text-center option">
                                        <a class="btn btn-secondary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-tag"></i></a>
                                        <a class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-pencil"></i></a>
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo $controller.'leaves_preview/3' ; ?>"><i class="bi bi-printer"></i>พิมพ์</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-word"></i>Word</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-text"></i>ไฟล์อัพโหลด</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-center">3</div>
                                </td>
                                <td>
                                    <div class="text-start"><?php echo abbreDate2(date("Y-m-d", strtotime("-30 day"))) . " ถึง " . abbreDate2(date("Y-m-d", strtotime("-27 day"))); ?></div>
                                </td>
                                <td>
                                    <div class="text-start">ไปทำธุระส่วนตัวที่ต่างจังหวัด</div>
                                </td>
                                <td>
                                    <div class="text-center">ลากิจส่วนตัว</div>
                                </td>
                                <td>
                                    <div class="text-center"><i class="bi-circle-fill text-success"></i> สิ้นสุดการอนุมัติ</div>
                                </td>
                                <td>
                                    <div class="text-center option">
                                        <a class="btn btn-secondary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-tag"></i></a>
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo $controller.'leaves_preview/2' ; ?>"><i class="bi bi-printer"></i>พิมพ์</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-word"></i>Word</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-text"></i>ไฟล์อัพโหลด</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-center">4</div>
                                </td>
                                <td>
                                    <div class="text-start"><?php echo abbreDate2(date("Y-m-d", strtotime("-60 day"))) . " ถึง " . abbreDate2(date("Y-m-d", strtotime("-56 day"))); ?></div>
                                </td>
                                <td>
                                    <div class="text-start">ลาคลอดบุตร และพักรักษาตัวที่บ้าน</div>
                                </td>
                                <td>
                                    <div class="text-center">ลาคลอดบุตร</div>
                                </td>
                                <td>
                                    <div class="text-center"><i class="bi-circle-fill text-success"></i> อนุมัติ</div>
                                </td>
                                <td>
                                    <div class="text-center option">
                                        <a class="btn btn-secondary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-tag"></i></a>
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo $controller.'leaves_preview/4' ; ?>"><i class="bi bi-printer"></i>พิมพ์</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-word"></i>Word</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-text"></i>ไฟล์อัพโหลด</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-center">5</div>
                                </td>
                                <td>
                                    <div class="text-start"><?php echo abbreDate2(date("Y-m-d", strtotime("-60 day"))) . " ถึง " . abbreDate2(date("Y-m-d", strtotime("-56 day"))); ?></div>
                                </td>
                                <td>
                                    <div class="text-start">ไม่เคยอุปสมบท, สถานที่ วัดพระบรมธาตุไชยาราชวรวิหาร หมู่ที่ 3 ตำบลเวียง อำเภอไชยา จังหวัดสุราษฎร์ธานี</div>
                                </td>
                                <td>
                                    <div class="text-center">ลาอุปสมบทหรือลาไปประกอบพิธีฮัจย์</div>
                                </td>
                                <td>
                                    <div class="text-center"><i class="bi-circle-fill text-danger"></i> ไม่อนุมัติ</div>
                                </td>
                                <td>
                                    <div class="text-center option">
                                        <a class="btn btn-secondary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-tag"></i></a>
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo $controller.'leaves_preview/5' ; ?>"><i class="bi bi-printer"></i>พิมพ์</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-word"></i>Word</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-text"></i>ไฟล์อัพโหลด</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-center">5</div>
                                </td>
                                <td>
                                    <div class="text-start"><?php echo abbreDate2(date("Y-m-d", strtotime("-60 day"))) . " ถึง " . abbreDate2(date("Y-m-d", strtotime("-56 day"))); ?></div>
                                </td>
                                <td>
                                    <div class="text-start">หัวเรื่องศึกษาเครื่องมือการแพทย์ โดยมีรายละเอียดไปศึกษาเครื่องมือใหม่ ๆ เพื่อนำมาประกอบการทำงาน ณ สถานที่ โรงพยาบาลศิริราชพยาบาล จังหวัดกรุงเทพมหานคร ประเทศไทย</div>
                                </td>
                                <td>
                                    <div class="text-center">ลาไปศึกษา ฝึกอบรม ปฏิบัติการวิจัย หรือดูงาน</div>
                                </td>
                                <td>
                                    <div class="text-center"><i class="bi-circle-fill text-success"></i> อนุมัติ</div>
                                </td>
                                <td>
                                    <div class="text-center option">
                                        <a class="btn btn-secondary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-tag"></i></a>
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo $controller.'leaves_preview/6' ; ?>"><i class="bi bi-printer"></i>พิมพ์</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-word"></i>Word</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-text"></i>ไฟล์อัพโหลด</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    // Set default end date
    const defaultEndDate = new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()); // Set default end date as 7 days ahead
    document.getElementById('leaves_end_date').value = formatDateToThai(defaultEndDate);
    generate_leaves_table();
});

flatpickr("#leaves_start_date", {
    plugins: [
        new rangePlugin({
            input: "#leaves_end_date"
        })
    ],
    dateFormat: 'd/m/Y',
    locale: 'th',
    defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
    onReady: function(selectedDates, dateStr, instance) {
        addMonthNavigationListeners();
        convertYearsToThai();
    },
    onOpen: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
    },
    onValueUpdate: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
        if (selectedDates[0]) {
            document.getElementById('leaves_start_date').value = formatDateToThai(selectedDates[0]);
        }
        if (selectedDates[1]) {
            document.getElementById('leaves_end_date').value = formatDateToThai(selectedDates[1]);
        }
    },
    onMonthChange: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
    },
    onYearChange: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
    }
});

function addMonthNavigationListeners() {
    const calendar = document.querySelector('.flatpickr-calendar');
    if (calendar) {
        const prevButton = calendar.querySelector('.flatpickr-prev-month');
        const nextButton = calendar.querySelector('.flatpickr-next-month');
        if (prevButton && nextButton) {
            prevButton.addEventListener('click', function() {
                setTimeout(convertYearsToThai, 0);
            });
            nextButton.addEventListener('click', function() {
                setTimeout(convertYearsToThai, 0);
            });
        }
    }
}

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
    const year = d.getFullYear();
    const month = ('0' + (d.getMonth() + 1)).slice(-2);
    const day = ('0' + d.getDate()).slice(-2);
    return `${day}/${month}/${year}`;
}
</script>


        <!-- Main Modal -->
        <div class="modal modal-lg" id="mainModal" aria-labelledby="mainModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mainModalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="mainModalBody">
                    </div>
                    <div class="modal-footer" id="mainModalFooter">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Modal -->