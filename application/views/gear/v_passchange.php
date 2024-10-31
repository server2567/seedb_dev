<style>
.topbar {
    position: absolute;
    top: 60px;
    background: #006897;
    width: 100.65%;
    font-size: 16px;
    left: 0;
    z-index: 1;
    line-height: 40px;
}
ol.breadcrumb {
    display: none;
}
#footer {
    position: absolute;
    bottom: 0;
    width: 95vw;
}
</style>
<div class="row topbar">
  <div class="col-md-12 nav_topbar">
      &nbsp;<i class="bi bi-caret-right text-warning" style="padding-left: 80px;"></i>&nbsp;
      &nbsp;<i class="bi bi-person-bounding-box text-white"></i>&nbsp;
    <span class='text-white font-16'>ตรวจสอบ Username และ Password</span>
  </div>
</div>
<div class="row mt-5 mb-5">
	<div class="col-md-12">
		<div class="panel panel-teal">
			<div class="panel-body">
				<div class="alert alert-dismissable alert-success font-20 text-center">
					เนื่องจาก Password ของท่านเหมือนกับ Username กรุณาเปลี่ยน Password ของท่านเพื่อความปลอดภัย จะกลับไปที่หน้าหลักใน 2 วินาที
					<?php
						header( "refresh: 5; ". base_url() );
					?>
				</div>
			</div>
		</div>
	</div>	
</div>