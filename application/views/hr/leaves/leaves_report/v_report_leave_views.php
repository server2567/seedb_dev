<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body pt-0 pb-0 mt-4 mb-4" id="print-section"  style="zoom:90%;">
        <div class="row">
          <div class="col-md-8 d-flex align-items-center">
            <img src="<?php echo base_url(); ?>assets/img/pms/logo_pms.png" class="card-img-top me-5" style="width:320px;">
            <h5 class="font-30 text-center mx-auto">แบบใบ<?= $result->leave_name ?></h5>
          </div>
          <div class="col-md-4 d-flex flex-column">
            <button type="button" class="btn btn-primary btn-lg"><i class="bi bi-printer me-2"></i> พิมพ์ใบลา</button>
            <h5 class="mt-4"><b>เลขที่ใบลา</b> : <?= $result->lhis_doc_id == '' ? '-': $result->lhis_doc_id ?></h5>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-8 mt-3">
            <div class="alert alert-success" role="alert">
              <div class="row">
                <div class="col-md-4 pe-0">
                  <span class="font-20"><b>ผู้ที่ทำเรื่องลา : </b><?= $result->pf_name.' '.$result->ps_fname.' '.$result->ps_lname ?></span>
                </div>
                <div class="col-md-3 ps-0">
                  <span class="font-20"><b>ตำแหน่ง : </b><?= $result->alp_name ?></span>
                </div>
                <div class="col-md-5 ps-0">
                  <span class="font-20"><b>ตำแหน่งในโครงสร้าง : </b><?= $result->stde_name_th ?></span>
                </div>
              </div>
            </div>
            <div class="row mx-4">
                <h5 class="mt-3 fw-bold">ประเภทการลา</h5>
                <h5 class="fw-medium mt-2"><?= $result->leave_name ?></h5>
            </div>
            <div class="row mx-4">
                <h5 class="mt-3 fw-bold">เรื่อง</h5>
                <h5 class="fw-medium mt-2">ขออนุญาต<?= $result->leave_name ?> เนื่องจาก <?= $result->lhis_topic ?></h5>
            </div>
            <div class="row mx-4 mt-3">
              <div class="col-md-4">
                <h5 class="mt-3 fw-bold">ตั้งแต่วันที่</h5>
                <h5 class="fw-medium mt-2"><?= fullDateth3($result->lhis_start_date) ?></h5>
              </div>
              <div class="col-md-4">
                <h5 class="mt-3 fw-bold">ถึงวันที่</h5>
                <h5 class="fw-medium mt-2"><?= fullDateth3($result->lhis_end_date) ?></h5>
              </div>
              <div class="col-md-4">
                <h5 class="mt-3 fw-bold">รวม</h5>
                <h5 class="fw-medium mt-2"><?= $result->lhis_num_day ?> วัน <?= $result->lhis_num_hour ?> ชั่วโมง <?= $result->lhis_num_minute ?> นาที</h5>
              </div>
            </div>
            <div class="row mx-4 mt-3">
              <div class="col-md-12">
                <h5 class="mt-3 fw-bold">ในระหว่างลาจะติดต่อข้าพเจ้าได้ที่</h5>
                <h5 class="fw-medium mt-2">โทรศัพท์ <?= $result->psd_cellphone != '' ? $result->psd_cellphone : '-' ?></h5>
              </div>
            </div>
          </div>
          <div class="col-md-4 mt-3">
            <div class="alert alert-warning " style="background: #fff9e8;" role="alert">
              <div class="row">
                <div class="col-md-12 pe-0">
                  <span class="font-22 fw-bold">สถิติการลาในปีปฏิทิน 2567</span>
                </div>
                <div class="col-md-6">
                  <div class="card text-white mb-3 mt-3">
                    <div class="card-header font-22 fw-bold text-success-emphasis">ลามาแล้ว <a href="#"><i class="bi bi-search font-22 text-primary float-end"></i></a>
                    </div>
                    <div class="card-body pb-0 d-flex justify-content-between">
                      <i class="bi bi-calendar-check font-36 text-success"></i>
                      <h5 class="card-title font-28"><?= $result->day_used ?> วัน</h5>
                    </div>
                    <div class="card-body pt-0 pb-0">
                      <h5 class="font-18 text-danger lh-base">ลาครั้งล่าสุดเมือวันที่ <br><?= fullDateth3($result->day_last_used) ?></h5>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card text-white mb-3 mt-3">
                    <div class="card-header font-22 fw-bold text-warning-emphasis">ลาครั้งนี้</div>
                    <div class="card-body pb-0  d-flex justify-content-between">
                      <i class="bi bi-calendar-week font-36 text-warning"></i>
                      <h5 class="card-title font-28 text-right"><?= $result->lhis_num_day ?>  วัน</h5>
                    </div>
                    <div class="card-body" style="padding-top: 0.7rem;">
                      <h5 class="font-18 text-danger lh-base">&emsp;</h5>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card text-white mb-3 mt-3">
                    <div class="card-header font-22 fw-bold text-primary-emphasis">รวมเป็น</div>
                    <div class="card-body d-flex justify-content-between">
                    <i class="bi bi-calendar3 font-36 text-primary"></i>
                      <h5 class="card-title font-28 text-right"><?= $result->day_used+$result->lhis_num_day ?>  วัน</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-md-4">
            <div class="alert alert-info bg-white mt-5" role="alert">
              <div class="row">
                <div class="col-md-12">
                  <h5 class="font-22 ms-4 fw-bold">ผู้ตรวจสอบการลา</h5>
                  <h5 class="mt-4 ms-4 text-success"><i class="bi bi-check-circle me-3 font-28"></i>อนุญาต</h5>
                  <h5 class="mt-4 ms-4"><span class=" fw-bold">ความเห็น</span> : อนุญาตให้นายภาติยะ เพียรสวัสดิ์ ลาในครั้งนี้</h5>
                  <h5 class="mt-4 ms-4 lh-base"><span class=" fw-bold">ลงชื่อ</span> นายสมหมาย เปิดหน้าต่างพิมพ์</h5>
                  <h5 class="ms-4">หัวหน้างานบุคลากร</h5>
                  <h5 class="ms-4">วันที่ 4 ธันวาคม พ.ศ. 2567 เวลา 14.00 น.</h5>
                </div>
              </div>
            </div>
          </div> -->
          <div class="col-md-6">
            <div class="alert alert-primary bg-white mt-5" role="alert">
              <div class="row">
                <div class="col-md-12">
                  <h5 class="font-22 ms-4 fw-bold">ความเห็นผู้บังคับบัญชา</h5>
                  <h5 class="mt-4 ms-4 text-primary"><i class="bi bi-circle me-3 font-28"></i>รอการอนุญาต</h5>
                  <h5 class="mt-4 ms-4"><span class=" fw-bold">ความเห็น</span> : รับทราบ</h5>
                  <h5 class="mt-4 ms-4 lh-base"><span class=" fw-bold">ลงชื่อ</span> นพ. บรรยง ชินกุลกิจนิวัฒน</h5>
                  <h5 class="ms-4">หัวหน้าภาคจักษุวิทยา (EYE)</h5>
                  <h5 class="ms-4">วันที่ 4 ธันวาคม พ.ศ. 2567 เวลา 09.00 น.</h5>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="alert alert-secondary bg-white mt-5" role="alert">
              <div class="row">
                <div class="col-md-12">
                  <h5 class="font-22 ms-4 fw-bold">ผู้มีอำนาจอนุมัติการลา</h5>
                  <h5 class="mt-4 ms-4 text-danger"><i class="bi bi-x-circle me-3 font-28"></i>ไม่อนุญาต</h5>
                  <h5 class="mt-4 ms-4 lh-base"><span class=" fw-bold">ความเห็น</span> : ไม่อนุมัติให้นายภาติยะ เพียรสวัสดิ์ ลาในครั้งนี้ มีภาระกิจด่วนที่ต้องจัดการให้เรียบร้อยก่อน ถึงจะสามารถลางานได้</h5>
                  <h5 class="mt-4 ms-4"><span class=" fw-bold">ลงชื่อ</span> นพ. บรรยง ชินกุลกิจนิวัฒน</h5>
                  <h5 class="ms-4">หัวหน้าภาคจักษุวิทยา (EYE)</h5>
                  <h5 class="ms-4">วันที่ 4 ธันวาคม พ.ศ. 2567</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>