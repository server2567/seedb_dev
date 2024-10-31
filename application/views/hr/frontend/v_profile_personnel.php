<div class="row topbar">
    <div class="col-md-12 nav_topbar">
        <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
        &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
        <a href="<?php echo $this->config->item('base_frontend_url') . 'index.php/que/frontend/Search_queuing_home'; ?>">
            &nbsp;<i class="bi bi-person-bounding-box"></i>&nbsp;
            <span class='font-16'>จัดการคิว และนัดหมายแพทย์</span>
        </a>
        &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
        &nbsp;<i class="bi bi-person-lines-fill text-white"></i>&nbsp;
        <span class='text-white font-16'>บุคลากรทั้งหมด</span>
    </div>
</div>
<div class="row topbar2" style="height: 400px;">
    <div class="pattern-square2"></div>
    <div class="page-title-overlap bg-accent pt-4 container" style="height: 150px;"></div>
</div>
<div class="row d-flex justify-content-center" style="margin-top: 57px;">
  <div class="col-6">
    <div class="form-floating mb-3">
      <input type="text" class="form-control font-18" id="floatingInput" placeholder="ค้นหาชื่อ" style="background-color: #ffffffc9; padding-top: 45px; line-height: 2; height: calc(5rem + calc(var(--bs-border-width)* 2));">
      <label for="floatingInput" class="font-20"><i class="bi bi-search"></i> ค้นหาชื่อบุคลากรโรงพยาบาลจักษุสุราษฎร์</label>
    </div>
  </div>
  <div class="col-3">
    <div class="form-floating mb-3">
      <select class="form-select" id="floatingSelect" aria-label="Floating label select example" style="background-color: #ffffffc9; padding-top: 35px; font-size: 20px; line-height: 2; height: calc(5rem + calc(var(--bs-border-width)* 2));">
        <option selected="">ทั้งหมด</option>
        <option value="1">แพทย์</option>
        <option value="2">พยาบาล</option>
        <option value="3">ผู้ช่วยพยาบาล</option>
        <option value="4">เจ้าหน้าที่สนับสนุน</option>
      </select>
      <label for="floatingSelect" class="font-18">ประเภทบุคลากร</label>
      <button type="button" class="btn btn-warning rounded-pill float-end btn-lg mt-3"><i class="bi bi-search"></i> ค้นหา</button>
    </div>
  </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-12 col-sm-12 col-md-12" style=" margin-top: 60px;">
        <div class="card bg-white ">
            <div class="card-body p-5">
              <div class="row">
                <div class="col-12 text-center">
                  <h2 class="fw-bold" style="margin-bottom: 4rem;">ทีมแพทย์ผู้บริหาร<hr style="border: 1px solid #FFC107; opacity: 1;"></h2>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <div class="card">
                    <img src="https://surateyehospital.com/wp-content/uploads/2023/01/S__64995330-e1674529006351.jpg" class="card-img-top rounded-3 " alt="...">
                  </div>
                </div>
                <div class="col-9">
                  <div class="ps-xl-5 ps-lg-3">
                    <h2 class="h3 mb-3">นพ.บรรยง ชินกุลกิจนิวัฒน์</h2>
                    <h2 class="h4 mb-3">ตำแหน่ง : ผู้บริหารโรงพยาบาลจักษุสุราษฎร์</h2>
                    <h2 class="h5 mb-3">ความเชี่ยวชาญ : จักษุแพทย์ เชี่ยวชาญการผ่าตัดต้อกระจก</h2>
                    <h2 class="h5 mb-3">รักษาโรคตาทั่วไปเชี่ยวชาญการผ่าตัดต้อกระจก Subspecialty General Ophthalmology and Cataract</h2>
                    <a href="<?php echo site_url(); ?>/hr/frontend/profile" target="_blank" class="btn btn-primary btn-lg mt-4 fs-5">ข้อมูลแพทย์เพิ่มเติม</a>
                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-3">
                  <div class="card text-center">
                    <a href="<?php echo site_url(); ?>/hr/frontend/profile" target="_blank">
                      <img src="https://surateyehospital.com/wp-content/uploads/2022/05/doctor_2_850.jpg" class="card-img-top rounded-3 " alt="...">
                      <h1 class="font-20 fw-bold mt-5 text-primary-emphasis pb-3">พญ.วิมล ชินกุลกิจนิวัฒน์</h1>
                      <h1 class="font-18 mt-1 mb-5 ps-2 pe-2 text-dark">รังสีวิทยาทั่วไป (General X-Ray)<br><br></h1>
                    </a>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card text-center">
                    <a href="<?php echo site_url(); ?>/hr/frontend/profile" target="_blank">
                      <img src="https://surateyehospital.com/wp-content/uploads/2022/05/doctor_3_850.jpg" class="card-img-top rounded-3 " alt="...">
                      <h1 class="font-20 fw-bold mt-5 text-primary-emphasis pb-3">พญ.บัวขวัญ ชินกุลกิจนิวัฒน์</h1>
                      <h1 class="font-18 mt-1 mb-5 ps-2 pe-2 text-dark">จักษุแพทย์เฉพาะทางด้านโรคกระจกตา</h1>
                    </a>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card text-center">
                    <a href="<?php echo site_url(); ?>/hr/frontend/profile" target="_blank">
                      <img src="https://surateyehospital.com/wp-content/uploads/2022/05/doctor_4_850.jpg" class="card-img-top rounded-3 " alt="...">
                      <h1 class="font-20 fw-bold mt-5 text-primary-emphasis pb-3">พญ.บุณยดา ชินกุลกิจนิวัฒน์</h1>
                      <h1 class="font-18 mt-1 mb-5 ps-2 pe-2 text-dark">จักษุแพทย์เฉพาะทางด้านโรคเส้นประสาทตา</h1>
                    </a>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card text-center">
                    <a href="<?php echo site_url(); ?>/hr/frontend/profile" target="_blank">
                      <img src="https://surateyehospital.com/wp-content/uploads/2023/01/หมอโบว์-scaled-e1674532097321.jpg" class="card-img-top rounded-3 " alt="...">
                      <h1 class="font-20 fw-bold mt-5 text-primary-emphasis pb-3">พญ.บุญพิสุทธิ์ ชินกุลกิจนิวัฒน์</h1>
                      <h1 class="font-18 mt-1 mb-5 ps-2 pe-2 text-dark">จักษุแพทย์เฉพาะทางทั่วไป<br><br></h1>
                    </a>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card text-center">
                    <a href="<?php echo site_url(); ?>/hr/frontend/profile" target="_blank">
                      <img src="https://surateyehospital.com/wp-content/uploads/2023/10/DSC08260-2-scaled-e1696476523244.jpg" class="card-img-top rounded-3 " alt="...">
                      <h1 class="font-20 fw-bold mt-5 text-primary-emphasis pb-3">ทพ.ญ.บรรณศร ชินกุลกิจนิวัฒน์</h1>
                      <h1 class="font-18 mt-1 mb-5 ps-2 pe-2 text-dark">ทันตแพทย์</h1>
                    </a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 text-center">
                  <h2 class="fw-bold" style="margin-bottom: 4rem;">แผนกจักษุแพทย์<hr style="border: 1px solid #FFC107; opacity: 1;"></h2>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <div class="card">
                    <img src="https://surateyehospital.com/wp-content/uploads/2023/01/S__64995330-e1674529006351.jpg" class="card-img-top rounded-3 " alt="...">
                  </div>
                </div>
                <div class="col-9">
                  <div class="ps-xl-5 ps-lg-3">
                    <h2 class="h3 mb-3">นพ.บรรยง ชินกุลกิจนิวัฒน์</h2>
                    <h2 class="h4 mb-3">ตำแหน่ง : หัวหน้าแผนกจักษุแพทย์</h2>
                    <h2 class="h5 mb-3">ความเชี่ยวชาญ : จักษุแพทย์ เชี่ยวชาญการผ่าตัดต้อกระจก</h2>
                    <h2 class="h5 mb-3">รักษาโรคตาทั่วไปเชี่ยวชาญการผ่าตัดต้อกระจก Subspecialty General Ophthalmology and Cataract</h2>
                    <a href="<?php echo site_url(); ?>/hr/frontend/profile" target="_blank" class="btn btn-primary btn-lg mt-5 fs-5">ข้อมูลแพทย์เพิ่มเติม</a>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
