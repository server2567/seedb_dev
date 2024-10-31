<div class="row justify-content-md-center mt-2" style="margin-top: -160px !important;">
    <div class="col-12 col-sm-12 col-md-12 text-center">
        <h5 class="font-weight-600">ค้นหาพยาบาลของโรพยาบาลจักษุสุราษฎร์</h5>
        <hr class="style-two">
    </div>
</div>
<div class="row justify-content-md-center mt-3">
    <div class="col-12 col-sm-6 col-md-4" style="margin-top: 3px;">
        <div class="form-floating mb-2">
            <input type="text" class="form-control mb-0" id="floatingInput" value="<?= $ft_name ?>">
            <label for="floatingInput">ค้นหาชื่อ - นามสกุล</label>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="form-floating mb-4">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                <option value="all" selected="">ทุกแผนก</option>
                <?php foreach ($filter_profile as $key => $value) { ?>
                    <option value="<?= $value->stde_id ?>" <?= $ft_select == $value->stde_id ? 'selected' : ''; ?>><?= $value->stde_name_th ?></option>
                <?php } ?>
            </select>
            <label for="floatingSelect">ค้นหาแผนก</label>
        </div>
    </div>
    <!-- <div class="col-12 col-sm-6 col-md-4">
        <div class="form-floating mb-2">
            <select class="form-select mb-0" id="floatingSelect" aria-label="Floating label select example">
                <option selected="">ทุกวันจันทร์ - อาทิตย์</option>
                <option value="1">จันทร์</option>
                <option value="2">อังคาร</option>
                <option value="3">พุธ</option>
                <option value="4">พฤหัสบดี</option>
                <option value="5">ศุกร์</option>
                <option value="6">เสาร์</option>
                <option value="7">อาทิตย์</option>
            </select>
            <label for="floatingSelect">ค้นหาวันที่ต้องการนัดหมายแพทย์</label>
        </div>
        <div class="mt-0 mb-2">หรือ</div>
        <div class="form-floating mb-4">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                <option selected="">ทุกเวลา</option>
                <option value="1">08.30 - 09.30</option>
                <option value="2">09.30 - 10.30</option>
                <option value="3">10.30 - 11.30</option>
                <option value="4">13.00 - 14.00</option>
                <option value="5">14.00 - 15.00</option>
            </select>
            <label for="floatingSelect">ค้นหาเวลาที่ต้องการนัดหมายแพทย์</label>
        </div>
    </div> -->
</div>
<div class="row justify-content-md-center mb-4 mt-2 text-center">
    <div class="col-12 col-sm-12 col-md-8">
        <button type="button" onclick="filter_profile()" id="seacrh_button" data-value="nurses" class="btn btn-primary-search mb-2 w-100 font-20 float-start"><i class="bi bi-search"></i> ค้นหาพยาบาล</button>
    </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12">
                        <h3 id="Mylabel" class="card-title pt-0 font-weight-600 font-22 text-warning-emphasis title-with-line">แผนกจักษุแพทย์</h3>
                    </div>
                    <?php if (count($nurses_person) > 0) : ?>
                        <?php foreach ($nurses_person as $key => $value) { ?>
                            <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                <div class="card">
                                    <img id="profile_picture" class="card-img-top" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($value->psd_picture != '' ? $value->psd_picture : "default.png")); ?>" height="300px">
                                    <div class="card-body p-3">
                                        <h5 class="card-title pb-0 pt-2 font-weight-600" style="min-height: 55px;"><?= $value->ps_fullname ?></h5>
                                        <h6 class="card-title pt-0 pb-2 font-16" style="min-height: 45px;"> <?= $value->alp_name ?> <?php
                                                                                                                                    $spcl_positions = json_decode($value->spcl_position, true);
                                                                                                                                    foreach ($spcl_positions as $key => $spcl) { ?>
                                                <?= (count($spcl_positions) >= 1 ? $key != (count($spcl_positions) - 1) ? $spcl['spcl_name'] . ',' :  $spcl['spcl_name'] : '&nbsp;') ?><?php } ?></h6>
                                        <div class="text-container" data-bs-toggle="tooltip" title="จักษุแพทย์ รักษาโรคตาทั่วไปเชี่ยวชาญการผ่าตัดต้อกระจก Subspecialty General Ophthalmology and Cataract">
                                            <p class="card-text pb-0 font-14 text-dark">
                                                <?= $value->pos_desc != '' ?  $value->pos_desc : '&nbsp;<br><br>' ?>
                                            </p>
                                        </div>
                                        <p class="card-text btn btn-primary font-16 text-dark mb-2"><span style="color: white;">ข้อมูลแพทย์เพิ่มเติม...</span></p>
                                    </div>
                                </div>
                            </div>
                        <?php }  ?>
                    <?php else : ?>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row justify-content-md-center">
                                ไม่พบข้อมูล
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>