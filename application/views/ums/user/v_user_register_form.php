<style>
    .password-toggle {
        cursor: pointer;
    }
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>แก้ไขข้อมูลผู้ลงทะเบียน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/User_register/update">
                        <div class="col-md-6">
                            <label for="RgFirstName" class="form-label required">ชื่อ</label>
                            <input type="text" class="form-control" name="RgFirstName" id="RgFirstName" placeholder="ชื่อ" value="<?php echo !empty($edit) ? $edit['RgFirstName'] : "ประชาชน" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="RgLastName" class="form-label required">นามสกุล</label>
                            <input type="text" class="form-control" name="RgLastName" id="RgLastName" placeholder="นามสกุล" value="<?php echo !empty($edit) ? $edit['RgLastName'] : "ลงทะเบียน" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="RgGender" class="form-label required">เพศ</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกเพศ --" name="RgGender" id="RgGender" required>
                                <option value=""></option>
                                <option value="1">ชาย</option>
                                <option value="2" selected>หญิง</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="RgBirthDate" class="form-label required">วันเกิด</label>
                            <input type="date" class="form-control" name="RgBirthDate" id="RgBirthDate" value="<?php echo !empty($edit) ? $edit['RgBirthDate'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="RgCareer" class="form-label required">อาชีพ</label>
                            <input type="text" class="form-control" name="RgCareer" id="RgCareer" placeholder="อาชีพ" value="<?php echo !empty($edit) ? $edit['RgCareer'] : "รับจ้าง" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StNameT" class="form-label required">Email</label>
                            <input type="email" class="form-control" name="StNameT" id="StNameT" placeholder="Email" value="<?php echo !empty($edit) ? $edit['StNameT'] : "register@gmail.com" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="RgUsername" class="form-label required">Username</label>
                            <input type="text" class="form-control" name="RgUsername" id="RgUsername" placeholder="Username" value="<?php echo !empty($edit) ? $edit['RgUsername'] : "register" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="RgPassword" class="form-label required">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="RgPassword" id="RgPassword" placeholder="Password" value="register" required>
                                <span class="input-group-text password-toggle" onclick="togglePassword(this)"><i class="bi-eye-slash"></i></span>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <label for="FileMenu" class="form-label required">กลุ่มการมองเห็น</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกกลุ่มการมองเห็น --" name="FileMenu" id="FileMenu" required>
                                <option value="">-- กรุณาเลือกกลุ่มการมองเห็น --</option>
                                <option value="2">ประชาชน</option>
                                <option value="3">บุคลากรของโรงพยาบาล</option>
                                <option value="4">กลุ่มตำแหน่งจักษุแพทย์</option>
                            </select>
                        </div> -->
                        <div class="col-md-6">
                            <label for="StActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="StActive" id="StActive" checked>
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/User_register'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(event) {
        var passwordInput = event.previousElementSibling;
        if (passwordInput.type == "password") {
            passwordInput.type = "text";
            if (event.children.length > 0) {
                Array.from(event.children).forEach(i => {
                    if (i.tagName.toLowerCase() === 'i') {
                        i.classList.remove('bi-eye-slash')
                        i.classList.add('bi-eye');
                    }
                });
            }
        }
        else { 
            passwordInput.type = "password";
            if (event.children.length > 0) {
                Array.from(event.children).forEach(i => {
                    if (i.tagName.toLowerCase() === 'i') {
                        i.classList.remove('bi-eye')
                        i.classList.add('bi-eye-slash');
                    }
                });
            }
        }
    }
</script>