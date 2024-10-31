<style>
    ul {
        list-style-type: none;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($stpo_info) ? 'แก้ไข' : 'เพิ่ม' ?>ตำแหน่งในโครงสร้าง</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อตำแหน่งในโครงสร้าง (ภาษาไทย)</label>
                            <?php if (!empty($stpo_info->stpo_id)) { ?>
                                <input type="text" name="structure_position[]" id="stpo_id" value="<?php echo !empty($stpo_info) ? $stpo_info->stpo_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="structure_position[]" id="stpo_name" placeholder="ตำแหน่งในโครงสร้างภาษาไทย" value="<?php echo !empty($stpo_info) ? $stpo_info->stpo_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="stpo_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อตำแหน่งในโครงสร้าง (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="structure_position[]" id="stpo_name_en" placeholder="ตำแหน่งในโครงสร้างภาษาอังกฤษ" value="<?php echo !empty($stpo_info) ?  $stpo_info->stpo_name_en : ""; ?>">
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label required">ชื่อตำแหน่งในโครงสร้าง (สำหรับแสดงในระบบ)</label>
                            <input type="text" class="form-control" name="structure_position[]" id="stpo_used" placeholder="ตำแหน่งในโครงสร้างภาษาอังกฤษ" value="<?php echo !empty($stpo_info) ?  $stpo_info->stpo_used : ""; ?>">
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-3">
                                    <?php if (!empty($stpo_info->stpo_id)) { ?>
                                        <input type="checkbox" name="structure_position[]" id="stpo_display" class="form-check-input m-1" value="<?php echo !empty($stpo_info) ? $stpo_info->stpo_display : ""; ?>" <?php echo !empty($stpo_info) && $stpo_info->stpo_display == '1' ? 'checked' : ""; ?>>
                                    <?php } else { ?>
                                        <input type="checkbox" name="structure_position[]" id="stpo_display" class="form-check-input ">
                                    <?php } ?>
                                    <label for="gridCheck1" class="form-check-label">แสดงผลในโครงสร้างองค์กร</label>
                                </div>
                                <div class="col-9 text-start">
                                    <?php if (!empty($stpo_info->stpo_id)) { ?>
                                        <input type="checkbox" name="structure_position[]" id="stpo_active" class="form-check-input m-1" value="<?php echo !empty($stpo_info) ? $stpo_info->stpo_active : ""; ?>" <?php echo !empty($stpo_info) && $stpo_info->stpo_active == '1' ? 'checked' : ""; ?>>
                                    <?php } else { ?>
                                        <input type="checkbox" id="stpo_active" class="form-check-input" checked disabled>
                                    <?php } ?>
                                    <label for="gridCheck1" class="form-check-label">สถานะการใช้งาน</label>
                                </div>
                               
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/structure_position'">ย้อนกลับ</button>
                            <?php if (!empty($stpo_info->stpo_id)) { ?>
                                <button type="button" onclick="submitEdit()" class="btn btn-success float-end">บันทึก</button>
                            <?php } else { ?>
                                <button type="button" onclick="submitAdd()" class="btn btn-success float-end">บันทึก</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var formData = {};

    function submitAdd() {
        $('[name^="structure_position"]').each(function() {                
            if (this.id != 'stpo_active' && this.id != 'stpo_display') {
                formData[this.id] = this.value;
            } else {
                var checkbox = document.getElementById(this.id);
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.stpo_id;
        if (!formData.stpo_name) {
            !formData.stpo_name ? $('#stpo_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'structure_position/checkValue'; ?>',
            method: 'POST',
            data: {
                stpo_name: formData['stpo_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('stpo_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ตำแหน่งในโครงสร้างนี้ถูกใช้งานแล้ว'
                });
                $('#stpo_name').get(0).focus()
                inputElement.innerHTML = "ตำแหน่งในโครงสร้างนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>structure_position/structure_position_insert',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/structure_position'
                    }, 1500);
                    i
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="structure_position"]').each(function() {
            if (this.id != 'stpo_active' && this.id != 'stpo_display') {
                formData[this.id] = this.value;
            } else {
                var checkbox = document.getElementById(this.id);
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.stpo_name) {
            !formData.stpo_name ? $('#stpo_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'structure_position/checkValue'; ?>',
            method: 'POST',
            data: {
                stpo_name: formData['stpo_name'],
                stpo_id: formData['stpo_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('stpo_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ตำแหน่งในโครงสร้างถูกนี้ใช้งานแล้ว'
                });
                $('#stpo_name').get(0).focus()
                inputElement.innerHTML = "ตำแหน่งในโครงสร้างนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>structure_position/structure_position_update',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                })
            }
        })
    }
</script>