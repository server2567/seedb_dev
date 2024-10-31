<h1 class="h3 mb-0">เปลี่ยนรหัสผ่าน</h1>
<div class="card-body pt-0 px-0">
  <div class="row g-3">
    <div class="col-12">
      <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center p-0 pt-3"></div>
      <form>
      <div class="card-body p-0 pt-5">
        <div class="col-md-9 mb-5 mx-auto">
          <label class="form-label">รหัสผ่านเดิม <span class=" text-danger">*</span></label>
          <div class="input-group-md">
            <input type="password" name="old_password" id="old_password" class="form-control" value="" >
            <input type="hidden" name="pt_id" id='pt_id' value="<?php echo $user->pt_id; ?>" />
          </div>
        </div>
        <div class="col-md-10 mb-5 mx-auto">
        <hr>
        </div>
        <div class="col-md-9 mb-3 mt-5 mx-auto">
          <label class="form-label">รหัสผ่านใหม่ <span class=" text-danger">*</span></label>
          <div class="input-group-md">
            <input type="password" name="new_password" id="new_password" class="form-control mb-0" value="" >
            <small>รหัสผ่านใหม่ต้องมีความยาวมากกว่า 8 ตัวอักษร</small>
          </div>
        </div>
        <div class="col-md-9 mx-auto">
          <label class="form-label">ยืนยันรหัสผ่านใหม่ <span class=" text-danger">*</span></label>
          <div class="input-group-md">
            <input type="password" name="confirm_password" id="confirm_password" class="form-control mb-0" value="" >
            <small class="">รหัสผ่านใหม่ต้องมีความยาวมากกว่า 8 ตัวอักษร</small>
          </div>
        </div>
        <div class="col-md-9 mt-5 mx-auto d-flex justify-content-end">
          <button type="button" class="btn btn-success" onclick="changePassword()">เปลี่ยนรหัสผ่าน</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
function changePassword() {
  var old_password = document.getElementById('old_password').value;
  var new_password = document.getElementById('new_password').value;
  var confirm_password = document.getElementById('confirm_password').value;
  var pt_id = document.getElementById('pt_id').value;

  if (new_password.length < 8) {
    Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด',
      text: 'รหัสผ่านใหม่ต้องมีความยาวมากกว่า 8 ตัวอักษร'
    });
    return;
  }

  if (new_password !== confirm_password) {
    Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด',
      text: 'รหัสผ่านใหม่และการยืนยันรหัสผ่านไม่ตรงกัน'
    });
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open('POST', '<?php echo site_url("ums/frontend/Register_login/change_password_new"); ?>', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.success) {
        Swal.fire({
          icon: 'success',
          title: 'สำเร็จ',
          text: 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
          showConfirmButton: false,
          timer: 1000
        }).then(() => {
          window.location.href = '<?php echo site_url("ums/frontend/Dashboard_home_patient"); ?>';
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'ข้อผิดพลาด',
          text: response.message
        });
      }
    }
  };
  xhr.send('old_password=' + encodeURIComponent(old_password) + '&new_password=' + encodeURIComponent(new_password) + '&pt_id=' + encodeURIComponent(pt_id));
}
</script>