<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($disease[0]['ds_id']) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลประเภท<?php echo !empty($disease[0]['ds_id']) ? $disease[0]['ds_name_disease_type'] : 'โรคผู้ป่วย'?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" id="disease_form">
                        <input type="hidden" class="form-control" name="ds_id" id="ds_id"  value="<?php echo !empty($disease[0]['ds_id']) ? $disease[0]['ds_id'] : "" ?>" >
                        <div class="col-md-6">
                            <label for="ds_stde_id" class="form-label required">แผนกการรักษา</label>
                                <select class="form-select select2" name="ds_stde_id" id="ds_stde_id" data-placeholder="-- กรุณาเลือกแผนกการรักษา --" required>
                                    <option value=""></option>
                                    <?php if (isset($stde)) { ?>
                                        <?php foreach ($stde as $dep) : ?>
                                            <option value="<?php echo $dep->stde_id ?>" data-name="<?php echo $dep->stde_name_th ?>" <?php echo (isset($disease[0]['ds_stde_id']) && $dep->stde_id == $disease[0]['ds_stde_id']) ? 'selected' : ''; ?>>
                                                <?php echo $dep->stde_name_th ?>
                                            </option>
                                        <?php endforeach ?>
                                    <?php } ?>
                                </select>                        
                            </div>
                            <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <label for="ds_name_disease_type" class="form-label required">ประเภทโรค (ไทย)</label>
                            <input type="text" class="form-control" name="ds_name_disease_type" id="ds_name_disease_type" placeholder="ประเภทโรค" value="<?php echo !empty($disease[0]['ds_name_disease_type']) ? $disease[0]['ds_name_disease_type'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ds_name_disease_type_en" class="form-label required">ประเภทโรค (อังกฤษ)</label>
                            <input type="text" class="form-control" name="ds_name_disease_type_en" id="ds_name_disease_type_en" placeholder="ประเภทโรค" value="<?php echo !empty($disease[0]['ds_name_disease_type_en']) ? $disease[0]['ds_name_disease_type_en'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ds_name_disease" class="form-label required">ชื่อโรค (ไทย)</label>
                            <input type="text" class="form-control" name="ds_name_disease" id="ds_name_disease" placeholder="ชื่อโรค" value="<?php echo !empty($disease[0]['ds_name_disease']) ? $disease[0]['ds_name_disease'] : "" ;?>" required>
                        </div>    
                        <div class="col-md-6">
                            <label for="ds_name_disease_en" class="form-label required">ชื่อโรค (อังกฤษ)</label>
                            <input type="text" class="form-control" name="ds_name_disease_en" id="ds_name_disease_en" placeholder="ชื่อโรค" value="<?php echo !empty($disease[0]['ds_name_disease_en']) ? $disease[0]['ds_name_disease_en'] : "" ;?>" required>
                        </div>     
                        <div class="col-md-6">
                            <label for="ds_detail" class="form-label">คำอธิบายประเภทโรค (ไทย)</label>
                                <!-- <div class="form-check">
                                    <textarea id="quill-editor" class="form-control" style="height: 200px;" name="ds_detail" id="hidden_ds_detail"></textarea>
                                </div> -->
                                <?php if (isset($disease) && !empty($disease[0]['ds_id'])) { ?>
                                    <div id="quill-editor" class="form-control" style="height: 200px;" id="ds_detail" name="ds_detail"></div>
                                    <textarea id="hidden_ds_detail" name="ds_detail" style="display:none;"></textarea>
                                <?php } else { ?>
                                    <textarea name="ds_detail" id="ds_detail"  class="quill-editor-default form-control" ></textarea>
                                <?php } ?>
                                <!-- <textarea name="ds_detail" id="ds_detail"  class=" form-control" ></textarea> -->
                           
                        </div>
                        <div class="col-md-6">
                            <label for="ds_detail_en" class="form-label">คำอธิบายประเภทโรค (อังกฤษ)</label>
                            <?php if (isset($disease) && !empty($disease[0]['ds_id'])) { ?>
                                    <div id="quill-editor2" class="form-control" style="height: 200px;" id="ds_detail_en" name="ds_detail_en"></div>
                                    <textarea id="hidden_ds_detail_en" name="ds_detail_en" style="display:none;"></textarea>
                                <?php } else { ?>
                                    <textarea name="ds_detail_en" id="ds_detail_en"  class="quill-editor-default form-control"></textarea>
                                <?php } ?>
                                <!-- <textarea name="ds_detail_en" id="ds_detail_en"  class="quill-editor-default form-control"></textarea> -->
                            
                        </div>
                        <div class="col-md-6">
                            <label for="ds_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ds_active" id="ds_active" <?php echo !empty($disease) && $disease[0]['ds_active'] == 1 ? "checked" : "" ;?>>
                                <label for="ds_active" class="form-check-label">เปิดใช้งาน</label>                          
                            </div>
                        </div>         
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_disease'">ย้อนกลับ</button>
                            <?php if (isset($disease) && !empty($disease[0]['ds_id'])) { ?>
                            <button type="button" class="btn btn-success float-end" id="disease_update">บันทึก</button>
                            <?php } else { ?>
                            <button type="button" class="btn btn-success float-end" id="disease_add">บันทึก</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('ds_name_disease_type').addEventListener('input', function(event) {
    var input = event.target;
    // Allow only English letters
    var sanitizedValue = input.value.replace(/[^ก-๙\s]/g, '');
    if (input.value !== sanitizedValue) {
        input.value = sanitizedValue;
    }
});
</script>
<script>
document.getElementById('ds_name_disease').addEventListener('input', function(event) {
    var input = event.target;
    // Allow only English letters
    var sanitizedValue = input.value.replace(/[^ก-๙\s]/g, '');
    if (input.value !== sanitizedValue) {
        input.value = sanitizedValue;
    }
});
</script>
<script>
document.getElementById('ds_detail').addEventListener('input', function(event) {
    var input = event.target;
    // Allow only English letters
    var sanitizedValue = input.value.replace(/[^ก-๙\s]/g, '');
    if (input.value !== sanitizedValue) {
        input.value = sanitizedValue;
    }
});
</script>

<script>
document.getElementById('ds_name_disease_type_en').addEventListener('input', function(event) {
    var input = event.target;
    // Allow only English letters
    var sanitizedValue = input.value.replace(/[^a-zA-Z\s]/g, '');
    if (input.value !== sanitizedValue) {
        input.value = sanitizedValue;
    }
});
</script>

<script>
document.getElementById('ds_name_disease_en').addEventListener('input', function(event) {
    var input = event.target;
    // Allow only English letters
    var sanitizedValue = input.value.replace(/[^a-zA-Z\s]/g, '');
    if (input.value !== sanitizedValue) {
        input.value = sanitizedValue;
    }
});
</script>
<script>
document.getElementById('ds_detail_en').addEventListener('input', function(event) {
    var input = event.target;
    // Allow only English letters
    var sanitizedValue = input.value.replace(/[^a-zA-Z\s]/g, '');
    if (input.value !== sanitizedValue) {
        input.value = sanitizedValue;
    }
});
</script>

<script>
    $(document).ready(function() {
        $('#disease_add').on('click', function() {
            // Populate hidden form field with Quill content

            var formData = $('#disease_form').serializeArray(); // Serialize form data
            let url = '<?php echo base_url(); ?>index.php/wts/Base_disease/disease_insert';
            save_ajax(url, "disease_form", formData); // from main.js
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#disease_update').on('click', function() {
            // Populate hidden form field with Quill content
            $('#hidden_ds_detail').val(quill.getText().trim());
            $('#hidden_ds_detail_en').val(quill2.getText().trim());
            var formData = $('#disease_form').serializeArray(); // Serialize form data
            let url = '<?php echo base_url(); ?>index.php/wts/Base_disease/disease_update';
            save_ajax(url, "disease_form", formData); // from main.js
        });
    });
</script>


<script>
function handleClick(element) {
  // ลบคลาส active จากทุก elements ที่มีคลาส active อยู่
  var activeElements = document.querySelectorAll('.active');
  activeElements.forEach(function(el) {
    el.classList.remove('active');
  });
  element.classList.add('active');
}

const initialData_th = [
            { insert: '<?php echo isset($disease) && !empty($disease) ? $disease[0]['ds_detail'] : ''; ?>\n' }
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


quill.setContents(initialData_th);

const initialData_en = [
            { insert: '<?php echo isset($disease) && !empty($disease) ? $disease[0]['ds_detail_en'] : ''; ?>\n' }
        ];
    
    var quill2 = new Quill('#quill-editor2', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic'],
            ['link', 'blockquote', 'code-block', 'image'],
            [{ list: 'ordered' }, { list: 'bullet' }],
        ],
    },
});

quill2.setContents(initialData_en);

</script>