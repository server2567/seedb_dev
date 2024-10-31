<style>
    .iconslist {
        grid-template-columns: repeat(auto-fit, minmax(133px, 1fr)) !important;
    }
    .iconslist i {
        cursor: pointer;
    }
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i onclick="chooseIcon(this);" class="bi-window-dock icon-menu"></i><span><?php echo !empty($mn_id) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลเมนู</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url()."index.php/ums/System/"; ?><?php echo !empty($mn_id) ? "system_menu_update/".$mn_id : "system_menu_insert"; ?>">
                        <input type="hidden" name="mn_st_id" value="<?php echo !empty($mn_st_id) ? $mn_st_id : ''; ?>"/>
                        <input type="hidden" name="mn_parent_mn_id" value="<?php echo !empty($mn_parent_mn_id) ? $mn_parent_mn_id : ''; ?>"/>
                        <input type="hidden" name="mn_seq" value="<?php echo !empty($edit) ? $edit['mn_seq'] : ''; ?>"/>
                        <input type="hidden" name="mn_level" value="<?php echo !empty($edit) ? $edit['mn_level'] : ''; ?>"/>
                        <input type="hidden" name="mn_create_user" value="<?php echo !empty($edit) ? $edit['mn_create_user'] : ''; ?>"/>
                        <input type="hidden" name="mn_update_user" value="<?php echo !empty($edit) ? $edit['mn_update_user'] : ''; ?>"/>
                        <input type="hidden" name="mn_seq" value="<?php echo !empty($edit) ? $edit['mn_seq'] : "0" ;?>">
                        <div class="col-md-6">
                            <label for="mn_name_th" class="form-label required">ชื่อเมนู(ท)</label>
                            <input type="text" class="form-control" name="mn_name_th" id="mn_name_th" placeholder="ชื่อเมนูภาษาไทย" value="<?php echo !empty($edit) ? $edit['mn_name_th'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mn_name_en" class="form-label">ชื่อเมนู(E)</label>
                            <input type="text" class="form-control" name="mn_name_en" id="mn_name_en" placeholder="ชื่อเมนูภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['mn_name_en'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="mn_detail" class="form-label">คำอธิบาย</label>
                            <input type="text" class="form-control" name="mn_detail" id="mn_detail" placeholder="คำอธิบายเมนู" value="<?php echo !empty($edit) ? $edit['mn_detail'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="mn_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mn_active" id="mn_active" <?php echo !empty($edit) && $edit['mn_active'] == 1 ? "checked" : "" ;?>>
                                <label for="mn_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="mn_url" class="form-label required">URL</label>
                            <input type="text" class="form-control" name="mn_url" id="mn_url" placeholder="URL" value="<?php echo !empty($edit) ? $edit['mn_url'] : "" ;?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="mn_icon" class="form-label required">ไอคอนของเมนู</label>
                            <input type="text" class="form-control" name="mn_icon" id="mn_icon" placeholder="ไอคอนของเมนู" data-bs-toggle="modal" data-bs-target="#iconsModal" value="<?php echo !empty($edit) ? $edit['mn_icon'] : "" ;?>" required>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System/system_menu/<?php echo $mn_st_id; ?>'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="iconsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เลือกไอคอนของเมนู</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="col-md-4 float-end">
                        <input type="text" class="form-control" name="IconSearch" id="IconSearch" placeholder="ค้นหา...">
                    </div>
                </div>
                <div class="col-md-12 iconslist">
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-alarm-fill"></i>
                    <div class="label">alarm-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-alarm"></i>
                    <div class="label">alarm</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-align-bottom"></i>
                    <div class="label">align-bottom</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-align-center"></i>
                    <div class="label">align-center</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-align-end"></i>
                    <div class="label">align-end</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-align-middle"></i>
                    <div class="label">align-middle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-align-start"></i>
                    <div class="label">align-start</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-align-top"></i>
                    <div class="label">align-top</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-alt"></i>
                    <div class="label">alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-app-indicator"></i>
                    <div class="label">app-indicator</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-app"></i>
                    <div class="label">app</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-archive-fill"></i>
                    <div class="label">archive-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-archive"></i>
                    <div class="label">archive</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-90deg-down"></i>
                    <div class="label">arrow-90deg-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-90deg-left"></i>
                    <div class="label">arrow-90deg-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-90deg-right"></i>
                    <div class="label">arrow-90deg-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-90deg-up"></i>
                    <div class="label">arrow-90deg-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-bar-down"></i>
                    <div class="label">arrow-bar-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-bar-left"></i>
                    <div class="label">arrow-bar-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-bar-right"></i>
                    <div class="label">arrow-bar-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-bar-up"></i>
                    <div class="label">arrow-bar-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-clockwise"></i>
                    <div class="label">arrow-clockwise</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-counterclockwise"></i>
                    <div class="label">arrow-counterclockwise</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-circle-fill"></i>
                    <div class="label">arrow-down-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-circle"></i>
                    <div class="label">arrow-down-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-left-circle-fill"></i>
                    <div class="label">arrow-down-left-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-left-circle"></i>
                    <div class="label">arrow-down-left-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-left-square-fill"></i>
                    <div class="label">arrow-down-left-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-left-square"></i>
                    <div class="label">arrow-down-left-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-left"></i>
                    <div class="label">arrow-down-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-right-circle-fill"></i>
                    <div class="label">arrow-down-right-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-right-circle"></i>
                    <div class="label">arrow-down-right-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-right-square-fill"></i>
                    <div class="label">arrow-down-right-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-right-square"></i>
                    <div class="label">arrow-down-right-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-right"></i>
                    <div class="label">arrow-down-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-short"></i>
                    <div class="label">arrow-down-short</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-square-fill"></i>
                    <div class="label">arrow-down-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-square"></i>
                    <div class="label">arrow-down-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down-up"></i>
                    <div class="label">arrow-down-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-down"></i>
                    <div class="label">arrow-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-left-circle-fill"></i>
                    <div class="label">arrow-left-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-left-circle"></i>
                    <div class="label">arrow-left-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-left-right"></i>
                    <div class="label">arrow-left-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-left-short"></i>
                    <div class="label">arrow-left-short</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-left-square-fill"></i>
                    <div class="label">arrow-left-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-left-square"></i>
                    <div class="label">arrow-left-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-left"></i>
                    <div class="label">arrow-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-repeat"></i>
                    <div class="label">arrow-repeat</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-return-left"></i>
                    <div class="label">arrow-return-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-return-right"></i>
                    <div class="label">arrow-return-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-right-circle-fill"></i>
                    <div class="label">arrow-right-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-right-circle"></i>
                    <div class="label">arrow-right-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-right-short"></i>
                    <div class="label">arrow-right-short</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-right-square-fill"></i>
                    <div class="label">arrow-right-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-right-square"></i>
                    <div class="label">arrow-right-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-right"></i>
                    <div class="label">arrow-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-circle-fill"></i>
                    <div class="label">arrow-up-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-circle"></i>
                    <div class="label">arrow-up-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-left-circle-fill"></i>
                    <div class="label">arrow-up-left-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-left-circle"></i>
                    <div class="label">arrow-up-left-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-left-square-fill"></i>
                    <div class="label">arrow-up-left-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-left-square"></i>
                    <div class="label">arrow-up-left-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-left"></i>
                    <div class="label">arrow-up-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-right-circle-fill"></i>
                    <div class="label">arrow-up-right-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-right-circle"></i>
                    <div class="label">arrow-up-right-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-right-square-fill"></i>
                    <div class="label">arrow-up-right-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-right-square"></i>
                    <div class="label">arrow-up-right-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-right"></i>
                    <div class="label">arrow-up-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-short"></i>
                    <div class="label">arrow-up-short</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-square-fill"></i>
                    <div class="label">arrow-up-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up-square"></i>
                    <div class="label">arrow-up-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrow-up"></i>
                    <div class="label">arrow-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrows-angle-contract"></i>
                    <div class="label">arrows-angle-contract</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrows-angle-expand"></i>
                    <div class="label">arrows-angle-expand</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrows-collapse"></i>
                    <div class="label">arrows-collapse</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrows-expand"></i>
                    <div class="label">arrows-expand</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrows-fullscreen"></i>
                    <div class="label">arrows-fullscreen</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-arrows-move"></i>
                    <div class="label">arrows-move</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-aspect-ratio-fill"></i>
                    <div class="label">aspect-ratio-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-aspect-ratio"></i>
                    <div class="label">aspect-ratio</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-asterisk"></i>
                    <div class="label">asterisk</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-at"></i>
                    <div class="label">at</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-award-fill"></i>
                    <div class="label">award-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-award"></i>
                    <div class="label">award</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-back"></i>
                    <div class="label">back</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-backspace-fill"></i>
                    <div class="label">backspace-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-backspace-reverse-fill"></i>
                    <div class="label">backspace-reverse-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-backspace-reverse"></i>
                    <div class="label">backspace-reverse</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-backspace"></i>
                    <div class="label">backspace</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-3d-fill"></i>
                    <div class="label">badge-3d-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-3d"></i>
                    <div class="label">badge-3d</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-4k-fill"></i>
                    <div class="label">badge-4k-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-4k"></i>
                    <div class="label">badge-4k</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-8k-fill"></i>
                    <div class="label">badge-8k-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-8k"></i>
                    <div class="label">badge-8k</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-ad-fill"></i>
                    <div class="label">badge-ad-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-ad"></i>
                    <div class="label">badge-ad</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-ar-fill"></i>
                    <div class="label">badge-ar-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-ar"></i>
                    <div class="label">badge-ar</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-cc-fill"></i>
                    <div class="label">badge-cc-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-cc"></i>
                    <div class="label">badge-cc</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-hd-fill"></i>
                    <div class="label">badge-hd-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-hd"></i>
                    <div class="label">badge-hd</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-tm-fill"></i>
                    <div class="label">badge-tm-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-tm"></i>
                    <div class="label">badge-tm</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-vo-fill"></i>
                    <div class="label">badge-vo-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-vo"></i>
                    <div class="label">badge-vo</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-vr-fill"></i>
                    <div class="label">badge-vr-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-vr"></i>
                    <div class="label">badge-vr</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-wc-fill"></i>
                    <div class="label">badge-wc-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-badge-wc"></i>
                    <div class="label">badge-wc</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-check-fill"></i>
                    <div class="label">bag-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-check"></i>
                    <div class="label">bag-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-dash-fill"></i>
                    <div class="label">bag-dash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-dash"></i>
                    <div class="label">bag-dash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-fill"></i>
                    <div class="label">bag-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-plus-fill"></i>
                    <div class="label">bag-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-plus"></i>
                    <div class="label">bag-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-x-fill"></i>
                    <div class="label">bag-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag-x"></i>
                    <div class="label">bag-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bag"></i>
                    <div class="label">bag</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bank"></i>
                    <div class="label">bank</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bank2"></i>
                    <div class="label">bank2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bar-chart-fill"></i>
                    <div class="label">bar-chart-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bar-chart-line-fill"></i>
                    <div class="label">bar-chart-line-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bar-chart-line"></i>
                    <div class="label">bar-chart-line</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bar-chart-steps"></i>
                    <div class="label">bar-chart-steps</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bar-chart"></i>
                    <div class="label">bar-chart</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-basket-fill"></i>
                    <div class="label">basket-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-basket"></i>
                    <div class="label">basket</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-basket2-fill"></i>
                    <div class="label">basket2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-basket2"></i>
                    <div class="label">basket2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-basket3-fill"></i>
                    <div class="label">basket3-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-basket3"></i>
                    <div class="label">basket3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-battery-charging"></i>
                    <div class="label">battery-charging</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-battery-full"></i>
                    <div class="label">battery-full</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-battery-half"></i>
                    <div class="label">battery-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-battery"></i>
                    <div class="label">battery</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bell-fill"></i>
                    <div class="label">bell-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bell-slash-fill"></i>
                    <div class="label">bell-slash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bell-slash"></i>
                    <div class="label">bell-slash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bell"></i>
                    <div class="label">bell</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bezier"></i>
                    <div class="label">bezier</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bezier2"></i>
                    <div class="label">bezier2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bicycle"></i>
                    <div class="label">bicycle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-binoculars-fill"></i>
                    <div class="label">binoculars-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-binoculars"></i>
                    <div class="label">binoculars</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-blockquote-left"></i>
                    <div class="label">blockquote-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-blockquote-right"></i>
                    <div class="label">blockquote-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-book-fill"></i>
                    <div class="label">book-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-book-half"></i>
                    <div class="label">book-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-book"></i>
                    <div class="label">book</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-check-fill"></i>
                    <div class="label">bookmark-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-check"></i>
                    <div class="label">bookmark-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-dash-fill"></i>
                    <div class="label">bookmark-dash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-dash"></i>
                    <div class="label">bookmark-dash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-fill"></i>
                    <div class="label">bookmark-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-heart-fill"></i>
                    <div class="label">bookmark-heart-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-heart"></i>
                    <div class="label">bookmark-heart</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-plus-fill"></i>
                    <div class="label">bookmark-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-plus"></i>
                    <div class="label">bookmark-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-star-fill"></i>
                    <div class="label">bookmark-star-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-star"></i>
                    <div class="label">bookmark-star</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-x-fill"></i>
                    <div class="label">bookmark-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark-x"></i>
                    <div class="label">bookmark-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmark"></i>
                    <div class="label">bookmark</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmarks-fill"></i>
                    <div class="label">bookmarks-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookmarks"></i>
                    <div class="label">bookmarks</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bookshelf"></i>
                    <div class="label">bookshelf</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bootstrap-fill"></i>
                    <div class="label">bootstrap-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bootstrap-reboot"></i>
                    <div class="label">bootstrap-reboot</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bootstrap"></i>
                    <div class="label">bootstrap</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-all"></i>
                    <div class="label">border-all</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-bottom"></i>
                    <div class="label">border-bottom</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-center"></i>
                    <div class="label">border-center</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-inner"></i>
                    <div class="label">border-inner</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-left"></i>
                    <div class="label">border-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-middle"></i>
                    <div class="label">border-middle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-outer"></i>
                    <div class="label">border-outer</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-right"></i>
                    <div class="label">border-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-style"></i>
                    <div class="label">border-style</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-top"></i>
                    <div class="label">border-top</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border-width"></i>
                    <div class="label">border-width</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-border"></i>
                    <div class="label">border</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bounding-box-circles"></i>
                    <div class="label">bounding-box-circles</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bounding-box"></i>
                    <div class="label">bounding-box</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-down-left"></i>
                    <div class="label">box-arrow-down-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-down-right"></i>
                    <div class="label">box-arrow-down-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-down"></i>
                    <div class="label">box-arrow-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-in-down-left"></i>
                    <div class="label">box-arrow-in-down-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-in-down-right"></i>
                    <div class="label">box-arrow-in-down-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-in-down"></i>
                    <div class="label">box-arrow-in-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-in-left"></i>
                    <div class="label">box-arrow-in-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-in-right"></i>
                    <div class="label">box-arrow-in-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-in-up-left"></i>
                    <div class="label">box-arrow-in-up-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-in-up-right"></i>
                    <div class="label">box-arrow-in-up-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-in-up"></i>
                    <div class="label">box-arrow-in-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-left"></i>
                    <div class="label">box-arrow-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-right"></i>
                    <div class="label">box-arrow-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-up-left"></i>
                    <div class="label">box-arrow-up-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-up-right"></i>
                    <div class="label">box-arrow-up-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-arrow-up"></i>
                    <div class="label">box-arrow-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box-seam"></i>
                    <div class="label">box-seam</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-box"></i>
                    <div class="label">box</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-braces"></i>
                    <div class="label">braces</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bricks"></i>
                    <div class="label">bricks</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-briefcase-fill"></i>
                    <div class="label">briefcase-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-briefcase"></i>
                    <div class="label">briefcase</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brightness-alt-high-fill"></i>
                    <div class="label">brightness-alt-high-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brightness-alt-high"></i>
                    <div class="label">brightness-alt-high</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brightness-alt-low-fill"></i>
                    <div class="label">brightness-alt-low-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brightness-alt-low"></i>
                    <div class="label">brightness-alt-low</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brightness-high-fill"></i>
                    <div class="label">brightness-high-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brightness-high"></i>
                    <div class="label">brightness-high</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brightness-low-fill"></i>
                    <div class="label">brightness-low-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brightness-low"></i>
                    <div class="label">brightness-low</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-broadcast-pin"></i>
                    <div class="label">broadcast-pin</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-broadcast"></i>
                    <div class="label">broadcast</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brush-fill"></i>
                    <div class="label">brush-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-brush"></i>
                    <div class="label">brush</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bucket-fill"></i>
                    <div class="label">bucket-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bucket"></i>
                    <div class="label">bucket</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bug-fill"></i>
                    <div class="label">bug-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bug"></i>
                    <div class="label">bug</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-building"></i>
                    <div class="label">building</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-bullseye"></i>
                    <div class="label">bullseye</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calculator-fill"></i>
                    <div class="label">calculator-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calculator"></i>
                    <div class="label">calculator</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-check-fill"></i>
                    <div class="label">calendar-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-check"></i>
                    <div class="label">calendar-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-date-fill"></i>
                    <div class="label">calendar-date-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-date"></i>
                    <div class="label">calendar-date</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-day-fill"></i>
                    <div class="label">calendar-day-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-day"></i>
                    <div class="label">calendar-day</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-event-fill"></i>
                    <div class="label">calendar-event-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-event"></i>
                    <div class="label">calendar-event</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-fill"></i>
                    <div class="label">calendar-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-minus-fill"></i>
                    <div class="label">calendar-minus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-minus"></i>
                    <div class="label">calendar-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-month-fill"></i>
                    <div class="label">calendar-month-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-month"></i>
                    <div class="label">calendar-month</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-plus-fill"></i>
                    <div class="label">calendar-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-plus"></i>
                    <div class="label">calendar-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-range-fill"></i>
                    <div class="label">calendar-range-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-range"></i>
                    <div class="label">calendar-range</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-week-fill"></i>
                    <div class="label">calendar-week-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-week"></i>
                    <div class="label">calendar-week</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-x-fill"></i>
                    <div class="label">calendar-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar-x"></i>
                    <div class="label">calendar-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar"></i>
                    <div class="label">calendar</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-check-fill"></i>
                    <div class="label">calendar2-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-check"></i>
                    <div class="label">calendar2-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-date-fill"></i>
                    <div class="label">calendar2-date-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-date"></i>
                    <div class="label">calendar2-date</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-day-fill"></i>
                    <div class="label">calendar2-day-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-day"></i>
                    <div class="label">calendar2-day</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-event-fill"></i>
                    <div class="label">calendar2-event-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-event"></i>
                    <div class="label">calendar2-event</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-fill"></i>
                    <div class="label">calendar2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-minus-fill"></i>
                    <div class="label">calendar2-minus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-minus"></i>
                    <div class="label">calendar2-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-month-fill"></i>
                    <div class="label">calendar2-month-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-month"></i>
                    <div class="label">calendar2-month</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-plus-fill"></i>
                    <div class="label">calendar2-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-plus"></i>
                    <div class="label">calendar2-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-range-fill"></i>
                    <div class="label">calendar2-range-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-range"></i>
                    <div class="label">calendar2-range</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-week-fill"></i>
                    <div class="label">calendar2-week-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-week"></i>
                    <div class="label">calendar2-week</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-x-fill"></i>
                    <div class="label">calendar2-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2-x"></i>
                    <div class="label">calendar2-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar2"></i>
                    <div class="label">calendar2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar3-event-fill"></i>
                    <div class="label">calendar3-event-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar3-event"></i>
                    <div class="label">calendar3-event</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar3-fill"></i>
                    <div class="label">calendar3-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar3-range-fill"></i>
                    <div class="label">calendar3-range-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar3-range"></i>
                    <div class="label">calendar3-range</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar3-week-fill"></i>
                    <div class="label">calendar3-week-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar3-week"></i>
                    <div class="label">calendar3-week</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar3"></i>
                    <div class="label">calendar3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar4-event"></i>
                    <div class="label">calendar4-event</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar4-range"></i>
                    <div class="label">calendar4-range</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar4-week"></i>
                    <div class="label">calendar4-week</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-calendar4"></i>
                    <div class="label">calendar4</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera-fill"></i>
                    <div class="label">camera-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera-reels-fill"></i>
                    <div class="label">camera-reels-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera-reels"></i>
                    <div class="label">camera-reels</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera-video-fill"></i>
                    <div class="label">camera-video-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera-video-off-fill"></i>
                    <div class="label">camera-video-off-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera-video-off"></i>
                    <div class="label">camera-video-off</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera-video"></i>
                    <div class="label">camera-video</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera"></i>
                    <div class="label">camera</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-camera2"></i>
                    <div class="label">camera2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-capslock-fill"></i>
                    <div class="label">capslock-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-capslock"></i>
                    <div class="label">capslock</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-card-checklist"></i>
                    <div class="label">card-checklist</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-card-heading"></i>
                    <div class="label">card-heading</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-card-image"></i>
                    <div class="label">card-image</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-card-list"></i>
                    <div class="label">card-list</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-card-text"></i>
                    <div class="label">card-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-down-fill"></i>
                    <div class="label">caret-down-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-down-square-fill"></i>
                    <div class="label">caret-down-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-down-square"></i>
                    <div class="label">caret-down-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-down"></i>
                    <div class="label">caret-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-left-fill"></i>
                    <div class="label">caret-left-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-left-square-fill"></i>
                    <div class="label">caret-left-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-left-square"></i>
                    <div class="label">caret-left-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-left"></i>
                    <div class="label">caret-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-right-fill"></i>
                    <div class="label">caret-right-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-right-square-fill"></i>
                    <div class="label">caret-right-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-right-square"></i>
                    <div class="label">caret-right-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-right"></i>
                    <div class="label">caret-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-up-fill"></i>
                    <div class="label">caret-up-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-up-square-fill"></i>
                    <div class="label">caret-up-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-up-square"></i>
                    <div class="label">caret-up-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-caret-up"></i>
                    <div class="label">caret-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-check-fill"></i>
                    <div class="label">cart-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-check"></i>
                    <div class="label">cart-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-dash-fill"></i>
                    <div class="label">cart-dash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-dash"></i>
                    <div class="label">cart-dash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-fill"></i>
                    <div class="label">cart-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-plus-fill"></i>
                    <div class="label">cart-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-plus"></i>
                    <div class="label">cart-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-x-fill"></i>
                    <div class="label">cart-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart-x"></i>
                    <div class="label">cart-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart"></i>
                    <div class="label">cart</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart2"></i>
                    <div class="label">cart2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart3"></i>
                    <div class="label">cart3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cart4"></i>
                    <div class="label">cart4</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cash-coin"></i>
                    <div class="label">cash-coin</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cash-stack"></i>
                    <div class="label">cash-stack</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cash"></i>
                    <div class="label">cash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cast"></i>
                    <div class="label">cast</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-dots-fill"></i>
                    <div class="label">chat-dots-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-dots"></i>
                    <div class="label">chat-dots</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-fill"></i>
                    <div class="label">chat-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-left-dots-fill"></i>
                    <div class="label">chat-left-dots-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-left-dots"></i>
                    <div class="label">chat-left-dots</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-left-fill"></i>
                    <div class="label">chat-left-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-left-quote-fill"></i>
                    <div class="label">chat-left-quote-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-left-quote"></i>
                    <div class="label">chat-left-quote</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-left-text-fill"></i>
                    <div class="label">chat-left-text-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-left-text"></i>
                    <div class="label">chat-left-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-left"></i>
                    <div class="label">chat-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-quote-fill"></i>
                    <div class="label">chat-quote-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-quote"></i>
                    <div class="label">chat-quote</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-right-dots-fill"></i>
                    <div class="label">chat-right-dots-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-right-dots"></i>
                    <div class="label">chat-right-dots</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-right-fill"></i>
                    <div class="label">chat-right-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-right-quote-fill"></i>
                    <div class="label">chat-right-quote-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-right-quote"></i>
                    <div class="label">chat-right-quote</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-right-text-fill"></i>
                    <div class="label">chat-right-text-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-right-text"></i>
                    <div class="label">chat-right-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-right"></i>
                    <div class="label">chat-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-square-dots-fill"></i>
                    <div class="label">chat-square-dots-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-square-dots"></i>
                    <div class="label">chat-square-dots</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-square-fill"></i>
                    <div class="label">chat-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-square-quote-fill"></i>
                    <div class="label">chat-square-quote-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-square-quote"></i>
                    <div class="label">chat-square-quote</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-square-text-fill"></i>
                    <div class="label">chat-square-text-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-square-text"></i>
                    <div class="label">chat-square-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-square"></i>
                    <div class="label">chat-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-text-fill"></i>
                    <div class="label">chat-text-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat-text"></i>
                    <div class="label">chat-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chat"></i>
                    <div class="label">chat</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check-all"></i>
                    <div class="label">check-all</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check-circle-fill"></i>
                    <div class="label">check-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check-circle"></i>
                    <div class="label">check-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check-lg"></i>
                    <div class="label">check-lg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check-square-fill"></i>
                    <div class="label">check-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check-square"></i>
                    <div class="label">check-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check"></i>
                    <div class="label">check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check2-all"></i>
                    <div class="label">check2-all</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check2-circle"></i>
                    <div class="label">check2-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check2-square"></i>
                    <div class="label">check2-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-check2"></i>
                    <div class="label">check2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-bar-contract"></i>
                    <div class="label">chevron-bar-contract</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-bar-down"></i>
                    <div class="label">chevron-bar-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-bar-expand"></i>
                    <div class="label">chevron-bar-expand</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-bar-left"></i>
                    <div class="label">chevron-bar-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-bar-right"></i>
                    <div class="label">chevron-bar-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-bar-up"></i>
                    <div class="label">chevron-bar-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-compact-down"></i>
                    <div class="label">chevron-compact-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-compact-left"></i>
                    <div class="label">chevron-compact-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-compact-right"></i>
                    <div class="label">chevron-compact-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-compact-up"></i>
                    <div class="label">chevron-compact-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-contract"></i>
                    <div class="label">chevron-contract</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-double-down"></i>
                    <div class="label">chevron-double-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-double-left"></i>
                    <div class="label">chevron-double-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-double-right"></i>
                    <div class="label">chevron-double-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-double-up"></i>
                    <div class="label">chevron-double-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-down"></i>
                    <div class="label">chevron-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-expand"></i>
                    <div class="label">chevron-expand</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-left"></i>
                    <div class="label">chevron-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-right"></i>
                    <div class="label">chevron-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-chevron-up"></i>
                    <div class="label">chevron-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-circle-fill"></i>
                    <div class="label">circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-circle-half"></i>
                    <div class="label">circle-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-circle-square"></i>
                    <div class="label">circle-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-circle"></i>
                    <div class="label">circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clipboard-check"></i>
                    <div class="label">clipboard-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clipboard-data"></i>
                    <div class="label">clipboard-data</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clipboard-minus"></i>
                    <div class="label">clipboard-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clipboard-plus"></i>
                    <div class="label">clipboard-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clipboard-x"></i>
                    <div class="label">clipboard-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clipboard"></i>
                    <div class="label">clipboard</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clock-fill"></i>
                    <div class="label">clock-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clock-history"></i>
                    <div class="label">clock-history</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clock"></i>
                    <div class="label">clock</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-arrow-down-fill"></i>
                    <div class="label">cloud-arrow-down-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-arrow-down"></i>
                    <div class="label">cloud-arrow-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-arrow-up-fill"></i>
                    <div class="label">cloud-arrow-up-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-arrow-up"></i>
                    <div class="label">cloud-arrow-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-check-fill"></i>
                    <div class="label">cloud-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-check"></i>
                    <div class="label">cloud-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-download-fill"></i>
                    <div class="label">cloud-download-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-download"></i>
                    <div class="label">cloud-download</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-drizzle-fill"></i>
                    <div class="label">cloud-drizzle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-drizzle"></i>
                    <div class="label">cloud-drizzle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-fill"></i>
                    <div class="label">cloud-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-fog-fill"></i>
                    <div class="label">cloud-fog-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-fog"></i>
                    <div class="label">cloud-fog</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-fog2-fill"></i>
                    <div class="label">cloud-fog2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-fog2"></i>
                    <div class="label">cloud-fog2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-hail-fill"></i>
                    <div class="label">cloud-hail-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-hail"></i>
                    <div class="label">cloud-hail</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-haze-1"></i>
                    <div class="label">cloud-haze-1</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-haze-fill"></i>
                    <div class="label">cloud-haze-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-haze"></i>
                    <div class="label">cloud-haze</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-haze2-fill"></i>
                    <div class="label">cloud-haze2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-lightning-fill"></i>
                    <div class="label">cloud-lightning-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-lightning-rain-fill"></i>
                    <div class="label">cloud-lightning-rain-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-lightning-rain"></i>
                    <div class="label">cloud-lightning-rain</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-lightning"></i>
                    <div class="label">cloud-lightning</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-minus-fill"></i>
                    <div class="label">cloud-minus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-minus"></i>
                    <div class="label">cloud-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-moon-fill"></i>
                    <div class="label">cloud-moon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-moon"></i>
                    <div class="label">cloud-moon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-plus-fill"></i>
                    <div class="label">cloud-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-plus"></i>
                    <div class="label">cloud-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-rain-fill"></i>
                    <div class="label">cloud-rain-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-rain-heavy-fill"></i>
                    <div class="label">cloud-rain-heavy-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-rain-heavy"></i>
                    <div class="label">cloud-rain-heavy</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-rain"></i>
                    <div class="label">cloud-rain</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-slash-fill"></i>
                    <div class="label">cloud-slash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-slash"></i>
                    <div class="label">cloud-slash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-sleet-fill"></i>
                    <div class="label">cloud-sleet-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-sleet"></i>
                    <div class="label">cloud-sleet</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-snow-fill"></i>
                    <div class="label">cloud-snow-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-snow"></i>
                    <div class="label">cloud-snow</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-sun-fill"></i>
                    <div class="label">cloud-sun-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-sun"></i>
                    <div class="label">cloud-sun</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-upload-fill"></i>
                    <div class="label">cloud-upload-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud-upload"></i>
                    <div class="label">cloud-upload</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloud"></i>
                    <div class="label">cloud</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clouds-fill"></i>
                    <div class="label">clouds-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-clouds"></i>
                    <div class="label">clouds</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloudy-fill"></i>
                    <div class="label">cloudy-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cloudy"></i>
                    <div class="label">cloudy</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-code-slash"></i>
                    <div class="label">code-slash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-code-square"></i>
                    <div class="label">code-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-code"></i>
                    <div class="label">code</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-coin"></i>
                    <div class="label">coin</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-collection-fill"></i>
                    <div class="label">collection-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-collection-play-fill"></i>
                    <div class="label">collection-play-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-collection-play"></i>
                    <div class="label">collection-play</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-collection"></i>
                    <div class="label">collection</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-columns-gap"></i>
                    <div class="label">columns-gap</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-columns"></i>
                    <div class="label">columns</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-command"></i>
                    <div class="label">command</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-compass-fill"></i>
                    <div class="label">compass-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-compass"></i>
                    <div class="label">compass</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cone-striped"></i>
                    <div class="label">cone-striped</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cone"></i>
                    <div class="label">cone</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-controller"></i>
                    <div class="label">controller</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cpu-fill"></i>
                    <div class="label">cpu-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cpu"></i>
                    <div class="label">cpu</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-credit-card-2-back-fill"></i>
                    <div class="label">credit-card-2-back-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-credit-card-2-back"></i>
                    <div class="label">credit-card-2-back</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-credit-card-2-front-fill"></i>
                    <div class="label">credit-card-2-front-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-credit-card-2-front"></i>
                    <div class="label">credit-card-2-front</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-credit-card-fill"></i>
                    <div class="label">credit-card-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-credit-card"></i>
                    <div class="label">credit-card</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-crop"></i>
                    <div class="label">crop</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cup-fill"></i>
                    <div class="label">cup-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cup-straw"></i>
                    <div class="label">cup-straw</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cup"></i>
                    <div class="label">cup</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-currency-bitcoin"></i>
                    <div class="label">currency-bitcoin</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-currency-dollar"></i>
                    <div class="label">currency-dollar</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-currency-euro"></i>
                    <div class="label">currency-euro</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-currency-exchange"></i>
                    <div class="label">currency-exchange</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-currency-pound"></i>
                    <div class="label">currency-pound</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-currency-yen"></i>
                    <div class="label">currency-yen</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cursor-fill"></i>
                    <div class="label">cursor-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cursor-text"></i>
                    <div class="label">cursor-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-cursor"></i>
                    <div class="label">cursor</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dash-circle-dotted"></i>
                    <div class="label">dash-circle-dotted</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dash-circle-fill"></i>
                    <div class="label">dash-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dash-circle"></i>
                    <div class="label">dash-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dash-lg"></i>
                    <div class="label">dash-lg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dash-square-dotted"></i>
                    <div class="label">dash-square-dotted</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dash-square-fill"></i>
                    <div class="label">dash-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dash-square"></i>
                    <div class="label">dash-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dash"></i>
                    <div class="label">dash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-diagram-2-fill"></i>
                    <div class="label">diagram-2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-diagram-2"></i>
                    <div class="label">diagram-2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-diagram-3-fill"></i>
                    <div class="label">diagram-3-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-diagram-3"></i>
                    <div class="label">diagram-3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-diamond-fill"></i>
                    <div class="label">diamond-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-diamond-half"></i>
                    <div class="label">diamond-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-diamond"></i>
                    <div class="label">diamond</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-1-fill"></i>
                    <div class="label">dice-1-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-1"></i>
                    <div class="label">dice-1</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-2-fill"></i>
                    <div class="label">dice-2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-2"></i>
                    <div class="label">dice-2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-3-fill"></i>
                    <div class="label">dice-3-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-3"></i>
                    <div class="label">dice-3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-4-fill"></i>
                    <div class="label">dice-4-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-4"></i>
                    <div class="label">dice-4</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-5-fill"></i>
                    <div class="label">dice-5-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-5"></i>
                    <div class="label">dice-5</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-6-fill"></i>
                    <div class="label">dice-6-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dice-6"></i>
                    <div class="label">dice-6</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-disc-fill"></i>
                    <div class="label">disc-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-disc"></i>
                    <div class="label">disc</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-discord"></i>
                    <div class="label">discord</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-display-fill"></i>
                    <div class="label">display-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-display"></i>
                    <div class="label">display</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-distribute-horizontal"></i>
                    <div class="label">distribute-horizontal</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-distribute-vertical"></i>
                    <div class="label">distribute-vertical</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-door-closed-fill"></i>
                    <div class="label">door-closed-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-door-closed"></i>
                    <div class="label">door-closed</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-door-open-fill"></i>
                    <div class="label">door-open-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-door-open"></i>
                    <div class="label">door-open</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-dot"></i>
                    <div class="label">dot</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-download"></i>
                    <div class="label">download</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-droplet-fill"></i>
                    <div class="label">droplet-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-droplet-half"></i>
                    <div class="label">droplet-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-droplet"></i>
                    <div class="label">droplet</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-earbuds"></i>
                    <div class="label">earbuds</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-easel-fill"></i>
                    <div class="label">easel-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-easel"></i>
                    <div class="label">easel</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-egg-fill"></i>
                    <div class="label">egg-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-egg-fried"></i>
                    <div class="label">egg-fried</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-egg"></i>
                    <div class="label">egg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eject-fill"></i>
                    <div class="label">eject-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eject"></i>
                    <div class="label">eject</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-angry-fill"></i>
                    <div class="label">emoji-angry-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-angry"></i>
                    <div class="label">emoji-angry</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-dizzy-fill"></i>
                    <div class="label">emoji-dizzy-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-dizzy"></i>
                    <div class="label">emoji-dizzy</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-expressionless-fill"></i>
                    <div class="label">emoji-expressionless-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-expressionless"></i>
                    <div class="label">emoji-expressionless</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-frown-fill"></i>
                    <div class="label">emoji-frown-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-frown"></i>
                    <div class="label">emoji-frown</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-heart-eyes-fill"></i>
                    <div class="label">emoji-heart-eyes-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-heart-eyes"></i>
                    <div class="label">emoji-heart-eyes</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-laughing-fill"></i>
                    <div class="label">emoji-laughing-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-laughing"></i>
                    <div class="label">emoji-laughing</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-neutral-fill"></i>
                    <div class="label">emoji-neutral-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-neutral"></i>
                    <div class="label">emoji-neutral</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-smile-fill"></i>
                    <div class="label">emoji-smile-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-smile-upside-down-fill"></i>
                    <div class="label">emoji-smile-upside-down-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-smile-upside-down"></i>
                    <div class="label">emoji-smile-upside-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-smile"></i>
                    <div class="label">emoji-smile</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-sunglasses-fill"></i>
                    <div class="label">emoji-sunglasses-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-sunglasses"></i>
                    <div class="label">emoji-sunglasses</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-wink-fill"></i>
                    <div class="label">emoji-wink-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-emoji-wink"></i>
                    <div class="label">emoji-wink</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-envelope-fill"></i>
                    <div class="label">envelope-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-envelope-open-fill"></i>
                    <div class="label">envelope-open-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-envelope-open"></i>
                    <div class="label">envelope-open</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-envelope"></i>
                    <div class="label">envelope</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eraser-fill"></i>
                    <div class="label">eraser-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eraser"></i>
                    <div class="label">eraser</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-circle-fill"></i>
                    <div class="label">exclamation-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-circle"></i>
                    <div class="label">exclamation-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-diamond-fill"></i>
                    <div class="label">exclamation-diamond-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-diamond"></i>
                    <div class="label">exclamation-diamond</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-lg"></i>
                    <div class="label">exclamation-lg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-octagon-fill"></i>
                    <div class="label">exclamation-octagon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-octagon"></i>
                    <div class="label">exclamation-octagon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-square-fill"></i>
                    <div class="label">exclamation-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-square"></i>
                    <div class="label">exclamation-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-triangle-fill"></i>
                    <div class="label">exclamation-triangle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation-triangle"></i>
                    <div class="label">exclamation-triangle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclamation"></i>
                    <div class="label">exclamation</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-exclude"></i>
                    <div class="label">exclude</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eye-fill"></i>
                    <div class="label">eye-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eye-slash-fill"></i>
                    <div class="label">eye-slash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eye-slash"></i>
                    <div class="label">eye-slash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eye"></i>
                    <div class="label">eye</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eyedropper"></i>
                    <div class="label">eyedropper</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-eyeglasses"></i>
                    <div class="label">eyeglasses</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-facebook"></i>
                    <div class="label">facebook</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-arrow-down-fill"></i>
                    <div class="label">file-arrow-down-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-arrow-down"></i>
                    <div class="label">file-arrow-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-arrow-up-fill"></i>
                    <div class="label">file-arrow-up-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-arrow-up"></i>
                    <div class="label">file-arrow-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-bar-graph-fill"></i>
                    <div class="label">file-bar-graph-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-bar-graph"></i>
                    <div class="label">file-bar-graph</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-binary-fill"></i>
                    <div class="label">file-binary-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-binary"></i>
                    <div class="label">file-binary</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-break-fill"></i>
                    <div class="label">file-break-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-break"></i>
                    <div class="label">file-break</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-check-fill"></i>
                    <div class="label">file-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-check"></i>
                    <div class="label">file-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-code-fill"></i>
                    <div class="label">file-code-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-code"></i>
                    <div class="label">file-code</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-diff-fill"></i>
                    <div class="label">file-diff-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-diff"></i>
                    <div class="label">file-diff</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-arrow-down-fill"></i>
                    <div class="label">file-earmark-arrow-down-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-arrow-down"></i>
                    <div class="label">file-earmark-arrow-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-arrow-up-fill"></i>
                    <div class="label">file-earmark-arrow-up-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-arrow-up"></i>
                    <div class="label">file-earmark-arrow-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-bar-graph-fill"></i>
                    <div class="label">file-earmark-bar-graph-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-bar-graph"></i>
                    <div class="label">file-earmark-bar-graph</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-binary-fill"></i>
                    <div class="label">file-earmark-binary-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-binary"></i>
                    <div class="label">file-earmark-binary</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-break-fill"></i>
                    <div class="label">file-earmark-break-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-break"></i>
                    <div class="label">file-earmark-break</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-check-fill"></i>
                    <div class="label">file-earmark-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-check"></i>
                    <div class="label">file-earmark-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-code-fill"></i>
                    <div class="label">file-earmark-code-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-code"></i>
                    <div class="label">file-earmark-code</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-diff-fill"></i>
                    <div class="label">file-earmark-diff-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-diff"></i>
                    <div class="label">file-earmark-diff</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-easel-fill"></i>
                    <div class="label">file-earmark-easel-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-easel"></i>
                    <div class="label">file-earmark-easel</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-excel-fill"></i>
                    <div class="label">file-earmark-excel-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-excel"></i>
                    <div class="label">file-earmark-excel</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-fill"></i>
                    <div class="label">file-earmark-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-font-fill"></i>
                    <div class="label">file-earmark-font-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-font"></i>
                    <div class="label">file-earmark-font</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-image-fill"></i>
                    <div class="label">file-earmark-image-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-image"></i>
                    <div class="label">file-earmark-image</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-lock-fill"></i>
                    <div class="label">file-earmark-lock-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-lock"></i>
                    <div class="label">file-earmark-lock</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-lock2-fill"></i>
                    <div class="label">file-earmark-lock2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-lock2"></i>
                    <div class="label">file-earmark-lock2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-medical-fill"></i>
                    <div class="label">file-earmark-medical-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-medical"></i>
                    <div class="label">file-earmark-medical</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-minus-fill"></i>
                    <div class="label">file-earmark-minus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-minus"></i>
                    <div class="label">file-earmark-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-music-fill"></i>
                    <div class="label">file-earmark-music-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-music"></i>
                    <div class="label">file-earmark-music</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-pdf-fill"></i>
                    <div class="label">file-earmark-pdf-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-pdf"></i>
                    <div class="label">file-earmark-pdf</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-person-fill"></i>
                    <div class="label">file-earmark-person-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-person"></i>
                    <div class="label">file-earmark-person</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-play-fill"></i>
                    <div class="label">file-earmark-play-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-play"></i>
                    <div class="label">file-earmark-play</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-plus-fill"></i>
                    <div class="label">file-earmark-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-plus"></i>
                    <div class="label">file-earmark-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-post-fill"></i>
                    <div class="label">file-earmark-post-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-post"></i>
                    <div class="label">file-earmark-post</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-ppt-fill"></i>
                    <div class="label">file-earmark-ppt-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-ppt"></i>
                    <div class="label">file-earmark-ppt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-richtext-fill"></i>
                    <div class="label">file-earmark-richtext-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-richtext"></i>
                    <div class="label">file-earmark-richtext</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-ruled-fill"></i>
                    <div class="label">file-earmark-ruled-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-ruled"></i>
                    <div class="label">file-earmark-ruled</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-slides-fill"></i>
                    <div class="label">file-earmark-slides-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-slides"></i>
                    <div class="label">file-earmark-slides</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-spreadsheet-fill"></i>
                    <div class="label">file-earmark-spreadsheet-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-spreadsheet"></i>
                    <div class="label">file-earmark-spreadsheet</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-text-fill"></i>
                    <div class="label">file-earmark-text-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-text"></i>
                    <div class="label">file-earmark-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-word-fill"></i>
                    <div class="label">file-earmark-word-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-word"></i>
                    <div class="label">file-earmark-word</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-x-fill"></i>
                    <div class="label">file-earmark-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-x"></i>
                    <div class="label">file-earmark-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-zip-fill"></i>
                    <div class="label">file-earmark-zip-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark-zip"></i>
                    <div class="label">file-earmark-zip</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-earmark"></i>
                    <div class="label">file-earmark</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-easel-fill"></i>
                    <div class="label">file-easel-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-easel"></i>
                    <div class="label">file-easel</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-excel-fill"></i>
                    <div class="label">file-excel-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-excel"></i>
                    <div class="label">file-excel</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-fill"></i>
                    <div class="label">file-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-font-fill"></i>
                    <div class="label">file-font-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-font"></i>
                    <div class="label">file-font</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-image-fill"></i>
                    <div class="label">file-image-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-image"></i>
                    <div class="label">file-image</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-lock-fill"></i>
                    <div class="label">file-lock-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-lock"></i>
                    <div class="label">file-lock</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-lock2-fill"></i>
                    <div class="label">file-lock2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-lock2"></i>
                    <div class="label">file-lock2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-medical-fill"></i>
                    <div class="label">file-medical-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-medical"></i>
                    <div class="label">file-medical</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-minus-fill"></i>
                    <div class="label">file-minus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-minus"></i>
                    <div class="label">file-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-music-fill"></i>
                    <div class="label">file-music-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-music"></i>
                    <div class="label">file-music</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-pdf-fill"></i>
                    <div class="label">file-pdf-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-pdf"></i>
                    <div class="label">file-pdf</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-person-fill"></i>
                    <div class="label">file-person-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-person"></i>
                    <div class="label">file-person</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-play-fill"></i>
                    <div class="label">file-play-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-play"></i>
                    <div class="label">file-play</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-plus-fill"></i>
                    <div class="label">file-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-plus"></i>
                    <div class="label">file-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-post-fill"></i>
                    <div class="label">file-post-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-post"></i>
                    <div class="label">file-post</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-ppt-fill"></i>
                    <div class="label">file-ppt-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-ppt"></i>
                    <div class="label">file-ppt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-richtext-fill"></i>
                    <div class="label">file-richtext-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-richtext"></i>
                    <div class="label">file-richtext</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-ruled-fill"></i>
                    <div class="label">file-ruled-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-ruled"></i>
                    <div class="label">file-ruled</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-slides-fill"></i>
                    <div class="label">file-slides-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-slides"></i>
                    <div class="label">file-slides</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-spreadsheet-fill"></i>
                    <div class="label">file-spreadsheet-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-spreadsheet"></i>
                    <div class="label">file-spreadsheet</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-text-fill"></i>
                    <div class="label">file-text-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-text"></i>
                    <div class="label">file-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-word-fill"></i>
                    <div class="label">file-word-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-word"></i>
                    <div class="label">file-word</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-x-fill"></i>
                    <div class="label">file-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-x"></i>
                    <div class="label">file-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-zip-fill"></i>
                    <div class="label">file-zip-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file-zip"></i>
                    <div class="label">file-zip</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-file"></i>
                    <div class="label">file</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-files-alt"></i>
                    <div class="label">files-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-files"></i>
                    <div class="label">files</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-film"></i>
                    <div class="label">film</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-filter-circle-fill"></i>
                    <div class="label">filter-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-filter-circle"></i>
                    <div class="label">filter-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-filter-left"></i>
                    <div class="label">filter-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-filter-right"></i>
                    <div class="label">filter-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-filter-square-fill"></i>
                    <div class="label">filter-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-filter-square"></i>
                    <div class="label">filter-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-filter"></i>
                    <div class="label">filter</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-flag-fill"></i>
                    <div class="label">flag-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-flag"></i>
                    <div class="label">flag</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-flower1"></i>
                    <div class="label">flower1</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-flower2"></i>
                    <div class="label">flower2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-flower3"></i>
                    <div class="label">flower3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder-check"></i>
                    <div class="label">folder-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder-fill"></i>
                    <div class="label">folder-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder-minus"></i>
                    <div class="label">folder-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder-plus"></i>
                    <div class="label">folder-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder-symlink-fill"></i>
                    <div class="label">folder-symlink-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder-symlink"></i>
                    <div class="label">folder-symlink</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder-x"></i>
                    <div class="label">folder-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder"></i>
                    <div class="label">folder</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder2-open"></i>
                    <div class="label">folder2-open</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-folder2"></i>
                    <div class="label">folder2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-fonts"></i>
                    <div class="label">fonts</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-forward-fill"></i>
                    <div class="label">forward-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-forward"></i>
                    <div class="label">forward</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-front"></i>
                    <div class="label">front</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-fullscreen-exit"></i>
                    <div class="label">fullscreen-exit</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-fullscreen"></i>
                    <div class="label">fullscreen</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-funnel-fill"></i>
                    <div class="label">funnel-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-funnel"></i>
                    <div class="label">funnel</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gear-fill"></i>
                    <div class="label">gear-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gear-wide-connected"></i>
                    <div class="label">gear-wide-connected</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gear-wide"></i>
                    <div class="label">gear-wide</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gear"></i>
                    <div class="label">gear</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gem"></i>
                    <div class="label">gem</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gender-ambiguous"></i>
                    <div class="label">gender-ambiguous</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gender-female"></i>
                    <div class="label">gender-female</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gender-male"></i>
                    <div class="label">gender-male</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gender-trans"></i>
                    <div class="label">gender-trans</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-geo-alt-fill"></i>
                    <div class="label">geo-alt-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-geo-alt"></i>
                    <div class="label">geo-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-geo-fill"></i>
                    <div class="label">geo-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-geo"></i>
                    <div class="label">geo</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gift-fill"></i>
                    <div class="label">gift-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-gift"></i>
                    <div class="label">gift</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-github"></i>
                    <div class="label">github</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-globe"></i>
                    <div class="label">globe</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-globe2"></i>
                    <div class="label">globe2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-google"></i>
                    <div class="label">google</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-graph-down"></i>
                    <div class="label">graph-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-graph-up"></i>
                    <div class="label">graph-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-1x2-fill"></i>
                    <div class="label">grid-1x2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-1x2"></i>
                    <div class="label">grid-1x2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-3x2-gap-fill"></i>
                    <div class="label">grid-3x2-gap-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-3x2-gap"></i>
                    <div class="label">grid-3x2-gap</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-3x2"></i>
                    <div class="label">grid-3x2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-3x3-gap-fill"></i>
                    <div class="label">grid-3x3-gap-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-3x3-gap"></i>
                    <div class="label">grid-3x3-gap</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-3x3"></i>
                    <div class="label">grid-3x3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid-fill"></i>
                    <div class="label">grid-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grid"></i>
                    <div class="label">grid</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grip-horizontal"></i>
                    <div class="label">grip-horizontal</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-grip-vertical"></i>
                    <div class="label">grip-vertical</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hammer"></i>
                    <div class="label">hammer</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hand-index-fill"></i>
                    <div class="label">hand-index-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hand-index-thumb-fill"></i>
                    <div class="label">hand-index-thumb-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hand-index-thumb"></i>
                    <div class="label">hand-index-thumb</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hand-index"></i>
                    <div class="label">hand-index</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hand-thumbs-down-fill"></i>
                    <div class="label">hand-thumbs-down-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hand-thumbs-down"></i>
                    <div class="label">hand-thumbs-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hand-thumbs-up-fill"></i>
                    <div class="label">hand-thumbs-up-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hand-thumbs-up"></i>
                    <div class="label">hand-thumbs-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-handbag-fill"></i>
                    <div class="label">handbag-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-handbag"></i>
                    <div class="label">handbag</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hash"></i>
                    <div class="label">hash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hdd-fill"></i>
                    <div class="label">hdd-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hdd-network-fill"></i>
                    <div class="label">hdd-network-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hdd-network"></i>
                    <div class="label">hdd-network</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hdd-rack-fill"></i>
                    <div class="label">hdd-rack-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hdd-rack"></i>
                    <div class="label">hdd-rack</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hdd-stack-fill"></i>
                    <div class="label">hdd-stack-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hdd-stack"></i>
                    <div class="label">hdd-stack</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hdd"></i>
                    <div class="label">hdd</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-headphones"></i>
                    <div class="label">headphones</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-headset-vr"></i>
                    <div class="label">headset-vr</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-headset"></i>
                    <div class="label">headset</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-heart-fill"></i>
                    <div class="label">heart-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-heart-half"></i>
                    <div class="label">heart-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-heart"></i>
                    <div class="label">heart</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-heptagon-fill"></i>
                    <div class="label">heptagon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-heptagon-half"></i>
                    <div class="label">heptagon-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-heptagon"></i>
                    <div class="label">heptagon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hexagon-fill"></i>
                    <div class="label">hexagon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hexagon-half"></i>
                    <div class="label">hexagon-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hexagon"></i>
                    <div class="label">hexagon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hourglass-bottom"></i>
                    <div class="label">hourglass-bottom</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hourglass-split"></i>
                    <div class="label">hourglass-split</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hourglass-top"></i>
                    <div class="label">hourglass-top</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hourglass"></i>
                    <div class="label">hourglass</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-house-door-fill"></i>
                    <div class="label">house-door-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-house-door"></i>
                    <div class="label">house-door</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-house-fill"></i>
                    <div class="label">house-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-house"></i>
                    <div class="label">house</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hr"></i>
                    <div class="label">hr</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-hurricane"></i>
                    <div class="label">hurricane</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-image-alt"></i>
                    <div class="label">image-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-image-fill"></i>
                    <div class="label">image-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-image"></i>
                    <div class="label">image</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-images"></i>
                    <div class="label">images</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-inbox-fill"></i>
                    <div class="label">inbox-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-inbox"></i>
                    <div class="label">inbox</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-inboxes-fill"></i>
                    <div class="label">inboxes-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-inboxes"></i>
                    <div class="label">inboxes</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-info-circle-fill"></i>
                    <div class="label">info-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-info-circle"></i>
                    <div class="label">info-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-info-lg"></i>
                    <div class="label">info-lg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-info-square-fill"></i>
                    <div class="label">info-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-info-square"></i>
                    <div class="label">info-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-info"></i>
                    <div class="label">info</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-input-cursor-text"></i>
                    <div class="label">input-cursor-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-input-cursor"></i>
                    <div class="label">input-cursor</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-instagram"></i>
                    <div class="label">instagram</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-intersect"></i>
                    <div class="label">intersect</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-album"></i>
                    <div class="label">journal-album</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-arrow-down"></i>
                    <div class="label">journal-arrow-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-arrow-up"></i>
                    <div class="label">journal-arrow-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-bookmark-fill"></i>
                    <div class="label">journal-bookmark-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-bookmark"></i>
                    <div class="label">journal-bookmark</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-check"></i>
                    <div class="label">journal-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-code"></i>
                    <div class="label">journal-code</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-medical"></i>
                    <div class="label">journal-medical</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-minus"></i>
                    <div class="label">journal-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-plus"></i>
                    <div class="label">journal-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-richtext"></i>
                    <div class="label">journal-richtext</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-text"></i>
                    <div class="label">journal-text</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal-x"></i>
                    <div class="label">journal-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journal"></i>
                    <div class="label">journal</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-journals"></i>
                    <div class="label">journals</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-joystick"></i>
                    <div class="label">joystick</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-justify-left"></i>
                    <div class="label">justify-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-justify-right"></i>
                    <div class="label">justify-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-justify"></i>
                    <div class="label">justify</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-kanban-fill"></i>
                    <div class="label">kanban-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-kanban"></i>
                    <div class="label">kanban</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-key-fill"></i>
                    <div class="label">key-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-key"></i>
                    <div class="label">key</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-keyboard-fill"></i>
                    <div class="label">keyboard-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-keyboard"></i>
                    <div class="label">keyboard</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-ladder"></i>
                    <div class="label">ladder</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lamp-fill"></i>
                    <div class="label">lamp-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lamp"></i>
                    <div class="label">lamp</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-laptop-fill"></i>
                    <div class="label">laptop-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-laptop"></i>
                    <div class="label">laptop</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layer-backward"></i>
                    <div class="label">layer-backward</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layer-forward"></i>
                    <div class="label">layer-forward</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layers-fill"></i>
                    <div class="label">layers-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layers-half"></i>
                    <div class="label">layers-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layers"></i>
                    <div class="label">layers</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-sidebar-inset-reverse"></i>
                    <div class="label">layout-sidebar-inset-reverse</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-sidebar-inset"></i>
                    <div class="label">layout-sidebar-inset</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-sidebar-reverse"></i>
                    <div class="label">layout-sidebar-reverse</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-sidebar"></i>
                    <div class="label">layout-sidebar</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-split"></i>
                    <div class="label">layout-split</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-text-sidebar-reverse"></i>
                    <div class="label">layout-text-sidebar-reverse</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-text-sidebar"></i>
                    <div class="label">layout-text-sidebar</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-text-window-reverse"></i>
                    <div class="label">layout-text-window-reverse</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-text-window"></i>
                    <div class="label">layout-text-window</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-three-columns"></i>
                    <div class="label">layout-three-columns</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-layout-wtf"></i>
                    <div class="label">layout-wtf</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-life-preserver"></i>
                    <div class="label">life-preserver</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lightbulb-fill"></i>
                    <div class="label">lightbulb-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lightbulb-off-fill"></i>
                    <div class="label">lightbulb-off-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lightbulb-off"></i>
                    <div class="label">lightbulb-off</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lightbulb"></i>
                    <div class="label">lightbulb</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lightning-charge-fill"></i>
                    <div class="label">lightning-charge-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lightning-charge"></i>
                    <div class="label">lightning-charge</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lightning-fill"></i>
                    <div class="label">lightning-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lightning"></i>
                    <div class="label">lightning</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-link-45deg"></i>
                    <div class="label">link-45deg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-link"></i>
                    <div class="label">link</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-linkedin"></i>
                    <div class="label">linkedin</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-list-check"></i>
                    <div class="label">list-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-list-nested"></i>
                    <div class="label">list-nested</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-list-ol"></i>
                    <div class="label">list-ol</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-list-stars"></i>
                    <div class="label">list-stars</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-list-task"></i>
                    <div class="label">list-task</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-list-ul"></i>
                    <div class="label">list-ul</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-list"></i>
                    <div class="label">list</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lock-fill"></i>
                    <div class="label">lock-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-lock"></i>
                    <div class="label">lock</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mailbox"></i>
                    <div class="label">mailbox</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mailbox2"></i>
                    <div class="label">mailbox2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-map-fill"></i>
                    <div class="label">map-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-map"></i>
                    <div class="label">map</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-markdown-fill"></i>
                    <div class="label">markdown-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-markdown"></i>
                    <div class="label">markdown</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mask"></i>
                    <div class="label">mask</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mastodon"></i>
                    <div class="label">mastodon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-megaphone-fill"></i>
                    <div class="label">megaphone-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-megaphone"></i>
                    <div class="label">megaphone</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-menu-app-fill"></i>
                    <div class="label">menu-app-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-menu-app"></i>
                    <div class="label">menu-app</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-menu-button-fill"></i>
                    <div class="label">menu-button-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-menu-button-wide-fill"></i>
                    <div class="label">menu-button-wide-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-menu-button-wide"></i>
                    <div class="label">menu-button-wide</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-menu-button"></i>
                    <div class="label">menu-button</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-menu-down"></i>
                    <div class="label">menu-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-menu-up"></i>
                    <div class="label">menu-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-messenger"></i>
                    <div class="label">messenger</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mic-fill"></i>
                    <div class="label">mic-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mic-mute-fill"></i>
                    <div class="label">mic-mute-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mic-mute"></i>
                    <div class="label">mic-mute</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mic"></i>
                    <div class="label">mic</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-minecart-loaded"></i>
                    <div class="label">minecart-loaded</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-minecart"></i>
                    <div class="label">minecart</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-moisture"></i>
                    <div class="label">moisture</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-moon-fill"></i>
                    <div class="label">moon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-moon-stars-fill"></i>
                    <div class="label">moon-stars-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-moon-stars"></i>
                    <div class="label">moon-stars</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-moon"></i>
                    <div class="label">moon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mouse-fill"></i>
                    <div class="label">mouse-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mouse"></i>
                    <div class="label">mouse</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mouse2-fill"></i>
                    <div class="label">mouse2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mouse2"></i>
                    <div class="label">mouse2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mouse3-fill"></i>
                    <div class="label">mouse3-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-mouse3"></i>
                    <div class="label">mouse3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-music-note-beamed"></i>
                    <div class="label">music-note-beamed</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-music-note-list"></i>
                    <div class="label">music-note-list</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-music-note"></i>
                    <div class="label">music-note</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-music-player-fill"></i>
                    <div class="label">music-player-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-music-player"></i>
                    <div class="label">music-player</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-newspaper"></i>
                    <div class="label">newspaper</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-node-minus-fill"></i>
                    <div class="label">node-minus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-node-minus"></i>
                    <div class="label">node-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-node-plus-fill"></i>
                    <div class="label">node-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-node-plus"></i>
                    <div class="label">node-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-nut-fill"></i>
                    <div class="label">nut-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-nut"></i>
                    <div class="label">nut</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-octagon-fill"></i>
                    <div class="label">octagon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-octagon-half"></i>
                    <div class="label">octagon-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-octagon"></i>
                    <div class="label">octagon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-option"></i>
                    <div class="label">option</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-outlet"></i>
                    <div class="label">outlet</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-paint-bucket"></i>
                    <div class="label">paint-bucket</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-palette-fill"></i>
                    <div class="label">palette-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-palette"></i>
                    <div class="label">palette</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-palette2"></i>
                    <div class="label">palette2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-paperclip"></i>
                    <div class="label">paperclip</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-paragraph"></i>
                    <div class="label">paragraph</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-check-fill"></i>
                    <div class="label">patch-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-check"></i>
                    <div class="label">patch-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-exclamation-fill"></i>
                    <div class="label">patch-exclamation-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-exclamation"></i>
                    <div class="label">patch-exclamation</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-minus-fill"></i>
                    <div class="label">patch-minus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-minus"></i>
                    <div class="label">patch-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-plus-fill"></i>
                    <div class="label">patch-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-plus"></i>
                    <div class="label">patch-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-question-fill"></i>
                    <div class="label">patch-question-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-patch-question"></i>
                    <div class="label">patch-question</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pause-btn-fill"></i>
                    <div class="label">pause-btn-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pause-btn"></i>
                    <div class="label">pause-btn</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pause-circle-fill"></i>
                    <div class="label">pause-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pause-circle"></i>
                    <div class="label">pause-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pause-fill"></i>
                    <div class="label">pause-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pause"></i>
                    <div class="label">pause</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-peace-fill"></i>
                    <div class="label">peace-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-peace"></i>
                    <div class="label">peace</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pen-fill"></i>
                    <div class="label">pen-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pen"></i>
                    <div class="label">pen</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pencil-fill"></i>
                    <div class="label">pencil-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pencil-square"></i>
                    <div class="label">pencil-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pencil"></i>
                    <div class="label">pencil</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pentagon-fill"></i>
                    <div class="label">pentagon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pentagon-half"></i>
                    <div class="label">pentagon-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pentagon"></i>
                    <div class="label">pentagon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-people-fill"></i>
                    <div class="label">people-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-people"></i>
                    <div class="label">people</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-percent"></i>
                    <div class="label">percent</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-badge-fill"></i>
                    <div class="label">person-badge-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-badge"></i>
                    <div class="label">person-badge</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-bounding-box"></i>
                    <div class="label">person-bounding-box</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-check-fill"></i>
                    <div class="label">person-check-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-check"></i>
                    <div class="label">person-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-circle"></i>
                    <div class="label">person-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-dash-fill"></i>
                    <div class="label">person-dash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-dash"></i>
                    <div class="label">person-dash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-fill"></i>
                    <div class="label">person-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-lines-fill"></i>
                    <div class="label">person-lines-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-plus-fill"></i>
                    <div class="label">person-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-plus"></i>
                    <div class="label">person-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-square"></i>
                    <div class="label">person-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-x-fill"></i>
                    <div class="label">person-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person-x"></i>
                    <div class="label">person-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-person"></i>
                    <div class="label">person</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-phone-fill"></i>
                    <div class="label">phone-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-phone-landscape-fill"></i>
                    <div class="label">phone-landscape-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-phone-landscape"></i>
                    <div class="label">phone-landscape</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-phone-vibrate-fill"></i>
                    <div class="label">phone-vibrate-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-phone-vibrate"></i>
                    <div class="label">phone-vibrate</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-phone"></i>
                    <div class="label">phone</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pie-chart-fill"></i>
                    <div class="label">pie-chart-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pie-chart"></i>
                    <div class="label">pie-chart</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-piggy-bank-fill"></i>
                    <div class="label">piggy-bank-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-piggy-bank"></i>
                    <div class="label">piggy-bank</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pin-angle-fill"></i>
                    <div class="label">pin-angle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pin-angle"></i>
                    <div class="label">pin-angle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pin-fill"></i>
                    <div class="label">pin-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pin-map-fill"></i>
                    <div class="label">pin-map-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pin-map"></i>
                    <div class="label">pin-map</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pin"></i>
                    <div class="label">pin</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pip-fill"></i>
                    <div class="label">pip-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-pip"></i>
                    <div class="label">pip</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-play-btn-fill"></i>
                    <div class="label">play-btn-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-play-btn"></i>
                    <div class="label">play-btn</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-play-circle-fill"></i>
                    <div class="label">play-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-play-circle"></i>
                    <div class="label">play-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-play-fill"></i>
                    <div class="label">play-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-play"></i>
                    <div class="label">play</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plug-fill"></i>
                    <div class="label">plug-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plug"></i>
                    <div class="label">plug</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plus-circle-dotted"></i>
                    <div class="label">plus-circle-dotted</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plus-circle-fill"></i>
                    <div class="label">plus-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plus-circle"></i>
                    <div class="label">plus-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plus-lg"></i>
                    <div class="label">plus-lg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plus-square-dotted"></i>
                    <div class="label">plus-square-dotted</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plus-square-fill"></i>
                    <div class="label">plus-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plus-square"></i>
                    <div class="label">plus-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-plus"></i>
                    <div class="label">plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-power"></i>
                    <div class="label">power</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-printer-fill"></i>
                    <div class="label">printer-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-printer"></i>
                    <div class="label">printer</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-puzzle-fill"></i>
                    <div class="label">puzzle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-puzzle"></i>
                    <div class="label">puzzle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-circle-fill"></i>
                    <div class="label">question-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-circle"></i>
                    <div class="label">question-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-diamond-fill"></i>
                    <div class="label">question-diamond-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-diamond"></i>
                    <div class="label">question-diamond</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-lg"></i>
                    <div class="label">question-lg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-octagon-fill"></i>
                    <div class="label">question-octagon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-octagon"></i>
                    <div class="label">question-octagon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-square-fill"></i>
                    <div class="label">question-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question-square"></i>
                    <div class="label">question-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-question"></i>
                    <div class="label">question</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-rainbow"></i>
                    <div class="label">rainbow</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-receipt-cutoff"></i>
                    <div class="label">receipt-cutoff</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-receipt"></i>
                    <div class="label">receipt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reception-0"></i>
                    <div class="label">reception-0</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reception-1"></i>
                    <div class="label">reception-1</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reception-2"></i>
                    <div class="label">reception-2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reception-3"></i>
                    <div class="label">reception-3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reception-4"></i>
                    <div class="label">reception-4</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-record-btn-fill"></i>
                    <div class="label">record-btn-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-record-btn"></i>
                    <div class="label">record-btn</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-record-circle-fill"></i>
                    <div class="label">record-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-record-circle"></i>
                    <div class="label">record-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-record-fill"></i>
                    <div class="label">record-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-record"></i>
                    <div class="label">record</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-record2-fill"></i>
                    <div class="label">record2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-record2"></i>
                    <div class="label">record2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-recycle"></i>
                    <div class="label">recycle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reddit"></i>
                    <div class="label">reddit</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reply-all-fill"></i>
                    <div class="label">reply-all-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reply-all"></i>
                    <div class="label">reply-all</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reply-fill"></i>
                    <div class="label">reply-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-reply"></i>
                    <div class="label">reply</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-rss-fill"></i>
                    <div class="label">rss-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-rss"></i>
                    <div class="label">rss</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-rulers"></i>
                    <div class="label">rulers</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-safe-fill"></i>
                    <div class="label">safe-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-safe"></i>
                    <div class="label">safe</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-safe2-fill"></i>
                    <div class="label">safe2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-safe2"></i>
                    <div class="label">safe2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-save-fill"></i>
                    <div class="label">save-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-save"></i>
                    <div class="label">save</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-save2-fill"></i>
                    <div class="label">save2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-save2"></i>
                    <div class="label">save2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-scissors"></i>
                    <div class="label">scissors</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-screwdriver"></i>
                    <div class="label">screwdriver</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sd-card-fill"></i>
                    <div class="label">sd-card-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sd-card"></i>
                    <div class="label">sd-card</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-search"></i>
                    <div class="label">search</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-segmented-nav"></i>
                    <div class="label">segmented-nav</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-server"></i>
                    <div class="label">server</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-share-fill"></i>
                    <div class="label">share-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-share"></i>
                    <div class="label">share</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-check"></i>
                    <div class="label">shield-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-exclamation"></i>
                    <div class="label">shield-exclamation</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-fill-check"></i>
                    <div class="label">shield-fill-check</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-fill-exclamation"></i>
                    <div class="label">shield-fill-exclamation</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-fill-minus"></i>
                    <div class="label">shield-fill-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-fill-plus"></i>
                    <div class="label">shield-fill-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-fill-x"></i>
                    <div class="label">shield-fill-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-fill"></i>
                    <div class="label">shield-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-lock-fill"></i>
                    <div class="label">shield-lock-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-lock"></i>
                    <div class="label">shield-lock</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-minus"></i>
                    <div class="label">shield-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-plus"></i>
                    <div class="label">shield-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-shaded"></i>
                    <div class="label">shield-shaded</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-slash-fill"></i>
                    <div class="label">shield-slash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-slash"></i>
                    <div class="label">shield-slash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield-x"></i>
                    <div class="label">shield-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shield"></i>
                    <div class="label">shield</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shift-fill"></i>
                    <div class="label">shift-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shift"></i>
                    <div class="label">shift</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shop-window"></i>
                    <div class="label">shop-window</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shop"></i>
                    <div class="label">shop</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-shuffle"></i>
                    <div class="label">shuffle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-signpost-2-fill"></i>
                    <div class="label">signpost-2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-signpost-2"></i>
                    <div class="label">signpost-2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-signpost-fill"></i>
                    <div class="label">signpost-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-signpost-split-fill"></i>
                    <div class="label">signpost-split-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-signpost-split"></i>
                    <div class="label">signpost-split</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-signpost"></i>
                    <div class="label">signpost</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sim-fill"></i>
                    <div class="label">sim-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sim"></i>
                    <div class="label">sim</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-backward-btn-fill"></i>
                    <div class="label">skip-backward-btn-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-backward-btn"></i>
                    <div class="label">skip-backward-btn</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-backward-circle-fill"></i>
                    <div class="label">skip-backward-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-backward-circle"></i>
                    <div class="label">skip-backward-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-backward-fill"></i>
                    <div class="label">skip-backward-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-backward"></i>
                    <div class="label">skip-backward</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-end-btn-fill"></i>
                    <div class="label">skip-end-btn-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-end-btn"></i>
                    <div class="label">skip-end-btn</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-end-circle-fill"></i>
                    <div class="label">skip-end-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-end-circle"></i>
                    <div class="label">skip-end-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-end-fill"></i>
                    <div class="label">skip-end-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-end"></i>
                    <div class="label">skip-end</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-forward-btn-fill"></i>
                    <div class="label">skip-forward-btn-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-forward-btn"></i>
                    <div class="label">skip-forward-btn</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-forward-circle-fill"></i>
                    <div class="label">skip-forward-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-forward-circle"></i>
                    <div class="label">skip-forward-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-forward-fill"></i>
                    <div class="label">skip-forward-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-forward"></i>
                    <div class="label">skip-forward</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-start-btn-fill"></i>
                    <div class="label">skip-start-btn-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-start-btn"></i>
                    <div class="label">skip-start-btn</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-start-circle-fill"></i>
                    <div class="label">skip-start-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-start-circle"></i>
                    <div class="label">skip-start-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-start-fill"></i>
                    <div class="label">skip-start-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skip-start"></i>
                    <div class="label">skip-start</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-skype"></i>
                    <div class="label">skype</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-slack"></i>
                    <div class="label">slack</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-slash-circle-fill"></i>
                    <div class="label">slash-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-slash-circle"></i>
                    <div class="label">slash-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-slash-lg"></i>
                    <div class="label">slash-lg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-slash-square-fill"></i>
                    <div class="label">slash-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-slash-square"></i>
                    <div class="label">slash-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-slash"></i>
                    <div class="label">slash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sliders"></i>
                    <div class="label">sliders</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-smartwatch"></i>
                    <div class="label">smartwatch</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-snow"></i>
                    <div class="label">snow</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-snow2"></i>
                    <div class="label">snow2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-snow3"></i>
                    <div class="label">snow3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-alpha-down-alt"></i>
                    <div class="label">sort-alpha-down-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-alpha-down"></i>
                    <div class="label">sort-alpha-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-alpha-up-alt"></i>
                    <div class="label">sort-alpha-up-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-alpha-up"></i>
                    <div class="label">sort-alpha-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-down-alt"></i>
                    <div class="label">sort-down-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-down"></i>
                    <div class="label">sort-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-numeric-down-alt"></i>
                    <div class="label">sort-numeric-down-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-numeric-down"></i>
                    <div class="label">sort-numeric-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-numeric-up-alt"></i>
                    <div class="label">sort-numeric-up-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-numeric-up"></i>
                    <div class="label">sort-numeric-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-up-alt"></i>
                    <div class="label">sort-up-alt</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sort-up"></i>
                    <div class="label">sort-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-soundwave"></i>
                    <div class="label">soundwave</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-speaker-fill"></i>
                    <div class="label">speaker-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-speaker"></i>
                    <div class="label">speaker</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-speedometer"></i>
                    <div class="label">speedometer</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-speedometer2"></i>
                    <div class="label">speedometer2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-spellcheck"></i>
                    <div class="label">spellcheck</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-square-fill"></i>
                    <div class="label">square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-square-half"></i>
                    <div class="label">square-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-square"></i>
                    <div class="label">square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stack"></i>
                    <div class="label">stack</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-star-fill"></i>
                    <div class="label">star-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-star-half"></i>
                    <div class="label">star-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-star"></i>
                    <div class="label">star</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stars"></i>
                    <div class="label">stars</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stickies-fill"></i>
                    <div class="label">stickies-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stickies"></i>
                    <div class="label">stickies</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sticky-fill"></i>
                    <div class="label">sticky-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sticky"></i>
                    <div class="label">sticky</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stop-btn-fill"></i>
                    <div class="label">stop-btn-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stop-btn"></i>
                    <div class="label">stop-btn</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stop-circle-fill"></i>
                    <div class="label">stop-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stop-circle"></i>
                    <div class="label">stop-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stop-fill"></i>
                    <div class="label">stop-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stop"></i>
                    <div class="label">stop</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stoplights-fill"></i>
                    <div class="label">stoplights-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stoplights"></i>
                    <div class="label">stoplights</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stopwatch-fill"></i>
                    <div class="label">stopwatch-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-stopwatch"></i>
                    <div class="label">stopwatch</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-subtract"></i>
                    <div class="label">subtract</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-suit-club-fill"></i>
                    <div class="label">suit-club-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-suit-club"></i>
                    <div class="label">suit-club</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-suit-diamond-fill"></i>
                    <div class="label">suit-diamond-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-suit-diamond"></i>
                    <div class="label">suit-diamond</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-suit-heart-fill"></i>
                    <div class="label">suit-heart-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-suit-heart"></i>
                    <div class="label">suit-heart</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-suit-spade-fill"></i>
                    <div class="label">suit-spade-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-suit-spade"></i>
                    <div class="label">suit-spade</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sun-fill"></i>
                    <div class="label">sun-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sun"></i>
                    <div class="label">sun</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sunglasses"></i>
                    <div class="label">sunglasses</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sunrise-fill"></i>
                    <div class="label">sunrise-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sunrise"></i>
                    <div class="label">sunrise</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sunset-fill"></i>
                    <div class="label">sunset-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-sunset"></i>
                    <div class="label">sunset</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-symmetry-horizontal"></i>
                    <div class="label">symmetry-horizontal</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-symmetry-vertical"></i>
                    <div class="label">symmetry-vertical</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-table"></i>
                    <div class="label">table</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tablet-fill"></i>
                    <div class="label">tablet-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tablet-landscape-fill"></i>
                    <div class="label">tablet-landscape-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tablet-landscape"></i>
                    <div class="label">tablet-landscape</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tablet"></i>
                    <div class="label">tablet</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tag-fill"></i>
                    <div class="label">tag-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tag"></i>
                    <div class="label">tag</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tags-fill"></i>
                    <div class="label">tags-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tags"></i>
                    <div class="label">tags</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telegram"></i>
                    <div class="label">telegram</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-fill"></i>
                    <div class="label">telephone-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-forward-fill"></i>
                    <div class="label">telephone-forward-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-forward"></i>
                    <div class="label">telephone-forward</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-inbound-fill"></i>
                    <div class="label">telephone-inbound-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-inbound"></i>
                    <div class="label">telephone-inbound</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-minus-fill"></i>
                    <div class="label">telephone-minus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-minus"></i>
                    <div class="label">telephone-minus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-outbound-fill"></i>
                    <div class="label">telephone-outbound-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-outbound"></i>
                    <div class="label">telephone-outbound</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-plus-fill"></i>
                    <div class="label">telephone-plus-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-plus"></i>
                    <div class="label">telephone-plus</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-x-fill"></i>
                    <div class="label">telephone-x-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone-x"></i>
                    <div class="label">telephone-x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-telephone"></i>
                    <div class="label">telephone</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-terminal-fill"></i>
                    <div class="label">terminal-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-terminal"></i>
                    <div class="label">terminal</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-text-center"></i>
                    <div class="label">text-center</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-text-indent-left"></i>
                    <div class="label">text-indent-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-text-indent-right"></i>
                    <div class="label">text-indent-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-text-left"></i>
                    <div class="label">text-left</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-text-paragraph"></i>
                    <div class="label">text-paragraph</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-text-right"></i>
                    <div class="label">text-right</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-textarea-resize"></i>
                    <div class="label">textarea-resize</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-textarea-t"></i>
                    <div class="label">textarea-t</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-textarea"></i>
                    <div class="label">textarea</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-thermometer-half"></i>
                    <div class="label">thermometer-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-thermometer-high"></i>
                    <div class="label">thermometer-high</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-thermometer-low"></i>
                    <div class="label">thermometer-low</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-thermometer-snow"></i>
                    <div class="label">thermometer-snow</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-thermometer-sun"></i>
                    <div class="label">thermometer-sun</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-thermometer"></i>
                    <div class="label">thermometer</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-three-dots-vertical"></i>
                    <div class="label">three-dots-vertical</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-three-dots"></i>
                    <div class="label">three-dots</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-toggle-off"></i>
                    <div class="label">toggle-off</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-toggle-on"></i>
                    <div class="label">toggle-on</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-toggle2-off"></i>
                    <div class="label">toggle2-off</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-toggle2-on"></i>
                    <div class="label">toggle2-on</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-toggles"></i>
                    <div class="label">toggles</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-toggles2"></i>
                    <div class="label">toggles2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tools"></i>
                    <div class="label">tools</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tornado"></i>
                    <div class="label">tornado</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-translate"></i>
                    <div class="label">translate</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-trash-fill"></i>
                    <div class="label">trash-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-trash"></i>
                    <div class="label">trash</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-trash2-fill"></i>
                    <div class="label">trash2-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-trash2"></i>
                    <div class="label">trash2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tree-fill"></i>
                    <div class="label">tree-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tree"></i>
                    <div class="label">tree</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-triangle-fill"></i>
                    <div class="label">triangle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-triangle-half"></i>
                    <div class="label">triangle-half</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-triangle"></i>
                    <div class="label">triangle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-trophy-fill"></i>
                    <div class="label">trophy-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-trophy"></i>
                    <div class="label">trophy</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tropical-storm"></i>
                    <div class="label">tropical-storm</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-truck-flatbed"></i>
                    <div class="label">truck-flatbed</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-truck"></i>
                    <div class="label">truck</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tsunami"></i>
                    <div class="label">tsunami</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tv-fill"></i>
                    <div class="label">tv-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-tv"></i>
                    <div class="label">tv</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-twitch"></i>
                    <div class="label">twitch</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-twitter"></i>
                    <div class="label">twitter</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-type-bold"></i>
                    <div class="label">type-bold</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-type-h1"></i>
                    <div class="label">type-h1</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-type-h2"></i>
                    <div class="label">type-h2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-type-h3"></i>
                    <div class="label">type-h3</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-type-italic"></i>
                    <div class="label">type-italic</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-type-strikethrough"></i>
                    <div class="label">type-strikethrough</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-type-underline"></i>
                    <div class="label">type-underline</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-type"></i>
                    <div class="label">type</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-ui-checks-grid"></i>
                    <div class="label">ui-checks-grid</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-ui-checks"></i>
                    <div class="label">ui-checks</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-ui-radios-grid"></i>
                    <div class="label">ui-radios-grid</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-ui-radios"></i>
                    <div class="label">ui-radios</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-umbrella-fill"></i>
                    <div class="label">umbrella-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-umbrella"></i>
                    <div class="label">umbrella</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-union"></i>
                    <div class="label">union</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-unlock-fill"></i>
                    <div class="label">unlock-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-unlock"></i>
                    <div class="label">unlock</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-upc-scan"></i>
                    <div class="label">upc-scan</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-upc"></i>
                    <div class="label">upc</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-upload"></i>
                    <div class="label">upload</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-vector-pen"></i>
                    <div class="label">vector-pen</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-view-list"></i>
                    <div class="label">view-list</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-view-stacked"></i>
                    <div class="label">view-stacked</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-vinyl-fill"></i>
                    <div class="label">vinyl-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-vinyl"></i>
                    <div class="label">vinyl</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-voicemail"></i>
                    <div class="label">voicemail</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-volume-down-fill"></i>
                    <div class="label">volume-down-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-volume-down"></i>
                    <div class="label">volume-down</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-volume-mute-fill"></i>
                    <div class="label">volume-mute-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-volume-mute"></i>
                    <div class="label">volume-mute</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-volume-off-fill"></i>
                    <div class="label">volume-off-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-volume-off"></i>
                    <div class="label">volume-off</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-volume-up-fill"></i>
                    <div class="label">volume-up-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-volume-up"></i>
                    <div class="label">volume-up</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-vr"></i>
                    <div class="label">vr</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wallet-fill"></i>
                    <div class="label">wallet-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wallet"></i>
                    <div class="label">wallet</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wallet2"></i>
                    <div class="label">wallet2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-watch"></i>
                    <div class="label">watch</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-water"></i>
                    <div class="label">water</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-whatsapp"></i>
                    <div class="label">whatsapp</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wifi-1"></i>
                    <div class="label">wifi-1</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wifi-2"></i>
                    <div class="label">wifi-2</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wifi-off"></i>
                    <div class="label">wifi-off</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wifi"></i>
                    <div class="label">wifi</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wind"></i>
                    <div class="label">wind</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-window-dock"></i>
                    <div class="label">window-dock</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-window-sidebar"></i>
                    <div class="label">window-sidebar</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-window"></i>
                    <div class="label">window</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-wrench"></i>
                    <div class="label">wrench</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-circle-fill"></i>
                    <div class="label">x-circle-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-circle"></i>
                    <div class="label">x-circle</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-diamond-fill"></i>
                    <div class="label">x-diamond-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-diamond"></i>
                    <div class="label">x-diamond</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-lg"></i>
                    <div class="label">x-lg</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-octagon-fill"></i>
                    <div class="label">x-octagon-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-octagon"></i>
                    <div class="label">x-octagon</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-square-fill"></i>
                    <div class="label">x-square-fill</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x-square"></i>
                    <div class="label">x-square</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-x"></i>
                    <div class="label">x</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-youtube"></i>
                    <div class="label">youtube</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-zoom-in"></i>
                    <div class="label">zoom-in</div>
                    </div>
                    <div class="icon">
                    <i onclick="chooseIcon(this);" class="bi-zoom-out"></i>
                    <div class="label">zoom-out</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('IconSearch').addEventListener('keyup', (event)=>{ 
            const search = document.getElementById('IconSearch').value;
            const icons = [...document.querySelectorAll('.iconslist i')];
            icons.forEach(function(icon) {
                if (icon.classList[0].includes(search)) {
                    icon.parentNode.style.display = 'block';
                } else {
                    icon.parentNode.style.display = 'none';
                }
            });
         }); 
    });
    
    function chooseIcon(e) {
        document.getElementById('mn_icon').value = 'bi-' + e.className.split('bi-')[1];
        var modal = bootstrap.Modal.getInstance(document.getElementById('iconsModal'));
        modal.hide();
    }
</script>