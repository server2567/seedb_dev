<div class="modal fade" id="dashboard-appointment-detail-modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-dashboard-appointment-detail-modal">รายละเอียดผู้ป่วยนัดพบทั้งหมด ประจำปีการ พ.ศ. 2567</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-clock-history icon-menu"></i><span id="topic-dashboard-appointment-detail-modal">  รายการรายละเอียดผู้ป่วย</span><span class="badge bg-success" id="summary-dashboard-appointment-detail-modal">540</span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <table class="table datatable" width="100%" id="table-dashboard-appointment-detail-modal">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col">ชื่อ - นามสกุล ผู้ป่วย</th>
                                                <th scope="col">รายละเอียด</th>
                                                <th scope="col">วันที่เข้านัดพบ</th>
                                                <th scope="col">ประเภทผู้ป่วย</th>
                                                <th scope="col">การดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="appointment-table-body">
                                            <!-- <?php for($i=0; $i<540; $i++){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i+1; ?></td>
                                                <td>นายผู้ป่วย คนไข้</td>
                                                <td>ตรวจวัดค่าสายตาตามนัดหมาย</td>
                                                <td>1 เมษายน พ.ศ. 2567 เวลา 08.00 น.</td>
                                                <td><?php echo $i%2 == 0 ? "ผู้ป่วยเก่า":"ผู้ป่วยใหม่"; ?></td>
                                                <td class="text-center option">
                                                    <button class="btn btn-info"><i class="bi-search"></i></button>
                                                </td>
                                            </tr>
                                            <?php } ?> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="คลิกเพื่อปิด" data-toggle="tooltip" data-placement="top">ปิด</button>
            </div>
        </div>
    </div>
</div>