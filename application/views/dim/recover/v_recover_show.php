<!-- Table -->
<div class="row">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-trash-fill icon-menu"></i><span> รายการไฟล์ที่ถูกลบ</span><span class="badge bg-success"><?php echo count($doc_bins); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">ชื่อไฟล์</th>
                                <th class="text-center" width="5%">Visit</th>
                                <th class="text-center" width="5%">HN</th>
                                <th width="15%">ชื่อ-นามสกุลผู้ป่วย</th>
                                <th width="15%">หน่วยงาน/แผนก</th>
                                <th width="10%">เครื่องมือหัตถการ</th>
                                <th class="text-center" width="10%">กำหนดการลบไฟล์</th>
                                <th class="text-center" width="10%">วันที่กู้คืนไฟล์</th>
                                <th class="text-center" width="10%">สถานะ</th>
                                <th class="text-center" width="10%">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($doc_bins as $row) {
                                    $status_class = $row['exrdb_status'] == 1 ? "text-danger" : ($row['exrdb_status'] == 0 ? "text-warning" : "text-success");
                                    $status_text = $row['exrdb_status'] == 1 ? "ลบแล้ว" : ($row['exrdb_status'] == 0 ? "รอดำเนินการ" : "กู้คืนแล้ว");
                            ?>
                            <tr>
                                <td><?php echo $row['exrd_file_name']; ?></td>
                                <td class="text-center"><?php echo $row['apm_visit']; ?></td>
                                <td class="text-center"><?php echo $row['pt_member']; ?></td>
                                <td><?php echo $row['pt_full_name']; ?></td>
                                <td><?php echo $row['dp_stde_name']; ?></td>
                                <td><?php echo $row['eqs_name']; ?></td>
                                <td><?php echo convertToThaiYear($row['exrdb_expiration_date'], true); ?></td>
                                <td><?php echo convertToThaiYear($row['exrdb_recover_date'], true); ?></td>
                                <td class="text-center <?php echo $status_class; ?>"><?php echo $status_text; ?></td>
                                <td class="text-center option">
                                    <!-- exrdb_status == 1(deleted) : cant do anything -->
                                    <?php if($row['exrdb_status'] != 1) { ?>
                                        <button class="btn btn-info" title="ดูรายละเอียด" onclick="showPreview('<?php echo $row['exrd_file_name']; ?>', '<?php echo $row['exrdb_exrd_id']; ?>')"><i class="bi-search"></i></button>
                                    <?php } ?>
                                    <!-- exrdb_status == 0(wait fo delete) : can recover -->
                                    <?php if($row['exrdb_status'] == 0) { ?>
                                        <button class="btn btn-success" title="กู้คืนไฟล์" onclick="recover_file('<?php echo base_url().'index.php/dim/Recover/Recover_update/2/'.$row['exrdb_exrd_id']; ?>', '<?php echo $row['exrd_file_name']; ?>')"><i class="bi-hourglass"></i></button>
                                        <button class="btn btn-danger" onclick="delete_file('<?php echo base_url().'index.php/dim/Recover/Recover_update/1/'.$row['exrdb_exrd_id']; ?>', '<?php echo $row['exrd_file_name']; ?>')"><i class="bi-trash"></i></button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php 
                                $i++; } 
                            ?>
                        </tbody>
                    </table>
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
    // Show preview in the modal
    function showPreview(filename, exrd_id) {
        let url = "<?php echo base_url()."index.php/dim/Examination_result/Examination_result_get_file/";?>" + exrd_id;
        let extension = filename.split('.').pop().toLowerCase();

        modalPreviewContainer.innerHTML = ''; // Clear previous preview

        if (['jpeg', 'jpg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp', 'svg', 'heif', 'heic', 'raw', 'cr2', 'nef', 'arw', 'psd', 'ico', 'eps', 'ai'].includes(extension)) {
            modalPreviewContainer.innerHTML = `<img src="${url}" class="img-fluid" alt="${filename}">`;
        } else if (['pdf'].includes(extension)) {
            modalPreviewContainer.innerHTML = `<iframe src="${url}" width="100%" height="600px"></iframe>`;
        } else if ((['mp4','avi','mov','wmv','mkv','flv','m4v','mpeg','mpg']).includes(extension)) {
            modalPreviewContainer.innerHTML = ` <video width="100%" height="100%" controls>
                                                    <source src="${url}" type="video/mp4">
                                                    Your browser does not support the video tag or the file format of this video.
                                                </video>`;
        } else {
            modalPreviewContainer.innerHTML = `<p>${filename}</p><a href="${url}" target="_blank">Open File</a>`;
        }
        
		$('#previewModalLabel').html(filename);
		$('#btn-download').attr('href', url);
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }
    
    function delete_file(url, filename) {
        let text = "เมื่อคุณลบไฟล์ คูณจะไม่สามารถกู้คืนไฟล์นี้ได้อีก คุณต้องการลบไฟล์ " + filename + " ใช่หรือไม่"
        swal_alert(url, text, "ลบข้อมูล");
    }
    
    function recover_file(url, filename) {
        let text = "คุณต้องการกู้คืนไฟล์ " + filename + " ใช่หรือไม่"
        swal_alert(url, text, "กู้คืนไฟล์");
    }

    function swal_alert(url, text, title) {
        Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#dc3545",
        confirmButtonText: text_swal_delete_confirm,
        cancelButtonText: text_swal_delete_cancel
        }).then((result) => {
        if (result.isConfirmed) {
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
</script>

<script>
    $(document).ready(function() {
        // Setting Export Datatable.js
        var table = $('.datatable').DataTable();
        var buttons = table.buttons();

        buttons.each(function(button, buttonIdx) {
            if (button) {
                // get config
                var config = button.inst.s.buttons[buttonIdx].conf;
                // specify some config
                var columns = [0, 1, 2, 3, 4, 5, 6, 7, 8]; // specify columns to export
                title = "รายการไฟล์ที่ถูกลบ"; // specify title of head in file

                if(config.titleAttr == "Print") { // if need setting file Print
                    config.exportOptions = { columns: columns };
                    config.title = '<h3 class="font-weight-600 text-center">รายการไฟล์ที่ถูกลบ</h3>';
                    // $("." + config.className).html("Print"); // specify text and style of button
                }
                if(config.titleAttr == "Excel") { // if need setting file Excel
                    config.exportOptions = { columns: columns };
                    config.title = title;
                    // $("." + config.className).html("Excel"); // specify text and style of button
                }
                if(config.titleAttr == "PDF") { // if need setting file PDF
                    config.exportOptions = { columns: columns };
                    config.title = title;
                    config.customize = function (doc) {
                        doc.defaultStyle = { font: 'THSarabun' };
                        doc.content[1].table.widths = ['10%', '5%', '15%', '15%', '15%', '10%', '10%', '10%'];
                        // doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto'];
                    };
                    // $("." + config.className).html("PDF"); // specify text and style of button
                }
            }
        });
    });
</script>