<style>
    .nav-tabs {
        border-top-left-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
        border-top-right-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
    }
    .card-menu {
        border: 2px solid #ebeef4 !important;
    }
    /* .card img {
        height: 150px;
        width: 150px;
    } */
    .card i {
        font-size: 60px;
    }
    .nav-link {
        font-weight: 700;
    }
    .card-menu:hover, .card-menu:hover > h5 {
        color: #717ff5;
        text-decoration: none;
        transition: all 0.3s;
    }
    /* .card-menu h5
    {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } */
</style>

<?php 
    $lv0 = array();

    foreach ($session_menus_sidebar as $mn0)  {
        if($mn0['mn_level'] == 0 && is_null_value($mn0['mn_parent_mn_id'])) { 
        $lv0[] = $mn0;
        }
    }

    function render_sub_menu($menus, $parent_id, $lv) {
        $html = '';
        $parent_id = decrypt_id($parent_id);

        $i = 1;
        foreach ($menus as $menu) {
            if ($menu['mn_parent_mn_id'] == $parent_id) {
                $html .= '<div class="col-md-2">';
                $html .= '<a href="'.base_url().'index.php/'.$menu['mn_url'].'">';
                $html .= '<div class="card card-menu p-2 d-flex align-items-center">';
                $html .= '<i class="'.$menu['mn_icon'].'"></i>';
                $html .= '<h5 class="card-title text-center">'.$menu['mn_name_th'].'</h5>';
                $html .= '</div>';
                $html .= '</a>';
                $html .= '</div>';
                
                // $count = 0;
                // foreach ($menus as $countsub) {
                //     if ($countsub['mn_parent_mn_id'] == decrypt_id($menu['mn_id'])) {
                //         $count++;
                //     }
                // }
                
                // // next level
                // if ($count > 0) {
                //    $html .= render_sub_menu($session_menus_sidebar, $menu['mn_id'], $lv+1);
                // }
            }
            $i++;
        }
        return $html;
    }
?>

<div class="card">
    <ul class="nav nav-tabs nav-tabs-bordered bg-primary-light" id="borderedTab" role="tablist">
        <?php 
            $i = 1;
            foreach ($lv0 as $mn0) {  
            $count_next_childs = 0;

            // find next child (nect level)
            foreach ($session_menus_sidebar as $mn1) {
                if($mn1['mn_level'] == 1 && $mn1['mn_parent_mn_id'] == decrypt_id($mn0['mn_id'])) { 
                    $count_next_childs++;
                }
            }
            ?>
            <li class="nav-item" role="presentation">
                <!-- case no have childs -->
                <?php if($count_next_childs == 0) { ?>
                    <a class="nav-link <?php echo $i === 1 ? "active" : ""; ?>" href="<?php echo base_url().'index.php/'.$mn0['mn_url']; ?>">
                        <?php echo $mn0['mn_name_th']; ?>
                    </a>
                <!-- case have childs -->
                <?php } else { ?>
                    <button class="nav-link <?php echo $i === 1 ? "active" : ""; ?>" data-bs-toggle="tab" data-bs-target="<?php echo "#tab-".$i?>" type="button" role="tab" aria-controls="tab-<?php echo $i?>" aria-selected="<?php echo $i === 1 ? "true" : "false"; ?>"><?php echo $mn0['mn_name_th']?></button>
                <?php } ?>
            </li>
        <?php $i++; } ?>
    </ul>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <?php 
                $i = 1;
                foreach ($lv0 as $mn0) {  
                $count_next_childs = 0;

                // find next child (nect level)
                foreach ($session_menus_sidebar as $mn1) {
                    if($mn1['mn_level'] == 1 && $mn1['mn_parent_mn_id'] == decrypt_id($mn0['mn_id'])) { 
                        $count_next_childs++;
                    }
                }
                ?>
                <div class="tab-pane fade <?php echo $i === 1 ? "show active" : ""; ?>" id="tab-<?php echo $i?>">
                    <div class="row">
                        <?php echo render_sub_menu($session_menus_sidebar, $mn0['mn_id'], 1);  ?>
                    </div>
                </div>
            <?php $i++; } ?>
        </div>
    </div>
</div>