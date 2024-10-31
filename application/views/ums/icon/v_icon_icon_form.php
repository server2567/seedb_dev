<?php
    $check_edit = !empty($edit) && !empty($image) && !empty($edit['ic_type']);
?>

<style>
    .card-body img {
        width: 60px;
    }
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($ic_id) ? 'แก้ไข' : 'เพิ่ม' ?>ไอคอนรูปภาพ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url()."index.php/ums/Icon/"; ?><?php echo !empty($ic_id) ? "icon_update/".$ic_id : "icon_insert"; ?>" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <label for="ic_name" class="form-label required">ชื่อไอคอน</label>
                            <input type="text" class="form-control" name="ic_name" id="ic_name" placeholder="" value="<?php echo !empty($edit) ? $edit['ic_name'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ic_type" class="form-label required">ระบุชนิดไอคอน</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกชนิดไอคอน --" name="ic_type" id="ic_type" required>
                                <option value=""></option>
                                <option value="header" <?php echo !empty($edit) && $edit['ic_type'] == 'header' ? 'selected' : '' ;?>>Hearder</option>
                                <option value="gear" <?php echo !empty($edit) && $edit['ic_type'] == 'gear' ? 'selected' : '' ;?>>Gear</option>
                                <option value="system" <?php echo !empty($edit) && $edit['ic_type'] == 'system' ? 'selected' : '' ;?>>System</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ic_file_id" class="form-label required">File</label>
                            <!-- update -->
                            <?php if ($check_edit) { ?>
                                <input type="file" class="form-control input-bs-file" data-url="<?php echo base_url()."index.php/ums/GetFile?type=".$edit['ic_type']."&image=".$image;?>" name="ic_file_id" id="ic_file_id" onchange="displaySelectedImage(event, 'selected-image')" required />
                                <div class="d-flex justify-content-center">
                                    <img id="selected-image" class="" src="<?php echo base_url()."index.php/ums/GetFile?type=".$edit['ic_type']."&image=".$image;?>" style="width: 300px;" />
                                </div>
                            <!-- insert -->
                            <?php } else { ?>
                                <input type="file" class="form-control input-bs-file" name="ic_file_id" id="ic_file_id" onchange="displaySelectedImage(event, 'selected-image')" required />
                                <div class="d-flex justify-content-center">
                                    <img id="selected-image" class="d-none" src="" style="width: 300px;" />
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Icon'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function displaySelectedImage(event, elementId) {
        const selected_image = document.getElementById(elementId);
        const fileInput = event.target;

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            const file = fileInput.files[0];

            reader.onload = function(e) {
                selected_image.value = file.name;
                selected_image.src = e.target.result;
                selected_image.classList.remove('d-none');
            } 

            reader.readAsDataURL(fileInput.files[0]);
        } else {
            selected_image.value = ''; // Clear the input value
            
            // Manually trigger the change event to handle the UI update
            const event = new Event('change');
            selected_image.dispatchEvent(event);

            // selected_image.src = e.target.result;
            selected_image.classList.add('d-none');
        }
    }
    
    // document.addEventListener("DOMContentLoaded", function(event) {
        
    // });
</script>