<script>
    // Get the current URL
var currentUrl = window.location.href;

// Split the URL by '/'
var urlParts = currentUrl.split('/');

// Get the last part of the URL which contains the IDs
var idsPart = urlParts[urlParts.length - 1];

// Split the IDs by ',' to get individual IDs
var ids = idsPart.split(',');

// Now you have the IDs in the 'ids' array, you can use them as needed
console.log(ids);

</script>
                            <?php
                                $data = array(
                                    array(
                                        'physician' => 'นพ.ธนินท์ สิงห์ขาว',
                                        'count' => '20',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 1
                                    ),
                                    array(
                                        'physician' => 'นพ.นพดล พรมบุตร',
                                        'count' => '16',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 2
                                    ),
                                    array(
                                        'physician' => 'นพ.ปรียาวดี เหล่าสุวรรณณา ',
                                        'count' => '18',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 3
                                    ),
                                    array(
                                        'physician' => 'นพ.ปริญญา วงศ์ทิพย์ ',
                                        'count' => '6',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 4
                                    ),
                                    array(
                                        'physician' => 'นพ.ปองเดช รัศมีโชติ ',
                                        'count' => '14',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 5
                                    ),
                                    array(
                                        'physician' => 'นพ.ลาภิน รักษาทรัพย์ ',
                                        'count' => '12',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 6
                                    ),
                                    array(
                                        'physician' => 'นพ.โชติกา โชคชัย',
                                        'count' => '16',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 7
                                    ),
                                    array(
                                        'physician' => 'นพ.ธนิณี กลิ่นโพธิ์',
                                        'count' => '6',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 8
                                    ),
                                    array(
                                        'physician' => 'นพ.กนกพร เจริญกาณต์ ',
                                        'count' => '8 ',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 9
                                    ),
                                    array(
                                        'physician' => 'นพ.ปิติภูมิ นวลจันทร์',
                                        'count' => '10',
                                        'time' => '9.00-16.00',
                                        'date' => 'จ-ศ',
                                        'id' => 10
                                    ),
                                );
                                $idString = $this->uri->segment(4);
                                $select_ids = explode(',', $idString);
                                $index=0;
                                
                            ?>

<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-search icon-menu"></i><span> ข้อมูลแพทย์ที่เลือก</span><span class="badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row">
                        
                        <div class="col-md-3 mb-3">
                            <label for="date" class="form-label ">วันที่</label>
                            
                                <input readonly type="date" class="form-control" name="date" id="date" >
                        </div>
                        
                    </div>
                <div class="row">
                
    
           
            
                    <table class="table " width="100%">
                        <thead>
                            <tr>
                                <th class="text-center w-10">ลำดับ</th>
                                <th class="w-25">ชื่อแพทย์</th>
                                <th class="text-center w-15"> ช่วงเวลา</th>
                                <th class="text-center w-15">วัน</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                $index = 0; // Initialize index counter
                foreach($data as $item) {
                    // Check if the ID of the current item is in the selected IDs array
                    if (in_array($item['id'], $select_ids)) {
                        // Increment index counter
                        $index++;

                        // Output table row for the selected physician
                        echo "<tr>";
                        echo "<td class='text-center'>$index</td>";
                        echo "<td>{$item['physician']}</td>";
                        echo "<td class='text-center'>{$item['time']}</td>";
                        echo "<td class='text-center'>{$item['date']}</td>";
                        echo "</tr>";
                    }
                }
            ?>
                        </tbody>
                    </table>
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
                    <i class="bi bi-window-dock icon-menu"></i><span> จัดการคิว</span><span class="badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="button">8.30 - 10.00<span class="badge bg-secondary">4</span></button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="button">10.00 - 12.00<span class="badge bg-secondary">6</span></button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="button">13.00 - 16.00<span class="badge bg-secondary">8</span></button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="button">16.00 - 20.00<span class="badge bg-secondary">5</span></button>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th class="text-center w-15">วัน</th>
                                    <th class="w-50">จำนวนคิว</th>
                                    
                                </tr>
                                </thead>
                                <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Physician_shift/update">
                                <tbody>
                                    <tr>
                                        <td class="text-center pt-4">จันทร์</td>
                                        <td class="">
                                            <div class="input-group mt-3 w-50">
                                                <input type="number" class="form-control" placeholder="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center pt-4">อังคาร</td>
                                        <td class="">
                                            <div class="input-group mt-3 w-50">
                                                <input type="number" class="form-control" placeholder="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center pt-4">พุธ</td>
                                        <td class="">
                                            <div class="input-group mt-3 w-50">
                                                <input type="number" class="form-control" placeholder="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center pt-4">พฤหัสบดี</td>
                                        <td class="">
                                            <div class="input-group mt-3 w-50">
                                                <input type="number" class="form-control" placeholder="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center pt-4">ศุกร์</td>
                                        <td class="">
                                            <div class="input-group mt-3 w-50">
                                                <input type="number" class="form-control" placeholder="0">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
<div class="row">
    <div class="col-md-12">
    <div class="form-check d-flex align-items-center">
            <input class="form-check-input" type="radio" name="recordType" id="recordTypeDate" value="date">
            <label class="form-check-label" for="recordTypeDate">บันทึกวันที่</label>
            <input type="number" class="form-control me-1 ms-2"style="width: 20%;height: 20%;" id="num" name="date">
            <input type="date" class="form-control"  style="width: 20%;height: 20%;" id="date" name="date">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-check d-flex align-items-center">
            <input class="form-check-input" type="radio" name="recordType" id="recordTypeWeek" value="week">
            <label class="form-check-label" for="recordTypeWeek">บันทึกสัปดาห์ </label>
            <input type="week" class="form-control me-1 ms-2"style="width: 20%;height: 20%;" id="num" name="date">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-check d-flex align-items-center">
            <input class="form-check-input" type="radio" name="recordType" id="recordTypeMonth" value="month">
            <label class="form-check-label" for="recordTypeMonth">บันทึกเดือน</label>
            <input type="month" class="form-control me-1 ms-2"style="width: 20%;height: 20%;" id="num" name="date">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-check d-flex align-items-center">
            <input class="form-check-input" type="radio" name="recordType" id="recordTypeYear" value="year">
            <label class="form-check-label" for="recordTypeYear">บันทึกปี</label>
            <input type="number" min=2557 placeholder="2557" class="form-control me-1 ms-2"style="width: 20%;height: 20%;" id="num" name="date">
        </div>
    </div>
    <div class="col-md-12 ">
        <button class="float-xl-end btn btn-primary"  type="submit"><i class="bt bt-success">ยืนยัน</i></button>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentDate = new Date();
        var year = currentDate.getFullYear();
        var month = String(currentDate.getMonth() + 1).padStart(2, '0');
        var day = String(currentDate.getDate()).padStart(2, '0');
        var formattedDate = year + '-' + month + '-' + day;

        document.getElementById("date").value = formattedDate;
    });
</script>
