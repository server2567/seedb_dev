คำนำหน้า *<style>
    .color-check:checked {
        background-color: #28a745;
        /* สีเขียว */
        border-color: #28a745;
        /* สีเขียว */
    }

    .color-check:focus {
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        /* เงาเมื่อโฟกัส */
    }

    .color-check {
        background-color: #fff;
        /* สีแดง */
        border-color: #51585e;
        /* สีแดง */
    }

    .sortable-chosen {
        background: #f0f0f0;
    }


    /* Add this CSS rule to change cursor to pointer */
    #person_list tbody tr {
        cursor: pointer;
    }

    .row-selected {
        border-color: red !important;
    }
</style>
<div class="accordion">
    <div class="accordion-item mb-2">
        <h2 class="accordion-header">
            <button class="accordion-button accordion-button-table" type="button">
                <i class="bi bi-list-ol"></i>&nbsp;&nbsp;&nbsp;<span>เพิ่มประเภทการเรียงลำดับข้อมูลบุคลากร<?= $hire_is_medical ?></span><span class="summary_person badge bg-success"></span>
            </button>
        </h2>
        <div id="collapseShow" class="accordion-collapse collapse show">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-3 col-md-3">
                        <label for="">หน่วยงาน:</label>
                        <input name="ordt_info[]" disabled id="ordt_dp_id" type="text" value="<?= $dp_name->dp_name_th ?>" data-value="<?= $dp_name->dp_id ?>" class="form-control">
                    </div>
                    <div class="col-3 col-md-3">
                        <label for="">ชื่อระบบ:<span style="color:red;"> *</span></label>
                        <select class="form-select select2" id="ordt_menu_id" name="ordt_info[]">
                            <option value="" selected disabled> กรุณาระบุชื่อระบบ</option>
                            <?php foreach ($mn_option as $key => $value) : ?>
                                <optgroup label="<?= $value->st_name_th ?>">
                                    <?php foreach ($value->mn_name as $key => $mn): ?>
                                        <option value="<?= $mn['mn_id'] ?>" <?=$ordt_info[0]->ordt_menu_id == $mn['mn_id'] ? 'selected' :'' ?>><?= $mn['mn_name_th'] ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="col-6 col-md-6">
                        <label for="">ชื่อประเภทการเรียงข้อมูล:<span style="color:red;"> *</span></label>
                        <input name="ordt_info[]" type="text" id="ordt_name" value="<?= !empty($ordt_info) ? $ordt_info[0]->ordt_name : '' ?>" placeholder="กรุณากรอกชื่อประเภทการจัดเรียงข้อมูล" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="">ประเภทปี:<span style="color:red;"> *</span></label>
                        <select id="ordt_type_year" name="ordt_info[]" class="form-control select2">
                            <option value="">--เลือกปี--</option>
                            <!-- JavaScript will populate the years here -->
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">ปีพุทธศักราช:<span style="color:red;"> *</span></label>
                        <select id="ordt_year" name="ordt_info[]" class="form-control select2">
                            <option value="">--เลือกปี--</option>
                            <!-- JavaScript will populate the years here -->
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">สถานะการใช้งาน: </label> <br>
                        <input name="ordt_info[]" id="ordt_active" type="checkbox" <?= isset($ordt_info) ? ($ordt_info[0]->ordt_active == 1 ? 'checked' : '') : 'checked disabled' ?> class="form-check-input" style="margin-left: 20px;"><span>ใช้งาน</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="p-2 col-md-12 mb-2" style="background-color:#cfe2ff">
                        <i class="bi-people icon-menu"></i>ตารางแสดงการจัดเรียงข้อมูลบุคลากร<?= $hire_is_medical ?>
                    </div>
                    <div class="col-md-8"></div>
                    <div class="col-md-2 text-end">คัดลอกรูปแบบการจัดเรียง:</div>
                    <div class="col-md-2">
                        <select name="" onchange="change_order_data()" class="form-select" id="change_order" title="คัดลอกข้อมูลจากประเภทที่มีอยู่">
                            <option value="<?= !empty($ordt_info[0]) ? $ordt_info[0]->ordt_id : '' ?>" selected>กำหนดเอง</option>
                            <?php if (isset($ordt_option)) : ?>
                                <?php foreach ($ordt_option as $key => $value) { ?>
                                    <option value="<?= $value->ordt_id ?>"><?= $value->ordt_name ?></option>
                                <?php } ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div style=" overflow-y: auto; max-height: 600px;">
                    <table id="person_list" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">ชื่อ-นามสกุล</th>
                                <th class="text-center">ประเภทบุคลากร</th>
                                <th class="text-center">ตำแหน่งในการบริหาร</th>
                                <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                <th class="text-center">ตำแหน่งงานเฉพาะทาง</th>
                                <th class="text-center">วุฒิการศึกษา (วุฒิสูงสุด)</th>
                                <th class="text-center" width="8%">สถานะการแสดงผล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ord_info)) : ?>
                                <?php foreach ($ord_info as $key => $item) : ?>
                                    <tr name="ordt_info[]" data-value="<?= $item->ps_id ?>">
                                        <td>
                                            <div class="text-center"><?php echo $key + 1; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo  $item->pf_name . ' ' . $item->ps_fname . ' ' . $item->ps_lname ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->alp_name != null ? $item->hire_name : '-' ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start">
                                                <ul><?php if ($item->admin_name != null) {
                                                        foreach ($item->admin_position as $key => $value) {
                                                            echo    '<li>' . $value . '</li>';
                                                        }
                                                    } else {
                                                        echo '-';
                                                    } ?><ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->alp_name != null ? $item->alp_name : '-' ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start">
                                                <ul><?php if ($item->spcl_name != null) {
                                                        foreach ($item->spcl_position as $key => $value) {
                                                            echo    '<li>' . $value . '</li>';
                                                        }
                                                    } else {
                                                        echo '-';
                                                    } ?><ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-start"><?php echo $item->edulv_name != null ? $item->edulv_name : '-' ?></div>
                                        </td>
                                        <td>
                                            <div class="text-end form-switch float-start">
                                                <input class="form-check-input color-check" <?= isset($item->ord_active) ? ($item->ord_active != '1' ? '' : 'checked') : 'checked' ?> type="checkbox" id="flexSwitchCheckDefault">
                                            </div>
                                            <div id="swap-button" class="float-end">
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <td colspan="7">
                                    <div class="text-center">ไม่มีรายการในระบบ</div>
                                </td>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xl-4">
                        <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/order_person'">ย้อนกลับ</button>
                    </div>
                    <div class="col-md-8 col-xl-8">
                        <button type="button" onclick="submitButton()" class="btn btn-success float-end">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    var formData = {}
    var valuesArray = [];
    var tlbody = document.getElementById('person_list').getElementsByTagName('tbody')[0]
    // document.addEventListener("DOMContentLoaded", function() {
    //     const tbody = document.getElementById('person_list').querySelector('tbody');
    //     const rowCount = tbody.querySelectorAll('tr').length;

    //     if (rowCount > 1) {
    //         new Sortable(tbody, {
    //             animation: 150,
    //             ghostClass: 'sortable-ghost',
    //             chosenClass: 'sortable-chosen',
    //             onEnd: function(evt) {
    //                 updateRowNumbers();
    //             }
    //         });
    //     }
    // });

    function updateRowNumbers() {
        const rows = document.querySelectorAll('#person_list tbody tr');
        rows.forEach((row, index) => {
            row.querySelector('td:first-child div').textContent = index + 1;
        });
    }


    function swapRows() {
        var table = document.getElementById('person_list');
        var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        var selectedRows = [];

        // เก็บแถวที่เลือกไว้
        for (var i = 0; i < rows.length; i++) {
            if (rows[i].classList.contains('row-selected')) {
                selectedRows.push(rows[i]);
            }
        }

        // ตรวจสอบว่ามีแถวที่เลือกไว้เพียงสองแถวหรือไม่
        if (selectedRows.length !== 2) {
            dialog_error({
                'header': 'ดำเนินการไม่สำเร็จ',
                'body': 'กรุณาเลือก 2 คนที่ต้องการสลับ'
            });
            return;
        }
        // สลับแถว
        var parent = rows[0].parentNode;
        var firstRow = selectedRows[0];
        var secondRow = selectedRows[1];

        // ทำการสลับตำแหน่ง
        if (firstRow.nextSibling === secondRow) {
            parent.insertBefore(secondRow, firstRow);
        } else if (secondRow.nextSibling === firstRow) {
            parent.insertBefore(firstRow, secondRow);
        } else {
            var firstNextSibling = firstRow.nextSibling;
            var secondNextSibling = secondRow.nextSibling;

            parent.insertBefore(firstRow, secondNextSibling);
            parent.insertBefore(secondRow, firstNextSibling);
        }
        updateRowNumbers();
        var selectedRows = table.querySelectorAll('.row-selected');
        selectedRows.forEach(function(row) {
            // หา div ที่มี id เป็น swap-button ในแถวนี้
            var swapButtonDiv = row.querySelector('#swap-button');
            if (swapButtonDiv) {
                // ลบเนื้อหาภายใน div ที่มี id เป็น swap-button
                swapButtonDiv.innerHTML = '';
            }
            row.classList.remove('row-selected');
        });
    }
    // เพิ่ม event listener เมื่อคลิกที่แถวในตาราง
    $(document).ready(function() {
        addRowClickEvent();
        addYearOption('ordt_type_year')
        addYearOption('ordt_year')
    });

    function addYearOption(id) {
        const select = document.getElementById(id);
        const currentYear = new Date().getFullYear() + 543; // Convert current Gregorian year to Buddhist Era
        const startYear = currentYear - 10; // Starting year in Buddhist Era
        const endYear = currentYear; // Ending year in Buddhist Era

        for (let year = endYear; year >= startYear; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            select.appendChild(option);
        }
    }

    function addRowClickEvent() {
        $('#person_list tbody').off('click', 'tr');
        $('#person_list tbody').on('click', 'tr', function(event) {
            var table = $('#person_list tbody');
            var selectedRows = table.find('.row-selected');
            if (event.target.type === 'checkbox' || $(event.target).hasClass('swap-btn')) {
                return; // ไม่ทำอะไรถ้าคลิกที่ checkbox
            }

            if (selectedRows.length == 2 && !$(this).hasClass('row-selected')) {
                dialog_error({
                    'header': 'ดำเนินการไม่สำเร็จ',
                    'body': 'เลือกบุคลากรได้สูงสุด 2 คน'
                });
                return 0;
            } else {
                if ($(this).hasClass('row-selected')) {
                    selectedRows.each(function() {
                        var swapButtonDiv = $(this).find('#swap-button');
                        if (swapButtonDiv.length) {
                            swapButtonDiv.empty();
                        }
                    });
                    $(this).removeClass('row-selected');
                } else {
                    if (selectedRows.length == 1) {
                        var swapButtonDiv = $(this).find('#swap-button');
                        if (swapButtonDiv.length) {
                            var swapButton = $('<button>', {
                                class: 'btn btn-info swap-btn',
                                html: '<i class="bi bi-arrow-left-right"></i>'
                            });
                            swapButton.on('click', swapRows);
                            swapButtonDiv.append(swapButton);
                        }
                    }
                    $(this).addClass('row-selected');
                }
            }
            // เพิ่มปุ่มใน div swap-button ในแถวที่ถูกเลือกเป็นอันที่ 2 (หากมีอยู่)
        });
    }

    function submitButton() {
        $('input[name="ordt_info[]"]').each(function() {
            if ($(this).attr('id') === 'ordt_dp_id') {
                formData[$(this).attr('id')] = $(this).data('value');
            } else {
                formData[$(this).attr('id')] = $(this).val();
            }
            if ($(this).attr('id') === 'ordt_active') {
                formData[$(this).attr('id')] = $(this).is(':checked') ? 1 : 0
            }
        });
        $('select[name="ordt_info[]"]').each(function() { // Get the ID of the select element
            formData[$(this).attr('id')] =  $(this).val();
        });

        if (!formData.ordt_name || !formData.ordt_menu_id || !formData.ordt_type_year || !formData.ordt_year) {
            !formData.ordt_name ? $('#ordt_name').get(0).focus() : '';
            dialog_error({
                'header': 'เพิ่มข้อมูลไม่สำเร็จ',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return 0;
        }
        // ดึงค่าจาก tr พร้อมลำดับของตาราง
        $('tr[name="ordt_info[]"]').each(function(index) {
            var dataValue = $(this).data('value');
            var id = $(this).attr('id');
            var checkboxStatus = $(this).find('input[type="checkbox"]').is(':checked') ? 1 : 0;
            valuesArray.push({
                index: index + 1,
                ps_id: dataValue,
                checkboxStatus: checkboxStatus
            });
        });
        formData['person'] = valuesArray
        <?php if (!empty($ordt_info[0]->ordt_id)) { ?>
            formData['ordt_id'] = '<?= $ordt_info[0]->ordt_id ?>'
            $.ajax({
                url: '<?php echo site_url() . '/' . $controller . 'order_person_update'; ?>',
                method: 'POST',
                data: formData // ใช้ Object formData ที่สร้างขึ้น
            }).done(function(returnedData) {
                dialog_success({
                    'header': '',
                    'body': 'แก้ไขข้อมูลสำเร็จ'
                });
            })
        <?php } else { ?>
            $.ajax({
                url: '<?php echo site_url() . '/' . $controller . 'order_person_insert'; ?>',
                method: 'POST',
                data: formData // ใช้ Object formData ที่สร้างขึ้น
            }).done(function(returnedData) {
                dialog_success({
                    'header': '',
                    'body': 'เพิ่มข้อมูลสำเร็จ'
                });
                setInterval(function() {
                    window.location.href = '<?php echo base_url() ?>index.php/hr/profile/Order_person/'
                }, 1000);
            })
        <?php } ?>
    }

    function change_order_data() {
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'get_order_person_data'; ?>',
            method: 'POST',
            data: {
                id: $('#change_order').val() != '' ? $('#change_order').val() : -1,
                dp_id: $('#ordt_dp_id').data('value')
            } // ใช้ Object formData ที่สร้างขึ้น
        }).done(function(returnedData) {
            $('#person_list tbody').empty();
            var data = JSON.parse(returnedData)
            if (data.order_person.length > 0) {
                data.order_person.forEach(function(item, index) {
                    var admin_name_ul = ``
                    var spcl_name_ul = ``
                    item.admin_position.forEach(element => {
                        var li = `<li> ${element} </li>`
                        admin_name_ul += li
                    });
                    if (admin_name_ul == ``) {
                        admin_name_ul = '-'
                    }
                    var admin_name_group = `<ul> ${admin_name_ul} </ul>`
                    item.spcl_position.forEach(element => {
                        var li = `<li> ${element} </li>`
                        spcl_name_ul += li
                    });
                    if (spcl_name_ul == ``) {
                        spcl_name_ul = '-'
                    }
                    var spcl_name_group = `<ul> ${spcl_name_ul} </ul>`
                    var rowHtml = `
<tr name="ordt_info[]" id="${item.ps_id}" data-value="${item.ps_id}">
    <td>
        <div class="text-center">${index + 1}</div>
    </td>
    <td>
        <div class="text-start">${item.pf_name} ${item.ps_fname} ${item.ps_lname}</div>
    </td>
    <td>
        <div class="text-start">${item.hire_name ? item.hire_name : '-'}</div>
    </td>
    <td>
        <div class="text-start">${item.admin_position ? admin_name_group : '-'}</div>
    </td>
    <td>
        <div class="text-start">${item.alp_name ? item.alp_name : '-'}</div>
    </td>
    <td>
        <div class="text-start">${item.spcl_position ? spcl_name_group: '-'}</div>
    </td>
    <td>
        <div class="text-start">${item.edulv_name ? item.edulv_name : '-'}</div>
    </td>
   <td>
        <div class="text-end form-switch float-start">
                <input class="form-check-input color-check" ${item.ord_active=='1' ? 'checked' : '2' } type="checkbox" id="flexSwitchCheckDefault">
        </div>
        <div id="swap-button" class="float-end"> 
        </div>
    </td>
</tr>
`;
                    $('#person_list tbody').append(rowHtml);
                })
                addRowClickEvent();
            } else {
                var rowHtml = `<tr> <td colspan="7">
                                    <div class="text-center">ไม่มีรายการในระบบ</div>
                                </td> </tr>`
                $('#person_list tbody').append(rowHtml);
            }
        })
    }
</script>