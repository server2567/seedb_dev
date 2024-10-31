<style>
    .leave1{
        color: #4154f1;
        background: #f6f6fe;
    }
    .leave2{
        color: #2eca6a;
        background: #e0f8e9;
    }
    .leave3{
        color: #ff771d;
        background: #ffecdf;
    }
    .leave4{
        color: #fa5278;
        background: #ffe0e7;
    }
    .leave5{
        color: #4154f1;
        background: #f6f6fe;
    }
    .leave6{
        color: #2eca6a;
        background: #e0f8e9;
    }
    .card:hover{
        background-color: #f0f6ff;
    }
    .info-card{
        cursor: pointer;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-card-list icon-menu"></i><span> รายการประเภทการลา</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <section class="section dashboard">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">

                                    <!-- ลาป่วย Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card" onclick="window.location.href='<?php echo site_url().'/'.$controller.'/leaves_input/1' ; ?>'">
                                            <div class="card-body">
                                                <h6 class="card-title">ลาป่วย</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center leave1">
                                                        <i class="ri ri-number-1"></i>
                                                    </div>
                                                    <div class="ps-3 mt-3">
                                                        <h5><span class="text-success fw-bold">คงเหลือ 20 วัน</span></h5>
                                                        <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End ลาป่วย Card -->

                                    <!-- ลากิจส่วนตัว Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card" onclick="window.location.href='<?php echo site_url().'/'.$controller.'/leaves_input/2' ; ?>'">
                                            <div class="card-body">
                                                <h6 class="card-title">ลากิจส่วนตัว</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center leave2">
                                                        <i class="ri ri-number-2"></i>
                                                    </div>
                                                    <div class="ps-3 mt-3">
                                                        <h5><span class="text-warning fw-bold">คงเหลือ 10 วัน</span></h5>
                                                        <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End ลากิจส่วนตัว Card -->

                                     <!-- ลาพักผ่อน Card -->
                                     <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card" onclick="window.location.href='<?php echo site_url().'/'.$controller.'/leaves_input/3' ; ?>'">
                                            <div class="card-body">
                                                <h6 class="card-title">ลาพักผ่อน</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center leave3">
                                                        <i class="ri ri-number-3"></i>
                                                    </div>
                                                    <div class="ps-3 mt-3">
                                                        <h5><span class="text-danger fw-bold">คงเหลือ 5 วัน</span></h5>
                                                        <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End ลาพักผ่อน Card -->

                                    <!-- ลาคลอดบุตร Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card" onclick="window.location.href='<?php echo site_url().'/'.$controller.'/leaves_input/4' ; ?>'">
                                            <div class="card-body">
                                                <h6 class="card-title">ลาคลอดบุตร</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center leave4">
                                                        <i class="ri ri-number-4"></i>
                                                    </div>
                                                    <div class="ps-3 mt-3">
                                                        <h5><span class="text-success fw-bold">คงเหลือ 15 วัน</span></h5>
                                                        <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End ลาคลอดบุตร Card -->

                                    <!-- ลาอุปสมบทหรือลาไปประกอบพิธีฮัจย์ Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card" onclick="window.location.href='<?php echo site_url().'/'.$controller.'/leaves_input/5' ; ?>'">
                                            <div class="card-body">
                                                <h6 class="card-title">ลากิจได้รับค่าจ้าง</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center leave5">
                                                        <i class="ri ri-number-5"></i>
                                                    </div>
                                                    <div class="ps-3 mt-3">
                                                        <h5><span class="text-success fw-bold">คงเหลือ 15 วัน</span></h5>
                                                        <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End ลาอุปสมบทหรือลาไปประกอบพิธีฮัจย์ Card -->

                                    <!-- ลาไปศึกษา ฝึกอบรม ปฏิบัติการวิจัย หรือดูงาน Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card" onclick="window.location.href='<?php echo site_url().'/'.$controller.'/leaves_input/6' ; ?>'">
                                            <div class="card-body">
                                                <h6 class="card-title">ลากิจไม่รับค่าจ้าง</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center leave6">
                                                        <i class="ri ri-number-6"></i>
                                                    </div>
                                                    <div class="ps-3 mt-3">
                                                        <h5><span class="text-success fw-bold">คงเหลือ 30 วัน</span></h5>
                                                        <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End ลาไปศึกษา ฝึกอบรม ปฏิบัติการวิจัย หรือดูงาน Card -->
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url().'/'.$controller; ?>'"> ย้อนกลับ</button>
                        </div>
                    </div>
                    <!-- button action form -->
                </div>
            </div>
        </div>
    </div>
</div>