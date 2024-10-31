<?php
                                $data = array(
                                    array(
                                        'physician' => 'โทรแจ้ง ',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'count' => '20',
                                        'id' => 1
                                    ),
                                    array(
                                        'physician' => 'อีเมล',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'count' => '16',
                                        'id' => 2
                                    ),
                                    array(
                                        'physician' => 'ข้อความ ',  
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'count' => '18',
                                        'id' => 3
                                    ),
                                    array(
                                        'physician' => 'ระบบ ',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'count' => '6',
                                        'id' => 4
                                    ),
                                    array(
                                        'physician' => 'ไลน์',
                                        'count' => '14',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 5
                                    ),
                                    array(
                                        'physician' => 'เบอร์โทร',
                                        'count' => '12',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 6
                                    ),
                                    array(
                                        'physician' => 'เบอร์โทร',
                                        'count' => '16',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 7
                                    ),
                                    array(
                                        'physician' => 'เบอร์โทร',
                                        'count' => '6',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 8
                                    ),
                                    array(
                                        'physician' => 'เบอร์โทร',
                                        'count' => '8 ',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 9
                                    ),
                                    array(
                                        'physician' => 'เบอร์โทร',
                                        'count' => '10',
                                        'status' => 'เปิดใช้งาน',
                                        'status_class' => 'text-success',
                                        'id' => 10
                                    ),
                                );
                                ?>
                                
<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
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
                    <i class="bi-newspaper icon-menu"></i><span> ตารางข้อมูลประเภทการแจ้งเตือนการนัดการหมาย</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse show">
            <div class="accordion-body m-1">
            <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_notify/'"><i class="bi-plus"></i> เพิ่มช่องทางการติดต่อ</button>
                    </div>
                <div class="table-responsive">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center w-10">#</th>
                                <th class="w-30">ช่องทางการแจ้งเตือน</th>
                                <th class="text-center w-20">สถานะการใช้งาน</th>
                                <th class="text-center w-20">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $key => $item){ ?>
                            <tr>
                                <td class="text-center "><?php echo $key+1; ?></td>
                                <td class=""><?php echo $item['physician']; ?></td>
                                <td class="text-center"><i class="bi-circle-fill <?php echo $item['status_class']; ?>"></i> <?php echo $item['status']; ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning edit-btn" id="edit_btn" name="edit_btn" data-id="<?php echo $item['id']; ?>"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_reserve/delete/<?php echo $item['id']; ?>"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                    
            </div>
            </div>
        </div>
    </div>
</div>

<script>
    console.log("Script is executed!");

    $(document).ready(function(){
        // Inline edit button click handler
        $(".edit-btn").click(function(){
            var id = $(this).data("id");
            // Redirect to edit form
            window.location.href = '<?php echo base_url()?>index.php/que/Physician_shift/update_form/' + id;
        });

        // Bulk edit button click handler
        $("#bulk-edit-btn").click(function(){
    var selectedIds = [];
    $("input[name='selected[]']:checked").each(function(){
        selectedIds.push($(this).val());
    });
    
    // Encode the IDs
    var encodedIds = selectedIds.map(id => encodeURIComponent(id)).join(',');
    
    // Redirect to edit_group with encoded IDs
    window.location.href = '<?php echo base_url()?>index.php/que/Physician_shift/edit_group/' + encodedIds;
});
$("#copy-btn").click(function(){
    var selectedIds = [];
    $("input[name='selected[]']:checked").each(function(){
        selectedIds.push($(this).val());
    });
    
    // Encode the IDs
    var encodedIds = selectedIds.map(id => encodeURIComponent(id)).join(',');
    
    // Redirect to edit_group with encoded IDs
    window.location.href = '<?php echo base_url()?>index.php/que/Physician_shift/copy_group/' + encodedIds;
});
});
</script>
