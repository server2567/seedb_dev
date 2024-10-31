
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>เพิ่มชื่อประเภทการแจ้งเตือน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show"  aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate id="departmentForm" method="post" action="<?php echo base_url(); ?>index.php/ams/Base_notify/add" >
                        <div class="col-md-6">
                            <label for="ntf_name" class="form-label">ชื่อประเภทการแจ้งเตือน (ภาษาไทย)</label>
                            <input type="text" class="form-control required" name="ntf_name" id="ntf_name" placeholder="ชื่อประเภทการแจ้งเตือนภาษาไทย"  oninput="validateThaiInput(this)" required>
                            <p id="errorThaiMessage" style="color: red; display: none;"> โปรดกรอกภาษาไทย</p>

                        </div>
                        <div class="col-md-6">
                            <label for="ntf_name_en" class="form-label">ชื่อประเภทการแจ้งเตือน (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="ntf_name_en" id="ntf_name_en" placeholder="ชื่อประเภทการแจ้งเตือนภาษาอังกฤษ"  oninput="validateEnglishInput(this)" required>
                            <p id="errorMessage" style="color: red; display: none;">โปรดกรอกภาษาอังกฤษ</p>
                        </div>
                        <div class="col-md-6">
                            <label for="ntf_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ntf_active" id="ntf_active" checked>
                                <label for="ntf_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ams/Base_notify'">ย้อนกลับ</button>
                            <button type="submit" id="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        function validateEnglishInput(input) {
            // Regular expression to allow English letters, numbers, spaces, and common punctuation
            const englishRegex = /^[a-zA-Z0-9 .,!?'"()-]*$/;
            const errorMessage = document.getElementById("errorMessage");

            // If the value doesn't match the regex, set the input value to the last valid value
            if (!englishRegex.test(input.value)) {
                errorMessage.style.display = 'block';
                input.value = input.value.slice(0, -1); // Remove the last character
            } else {
                errorMessage.style.display = 'none';
            }
        }
        function validateThaiInput(input) {
            // Regular expression to allow English letters, numbers, spaces, and common punctuation
            const thaiRegex = /^[ก-๙\s]*$/;
            const errorMessage = document.getElementById("errorThaiMessage");

            // If the value doesn't match the regex, set the input value to the last valid value
            if (!thaiRegex.test(input.value)) {
                errorMessage.style.display = 'block';
                input.value = input.value.slice(0, -1); // Remove the last character
            } else {
                errorMessage.style.display = 'none';
            }
        }
</script>