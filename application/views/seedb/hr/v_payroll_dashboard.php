<div class="col-md-12">
    <div class="card">
    <div class="card-body">
        <h5 class="card-title pt-1 pb-0 font-16 w-90">[PAY-1] รายจ่ายค่าตอบแทนรายเดือนเเละค่าสวัสดิการต่างๆ
        <select id="month-select-pay" class="form-select w-15 d-inline me-5 ms-3">
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
        <div class="col-md-3">
            <div class="card info-card revenue-card" style="border-bottom: 3px solid #9bab00; background: #fbffd3;">
            <div class="card-body pb-2">
                <h5 class="pt-1 pb-3 font-16">[PAY-C1] จำนวนเลขที่ใบ Payroll</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #417800;background: #d9e374;">
                    <i class="bi bi-person-fill-gear"></i>
                </div>
                <div class="ps-4">
                    <h6 id="pay-c1-amount">30 ใบ</h6>
                </div>
                </div>
            </div>
            <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card info-card revenue-card" style="border-bottom: 3px solid #00bcd4; background: #e8faff;">
            <div class="card-body pb-2">
                <h5 class="pt-1 pb-3 font-16">[PAY-C2] รายจ่ายเงินเดือน</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #00BCD4;background: #a7f5ff;">
                    <i class="bi bi-person-fill-gear"></i>
                </div>
                <div class="ps-4">
                    <h6 id="pay-c2-amount"><?php echo number_format('9154700', 2) ?> บาท</h6>
                </div>
                </div>
            </div>
            <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card info-card revenue-card" style="border-bottom: 3px solid #9866ff; background: #f5f1ff;">
            <div class="card-body pb-2">
                <h5 class="pt-1 pb-3 font-16">[PAY-C3] รายการค่าสวัสดิการต่างๆ</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9866ff;background: #e0d1ff;">
                    <i class="bi bi-person-fill-gear"></i>
                </div>
                <div class="ps-4">
                    <h6 id="pay-c3-amount"><?php echo number_format('724200', 2) ?> บาท</h6>
                </div>
                </div>
            </div>
            <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card info-card revenue-card" style="border-bottom: 3px solid #4CAF50; background: #f5fff6;">
            <div class="card-body pb-2">
                <h5 class="pt-1 pb-3 font-16">[PAY-C4] สรุปยอดรายจ่าย</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4CAF50;background: #c8e6c9;">
                    <i class="bi bi-person-fill-gear"></i>
                </div>
                <div class="ps-4">
                    <h6 id="pay-c4-amount"><?php echo number_format('9878900', 2) ?> บาท</h6>
                </div>
                </div>
            </div>
            <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"></a>
            </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
            <div class="card">
            <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#"> ดูรายละเอียด</a>
            </div>
            <div class="card-body">
                <h5 class="card-title pt-1 pb-0 font-16 w-90" data-title-id="pay-2-title">[PAY-2] กราฟแสดงรายจ่าย จำแนกตามประเภทของรายจ่าย ประจำเดือนสิงหาคม</h5>
                <hr>
                <div class="row">
                <div class="col-md-12">
                    <div class="chart-containe">
                    <div id="SplitPacked"></div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
            <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#"> ดูรายละเอียด</a>
            </div>
            <div class="card-body">
                <h5 class="card-title pt-1 pb-0 font-16 w-90">[PAY-3] กราฟแสดงเปรียบเทียบรายจ่ายของแต่ละเดือน</h5>
                <hr>
                <div class="row">
                <div class="col-md-12">
                    <div class="chart-containe">
                    <div id="barChartContainer"></div>
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

<script>

  // ฟังก์ชันเพื่อหาค่าเดือนปัจจุบัน
  function setCurrentMonth() {
    var monthNames = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    var now = new Date();
    var currentMonth = monthNames[now.getMonth()]; // หาค่าเดือนปัจจุบัน
    document.getElementById('month-select-pay').value = currentMonth; // ตั้งค่า selected ให้กับ dropdown
    updatePackedBubbleChart(currentMonth); // อัปเดตกราฟตามเดือนปัจจุบัน
    updateBarChart(currentMonth, now.getMonth()); // อัปเดตกราฟแท่งตามเดือนปัจจุบัน
  }

  document.getElementById('month-select-pay').addEventListener('change', function() {
    var selectedMonth = this.value;
    var monthNamesFull = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    var monthIndex = monthNamesFull.indexOf(selectedMonth);
    updatePackedBubbleChart(selectedMonth);
    updateBarChart(selectedMonth, monthIndex);
  });

  function updatePackedBubbleChart(month) {
    setTimeout(function() {

      // ตัวอย่างข้อมูลรายจ่ายในแต่ละเดือน
      var data = {
        'กรกฎาคม': {
          salary: [{
            name: 'เงินเดือน',
            value: 9154700
          }, {
            name: 'ค่าเวร',
            value: 465210
          }, {
            name: 'เบี้ยขยัน',
            value: 241032
          }, {
            name: 'ค่าขึ้นเวร',
            value: 150000
          }, {
            name: 'OT',
            value: 80000
          }, {
            name: 'ค่าเบี้ยขยัน',
            value: 30000
          }, {
            name: 'แพทย์FT ',
            value: 7300000
          }, {
            name: 'แพทย์PT ',
            value: 5003000
          }],
          allowances: [{
            name: 'ค่าอาหาร',
            value: 125000
          }, {
            name: 'ค่าประกันอุบัติเหตุ',
            value: 100000
          }, {
            name: 'ค่าเช่าที่พัก',
            value: 210000
          }],
          deductions: [{
            name: 'สาย',
            value: 15000
          }, {
            name: 'ขาดงาน',
            value: 30000
          }],
          totalSalary: 9154700,
          totalAllowances: 724200,
          totalDeductions: 20,
          totalExpenses: 9878900
        },
        'สิงหาคม': {
          salary: [{
            name: 'เงินเดือน',
            value: 8000000
          }, {
            name: 'ค่าเวร',
            value: 400000
          }, {
            name: 'เบี้ยขยัน',
            value: 200000
          }, {
            name: 'ค่าขึ้นเวร',
            value: 130000
          }, {
            name: 'OT',
            value: 70000
          }, {
            name: 'ค่าเบี้ยขยัน',
            value: 25000
          }, {
            name: 'แพทย์FT ',
            value: 6800000
          }, {
            name: 'แพทย์PT ',
            value: 4500000
          }],
          allowances: [{
            name: 'ค่าอาหาร',
            value: 115000
          }, {
            name: 'ค่าประกันอุบัติเหตุ',
            value: 95000
          }, {
            name: 'ค่าเช่าที่พัก',
            value: 200000
          }],
          deductions: [{
            name: 'สาย',
            value: 14000
          }, {
            name: 'ขาดงาน',
            value: 28000
          }],
          totalSalary: 8000000,
          totalAllowances: 645000,
          totalDeductions: 50,
          totalExpenses: 8688000
        },
        // เพิ่มข้อมูลสำหรับเดือนอื่นๆ ตามต้องการ
      };

      var selectedData = data[month] || {
        salary: [],
        allowances: [],
        deductions: [],
        totalSalary: 0,
        totalAllowances: 0,
        totalDeductions: 0,
        totalExpenses: 0
      };
      document.getElementById('pay-c4-amount').textContent = new Intl.NumberFormat().format(selectedData.totalExpenses) + ' บาท';
      document.getElementById('pay-c2-amount').textContent = new Intl.NumberFormat().format(selectedData.totalSalary) + ' บาท';
      document.getElementById('pay-c3-amount').textContent = new Intl.NumberFormat().format(selectedData.totalAllowances) + ' บาท';
      document.getElementById('pay-c1-amount').textContent = new Intl.NumberFormat().format(selectedData.totalDeductions) + ' ใบ';
      document.querySelector('[data-title-id="pay-2-title"]').textContent = `[PAY-2] รายจ่ายทั้งหมดของเดือน ${month} 2567`;

      Highcharts.chart('SplitPacked', {
        chart: {
          type: 'packedbubble'
        },
        title: {
          text: '',
          style: {
            fontSize: '16px'
          }
        },
        tooltip: {
          useHTML: true,
          formatter: function() {
            return '<b>' + this.point.name + ':</b> ' + Highcharts.numberFormat(this.point.value, 0, '.', ',') + ' บาท';
          },
          style: {
            fontSize: '16px'
          }
        },
        plotOptions: {
          packedbubble: {
            minSize: '50%',
            maxSize: '80%',
            zMin: 100000,
            zMax: 500000,
            layoutAlgorithm: {
              splitSeries: true,
              gravitationalConstant: 0.02
            },
            dataLabels: {
              enabled: true,
              format: '{point.name}',
              style: {
                fontSize: '16px',
                color: 'black',
                textOutline: 'none',
                fontWeight: 'normal'
              }
            }
          }
        },
        series: [{
          name: 'เงินเดือน',
          color: '#00BCD4',
          data: selectedData.salary
        }, {
          name: 'ค่าสวัสดิการต่างๆ',
          color: '#7634ff',
          data: selectedData.allowances
        }, {
          name: 'รายการหักเงิน',
          color: '#ff877e',
          data: selectedData.deductions
        }]
      });
    }, 500); // หน่วงเวลา 1000 มิลลิวินาที (1 วินาที)

  }
  // เรียกฟังก์ชันนี้เมื่อโหลดหน้าเว็บครั้งแรก
  setCurrentMonth();
  // เรียกฟังก์ชันนี้เมื่อโหลดหน้าเว็บครั้งแรก
  updatePackedBubbleChart(document.getElementById('month-select-pay').value);

  function updateBarChart(month, currentMonthIndex) {
    setTimeout(function() {
      var data = {
        salary: [9154700, 8000000, 7500000, 9200000, 8900000, 9400000, 9700000, 9154700, 8000000, 7500000, 9200000, 8900000],
        allowances: [724200, 680000, 600000, 750000, 720000, 770000, 800000, 724200, 680000, 600000, 750000, 720000],
        deductions: [45000, 40000, 35000, 50000, 48000, 52000, 55000, 45000, 40000, 35000, 50000, 48000]
      };

      var monthNamesShort = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

      Highcharts.chart('barChartContainer', {
        chart: {
          zoomType: 'xy'
        },
        title: {
          text: '',
          style: {
            fontSize: '16px'
          }
        },
        xAxis: [{
          categories: monthNamesShort.slice(0, currentMonthIndex + 1),
          crosshair: true,
          labels: {
            style: {
              fontSize: '14px'
            }
          }
        }],
        yAxis: [{ // Primary yAxis
          labels: {
            enabled: false
          },
          title: {
            text: null
          },
          max: 10001000 // ตั้งค่า max เป็น 10 ล้าน
        }, { // Secondary yAxis
          labels: {
            enabled: false
          },
          title: {
            text: null
          },
          opposite: true,
          max: 1000000 // ตั้งค่า max สำหรับรายการหักเงินให้สูงขึ้น
        }, { // Secondary yAxis
          labels: {
            enabled: false
          },
          title: {
            text: null
          },
          opposite: true,
          max: 5000000 // ตั้งค่า max สำหรับรายการหักเงินให้สูงขึ้น
        }],
        tooltip: {
          shared: true,
          style: {
            fontSize: '16px'
          },
          formatter: function() {
            return '<b>' + this.x + '</b><br/>' +
              this.points.map(point => `<span style="color:${point.series.color}">${point.series.name}</span>: <b>${Highcharts.numberFormat(point.y, 2, '.', ',')}</b> บาท<br/>`).join('');
          }
        },
        plotOptions: {
          column: {
            dataLabels: {
              enabled: true,
              formatter: function() {
                let y = this.y;
                if (y >= 1000000) {
                  return (y / 1000000).toFixed(2) + 'M';
                } else if (y >= 1000) {
                  return (y / 1000).toFixed(2) + 'k';
                }
                return y;
              },
              style: {
                color: '#000',
                fontSize: '14px'
              }
            }
          }
        },
        series: [{
          name: 'เงินเดือน',
          type: 'column',
          yAxis: 0,
          data: data.salary.slice(0, currentMonthIndex + 1),
          color: '#00BCD4',
          tooltip: {
            valueSuffix: ' บาท'
          }
        }, {
          name: 'ค่าสวัสดิการต่างๆ',
          type: 'column',
          yAxis: 2,
          data: data.allowances.slice(0, currentMonthIndex + 1),
          color: '#7634ff',
          tooltip: {
            valueSuffix: ' บาท'
          }
        }, {
          name: 'รายการหักเงิน',
          type: 'column',
          yAxis: 1,
          data: data.deductions.slice(0, currentMonthIndex + 1),
          color: '#ff877e',
          tooltip: {
            valueSuffix: ' บาท'
          }
        }, {
          name: 'สรุปยอดรายจ่าย',
          type: 'spline',
          yAxis: 0,
          data: data.salary.slice(0, currentMonthIndex + 1).map(function(value, index) {
            return (value + data.allowances[index] - data.deductions[index]); // ตัวอย่างการคำนวณเส้นแนวโน้ม
          }),
          color: '#4caf50', // กำหนดสีของเส้นแนวโน้มเป็นสีเขียว
          tooltip: {
            valueSuffix: ' บาท'
          }
        }]
      });
    }, 500); // หน่วงเวลา 500 มิลลิวินาที (0.5 วินาที)
  }
</script>