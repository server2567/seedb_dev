<?php
    $is_have_files = 0;
    if(!empty($files) && isset($files))
        $is_have_files = 1;

    $is_detail_page = 0;
    if(!empty($exr_id) && !empty($is_detail) && isset($is_detail))
        $is_detail_page = $is_detail;

    $header_text = $is_detail_page ? "รายละเอียดผลตรวจเครื่องมือหัตถการ" : (!empty($exr_id) ? "แก้ไขผลตรวจเครื่องมือหัตถการ" : "เพิ่มผลตรวจเครื่องมือหัตถการ");

	$back_url = base_url() . 'index.php/dim/Import_examination_result'; // for officer
    if($actor == 'doctor') {
        if($this->session->userdata('st_name_abbr_en') == 'AMS') // if AMS then go to AMS-Notification_result
            $back_url = base_url() . 'index.php/ams/Notification_result/update_form/' . $edit['exr_ntr_id'];
        else
            $back_url = base_url() . 'index.php/dim/Examination_result';

    }
?>

<style>
    #fileTableBody td {
        word-wrap: break-word;
        white-space: normal;
    }
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 5px;
        background: #f8f9fa;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        color: #007bff;
        align-content: center;
        height: 220px;
    }
    .dropzone.dragover {
        background: #e2e6ea;
    }
</style>
<!-- Detail -->
<div class="row mb-3">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span>  <?php echo $header_text; ?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url()."index.php/dim/Import_examination_result/"; ?><?php echo !empty($exr_id) ? "Import_examination_result_update/".$exr_id : "Import_examination_result_insert"; ?>">
                        <input type="hidden" name="exr_eqs_id" id="exr_eqs_id" value="<?php echo !empty($edit) ? $edit['exr_eqs_id'] : "" ;?>">
                        <input type="hidden" name="next_exr_id" id="next_exr_id" value="<?php echo isset($next_exr_id) ? $next_exr_id : "" ;?>">
                        <div class="col-md-5">
                            <div id="dropzone" class="font-20 dropzone <?php echo $is_detail_page == 1 ? "d-none" : ""; ?>">
                                Upload ผลตรวจได้ที่นี้ กรุณาคลิก
                            </div>
                            <input class="form-control d-none" type="file" id="files" name="files[]" multiple>
                            <div class="mt-4"> <input type="hidden" id="file_message" name="file_message"></div>
                            <table class="table table-bordered mt-4" style="table-layout: fixed; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>ชื่อไฟล์</th>
                                        <th class="text-center">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody id="fileTableBody">
                                    <tr>
                                        <td class="text-center" colspan="3">ไม่พบข้อมูล</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-7 row g-2">
                            <div class="col-md-6">
                                <h5 class="text-muted font-18">Visit</h5>
                                <p class="fw-bold font-18"><?php echo $edit['apm_visit'];?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted font-18">หมายเลขคิว</h5>
                                <p class="fw-bold font-18"><?php echo $edit['apm_ql_code'];?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted font-18">HN</h5>
                                <p class="fw-bold font-18"><?php echo $edit['pt_member'];?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted font-18">ชื่อผู้ป่วย</h5>
                                <p class="fw-bold font-18"><?php echo $edit['pt_full_name'];?></p>
                            </div>
                            <!-- <div class="col-md-6">
                                <h5 for="exr_round" class="text-muted font-18">รอบที่เข้ามาใช้บริการของวันปัจจุบัน</h5>
                                <p class="fw-bold font-18"><?php echo $edit['exr_round'];?></p>
                            </div> -->
                            <!-- <div class="col-md-6">
                                <h5 for="" class="text-muted font-18"><b> </b></h5>
                                <p class="text-warning" name="exr_last_round" id="exr_last_round" style="padding-top: 18px;"></p>
                            </div> -->
                            <hr>

                            <div class="col-md-6">
                                <h5 for="dp_id" class="text-muted font-18">หน่วยงาน</h5>
                                <p class="fw-bold font-18"><?php echo $edit['dp_name_th'];?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 for="exr_stde_id" class="text-muted font-18">แผนก</h5>
                                <p class="fw-bold font-18"><?php echo $edit['stde_name_th'];?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 for="exr_ps_id" class="text-muted font-18">ชื่อแพทย์เจ้าของผู้ป่วย</h5>
                                <p class="fw-bold font-18"><?php echo $edit['ps_full_name'];?></p>
                            </div>
                            <hr>

                            <div class="col-md-6">
                                <h5 for="rm_id" class="text-muted font-18">ห้องปฏิบัติการ</h5>
                                <p class="fw-bold font-18"><?php echo $edit['rm_name'];?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 for="exr_eqs_id" class="text-muted font-18">เครื่องมือหัตถการ</h5>
                                <p class="fw-bold font-18"><?php echo $edit['eqs_name'];?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 for="exr_create_user" class="text-muted font-18">เจ้าหน้าที่ดำเนินการ</h5>
                                <p class="fw-bold font-18"><?php echo $person->pf_name_abbr.$person->ps_fname.' '.$person->ps_lname; ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 for="exr_inspection_time" class="text-muted font-18">วันที่เวลาที่สั่งตรวจ</h5>
                                <p class="fw-bold font-18"><?php 
                                        if(empty($exr_inspection_time)) {
                                            echo "ยังไม่ได้ทำการตรวจ";
                                        } else {
                                            echo convertToThaiYear($exr_inspection_time, true);
                                        }
                                    ?></p>
                                <input type="hidden" class="form-control" name="exr_inspection_time" id="exr_inspection_time" value="<?php echo !empty($exr_inspection_time) ? $exr_inspection_time : null ;?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo $back_url; ?>'">ย้อนกลับ</button>
                            <?php if($is_detail_page == 0) { 
                                // $text = $next_exr_id ? 'ยืนยันผลตรวจ และตรวจเครื่องมือถัดไป' : 'ยืนยันผลตรวจ';
                                $text = 'ยืนยันผลตรวจ';
                            ?>
                                <button type="submit" class="btn btn-success float-end ms-2 font-20"><?php echo $text; ?></button>
                            <?php } ?>
                            <?php if(!empty($exr_id) && !empty($edit) && ($edit['exr_status'] != 'C') && $actor == 'officer') { ?>
                                <button type="button" class="btn btn-danger float-start ms-5" onclick="submit_cancel()">ยกเลิกผลตรวจ</button>
                            <?php } ?>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalPreviewContainer" class="text-center"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <a href="#" class="btn btn-primary" id="btn-download" target="_blank" title="คลิกปุ่มเพื่อดาวน์โหลดไฟล์"> ดาวน์โหลดไฟล์</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // const originalAjax = $.ajax;
    // $.ajax = function(settings) {
    //     console.log("AJAX Call: ", settings);
    //     return originalAjax.apply(this, arguments);
    // };
    
    // $(document).ajaxComplete(function() {
    //     console.log("Reloading the view page...");
    // });

    const dropzone = document.getElementById('dropzone');
    const files = document.getElementById('files');
    const fileTableBody = document.getElementById('fileTableBody');
    const modalPreviewContainer = document.getElementById('modalPreviewContainer');
    let filesArray = [];
    const is_have_files = <?php echo $is_have_files; ?>;
    const is_detail_page = <?php echo json_encode($is_detail_page); ?>;

    if(is_have_files == 1){
        let files = <?php echo !empty($files) && isset($files) ? json_encode($files, JSON_PRETTY_PRINT) : json_encode([]); ?>;
        addFilesFromDB(files);
    }

    // Handle click event to open file dialog
    dropzone.addEventListener('click', () => {
        files.click();
    });

    // Handle file input change event
    files.addEventListener('change', () => {
        addFiles(files.files);
    });

    // Handle drag and drop events
    dropzone.addEventListener('dragover', (event) => {
        event.preventDefault();
        event.stopPropagation();
        dropzone.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', (event) => {
        event.preventDefault();
        event.stopPropagation();
        dropzone.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', (event) => {
        event.preventDefault();
        event.stopPropagation();
        dropzone.classList.remove('dragover');
        addFiles(event.dataTransfer.files);
    });

    // Add files from db that saved to the filesArray and update the table
    function addFilesFromDB(newFiles) {
        for (const fileInfo of newFiles) {
            const { lastModified, name, size, type, webkitRelativePath, url } = fileInfo.file;
            
            // Create a Blob with file content
            const blob = new Blob([], { type });

            // Create the File object
            const file = new File([blob], name, {
                type,
                lastModified
            });

            // Set the correct file size
            Object.defineProperty(file, 'size', {
                value: size,
                writable: false
            });

            filesArray.push({
                file: file,
                name: file.name,
                // url: URL.createObjectURL(file)
                url: fileInfo.url,
                exrdId: fileInfo.exrdId
            });
        }

        updatefiles();
        updateTable();
    }

    // Add files to the filesArray and update the table
    function addFiles(newFiles) {
        for (const file of newFiles) {
            filesArray.push({
                file: file,
                name: file.name,
                url: URL.createObjectURL(file)
            });
        }
        updatefiles();
        updateTable();
    }

    // Update the file input's files property to reflect the files in filesArray
    function updatefiles() {
        const dataTransfer = new DataTransfer();
        filesArray.forEach(item => {
            dataTransfer.items.add(item.file);
        });
        files.files = dataTransfer.files;
    }

    // Update the table with the files in filesArray
    function updateTable() {
        fileTableBody.innerHTML = ''; // Clear previous rows
        filesArray.forEach((item, index) => {
            const row = document.createElement('tr');

            const noCell = document.createElement('td');
            noCell.classList.add('text-center');
            noCell.textContent = index + 1;

            const nameCell = document.createElement('td');
            nameCell.textContent = item.name;
            const nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.value = item.exrdId;
            nameInput.name = 'exrd_ids[]';
            nameCell.appendChild(nameInput);
            // const nameInput = document.createElement('input');
            // nameInput.type = 'text';
            // nameInput.value = item.name;
            // nameInput.classList.add('form-control');
            // nameInput.addEventListener('change', (event) => {
            //     item.name = event.target.value;
            //     // updateHiddenInputs();
            // });
            // nameCell.appendChild(nameInput);

            const actionCell = document.createElement('td');
            actionCell.classList.add('text-center');
            const iconSearch = document.createElement('i');
            iconSearch.className = 'bi-search';
            const previewButton = document.createElement('button');
            previewButton.classList.add('btn', 'btn-primary', 'me-3');
            previewButton.appendChild(iconSearch);
            previewButton.type = 'button';
            previewButton.addEventListener('click', () => {
                showPreview(item);
            });
            actionCell.appendChild(previewButton);

            if(is_detail_page == 0) {
                const iconRemove = document.createElement('i');
                iconRemove.className = 'bi-trash';
                const removeButton = document.createElement('button');
                removeButton.classList.add('btn', 'btn-danger');
                removeButton.appendChild(iconRemove);
                removeButton.addEventListener('click', () => {
                    removeFile(index);
                });
                actionCell.appendChild(removeButton);
            }

            row.appendChild(noCell);
            row.appendChild(nameCell);
            row.appendChild(actionCell);

            fileTableBody.appendChild(row);
        });
        // updateHiddenInputs();
    }

    // // Update hidden inputs for file names
    // function updateHiddenInputs() {
    //     // Clear existing hidden inputs
    //     const existingHiddenInputs = uploadForm.querySelectorAll('.hiddenFileNameInput');
    //     existingHiddenInputs.forEach(input => input.remove());

    //     // Add hidden inputs for updated file names
    //     filesArray.forEach((item, index) => {
    //         const hiddenInput = document.createElement('input');
    //         hiddenInput.type = 'hidden';
    //         hiddenInput.name = `fileNames[${index}]`;
    //         hiddenInput.value = item.name;
    //         hiddenInput.classList.add('hiddenFileNameInput');
    //         uploadForm.appendChild(hiddenInput);
    //     });
    // }

    // Remove file from the filesArray and update the table
    function removeFile(index) {
        filesArray.splice(index, 1);
        updatefiles();
        updateTable();
    }

    // Show preview in the modal
    function showPreview(item) {
        modalPreviewContainer.innerHTML = ''; // Clear previous preview

        if (item.file.type.startsWith('image/')) {
            modalPreviewContainer.innerHTML = `<img src="${item.url}" class="img-fluid" alt="${item.name}">`;
        } else if (item.file.type === 'application/pdf') {
            modalPreviewContainer.innerHTML = `<iframe src="${item.url}" width="100%" height="600px"></iframe>`;
        } else if (item.file.type === 'video/mp4') {
            modalPreviewContainer.innerHTML = ` <video width="100%" height="100%" controls>
                                                    <source src="${item.url}" type="video/mp4">
                                                    Your browser does not support the video tag or the file format of this video.
                                                </video>`;
        } else {
            modalPreviewContainer.innerHTML = `<p>${item.name}</p><a href="${item.url}" target="_blank">Open File</a>`;
        }

		$('#previewModalLabel').html(item.name);
		$('#btn-download').attr('href', item.url);
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }
</script>

<script>
    if(is_detail_page == 1) {
        // Disable all input elements
        $('input').prop('disabled', true);

        // // Disable all select2 elements
        // $('.select2').each(function() {
        //     $(this).prop('disabled', true);  // Disable the select2 container
        // });
    }

    function submit_cancel() {
        Swal.fire({
            title: 'คำเตือน',
            text: 'คุณต้องการยกเลิกผลตรวจนี้ใช่หรือไม่',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#dc3545",
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            }).then((result) => {
            if (result.isConfirmed) { // select confirm cancel
                let url = '<?php echo !empty($exr_id) && isset($exr_id) ? base_url()."index.php/dim/Import_examination_result/Import_examination_result_cancel/".$exr_id : "" ;?>';
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        if (data.data.status_response == status_response_success) {
                        dialog_success({ 'header': text_toast_delete_success_header, 'body': text_toast_delete_success_body }, null, true);
                        } else if (data.data.status_response == status_response_error) {
                        dialog_error({ 'header': text_toast_delete_error_header, 'body': text_toast_delete_error_body });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr);
                        dialog_error({ 'header': text_toast_delete_error_header, 'body': text_toast_delete_error_body });
                    }
                });
            }
        });
    }

    /**
     * is_null(value) : Function to check if a value is null, empty, or undefined
     */
    function is_null(value) {
        if (value !== null && value !== '' && value !== undefined) return false
        else return true
    }
</script>