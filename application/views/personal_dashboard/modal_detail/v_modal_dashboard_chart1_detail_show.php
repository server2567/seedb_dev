<div class="modal fade" id="dashboard-chart1-detail-modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดการมาทำงาน การทำงานล่วงเวลา การลา และมาสาย ประจำเดือนพฤษภาคมปี พ.ศ. 2567</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <div class="mb-3 text-end">
                    <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/UMS'"><i class="bi-arrow-right-square"></i> เข้าสู่ระบบ </button>
                </div> -->
                <div class="card">
                    <ul class="nav nav-tabs d-flex" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="dashboard-work-detail-tab" data-bs-toggle="tab" data-bs-target="#dashboard-work-detail" type="button" role="tab" aria-controls="dashboard-work-detail" aria-selected="true">การมาทำงาน</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="dashboard-overtime-detail-tab" data-bs-toggle="tab" data-bs-target="#dashboard-overtime-detail" type="button" role="tab" aria-controls="dashboard-overtime-detail" aria-selected="false">ทำงานล่วงเวลา</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="dashboard-leave-detail-tab" data-bs-toggle="tab" data-bs-target="#dashboard-leave-detail" type="button" role="tab" aria-controls="dashboard-leave-detail" aria-selected="false">การลา</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="dashboard-late-detail-tab" data-bs-toggle="tab" data-bs-target="#dashboard-late-detail" type="button" role="tab" aria-controls="dashboard-late-detail" aria-selected="false">การมาสาย</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="dashboard-work-detail" role="tabpanel" aria-labelledby="dashboard-work-detail-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingWork">
                                            <button class="accordion-button accordion-button-table" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWork" aria-expanded="true" aria-controls="collapseWork">
                                                <i class="bi-clock-history icon-menu"></i><span> รายละเอียดการมาทำงาน</span><span class="badge bg-success">17</span>
                                            </button>
                                        </h2>
                                        <div id="collapseWork" class="accordion-collapse collapse show" aria-labelledby="headingWork" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%" scope="col" class="text-center">#</th>
                                                            <th width="45%" scope="col">วันที่เข้างาน</th>
                                                            <th width="45%" scope="col">เวลาเข้างาน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < 17; $i++) { ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $i + 1; ?></td>
                                                                <td><?php echo $i + 1; ?> พฤษภาคม พ.ศ. 2567</td>
                                                                <td>09.00 - 18.00</td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="dashboard-overtime-detail" role="tabpanel" aria-labelledby="dashboard-overtime-detail-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOvertime">
                                            <button class="accordion-button accordion-button-table" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOvertime" aria-expanded="false" aria-controls="collapseOvertime">
                                                <i class="bi-clock-history icon-menu"></i><span> รายละเอียดการทำงานล่วงเวลา</span><span class="badge bg-success">2</span>
                                            </button>
                                        </h2>
                                        <div id="collapseOvertime" class="accordion-collapse collapse show" aria-labelledby="headingOvertime" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%" scope="col" class="text-center">#</th>
                                                            <th width="45%" scope="col">ตั้งแต่วันที่</th>
                                                            <th width="45%" scope="col">สิ้นสุดวันที่</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td>1 พฤษภาคม พ.ศ. 2567 เวลา 09.00</td>
                                                            <td>1 พฤษภาคม พ.ศ. 2567 เวลา 18.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">2</td>
                                                            <td>5 พฤษภาคม พ.ศ. 2567 เวลา 09.00</td>
                                                            <td>5 พฤษภาคม พ.ศ. 2567 เวลา 18.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="dashboard-leave-detail" role="tabpanel" aria-labelledby="dashboard-leave-detail-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingLeave">
                                            <button class="accordion-button accordion-button-table" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeave" aria-expanded="false" aria-controls="collapseLeave">
                                                <i class="bi-clock-history icon-menu"></i><span> รายละเอียดการลา</span><span class="badge bg-success">2</span>
                                            </button>
                                        </h2>
                                        <div id="collapseLeave" class="accordion-collapse collapse show" aria-labelledby="headingLeave" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" class="text-center">#</th>
                                                            <th width="15%">ประเภทการลา</th>
                                                            <th width="35%">รายละเอียด</th>
                                                            <th width="5%" class="text-center">จำนวน</th>
                                                            <th width="20%">ตั้งแต่วันที่</th>
                                                            <th width="20%">สิ้นสุดวันที่</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td>ลาเพื่อฝึกอบรมหรือพัฒนาความรู้</td>
                                                            <td>เข้าอบรม</td>
                                                            <td class="text-center">2 วัน</td>
                                                            <td>1 พฤษภาคม พ.ศ. 2567<br>เวลา 09.00 น.</td>
                                                            <td>2 พฤษภาคม พ.ศ. 2567<br>เวลา 18.00 น.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">2</td>
                                                            <td>ลาป่วย</td>
                                                            <td>ไม่สบาย</td>
                                                            <td class="text-center">1 วัน</td>
                                                            <td>3 พฤษภาคม พ.ศ. 2567<br>เวลา 09.00 น.</td>
                                                            <td>3 พฤษภาคม พ.ศ. 2567<br>เวลา 18.00 น.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">3</td>
                                                            <td>ลากิจ</td>
                                                            <td>ทำบัตรประชาชน</td>
                                                            <td class="text-center">1 วัน</td>
                                                            <td>8 พฤษภาคม พ.ศ. 2567<br>เวลา 09.00 น.</td>
                                                            <td>8 พฤษภาคม พ.ศ. 2567<br>เวลา 18.00 น.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="dashboard-late-detail" role="tabpanel" aria-labelledby="dashboard-late-detail-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingLate">
                                            <button class="accordion-button accordion-button-table" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLate" aria-expanded="false" aria-controls="collapseLate">
                                                <i class="bi-clock-history icon-menu"></i><span> รายละเอียดการมาทำงานสาย</span><span class="badge bg-success">2</span>
                                            </button>
                                        </h2>
                                        <div id="collapseLate" class="accordion-collapse collapse show" aria-labelledby="headingLate" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%" scope="col" class="text-center">#</th>
                                                            <th width="30%" scope="col">วันที่เข้างาน</th>
                                                            <th width="30%" scope="col" class="text-center">เวลาเข้างาน</th>
                                                            <th width="30%" scope="col" class="text-center">สายเป็นระยะเวลา</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < 4; $i++) { ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $i + 1; ?></td>
                                                                <td><?php echo $i + 1; ?> พฤษภาคม พ.ศ. 2567</td>
                                                                <td class="text-center">09.05</td>
                                                                <td class="text-center">5 นาที</td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>