<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> รายชื่อบุคลากร</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/timework/Timework_person/get_add_format'"><i class="bi-plus"></i>เพิ่มรูปแบบการลงเวลา</button>
                    </div>
                    <table class="table datatable" width='100%'>
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ประเภท</th>
                                <th class="text-center" scope="col">ชื่อ - นามสกุล</th>
                                <th class="text-center" scope="col">วันที่สิ้นสุด</th>
                                <th class="text-center" scope="col">เข้างาน</th>
                                <th class="text-center" scope="col">สาย</th>
                                <th class="text-center" scope="col">ครึ่งวัน</th>
                                <th class="text-center" scope="col">ออกงาน</th>
                                <th class="text-center" scope="col">วันทำงาน</th>
                                <th class="text-center" scope="col">วันหยุดนักขัตฤกษ์</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $i + 1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center">รายบุคคล</div>
                                    </td>
                                    <td>
                                        <div class="text-center">ขจรศักดิ์ ผักใบเขียว</div>
                                    </td>
                                    <td>
                                        <div class="text-center">1/9/67</div>
                                    </td>
                                    <td>
                                        <div class="text-center">8.00</div>
                                    </td>
                                    <td>
                                        <div class="text-center">8.30</div>
                                    </td>
                                    <td>
                                        <div class="text-center">12.00</div>
                                    </td>
                                    <td>
                                        <div class="text-center">17.00</div>
                                    </td>
                                    <td>
                                        <div class="text-center">จ-ศ</div>
                                    </td>
                                    <td>
                                        <div class="text-center"><input type="checkbox" class=" form-check-input" name="" id="" checked></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><input type="checkbox" class=" form-check-input" name="" id="" checked></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/timework/Timework_person/get_edit_format/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
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

