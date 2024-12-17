<style>
  @media (max-width: 500px) {
    body {
    zoom:70% !important;
  }
}
</style>
<div class="row topbar toggle-sidebar-btn">
  <div class="col-md-12 nav_topbar">
    <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      &nbsp;<i class="bi bi-box-arrow-in-right text-white"></i>&nbsp;
      <span class='text-white font-16'>ล็อกอินเข้าสู่ระบบ</span>
  </div>
</div>
<div class="pattern-square"></div>
<section class="py-5 py-lg-4">
  <div class="container">
      <div class="row">
        <div class="col-xl-6 offset-xl-3 col-md-12 col-12">
            <div class="text-center">
              <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="brand" class="mb-3 ms-3" style="width:140px">
              <h1 class="mb-1">ยินดีต้อนรับ</h1>
              <p class="mb-0 fs-5">
                  ถ้าท่านยังไม่เคยลงทะเบียน สามารถลงทะเบียนได้ที่นี้
                  <a href="<?php echo site_url(); ?>/Gear/frontend_register" class="text-primary fs-5">ลงทะเบียน</a>
              </p>
            </div>
        </div>
      </div>
  </div>
</section>
<section>
  <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8 col-12">
            <div class="card shadow-sm mb-6">
              <div class="card-body">
                  <form class="mb-6 mobile">
                    <div class="mb-3 input-group-lg">
                        <label for="signinInput" class="form-label">
                          เลขบัตรประจำตัวประชาชน / พาสปอร์ต / เลขบัตรต่างด้าว
                          <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control mb-0" name="Username" id="signinInput" placeholder="1209700000000 / ME02154 / 0209700000000">
                    </div>
                    <div class="mb-3 mt-4">
                        <label for="formSignUpPassword" class="form-label">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                        <div class="password-field position-relative input-group-lg">
                          <input type="text" class="form-control mb-0 fakePassword" name="Password" id="formSignUpPassword">
                          <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                        </div>
                    </div>
                    <div class="mb-4 d-flex align-items-center justify-content-between mt-5">
                        <div class="form-check">
                        </div>
                        <div class="form-check"><a href="<?php echo site_url();?>/gear/frontend_forget" class="text-primary">ลืมรหัสผ่าน</a></div>
                    </div>
                    <div class="d-grid mb-5">
                        <button type="button" class="btn btn-primary btn-lg" onclick="submit_data()">เข้าสู่ระบบ</button>
                    </div>
                    <p class="mb-1 text-center fs-5">ถ้าท่านยังไม่เคยลงทะเบียน สามารถลงทะเบียนได้ที่นี้</p>
                    <!-- <div class="d-grid mb-5">
                      <a href="<?php echo site_url(); ?>/Gear/frontend_register" class="btn btn-success btn-lg">ลงทะเบียน</a>
                    </div> -->
                    <!-- <div class="d-grid mb-5">
                      <a href="javascript:void(0);" onclick="access_frontend_register_page()" class="btn btn-success btn-lg">ลงทะเบียน</a>
                  </div> -->
                  </form> 
              </div>
            </div>
        </div>
      </div>
  </div>
</section>
<script charset="utf-8" src="https://static.line-scdn.net/liff/edge/versions/2.22.3/sdk.js"></script>
<style>
  .swal2-actions{
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    align-items: flex-end;
  }
</style>
<script>
  main();

  async function main() {
		await liff.init({
				liffId: '<?php echo $this->config->item('login_liff_id'); ?>'
		}, () => {
				if (!liff.isLoggedIn()) {
					//ถ้าไม่ Login ผ่าน LINE ต้อง Login
					liff.login();
				}
				// else{
				// 	console.log(liff.getOS());
				// 	console.log(liff.getLanguage());
				// 	console.log(liff.getVersion());
				// 	console.log(liff.getLineVersion());
				// 	console.log(liff.getContext());
				// 	console.log(liff.isInClient());
					
				// }
		}, err => console.error(err.code, error.message));
	} //main

  /*
	* submit_data 
	* input : username, password
	* output : ส่งข้อความหลังล็อคอินสำเร็จ ให้ user
	* author: Tanadon
	* Create Date : 2024-07-14
	*/
	async function submit_data() {
    let Username = $("input[name='Username']").val();
    let Password = $("input[name='Password']").val();
    let isValid = true;

    if (Username === '' || Password === '') {
        isValid = false;
    }

    if (isValid) {
        // Get LINE profile details
        let line_user_id;
        let line_user_name;
        await liff.getProfile().then(profile => {
            line_user_id = profile.userId;
            line_user_name = profile.displayName;
        }).catch(err => console.error(err));

        $.ajax({
            type: "post",
            url: "<?php echo site_url();?>/line/Frontend/checklogin",
            data: {
                'Username': Username,
                'Password': Password
            },
            dataType: "JSON",
            success: function(data) {
                if (data['is_exist'] === true && data['error'] === null) {
                    // Successful login
                    $.ajax({
                        type: "post",
                        url: "<?php echo site_url();?>/line/Frontend/login",
                        data: {
                            'line_user_id': line_user_id,
                            'Username': Username,
                            'Password': Password
                        },
                        dataType: "JSON",
                        success: function(loginData) {
                            if (loginData['status_line'] === "Y") {
                                liff.closeWindow();
                            }
                        }
                    });
                } else {
                    // Handle different errors based on the returned error and message
                    Swal.fire({
                        icon: 'error',
                        title: data['message'],
                        text: data['error'],
                        confirmButtonText: 'ยืนยัน',
                        customClass: {
                            confirmButton: 'btn btn-primary btn-lg',
                        },
                        buttonsStyling: false
                    });
                }
            }
        });
    }
}

function access_frontend_register_page(){
  window.location.href = "<?php echo site_url(); ?>/line/Frontend/frontend_register";
}

</script>
<script src="<?php echo base_url(); ?>assets/vendor/password/password.js"></script>