<?php
    function renderMenu($menus, $parentID = 0, $level = 0) {
    $html = '';

    foreach ($menus as $menu) {
        if ($menu['mn_parent_mn_id'] == $parentID) {
            $mn_st_id = encrypt_id($menu['mn_st_id']);
            $mn_parent_mn_id = encrypt_id($menu['mn_parent_mn_id']);
            $mn_id = encrypt_id($menu['mn_id']);

            $html .= '<li class="list-group-item ' . ($menu['mn_level'] == 0 ? 'list-group-item-warning' : '') . ' menu-Level-' . $menu['mn_level'] . '">';
            $html .= '<div class="float-start">';
            $html .= '<span style="padding-left: ' . ($level * 20) . 'px;">' . ($level <> 0 ? '<i class="bi-arrow-return-right"></i> ' : '') . $menu['mn_name_th'] . '</span>';
            $html .= '<input type="hidden" name="Seq[]" value="' . $mn_id . '"/>';
            $html .= '</div>';
            $html .= '<div class="float-end">';
            $html .= '<span class="float-start me-4"><i class="bi-circle-fill '.($menu['mn_active'] == 1 ? 'text-success' : 'text-danger').'"></i> '.($menu['mn_active'] == 1 ? 'เปิดใช้งาน' : 'ปิดใช้งาน').'</span>';
            $html .= '<button class="me-2 btn btn-success rounded-circle btn-sm" onclick="window.location.href=\''. base_url() .'index.php/ums/System/system_menu_edit/' . $mn_st_id . '/' . $mn_id . '\'"><i class="bi-plus"></i></button>';
            $html .= '<button class="me-2 btn btn-warning rounded-circle btn-sm" onclick="window.location.href=\''. base_url() .'index.php/ums/System/system_menu_edit/' . $mn_st_id . '/' . (!empty($mn_parent_mn_id) ? $mn_parent_mn_id : 0) . '/' . $mn_id . '\'"><i class="bi-pencil-square text-white"></i></button>';

            $count = 0;
            foreach ($menus as $countsub) {
                if ($countsub['mn_parent_mn_id'] == $menu['mn_id']) {
                    $count++;
                }
            }

            $html .= '<button class="me-2 btn btn-danger rounded-circle btn-sm" onclick="deleteMn(' . $count . ',`' . $mn_id . '`);"><i class="bi-trash"></i></button>';
            $html .= '</div>';
            $html .= '</li>';

            $html .= '<ul class="list-group">';
            $html .= renderMenu($menus, $menu['mn_id'], $level + 1);
            $html .= '</ul>';
        }
    }

    return $html;
}
?>

<!-- <link href="<?php  echo base_url(); ?>assets/css/ums/panel.css" rel="stylesheet" type="text/css">				 -->
<script type="text/javascript" src="<?php  echo base_url(); ?>assets/js/ums/Sortable/Sortable.min.js"></script>
<!-- Main Content Wrapper -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-menu-button-wide icon-menu"></i><span>กำหนดเมนูระบบ</span><span class="badge bg-success"><?php echo count($menus); ?></span>
                </button>
            </h2>
            <div class="card-body">
                <!-- <form method="post" action="<?php  echo base_url(); ?>index.php/ums/System/SaveSeq"> -->
                <?php if (count($menus) > 0) { ?>
                    <ul class="list-group">
                        <?php echo renderMenu($menus);  ?>
                    </ul>
                <?php } else {  ?>
                    <div class="text-center">ไม่มีข้อมูลในระบบ</div>
                <?php }  ?>
                <!-- </form> -->
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-secondary float-start me-2" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System'">ย้อนกลับ</button>
        <button type="submit" class="btn btn-success float-start">บันทึก</button>
        <button class="btn btn-success float-end rounded-circle btn-sm" onclick="window.location.href='<?php echo base_url() . 'index.php/ums/System/system_menu_edit/' . $st_id ;?>'"><i class="bi-plus"></i></button>
    </div>
</div>

<script>
    function deleteMn(count, mn_id) {
        if (count > 0) {
            // dialog_error({'header': "ไม่สามารถลบข้อมูลได้!", 'body': "เมนูนี้มีเมนูย่อยไม่สามารถลบได้"});
            Swal.fire({
            title: "ไม่สามารถลบข้อมูลได้!",
            text: "เมนูนี้มีเมนูย่อยไม่สามารถลบได้",
            icon: "error",
            // showCancelButton: true,
            confirmButtonColor: "#198754",
            // cancelButtonColor: "#dc3545",
            confirmButtonText: "ตกลง",
            // cancelButtonText: "ยกเลิก"
            });
        } 
        else {
            Swal.fire({
            title: text_swal_delete_title,
            text: text_swal_delete_text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#dc3545",
            confirmButtonText: text_swal_delete_confirm,
            cancelButtonText: text_swal_delete_cancel
            }).then((result) => {
            if (result.isConfirmed) {
                const url = "<?php echo base_url().'index.php/ums/System/system_menu_delete/'.$st_id.'/'; ?>" + mn_id;
                $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                // data: {
                //   zipcode: 97201
                // },
                success: function(data) {
                    if (data.data.status_response == status_response_success) {
                    dialog_success({'header': text_toast_delete_success_header, 'body': text_toast_delete_success_body}, null, true);
                    } else if (data.data.status_response == status_response_error) {
                    dialog_error({'header':text_toast_delete_error_header, 'body': text_toast_delete_error_body});
                    } 
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    dialog_error({'header':text_toast_delete_error_header, 'body': text_toast_delete_error_body});
                },
                });
            }
            });
        }
    }
</script>