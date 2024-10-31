
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> รายการรูปแบบหมายเลขนัดหมาย</span><span class="badge bg-success">5</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking_manage/add_form'"><i class="bi-plus"></i> เพิ่มรูปแบบหมายเลขนัดหมาย </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ชื่อหมายเลขนัดหมาย</th>
                                <th class="text-center">ตัวย่อแผนก</th>
                                <th class="text-center">รูปแบบหมายเลขนัดหมาย</th>
                                <th class="text-center">วันที่บันทึกข้อมูลล่าสุด</th>
                                <th>ผู้บันทึกข้อมูล</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($track)) {
                                foreach($track as $key => $item){ ?>
                            <tr>
                                <td class="text-center"><?php echo $key+1; ?></td>
                                <td> <?php echo $item->ct_name; ?></td>
                                <td class="text-center"> <?php echo $item->ct_keyword; ?></td>
                                <td class="text-center"> <?php if(isset($item->ct_value_demo)){echo $item->ct_value_demo;} else {echo "ไม่มีรูปแบบ";}; ?></td>
                                <td class="text-center"> <?php if(is_null($item->ct_update_date)){echo convertToThaiYear($item->ct_create_date, true);} else {echo convertToThaiYear($item->ct_update_date, true);} ?> </td>
                                <td> <?php if(is_null($item->ct_update_user)){echo $item->create_user_name;} else {echo $item->update_user_name;} ?> </td>
                                <td class="text-center"><i class="bi-circle-fill <?php if($item->ct_active == '1') {echo 'text-success';} else {echo 'text-danger';} ?>"></i> <?php if($item->ct_active=='1'){echo 'เปิดใช้งาน';} else {echo 'ปิดใช้งาน';} ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking_manage/update_form/<?php echo $item->ct_id;?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-success" title="จัดการรูปแบบ" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking_manage/format_form/<?php echo $item->ct_id;?>'"><i class="bi-card-list"></i></button>
                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url()?>index.php/que/Tracking_manage/delete/<?php echo $item->ct_id; ?>"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>