<div class="modal-header">
    <h5 class="modal-title" id="modal-toolsLabel">กลุ่มผู้ใช้ใน <?php echo $system->st_name_th; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <table class="table datatable" width="100%">
        <thead class="dataTable">
            <tr>
                <th class="text-center">#</th>
                <th>ชื่อกลุ่มผู้ใช้(ท)</th>
                <th>ชื่อกลุ่มผู้ใช้(E)</th>
                <th class="text-center">สถานะการใช้งาน</th>
                <th class="text-center">ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($base_groups) == 0) { ?>
            <tr>
                <td class="text-center" colspan="5">ไม่มีรายการข้อมูล</td>
            </tr>
            <?php } else { ?>
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
                    </td>
                </tr>
                <?php 
                    $i++; } 
                ?>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="modal-footer end-0">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>