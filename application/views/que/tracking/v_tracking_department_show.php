
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> ตารางแสดงรายชื่อหมายเลขนัดหมายแผนก </span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking_department/add_form'"><i class="bi-plus"></i> เพิ่มหมายเลขนัดหมายของแผนก </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">หมายเลขนัดหมาย</th>
                                <th>ชื่อแผนก</th>
                                <th>รายละเอียดเพิ่มเติม </th>
                                <th class="text-center"> วันที่บันทึกข้อมูลล่าสุด </th>
                                <th class="text-center"> ผู้บันทึกข้อมูล </th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($dep)){
                            foreach($dep as $key => $item){ ?>
                            <tr>
                                <td class="text-center"><?php echo $key+1; ?></td>
                                <td class= "text-center" > <?php echo $item->dpk_keyword; ?></td>
                                <td> <?php echo $item->dpk_name;?> </td>
                                <td class= "<?php echo  !empty($item->dpk_detail) ? "" : "text-center"?>"> <?php echo !empty($item->dpk_detail) ? $item->dpk_detail : "-"; ?></td>
                                <td class="text-center"> <?php if(is_null($item->dpk_update_date)){echo convertToThaiYear($item->dpk_create_date, true);} else {echo convertToThaiYear($item->dpk_update_date,true);} ?> </td>
                                <td class="text-center"> <?php if(is_null($item->dpk_update_user)){echo $item->create_user_name;} else {echo $item->update_user_name;} ?> </td>
                                <td class="text-center"><i class="bi-circle-fill <?php if($item->dpk_active == '1') {echo 'text-success';} else {echo 'text-danger';} ?>"></i> <?php if($item->dpk_active=='1'){echo 'เปิดใช้งาน';} else {echo 'ปิดใช้งาน';} ?></td>

                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking_department/update_form/<?php echo $item->dpk_id;?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url()?>index.php/que/Tracking_department/delete/<?php echo $item->dpk_id; ?>"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>