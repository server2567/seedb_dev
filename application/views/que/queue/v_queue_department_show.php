
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> ตารางแสดงรายชื่อหมายเลขคิวรายแผนก</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Queue_department/form_show'"><i class="bi-plus"></i> เพิ่มหมายเลขคิวของแผนก </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">หมายเลขคิว</th>
                                <th>ชื่อแผนก</th>
                                <th>รายละเอียดเพิ่มเติม </th>
                                <th class="text-center"> วันที่บันทึกข้อมูล </th>
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
                                <td class= "text-center" > <?php echo $item->dpq_keyword; ?></td>
                                <td> <?php echo $item->dpq_name;?> </td>
                                <td class= "<?php echo  !empty($item->dpq_detail) ? "" : "text-center"?>"> <?php echo !empty($item->dpq_detail) ? $item->dpq_detail : "-"; ?></td>
                                <td class="text-center"> <?php if(is_null($item->dpq_update_date)){echo convertToThaiYear($item->dpq_create_date, true);} else {echo convertToThaiYear($item->dpq_update_date,true);} ?> </td>
                                <td class="text-center"> <?php if(is_null($item->dpq_update_user)){echo $item->create_us;} else {echo $item->update_us;} ?> </td>
                                <td class="text-center"><i class="bi-circle-fill <?php if($item->dpq_active == '1') {echo 'text-success';} else {echo 'text-danger';} ?>"></i> <?php if($item->dpq_active=='1'){echo 'เปิดใช้งาน';} else {echo 'ปิดใช้งาน';} ?></td>

                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Queue_department/form_show/<?php echo $item->dpq_id;?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url()?>index.php/que/Queue_department/delete/<?php echo $item->dpq_id; ?>"><i class="bi-trash"></i></button>
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