<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> ข้อมูลจำนวนคิว-กำหนดจำนวนคิว</span><span class="badge bg-success">5</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_reserve/add_form'"><i class="bi-plus"></i> เพิ่มรายการคิว</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">วันที่</th>
                                <th class="text-center">จำนวนการจอง</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $data = array(
                                    array(
                                        'title' => '24/4/2024',
                                        'title_des' => '20',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 1
                                    ),
                                    array(
                                        'title' => '30/4/2024',
                                        'title_des' => '50',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 2
                                    ),
                                    array(
                                        'title' => '1/5/2024',
                                        'title_des' => '10',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 3
                                    ),
                                    array(
                                        'title' => '10/5/2024',
                                        'title_des' => '30',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 4
                                    ),
                                    array(
                                        'title' => '20/4/2024',
                                        'title_des' => '40',
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
                                <td class="text-center"> <?php echo $item['title_des'];?> </td>
                                <td class="text-center"><i class="bi-circle-fill <?php echo $item['status_class']; ?>"></i> <?php echo $item['status']; ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_reserve/update_form/<?php echo $item['id'];?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_reserve/delete/<?php echo $item['id']; ?>"><i class="bi-trash"></i></button>
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