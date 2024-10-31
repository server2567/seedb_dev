<style>
  .next-child {
    margin-right: 8px !important;
    font-size: 10px !important;
}
@media (min-width: 1200px) {
    .toggle-sidebar .sidebar ul.nav-content {
        padding-right: 0px;
        
    }
}
.sidebar-nav .nav-content a{
  font-size: 15px;
}
</style>

<?php 
  $this_level = $parent_level + 1;
  $lv0 = array();
?>
<?php //echo $session_menus_sidebar[0]['mn_name_th']; ?>
<?php foreach ($session_menus_sidebar as $key => $mn) { 
  if($mn['mn_level'] == ($this_level) && $mn['mn_parent_mn_id'] == $parent_mn_id) { 
    $count_next_childs = 0;
    // find next child (nect level)
    foreach ($session_menus_sidebar as $key2 => $next_child) {
      if($next_child['mn_level'] == ($this_level+1) && $next_child['mn_parent_mn_id'] == $mn['mn_id']) { 
        $count_next_childs++;
      }
    }
    ?>

    <li>
      <!-- case have childs -->
      <?php if($count_next_childs == 0) { ?>
      <a href="<?php echo base_url().'index.php/ums/UMS_Controller/insert_log_menu/'.$mn['mn_id']; ?>" data-menu="<?php echo $mn['mn_seq']; ?>" style="padding-left: <?php echo $this_level * 15; ?>px;">
        <i class="bi-circle"></i><span><?php echo $mn['mn_name_th']; ?>&emsp;</span>
      </a>
      <!-- case no have childs -->
      <?php } else { ?>
        <div class="sub-menu-head">
          <a class="nav-link collapsed" data-bs-target="#components-<?php echo $mn['mn_seq']; ?>" data-bs-toggle="collapse" data-menu="<?php echo $mn['mn_seq']; ?>" style="padding-left: <?php echo $this_level * 15; ?>px;">
            <i class="bi-circle"></i><span><?php echo $mn['mn_name_th']; ?></span>
            <?php if($count_next_childs>0) { ?>
            <i class="bi-chevron-down ms-auto next-child"></i>
            <?php } ?>
          </a>
        </div>
      <ul id="components-<?php echo $mn['mn_seq']; ?>" class="nav-content collapse" data-bs-parent="#sidebar-nav-<?php echo $mn['mn_id']; ?>">
        <?php
          $data['session_menus_sidebar'] = $session_menus_sidebar;
          $data['parent_level'] = $this_level;
          $data['parent_mn_id'] = $mn['mn_id'];
          $this->load->view('template/sidebar_submenu', $data); ?>
      </ul>
      <?php } ?>
    </li>
<?php } } ?>