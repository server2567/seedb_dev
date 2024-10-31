<style>
    .card-menu {
        border: 2px solid #ebeef4 !important;
    }
    .card-menu:hover, .card-menu:hover > h5 {
        color: #717ff5;
        text-decoration: none;
        transition: all 0.3s;
    }
    #collapseOne i {
        font-size: 60px;
    }
</style>

<div class="card">
    <!-- Default Accordion -->
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="<?php echo $parent_menu[0]['mn_icon']; ?> icon-menu"></i><span>  <?php echo $parent_menu[0]['mn_name_th']; ?></span>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row">
                    <?php 
                        $i=0;
                        foreach ($sub_menus as $row) {
                    ?>
                        <div class="col-md-2">
                            <a href="<?php echo base_url().'index.php/ums/UMS_Controller/insert_log_menu/'.$row['mn_id']; ?>">
                                <div class="card card-menu pt-3 d-flex align-items-center">
                                    <i class="<?php echo $row['mn_icon']; ?>"></i>
                                    <h4 class="card-title text-center"><?php echo $row['mn_name_th']; ?></h4>
                                </div>
                            </a>
                        </div>
                    <?php $i++; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>