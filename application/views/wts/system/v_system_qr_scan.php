<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                    <i class="bi-people icon-menu"></i><span>ข้อมูลผู้ป่วยที่แสกน QR-Code</span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row g-6">
                    <?php foreach($stde as $key =>$dep){ ?>
                        <div class="col-md-4">
                            <div class="card card-button" onclick="window.location.href='<?php echo base_url()?>index.php/wts/System_qr_scan/qr_scan_show/<?php echo $dep->stde_id;?>'">
                                <div class="card-body">
                                    <div><?php echo $dep->stde_name_th ?></div>
                                    <div class="card-icon rounded-circle float-start">
                                        <i class="bi-people text-warning"></i>
                                    </div>
                                    <div class="float-end">
                                        <h1>
                                            <?php echo count($qr_code[$dep->stde_id]); ?>
                                             คน</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </div>
</div>
