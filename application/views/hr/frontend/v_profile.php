<meta name="viewport" content="width=device-width, initial-scale=0.3">
<style>
    .table {
        table-layout: fixed;
        /* บังคับให้แบ่งตามสัดส่วน */
        word-break: break-word;
        /* ตัดคำในกรณีข้อความยาวเกิน */
    }

    thead th {
        background-color: #fff3cd;
        /* สีพื้นหลังหัวข้อ */
    }

    tbody tr:nth-child(odd) {
        background-color: #fff8e1;
        /* สีพื้นหลังแถวสลับ */
    }

    @media (min-width: 1473px) {
        .logo img {
            max-height: 60px;
        }

        .font-24 {
            font-size: 20px !important;
        }
    }
    @media (max-width: 600px) {
        .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
            max-width: 100%;
        }
        .header {
          display: none !important;
        }
        .topbar2 {
          top: 0px;
        }
        .col-md-12.nav_topbar {
            display: none;
        }
        a.nav-link.nav-profile.d-flex.align-items-center.pe-0 {
            display: none !important;
        }
        .card.bg-white {
            margin-top: -150px !important;
        }
        .row.ps-lg3.mt-2 {
            zoom: 1.2; /* ใช้สำหรับเบราว์เซอร์ที่รองรับ */
            transform: scale(1.5); /* ใช้สำหรับ iOS*/
            transform-origin: top left; /* ตั้งจุดเริ่มต้น */
       }
        .card-body.p-5 {
            height: 100vh;
        }

    } 
</style>

<div class="row topbar">
    <div class="col-md-12 nav_topbar">
        &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
        <?php if (!in_array($ps_info->hire_is_medical, ['SM', 'T', 'A', 'N'])) : ?>
            <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
            <a href="<?php echo $this->config->item('base_frontend_url') . 'index.php/staff/Directory_profile'; ?>">
                &nbsp;<i class="bi bi-person-bounding-box"></i>&nbsp;
                <span class='font-16'>Staff Directory</span>
            </a>
        <?php else: ?>
            <a href="<?php echo $this->config->item('base_frontend_url') . 'index.php/hr/profile/Profile_staff'; ?>">
                &nbsp;<i class="bi bi-person-bounding-box"></i>&nbsp;
                <span class='font-16'>Staff Profile</span>
            </a>
        <?php endif; ?>
        &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
        &nbsp;<i class="bi bi-person-bounding-box text-white"></i>&nbsp;
        <span class='text-white font-16'>Profile</span>
    </div>
</div>
<div class="row topbar2">
    <div class="pattern-square2"></div>
    <div class="page-title-overlap bg-accent pt-4 container" style="height: 150px;"></div>
</div>
<div class="row justify-content-md-center">
    <div class="col-12 col-sm-12 col-md-12 mt-5 ">
        <div class="card bg-white ">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col col-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="card">
                            <div class="position-relative rounded-5">
                                <img id="profile_picture" class="card-img-top rounded-2" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($ps_info->psd_picture != '' ? $ps_info->psd_picture : "default.png")); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="ps-xl-5 ps-lg-3">
                            <h2 class="h3 mb-3"><?= $ps_info->ps_fullname ?></h2>

                            <h2 class="h5 mb-3"><?php
                                                                echo $ps_info->hire_abbr;
                                                                $spcl_positions = json_decode($ps_info->spcl_position, true);
                                                                $num = 0;
                                                                foreach ($spcl_positions as $key => $spcl) { ?>
                                    <?php if (is_string($spcl)) {
                                                                        $spcl = json_decode($spcl, true);
                                                                    } 
                                                                    if($num == 0 && $spcl['spcl_name'] != ""){
                                                                        echo " : ";
                                                                    }
                                                                    ?>

                                                                    
                                    <?= (count($spcl_positions) >= 1 ? $key != (count($spcl_positions) - 1) ? $spcl['spcl_name'] . ',' : $spcl['spcl_name'] : '&nbsp;') ?><?php } ?></h2>
                            <h2 class="h5 mb-3"><?= $ps_info->pos_desc ?></h2>
                        </div>
                        <div class="row ps-xl-5 ps-lg-3 font-18 align-items-center mb-5 mt-5">
                            <div class="col col-4 col-sm-4 col-md-4 col-lg-3 ms-1">
                                ประสบการณ์ทำงาน
                            </div>
                            <div class="col col-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="text-light rounded p-2 text-center" style="background-color: #146C94;"><?= $work_age['year'] ?> ปี</div>
                            </div>
                            <div class="col col-3 col-sm-3 col-md-3 col-lg-2">
                                <div class="text-light rounded p-2 text-center" style="background-color: #3795BD;"><?= $work_age['months'] ?> เดือน</div>
                            </div>
                            <!-- <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="bg-info-subtle text-light rounded p-2 text-dark text-center">- วัน</div>
                            </div> -->
                        </div>
                        <?php
                        // อาร์เรย์ของชื่อเดือนภาษาไทย
                        $thai_months = array(
                            1 => 'มกราคม',
                            'กุมภาพันธ์',
                            'มีนาคม',
                            'เมษายน',
                            'พฤษภาคม',
                            'มิถุนายน',
                            'กรกฎาคม',
                            'สิงหาคม',
                            'กันยายน',
                            'ตุลาคม',
                            'พฤศจิกายน',
                            'ธันวาคม'
                        );

                        // ดึงเดือนและปีปัจจุบัน
                        $current_month = (int)date('m'); // เดือนในรูปแบบตัวเลข
                        $current_year = (int)date('Y') + 543; // ปี พ.ศ. (ค.ศ. + 543)

                        ?>
                        <?php if ($doctor_timework_current != null && count($doctor_timework_current) > 0) : ?>
                            <div class="row ps-xl-2 ps-lg-3" style="margin-top: 3rem;">
                                <div class="col-12">
                                    <button class="btn btn-info btn-lg mb-3 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCurrent" aria-expanded="false" aria-controls="collapseExample_1">
                                        ตารางแพทย์ออกตรวจ ประจำเดือน <?php echo $thai_months[$current_month] . ' พ.ศ. ' . $current_year; ?>
                                    </button>
                                </div>
                                <!-- <div class="col-12">
                              <a href="<?php echo site_url(); ?>/que/frontend/Queuing_form_step1" class="btn btn-primary-search btn-lg mb-3 w-100">นัดหมายแพทย์</a>
                          </div> -->
                            </div>
                            <div class="row ps-xl-2 ps-lg-3 mt-3">
                                <div class="col">
                                    <div class="collapse show" id="collapseCurrent">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="position-relative d-flex align-items-center bg-success bg-opacity-10 border rounded border-success mb-4 p-2">
                                                    <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle lh-1 h-20px">
                                                        <i class="bi bi-calendar-plus-fill text-success fs-3"></i>
                                                    </div>
                                                    <div class="me-md-3 mb-3 mb-md-0">
                                                        <h6 class="mb-1 fw-bold" style="line-height: 1.6;">วันปัจจุบัน<br>
                                                            <span class="font-20"><?= abbreDate5(date('Y-m-d')) ?></span>
                                                        </h6>
                                                        <h6 class="mb-2 font-18">
                                                            <?php foreach ($person_department_topic as $key => $dp) { ?>
                                                                <div class="row mt-3">
                                                                    <div class="col-2">
                                                                        <span class="badge badge-warning font-18" <?= $dp->dp_id % 2 != 0 ? 'style="background: #9d6c01;"' : 'style="background: #006491;"' ?>> </span>
                                                                    </div>
                                                                    <div class="col-10 font-14">
                                                                        <?php if (isset($today_timework[$dp->dp_id]['timework'])) : ?>
                                                                            <?= preg_replace('/\s?น\./u', '', $today_timework[$dp->dp_id]['timework']) ?>
                                                                        <?php else: ?>
                                                                            ไม่ออกตรวจ
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <!-- <span class="badge badge-warning font-18 mt-3" style="background: #9d6c01;"> </span> 15.00 - 16.00 <br> -->
                                                                <!-- <span class="badge badge-primary font-18 mt-3" style="background: #006491;"> </span> 16:30 - 20:00 -->
                                                            <?php } ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="position-relative d-flex align-items-center bg-info bg-opacity-10 border rounded border-info mb-4 p-2">
                                                    <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle lh-1 h-20px">
                                                        <i class="bi bi-calendar2-heart-fill text-info fs-3"></i>
                                                    </div>
                                                    <div class="me-md-3 mb-3 mb-md-0">
                                                        <h6 class="mb-2 fw-bold" style="line-height: 1.6;">จำนวนวันออกตรวจ<br>
                                                            <span class="font-20"><?= abbreDate6(date('Y-m-d')) ?></span>
                                                        </h6>
                                                        <h6 class="mb-2 font-14">
                                                            <?php foreach ($person_department_topic as $key => $dp) { ?>
                                                                <?php if (isset($days_count_current[$dp->dp_id])) { ?>
                                                                    <span class="badge badge-warning font-18 mt-2" <?= $dp->dp_id % 2 != 0 ? 'style="background: #9d6c01; "' : 'style="background: #006491;"' ?>> </span> <?= $days_count_current[$dp->dp_id] ?> วัน<br>
                                                            <?php }
                                                            } ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $time_work_index = 0;
                                            if (count($today_timework) > 0) {
                                                foreach ($today_timework as $key => $value) {
                                                    $time_work_index = $key;
                                                    break;
                                                }
                                            }
                                            ?>
                                            <div class="col-9 ps-1">
                                                <div class="current-weeks">
                                                    <?php foreach ($doctor_timework_current as $key => $week) { ?>
                                                        <div class="week-container" id="week-<?= $key ?>" style="<?= isset($today_timework[$time_work_index]['week_of_month']) ? ($key === $today_timework[$time_work_index]['week_of_month'] ? '' : 'display:none;') : '' ?>">
                                                            <div class="d-flex mb-2 px-2">
                                                                <?php if ($key != 1) : ?>
                                                                    <button class="btn btn-outline-success me-3 prev-week" data-week="<?= $key ?>">
                                                                        <i class="bi bi-chevron-left fw-bold me-2"></i>สัปดาห์ก่อนหน้า
                                                                    </button>
                                                                <?php endif; ?>
                                                                <?php if ($key != 5) : ?>
                                                                    <button class="btn btn-outline-success next-week" data-week="<?= $key ?>">
                                                                        สัปดาห์ถัดไป<i class="bi bi-chevron-right fw-bold ms-2"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                            <table class="table border-warning">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="font-18 w-20" style="color:#006e64;">สัปดาห์ที่ <?= $key ?></th>
                                                                        <?php foreach ($person_department_topic as $key => $dp) { ?>
                                                                            <th <?= $key == 0 ? 'class="text-left"' : '' ?>>
                                                                                <span class="badge badge-warning font-16" <?= ($dp->dp_id % 2 != 0 ? 'style="background: #9d6c01;"' : 'style="background: #006491;"') ?>><?= $dp->dp_name_th ?></span>
                                                                            </th>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $anoth_month = 0;
                                                                    $another_text = '';
                                                                    $count_dp = count($person_department_topic) - 1;
                                                                    $index = 0;
                                                                    foreach ($week as $day => $data) {
                                                                        $index++;
                                                                        $td_date = '';
                                                                        if ($data[array_key_first($data)]['timework'] == '0') {
                                                                            $anoth_month++;
                                                                            $another_text = $data[array_key_first($data)]['days'][0];
                                                                            if ($index == 7) {
                                                                                $td_date = '<td  colspan="' . ($count_dp + 2) . '" class="font-20 fw-bold text-center pt-4" style="background-color:#c3f7ff;">' . $another_text . '</td>';
                                                                            } else {
                                                                                continue;
                                                                            }
                                                                        } else {
                                                                            if ($anoth_month > 0) {
                                                                                $td_date = '<tr><td  colspan="' . ($count_dp + 2) . '" class="font-20 fw-bold text-center pt-4" style="background-color:#c3f7ff;">' . $another_text . '</td><tr>';
                                                                                $anoth_month = 0;
                                                                            }
                                                                        }
                                                                    ?>
                                                                        <tr>
                                                                            <?php
                                                                            if ($anoth_month == 0) {
                                                                                foreach ($person_department_topic as $key => $dp) {
                                                                                    if ($key == 0) {
                                                                                        $td_date .= ' <td ' . ($data[array_key_first($data)]['is_today'] == 1 ? 'style="background-color:#acdfc8;"' : '') . ' class="font-16 fw-bold">' . $day . ' (' . ($data[$dp->dp_id]['day']) . ') </td>';
                                                                                    }
                                                                                    $td_date .=   '<td ' . ($data[array_key_first($data)]['is_today'] == 1 ? 'style="background-color:#acdfc8;"' : '') . '>
                                                                                <div class="row"> <div class="col-1"><span class="badge badge-warning font-16" ' . ($dp->dp_id % 2 != 0 ? 'style="background: #9d6c01;"' : 'style="background: #006491;"') . '> </span> </div> <div class="col-10">' . $data[$dp->dp_id]['timework'] . '
                                                                            </div></div></td>';
                                                                                }
                                                                            } ?>
                                                                            <?= $td_date ?>
                                                                        </tr>
                                                                    <?php
                                                                    } ?>
                                                                    <!-- <tr class="pt-5">
                                                                    <td colspan="3" class="font-20 fw-bold text-center pt-4" style="background-color:#c3f7ff;">
                                                                        สิ้นสุดเดือน ต.ค. 67
                                                                    </td>
                                                                </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($doctor_timework_previous != null && count($doctor_timework_previous) > 0) : ?>
                            <div class="row ps-xl-2 ps-lg-3">
                                <div class="col-12">
                                    <button class="btn btn-info btn-lg mb-3 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrevious" aria-expanded="false" aria-controls="collapseExample_1">
                                        ตารางแพทย์ออกตรวจ ประจำเดือน <?php echo $thai_months[$current_month + 1] . ' พ.ศ. ' . $current_year; ?>
                                    </button>
                                </div>
                                <!-- <div class="col-12">
                              <a href="<?php echo site_url(); ?>/que/frontend/Queuing_form_step1" class="btn btn-primary-search btn-lg mb-3 w-100">นัดหมายแพทย์</a>
                          </div> -->
                            </div>
                            <div class="row ps-xl-2 ps-lg-3 mt-3">
                                <div class="col">
                                    <div class="collapse" id="collapsePrevious">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="position-relative d-flex align-items-center bg-info bg-opacity-10 border rounded border-info mb-4 p-2">
                                                    <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle lh-1 h-20px">
                                                        <i class="bi bi-calendar2-heart-fill text-info fs-3"></i>
                                                    </div>
                                                    <div class="me-md-3 mb-3 mb-md-0">
                                                        <h6 class="mb-2 fw-bold" style="line-height: 1.6;">จำนวนวันออกตรวจ<br>
                                                            <span class="font-20"><?= abbreDate6(date('Y-m-d', strtotime('+1 month'))) ?></span>
                                                        </h6>
                                                        <h6 class="mb-2 font-18">
                                                            <?php foreach ($person_department_topic as $key => $dp) { ?>
                                                                <?php if (isset($days_count_previous[$dp->dp_id])) { ?>
                                                                    <span class="badge badge-warning font-18 mt-2" <?= $dp->dp_id % 2 != 0 ? 'style="background: #9d6c01;"' : 'style="background: #006491;"' ?>> </span> <span class="font-14"> <?= $days_count_previous[$dp->dp_id] ?> วัน</span><br>
                                                            <?php }
                                                            } ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9 ps-1">
                                                <div class="previous-weeks">
                                                    <?php foreach ($doctor_timework_previous as $key => $week) { ?>
                                                        <div class="week-container" id="week-pe-<?= $key ?>" style="<?= $key === 1 ? '' : 'display:none;' ?>">
                                                            <div class="d-flex mb-2 px-2">
                                                                <?php if ($key != 1) : ?>
                                                                    <button class="btn btn-outline-success me-3 prev-week" data-week="<?= $key ?>">
                                                                        <i class="bi bi-chevron-left fw-bold me-2"></i>สัปดาห์ก่อนหน้า
                                                                    </button>
                                                                <?php endif; ?>
                                                                <?php if ($key != 5) : ?>
                                                                    <button class="btn btn-outline-success next-week" data-week="<?= $key ?>">
                                                                        สัปดาห์ถัดไป<i class="bi bi-chevron-right fw-bold ms-2"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                            <table class="table border-warning">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="font-18 w-20" style="color:#006e64;">สัปดาห์ที่ <?= $key ?></th>
                                                                        <?php foreach ($person_department_topic as $key => $dp) { ?>
                                                                            <th <?= $key == 0 ? 'class="text-left"' : '' ?>>
                                                                                <span class="badge badge-warning font-16" <?= ($dp->dp_id % 2 != 0 ? 'style="background: #9d6c01;"' : 'style="background: #006491;"') ?>><?= $dp->dp_name_th ?></span>
                                                                            </th>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $anoth_month = 0;
                                                                    $another_text = '';
                                                                    $count_dp = count($person_department_topic) - 1;
                                                                    $index = 0;
                                                                    foreach ($week as $day => $data) {
                                                                        $index++;
                                                                        $td_date = '';
                                                                        if ($data[array_key_first($data)]['timework'] == '0') {
                                                                            $anoth_month++;
                                                                            $another_text = $data[array_key_first($data)]['days'][0];
                                                                            if ($index == 7) {
                                                                                $td_date = '<td colspan="' . ($count_dp + 2) . '" class="font-20 fw-bold text-center pt-4" style="background-color:#c3f7ff;">' . $another_text . '</td>';
                                                                            } else {
                                                                                continue;
                                                                            }
                                                                        } else {
                                                                            if ($anoth_month > 0) {
                                                                                $td_date = '<tr><td  colspan="' . ($count_dp + 2) . '" class="font-20 fw-bold text-center pt-4" style="background-color:#c3f7ff;">' . $another_text . '</td><tr>';
                                                                                $anoth_month = 0;
                                                                            }
                                                                        }
                                                                    ?>
                                                                        <tr>
                                                                            <?php
                                                                            if ($anoth_month == 0) {
                                                                                foreach ($person_department_topic as $key => $dp) {
                                                                                    if (isset($data[$dp->dp_id])) {
                                                                                        if ($key == 0) {
                                                                                            $td_date .= ' <td ' . ($data[array_key_first($data)]['is_today'] == 1 ? 'style="background-color:#acdfc8;"' : '') . ' class="font-16 fw-bold">' . $day . ' (' . ($data[$dp->dp_id]['day']) . ') </td>';
                                                                                        }
                                                                                        $td_date .=   '<td ' . ($data[array_key_first($data)]['is_today'] == 1 ? 'style="background-color:#acdfc8;"' : '') . '>
                                                                                <div class="row"> <div class="col-1"><span class="badge badge-warning font-16" ' . ($dp->dp_id % 2 != 0 ? 'style="background: #9d6c01;"' : 'style="background: #006491;"') . '> </span> </div> <div class="col-10">' . $data[$dp->dp_id]['timework'] . '
                                                                            </div></div></td>';
                                                                                    }
                                                                                }
                                                                            } ?>
                                                                            <?= $td_date ?>
                                                                        </tr>
                                                                    <?php
                                                                    } ?>
                                                                    <!-- <tr class="pt-5">
                                                                    <td colspan="3" class="font-20 fw-bold text-center pt-4" style="background-color:#c3f7ff;">
                                                                        สิ้นสุดเดือน ต.ค. 67
                                                                    </td>
                                                                </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row  ps-lg3 mt-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php if (count($ps_education) > 0) : ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold font-18" id="profile-tab" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab" aria-selected="true">ข้อมูลการศึกษา</button>
                            </li>
                        <?php endif; ?>
                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold font-18" id="training-tab" data-bs-toggle="tab" data-bs-target="#training" type="button" role="tab" aria-selected="false" tabindex="-1">ข้อมูลการอบรม</button>
                        </li> -->
                        <?php if (count($ps_reward) > 0) : ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold font-18" id="reward-tab" data-bs-toggle="tab" data-bs-target="#reward" type="button" role="tab" aria-selected="false" tabindex="-1">ข้อมูลรางวัล</button>
                            </li>
                        <?php endif; ?>
                        <?php if (count($ps_external) > 0) : ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold font-18" id="int-out-tab" data-bs-toggle="tab" data-bs-target="#int-out" type="button" role="tab" aria-selected="false" tabindex="-1">ข้อมูลการบริการหน่วยงานภายนอก</button>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <?php if ((count($ps_education) + count($ps_reward) + count($ps_external)) > 0) : ?>
                        <div class="tab-content p-3 pt-4" style="border-right: 1px solid #e1e1e1; border-left: 1px solid #e1e1e1; border-bottom: 1px solid #e1e1e1; border-radius: 5px;">
                            <div class="tab-pane fade active show" id="education" role="tabpanel" aria-labelledby="profile-tab">
                                <?php if (count($ps_education) > 0) : ?>
                                    <?php $index = 1 ?>
                                    <?php foreach ($ps_education as $key => $value) : ?>
                                        <div class="profile-item d-flex mb-4">
                                            <div class="profile-icon">
                                                <i class="bi-bookmark-star-fill profile-badge text-info-emphasis font-30 me-4"></i>
                                            </div>
                                            <div class="profile-content font-18">
                                                <div class="mt-2 mb-2 font-22"><b><?= $value->edulv_name ?></b></div>
                                                <div><i class="bi-mortarboard pe-2 font-28 me-4"></i>
                                                    <?= $value->edudg_name . ' ' . $value->edumj_name . ' ' . $value->place_name ?></div>
                                            </div>
                                        </div>
                                        <?php if ($index != count($ps_education)) : $index++ ?>
                                            <hr class="mb-4">
                                        <?php else: ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <!-- <div class="profile-item d-flex mb-4">
                                    <div class="profile-icon">
                                        <i class="bi-bookmark-star-fill profile-badge text-info-emphasis font-30 me-4"></i>
                                    </div>
                                    <div class="profile-content font-18">
                                        <div class="mt-2 mb-2 font-22"><b>การศึกษา</b></div>
                                        <div><i class="bi-mortarboard pe-2 font-28 me-4"></i>
                                            พ.ศ. 2544 แพทยศาสตรบัณฑิต คณะแพทยศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล</div>
                                    </div>
                                </div>
                                <hr class="mb-4"> -->
                                <?php endif; ?>
                                <!-- <div class="profile-item d-flex mb-4">
                                <div class="profile-icon">
                                    <i class="bi-bookmark-star-fill profile-badge text-primary font-30 me-4"></i>
                                </div>
                                <div class="profile-content font-18">
                                    <div class="mt-2 mb-3 font-22"><b>วุฒิบัตร</b></div>
                                    <div><i class="bi-mortarboard pe-2 font-28 me-4"></i>พ.ศ. 2550 จักษุวิทยา ราชวิทยาลัยจักษุแพย์แห่งประเทศไทย</div>
                                    <div><i class="bi-mortarboard pe-2 font-28 me-4"></i>พ.ศ. 2551 จักษุต่อยอดเฉพาะทางต้อหิน ราชวิทยาลัยจักษุแพทย์แห่งประเทศไทย</div>
                                </div>
                            </div>
                            <hr class="mb-4">
                            <div class="profile-item d-flex mb-4">
                                <div class="profile-icon">
                                    <i class="bi-bookmark-star-fill profile-badge text-info font-30 me-4"></i>
                                </div>
                                <div class="profile-content font-18">
                                    <div class="mt-2 mb-3 font-22"><b>การศึกษาหลังปริญญา</b></div>
                                    <div><i class="bi-mortarboard pe-2 font-28 me-4"></i>พ.ศ. 2552 แพทย์ประจำบ้านต่อยอดสาขาจักษุวิทยากระจกตาและการแก้ไขสายตา คณะแพทยศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล</div>
                                    <div><i class="bi-mortarboard pe-2 font-28 me-4"></i>พ.ศ. 2553 Glaucoma Fellowship, University of California, San Francisco (UCSF)</div>
                                </div>
                            </div> -->
                            </div>
                            <div class="tab-pane fade" id="training" role="tabpanel" aria-labelledby="training-tab">
                                <div class="profile-item d-flex mb-4">
                                    <div class="profile-icon">
                                        <i class="bi-book-half profile-badge  text-info-emphasis font-30 me-4"></i>
                                    </div>
                                    <div class="profile-content font-18">
                                        <div class="mt-2 mb-3 font-22"><b>พ.ศ. 2567</b></div>
                                        <div><i class="bi-journal-bookmark pe-2 font-28 me-4"></i>การอบรมเชิงปฏิบัติการเรื่องการพัฒนาทักษะ กรมพัฒนาฝีมือแรงงาน</div>
                                        <div><i class="bi-journal-bookmark pe-2 font-28 me-4"></i>สัมมนาเรื่องนวัตกรรมเทคโนโลยี มหาวิทยาลัยเทคโนโลยี</div>
                                    </div>
                                </div>
                                <!-- <hr class="mb-4">
                            <div class="profile-item d-flex mb-4">
                                <div class="profile-icon">
                                    <i class="bi-book-half profile-badge text-primary  font-30 me-4"></i>
                                </div>
                                <div class="profile-content font-18">
                                    <div class="mt-2 mb-3 font-22"><b>พ.ศ. 2550</b></div>
                                    <div><i class="bi-journal-bookmark pe-2 font-28 me-4"></i>กระบวนวิชา 315721 จักษุวิทยาทั่วไป คณะแพทยศาสตร์ จุฬาลงกรณ์มหาวิทยาลัย</div>
                                    <div><i class="bi-journal-bookmark pe-2 font-28 me-4"></i>กระบวนวิชา 315722 จักษุวิทยาคลินิก คณะแพทยศาสตร์ จุฬาลงกรณ์มหาวิทยาลัย</div>
                                </div>
                            </div>
                            <hr class="mb-4">
                            <div class="profile-item d-flex mb-4">
                                <div class="profile-icon">
                                    <i class="bi-book-half profile-badge text-info font-30 me-4"></i>
                                </div>
                                <div class="profile-content font-18">
                                    <div class="mt-2 mb-3 font-22"><b>พ.ศ. 2549</b></div>
                                    <div><i class="bi-journal-bookmark pe-2 font-28 me-4"></i>กระบวนวิชา 345701 เพิ่มพูนทักษะวิชาชีพสำหรับแพทย์ประจำบ้าน คณะแพทยศาสตร์ จุฬาลงกรณ์มหาวิทยาลัย</div>
                                </div>
                            </div> -->
                            </div>
                            <div class="tab-pane fade" id="reward" role="tabpanel" aria-labelledby="reward-tab">
                                <?php $index = 1 ?>
                                <?php if (count($ps_reward) > 0) : ?>
                                    <?php foreach ($ps_reward as $key_reward => $reward_group) : ?>
                                        <div class="profile-item d-flex">
                                            <div class="profile-icon">
                                                <i class="ri-medal-fill profile-badge text-info-emphasis font-30 me-4"></i>
                                            </div>
                                            <div class="profile-content font-18">
                                                <div class="mt-2 font-22">
                                                    <b>
                                                        <?php  
                                                            if($key_reward != "ไม่ระบุ"){
                                                                echo "พ.ศ. " . $key_reward;
                                                            }
                                                            else{
                                                                echo "อื่น ๆ";
                                                            }
                                                        ?>
                                                    </b>
                                                </div>
                                                <?php foreach ($reward_group as $key_info => $reward_info) : ?>
                                                    <div class="mt-2"><i class="bi-award pe-2 font-28 me-4"></i><?= $reward_info->rewd_name_th . ' ' . $reward_info->rewd_org_en ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php if ($index != count($ps_reward)) : ?>
                                            <hr class="mb-4">
                                        <?php else: $index++ ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="tab-pane fade" id="int-out" role="tabpanel" aria-labelledby="reward-tab">
                                <?php $index = 1 ?>
                                <?php if (count($ps_external) > 0) : ?>
                                    <?php foreach ($ps_external as $external_year => $ps_external) : ?>
                                        <div class="profile-item d-flex">
                                            <div class="profile-icon">
                                                <i class="ri-service-fill profile-badge text-info-emphasis font-30 me-4"></i>
                                            </div>
                                            <div class="profile-content font-18">
                                                <div class="mt-2 font-22">
                                                    <b>
                                                        <?php  
                                                            if($external_year != "ไม่ระบุ"){
                                                                echo "พ.ศ. " . $external_year;
                                                            }
                                                            else{
                                                                echo "อื่น ๆ";
                                                            }
                                                        ?>
                                                    </b>
                                                </div>
                                                <div style="padding-left: 15px;">
                                                    <?php foreach ($ps_external as $external_id => $external_group) : ?>
                                                        <?php foreach ($external_group as $key => $external_info) : ?>
                                                            <?php if ($key == 0) : ?>
                                                                <div class="mt-2 font-22"><b><?= $external_info->exts_name_th ?></b></div>
                                                                <ul>
                                                                <?php endif; ?>
                                                                <li>
                                                                    <?= $external_info->pexs_name_th . ' ณ ' . $external_info->place_name . '<b class="text-secondary">' . ($external_info->pexs_date != "0000-00-00" ? '(วันที่ '.fullDateTH3($external_info->pexs_date).')' : "") . '</b>' ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                                </ul>
                                                            <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($index != count($ps_external)) : ?>
                                            <hr class="mb-4">
                                        <?php else: $index++ ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.prev-week, .next-week').forEach(button => {
        button.addEventListener('click', function() {
            const currentWeek = parseInt(this.getAttribute('data-week'));
            const isPrevious = this.classList.contains('prev-week');
            const nextWeek = isPrevious ? currentWeek - 1 : currentWeek + 1;

            const container = this.closest('.current-weeks') || this.closest('.previous-weeks');
            // console.log(container);

            const currentElement = container.querySelector(`#week-${currentWeek}`) ||
                container.querySelector(`#week-pe-${currentWeek}`);
            const nextElement = container.querySelector(`#week-${nextWeek}`) ||
                container.querySelector(`#week-pe-${nextWeek}`);

            if (currentElement && nextElement) {
                currentElement.style.display = 'none';
                nextElement.style.display = 'block';
            } else {
                // console.error(`ไม่พบองค์ประกอบสำหรับสัปดาห์: #week-${currentWeek} หรือ #week-pe-${nextWeek}`);
            }
        });
    });
</script>
<!-- <script>
    var top = doc.getElementById("topbar_head");

    if (top) {
        top.classList.remove('col-lg-5');
        top.classList.add('col-lg-3');
    }
</script> -->