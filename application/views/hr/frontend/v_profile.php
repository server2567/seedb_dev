<div class="row topbar">
    <div class="col-md-12 nav_topbar">
        <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
        &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
        <a href="<?php echo $this->config->item('base_frontend_url') . 'index.php/staff/Directory_profile'; ?>">
            &nbsp;<i class="bi bi-person-bounding-box"></i>&nbsp;
            <span class='font-16'>Staff Directory And Profile</span>
        </a>
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

                            <h2 class="h5 mb-3">ความเชี่ยวชาญ : <?php
                                                                $spcl_positions = json_decode($ps_info->spcl_position, true);
                                                                foreach ($spcl_positions as $key => $spcl) { ?>
                                    <?php if (is_string($spcl)) {
                                                                        $spcl = json_decode($spcl, true);
                                                                    } ?>
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
                                1 => 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 
                                'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                            );

                            // ดึงเดือนและปีปัจจุบัน
                            $current_month = (int)date('m'); // เดือนในรูปแบบตัวเลข
                            $current_year = (int)date('Y') + 543; // ปี พ.ศ. (ค.ศ. + 543)

                            ?>
                        <div class="row ps-xl-5 ps-lg-3" style="margin-top: 5rem;">
                          <div class="col-12">
                              <button class="btn btn-info btn-lg mb-3 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample_1" aria-expanded="false" aria-controls="collapseExample_1">
                                  ตารางแพทย์ออกตรวจ ประจำเดือน <?php echo $thai_months[$current_month] . ' พ.ศ. ' . $current_year; ?>
                              </button>
                          </div>
                          <!-- <div class="col-12">
                              <a href="<?php echo site_url(); ?>/que/frontend/Queuing_form_step1" class="btn btn-primary-search btn-lg mb-3 w-100">นัดหมายแพทย์</a>
                          </div> -->
                        </div>
                        <div class="row ps-xl-5 ps-lg-3 mt-3">
                            <div class="col">
                                <div class="collapse show" id="collapseExample_1">
                                    <span class="text-danger font-26">ข้อมูลสำหรับการทดสอบเท่านั้น ไม่ใช่ข้อมูลจริง</span>
                                    <table class='table border-warning'>
                                        <thead>
                                            <tr>
                                                <th>วันที่ออกตรวจ</th>
                                                <th>โรงพยาบาลจักษุสุราษฎร์</th>
                                                <th>คลินิกบรรยงจักษุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>จันทร์</td>
                                                <td>09.00 - 16.00</td>
                                                <td>07.30 - 08.30 และ 17.00 - 20.00</td>
                                            </tr>
                                            <tr>
                                                <td>อังคาร</td>
                                                <td>09.00 - 16.00</td>
                                                <td>07.30 - 08.30 และ 17.00 - 20.00</td>
                                            </tr>
                                            <tr>
                                                <td>พุธ</td>
                                                <td>09.00 - 16.00</td>
                                                <td>07.30 - 08.30 และ 17.00 - 20.00</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
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
                                                    <?= $value->edudg_name .' '. ($value->edumj_name !== null ?$value->edumj_name: '' ) . ' ' . $value->place_name ?></div>
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
                                                <div class="mt-2 font-22"><b>พ.ศ. <?= $key_reward ?></b></div>
                                                <?php foreach ($reward_group as $key_info => $reward_info) : ?>
                                                    <div class="mt-2"><i class="bi-award pe-2 font-28 me-4"></i><?= $reward_info->rewd_name_th . ' ' . $reward_info->rewd_org_th ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php if ($index != count($ps_reward)) : ?>
                                            <hr class="mb-4">
                                        <?php else: $index++ ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <!-- <div class="profile-item d-flex">
                                <div class="profile-icon">
                                    <i class="ri-medal-fill profile-badge text-primary  font-30 me-4"></i>
                                </div>
                                <div class="profile-conten font-18t">
                                    <div class="mt-2 font-22"><b>พ.ศ. 2550</b></div>
                                    <div class="mt-2"><i class="bi-award pe-2 font-28 me-4"></i>Best Presentation Award</div>
                                    <div><i class="bi-person pe-2 font-28 me-4"></i>The Korean Ophthalmological Society</div>
                                </div>
                            </div> -->
                            </div>
                            <div class="tab-pane fade" id="int-out" role="tabpanel" aria-labelledby="reward-tab">
                                <?php $index = 0 ?>
                                <?php $count = count($ps_external) ;?>
                                <?php if (count($ps_external) > 0) : ?>
                                    <?php foreach ($ps_external as $external_year => $ps_external) : ?>
                                        <div class="profile-item d-flex">
                                            <div class="profile-icon">
                                                <i class="ri-service-fill profile-badge text-info-emphasis font-30 me-4"></i>
                                            </div>
                                            <div class="profile-content font-18">
                                                <div class="mt-2 font-22"><b>พ.ศ. <?= $external_year ?></b></div>
                                                <div style="padding-left: 15px;">
                                                    <?php foreach ($ps_external as $external_id => $external_group) : ?>
                                                        <?php foreach ($external_group as $key => $external_info) : ?>
                                                            <?php if ($key == 0) : ?>
                                                                <div class="mt-2 font-22"><b><?= $external_info->exts_name_th ?></b></div>
                                                                <ul>
                                                                <?php endif; ?>
                                                                <li>
                                                                    <?= $external_info->pexs_name_th . ' ณ ' . $external_info->place_name . '<b class="text-secondary"> (วันที่ ' . fullDateTH3($external_info->pexs_date) . ')</b>' ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                                </ul>
                                                            <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($index != $count-1) : ?>
                                            <hr class="mb-4 <?= $count ?>">
                                        <?php  $index++ ?>
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
<!-- <script>
    var top = doc.getElementById("topbar_head");

    if (top) {
        top.classList.remove('col-lg-5');
        top.classList.add('col-lg-3');
    }
</script> -->