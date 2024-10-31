<head>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpdate" aria-expanded="true" aria-controls="collapseUpdate">
                    <i class="bi-pencil-square icon-menu"></i><span>แก้ไขเลขนัดหมายของแผนก</span>
                </button>
            </h2>
            <div id="collapseUpdate" class="accordion-collapse collapse show" aria-labelledby="headingUpdate">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate id="updateDepartmentForm">
                        <div class="col-md-6">
                        <input type="hidden" name="dpk_id" id="dpk_id" value="<?php echo $dep_detail->dpk_id ?>">
                            <label for="dep_id" class="form-label required">ชื่อแผนก</label>
                            <select class="form-control select2" data-placeholder="-- เลือกแผนก --" name="dep_id" id="dep_id" required>
                                <option value=""></option>
                                <?php if (isset($dep_info)) { ?>
                                    <?php foreach ($dep_info as $dep) : ?>
                                        <option value="<?php echo $dep->stde_id ?>" data-name="<?php echo $dep->stde_name_th ?>" <?php echo ($dep->stde_id == $dep_detail->dpk_stde_id) ? 'selected' : ''; ?>><?php echo $dep->stde_name_th ?></option>
                                    <?php endforeach ?>
                                        
                                        <!-- <option value="<?php echo $dep_detail->dpk_stde_id ?>" > <?php echo $dep_detail->stde_name_th ?></option>     -->

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="dep_keyword" class="form-label required">Keyword</label>
                            <input type="text" class="form-control" maxlength="3" name="dep_keyword" id="dep_keyword" value="<?php echo $dep_detail->dpk_keyword ?>" placeholder="รายละเอียดเลขนัดหมาย" required>
                        </div>
                        <div class="col-md-12">
                            <label for="dep_desc" class="form-label">รายละเอียดเพิ่มเติม(ถ้ามี)</label>
                            <div class="">
                                <div id="quill-editor" class="form-control" style="height: 150px;" id="dep_desc" name="dep_desc"></div>
                                <textarea id="hidden_dep_desc" name="dep_desc" style="display:none;"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="StActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dep_active" id="dep_active" <?php echo ($dep_detail->dpk_active) ? 'checked' : ''; ?>>
                                <label for="dep_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking_department'">ย้อนกลับ</button>
                            <button type="button" id="updateSubmit" class="btn btn-success float-end">บันทึก</button>
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

const initialData = [
            { insert: '<?php echo $dep_detail->dpk_detail ?>\n' }
        ];

    
    var quill = new Quill('#quill-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic'],
            ['link', 'blockquote', 'code-block', 'image'],
            [{ list: 'ordered' }, { list: 'bullet' }],
        ],
    },
});
    
    quill.setContents(initialData);
        
    $(document).ready(function() {
        $('#updateSubmit').on('click', function() {
            // Populate hidden form field with Quill content
            $('#hidden_dep_desc').val(quill.getText().trim());

            // Get the selected option
            var depSelect = $('#dep_id');
            var selectedOption = depSelect.find('option:selected');

            console.log(depSelect.val());

            var formData = $('#updateDepartmentForm').serialize(); // Serialize form data
            console.log(formData);
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
                url: '<?php echo base_url(); ?>index.php/que/Tracking_department/update',
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
    function dialog_error(options) {
        // Custom function to show error dialog
        alert(options.header + '\n' + options.body);
    }

    function dialog_success(options) {
        // Custom function to show success dialog
        alert(options.header + '\n' + options.body);
    }
</script>
