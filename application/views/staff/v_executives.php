<meta name="viewport" content="width=device-width, initial-scale=0.7">
<style>
    .card-img-container {
        height: 300px; /* Fixed height for the image container */
        overflow: hidden; /* Hide overflowed content */
    }

    .card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensure image covers the container without distortion */
    }

    .card {
        margin-bottom: 1rem; /* Space between cards */
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    @media (max-width: 600px) { 
      #header{
        display: none !important;
      }
      .row.topbar {
          margin-top: -96px;
      }
      #main {
        margin-top: 30px;
      }
      #profile {
        margin-top: 100px !important;
        width: 116%;
        margin-left: -60px;
      }
      .row.justify-content-md-center.mt-2 {
          display: flex;
          justify-content: center;
          margin-top: 30px !important;
      }
      a.nav-link.nav-profile.d-flex.align-items-center.pe-0 {
          display: none !important;
      }
      #profile label {
          font-size: 20px;
          margin-top: -35px;
      }
      #profile input#floatingInput {
          font-size: 20px;
      }
      #profile .form-floating.mb-2 {
          margin-bottom: 40px !important;
      }
      #profile select#floatingSelect {
          font-size: 20px;
      }
      #profile button#seacrh_button {
          font-size: 28px !important;
      }
      #profile .card-img-container img {
          width: 100%;
          height: auto !important;
          object-fit: cover !important;
          position: absolute !important;
      }
      #profile .col-6.col-sm-6.col-md-3.col-lg-3 {
          padding: 0;
          padding-right: 5px;
          padding-left: 5px;
      }
      #profile .card-img-container {
          height: 550px !important;
      }
      #profile .h-160 {
          height: auto !important;
      }
      #profile .card.content-card {
        height: auto !important;
        padding: 5px;
      }
      #profile p.card-text.btn.btn-primary.font-16.text-dark.mb-2.mt-2.pt-2 {
          font-size: 20px !important;
      }
      #profile p.card-text.pb-0.font-14.text-dark {
          font-size: 18px !important;
      }
      #profile .card-body.pb-0 {
          padding: 10px !important;
      }
      #profile .col-6.col-sm-6.col-md-6.col-lg-6.mb-4 {
          padding: 10px !important;
      }
      #profile .col-md-7 {
          margin-top: 250px !important;
      }
      #profile p.card-text.btn.btn-primary.font-16.text-dark.mb-2 {
          font-size: 20px !important;
      }
      #profile button#search_button {
          font-size: 24px !important;
      }
    }
</style>
<div id="profile">
<div class="row justify-content-md-center mt-2" style="margin-top: -160px !important;">
    <div class="col-12 col-sm-12 col-md-12 text-center">
        <h5 class="font-weight-600">ค้นหาทีมบริหารของโรงพยาบาลจักษุสุราษฎร์</h5>
        <hr class="style-two">
    </div>
</div>

<div class="row justify-content-md-center mt-3">
    <div class="col-12 col-sm-6 col-md-4" style="margin-top: 3px;">
        <div class="form-floating mb-2">
            <input type="text" class="form-control mb-0" id="floatingInput" value="<?= $ft_name ?>">
            <label for="floatingInput">ค้นหาชื่อ - นามสกุลทีมบริหาร</label>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="form-floating mb-4">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                <option value="all" selected="">ทุกตำแหน่ง</option>
                <?php foreach ($filter_profile as $key => $value) { ?>
                    <option value="<?= $value->stde_id ?>" <?= $ft_select == $value->stde_id ? 'selected' : ''; ?>><?= $value->stde_name_th ?></option>
                <?php } ?>
            </select>
            <label for="floatingSelect">ตำแหน่งทีมบริหาร</label>
        </div>
    </div>
</div>

<div class="row justify-content-md-center mb-4 mt-2 text-center">
    <div class="col-12 col-sm-12 col-md-8">
        <button type="button" onclick="filter_profile()" id="search_button" data-value="executives" class="btn btn-primary-search mb-2 w-100 font-20 float-start"><i class="bi bi-search"></i> ค้นหาผู้บริหาร</button>
    </div>
</div>

<div class="row justify-content-md-center">
    <div class="col-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12">
                        <h3 id="Mylabel" class="card-title pt-0 font-weight-600 font-22 text-warning-emphasis title-with-line">ทุกตำแหน่ง</h3>
                    </div>
                    <?php if (count($director_person) > 0) : ?>
                        <?php foreach ($director_person as $key => $value) { ?>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-4">
                                <div class="card">
                                    <div class="row no-gutters">
                                        <div class="col-md-5 card-img-container">
                                            <img id="profile_picture" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($value->psd_picture != '' ? $value->psd_picture : "default.png")); ?>" alt="Profile Picture">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="card-body pb-0">
                                                <h5 class="card-title pb-0 pt-0 font-weight-600"><?= $value->ps_fullname ?></h5>
                                                <h6 class="card-title pb-0 pt-0 font-16">
                                                    <?php $admin_position = json_decode($value->admin_position, true);
                                                    foreach ($admin_position as $key => $admin) { ?>
                                                    <?php if(is_string($admin)){$admin = json_decode($admin,true);}?>
                                                        <?= (count($admin_position) >= 1 ? $key != (count($admin_position) - 1) ? $admin['admin_name'] . ',' :  $admin['admin_name'] : '&nbsp;') ?><?php } ?>
                                                </h6>
                                                <h6 class="card-title pt-0 pb-0 font-16" style="min-height: 0px;"> <?= $value->alp_name ?><?php
                                                                                                                                            $spcl_positions = json_decode($value->spcl_position, true);
                                                                                                                                            foreach ($spcl_positions as $key => $spcl) { ?>
                                                          <?php if(is_string($spcl)){$spcl = json_decode($spcl,true);}?>
                                                    <?= (count($spcl_positions) >= 1 ? $key != (count($spcl_positions) - 1) ? $spcl['spcl_name'] . ',' :  'เชี่ยวชาญ' . $spcl['spcl_name'] : '&nbsp;') ?><?php } ?></h6>
                                                <div class="text-container" style="min-height:0px" data-bs-toggle="tooltip" title="จักษุแพทย์ รักษาโรคตาทั่วไปเชี่ยวชาญการผ่าตัดต้อกระจก Subspecialty General Ophthalmology and Cataract">
                                                    <p class="card-text pb-0 font-14 text-dark">
                                                        <?= $value->pos_desc != '' ?  $value->pos_desc : '&nbsp;<br><br>' ?>
                                                    </p>
                                                </div>
                                                <br>
                                                <p class="card-text btn btn-primary font-16 text-dark mb-2"><a href="<?php echo site_url(); ?>/hr/frontend/profile/view_profile/<?= $value->ps_id ?>" style="color: white;">ข้อมูลแพทย์เพิ่มเติม</a></p>
                                            </div>
                                        </div>
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
</div>
