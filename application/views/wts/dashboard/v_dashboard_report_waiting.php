<style>
    .alert .row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .alert #timer {
        text-align: left;
    }
    .alert input[type="date"] {
        text-align: right;
        margin-left: auto;
    }
</style>

<!-- Time Card -->
<!-- <div class="col-lg-12">
    <div class="row">
        <div class="col-xxl-12 col-md-12">
            <div class="alert alert-info" role="alert">
                <div class="row g-2">
                    <div class="col-md-6 float-start text-start" id="timer"></div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Search Dashboard Card -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSearch" aria-expanded="true" aria-controls="collapseSearch">
                    <i class="bi-search icon-menu"></i><span>ค้นหาข้อมูล</span>
                </button>
            </h2>
            <div id="collapseSearch" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="db_wts_date" class="form-label">วัน/เดือน/ปี</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="db_wts_date" id="db_wts_date" value="" placeholder="เลือกวัน/เดือน/ปี">
                                    <span class="input-group-text btn btn-secondary" onclick="$('#db_wts_date').val(null);" title="clear" data-clear><i class="bi-x"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="db_wts_dept" class="form-label">แผนกการรักษา</label>
                                <select class="form-select select2" name="db_wts_dept" id="db_wts_dept" data-placeholder="-- กรุณาเลือกแผนกการรักษา --">
                                    <option value=""></option>
                                    <option value="1">จักษุ</option>
                                    <option value="2">โสต ศอ นาสิก</option>
                                    <option value="3">ทันตกรรม</option>
                                    <option value="4">รังสี</option>                            
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button type="reset" class="btn btn-secondary float-start" name="reset">เคลียร์ข้อมูล</button>
                                <button type="submit" class="btn btn-primary float-end" name="search">ค้นหา</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Patient Type -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReport" aria-expanded="true" aria-controls="collapseReport">
                    <i class="bi-people icon-menu"></i><span>รายงานแสดงจำนวนผู้ป่วยที่เข้ามารับการรักษา</span>
                </button>
            </h2>
            <div id="collapseReport" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card card-button" onclick="openInNewTab('<?php echo base_url()?>index.php/wts/Dashboard_waiting/reportPatient/')">
                                <!-- <div class="card-body">
                                    <div>จำนวนผู้ป่วยทั้งหมด</div>
                                    <div class="card-icon rounded-circle float-end">
                                    <i class="bi-search text-primary"></i>
                                    </div>
                                    <div class="card-icon rounded-circle float-end">
                                    </div>
                                    <div class="float-end">
                                        <h1>30 คน</h1>
                                    </div>
                                </div> -->
                                <div class="card-body">                      
                                    <div class="filter float-end">
                                            <a class="bi-search" data-bs-toggle="modal" data-bs-target="#dashboard-learn-detail-modal"></a>
                                    </div>
                                    <div>จำนวนผู้ป่วยทั้งหมด</div>
                                    <div class="card-icon rounded-circle float-start">
                                        <i class="bi-people text-warning"></i>
                                    </div>
                                        <div class="float-end text-end">
                                            <h1>170 คน</h1>
                                        </div>                      
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="filter float-end">
                                            <a class="bi-search" data-bs-toggle="modal" data-bs-target="#dashboard-learn-detail-modal"></a>
                                    </div>
                                    <div>จำนวนผู้ป่วยที่กำลังรอคอย</div>
                                    <div class="card-icon rounded-circle float-start">
                                        <i class="bi-people text-warning"></i>
                                    </div>
                                    <div class="float-end">
                                        <h1>170 คน</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="filter float-end">
                                            <a class="bi-search" data-bs-toggle="modal" data-bs-target="#dashboard-learn-detail-modal"></a>
                                    </div>
                                    <div>ผู้ป่วยที่เสร็จสิ้นการรักษา</div>
                                    <div class="card-icon rounded-circle float-start">
                                        <i class="bi-people text-warning"></i>
                                    </div>
                                    <div class="float-end">
                                        <h1>170 คน</h1>
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

<!-- Status Graph -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGraph" aria-expanded="true" aria-controls="collapseGraph">
                    <i class="bi-bar-chart-line icon-menu"></i><span>สถานะของผู้ป่วย</span>
                </button>
            </h2>
            <div id="collapseGraph" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="card-body pb-0">
                        <div id="dashboard_patient_status"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="myToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">แจ้งเตือนใกล้สิ้นสุดเวลา</strong>
      <small><?php// echo date("h:i") . " น." ?></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      อีก 2 นาทีจะหมดเวลาการรักษาที่กำหนดไว้
    </div>
  </div>
</div> -->

<script>
// สร้างฟังก์ชันสำหรับแสดง Toast
// function showToast() {
//   var toastEl = document.getElementById('myToast');
//   var toast = new bootstrap.Toast(toastEl);
//   toast.show();
// } 

// // เรียกใช้ฟังก์ชันแสดง Toast ทุกๆ 5 วินาที
// setInterval(showToast, 5000);
</script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/high-contrast-light.js"></script>

<script>
  // Sample data for illustration
  const colors = Highcharts.getOptions().colors;

    Highcharts.chart('dashboard_patient_status', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        xAxis: {
            labels: {
                style: {
                    fontSize: '16px',
                    fontFamily: 'Sarabun'
                }
            }
        },
        yAxis: {
            labels: {
                style: {
                    fontSize: '16px',
                    fontFamily: 'Sarabun'
                }
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
            style: {
                fontSize: '16px',
                fontFamily: 'Sarabun'
            }
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true, // Enable data labels
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    distance: 20, // Adjust the distance of labels from the center of the pie
                    style: {
                        fontSize: '16px',
                        fontFamily: 'Sarabun'
                    }
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            colors: ['#F0AB00', '#F4C145', '#F6D173', '#F9E0A2'], // Light colors
            data: [{
                name: 'จำนวนผู้ป่วยที่กำลังรอคอย',
                y: 55.02,
                sliced: true,
                selected: true
            },  {
                name: 'ผู้ป่วยที่เสร็จสิ้นการรักษา',
                y: 26.71
            },  {
                name: 'ผู้ป่วยที่กำลังรอคอยเกินเวลา',
                y: 2.09
            },  {
                name: 'ผู้ป่วยที่เสร็จสิ้นการรักษาเกินเวลา',
                y: 15.5
            }
            ]
        }]
    });

    flatpickr("#db_wts_date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        onReady: function(selectedDates, dateStr, instance) {
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
                document.getElementById('db_wts_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('db_wts_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
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

<script>
    function openInNewTab(url) {
        window.open(url, '_blank');
    }
</script>

<script>
    // // Function to update the timer display
    // function update_timer() {
    //     // Get the current time
    //     const now = new Date();

    //     // Calculate days, months, years, hours, minutes, and seconds
    //     const day = now.toLocaleString('th-TH', {
    //         weekday: 'long'
    //     });
    //     const date = now.getDate();
    //     const months = now.toLocaleString('th-TH', {
    //         month: 'long'
    //     }); //now.getMonth() + 1; // January is 0
    //     const years = now.getUTCFullYear() + 543; //now.getFullYear();
    //     const hours = now.getHours();
    //     const minutes = now.getMinutes();
    //     const seconds = now.getSeconds();

    //     // Display the time in the format dd/mm/yyyy hh:mm:ss
    //     document.getElementById("timer").innerText = day.toString() + "ที่ " +
    //         date.toString() + " " +
    //         months.toString() + " พ.ศ. " +
    //         years.toString() + " เวลา " +
    //         hours.toString().padStart(2, '0') + ":" +
    //         minutes.toString().padStart(2, '0') + ":" +
    //         seconds.toString().padStart(2, '0') + " น.";
    // }

    // // Start time (current time when the script begins)
    // var startTime = new Date();

    // // Update the timer display every second
    // setInterval(update_timer, 20000);
</script>

