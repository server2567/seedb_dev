<!-- เลือกแผนก -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi bi-info-circle-fill icon-menu"></i><span>ข้อมูล<?php echo !empty($route[0]['rdp_id']) ? $route[0]['rdp_name'] : 'เส้นทางการรักษา' ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" id="route_form">
                        <input type="hidden" class="form-control" name="rdp_id" id="rdp_id"  value="<?php echo !empty($route[0]['rdp_id']) ? $route[0]['rdp_id'] : "" ?>" >
                        <div class="row g-2">
                        <div class="col-md-6">
                            <label for="rdp_stde_id" class="form-label">แผนกการรักษา</label>
                            <select class="form-select select2" name="rdp_stde_id" id="rdp_stde_id" data-placeholder="-- กรุณาเลือกแผนกการรักษา --">
                                    <option value=""></option>
                                    <?php if (isset($stde)) { ?>
                                        <?php foreach ($stde as $dep) : ?>
                                            <option value="<?php echo $dep->stde_id ?>" data-name="<?php echo $dep->stde_name_th ?>" <?php echo (isset($route[0]['rdp_stde_id']) && $dep->stde_id == $route[0]['rdp_stde_id']) ? 'selected' : ''; ?>
                                            >
                                                <?php echo $dep->stde_name_th ?>
                                            </option>
                                        <?php endforeach ?>
                                    <?php } ?>
                                </select>  
                        </div>
                        <div class="col-md-6">
                            <label for="rdp_ds_id" class="form-label">ประเภทโรค</label>
                            <select class="form-select select2" name="rdp_ds_id" id="rdp_ds_id" data-placeholder="-- กรุณาเลือกประเภทโรค --">
                                    <option value=""></option>
                                    <?php if (isset($ds_type)) { ?>
                                        <?php foreach ($ds_type as $ds) : ?>
                                            <option value="<?php echo $ds->ds_id ?>" data-name="<?php echo $ds->ds_name_disease_type ?>" <?php echo (isset($route[0]['rdp_ds_id']) && $ds->ds_id == $route[0]['rdp_ds_id']) ? 'selected' : ''; ?>
                                            >
                                                <?php echo $ds->ds_name_disease_type ?>
                                            </option>
                                        <?php endforeach ?>
                                    <?php } ?>
                                </select>  
                        </div>

                            <div class="col-md-6">
                                <label for="rdp_name" class="form-label required">ชื่อเส้นทาง</label>
                                <input type="text" class="form-control" name="rdp_name" id="rdp_name" placeholder="ชื่อเส้นทาง" value="<?php echo !empty($route[0]['rdp_name']) ? $route[0]['rdp_name'] : "" ;?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="rdp_active" class="form-label">สถานะ</label>
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" name="rdp_active" id="rdp_active" <?php echo !empty($route) && $route[0]['rdp_active'] == 1 ? "checked" : "" ;?>>
                                    <label for="rdp_active" class="form-check-label">เปิดใช้งาน</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_sickness_path'">ย้อนกลับ</button>
                                <?php if (isset($route) && !empty($route[0]['rdp_id'])) { ?>
                                    <button type="submit" class="btn btn-success float-end" id="route_update">บันทึก</button>
                                <?php } else { ?>
                                    <button type="submit" class="btn btn-success float-end" id="route_add">บันทึก</button>
                                <?php } ?>
                                <!-- <button type="submit" class="btn btn-success float-end" id="route_add">บันทึก</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#route_add').on('click', function() {
            var formData = $('#route_form').serializeArray(); // Serialize form data
            let url = '<?php echo base_url(); ?>index.php/wts/Base_sickness_path/route_insert';
            save_ajax(url, "route_form", formData); // from main.js
        });
        $('#route_update').on('click', function() {
            var formData = $('#route_form').serializeArray(); // Serialize form data
            let url = '<?php echo base_url(); ?>index.php/wts/Base_sickness_path/route_update';
            save_ajax(url, "route_form", formData); // from main.js
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
