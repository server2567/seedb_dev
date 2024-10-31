<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> รายการเปิดจองคิว</span><span class="badge bg-success">5</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base/queue_form'"><i class="bi-plus"></i> เพิ่มรูปการเปิดจองคิว </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">วันที่</th>
                                <th class="text-center">จำนวนเปิดจองคิว </th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody><?php
                                $data = array(
                                    array(
                                        'title' => '8/5/2024',
                                        'count' => '25',
                                        'tracking_des' => 'เลขติดตามแผนกห้องฉุกเฉิน',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 1
                                    ),
                                    array(
                                        'title' => '7/5/2024',
                                        'count' => '20',
                                        'tracking_des' => 'เลขติดตามผู้ป่วยนอก',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 2
                                    ),
                                    array(
                                        'title' => '6/5/2024',
                                        'count' => '30',
                                        'tracking_des' => 'เลขติดตามผู้ป่วยใน',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 3
                                    ),
                                    array(
                                        'title' => '5/5/2024',
                                        'count' => '10',
                                        'tracking_des' => 'เลขติดตามแผนกหอผู้ป่วยวิกฤต',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 4
                                    ),
                                    array(
                                        'title' => '4/5/2024',
                                        'count' => '15',
                                        'tracking_des' => 'เลขติดตามผู้ตั้งครภ์',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 5
                                    ),
                                    
                                );
                                ?>
                            <?php foreach($data as $key => $item){ ?>
                            <tr>
                                <td class="text-center"><?php echo $key+1; ?></td>
                                <td class= "text-center" > <?php echo $item['title']; ?></td>
                                <td class="text-center"> <?php echo $item['count']; ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base/update_form/<?php echo $item['id'];?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Tracking_manage/delete/<?php echo $item['id']; ?>"><i class="bi-trash"></i></button>
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