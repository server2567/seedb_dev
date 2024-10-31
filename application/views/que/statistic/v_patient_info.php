                            <?php
                                $data = array(
                                    array(
                                        'tracking' => 'IP-0001',
                                        'fullname' => 'หฤทัย ทองชัยภูมิ',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 1
                                    ),
                                    array(
                                        'tracking' => 'OP-0001',
                                        'fullname' => 'ปิติภัทร แสนธารา',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 2
                                    ),
                                    array(
                                        'tracking' => 'A-ER-0001',
                                        'fullname' => 'นัทธ์ รุ่งรัศมีทรัพย์',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 3
                                    ),
                                    array(
                                        'tracking' => 'C-IP-0001',
                                        'fullname' => 'ธณิกา ก้องวัฒนะกุล',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 4
                                    ),
                                    array(
                                        'tracking' => 'G-0001',
                                        'fullname' => 'ก้องวัฒนะกุล รัชนวีระ',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 5
                                    ),
                                    array(
                                        'tracking' => 'OP-0001',
                                        'fullname' => 'รัชนวีระ พัชญ์ธนัน ',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 6
                                    ),
                                    array(
                                        'tracking' => 'A-ER-0001',
                                        'fullname' => 'พัชญ์ธนัน แสนธารา',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 7
                                    ),
                                    array(
                                        'tracking' => 'C-IP-0001',
                                        'fullname' => 'ก้อง พัชญ์ธนัน',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 8
                                    ),
                                    array(
                                        'tracking' => 'G-0001',
                                        'fullname' => 'วัฒนะกุล รัชนวีระ',
                                        'history' => 'รักษาอาการไอ',
                                        'id' => 9
                                    ),
                                );


                                $found_data = array();
                                foreach ($data as $item) {
                                    if ($item['id'] == $id) {
                                        $found_data = $item;
                                        break;
                                    }
                                }

                            ?>


<div class="card dashboard">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>ข้อมูลเพิ่มเติม</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation dissable" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Prepare_manage/add">   <!-- id="validate-form" data-parsley-validate   -->
                        <div class="col-md-6">
                            <label for="StNameT" class="form-label ">หมายเลขติดตาม</label>
                            <input  readonly type="text" class="form-control" name="StNameT" id="StNameT" placeholder=" <?php echo $found_data['tracking']; ?>" value="<?php echo !empty($edit) ? $edit['StNameT'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StNameE" class="form-label ">ชื่อ-นามสกุล</label>
                            <input readonly  type="text" class="form-control" name="StNameE" id="StNameE" placeholder="<?php echo $found_data['fullname']; ?>" value="<?php echo !empty($edit) ? $edit['StNameE'] : "" ;?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="StActive" class="form-label">ประวัติการรักษา</label>
                            <div class="col-md-12">
                                <label for="StNameE" class="form-label "><?php echo $found_data['history']; ?></label>
                            </div>

                        </div>
                        <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">เส้นทางของผู้ป่วย <span>| วันปัจจุบัน</span></h5>

              <div class="activity">

                <div class="activity-item d-flex">
                  <div class="activite-label">32 นาที</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    แผนกผู้ป่วยนอก <a href="#" class="fw-bold text-dark">ลงทะเบียน</a>
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">35 นาที</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    ห้องตรวจโรคทั่วไป <a href="#" class="fw-bold text-dark">พบแพทย์</a>
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">42 นาที</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    แผนกจักษุ <a href="#" class="fw-bold text-dark">พบจักษุแพทย์</a>
                  </div>
                </div><!-- End activity item-->

                

              </div>

            </div>
          </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/que/Patient'">ย้อนกลับ</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

