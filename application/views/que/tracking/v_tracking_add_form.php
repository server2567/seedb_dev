<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>เพิ่มชนิดเลขติดตาม</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Tracking/add">   <!-- id="validate-form" data-parsley-validate   -->
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="StNameT" class="form-label required">ชนิดเลขติดตาม</label>
                                <input type="text" class="form-control" name="type_name" id="type_name" placeholder="ระบุชื่อชนิดเลขติดตาม" value="" required>
                            </div>
                            <div class="col-md-6">
                                <label for="type_code" class="form-label required">ประเภทเลขติดตาม</label>
                                <select class="form-control" name="type_code" id="type_code"> 
                                    <option value="none" disabled selected>--- เลือกประเภท ---</option>
                                    <option value="fx">Fix value</option>
                                    <option value="rn">Running number</option>
                                    <option value="rd">Random value</option>
                                    <option value="yr">Year value</option>
                                </select>
                            </div>
                        </div>
                        
                        <div id="dynamic-content" class="col-md-12 mt-2" name="dynamic_content"></div>
                       
                        <div class="col-md-6">
                            <label for="StActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="type_active" id="type_active" checked>
                                <label for="type_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/que/Tracking'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function(){
    $('#type_code').change(function(){
      var selectedValue = $(this).val();
      var dynamicContent = '';

      if (selectedValue == 'fx') {
        dynamicContent = '' ;
      } else if (selectedValue == 'rn') {
        dynamicContent = '<label for="running">กำหนดตัวอักษรเริ่มต้น</label><input required type="text" class="form-control" name="running" id="running" placeholder="ระบุตัวอักษรเริ่มต้น เช่น 1 , a , A , ก "><label for="running">กำหนดตัวอักษรที่ต้องการ</label><input required type="text" class="form-control" name="running_format" id="running_format" placeholder="ระบุชุดตัวอักษร เช่น 0-9 , a-z , A-Z , ก-ฮ">';
      } else if (selectedValue == 'rd') {
        dynamicContent = '';
      } else if (selectedValue == 'yr') {
        dynamicContent = '<label for="yearValue">Year Value Format</label><select required class="form-control" name="yearValue" id="yearValue"><option value="" disabled selected>--- เลือกประเภท ---</option><option value="1"> ปีปฏิทิน </option> <option value="2"> ปีงบประมาณ </option> </select>';
      }

      $('#dynamic-content').html(dynamicContent);
    });
  });
</script>
