<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($disease_time[0]['dst_id']) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลระยะเวลาการรักษาของแต่ละประเภทโรคผู้ป่วย</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" id="disease_time_form">
                    <input type="hidden" class="form-control" name="dst_id" id="dst_id"  value="<?php echo !empty($disease_time[0]['dst_id']) ? $disease_time[0]['dst_id'] : "" ?>" >
                        <div class="col-md-6">
                            <label for="dst_ds_id"" class="form-label required">ประเภทโรค</label>
                            <select class="form-select select2" name="dst_ds_id" id="dst_ds_id" data-placeholder="-- กรุณาเลือกประเภทโรค --" disabled>
                                    <option value=""></option>
                                    <?php if (isset($ds_type)) { ?>
                                        <?php foreach ($ds_type as $item) : ?>
                                            <option value="<?php echo $item->ds_id ?>" data-name="<?php echo $item->ds_name_disease_type ?>" <?php echo (isset($disease_time[0]['dst_ds_id']) && $item->ds_id == $disease_time[0]['dst_ds_id']) ? 'selected' : ''; ?>>
                                                <?php echo $item->ds_name_disease_type ?>
                                            </option>
                                        <?php endforeach ?>
                                    <?php } ?>
                                </select>    
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <label for="dst_name_point" class="form-label required">จุดบริการ (ไทย)</label>
                            <input type="text" class="form-control" name="dst_name_point" id="dst_name_point" placeholder="จุดบริการ" value="<?php echo !empty($disease_time[0]['dst_name_point']) ? $disease_time[0]['dst_name_point'] : "" ;?>" required disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="dst_name_point_en" class="form-label required">จุดบริการ (อังกฤษ)</label>
                            <input type="text" class="form-control" name="dst_name_point_en" id="dst_name_point_en" placeholder="จุดบริการ" value="<?php echo !empty($disease_time[0]['dst_name_point_en']) ? $disease_time[0]['dst_name_point_en'] : "" ;?>" required disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="dst_minute" class="form-label required">ระยะเวลาการรักษา</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                <input class="form-control" type="text" name="dst_minute" id="dst_minute" value="<?php echo !empty($disease_time[0]['dst_minute']) ? $disease_time[0]['dst_minute'] : "" ;?>" required disabled>
                                </div>
                                <div class="col-md-3">
                                <label for="dst_minute" class="form-label">นาที</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dst_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input " type="checkbox" name="dst_active" id="dst_active" <?php echo !empty($disease_time) && $disease_time[0]['dst_active'] == 1 ? "checked" : "" ;?> disabled>
                                <label for="dst_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_disease_time'">ย้อนกลับ</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('ds_name_point_en').addEventListener('input', function(event) {
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
        $('#disease_time_add').on('click', function() {
            // Populate hidden form field with Quill content


            var formData = $('#disease_time_form').serializeArray(); // Serialize form data

            $.ajax({
                url: '<?php echo base_url(); ?>index.php/wts/Base_disease_time/disease_time_insert',
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

    $(document).ready(function() {
        $('#disease_time_update').on('click', function() {
            // Populate hidden form field with Quill content
            var formData = $('#disease_time_form').serializeArray(); // Serialize form data
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/wts/Base_disease_time/disease_time_update',
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

    function dialog_error(options) {
        // Custom function to show error dialog
        alert(options.header + '\n' + options.body);
    }

    function dialog_success(options) {
        // Custom function to show success dialog
        alert(options.header + '\n' + options.body);
    }
</script>