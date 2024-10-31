<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> รายการจำนวนวันยกเลิกนัดหมาย</span><span class="badge bg-success">5</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_cancel/add_form'"><i class="bi-plus"></i> เพิ่มรายการยกเลิกนัดหมาย </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ประเภทผู้ป่วย</th>
                                <th class="text-center">จำนวนวันขั้นต่ำในการยกเลิกนัดหมาย</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $data = array(
                                    array(
                                        'title' => 'IP',
                                        'title_des' => '2',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 1
                                    ),
                                    array(
                                        'title' => 'OP',
                                        'title_des' => '2',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 2
                                    ),
                                    array(
                                        'title' => 'A',
                                        'title_des' => '1',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 3
                                    ),
                                    array(
                                        'title' => 'C',
                                        'title_des' => '3',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 4
                                    ),
                                    array(
                                        'title' => 'G',
                                        'title_des' => '4',
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
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_cancel/update_form/<?php echo $item['id'];?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_cancel/delete/<?php echo $item['id']; ?>"><i class="bi-trash"></i></button>
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