<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลผู้ป่วยที่ทำการแสกน QR-Code <?php  ?></span><span class="badge bg-success"><?php echo count($qr_code); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                    </div>
                    <table class="table datatable" width="100%" id="sickness-duration-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">ชื่อ-นามสกุลผู้ป่วย</th>
                                <th class="text-center">เส้นทางการรักษา</th>
                                <th class="text-center">จุดบริการปัจจุบัน</th>
                                <th class="text-center">วันเวลาที่ทำการแสกน</th>
                                <!-- <th class="text-center">วันที่อัปเดตล่าสุด</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($qr_code as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                    <div><?php echo $item['pt_name'] ?></div>

                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo isset($item['rdp_name']) ? $item['rdp_name'] : '-'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item['dst_name_point']?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item['qrsp_date_time']?></div>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>