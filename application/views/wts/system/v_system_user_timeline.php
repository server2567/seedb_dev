<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>เส้นทางการรักษาผู้ป่วย</span><span class="badge bg-success">4</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">ดำเนินการ</th>
                                <th class="text-center">#</th>
                                <th>แผนก</th>
                                <th>สถานะ</th>
                                <th>ห้องปฏิบัติการทางการแพทย์</th>
                                <th class="text-center">ระยะเวลาที่ต้องรอ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $data = array(
                                    array(
                                        'pat_type' => 'ซักประวัติ',
                                        'pat_status' => 'วัดน้ำหนัก ส่วนสูง',
                                        'pat_room' => 'โต๊ะซักประวัติ',
                                        'pat_time' => '10 นาที',
                                        'id' => 1
                                    ),
                                    array(
                                        'pat_type' => 'จักษุ',
                                        'pat_status' => 'ตรวจม่านตา',
                                        'pat_room' => 'ห้องตรวจโรคทั่วไป 2',
                                        'pat_time' => '15 นาที',
                                        'id' => 2
                                    ),
                                    array(
                                        'pat_type' => 'การเงิน',
                                        'pat_status' => 'จ่ายค่ารักษา',
                                        'pat_room' => 'ห้อองการเงิน 2',
                                        'pat_time' => '10 นาที',
                                        'id' => 3
                                    ),
                                    array(
                                        'pat_type' => 'จ่ายยา',
                                        'pat_status' => 'รับยา',
                                        'pat_room' => 'ห้องจ่ายยาช่อง 3',
                                        'pat_time' => '20 นาที',
                                        'id' => 4
                                    )
                                );
                            ?>
                            <?php foreach ($data as $key => $item) { ?>
                                <tr>
                                    <td>
                                    <!-- Checkbox อยู่ตรงกลาง -->
                                        <div class="checkbox-container text-center">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['pat_type']?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['pat_status']?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['pat_room']?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item['pat_time']?></div>
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