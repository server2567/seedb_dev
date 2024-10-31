<?php
    $url_form = base_url()."index.php/ums/System_group/system_group_permission_update/".$gp_id;
    $url_back = base_url()."index.php/ums/System_group";
    
    if(isset($us_id) && !empty($us_id)) {
        $url_form = base_url()."index.php/ums/User/user_usergroup_update/".$us_id;
        $url_back = base_url()."index.php/ums/User/user_usergroup/".$us_id;
    }

    function renderMenu($menus, $group_permissions, $gp_id, $parentID = 0, $level = 0) {
    $html = '';
    
    foreach ($menus as $menu) {
        if ($menu['mn_parent_mn_id'] == $parentID) {
            $mn_id = encrypt_id($menu['mn_id']);

            // $count = 0;
            // foreach ($menus as $countsub) {
            //     if ($countsub['mn_parent_mn_id'] == $menu['mn_id']) {
            //         $count++;
            //     }
            // }

            $padding_left = "padding-left: ".(($menu['mn_level']*20)+20)."px;";
            $font_bold = $level == 0 ? "font-weight: bold;" : "";
            $is_checked = "";
            foreach ($group_permissions as $gpn) {
                if ($gpn['gpn_gp_id'] == decrypt_id($gp_id) && $gpn['gpn_mn_id'] == $menu['mn_id'] && $gpn['gpn_active'] == 1)
                $is_checked = "checked";
            }

            $html .= '<tr>';
            $html .= '<td class="text-start" style="'.$padding_left.' '.$font_bold.'"; ?>'.$menu['mn_name_th'].'</td>';
            // $html .= '<td class="text-center"><input class="form-check-input" type="checkbox" name="is_active[]" id="is_active-'.$mn_id.'" '.($is_checked).'></td>';
            $html .= '<td class="text-center"><input class="form-check-input" type="checkbox" name="is_active-'.$mn_id.'" '.($is_checked).'></td>';
            $html .= '<input type="hidden" name="checkbox_id[]" value="is_active-'.$mn_id.'">';
            $html .= '</tr>';

            $html .= renderMenu($menus, $group_permissions, $gp_id, $menu['mn_id'], $level + 1);
        }
    }

    return $html;
}
?>

<style>
    /* .table th, .table td:not(:nth-child(2)) {
        text-align: center !important;
    } */
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>กำหนดสิทธิ์ของกลุ่มงาน <i class="bi-chevron-double-right"></i> <?php echo $group['st_name_th']." (สิทธิ์ ".$group['gp_name_th'].")"; ?></span><span class="badge bg-success"><?php echo count($menus); ?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo $url_form; ?>">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="table-dark">
                                        <!-- <th scope="col">#</th> -->
                                        <th class="text-start">เมนู</th>
                                        <th class="text-center">เปิดการแสดงผล</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (count($menus) > 0) { ?>
                                        <?php echo renderMenu($menus, $group_permissions, $gp_id);  ?>
                                <?php } else {  ?>
                                    <tr>
                                        <td class="text-center" colspan="3">ไม่มีข้อมูลในระบบ</td>
                                    </tr>
                                <?php }  ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start me-2" onclick="window.location.href='<?php echo $url_back; ?>'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>