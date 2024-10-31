<div class="row topbar">
  <div class="col-md-12 nav_topbar">
    <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      &nbsp;<i class="bi bi-person-bounding-box text-white"></i>&nbsp;
    <span class='text-white font-16'>จัดการคิว และนัดหมายแพทย์</span>
  </div>
</div>
<div class="row justify-content-md-center mt-2">
  <div class="col-12 col-sm-12 col-md-12 text-center">
    <h5 class="font-weight-600">ค้นหาข้อมูลการจัดการคิว และนัดหมายแพทย์</h5>
    <hr class="style-two">
  </div>
</div>
<div class="row justify-content-md-center mt-3">
  <div class="col-12 col-sm-6 col-md-4">
    <div class="form-floating mb-2">
      <input type="text" class="form-control mb-0" id="floatingInput" placeholder="ภาติยะ">
      <label for="floatingInput">ค้นหาชื่อ - นามสกุลแพทย์</label>
    </div>
    <div class="mt-0 mb-2">หรือ</div>
    <div class="form-floating mb-4">
      <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
        <option selected="">ทุกแผนก</option>
        <option value="1">จักษุแพทย์</option>
        <option value="2">โสต ศอ นาสิกแพทย์</option>
        <option value="3">รังสีแพทย์</option>
        <option value="4">ทันตแพทย์</option>
      </select>
      <label for="floatingSelect">ค้นหา</label>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-4">
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
  </div>
</div>
<div class="row justify-content-md-center mb-4 mt-2 text-center">
  <div class="col-12 col-sm-12 col-md-8">
    <button type="submit" class="btn btn-primary-search mb-2 w-50 font-20 float-start"><i class="bi bi-search"></i> ค้นหาแพทย์</button>
    <button type="submit" class="btn btn-info mb-2 w-40 font-20 float-end"><i class="bi bi-person-video2"></i> นัดหมายแพทย์ แบบไม่ระบุแพทย์</button>
  </div>
</div>
<div class="row justify-content-md-center">
  <div class="col-12 col-sm-12 col-md-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title pt-0 font-weight-600">ผลการค้นหาแพทย์</h5>
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12">
            <h3 class="card-title pt-0 font-weight-600 font-22 text-warning-emphasis">จักษุแพทย์</h3>
          </div>
          <div class="col-6 col-sm-6 col-md-4 col-lg-3">
            <div class="card">
              <img src="https://surateyehospital.com/wp-content/uploads/2023/01/S__64995330-e1674529006351.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title pb-0 font-weight-600">นพ.บรรยง ชินกุลกิจนิวัฒน์</h5>
                <h6 class="card-title pt-0 font-16">จักษุแพทย์ เชี่ยวชาญการผ่าตัดต้อกระจก<br><br></h6>
                <div class="text-container" data-bs-toggle="tooltip" title="จักษุแพทย์ รักษาโรคตาทั่วไปเชี่ยวชาญการผ่าตัดต้อกระจก Subspecialty General Ophthalmology and Cataract">
                  <p class="card-text pb-0 font-14 text-dark">
                    จักษุแพทย์ รักษาโรคตาทั่วไปเชี่ยวชาญการผ่าตัดต้อกระจก Subspecialty General Ophthalmology and Cataract
                  </p>
                </div>
                <p class="card-text pb-1 font-14 text-dark"><a href="<?php echo site_url();?>/hr/frontend/profile" class="card-link">ข้อมูลแพทย์เพิ่มเติม</a></p>
                <button class="btn btn-info w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample_1" aria-expanded="false" aria-controls="collapseExample_1">
                ตารางแพทย์ออกตรวจ
                </button>
                <div class="collapse" id="collapseExample_1">
                  <div class="card-body">
                    <table class='table border-warning'>
                      <thead>
                        <tr>
                          <th>วันที่ออกตรวจ</th>
                          <th>เวลาที่ออกตรวจ</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>วันจันทร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>อังคาร</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>พุธ</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>พฤหัสบดี</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>ศุกร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>เสาร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>อาทิตย์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <a href="<?php echo base_frontend_url('index.php').'/'.$this->config->item('que_frontend_path').'/Queuing_form_step1'; ?>" class="btn btn-primary-search w-100 mt-3 fs-5 fw-bold">นัดหมายแพทย์</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-4 col-lg-3">
            <div class="card">
              <img src="https://surateyehospital.com/wp-content/uploads/2022/05/doctor_3_850.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title pb-0 font-weight-600">พญ.บัวขวัญ ชินกุลกิจนิวัฒน์</h5>
                <h6 class="card-title pt-0 font-16">จักษุแพทย์เฉพาะทางด้านโรคกระจกตา<br><br></h6>
                <div class="text-container" data-bs-toggle="tooltip" title="จักษุแพทย์เฉพาะทางด้านกระจกตา กระจกตาติดเชื้อการผ่าตัดแก้ไขค่าสายตา เปลี่ยนกระจกตารักษาโรคตาทั่วไป ต้อกระจก Subspecialty Cornea and Refractive Surgery">
                  <p class="card-text pb-0 font-14 text-dark">จักษุแพทย์เฉพาะทางด้านกระจกตา กระจกตาติดเชื้อการผ่าตัดแก้ไขค่าสายตา เปลี่ยนกระจกตารักษาโรคตาทั่วไป ต้อกระจก Subspecialty Cornea and Refractive Surgery</p>
                </div>
                <p class="card-text pb-1 font-14 text-dark"><a href="<?php echo site_url();?>/hr/frontend/profile" class="card-link">ข้อมูลแพทย์เพิ่มเติม</a></p>
                <button class="btn btn-info w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample_2" aria-expanded="false" aria-controls="collapseExample_2">
                ตารางแพทย์ออกตรวจ
                </button>
                <div class="collapse" id="collapseExample_2">
                  <div class="card-body">
                    <table class='table border-warning'>
                      <thead>
                        <tr>
                          <th>วันที่ออกตรวจ</th>
                          <th>เวลาที่ออกตรวจ</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>วันจันทร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>อังคาร</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>พุธ</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>พฤหัสบดี</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>ศุกร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>เสาร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>อาทิตย์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <a href="<?php echo base_frontend_url('index.php').'/'.$this->config->item('que_frontend_path').'/Queuing_form_step1'; ?>" class="btn btn-primary-search w-100 mt-3 fs-5 fw-bold">นัดหมายแพทย์</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-4 col-lg-3">
            <div class="card">
              <img src="https://surateyehospital.com/wp-content/uploads/2022/05/doctor_4_850.jpg" class="card-img-top" alt="..." >
              <div class="card-body">
                <h5 class="card-title pb-0 font-weight-600">พญ.บุณยดา ชินกุลกิจนิวัฒน์</h5>
                <h6 class="card-title pt-0 font-16">จักษุแพทย์เฉพาะทางด้านโรคเส้นประสาทตา <br><br></h6>
                <div class="text-container" data-bs-toggle="tooltip" title="จักษุแพทย์เฉพาะทางด้านประสาทจักษุวิทยาดูแลผู้ป่วยเห็นภาพซ้อน ตาสั่น หน้ากระตุกเปลือกตาตก และ ภาวะเส้นประสาทตาอักเสบ Subspecialty Neuro-Opththalmology">
                <p class="card-text pb-0 font-14 text-dark">จักษุแพทย์เฉพาะทางด้านประสาทจักษุวิทยาดูแลผู้ป่วยเห็นภาพซ้อน ตาสั่น หน้ากระตุกเปลือกตาตก และ ภาวะเส้นประสาทตาอักเสบ Subspecialty Neuro-Opththalmology</p>
                </div>
                <p class="card-text pb-1 font-14 text-dark"><a href="<?php echo site_url();?>/hr/frontend/profile" class="card-link">ข้อมูลแพทย์เพิ่มเติม</a></p>
                <button class="btn btn-info w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample_3" aria-expanded="false" aria-controls="collapseExample_3">
                ตารางแพทย์ออกตรวจ
                </button>
                <div class="collapse" id="collapseExample_3">
                  <div class="card-body">
                    <table class='table border-warning'>
                      <thead>
                        <tr>
                          <th>วันที่ออกตรวจ</th>
                          <th>เวลาที่ออกตรวจ</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>วันจันทร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>อังคาร</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>พุธ</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>พฤหัสบดี</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>ศุกร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>เสาร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>อาทิตย์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <a href="<?php echo base_frontend_url('index.php').'/'.$this->config->item('que_frontend_path').'/Queuing_form_step1'; ?>" class="btn btn-primary-search w-100 mt-3 fs-5 fw-bold">นัดหมายแพทย์</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-4 col-lg-3">
            <div class="card">
              <img src="https://surateyehospital.com/wp-content/uploads/2023/01/หมอโบว์-scaled-e1674532097321.jpg" class="card-img-top" alt="..." >
              <div class="card-body">
                <h5 class="card-title pb-0 font-weight-600">พญ.บุญพิสุทธิ์ ชินกุลกิจนิวัฒน์</h5>
                <h6 class="card-title pt-0 font-16">จักษุแพทย์เฉพาะทางทั่วไป<br><br><br></h6>
                <div class="text-container" data-bs-toggle="tooltip" title="จักษุแพทย์ รักษาโรคทางตาทั่วไป Subspecialty General Ophthalmology">
                <p class="card-text pb-0 font-14 text-dark">จักษุแพทย์ รักษาโรคทางตาทั่วไป Subspecialty General Ophthalmology</p>
                </div>
                <p class="card-text pb-1 font-14 text-dark"><a href="<?php echo site_url();?>/hr/frontend/profile" class="card-link">ข้อมูลแพทย์เพิ่มเติม</a></p>
                <button class="btn btn-info w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample_3" aria-expanded="false" aria-controls="collapseExample_3">
                ตารางแพทย์ออกตรวจ
                </button>
                <div class="collapse" id="collapseExample_3">
                  <div class="card-body">
                    <table class='table border-warning'>
                      <thead>
                        <tr>
                          <th>วันที่ออกตรวจ</th>
                          <th>เวลาที่ออกตรวจ</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>วันจันทร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>อังคาร</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>พุธ</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>พฤหัสบดี</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>ศุกร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>เสาร์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                        <tr>
                          <td>อาทิตย์</td>
                          <td>08.30 - 16.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <a href="<?php echo base_frontend_url('index.php').'/'.$this->config->item('que_frontend_path').'/Queuing_form_step1'; ?>" class="btn btn-primary-search w-100 mt-3 fs-5 fw-bold">นัดหมายแพทย์</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
