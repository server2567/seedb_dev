<style>
    .card-hover:hover {
        background-color: #cfe2ff;
        cursor: pointer;
        opacity: 0.6;
        /* เปลี่ยนค่าตามต้องการ */
    }

    .card-hover span {
        font-size: 14px;
    }

    .accordion-header:hover {
        background-color: #cfe2ff;
        cursor: pointer;
        opacity: 0.6;
        /* เปลี่ยนค่าตามต้องการ */
    }
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">จัดการข้อมูลพื้นฐาน</h5>
            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">
                <div class="accordion-body">

                </div>
                <?php if (!empty($parent)) : ?>
                    <?php $index = 0; ?>
                    <?php foreach ($parent as $key => $value) : ?>
                        <div class="accordion-item mt-2">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= ++$index ?>" aria-expanded="true" aria-controls="collapse<?= $index ?>">
                                    <?= $value->mn_name_th ?>&nbsp;&nbsp;<span class="badge bg-success"><?= isset($value->sum_count) ? $value->sum_count : 0  ?></span>
                                </button>
                            </h2>
                            <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <?php foreach ($value->children as $children) : ?>
                                            <div class="col-4">
                                                <div class="card info-card sales-card" onclick="window.location.href='<?php echo base_url() ?>index.php/<?= $children->mn_url ?>'">
                                                    <div class="card-body card-hover">
                                                        <h1 class="card-title"><?= $children->mn_name_th ?></h1>
                                                        <div class="d-flex align-items-center">
                                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                                <h1 class="bi <?= $children->mn_icon ?>"></h1>
                                                            </div>
                                                            <div class="ps-4">
                                                                <h3><?= isset($children->data_count) ? $children->data_count : 0 ?></h3>
                                                            </div>
                                                            <div class="pr-5">
                                                                <h4>&nbsp;</h3>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <h4>รายการ</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- End Default Accordion Example -->
            </div>
        </div>
    </div>