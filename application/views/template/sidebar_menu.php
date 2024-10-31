<?php 
  $lv0 = array();

  foreach ($session_menus_sidebar as $mn0)  {
    if($mn0['mn_level'] == 0 && is_null_value($mn0['mn_parent_mn_id'])) { 
      $lv0[] = $mn0;
    }
  }

  function is_null_value($value){
    if (isset($value) && !empty($value) && $value !== null && $value !== '') return false;
    else return true;
  }
?>

<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item" style="background-color: #cfe2ff;">
      <!-- case no have childs -->
      <a class="nav-link collapsed" href="<?php echo site_url() . "/" . $this->config->item('pd_dir').'Home'; ?>" data-menu="00" style="background-color: #cfe2ff;">
        <i class="font-20 bi-house-door" style="color: #012970;"></i><span class="menu-lv0">หน้าหลัก</span>
      </a>
      <!-- case menu-head -->
      <ul id="components-0" class="nav-content collapse menu-head" data-bs-parent="#sidebar-nav">
        <li>
          <a class="nav-link collapsed" data-menu="0">
            <b>หน้าหลัก</b>
          </a>
        </li>
      </ul>
      <!-- sidebar หน้าหลัก -->
    </li>
  
    <?php foreach ($lv0 as $mn0) {  
      $count_next_childs = 0;

    // find next child (nect level)
      foreach ($session_menus_sidebar as $mn1) {
        if($mn1['mn_level'] == 1 && $mn1['mn_parent_mn_id'] == $mn0['mn_id']) { 
          $count_next_childs++;
        }
      }
    ?>
    <li class="nav-item">
      <!-- case no have childs -->
      <?php if($count_next_childs == 0) { ?>
      <a class="nav-link collapsed" href="<?php echo base_url().'index.php/ums/UMS_Controller/insert_log_menu/'.$mn0['mn_id']; ?>" data-menu="<?php echo $mn0['mn_seq']; ?>">
        <i class="<?php echo !is_null_value($mn0['mn_icon']) ? $mn0['mn_icon'] : 'bi-circle'; ?>"></i><span class="menu-lv0"><?php echo $mn0['mn_name_th']; ?></span>
      </a>
      <!-- case menu-head -->
      <ul id="components-<?php echo $mn0['mn_seq']; ?>" class="nav-content collapse menu-head d-none" data-bs-parent="#sidebar-nav">
        <li>
          <a class="nav-link collapsed" data-menu="<?php echo $mn0['mn_seq']; ?>">
            <b><?php echo $mn0['mn_name_th']; ?></b>
          </a>
        </li>
      </ul>
      <!-- case have childs -->
      <?php } else { ?>
      <a class="nav-link collapsed" data-bs-target="#components-<?php echo $mn0['mn_seq']; ?>" data-bs-toggle="collapse" data-menu="<?php echo $mn0['mn_seq']; ?>">
        <i class="<?php echo !is_null_value($mn0['mn_icon']) ? $mn0['mn_icon'] : 'bi-circle'; ?>"></i><span class="menu-lv0"><?php echo $mn0['mn_name_th']; ?></span>
        <i class="bi-chevron-down ms-auto menu-lv0"></i>
      </a>
      <ul id="components-<?php echo $mn0['mn_seq']; ?>" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <!-- case menu-head -->
        <li class="menu-head d-none">
          <a class="nav-link collapsed" data-menu="<?php echo $mn0['mn_seq']; ?>">
            <b><?php echo $mn0['mn_name_th']; ?></b>
          </a>
        </li>
        <?php
          $data['session_menus_sidebar'] = $session_menus_sidebar;
          $data['parent_level'] = 0;
          $data['parent_mn_id'] = $mn0['mn_id'];
          $this->load->view('template/sidebar_submenu', $data); ?>
      </ul>
      <?php } ?>
    </li>
    <?php } ?>
  </ul>
</aside><!-- End Sidebar-->