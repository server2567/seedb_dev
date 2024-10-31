<?php
                                $data = array(
                                    array(
                                        'physician' => 'นพ.ธนินท์ สิงห์ขาว',
                                        'count' => '20',
                                        'id' => 1
                                    ),
                                    array(
                                        'physician' => 'นพ.นพดล พรมบุตร',
                                        'count' => '16',
                                        'id' => 2
                                    ),
                                    array(
                                        'physician' => 'นพ.ปรียาวดี เหล่าสุวรรณณา ',
                                        'count' => '18',
                                        'id' => 3
                                    ),
                                    array(
                                        'physician' => 'นพ.ปริญญา วงศ์ทิพย์ ',
                                        'count' => '6',
                                        'id' => 4
                                    ),
                                    array(
                                        'physician' => 'นพ.ปองเดช รัศมีโชติ ',
                                        'count' => '14',
                                        'id' => 5
                                    ),
                                    array(
                                        'physician' => 'นพ.ลาภิน รักษาทรัพย์ ',
                                        'count' => '12',
                                        'id' => 6
                                    ),
                                    array(
                                        'physician' => 'นพ.โชติกา โชคชัย',
                                        'count' => '16',
                                        'id' => 7
                                    ),
                                    array(
                                        'physician' => 'นพ.ธนิณี กลิ่นโพธิ์',
                                        'count' => '6',
                                        'id' => 8
                                    ),
                                    array(
                                        'physician' => 'นพ.กนกพร เจริญกาณต์ ',
                                        'count' => '8 ',
                                        'id' => 9
                                    ),
                                    array(
                                        'physician' => 'นพ.ปิติภูมิ นวลจันทร์',
                                        'count' => '10',
                                        'id' => 10
                                    ),
                                );
                                ?>
                                
<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
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
</div>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> ตารางเวรแพทย์</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="table-responsive">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">เลือก</th>
                                <th class="w-25">รายชื่อแพทย์</th>
                                <th class="text-center"> ตำแหน่ง</th>
                                <th class="text-center">จำนวนครั้งทั้งหมด</th>
                                <th class="text-center">จำนวนครั้งที่ลงตาราง</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $key => $item){ ?>
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $item['id']; ?>"></td>
                                <td class=""><?php echo $item['physician']; ?></td>
                                <td class="text-center"> ชำนาญการ </td>
                                <td class="text-center"><?php echo $item['count']; ?></td>
                                <td class="text-center"><?php echo $item['count']-($item['count']/2); ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning edit-btn" id="edit_btn" name="edit_btn" data-id="<?php echo $item['id']; ?>"><i class="bi-pencil-square"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                    <div class="row mg-2">
                        <div class="colum mg-2">
                            <button id="bulk-edit-btn" class="btn btn-primary">จัดการรายกลุ่ม</button>
                            <button id="copy-btn" class="btn btn-secondary">คัดลอกเวร</button>
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
