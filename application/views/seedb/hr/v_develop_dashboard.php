<hr>
<p class="text-center font-20 text-primary fw-bold">ระบบ HRD อยู่ระหว่างดำเนินการพัฒนา <i class="bi bi-arrow-down-square-fill text-success font-30 ps-5"></i></p>
<hr>
<div class="col-md-12">
    <div class="card">
    <div class="card-body">
        <h5 class="card-title pt-1 pb-0 font-16 w-90">[TIME-1] สถิติการมาทำงานของบุคลากรทั้งหมด (รายวัน)</h5>
        <hr>
        <div class="row">
        <div class="col-md-5">
            <div id="calendar"></div>
        </div>
        <div class="col-md-7">
            <div id="details" class="details"></div>
            <div class="row" style="border: 1px solid #ddd; border-radius: 10px; margin-left: 0px; margin-right: 0px; padding-top: 10px;">
            <div class="col-md-6">
                <div id="leaveSummaryChart"></div>
            </div>
            <div class="col-md-6">
                <div id="details_label" style="margin-top: 60px; line-height: 2.5;"></div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
    <div class="card-body">
        <h5 class="card-title pt-1 pb-0 font-16 w-90 ">[TIME-2] รายงานจำนวนชั่วโมงการทำงานของพยาบาล ประจำเดือน
        <select id="month-select" class="form-select w-15 d-inline me-5 ms-3">
            <option value="มกราคม">มกราคม</option>
            <option value="กุมภาพันธ์">กุมภาพันธ์</option>
            <option value="มีนาคม">มีนาคม</option>
            <option value="เมษายน">เมษายน</option>
            <option value="พฤษภาคม">พฤษภาคม</option>
            <option value="มิถุนายน">มิถุนายน</option>
            <option value="กรกฎาคม">กรกฎาคม</option>
            <option value="สิงหาคม">สิงหาคม</option>
            <option value="กันยายน">กันยายน</option>
            <option value="ตุลาคม">ตุลาคม</option>
            <option value="พฤศจิกายน">พฤศจิกายน</option>
            <option value="ธันวาคม">ธันวาคม</option>
        </select>
        </h5>
        <hr>
        <div class="row">
        <!-- Container for Donut Chart -->
        <div class="col-md-6">
            <div class="row">
            <div class="col-md-6">
                <div class="card info-card sales-card" style="border-bottom: 3px solid #4bc0c0; background: #e8fff9;">
                <div class="card-body pb-2">
                    <h5 class="pt-1 pb-3 font-16">[HRD-C5] จำนวนพยาบาลทั้งหมด</h5>
                    <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #18a1a1; background: #b1ebeb;">
                        <i class="ri ri-nurse-fill"></i>
                    </div>
                    <div class="ps-4">
                        <h6 id="total-nurses">120 คน</h6>
                    </div>
                    </div>
                </div>
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card info-card revenue-card" style="border-bottom: 3px solid #607D8B; background: #ebebeb;">
                <div class="card-body pb-2">
                    <h5 class="pt-1 pb-3 font-16">[HRD-C6] ยังไม่ได้จัดลงตารางเวร</h5>
                    <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #3c5e6e;background: #cdcdcd;">
                        <i class="bi bi-inboxes"></i>
                    </div>
                    <div class="ps-4">
                        <h6 id="unscheduled-nurses">20 คน</h6>
                    </div>
                    </div>
                </div>
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card info-card revenue-card" style="border-bottom: 3px solid #4CAF50; background: #f5fff6;">
                <div class="card-body pb-2">
                    <h5 class="pt-1 pb-3 font-16">[HRD-C7] จำนวนชั่วโมงมากกว่าหรือเท่ากับ 200 ชั่วโมง</h5>
                    <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4CAF50;background: #c8e6c9;">
                        <i class="bi bi-layer-forward"></i>
                    </div>
                    <div class="ps-4">
                        <h6 id="more-than-200">70 คน</h6>
                    </div>
                    </div>
                </div>
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card info-card revenue-card" style="border-bottom: 3px solid #FFC107; background: #fff8e1;">
                <div class="card-body pb-2">
                    <h5 class="pt-1 pb-3 font-16">[HRD-C8] จำนวนชั่วโมงน้อยกว่า 200 ชั่วโมง</h5>
                    <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #c39305;background: #ffecb3;">
                        <i class="bi bi-layer-backward"></i>
                    </div>
                    <div class="ps-4">
                        <h6 id="less-than-200">30 คน</h6>
                    </div>
                    </div>
                </div>
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14 float-end" title="คลิกเพื่อดูรายละเอียด"> ดูรายละเอียด</a>
            <div id="loader4" class="loader"></div>
            <div id="donut-chart" style="width: 100%; height: 400px;"></div>
        </div>
        </div>
    </div>
    </div>
</div>
    


<script>
  $(document).ready(function() {
    function updateCalendarTitle() {
      var titleText = $('.fc-center h2').text();
      var yearMatch = titleText.match(/\d{4}/);
      if (yearMatch) {
        var yearAD = parseInt(yearMatch[0]);
        var yearBE = yearAD + 543;
        var newTitleText = titleText.replace(yearAD, yearBE);
        $('.fc-center h2').text(newTitleText);
      }
    }

    function updateDateDetails(date) {
      var dateStr = date.format('LL'); // รูปแบบวันที่แบบไทย
      var dateStrBE = dateStr.replace(/\d{4}/, function(year) {
        return parseInt(year) + 543;
      });
      return dateStrBE;
    }

    var events = [{
        title: 'ปกติ: 20 คน',
        start: '2024-08-01',
        description: '[HRD-C1] มาทำงานปกติ',
        order: 1,
        color: '#4CAF50',
        textColor: '#FFFFFF'
      },
      {
        title: 'สาย: 5 คน',
        start: '2024-08-01',
        description: '[HRD-C2] มาทำงานสาย',
        order: 2,
        color: '#F44336',
        textColor: '#FFFFFF'
      },
      {
        title: 'ลา: 5 คน / 4 ครั้ง',
        start: '2024-08-01',
        description: '[HRD-C3] ลาป่วย ลาพักร้อน ลากิจ',
        order: 3,
        color: '#FFC107',
        textColor: '#000'
      },
      {
        title: 'แพทย์: 7 คน',
        start: '2024-08-01',
        description: '[HRD-C4] จำนวนแพทย์ออกตรวจ',
        order: 4,
        color: '#2196F3',
        textColor: '#FFFFFF'
      },
      {
        title: 'มาทำงานปกติ: 22 คน',
        start: '2024-08-04',
        description: '[HRD-C1] มาทำงานปกติ',
        order: 1,
        color: '#4CAF50',
        textColor: '#FFFFFF'
      },
      {
        title: 'สาย: 3 คน',
        start: '2024-08-04',
        description: '[HRD-C2] มาทำงานสาย',
        order: 2,
        color: '#F44336',
        textColor: '#FFFFFF'
      },
      {
        title: 'การลา: 3 คน / 30 ครั้ง',
        start: '2024-08-04',
        description: '[HRD-C3] ลาป่วย ลาพักร้อน ลากิจ',
        order: 3,
        color: '#FFC107',
        textColor: '#000'
      },
      {
        title: 'แพทย์: 8 คน',
        start: '2024-08-04',
        description: '[HRD-C4] จำนวนแพทย์ออกตรวจ',
        order: 4,
        color: '#2196F3',
        textColor: '#FFFFFF'
      }
    ];

    // แสดงรายละเอียดของวันที่ปัจจุบัน
    var today = moment();
    var todayStrBE = updateDateDetails(today);
    var dayName = today.format('dddd'); // แสดงชื่อวันในภาษาไทย
    var monthName = today.format('MMMM'); // แสดงชื่อวันในภาษาไทย
    $('#details').html(`
        <h5 class="mt-2 mb-4">ข้อมูลรายละเอียดสำหรับวัน${dayName} ที่ (${todayStrBE})</h5>
        <div class="row">
          <div class="col-md-6">
            <div id="card_work">
              <div class="card info-card sales-card" style="border-bottom: 3px solid #4CAF50; background: #e8f5e9;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[HRD-C1] มาทำงานปกติ</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4CAF50; background: #c8e6c9;">
                      <i class="bi bi-person-check"></i>
                    </div>
                    <div class="ps-4">
                      <h6>20 คน</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="work" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div id="card_late">
              <div class="card info-card sales-card" style="border-bottom: 3px solid #F44336; background: #ffebee;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[HRD-C2] มาทำงานสาย</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #F44336; background: #ffcdd2;">
                      <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="ps-4">
                      <h6>5 คน</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="late" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div id="card_leave">
              <div class="card info-card sales-card" style="border-bottom: 3px solid #FFC107; background: #fff8e1;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[HRD-C3] ลาป่วย ลาพักร้อน ลากิจ</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #FFC107; background: #ffecb3;">
                      <i class="bi bi-person-x"></i>
                    </div>
                    <div class="ps-4">
                      <h6>5 คน </h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="leave" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div id="card_doctors">
              <div class="card info-card sales-card" style="border-bottom: 3px solid #2196F3; background: #e3f2fd;">
                <div class="card-body pb-2">
                  <h5 class="pt-1 pb-3 font-16">[HRD-C4] จำนวนแพทย์ออกตรวจ</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #2196F3; background: #bbdefb;">
                      <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="ps-4">
                      <h6>7 คน</h6>
                    </div>
                  </div>
                </div>
                <div class="filter filterDetail">
                  <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="doctors" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      `);

    setTimeout(function() {
      // สร้างกราฟ Highcharts แบบครึ่งวงกลม
      Highcharts.chart('leaveSummaryChart', {
        chart: {
          type: 'pie',
          height: 300,
          style: {
            fontSize: '16px' // ขนาดฟอนต์ของทั้งกราฟ
          }
        },
        title: {
          text: `[HRD-C3-G1] ผลสรุปการลาของเดือนเดือน ${monthName} 2567`,
          align: 'left', // ตัวอักษรอยู่ทางซ้าย
          style: {
            color: '#012970', // สีน้ำเงิน
            fontSize: '18px' // ขนาดฟอนต์ 16px
          }
        },
        colors: ['#36A2EB', '#4BC0C0', '#9966FF', '#F44336'], // สีสดใส
        tooltip: {
          useHTML: true,
          formatter: function() {
            return `
                    <span style="color: ${this.point.color}; font-size: 16px">${this.key}</span>: 
                    <span style="font-size: 16px">${this.y} ครั้ง</span>
                `;
          },
          style: {
            fontSize: '16px' // ขนาดฟอนต์ของทูลทิป
          }
        },
        plotOptions: {
          pie: {
            innerSize: '50%',
            depth: 45,
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '100%'],
            dataLabels: {
              distance: 0,
              enabled: true,
              style: {
                fontSize: '14px', // ขนาดฟอนต์ของป้ายข้อมูล
                color: '#000000'
              },
              format: '{point.name}: {point.y} คน'
            }
          }
        },
        legend: {
          itemStyle: {
            fontSize: '16px' // ขนาดฟอนต์ของตำนานกราฟ
          }
        },
        series: [{
          name: 'จำนวนการลา',
          data: [{
              name: 'ลาป่วย',
              y: 5
            },
            {
              name: 'ลาพักร้อน',
              y: 3
            },
            {
              name: 'ลากิจ',
              y: 2
            },
            {
              name: 'สาย',
              y: 2
            }
          ] // แทนที่ค่าด้วยค่าจริงที่ต้องการแสดง
        }]
      });
    }, 500); // Match the transition duration
    $('#details_label').html(`
      <span class="badge rounded-pill bg-primary font-16 me-4">ลาป่วย</span><span class="font-20 fw-bold" style="padding-left: 25px;"> 5 คน 
      <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
      <span class="badge rounded-pill bg-success font-16 me-4">ลาพักร้อน</span><span class="font-20 fw-bold" style="padding-left: 3px;"> 3 คน 
      <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
      <span class="badge rounded-pill font-16 me-4" style="background:#480ac7;">ลากิจ</span><span class="font-20 fw-bold" style="padding-left: 34px;"> 2 คน 
      <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
      <span class="badge rounded-pill bg-danger font-16 me-1">มาทำงานสาย</span><span class="font-20 fw-bold" style="padding-left: 0px;"> 2 คน 
      <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span>
      `);

    $('#calendar').fullCalendar({
      locale: 'th',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month'
      },
      events: events,
      eventOrder: "order",
      dayClick: function(date, jsEvent, view) {
        var dateStrBE = updateDateDetails(date);
        var dayName = today.format('dddd'); // แสดงชื่อวันในภาษาไทย
        // ลบคลาสที่เน้นสีจากวันที่ที่เคยถูกคลิกมาก่อนหน้า
        $('#calendar').find('.fc-day').removeClass('clicked-day');

        // เพิ่มคลาสเพื่อเน้นสีวันที่ที่ถูกคลิก
        $(this).addClass('clicked-day');

        // ลบการ์ดเก่าก่อนที่จะแสดงการ์ดใหม่
        $('#details').empty();
        $('#details_label').empty();

        // กรอง event ตามวันที่คลิก
        var filteredEvents = events.filter(function(event) {
          return moment(event.start).isSame(date, 'day');
        });

        // เรียงลำดับ event ตามประเภทของการ์ด
        filteredEvents.sort(function(a, b) {
          return a.order - b.order;
        });


        if (filteredEvents.length > 0) {
          // แสดงรายละเอียดวันที่ที่คลิกในคอลัมน์ขวา
          $('#details').html(`
          <h5 class="mt-2 mb-4">ข้อมูลรายละเอียดสำหรับวัน${dayName} ที่ ${dateStrBE}</h5>
          <div class="row"></div>
      `);

          filteredEvents.forEach(function(event) {
            var cardColor, iconClass, backgroundColor, iconBgColor;

            // กำหนดสีและไอคอนตามประเภทของการ์ด
            if (event.description.includes('[HRD-C1]')) {
              cardColor = '#4CAF50';
              iconClass = 'bi bi-person-check';
              backgroundColor = '#e8f5e9';
              iconBgColor = '#c8e6c9';
            } else if (event.description.includes('[HRD-C2]')) {
              cardColor = '#F44336';
              iconClass = 'bi bi-clock-history';
              backgroundColor = '#ffebee';
              iconBgColor = '#ffcdd2';
            } else if (event.description.includes('[HRD-C3]')) {
              cardColor = '#FFC107';
              iconClass = 'bi bi-person-x';
              backgroundColor = '#fff8e1';
              iconBgColor = '#ffecb3';
            } else if (event.description.includes('[HRD-C4]')) {
              cardColor = '#2196F3';
              iconClass = 'bi bi-person-badge';
              backgroundColor = '#e3f2fd';
              iconBgColor = '#bbdefb';
            }

            $('#details .row').append(`
              <div class="col-md-6">
                  <div class="card info-card sales-card" style="border-bottom: 3px solid ${cardColor}; background: ${backgroundColor};">
                      <div class="card-body pb-2">
                          <h5 class="pt-1 pb-3 font-16">${event.description}</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: ${cardColor}; background: ${iconBgColor};">
                                  <i class="${iconClass}"></i>
                              </div>
                              <div class="ps-4">
                                  <h6>${event.title.split(':')[1]}</h6>
                              </div>
                          </div>
                      </div>
                      <div class="filter filterDetail">
                          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="work" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                      </div>
                  </div>
              </div>
          `);
          });

          setTimeout(function() {
            // สร้างกราฟ Highcharts แบบครึ่งวงกลม
            Highcharts.chart('leaveSummaryChart', {
              chart: {
                type: 'pie',
                height: 300,
                style: {
                  fontSize: '16px' // ขนาดฟอนต์ของทั้งกราฟ
                }
              },
              title: {
                text: `[HRD-C3-G1] ผลสรุปการลาประจำเดือน ${monthName}`,
                align: 'left', // ตัวอักษรอยู่ทางซ้าย
                style: {
                  color: '#012970', // สีน้ำเงิน
                  fontSize: '18px' // ขนาดฟอนต์ 16px
                }
              },
              colors: ['#36A2EB', '#4BC0C0', '#9966FF', '#F44336'], // สีสดใส
              tooltip: {
                useHTML: true,
                formatter: function() {
                  return `
                        <span style="color: ${this.point.color}; font-size: 16px">${this.key}</span>: 
                        <span style="font-size: 16px">${this.y} ครั้ง</span>
                    `;
                },
                style: {
                  fontSize: '16px' // ขนาดฟอนต์ของทูลทิป
                }
              },
              plotOptions: {
                pie: {
                  innerSize: '50%',
                  depth: 45,
                  startAngle: -90,
                  endAngle: 90,
                  center: ['50%', '75%'],
                  dataLabels: {
                    distance: 0,
                    enabled: true,
                    style: {
                      fontSize: '14px', // ขนาดฟอนต์ของป้ายข้อมูล
                      color: '#000000'
                    },
                    format: '{point.name}: {point.y} ครั้ง'
                  }
                }
              },
              legend: {
                itemStyle: {
                  fontSize: '16px' // ขนาดฟอนต์ของตำนานกราฟ
                }
              },
              series: [{
                name: 'จำนวนการลา',
                data: [{
                    name: 'ลาป่วย',
                    y: 5
                  },
                  {
                    name: 'ลาพักร้อน',
                    y: 3
                  },
                  {
                    name: 'ลากิจ',
                    y: 2
                  },
                  {
                    name: 'สาย',
                    y: 2
                  }
                ] // แทนที่ค่าด้วยค่าจริงที่ต้องการแสดง
              }]
            });
          }, 500); // Match the transition duration
          $('#details_label').html(`
          <span class="badge rounded-pill bg-primary font-16 me-4">ลาป่วย</span><span class="font-20 fw-bold" style="padding-left: 25px;"> 5 คน / 5 ครั้ง
          <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
          <span class="badge rounded-pill bg-success font-16 me-4">ลาพักร้อน</span><span class="font-20 fw-bold" style="padding-left: 3px;"> 3 คน / 3 ครั้ง
          <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
          <span class="badge rounded-pill font-16 me-4" style="background:#480ac7;">ลากิจ</span><span class="font-20 fw-bold" style="padding-left: 34px;"> 2 คน / 2 ครั้ง
          <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span><hr>
          <span class="badge rounded-pill bg-danger font-16 me-1">มาทำงานสาย</span><span class="font-20 fw-bold" style="padding-left: 0px;"> 2 คน / 2 ครั้ง
          <a class="bi-search btn btn-primary p-1 ps-2 pe-2 me-5 font-12 float-end mt-3"></a></span>
          `);
        } else {
          // แสดงข้อความไม่มีข้อมูลถ้าไม่มี event ในวันนั้น
          $('#details').html(`
          <h5 class="mt-2 mb-4">ข้อมูลรายละเอียดสำหรับวัน${dayName} ที่ ${dateStrBE}</h5>
          <p>ไม่มีข้อมูล</p>
      `);

          // ลบกราฟ Highcharts ถ้าไม่มีข้อมูล
          $('#leaveSummaryChart').empty();
        }
      },
      viewRender: function(view, element) {
        // เพิ่มคลาส current-day ให้กับวันที่ปัจจุบัน
        var todayElement = $('#calendar').find('.fc-today');
        todayElement.addClass('current-day');

        // แปลงปี ค.ศ. เป็นปี พ.ศ. ใน title
        setTimeout(updateCalendarTitle, 10);
      }
    });


    // เปลี่ยนข้อความ "วันนี้" เป็น "เปลี่ยนเดือน"
    $(".fc-today-button").text("เปลี่ยนเดือน");
  });
</script>

<script>
  document.getElementById('month-select').addEventListener('change', function() {
    updateChart(this.value);
    updateCards(this.value);
  });

  function updateChart(month) {
    setTimeout(function() {
      Highcharts.chart('donut-chart', {
        chart: {
          type: 'pie',
          events: {
            load: function() {
              // ซ่อนตัวโหลดเมื่อกราฟโหลดเสร็จ
              document.getElementById('loader4').classList.add('hidden');
            }
          }
        },
        title: {
          text: '',
        },
        tooltip: {
          style: {
            fontSize: '18px'
          },
          pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y} คน ({point.percentage:.1f}%)</b>'
        },
        colors: ['#FF9F40', '#4CAF50', '#607d8b'], // สีสดใส
        plotOptions: {
          pie: {
            innerSize: '50%',
            dataLabels: {
              enabled: true,
              formatter: function() {
                return '<span>' + this.point.name + ':<br>' + this.point.y + ' คน (' + this.point.percentage.toFixed(1) + '%)</span>';
              },
              style: {
                fontSize: '14px',
                color: '#000000'
              }
            },
            showInLegend: true
          }
        },
        series: [{
          name: 'พยาบาล',
          colorByPoint: true,
          data: [{
            name: 'น้อยกว่า 200 ชั่วโมง',
            y: 30 // เปลี่ยนเป็นจำนวนพยาบาลที่ทำงานน้อยกว่า 200 ชั่วโมงจริง
          }, {
            name: 'มากกว่าหรือเท่ากับ 200 ชั่วโมง',
            y: 70 // เปลี่ยนเป็นจำนวนพยาบาลที่มากกว่าหรือเท่ากับ 200 ชั่วโมงจริง
          }, {
            name: 'ยังไม่ได้จัดลงตารางเวร',
            y: 20 // เปลี่ยนเป็นจำนวนพยาบาลที่ยังไม่ได้จัดลงตารางเวรจริง
          }]
        }],
        legend: {
          enabled: true,
          itemStyle: {
            fontSize: '14px'
          },
          labelFormatter: function() {
            return '<span style="font-size:14px">' + this.name + '</span>';
          }
        }
      });
    }, 500); // หน่วงเวลา 1000 มิลลิวินาที (1 วินาที)
  }

  function updateCards(month) {
    // ตัวอย่างข้อมูล สามารถเปลี่ยนให้เป็นข้อมูลที่เหมาะสมจากฐานข้อมูลหรือ API
    const data = {
      "พฤษภาคม": {
        total: 120,
        unscheduled: 20,
        moreThan200: 70,
        lessThan200: 30
      },
      "มิถุนายน": {
        total: 130,
        unscheduled: 22,
        moreThan200: 72,
        lessThan200: 36
      },
      "กรกฎาคม": {
        total: 125,
        unscheduled: 18,
        moreThan200: 68,
        lessThan200: 39
      },
      // เพิ่มข้อมูลสำหรับเดือนอื่นๆ ที่เหลือ
    };

    const monthData = data[month];
    if (monthData) {
      document.getElementById('total-nurses').innerText = `${monthData.total} คน`;
      document.getElementById('unscheduled-nurses').innerText = `${monthData.unscheduled} คน`;
      document.getElementById('more-than-200').innerText = `${monthData.moreThan200} คน`;
      document.getElementById('less-than-200').innerText = `${monthData.lessThan200} คน`;
    }
  }

  // Set the current month in the dropdown and initialize the chart and cards
  document.addEventListener('DOMContentLoaded', function() {
    const monthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    const currentMonth = new Date().getMonth(); // Get the current month (0-11)
    document.getElementById('month-select').value = monthNames[currentMonth];
    updateChart(monthNames[currentMonth]);
    updateCards(monthNames[currentMonth]);
  });

  // Set the current month in the dropdown and initialize the chart and cards
  document.addEventListener('DOMContentLoaded', function() {
    const monthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    const currentMonth = new Date().getMonth(); // Get the current month (0-11)
    document.getElementById('month-select-pay').value = monthNames[currentMonth];
    updateChart(monthNames[currentMonth]);
    updateCards(monthNames[currentMonth]);
  });
</script>