<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi bi-info-circle-fill icon-menu"></i><span><?php echo !empty($qr_code[0]['qr_id']) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูล QR-Code <?php echo !empty($qr_code[0]['qr_id']) ? $qr_code[0]['qr_stde_name'] : '' ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" id="qr_form">
                        <input type="hidden" class="form-control" name="qr_id" id="qr_id" value="<?php echo !empty($qr_code[0]['qr_id']) ? $qr_code[0]['qr_id'] : "" ?>">
                        <div class="col-md-6">
                          <label for="qr_stde_id" class="form-label required">แผนกการรักษา</label>
                          <select class="form-select select2" name="qr_stde_id" id="qr_stde_id" data-placeholder="-- กรุณาเลือกแผนกการรักษา --">
                            <option value=""></option>
                            <?php if (isset($stde)) { ?>
                              <?php foreach ($stde as $dep) : ?>
                                <option value="<?php echo $dep->stde_id ?>" data-name="<?php echo $dep->stde_name_th ?>" <?php echo (isset($qr_code[0]['qr_stde_id']) && $dep->stde_id == $qr_code[0]['qr_stde_id']) ? 'selected' : ''; ?>>
                                  <?php echo $dep->stde_name_th ?>
                                </option>
                              <?php endforeach ?>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <label for="qr_deatile" class="form-label">คำอธิบายเพิ่มเติม</label>
                                <?php if (isset($qr_code) && !empty($qr_code[0]['qr_id'])) { ?>
                                    <div id="quill-editor" class="form-control" style="height: 200px;" id="qr_deatile" name="qr_deatile"></div>
                                    <textarea id="hidden_qr_deatile" name="qr_deatile" style="display:none;"></textarea>
                                <?php } else { ?>
                                    <textarea name="qr_deatile" id="qr_deatile"  class="quill-editor-default form-control" ></textarea>
                                <?php } ?>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <div id="qr_display">
                                </div>
                        </div>
                        <div class="col-md-12">
                          <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/wts/System_qr_code'">ย้อนกลับ</button>
                            <?php if (isset($qr_code) && !empty($qr_code[0]['qr_id'])) { ?>
                                <button type="submit" class="btn btn-success float-end" id="qr_update">บันทึก</button>
                            <?php } else { ?>
                                <button type="submit" class="btn btn-success float-end" id="qr_add">บันทึก</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function handleClick(element) {
  var activeElements = document.querySelectorAll('.active');
  activeElements.forEach(function(el) {
    el.classList.remove('active');
  });
  element.classList.add('active');
}

const qr_deatile = [
  { insert: '<?php echo $qr_code[0]['qr_deatile'] ?>\n' }
];

var quill = new Quill('#quill-editor', {
  theme: 'snow',
  modules: {
    toolbar: [
      ['bold', 'italic'],
      ['link', 'blockquote', 'code-block', 'image'],
      [{ list: 'ordered' }, { list: 'bullet' }],
    ],
  },
});

quill.setContents(qr_deatile);

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    function qr_generate() {
      const qr_id = $('#qr_id').val();
      const qr_stde = $('#qr_stde_id option:selected').val();
      const qr_deatile = $('#qr_deatile').val();
      const base_url = "<?php echo base_url(); ?>index.php/wts/frontend/User_check_que/que_search/";
      const qr_text = base_url + qr_id + '/' + qr_stde;
      let qr_img_name = ''; // Use 'let' instead of 'const'

      if (qr_id == '') {
        qr_img_name = 'qrcode_id_'; // Assign value without 'const'
      } else {
        qr_img_name = 'qrcode_id_' + qr_id; // Assign value without 'const'
      }   
      const qr_container = document.getElementById('qr_display');
      qr_container.innerHTML = '';

      var qr_img = new QRCode(qr_container, {
        text: qr_text,
        width: 230,
        height: 230
      });

      var canvas = qr_container.getElementsByTagName('canvas')[0];
      var qr_img_url = canvas.toDataURL("image/png"); // Convert canvas to data URL
      return { qr_img_url: qr_img_url, qr_img_name: qr_img_name }; // Return data
    }

    if ($('#qr_id').val() != '') {
      qr_generate();
    }

    $('#qr_add').on('click', function(event) {
        var qrData = qr_generate(); // Get QR code data

        var formData = $('#qr_form').serializeArray();
        formData.push({ name: 'qr_img_url', value: qrData.qr_img_url }); // Add QR image URL to formData
        formData.push({ name: 'qr_img_name', value: qrData.qr_img_name }); // Add QR image name to formData

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/wts/System_qr_code/qr_insert',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    dialog_error({
                        'header': response.header,
                        'body': response.body
                    });
                } else if (response.status === 'success') {
                    dialog_success({
                        'header': response.header,
                        'body': response.body
                    });
                    setInterval(function(){window.location.href = response.returnUrl;}, 3000);
                  }
            }
        });
    });

    $('#qr_update').on('click', function(event) {
      var qrData = qr_generate(); // Get QR code data

      $('#hidden_qr_deatile').val(quill.getText().trim());

      var formData = $('#qr_form').serializeArray(); // Serialize form data
      formData.push({ name: 'qr_img_url', value: qrData.qr_img_url }); // Add QR image URL to formData
      formData.push({ name: 'qr_img_name', value: qrData.qr_img_name }); // Add QR image name to formData
      $.ajax({
        url: '<?php echo base_url(); ?>index.php/wts/System_qr_code/qr_update',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response.status === 'error') {
            dialog_error({
              'header': response.header,
              'body': response.body
            });
          } else if (response.status === 'success') {
            dialog_success({
              'header': response.header,
              'body': response.body
            });
            setInterval(function(){window.location.href = response.returnUrl;}, 3000);
          }
        }
      });
    });
  });

  function dialog_error(options) {
    // Custom function to show error dialog
    alert(options.header + '\n' + options.body);
  }

  function dialog_success(options) {
    // Custom function to show success dialog
    alert(options.header + '\n' + options.body);
  }
</script>
