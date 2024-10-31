<?php
                                $data = array(
                                    array(
                                        'sync_que_type' => 'จักษุ',
                                        'sync_que_room' => 'ห้องตรวจโรคทั่วไป 2',
                                        'sync_que_time' => '10',
                                        'id' => 1
                                    ),
                                    array(
                                        'sync_que_type' => 'โสต ศอ นาสิก',
                                        'sync_que_room' => 'ห้องตรวจหู 2',
                                        'sync_que_time' => '8',
                                        'id' => 2
                                    ),
                                    array(
                                        'sync_que_type' => 'ทันตกรรม',
                                        'sync_que_room' => 'ห้องทันตกรรมทั่วไป',
                                        'sync_que_time' => '3',
                                        'id' => 3
                                    ),
                                    array(
                                        'sync_que_type' => 'รังสี',
                                        'sync_que_room' => 'ห้องอัลตราซาวน์ 1',
                                        'sync_que_time' => '1',
                                        'id' => 4
                                    ),
                                    array(
                                        'sync_que_type' => 'จักษุ',
                                        'sync_que_room' => 'ห้องตรวจโรคทั่วไป 1',
                                        'sync_que_time' => '10',
                                        'id' => 5
                                    ),
                                    array(
                                        'sync_que_type' => 'โสต ศอ นาสิก',
                                        'sync_que_room' => 'ห้องตรวจหู 3',
                                        'sync_que_time' => '8',
                                        'id' => 6
                                    ),
                                    array(
                                        'sync_que_type' => 'ทันตกรรม',
                                        'sync_que_room' => 'ห้องทันตกรรมเด็ก',
                                        'sync_que_time' => '3',
                                        'id' => 7
                                    ),
                                    array(
                                        'sync_que_type' => 'รังสี',
                                        'sync_que_room' => 'ห้องอัลตราซาวน์ 2',
                                        'sync_que_time' => '1',
                                        'id' => 8
                                    ),
                                    array(
                                        'sync_que_type' => 'ทันตกรรม',
                                        'sync_que_room' => 'ห้องทันตกรรมจัดฟัน',
                                        'sync_que_time' => '3',
                                        'id' => 9
                                    ),
                                    array(
                                        'sync_que_type' => 'รังสี',
                                        'sync_que_room' => 'ห้องอัลตราซาวน์ 3',
                                        'sync_que_time' => '1',
                                        'id' => 10
                                    )
                                );
                            ?>


<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>จำนวนคิวของแต่ละแผนก</span><span class="badge bg-success"><?php echo count($data); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>แผนก</th>
                                <th>ห้องปฏิบัติการทางการแพทย์</th>
                                <th class="text-center">จำนวนคิวตกค้าง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['sync_que_type']?></div>
                                    </td>

                                    <td>
                                        <div><?php echo $item['sync_que_room']?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item['sync_que_time']?></div>
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