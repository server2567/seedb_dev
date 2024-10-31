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
                          <select class="form-select select2" name="qr_stde_id" id="qr_stde_id" data-placeholder="-- กรุณาเลือกแผนกการรักษา --" disabled>
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
                                <div>
                                <img id="qr_img" src="<?php echo $qr_code[0]['qr_link'] ?>" style="width: 230px;" />
                                </div>
                                  <!-- <input type="hidden" class="form-control" name="qr_img_name" id="qr_img_name" value="QR-Code-<?php echo !empty($qr_code[0]['qr_id']) ? $qr_code[0]['qr_rdp_name'] : '' ?>.jng"> -->
                        </div>
                        <div class="col-md-12">
                          <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/wts/System_qr_code'">ย้อนกลับ</button>
                          <button type="button" class="btn btn-primary float-end" id="qr_download">ดาวน์โหลด QR-Code</button>
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
quill.enable(false);

quill.setContents(qr_deatile);

document.addEventListener('DOMContentLoaded', function() {
  $('#qr_download').on('click', function() {
    // Fetch the image URL from the img element
    const qr_img_url = $('#qr_img').attr('src');
    
    // Get the image name from PHP variable
    const qr_img_name = <?php echo json_encode($qr_code[0]['qr_img_name']); ?>;
    
    // Create a temporary anchor element to trigger the download
    const a = document.createElement("a");
    a.href = qr_img_url;
    a.download = qr_img_name;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
