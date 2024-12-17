<!-- <div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($stuc_info) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลโครงสร้าง</span>
                </button>
            </h2>
            <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อโครงสร้าง (ภาษาไทย)</label>
                            <input type="text" class="form-control" name="StNameT" id="StNameT" placeholder="ชื่อโครงสร้างภาษาไทย" value="<?php echo !empty($std_info) ? $std_info->dp_name_th : ""; ?>" required disabled>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อโครงสร้าง (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="StAbbrT" id="StAbbrT" placeholder="ชื่อโครงสร้างภาษาอังกฤษ" value="<?php echo !empty($std_info) ? $std_info->dp_name_en : ""; ?>" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
<style>
    .bi-filter-square-fill {
        cursor: pointer;
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'><path stroke='%23ffffff' stroke-width='2' fill='none' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important;
        background-size: 1rem 1rem;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><?php echo !empty($stuc_info) ? 'แก้ไข' : 'เพิ่ม' ?><span>โครงสร้าง<?php echo !empty($std_info) ? $std_info->dp_name_th : ""; ?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <?php if (empty($stuc_info)) { ?>
                            <button id="addorg" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="bi-plus"></i> สร้างโครงสร้างลำดับที่ 1
                            </button>
                        <?php } ?>
                    </div>
                    <div class="col-12">
                        <div id="tableContainer" class="table-responsive tableContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">เพิ่มโครงสร้างหน่วยงานลำดับที่ 1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12">
                            ชื่อ<span id="thIndex">หน่วยงานลำดับที่ 1</span> (ภาษาไทย) : <span style="color:red">*</span>
                        </div>
                        <div class="col-12">
                            <input id="nameTH" class="form-control" placeholder="เช่น ผู้อำนวยการรพ. ฝ่ายเทคนิคการแพทย์ หรือแผนกจักษุแพทย์">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            ชื่อ<span id="engIndex">หน่วยงานลำดับที่ 1</span> (ภาษาอังกฤษ) :
                        </div>
                        <div class="col-12">
                            <input id="nameEN" class="form-control" placeholder="Ex. Deputy Director">
                        </div>
                    </div>
                    <label>รายละเอียด<span id="detailIndex">หน่วยงานลำดับที่ 1</span></label><textarea id="detail" class="form-control" placeholder="เช่น รองผู้อำนวยการโรงพยาบาลทำหน้าที่ช่วยเหลือและสนับสนุนการทำงานของผู้อำนวยการโรงพยาบาลในด้านการบริหารจัดการและการปฏิบัติงานทั่วไป"></textarea>
                    <div class="row">
                        <div class="col-12">
                            สายงาน : <span style="color:red">*</span>
                        </div>
                        <div class="col-12">
                            <input name="ismedicalOption" value="Y" id="ismedical" type="radio" class="form-check-input" placeholder="ชื่อโครงสร้างภาษาอังกฤษ">
                            <label for="">สายการแพทย์</label><br>
                            <input name="ismedicalOption" value="N" id="ismedical3" type="radio" class="form-check-input" placeholder="ชื่อโครงสร้างภาษาอังกฤษ">
                            <label for="">สายพยาบาล</label><br>
                            <input name="ismedicalOption" value="S" id="ismedical2" type="radio" class="form-check-input" placeholder="ชื่อโครงสร้างภาษาอังกฤษ">
                            <label for="">สายสนับสนุน</label><br>
                            <input name="ismedicalOption" value="SM" id="ismedical3" type="radio" class="form-check-input" placeholder="ชื่อโครงสร้างภาษาอังกฤษ">
                            <label for="">สายสนับสนุนทางการแพทย์</label><br>
                            <input name="ismedicalOption" value="T" id="ismedical3" type="radio" class="form-check-input" placeholder="ชื่อโครงสร้างภาษาอังกฤษ">
                            <label for="">สายเทคนิคและบริการ</label><br>
                            <input name="ismedicalOption" value="A" id="ismedical3" type="radio" class="form-check-input" placeholder="ชื่อโครงสร้างภาษาอังกฤษ">
                            <label for="">สายบริหาร</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                <button id="addButton " type="button" class="btn btn-success" onclick="Addnstitution(true,$('#nameTH').val(),$('#nameEN').val(),$('#detail').val(),'','','<?= isset($stuc_info) ? $stuc_info->stuc_id : null ?>')">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<?php $index = 0; ?>
<div class="modal fade" id="addPersonModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addpermodal">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="text" id="personIndex" hidden>
                    <div class="col-4">
                        ชื่อบุคลากร :
                    </div>
                    <div class="col-8 mb-2">
                        <div id="person">
                            <select id="person_opt" class="form-control select2" onchange="Personpostion(<?= isset($std_info) ? $std_info->dp_id : null ?>,$('#person_opt').val())" placeholder="เลือกบุคคล">
                                <option value="0" disabled selected>เลือกบุคลากร</option>
                                <?php if (isset($ps_info)) : ?>
                                    <?php foreach ($ps_info as $value) : ?>
                                        <option value="<?= $value->ps_id ?>"><?= $value->pf_name_abbr ?> <?= $value->ps_fname . ' ' . $value->ps_lname ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="stuc_position" class="row">
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="admin_position" class="row"></div>
                    </div>
                    <div class="col-12">
                        <div id="adline_position" class="row"></div>
                    </div>
                    <div class="col-12">
                        <div id="special_position" class="row"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                <div id="submitPerson">
                    <button id="addPerson" name="newAdd" type="button" class="btn btn-success" onclick="addPerson($('#person_opt').val(),$('#person_opt option:selected').text(),$('#stdp_po_id').val(),$('#admin_position').val(),$('#adline_position').val(),$('#special_position').val())">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ums/Sortable/Sortable.min.js"></script>
<script>
    var index1 = '1';
    var index2 = '1';
    var index3 = '';
    var secretaryIndex = '1';
    var last_id = null;
    var paname = '';
    var method = 0;
    var parent = 0;
    var index4 = 0;
    var sindex = 0;
    var select = null;
    var process = '<?= $process ?>'
    var tindex = [];
    var cls = 'Level1'
    let count = 0;
    var color = ['#00386B', '#6689CC', '#C4D3DD', '#D6D6D8']
    var Tcolor = ['white', 'white', 'black', 'black']
    var insertLevel = ['หน่วยงานลำดับที่ 1', 'หน่วยงานลำดับที่ 2', 'ฝ่าย', 'แผนก']
    var is_medical_array = {
        'Y': 'สายการแพทย์',
        'N': 'สายพยาบาล',
        'S': 'สายสนับสนุน',
        'SM': 'สายสนับสนุนทางการแพทย์',
        'T': 'สายเทคนิคและบริการ',
        'A': 'สายบริหาร'
    }
    var is_medical_text = ''
    var previousOrder = {};
    $(document).ready(function() {
        if (process == 'edit') {
            $.ajax({
                url: '<?php echo site_url() . '/' . $controller . 'structure_org/get_stucture_detail'; ?>',
                method: 'POST',
                data: {
                    id: `<?= isset($stuc_info) ? $stuc_info->stuc_id : -1 ?>`
                }
            }).done(function(returnedData) {
                var data = JSON.parse(returnedData)
                let post_data = [];
                data.forEach(element => {
                    let parts = element.stde_seq.split('.');
                    if (parts.length > 1) {
                        parts.pop(); // ตัดส่วนสุดท้ายออกถ้ามีจุด
                        var level = parts.join('.')
                    } else {
                        var level = null
                    }
                    Select(level)
                    is_medical_text = element.stde_is_medical
                    Addnstitution(null, element.stde_name_th, element.stde_name_en, element.stde_desc, element.stde_is_medical, element.stde_id, null, element.stde_seq)
                    post_data.push({
                        id: element.stde_id,
                        seq: element.stde_seq.replaceAll('.', '-')
                    });
                });

                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'structure_org/get_stuc_person_by_detail'; ?>',
                    method: 'POST',
                    data: {
                        id: post_data,
                        stuc_id: `<?= isset($stuc_info) ? $stuc_info->stuc_id : -1 ?>`
                    }
                }).done(function(returnedData) {
                    var data = JSON.parse(returnedData)
                    person_info = data.person_info
                    base_structure_position = data.base_structure_position
                    if (person_info.length > 0) {
                        person_info.forEach(seq => {
                            seq.person.forEach(person => {
                                if (person.stdp_id) {
                                    var array_admin = '';
                                    var array_spcl = '';
                                    person.admin_position.forEach(element => {
                                        array_admin += (element == null ? '-' : '<li>' + element + '</li>');
                                    });
                                    person.spcl_position.forEach(element => {
                                        array_spcl += (element == null ? '-' : '<li>' + element + '</li>');
                                    });
                                    var admin_position = `<ul> ${array_admin} </ul>`
                                    var spcl_position = `<ul> ${array_spcl} </ul>`
                                    var result = base_structure_position.find(item => item.stpo_id === person.stdp_po_id);
                                    if (result) {
                                        if (result.stpo_name.includes('หัวหน้า')) {
                                            if (result.stpo_name.includes("รองหัวหน้า")) {
                                                test_color = "#0076ab";
                                            } else {
                                                test_color = "#ffc107";
                                            }
                                        } else {
                                            test_color = "#198754";
                                        }
                                        var stdp_po_id = `<p style="color:${test_color}">  ${result.stpo_name} </p>`
                                    } else {
                                        var stdp_po_id = `<p style="color:#198754">  - </p>`
                                    }
                                    addPerson(person.stdp_id, person.full_name, stdp_po_id, admin_position, person.alp_name, spcl_position, seq.seq.replaceAll('.', '-'), person.stdp_id)

                                }
                            })
                        });
                    }
                })
            })
        }
    })

    function Select(index) {
        if (index != null) {
            select = index.toString().replace(/\./g, '-');
        }
    }

    function Personpostion(dp_id = null, id) {
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'structure_org/get_person_position'; ?>',
            method: 'POST',
            data: {
                pos_id: id,
                dp_id: dp_id
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            psp_info = data.psp_info
            base_structure_position = data.base_structure_position
            psp_info.forEach(element => {
                admin_position = document.getElementById('admin_position')
                let adminNames = element.admin_position != null ? element.admin_position.map(item => item.admin_name).join(", ") : '-';
                let spclNames = element.spcl_position != null ? element.spcl_position.map(item => item.spcl_name).join(", ") : '-';
                admin_position.innerHTML = `<div class="col-4 mt-2 mb-2">ตำแหน่งบริหาร:</div><div class="col-8 mt-2 mb-2">${adminNames}</div>`
                adline_position = document.getElementById('adline_position')
                adline_position.innerHTML = `<div class="col-4 mt-2 mb-2">ตำแหน่งปฏิบัติงาน:</div><div class="col-8 mt-2 mb-2">${element.alp_name}</div>`
                special_position = document.getElementById('special_position')
                special_position.innerHTML = `<div class="col-4 mt-2 mb-2">ตำแหน่งเฉพาะทาง:</div><div class="col-8 mt-2 mb-2">${spclNames}</div>`
                let stuc_position = document.getElementById('stuc_position');
                let selectOptions = `<div class="col-4 mt-2 mb-2">ตำแหน่งในโครงสร้าง:</div>
                     <div class="col-8 mt-2 mb-2">
                         <select id="stdp_po_id" class="form-select">
                             <option value="" selected>เลือกตำแหน่งในโครงสร้าง</option>`;

                // Check if the `base_structure_position` array has positions
                if (base_structure_position.length > 0) {
                    base_structure_position.forEach(base_stpo => {
                        selectOptions += `<option ${element.stdp_po_id == base_stpo.stpo_id ? 'selected' : ''} value="${base_stpo.stpo_id}">${base_stpo.stpo_name}</option>`;
                    });
                }

                selectOptions += `</select></div>`;
                stuc_position.innerHTML = selectOptions;
            });
        })
    }

    function EditPeron(id) {
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'structure_org/edit_person_position'; ?>',
            method: 'POST',
            data: {
                stdp_ps_id: id,
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            stdp_info = data.stdp_info
            base_structure_position = data.base_structure_position
            stdp_info.forEach(element => {
                $('#person_opt').empty();
                var newOption = new Option(`${element.pf_name_abbr} ${element.ps_fname} ${element.ps_lname}`, "1", true, true);
                document.getElementById('addpermodal').innerHTML = 'แก้ไขตำแหน่งในโครงสร้างบุคลากรของ' + element.stde_name_th
                $('#person_opt').append(newOption);
                $('#person_opt').attr('disabled', true);
                $('#admin_position').val(element.admin_name)
                $('#adline_position').val(element.alp_name)
                $('#special_position').val(element.spcl_name)
                let stuc_position = document.getElementById('stuc_position');
                let selectOptions = `<div class="col-4 mt-2 mb-2">ตำแหน่งในโครงสร้าง:</div>
                     <div class="col-8 mt-2 mb-2">
                         <select id="stdp_po_id" class="form-select">
                             <option value="" selected>เลือกตำแหน่งในโครงสร้าง</option>`;

                // Check if the `base_structure_position` array has positions
                if (base_structure_position.length > 0) {
                    base_structure_position.forEach(base_stpo => {
                        selectOptions += `<option ${element.stdp_po_id == base_stpo.stpo_id ? 'selected' : ''} value="${base_stpo.stpo_id}">${base_stpo.stpo_name}</option>`;
                    });
                }

                selectOptions += `</select></div>`;

                // Update the innerHTML only once for better performance
                stuc_position.innerHTML = selectOptions;
                button_person_positon = document.getElementById('submitPerson')
                button_person_positon.innerHTML = ''
                button_person_positon.innerHTML = `<button id="editPerson" type="button" class="btn btn-success" onclick="submitPersonPosition('${element.stdp_id}',$('#stdp_po_id').val())">บันทึก</button>`
            });
        })
    }

    function submitPersonPosition(id, stdp_po_id) {
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'structure_org/stucture_person_update'; ?>',
            method: 'POST',
            data: {
                stdp_id: id,
                stdp_po_id: stdp_po_id,
            }
        }).done(function(returnedData) {
            dialog_success({
                'header': '',
                'body': 'เพิ่มข้อมูลสำเร็จ'
            });
            setInterval(function() {
                window.location.reload();
            }, 1000);
        })
    }

    function editInstitue(index, checkNew, id = null) {
        if (checkNew == false) {
            $.ajax({
                url: '<?php echo site_url() . '/' . $controller . 'structure_org/get_stucture_detail_by_id'; ?>',
                method: 'POST',
                data: {
                    id: id,
                }
            }).done(function(returnedData) {
                var data = JSON.parse(returnedData)
                data.forEach(element => {
                    $('#nameTH').val(element.stde_name_th)
                    $('#nameEN').val(element.stde_name_en)
                    $('#detail').val(element.stde_desc)
                    $('input[name="ismedicalOption"][value="' + element.stde_is_medical + '"]').prop('checked', true);
                });
            })
            console.log(index);
            $('#staticBackdropLabel').text('แก้ไข' + insertLevel[index]);
            $('#thIndex').text(insertLevel[index])
            $('#engIndex').text(insertLevel[index])
            $('#detailIndex').text(insertLevel[index])
            method = id
        } else {
            method = 0
            parent = id
            $('#staticBackdropLabel').text('เพิ่ม' + insertLevel[index]);
            $('#thIndex').text(insertLevel[index])
            $('#engIndex').text(insertLevel[index])
            $('#detailIndex').text(insertLevel[index])
            $('#nameTH').val('')
            $('#nameEN').val('')
            $('#detail').val('')
            $('input[name="ismedicalOption"]').prop('checked', false);
        }
    }

    function Addnstitution(checkNew, name, nameEN, detail, ismedical, headID, stuc_id = null, stde_seq = null) {
        if (process == 'add' && !stuc_id) {
            if ($('#nameTH').val() == '' || $('input[name="ismedicalOption"]:checked').length === 0) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
                });
                return 0;
            }
            $.ajax({
                url: '<?php echo site_url() . '/' . $controller . 'Structure_org/structure_insert'; ?>',
                method: 'POST',
                data: {
                    stuc_dp_id: `<?= isset($dp_id) ? decrypt_id($dp_id) : 0 ?>`,
                    stuc_confirm_date: null,
                    stuc_status: '2'
                }
            }).done(function(returnedData) {
                var data = JSON.parse(returnedData)
                const radios2 = document.querySelectorAll('input[name="ismedicalOption"]');
                hire_is_medical = null;
                radios2.forEach((radio) => {
                    if (radio.checked) {
                        hire_is_medical = radio.value;
                    }
                });
                Addnstitution(true, $('#nameTH').val(), $('#nameEN').val(), $('#detail').val(), hire_is_medical, '', data.data.return_id)
            })
            return 0;
        }
        var button = document.createElement('button');
        if (name == '' || (checkNew != null && $('input[name="ismedicalOption"]:checked').length === 0)) {
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return 0;
        }
        if (select != null) {
            index3 = select
            var countele = []
            var classPrefix = "Level" + index3 + "-";
            var elements = document.querySelectorAll('[class^="' + classPrefix + '"]');
            if (elements.length > 0) {
                elements.forEach(function(element, index) {
                    check = element.className.split(' ')[0]
                    if ((check.length - classPrefix.length) <= 2) {
                        countele.push(element);
                    }
                });
            }
            Selectheader = '.Level' + index3
            if (stde_seq != null) {
                counteleIndex = stde_seq.split('.').pop().toString()
            } else {
                if (countele.length != 0) {
                    var str = countele[countele.length - 1].className.split(' ')[0]
                    var counteleIndex = (parseInt(str.split('-').pop()) + 1).toString();
                } else {
                    counteleIndex = 1;
                }
            }
            secretaryIndex = index3.replace(/-/g, '.') + "." + (counteleIndex)
            index1 = index3 + "-" + (counteleIndex)
            count = index1.split('-').length - 1;
            index2 = '1.' + (counteleIndex)
            cls = 'Level' + index1
            button.innerHTML = '+ เพิ่ม' + insertLevel[(((index3.match(/-/g) || []).length) + 2)];
        } else {
            Selectheader = '.tableContainer'
            button.innerHTML = '+ เพิ่มหน่วยงานลำดับที่ 2';
        }
        tindex[index4] = 0;
        button.classList.add('btn', 'btn-add', 'btn-success', 'newAdd');
        button.name = 'newAdd';
        button.setAttribute('onclick', `editInstitue('${(((index1.match(/-/g) || []).length)+1)}',true,'${headID}')`)
        button.setAttribute('id', 'deleteButton');
        index4++
        button.setAttribute("data-bs-toggle", "modal");
        button.setAttribute("data-bs-target", "#exampleModal");
        button.style.marginRight = "30px";
        var h2 = document.createElement("h2");
        h2.classList.add("accordion-header");

        /// เพิ่ม Collap Header {
        var buttonheader = document.createElement("button");
        buttonheader.classList.add("accordion-button", 'mt-2');
        buttonheader.setAttribute("type", "button");
        buttonheader.setAttribute("data-bs-toggle", "collapse");
        buttonheader.setAttribute("data-bs-target", "#collapseAdd" + index1);
        buttonheader.setAttribute("aria-expanded", "true");
        buttonheader.setAttribute("aria-controls", "collapseAdd" + index1);
        buttonheader.style.backgroundColor = color[count];
        buttonheader.style.color = Tcolor[count];
        /// } เพิ่ม Collap Header 

        /// ปุ่มเพิ่มหน่วย {
        // const buttonSecretary = document.createElement('button');
        // buttonSecretary.innerHTML = '+ เพิ่มหน่วยงานหลัก';
        // buttonSecretary.classList.add('btn', 'btn-warning');
        // buttonSecretary.setAttribute('id', 'deleteButton2');
        // buttonSecretary.style.color = 'white';
        // buttonSecretary.style.marginRight = "30px";
        /// } ปุ่มเพิ่มหน่วย 

        // ปุ่มแก้ไขหน่วยงาน {
        const editbutton = document.createElement('button');
        editbutton.innerHTML = '<i class="bi bi-pencil"></i>';
        editbutton.setAttribute("data-bs-toggle", "modal");
        editbutton.setAttribute("data-bs-target", "#exampleModal");
        editbutton.setAttribute('onclick', `editInstitue('${(((index1.match(/-/g) || []).length))}',false,'${headID}')`);
        editbutton.classList.add('btn', 'btn-warning');
        editbutton.style.marginRight = "30px";
        editbutton.style.color = 'white';
        // } ปุ่มแก้ไขหน่วยงาน

        // ปุ่มลบหน่วยงาน {
        const delbutton = document.createElement('button');
        delbutton.innerHTML = '<i class="bi bi-trash"></i>';
        delbutton.classList.add('btn', 'btn-danger', 'delInt');
        delbutton.setAttribute('id', 'deleteButton2');
        // delbutton.setAttribute('onclick', `del(${secretaryIndex}, '${nameTH}')`);
        // } ปุ่มลบหน่วยงาน
        /// เพิ่ม Body สำหรับ Collap Header { 
        var coll = document.createElement("div");
        coll.setAttribute('id', 'collapseAdd' + index1);
        coll.classList.add(cls, "card", "accordion-collapse", 'collapse', 'p-4');
        if (index1 == 1) {
            coll.classList.add("show");
        }
        var btt = document.createElement("div");
        btt.setAttribute('id', 'btb' + index1);
        btt.classList.add("accordion-body", cls);
        var secretaryCol = document.createElement("div");
        secretaryCol.classList.add("card");
        secretaryCol.setAttribute('id', 'secretaryCol' + secretaryIndex);
        var table = createTable();
        coll.appendChild(secretaryCol);
        coll.appendChild(table);
        coll.appendChild(btt);
        /// } เพิ่ม Body สำหรับ Collap Header  

        var i = document.createElement("i");
        i.classList.add("bi-window-dock", "icon-menu");
        var span = document.createElement("div");
        span.classList.add("row", 'w-100');
        var btn = document.createElement("div");
        btn.classList.add('head' + index1);
        // btn.appendChild(button);
        span.innerHTML = '<div class="col-lg-6 col-md-6 col-sm-4 text-start"> <span id=' + "name" + index1 + ">" + name + '</span>' + (nameEN != '' ? '( ' + nameEN + ' )' : '') + '<br>สายงาน: ' + (is_medical_array[is_medical_text] ? is_medical_array[is_medical_text] : '-') + '</div>';
        var sindex = null;
        if (secretaryIndex != '') {
            sindex = secretaryIndex
        } else {
            sindex = 0;
        }
        // buttonSecretary.setAttribute('onclick', `AddSecretary('${sindex}', '${name}')`);
        const btn2 = document.createElement("div");
        btn2.classList.add("col-2", 'text-end');
        // btn2.appendChild(buttonSecretary);

        // สร้าง Header แทบหน่วยงาน {
        const debtn = document.createElement("div");
        debtn.classList.add(index1, "col-lg-6", 'col-md-6', 'col-sm-8', 'text-end');
        if (index1.length < 7) {
            debtn.appendChild(button);
        }
        debtn.appendChild(editbutton);
        if (select != null) {
            debtn.appendChild(delbutton);
        }
        // span.appendChild(btn2);
        // span.appendChild(btn);
        if (checkNew != null) {
            if (method != 0) {
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'Structure_org/structure_detail_update'; ?>',
                    method: 'POST',
                    data: {
                        stde_id: method,
                        stde_name_th: $('#nameTH').val(),
                        stde_name_en: $('#nameEN').val(),
                        stde_desc: $('#detail').val(),
                        stde_is_medical: $('input[name="ismedicalOption"]:checked').val()
                    }
                })
                Swal.fire({
                    title: '',
                    text: 'แก้ไขข้อมูลสำเร็จ',
                    icon: 'success',
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false
                });
                setInterval(function() {
                    window.location.reload();
                }, 1000);
                is_medical_text = $('input[name="ismedicalOption"]:checked').val()
            } else {
                const levels = secretaryIndex.split('.')
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'Structure_org/structure_detail_insert'; ?>',
                    method: 'POST',
                    data: {
                        stde_stuc_id: stuc_id,
                        stde_name_th: name,
                        stde_parent: parent,
                        stde_name_en: nameEN,
                        stde_is_medical: $('input[name="ismedicalOption"]:checked').val(),
                        stde_seq: secretaryIndex,
                        stde_desc: detail,
                        stde_level: levels.length
                    }
                }).done(function(returnedData) {
                    var data = JSON.parse(returnedData)
                    btn.setAttribute('data-value', data.data.return_id);
                    editbutton.setAttribute('onclick', `editInstitue('${(((index1.match(/-/g) || []).length))}',false,'${data.data.return_id}')`);
                })
                Swal.fire({
                    title: '',
                    text: 'เพิ่มข้อมูลสำเร็จ',
                    icon: 'success',
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false
                });
                span.appendChild(debtn);
                buttonheader.appendChild(span);
                h2.appendChild(buttonheader);
                btn.appendChild(h2)
                btn.appendChild(coll)
                document.querySelector(Selectheader).appendChild(btn);
                is_medical_text = $('input[name="ismedicalOption"]:checked').val()
            }
            checkNew = null
        } else {
            btn.dataset.value = headID;
            var dataValue = btn.dataset.value;
            span.appendChild(debtn);
            buttonheader.appendChild(span);
            h2.appendChild(buttonheader);
            btn.appendChild(h2)
            btn.appendChild(coll)
            document.querySelector(Selectheader).appendChild(btn);
        }
        // headId.style.display = "none";
        // } สร้าง Header แทบหน่วยงาน
        select = null;
        $('#nameTH').val('')
        $('#nameEN').val('')
        $('#detail').val('')
        $('input[name="ismedicalOption"]').prop('checked', false);
        $('#exampleModal').modal('hide')
        $('.modal-backdrop').remove();
        var buttons = document.querySelectorAll('.btn-add');
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                var parentClass = this.parentNode.className.split(' ')[0];
                Select(parentClass)
            });
        });
        var buttons = document.getElementsByName('addPerson');
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                var buttonId = this.id;
                var newStr = buttonId.replace("addPerson", "");
                $('#personIndex').val(newStr);
                var Th = document.getElementById('name' + $('#personIndex').val()).innerHTML
                document.getElementById('addpermodal').innerHTML = 'เพิ่มบุคลากรของ' + Th
            });
        });
        var buttons = document.querySelectorAll('.delInt');
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                var parentClass = this.parentNode.className.split(' ')[0];
                Select(parentClass)
                Swal.fire({
                    title: 'ต้องการลบหน่วยงาน',
                    text: 'คุณต้องการลบหน่วยใช่ หรือไม่?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonText: 'ตกลง',
                    cancelButtonColor: '#DC3545',
                    confirmButtonColor: '#198754',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var elements = document.querySelectorAll('.head' + parentClass);
                        // ลบ element ที่ค้นหาได้
                        elements.forEach(function(element) {
                            $.ajax({
                                url: '<?php echo site_url() . '/' . $controller . 'Structure_org/delete_structure_detail'; ?>',
                                method: 'POST',
                                data: {
                                    delete_id: element.dataset.value,
                                }
                            }).done(function(returnedData) {
                                var data = JSON.parse(returnedData)
                                if (data.data.status_response == 1) {
                                    element.remove();
                                    dialog_success({
                                        'header': '',
                                        'body': 'ลบข้อมูลสำเร็จ'
                                    });
                                } else {
                                    dialog_error({
                                        'header': 'ไม่สามารถลบข้อมูลได้!',
                                        'body': 'ข้อมูลมีการใช้งานอยู่'
                                    });
                                }
                            })
                        });
                        var element = document.getElementById('tableContainer');
                        // เช็คว่า element มี content หรือไม่
                        if (element.textContent.trim() == '') {
                            document.getElementById("addorg").hidden = false;
                            select = null;
                            index1 = '1';
                            secretaryIndex = '';
                            cls = 'Level1';
                            count = 0;
                        }
                    } else {}
                });
            });
        });
        if (process == 'add') {
            window.location.href = '<?php echo base_url() ?>index.php/hr/structure/Structure_org/stucture_org_edit/' + stuc_id;
        }
    }

    function clearInput() {
        $('#person_opt').attr('disabled', false);
        $('#admin_position').html('')
        $('#adline_position').html('')
        $('#special_position').html('')
        stuc_position = document.getElementById('stuc_position')
        stuc_position.innerHTML = ''
        $('#person_opt').val(0);
        person = document.getElementById('person')
        person.innerHTML = `<select id="person_opt" class="form-control select2" onchange="Personpostion(<?= isset($std_info) ? $std_info->dp_id : null ?>,$('#person_opt').val())" placeholder="เลือกบุคคล">
                            <option value="0" disabled selected>เลือกบุคลากร</option>
                            <?php if (isset($ps_info)) : ?>
                                <?php foreach ($ps_info as $value) : ?>
                                    <option value="<?= $value->ps_id ?>"><?= $value->pf_name_abbr ?> <?= $value->ps_fname . ' ' . $value->ps_lname ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>`
        $('#person_opt').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#addPersonModal')
        });
        button_person_positon = document.getElementById('submitPerson')
        button_person_positon.innerHTML = `<button id="addPerson" name="newAdd" type="button" class="btn btn-success" onclick="addPerson($('#person_opt').val(),$('#person_opt option:selected').text(),$('#stdp_po_id').val(),$('#admin_position').val(),$('#adline_position').val(),$('#special_position').val())">บันทึก</button>`
    }

    function createTable() {
        var divTag = document.createElement("div");
        divTag.setAttribute('id', 'divPerson');
        divTag.classList.add('accordion-body');
        var button = document.createElement('button');
        button.innerHTML = '+ เพิ่มรายชื่อบุคลากร';
        button.classList.add('btn', 'btn-primary', 'mt-3', 'mb-2');
        button.setAttribute('id', 'addPerson' + index1);
        button.setAttribute('name', 'addPerson');
        button.setAttribute('onclick', 'clearInput()');
        button.setAttribute("data-bs-toggle", "modal");
        button.setAttribute("data-bs-target", "#addPersonModal");
        divTag.appendChild(button)
        var table = document.createElement("table");
        table.classList.add("table", 'datatable');
        table.setAttribute('id', 'table' + index1);
        var thead = document.createElement("thead");
        var tr = document.createElement("tr");
        var th0 = document.createElement("th");
        th0.setAttribute("scope", "col");
        th0.classList.add("text-center");
        th0.setAttribute('width', '5%');
        th0.textContent = "เรียงข้อมูล";
        var th1 = document.createElement("th");
        th1.setAttribute("scope", "col");
        var div1 = document.createElement("div");
        div1.classList.add("text-center");
        div1.textContent = "ลำดับ";
        th1.appendChild(div1);

        var th2 = document.createElement("th");
        th2.setAttribute("scope", "col");
        th2.classList.add("text-center");
        th2.textContent = "ชื่อ - นามสกุล";

        var th3 = document.createElement("th");
        th3.setAttribute("scope", "col");
        th3.classList.add("text-center");
        th3.textContent = "ตำแหน่งในโครงสร้าง";

        var th4 = document.createElement("th");
        th4.classList.add("text-center");
        th4.setAttribute("scope", "col");
        th4.textContent = "ตำแหน่งบริหารงาน";

        var th5 = document.createElement("th");
        th5.classList.add("text-center");
        th5.setAttribute("scope", "col");
        th5.textContent = "ตำแหน่งปฏิบัติงาน";

        var th6 = document.createElement("th");
        th6.classList.add("text-center");
        th6.setAttribute("scope", "col");
        th6.textContent = "ตำแหน่งงานเฉพาะทาง";

        var th7 = document.createElement("th");
        th7.classList.add("text-center");
        th7.setAttribute("scope", "col");
        th7.textContent = "ดำเนินการ";
        tr.appendChild(th0);
        tr.appendChild(th1);
        tr.appendChild(th2);
        tr.appendChild(th3);
        tr.appendChild(th4);
        tr.appendChild(th5);
        tr.appendChild(th6);
        tr.appendChild(th7);

        thead.appendChild(tr);
        table.appendChild(thead);

        var tbody = document.createElement("tbody");
        // Add a row to indicate no data is available
        var trNoData = document.createElement("tr");
        var tdNoData = document.createElement("td");
        tdNoData.setAttribute("colspan", "8"); // Adjust the colspan to match the number of columns
        tdNoData.classList.add("text-center");
        tdNoData.textContent = "ไม่มีข้อมูลบุคลากร";
        trNoData.appendChild(tdNoData);

        tbody.appendChild(trNoData);
        table.appendChild(tbody);
        divTag.appendChild(table)
        return divTag;
    }

    function addPerson(id, name, stuc_po, admin, adline, spcl, passindex = null, stdp_id = null) {
        if (!id) {
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณาเลือกบุคลากร'
            });
            return 0;
        }
        // else {
        //     check_po = document.getElementById('stdp_po_id')
        //     if (check_po) {
        //         if (!$('#stdp_po_id').val()) {
        //             dialog_error({
        //                 'header': 'ไม่สามารถเพิ่มข้อมูลได้',
        //                 'body': 'กรุณาเลือกตำแหน่งในโครงสร้าง'
        //             });
        //             return 0;
        //         }
        //     }
        // }
        if (passindex == null) {
            index = $('#personIndex').val()
        } else {
            index = passindex
        }
        if (name) {
            var tableBody = document.getElementById('table' + index).querySelector('tbody');
            var noDataRow = tableBody.querySelector('tr td[colspan="8"]');
            // Remove the "ไม่มีข้อมูลบุคลากร" row if it exists
            if (noDataRow) {
                noDataRow.parentElement.remove();
            }
            var newRow = document.createElement("tr");
            var sortCell = document.createElement("td");
            sortCell.classList.add('text-center')
            sortCell.innerHTML = `<i data-value="${stdp_id}" class="bi bi-filter-square-fill"></i>`;
            var numCell = document.createElement("td");
            numCell.classList.add('text-center', 'order')
            numCell.innerHTML = '<p>' + (tableBody.rows.length + 1) + '</p>';
            var nameCell = document.createElement("td");
            nameCell.innerHTML = '<p>' + name + '</p>';
            var stucpoCell = document.createElement("td");
            stucpoCell.innerHTML = stuc_po
            var buttonCell = document.createElement("td");
            var adlineCell = document.createElement("td");
            var return_id = null;
            if (passindex == null) {
                var element = document.querySelectorAll(".head" + index);
                // ดึงค่า data-value
                var dataValue = null
                element.forEach(function(element) {
                    // ดึงค่า data-value
                    dataValue = element.getAttribute("data-value");
                });
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'Structure_org/structure_person_insert'; ?>',
                    method: 'POST',
                    data: {
                        stdp_stde_id: dataValue,
                        stdp_ps_id: id,
                        stdp_po_id: $('#stdp_po_id').val(),
                        stdp_seq: (tableBody.rows.length + 1),
                        dp_id: <?= isset($std_info) ? $std_info->dp_id : null ?>
                    }
                }).done(function(returnedData) {
                    var data = JSON.parse(returnedData)
                    var stdmin = ''
                    var stspcl = ''
                    data.data.position.forEach(element => {
                        if (element.admin_position != null) {
                            element.admin_position.forEach(admin => {
                                stdmin += '<li>' + admin.admin_name + '</li>';
                            });
                        } else {
                            stdmin = '-';
                        }
                        if (element.spcl_position != null) {
                            element.spcl_position.forEach(spcl => {
                                stspcl += '<li>' + spcl.spcl_name + '</li>';
                            });
                        } else {
                            stspcl = '-'
                        }
                        if (element.alp_name != null) {
                            adline = element.alp_name
                        } else {
                            adline = '-'
                        }
                    });
                    if (data.data.status_response == 2) {
                        dialog_error({
                            'header': 'เพิ่มบุคลากรไม่สำเร็จ',
                            'body': 'มีการเพิ่มบุคลากรซ้ำในโครงสร้างเดียวกัน'
                        });
                        return 0;
                    }
                    var adminCell = document.createElement("td");
                    adminCell.innerHTML = '<ul>' + stdmin + '</ul>';
                    var spclCell = document.createElement("td");
                    spclCell.innerHTML = '<ul>' + stspcl + '</ul>';
                    adlineCell.innerHTML = '<p>' + adline + '</p>';
                    buttonCell.innerHTML = `<div class="btn btn-waring mr-2" onclick="clearInput(),EditPeron('${data.data.return_id}') " data-bs-toggle="modal" data-bs-target="#addPersonModal" style="background-color:#ffc107;color:white;"><i class="bi bi-pencil"> </i></div> <div class="btn btn-danger deleteBtn" data-value="${data.data.return_id}" style="background-color:#dc3545;color:white;"><i class="bi bi-trash"> </i></div>`
                    buttonCell.classList.add('text-center')
                    Swal.fire({
                        title: '',
                        text: 'เพิ่มข้อมูลสำเร็จ',
                        icon: 'success',
                        timer: 1000,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    newRow.appendChild(sortCell);
                    newRow.appendChild(numCell);
                    newRow.appendChild(nameCell);
                    newRow.appendChild(stucpoCell);
                    newRow.appendChild(adminCell);
                    newRow.appendChild(adlineCell);
                    newRow.appendChild(spclCell);
                    newRow.appendChild(buttonCell);
                    tableBody.appendChild(newRow);
                    Loadperson_delete(index)
                })
            } else {
                buttonCell.innerHTML = `<div class="btn btn-waring" onclick="clearInput(),EditPeron('${id}')"data-bs-toggle="modal" data-bs-target="#addPersonModal" style="background-color:#ffc107;color:white;"><i class="bi bi-pencil"> </i></div> <div class="btn btn-danger deleteBtn" data-value="${id}" style="background-color:#dc3545;color:white;"><i class="bi bi-trash"> </i></div>`
                buttonCell.classList.add('text-center')
                var adminCell = document.createElement("td");
                adminCell.innerHTML = admin
                var spclCell = document.createElement("td");
                spclCell.innerHTML = spcl
                adlineCell.innerHTML = '<p>' + adline + '</p>';
                newRow.appendChild(sortCell);
                newRow.appendChild(numCell);
                newRow.appendChild(nameCell);
                newRow.appendChild(stucpoCell);
                newRow.appendChild(adminCell);
                newRow.appendChild(adlineCell);
                newRow.appendChild(spclCell);
                newRow.appendChild(buttonCell);
                tableBody.appendChild(newRow);
                Loadperson_delete(index)
            }
            // เพิ่ม <td> ใหม่เข้าไปใน <tr>
        } else {
            Swal.fire({
                title: '',
                text: 'เพิ่มข้อมูลไม่สำเร็จ',
                icon: 'danger',
                timer: 1000,
                showCancelButton: false,
                showConfirmButton: false
            });
        }
        $('#addPersonModal').modal('hide')
        $('person').val(0)
        $('#admin_position').val('')
        $('#adline_position').val('')
        $('#special_position').val('')
        $('.modal-backdrop').remove();
    }

    function Loadperson_delete(index) {
        const table = document.getElementById('table' + index);
        let dataValues = [];
        if (table) {
            function collectDataValues() {
                table.querySelector('tbody').querySelectorAll('tr').forEach((row, index) => {
                    row.querySelector('td:nth-child(2)').innerHTML = '<p>' + (index + 1) + '</p>';
                    let dataValue = row.querySelector('.deleteBtn').getAttribute('data-value');
                    dataValues.push({
                        index: index + 1,
                        value: dataValue
                    });
                });
                if (dataValues.length > 0) {
                    $.ajax({
                        url: '<?php echo site_url() . '/' . $controller . 'Structure_org/structure_person_update_seq'; ?>',
                        method: 'POST',
                        data: {
                            info: dataValues
                        }
                    })
                } else {
                    var trNoData = document.createElement("tr");
                    var tdNoData = document.createElement("td");
                    tdNoData.setAttribute("colspan", "8"); // Adjust the colspan to match the number of columns
                    tdNoData.classList.add("text-center");
                    tdNoData.textContent = "ไม่มีข้อมูลบุคลากร";
                    trNoData.appendChild(tdNoData);
                    table.querySelector('tbody').appendChild(trNoData);
                    return 0;
                }
            }
            // เพิ่ม event listener ให้กับปุ่มลบภายในตารางที่เลือก
            table.querySelectorAll('.deleteBtn').forEach(button => {
                button.addEventListener('click', function(e) {
                    let button = e.currentTarget; // ปุ่มที่ถูกกด
                    let dataValue = button.getAttribute('data-value'); // ดึงค่า data-value
                    let row = button.closest('tr'); // หาแถวที่ใกล้ที่สุด
                    // ลบแถว
                    Swal.fire({
                        title: 'ต้องการลบบุคลากร',
                        text: 'คุณต้องการลบบุคลากรใช่ หรือไม่?',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'ยกเลิก',
                        confirmButtonText: 'ตกลง',
                        cancelButtonColor: '#DC3545',
                        confirmButtonColor: '#198754'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '<?php echo site_url() . '/' . $controller . 'Structure_org/delete_structure_person'; ?>',
                                method: 'POST',
                                data: {
                                    stdp_stde_id: dataValue,
                                }
                            }).done(function(returnedData) {
                                row.remove();
                                collectDataValues();
                                dialog_success({
                                    'header': '',
                                    'body': 'ลบข้อมูลสำเร็จ'
                                });
                            })
                        }
                    });
                });
            });
        }

        function updateRowOrder(tableId) {
            var updateReq = [];
            $('#table' + tableId + ' tbody tr').each(function(index) {
                $(this).find('.order').text(index + 1);
                var dataValue = $(this).find('.bi-filter-square-fill').data('value');
                updateReq.push({
                    'seq': index + 1,
                    'stdp_id': dataValue
                });
            });
            if (updateReq.length > 1) {
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'structure_org/update_stdp_seq'; ?>',
                    method: 'POST',
                    data: {
                        post_info: updateReq
                    }
                }).done(function(returnedData) {
                    dialog_success({
                        'header': '',
                        'body': 'เปลี่ยนแปลงลำดับบุคลากรสำเร็จ'
                    });
                })
            }
        }
        new Sortable(document.getElementById('table' + index).getElementsByTagName('tbody')[0], {
            animation: 150,
            handle: '.bi-filter-square-fill',
            onEnd: function( /**Event*/ evt) {
                updateRowOrder(index)
            }
        });
    }
</script>