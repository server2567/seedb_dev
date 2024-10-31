<style>
    .profile-item .profile-badge {
        font-size: 2rem;
        line-height: normal;
    }

    .profile-item .profile-content {
        padding-left: 10px;
    }

    .profile-item {
        padding-bottom: 2rem;
    }

    .profile-item:last-child {
        padding-bottom: 0;
    }

    .profile-content .bi-circle-fill {
        font-size: 10px;
    }

    /* .profile-icon {
        padding-top: 10px; 
    } */


    .list-group-borderless {
        --bs-list-group-border-width: 0px
    }
</style>

<h4 class="partial-name"><span>ข้อมูลส่วนตัว</span></h4>

<div class="p-3">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">ข้อมูลทั่วไป</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab">ข้อมูลที่อยู่</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab">ข้อมูลการศึกษา</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#work_history" type="button" role="tab">ข้อมูลประสบการณ์ทำงาน</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reward-tab" data-bs-toggle="tab" data-bs-target="#reward" type="button" role="tab">ข้อมูลรางวัล</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="external-service-tab" data-bs-toggle="tab" data-bs-target="#external_service" type="button" role="tab">ข้อมูลบริการหน่วยงานภายนอก</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="training-tab" data-bs-toggle="tab" data-bs-target="#training" type="button" role="tab">ข้อมูลการพัฒนาบุคลากร</button>
        </li>
        <!--<li class="nav-item" role="presentation">
            <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary" type="button" role="tab">ประวัติเงินเดือน</button>
        </li> -->
    </ul>
    <div class="tab-content p-3 pt-4">
        <div class="tab-pane fade show active" id="profile" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-12"><b>ข้อมูลทั่วไป</b></div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ชื่อ - นามสกุล <br>(ภาษาไทย)</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->pf_name_abbr . $profile_person['person_detail']->ps_fname . " " . $profile_person['person_detail']->ps_lname;
                            ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ชื่อเล่น (TH)</div>
                        <div class="col-md-7">บูม</div>
                    </div>
                </div> -->
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ชื่อ - นามสกุล <br>(ภาษาอังกฤษ)</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->pf_name_abbr_en . $profile_person['person_detail']->ps_fname_en . " " . $profile_person['person_detail']->ps_lname_en;
                            ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ชื่อเล่น (EN)</div>
                        <div class="col-md-7">Boom</div>
                    </div>
                </div> -->
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">เพศ</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->gd_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">เลขบัตรประชาชน</div>
                        <div class="col-md-7">
                            <?php

                            // แบ่งข้อความออกเป็นส่วนย่อยที่มีความยาว 1, 3, 4, 5, 0
                            $parts = str_split($profile_person['person_detail']->psd_id_card_no, 1);
                            // สร้างอาร์เรย์ใหม่โดยนำส่วนย่อยมาต่อกัน
                            // $new_parts = array($parts[0], $parts[1].$parts[2].$parts[3].$parts[4], $parts[5].$parts[6].$parts[7].$parts[8].$parts[9], $parts[10].$parts[11], $parts[12]);
                            $new_parts = array("x xxxx xxxxx ", $parts[10] . $parts[11], $parts[12]);
                            // รวมส่วนย่อยเข้าด้วยกันโดยเว้นวรรคหลังจากส่วนย่อยที่ 1, 3, 4, 5, 0
                            $psd_id_card_no = implode(' ', $new_parts);

                            echo $psd_id_card_no; // ผลลัพธ์: 1 2345 67890 12 3
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">วันเกิด</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_birthdate ? abbreDate2($profile_person['person_detail']->psd_birthdate) : "";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">อายุ</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_birthdate ? $profile_person['person_detail']->psd_year . " ปี" : "";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">กรุ๊ปเลือด</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->blood_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">สัญชาติ</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->nation_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">เชื้อชาติ</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->race_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ศาสนา</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->reli_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">สถานภาพสมรส</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psst_name;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="address" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-12">
                    <b class="float-start">ที่อยู่ที่ติดต่อได้</b>
                    <!-- <a href="" data-bs-toggle="modal" data-bs-target="#profile-address-his-modal" class="float-end">ประวัติการเปลี่ยนที่อยู่</a> -->
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ที่อยู่</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addcur_no;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ตำบล</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addcur_dist_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">อำเภอ</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addcur_amph_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">จังหวัด</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addcur_pv_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">รหัสไปรษณีย์</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addcur_zipcode;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-12"><b>ที่อยู่ตามสำเนาทะเบียนบ้าน</b></div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ที่อยู่</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addhome_no;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">ตำบล</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addhome_dist_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">อำเภอ</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addhome_amph_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">จังหวัด</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addhome_pv_name;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5 text-muted">รหัสไปรษณีย์</div>
                        <div class="col-md-7">
                            <?php
                            echo $profile_person['person_detail']->psd_addhome_zipcode;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="education" role="tabpanel">
            <?php
            foreach ($profile_person['person_education_list'] as $key => $edu) {
                // กำหนดค่าเริ่มต้นของ $edu_style เป็น "text-info"
                $edu_style = "text-info";
                // กำหนดค่าของ $edu_style.index
                $edu_style_index = 1; // ให้มีค่าตั้งต้นเป็น 3 เช่นเดียวกับค่าของ "text-danger"

                // ตรวจสอบเงื่อนไขที่ $key มีค่ามากกว่า $edu_style.index
                if ($key > $edu_style_index) {
                    $edu_style_index = 1;
                }

                // ตรวจสอบค่า $key และกำหนดค่าของ $edu_style ตามค่าของ $key
                switch ($key) {
                    case 0:
                        $edu_style_class = "text-primary";
                        break;
                    case 1:
                        $edu_style_class = "text-secondary";
                        break;
                    case 2:
                        $edu_style_class = "text-success";
                        break;
                    case 3:
                        $edu_style_class = "text-danger";
                        break;
                    case 4:
                        $edu_style_class = "text-warning";
                        break;
                        // เพิ่มเติมตามลำดับค่าของ $key ตามต้องการ
                    default:
                        $edu_style_class = "text-primary"; // ค่าเริ่มต้นหากไม่มีเงื่อนไขที่ตรงกัน
                }

            ?>
                <div class="profile-item d-flex">
                    <div class="profile-icon">
                        <!-- ใช้คลาส CSS ที่ได้จากการตรวจสอบ $key หรือค่า "1" -->
                        <i class='bi-bookmark-star-fill profile-badge <?php echo $edu_style_class; ?>'></i>
                    </div>
                    <div class="profile-content">
                        <div class="mt-2 mb-3"><b><?php echo $edu->edulv_name; ?></b></div>
                        <div>
                            <i class='bi-mortarboard-fill pe-2'></i>
                            <?php echo "พ.ศ. " . ($edu->edu_start_year + 543) . "-" . ($edu->edu_end_year + 543) . " " . $edu->edudg_name . " " . $edu->edumj_name . " " . $edu->place_name; ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
        <div class="tab-pane fade" id="work_history" role="tabpanel">
            <?php $this->load->view($this->config->item('pd_dir') . 'v_home_profile_work_history'); ?>
        </div>
        <div class="tab-pane fade" id="training" role="tabpanel">
            <section class="section dashboard">
                <div clas="row">
                    <div class="col-md-12">
                        <div class="d-grid col-4 mx-auto">
                            <label for="select_year_develop d-flex justify-content-center" class="form-label">ปีปฏิทิน</label>
                            <select class="form-select select2 ms-2 w-15" style="display: inline;" data-placeholder="-- กรุณาเลือกปี --" name="select_year_develop" id="select_year_develop" onchange="filterDataByYear(value)">
                                <option value="2567">2567</option>
                                <option value="2566">2566</option>
                                <option value="2565">2565</option>
                                <option value="2564">2564</option>
                                <option value="2563">2563</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 ">
                    <div class="col-md-12">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                                <div class="card info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title">จำนวนชั่วโมงการไปพัฒนาบุคลากร</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-briefcase-fill"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6 id='dev_sum_hour'><?= $dev_sum_hour ?> ชั่วโมง</h6>
                                                <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="card info-card customers-card">

                                    <div class="card-body">
                                        <h5 class="card-title">งบประมาณที่ใช้ไป</h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-currency-dollar"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>35500 บาท</h6>
                                               <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                            <!-- </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  -->
                            <!-- Pills Tabs -->
                            <?php if (!empty($devlop_list_person)) {
                                $devl_fl = array_filter($devlop_list_person, function ($dl) {
                                    return $dl->dev_organized_type == 1;
                                });
                                $devl_fl2 = array_filter($devlop_list_person, function ($dl) {
                                    return $dl->dev_organized_type == 2;
                                });
                                $devl_1 = count($devl_fl);
                                $devl_2 = count($devl_fl2);
                            } else {
                                $devl_1 = 0;
                                $devl_2 = 0;
                            } ?>
                            <ul class="nav nav-pills mb-3 mt-3" id="hr-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="hr-develop-in-tab" data-bs-toggle="pill" data-bs-target="#hr-develop-in" type="button" role="tab" aria-controls="hr-develop-in" aria-selected="true" style="margin-left: 13px;">อบรมภายใน <span class="badge bg-success" id="summary-develop-in"><?= $devl_1 ?></span></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="hr-develop-out-tab" data-bs-toggle="pill" data-bs-target="#hr-develop-out" type="button" role="tab" aria-controls="hr-develop-out" aria-selected="false">อบรมภายนอก <span class="badge bg-success" id="summary-develop-out"><?= $devl_2 ?></span></button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="table-hr-develop-in-tab">
                                <div class="tab-pane fade show active" id="hr-develop-in" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="card">
                                        <div class="accordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button accordion-button-table" type="button">
                                                        <i class="bi bi-table icon-menu"></i><span> ตารางรายการข้อมูลพัฒนาบุคลากรภายในโรงพยาบาล</span></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse-hr-develop-in-tab" class="accordion-collapse collapse show">
                                                    <div class="accordion-body">
                                                        <table class="table datatable table-hover" width="100%" id="table-develop-in">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-center">#</th>
                                                                    <th scope="col">ชื่อเรื่อง</th>
                                                                    <th scope="col">วันที่</th>
                                                                    <th scope="col">ประเภทการพัฒนาบุคลากร</th>
                                                                    <th scope="col">ผู้จัดโครงการ/หน่วยงาน</th>
                                                                    <th scope="col">จำนวนชั่วโมง</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($devlop_list_person as $key => $develop_one) : ?>
                                                                    <?php if ($develop_one->dev_organized_type == 1) : ?>
                                                                        <tr>
                                                                            <td class="text-center"><?= $key + 1 ?></td>
                                                                            <td><?= $develop_one->dev_topic ?></td>
                                                                            <td class="text-center"><?= fullDateTH3($develop_one->dev_start_date) ?></td>
                                                                            <td><?= $develop_one->dev_server_type_name ?></td>
                                                                            <td><?= $develop_one->dev_project ?></td>
                                                                            <td class="text-center"><?= $develop_one->dev_hour ?></td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="hr-develop-out" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="tab-pane fade show active" id="hr-develop-out" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="card">
                                            <div class="accordion">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button accordion-button-table" type="button">
                                                            <i class="bi bi-table icon-menu"></i><span> ตารางรายการพัฒนาข้อมูลบุคลากรภายนอกโรงพยาบาล</span></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse-hr-develop-out-tab" class="accordion-collapse collapse show">
                                                        <div class="accordion-body">
                                                            <table class="table datatable table-hover" width="100%" id="table-develop-out">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" class="text-center">#</th>
                                                                        <th scope="col">ชื่อเรื่อง</th>
                                                                        <th scope="col">วันที่</th>
                                                                        <th scope="col">ประเภทการพัฒนาบุคลากร</th>
                                                                        <th scope="col">ผู้จัดโครงการ/หน่วยงาน</th>
                                                                        <th scope="col">จำนวนชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($devlop_list_person as $key => $develop_two) : ?>
                                                                        <?php if ($develop_two->dev_organized_type == 2) : ?>
                                                                            <tr>
                                                                                <td class="text-center"><?= $key + 1 ?></td>
                                                                                <td><?= $develop_two->dev_topic ?></td>
                                                                                <td class="text-center"><?= fullDateTH3($develop_two->dev_start_date) ?></td>
                                                                                <td><?= $develop_two->dev_server_type_name ?></td>
                                                                                <td><?= $develop_two->dev_project ?></td>
                                                                                <td class="text-center"><?= $develop_two->dev_hour ?></td>
                                                                            </tr>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Pills Tabs -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="reward" role="tabpanel">
            <?php
            foreach ($profile_person['person_reward_list'] as $year) {
            ?>
                <div class="profile-item d-flex">
                    <div class="profile-icon">
                        <i class="ri-medal-fill icon-menu text-warning profile-badge"></i>
                    </div>
                    <div class="profile-content">
                        <div class="mt-2"><b>พ.ศ. <?php echo $year->rewd_year; ?></b></div>
                        <?php
                        foreach ($year->reward_detail as $rewd) {
                        ?>
                            <div>
                                <i class='bi-award pe-2'></i><?php echo $rewd->rewd_name_th . " (" . $rewd->rewd_name_en . ")" . $rewd->rewd_org_th . " (" . $rewd->rewd_org_en . ")"; ?>
                            </div>
                            <!-- <div>
                                <i class='bi-people-fill pe-2'></i><?php echo $rewd->rewd_org_th . " (" . $rewd->rewd_org_en . ")"; ?>
                            </div> -->
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <!-- reward -->

        <div class="tab-pane fade" id="external_service" role="tabpanel">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button accordion-button-table" type="button">
                                <i class="bi bi-table icon-menu"></i><span> ตารางรายการข้อมูลบริการหน่วยงายภายนอก</span></span>
                            </button>
                        </h2>
                        <div id="collapse-hr-develop-in-tab" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <table class="table datatable" width="100%">
                                    <thead class="">
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col">เรื่อง</th>
                                            <th scope="col">ประเภท</th>
                                            <th scope="col" class="text-center">วันที่</th>
                                            <th scope="col">สถานที่/หน่วยงาน</th>
                                            <th scope="col" class="text-center">ไฟล์เอกสารแนบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($profile_person['person_external_service_list'])) { ?>
                                            <?php foreach ($profile_person['person_external_service_list'] as $index => $service) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $index + 1; ?></td>
                                                    <td><?php echo htmlspecialchars($service->pexs_name_th); ?></td>
                                                    <td><?php echo htmlspecialchars($service->exts_name_th); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($service->pexs_date); ?></td>
                                                    <td><?php echo htmlspecialchars($service->place_name); ?></td>
                                                    <td class="text-center">
                                                        <?php if (!empty($service->pexs_attach_file)) { ?>
                                                            <button type="button" class="btn btn-primary"
                                                                data-file-name="<?php echo $service->pexs_attach_file; ?>"
                                                                data-preview-path="<?php echo site_url($this->config->item('hr_dir') . 'Getpreview?path=' . $this->config->item('hr_upload_profile_external_service') . '&doc='); ?><?php echo $service->pexs_attach_file; ?>"
                                                                data-download-path="<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_profile_external_service') . '&doc='); ?><?php echo $service->pexs_attach_file; ?>&rename=<?php echo $service->pexs_attach_file; ?>"
                                                                data-bs-toggle="modal" id="btn_preview_file"
                                                                data-bs-target="#preview_file_modal"
                                                                title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน"
                                                                data-toggle="tooltip" data-bs-placement="top">
                                                                <i class="bi-file-earmark"></i>
                                                            </button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- external_service -->

    <div class="tab-pane fade" id="salary" role="tabpanel">
        <div id="pincode-container">
            <div class="text-center mb-5">
                โปรดระบุ PIN เพื่อดูประวัติเงินเดือน
            </div>
            <div class="text-center w-100">
                <input type="text" id="pincode-input5">
            </div>
            <div class="text-center">
                <button class="btn btn-primary" id="pincode-btn" onclick="checkPin()" disabled>ยืนยัน</button>
            </div>
        </div>
        <div id="salary-his-container" style="display: none;">
            <div class="text-center">
                ปี พ.ศ.
                <span>
                    <select class="form-select form-control ms-2 w-15" style="display: inline;" data-placeholder="-- กรุณาเลือกปี --" name="DashboardYearSearch1" id="DashboardYearSearch1">
                        <option value="2567">2567</option>
                        <option value="2566">2566</option>
                        <option value="2565">2565</option>
                        <option value="2564">2564</option>
                        <option value="2563">2563</option>
                    </select>
                </span>
            </div>

            <div class="row">
                <div class="col-lg-4 ps-xl-6" id="total-salary">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="p-3">
                                <span class="d-block text-sm text-muted">ยอดรวมสุทธิต่อปี (บาท)</span>
                                <h2 class="d-block text-sm text-heading fw-bold text-end">316,780</h2>
                            </div>
                            <div id="salary-total-chart" class="w-100 p-0"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 ps-xl-6" id="total-income-salary">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="p-3">
                                <span class="d-block text-sm text-muted">รายได้สุทธิต่อปี (บาท)</span>
                                <h2 class="d-block text-sm text-heading fw-bold text-end">355,000</h2>
                            </div>
                            <div id="salary-income-chart" class="w-100 p-0"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 ps-xl-6" id="total-expense-salary">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="p-3">
                                <span class="d-block text-sm text-muted">ค่าใช้จ่ายสุทธิต่อปี (บาท)</span>
                                <h2 class="d-block text-sm text-heading fw-bold text-end">38,220</h2>
                            </div>
                            <div id="salary-expense-chart" class="w-100 p-0"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ps-xl-6" id="month-salary">
                    <div class="card border-primary-hover shadow-soft-3-hover">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-xl-row gap-10 justify-content-xl-between align-items-xl-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-group">
                                        <i class="avatar avatar-lg bi-currency-exchange text-success"></i>
                                        <i class="avatar avatar-lg bi-currency-exchange text-danger"></i>
                                        <!-- <img src="../../img/crypto/color/btc.svg" class="avatar avatar-lg border border-2 border-body rounded-circle" alt="..."> 
                                            <img src="../../img/crypto/color/usdt.svg" class="avatar avatar-lg border border-2 border-body rounded-circle" alt="..."> -->
                                    </div>
                                    <div class="">
                                        <h6>เมษายน</h6>
                                        <span class="badge bg-danger"><i class="bi-arrow-down me-1"></i> 2.55%</span>
                                    </div>
                                </div>
                                <div class="row g-10 gx-xl-16 align-items-center justify-content-between">
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">รายได้ (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">86,000</span>
                                    </div>
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">ค่าใช้จ่าย (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">9,555</span>
                                    </div>
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">ยอดรวม (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">76,445</span>
                                    </div>
                                    <div class="col-12 col-sm-auto col-xl-auto">
                                        <button type="button" class="btn btn-info text-white" data-bs-target="#profile-salary-his-modal" data-bs-toggle="modal"><i class="bi-search"></i></button>
                                        <button class="btn btn-primary text-white"><i class="bi-printer"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-primary-hover shadow-soft-3-hover">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-xl-row gap-10 justify-content-xl-between align-items-xl-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-group">
                                        <i class="avatar avatar-lg bi-currency-exchange text-success"></i>
                                        <i class="avatar avatar-lg bi-currency-exchange text-danger"></i>
                                        <!-- <img src="../../img/crypto/color/btc.svg" class="avatar avatar-lg border border-2 border-body rounded-circle" alt="..."> 
                                            <img src="../../img/crypto/color/usdt.svg" class="avatar avatar-lg border border-2 border-body rounded-circle" alt="..."> -->
                                    </div>
                                    <div class="">
                                        <h6>มีนาคม</h6>
                                        <span class="badge bg-danger"><i class="bi-arrow-down me-1"></i> 9.26%</span>
                                    </div>
                                </div>
                                <div class="row g-10 gx-xl-16 align-items-center justify-content-between">
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">รายได้ (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">88,000</span>
                                    </div>
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">ค่าใช้จ่าย (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">9,555</span>
                                    </div>
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">ยอดรวม (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">78,445</span>
                                    </div>
                                    <div class="col-12 col-sm-auto col-xl-auto">
                                        <button type="button" class="btn btn-info text-white" data-bs-target="#profile-salary-his-modal" data-bs-toggle="modal"><i class="bi-search"></i></button>
                                        <button class="btn btn-primary text-white"><i class="bi-printer"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-primary-hover shadow-soft-3-hover">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-xl-row gap-10 justify-content-xl-between align-items-xl-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-group">
                                        <i class="avatar avatar-lg bi-currency-exchange text-success"></i>
                                        <i class="avatar avatar-lg bi-currency-exchange text-danger"></i>
                                        <!-- <img src="../../img/crypto/color/btc.svg" class="avatar avatar-lg border border-2 border-body rounded-circle" alt="..."> 
                                            <img src="../../img/crypto/color/usdt.svg" class="avatar avatar-lg border border-2 border-body rounded-circle" alt="..."> -->
                                    </div>
                                    <div class="">
                                        <h6>กุมภาพันธ์</h6>
                                        <span class="badge bg-success"><i class="bi-arrow-up me-1"></i> 14.59%</span>
                                    </div>
                                </div>
                                <div class="row g-10 gx-xl-16 align-items-center justify-content-between">
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">รายได้ (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">96,000</span>
                                    </div>
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">ค่าใช้จ่าย (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">9,555</span>
                                    </div>
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">ยอดรวม (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">86,445</span>
                                    </div>
                                    <div class="col-12 col-sm-auto col-xl-auto">
                                        <button type="button" class="btn btn-info text-white" data-bs-target="#profile-salary-his-modal" data-bs-toggle="modal"><i class="bi-search"></i></button>
                                        <button class="btn btn-primary text-white"><i class="bi-printer"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-primary-hover shadow-soft-3-hover">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-xl-row gap-10 justify-content-xl-between align-items-xl-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-group">
                                        <i class="avatar avatar-lg bi-currency-exchange text-success"></i>
                                        <i class="avatar avatar-lg bi-currency-exchange text-danger"></i>
                                        <!-- <img src="../../img/crypto/color/btc.svg" class="avatar avatar-lg border border-2 border-body rounded-circle" alt="..."> 
                                            <img src="../../img/crypto/color/usdt.svg" class="avatar avatar-lg border border-2 border-body rounded-circle" alt="..."> -->
                                    </div>
                                    <div class="">
                                        <h6>มกราคม</h6>
                                        <span class="badge bg-success"><i class="bi-arrow-up me-1"></i> 0.30%</span>
                                    </div>
                                </div>
                                <div class="row g-10 gx-xl-16 align-items-center justify-content-between">
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">รายได้ (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">85,000</span>
                                    </div>
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">ค่าใช้จ่าย (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">9,555</span>
                                    </div>
                                    <div class="col-6 col-sm-auto col-xl-auto">
                                        <span class="d-block text-xs text-muted">ยอดรวม (บาท)</span>
                                        <span class="d-block text-heading text-sm text-end">75,445</span>
                                    </div>
                                    <div class="col-12 col-sm-auto col-xl-auto">
                                        <button type="button" class="btn btn-info text-white" data-bs-target="#profile-salary-his-modal" data-bs-toggle="modal"><i class="bi-search"></i></button>
                                        <button class="btn btn-primary text-white"><i class="bi-printer"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div>
                    <ul class="nav nav-tabs" role="tablist">
                    <?php
                    setlocale(LC_TIME, 'th_TH.utf8');
                    $thaiMonths = array(
                        'มกราคม',
                        'กุมภาพันธ์',
                        'มีนาคม',
                        'เมษายน'
                    );
                    ?>
                        <?php
                        $i = 0;
                        foreach ($thaiMonths as $row) {
                            if (count($thaiMonths) - 1 == $i) { ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="<?php echo $i; ?>-salary-tab" data-bs-toggle="tab" data-bs-target="#salary-month" type="button" role="tab"><?php echo $row; ?></button>
                                </li>
                                <?php } else { ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="<?php echo $i; ?>-salary-tab" data-bs-toggle="tab" data-bs-target="#salary-month" type="button" role="tab"><?php echo $row; ?></button>
                                </li>
                                <?php }
                            $i++;
                        }
                                ?>
                    </ul>
                    <div class="tab-content p-3 pt-4">
                        <div class="tab-pane fade show active" id="salary-month" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12 ps-xl-6" id="total-salary">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <span class="mb-0 ms-1 text-muted">รายได้สุทธิ</span>
                                            <h2 class="heading-color ms-1">75,445 บาท</h2>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary"><i class="bi-printer"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 ps-xl-6" id="income-salary">
                                    <div class="card border p-4">
                                        <div class="card-header p-0 pb-3">
                                            <h5 class="card-title mb-0">รายรับ <i class="bi-currency-exchange ms-1 text-success"></i></h5>
                                        </div>
                                        <div class="card-body p-0 pb-3 mt-2">
                                            <ul class="list-group list-group-borderless">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>ค่าตอบแทน</span>
                                                    <span class="heading-color fw-semibold mb-0">80,000 บาท</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>ค่าหัตถการ</span>
                                                    <span class="heading-color fw-semibold mb-0">5,000 บาท</span>	
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer bg-transparent border-top p-0 pt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="heading-color fw-normal text-success">รายได้ทั้งหมด</span>
                                                <span class="h6 mb-0 text-success">85,000 บาท</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 ps-xl-6" id="expenses-salary">
                                    <div class="card border p-4">
                                        <div class="card-header p-0 pb-3">
                                            <h5 class="card-title mb-0">รายจ่าย <i class="bi-currency-exchange ms-1 text-danger"></i></h5>
                                        </div>
                                        <div class="card-body p-0 pb-3 mt-2">
                                            <ul class="list-group list-group-borderless">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>ภาษีเงินได้</span>
                                                    <span class="heading-color fw-semibold mb-0">8,805 บาท</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>กองทุนประกันสังคม</span>
                                                    <span class="heading-color fw-semibold mb-0">750 บาท</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer bg-transparent border-top p-0 pt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="heading-color fw-normal text-danger">รายจ่ายทั้งหมด</span>
                                                <span class="h6 mb-0 text-danger">9,555 บาท</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/personal_dashboard/bootstrap-pincode-input/bootstrap-pincode-input.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/personal_dashboard/bootstrap-pincode-input/bootstrap-pincode-input.css" rel="stylesheet">

<script>
    $('#pincode-input5').pincodeInput({
        hidedigits: true,
        inputs: 4,
        change: function(input, value, inputnumber) {
            if ($('#pincode-input5').val().length == 4) $('#pincode-btn').prop('disabled', false);
            else $('#pincode-btn').prop('disabled', true);
        }
    });

    function filterDataByYear(year) {
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_develop_list_person_by_filter_year',
            type: 'POST',
            async: false, // Make the request synchronous (not recommended for large data or slow connections)
            data: {
                year: year,
            },
            success: function(data) {
                // Parse the returned data and update
                data = JSON.parse(data);
                var developData = data.data.filter_data
                const tableBody = document.getElementById('table-develop-in').getElementsByTagName('tbody')[0];
                const tableBodyOut = document.getElementById('table-develop-out').getElementsByTagName('tbody')[0];
                const summaryIn = document.getElementById('summary-develop-in');
                const summaryOut = document.getElementById('summary-develop-out');
                const sumhour = document.getElementById('dev_sum_hour')
                sumhour.textContent = data.data.ft_sum_hour + ' ชั่วโมง'
                tableBody.innerHTML = ''; // ล้างข้อมูลตารางเดิม
                tableBodyOut.innerHTML = ''; // ล้างข้อมูลตารางเดิม

                let countIn = 0;
                let countOut = 0;
                developData.forEach(item => {
                    const row = document.createElement('tr');

                    if (item.dev_organized_type == 1) {
                        countIn++;
                        row.innerHTML = `
                        <td class="text-center">${countIn}</td>
                        <td>${item.dev_topic}</td>
                        <td class="text-center">${item.dev_start_date}</td>
                        <td>${item.dev_server_type_name}</td>
                        <td>${item.dev_project}</td>
                        <td class="text-center">${item.dev_hour}</td>     
                    `;
                        tableBody.appendChild(row);
                    } else {
                        countOut++;
                        row.innerHTML = `
                        <td class="text-center">${countOut}</td>
                        <td>${item.dev_topic}</td>
                        <td class="text-center">${item.dev_start_date}</td>
                        <td>${item.dev_server_type_name}</td>
                        <td>${item.dev_project}</td>
                        <td class="text-center">${item.dev_hour}</td>     
                    `;
                        tableBodyOut.appendChild(row);
                    }
                })
                if (countIn === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="6" class="text-center">ไม่พบข้อมูล</td>`;
                    tableBody.appendChild(row);
                }
                if (countOut === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="6" class="text-center">ไม่พบข้อมูล</td>`;
                    tableBodyOut.appendChild(row);
                }
                summaryIn.textContent = countIn;
                summaryOut.textContent = countOut;

            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });

    }

    function checkPin() {
        // console.log($('#pincode-input5').val());

        $("#pincode-container").fadeOut(function() {
            // Code to execute after fade-out animation completes
            $("#salary-his-container").fadeIn(); // Fade in after fade out completes
        });
    }
</script>

<!-- JS Chart -->
<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

<script>
    Highcharts.chart('salary-total-chart', {
        chart: {
            type: 'area',
            margin: 0, // Set margin to 0
            spacing: [0, 0, 0, 0], // Set spacing to 0 for all sides
            spacingTop: 0,
            height: 50 // Set the height of the chart
        },
        title: {
            text: '',
            enabled: false
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        xAxis: {
            visible: false,
            categories: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            labels: {
                enabled: true,
                visible: false
            }
        },
        yAxis: {
            max: 100000, // เดี๋ยวอนาคตเช็คว่า กลุ่มไหนเงินมากสุด เอาอันนั้นเป็น max
            visible: false
        },
        tooltip: {
            pointFormat: '{series.name} <b>{point.y:,.0f}</b>'
        },
        plotOptions: {
            visible: false,
            area: {
                // pointStart: 1940,
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                },
            },
            series: {
                showInLegend: false,
                lineWidth: 2, // Set line width for the line series
                color: '#0dcaf0', // Set color for the line series
                fillColor: '#cff4fc' // Set color and transparency for the area series
            }
        },
        series: [{
            name: 'ยอดรวม',
            data: [
                75445, 86445, 78445, 76445
            ]
        }]
    });
</script>

<script>
    Highcharts.chart('salary-income-chart', {
        chart: {
            type: 'area',
            margin: 0, // Set margin to 0
            spacing: [0, 0, 0, 0], // Set spacing to 0 for all sides
            spacingTop: 0,
            height: 50 // Set the height of the chart
        },
        title: {
            text: '',
            enabled: false
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        xAxis: {
            visible: false,
            categories: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            labels: {
                enabled: true,
                visible: false
            }
        },
        yAxis: {
            max: 100000, // เดี๋ยวอนาคตเช็คว่า กลุ่มไหนเงินมากสุด เอาอันนั้นเป็น max
            visible: false
        },
        tooltip: {
            pointFormat: '{series.name} <b>{point.y:,.0f}</b>'
        },
        plotOptions: {
            visible: false,
            area: {
                // pointStart: 1940,
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                },
            },
            series: {
                showInLegend: false,
                lineWidth: 2, // Set line width for the line series
                color: '#198754', // Set color for the line series
                fillColor: '#a3cfbb' // Set color and transparency for the area series
            }
        },
        series: [{
            name: 'รายได้',
            data: [
                85000, 96000, 88000, 86000
            ]
        }]
    });
</script>

<script>
    Highcharts.chart('salary-expense-chart', {
        chart: {
            type: 'area',
            margin: 0, // Set margin to 0
            spacing: [0, 0, 0, 0], // Set spacing to 0 for all sides
            spacingTop: 0,
            height: 50 // Set the height of the chart
        },
        title: {
            text: '',
            enabled: false
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        xAxis: {
            visible: false,
            categories: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            labels: {
                enabled: true,
                visible: false
            }
        },
        yAxis: {
            max: 100000, // เดี๋ยวอนาคตเช็คว่า กลุ่มไหนเงินมากสุด เอาอันนั้นเป็น max
            visible: false
        },
        tooltip: {
            pointFormat: '{series.name} <b>{point.y:,.0f}</b>'
        },
        plotOptions: {
            visible: false,
            area: {
                // pointStart: 1940,
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                },
            },
            series: {
                showInLegend: false,
                lineWidth: 2, // Set line width for the line series
                color: '#dc3545', // Set color for the line series
                fillColor: '#f1aeb5' // Set color and transparency for the area series
            }
        },
        series: [{
            name: 'ค่าใช้จ่าย',
            data: [
                9555, 9555, 9555, 9555
            ]
        }]
    });
</script>