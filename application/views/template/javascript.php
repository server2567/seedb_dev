<!-- Vendor JS Files -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/chart.js/chart.umd.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/echarts/echarts.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/quill/quill.min.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/simple-datatables/simple-datatables.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/php-email-form/validate.js"></script> -->


<!-- Plugin JS Files -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/toast/bootstrap-show-toast.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert2-11.10.6/sweetalert2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/js/select2.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/buttons.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/vfs_fonts_thsarabun.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/buttons.print.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/flatpickr/rangePlugin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/flatpickr/flatpickr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/flatpickr/th.js"></script> -->

<!-- Template Main JS File -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script>
    // Define Enum OK Status Code
    const status_response_show = <?php echo $this->config->item('status_response_show'); ?>;
    const status_response_success = <?php echo $this->config->item('status_response_success'); ?>;
    const status_response_error = <?php echo $this->config->item('status_response_error'); ?>;

    const text_invalid_default = "<?php echo $this->config->item('text_invalid_default'); ?>";
    const text_invalid_inputs = "<?php echo $this->config->item('text_invalid_inputs'); ?>";
    const text_invalid_duplicate = "<?php echo $this->config->item('text_invalid_duplicate'); ?>";

    const text_swal_delete_title = "<?php echo $this->config->item('text_swal_delete_title'); ?>";
    const text_swal_delete_text = "<?php echo $this->config->item('text_swal_delete_text'); ?>";
    const text_swal_delete_confirm = "<?php echo $this->config->item('text_swal_delete_confirm'); ?>";
    const text_swal_delete_cancel = "<?php echo $this->config->item('text_swal_delete_cancel'); ?>";
    
    const text_toast_default_success_header = "<?php echo $this->config->item('text_toast_default_success_header'); ?>";
    const text_toast_default_success_body = "<?php echo $this->config->item('text_toast_default_success_body'); ?>";
    const text_toast_default_error_header = "<?php echo $this->config->item('text_toast_default_error_header'); ?>";
    const text_toast_default_error_body = "<?php echo $this->config->item('text_toast_default_error_body'); ?>";

    const text_toast_save_success_header = "<?php echo $this->config->item('text_toast_save_success_header'); ?>";
    const text_toast_save_success_body = "<?php echo $this->config->item('text_toast_save_success_body'); ?>";
    const text_toast_save_error_header = "<?php echo $this->config->item('text_toast_save_error_header'); ?>";
    const text_toast_save_error_body = "<?php echo $this->config->item('text_toast_save_error_body'); ?>";

    const text_toast_delete_success_header = "<?php echo $this->config->item('text_toast_delete_success_header'); ?>";
    const text_toast_delete_success_body = "<?php echo $this->config->item('text_toast_delete_success_body'); ?>";
    const text_toast_delete_error_header = "<?php echo $this->config->item('text_toast_delete_error_header'); ?>";
    const text_toast_delete_error_body = "<?php echo $this->config->item('text_toast_delete_error_body'); ?>";

    const datatable_second_reload = "<?php echo $this->config->item('datatable_second_reload'); ?>";

    // Set Active Menu
    const menuActive = <?php echo !empty($session_menus_active) ? json_encode($session_menus_active) : json_encode(null); ?>;
    setActiveMenu();
    $(document).ready(function() {
        $('#mainModal').modal({
            backdrop: 'static',
            keyboard: false
        })
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

	$(document).on("click", "#btn_preview_file", function () {
		var file_name = $(this).data('file-name');
		var file_id = $(this).data('file-id');
		var file_preview_path = $(this).data('preview-path');
		var file_download_path = $(this).data('download-path');
		$('#preview_file_modal .modal-header .modal-title').html("ตัวอย่างไฟล์ " + file_name);
		$('#preview_file_modal .modal-body #modal-iframe').attr('src', file_preview_path);
		$('#preview_file_modal .modal-footer .download_file_btn_modal').attr('href', file_download_path);

	});

// Areerat ฟังก์ช์ชันพวกนี้ให้ย้ายไปใช้ใน Header นะ
  function convertYearsToThai() {
    const calendar = document.querySelector('.flatpickr-calendar');
    if (!calendar) return;

    const years = calendar.querySelectorAll('.cur-year, .numInput');
    years.forEach(function(yearInput) {
        convertToThaiYear(yearInput);
    });

    const yearDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
    yearDropdowns.forEach(function(monthDropdown) {
        if (monthDropdown) {
            monthDropdown.querySelectorAll('option').forEach(function(option) {
                convertToThaiYearDropdown(option);
            });
        }
    });

    const currentYearElement = calendar.querySelector('.flatpickr-current-year');
    if (currentYearElement) {
        const currentYear = parseInt(currentYearElement.textContent);
        if (currentYear < 2400) {
            currentYearElement.textContent = currentYear + 543;
            
        }
    }
  }

  function convertToThaiYear(yearInput) {
    const currentYear = parseInt(yearInput.value);
    if (currentYear < 2400) { // Convert to B.E. only if not already converted
        yearInput.value = currentYear + 543;
    }

  }

  function convertToThaiYearDropdown(option) {
    const year = parseInt(option.textContent);
    if (year < 2400) { // Convert to B.E. only if not already converted
        option.textContent = year + 543;
    }
  }

  function formatDateToThai(date) {
    let d = new Date(date);
    let year = d.getFullYear();
    let month = ('0' + (d.getMonth() + 1)).slice(-2);
    let day = ('0' + d.getDate()).slice(-2);

    if (year < 2400) { // Convert to B.E. only if not already converted
        year = year + 543;
    }

    return `${day}/${month}/${year}`;
  } 
</script>