<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span>  กำหนดช่วงเวลาในการค้นหา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/Policy/Consenters">   <!-- id="validate-form" data-parsley-validate   -->
                        <div class="col-md-6">
                            <label for="date" class="form-label ">ระหว่าง วันที่</label>
                            <div class="input-group date input-daterange">
                                <input type="date" class="form-control" name="StartDate" id="StartDate" placeholder="" value="<?php echo !empty($edit) ? $edit['StartDate'] : "" ;?>">
                                <span class="input-group-text">ถึง</span>
                                <input type="date" class="form-control" name="EndDate" id="EndDate" placeholder="" value="<?php echo !empty($edit) ? $edit['EndDate'] : "" ;?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-bookmark-check icon-menu"></i><span>  รายชื่อผู้ยินยอม</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Username</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th class="text-center">วันที่กดยินยอม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<15; $i++){ ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td>admin</td>
                                <td>นายแอดมิน ระบบ</td>
                                <td class="text-center">2024-03-26</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>