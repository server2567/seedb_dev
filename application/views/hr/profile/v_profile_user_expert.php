<form method="post" class="needs-validation" id="profile_expert_form" enctype="multipart/form-data" novalidate>                       
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">       
    <input type="hidden" name="expt_id" id="expt_id" value="">    
    <input type="hidden" name="tab_active" id="tab_active" value="6">                          
    <div class="row g-3">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bi bi-emoji-laughing icon-menu font-20"></i> จัดการข้อมูลความเชี่ยวชาญ/ความชำนาญ
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body row">
                            <div class="col-md-12">
                                <label for="expt_title_th" class="form-label required">เรื่อง (ภาษาไทย)</label>
                                <input type="text" class="form-control" id="expt_title_th" name="expt_title_th" placeholder="ระบุเรื่องที่ชำนาญ เช่น การสอน การบริหาร ฯลฯ">
                            </div>
                            <div class="col-md-12">
                                <label for="expt_title_en" class="form-label required">เรื่อง (ภาษาอังกฤษ)</label>
                                <input type="text" class="form-control" id="expt_title_en" name="expt_title_en" placeholder="Tech Management Computer etc.">
                            </div>
                            <div class="col-md-12">
                                <label for="expt_detail_th" class="form-label">รายละเอียด (ภาษาไทย)</label>
                                <textarea class="form-control" name="expt_detail_th" id="expt_detail_th" rows="6" placeholder="ตำแหน่ง: แพทย์จักษุ
ระยะเวลา: มกราคม 2563 - ธันวาคม 2566

ได้มีโอกาสทำงานที่โรงพยาบาลจักษุสุราษฎร์ ในฐานะแพทย์จักษุ ซึ่งได้พัฒนาความเชี่ยวชาญและความชำนาญในด้านต่างๆ ดังนี้:

1. การตรวจวินิจฉัยและการดูแลโรคตา
- มีทักษะในการวินิจฉัยและดูแลรักษาโรคตาต่างๆ เช่น ต้อกระจก ต้อหิน โรคจอประสาทตา และการติดเชื้อในดวงตา
- มีความชำนาญในการใช้เครื่องมือและเทคโนโลยีที่ทันสมัยในการวินิจฉัยโรคตา

2. การผ่าตัดและการรักษาขั้นสูง
- เชี่ยวชาญในการผ่าตัดต้อกระจกและต้อหิน รวมถึงการผ่าตัดด้วยเลเซอร์เพื่อแก้ไขปัญหาสายตาต่างๆ
- มีประสบการณ์ในการจัดการกับภาวะแทรกซ้อนหลังการผ่าตัดและการฟื้นฟูสุขภาพดวงตา

3. การให้คำปรึกษาและการดูแลแบบองค์รวม
- เชี่ยวชาญในการให้คำปรึกษาและแนะนำผู้ป่วยเกี่ยวกับการรักษาและการป้องกันโรคตา
- ทำงานร่วมกับทีมแพทย์และพยาบาลในการดูแลและติดตามผลการรักษาผู้ป่วยอย่างครบวงจร"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="expt_detail_en" class="form-label">รายละเอียด (ภาษาอังกฤษ)</label>
                                <textarea class="form-control" name="expt_detail_en" id="expt_detail_en" rows="6" placeholder="Position: Ophthalmologist
Duration: January 2020 - December 2023

During my tenure at Surat Eye Hospital as an ophthalmologist, I developed expertise and specialization in the following areas:

1. Diagnosis and Management of Eye Diseases
- Skilled in diagnosing and managing various eye diseases such as cataracts, glaucoma, retinal disorders, and eye infections.
- Proficient in using advanced diagnostic tools and technologies for eye disease detection.

2. Advanced Surgical Procedures and Treatments
- Specialized in performing cataract and glaucoma surgeries, including laser surgeries for various vision correction needs.
- Experienced in managing post-operative complications and ensuring successful recovery of eye health.

3. Comprehensive Consultation and Patient Care
- Expert in providing consultations and advising patients on treatment options and preventive measures for eye diseases.
- Collaborated with a multidisciplinary team of doctors and nurses to deliver holistic patient care and follow-up."></textarea>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <!-- <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url()."/".$controller_dir; ?>">ย้อนกลับ</a> -->
                                <button type="button" class="btn btn-success float-end" id="button_profile_expert_save_form" onclick="profile_expert_save_form()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-placement="top">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-table icon-menu font-20"></i>ตารางข้อมูลความเชี่ยวชาญ/ความชำนาญ
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table datatable" id="expert_list" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">เรื่อง (ภาษาไทย)</th>
                                        <th class="text-center">เรื่อง (ภาษาอังกฤษ)</th>
                                        <th class="text-center">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php for ($i = 0; $i < 4; $i++) { ?>
                                        <tr>
                                            <td>
                                                <div class="text-center"><?php echo $i + 1; ?></div>
                                            </td>
                                            <td>
                                                <div class="text-start">การพยาบาล</div>
                                            </td>
                                            <td>
                                                <div class="text-start">----</div>
                                            </td>
                                            <td>
                                                <div class="text-center option">
                                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Profile_user/get_Profile_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                                                    <button class="btn btn-danger" data-url="<?php echo base_url() ?>index.php/ums/User/delete/<?php echo 1 ?>"><i class="bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
    var data_expert_list_table = $('#expert_list').DataTable();
    var expt_id = $('#expt_id').val();
    var tab_active = $('#profile_expert_form #tab_active').val();

    // Function to update DataTable based on select dropdown values
    function updateDataTable() {
        var ps_id = $('#ps_id').val();

        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>get_profile_person_expert_list',
            type: 'GET',
            data: { 
                ps_id: ps_id
            },
            success: function(data) {
                // Clear existing data_expert_list_table data
                data = JSON.parse(data);
                data_expert_list_table.clear().draw();

                $(".summary_person").text(data.length);
                // Add new data to data_expert_list_table
                data.forEach(function(row, index) {
                     // Create new variables for combined title and detail
                    var titleThWithDetail = row.expt_title_th + (row.expt_detail_th != "" ? " (" + row.expt_detail_th + ")" : "");
                    var titleEnWithDetail = row.expt_title_en + (row.expt_detail_en != "" ? " (" + row.expt_detail_en + ")" : "");
                    row.expt_detail_th = (row.expt_detail_th != "" ? row.expt_detail_th : "-");
                    row.expt_detail_en = (row.expt_detail_en != "" ? row.expt_detail_en : "-");

                    var button =    `  <div class="text-center option">
                                            <button type="button" class="btn btn-warning" onclick="get_expert_detail_by_id('${row.expt_id}')" title="คลิกเพื่อแก้ไขข้อมูล" data-toggle="tooltip" data-bs-placement="top">
                                                <i class="bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="modal_confirm_delete(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-bs-placement="top"
                                            data-id="${row.expt_id}" 
                                                data-tab="${tab_active}"
                                                data-table="expert" 
                                                data-topic="ความเชี่ยวชาญ/ความชำนาญ" 
                                                data-index="${(index+1)}" 
                                                data-detail="
                                                    <div>
                                                        <h6>เรื่อง (ภาษาไทย)</h6>
                                                        <p>${replaceQuotes(row.expt_title_th)}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>รายละเอียด (ภาษาไทย)</h6>
                                                        <p>${replaceQuotes(row.expt_detail_th)}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>เรื่อง (ภาษาอังกฤษ)</h6>
                                                        <p>${replaceQuotes(row.expt_title_en)}</p>
                                                    </div>
                                                    <div>
                                                        <h6>รายละเอียด (ภาษาอังกฤษ)</h6>
                                                        <p>${replaceQuotes(row.expt_detail_en)}</p>
                                                    </div>">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                    `;
                data_expert_list_table.row
                .add([
                        (index+1),
                        titleThWithDetail,
                        titleEnWithDetail,
                        button  
                    ]).draw();
                });
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
            }
        });
    }

    // Initial DataTable update
    updateDataTable();

});

function get_expert_detail_by_id(expt_id) {
    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>get_expert_detail_by_id/' + expt_id,
        type: 'POST',
        data: { 
            expt_id: expt_id 
        },
        success: function(data) {
            data = JSON.parse(data);

            if (data.length > 0) {
                var expert = data[0];

                $('#expt_id').val(expert.expt_id);
                $('#expt_title_th').val(expert.expt_title_th);
                $('#expt_title_en').val(expert.expt_title_en);
                $('#expt_detail_th').text(expert.expt_detail_th);
                $('#expt_detail_en').text(expert.expt_detail_en);
                
                $('#profile_expert_form #collapseOne').addClass('show');
                $('html, body').animate({ scrollTop: 0 }, 0);
            }
        },
        error: function(xhr, status, error) {
            dialog_error({ header: text_toast_default_error_header, body: text_toast_default_error_body });
        }
    });
}
// get_expert_detail_by_id


function profile_expert_save_form() {
    var form = document.getElementById('profile_expert_form');
    var profile_expert_form = new FormData(form); // Create a FormData object from the form

    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>profile_expert_update',
        type: 'POST',
        data: profile_expert_form,
        contentType: false, // Required for file uploads
        processData: false, // Required for file uploads
        success: function(data) {
            data = JSON.parse(data);
            // console.log(data.data.status_response)
            if (data.data.status_response == status_response_success) {
                dialog_success({'header': text_toast_save_success_header, 'body': data.data.message_dialog}, data.data.return_url, false);
            } else if (data.data.status_response == status_response_error) {
                dialog_error({'header':text_toast_default_error_header, 'body': data.data.message_dialog});
            } 

        },
        error: function(xhr, status, error) {
            dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
    
}

</script>

   