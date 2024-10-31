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
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?> index.php/wts/Base_disease/disease_insert">
                    <div class="col-md-6">
                            <label for="ds_stde_id" class="form-label required">แผนกการรักษา</label>
                                <select class="form-select select2" name="ds_stde_id" id="ds_stde_id" data-placeholder="-- กรุณาเลือกแผนกการรักษา --" disabled readonly>
                                    <option value=""></option>
                                    <?php if (isset($stde)) { ?>
                                    <?php foreach ($stde as $dep) : ?>
                                        <option value="<?php echo $dep->stde_id ?>" data-name="<?php echo $dep->stde_name_th ?>" <?php echo ($dep->stde_id == $disease[0]['ds_stde_id']) ? 'selected' : ''; ?>><?php echo $dep->stde_name_th ?></option>
                                    <?php endforeach ?>
                                <?php } ?>
                                </select>                        
                            </div>
                            <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <label for="ds_name_disease_type" class="form-label required">ประเภทโรค (ไทย)</label>
                            <input type="text" class="form-control" name="ds_name_disease_type" id="ds_name_disease_type" placeholder="ประเภทโรค" value="<?php echo !empty($disease[0]['ds_name_disease_type']) ? $disease[0]['ds_name_disease_type'] : " " ;?>" disabled readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="ds_name_disease_type_en" class="form-label required">ประเภทโรค (อังกฤษ)</label>
                            <input type="text" class="form-control" name="ds_name_disease_type_en" id="ds_name_disease_type_en" placeholder="ประเภทโรค" value="<?php echo !empty($disease[0]['ds_name_disease_type_en']) ? $disease[0]['ds_name_disease_type_en'] : " " ;?>" disabled readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="ds_name_disease" class="form-label ">ชื่อโรค (ไทย)</label>
                            <input type="text" class="form-control" name="ds_name_disease" id="ds_name_diseasee" placeholder="ชื่อโรค" value="<?php echo !empty($disease[0]['ds_name_disease']) ? $disease[0]['ds_name_disease'] : " " ;?>" disabled readonly>
                        </div>    
                        <div class="col-md-6">
                            <label for="ds_name_disease_en" class="form-label ">ชื่อโรค (อังกฤษ)</label>
                            <input type="text" class="form-control" name="ds_name_disease_en" id="ds_name_disease_en" placeholder="ชื่อโรค" value="<?php echo !empty($disease[0]['ds_name_disease_en']) ? $disease[0]['ds_name_disease_en'] : " " ;?>" disabled readonly>
                        </div>     
                        <div class="col-md-6">
                            <label for="ds_detail" class="form-label">คำอธิบายประเภทโรค (ไทย)</label>
                            <div id="quill-editor" class="form-control" style="height: 200px;" id="ds_detail" name="ds_detail"></div>
                                <!-- <textarea name="ds_detail" id="ds_detail"  class="quill-editor-default form-control" disabled readonly></textarea> -->
                           
                        </div>
                        <div class="col-md-6">
                            <label for="ds_detail_en" class="form-label">คำอธิบายประเภทโรค (อังกฤษ)</label>
                            <div id="quill-editor2" class="form-control" style="height: 200px;" id="ds_detail_en" name="ds_detail_en"></div>
                                <!-- <textarea name="ds_detail_en" id="ds_detail_en"  class="quill-editor-default form-control" disabled readonly></textarea> -->
                            
                        </div>
                        <div class="col-md-6">
                            <label for="ds_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ds_active" id="ds_active"  <?php echo !empty($disease[0]['ds_active'] == 1) ? 'checked disabled readonly' : 'disabled readonly' ;?>>
                                <label for="ds_status" class="form-check-label">เปิดใช้งาน</label>                          
                            </div>
                        </div>         
                        <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_disease'">ย้อนกลับ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        // ค่าที่ต้องการแสดงใน textarea
        var textareaValue = <?php echo !empty($disease[0]['ds_detail']) ? $disease[0]['ds_detail'] : "" ;?>;

        // กำหนดค่าลงใน textarea
        document.getElementById('ds_detail').value = textareaValue;
    </script>

<script>
    // Function to save checkbox state
function saveCheckboxState() {
    const checkbox = document.getElementById('SgActive');
    localStorage.setItem('SgActive', checkbox.checked);
}

// Function to load checkbox state
function loadCheckboxState() {
    const checkbox = document.getElementById('SgActive');
    const savedState = localStorage.getItem('SgActive') === 'true';
    checkbox.checked = savedState;
}

// Add event listener to save state when checkbox changes
document.getElementById('SgActive').addEventListener('change', saveCheckboxState);

// Load the checkbox state when the page loads
document.addEventListener('DOMContentLoaded', loadCheckboxState);

</script>

<script>
function handleClick(element) {
  // ลบคลาส active จากทุก elements ที่มีคลาส active อยู่
  var activeElements = document.querySelectorAll('.active');
  activeElements.forEach(function(el) {
    el.classList.remove('active');
  });

  // เพิ่มคลาส active ให้กับ element ที่ถูกคลิก
  element.classList.add('active');
}

const initialData_th = [
            { insert: '<?php echo $disease[0]['ds_detail'] ?>\n' }
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
quill.enable(false);


quill.setContents(initialData_th);

const initialData_en = [
            { insert: '<?php echo $disease[0]['ds_detail_en'] ?>\n' }
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
quill2.enable(false);


quill2.setContents(initialData_en);
// if (document.querySelector('.quill-editor-default')) {
//   new Quill('.quill-editor-default', {
//     theme: 'snow'
//   });
//   $('.ql-container').addClass('custom-height').css('height', '200px');
// }
// if (document.querySelector('.quill-editor-default2')) {

//   new Quill('.quill-editor-default2', {
//     theme: 'snow'
//   });
//   $('.ql-container').addClass('custom-height').css('height', '200px');
// }
</script>