<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="filter filterDetail">
        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#details_chart_1_modal"> ดูรายละเอียด</a>
      </div>
      <div class="card-body">
        <h5 class="card-title pt-1 pb-0 font-20 w-90">[HRM-1] จำนวนบุคลากร จำแนกตามสายงาน</h5>
        <hr>
        <div class="row">
          <!-- กราฟวงกลมด้านซ้าย -->
          <div class="col-md-6">
            <div class="chart-container">
              <div id="loader1" class="loader"></div>
              <div id="hrm-chart-1"></div>
            </div>
          </div>
          <!-- การ์ดด้านขวา -->
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <div id="card_all">
                  <div class="card info-card sales-card" style="border-bottom: 3px solid #FF9800; background: #fff5e8;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3 font-16">[HRM-C1] บุคลากรทั้งหมด</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #FF9800; background: #ffeacc;">
                          <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ps-4">
                          <h6></h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="all" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div id="card_admin">
                  <div class="card info-card revenue-card" style="border-bottom: 3px solid #E91E63; background: #ffe9f1;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3 font-16">[HRM-C2] สายบริหาร</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #E91E63; background: #ffc1d6;">
                          <i class="bi bi-person-fill-gear"></i>
                        </div>
                        <div class="ps-4">
                          <h6></h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12  toggleCardHRMDetail" data-card-type="admin" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div id="card_medical">
                  <div class="card info-card customers-card" style="border-bottom: 3px solid #00bcd4; background: #e8faff;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3  font-16">[HRM-C3] สายแพทย์เต็มเวลา / แพทย์บางเวลา</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #00BCD4; background: #a7f5ff;">
                          <i class="bi bi-person-hearts"></i>
                        </div>
                        <div class="ps-4">
                          <h6></h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12  toggleCardHRMDetail" data-card-type="medical" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div id="card_nurse">
                  <div class="card info-card revenue-card" style="border-bottom: 3px solid #4bc0c0; background: #e8fff9;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3  font-16">[HRM-C4] สายการพยาบาล</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #18a1a1; background: #b1ebeb;">
                          <i class="ri ri-nurse-fill"></i>
                        </div>
                        <div class="ps-4">
                          <h6></h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12  toggleCardHRMDetail" data-card-type="nurse" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div id="card_support_medical">
                  <div class="card info-card revenue-card" style="border-bottom: 3px solid #9866ff; background: #f5f1ff;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3 font-16">[HRM-C5] สายสนับสนุนทางการแพทย์</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9866ff; background: #e0d1ff;">
                          <i class="bi bi-person-fill-check"></i>
                        </div>
                        <div class="ps-4">
                          <h6></h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="support_medical" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div id="card_technical">
                  <div class="card info-card revenue-card" style="border-bottom: 3px solid #607D8B; background: #ebebeb;">
                    <div class="card-body pb-2">
                      <h5 class="pt-1 pb-3 font-16">[HRM-C6] สายเทคนิคและบริการ</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #3c5e6e; background: #cdcdcd;">
                          <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="ps-4">
                          <h6></h6>
                        </div>
                      </div>
                    </div>
                    <div class="filter filterDetail">
                      <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggleCardHRMDetail" data-card-type="technical" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- .row -->
          </div> <!-- .col-md-6 -->
        </div> <!-- .row -->
      </div> <!-- .card-body -->
    </div> <!-- .card -->
  </div> <!-- .col-md-12 -->
  <div class="col-md-6">
    <div class="card">
      <div class="filter filterDetail">
        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#details_chart_2_modal"></a>
      </div>
      <div class="card-body">
        <h5 class="card-title pt-1 pb-0 font-20 w-90">[HRM-2] จำนวนบุคลากร จำแนกตามฝ่าย</h5>
        <hr>
        <div class="row">
          <!-- กราฟวงกลมด้านซ้าย -->
          <div class="col-md-12">
            <div class="chart-containe">
              <div id="loader2" class="loader"></div>
              <div id="hrm-chart-2" style="height:370px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="filter filterDetail">
        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#details_chart_3_Modal"></a>
      </div>
      <div class="card-body">
        <h5 class="card-title pt-1 pb-0 font-20 w-90">[HRM-3] จำนวนบุคลากรจำแนกตามช่วงอายุการทำงาน</h5>
        <hr>
        <div class="row">
          <!-- กราฟวงกลมด้านซ้าย -->
          <div class="col-md-12">
            <div class="chart-containe">
              <div id="loader3" class="loader"></div>
              <div id="hrm-chart-3" style="height:370px;"></div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="filter filterDetail">
        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#details_chart_4_modal"></a>
      </div>
      <div class="card-body">
        <h5 class="card-title pt-1 pb-0 font-20 w-90">[HRM-4] รายงานจำนวนแพทย์ และพยาบาลที่อยู่ในแผนก</h5>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="chart-containe">
              <div id="hrm-chart-4"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="filter filterDetail">
        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#details_chart_5_modal"></a>
      </div>
      <div class="card-body">
        <h5 class="card-title pt-1 pb-0 font-20 w-90">[HRM-5] รายงานจำนวนวุฒิการศึกษาของแต่ละสายงาน จำแนกตามวุฒิการศึกษา</h5>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="chart-containe">
              <div id="hrm-chart-5"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const processStatusKey = 'processStatus';
    // ฟังก์ชันเก็บสถานะของทำงานใน LocalStorage
    function saveProcessStatus(chart) {
      const processItems = chart.series[0].data;
      const processVisibility = processItems.map(item => item.visible);
      localStorage.setItem(processStatusKey, JSON.stringify(processVisibility));
    }

    // ฟังก์ชันตั้งค่าสถานะของทำงานจาก LocalStorage
    function loadProcessStatus(chart) {
      const processStatus = localStorage.getItem(processStatusKey);
      if (processStatus) {
        const processVisibility = JSON.parse(processStatus);
        chart.series[0].data.forEach((item, index) => {
          item.setVisible(processVisibility[index], false);
        });
        chart.redraw();
      }
    }

 
</script>
