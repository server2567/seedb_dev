<style>
    .quill-editor-full {
        height: auto;
    }

    .ql-editor {
        height: 150px;
        /* line-height: 5; */
    }
</style>
<style>
    .mce-content-body {
        background-image: linear-gradient(to right, #000 1px, transparent 1px);
        background-size: 20px 100%;
        position: relative;
    }

    .mce-content-body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #000;
    }
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($PolicyID) ? 'แก้ไข' : 'เพิ่ม' ?>หัวข้อข้อมูลนโยบายคุ้มครองข้อมูลส่วนบุคคล</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation">
                        <div class="col-md-6">
                            <label for="PolicyNameT" class="form-label required">หัวเรื่อง</label>
                            <input type="text" class="form-control" name="nameinput[]" id="PolicyNameT" placeholder="ชื่อระบบภาษาไทย" value="<?php echo !empty($edit) ? $edit->policy_name : ""; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="PolicyActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" onchange="ckeckStatus(<?php echo !empty($edit->policy_id) ? $edit->policy_id : ''; ?>)" type="checkbox" name="nameinput[]" id="PolicyActive" <?php echo !empty($edit) && $edit->policy_status == "1" ? 'checked' : ''; ?> required>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row equal-height">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="col-md-12  nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="max-height: 550px; overflow-y: auto; overflow-x: hidden;">
                        <div class="text-center">
                            <a class="nav-link active border" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">เกรินนำ</a>
                            <a class="nav-link border" id="v-pills-profile1-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile1" type="button" role="tab" aria-controls="v-pills-profile1" aria-selected="false" tabindex="-1">คำนิยาม</a>
                            <a class="nav-link border" id="v-pills-profile2-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile2" type="button" role="tab" aria-controls="v-pills-profile2" aria-selected="false" tabindex="-1">การตกลงยอมรับข้อกำหนด</a>
                            <a class="nav-link border" id="v-pills-profile3-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile3" type="button" role="tab" aria-controls="v-pills-profile3" aria-selected="false" tabindex="-1">การแก้ไขข้อกำหนด</a>
                            <a class="nav-link border" id="v-pills-profile4-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile4" type="button" role="tab" aria-controls="v-pills-profile4" aria-selected="false" tabindex="-1">บัญชี</a>
                            <a class="nav-link border" id="v-pills-profile5-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile5" type="button" role="tab" aria-controls="v-pills-profile5" aria-selected="false" tabindex="-1">การคุ้มครองข้อมูลส่วนบุคคล</a>
                            <a class="nav-link border" id="v-pills-profile6-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile6" type="button" role="tab" aria-controls="v-pills-profile6" aria-selected="false" tabindex="-1">การให้บริการ</a>
                            <a class="nav-link border" id="v-pills-profile7-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile7" type="button" role="tab" aria-controls="v-pills-profile7" aria-selected="false" tabindex="-1">การแจ้งเหตุฉุกเฉิน</a>
                            <a class="nav-link border" id="v-pills-profile8-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile8" type="button" role="tab" aria-controls="v-pills-profile8" aria-selected="false" tabindex="-1">การประกาศ</a>
                            <a class="nav-link border" id="v-pills-profile9-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile9" type="button" role="tab" aria-controls="v-pills-profile9" aria-selected="false" tabindex="-1">ผู้ให้บริการภายนอก</a>
                            <a class="nav-link border" id="v-pills-profile10-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile10" type="button" role="tab" aria-controls="v-pills-profile10" aria-selected="false" tabindex="-1">เนื้อหา</a>
                            <a class="nav-link border" id="v-pills-profile11-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile11" type="button" role="tab" aria-controls="v-pills-profile11" aria-selected="false" tabindex="-1">ค่าธรรมเนียมการใช้บริการ</a>
                            <a class="nav-link border" id="v-pills-profile12-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile12" type="button" role="tab" aria-controls="v-pills-profile12" aria-selected="false" tabindex="-1">ข้อจำกัดการใช้งาน</a>
                            <a class="nav-link border" id="v-pills-profile13-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile13" type="button" role="tab" aria-controls="v-pills-profile13" aria-selected="false" tabindex="-1">ความรับผิดชอบของผู้สมัครสมาชิก</a>
                            <a class="nav-link border" id="v-pills-profile14-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile14" type="button" role="tab" aria-controls="v-pills-profile14" aria-selected="false" tabindex="-1">ข้อจำกัดความรับผิดของระบบ</a>
                            <a class="nav-link border" id="v-pills-profile15-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile15" type="button" role="tab" aria-controls="v-pills-profile15" aria-selected="false" tabindex="-1">การแจ้งเตือนและการติดต่อ</a>
                            <a class="nav-link border" id="v-pills-profile16-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile16" type="button" role="tab" aria-controls="v-pills-profile16" aria-selected="false" tabindex="-1">วัตถุประสงค์ในการเก็บรวบรวม</a>
                            <a class="nav-link border" id="v-pills-profile17-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile17" type="button" role="tab" aria-controls="v-pills-profile17" aria-selected="false" tabindex="-1">การเก็บรวบรวม</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                            <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($PolicyID) ? 'แก้ไข' : 'เพิ่ม' ?>รายละเอียดข้อมูลนโยบายคุ้มครองข้อมูลส่วนบุคคล</span>
                        </button>
                    </h2>
                    <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body">
                            <form class="row g-3 needs-validation">
                                <div class="card-body pt-3">
                                    <div class="tab-content pt-2" id="myTabContent" style="flex: 1;">
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">เกรินนำ</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_0"><?php echo !empty($DetailsArray[0]) ? $DetailsArray[0] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile1" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">1. คำนิยาม</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_1"><?php echo !empty($DetailsArray[1]) ? $DetailsArray[1] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile2" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">2. การตกลงยอมรับข้อกำหนดและเงื่อนไขฯ ฉบับนี้</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_2"><?php echo !empty($DetailsArray[2]) ? $DetailsArray[2] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile3" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">3. การแก้ไขข้อกำหนดและเงื่อนไขฯ ฉบับนี้</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_3"><?php echo !empty($DetailsArray[3]) ? $DetailsArray[3] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile4" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">4. บัญชี</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_4"><?php echo !empty($DetailsArray[4]) ? $DetailsArray[4] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile5" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">5. การคุ้มครองข้อมูลส่วนบุคคล</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_5"><?php echo !empty($DetailsArray[5]) ? $DetailsArray[5] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile6" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">6. การให้บริการฯ</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_6"><?php echo !empty($DetailsArray[6]) ? $DetailsArray[6] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile7" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">7. การแจ้งเหตุฉุกเฉิน</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_7"><?php echo !empty($DetailsArray[7]) ? $DetailsArray[7] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile8" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">8. การประกาศ</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_8"><?php echo !empty($DetailsArray[8]) ? $DetailsArray[8] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile9" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">9. ผู้ให้บริการภายนอก</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_9"><?php echo !empty($DetailsArray[9]) ? $DetailsArray[9] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile10" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">10. เนื้อหา</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_10"><?php echo !empty($DetailsArray[10]) ? $DetailsArray[10] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile11" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">11. ค่าธรรมเนียมการใช้บริการ</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_11"><?php echo !empty($DetailsArray[11]) ? $DetailsArray[11] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile12" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">12. ข้อจำกัดการใช้งาน</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_12"><?php echo !empty($DetailsArray[12]) ? $DetailsArray[12] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile13" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">13. ความรับผิดชอบของผู้สมัครสมาชิก</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_13"><?php echo !empty($DetailsArray[13]) ? $DetailsArray[13] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile14" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">14. ข้อจำกัดความรับผิดของระบบฯ</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_14"><?php echo !empty($DetailsArray[14]) ? $DetailsArray[14] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile15" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">15. การแจ้งเตือนและการติดต่อ</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_15"><?php echo !empty($DetailsArray[15]) ? $DetailsArray[15] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile16" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">16. วัตถุประสงค์ในการเก็บรวบรวม ใช้ และ/หรือเปิดเผยข้อมูล</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_16"><?php echo !empty($DetailsArray[16]) ? $DetailsArray[16] : ""; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile17" role="tabpanel">
                                            <div class="col-md-12">
                                                <label for="PolicyDetail" class="form-label">17. การเก็บรวบรวม ใช้ หรือเปิดเผยข้อมูลส่วนบุคคล</label>
                                                <textarea class="tinymce-editor" name="nameinput1[]" id="PolicyDetail_17"><?php echo !empty($DetailsArray[17]) ? $DetailsArray[17] : ""; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                        <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($PolicyID) ? 'แก้ไข' : 'เพิ่ม' ?>ไฟล์ข้อมูลนโยบายคุ้มครองข้อมูลส่วนบุคคล</span>
                    </button>
                </h2>
                <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                    <div class="accordion-body">
                        <form class="row g-3 needs-validation">
                            <div class="col-md-6">
                                <label for="PolicyNameE" class="form-label">อัพโหลดไฟล์เอกสาร</label>
                                <input type="file" class="form-control" name="nameinput[]" id="PolicyFileId" placeholder="" value="<?php echo !empty($edit) ? $edit->policy_namefile : ""; ?>">
                                <?php if (isset($edit) && is_object($edit) && !empty($edit->policy_namefile)) : ?>
                                    <div>
                                        <?php if (isset($edit->policy_namefile) && !empty($edit->policy_namefile)) : ?>
                                            <a class="btn btn-link" data-file-name="<?php echo $edit->policy_namefile; ?>" data-preview-path="<?php echo site_url($this->config->item('ums_dir') . 'Getpreview?path=' . $this->config->item('ums_uploads_Policy') . '&doc=' . $edit->policy_namefile); ?>" data-download-path="<?php echo site_url($this->config->item('ums_uploads_Policy') . 'Getdoc?path=' . $this->config->item('ums_uploads_Policy') . '&doc=' . "a.png" . '&rename=' . "a.png"); ?>" data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน">
                                                <?php echo $edit->policy_namefile; ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/Policy'">ย้อนกลับ</button>
        <?php if (!empty($edit->policy_id)) : ?>
            <button onclick="saveFormSubmit(<?php echo !empty($edit->policy_id) ? $edit->policy_id : ""; ?>)" class="btn btn-success float-end">บันทึก</button>
        <?php else : ?>
            <button onclick="saveFormSubmit()" class="btn btn-success float-end">บันทึก</button>
        <?php endif ?>
    </div>
</div>
<script>
    tinymce.init({
        selector: 'textarea', // เลือก textarea ที่จะใช้ TinyMCE
        plugins: 'visualblocks code', // เพิ่มปลั๊กอิน visualblocks และ code
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | visualblocks | code', // เพิ่ม visualblocks และ code ใน toolbar
        content_css: '//www.tiny.cloud/css/codepen.min.css', // เพิ่ม CSS จาก TinyMCE
        setup: function(editor) {
            editor.on('keydown', function(event) {
                if (event.keyCode === 9) { // KeyCode 9 คือปุ่ม Tab
                    event.preventDefault(); // ป้องกันการทำงานปกติของปุ่ม Tab
                    if (event.shiftKey) {
                        editor.execCommand('Outdent'); // เยื้องกลับ
                    } else {
                        editor.execCommand('Indent'); // เยื้องเข้า
                    }
                }
            });
        }
    });


    tinymce.init({
        selector: 'textarea', // เลือก textarea ที่จะใช้ TinyMCE
        // plugins: 'visualblocks code', // เพิ่มปลั๊กอิน visualblocks และ code
        plugins: 'wordcount',
        toolbar: 'wordcount',
        // toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | visualblocks | code', // เพิ่ม visualblocks และ code ใน toolbar
        content_style: '.mce-content-body { background-image: linear-gradient(to right, #000 1px, transparent 1px); background-size: 20px 100%; position: relative; } .mce-content-body::before { content: ""; position: absolute; top: 0; left: 0; right: 0; height: 1px; background-color: #000; }',
        setup: function(editor) {
            editor.on('keydown', function(event) {
                if (event.keyCode === 9) { // KeyCode 9 คือปุ่ม Tab
                    event.preventDefault(); // ป้องกันการทำงานปกติของปุ่ม Tab
                    if (event.shiftKey) {
                        editor.execCommand('Outdent'); // เยื้องกลับ
                    } else {
                        editor.execCommand('Indent'); // เยื้องเข้า
                    }
                }
            });
        }
    });

    function saveFormSubmit(id = null) {
        console.log(id);
        var formData = new FormData();
        // รวบรวมข้อมูลฟอร์มที่ไม่ใช่ไฟล์
        var policyNameT = document.getElementById('PolicyNameT').value;
        var policyActive = document.getElementById('PolicyActive').checked ? "1" : "0";
        var policyDetails = []; // สร้าง array เพื่อเก็บค่า
        $('[name^="nameinput1[]"]').each(function(i) {
            var editorId = 'PolicyDetail_' + i;
            console.log(editorId);
            console.log(this.id);
            if (this.id == editorId) {
                var policyDetail = tinymce.get(editorId).getContent();
                policyDetails[i] = policyDetail; // เก็บค่าใน array 
            }
        });
        // ตอนนี้ policyDetails จะมีค่าเนื้อหาจาก TinyMCE editor แต่ละตัว
        var policyDetailsString = policyDetails.map(function(detail, index) {
            return index + ": " + detail;
        }).join(", ");
        if (id) {
            formData.append('id', id);
        }
        formData.append('PolicyNameT', policyNameT);
        formData.append('PolicyActive', policyActive);
        formData.append('PolicyDetail', policyDetailsString);
        // รวบรวมข้อมูลไฟล์
        var policyFileInput = document.getElementById('PolicyFileId');
        if (policyFileInput.files.length > 0) {
            formData.append('PolicyFileId', policyFileInput.files[0]);
        }
        if (id == null) {
            $.ajax({
                method: "POST",
                url: 'add',
                data: formData,
                processData: false,
                contentType: false,
                success: function(returnData) {
                    console.log(returnData);
                    if (returnData == 1) {
                        dialog_success({
                            'header': 'ดำเนินการเสร็จสิ้น',
                            'body': 'บันทึกข้อมูลเสร็จสิ้น'
                        });
                        // setTimeout(function() {
                        //     window.location.href = '<?php echo base_url() ?>index.php/ums/Policy'
                        // }, 1500);

                    } else {
                        dialog_error({
                            'header': 'การเพิ่มข้อมุลล้มเหลว',
                            'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                        });
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': 'การเพิ่มข้อมุลล้มเหลว',
                        'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                    });
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 1500);
                }
            });
        } else {
            $.ajax({
                method: "POST",
                url: '../update',
                data: formData,
                processData: false,
                contentType: false,
                success: function(returnData) {
                    console.log(returnData);
                    if (returnData == 1) {
                        dialog_success({
                            'header': 'ดำเนินการเสร็จสิ้น',
                            'body': 'บันทึกข้อมูลเสร็จสิ้น'
                        });
                        // setTimeout(function() {
                        //     window.location.href = '<?php echo base_url() ?>index.php/ums/Policy'
                        // }, 1500);

                    } else {
                        dialog_error({
                            'header': 'การเพิ่มข้อมุลล้มเหลว',
                            'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                        });
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': 'การเพิ่มข้อมุลล้มเหลว',
                        'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                    });
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 1500);
                }
            });
        }
    }

    function ckeckStatus(id = null) {
        console.log(id);
        url = ""
        if (id == null) {
            url1 = 'check_status';
            url2 = 'update_status';
        } else {
            url1 = '../check_status';
            url2 = '../update_status';
        }
        $.ajax({
            method: "POST",
            url: url1,
            processData: false,
            contentType: false,
            success: function(returnData) {
                console.log(returnData);
                const arrayValue = JSON.parse(returnData);
                if (arrayValue.status_response == 1) {
                    Swal.fire({
                        title: 'มีการเปิดใช้งานหัวข้ออื่นอยู่!',
                        text: 'คุณต้องการปิดหัวข้ออื่นเพื่อเปิดใช้งาน หรือไม่ ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ใช่',
                        cancelButtonText: 'ไม่'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: "POST",
                                url: url2,
                                data: {
                                    id: arrayValue.ck.policy_id
                                },
                                success: function(returnData) {
                                    Swal.fire(
                                        'เรียบร้อย!',
                                        'คุณสามารถเปิดการใช้งานหัวข้อนี้อย่างสมบูรณ์.',
                                        'success'
                                    );
                                },
                                error: function(xhr, status, error) {

                                }
                            });
                        }
                    });
                }
            },
            error: function(xhr, status, error) {

            }
        });
    }
</script>