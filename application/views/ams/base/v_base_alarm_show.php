
<!-- <div class="card">
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
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button " type="button"  data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="falseCard" aria-controls="collapseCard">
                    <i class="bi-newspaper icon-menu"></i><span> ข้อมูลระยะเวลาการเเจ้งเตือน </span><span class="badge bg-success"><?php echo isset($alarm) && !empty($alarm) ? count($alarm) : 0; ?></span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse show">
            <div class="accordion-body m-1">
            <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/ams/Base_alarm/add_form'"><i class="bi-plus"></i> เพิ่มเวลาการแจ้งเตือน</button>
                    </div>
                <div class="table-responsive">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center"> ประเภทการเเจ้งเตือน</th>
                                <th class="text-center"> จำนวนครั้ง </th>
                                <th class="text-center"> วันของการแจ้งเตือน</th>
                                <th class="text-center">เวลาแจ้งเตือนอัตโนมัติ (นาที)</th>
                                <th class="text-center">แจ้งเตือนทุก (นาที)</th>             
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($alarm)){
                             foreach($alarm as $key => $item){ ?>
                            <tr>
                                <td class="text-center "><?php echo $key+1; ?></td>
                                <td class="text-center"><?php if(isset($item->notify_name)) {echo $item->notify_name;} else {echo '-';} ?></td>
                                <td class="text-center"><?php if(isset($item->al_number)) {echo $item->al_number;} else {echo '-';} ?></td>
                                <td class="text-center"> <?php if(isset($item->al_day)) {echo $item->al_day.' วัน'; } else {echo '-';} ?></td>
                                <td class="text-center"><?php if(isset($item->al_minute)){ echo $item->al_minute;} else {echo '-';} ?> </td>
                                <td class="text-center"><?php if(isset($item->al_time)) {echo $item->al_time;} else {echo '-'; } ?> </td>
                                <td class="text-center"><i class="bi-circle-fill <?php if($item->al_active == '1') {echo 'text-success';} else {echo 'text-danger';} ?>"></i> <?php if($item->al_active=='1'){echo 'เปิดใช้งาน';} else {echo 'ปิดใช้งาน';} ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning edit-btn" id="edit_btn"  onclick="window.location.href='<?php echo base_url()?>index.php/ams/Base_alarm/update_form/<?php echo $item->al_id;?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ams/Base_alarm/delete/<?php echo $item->al_id; ?>"><i class="bi-trash"></i></button>
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
</div>
