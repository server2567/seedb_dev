<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>เปิดการจองคิว</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form id="dynamicForm" class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Base/add">
                        <div class="col-md-6">
                            <label for="StNameT" class="form-label required">วันที่</label>
                            <input type="date" class="form-control" name="StNameT" id="StNameT" placeholder="ระบุชื่อเลขติดตาม" value="<?php echo !empty($edit) ? $edit['StNameT'] : "";?>" required>
                        </div>
                        
                        <div id="dynamicDropdowns" class="row">
                            <label for="StNameT" class="col form-label required">รูปแบบเลขติดตาม</label>
                            <button type="button" id="addDropdown" class="col-3 m-3 btn btn-outline-primary btn-sm">เพิ่มช่วงเวลา</button>
                            <button type="button" id="removeDropdown" class="col-3 m-3 w-25 btn btn-outline-danger btn-sm ">ลบช่วงเวลา</button>
                            <!-- Dynamic dropdown lists will be appended here -->
                            </div>
                       
                        <div class="col-md-6">
                            <label for="StNameE" class="form-label required">จำนวนเปิดจองคิวทั้งหมด</label>
                            <input type="text" class="form-control" name="StNameE" id="allcount" placeholder="รายละเอียดเลขติดตาม" value="" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="StActive" id="StActive">
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        
                        
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
    
<div class="col-md-12">
                            
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base/queue_show'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dynamicDropdowns = document.getElementById('dynamicDropdowns');
        const addDropdownButton = document.getElementById('addDropdown');
        const removeDropdownButton = document.getElementById('removeDropdown');

        let dropdownIndex = 0;

        addDropdownButton.addEventListener('click', function() {
            if (dropdownIndex % 4 === 0) {
                const newRow = document.createElement('div');
                newRow.classList.add('row');
                dynamicDropdowns.appendChild(newRow);
            }

            const newCol = document.createElement('div');
            newCol.classList.add('col-md-3'); // Adjust column size as needed
            newCol.innerHTML = `
                <div class="card ">
                    <div class="card-body">
                        <div class=" card-title pt-1">
                            <span class="small" style="font-weight: 700; color: var(--tp-font-color);">ช่วงเวลาที่ ${dropdownIndex+1}</span>
                        </div>

                        <div class="row ">
                            <div class="col">
                                <label>เริ่มต้น</label>
                                <input type="time" class="form-control" name="start" id="start"   required>
                            </div>
                            <div class="col ">
                                <label>สิ้นสุด</label>
                                <input type="time" class="form-control" name="end" id="end"   required>
                            </div>
                            <div class="col m-1">
                                <label>จำนวนคิว</label>
                                <input type="number" class="form-control" name="count" id="count"   required>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            dynamicDropdowns.lastChild.appendChild(newCol);
            dropdownIndex++;
        });

        removeDropdownButton.addEventListener('click', function() {
            const lastRow = dynamicDropdowns.lastChild;
            const lastDropdown = lastRow.lastChild;
            if (lastDropdown) {
                lastRow.removeChild(lastDropdown);
                dropdownIndex--;
            }
            // If no dropdowns left, remove the row
            if (lastRow.children.length === 0) {
                dynamicDropdowns.removeChild(lastRow);
            }
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-dropdown')) {
                const index = parseInt(event.target.getAttribute('data-index'));
                const dropdown = document.getElementById(`dynamicDropdown${index}`);
                
                // Remove the dropdown from the DOM
                dropdown.parentNode.parentNode.parentNode.removeChild(dropdown.parentNode.parentNode);
                
                // Update index of each dropdown after removal
                const dropdowns = dynamicDropdowns.querySelectorAll('.remove-dropdown');
                dropdowns.forEach((dropdown, newIndex) => {
                    dropdown.setAttribute('data-index', newIndex);
                });
            }
        });
    });
    document.addEventListener('click', function() {
    const queueInputs = document.querySelectorAll('input[name="count"]');
    const totalQueueInput = document.getElementById('allcount');

    // Function to update the total queue count
    function updateTotalQueueCount() {
        let total = 0;
        queueInputs.forEach(function(input) {
            total += parseInt(input.value) || 0;
        });
        totalQueueInput.value = total;
    }

    // Listen for changes in each queue input
    queueInputs.forEach(function(input) {
        input.addEventListener('input', updateTotalQueueCount);
    });

    // Update total count initially
    updateTotalQueueCount();
});
</script>

