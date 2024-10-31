<?php 
    function render_file($files = []) {
        $html = '';

        if (empty($files)) {
            $html = '<div class="text-center">ไม่มีข้อมูล</div>';
        } else {
            foreach ($files as $file) {
                $name = htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8');
                $url = htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8');
                $type = htmlspecialchars($file['type'], ENT_QUOTES, 'UTF-8');
                
                if (strpos($type, 'image/') === 0) { // image
                    $html .= '<img src="' . $url . '" class="img-fluid" alt="' . $name . '">';
                } else if ($type === 'application/pdf') {
                    $html .= '<iframe src="' . $url . '" width="100%" height="600px"></iframe>';
                } else if (strpos($type, 'video/') === 0) {
                    $html .= '<video width="100%" height="100%" controls>
                                <source src="' . $url . '" type="' . $type . '">
                                Your browser does not support the video tag or the file format of this video.
                            </video>';
                } else {
                    $html .= '<p>' . $name . '</p><a href="' . $url . '" target="_blank">Open File</a>';
                }
                $html .= '<br>';
                $html .= '<a href="' . $url . '" class="btn btn-primary mt-2 mb-2 float-end" target="_blank" title="คลิกปุ่มเพื่อดาวน์โหลดไฟล์"> ดาวน์โหลดไฟล์</a>';
                $html .= '<br><br>';
            }
        }
        
        return $html;
    }
?>

<style>
    .head-exr, .head-exr:not(.collapsed) {
        color: var(--tp-font-color);
        background-color: #f6f9ff;
    }
    .head-exr .font-normal {
        font-weight: normal;
    }
    .head-exr .font-label {
        font-weight: bold;
    }
    .head-exr h5 {
        font-weight: bold;
    }
    .modal-footer {
        display: flex;
        justify-content: space-between;
    }
</style>

<div class="modal fade" id="modal-exr" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header head-exr">
                <!-- <h5 class="modal-title" id="modal-toolsLabel">ผลตรวจ<?php echo $exam_result['eqs_name']; ?></h5> -->
                <div class="row">
                    <div class="row">
                        <h5 class="col-md-6"><?php echo $exam_result['eqs_name'] . " (" . $exam_result['rm_name'] . ")"; ?></h5>
                        <div class="col-md-6">
                            <i class="bi-clipboard-plus font-20"></i>
                            <span class="font-label me-3"> ผู้ป่วย </span>
                            <span class="font-normal"> <?php echo "HN " . $exam_result['pt_member'] . " " .  $exam_result['pt_full_name']; ?></span>
                        </div>
                        <div class="col-md-6">
                            <i class="bi-calendar-check font-20"></i>
                            <span class="font-label me-3"> วัน-เวลาที่สั่งตรวจ </span>
                            <span class="font-normal"> <?php echo convertToThaiYear($exam_result['exr_inspection_time'], true); ?></span>
                        </div>
                        <div class="col-md-6">
                            <i class="bi-person font-20"></i>
                            <span class="font-label me-3"> เจ้าหน้าที่ดำเนินการ </span>
                            <span class="font-normal"> <?php echo $exam_result['ps_full_name']; ?></span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" onclick="closeModal('#modal-exr', '#examination-result-doc')"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                <?php 
                    $docs = [];
                    foreach ($exr_docs as $file) {
                        if($file['exr_id'] == $exam_result['exr_id'])
                            $docs[] = $file;
                    } 
                    echo render_file($docs);
                ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="w-10 btn btn-secondary" onclick="closeModal('#modal-exr', '#examination-result-doc')">ปิด</button>
                <div class="w-50">
                    <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="exr_id" id="exr_id" onchange="trigger_select_onchange_modal()">
                        <?php foreach ($exam_results as $row) { 
                            $selected = decrypt_id($row['exr_id']) == $exam_result['exr_id'] ? 'selected' : '';
                            ?>
                            <option value="<?php echo $row['exr_id']; ?>" <?php echo $selected; ?>><?php echo $row['rm_name'] . ': ' . $row['eqs_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        <?php //if($is_officer) { ?>
            $('#modal-exr').modal({
                backdrop: 'static',
                keyboard: false
            });
        <?php //} ?>

        $('#modal-exr').modal('show');
        $('#modal-load').modal('hide');
        
        // Reinitialize select2 for new elements
        $(`#exr_id`).select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: false,
        });
    });
    
    function closeModal(selector, content) {
        $(selector).modal('hide');
        $(content).empty();
    }

    function trigger_select_onchange_modal() {
        // Get the selected value from the select element
        var exr_id = $('#exr_id').val();

        if(!is_null(exr_id)) {
            $('#modal-exr').modal('hide');
            $('#examination-result-doc').html('');

            // Show the modal with the loading spinner
            $('#modal-load').modal('show');
            $('#modal-content-loading').html(`
                <div class="center-container">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`);

            // Make the AJAX request with the selected value
            $.ajax({
                url: "<?php echo site_url('/ams/Notification_result/Notification_result_get_docs'); ?>/" + exr_id,
                method: "GET",
                success: function(data) {
                    // Replace the content of #examination-result-doc with the new data
                    $('#examination-result-doc').html(data);
                    // Hide the modal after loading is complete
                    $('#modal-load').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('AJAX error:', textStatus, errorThrown);
                    // Hide the modal if there's an error
                    $('#modal-load').modal('hide');
                }
            });
        }
    }
</script>