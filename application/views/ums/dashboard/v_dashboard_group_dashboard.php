<style>
    .card-icon i {
        font-size: 3rem;
        opacity: 0.5;
    }
    button.accordion-button {
        font-weight: normal;
    }
    .accordion-body .d-grid {
        max-width: 100%;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.25rem;
    }
    .accordion-body button.accordion-button:not(.collapsed) {
        color: var(--bs-primary);
    }
    .form-check:last-child, .no-group {
        margin-bottom: 0px;
    }
    .form-check-input:disabled~.form-check-label, .form-check-input[disabled]~.form-check-label {
        opacity: 1;
    }
</style>

<div class="row">
    <div class="d-flex justify-content-center">
        <div class="card card-button col-md-4 me-5" id="btn-people">
            <div class="card-body">
                <div class="card-icon rounded-circle float-start">
                    <i class="bi-people text-warning"></i>
                </div>
                <div class="float-end mt-3">
                    <h1>จำแนกบุคลากร</h1>
                </div>
            </div>
        </div>
        <div class="card card-button col-md-4" id="btn-systems">
            <div class="card-body">
                <div class="card-icon rounded-circle float-start">
                    <i class="bi-gear text-success"></i>
                </div>
                <div class="float-end mt-3">
                    <h1>จำแนกระบบ</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- จำแนกบุคลากร -->
<div class="card" id="card-people">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <div class="accordion-button accordion-button-table">
                    <div class="accordion-button-left">
                        <i class="bi-hdd-rack icon-menu"></i><span>รายงานสิทธิ์การใช้งาน (รายบุคคล)</span>
                    </div>
                    <div class="accordion-button-right">
                        <!-- <button class="btn buttons-excel btn-sm me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์ Excel ทั้งหมด" onclick="print_users('excel', '')" ><i class="bi-file-earmark-excel-fill"></i>  พิมพ์ Excel ทั้งหมด</button> -->
                        <button class="btn buttons-pdf btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์ PDF ทั้งหมด" onclick="print_users('pdf', '')" ><i class="bi-file-earmark-pdf-fill"></i>  พิมพ์ PDF ทั้งหมด</button>
                    </div>
                </div>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row g-3">
                        <?php $i = 0;
                            foreach($users as $row){ ?>
                            <div class="col-md-4">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header bg-warning-subtle d-flex" id="heading<?php echo "-us-" . $i+1; ?>">
                                            <div class="col-md-10">
                                                <button class="accordion-button collapsed bg-warning-subtle" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo "-us-" . $i+1; ?>" aria-expanded="false" aria-controls="collapse<?php echo "-us-" . $i+1; ?>">
                                                    <b><i class="bi-person icon-menu"></i><?php echo $row['us_name']; ?></b>
                                                </button>
                                            </div>
                                            <div class="col-md align-content-center">
                                                <!-- <i style="color: #4dc98f;" class="bi-file-earmark-excel-fill" onclick="print_users('excel', '<?php echo $row['us_id']; ?>')" data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์ Excel"></i> -->
                                                <i style="color: #ff6158;" class="bi-file-earmark-pdf-fill" onclick="print_users('pdf', '<?php echo $row['us_id']; ?>')" data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์ PDF"></i>
                                            </div>
                                        </h2>
                                        <div id="collapse<?php echo "-us-" . $i+1; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo "-us-" . $i+1; ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <?php if(empty($row['groups'])) { ?>
                                                    <p class="no-group text-center">ไม่มีรายการสิทธิ์</p>
                                                <?php } else {
                                                    $st_ids = [];
                                                    foreach($row['groups'] as $st){
                                                        $is_passed = true;
                                                        if (!in_array($st['st_id'], $st_ids)) {
                                                            $st_ids[] = $st['st_id'];
                                                            $is_passed = false;
                                                        }
                                                        if (!$is_passed) {
                                                            $j = 0; ?>
                                                            <b><p><i class="bi-window-dock me-1"></i> <?php echo $st['st_name_th']; ?></p></b>
                                                            <?php foreach($row['groups'] as $gp){
                                                                if($gp['gp_st_id'] == $st['st_id']) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="gp-<?php echo $i.'_'.$j; ?>" id="gp-<?php echo $i.'_'.$j; ?>" checked disabled>
                                                                        <label class="form-check-label" for="gp-<?php echo $i.'_'.$j; ?>"><?php echo $gp['gp_name_th'];?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php $j++; } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- จำแนกระบบ -->
<div class="card" id="card-systems" style="display: none;">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <div class="accordion-button accordion-button-table">
                    <div class="accordion-button-left">
                        <i class="bi-hdd-rack icon-menu"></i><span>รายงานสิทธิ์การใช้งาน (รายระบบ)</span>
                    </div>
                    <div class="accordion-button-right">
                        <!-- <button class="btn buttons-excel btn-sm me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์ Excel ทั้งหมด" onclick="print_systems('excel', '')" ><i class="bi-file-earmark-excel-fill"></i>  พิมพ์ Excel ทั้งหมด</button> -->
                        <button class="btn buttons-pdf btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์ PDF ทั้งหมด" onclick="print_systems('pdf', '')" ><i class="bi-file-earmark-pdf-fill"></i>  พิมพ์ PDF ทั้งหมด</button>
                    </div>
                </div>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row g-3">
                        <?php $i = 0;
                            foreach($systems as $row){ ?>
                            <div class="col-md-4">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header bg-warning-subtle d-flex" id="heading<?php echo "-st-".$i+1; ?>">
                                            <div class="col-md-10">
                                                <button class="accordion-button collapsed bg-warning-subtle" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo "-st-".$i+1; ?>" aria-expanded="false" aria-controls="collapse<?php echo "-st-".$i+1; ?>">
                                                    <b><i class="bi-window-dock icon-menu"></i><?php echo $row['st_name_th']; ?></b>
                                                </button>
                                            </div>
                                                <!-- <i style="color: #4dc98f;" class="bi-file-earmark-excel-fill" onclick="print_systems('excel', '<?php echo $row['st_id']; ?>')" data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์ Excel"></i> -->
                                                <i style="color: #ff6158;" class="bi-file-earmark-pdf-fill" onclick="print_systems('pdf', '<?php echo $row['st_id']; ?>')" data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์ PDF"></i>
                                        </h2>
                                        <div id="collapse<?php echo "-st-".$i+1; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo "-st-".$i+1; ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <?php if(empty($row['groups'])) { ?>
                                                    <p class="no-group text-center">ไม่มีรายการสิทธิ์</p>
                                                <?php } else {
                                                    foreach($row['groups'] as $gp){ ?>
                                                        <b><i class="bi-people-fill icon-menu"></i><?php echo $gp['gp_name_th']; ?></b>
                                                        <?php if(empty($gp['users'])) { ?>
                                                            <p class="no-group ms-5"> - ไม่มีรายการผู้ใช้ -</p>
                                                        <?php } else { ?>
                                                            <div class="ms-4">
                                                                <?php foreach($gp['users'] as $us){ ?>
                                                                    <i class="bi-person-fill icon-menu"></i><?php echo $us['us_name']; ?><br>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('btn-people').onclick = function () {
            $("#card-people").fadeIn('slow');
            $("#card-systems").hide();
        }

        document.getElementById('btn-systems').onclick = function () {
            $("#card-systems").fadeIn('slow');
            $("#card-people").hide();
        }
    });
    
    function print_users(type, us_id) {
        let url = '<?php echo base_url()."index.php/ums/Dashboard_group/Dashboard_group_export_users/"?>' + type + '/' + us_id;
        window.open(url, "_blank");
    }
    function print_systems(type, st_id) {
        let url = '<?php echo base_url()."index.php/ums/Dashboard_group/Dashboard_group_export_systems/"?>' + type + '/' + st_id;
        window.open(url, "_blank");
    }
</script>