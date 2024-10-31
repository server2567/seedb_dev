<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลกลุ่มตำแหน่งงาน</span><span class="badge bg-success">4</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Base_position_group/edit'"><i class="bi-plus"></i> เพิ่มข้อมูลกลุ่มตำแหน่งงาน </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ชื่อกลุ่มตำแหน่งงานภาษาไทย</th>
                                <th>ชื่อกลุ่มตำแหน่งงานภาษาอังกฤษ</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>จักษุแพทย์</td>
                                <td>Ophthalmologist</td>
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Base_position_group/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position_group/delete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>โสต ศอ นาสิกแพทย์</td>
                                <td>Otolaryngology</td>
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Base_position_group/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position_group/delete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>รังสีแพทย์</td>
                                <td>Radiologist</td>
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Base_position_group/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position_group/delete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>ทันตแพทย์</td>
                                <td>Dentist</td>
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Base_position_group/edit/1'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/Base_position_group/delete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>