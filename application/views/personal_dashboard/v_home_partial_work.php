<style>
    .timeline div {
        padding: 0;
        height: 40px;
    }
    .timeline hr {
        border-top: 3px solid #5c6bc0;
        margin: 0;
        top: 17px;
        position: relative;
    }
    .timeline .col-2 {
        display: flex;
        overflow: hidden;
    }
    .timeline .corner {
        border: 3px solid #7986cb;
        width: 100%;
        position: relative;
        border-radius: 15px;
    }
    .timeline .top-right {
        left: 50%;
        top: -50%;
    }
    .timeline .left-bottom {
        left: -50%;
        top: calc(50% - 3px);
    }
    .timeline .top-left {
        left: -50%;
        top: -50%;
    }
    .timeline .right-bottom {
        left: 50%;
        top: calc(50% - 3px);
    }
    .circle {
        padding: 13px 20px;
        border-radius: 50%;
        background-color: #7986cb;
        color: #fff;
        max-height: 100px;
        z-index: 2;
    }
</style>

<h4 class="partial-name"><span>ข้อมูลบุคลากร</span></h4>

<div class="row p-3">
    <div class="col-md-6">
        <div class="card card-solid border-primary-subtle" style="background: #35c5e321;">
            <div class="card-body">
                <div class="text-start">รหัสประจำตัวบุคลากร</span></div>
                <div class="row">
                    <div class="col-2 text-start">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi-credit-card-2-front"></i>
                        </div>
                    </div>
                    <div class="col-10 text-end">
                        <h5 class="text-end">DT-001</h5>
                        <div class="text-dark text-end small"><i>สำหรับบุคลากรของโรงพยาบาลจักษุสุราษฎร์</i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-solid border-primary-subtle" style="background: #35c5e321;">
            <div class="card-body">
                <div class="filter float-end">
                    <a class="bi-search" data-bs-toggle="modal" data-bs-target="#work-employee-type"></a>
                </div>
                <div class="text-start">ประเภทบุคลากร</span></div>
                <div class="row">
                    <div class="col-2 text-start">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi-person-fill"></i>
                        </div>
                    </div>
                    <div class="col-10 text-end">
                        <h5 class="text-end">แพทย์ปฏิบัติงานเต็มเวลา</h5>
                        <div class="text-dark text-end small"><i>Full time</i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-solid border-primary-subtle" style="background: #353ce321; border-color: #353ce396 !important;">
            <div class="card-body">
                <div class="text-start">เลขที่ใบประกอบวิชาชีพเวชกรรม</span></div>
                <div class="row">
                    <div class="col-2 text-start">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi-card-heading"></i>
                        </div>
                    </div>
                    <div class="col-10 text-end">
                        <h5 class="text-end">23575</h5>
                        <div class="text-dark text-end small"><i>หมดอายุวันที่ 23 ธันวคม พ.ศ.2570</i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="card card-solid border-primary-subtle" style="background: #353ce321; border-color: #353ce396 !important;">
            <div class="card-body">
                <div class="filter float-end">
                    <a class="bi-search" data-bs-toggle="modal" data-bs-target="#work-timeline-modal"></a>
                </div>
                <div class="text-start">เงินเดือน</span></div>
                <div class="row">
                    <div class="col-2 text-start">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi-briefcase-fill"></i>
                        </div>
                    </div>
                    <div class="col-10 text-end">
                        <h5 class="text-end">แพทย์ปฏิบัติงานประจำ</h5>
                        <div class="text-dark text-end small"><i>Full time</i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="col-md-6">
        <div class="card card-solid border-primary-subtle" style="background: #353ce321; border-color: #353ce396 !important;">
            <div class="card-body">
                <div class="filter float-end">
                    <a class="bi-search" data-bs-toggle="modal" data-bs-target="#work-timeline-modal"></a>
                </div>
                <div class="text-start">ประสบการณ์ทำงาน</span></div>
                <div class="row">
                    <div class="col-2 text-start">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi-briefcase-fill"></i>
                        </div>
                    </div>
                    <div class="col-10 text-end">
                        <h5 class="text-end">17 ปี 5 เดือน 9 วัน</h5>
                        <div class="text-dark text-end small"><i>เริ่มงานวันที่ 20 เมษายน พ.ศ.2530</i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="card card-solid border-primary-subtle" style="background: #e3359229; border-color: #e335ab96 !important;">
            <div class="card-body">
                <div class="filter float-end">
                    <a class="bi-search" data-bs-toggle="modal" data-bs-target="#reward-timeline-modal"></a>
                </div>
                <div class="text-start">จำนวนผลงาน/รางวัล</span></div>
                <div class="row">
                    <div class="col-2 text-start">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi-list-stars"></i>
                        </div>
                    </div>
                    <div class="col-10 text-end">
                        <h5 class="text-end">5</h5>
                        <div class="text-dark text-end small"><i>รายการ</i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>

<div class="modal fade" id="work-employee-type" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ความหมายประเภทบุคลากร</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <div class="tab-pane fade show active profile-overview" id="profile-overview">
                </div> -->
                <p>▪ แพทย์ปฏิบัติงานเต็มเวลา (Full time) หมายถึง แพทย์ที่ปฏิบัติงานเต็มเวลา ทั้งนี้ต้องไม่น้อยกว่าสัปดาห์ละ 40 ชม. โดยทำสัญญาจ้างเป็นลายลักษณ์อักษรหรือมีข้อตกลงจากผู้อนุญาตประกอบกิจการ</p>
                <p>▪ แพทย์ปฏิบัติงานบางเวลา (Part time) หมายถึง แพทย์ที่ปฏิบัติงาน น้อยกว่าสัปดาห์ละ 40 ชม.</p>
                <p>▪ แพทย์ที่ปรึกษา หมายถึง แพทย์ที่มาปฏิบัติงานเฉพาะเมื่อมีผู้ป่วยเฉพาะราย</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>