<?php $this->load->view($view_dir . 'v_manage_trello_style'); ?>

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
                            <label for="date" class="form-label ">วัน/เดือน/ปี ที่นัดหมายแพทย์</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control datepicker_th" name="year-bh" id="year-bh" value="" placeholder="เลือกวันที่นัดหมาย">
                                <span class="input-group-text btn btn-secondary" onclick="$('#year-bh').val(null);" title="clear" data-clear><i class="bi-x"></i></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="" class="form-label ">ชื่อแพทย์</label><br>
                          <select class="form-select select2" data-placeholder="-- กรุณาเลือกชื่อแพทย์ --" name="doctor">
                              <option value=""></option>
                              <?php foreach($get_doctors as $ps) { ?>
                                <option value="<?php echo $ps['ps_id']?> "><?= $ps['pf_name'].''.$ps['ps_fname'].' '.$ps['ps_lname']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label ">Visit Id</label>
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
                    <i class="bi-newspaper icon-menu"></i><span> ข้อมูลผู้ป่วยที่รอรับการตรวจของ </span><span class="span-date pe-1"></span> <span class="badge bg-success font-14 badge-count-total"></span>
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
                                <div class="sortable-list" id="tasks-wait">
                                    <!-- Tasks will be dynamically added here -->
                                </div>
                            </div>
                        </div>
                        <?php foreach ($get_doctors as $doctor): ?>
                            <div class="col-md-4">
                                <div class="card m-3 p-2 pb-0">
                                    <div class="card-header bg-primary text-white mb-2">
                                        <div class="doctor-detail">
                                            <p class="mb-2 room-name-text" 
                                                data-doctor-id="<?php echo $doctor['ps_id']; ?>" 
                                                data-ori-rm-id="<?php echo $doctor['rm_id']; ?>"
                                                data-psrm-id="<?php echo $doctor['psrm_id']; ?>">
                                                <?php echo $doctor['rm_name']; ?>
                                            </p>
                                            <span class="room-name-select" style="display: none;" 
                                                data-doctor-id="<?php echo $doctor['ps_id']; ?>">
                                                <select class="form-select select2" 
                                                    name="psrm-<?php echo $doctor['ps_id']; ?>" 
                                                    id="psrm-<?php echo $doctor['ps_id']; ?>" 
                                                    data-placeholder="-- กรุณาเลือกห้อง --" >
                                                    <option value=""></option>
                                                    <?php foreach ($rooms as $row) { ?>
                                                        <option value="<?php echo $row['rm_id']; ?>" <?php echo ($row['rm_id'] == $doctor['rm_id']) ? "selected" : "" ; ?>><?php echo $row['rm_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <button class="btn btn-danger btn-cancel">ยกเลิก</button>
                                                <button class="btn btn-success btn-save">บันทึก</button>
                                            </span>
                                            <p class="mb-1"><?php echo $doctor['ps_name']; ?></p>
                                        </div>
                                        <div class="patient-count"></div>
                                    </div>
                                    <div class="sortable-list" id="tasks-<?php echo $doctor['ps_id']; ?>">
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
                                <div class="sortable-list" id="tasks-success">
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

<!-- Defined variable -->
<script>
    var doctors = <?php echo json_encode($get_doctors); ?>;
    var rooms = <?php echo json_encode($rooms); ?>;
    var patients_by_doctors = [];
    var search_params = [];
    let refreshInterval;

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
        reload_que()
        reset_interval(); // Initial call to set the interval
        search_params = getSearchParams();

        // trigger change room
        $('.room-name-text').click(function() {
            let roomName = $(this);
            let doctorId = roomName.data('doctor-id');
            $('.room-name-select[data-doctor-id="' + doctorId + '"]').show();
            $(this).hide(); // room-name-select
        });
        $('.room-name-select .btn-cancel').click(function() {
            // get original id
            let select = $(this).closest('.room-name-select');
            let doctorId = select.data('doctor-id');
            let text = $('.room-name-text[data-doctor-id="' + doctorId + '"]');
            let ori = text.data('ori-rm-id');

            // set in select2
            $('#psrm-' + doctorId).val(ori).trigger('change');

            // hide/show element
            text.show();
            select.hide();
        });
        $('.room-name-select .btn-save').click(function() {
            // get original id
            let select = $(this).closest('.room-name-select');
            let doctorId = select.data('doctor-id');
            let text = $('.room-name-text[data-doctor-id="' + doctorId + '"]');
            let ori = text.data('ori-rm-id');
            let psrm_id = text.data('psrm-id');

            // get value from select
            let val = $('#psrm-' + doctorId + ' option:selected').val();
            var valText = $('#psrm-' + doctorId + ' option:selected').text();

            // update html
            text.data('ori-rm-id', val);
            text.html(valText);

            // update in db
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_update_room',
                data: {
                    psrm_id: psrm_id,
                    psrm_ps_id: doctorId,
                    psrm_rm_id: val,
                    psrm_date: null
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

            // hide/show element
            text.show();
            select.hide();
        });
    });
</script>
<script>
    function get_patient_by_doctor() {
        var ps_id = parseInt(search_params['doctor']);
        if(!isNaN(ps_id)) {
            get_patient_ajax(search_params['doctor']);

            // Loop through each doctor card to hidden
            $('.doctor-detail').each(function() {
                var doctorId = $(this).find('.room-name-text').data('doctor-id');
                // Check if the doctor ID is not 4
                if (ps_id !== parseInt(doctorId)) {
                    // Hide the entire doctor card
                    $(this).closest('.col-md-4').hide();
                } else {
                    $(this).closest('.col-md-4').show();
                }
            });
        } else {
            // Loop through each doctor card to show
            $('.doctor-detail').each(function() {
                var doctorId = $(this).find('.room-name-text').data('doctor-id');
                $(this).closest('.col-md-4').show();
            });
            doctors.forEach(function(doctor) {
                get_patient_ajax(doctor.ps_id);
            });
        }
    }

    function get_patient_ajax(ps_id, status = null) {
        var sta_id = null;
        var is_null_ps_id = false;
        var is_process = false;
        var ori_list_id = 'tasks-' + ps_id;
        if(status == 'wait') { 
            sta_id = 4 
            is_null_ps_id = true;
            ori_list_id = 'tasks-wait';
            // tasksContainer = $('#tasks-wait');
        } else if(status == 'success') {
            sta_id = 10
            ori_list_id = 'tasks-success';
            // tasksContainer = $('#tasks-success');
        } else {
            is_process = true;
        }
        var tasksContainer = $('#' + ori_list_id);

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_get_ques',
            type: 'POST',
            data: {
                doctor: ps_id,
                sta_id: sta_id,
                is_null_ps_id: is_null_ps_id,
                is_process: is_process,

                date: search_params['date'],
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
                result.tasks.forEach(function(task, index) {
                    // 1. check duplicate apm_ql_code
                    // 1.1 if duplicate then update status if status has changed
                    // 1.2 if not duplicate then append in card of doctor
                    let isDuplicate = false; // Track whether the task is a duplicate
                    patients_by_doctors.forEach(function(doctorRecord, index) {
                        if(doctorRecord.ps_id === ps_id) {
                            doctorRecord.patient_ques.forEach(function(que, index2) {
                                if (que.apm_ql_code === task.apm_ql_code) {
                                    isDuplicate = true;

                                    // Check if the status has changed
                                    if (que.apm_sta_id !== task.apm_sta_id) {
                                        // Update the text and button for the existing task
                                        let taskElement = $('[data-task-id="' + task.apm_ql_code + '"]');

                                        // Update the status text and status icon class
                                        taskElement.find('.status-text').html('<i class="bi-circle-fill me-2 ' + task.status_class + '"></i>' + task.status_text);

                                        // Update the button(s)
                                        taskElement.find('.task-buttons').html(task.btn);
                                    }
                                }
                            });
                        }
                    });
                    if (!isDuplicate) {
                        apmQlCodes.push({
                            apm_ql_code: task.apm_ql_code,
                            apm_sta_id: task.apm_sta_id,
                            btn: task.btn,
                        });
                        
                        let bg_class = 'bg-success-light';
                        let timeArray = task.ntdp_time_start.split(':');
                        // สร้างวันที่ปัจจุบันแล้วกำหนดเวลา
                        let currentDate = new Date();
                        let timeDate = new Date(currentDate);
                        timeDate.setHours(timeArray[0], timeArray[1], 0, 0);

                        // คำนวณความแตกต่างของเวลา (ในมิลลิวินาที)
                        let timeDiff = currentDate - timeDate;
                        
                        // คำนวณเป็นนาที
                        let diffMinutes = Math.floor(timeDiff / 1000 / 60);

                        if (diffMinutes >= 5) {
                            // ใส่คลาส bg-white ถ้าเวลาผ่านไป 5 นาที
                            bg_class = 'bg-white';
                        }                   
                        let time = timeArray[0] + ':' + timeArray[1];

                        // Manually create the HTML string
                        var taskHtml = '<div class="sortable-item card-body rounded ' + bg_class + ' shadow-2 mb-2" data-task-id="' + task.apm_ql_code + '" data-origin-list-id="' + ori_list_id + '">';
                        taskHtml += '  <div class="task-header">';
                        taskHtml += '    <div class="task-que">';
                        taskHtml += '       <span class="order-number">' + (index + 1) + '. </span>';
                        taskHtml += '       <span class="que-text">' + task.apm_ql_code + '</span>';
                        taskHtml += '    </div>';
                        taskHtml += '  </div>';
                        taskHtml += '  <div class="task-body mb-1">';
                        taskHtml += '    <div class="task-status">';
                        taskHtml += '       <span class="status-text"><i class="bi-circle-fill me-2 ' + task.status_class + '"></i>' + task.status_text + '</span>';
                        taskHtml += '    </div>';
                        taskHtml += '  </div>';
                        taskHtml += '  <div class="task-body">';
                        taskHtml += '    <div class="task-patient">';
                        taskHtml += '      <p class="m-0"> Visit Id: ' + task.apm_visit + '</p>';
                        taskHtml += '      <p class="m-0"> ชื่อผู้ป่วย: ' + task.pt_name + '</p>';
                        taskHtml += '    </div>';
                        taskHtml += '  </div>';
                        taskHtml += '  <div class="task-body">';
                        taskHtml += '    <div class="task-priority">';
                        // taskHtml += '      <span class="priority-text p-2" style="background-color: ' + task.pri_color + ';">' + task.pri_name + '</span>';
                        taskHtml += '      <span class="type-text">' + (task.apm_patient_type == 'old' ? 'ผู้ป่วยเก่า' : 'ผู้ป่วยใหม่') + ' </span>';
                        taskHtml += '      <span class="priority-text" style="color: ' + task.pri_color + ';">(' + task.pri_name + ' )</span>';
                        taskHtml += '    </div>';
                        taskHtml += '  </div>';
                        taskHtml += '  <div class="task-body">';
                        taskHtml += '    <div class="task-time">';
                        taskHtml += '       <span class="time-text">เวลา: ' + time + ' น. </span>';
                        taskHtml += '    </div>';
                        taskHtml += '  </div>';
                        taskHtml += '  <div class="task-buttons text-end option">';
                        taskHtml += task.btn;
                        taskHtml += '  </div>';
                        taskHtml += '</div>';

                        // Append the created HTML to the tasks container
                        tasksContainer.append(taskHtml);
                    }
                    
                    // Update room-name-text => Loop through each doctor card to show
                    $('.doctor-detail .room-name-text').each(function() {
                        var doctorIdElement = $(this);
                        if(parseInt(doctorIdElement.data('doctor-id')) === parseInt(ps_id)) {
                            if(task.psrm_id != null) {
                                doctorIdElement.data('ori-rm-id', task.rm_id);
                                doctorIdElement.data('psrm-id', task.psrm_id);
                                doctorIdElement.html(task.rm_name);
                            } else {
                                doctorIdElement.data('ori-rm-id', '');
                                doctorIdElement.data('psrm-id', '');
                                doctorIdElement.html('ห้อง xxx');
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

    function reset_interval() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
        refreshInterval = setInterval(function() {
            reload_que();
        }, 60000); // 60000 - 1 minute // or datatable_second_reload
    }

    function goto_see_doctor(url) {
        const sta_id = 2;
        $.ajax({
            url: url,
            type: 'POST',
            data: { sta_id: sta_id },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status_response == "<?php echo $this->config->item('status_response_success'); ?>") {
                    Swal.fire({
                        title: 'เรียกพบแพทย์เสร็จสิ้น',
                        text: '',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        customClass: {
                            htmlContainer: 'swal2-html-line-height'
                        },
                    }).then(() => {
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

    function reload_que() {
            get_patient_ajax(null, 'wait') // ยังไม่ได้ระบุแพทย์
            get_patient_by_doctor(); // กำลังดำเนินการในแผนก
            get_patient_ajax(null, 'success') // พบแพทย์เสร็จสิ้น
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

            $('.spinner-overlay').addClass('d-none');
        }, 2000); // Adjust the time as needed to wait for the operations to complete
    }

    function getSearchParams() {
        return {
            date: document.getElementById('year-bh').value,
            // department: document.querySelector('select[name="department"]').value,
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
    function clear_que() {
        patients_by_doctors = [];
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

    function save_data() {
        var doctor_patient_ques = [];
        $('.sortable-list').each(function() {
            var ps_id = $(this).attr('id')
            var patient_ques = [];

            // Reorder number patient
            $(this).children('.sortable-item').each(function(index) {
                let apm_ql_code = $(this).data('task-id');
                let orderNumber = index + 1;
                // data-task-id
                // date after press search
                patient_ques.push({apm_ql_code: apm_ql_code, seq: orderNumber});
            });
            doctor_patient_ques.push({ps_id: ps_id, patient_ques: patient_ques})
        });

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/wts/Manage_queue_trello/Manage_queue_trello_edit',
            data: {
                doctor_patient_ques: doctor_patient_ques,
                date: null
            },
            dataType: 'json', // Expect JSON response from the server
            success: function(data) {
                if (data.status_response == status_response_success) {
                    dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, data.returnUrl, false);
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    // drag sortable
    $(function() {
        $(".sortable-list").sortable({
            connectWith: ".sortable-list",
            placeholder: "ui-state-highlight",
            start: function(event, ui) {
                // Remove empty class from the current list
                ui.item.closest('.sortable-list').removeClass('empty');
            },
            update: function(event, ui) {
                // // Check if the item was moved within the same list or to a different list
                // // If `ui.sender` is `null`, the item was moved within the same list
                // // If `ui.sender` is not `null`, the item was moved to a different list
                // if (ui.sender || ui.item.closest('.sortable-list').data('list-id') === ui.item.data('original-list-id')) {
                //     // Add the `bg-warning-light` class when moving within the same list
                //     ui.item.removeClass('bg-white').addClass('bg-warning-light');
                // }

                // // Update the original list ID to the current list ID
                // ui.item.data('original-list-id', ui.item.closest('.sortable-list').data('list-id'));

                // check_sortable_list();

                // new
                // Check if the item was moved within the same list or to a different list
                // If `ui.sender` is `null`, the item was moved within the same list
                // If `ui.sender` is not `null`, the item was moved to a different list
                var originList = ui.sender ? ui.sender.attr('id') : ui.item.data('origin-list-id');
                var targetList = ui.item.closest('.sortable-list').attr('id');
                var isTransfer = originList !== targetList;

                // condition to show swal2
                // 1. tasks-wait               -> tasks-success                = swal2 warning cant do
                // 2. tasks-success            -> tasks-wait                   = swal2 warning but can do if cancel then tranfer back else if confirm then transfer
                // 3. tasks-$doctor['ps_id']   -> tasks-wait                   = swal2 warning but can do if cancel then tranfer back else if confirm then transfer
                // 4. tasks-$doctor['ps_id']   -> tasks-$doctor['ps_id']       = swal2 warning but can do if cancel then tranfer back else if confirm then transfer
                // then show swal2 to confirm transfer if cancel then tranfer back else if confirm then transfer
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
                } else if (originListTask == 'success' && targetListTask == 'wait') { // 2
                    is_show_alert = true;
                    title = 'คำเตือน';
                    text = 'ต้องการไม่ระบุแพทย์ และปรับสถานะเป็นรอระบุแพทย์หรือไม่';
                } else if ((originListTask != 'wait' && originListTask != 'success') && targetListTask == 'wait') { // 3
                    is_show_alert = true;
                    title = 'คำเตือน';
                    text = 'ต้องการไม่ระบุแพทย์ และปรับสถานะเป็นรอระบุแพทย์หรือไม่';
                } else if ((originListTask != 'wait' && originListTask != 'success') && (targetListTask != 'wait' && targetListTask != 'success') && isTransfer) { // 4
                    is_show_alert = true;
                    title = 'คำเตือน';
                    text = 'ต้องการเปลี่ยนแพทย์ใช่หรือไม่';
                }


                // console.log(originList, ' - ', targetList)
                // console.log(ui.sender)
                if (is_can_not_do) {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: "error",
                        // footer: '<a href="#">Why do I have this issue?</a>'
                    });
                    // Revert the item back to the original list if canceled
                    $('#' + originList).append(ui.item);
                } else {
                    if (is_show_alert) {
                        Swal.fire({
                            title: title,
                            text: text,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ยืนยัน',
                            cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Swal.fire(
                                //     'Transferred!',
                                //     'The item has been transferred.',
                                //     'success'
                                // );

                                // Move the item to the new list manually if confirmed
                                $('#' + targetList).append(ui.item);
                                ui.item.removeClass('bg-white').addClass('bg-warning-light');
                                ui.item.data('origin-list-id', targetList);
                            } else {
                                // Revert the item back to the original list if canceled
                                $('#' + originList).append(ui.item);
                            }
                        });
                    } else {
                        ui.item.removeClass('bg-white').addClass('bg-warning-light');

                        // Update the original list ID to the current list ID
                        ui.item.data('origin-list-id', targetList);
                    }


                    // if (isTransfer) {
                    //     Swal.fire({
                    //         title: title,
                    //         text: text,
                    //         icon: 'warning',
                    //         showCancelButton: true,
                    //         confirmButtonColor: '#3085d6',
                    //         cancelButtonColor: '#d33',
                    //         confirmButtonText: 'ยืนยัน',
                    //         cancelButtonText: 'ยกเลิก'
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {
                    //             // Swal.fire(
                    //             //     'Transferred!',
                    //             //     'The item has been transferred.',
                    //             //     'success'
                    //             // );

                    //             // Move the item to the new list manually if confirmed
                    //             $('#' + targetList).append(ui.item);
                    //             ui.item.removeClass('bg-white').addClass('bg-warning-light');
                    //             ui.item.data('origin-list-id', targetList);
                    //         } else {
                    //             // Revert the item back to the original list if canceled
                    //             $('#' + originList).append(ui.item);
                    //         }
                    //     });
                    // } else {
                    //     ui.item.removeClass('bg-white').addClass('bg-warning-light');

                    //     // Update the original list ID to the current list ID
                    //     ui.item.data('origin-list-id', targetList);
                    // }
                }

                check_sortable_list();
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
