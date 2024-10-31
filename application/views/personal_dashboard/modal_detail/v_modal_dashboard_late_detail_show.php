<div class="modal fade" id="dashboard-late-detail-modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดการมาทำงานสาย ประจำเดือนพฤษภาคม ปี พ.ศ. 2567</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-clock-history icon-menu"></i><span>  รายการการมาทำงานสาย</span><span class="badge bg-success">2</span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
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
                                            <?php for($i=0; $i<4; $i++){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i+1; ?></td>
                                                <td><?php echo $i+1; ?> พฤษภาคม พ.ศ. 2567</td>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>