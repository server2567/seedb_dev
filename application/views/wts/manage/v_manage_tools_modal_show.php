<div class="modal-header">
    <h5 class="modal-title" id="modal-toolsLabel">จัดการเครื่องมือหัตถการ</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="btn-option mb-3">
        <button type="button" class="btn btn-primary" onclick="add_row_tool()"><i class="bi-plus"></i> เพิ่มเครื่องมือหัตถการ</button>
    </div>
    <form id="updateform">
        <input name="ddt_stde_id" value="<?php echo isset($ddt_stde_id) ? $ddt_stde_id : ''; ?>" type="hidden">
        <input name="ddt_ds_id" value="<?php echo isset($ddt_ds_id) ? $ddt_ds_id : ''; ?>" type="hidden">
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th width="15%" class="text-center">#</th>
                    <th width="35%">ห้องปฏิบัติการ</th>
                    <th width="35%" class="text-center">เครื่องมือหัตถการ</th>
                    <th width="15%" class="text-center">ดำเนินการ</th>
                </tr>
            </thead>
            <tbody id="dynamic-elements">
                <?php if(empty($tools)) { ?>
                    <tr class="no_row_tool">
                        <td class="text-center" colspan="4">ไม่มีรายการข้อมูล</td>
                    </tr>
                <?php } else { 
                    $i=0;
                    foreach ($tools as $row) {
                ?>
                <tr class="data_row_tool">
                    <input name="ddt_id[]" value="<?php echo $row['ddt_id']; ?>" type="hidden">
                    <td class="text-center"><?php echo $i+1; ?></td>
                    <td>
                        <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="rm_id[]" id="rm_id_<?php echo $i; ?>" onchange="trigger_select_onchange('rm_id_<?php echo $i; ?>')">
                            <option value=""></option>
                            <?php foreach ($rooms as $rm) { 
					            $selected = decrypt_id($rm['rm_id']) == decrypt_id($row['eqs_rm_id']) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $rm['rm_id']; ?>" <?php echo $selected; ?>><?php echo $rm['rm_name']; ?></option>
                            <?php } ?>
                        </select>
                        <input name="rm_id_name[]" value="rm_id_<?php echo $i; ?>" type="hidden">
                    </td>
                    <td>
                        <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="eqs_id[]" id="eqs_id_<?php echo $i; ?>">
                            <option value=""></option>
                            <?php foreach ($equipments as $eqs) { 
                                if(decrypt_id($eqs['eqs_rm_id']) == decrypt_id($row['eqs_rm_id']) && $eqs['eqs_fmst_id'] == 12) { // ประเภทเครื่องมือหัตถการ
					                $selected = decrypt_id($eqs['eqs_id']) == decrypt_id($row['ddt_eqs_id']) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $eqs['eqs_id']; ?>" <?php echo $selected; ?>><?php echo $eqs['eqs_name']; ?></option>
                            <?php }} ?>
                        </select>
                        <input name="eqs_id_name[]" value="eqs_id_<?php echo $i; ?>" type="hidden">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger removeElement"><i class="bi-x"></i></button>
                    </td>
                </tr>
                <?php $i++; }} ?>
            </tbody>
        </table>
    </form>
</div>
<div class="modal-footer">
    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
    <button type="button" class="btn btn-success" onclick="save_data()" data-dismiss="modal">บันทึกข้อมูล</button>
</div>

<script>
    // let tools = <?php //echo !empty($tools) ? json_encode($tools) : '[]'; ?>;

    $(document).ready(function() {
        index_tools = <?php echo !empty($tools) ? count($tools) : 0; ?>;
        order_tools = <?php echo !empty($tools) ? count($tools) : 0; ?>;

        // Reinitialize select2 for new elements
        $(`.select2`).select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,
        });
        // add div invalid-feedback for alert validate
        let div = document.createElement("div");
        div.classList.add('invalid-feedback')
        div.append(text_invalid_default);
        let element1 = document.querySelector(`.select2`).nextElementSibling.closest('.select2-container');
        element1.insertAdjacentElement('afterend', div);

        // Remove element functionality
        $('#dynamic-elements').on('click', '.removeElement', function() {
            $(this).closest('tr').remove();

            order_tools = 0;
            if ($('#dynamic-elements .data_row_tool').length == 0) {
                no_row_tool();
            } else {
                $('#dynamic-elements .data_row_tool').each(function(index) {
                    $(this).find('td').first().text(index + 1);
                    order_tools++;
                });
            }
        });
    });

    function no_row_tool() {
        let newElement = `
        <tr class="no_row_tool">
            <td class="text-center" colspan="4">ไม่มีรายการข้อมูล</td>
        </tr>`;

        $('#dynamic-elements').append(newElement);
    }

    function add_row_tool() {
        if ($('.no_row_tool').length) 
            $('.no_row_tool').remove();

        index_tools++;
        order_tools++;
        let btn = `     <button type="button" class="btn btn-danger removeElement"><i class="bi-x"></i></button>`;
        let newElement = `
        <tr class="data_row_tool">
            <input name="ddt_id[]" value="" type="hidden">
            <td class="text-center">${order_tools}</td>
            <td>
                <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="rm_id[]" id="rm_id_${index_tools}" onchange="trigger_select_onchange('rm_id_${index_tools}')">
                    <option value=""></option>
                    <?php foreach ($rooms as $row) { ?>
                        <option value="<?php echo $row['rm_id']; ?>"><?php echo $row['rm_name']; ?></option>
                    <?php } ?>
                </select>
                <input name="rm_id_name[]" value="rm_id_${index_tools}" type="hidden">
            </td>
            <td>
                <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="eqs_id[]" id="eqs_id_${index_tools}" disabled>
                    <option value=""></option>
                </select>
                <input name="eqs_id_name[]" value="eqs_id_${index_tools}" type="hidden">
            </td>
            <td class="text-center">${btn}</td>
        </tr>`;

        $('#dynamic-elements').append(newElement);

        // Reinitialize select2 for new elements
        $(`#rm_id_${index_tools}, #eqs_id_${index_tools}`).select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,
        });

        // add div invalid-feedback for alert validate
        let div = document.createElement("div");
        div.classList.add('invalid-feedback')
        div.append(text_invalid_default);
        let element1 = document.querySelector(`#rm_id_${index_tools}`).nextElementSibling.closest('.select2-container');
        let element2 = document.querySelector(`#eqs_id_${index_tools}`).nextElementSibling.closest('.select2-container');
        element1.insertAdjacentElement('afterend', div);
        element2.insertAdjacentElement('afterend', div);
    }

    function trigger_select_onchange(rm_id) {
        let eqs_id_index = "eqs_id_" + rm_id.split('rm_id_')[1];
        clear_select_eqs_id("#" + eqs_id_index);
        let url = "<?php echo base_url() ?>index.php/dim/Import_examination_result/Import_examination_result_get_equipments"
        get_select_onchange(rm_id, eqs_id_index, "rm_id", url);
    }

    function clear_select_eqs_id(selector) {
        if (!$(selector).prop('disabled')) $(selector).val(null).trigger('change');
    }

    function get_select_onchange(select2Id, targetId, objName, url) {
        let select2Value = $('#' + select2Id).val();
        let target = $('#' + targetId);
        let data = {};
        data[objName] = select2Value;

        if (!is_null(select2Value)) {
            $.post(url, data)
                .done(function(responseData) {
                    target.empty();
                    target.prop('disabled', false);
                    target.html(responseData);
                })
                .fail(function() {
                    console.error("Error occurred");
                })
                .always(function() {
                    // Optional: Code to execute always after request finishes
                });
        } else {
            target.val(null);
            target.prop('disabled', true);
        }

    }

    function save_data() {
        const url = '<?php echo base_url()."index.php/wts/Manage_tool/Manage_tool_update"; ?>';
        const formData = getFormData();
        let form = document.getElementById('updateform');

        if (form.checkValidity()) {
            clear_input_invalid();
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json', // Expect JSON from the server
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.data.status_response == status_response_success) {
                        dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, data.data.returnUrl, false);
                    } else if (data.data.status_response == status_response_error) {
                        if (!is_null(data.data.error_inputs)) {
                          setInvalidInput(data.data.error_inputs);
                        }

                        if (!is_null(data.data.message_dialog))
                            dialog_error({ 'header': text_toast_save_error_header, 'body': data.data.message_dialog });
                        else
                            dialog_error({ 'header': text_toast_save_error_header, 'body': text_toast_save_error_body });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let errorMessage = jqXHR.responseText || textStatus + ' - ' + errorThrown;
                    try {
                        // Parse the JSON error message
                        let jsonError = JSON.parse(errorMessage);
                        errorMessage = jsonError.message || errorMessage;
                    } catch (e) {
                        // If not JSON, use original message
                    }
                    dialog_error({
                        'header': 'AJAX Error',
                        'body': errorMessage
                    });
                }
            });
        }
        form.classList.add('was-validated')
    }

    // submit form
    function getFormData() {
        const formData = new FormData();
        const formElements = document.getElementById('updateform').elements;
        for (let i = 0; i < formElements.length; i++) {
            const element = formElements[i];
            if (element.name && element.type !== 'file') {
                formData.append(element.name, element.value);
            }
        }
        return formData;
    }
</script>