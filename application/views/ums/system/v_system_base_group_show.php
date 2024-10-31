<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลกลุ่มผู้ใช้</span><span class="badge bg-success"><?php echo count($base_groups); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System_base_group/base_group_edit'"><i class="bi-plus"></i> เพิ่มข้อมูลกลุ่มผู้ใช้ </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ชื่อกลุ่มผู้ใช้(ท)</th>
                                <th>ชื่อกลุ่มผู้ใช้(E)</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($base_groups as $row) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td><?php echo $row['bg_name_th']; ?></td>
                                <td><?php echo $row['bg_name_en']; ?></td>
                                <td class="text-center"><i class="bi-circle-fill <?php echo $row['bg_active'] == 1 ? "text-success" : "text-danger"; ?>"></i> <?php echo $row['bg_active'] == 1 ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?></td>
                                <td class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url().'index.php/ums/System_base_group/base_group_edit/'.$row['bg_id'] ; ?>'"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger swal-delete" data-url="<?php echo base_url().'index.php/ums/System_base_group/base_group_delete/'.$row['bg_id'] ; ?>"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php 
                                $i++; } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>