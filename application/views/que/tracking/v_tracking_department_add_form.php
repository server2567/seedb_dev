<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>เพิ่มเลขนัดหมายของแผนก</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate id="departmentForm">
                        <div class="col-md-6">
                            <label for="dep_id" class="form-label required">ชื่อแผนก</label>
                            <select class="form-control select2 required" data-placeholder="-- เลือกแผนก --" name="dep_id" id="dep_id" required>
                                <option value=""></option>
                                <?php if (isset($dep_info)) { ?>
                                    <?php foreach ($dep_info as $dep) : ?>
                                        <option value="<?php echo $dep->stde_id ?>" data-name="<?php echo $dep->stde_name_th ?>"><?php echo $dep->stde_name_th ?></option>
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="dep_keyword" class="form-label required">เลขนัดหมาย</label>
                            <input type="text" class="form-control required" maxlength="3" name="dep_keyword" id="dep_keyword" placeholder="สูงสุด 3 อักษร" required>
                        </div>
                        <div class="col-md-12">
                            <label for="dep_desc" class="form-label">รายละเอียดเพิ่มเติม(ถ้ามี)</label>
                            <textarea id="quill-editor" class="form-control" style="height: 150px;" name="dep_desc" id="hidden_dep_desc"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="StActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dep_active" id="dep_active" checked>
                                <label for="dep_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking_department'">ย้อนกลับ</button>
                            <button type="button" id="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Quill's JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    
    var quill = new Quill('#quill-editor', {
        theme: 'snow'
    });
    
    $(document).ready(function() {
        $('#submit').on('click', function() {
            // Populate hidden form field with Quill content
            $('#hidden_dep_desc').val(quill.root.innerHTML);

            // Get the selected option
            var depSelect = $('#dep_id');
            var selectedOption = depSelect.find('option:selected');

            var formData = $('#departmentForm').serialize(); // Serialize form data
            if (!validateFormData(formData)) {
                Swal.fire({
                    title: 'ข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลในทุกช่องที่ขึ้น * (สีแดง)',
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                });
                return;
            }
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/que/Tracking_department/add',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'error') {
                        // Show error dialog
                        dialog_error({
                            'header': response.header,
                            'body': response.body
                        });
                    } else if (response.status === 'success') {
                        dialog_success({
                            'header': response.header,
                            'body': response.body
                        });
                        
                        setInterval(function(){window.location.href = response.returnUrl;}, 3000);
                        
                    }
                }
            });
        });
    });

    function validateFormData() {
    let isValid = true;
    const requiredFields = ['dep_keyword', 'dep_id'];

    requiredFields.forEach(field => {
        const value = $('[name="' + field + '"]').val();  // Correctly select the value
        const element = document.getElementById(field);
        if (!value || value.trim() === '') {
            isValid = false;
            if (element) {
                element.classList.add('is-invalid');
            }

            // Handle select2 invalid state
            const select2Container = $(element).next('.select2-container');
            if (select2Container.length) {
                select2Container.find('.select2-selection').addClass('is-invalid');
            }
        } else {
            if (element) {
                element.classList.remove('is-invalid');
            }

            // Handle select2 valid state
            const select2Container = $(element).next('.select2-container');
            if (select2Container.length) {
                select2Container.find('.select2-selection').removeClass('is-invalid');
            }
        }
    });

    return isValid;
}
</script>
