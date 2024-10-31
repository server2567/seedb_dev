<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลประเภทตำแหน่ง</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/hr/structure/Structure_base_group_position/edit'"><i class="bi-plus"></i> เพิ่มประเภทตำแหน่ง </button>
                    </div>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col"><div class="text-center">#</div></th>
                                <th scope="col">ชื่อประเภทตำแหน่งภาษาไทย</th>
                                <th scope="col">ชื่อประเภทตำแหน่งภาษาอังกฤษ</th>
                                <!-- <th scope="col">ตัวย่อภาษาไทย</th>
                                <th scope="col">ตัวย่อภาษาอังกฤษ</th> -->
                                <th scope="col">สถานะการใช้งาน</th>
                                <th scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="text-center">1</div></td>
                                <td>ผู้อำนวยการวิทยาลัย</td>
                                <td>Director of the College</td>
                                <!-- <td><div class="text-center"></div></td>
                                <td><div class="text-center"></div></td> -->
                                <td><div class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</div></td>
                                <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/hr/structure/Structure_base_group_position/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position/delete/1"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-center">2</div></td>
                                <td>หัวหน้าภาควิชา</td>
                                <td>Head of Department</td>
                                <!-- <td><div class="text-center"></div></td>
                                <td><div class="text-center"></div></td> -->
                                <td><div class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</div></td>
                                <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/hr/structure/Structure_base_group_position/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position/delete/1"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-center">3</div></td>
                                <td>ประธานหลักสูตร</td>
                                <td>Program Chair</td>
                                <!-- <td><div class="text-center"></div></td>
                                <td><div class="text-center"></div></td> -->
                                <td><div class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</div></td>
                                <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/hr/structure/Structure_base_group_position/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position/delete/1"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-center">4</div></td>
                                <td>หัวหน้าศูนย์</td>
                                <td>Center Director</td>
                                <!-- <td><div class="text-center"></div></td>
                                <td><div class="text-center"></div></td> -->
                                <td><div class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</div></td>
                                <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/hr/structure/Structure_base_group_position/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position/delete/1"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-center">5</div></td>
                                <td>หัวหน้างาน</td>
                                <td>Manager</td>
                                <!-- <td><div class="text-center"></div></td>
                                <td><div class="text-center"></div></td> -->
                                <td><div class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</div></td>
                                <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/hr/structure/Structure_base_group_position/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position/delete/1"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-center">6</div></td>
                                <td>อาจารย์</td>
                                <td>Professor</td>
                                <!-- <td><div class="text-center"></div></td>
                                <td><div class="text-center"></div></td> -->
                                <td><div class="text-center"><i class="bi-circle-fill text-danger"></i> ปิดใช้งาน</div></td>
                                <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/hr/structure/Structure_base_group_position/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position/delete/1"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>