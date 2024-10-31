
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> รายการจำนวนคิวที่รับ</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <!-- <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Physician_assign_queue/add_form'"><i class="bi-plus"></i> เพิ่มจำนวนคิว </button>
                    </div> -->
                    <div class="btn-option mb-3">
                        <button class="btn btn-secondary" ><i class="bi bi-clipboard-plus-fill"></i> คัดลอกข้อมูลจากเดือนที่เเล้ว</button>
                    </div>
                   <form method="post" >
                    <div class="btn-option mb-3" id="button-container" style="display : none;">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-pencil-fill"></i> Edit Selected Records</button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">เลือก</th>
                                <th class="text-center">#</th>
                                <th class="w-25">วันที่</th>
                                <th class="text-center">จำนวนคิวที่สามารถรับได้ในแต่ละวัน </th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody><?php
                                $data = array(
                                    array(
                                        'physician' => '30/4/2024',
                                        'count' => '20',
                                        'id' => 1
                                    ),
                                    array(
                                        'physician' => '29/4/2024',
                                        'count' => '20',
                                        'id' => 2
                                    ),
                                    array(
                                        'physician' => '28/4/2024',
                                        'count' => '20',
                                        'id' => 3
                                    ),
                                    array(
                                        'physician' => '27/4/2024 ',
                                        'count' => '20',
                                        'id' => 4
                                    ),
                                    array(
                                        'physician' => '26/4/2024 ',
                                        'count' => '20',
                                        'id' => 5
                                    ),
                                    array(
                                        'physician' => '25/4/2024 ',
                                        'count' => '20',
                                        'id' => 6
                                    ),
                                    array(
                                        'physician' => '24/4/2024',
                                        'count' => '20',
                                        'id' => 7
                                    ),
                                    array(
                                        'physician' => '23/4/2024',
                                        'count' => '20',
                                        'id' => 8
                                    ),
                                    array(
                                        'physician' => '22/4/2024',
                                        'count' => '20 ',
                                        'id' => 9
                                    ),
                                    array(
                                        'physician' => '21/4/2024',
                                        'count' => '20',
                                        'id' => 10
                                    ),
                                );
                                ?>
                            <?php foreach($data as $key => $item){ ?>
                            <tr>
                                <td class="text-center option"> 
                                    <input type="checkbox" name="record_ids[]" value="<?php echo $item['id']; ?>" />    
                                </td>
                                <td class="text-center"><?php echo $key+1; ?></td>
                                <td class= "" > <?php echo $item['physician']; ?></td>
                                <td class="text-center"> <?php echo $item['count'];?> </td>
                                
                                <td class="text-center option">

                                    <!-- <button class="btn btn-warning btn-inline" onclick="window.location.href='<?php echo base_url()?>index.php/que/Physician_assign_queue/update_form/<?php echo $item['id'];?>'"><i class="bi-pencil-square"></i></button> -->
                                    <button class="btn btn-danger btn-inline" data-url="<?php echo base_url()?>index.php/que/Physician_assign_queue/delete/<?php echo $item['id']; ?>"><i class="bi-trash"></i></button>
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
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const buttonContainer = document.getElementById('button-container');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                if (checkedCheckboxes.length >= 2) {
                    buttonContainer.style.display = 'block';
                } else {
                    buttonContainer.style.display = 'none';
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all buttons with the class btn-warning
        var updateButtons = document.querySelectorAll('.update-button');

        // Add click event listener to each button
        updateButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();
                // Get the URL from the data-href attribute
                var url = button.getAttribute('data-href');
                // Navigate to the URL
                window.location.href = url;
            });
        });
    });
</script>