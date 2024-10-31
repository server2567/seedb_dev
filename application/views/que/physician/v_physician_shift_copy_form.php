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
                    <i class="bi bi-window-dock icon-menu"></i><span> แพทย์ที่ต้องการคัดลอก</span><span class="badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                <div class="row">
<form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Physician_shift/add">
    <div class="col-md-12">
        <div class="form-group">
            <label for="doctor">เลือกแพทย์:</label>
            <select class="form-control" id="doctor">
                <?php foreach ($data as $physician): ?>
                    <option value="<?php echo $physician['physician']; ?>"><?php echo $physician['physician']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="recordType" id="weekly" value="weekly">
            <label class="form-check-label" for="weekly">รายสัปดาห์</label>
        </div>
        <div class="form-group mt-2" id="weeklyInput" style="display: none;">
            <label for="week">สัปดาห์:</label>
            <input type="week" class="form-control" id="week" name="week">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="recordType" id="monthly" value="monthly">
            <label class="form-check-label" for="monthly">รายเดือน</label>
        </div>
        <div class="form-group mt-2" id="monthlyInput" style="display: none;">
            <label for="month">เดือน:</label>
            <input type="month" class="form-control" id="month" name="month">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="recordType" id="yearly" value="yearly">
            <label class="form-check-label" for="yearly">รายปี</label>
        </div>
        <div class="form-group mt-2" id="yearlyInput" style="display: none;">
            <label for="year">ปี:</label>
            <input type="number" class="form-control" min="2566" placeholder="2566" name="year">
        </div>
    </div>
</div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            
<div class="row">
    <div class="col-md-12 ">
        <button class="float-xl-end btn btn-primary"  type="submit"><i class="bt bt-success">ยืนยัน</i></button>
    </div>
</div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get references to the radio buttons and input fields
        var weeklyRadio = document.getElementById("weekly");
        var monthlyRadio = document.getElementById("monthly");
        var yearlyRadio = document.getElementById("yearly");

        var weeklyInput = document.getElementById("weeklyInput");
        var monthlyInput = document.getElementById("monthlyInput");
        var yearlyInput = document.getElementById("yearlyInput");

        // Function to toggle visibility of input fields
        function toggleInputFields() {
            if (weeklyRadio.checked) {
                weeklyInput.style.display = "block";
                monthlyInput.style.display = "none";
                yearlyInput.style.display = "none";
            } else if (monthlyRadio.checked) {
                weeklyInput.style.display = "none";
                monthlyInput.style.display = "block";
                yearlyInput.style.display = "none";
            } else if (yearlyRadio.checked) {
                weeklyInput.style.display = "none";
                monthlyInput.style.display = "none";
                yearlyInput.style.display = "block";
            } else {
                weeklyInput.style.display = "none";
                monthlyInput.style.display = "none";
                yearlyInput.style.display = "none";
            }
        }

        // Call the toggleInputFields function initially
        toggleInputFields();

        // Add event listeners to radio buttons to trigger toggleInputFields function
        weeklyRadio.addEventListener("change", toggleInputFields);
        monthlyRadio.addEventListener("change", toggleInputFields);
        yearlyRadio.addEventListener("change", toggleInputFields);
    });
</script>



