<?php 
    // get data group
        $pt_full_name = $exrs[0]['detail']['pt_full_name'];
        $pt_member = $exrs[0]['detail']['pt_member'];
        $rm_name = $exrs[0]['detail']['rm_name'];
        $eqs_name = $exrs[0]['detail']['eqs_name'];

    function render_file($files = []) {
        $html = '';

        if (empty($files)) {
            $html = '<div class="text-center">ไม่มีข้อมูล</div>';
        } else {
            foreach ($files as $file) {
                $name = htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8');
                $url = htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8');
                $type = htmlspecialchars($file['type'], ENT_QUOTES, 'UTF-8');
                
                // $html = '<div class="text-content">';
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
                // $html .= '<a href="' . $url . '" class="btn btn-primary mt-2 mb-2 float-end" target="_blank" title="คลิกปุ่มเพื่อดาวน์โหลดไฟล์"> ดาวน์โหลดไฟล์</a>';
                // $html .= '<br><br>';
                // $html = '</div>';
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

    .accordion-body {
        /* display: block;
        white-space: nowrap;
        overflow-x: auto; */
        display: flex;
        white-space: nowrap;
        overflow-x: auto;
    }
    /* .accordion-body .content-exr {
        display: inline-block;
        vertical-align: top;
        margin-right: 20px;
    } */
</style>

<div class="modal fade" id="modal-exr" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">
        <div class="modal-content" style="min-height: 100%">
            <div class="modal-header head-exr">
                <div class="row">
                    <div class="row">
                        <h5 class="col-md-12"><?php echo $eqs_name . " (" . $rm_name . ")"; ?></h5>
                        <div class="col-md-12">
                            <i class="bi-clipboard-plus font-20"></i>
                            <span class="font-label me-3"> ผู้ป่วย </span>
                            <span class="font-normal"> <?php echo "HN " . $pt_member . " " .  $pt_full_name; ?></span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" onclick="closeModal('#modal-exr', '#examination-result-doc')"></button>
            </div>
            <div class="modal-body">
                <div class="accordion">
                <?php 
                    foreach ($exrs as $index => $exr) {
                        if(isset($exr['detail']) && !empty($exr['detail'])) {
                            $detail = $exr['detail'];
                            $docs = [];
                ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="exr-<?php echo $index; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#exr-collapse-<?php echo $index; ?>" aria-expanded="false" aria-controls="exr-collapse-<?php echo $index; ?>">
                                        <div class="col-md-2"><span class="font-label me-3">Visit: </span><span class="font-normal"><?php echo $detail['apm_visit'] ;?></span></div>
                                        <div class="col-md-4"><span class="font-label me-3">วัน-เวลาที่สั่งตรวจ: </span><span class="font-normal"><?php echo convertToThaiYear($detail['exr_inspection_time']) ;?></span></div>
                                        <div class="col-md-6"><span class="font-label me-3">เจ้าหน้าที่ดำเนินการ: </span><span class="font-normal"><?php echo $detail['ps_full_name'] ;?></span></div>
                                    </button>
                                </h2>
                                <div id="exr-collapse-<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="exr-<?php echo $index; ?>" data-bs-parent="#accordionFlushExample" style="">
                                    <div class="accordion-body">
                                        <!-- <div class="content-exr"> -->
                                        <?php 
                                            foreach ($detail['exr_docs'] as $file) {
                                                // if($file['exr_id'] == $exam_result['exr_id'])
                                                    $docs[] = $file;
                                            } 
                                            echo render_file($docs);
                                        ?>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    }
                ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="w-10 btn btn-secondary" onclick="closeModal('#modal-exr', '#examination-result-doc')">ปิด</button>
                <div class="w-50">
                    <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="exr_eqs_id" id="exr_eqs_id" onchange="trigger_select_onchange_modal()">
                        <?php foreach ($exam_results as $row) { 
                            $selected = decrypt_id($row['exr_eqs_id']) == $exrs[0]['detail']['exr_eqs_id'] ? 'selected' : '';
                            ?>
                            <option value="<?php echo $row['exr_eqs_id']; ?>" data-pt-id="<?php echo $row['apm_pt_id']; ?>" data-stde-id="<?php echo $row['apm_stde_id']; ?>" data-ds-id="<?php echo $row['apm_ds_id']; ?>" <?php echo $selected; ?>>
                                <?php echo $row['rm_name'] . ': ' . $row['eqs_name']; ?>
                            </option>
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
        // Get the selected option
        var selectedOption = $('#exr_eqs_id option:selected');

        // Get the value of data attributes
        var exr_eqs_id = $('#exr_eqs_id').val();  // This gets the selected value
        var apm_pt_id = selectedOption.data('pt-id');
        var apm_stde_id = selectedOption.data('stde-id');
        var apm_ds_id = selectedOption.data('ds-id');

        console.log(exr_eqs_id, ' - ', apm_pt_id, ' - ', apm_stde_id, ' - ', apm_ds_id)
        if(!is_null(exr_eqs_id)) {
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
                url: "<?php echo site_url('/ams/Notification_result/Notification_result_get_all_docs_by_tool'); ?>/" + exr_eqs_id + '/' + apm_pt_id + '/' + apm_stde_id + '/' + apm_ds_id,
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