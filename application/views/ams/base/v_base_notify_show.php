<!-- 
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button " type="button"  data-bs-toggle="collapse" data-bs-target="#collapseShow" aria-expanded="falseCard" aria-controls="collapseShow">
                    <i class="bi-search icon-menu"></i><span> ตัวเลือกการค้นหา</span><span class="badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="code" class="form-label">วันที่</label>
                            <input class="form-control" type="number" id="day" name="day" min="1" max="31" required>
                        </div>
                        <div class="col-md-3">
                            <label for="code" class="form-label">สัปดาห์</label>
                            <input type="week" class="form-control" name="code" id="code" placeholder="" value=""> </input>
                        </div>
                        <div class="col-md-3">
                            <label for="code" class="form-label">เดือน</label>
                            <input type="month" class="form-control" name="" id=""></select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date" class="form-label ">ปี พ.ศ.</label>
                            
                                <input type="number" class="form-control" name="year-bh" id="year-bh" step="1"  placeholder="" value="">
                        </div>
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<?php 
    $total_count = count($notify);
    $active_count = 0;
    $inactive_count = 0;
    
    foreach ($notify as $item) {
        if ($item->ntf_active == 1) {
            $active_count++;
        } elseif ($item->ntf_active == 0) {
            $inactive_count++;
        }
    }
    
   

?>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button " type="button"  data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="falseCard" aria-controls="collapseCard">
                    <i class="bi-newspaper icon-menu"></i><span class=" me-3"> ข้อมูลประเภทการแจ้งเตือนการนัดการหมาย</span><span class="badge bg-success font-14 me-3" ><?php echo $active_count ?> จำนวนช่องทางการนัดหมายที่เปิดใช้งาน</span><span class="badge bg-danger font-14 me-3"><?php echo $inactive_count ?> จำนวนช่องทางการนัดหมายที่ปิดใช้งาน</span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse show">
            <div class="accordion-body m-1">
            <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/ams/Base_notify/add_form'"><i class="bi-plus"></i> เพิ่มช่องทางการติดต่อ</button>
                    </div>
                <div class="table-responsive">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center w-10">#</th>
                                <th class="w-20">ชื่อประเภทการแจ้งเตือน-ไทย</th>
                                <th class="w-20">ชื่อประเภทการแจ้งเตือน-EN</th>
                                <th class="text-center">วันที่บันทึกข้อมูลล่าสุด</th>
                                <th class="text-center">ผู้บันทึกข้อมูล</th>
                                <th class="text-center ">สถานะการใช้งาน</th>
                                <th class="text-center ">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($notify)) { 
                            foreach($notify as $key => $item){ ?>
                            <tr>
                                <td class="text-center "><?php echo $key+1; ?></td>
                                <td class="text-center"><?php echo $item->ntf_name; ?></td>
                                <td class="text-center"><?php if(isset($item->ntf_name_en)){echo $item->ntf_name_en;} else {echo '-';} ?></td>
                                <td class="text-center"> <?php if(is_null($item->ntf_update_date)){echo convertToThaiYear($item->ntf_create_date);} else {echo convertToThaiYear($item->ntf_update_date);} ?> </td>
                                <td class="text-center"> <?php if(is_null($item->ntf_update_user)){echo $item->create_user_name;} else {echo $item->update_user_name;} ?> </td>
                                <td class="text-center"><i class="bi-circle-fill <?php if($item->ntf_active == '1') {echo 'text-success';} else {echo 'text-danger';} ?>"></i> <?php if($item->ntf_active=='1'){echo 'เปิดใช้งาน';} else {echo 'ปิดใช้งาน';} ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning edit-btn"  onclick="window.location.href='<?php echo base_url()?>index.php/ams/Base_notify/update_form/<?php echo $item->ntf_id;?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url()?>index.php/ams/Base_notify/delete/<?php echo $item->ntf_id; ?>"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
                    <div class="row mg-2">
                        
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>

