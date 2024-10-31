<?php $this->load->view($view_dir . 'v_manage_trello_style'); ?>

<?php 
  $colorSchemes = [
    1 => ['background-color' => '#FFDAB9', 'color' => '#811d0b'], 
    2 => ['background-color' => '#d7efff', 'color' => '#0033A0'], 
    3 => ['background-color' => '#BFFFC6', 'color' => '#004d3b'], 
    4 => ['background-color' => '#E6E6FA', 'color' => '#3f3578'], 
    5 => ['background-color' => '#fafac8', 'color' => '#574900'], 
    6 => ['background-color' => '#ffc5ea', 'color' => '#5f0b41'], 
    7 => ['background-color' => '#B0E57C', 'color' => '#1e651e'], 
    8 => ['background-color' => '#ffe5c4', 'color' => '#d37400'], 
    9 => ['background-color' => '#F0D9FF', 'color' => '#371359'], 
    10 => ['background-color' => '#ffa1a1', 'color' => '#7f2200'], 
  ];
  ?>
  
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button " type="button"  data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                    <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูลผู้ป่วย</span><span class="badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="row">
                        
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label ">วัน/เดือน/ปี ที่ดำเนินการ</label>
                            <input type="text" class="form-control datepicker_th" name="year-bh" id="year-bh" value="" placeholder="เลือกวันที่นัดหมาย">
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="" class="form-label ">ชั้น</label><br>
                          <select class="form-select select2" data-placeholder="-- กรุณาเลือกชั้น --" name="floor" id="floor">
                                <option value="1" <?php echo $floor == 1 ? 'selected' : ''; ?>>ชั้นที่ 1</option>
                                <option value="2" <?php echo $floor == 2 ? 'selected' : ''; ?>>ชั้นที่ 2</option>
                          </select>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="" class="form-label ">แผนก</label><br>
                          <select class="form-select select2-multiple" data-placeholder="-- กรุณาเลือกแผนก --" name="department" id="department" multiple>
                          </select>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="" class="form-label ">ชื่อแพทย์</label><br>
                          <select class="form-select select2" data-placeholder="-- กรุณาเลือกชื่อแพทย์ --" name="doctor">
                          </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label ">Visit</label>
                            <input type="number" class="form-control" name="" id="visit-id" step=""  placeholder="Visit Id" value="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label ">HN</label>
                            <input type="number" class="form-control" name="" id="patient-id" step=""  placeholder="HN" value="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label ">ชื่อ-นามสกุล ผู้ป่วย</label>
                            <input type="text" class="form-control" name="" id="patient-name" step=""  placeholder="ชื่อ-นามสกุลผู้ป่วย" value="">
                        </div>
                        <!-- <div class="col-md-4 mb-3">
                          <label for="" class="form-label ">สถานะ</label><br>
                          <select class="form-select select2" data-placeholder="-- กรุณาเลือกสถานะ --" name="sta">
                              <option value="" ></option>
                              <?php // foreach($get_status as $ps) { ?>
                                <option value="<?php //echo $ps['sta_id']?> "><?php //echo $ps['sta_name']; ?> </option>
                            <?php // } ?>
                          </select>
                        </div> -->
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary float-end me-5" onclick="search_que()"><i class="bi-search icon-menu"></i>&nbsp;ค้นหา&emsp;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
                    <i class="bi-newspaper icon-menu"></i><span class="span-stde pe-1"></span><span class="span-date pe-1"></span> <span class="badge bg-success font-14 badge-count-total"></span>
                </button>
            </h2>
            <div id="collapseTable" class="accordion-body">
                <div class="accordion-collapse collapse show">
                    <div class="scrollbar-top-container">
                        <div class="scrollbar-top"></div>
                    </div>
                    <div class="container-que scroll-x-container">
                        <!-- Spinner Overlay -->
                        <div class="spinner-overlay d-none justify-content-center align-items-center d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card m-3 p-2 pb-0">
                                <div class="card-header bg-warning text-white mb-2">
                                    <p class="mb-2 text-black">รอระบุแพทย์</p>
                                    <div class="patient-count text-black"></div>
                                </div>
                                <div class="sortable-list p-0" id="tasks-wait" data-ps-id="">
                                    <!-- Tasks will be dynamically added here -->
                                </div>
                            </div>
                        </div>
                        <?php foreach ($get_doctors as $index => $doctor): 
                            $bg_color = isset($colorSchemes[$index+1]) ? 
                                'background-color: '.$colorSchemes[$index+1]['background-color'].';'
                                .'color: '.$colorSchemes[$index+1]['color'].';'
                                : '';
                            ?>
                            <div class="col-md-4" style="display:none;">
                                <div class="card m-3 p-2 pb-0">
                                    <div class="card-header fw-bold mb-2" style="<?php echo $bg_color; ?>">
                                        <div class="doctor-detail">
                                            <p class="mb-1 room-name-text" 
                                                data-doctor-id="<?php echo $doctor['ps_id']; ?>" 
                                                data-ori-rm-id="<?php echo $doctor['rm_id']; ?>"
                                                data-psrm-id="<?php echo $doctor['psrm_id']; ?>">
                                                <?php echo $doctor['rm_name']; ?>
                                            </p>
                                            <span class="room-name-select" style="display: none;" 
                                                data-doctor-id="<?php echo $doctor['ps_id']; ?>">
                                                <select class="form-select select2 select2-rm" 
                                                    name="psrm-<?php echo $doctor['ps_id']; ?>" 
                                                    id="psrm-<?php echo $doctor['ps_id']; ?>" 
                                                    data-placeholder="-- กรุณาเลือกห้อง --" >
                                                    <option value=""></option>
                                                    <?php foreach ($rooms as $row) { 
                                                        $select = '';
                                                        $stde_name_th = '';
                                                        if(($row['rm_id'] == $doctor['rm_id'])) {
                                                            $select = 'selected';
                                                            $stde_name_th = $row['stde_name_th'];
                                                        }
                                                        ?>
                                                        <option value="<?php echo $row['rm_id']; ?>" <?php echo $select ; ?> data-stde="<?php echo $row['stde_name_th']; ?>" data-floor="<?php echo $row['rm_floor']; ?>">
                                                            <?php echo $row['rm_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <button class="btn btn-danger btn-cancel">ยกเลิก</button>
                                                <button class="btn btn-success btn-save">บันทึก</button>
                                            </span>
                                            <p class="mb-2 stde-name-th" data-doctor-id="<?php echo $doctor['ps_id']; ?>"><?php echo empty($stde_name_th) ? '(แผนก -)' : $stde_name_th; ?></p>
                                            <p class="mb-1"><?php echo $doctor['ps_name']; ?></p>
                                        </div>
                                        <div class="patient-count" style="margin-left: -20px;"></div>
                                    </div>
                                    <div class="sortable-list p-0" id="tasks-walkin-<?php echo $doctor['ps_id']; ?>" data-ps-id="<?php echo $doctor['ps_id']; ?>">
                                        <!-- Tasks will be dynamically added here -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="card m-3 p-2 pb-0">
                                    <div class="card-header fw-bold mb-2" style="<?php echo $bg_color; ?>">
                                        <div class="doctor-detail">
                                            <p class="mb-1 room-appointment" 
                                                data-doctor-id="<?php echo $doctor['ps_id']; ?>">
                                                ผู้ป่วยนัดหมาย
                                            </p>
                                            <p class="mb-2 stde-name-th" data-doctor-id="<?php echo $doctor['ps_id']; ?>"><?php echo empty($stde_name_th) ? '(แผนก -)' : $stde_name_th; ?></p>
                                            <p class="mb-1"><?php echo $doctor['ps_name']; ?></p>
                                        </div>
                                        <div class="patient-count" style="margin-left: -20px;"></div>
                                    </div>
                                    <div class="sortable-list p-0" id="tasks-appointment-<?php echo $doctor['ps_id']; ?>" data-ps-id="<?php echo $doctor['ps_id']; ?>">
                                        <!-- Tasks will be dynamically added here -->
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="col-md-4">
                            <div class="card m-3 p-2 pb-0">
                                <div class="card-header bg-success text-white mb-2">
                                    <p class="mb-2">พบแพทย์เสร็จสิ้น</p>
                                    <div class="patient-count"></div>
                                </div>
                                <div class="sortable-list" id="tasks-success" data-ps-id="">
                                    <!-- Tasks will be dynamically added here -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card m-3 p-2 pb-0">
                                <div class="card-header bg-danger text-white mb-2">
                                    <p class="mb-2">ยกเลิกการจองคิว</p>
                                    <div class="patient-count"></div>
                                </div>
                                <div class="sortable-list p-0" id="tasks-cancel" data-ps-id="">
                                    <!-- Tasks will be dynamically added here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-actions">
    <button class="action-btn btn btn-success" onclick="save_data()">บันทึกข้อมูล</button>
    <!-- <button class="action-btn cancel-btn">Cancel</button> -->
</div>

<!-- Modal -->
<div class="modal fade" id="modal-ntr" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-card-heading icon-menu font-20"></i>
                    <span>รายละเอียดข้อมูลผลตรวจจากห้องปฏิบัติการทางการแพทย์</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
            <div id="notification-result-data"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-ntr" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-card-heading icon-menu font-20"></i>
                    <span>รายละเอียดข้อมูลผลตรวจจากห้องปฏิบัติการทางการแพทย์</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="notification-result-data"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-apm" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-card-heading icon-menu font-20"></i>
                    <span>รายละเอียดการลงทะเบียน</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="appointment-data"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-note" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-card-heading icon-menu font-20"></i>
                    <span>รายละเอียดการประกาศ</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="note-data">
                <div class="mb-3">
                    <label for="note-text" class="form-label">ข้อความประกาศ</label>
                    <textarea class="form-control" id="note-text" rows="4"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="an_time_start" class="form-label required">เวลาเริ่มต้น</label>
                        <input type="text" class="form-control" name="an_time_start" id="an_time_start" maxlength="5" placeholder="HH:MM" pattern="[0-9]{2}:[0-9]{2}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="an_time_end" class="form-label required">เวลาสิ้นสุด</label>
                        <input type="text" class="form-control" name="an_time_end" id="an_time_end" maxlength="5" placeholder="HH:MM" pattern="[0-9]{2}:[0-9]{2}" required>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
    <input type="hidden" id="card-id" value="">
    <button type="button" class="btn btn-success" onclick="saveNote()">บันทึก</button>
</div>
        </div>
    </div>
</div>

<script>
function setCurrentTime() {
    const now = new Date();
    let hours = now.getHours().toString().padStart(2, '0'); // Add 0 if single digit
    let minutes = now.getMinutes().toString().padStart(2, '0'); // Add 0 if single digit
    const timeString = `${hours}:${minutes}`;

    // Set the time only for the start input
    document.getElementById('an_time_start').value = timeString;
    document.getElementById('an_time_end').value = ''; // Leave end time empty
}

document.querySelectorAll('#an_time_start, #an_time_end').forEach(function(input) {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, ''); // Remove all non-numeric characters
        if (value.length >= 3) {
            // If there are at least 3 digits, add a colon
            value = value.slice(0, 2) + ':' + value.slice(2);
        }
        e.target.value = value;
    });
});

// Call the function to set the current time when the page loads
window.onload = setCurrentTime;
</script>
<!-- Defined variable -->
<script>
    var doctors = <?php echo json_encode($get_doctors); ?>;
    var rooms = <?php echo json_encode($rooms); ?>;
    var patients_by_doctors = [];
    var search_params = [];
    let refreshInterval;
    let floor = '<?php echo isset($floor) && !empty($floor) ? $floor : ""; ?>';

    let index_tools = 0;
    let order_tools = 0;
    let index_draft_tools = 0;
    let order_draft_tools = 0;
    let refreshInterval_modal;
    let url_temp = '';
    let is_first_load_exr = true;
</script>

<script>
    $(function(){
        // Set the width of the custom scrollbar to match the content width of the scroll-x-container
        $(".scrollbar-top").width($(".scroll-x-container")[0].scrollWidth);

        // Scroll event on the scroll-x-container (main content)
        $(".scroll-x-container").on('scroll', function() {
            $(".scrollbar-top-container").scrollLeft($(this).scrollLeft());
        });

        // Scroll event on the custom scrollbar (scrollbar-top-container)
        $(".scrollbar-top-container").on('scroll', function() {
            $(".scroll-x-container").scrollLeft($(this).scrollLeft());
        });
    });

    $(document).ready(function() {
        if (is_null(floor)) {
            
            let html = `<select class="form-select select2" data-placeholder="-- กรุณาเลือกชั้น --" name="session_floor" id="session_floor">
                            <option value=""></option>
                            <option value="1">ชั้นที่ 1</option>
                            <option value="2">ชั้นที่ 2</option>
                        </select>
                        `
            let url = "<?php echo base_url() ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_set_wts_floor_of_manage_queue"
            Swal.fire({
                title: "กรุณาเลือกชั้นที่กำลังประจำการ",
                html: html,
                icon: "warning",
                confirmButtonColor: "#198754",
                confirmButtonText: "ยืนยัน",
                allowOutsideClick: false,
                preConfirm: () => {
                    const selectedId = document.getElementById('session_floor').value;
                    return selectedId ? selectedId : Swal.showValidationMessage('-- กรุณาเลือกชั้น --');
                    // const selectedStde = document.getElementById('session_stde').value;
                    // return selectedStde ? selectedStde : Swal.showValidationMessage('-- กรุณาเลือกแผนก --');
                },
                didOpen: () => {
                    $('#session_floor').select2({
                        theme: "bootstrap-5",
                        dropdownParent: $('.swal2-popup')
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        wts_floor_of_manage_queue: result.value
                    },
                    success: function(data) {
                    if (data.data.status_response == status_response_success) {
                        window.location.reload();
                    } else {
                        Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                        });
                    }
                    },
                    error: function(xhr, status, error) {
                    console.error(xhr);
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    }
                });
                }
            });
        } else {
            search_params = getSearchParams();
            
            reload_que()
            reset_interval(); // Initial call to set the interval
            // search_params = getSearchParams();
        }
        // search_params = getSearchParams();
        // reload_que()
        // reset_interval(); // Initial call to set the interval
        // // search_params = getSearchParams();

        // set dropdown select
        set_department_select();
        $('#floor').on('change', function() {
            set_department_select();
        });
        set_doctors_select();
        $('#department').on('change', function() {
            set_doctors_select();
        });
        set_rooms_select();

        // $('.select2-rm, select[name="department"]').each(function() {
        $('.select2-rm, select[name="floor"]').each(function() {
            $(this).select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                allowClear: false // Set allowClear as needed
            });
        });

        // trigger change room
        $('.room-name-text').click(function() {
            let roomName = $(this);
            let doctorId = roomName.data('doctor-id');
            $('.stde-name-th[data-doctor-id="' + doctorId + '"]').hide();
            $('.room-name-select[data-doctor-id="' + doctorId + '"]').show();
            $(this).hide(); // room-name-select
        });
        $('.room-name-select .btn-cancel').click(function() {
            // get original id
            let select = $(this).closest('.room-name-select');
            let doctorId = select.data('doctor-id');
            let text = $('.room-name-text[data-doctor-id="' + doctorId + '"]');
            let stdeText = $('.stde-name-th[data-doctor-id="' + doctorId + '"]');
            let ori = text.data('ori-rm-id');

            // set in select2
            $('#psrm-' + doctorId).val(ori).trigger('change');

            // hide/show element
            text.show();
            stdeText.show();
            select.hide();
        });
        $('.room-name-select .btn-save').click(function() {
            // get original id
            let select = $(this).closest('.room-name-select');
            let doctorId = select.data('doctor-id');
            let text = $('.room-name-text[data-doctor-id="' + doctorId + '"]');
            let stdeText = $('.stde-name-th[data-doctor-id="' + doctorId + '"]');
            let ori = text.data('ori-rm-id');
            let psrm_id = text.data('psrm-id');
            // let stde = select.data('stde');

            // get value from select
            let val = $('#psrm-' + doctorId + ' option:selected').val();
            var valText = $('#psrm-' + doctorId + ' option:selected').text();
            var valStdeText = $('#psrm-' + doctorId + ' option:selected').data('stde');

            if(val != '') {
                // update html
                text.data('ori-rm-id', val);
                text.html(valText);
                stdeText.html(valStdeText);

                // update in db
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_update_room',
                    data: {
                        psrm_id: psrm_id,
                        psrm_ps_id: doctorId,
                        psrm_rm_id: val,
                        psrm_date: search_params['date']
                    },
                    dataType: 'json', // Expect JSON response from the server
                    success: function(data) {
                        if (data.status_response == status_response_success && data.psrm_id != null) {
                            text.data('psrm-id', data.psrm_id);
                            // dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, null, false);
                        } else{
                            dialog_error({ 'header': text_toast_save_error_header, 'body': text_toast_save_error_body });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
            }

            // hide/show element
            text.show();
            stdeText.show();
            select.hide();
        });
    });
</script>
<script>
    function get_patient_by_doctor(is_from_save) {
        var ps_id = parseInt(search_params['doctor']);
        if(!isNaN(ps_id)) {
            check_doctors_ajax(ps_id)
            get_patient_ajax(ps_id, null, is_from_save);
        } else {
            check_doctors_ajax()
            doctors.forEach(function(doctor) {
                get_patient_ajax(doctor.ps_id, null, is_from_save);
            });
        }
    }

    function get_patient_ajax(ps_id, status = null, is_from_save = false) {
        var sta_id = null;
        var is_null_ps_id = false;
        var is_process = false;
        var arr_selector = [];
        // var ori_list_id = 'tasks-walkin-' + ps_id;
        // var apm_list_id = '';
        if(status == 'wait') { 
            sta_id = 4 // ออกหมายเลขคิว
            is_null_ps_id = true;
            arr_selector.push('tasks-wait');
            // ori_list_id = 'tasks-wait';
            // tasksContainer = $('#tasks-wait');
        } else if(status == 'success') {
            sta_id = 10 // พบแพทย์เสร็จสิ้น
            arr_selector.push('tasks-success');
            // ori_list_id = 'tasks-success';
            // tasksContainer = $('#tasks-success');
        }  else if(status == 'cancel') {
            sta_id = 9 // ยกเลิกการจองคิว
            arr_selector.push('tasks-cancel');
            // ori_list_id = 'tasks-cancel';
            // tasksContainer = $('#tasks-cancel');
        } else {
            arr_selector.push('tasks-walkin-' + ps_id, 'tasks-appointment-' + ps_id);
            // apm_list_id = 'tasks-appointment-' + ps_id;
            is_process = true;
        }
        // var tasksContainer = $('#' + ori_list_id);
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_get_ques',
            type: 'POST',
            data: {
                doctor: ps_id,
                sta_id: sta_id,
                is_null_ps_id: is_null_ps_id,
                is_process: is_process,

                date: search_params['date'],
                floor: search_params['floor'],
                department: search_params['department'],
                // sta_id: search_params['sta'],
                patientId: search_params['patientId'],
                visitId: search_params['visitId'],
                patientName: search_params['patientName'],
            },
            success: function(response) {
                var result = JSON.parse(response);
                // Clear the existing content in the tasks container
                // tasksContainer.html('');
                    
                // Array to hold apm_ql_code values
                var apmQlCodes = [];

                // Iterate over the tasks in the result (assuming result.tasks contains the tasks)
                // con
                let announce_card_count = 1;

                arr_selector.forEach(function(selector, index_selector) {
                    var tasksContainer = $('#' + selector);
                    result.tasks.forEach(function(task, index) {
                        // 0. check walk-in and appointment use break for stop process append
                        // 0.1 if walk-in then container = 'tasks-walkin-' + ps_id
                        // 0.2 if appointment 'tasks-appointment-' + ps_id
                        // but priority of qus_app_walk > (apm_app_walk + apm_pri_id)
                        let apm_pri_id = parseInt(task.apm_pri_id);
                        let qus_app_walk = task.qus_app_walk;
                        let apm_app_walk = task.apm_app_walk;
                        if (selector.includes('tasks-walkin')) {
                            if (qus_app_walk != null) {
                                if (!(qus_app_walk == 'W'))
                                    return; // Exit the loop iteration if the condition is not met
                            } else {
                                if (!(apm_app_walk == 'W' && (apm_pri_id === 2 || apm_pri_id === 5)))
                                    return; // Exit the loop iteration if the condition is not met
                            }
                        } else if (selector.includes('tasks-appointment')) {
                            if (qus_app_walk != null) {
                                if (!(qus_app_walk == 'A'))
                                    return; // Exit the loop iteration if the condition is not met
                            } else {
                                if (!(apm_app_walk == 'A' || apm_pri_id === 1 || apm_pri_id === 3 || apm_pri_id === 4))
                                    return; // Exit the loop iteration if the condition is not met
                            }
                        }

                        // 1. check duplicate apm_ql_code
                        // 1.1 if duplicate then update status if status has changed
                        // 1.2 if not duplicate then append in card of doctor
                        let isDuplicate = false; // Track whether the task is a duplicate
                        patients_by_doctors.forEach(function(doctorRecord, index) {
                            if(doctorRecord.ps_id === ps_id) {
                                doctorRecord.patient_ques.forEach(function(que, index2) {
                                    if (que.apm_ql_code === task.apm_ql_code) {
                                        isDuplicate = true;

                                        // Update the text and button for the existing task
                                        let taskElement = $('[data-task-id="' + task.apm_ql_code + '"]');

                                        // Check if the status has changed
                                        if (que.apm_sta_id !== task.apm_sta_id) {
                                            // Update the status text and status icon class
                                            taskElement.find('.status-text').html('<i class="bi-circle-fill me-2 ' + task.status_class + '"></i>' + task.status_text);

                                            // Update the button(s)
                                            taskElement.find('.task-buttons').html(task.btn);
                                        }

                                        // Check change bg-color
                                        if (taskElement.hasClass('bg-success-light')) {
                                            let dateTimeString = task.ntdp_date_start + ' ' + task.ntdp_time_start;
                                            let taskDateTime = new Date(dateTimeString);
                                            let time = '-';

                                            if (!isNaN(taskDateTime.getTime())) {
                                                let currentDateTime = new Date();

                                                // Calculate the difference in milliseconds
                                                let timeDiff = currentDateTime - taskDateTime;

                                                // Convert the difference to minutes
                                                let diffMinutes = Math.floor(timeDiff / 1000 / 60);

                                                if (diffMinutes >= 5) {
                                                    // If the difference is 5 minutes or more, change the background class
                                                    taskElement.removeClass('bg-success-light').addClass('bg-white');
                                                }
                                            } else {
                                                taskElement.removeClass('bg-success-light').addClass('bg-white');
                                            }
                                        }
                                    }
                                });
                            }
                        });
                        if (!isDuplicate) {
                            apmQlCodes.push({
                                apm_id: task.apm_id,
                                apm_ql_code: task.apm_ql_code,
                                apm_sta_id: task.apm_sta_id,
                                btn: task.btn,
                            });

                            if(!is_from_save) {
                                // เวลาที่นัดหมาย
                                let timeApmArr = task.apm_time.split(':');
                                timeApm = timeApmArr[0] + ':' + timeApmArr[1] + ' น.';

                                // เวลาที่เข้าแผนก
                                let bg_class = 'bg-success-light';
                                // Combine the date and time into a single Date object
                                let dateTimeString = task.ntdp_date_start + ' ' + task.ntdp_time_start;
                                let taskDateTime = new Date(dateTimeString);
                                let time = '-';

                                if (!isNaN(taskDateTime.getTime())) {
                                    let currentDateTime = new Date();

                                    // Calculate the difference in milliseconds
                                    let timeDiff = currentDateTime - taskDateTime;

                                    // Convert the difference to minutes
                                    let diffMinutes = Math.floor(timeDiff / 1000 / 60);

                                    if (diffMinutes >= 5) {
                                        // If the difference is 5 minutes or more, change the background class
                                        bg_class = 'bg-white';
                                    }

                                    // Optional: Format the time to display only hours and minutes
                                    let timeArray = task.ntdp_time_start.split(':');
                                    time = timeArray[0] + ':' + timeArray[1];
                                } else {
                                    bg_class = 'bg-white';
                                }

                                let pri_name = task.pri_name;
                                let pri_color = task.pri_color;
                                if (task.apm_app_walk == 'A') {
                                    if (task.apm_pri_id === 5 || task.apm_pri_id === 4) { // ดัก
                                    pri_name = 'นัดหมาย';
                                    pri_color = '#00FF44';
                                    }
                                }
                                // if(task.apm_app_walk == 'A') {
                                //     pri_name = 'นัดหมาย';
                                //     pri_color = '#00FF44';
                                // } else if(!task.pri_name && !task.pri_color && task.apm_app_walk) {
                                //     pri_name = task.apm_app_walk == 'W' ? 'Walk-in' : 'นัดหมาย';
                                //     pri_color = task.apm_app_walk == 'W' ? '#012970' : '#00FF44';
                                // }
                                // Manually create the HTML string
                                if(!task.announce) {
                                    var taskHtml = '<div class="sortable-item card-body rounded ' + bg_class + ' shadow-2 mb-2" data-task-id="' + task.apm_ql_code + '" data-task-apm-id="' + task.apm_id + '" data-origin-list-id="' + selector + '">';
                                    taskHtml += '  <div class="task-header">';
                                    taskHtml += '    <div class="task-que">';
                                    taskHtml += '       <span class="order-number">' + (index + 1) + '. </span>';
                                    taskHtml += '       <span class="que-text">หมายเลขคิว ' + task.apm_ql_code + '</span>';
                                    taskHtml += '    </div>';
                                    taskHtml += '  </div>';
                                    taskHtml += '  <div class="task-body mb-1">';
                                    taskHtml += '    <div class="task-status">';
                                    taskHtml += '       <span class="status-text"><i class="bi-circle-fill me-2 ' + task.status_class + '"></i>' + task.status_text + '</span>';
                                    taskHtml += '    </div>';
                                    taskHtml += '  </div>';
                                    taskHtml += '  <div class="task-body">';
                                    taskHtml += '    <div class="task-patient">';
                                    taskHtml += '      <p class="m-0"> <b>Visit:</b> ' + task.apm_visit + '</p>';
                                    taskHtml += '      <p class="m-0"> <b>ชื่อผู้ป่วย:</b> ' + task.pt_name + '</p>';
                                    taskHtml += '    </div>';
                                    taskHtml += '  </div>';
                                    taskHtml += '  <div class="task-body">';
                                    taskHtml += '    <div class="task-priority">';
                                    // taskHtml += '      <span class="priority-text p-2" style="background-color: ' + task.pri_color + ';">' + task.pri_name + '</span>';
                                    taskHtml += '      <span class="type-text">' + (task.apm_patient_type == 'old' ? 'ผู้ป่วยเก่า' : 'ผู้ป่วยใหม่') + ' </span>';
                                    taskHtml += '      <span class="priority-text" style="color: ' + pri_color + ';">(' + pri_name + ')</span>';
                                    taskHtml += '    </div>';
                                    taskHtml += '  </div>';
                                    taskHtml += '  <div class="task-body">';
                                    taskHtml += '    <div class="task-time">';
                                    taskHtml += '       <span class="time-text"><b>เวลาที่นัดหมาย:</b> ' + timeApm + ' </span>';
                                    taskHtml += '    </div>';
                                    taskHtml += '  </div>';
                                    taskHtml += '  <div class="task-body">';
                                    taskHtml += '    <div class="task-time">';
                                    taskHtml += '       <span class="time-text"><b>เวลาที่เข้าแผนก:</b> ' + time + ' </span>';
                                    taskHtml += '    </div>';
                                    taskHtml += '  </div>';
                                    taskHtml += '  <div class="task-buttons text-end option">';
                                    taskHtml += task.btn;
                                    taskHtml += '  </div>';
                                    taskHtml += '</div>';

                                    tasksContainer.append(taskHtml);
                                    if((result.tasks[index + 1] && !result.tasks[index + 1].announce) || !result.tasks[index + 1]) {
                                        var additionalCardHtml = '<button type="button" onclick="showModalNote()" class="sortable-item card-body rounded bg-light shadow-2 mb-2 btn btn-primary w-100" id="an_btn" data-card_id="' + announce_card_count + '">';
                                        additionalCardHtml += '  <div class="additional-info text-center">';
                                        additionalCardHtml += '    <i class="bi bi-plus-lg"></i>';
                                        additionalCardHtml += '  </div>';
                                        additionalCardHtml += '</button>';
                                        tasksContainer.append(additionalCardHtml);
                                        announce_card_count++;


                                    }
                                }else{

                                        var additionalCardHtml = '  <div class="sortable-item card-body rounded bg-white shadow-2 mb-2" data-card_id="' + task.apm_id + '" data-announce="' + task.announce + '" data-an_time_start="' + task.announce_time_start + '" data-an_time_end="' + task.announce_time_end + '" id="note_card">';
                                        additionalCardHtml += '      <p class="text-center m-0">' + task.announce + '</p>';
                                        additionalCardHtml += '      <p class="text-center m-0">' + task.announce_time_start + ' น. - ' + task.announce_time_end + ' น.</p>';
                                        additionalCardHtml += '  <div class="task-buttons text-end option">';
                                        additionalCardHtml += '  <button class="btn btn-warning ms-1" onclick="editModalNote(this.parentElement.parentElement)" title="แก้ไขการประกาศ"><i class="bi-pencil-square"></i></button>';
                                        additionalCardHtml += '  <button class="btn btn-danger ms-1" onclick="deleteNoteCard(this.parentElement.parentElement)" title="ลบการประกาศ"><i class="bi-trash"></i></button>';
                                        additionalCardHtml += '  </div>';
                                        additionalCardHtml += '  </div>';

                                        tasksContainer.append(additionalCardHtml);

                                    
                                }
                                $('.tooltips').tooltip();
                            } else {
                                // เขียนเช็คเปลี่ยนข้อมูลที่ sortable-item (update html)
                                const substrings = ['tasks-walkin', 'tasks-appointment'];
                                let is_doctor_card = false;
                                if (substrings.some(substring => selector.includes(substring))) {
                                    is_doctor_card = true;
                                }
                                if (is_doctor_card) {
                                    $(`.sortable-list[data-ps-id="${task.apm_ps_id}"] .sortable-item[data-task-id="${task.apm_ql_code}"]`).each(function() {
                                        update_queue_card($(this), selector, task)
                                    });
                                } else {
                                    $(`.sortable-list#${selector} .sortable-item[data-task-id="${task.apm_ql_code}"]`).each(function() {
                                        update_queue_card($(this), selector, task)
                                    });
                                }
                            }
                        }
                    });
                });
                patients_by_doctors.push({
                    ps_id: ps_id,
                    patient_ques: apmQlCodes
                })
                
                check_sortable_list();

                update_badge_date(result.badge)
            },
            error: function(error) {
                console.error('Error fetching tasks:', error);
            }
        });
    }
//     $(document).on('click', '.btn-primary', function() {
//     // Handle button click action here
//     alert('Button clicked!');
// });
    function update_queue_card(div, selector, task) {
        div.attr('data-origin-list-id', selector);

        // กรณีกดปุ่มบันทึก แล้วมีการย้ายการ์ดเปลี่ยนสถานะคิว
        let status_text = '<i class="bi-circle-fill me-2 ' + task.status_class + '"></i>' + task.status_text;
        div.find('.task-status .status-text').html(status_text);
    }

    function check_doctors_ajax(ps_id = null) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_get_doctors',
            type: 'POST',
            data: {
                doctor: ps_id,
                
                date: search_params['date'],
                floor: search_params['floor'],
                department: search_params['department'],
                // sta_id: search_params['sta'],
                patientId: search_params['patientId'],
                visitId: search_params['visitId'],
                patientName: search_params['patientName'],
            },
            success: function(response) {
                var result = JSON.parse(response);
                // Update room-name-text => Loop through each doctor card to show
                if(result.doctors.length != 0) {
                    $('.doctor-detail .room-name-text').each(function() {
                        var doctorIdElement = $(this);
                        var doctorId = parseInt(doctorIdElement.data('doctor-id'))
                        // Find the doctor object with a matching doctorId
                        var doctorExists = result.doctors.find(function(doctor) {
                            return parseInt(doctor.apm_ps_id) === doctorId;
                        });

                        // For check and show room-appointment class if matching doctorId
                        var appointmentElement = $(`.doctor-detail .room-appointment[data-doctor-id='${doctorId}']`);
                        if (!doctorExists) {
                            // Hide doctor card if doctorId is not found in result.doctors
                            $(this).closest('.col-md-4').hide();

                            if (appointmentElement.length > 0) {
                                appointmentElement.closest('.col-md-4').hide();
                            }
                        } else {
                            // Show doctor card if doctorId is found
                            if(doctorExists.psrm_id != null) {
                                doctorIdElement.data('ori-rm-id', doctorExists.rm_id);
                                doctorIdElement.data('psrm-id', doctorExists.psrm_id);
                                doctorIdElement.html(doctorExists.rm_name);
                                $('.stde-name-th[data-doctor-id="' + doctorId + '"]').html(doctorExists.stde_name_th);
                            } else {
                                doctorIdElement.data('ori-rm-id', '');
                                doctorIdElement.data('psrm-id', '');
                                doctorIdElement.html('เลือกห้องตรวจ');
                                $('.stde-name-th[data-doctor-id="' + doctorId + '"]').html('(แผนก -)');
                            }
                            $(this).closest('.col-md-4').show();

                            if (appointmentElement.length > 0) {
                                appointmentElement.closest('.col-md-4').show();
                            }
                        }
                    });
                } else {
                    // Hide all doctors card
                    $('.doctor-detail').closest('.col-md-4').hide();
                }
            },
            error: function(error) {
                console.error('Error fetching tasks:', error);
                // reject(error);
            }
        });
    }
    
    function set_department_select() {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_get_stdes_select',
            type: 'POST',
            data: {
                // date: document.getElementById('year-bh').value,
                floor: $('#floor').val(),
            },
            success: function(response) {
                var result = JSON.parse(response);
                if(result.stdes_select.length != 0) {
                    var $doctorSelect = $('select[name="doctor"]');
                    var $departmentSelect = $('select[name="department"]');

                    // Clear existing options
                    $doctorSelect.empty();
                    $doctorSelect.prop('disabled', true);
                    $departmentSelect.empty();

                    // Add the placeholder option
                    $departmentSelect.append('<option value=""></option>');

                    // Append new options
                    $.each(result.stdes_select, function(index, stde) {
                        var optionText = stde.stde_name_th;
                        $departmentSelect.append($('<option>', {
                            value: stde.rm_stde_id,
                            text: optionText
                        }));
                    });

                    // Reinitialize Select2
                    $departmentSelect.trigger('change').select2({
                        theme: "bootstrap-5",
                        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                        placeholder: "-- กรุณาเลือกแผนก --",
                        allowClear: true
                    });
                }
            },
            error: function(error) {
                console.error('Error fetching tasks:', error);
            }
        });
    }

    function set_doctors_select() {
        if($('#department').val() == '') {
            // Clear existing options
            var $doctorSelect = $('select[name="doctor"]');
            $doctorSelect.empty();
            $doctorSelect.prop('disabled', true);
        } else {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_get_doctors_select',
                type: 'POST',
                data: {
                    // date: document.getElementById('year-bh').value,
                    // floor: $('#floor').val(),
                    department: $('#department').val(),
                },
                success: function(response) {
                    var $doctorSelect = $('select[name="doctor"]');

                    // Clear existing options
                    $doctorSelect.empty();
                    $doctorSelect.prop('disabled', false);

                    var result = JSON.parse(response);
                    if(result.doctors_select.length != 0) {
                        // Add the placeholder option
                        $doctorSelect.append('<option value=""></option>');

                        // Append new options
                        $.each(result.doctors_select, function(index, doctor) {
                            var optionText = doctor.ps_name;
                            $doctorSelect.append($('<option>', {
                                value: doctor.apm_ps_id,
                                text: optionText
                            }));
                        });

                        // Reinitialize Select2
                        $doctorSelect.trigger('change').select2({
                            theme: "bootstrap-5",
                            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                            placeholder: "-- กรุณาเลือกชื่อแพทย์ --",
                            allowClear: true
                        });
                    }
                },
                error: function(error) {
                    console.error('Error fetching tasks:', error);
                }
            });
        }
    }

    function reset_interval() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
        refreshInterval = setInterval(function() {
            reload_que();
        }, 60000); // 60000 - 1 minute // or datatable_second_reload
    }

    function goto_see_doctor(url, sta_id = 2) {
        let title = 'เรียกพบแพทย์แล้ว';
        let text = '';
        if(sta_id == 10) {
            title = 'พบแพทย์เสร็จสิ้นแล้ว';
            text = '';
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: { sta_id: sta_id },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status_response == "<?php echo $this->config->item('status_response_success'); ?>") {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        customClass: {
                            htmlContainer: 'swal2-html-line-height'
                        },
                    }).then(() => {
                        // if change status => success / cancel
                        if (data.appointment != undefined && data.appointment != null) {
                            let is_break = false;
                            for (let i = 0; i < patients_by_doctors.length; i++) {
                                if (is_break) break;
                                let doctorRecord = patients_by_doctors[i];
                                if (doctorRecord.ps_id === data.appointment.apm_ps_id) {
                                    for (let j = 0; j < doctorRecord.patient_ques.length; j++) {
                                        if (is_break) break;
                                        let que = doctorRecord.patient_ques[j];
                                        if (que.apm_ql_code === data.appointment.apm_ql_code) {
                                            let apm_sta_id = parseInt(data.appointment.apm_sta_id);
                                            if (apm_sta_id === 10 || apm_sta_id === 9) {
                                                // Remove the que from doctorRecord.patient_ques
                                                doctorRecord.patient_ques.splice(j, 1);

                                                // Find and remove the corresponding sortable-item from the DOM
                                                $(`.sortable-list[data-ps-id="${data.appointment.apm_ps_id}"] .sortable-item[data-task-id="${data.appointment.apm_ql_code}"]`).remove();

                                                // Exit both loops
                                                is_break = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        reload_que();
                        //     // goto AMS noti_result
                        // if (data.returnUrl) {
                        //     // window.location.href = data.returnUrl;
                        //     // showModalNtr(data.returnUrl);
                        //     reload_que();
                        //     // reset_interval();
                        //     // $('#dataTable').DataTable().ajax.reload(null, false); // false to stay on the current page
                        // }
                        // else 
                        //     location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading modal content:', error);
            }
        });
    }

    function reload_que(is_from_save = false) {
            get_patient_ajax(null, 'wait', is_from_save) // ยังไม่ได้ระบุแพทย์
            get_patient_by_doctor(is_from_save); // กำลังดำเนินการในแผนก
            get_patient_ajax(null, 'success', is_from_save) // พบแพทย์เสร็จสิ้น
            get_patient_ajax(null, 'cancel', is_from_save) // ยกเลิกการจองคิว
    }

    function search_que() {
        // loading spin
        $('.spinner-overlay').removeClass('d-none');

        // get doctor that date

        // get patient
        setTimeout(function() {
            search_params = getSearchParams();
            clear_que();
            reload_que();
            set_rooms_select();

            $('.spinner-overlay').addClass('d-none');
        }, 3000); // Adjust the time as needed to wait for the operations to complete
    }

    function set_rooms_select() {
        let floor = search_params['floor'];

        // Loop through each select with the class 'select2-rm'
        $('.select2-rm').each(function() {
            var $select = $(this);
            var doctorId = $select.attr('id').split('-')[1];  // Extract doctor ID from the select element's ID
            var $roomNameText = $(`p.room-name-text[data-doctor-id="${doctorId}"]`);  // Find the corresponding <p> element
            var oriRmId = $roomNameText.data('ori-rm-id');  // Get the original room ID (data-ori-rm-id)
            var selectedValue = $select.val();  // Store the current selected value

            // Clear existing options, but keep the name and id attributes intact
            $select.find('option').remove();

            // Add the placeholder option back
            $select.append('<option value=""></option>');

            // Iterate through all the rooms and append options based on the floor
            <?php foreach ($rooms as $row) { ?>
                var optionFloor = <?php echo $row['rm_floor']; ?>;
                var optionValue = '<?php echo $row['rm_id']; ?>';
                var optionStde = '<?php echo $row['stde_name_th']; ?>';
                var optionText = '<?php echo $row['rm_name']; ?>';

                if (optionFloor == parseInt(floor)) {
                    // Check if this option is the originally selected room
                    var selected = (parseInt(optionValue) == parseInt(oriRmId)) ? 'selected' : '';
                    
                    // Append the option with the 'selected' attribute if it matches
                    $select.append(`<option value="${optionValue}" ${selected} data-stde="${optionStde}" data-floor="${optionFloor}">${optionText}</option>`);
                }
            <?php } ?>

            // Set the previously selected value if it's still available
            $select.val(selectedValue);

            // Trigger select2 update to apply changes
            $select.trigger('change.select2');
        });
    }
    
    function getSearchParams() {
        let floor = document.getElementById('floor').value;
        let selectedDepartment = $('#department').find('option:selected');
        let selectedDepartmentValue = null;
        if (floor != null || floor != '' || selectedDepartment.length) {
            let selectedDepartmentText = selectedDepartment.text();  // Get the text of the selected option
            selectedDepartmentValue = $('#department').val();     // Get the value of the selected option

            const badges = document.querySelectorAll('.span-stde');
            badges.forEach(badge => {
                badge.innerHTML = `ข้อมูลผู้ป่วยที่รอรับการตรวจของชั้นที่ ${floor} ${selectedDepartmentText}`;
            });
        }
        
        return {
            date: document.getElementById('year-bh').value,
            floor: floor,
            department: selectedDepartmentValue,
            doctor: document.querySelector('select[name="doctor"]').value,
            // sta: document.querySelector('select[name="sta"]').value,
            patientId: document.getElementById('patient-id').value,
            visitId: document.getElementById('visit-id').value,
            patientName: document.getElementById('patient-name').value,
        };
    }

    function update_badge_date(text) {
        const badges = document.querySelectorAll('.span-date');
        badges.forEach(badge => {
            badge.innerHTML = `${text}`;
        });
    }

    // Reorder number patient
    // Check if any list is empty after the move
    function check_sortable_list() {
        var count_total = 0;
        $('.sortable-list').each(function() {
            var count = 0;

            // Reorder number patient
            $(this).children('.sortable-item').each(function(index) {
                var orderNumber = index + 1;
                $(this).find('.order-number').text(orderNumber + '. ');
                count = orderNumber; // Update maxOrderNumber
            });
            // Update patient count
            $(this).closest('.card').find('.patient-count').text(count + " ผู้ป่วย");
            count_total += count;

            // Check if any list is empty after the move
            if ($(this).children().length === 0) {
                $(this).addClass('empty');
            } else {
                $(this).removeClass('empty');
            }
        });

        $('.badge-count-total').text(count_total + ' ผู้ป่วย');
    }

    // Clear all que when search
    function clear_que(is_from_save = false) {
        patients_by_doctors = [];
        if(!is_from_save) {
            $('.sortable-list').each(function() {
                // clear ques
                $(this).html('');
                $(this).closest('.card').find('.patient-count').text(0);
                // Check if any list is empty after the move
                if ($(this).children().length === 0) {
                    $(this).addClass('empty');
                } else {
                    $(this).removeClass('empty');
                }
            });
            $('.badge-count-total').text('');
        } else {
            // Check change bg-color - Select all elements with the class 'sortable-item'
            let all_tasks = $('.sortable-item');
            // Loop through each element
            all_tasks.each(function() {
                // `this` refers to the current DOM element in the loop
                let taskElement = $(this);

                // Check if the current element has the class 'bg-warning-light'
                if (taskElement.hasClass('bg-warning-light')) {
                    // Remove 'bg-warning-light' class and add 'bg-white' class
                    taskElement.removeClass('bg-warning-light').addClass('bg-white');
                }
            });
        }
    }
    
    function showModalNtr(url) {
        url_temp = url;
        // window.location.href = url;
        // $('#notification-result-data').empty();
        // $('#modal-ntr').modal('show');
        // $('#notification-result-data').html(`
        //     <div class="center-container">
        //         <div class="spinner-border text-info" role="status">
        //             <span class="visually-hidden">Loading...</span>
        //         </div>
        //     </div>`);
        // $.ajax({
        //     url: url,
        //     method: "GET",
        //     success: function(data) {
        //         $('#notification-result-data').html(data);
        //     },
        //     error: function(jqXHR, textStatus, errorThrown) {
        //         console.log('AJAX error:', textStatus, errorThrown);
        //     }
        // });

        let selector = '#notification-result-data';

        // Clear the modal content
        clearModalContent(selector);

        // Show the modal
        $('#modal-ntr').modal('show');

        // Display the loading spinner
        showLoadingSpinner(selector);

        // Use setTimeout to ensure the spinner is displayed before loading new content
        setTimeout(function() {
            $(selector).load(url, function(response, status, xhr) {
                if (status === "error") {
                    console.log('AJAX error:', xhr.status, xhr.statusText);
                    showErrorMessage();
                } else {
                    // Clear spinner after content is loaded
                    clearLoadingSpinner(selector);
                }
            });
        }, 100); // Adjust the delay if needed
    }

    function clearModalContent(selector) {
        $(selector).empty();
    }

    function clearModalValue(selector) {
        $(selector).val('');
    }

    function clearLoadingSpinner(selector) {
        $(selector + ' .spinner-border').remove();
    }

    function showLoadingSpinner(selector) {
        const spinnerHTML = `
            <div class="center-container text-center">
                <div class="spinner-border text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        $(selector).append(spinnerHTML);
    }

    function showErrorMessage() {
        const errorMessageHTML = `
            <div class="alert alert-danger" role="alert">
                An error occurred while loading the content. Please try again later.
            </div>
        `;
        $('#notification-result-data').empty(); // Clear the spinner or any existing content
        $('#notification-result-data').append(errorMessageHTML);
    }

    function showModalApm(url) {
        let selector = '#appointment-data';

        // Clear the modal content
        clearModalContent(selector);

        // Show the modal
        $('#modal-apm').modal('show');

        // Display the loading spinner
        showLoadingSpinner(selector);

        // Use setTimeout to ensure the spinner is displayed before loading new content
        setTimeout(function() {
            $(selector).load(url, function(response, status, xhr) {
                if (status === "error") {
                    console.log('AJAX error:', xhr.status, xhr.statusText);
                    showErrorMessage();
                } else {
                    // Clear spinner after content is loaded
                    clearLoadingSpinner(selector);
                }
            });
        }, 100); // Adjust the delay if needed
    }

// Function to create and show the modal
var isEditing = false; // ใช้ตัวแปรนี้เพื่อตรวจสอบสถานะ

function deleteNoteCard(cardElement) {
    // Use SweetAlert to confirm deletion
    Swal.fire({
        text: "ต้องการลบการประกาศนี้หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // Remove the card from the DOM
            cardElement.remove();
            
            // Get the card ID from the data attribute
            var cardId = cardElement.getAttribute("data-card_id");

            // AJAX request to delete the card from the server
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/delete_card', // Update with your API URL
                type: 'POST',
                data: { id: cardId },
                success: function(response) {
                    Swal.fire(
                        'ลบเสร็จสิ้น',
                        'success'
                    );
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'เกิดข้อผิดพลาด',
                        'ไม่สามารถลบการประกาศได้.',
                        'error'
                    );
                    console.error('เกิดข้อผิดพลาดในการลบ:', error);
                }
            });
        }
    });
}

function saveNote() {
    // ดึงข้อมูลจาก modal
    var noteText = document.getElementById('note-text').value;
    var timeStart = document.getElementById('an_time_start').value;
    var timeEnd = document.getElementById('an_time_end').value;

    // ตรวจสอบว่าข้อมูลครบถ้วน
    if (!noteText || !timeStart || !timeEnd) {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        return;
    }

    // ตรวจสอบว่ามีการแก้ไขหรือไม่
    if (isEditing) {
        // ถ้าเป็นการแก้ไข, ค้นหาการ์ดที่มี note_card และ data-card_id ตรงกับ element ที่ถูกแก้ไข
        var editingCard = document.querySelector('#note_card[data-card_id="' + editingElement.getAttribute('data-card_id') + '"]');
        
        if (editingCard) {
            // แก้ไขเนื้อหาในการ์ดเดิม
            editingCard.setAttribute('data-announce', noteText);
            editingCard.setAttribute('data-an_time_start', timeStart);
            editingCard.setAttribute('data-an_time_end', timeEnd);

            // อัปเดตเนื้อหาในการ์ด
            editingCard.querySelector('p:nth-child(1)').innerText = noteText;
            editingCard.querySelector('p:nth-child(2)').innerText = timeStart + ' น. - ' + timeEnd + ' น.';
        }
    } else {
        // ถ้าเป็นการสร้างการ์ดใหม่
        var additionalCardContainer = document.getElementById('an_btn');
        var cardId = additionalCardContainer.getAttribute('data-card_id');

        // สร้าง HTML ใหม่สำหรับการ์ด
        var newCardHtml = '  <div class="sortable-item card-body rounded bg-white shadow-2 mb-2" data-card_id="' + cardId + '" data-announce="' + noteText + '" data-an_time_start="' + timeStart + '" data-an_time_end="' + timeEnd + '" id="note_card">';
        newCardHtml += '      <p class="text-center m-0">' + noteText + '</p>';
        newCardHtml += '      <p class="text-center m-0">' + timeStart + ' น. - ' + timeEnd + ' น.</p>';
        newCardHtml += '  <div class="task-buttons text-end option">';
        newCardHtml += '  <button class="btn btn-warning ms-1" onclick="editModalNote(this.parentElement.parentElement)" title="แก้ไขการประกาศ"><i class="bi-pencil-square"></i></button>';
        newCardHtml += '  <button class="btn btn-danger ms-1" onclick="deleteNoteCard(this.parentElement.parentElement)" title="ลบการประกาศ"><i class="bi-trash"></i></button>';
        newCardHtml += '  </div>';
        newCardHtml += '  </div>';

        // แทนที่เนื้อหาใน additionalCardContainer
        additionalCardContainer.outerHTML = newCardHtml;
    }

    // ปิด modal
    var modalElement = document.getElementById('modal-note');
    var modalInstance = bootstrap.Modal.getInstance(modalElement);
    modalInstance.hide();
}

function showModalNote(editingElement = null) {
    // Set the cardId to the hidden input field
    let selector = '#note-text, #an_time_start, #an_time_end';

    if (editingElement) {
        // ถ้าเป็นการแก้ไข ให้ดึงข้อมูลมาแสดงใน modal
        isEditing = true;
        this.editingElement = editingElement; // เก็บ reference ของการ์ดที่ถูกแก้ไข
        var noteText = editingElement.querySelector('p:nth-child(1)').innerText;
        var time = editingElement.querySelector('p:nth-child(2)').innerText.split(' น. - ');
var timeStart = time[0].replace(' น.', '');  // ตัด ' น.' ออกจาก timeStart
var timeEnd = time[1].replace(' น.', '');

        document.getElementById('note-text').value = noteText;
        document.getElementById('an_time_start').value = timeStart;
        document.getElementById('an_time_end').value = timeEnd;
    } else {
        // ถ้าไม่ใช่การแก้ไข (การสร้างใหม่) ให้เคลียร์ข้อมูล
        isEditing = false;
        this.editingElement = null; // ล้าง reference ของการ์ด
        clearModalValue(selector);
    }

    // Show the modal
    var modalElement = document.getElementById('modal-note');
    var modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.show();
}

// ฟังก์ชันแก้ไขเมื่อกดปุ่มแก้ไข
function editModalNote(element) {
    showModalNote(element); // เรียก modal พร้อมส่ง element ที่ต้องการแก้ไข
}

// additionalCardContainer.outerHTML = newCardHtml;
    function save_data() {
        var doctor_patient_ques = [];
        $('.sortable-list').each(function() {
            var ps_id = $(this).data('ps-id');
            var card = $(this).attr('id')
            var patient_ques = [];

            // Reorder number patient
            $(this).children('.sortable-item').each(function(index) {
                let apm_ql_code = $(this).data('task-id');
                let apm_id = $(this).data('task-apm-id');
                let announce_id = $(this).data('card_id');
                let announce = $(this).data('announce');
                let an_time_start = $(this).data('an_time_start');
                let an_time_end = $(this).data('an_time_end');
                let orderNumber = index + 1;

                if (apm_id || announce) {
                    patient_ques.push({
                        apm_id: apm_id,
                        apm_ql_code: apm_ql_code,
                        announce_id: announce_id,
                        announce: announce,
                        an_time_start: an_time_start,
                        an_time_end: an_time_end,
                        seq: orderNumber
                    });
                }
            });            
            doctor_patient_ques.push({card: card, ps_id: ps_id, patient_ques: patient_ques})
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_edit',
            data: {
                doctor_patient_ques: doctor_patient_ques,
                stde_id: search_params['department'],
                date: search_params['date'],
            },
            dataType: 'json', // Expect JSON response from the server
            success: function(data) {
                if (data.status_response == status_response_success) {
                    // dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, data.returnUrl, false);
                    
                    // not reload page
                    clear_que(true);
                    reload_que(true);
                    dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, null, false);
                } else{
                    if (!is_null(data.message_dialog))
                        dialog_error({ 'header': text_toast_save_error_header, 'body': data.message_dialog });
                    else
                        dialog_error({ 'header': text_toast_save_error_header, 'body': text_toast_save_error_body });
                }
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(xhr.responseText);
            }
        });
    }
</script>

<!-- flatpickr -->
<script>
    var today = new Date();
    var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    var maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 500);
    flatpickr(".datepicker_th", {
        dateFormat: 'd/m/Y',
        defaultDate: new Date(), // Set to current date
        locale: 'th',
            // defaultDate: today, // Set to current Gregorian date
            //   minDate: minDate, // Minimum date is today
            //   maxDate: maxDate, // Maximum date is today + 500 days
        
        onReady: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates); // Display the default date in Buddhist year format
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates);
        },
    });
    function updateDatepickerValues(selectedDates) {
        if (selectedDates.length > 0) {
            var date = selectedDates[0];
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var yearBE = date.getFullYear(); // Get year in BE (Buddhist Era)
            var yearTH = yearBE + 543; // Convert to Buddhist year
            var formattedDate = day + '/' + month + '/' + yearTH;
            $(".datepicker_th").val(formattedDate);
        }
    }
</script>

<!-- jQuery and jQuery UI -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    // drag sortable
    $(function() {
        // คาดว่าน่าจะเพราะเกิด 2 trigger คือลากออกจากการ์ดเดิม และลากลงการ์ดใหม่ มันเลยเหมือนเข้า function update 2 ครั้ง
        // เลยสร้าง toastShown เพื่อเช็คการแสดง toast
        let toastShown = false; // Flag to track if the toast has been shown

        $(".sortable-list").sortable({
            connectWith: ".sortable-list",
            placeholder: "ui-state-highlight",
            start: function(event, ui) {
                // Capture the original index of the item before it's moved
                ui.item.data('originalIndex', ui.item.index());
                
                // Remove empty class from the current list
                ui.item.closest('.sortable-list').removeClass('empty');
            },
            update: function(event, ui) {
                // Check if the item was moved within the same list or to a different list
                // If `ui.sender` is `null`, the item was moved within the same list
                // If `ui.sender` is not `null`, the item was moved to a different list
                var originList = ui.sender ? ui.sender.attr('id') : ui.item.data('origin-list-id');
                var targetList = ui.item.closest('.sortable-list').attr('id');
                var isTransfer = originList !== targetList;

                // Capture the initial position of the item
                var currentItemIndex = ui.item.index();
                            
                // Store the original index of the item before it's moved
                var originalIndex = ui.item.data('originalIndex') || ui.item.index();

                // condition to show swal2
                // 1. tasks-wait               -> tasks-success                = swal2 warning cant do
                // 2. tasks-success            -> tasks-wait                   = swal2 warning but can do if cancel then tranfer back else if confirm then transfer
                // 3. tasks-$doctor['ps_id']   -> tasks-wait                   = swal2 warning but can do if cancel then tranfer back else if confirm then transfer
                // 4. tasks-$doctor['ps_id']   -> tasks-$doctor['ps_id']       = swal2 warning but can do if cancel then tranfer back else if confirm then transfer
                // (เป็นกรณีเปลี่ยนแพทย์)
                // 4.1 tasks-waklin-$doctor['ps_id'] -> tasks-waklin-$doctor['ps_id']
                // 4.2 tasks-waklin-$doctor['ps_id'] -> tasks-appointment-$doctor['ps_id']
                // 4.2 tasks-appointment-$doctor['ps_id'] -> tasks-waklin-$doctor['ps_id']
                // 4.4 tasks-appointment-$doctor['ps_id'] -> tasks-appointment-$doctor['ps_id']
                // (เป็นกรณีแพทย์คนเดิม แต่ต้องการย้ายจาก waklin -> appointment)
                // 4.5 tasks-waklin            -> tasks-appointment
                // 4.6 tasks-appointment       -> tasks-waklin
                // 5. tasks-...                -> tasks-cancel                 = swal2 warning but can do if cancel then tranfer back else if confirm then transfer
                // 6. tasks-wait  ->  tasks-$doctor['ps_id']  -> tasks-success = swal2 warning cant do
                // then show swal2 to confirm transfer if cancel then tranfer back else if confirm then transfer
                var originListId = ui.item[0].dataset.originListId; // for check wait -> doctor -> succes(dont save yet)
                var originListTask = originList.split('-')[1];
                var targetListTask = targetList.split('-')[1];
                var title = '';
                var text = '';
                var is_can_not_do = false;
                var is_show_alert = false;
                if (originListTask == 'wait' && targetListTask == 'success') { // 1
                    is_can_not_do = true;
                    title = 'ขออภัย';
                    text = 'ไม่สามารถปรับสถานะ "พบแพทย์เสร็จสิ้น" ให้กับคิวที่ยังไม่ระบุแพทย์ได้';
                } else if (originListId == 'tasks-wait' && targetListTask == 'success') { // 6
                    is_can_not_do = true;
                    title = 'ขออภัย';
                    text = 'คิวนี้ยังไม่บันทึกระบุแพทย์ จึงไม่สามารถปรับสถานะ "พบแพทย์เสร็จสิ้น" ให้กับคิวที่ยังไม่ระบุแพทย์ได้';
                } else if (originListTask == 'success' && targetListTask == 'wait') { // 2
                    // is_show_alert = true;
                    // title = 'คำเตือน';
                    // text = 'ต้องการไม่ระบุแพทย์ และปรับสถานะเป็นรอระบุแพทย์หรือไม่';

                    is_show_alert = true;
                    title = 'ปรับสถานะเป็นรอระบุแพทย์';
                    text = 'กรุณากดปุ่มบันทึกข้อมูล';
                } else if ((originListTask != 'wait' && originListTask != 'success') && targetListTask == 'wait') { // 3
                    // is_show_alert = true;
                    // title = 'คำเตือน';
                    // text = 'ต้องการไม่ระบุแพทย์ และปรับสถานะเป็นรอระบุแพทย์หรือไม่';

                    is_show_alert = true;
                    title = 'ปรับสถานะเป็นรอระบุแพทย์';
                    text = 'กรุณากดปุ่มบันทึกข้อมูล';
                } else if (targetListTask == 'cancel') { // 5
                    // is_show_alert = true;
                    // title = 'คำเตือน';
                    // text = 'ต้องการยกเลิกการจองคิว ใช่หรือไม่';

                    is_show_alert = true;
                    title = 'ปรับสถานะเป็นยกเลิกการจองคิว';
                    text = 'กรุณากดปุ่มบันทึกข้อมูล';
                } else if ((originListTask != 'wait' && originListTask != 'success') && (targetListTask != 'wait' && targetListTask != 'success') && isTransfer) { // 4
                    let originArray = originList.split('-');
                    let targetArray = targetList.split('-');
                    if (originArray[2] != targetArray[2]) { // 4.1, 4.2, 4.3, 4.4
                        // is_show_alert = true;
                        // title = 'คำเตือน';
                        // text = 'ต้องการเปลี่ยนแพทย์ใช่หรือไม่';
                        
                        is_show_alert = true;
                        title = 'เปลี่ยนแพทย์';
                        text = 'กรุณากดปุ่มบันทึกข้อมูล';
                    }
                    // comment ไว้ ยังไม่ต้องการให้ alert 
                    // else {
                    //     is_show_alert = true;
                    //     title = 'คำเตือน';
                    //     if (originArray[1] == 'walkin' && targetArray[1] == 'appointment') { // 4.5
                    //         text = 'ต้องการเปลี่ยนคิวปกติเป็นคิวนัดหมายใช่หรือไม่';
                    //     } else if (originArray[1] == 'appointment' && targetArray[1] == 'walkin') { // 4.6
                    //         text = 'ต้องการเปลี่ยนคิวนัดหมายเป็นคิวปกติใช่หรือไม่';
                    //     }
                    // }
                } 


                // console.log(originListTask, ' - ', targetListTask);
                // console.log(originList, ' - ', targetList)
                // console.log(ui.sender)
                // console.log(originListId);
                // console.log("-----------")

                if (is_can_not_do) {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: "error",
                    }).then(() => {
                        // Revert the item back to the original list and original position if an error occurs
                        $('#' + originList).append(ui.item);
                        var $originalList = $('#' + originList);
                        ui.item.insertBefore($originalList.children().eq(originalIndex));
                        check_sortable_list(); // Call check_sortable_list after reverting
                    });
                } else {
                    if (is_show_alert) {
                        if(!toastShown) {
                            dialog_success({ 'header': title, 'body': text, 
                                             'toastClass': 'bg-warning border-0',
                                             'headerClass': 'bg-warning border-0',
                                             'icon': 'bi bi-info-circle me-1' }, null, false);
                            toastShown = true;
                        } else
                            toastShown = false;
                        ui.item.removeClass('bg-white').addClass('bg-warning-light');

                        // Update the original list ID to the current list ID
                        ui.item.data('origin-list-id', targetList);
                        check_sortable_list();

                        // Swal.fire({
                        //     title: title,
                        //     text: text,
                        // }).then(() => {
                        //     ui.item.removeClass('bg-white').addClass('bg-warning-light');

                        //     // Update the original list ID to the current list ID
                        //     ui.item.data('origin-list-id', targetList);
                        //     check_sortable_list();
                        // });

                        // old - confirm to transfer or not?
                        // Swal.fire({
                        //     title: title,
                        //     text: text,
                        //     icon: 'warning',
                        //     showCancelButton: true,
                        //     confirmButtonColor: '#3085d6',
                        //     cancelButtonColor: '#d33',
                        //     confirmButtonText: 'ยืนยัน',
                        //     cancelButtonText: 'ยกเลิก'
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         // Manually move the item to the desired position
                        //         var $targetList = $('#' + targetList);
                        //         var $items = $targetList.children();

                        //         if ($items.length > 1) {
                        //             if (currentItemIndex === 0) {
                        //                 ui.item.insertBefore($items.eq(0)); // ถ้าต้องการให้เป็นอันดับแรก
                        //             } else {
                        //                 ui.item.insertBefore($items.eq(currentItemIndex));
                        //             }
                        //         } else {
                        //             if (currentItemIndex === 0) {
                        //                 $targetList.prepend(ui.item); // ถ้ามีแค่หนึ่งรายการและต้องการให้เป็นอันดับแรก
                        //             } else {
                        //                 $targetList.append(ui.item);
                        //             }
                        //         }

                        //         ui.item.removeClass('bg-white').addClass('bg-warning-light');
                        //         ui.item.data('origin-list-id', targetList);
                        //         check_sortable_list();
                        //     } else {
                        //         // // Revert the item back to the original list and original position if canceled
                        //         // var $originalList = $('#' + originList);
                        //         // ui.item.insertBefore($originalList.children().eq(originalIndex));
                        //         // check_sortable_list(); // Call check_sortable_list after reverting

                        //         // Revert the item back to the original list and original position if an error occurs
                        //         $('#' + originList).append(ui.item);
                        //         var $originalList = $('#' + originList);
                        //         ui.item.insertBefore($originalList.children().eq(originalIndex));
                        //         check_sortable_list(); // Call check_sortable_list after reverting
                        //     }
                        // });
                    } else {
                        ui.item.removeClass('bg-white').addClass('bg-warning-light');

                        // Update the original list ID to the current list ID
                        ui.item.data('origin-list-id', targetList);
                        check_sortable_list();
                    }
                }

                // check_sortable_list();
            }
        }).disableSelection();

        // Mark empty lists initially
        $('.sortable-list').each(function() {
            if ($(this).children().length === 0) {
                $(this).addClass('empty');
            }
        });
    });
</script>

