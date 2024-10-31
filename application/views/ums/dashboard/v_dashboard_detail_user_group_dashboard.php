<style>
    .list-group-item:first-child {
        border-top-left-radius: unset;
        border-top-right-radius: unset;
    }
    #groups {
        max-height: 70vh; /* Sets the height of the element to 100% of the viewport height */
        overflow-y: auto; /* Enables vertical scrolling if the content overflows */
    }
</style>

<!-- Tab & Table -->
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button accordion-button-table" type="button">
                            <i class="bi-people icon-menu"></i><span>กลุ่มผู้ใช้</span>
                        </button>
                    </h2>
                    <div id="groups" class="accordion-collapse collapse show">
                            <div class="list-group list-group-alternate mb-n">
                                <?php 
                                    $i = 0;
                                    foreach ($unique_groups as $row) { 
                                        $count = 0;
                                        foreach ($rpt_users_groups_system as $rpt) {
                                            if($rpt['gp_id'] == $row['gp_id'])
                                                $count++;
                                        }
                                ?>
                                    <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab-<?php echo $i; ?>" class="list-group-item <?php echo $i == 0 ? 'active' : ''; ?>">
                                        <?php echo $row['gp_name_th'] . " ($count)"; ?>
                                    </a>
                                <?php $i++; } ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content" id="profile_user_type">
            <?php 
                $j = 0;
                foreach ($unique_groups as $row) { 
                    $users = [];
                    foreach ($rpt_users_groups_system as $rpt) {
                        if($rpt['gp_id'] == $row['gp_id'])
                            $users[] = $rpt;
                    }
            ?>
                <div class="tab-pane fade row g-1 <?php echo $j == 0 ? 'show active' : ''; ?>" id="tab-<?php echo $j; ?>" role="tabpanel">
                    <div class="card">
                        <div class="accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button accordion-button-table" type="button">
                                        <i class="bi-window-dock icon-menu"></i><span><?php echo $row['st_name_th']; ?><i class="bi-caret-right-fill icon-menu"></i><?php echo $row['gp_name_th']; ?></span><span class="badge bg-success"><?php echo count($users); ?></span>
                                    </button>
                                </h2>
                                <div id="collapseShow" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <table class="table datatable" width="100%">
                                            <thead>
                                                <tr>				
                                                    <th width="5%" class="text-center">#</th>
                                                    <!-- <th>หน่วยงาน</th> -->
                                                    <th width="25%">ชื่อ - สกุล</th>
                                                    <th width="20%">ชื่อเข้าสู่ระบบ</th>
                                                    <th width="25%" class="text-center">ได้รับสิทธิ์เมื่อวันที่</th>
                                                    <th width="25%" class="text-center">เข้าสู่ระบบล่าสุด</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i = 0;
                                                    foreach ($users as $user) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i+1; ?></td>
                                                    <!-- <td>แอดมิน ระบบ</td> -->
                                                    <td><?php echo $user['us_name']; ?></td>
                                                    <td><?php echo $user['us_username']; ?></td>
                                                    <td class="text-center"><?php echo convertToThaiYear($user['last_get_permission'], true); ?></td>
                                                    <td class="text-center"><?php echo convertToThaiYear($user['last_login'], true); ?></td>
                                                </tr>
                                                <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $j++; } ?>
        </div>
    </div>
</div>

<!-- Button -->
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Dashboard'">ย้อนกลับ</button>
    </div>
</div>