<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลประเภทการขึ้นเวร</span><span class="badge bg-success">3</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_shift/get_Time__work_add'"><i class="bi-plus"></i> เพิ่มประเภทการขึ้นเวร</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อประเภทการขึ้นเวร (ภาษาไทย)</th>
                                <th class="text-center" scope="col">ชื่อประเภทการขึ้นเวร (ภาษาอังกฤษ)</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $data = array(
                                array(
                                    'title' => 'เวรเช้า',
                                    'title_en' => 'Morning shift',
                                    'status' => 'เปิดใช้งาน',
                                    'status_class' => 'text-success',
                                    'id' => 1
                                ),
                                array(
                                    'title' => 'เวรบ่าย',
                                    'title_en' => 'Afternoon shift',
                                    'status' => 'เปิดใช้งาน',
                                    'status_class' => 'text-success',
                                    'id' => 2
                                ),
                                array(
                                    'title' => 'เวรดึก',
                                    'title_en' => 'Night shift',
                                    'status' => 'เปิดใช้งาน',
                                    'status_class' => 'text-success',
                                    'id' => 3
                                ),
                                
                            );
                            ?>
                            <?php foreach ($data as $key => $item ) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key + 1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item['title']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item['title_en']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill  <?php echo $item['status_class']; ?>"></i> <?php echo $item['status']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_work_shift/get_Time__work_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
                                        </div>
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