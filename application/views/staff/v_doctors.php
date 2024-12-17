<meta name="viewport" content="width=device-width, initial-scale=0.7">
<style>
    .card.bg-card {
        position: relative;
        width: 100%;
        border-radius: 0.25rem;
        overflow: hidden;
        padding-bottom: 150px;
        /* Adjust based on your image height */
    }

    .card.bg-card #profile_picture {
        width: 100%;
        height: 60%;
        object-fit: cover;
        /* ทำให้ภาพครอบคลุมเต็มพื้นที่ */
        position: absolute;
        top: 0;
        left: 0;
    }

    .card.content-card {
        position: absolute;
        bottom: -30px;
        /* Adjust as needed */
        left: 0;
        right: 0;
        z-index: 1;
        background-color: #fff;
        padding: 1rem;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        height: 250px;
        /* Set a fixed height for the content card */
        /* Add additional styles if needed */
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
      #profile .card.bg-card #profile_picture {
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
      #profile .card.bg-card {
          height: 1200px !important;
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
    }
</style>
<div id="profile">
<div class="row justify-content-md-center mt-2" style="margin-top: -160px !important;">
    <div class="col-12 col-sm-12 col-md-12 text-center">
        <h5 class="font-weight-600">ค้นหาแพทย์ของโรงพยาบาลจักษุสุราษฎร์</h5>
        <hr class="style-two">
    </div>
</div>
<div class="row justify-content-md-center mt-3">
    <div class="col-12 col-sm-6 col-md-4" style="margin-top: 3px;">
        <div class="form-floating mb-2">
            <input type="text" class="form-control mb-0" id="floatingInput" value="<?= $ft_name ?>">
            <label for="floatingInput">ค้นหาชื่อ - นามสกุลแพทย์</label>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="form-floating mb-4" id="select-container">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                <option value="all" selected="">ทุกแผนก</option>
                <?php foreach ($filter_profile as $key => $value) { ?>
                    <option value="<?= $value->stde_id ?>" <?= $ft_select == $value->stde_id ? 'selected' : ''; ?>><?= $value->stde_name_th ?></option>
                <?php } ?>
            </select>
            <label for="floatingSelect">ค้นหาแผนก</label>
        </div>
    </div>
</div>
<div class="row justify-content-md-center mb-4 mt-2 text-center">
    <div class="col-12 col-sm-12 col-md-8">
        <button type="button" onclick="filter_profile()" id="seacrh_button" data-value="doctors" class="btn btn-primary-search mb-2 w-100 font-20 float-start"><i class="bi bi-search"></i> ค้นหาแพทย์</button>
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
                    <?php if (count($medical_person) > 0) : ?>
                        <?php foreach ($medical_person as $key => $value) { ?>
                            <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                <div class="card bg-card" style="height: 625px;">
                                    <!-- Background Card with Image -->
                                    <img id="profile_picture" class="card-img" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($value->psd_picture != '' ? $value->psd_picture : "default.png")); ?>" alt="Profile Picture">

                                    <!-- Foreground Content Card -->
                                    <div class="card content-card">
                                        <div class="card-body p-2">
                                              <div class="h-160" style="height: 160px;">
                                                <h5 class="card-title pb-0 pt-2 font-weight-600"><?= $value->ps_fullname ?></h5>
                                                <h6 class="card-title pt-0 pb-2 font-16" style="min-height: 45px;">
                                                    <?= $value->hire_abbr ?>
                                                    <?php
                                                    
                                                    $spcl_positions = json_decode($value->spcl_position, true);
                                                    $num = 0;
                                                    foreach ($spcl_positions as $key => $spcl) {
                                                        
                                                        if (is_string($spcl)) {
                                                            $spcl = json_decode($spcl, true);
                                                            
                                                        }
                                                        if($num == 0 && $spcl['spcl_name'] != ""){
                                                            echo " : ";
                                                        }
                                                        echo (count($spcl_positions) >= 1 ? $key != (count($spcl_positions) - 1) ? $spcl['spcl_name'] . ',' : $spcl['spcl_name'] : '&nbsp;');
                                                        $num++;
                                                    }
                                                    ?>
                                                </h6>
                                                <div class="text-container" style="min-height:42px" data-bs-toggle="tooltip" title="จักษุแพทย์ รักษาโรคตาทั่วไปเชี่ยวชาญการผ่าตัดต้อกระจก Subspecialty General Ophthalmology and Cataract">
                                                    <p class="card-text pb-0 font-14 text-dark">
                                                          <?= $value->pos_desc != '' ? $value->pos_desc : '&nbsp;<br><br>' ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="card-text btn btn-primary font-16 text-dark mb-2 mt-2 pt-2">
                                                  <a href="<?php echo site_url(); ?>/hr/frontend/profile/view_profile/<?= $value->ps_id ?>" style="color: white;">ข้อมูลแพทย์เพิ่มเติม</a>
                                            </p>
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