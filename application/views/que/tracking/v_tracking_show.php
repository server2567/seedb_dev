
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> รายการชนิดเลขติดตาม</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking/add_form'"><i class="bi-plus"></i> เพิ่มชนิดเลขติดตาม </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ชื่อชนิดเลขติดตาม</th>
                                <th class="text-center">ประเภทเลขติดตาม</th>
                                <th class="text-center"> วันที่บันทึกข้อมูลล่าสุด </th>
                                <th class="text-center"> ผู้บันทึกข้อมูล </th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            <?php if(isset($Track)) { 
                                foreach($Track as $key => $item) {?>

                            <tr>
                                <td class="text-center"><?php echo $key+1; ?></td>
                                <td class= "text-center" > <?php echo $item->type_name; ?></td>
                                <td class="text-center"> <?php switch ($item->type_code) {
                                                                    case 'fx':
                                                                        echo "fixed value.";
                                                                        break;
                                                                    case 'rn':
                                                                        echo "running number.";
                                                                        break;
                                                                    case 'rd':
                                                                        echo "random value.";
                                                                        break;
                                                                    case 'yr':
                                                                        echo "yearly value.";
                                                                        break;
                                                                    default:
                                                                        echo "Type code is unknown";
                                                                        break;
                                                                }?> </td>
                                <td class="text-center"> <?php if(is_null($item->type_update_date)){echo convertToThaiYear($item->type_create_date);} else {echo convertToThaiYear($item->type_update_date);} ?> </td>
                                <td class="text-center"> <?php if(is_null($item->type_update_user)){echo $item->create_user_name;} else {echo $item->update_user_name;} ?> </td>
                                <td class="text-center"><i class="bi-circle-fill <?php if($item->type_active == '1') {echo 'text-success';} else {echo 'text-danger';} ?>"></i> <?php if($item->type_active=='1'){echo 'เปิดใช้งาน';} else {echo 'ปิดใช้งาน';} ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking/update_form/<?php echo $item->type_id;?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url()?>index.php/que/Tracking/delete/<?php echo $item->type_id; ?>"><i class="bi-trash"></i></button>
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