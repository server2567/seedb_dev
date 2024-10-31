<?php
    function renderMenu($menus, $parentID = 0, $level = 0) {
        $html = '';

        $i = 1;
        foreach ($menus as $menu) {
            if ($menu['mn_parent_mn_id'] == $parentID) {
                $element = 'list-group-lv'.$level.'-'.$i;
                $mn_st_id = encrypt_id($menu['mn_st_id']);
                $mn_parent_mn_id = encrypt_id($menu['mn_parent_mn_id']);
                $mn_id = encrypt_id($menu['mn_id']);

                $html .= '<li class="list-group-item ' . (empty($menu['mn_parent_mn_id']) ? 'list-group-item-warning' : '') . ' menu-level-' . $menu['mn_level'] . '">';
                $html .= '<div class="mn-data d-flex">';
                $html .= '<div class="col-7">';
                $html .= '<span style="padding-left: ' . ($level * 20) . 'px;">' . ($level <> 0 ? '<i class="bi-arrow-return-right"></i> ' : '') . $menu['mn_name_th']. '</span>';
                $html .= '<input type="hidden" name="mn_seq[]" value="' . $mn_id . '"/>';
                $html .= '</div>';
                $html .= '<div class="col-5 text-end">';
                $html .= '<span class=" me-4"><i class="bi-circle-fill '.($menu['mn_active'] == 1 ? 'text-success' : 'text-danger').'"></i> '.($menu['mn_active'] == 1 ? 'เปิดใช้งาน' : 'ปิดใช้งาน').'</span>';
                $html .= '<button type="button" class="me-2 btn btn-success rounded-circle btn-sm" onclick="window.location.href=\''. base_url() .'index.php/ums/System/system_menu_edit/' . $mn_st_id . '/' . $mn_id . '\'"><i class="bi-plus"></i></button>';
                $html .= '<button type="button" class="me-2 btn btn-warning rounded-circle btn-sm" onclick="window.location.href=\''. base_url() .'index.php/ums/System/system_menu_edit/' . $mn_st_id . '/' . (!empty($mn_parent_mn_id) ? $mn_parent_mn_id : 0) . '/' . $mn_id . '\'"><i class="bi-pencil-square text-white"></i></button>';

                $count = 0;
                foreach ($menus as $countsub) {
                    if ($countsub['mn_parent_mn_id'] == $menu['mn_id']) {
                        $count++;
                    }
                }

                $html .= '<button type="button" class="me-2 btn btn-danger rounded-circle btn-sm" onclick="deleteMn(' . $count . ',`' . $mn_id . '`);"><i class="bi-trash"></i></button>';
                $html .= '</div>';
                $html .= '</div>';
                
                // next level
                if ($count > 0) {
                    $html .= '<ul class="list-group nested-sortable" id="' . $element . '">';
                    $html .= renderMenu($menus, $menu['mn_id'], $level + 1);
                    $html .= '</ul>';
                }
                $html .= '</li>';
            }
            $i++;
        }

        return $html;
    }
    
    function renderListLevel($menus, $parent_group, $parentID = 0, $level = 0) {
        $js = '';

        $j = 1;
        foreach ($menus as $menu) {
            if ($menu['mn_parent_mn_id'] == $parentID) {
                $element = 'list-group-lv'.$level.'-'.$j;

                $count = 0;
                foreach ($menus as $countsub) {
                    if ($countsub['mn_parent_mn_id'] == $menu['mn_id']) {
                        $count++;
                    }
                }

                // next level then gen Sortable for child
                if ($count > 0) {
                    $js .= 'new Sortable(document.getElementById("'.$element.'"), {
                        animation: 150,
                        ghostClass: "blue-background-class"
                    });
                    ';
                }

                $js .= renderListLevel($menus, $element, $menu['mn_id'], $level + 1);
            }
            $j++;
        }

        return $js;
    }
?>

<style>
    .list-group-item {
        padding: 0;
        border: 0;
    }
    .mn-data {
        padding: var(--bs-list-group-item-padding-y) var(--bs-list-group-item-padding-x) var(--bs-list-group-item-padding-y) var(--bs-list-group-item-padding-x);
    }
    .card-footer {
        padding-bottom: 55px;
    }
    .menu-level-0 .mn-data {
        border: var(--bs-list-group-border-width) solid var(--bs-list-group-border-color);
    }
</style>

<!-- Main Content Wrapper -->
<div class="card">
	<form class="needs-validation" novalidate method="post" action="<?php echo base_url().'index.php/ums/System/system_menu_update_seq/'.$st_id; ?>">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button accordion-button-table" type="button">
                        <i class="bi-menu-button-wide icon-menu"></i><span>กำหนดเมนูระบบ</span><span class="badge bg-success"><?php echo count($menus); ?></span>
                    </button>
                </h2>
                <div class="card-body">
                    <?php if (count($menus) > 0) { ?>
                        <div class="nested">
                            <ul class="list-group nested-sortable" id="list-group-lv0">
                                <?php echo renderMenu($menus);  ?>
                            </ul>
                        </div>
                    <?php } else {  ?>
                        <div class="text-center">ไม่มีข้อมูลในระบบ</div>
                    <?php }  ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-secondary float-start me-2" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System'">ย้อนกลับ</button>
            <button type="submit" class="btn btn-success float-start">บันทึก</button>
            <button class="btn btn-success float-end rounded-circle btn-sm" onclick="window.location.href='<?php echo base_url() . 'index.php/ums/System/system_menu_edit/' . $st_id ;?>'"><i class="bi-plus"></i></button>
        </div>
    </form>
</div>

<script type="text/javascript" src="<?php  echo base_url(); ?>assets/js/ums/Sortable/Sortable.min.js"></script>

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
            let text = text_swal_delete_text;

            const url_check = "<?php echo base_url().'index.php/ums/System/system_menu_check_delete/'; ?>" + mn_id;
            $.ajax({
                url: url_check,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.data.status_response == status_response_success) {
                        if (data.data.is_have) {
                            text = "เมนูนี้มีผู้ใช้กำลังใช้งานอยู่ คุณยืนยันที่จะลบเมนูนี้หรือไม่";
                        }
                    }

                    Swal.fire({
                        title: text_swal_delete_title,
                        text: text,
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
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    dialog_error({'header':text_toast_delete_error_header, 'body': text_toast_delete_error_body});
                },
            });
        }
    }

    document.addEventListener("DOMContentLoaded", function(event) {
        // render Sortables level 0
        var sortable = new Sortable(document.getElementById("list-group-lv0"), {
            group: 'nested',
            animation: 150,
            ghostClass: 'blue-background-class'
        });

        // render Sortables level > 0
        <?php echo renderListLevel($menus, "list-group-lv0");  ?>
    });
</script>