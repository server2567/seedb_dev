<form method="post" class="needs-validation" id="profile_work_history_form" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">
    <input type="hidden" name="wohr_id" id="wohr_id" value="">
    <input type="hidden" name="tab_active" id="tab_active" value="5">
    <?php
    setlocale(LC_TIME, 'th_TH.utf8');

    // Array of Thai month names
    $thaiMonths = array(
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    );

    function getIndentation($seq)
    {
        // Count the number of periods in the sequence to determine the depth
        $depth = substr_count($seq, '.');
        // Return a string of non-breaking spaces for indentation
        return str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $depth * 4);
    }

    ?>

    <div class="row g-3">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_person_work_history" aria-expanded="false" aria-controls="collapse_person_work_history">
                            <i class="bi bi-briefcase icon-menu font-20"></i>จัดการข้อมูลประสบการณ์การทำงาน
                        </button>
                    </h2>
                    <div id="collapse_person_work_history" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body row">
                            <!-- <div class="col-md-6">
                                <label for="wohr_date_type" class="form-label required">ประเภทช่วงเวลา</label>
                                <select class="form-select select2" data-placeholder="-- เลือกประเภทช่วงเวลา --" name="wohr_date_type" id="wohr_date_type">
                                    <option value="D">วัน/เดือน/ปี</option>
                                    <option value="MY">เดือน/ปี</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="date_type_D" style="display: none;">
                                <label for="wohr_start_date" class="form-label required">วันที่การทำงาน</label>
                                <div class="input-group date input-daterange">
                                    <input type="text" class="form-control" name="wohr_start_date" id="wohr_start_date">
                                    <span class="input-group-text">ถึง</span>
                                    <input type="text" class="form-control" name="wohr_end_date" id="wohr_end_date">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wohr_end_date_now_type_D" name="wohr_end_date_now_type_D">
                                    <label class="form-check-label" for="wohr_end_date_now_type_D">
                                        ถึงปัจจุบัน
                                    </label>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <label for="wohr_date_start_day" class="form-label required">วันที่การทำงาน</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 38px; width: 100px;">เริ่มต้นวันที่</span>
                                    <select class="form-select" data-placeholder="-- เลือกวันที่ --" name="wohr_date_start_day" id="wohr_date_start_day" style="height: 38px;">
                                        <option value="0" selected>ไม่ระบุ</option>
                                        <?php

                                        $i = 0;
                                        for ($i = 1; $i <= 31; $i++) {
                                            // Get current date

                                            echo '<option value="' . ($i) . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="input-group-text" style="height: 38px; width: 65px;">เดือน</span>
                                    <select class="form-select" data-placeholder="-- เลือกเดือน --" name="wohr_date_start_month" id="wohr_date_start_month" style="height: 38px;">
                                        <?php
                                        $i = 0;
                                        foreach ($thaiMonths as $row) {
                                            // Get current date

                                            echo '<option value="' . ($i + 1) . '">' . $row . '</option>';
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                    <span class="input-group-text" style="height: 38px;">ปี (พ.ศ.)</span>
                                    <select class="form-select" data-placeholder="-- เลือกปี --" name="wohr_date_start_year" id="wohr_date_start_year" style="height: 38px;">
                                        <?php
                                        $currentYear = date('Y');
                                        $currentYear += 543;
                                        for ($i = $currentYear; $i >= $currentYear - 60; $i--) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group mt-3" id="div_wohr_date_end">
                                    <span class="input-group-text" style="height: 38px; width: 100px;">สิ้นสุดวันที่</span>
                                    <select class="form-select" data-placeholder="-- เลือกเดือน --" name="wohr_end_end_day" id="wohr_end_end_day" style="height: 38px;">
                                        <option value="0" selected>ไม่ระบุ</option>
                                        <?php
                                        $i = 0;
                                        for ($i = 1; $i <= 31; $i++) {
                                            // Get current date

                                            echo '<option value="' . ($i) . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="input-group-text" style="height: 38px; width: 65px;">เดือน</span>
                                    <select class="form-select" data-placeholder="-- เลือกเดือน --" name="wohr_date_end_month" id="wohr_date_end_month" style="height: 38px;">
                                        <?php
                                        $i = 0;
                                        foreach ($thaiMonths as $row) {
                                            // Get current date
                                            if ((date('n') - 1) == $i)
                                                echo '<option value="' . ($i + 1) . '" selected>' . $row . '</option>';
                                            else
                                                echo '<option value="' . ($i + 1) . '">' . $row . '</option>';
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                    <span class="input-group-text" style="height: 38px;">ปี (พ.ศ.)</span>
                                    <select class="form-select" data-placeholder="-- เลือกปี --" name="wohr_end_date_year" id="wohr_end_date_year" style="height: 38px;">
                                        <?php
                                        $currentYear = date('Y');
                                        $currentYear += 543;
                                        for ($i = $currentYear; $i >= $currentYear - 60; $i--) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wohr_check_date_now" name="wohr_check_date_now">
                                    <label class="form-check-label" for="wohr_check_date_now">
                                        ถึงปัจจุบัน
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="wohr_admin_id" class="form-label">ตำแหน่งบริหารงาน</label>
                                <select class="form-select select2" data-placeholder="-- เลือกตำแหน่งบริหารงาน--" name="wohr_admin_id" id="wohr_admin_id">
                                    <option value="">-- เลือกตำแหน่งปฏิบัติงาน--</option>
                                    <?php
                                    foreach ($base_admin_position_list as $key => $row) {
                                    ?>
                                        <option value="<?php echo $row->admin_id; ?>"><?php echo $row->admin_name; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="wohr_alp_id" class="form-label required">ตำแหน่งปฏิบัติงาน</label>
                                <select class="form-select select2" data-placeholder="-- เลือกตำแหน่งปฏิบัติงาน --" name="wohr_alp_id" id="wohr_alp_id">
                                    <option value="">-- เลือกตำแหน่งปฏิบัติงาน--</option>
                                    <?php
                                    foreach ($base_adline_position_list as $key => $row) {
                                    ?>
                                        <option value="<?php echo $row->alp_id; ?>"><?php echo $row->alp_name; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wohr_dept_id" name="wohr_dept_id" checked>
                                    <label class="form-check-label" for="wohr_dept_id">
                                        <?php echo $this->config->item('site_name_th') ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 div_wohr_structure">
                                <label for="wohr_structure" class="form-label required ">โครงสร้างหน่วยงาน</label>
                                <select class="form-select select2" data-placeholder="-- เลือกวันที่บังคับใช้โครงสร้าง --" name="wohr_stuc_id" id="wohr_stuc_id" width="100%">
                                    <option value="" selected disabled>-- เลือกวันที่บังคับใช้โครงสร้าง --</option>
                                    <?php
                                    foreach ($structure_list as $key => $row) {
                                    ?>
                                        <option value="<?php echo $row->stuc_id; ?>" <?= $row->stuc_status == 1 ? 'selected' : '' ?>><?php echo fullDateTH3($row->stuc_confirm_date) . ($row->stuc_status == 1 ? ' (โครงสร้างปัจจุบัน) </p>' : ' (โครงสร้างเก่า)'); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 div_wohr_structure">
                                <label for="wohr_structure" class="form-label required">หน่วยงานที่สังกัด</label>
                                <select class="form-select select2" data-placeholder="-- เลือกหน่วยงานที่สังกัด --" name="wohr_stde_id" id="wohr_stde_id" width="100%">
                                    <option value="">-- เลือกหน่วยงานที่สังกัด--</option>
                                    <?php
                                    foreach ($structure_detail_list as $key => $row) {
                                        // Get the indentation based on the sequence
                                        $indentation = getIndentation($row->stde_seq);
                                    ?>
                                        <option value="<?php echo $row->stde_id; ?>"><?php echo $indentation . $row->stde_name_th; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12 mt-3" id="div_wohr_place_name" style="display: none;">
                                <label for="wohr_alp_id" class="form-label required">สถานที่/หน่วยงานที่สังกัด</label>
                                <input type="text" class="form-control" id="wohr_place_name" name="wohr_place_name">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label for="wohr_detail_th" class="form-label">รายละเอียด (ภาษาไทย)</label>
                                <textarea class="form-control" name="wohr_detail_th" id="wohr_detail_th" rows="6" placeholder="ได้มีโอกาสทำงานที่โรงพยาบาลจักษุสุราษฎร์ ในฐานะแพทย์จักษุ ซึ่งได้รับประสบการณ์ที่มีคุณค่าและเป็นประโยชน์อย่างยิ่งในการพัฒนาทักษะและความรู้ในด้านการรักษาสายตาและโรคทางตา

1.การตรวจวินิจฉัยโรคตา
- ทำการตรวจวินิจฉัยโรคตาและปัญหาด้านสายตาต่างๆ เช่น ต้อกระจก ต้อหิน และจอประสาทตาเสื่อม
- ใช้อุปกรณ์และเทคโนโลยีทันสมัย เช่น เครื่องสแกน OCT (Optical Coherence Tomography) และเครื่องวัดความดันตา

2.การผ่าตัดและการรักษา
- มีประสบการณ์ในการทำการผ่าตัดต้อกระจกและต้อหิน รวมถึงการผ่าตัดเลเซอร์เพื่อแก้ไขปัญหาสายตา
- ดูแลและติดตามผู้ป่วยหลังการผ่าตัดเพื่อให้แน่ใจว่ามีการฟื้นตัวที่ดีและไม่มีภาวะแทรกซ้อน

3.การให้คำปรึกษาและการดูแลผู้ป่วย
- ให้คำปรึกษาและข้อมูลแก่ผู้ป่วยเกี่ยวกับวิธีการรักษาและการป้องกันโรคตา
- ทำงานร่วมกับทีมแพทย์และพยาบาลในการดูแลผู้ป่วยอย่างครบวงจร"></textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="wohr_detail_en" class="form-label">รายละเอียด (ภาษาอังกฤษ)</label>
                                <textarea class="form-control" name="wohr_detail_en" id="wohr_detail_en" rows="6" placeholder="I had the opportunity to work at Surat Eye Hospital as an ophthalmologist, where I gained valuable and beneficial experiences in developing my skills and knowledge in eye care and ophthalmic diseases.

1. Eye Disease Diagnosis
- Conducted diagnosis of various eye diseases and vision problems such as cataracts, glaucoma, and macular degeneration.
- Utilized modern equipment and technology such as Optical Coherence Tomography (OCT) and tonometry devices.

2. Surgery and Treatment
- Experienced in performing cataract and glaucoma surgeries, including laser surgeries to correct vision problems.
- Provided post-operative care and follow-up to ensure good recovery and absence of complications.

3.Consultation and Patient Care
- Offered consultation and information to patients about treatment methods and eye disease prevention.
- Collaborated with a team of doctors and nurses to provide comprehensive patient care."></textarea>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <!-- <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url() . "/" . $controller_dir; ?>">ย้อนกลับ</a> -->
                                <button type="button" class="btn btn-success float-end" id="button_profile_work_history_save_form" onclick="profile_work_history_save_form()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-bs-placement="top">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-table icon-menu font-20"></i>ตารางข้อมูลประสบการณ์การทำงาน
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table datatable" id="work_history_list" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">ตำแหน่งบริหารงาน</th>
                                        <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                        <th class="text-center">สถานที่/หน่วยงานที่สังกัด</th>
                                        <th class="text-center">วันที่เริ่มต้น</th>
                                        <th class="text-center">วันที่สิ้นสุด</th>
                                        <th class="text-center">ดำเนินการ</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var stde_id_select = ''
    $(document).ready(function() {
        var data_work_history_list_table = $('#work_history_list').DataTable();
        var wohr_id = $('#wohr_id').val();
        var tab_active = $('#profile_work_history_form #tab_active').val();
        // Function to update DataTable based on select dropdown values
        function updateDataTable() {
            var ps_id = $('#ps_id').val();
            stde_id_select = $('wohr_stde_id').val()
            // Make AJAX request to fetch updated data
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_profile_person_work_history_list',
                type: 'GET',
                data: {
                    ps_id: ps_id
                },
                success: function(data) {
                    // Clear existing data_work_history_list_table data
                    data = JSON.parse(data);
                    data_work_history_list_table.clear().draw();

                    $(".summary_person").text(data.length);
                    // Add new data to data_work_history_list_table
                    data.forEach(function(row, index) {
                        var place = (row.wohr_stde_name_th != null ? '<?php echo $this->config->item('site_name_th'); ?>' + " " + row.stde_name_th : row.wohr_place_name);
                        var button = `  <div class="text-center option">
                                            <button type="button" class="btn btn-warning" onclick="get_work_history_detail_by_id('${row.wohr_id}')" title="คลิกเพื่อแก้ไขข้อมูล" data-toggle="tooltip" data-bs-placement="top">
                                                <i class="bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="modal_confirm_delete(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-bs-placement="top"
                                            data-id="${row.wohr_id}" 
                                                data-tab="${tab_active}"
                                                data-table="work_history" 
                                                data-topic="ประสบการณ์ทำงาน" 
                                                data-index="${(index+1)}" 
                                                data-detail="
                                                    <div>
                                                        <h6>ตำแหน่งบริหารงาน</h6>
                                                        <p>${replaceQuotes(row.admin_name)}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>ตำแหน่งปฏิบัติงาน</h6>
                                                        <p>${replaceQuotes(row.alp_name)}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>สถานที่/หน่วยงานที่สังกัด</h6>
                                                        <p>${replaceQuotes(place)}</p>
                                                    </div>
                                                    <div>
                                                        <h6>วันที่การทำงาน</h6>
                                                        <p>${row.wohr_start_date.replace("00 ", "ไม่ระบุ ")} ถึง ${row.wohr_end_date.replace("00 ", " ")}</p>
                                                    </div>">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                    `;
                        data_work_history_list_table.row
                            .add([
                                (index + 1),
                                row.admin_name,
                                row.alp_name,
                                place,
                                row.wohr_start_date.replace("00 ", " "),
                                row.wohr_end_date.replace("00 ", " "),
                                button
                            ]).draw();
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            });
        }
        // ทำงานเมื่อเลือกตัวเลือกใหม่
        $('#wohr_stde_id').on('select2:select', function(e) {
            cleanSelect2Text();
        });


        // Handle checkbox change event
        $('#wohr_check_date_now').change(function() {
            if ($(this).is(':checked')) {
                $('#div_wohr_date_end').slideUp();
            } else {
                $('#div_wohr_date_end').slideDown();
            }
        });

        // Handle checkbox change event
        $('#wohr_dept_id').change(function() {
            if ($(this).is(':checked')) {
                $('.div_wohr_structure').slideDown();
                $('#div_wohr_place_name').slideUp();
            } else {
                $('.div_wohr_structure').slideUp();
                $('#div_wohr_place_name').slideDown();
            }
        });
        // Add event listener to handle changes
        $('#wohr_stuc_id').on('change', function() {
            format_dept_option();
        });

        // Initial DataTable update
        updateDataTable();

    });

    function cleanSelect2Text() {
        // ดึงข้อความที่แสดงใน select2
        var select2Element = $('#wohr_stde_id').siblings('.select2-container').find('.select2-selection__rendered');
        var innerHtml = select2Element.html();

        // ลบช่องว่างที่เป็น &nbsp; ออก
        var cleanedHtml = innerHtml.replace(/&nbsp;/g, '').trim();

        // อัปเดตข้อความที่แสดงอยู่ใน select2
        select2Element.html(cleanedHtml);
    }

    function format_dept_option() {
        // Get the selected data from Select2
        var selectedData = $('#wohr_stuc_id').select2('data')[0]; // Get the first selected data object
        function getIndentation(seq) {
            // Count the number of periods in the sequence to determine the depth
            const depth = (seq.match(/\./g) || []).length;

            // Return a string of non-breaking spaces for indentation
            // Using `\u00A0` for non-breaking space (HTML entity &nbsp; equivalent)
            return '\u00A0'.repeat(depth * 4); // 4 non-breaking spaces per depth level
        }
        if (selectedData) {
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_structure_detail_by_stuc_id',
                type: 'POST',
                data: {
                    stuc_id: selectedData.id
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.length > 0) {
                        $('#wohr_stde_id').empty();
                        var newOption = new Option('-- เลือกหน่วยงานที่สังกัดasd --', '', true, false);
                        $('#wohr_stde_id').append(newOption);
                        data.forEach(element => {
                            if (stde_id_select == element.stde_id) {
                                selected = true
                                stde_id_select = element.stde_id
                            } else {
                                selected = false
                            }
                            newOption = new Option(getIndentation(element.stde_seq) + element.stde_name_th, element.stde_id, false, selected);
                            $('#wohr_stde_id').append(newOption)
                        });
                        const $selectedOption = $('#wohr_stde_id option:selected');
                        const selectedText = $selectedOption.text().trim();

                        // Update the displayed value (if needed)
                        $selectedOption.text(selectedText);
                    }
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        header: text_toast_default_error_header,
                        body: text_toast_default_error_body
                    });
                }
            });
        }
    }

    function get_work_history_detail_by_id(wohr_id) {
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_work_history_detail_by_id/' + wohr_id,
            type: 'POST',
            data: {
                wohr_id: wohr_id
            },
            success: function(data) {
                data = JSON.parse(data);

                if (data.length > 0) {
                    var work_history = data[0];

                    $('#wohr_id').val(work_history.wohr_id);
                    $('#wohr_detail_th').text(work_history.wohr_detail_th);
                    $('#wohr_detail_en').text(work_history.wohr_detail_en);
                    $('#wohr_alp_id').val(work_history.wohr_alp_id).trigger('change');
                    $('#wohr_admin_id').val(work_history.wohr_admin_id).trigger('change');
                    $('#wohr_stuc_id').val(work_history.wohr_stuc_id).trigger('change');
                    $('#wohr_stde_id').val(work_history.wohr_stde_id).trigger('change');
                    stde_id_select = work_history.wohr_stde_id
                    // Split the start date and populate fields
                    if (work_history.wohr_start_date) {
                        var startDateParts = work_history.wohr_start_date.split('/');
                        $('#wohr_date_start_year').val((parseInt(startDateParts[2])));
                        $('#wohr_date_start_month').val(parseInt(startDateParts[1]));
                        $('#wohr_date_start_day').val(parseInt(startDateParts[0]));
                    }
                    if (work_history.wohr_stde_name_th == null) {
                        $('#wohr_dept_id').prop('checked', false);
                        $('#wohr_place_name').val(work_history.wohr_place_name)
                        $('#div_wohr_structure').slideUp();
                        $('#div_wohr_place_name').slideDown();

                    } else {
                        $('#wohr_dept_id').prop('checked', true);
                        $('#div_wohr_structure').slideDown();
                        $('#div_wohr_place_name').slideUp();
                    }
                    // Split the end date and populate fields
                    if (work_history.wohr_end_date === '') {
                        $('#wohr_check_date_now').prop('checked', true);
                        $('#div_wohr_date_end').hide();
                    } else {
                        $('#wohr_check_date_now').prop('checked', false);
                        $('#div_wohr_date_end').show();
                        if (work_history.wohr_end_date) {
                            var endDateParts = work_history.wohr_end_date.split('/');
                            $('#wohr_end_date_year').val(parseInt(endDateParts[2]));
                            $('#wohr_date_end_month').val(parseInt(endDateParts[1]));
                            $('#wohr_end_end_day').val(parseInt(endDateParts[0]));
                        }
                    }
                    // ทำงานเมื่อหน้าเว็บโหลดเสร็จ

                    // Show the accordion and scroll to the top
                    $('#profile_work_history_form #collapse_person_work_history').collapse('show');
                    $('html, body').animate({
                        scrollTop: 0
                    }, 0);
                }
            },
            error: function(xhr, status, error) {
                dialog_error({
                    header: text_toast_default_error_header,
                    body: text_toast_default_error_body
                });
            }
        });
    }
    // get_work_history_detail_by_id


    function profile_work_history_save_form() {
        var form = document.getElementById('profile_work_history_form');
        var profile_work_history_form = new FormData(form); // Create a FormData object from the form

        var isValid = true;

        // List of fields to exclude from validation

        if ($('#wohr_dept_id').prop('checked')) {
            var excludeFields = ["wohr_admin_id", "wohr_detail_en", "wohr_place_name"];
            // $('#wohr_place_name').val('')
        } else {
            var excludeFields = ["wohr_admin_id", "wohr_detail_en", "wohr_stde_id", "wohr_stuc_id"];
            // $('#wohr_structure').val('null').trigger('change');
        }

        // Validate regular form controls
        $('#profile_work_history_form .form-control').each(function() {
            var fieldName = $(this).attr('name');
            if (!excludeFields.includes(fieldName)) {
                if ($(this).val() === '' || $(this).val() === null) {
                    isValid = false;
                    $(this).removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
                } else {
                    $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
                }
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
            }
        });

        // Validate Select2 elements
        $('#profile_work_history_form .form-select').each(function() {
            var fieldName = $(this).attr('name');
            var fieldValue = $(this).val();

            if (!excludeFields.includes(fieldName)) {
                if ($(this).val() === '' || $(this).val() === 0 || $(this).val() === null) {
                    $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-valid').addClass('is-invalid');
                    isValid = false;
                    $(this).siblings('.invalid-feedback').show();
                } else {
                    $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-invalid').addClass('is-valid');
                    $(this).siblings('.invalid-feedback').hide();
                }

            } else {
                // If there is a value, show as valid
                $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-invalid').addClass('is-valid');
                $(this).siblings('.invalid-feedback').hide();
            }
        });

        if (isValid) {
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>profile_work_history_update',
                type: 'POST',
                data: profile_work_history_form,
                contentType: false, // Required for file uploads
                processData: false, // Required for file uploads
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.data.status_response == status_response_success) {
                        dialog_success({
                            'header': text_toast_save_success_header,
                            'body': data.data.message_dialog
                        }, data.data.return_url, false);
                    } else if (data.data.status_response == status_response_error) {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': data.data.message_dialog
                        });
                    }

                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            });
        }
    }
</script>