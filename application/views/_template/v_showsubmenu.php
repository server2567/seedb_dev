<style>
    .card-menu {
        border: 2px solid #ebeef4 !important;
    }
    .card img {
        height: 150px;
        width: 150px;
    }
</style>

<div class="card">
        <!-- Default Accordion -->
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        ระบบงาน - เมนู
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row">
                    <?php for($i=0; $i<5; $i++){ ?>
                        <div class="col-md-3">
                            <a href="#">
                                <div class="card card-menu pt-3 d-flex align-items-center">
                                    <img src="<?php echo base_url();?>assets/img/getIcon.png" alt="...">
                                        <h5 class="card-title text-center">ข้อมูลระบบ - เมนู</h5>
                                        <!-- <p class="card-text">ข้อมูลระบบ - เมนู</p> -->
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
    </div>