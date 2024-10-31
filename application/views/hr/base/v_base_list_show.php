<style>
    .card-hover:hover {
        background-color: #cfe2ff;
        cursor: pointer;
        opacity: 0.6;
        /* เปลี่ยนค่าตามต้องการ */
    }

    .card-hover span {
        font-size: 14px;
    }

    .accordion-header:hover {
        background-color: #cfe2ff;
        cursor: pointer;
        opacity: 0.6;
        /* เปลี่ยนค่าตามต้องการ */
    }
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">จัดการข้อมูลพื้นฐาน</h5>
            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">
                <div class="accordion-body">

                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            ข้อมูลส่วนตัว
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Prefix'">
                                        <div class="card-body card-hover">
                                            <div class="card-body">
                                                <h1 class="card-title">คำนำหน้าชื่อ/ยศ</h1>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <h1 class="bi bi-person-vcard-fill"></h1>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h3>145</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Nation'">
                                        <div class="card-body card-hover">
                                            <div class="card-body">
                                                <h1 class="card-title">ข้อมูลสัญชาติ</h1>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <h1 class="bi bi-person-vcard-fill"></h1>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h3>145</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Race'">
                                        <div class="card-body card-hover">
                                            <div class="card-body">
                                                <h1 class="card-title">ข้อมูลเชื้อชาติ</h1>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <h1 class="bi bi-person-vcard-fill"></h1>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h3>145</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Religion'">
                                        <div class="card-body card-hover">
                                            <div class="card-body">
                                                <h1 class="card-title">ข้อมูลศาสนา</h1>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <h1 class="bi bi-person-vcard-fill"></h1>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h3>145</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Person_status'">
                                        <div class="card-body card-hover">
                                            <div class="card-body">
                                                <h1 class="card-title">ข้อมูลสถานภาพ</h1>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <h1 class="bi bi-person-vcard-fill"></h1>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h3>145</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Retire'">
                                        <div class="card-body card-hover">
                                            <div class="card-body">
                                                <h1 class="card-title">ข้อมูลสถานะปัจจุบัน</h1>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <h1 class="bi bi-person-vcard-fill"></h1>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h3>145</h3>
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
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            ข้อมูลที่อยู่
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/District'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ข้อมูลตำบล</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-map"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>230</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Amphur'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ข้อมูลอำเภอ</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-map"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>170</h3>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Province/'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ข้อมูลจังหวัด</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-map"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>77</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Country'">
                                        <div class="card-body card-body card-hover">
                                            <h1 class="card-title">ข้อมูลประเทศ</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-map"></h1>
                                                    <div class="ps-3">
                                                        <h3>77</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>+
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            ด้านการศึกษา
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_level'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ระดับการศึกษา</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-pencil-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>230</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_degree'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">วุฒิการศึกษา</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-pencil-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>170</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_major'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">สาขาวิชาการศึกษา</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-pencil-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>77</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_place'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">สถานศึกษา</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-pencil-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>77</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            ใบประกอบวิชาชีพ
                        </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Vocation'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ชื่อวิชาชีพ</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-file-text-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>230</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            รูปแบบการลงเวลาทำงาน
                        </button>
                    </h2>
                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_shift'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ข้อมูลประเภทการขึ้นเวร</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-hourglass-bottom"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>4</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_status'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ข้อมูลสถานะการปฏิบัติงาน</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-hourglass-bottom"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>5</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse5">
                            แผนก/ห้องปฏิบัติงาน
                        </button>
                    </h2>
                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_base_department'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">แผนก และห้องปฏิบัติงาน</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-person-badge-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>4</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_status'">
                                        <div class="card-body">
                                            <h1 class="card-title">สถานะการปฏิบัติงาน</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-card-list"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>5</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="true" aria-controls="collapse6">
                            </i> ตำแหน่งโครงสร้างองค์กร
                        </button>
                    </h2>
                    <div id="collapse7" class="accordion-collapse collapse " aria-labelledby="heading6" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/hire'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ประเภทบุคลากร</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-people"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>4</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/special_position'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ตำแหน่งงานเฉพาะทาง</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-people"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>5</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/admin_position'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ตำแหน่งในการบริหารงาน</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-people"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>5</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/adline_position'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ตำแหน่งในสายงาน</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-people"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>5</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="true" aria-controls="collapse8">
                            </i> ข้อมูลวันหยุด
                        </button>
                    </h2>
                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/calendar'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ข้อมูลวันหยุด</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-calendar2-day-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>4</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="true" aria-controls="collapse9">
                            </i> ข้อมูลรางวัล/นวัตกรรม
                        </button>
                    </h2>
                    <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/reward_level'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ข้อมูลระดับรางวัล</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-trophy-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>4</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/reward_type'">
                                        <div class="card-body card-hover">
                                            <h1 class="card-title">ข้อมูลด้านรางวัล</h1>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <h1 class="bi bi-trophy-fill"></h1>
                                                </div>
                                                <div class="ps-3">
                                                    <h3>4</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Default Accordion Example -->
            </div>
        </div>
    </div>