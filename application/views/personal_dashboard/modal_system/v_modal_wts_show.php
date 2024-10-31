<div class="modal fade" id="wts_system_modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="wts_hidden_st_id" value=""> <!-- Hidden input field to store st_id -->
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" title="คลิกเพื่อเข้าสู่ระบบ" data-toggle="tooltip" data-placement="top" onclick="redirect_to_gear('wts')"> <i class="bi-arrow-right-square"></i> เข้าสู่ระบบ </button>
                </div>
        
                <div class="row mb-3">
                    <div class="col-md-6 text-start">
                        <div class="" id="timer"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-bell icon-menu"></i><span>  รายการกิจกรรมล่าสุด</span><span class="badge bg-success">4</span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <table class="table datatable" width="100%">
                                        <thead>
                                            <tr>			
                                                <th class="text-center" width="5%">#</th>
                                                <th width="20%">ชื่อ - นามสกุลผู้ป่วย</th>
                                                <th width="15%">แผนก</th>
                                                <th width="30%">สถานะ</th>
                                                <th width="20%">ห้องปฏิบัติการทางการแพทย์</th>
                                                <th class="text-center" width="10%">เวลา</th>
                                                <!-- <th class="text-center" width="10%">ดำเนินการ</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>อารีรัตน์ ผ่องอุไร</td>
                                                <td>จักษุแพทย์</td>
                                                <td>วัดระยะการมองเห็น</td>
                                                <td>ห้องเครื่องมือพิเศษ</td>
                                                <td class="text-center">10 นาที</td>
                                                <!-- <td class="text-center option">
                                                    <button class="btn btn-info" title="ดูรายละเอียด"><i class="bi-search"></i></button>
                                                </td> -->
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td>พิศมัย สาวงค์</td>
                                                <td>จักษุแพทย์</td>
                                                <td>พบจักษุแพทย์</td>
                                                <td>ห้องเครื่องมือพิเศษ</td>
                                                <td class="text-center">20 นาที</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td>ชื่นจิต จิตใจ</td>
                                                <td>จักษุแพทย์</td>
                                                <td>ลงทะเบียน วัดส่วนสูง ชั้นน้ำหนัก</td>
                                                <td>ชั้น 1 : ห้องเครื่องมือ</td>
                                                <td class="text-center">24 นาที</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td>รักษณา วังดี</td>
                                                <td>จักษุแพทย์</td>
                                                <td>รับยา/คำแนะนำจากเภสัชกร</td>
                                                <td>ห้องรับยา</td>
                                                <td class="text-center">47 นาที</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="คลิกเพื่อปิด" data-toggle="tooltip" data-placement="top">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to update the timer display
    function update_timer() {
        // Get the current time
        const now = new Date();

        // Calculate days, months, years, hours, minutes, and seconds
        const day = now.toLocaleString('th-TH', {
            weekday: 'long'
        });
        const date = now.getDate();
        const months = now.toLocaleString('th-TH', {
            month: 'long'
        }); //now.getMonth() + 1; // January is 0
        const years = now.getUTCFullYear() + 543; //now.getFullYear();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();

        // Display the time in the format dd/mm/yyyy hh:mm:ss
        document.getElementById("timer").innerText = day.toString() + "ที่ " +
            date.toString() + " " +
            months.toString() + " พ.ศ. " +
            years.toString() + " เวลา " +
            hours.toString().padStart(2, '0') + ":" +
            minutes.toString().padStart(2, '0') + ":" +
            seconds.toString().padStart(2, '0');
    }

    // Start time (current time when the script begins)
    var startTime = new Date();

    // Update the timer display every second
    setInterval(update_timer, 1000);
</script>