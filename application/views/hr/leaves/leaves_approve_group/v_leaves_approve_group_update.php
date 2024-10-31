<style>
#structure-container {
    /* max-width: 800px; */
    margin: 0 auto;
}

</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-ui-checks icon-menu"></i><span>แก้ไขข้อมูลเส้นทางอนุมัติการลา</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <form id="form_update_approve_group" class="row g-3 needs-validation">
                        <div class="col-md-12">
                            <label class="form-label required" for="lapg_name"><b>ชื่อเส้นทางอนุมัติการลา</b></label>
                            <textarea class="form-control" id="lapg_name" name="lapg_name" placeholder="ชื่อเส้นทางการอนุมัติ"></textarea>
                        </div>
                        <!-- ชื่อเส้นทางอนุมัติการลา -->

                        <div class="col-md-6">
                            <label for="lapg_type" class="form-label"><b>ประเภทกลุ่มเส้นทาง</b></label>
                            <p id="lapg_type_text"></p>
                            <input type="hidden" name="lapg_type" id="lapg_type">
                        </div>
                        <!-- ประเภทกลุ่มเส้นทาง -->

                        <div class="col-md-6" id="div_select_dp_id">
                            <label for="select_dp_id" class="form-label"><b>หน่วยงาน</b></label>
                            <p id="dp_text"></p>
                            <input type="hidden" name="select_dp_id" id="select_dp_id">
                        </div>
                        <!-- หน่วยงาน -->

                        <div class="col-md-6 mt-4" id="div_select_stuc">
                            <label for="select_stuc" class="form-label"><b>โครงสร้างหน่วยงาน</b></label>
                            <p id="stuc_text"></p>
                            <input type="hidden" name="select_stuc" id="select_stuc">
                        </div>
                        <!-- โครงสร้างหน่วยงาน -->

                        <div class="col-md-6 mt-4" id="div_select_stde">
                            <label for="select_stde" class="form-label"><b>โครงสร้างองค์กร</b></label>
                            <p id="stde_text"></p>
                            <input type="hidden" name="select_stde" id="select_stde">
                        </div>
                        <!-- โครงสร้างองค์กร -->

                        <div class="col-md-6" id="div_select_hire">
                            <label for="select_hire_is_medical" class="form-label"><b>สายปฏิบัติงาน</b></label>
                            <p id="hire_text"></p>
                            <input type="hidden" name="select_hire_is_medical" id="select_hire_is_medical">
                        </div>
                        <!-- สายปฏิบัติงาน -->

                        <div class="col-md-6" id="div_select_ps">
                            <label for="select_ps" class="form-label"><b>รายชื่อบุคลากร</b></label>
                            <p id="ps_text"></p>
                            <input type="hidden" name="select_ps" id="select_ps">
                        </div>
                        <!-- รายชื่อบุคลากร -->

                        <div class="col-md-12 mt-4">
                            <label class="form-label" for="lapg_desc"><b>รายละเอียดเพิ่มเติมหรือหมายเหตุ</b></label>
                            <textarea class="form-control" id="lapg_desc" name="lapg_desc" placeholder="รายละเอียดเพิ่มเติมหรือหมายเหตุ"></textarea>
                        </div>
                        <!-- รายละเอียดเพิ่มเติมหรือหมายเหตุ -->

                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lapg_active" name="lapg_active" value="Y" checked disabled>
                                <label class="form-check-label" for="lapg_active">
                                    สถานะการใช้งาน
                                </label>
                            </div>
                        </div>
                        <!-- สถานะการใช้งาน -->

                        <div class="mt-3 mb-3 col-md-12">
                            <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url()."/".$controller_dir; ?>" title="คลิกเพื่อย้อนกลับ" data-toggle="tooltip" data-placement="top">ย้อนกลับ</a>
                            <button type="button" class="btn btn-success float-end" onclick="submitApproveGroupDetails()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-placement="top">บันทึกข้อมูล</button>
                        </div>

                   </form>

                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-ui-checks icon-menu"></i><span>แก้ไขผู้อนุมัติการลา</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <form id="form_update_approve_group_detail" class="row g-3 needs-validation">
                        <div id="structure-container" class="container mt-4"></div>
                        <div id="approve-group-detail-container" class="container mt-4"></div>
                        <!-- <div class="col-12">
                            <button type="button" class="btn btn-primary" onclick="submitApproveGroupDetails()">Submit</button>
                        </div> -->
                   </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-ui-checks icon-menu"></i><span>แก้ไขผู้เข้าร่วมเส้นทางการอนุมัติ</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <form id="form_update_approve_group_person" class="row g-3 needs-validation">
                        <div id="approve-group-person-container" class="container mt-4"></div>
                   </form>
                </div>
                
            </div>
        </div>
    </div>
</div>



<script>
// Declare a global variable to hold the data
var globalData;

$(document).ready(function() {
    get_data_leave_approve_group_default();
    $('[data-toggle="tooltip"]').tooltip();
});

function get_data_leave_approve_group_default(){
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_leaves_approve_group_by_id',
        type: 'POST',
        data: {
            lapg_id : '<?php echo $lapg_id; ?>'
        },
        success: function(data) {
            // Parse the returned data
            data = JSON.parse(data);
            globalData = data;

            group_data = data.group[0];
            stuc_data = data.stuc;
            
            var type_text = "";

            $("#lapg_name").text(group_data.lapg_name);
            if(group_data.lapg_type == "stuc"){
                $("#div_select_dp_id").show();
                $("#div_select_stuc").show();
                $("#div_select_stde").show();
                $("#div_select_hire").hide();
                $("#div_select_ps").hide();
                $("#structure-container").show();
                $("#approve-group-detail-container").hide();
                type_text = "โครงสร้างองค์กร";
                $("#select_dp_id").val(stuc_data.dp_id);
                $("#dp_text").html(stuc_data.dp_name_th);

                $("#select_stuc").val(group_data.lapg_stuc_id);
                $("#stuc_text").html(`${stuc_data.stuc_confirm_date} ${stuc_data.stuc_status == 1 ? " (โครงสร้างปัจจุบัน)" : " (โครงสร้างเก่า)"}`);
                
                $("#stde_text").html(stuc_data.stde_name_th);
                $("#select_stde").val(group_data.lapg_parent_id);
                get_structure_leave_approve_group_detail();
            }
            else if(group_data.lapg_type == "hire"){
                $("#div_select_dp_id").hide();
                $("#div_select_stuc").hide();
                $("#div_select_stde").hide();
                $("#div_select_hire").show();
                $("#div_select_ps").hide();
                $("#structure-container").hide();
                $("#approve-group-detail-container").show();
                type_text = "สายปฏิบัติงาน";
                $("#hire_text").html(type_text);
                $("#select_hire_is_medical").val(group_data.lapg_parent_id);
                renderApproveGroupDetail();
                renderApproveGroupPerson();
            }
            else{
                $("#div_select_dp_id").hide();
                $("#div_select_stuc").hide();
                $("#div_select_stde").hide();
                $("#div_select_hire").hide();
                $("#div_select_ps").show();
                $("#structure-container").hide();
                $("#approve-group-detail-container").show();
                type_text = "เฉพาะบุคคล";
                $("#ps_text").html(type_text);
                $("#select_ps").val(group_data.lapg_parent_id);
                renderApproveGroupDetail();
                renderApproveGroupPerson();
            }
            $("#lapg_type").val(group_data.lapg_type);
            $("#lapg_type_text").html(type_text);
            $("#lapg_desc").text(group_data.lapg_desc);

            $('[data-toggle="tooltip"]').tooltip();

            const lapg_active_checkbox = document.getElementById("lapg_active");
            lapg_active_checkbox.checked = (group_data.lapg_active === "Y");

        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}

// Main function to generate table and add event listeners
function get_structure_leave_approve_group_detail() {
    
    $('#structure-container').empty();

    // Iterate over each stuc group
    globalData.detail.stuc.forEach(function(stucGroup, stucIndex) {
        var collage = `
            <div class="card mb-3">
                <div class="accordion" id="accordion-${stucIndex}-${stucGroup.stde_id}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-${stucIndex}-${stucGroup.stde_id}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${stucIndex}-${stucGroup.stde_id}" aria-expanded="true" aria-controls="collapse-${stucIndex}-${stucGroup.stde_id}">
                                ${stucGroup.stde_name_th}
                            </button>
                        </h2>
                        <div id="collapse-${stucIndex}-${stucGroup.stde_id}" class="accordion-collapse collapse show" aria-labelledby="heading-${stucIndex}-${stucGroup.stde_id}" data-bs-parent="#accordion-${stucIndex}-${stucGroup.stde_id}">
                            <div class="accordion-body">
                                <button type="button" onclick="add_row_ps_in_stuc(${stucIndex},${stucGroup.stde_id})" class="btn btn-primary btn-md mb-2" title="คลิกเพื่อเพิ่มผู้อนุมัติ" data-toggle="tooltip" data-placement="top">เพิ่มรายชื่อบุคลากร</button>
                                <table class="table table-striped table-bordered table-hover" id="table-${stucIndex}">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%">#</th>
                                            <th class="text-center" width="25%">ชื่อ</th>
                                            <th class="text-center" width="20%">ประเภทบุคลากร</th>
                                            <th class="text-center" width="20%">ตำแหน่งบริหารงาน</th>
                                            <th class="text-center" width="10%">สายงาน</th>
                                            <th class="text-center" width="15%">หน้าที่ผู้อนุมัติ</th>
                                            <th class="text-center" width="5%">ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                                    stucGroup.person_list.forEach(function(person, personIndex) {
                                        var selectOptions = globalData.select_person.map(selectPs => 
                                            `<option value="${selectPs.ps_id}" ${selectPs.ps_id === person.ps_id ? 'selected' : ''}>${selectPs.pf_name}${selectPs.ps_fname} ${selectPs.ps_lname}</option>`
                                        ).join('');

                                        var approveStatusOptions = globalData.select_leave_approve_status.map(status => 
                                            `<option value="${status.last_id}" ${status.last_id === person.lage_last_id ? 'selected' : ''}>${status.last_name}</option>`
                                        ).join('');

                                        collage += `
                                            <tr>
                                                <td class="text-center"></td>
                                                <td>
                                                    <select class="select2 select-structure-ps" id="select_structure_ps_${stucIndex}_${personIndex}" onchange="show_detail_structure_by_ps(this, '${stucIndex}_${personIndex}')">
                                                        ${selectOptions}
                                                    </select>
                                                </td>
                                                <td id="position_${stucIndex}_${personIndex}">${person.hire_name}</td>
                                                <td id="admin_position_${stucIndex}_${personIndex}">${person.admin_position || ""}</td>
                                                <td class="text-center" id="work_line_${stucIndex}_${personIndex}">${person.hire_is_medical_label}</td>
                                                <td class="text-center">
                                                    <select class="select2" id="select_approve_status_${stucIndex}_${personIndex}" onchange="updateHiddenInputs(this, '${stucIndex}_${personIndex}')">
                                                        ${approveStatusOptions}
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-md" onclick="deleteRow(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-placement="top">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <input type="hidden" id="select_stde_id_${stucIndex}_${personIndex}" value="${stucGroup.stde_id}">
                                                </td>
                                                <!-- Hidden inputs to store the sequence, ps_id, and approve_status -->
                                                <input type="hidden" name="sequence[]" id="sequence_${stucIndex}_${personIndex}" value="">
                                                <input type="hidden" name="ps_id[]" id="ps_id_${stucIndex}_${personIndex}" value="${person.ps_id}">
                                                <input type="hidden" name="stde_id[]" id="stde_id_${stucIndex}_${personIndex}" value="">
                                                <input type="hidden" name="approve_status[]" id="approve_status_${stucIndex}_${personIndex}" value="">
                                            </tr>`;
                                    });

                                    collage += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

        $('#structure-container').append(collage);

        // Initialize Select2 for each unique dropdown
        stucGroup.person_list.forEach(function(person, personIndex) {
            initializeSelect2(`#select_structure_ps_${stucIndex}_${personIndex}`);
            initializeSelect2(`#select_approve_status_${stucIndex}_${personIndex}`);
            updateHiddenInputs(`select_approve_status_${stucIndex}_${personIndex}`, `${stucIndex}_${personIndex}`);
            updateHiddenInputs(`select_structure_ps_${stucIndex}_${personIndex}`, `${stucIndex}_${personIndex}`);
            updateHiddenInputs(`stde_id_${stucIndex}_${personIndex}`, `${stucIndex}_${personIndex}`);
        });
    });

    reindexRows();
    renderApproveGroupDetail();
    addRowToApproveGroup();
    renderApproveGroupPerson();
    // addRowToApproveGroupPerson();
        
        
}

// Function to update hidden inputs when dropdown changes
function updateHiddenInputs(selectElement, rowIdentifier) {
    const personId = $(`#select_structure_ps_${rowIdentifier}`).val();
    const approveStatus = $(`#select_approve_status_${rowIdentifier}`).val();
    const stde_id = $(`#select_stde_id_${rowIdentifier}`).val();

    $(`#ps_id_${rowIdentifier}`).val(personId);
    $(`#approve_status_${rowIdentifier}`).val(approveStatus);
    $(`#stde_id_${rowIdentifier}`).val(stde_id);

    reindexRows();
    $('[data-toggle="tooltip"]').tooltip();
}

// Function to add a new row to the specified table
function add_row_ps_in_stuc(stucIndex, stde_id) {
    var table = $(`#table-${stucIndex} tbody`);
    var newRowIndex = table.find('tr').length;

    var selectOptions = globalData.select_person.map(person => 
        `<option value="${person.ps_id}">${person.pf_name}${person.ps_fname} ${person.ps_lname}</option>`
    ).join('');

    var approveStatusOptions = globalData.select_leave_approve_status.map(status => 
        `<option value="${status.last_id}">${status.last_name}</option>`
    ).join('');

    var newRow = `
        <tr>
            <td class="text-center"></td>
            <td>
                <select class="select2 select-structure-ps" id="select_structure_ps_${stucIndex}_${newRowIndex}" onchange="show_detail_structure_by_ps(this, '${stucIndex}_${newRowIndex}')">
                    ${selectOptions}
                </select>
            </td>
            <td id="position_${stucIndex}_${newRowIndex}"></td>
            <td id="admin_position_${stucIndex}_${newRowIndex}"></td>
            <td class="text-center" id="work_line_${stucIndex}_${newRowIndex}"></td>
            <td class="text-center">
                <select class="select2" id="select_approve_status_${stucIndex}_${newRowIndex}" onchange="updateHiddenInputs(this, '${stucIndex}_${newRowIndex}')">
                    ${approveStatusOptions}
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-md" onclick="deleteRow(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-placement="top">
                    <i class="bi bi-trash"></i>
                </button>
                <input type="hidden" id="select_stde_id_${stucIndex}_${newRowIndex}" value="${stde_id}">

            </td>
            <!-- Hidden inputs to store the sequence, ps_id, and approve_status -->
            <input type="hidden" name="sequence[]" id="sequence_${stucIndex}_${newRowIndex}" value="">
            <input type="hidden" name="ps_id[]" id="ps_id_${stucIndex}_${newRowIndex}" value="">
            <input type="hidden" name="stde_id[]" id="stde_id_${stucIndex}_${newRowIndex}" value="${stde_id}">
            <input type="hidden" name="approve_status[]" id="approve_status_${stucIndex}_${newRowIndex}" value="">
        </tr>`;
  
    table.append(newRow);


    initializeSelect2($(`#select_structure_ps_${stucIndex}_${newRowIndex}`));
    initializeSelect2($(`#select_approve_status_${stucIndex}_${newRowIndex}`));

    var selectElement = document.getElementById(`select_structure_ps_${stucIndex}_${newRowIndex}`);
    show_detail_structure_by_ps(selectElement, `${stucIndex}_${newRowIndex}`);

    $(`#stde_id_${stucIndex}_${newRowIndex}`).val(stde_id);

    reindexRows();
}

// Toggle function to show or hide selected person's details
function show_detail_structure_by_ps(selectElement, rowIdentifier) {
    // Get the selected person's ID from the dropdown
    var selectedPersonId = $(selectElement).val();
    
    // Find the selected person in globalData
    var selectedPerson = globalData.select_person.find(p => p.ps_id === selectedPersonId);

    updateHiddenInputs(selectElement, rowIdentifier);

    if (selectedPerson) {
        // Toggle display of selected person’s details in the row
        $(`#position_${rowIdentifier}`).text(selectedPerson.hire_name || '');
        $(`#admin_position_${rowIdentifier}`).html(selectedPerson.admin_position || '');
        $(`#work_line_${rowIdentifier}`).text(selectedPerson.hire_is_medical_label || '');
    }

}

// Function to delete a row and reindex the rows
function deleteRow(button) {
    $(button).closest('tr').remove();
    reindexRows();
}

// Function to reindex the # column sequentially and update sequence inputs
function reindexRows() {
    let index = 1;

    $('#structure-container table tbody').each(function() {
        $(this).find('tr').each(function() {
            $(this).find('td').eq(0).text(index); // Update the # column
            $(this).find('input[name="sequence[]"]').val(index); // Update hidden sequence input
            index++;
        });
    });
}

// Function to render a single table in approve-group-detail-container
function renderApproveGroupDetail() {
    $('#approve-group-detail-container').empty(); // Clear any existing content

    const table = `
            <button type="button" onclick="addRowToApproveGroup()" class="btn btn-primary btn-md mb-2" title="คลิกเพื่อเพิ่มผู้อนุมัติ" data-toggle="tooltip" data-placement="top">เพิ่มรายชื่อบุคลากร</button>
            <table class="table table-striped table-bordered table-hover" id="approve-group-table">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">#</th>
                        <th class="text-center" width="25%">ชื่อ</th>
                        <th class="text-center" width="20%">ประเภทบุคลากร</th>
                        <th class="text-center" width="20%">ตำแหน่งบริหารงาน</th>
                        <th class="text-center" width="10%">สายงาน</th>
                        <th class="text-center" width="15%">หน้าที่ผู้อนุมัติ</th>
                        <th class="text-center" width="5%">ลบ</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        `;

    $('#approve-group-detail-container').append(table);

    if(globalData.group[0].lapg_type != "stuc"){
        // Populate rows using globalData.detail
        globalData.detail.forEach((detail, index) => {
            addRowToApproveGroup(index, detail);
        });
    }



    // Initialize Select2 on all dropdowns
    reindexApproveGroupRows();
}

// Function to add a row in approve-group-table with optional data
function addRowToApproveGroup(rowIndex, detail = null) {
    const tableBody = $('#approve-group-table tbody');
    const newRowIndex = rowIndex !== undefined ? rowIndex : tableBody.find('tr').length;

    const selectOptions = globalData.select_person.map(person => 
        `<option value="${person.ps_id}" ${detail && detail.lage_ps_id === person.ps_id ? 'selected' : ''}>${person.pf_name}${person.ps_fname} ${person.ps_lname}</option>`
    ).join('');

    const approveStatusOptions = globalData.select_leave_approve_status.map(status => 
        `<option value="${status.last_id}" ${detail && detail.lage_last_id === status.last_id ? 'selected' : ''}>${status.last_name}</option>`
    ).join('');

    const newRow = `
        <tr>
            <td class="text-center">${detail ? detail.lage_seq : ''}</td>
            <td>
                <select class="select2 select-approve-group-ps" id="approve_group_select_structure_ps_${newRowIndex}" onchange="updateApproveGroupRowDetails(this, '${newRowIndex}')">
                    ${selectOptions}
                </select>
            </td>
            <td id="approve_group_position_${newRowIndex}"></td>
            <td id="approve_group_admin_position_${newRowIndex}"></td>
            <td class="text-center" id="approve_group_work_line_${newRowIndex}"></td>
            <td class="text-center">
                <select class="select2" id="approve_group_select_approve_status_${newRowIndex}" onchange="updateApproveGroupRowDetails(this, '${newRowIndex}')">
                    ${approveStatusOptions}
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-md" onclick="deleteApproveGroupRow(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-placement="top">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
            <!-- Hidden inputs to store sequence, ps_id, and approve_status -->
            <input type="hidden" name="approve_group_sequence[]" id="approve_group_sequence_${newRowIndex}" value="${detail ? detail.lage_seq : ''}">
            <input type="hidden" name="approve_group_ps_id[]" id="approve_group_ps_id_${newRowIndex}" value="${detail ? detail.lage_ps_id : ''}">
            <input type="hidden" name="approve_group_approve_status[]" id="approve_group_approve_status_${newRowIndex}" value="${detail ? detail.lage_last_id : ''}">
        </tr>`;

    tableBody.append(newRow);

    // Initialize Select2 for the new row's dropdowns
    initializeSelect2($(`#approve_group_select_structure_ps_${newRowIndex}`));
    initializeSelect2($(`#approve_group_select_approve_status_${newRowIndex}`));

    // Update row details for new row if data is provided
    updateApproveGroupRowDetails(document.getElementById(`approve_group_select_structure_ps_${newRowIndex}`), newRowIndex);

    // Reindex the rows after adding a new row
    reindexApproveGroupRows();
}

// Function to update row details in approve-group-table
function updateApproveGroupRowDetails(selectElement, rowIndex) {
    const selectedPersonId = $(selectElement).val();
    const selectedPerson = globalData.select_person.find(p => p.ps_id === selectedPersonId);

    $(`#approve_group_ps_id_${rowIndex}`).val(selectedPersonId);
    $(`#approve_group_approve_status_${rowIndex}`).val($(`#approve_group_select_approve_status_${rowIndex}`).val());
    $('[data-toggle="tooltip"]').tooltip();

    if (selectedPerson) {
        $(`#approve_group_position_${rowIndex}`).text(selectedPerson.hire_name || '');
        $(`#approve_group_admin_position_${rowIndex}`).html(selectedPerson.admin_position || '');
        $(`#approve_group_work_line_${rowIndex}`).text(selectedPerson.hire_is_medical_label || '');
    }
}

// Function to delete a row from approve-group-table
function deleteApproveGroupRow(button) {
    $(button).closest('tr').remove();
    reindexApproveGroupRows();
}

// Function to reindex the # column sequentially for approve-group-table
function reindexApproveGroupRows() {
    let index = 1;
    $('#approve-group-table tbody tr').each(function() {
        $(this).find('td').eq(0).text(index); // Update the # column
        $(this).find('input[name="approve_group_sequence[]"]').val(index); // Update hidden sequence input
        index++;
    });
}

// Function to render a single table in approve-group-person-container
function renderApproveGroupPerson() {
    $('#approve-group-person-container').empty(); // Clear any existing content

    // Begin table structure
    const tableHeader = `
        <button type="button" onclick="addRowToApproveGroupPerson()" class="btn btn-primary btn-md mb-2" title="คลิกเพื่อผู้เข้าร่วม" data-toggle="tooltip" data-placement="top">เพิ่มรายชื่อบุคลากร</button>
        <table class="table table-striped table-bordered table-hover" id="approve-group-person-table">
            <thead>
                <tr>
                    <th class="text-center" width="5%">#</th>
                    <th class="text-center" width="30%">ชื่อ</th>
                    <th class="text-center" width="30%">ประเภทบุคลากร</th>
                    <th class="text-center" width="25%">ตำแหน่งบริหารงาน</th>
                    <th class="text-center" width="15%">สายงาน</th>
                    <th class="text-center" width="5%">ลบ</th>
                </tr>
            </thead>
            <tbody>`;

    // Generate rows for each person in globalData.group_person
    const tableRows = globalData.group_person.map((person, index) => {

        const selectOptions = globalData.select_person.map(option =>
            `<option value="${option.ps_id}" ${option.ps_id === person.ps_id ? 'selected' : ''}>
                ${option.pf_name}${option.ps_fname} ${option.ps_lname}
             </option>`
        ).join('');

        return `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td>
                    <select class="select2 select-approve-group-person-ps" 
                            id="approve_group_person_select_structure_ps_${index}" 
                            onchange="updateApproveGroupPersonRowDetails(this, '${index}')">
                        ${selectOptions}
                    </select>
                </td>
                <td id="approve_group_person_position_${index}">${person.hire_name || ''}</td>
                <td id="approve_group_person_admin_position_${index}">${person.admin_position || ''}</td>
                <td class="text-center" id="approve_group_person_work_line_${index}">${person.hire_is_medical_label}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-md" onclick="deleteApproveGroupPersonRow(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-placement="top">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
                <input type="hidden" name="approve_group_person_ps_id[]" id="approve_group_person_ps_id_${index}" value="${person.ps_id}">
            </tr>`;
    }).join('');

    // Close table structure
    const tableFooter = `</tbody></table>`;

    // Append the full table structure to the container
    $('#approve-group-person-container').append(tableHeader + tableRows + tableFooter);

    // Initialize Select2 for each generated dropdown
    globalData.group_person.forEach((_, index) => {
        initializeSelect2(`#approve_group_person_select_structure_ps_${index}`);
    });

    reindexApproveGroupPersonRows(); // Reindex the rows after rendering
}


// Function to add a row in approve-group-person-table
function addRowToApproveGroupPerson() {
    const tableBody = $('#approve-group-person-table tbody');
    const newRowIndex = tableBody.find('tr').length;

    const selectOptions = globalData.select_person.map(person => 
        `<option value="${person.ps_id}">${person.pf_name}${person.ps_fname} ${person.ps_lname}</option>`
    ).join('');

    const newRow = `
        <tr>
            <td class="text-center"></td>
            <td>
                <select class="select2 select-approve-group-person-ps" id="approve_group_person_select_structure_ps_${newRowIndex}" onchange="updateApproveGroupPersonRowDetails(this, '${newRowIndex}')">
                    ${selectOptions}
                </select>
            </td>
            <td id="approve_group_person_position_${newRowIndex}"></td>
            <td id="approve_group_person_admin_position_${newRowIndex}"></td>
            <td class="text-center" id="approve_group_person_work_line_${newRowIndex}"></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-md" onclick="deleteApproveGroupPersonRow(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-placement="top">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
            <!-- Hidden inputs to store ps_id -->
            <input type="hidden" name="approve_group_person_ps_id[]" id="approve_group_person_ps_id_${newRowIndex}" value="">
        </tr>`;
    
    tableBody.append(newRow);

    // Initialize Select2 for the new row's dropdown
    initializeSelect2(`#approve_group_person_select_structure_ps_${newRowIndex}`);

    // Call the function to show details for the first selected person by default
    const selectElement = document.getElementById(`approve_group_person_select_structure_ps_${newRowIndex}`);
    updateApproveGroupPersonRowDetails(selectElement, newRowIndex);

    // Reindex the rows after adding a new row
    reindexApproveGroupPersonRows();
}

// Function to update row details in approve-group-person-table
function updateApproveGroupPersonRowDetails(selectElement, rowIndex) {
    const selectedPersonId = $(selectElement).val();
    const selectedPerson = globalData.select_person.find(p => p.ps_id === selectedPersonId);

    $(`#approve_group_person_ps_id_${rowIndex}`).val(selectedPersonId);
    $('[data-toggle="tooltip"]').tooltip();

    if (selectedPerson) {
        $(`#approve_group_person_position_${rowIndex}`).text(selectedPerson.hire_name || '');
        $(`#approve_group_person_admin_position_${rowIndex}`).html(selectedPerson.admin_position || '');
        $(`#approve_group_person_work_line_${rowIndex}`).text(selectedPerson.hire_is_medical_label || '');
    }
}

// Function to delete a row from approve-group-person-table
function deleteApproveGroupPersonRow(button) {
    $(button).closest('tr').remove();
    reindexApproveGroupPersonRows();
}

// Function to reindex the # column sequentially for approve-group-person-table
function reindexApproveGroupPersonRows() {
    let index = 1;
    $('#approve-group-person-table tbody tr').each(function() {
        $(this).find('td').eq(0).text(index); // Update the # column
        index++;
    });
}

// Function to gather data from the form
function submitApproveGroupDetails() {
    // Initialize form data object
    const leave_approve_group_form = {
        approve_group: {
            id: '<?php echo $lapg_id; ?>',
            name: $("#lapg_name").val(),
            type: $("#lapg_type").val(),
            description: $("#lapg_desc").val(),
            active: null,
            parent_id: null,
            stuc_id: null
        },
        details: [],
        persons: [] // To store data from approve-group-person-container
    };

    const lapg_type = leave_approve_group_form.approve_group.type;

    // Validation flag
    let isValid = true;

    // Validate lapg_name
    if (!leave_approve_group_form.approve_group.name) {
        $("#lapg_name").removeClass("is-valid").addClass("is-invalid").siblings('.invalid-feedback').show();
        isValid = false;
    } else {
        $("#lapg_name").removeClass("is-invalid").addClass("is-valid").siblings('.invalid-feedback').hide();
    }

    // Validate lapg_type (for select2)
    if (lapg_type === "-1" || !lapg_type) {
        $("#lapg_type").siblings('.select2-container').find('.select2-selection')
            .removeClass("is-valid").addClass("is-invalid");
        $("#lapg_type").siblings('.invalid-feedback').show();
        isValid = false;
    } else {
        $("#lapg_type").siblings('.select2-container').find('.select2-selection')
            .removeClass("is-invalid").addClass("is-valid");
        $("#lapg_type").siblings('.invalid-feedback').hide();
    }

    // Validate select_dp_id, select_stuc, and select_stde if lapg_type is "stuc"
    if (lapg_type === "stuc") {
        leave_approve_group_form.approve_group.parent_id = $("#select_stde").val();
        leave_approve_group_form.approve_group.stuc_id = $("#select_stuc").val();

        // Validate select_dp_id (for select2)
        if (!$("#select_dp_id").val()) {
            $("#select_dp_id").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-valid").addClass("is-invalid");
            $("#select_dp_id").siblings('.invalid-feedback').show();
            isValid = false;
        } else {
            $("#select_dp_id").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-invalid").addClass("is-valid");
            $("#select_dp_id").siblings('.invalid-feedback').hide();
        }

        // Validate select_stuc (for select2)
        if (!leave_approve_group_form.approve_group.parent_id) {
            $("#select_stuc").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-valid").addClass("is-invalid");
            $("#select_stuc").siblings('.invalid-feedback').show();
            isValid = false;
        } else {
            $("#select_stuc").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-invalid").addClass("is-valid");
            $("#select_stuc").siblings('.invalid-feedback').hide();
        }

        // Validate select_stde (for select2)
        if (!leave_approve_group_form.approve_group.stuc_id) {
            $("#select_stde").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-valid").addClass("is-invalid");
            $("#select_stde").siblings('.invalid-feedback').show();
            isValid = false;
        } else {
            $("#select_stde").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-invalid").addClass("is-valid");
            $("#select_stde").siblings('.invalid-feedback').hide();
        }

    } else if (lapg_type === "hire") {
        leave_approve_group_form.approve_group.parent_id = $("#select_hire_is_medical").val();

        if (!leave_approve_group_form.approve_group.parent_id) {
            $("#select_hire_is_medical").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-valid").addClass("is-invalid");
            $("#select_hire_is_medical").siblings('.invalid-feedback').show();
            isValid = false;
        } else {
            $("#select_hire_is_medical").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-invalid").addClass("is-valid");
            $("#select_hire_is_medical").siblings('.invalid-feedback').hide();
        }

    } else if (lapg_type === "ps") {
        leave_approve_group_form.approve_group.parent_id = $("#select_ps").val();

        if (!leave_approve_group_form.approve_group.parent_id) {
            $("#select_ps").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-valid").addClass("is-invalid");
            $("#select_ps").siblings('.invalid-feedback').show();
            isValid = false;
        } else {
            $("#select_ps").siblings('.select2-container').find('.select2-selection')
                .removeClass("is-invalid").addClass("is-valid");
            $("#select_ps").siblings('.invalid-feedback').hide();
        }
    }

    // Stop submission if validation fails
    if (!isValid) {
        $("#form_update_approve_group").addClass("was-validated");
        return;
    }

    // Collect approve group details based on type
    if (lapg_type === "stuc") {
        // Iterate over each row in all tables within structure-container
        $('#structure-container table tbody').each(function() {
            $(this).find('tr').each(function() {
                const detail = {
                    seq: $(this).find('input[name="sequence[]"]').val(),
                    ps_id: $(this).find('input[name="ps_id[]"]').val(),
                    stde_id: $(this).find('input[name="stde_id[]"]').val(),
                    status: $(this).find('input[name="approve_status[]"]').val()
                };
                leave_approve_group_form.details.push(detail);
            });
        });

    } else {
        // For other types, gather details from approve-group-detail-container
        $('#approve-group-detail-container table tbody').each(function() {
            $(this).find('tr').each(function() {
                const detail = {
                    seq: $(this).find('input[name="approve_group_sequence[]"]').val(),
                    ps_id: $(this).find('input[name="approve_group_ps_id[]"]').val(),
                    stde_id: "",
                    status: $(this).find('input[name="approve_group_approve_status[]"]').val()
                };
                leave_approve_group_form.details.push(detail);
            });
        });
    }

    // Collect data for approve group persons
    $('#approve-group-person-container table tbody').each(function() {
        $(this).find('tr').each(function() {
            const person = {
                ps_id: $(this).find('input[name="approve_group_person_ps_id[]"]').val()
            };
            leave_approve_group_form.persons.push(person);
        });
    });

    const lapg_active_checkbox = document.getElementById("lapg_active");
    // Define the initial active status in `leave_approve_group_form`
    leave_approve_group_form.approve_group.active = lapg_active_checkbox.checked ? "Y" : "N";

    // Log the collected data or submit as needed
    // console.log('Collected Data:', leave_approve_group_form);

    // Submit form data via AJAX
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>save_leave_approve_group',
        type: 'POST',
        data: { leave_approve_group_form },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status_response == status_response_success) {
                dialog_success({'header': text_toast_save_success_header, 'body': data.message_dialog}, data.return_url, false);
            } else if (data.status_response == status_response_error) {
                dialog_error({'header':text_toast_default_error_header, 'body': data.message_dialog});
            } 
        },
        error: function(xhr, status, error) {
            dialog_error({'header': text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
}






</script>