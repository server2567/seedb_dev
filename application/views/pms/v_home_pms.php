<div class="card">
  <div class="accordion">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
          <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อบุคลากร</span>
        </button>
      </h2>
      <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
        <div class="accordion-body">
          <form class="row g-3" method="get">
            <div class="col-md-3">
              <label for="select_dp_id" class="form-label">หน่วยงาน</label><span class="text-danger"> *</span>
              <select class="form-select select2 select2-hidden-accessible" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="" id="">
                <option value="1" selected="">โรงพยาบาลจักษุสุราษฎร์</option>
                <option value="2">คลินิกบรรยงจักษุ</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="select_dp_id" class="form-label">ปีปฏิทิน</label><span class="text-danger"> *</span>
              <select class="form-select select2 select2-hidden-accessible" data-placeholder="-- กรุณาเลือกปีปฏิทิน --" name="" id="">
                <option value="2567" selected="">2567</option>
                <option value="2566">2566</option>
              </select>
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
          <i class="bi bi-table me-2"></i><span>ตารางแสดงสรุปรายจ่ายเงินเดือน จำแนกตามเดือน</span>
        </button>
      </h2>
      <div id="collapseShow" class="accordion-collapse collapse show">
        <div class="card-body"> 
            <a type="button" href='<?php echo site_url();?>/pms/Payroll' class="btn btn-primary font-24"><i class="bi bi-paypal me-1"></i> เพิ่มใบจ่ายเงินเดือน</a>
        </div>
        <div class="accordion-body">
          <table id="" class="table datatable" width="100%" style="width: 100%;">
            <thead>
              <tr>
                <th>ลำดับ</th>
                <th>เลขที่จ่ายสรุปเงินเดือน</th>
                <th>วันที่ทำรายการ</th>
                <th>รอบที่จ่าย</th>
                <th>จำนวนพนักงาน</th>
                <th>จำนวนการจ่าย</th>
                <th>จำนวนเงินที่จ่ายสุทธิ</th>
                <th>สถานะ</th>
                <th>ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">1</td>
                <td>PAYS-2567-05-20</td>
                <td>19/10/2567</td>
                <td>30/10/2567 - 20/03/2567</td>
                <td class="text-center">105</td>
                <td class="text-center">113</td>
                <td>1,011,414.01</td>
                <td class="text-center">
                <span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i> อนุมัติ</span><br>
                <span class="badge bg-light text-primary fs-6 mt-3" style="line-height:1.5"><i class="bi bi-alexa me-1"></i> 27/11/2567 <br>รอจ่าย</span></td>
                <td class="text-center"><a type="button" class="btn btn-dark" href="<?php echo site_url(); ?>/pms/Payroll_print"><i class="bi bi-printer"></i></a></td>
              </tr>
              <tr>
                <td class="text-center">2</td>
                <td>PAYS-2567-09-20</td>
                <td>22/10/2567</td>
                <td>11/08/2567 - 02/05/2567</td>
                <td class="text-center">118</td>
                <td class="text-center">120</td>
                <td>1,293,108.16</td>
                <td class="text-center"><span class="badge bg-warning text-dark fs-6"><i class="bi bi-check-circle me-1"></i> รอการอนุมัติ</span></td>
                <td class="text-center"><a type="button" class="btn btn-primary" href="<?php echo site_url(); ?>/pms/Payroll_show"><i class="bi bi-search"></i></a></td>
              </tr>
              <tr>
                <td class="text-center">3</td>
                <td>PAYS-2567-11-08</td>
                <td>29/09/2567</td>
                <td>21/03/2567 - 23/09/2567</td>
                <td class="text-center">146</td>
                <td class="text-center">157</td>
                <td>1,017,715.58</td>
                <td class="text-center"><span class="badge bg-warning text-dark fs-6"><i class="bi bi-check-circle me-1"></i> รอการอนุมัติ</span></td>
                <td class="text-center"><a type="button" class="btn btn-primary" href="<?php echo site_url(); ?>/pms/Payroll_show"><i class="bi bi-search"></i></a></td>
              </tr>
              <tr>
                <td class="text-center">4</td>
                <td>PAYS-2567-03-12</td>
                <td>28/03/2567</td>
                <td>09/04/2567 - 05/12/2567</td>
                <td class="text-center">131</td>
                <td class="text-center">131</td>
                <td>1,300,383.61</td>
                <td class="text-center"><span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i> อนุมัติ</span><br>
                <span class="badge bg-light text-success fs-6 mt-3" style="line-height:1.5"><i class="bi bi-check-circle-fill me-1"></i> 27/09/2567 <br>จ่ายแล้ว</span></td>
                <td class="text-center"><a type="button" class="btn btn-dark" href="<?php echo site_url(); ?>/pms/Payroll_print"><i class="bi bi-printer"></i></a></td>
              </tr>
              <tr>
                <td class="text-center">5</td>
                <td>PAYS-2567-04-21</td>
                <td>08/04/2567</td>
                <td>07/05/2567 - 05/03/2567</td>
                <td class="text-center">122</td>
                <td class="text-center">136</td>
                <td>1,408,625.07</td>
                <td class="text-center"><span class="badge bg-warning text-dark fs-6"><i class="bi bi-check-circle me-1"></i> รอการอนุมัติ</span></td>
                <td class="text-center"><a type="button" class="btn btn-primary" href="<?php echo site_url(); ?>/pms/Payroll_show"><i class="bi bi-search"></i></a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>