


<?php
  function set_url($url, $id) {
    if ($url == '#' || empty($url))
      return base_url()."index.php/ums/UMS_Controller/submenu/".$id;
    else
      return base_url()."index.php/".$url;
  }
?>

<main id="main" class="main" style="margin-top: 50px;">
  <div class="pagetitle">
    <nav>
      <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="<?php echo base_url("index.php/".$this->config->item('pd_dir')."Personal_dashboard_Controller"); ?>">
      <span style="position: absolute; padding-left: 9.5px; color: #607D8B; padding-top: 3px; font-size: 8px;">PD</span>
      <i class="bi bi-house-door fs-3" style="margin-top: -12px; padding-right: 20px; position: absolute;"></i></a></li>
      
      <?php if (!empty($session_st_home_url) && !empty($session_st_name_abbr_en)) { ?>
      <li class="breadcrumb-item" style="padding-left: 35px;"><a href="<?php echo base_url().'index.php/'.$session_st_home_url; ?>"><?php echo $session_st_name_abbr_en ?></a></li>
      <?php } ?>

      <?php if (!empty($session_menus_active) && count($session_menus_active) > 0) {
        $i = 0;
        foreach( $session_menus_active as $mn ) { ?>
        <li class="breadcrumb-item active">
              <a href="<?php echo set_url($mn['mn_url'], $mn['mn_id']); ?>">
                <?php echo $mn['mn_name_th']; ?>
              </a>
              
            <!-- <?php if ($i != count($session_menus_active)-1) { ?>
              <a href="<?php echo set_url($mn['mn_url'], $mn['mn_id']); ?>">
                <?php echo $mn['mn_name_th']; ?>
              </a>
            <?php } else { ?>
              <?php echo $mn['mn_name_th']; ?>
            <?php } ?> -->
        </li>
      <?php 
      $i++;
      } } ?>
      </ol>
    </nav>
  </div>

  <!--start modal-->
  <div class="modal fade" id="preview_file_modal" style="width:100%; height:100%;" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
				        <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
            <div class="modal-body">
              <iframe id="modal-iframe" style="width:100%; height: 70vh;" frameborder="0"></iframe>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <a href="#" class="btn btn-primary download_file_btn_modal" target="_blank" data-original-title="คลิกปุ่มเพื่อดาวน์โหลดไฟล์"> ดาวน์โหลดไฟล์</a>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
          </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->