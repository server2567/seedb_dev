<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลอาชีพของบุคคลที่เกี่ยวข้อง</span><span class="badge bg-success">11</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/get_occupation_form'"><i class="bi-plus"></i> เพิ่มอาชีพ </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่ออาชีพ (ภาษาไทย)</th>
                                <th class="text-center" scope="col">ชื่ออาชีพ (ภาษาอังกฤษ)</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $data = array(
                                    array(
                                        'title' => 'รับราชการ',
                                        'title_en' => 'public service',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 1
                                    ),
                                    array(
                                        'title' => 'นักเรียน',
                                        'title_en' => 'Student',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 2
                                    ),
                                    array(
                                        'title' => 'นักศึกษา',
                                        'title_en' => 'college student',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 3
                                    ),
                                    array(
                                        'title' => 'รับจ้าง',
                                        'title_en' => 'Freelancer',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 4
                                    ),
                                    array(
                                        'title' => 'พนักงานบริษัท',
                                        'title_en' => 'company employee',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 5
                                    ),
                                    array(
                                        'title' => 'พนักงานรัฐวิสาหกิจ',
                                        'title_en' => 'State enterprise employee',
                                        'status' => 'ปิดใช้งาน',
                                        'status_class' => 'text-danger',
                                        'id' => 6
                                    ),
                                    array(
                                        'title' => 'เกษตรกรรม',
                                        'title_en' => 'agriculturist',
                                        'status' => 'ปิดใช้งาน',
                                        'status_class' => 'text-danger',
                                        'id' => 7
                                    ),
                                    array(
                                        'title' => 'ประกอบธุรกิจส่วนตัว',
                                        'title_en' => 'personal business',

                                        'status' => 'ปิดใช้งาน',
                                        'status_class' => 'text-danger',
                                        'id' => 8
                                    ),
                                    array(
                                        'title' => 'แม่บ้าน',
                                        'title_en' => 'Housekeeper',
                                        'status' => 'ปิดใช้งาน',
                                        'status_class' => 'text-danger',
                                        'id' => 9
                                    ),
                                    array(
                                        'title' => 'ข้าราชการบำนาญ',
                                        'title_en' => 'retired government official',
                                        'status' => 'ปิดใช้งาน',
                                        'status_class' => 'text-danger',
                                        'id' => 10
                                    ),
                                    array(
                                        'title' => 'ไม่มีอาชีพ	',
                                        'title_en' => 'unemployed',
                                        'status' => 'ปิดใช้งาน',
                                        'status_class' => 'text-danger',
                                        'id' => 11
                                    ),
                                );?>
                            <?php foreach ($data as $key => $item) { ?>
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
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $item['status_class']; ?>"></i> <?php echo $item['status']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/get_occupation_form/<?php echo $item['id']; ?>'"><i class="bi-pencil-square"></i></button>
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