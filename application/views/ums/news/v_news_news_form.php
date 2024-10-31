<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<!-- Bootstrap Bundle JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js"></script>

<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<?php
// ฟังก์ชันแปลงปีไทย (พ.ศ.) เป็นปีคริสต์ศักราช (ค.ศ.)
function convertToCE($dateStr)
{
    $parts = explode('/', $dateStr);
    if (count($parts) === 3) {
        $day = $parts[0];
        $month = $parts[1];
        $year = $parts[2] - 543; // แปลงปีเป็น ค.ศ.
        return "$day/$month/$year";
    }
    return $dateStr;
}

// ฟังก์ชันแปลงปีคริสต์ศักราช (ค.ศ.) เป็นปีไทย (พ.ศ.)
function convertToTH($dateStr)
{
    $parts = explode('-', $dateStr);
    if (count($parts) === 3) {
        $year = $parts[0] + 543;
        $month = $parts[1];
        $day = $parts[2];
        return "$day/$month/$year";
    }
    return $dateStr;
}

// สมมติว่าคุณมีค่า $date_start, $date_stop
$date_start = !empty($date_start) ? convertToTH($date_start) : '';
$date_stop = !empty($date_stop) ? convertToTH($date_stop) : '';
?>

<style>
    .quill-editor-full {
        height: auto;
    }

    .ql-editor {
        height: 150px;
    }
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($usID) ? 'แก้ไข' : 'เพิ่ม' ?>หัวข้อข้อมูลข่าวสาร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation">
                        <div class="col-md-6">
                            <label for="StNameT" class="form-label required">หัวเรื่อง</label>
                            <input type="text" class="form-control" name="nameinput[]" id="StNameT" placeholder="ชื่อระบบภาษาไทย" value="<?php echo !empty($edit) ? $edit->news_name : ""; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StType" class="form-label required">ประเภท</label>
                            <div class="form-check">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="nameinput[]" id="StType1" value="1" <?php echo !empty($edit) && $edit->news_type == "1" ? 'checked' : ''; ?> required>
                                        <label for="StType1" class="form-check-label">ปกติ</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="nameinput[]" id="StType2" value="2" <?php echo !empty($edit) && $edit->news_type == "2" ? 'checked' : ''; ?> required>
                                        <label for="StType2" class="form-check-label">ด่วน</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="date" class="form-label required">แสดง</label>
                            <div class="input-group date input-daterange">
                                <input type="text" class="form-control" name="nameinput[]" id="start_date" value="<?php echo $date_start; ?>" placeholder="วว/ดด/ปป">
                                <span class="input-group-text mb-3">เวลา</span>
                                <input type="time" class="form-control" name="nameinput[]" id="time_start" placeholder="ชม:นาที" value="<?php echo !empty($time_start) ? $time_start : ''; ?>" required>
                                <span class="input-group-text mb-3">ถึง</span>
                                <input type="text" class="form-control" name="nameinput[]" id="end_date" required placeholder="วว/ดด/ปป" value="<?php echo $date_stop; ?>">
                                <span class="input-group-text mb-3">เวลา</span>
                                <input type="time" class="form-control" name="nameinput[]" id="time_stop" value="<?php echo !empty($time_stop) ? $time_stop : ''; ?>" placeholder="ชม:นาที" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="NgId" class="form-label required">กลุ่มการมองเห็น</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกกลุ่มการมองเห็น --" name="nameinput[]" id="NgId" multiple required>
                                <?php
                                $index = 0; // Initialize index counter
                                foreach (ROLE as $keys => $group) : ?>
                                    <option value="<?= $keys; ?>" <?= !empty($bg_id[$keys]) && $bg_id[$keys] == $keys ? 'selected' : ''; ?>>
                                        <?= ($keys) . '. ' . $group; ?> <!-- Display index and group name -->
                                    </option>
                                <?php
                                    $index++; // Increment index counter
                                endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="StActive" class="form-label required">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="nameinput[]" id="StActive" <?php echo !empty($edit) && $edit->news_active == "1" ? 'checked' : ''; ?>>
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="StDetail" class="form-label">รายละเอียด</label>
                            <textarea class="tinymce-editor" name="nameinput[]" id="StDetail">
                            <?php echo !empty($edit->news_text) ? $edit->news_text : ""; ?>
                            </textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="FileId" class="form-label">อัพโหลดไฟล์เอกสาร</label>
                            <input type="file" class="form-control" name="nameinput[]" id="FileId" accept=".pdf,.doc,.docx">
                        </div>

                        <?php if (isset($edit) && is_object($edit) && !empty($edit->news_file_name)) : ?>
                            <div>
                                <?php if (isset($edit->news_file_name) && !empty($edit->news_file_name)) : ?>
                                    <a class="btn btn-link" data-file-name="<?php echo $edit->news_file_name; ?>" data-preview-path="<?php echo site_url($this->config->item('ums_dir') . 'Getpreview?path=' . $this->config->item('ums_uploads_news_file') . '&doc=' . $edit->news_file_name); ?>" data-download-path="<?php echo site_url($this->config->item('ums_uploads_news_file') . 'Getdoc?path=' . $this->config->item('ums_uploads_news_file') . '&doc=' . "a.png" . '&rename=' . "a.png"); ?>" data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน">
                                        <?php echo $edit->news_file_name; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                            <label for="ImageId" class="form-label">อัพโหลดรูปภาพ</label>
                            <input type="file" class="form-control" name="nameinput[]" id="imgId" accept=".jpg,.jpeg,.png,.gif">
                        </div>
                        <?php if (isset($edit) && is_object($edit) && !empty($edit->news_img_name)) : ?>
                            <div>
                                <?php if (isset($edit->news_img_name) && !empty($edit->news_img_name)) : ?>
                                    <a class="btn btn-link" data-file-name="<?php echo $edit->news_img_name; ?>" data-preview-path="<?php echo site_url($this->config->item('ums_dir') . 'Getpreview?path=' . $this->config->item('ums_uploads_news_img') . '&doc=' . $edit->news_img_name); ?>" data-download-path="<?php echo site_url($this->config->item('ums_uploads_news_img') . 'Getdoc?path=' . $this->config->item('ums_uploads_news_img') . '&doc=' . "a.png" . '&rename=' . "a.png"); ?>" data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน">
                                        <?php echo $edit->news_img_name; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="container mt-5">
                            <h2>Upload your files</h2>
                            <form action="/upload" class="dropzone" id="my-dropzone"></form>
                        </div>

                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/ums/News'">ย้อนกลับ</button>
                            <?php if (!empty($edit->news_id)) : ?>
                                <button onclick="saveFormSubmit(<?php echo !empty($edit->news_id) ? $edit->news_id : ""; ?>)" class="btn btn-success float-end">บันทึก</button>
                            <?php else : ?>
                                <button onclick="saveFormSubmit()" class="btn btn-success float-end">บันทึก</button>
                            <?php endif ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script>
    // flatpickr("#start_date", {
    //     plugins: [
    //         new rangePlugin({
    //             input: "#end_date"
    //         })
    //     ],
    //     dateFormat: 'd/m/Y',
    //     locale: 'th',
    //     defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
    //     onReady: function(selectedDates, dateStr, instance) {
    //         document.getElementById('start_date').value = formatDateToThai('<?php echo !empty($search) && isset($search['start_date']) ? $search['start_date'] : ""; ?>');
    //         document.getElementById('end_date').value = formatDateToThai('<?php echo !empty($search) && isset($search['end_date']) ? $search['end_date'] : ""; ?>');
    //         // addMonthNavigationListeners();
    //         // convertYearsToThai();
    //     },
    //     onOpen: function(selectedDates, dateStr, instance) {
    //         convertYearsToThai();
    //     },
    //     onValueUpdate: function(selectedDates, dateStr, instance) {
    //         convertYearsToThai();
    //         if (selectedDates[0]) {
    //             document.getElementById('start_date').value = formatDateToThai(selectedDates[0]);
    //         }
    //         if (selectedDates[1]) {
    //             document.getElementById('end_date').value = formatDateToThai(selectedDates[1]);
    //         }
    //     },
    //     onMonthChange: function(selectedDates, dateStr, instance) {
    //         convertYearsToThai();
    //     },
    //     onYearChange: function(selectedDates, dateStr, instance) {
    //         convertYearsToThai();
    //     }
    // });

    // function convertYearsToThai() {
    //     const calendar = document.querySelector('.flatpickr-calendar');
    //     if (!calendar) return;

    //     const years = calendar.querySelectorAll('.cur-year, .numInput');
    //     years.forEach(function(yearInput) {
    //         convertToThaiYear(yearInput);
    //     });

    //     const yearDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
    //     yearDropdowns.forEach(function(monthDropdown) {
    //         if (monthDropdown) {
    //             monthDropdown.querySelectorAll('option').forEach(function(option) {
    //                 convertToThaiYearDropdown(option);
    //             });
    //         }
    //     });

    //     const currentYearElement = calendar.querySelector('.flatpickr-current-year');
    //     if (currentYearElement) {
    //         const currentYear = parseInt(currentYearElement.textContent);
    //         if (currentYear < 2500) {
    //             currentYearElement.textContent = currentYear + 543;
    //         }
    //     }
    // }

    // function convertToThaiYear(yearInput) {
    //     const currentYear = parseInt(yearInput.value);
    //     if (currentYear < 2500) { // Convert to B.E. only if not already converted
    //         yearInput.value = currentYear + 543;
    //     }
    // }

    // function convertToThaiYearDropdown(option) {
    //     const year = parseInt(option.textContent);
    //     if (year < 2500) { // Convert to B.E. only if not already converted
    //         option.textContent = year + 543;
    //     }
    // }

    // function formatDateToThai(date) {
    //     if (date) {
    //         const d = new Date(date);
    //         const year = d.getFullYear() + 543;
    //         const month = ('0' + (d.getMonth() + 1)).slice(-2);
    //         const day = ('0' + d.getDate()).slice(-2);
    //         // const hour = ('0' + d.getHours()).slice(-2);
    //         // const min = ('0' + d.getMinutes()).slice(-2);
    //         return `${day}/${month}/${year}`;
    //     }
    //     return '';
    // }

    function saveFormSubmit(id = null) {
        var formData = new FormData();
        var date = [];
        var File = "";
        var img = "";
        var gid = [];
        var StDetail = '';
        var StNameT = "";

        // ฟังก์ชันแปลงปีไทย (พ.ศ.) เป็นปีคริสต์ศักราช (ค.ศ.)
        function convertToCE(dateStr) {
            var parts = dateStr.split('/');
            if (parts.length === 3) {
                var day = parts[0];
                var month = parts[1];
                var year = parts[2] - 543;
                return `${day}/${month}/${year}`;
            }
            return dateStr;
        }

        $('[name^="nameinput[]"]').each(function() {
            if (this.tagName === "SELECT" && this.multiple) {
                // Handle multiple selected options
                Array.from(this.selectedOptions).forEach(option => gid.push(option.value));
            }
            if (this.id == "StDetail") {
                StDetail = tinymce.get('StDetail').getContent();
            }
            if (this.id == 'start_date' || this.id == 'time_start') {
                formData.append(this.id, convertToCE(this.value)); // แปลงปีเป็น ค.ศ.
                // date[this.id] = this.value;
            }
            if (this.id == 'end_date' || this.id == 'time_stop') {
                formData.append(this.id, convertToCE(this.value)); // แปลงปีเป็น ค.ศ.
                // date[this.id] = this.value;
            }
            if (this.id == 'StNameT') {
                StNameT = this.value;
            }
        });

        console.log(formData);
        var StActive = document.getElementById('StActive').checked ? "1" : "0";
        // Handle radio button
        var StType = document.querySelector('input[name="nameinput[]"]:checked').value;
        var FileInput = document.getElementById('FileId');
        console.log(FileInput.files[0]);
        var imgInput = document.getElementById('imgId');
        if (FileInput.files.length) {
            File = FileInput.files[0];
            formData.append('FileInput', FileInput.files[0]);
        }
        if (imgInput.files.length > 0) {
            // fileData.append('imgInput', imgInput.files[0]);
            img = imgInput.files[0];
        }
        formData.append('StDetail', StDetail);
        formData.append('StActive', StActive);
        formData.append('StType', StType);
        formData.append('gid', gid);
        formData.append('date', date);
        formData.append('FileInput', File);
        formData.append('ImgInput', img);
        formData.append('StNameT', StNameT);
        console.log(formData);
        if (id) {
            formData.append('id', id);
        }
        if (id != null) {
            $.ajax({
                method: "POST",
                url: '../Update_News',
                data: formData,
                processData: false,
                contentType: false,
                success: function(returnData) {
                    console.log(returnData);
                    if (returnData == 1) {
                        dialog_success({
                            'header': 'ดำเนินการเสร็จสิ้น',
                            'body': 'บันทึกข้อมูลเสร็จสิ้น'
                        });
                        // setTimeout(function() {
                        //     window.location.href = '<?php echo base_url() ?>index.php/ums/News'
                        // }, 1500);

                    } else {
                        dialog_error({
                            'header': 'การเพิ่มข้อมุลล้มเหลว',
                            'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                        });
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': 'การเพิ่มข้อมุลล้มเหลว',
                        'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            });
        } else {
            $.ajax({
                method: "POST",
                url: 'add',
                data: formData,
                processData: false,
                contentType: false,
                success: function(returnData) {
                    console.log(returnData);
                    if (returnData == 1) {
                        dialog_success({
                            'header': 'ดำเนินการเสร็จสิ้น',
                            'body': 'บันทึกข้อมูลเสร็จสิ้น'
                        });
                        // setTimeout(function() {
                        //     window.location.href = '<?php echo base_url() ?>index.php/ums/News'
                        // }, 1500);

                    } else {
                        dialog_error({
                            'header': 'การเพิ่มข้อมุลล้มเหลว',
                            'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                        });
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': 'การเพิ่มข้อมุลล้มเหลว',
                        'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            });
        }
    }


    // $(document).ready(function() {
    //     function updateDatepickerValues(selectedDates) {
    //         if (selectedDates.length > 0) {
    //             var date = selectedDates[0];
    //             var day = ('0' + date.getDate()).slice(-2);
    //             var month = ('0' + (date.getMonth() + 1)).slice(-2);
    //             var year = date.getFullYear() + 543; // Convert to Buddhist year
    //             var formattedDate = day + '/' + month + '/' + year;
    //             $(".datepicker").val(formattedDate);
    //         }
    //     }
    //     var today = new Date();
    //     var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    //     var maxDate = new Date();
    //     maxDate.setDate(maxDate.getDate() + 500);

    //     // Initialize Flatpickr with Thai locale and Thai Buddhist calenda
    // });
    // $(document).ready(function() {
    //     function updateDatepickerValues(selectedDates) {
    //         if (selectedDates.length > 0) {
    //             var date = selectedDates[0];
    //             var day = ('0' + date.getDate()).slice(-2);
    //             var month = ('0' + (date.getMonth() + 1)).slice(-2);
    //             var year = date.getFullYear() + 543; // Convert to Buddhist year
    //             var formattedDate = day + '/' + month + '/' + year;
    //             $(".datepicker").val(formattedDate);
    //         }
    //     }
    //     var today = new Date();
    //     var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    //     var maxDate = new Date();
    //     maxDate.setDate(maxDate.getDate() + 500);

    //     // Initialize Flatpickr with Thai locale and Thai Buddhist calendar
    //     flatpickr(".datepicker", {
    //         dateFormat: 'd/m/Y',
    //         locale: 'th',
    //         defaultDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()), // Set to current Gregorian date

    //         onReady: function(selectedDates, dateStr, instance) {
    //             convertYearsToThai(instance);
    //             updateDatepickerValues([today]); // Display the default date in Buddhist year format
    //         },
    //         onOpen: function(selectedDates, dateStr, instance) {
    //             convertYearsToThai(instance);
    //         },
    //         onValueUpdate: function(selectedDates, dateStr, instance) {
    //             convertYearsToThai(instance);
    //             updateDatepickerValues(selectedDates);
    //         },
    //         onMonthChange: function(selectedDates, dateStr, instance) {
    //             convertYearsToThai(instance);
    //         },
    //         onYearChange: function(selectedDates, dateStr, instance) {
    //             convertYearsToThai(instance);
    //         }
    //     });
    // });
</script> -->
<!-- <script>
    flatpickr("#start_date", {
        plugins: [
            new rangePlugin({
                input: "#end_date"
            })
        ],
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        onReady: function(selectedDates, dateStr, instance) {
            document.getElementById('start_date').value = '<?php echo $thai_date_start; ?>';
            document.getElementById('end_date').value = '<?php echo $thai_date_stop; ?>';
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (selectedDates[0]) {
                document.getElementById('start_date').value = formatDateToThai(selectedDates[0]);
            }
            if (selectedDates[1]) {
                document.getElementById('end_date').value = formatDateToThai(selectedDates[1]);
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });
</script> -->
<!-- <script>
    flatpickr("#start_date", {
        plugins: [
            new rangePlugin({
                input: "#end_date"
            })
        ],
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        onReady: function(selectedDates, dateStr, instance) {
            document.getElementById('start_date').value = '<?php echo $date_start; ?>';
            document.getElementById('end_date').value = '<?php echo $date_stop; ?>';
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (selectedDates[0]) {
                document.getElementById('start_date').value = formatDateToThai(selectedDates[0]);
            }
            if (selectedDates[1]) {
                document.getElementById('end_date').value = formatDateToThai(selectedDates[1]);
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    function convertToCE(dateStr) {
        var parts = dateStr.split('/');
        if (parts.length === 3) {
            var day = parts[0];
            var month = parts[1];
            var year = parseInt(parts[2], 10) - 543;
            return `${day}/${month}/${year}`;
        }
        return dateStr;
    }

    
</script> -->
<script>
    flatpickr("#start_date", {
        plugins: [
            new rangePlugin({
                input: "#end_date"
            })
        ],
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        onReady: function(selectedDates, dateStr, instance) {
            document.getElementById('start_date').value = '<?php echo $date_start; ?>';
            document.getElementById('end_date').value = '<?php echo $date_stop; ?>';
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (selectedDates[0]) {
                document.getElementById('start_date').value = formatDateToThai(selectedDates[0]);
            }
            if (selectedDates[1]) {
                document.getElementById('end_date').value = formatDateToThai(selectedDates[1]);
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    function convertToCE(dateStr) {
        var parts = dateStr.split('/');
        if (parts.length === 3) {
            var day = parts[0];
            var month = parts[1];
            var year = parseInt(parts[2], 10) - 543;
            return `${year}-${month}-${day}`; // เปลี่ยนเป็น Y-m-d
        }
        return dateStr;
    }

    function saveFormSubmit(id = null) {
        if (!validateRequiredFields()) {
            dialog_error({
                'header': 'การเพิ่มข้อมุลล้มเหลว',
                'body': 'กรุณาใส่ข้อมูลให้ครบถ้วน'
            });
            return; // หยุดการทำงานหากไม่ผ่านการตรวจสอบ
        }
        var formData = new FormData();
        var date = [];
        var File = "";
        var img = "";
        var gid = [];
        var StDetail = '';
        var StNameT = "";

        $('[name^="nameinput[]"]').each(function() {
            if (this.tagName === "SELECT" && this.multiple) {
                // Handle multiple selected options
                Array.from(this.selectedOptions).forEach(option => gid.push(option.value));
            }
            if (this.id == "StDetail") {
                StDetail = tinymce.get('StDetail').getContent();
            }
            if (this.id == 'start_date') {
                var startDateCE = convertToCE(this.value); // แปลงปีเป็น ค.ศ.
                formData.append(this.id, startDateCE);
            }
            if (this.id == 'time_start') {
                formData.append(this.id, this.value);
            }
            if (this.id == 'end_date') {
                var endDateCE = convertToCE(this.value); // แปลงปีเป็น ค.ศ.
                formData.append(this.id, endDateCE);
            }
            if (this.id == 'time_stop') {
                formData.append(this.id, this.value);
            }
            if (this.id == 'StNameT') {
                StNameT = this.value;
            }
        });

        console.log(formData);
        var StActive = document.getElementById('StActive').checked ? "1" : "0";
        // Handle radio button
        var StType = document.querySelector('input[name="nameinput[]"]:checked').value;
        var FileInput = document.getElementById('FileId');
        console.log(FileInput.files[0]);
        var imgInput = document.getElementById('imgId');
        if (FileInput.files.length) {
            File = FileInput.files[0];
            formData.append('FileInput', FileInput.files[0]);
        }
        if (imgInput.files.length > 0) {
            img = imgInput.files[0];
        }
        formData.append('StDetail', StDetail);
        formData.append('StActive', StActive);
        formData.append('StType', StType);
        formData.append('gid', gid);
        formData.append('FileInput', File);
        formData.append('ImgInput', img);
        formData.append('StNameT', StNameT);
        console.log(formData);
        if (id) {
            formData.append('id', id);
        }
        if (id != null) {
            $.ajax({
                method: "POST",
                url: '../Update_News',
                data: formData,
                processData: false,
                contentType: false,
                success: function(returnData) {
                    console.log(returnData);
                    if (returnData == 1) {
                        dialog_success({
                            'header': 'ดำเนินการเสร็จสิ้น',
                            'body': 'บันทึกข้อมูลเสร็จสิ้น'
                        });
                        setTimeout(function() {
                            window.location.href = '<?php echo base_url() ?>index.php/ums/News'
                        }, 1500);

                    } else {
                        dialog_error({
                            'header': 'การเพิ่มข้อมุลล้มเหลว',
                            'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': 'การเพิ่มข้อมุลล้มเหลว',
                        'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            });
        } else {
            $.ajax({
                method: "POST",
                url: 'add',
                data: formData,
                processData: false,
                contentType: false,
                success: function(returnData) {
                    console.log(returnData);
                    if (returnData == 1) {
                        dialog_success({
                            'header': 'ดำเนินการเสร็จสิ้น',
                            'body': 'บันทึกข้อมูลเสร็จสิ้น'
                        });
                        setTimeout(function() {
                            window.location.href = '<?php echo base_url() ?>index.php/ums/News'
                        }, 1500);

                    } else {
                        dialog_error({
                            'header': 'การเพิ่มข้อมุลล้มเหลว',
                            'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': 'การเพิ่มข้อมุลล้มเหลว',
                        'body': 'ไม่สามารถเพิ่มข้อมูลได้'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            });
        }
    }

    function validateRequiredFields() {
        var isValid = true;
        // ตรวจสอบทุก input ที่มี attribute `required`
        document.querySelectorAll('input[required], select[required], textarea[required]').forEach(function(element) {
            if (!element.value) {
                isValid = false;
                // เพิ่มคลาส error หรือทำสิ่งที่คุณต้องการเพื่อแจ้งเตือนผู้ใช้
                element.classList.add('error');
            } else {
                element.classList.remove('error');
            }
        });

        return isValid;
    }
</script>