<div class="card">
    <div class="accordion">
        <h2 class="accordion-header">
            <button class="accordion-button accordion-button-table">จัดการข้อมูลหัวเรื่องการอบรม</button>
        </h2>
        <div class="accordion-body">
            <div class="col-12 mb-3">
                <div class="row">
                    <div class="col-12">
                        <label for="StNameT" class="form-label required" style="font-weight: bold;">ชื่อหัวข้อ </label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="devh_info[]" id="devh_group_name" placeholder="กรอกหัวเรื่อง" value="<?= isset($develop_heading) ? $develop_heading->devh_group_name : '' ?>" class="form-control">
                    </div>
                    <div class="col-4">
                    </div>
                    <div class="col-4">
                        <label for="StNameT" class="form-label required" style="font-weight: bold;">หัวเรื่องการอบรม (ภาษาไทย)</label>
                    </div>
                    <div class="col-4">
                        <label for="StNameT" class="form-label required " style="font-weight: bold;">หัวเรื่องการอบรม (ภาษาอังกฤษ)</label>
                    </div>
                    <div class="col-4">

                    </div>
                    <div class="col-4">
                        <input type="text" name="devh_info[]" id="devh_name_th" data-devh-id="<?= isset($develop_heading) ?$develop_heading->devh_child[0]['devh_id'] : null?>" placeholder="กรอกหัวเรื่อง" value="<?= isset($develop_heading) ? $develop_heading->devh_child[0]['devh_name_th'] : '' ?>" class="form-control">
                        <div class="col-12 mb-3" id="additional_rounds_th">
                            <?php if ( isset($develop_heading) && count($develop_heading->devh_child) > 1) : ?>
                                <?php for ($i = 1; $i < $develop_heading->count_round; $i++) : ?>
                                    <div class="input-group mt-2" id="round_th_<?= $i + 1 ?>">
                                        <input type="text" name="inputField[]" data-devh-id='<?= $develop_heading->devh_child[$i]['devh_id'] ?>' value="<?= isset($develop_heading) ? $develop_heading->devh_child[$i]['devh_name_th'] : '' ?>" class="form-control">
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-4">
                        <input type="text" name="devh_info[]" id="devh_name_en"  data-devh-id="<?= isset($develop_heading) ?$develop_heading->devh_child[0]['devh_id'] :null?>" value="<?= isset($develop_heading) ? $develop_heading->devh_child[0]['devh_name_en'] : '' ?>" class="form-control">
                        <div class="col-12 mb-3" id="additional_rounds_en">
                            <?php if ( isset($develop_heading) && count($develop_heading->devh_child) > 1) : ?>
                                <?php for ($i = 1; $i < $develop_heading->count_round; $i++) : ?>
                                    <div class="input-group mt-2" id="round_en_<?= $i + 1 ?>">
                                        <input type="text" name="inputField[]" data-devh-id='<?= $develop_heading->devh_child[$i]['devh_id'] ?>' value="<?= isset($develop_heading) ? $develop_heading->devh_child[$i]['devh_name_en'] : '' ?>" class="form-control">
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="add_round_checkbox" <?= isset($develop_heading->count_round) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="add_round_checkbox">
                                เพิ่มรอบ
                            </label>
                        </div>
                        <div class="input-group mt-2" id="round_count_container" <?= isset($develop_heading->count_round) ? '' : 'style="display: none"'; ?>">
                            <input type="number" id="round_count" name="devh_info[]" placeholder="กรอกจำนวนรอบ" class="form-control" min="1" value="<?= isset($develop_heading->count_round) ? $develop_heading->count_round : '' ?>">
                            <span class="input-group-text">รอบ</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/develop/Develop_heading'">ย้อนกลับ</button>
                        <?php if (!isset($develop_heading)) : ?>
                            <button type="button" id="submit-button" onclick="submitAdd()" class="btn btn-success float-end">บันทึก</button>
                        <?php else : ?>
                            <button type="button" onclick="submitEdit(<?= $develop_heading->devh_gp_id ?>)" class="btn btn-success float-end">บันทึก</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Track the current number of rounds being displayed
        let currentRounds = parseInt($('#round_count').val()) || 1;

        // Initialize the rounds if the value is greater than or equal to 2
        if (currentRounds >= 2) {
            adjustRounds(currentRounds);
        }

        // Show or hide the round count input based on the checkbox state
        $('#add_round_checkbox').change(function() {
            if ($(this).is(':checked')) {
                $('#round_count_container').show(); // Show the input field for number of rounds
                if (parseInt($('#round_count').val()) >= 2) {
                    adjustRounds(parseInt($('#round_count').val()));
                }
            } else {
                $('#round_count_container').hide(); // Hide the field for number of rounds
                $('#additional_rounds_th').empty(); // Clear previously added rounds
                $('#additional_rounds_en').empty(); // Clear previously added rounds
                currentRounds = 1; // Reset the current rounds count
            }
        });

        // When there's a change in the "จำนวนรอบ" field
        $('#round_count').on('input', function() {
            const newValue = parseInt($(this).val());
            if (!isNaN(newValue) && newValue >= 2) {
                adjustRounds(newValue);
            } else if (newValue < 2) {
                // If the value is less than 2, clear all rounds and reset to the main topics only
                $('#additional_rounds_th').empty();
                $('#additional_rounds_en').empty();
                currentRounds = 1;
            }
        });

        // When there's a change in the topic fields
        $('#devh_name_th, #devh_name_en').on('input', function() {
            adjustRounds(parseInt($('#round_count').val()));
        });

        function adjustRounds(newRoundCount) {
            const baseTopicTh = $('#devh_name_th').val(); // Get the Thai topic
            const baseTopicEn = $('#devh_name_en').val(); // Get the English topic
            const containerTh = $('#additional_rounds_th');
            const containerEn = $('#additional_rounds_en');

            // If no topics are set, do not adjust rounds
            if (!baseTopicTh || !baseTopicEn) {
                return;
            }
            if (isNaN(currentRounds)) {
                currentRounds = 1;
            }
            // Add new rounds if the new count is greater than the current count
            if (newRoundCount > currentRounds) {
                for (let i = currentRounds + 1; i <= newRoundCount; i++) {
                    const newDivTH = `
                    <div class="input-group mt-2" id="round_th_${i}">
                        <input type="text" data-devh-id="null" name="inputField[]" class="form-control" value="${baseTopicTh} รอบ ${i}">
                    </div>`;
                    containerTh.append(newDivTH);

                    const newDivEn = `
                    <div class="input-group mt-2" id="round_en_${i}">
                        <input type="text" data-devh-id="null" name="inputField[]" class="form-control" value="${baseTopicEn} ${i}">
                    </div>`;
                    containerEn.append(newDivEn);
                }
            }
            // Remove rounds if the new count is less than the current count
            else if (newRoundCount < currentRounds) {
                for (let i = currentRounds; i > newRoundCount; i--) {
                    $(`#round_th_${i}`).remove();
                    $(`#round_en_${i}`).remove();
                }
            }

            // Update the current round count
            currentRounds = newRoundCount;
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($develop_heading)) : ?>
            const roundField = document.getElementById('round_count');

            // Get the initial value of the "รอบ" field when the page loads
            const currentRoundValue = parseInt(roundField.value, 10);

            // Listen for changes in the input field
            roundField.addEventListener('input', function() {
                const newValue = parseInt(roundField.value, 10);

                // Check if the new value is less than the current value
                if (!isNaN(newValue) && newValue < currentRoundValue) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'ไม่สามารถลดรอบการอบรมได้'
                    });
                    roundField.value = currentRoundValue; // Reset to the previous value
                    return;
                }
            });
        <?php endif; ?>
    });

    function submitAdd() {
        const develop_info = {
            devh_name_th_main: $('#devh_group_name').val(), // Main topic in Thai
            count_round: $('#round_count').val(),
            additional_rounds: [{
                round_number: 1,
                devh_name_th: $('#devh_name_th').val(), // Main topic in Thai
                devh_name_en: $('#devh_name_en').val()
            }]
        };
        // Collect additional rounds if they exist
        $('#additional_rounds_th .input-group').each(function(index) {
            const round_th = $(this).find('input').val(); // Thai round value
            const round_en = $(`#additional_rounds_en .input-group:eq(${index})`).find('input').val(); // English round value

            develop_info.additional_rounds.push({
                round_number: index + 2, // Round number starts from 2
                devh_name_th: round_th,
                devh_name_en: round_en
            });
        });

        // Validate required fields
        if (develop_info.devh_name_th_main === '' || develop_info.devh_name_en_main === '') {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return 0;
        }

        $.ajax({
            method: "post",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>insert_develop_heading',
            data: {
                develop_info: develop_info
            }
        }).done(function(data) {
            data = JSON.parse(data);
            if (data.data.status_response === 1) {
                dialog_success({
                    'header': text_toast_default_success_header,
                    'body': 'บันทึกข้อมูล'
                });
                setTimeout(function() {
                    window.location.href = '<?php echo site_url() ?>/hr/develop/Develop_heading';
                }, 1500);
            } else {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'บันทึกข้อมูลไม่สำเร็จ'
                });
            }
        });
    }

    function submitEdit(gp_id) {
        const develop_info = {
            devh_name_th_main: $('#devh_group_name').val(), // Main topic in Thai
            count_round: $('#round_count').val(),
            devh_gp_id : gp_id,
            additional_rounds: [{
                devh_id: $('#devh_name_th').data('devh-id'),
                round_number: 1,
                devh_name_th: $('#devh_name_th').val(), // Main topic in Thai
                devh_name_en: $('#devh_name_en').val()
            }]
        };
        // Collect additional rounds if they exist
        $('#additional_rounds_th .input-group').each(function(index) {
            const round_th = $(this).find('input').val(); // Thai round value
            const round_en = $(`#additional_rounds_en .input-group:eq(${index})`).find('input').val(); // English round value
            const devh_id =  $(this).find('input').data('devh-id');
            develop_info.additional_rounds.push({
                devh_id : devh_id,
                round_number: index + 2, // Round number starts from 2
                devh_name_th: round_th,
                devh_name_en: round_en
            });
        });
        if (develop_info['devh_name_th'] == '' || develop_info['devh_name_en'] == '') {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return 0;
        }
        $.ajax({
            method: "post",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>update_develop_heading',
            data: {
                develop_info: develop_info
            }
        }).done(function(data) {
            data = JSON.parse(data)
            if (data.data.status_response == 1) {
                dialog_success({
                    'header': text_toast_default_success_header,
                    'body': 'บันทึกข้อมูล'
                });
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            } else {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'บันทึกข้อมูลไม่สำเร็จ'
                });
            }
        })
    }
</script>